<?php

/**
 * This is the model class for table "grupocomida_valnutr".
 *
 * The followings are the available columns in table 'grupocomida_valnutr':
 * @property integer $id_frec_cons
 * @property integer $id_val_nutricion
 * @property integer $id_grupo_comida
 * @property string $observ_frec_cons
 *
 * The followings are the available model relations:
 * @property FrecuenciaConsumo $idFrecCons
 * @property ValoracionNutricional $idValNutricion
 * @property GrupoComida $idGrupoComida
 */
class GrupocomidaValnutr extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'grupocomida_valnutr';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_frec_cons, id_val_nutricion, id_grupo_comida', 'required','message'=>'Debe seleccionar una opción.'),
			array('id_frec_cons, id_val_nutricion, id_grupo_comida', 'numerical', 'integerOnly'=>true),
			array('observ_frec_cons', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_frec_cons, id_val_nutricion, id_grupo_comida, observ_frec_cons', 'safe', 'on'=>'search'),
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
			'idFrecCons' => array(self::BELONGS_TO, 'FrecuenciaConsumo', 'id_frec_cons'),
			'idValNutricion' => array(self::BELONGS_TO, 'ValoracionNutricional', 'id_val_nutricion'),
			'idGrupoComida' => array(self::BELONGS_TO, 'GrupoComida', 'id_grupo_comida'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_frec_cons' => 'Frecuencia de consumo',
			'id_val_nutricion' => 'Id Val Nutricion',
			'id_grupo_comida' => 'Id Grupo Comida',
			'observ_frec_cons' => 'Observ Frec Cons',
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

		$criteria->compare('id_frec_cons',$this->id_frec_cons);
		$criteria->compare('id_val_nutricion',$this->id_val_nutricion);
		$criteria->compare('id_grupo_comida',$this->id_grupo_comida);
		$criteria->compare('observ_frec_cons',$this->observ_frec_cons,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GrupocomidaValnutr the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaFrecuenciaConsObs(){
		$conect= Yii::app()->db;
		$sqlFrecCons="select * from grupocomida_valnutr where id_val_nutricion=:id_val_nutricion and id_grupo_comida=:id_grupo_comida";	
		$consFrecCons=$conect->createCommand($sqlFrecCons);
		$consFrecCons->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$consFrecCons->bindParam(":id_grupo_comida",$this->id_grupo_comida,PDO::PARAM_INT);
		$readFrecCons=$consFrecCons->query();
		$resFrecCons=$readFrecCons->read();
		$readFrecCons->close();
		return $resFrecCons;					
	}
	public function registraFrecCons(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegFrecCons="insert into grupocomida_valnutr (
				id_frec_cons,
				id_val_nutricion,
				id_grupo_comida,
				observ_frec_cons	
			) values (
				:id_frec_cons,
				:id_val_nutricion,
				:id_grupo_comida,
				:observ_frec_cons	
			)";	
			if(empty($this->observ_frec_cons)){
				$this->observ_frec_cons=null;
			}
			$regFrecCons=$conect->createCommand($sqlRegFrecCons);	
			$regFrecCons->bindParam(":id_frec_cons",$this->id_frec_cons,PDO::PARAM_INT);	
			$regFrecCons->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);	
			$regFrecCons->bindParam(":id_grupo_comida",$this->id_grupo_comida,PDO::PARAM_INT);
			$regFrecCons->bindParam(":observ_frec_cons",$this->observ_frec_cons,PDO::PARAM_NULL);
			$regFrecCons->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function modificaFrecCons(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegFrecCons="update grupocomida_valnutr set 
				id_frec_cons=:id_frec_cons,observ_frec_cons=:observ_frec_cons
			where
				id_val_nutricion=:id_val_nutricion and id_grupo_comida=:id_grupo_comida
			";	
			if(empty($this->observ_frec_cons)){
				$this->observ_frec_cons=null;
			}
			$regFrecCons=$conect->createCommand($sqlRegFrecCons);	
			$regFrecCons->bindParam(":id_frec_cons",$this->id_frec_cons,PDO::PARAM_INT);	
			$regFrecCons->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);	
			$regFrecCons->bindParam(":id_grupo_comida",$this->id_grupo_comida,PDO::PARAM_INT);
			$regFrecCons->bindParam(":observ_frec_cons",$this->observ_frec_cons,PDO::PARAM_NULL);
			$regFrecCons->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
}
