<?php

/**
 * This is the model class for table "grupocomida_nutradol".
 *
 * The followings are the available columns in table 'grupocomida_nutradol':
 * @property integer $id_grupo_comida
 * @property string $id_nutradol
 * @property integer $id_val_nutricion
 * @property integer $id_tiempo_alimento
 * @property integer $num_porciones
 *
 * The followings are the available model relations:
 * @property GrupoComida $idGrupoComida
 * @property NutricionAdol $idNutradol
 * @property NutricionAdol $idValNutricion
 * @property TiempoAlimento $idTiempoAlimento
 */
class GrupocomidaNutradol extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $_porciones;
	public function tableName()
	{
		return 'grupocomida_nutradol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_grupo_comida, id_nutradol, id_val_nutricion, id_tiempo_alimento, num_porciones', 'required'),
			array('id_grupo_comida, id_val_nutricion, id_tiempo_alimento, num_porciones', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_grupo_comida, id_nutradol, id_val_nutricion, id_tiempo_alimento, num_porciones', 'safe', 'on'=>'search'),
			array('num_porciones','validaNumPorciones')
		);
	}

	public function validaNumPorciones($attribute=NULL,$params=NULL){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["GrupocomidaNutradol"]["grupo_comida"])&&!empty($datosInput["GrupocomidaNutradol"]["grupo_comida"])){
				//print_r($_POST["Adolescente"]);
				$porciones=$datosInput["GrupocomidaNutradol"]["grupo_comida"];
				foreach($porciones as $porcion){
					if(!empty($porcion)){
						if(!is_numeric($porcion)){
							$this->num_porciones="string";
						}						
					}				
				}
				if(empty($this->num_porciones)){
					$this->addError($attribute,"Solo debe digitar números");
				}
			}
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
			'idTiempoAlimento' => array(self::BELONGS_TO, 'TiempoAlimento', 'id_tiempo_alimento'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_grupo_comida' => 'Grupo Comida',
			'id_nutradol' => 'Nutrición adol',
			'id_val_nutricion' => 'Valoración nutrición',
			'id_tiempo_alimento' => 'Tiempo de alimento',
			'num_porciones' => 'Número de porciones',
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
		$criteria->compare('id_tiempo_alimento',$this->id_tiempo_alimento);
		$criteria->compare('num_porciones',$this->num_porciones);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GrupocomidaNutradol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaConsumPorciones(){
		$conect= Yii::app()->db;
		$sqlFrecCons="select * from grupocomida_nutradol where id_val_nutricion=:id_val_nutricion and id_grupo_comida=:id_grupo_comida and id_nutradol=:id_nutradol";	
		$consFrecCons=$conect->createCommand($sqlFrecCons);
		$consFrecCons->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$consFrecCons->bindParam(":id_grupo_comida",$this->id_grupo_comida,PDO::PARAM_INT);
		$consFrecCons->bindParam(":id_nutradol",$this->id_nutradol,PDO::PARAM_INT);
		$readFrecCons=$consFrecCons->query();
		$resFrecCons=$readFrecCons->readAll();
		$readFrecCons->close();
		return $resFrecCons;					
	}
	public function consultaConsumPorcionesTiempo(){
		$conect= Yii::app()->db;
		$sqlFrecCons="select * from grupocomida_nutradol where id_val_nutricion=:id_val_nutricion and id_grupo_comida=:id_grupo_comida and id_nutradol=:id_nutradol and id_tiempo_alimento=:id_tiempo_alimento";	
		$consFrecCons=$conect->createCommand($sqlFrecCons);
		$consFrecCons->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$consFrecCons->bindParam(":id_grupo_comida",$this->id_grupo_comida,PDO::PARAM_INT);
		$consFrecCons->bindParam(":id_nutradol",$this->id_nutradol,PDO::PARAM_STR);
		$consFrecCons->bindParam(":id_tiempo_alimento",$this->id_tiempo_alimento,PDO::PARAM_INT);
		$readFrecCons=$consFrecCons->query();
		$resFrecCons=$readFrecCons->read();
		$readFrecCons->close();
		return $resFrecCons;					
	}
	public function creaRegPorciones(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		$sqlRegPorcionesComida="insert into grupocomida_nutradol(
			id_grupo_comida,
			id_nutradol,
			id_val_nutricion,
			id_tiempo_alimento,
			num_porciones				
		) values(
			:id_grupo_comida,
			:id_nutradol,
			:id_val_nutricion,
			:id_tiempo_alimento,
			:num_porciones				
		)
		";
		try{
			foreach($this->_porciones as $pk=>$porcion){
				if(!empty($porcion)){
					$regPorcionesComida=$conect->createCommand($sqlRegPorcionesComida);
					$regPorcionesComida->bindParam(":id_grupo_comida",$this->id_grupo_comida,PDO::PARAM_INT);
					$regPorcionesComida->bindParam(":id_nutradol",$this->id_nutradol,PDO::PARAM_STR);
					$regPorcionesComida->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
					$regPorcionesComida->bindParam(":id_tiempo_alimento",$pk,PDO::PARAM_INT);
					$regPorcionesComida->bindParam(":num_porciones",$porcion,PDO::PARAM_INT);
					$regPorcionesComida->execute();								
				}
			}			
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
			
		}				
	}
	
	public function eliminaPorcionComida(){
		$conect= Yii::app()->db;
		$sqlFrecCons="delete from grupocomida_nutradol where id_val_nutricion=:id_val_nutricion and id_grupo_comida=:id_grupo_comida and id_nutradol=:id_nutradol";	
		$consFrecCons=$conect->createCommand($sqlFrecCons);
		$consFrecCons->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$consFrecCons->bindParam(":id_grupo_comida",$this->id_grupo_comida,PDO::PARAM_INT);
		$consFrecCons->bindParam(":id_nutradol",$this->id_nutradol,PDO::PARAM_INT);
		$readFrecCons=$consFrecCons->execute();
	}
}
