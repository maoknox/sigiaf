<?php

/**
 * This is the model class for table "porciones_comida".
 *
 * The followings are the available columns in table 'porciones_comida':
 * @property integer $id_grupo_comida
 * @property string $id_nutradol
 * @property integer $id_val_nutricion
 * @property integer $num_porc_cons_diario
 * @property integer $num_porc_recomendadas
 * @property integer $dif_num_porc_cons_rec
 *
 * The followings are the available model relations:
 * @property GrupoComida $idGrupoComida
 * @property NutricionAdol $idNutradol
 * @property NutricionAdol $idValNutricion
 */
class PorcionesComida extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'porciones_comida';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_grupo_comida, id_nutradol, id_val_nutricion, num_porc_recomendadas', 'required'),
			array('id_grupo_comida, id_val_nutricion, num_porc_cons_diario, num_porc_recomendadas, dif_num_porc_cons_rec', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_grupo_comida, id_nutradol, id_val_nutricion, num_porc_cons_diario, num_porc_recomendadas, dif_num_porc_cons_rec', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idGrupoComida' => array(self::BELONGS_TO, 'GrupoComida', 'id_grupo_comida'),
			'idNutradol' => array(self::BELONGS_TO, 'NutricionAdol', 'id_nutradol'),
			'idValNutricion' => array(self::BELONGS_TO, 'NutricionAdol', 'id_val_nutricion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_grupo_comida' => 'Grupo comida',
			'id_nutradol' => 'Nutricion adol',
			'id_val_nutricion' => 'Valoración nutricional',
			'num_porc_cons_diario' => 'Número de porciones de consumo diario',
			'num_porc_recomendadas' => 'Número de porciones recomendadas',
			'dif_num_porc_cons_rec' => 'Diferencia porciones consumidas vs recomendadas',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_grupo_comida',$this->id_grupo_comida);
		$criteria->compare('id_nutradol',$this->id_nutradol,true);
		$criteria->compare('id_val_nutricion',$this->id_val_nutricion);
		$criteria->compare('num_porc_cons_diario',$this->num_porc_cons_diario);
		$criteria->compare('num_porc_recomendadas',$this->num_porc_recomendadas);
		$criteria->compare('dif_num_porc_cons_rec',$this->dif_num_porc_cons_rec);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PorcionesComida the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 *	Consulta consumo de porciones de consumo
	 *
	 *	@param string $this->id_val_nutricion
	 *	@param int $this->id_grupo_comida
	 *	@param int $this->id_nutradol
	 *	@return $resFrecCons
	 */		
	public function consultaConsumPorcionesGen(){
		$conect= Yii::app()->db;
		$sqlFrecCons="select * from porciones_comida where id_val_nutricion=:id_val_nutricion and id_grupo_comida=:id_grupo_comida and id_nutradol=:id_nutradol";	
		$consFrecCons=$conect->createCommand($sqlFrecCons);
		$consFrecCons->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$consFrecCons->bindParam(":id_grupo_comida",$this->id_grupo_comida,PDO::PARAM_INT);
		$consFrecCons->bindParam(":id_nutradol",$this->id_nutradol,PDO::PARAM_INT);
		$readFrecCons=$consFrecCons->query();
		$resFrecCons=$readFrecCons->read();
		$readFrecCons->close();
		return $resFrecCons;					
	}
	/**
	 *	Registra porciones de consumo
	 *
	 *	@param int $this->id_grupo_comida
	 *	@param string $this->id_nutradol
	 *	@param int $this->id_val_nutricion
	 *	@param int $this->num_porc_cons_diario
	 *	@param int $this->num_porc_recomendadas
	 *	@param int $this->dif_num_porc_cons_rec			
	 *	@param string $this->concepto_integral
	 *	@return resultado de la transacción 
	 */		
	public function registraPorcionesRec(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->num_porc_cons_diario)){$this->num_porc_cons_diario=null;}
			if(empty($this->dif_num_porc_cons_rec)){$this->dif_num_porc_cons_rec=null;}
			$sqlRegPorcRec="insert into porciones_comida (
				id_grupo_comida,
				id_nutradol,
				id_val_nutricion,
				num_porc_cons_diario,
				num_porc_recomendadas,
				dif_num_porc_cons_rec			
			) values (
				:id_grupo_comida,
				:id_nutradol,
				:id_val_nutricion,
				:num_porc_cons_diario,
				:num_porc_recomendadas,
				:dif_num_porc_cons_rec			
			) ";
			$regPorcRec=$conect->createCommand($sqlRegPorcRec);
			$regPorcRec->bindParam(":id_grupo_comida",$this->id_grupo_comida,PDO::PARAM_INT);
			$regPorcRec->bindParam(":id_nutradol",$this->id_nutradol,PDO::PARAM_STR);
			$regPorcRec->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
			$regPorcRec->bindParam(":num_porc_cons_diario",$this->num_porc_cons_diario,PDO::PARAM_NULL);
			$regPorcRec->bindParam(":num_porc_recomendadas",$this->num_porc_recomendadas,PDO::PARAM_INT);
			$regPorcRec->bindParam(":dif_num_porc_cons_rec",$this->dif_num_porc_cons_rec,PDO::PARAM_NULL);
			$regPorcRec->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
			
		}
	}
	/**
	 *	Modifica porciones de consumo
	 *
	 *	@param int $this->id_grupo_comida
	 *	@param string $this->id_nutradol
	 *	@param int $this->id_val_nutricion
	 *	@param int $this->num_porc_cons_diario
	 *	@param int $this->num_porc_recomendadas
	 *	@param int $this->dif_num_porc_cons_rec			
	 *	@param string $this->concepto_integral
	 *	@return resultado de la transacción 
	 */		
	public function modificaPorcionesRec(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->num_porc_cons_diario)){$this->num_porc_cons_diario=null;}
			if(empty($this->dif_num_porc_cons_rec)){$this->dif_num_porc_cons_rec=null;}
			$sqlRegPorcRec="update porciones_comida set				
				num_porc_cons_diario=:num_porc_cons_diario,
				num_porc_recomendadas=:num_porc_recomendadas,
				dif_num_porc_cons_rec=:dif_num_porc_cons_rec			
			where
				id_grupo_comida=:id_grupo_comida and
				id_nutradol=:id_nutradol and
				id_val_nutricion=:id_val_nutricion					
			 ";
			$regPorcRec=$conect->createCommand($sqlRegPorcRec);
			$regPorcRec->bindParam(":id_grupo_comida",$this->id_grupo_comida,PDO::PARAM_INT);
			$regPorcRec->bindParam(":id_nutradol",$this->id_nutradol,PDO::PARAM_STR);
			$regPorcRec->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
			$regPorcRec->bindParam(":num_porc_cons_diario",$this->num_porc_cons_diario,PDO::PARAM_NULL);
			$regPorcRec->bindParam(":num_porc_recomendadas",$this->num_porc_recomendadas,PDO::PARAM_INT);
			$regPorcRec->bindParam(":dif_num_porc_cons_rec",$this->dif_num_porc_cons_rec,PDO::PARAM_NULL);
			$regPorcRec->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
			
		}
	}
}
