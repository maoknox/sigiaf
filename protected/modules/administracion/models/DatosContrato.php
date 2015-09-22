<?php

/**
 * This is the model class for table "datos_contrato".
 *
 * The followings are the available columns in table 'datos_contrato':
 * @property integer $id_pers_contrato
 * @property string $id_cedula
 * @property string $numero_contrato
 * @property string $fecha_contrato
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $fecha_extension
 * @property boolean $contrato_actual
 *
 * The followings are the available model relations:
 * @property Persona $idCedula
 */
class DatosContrato extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $contrato;
	public function tableName()
	{
		return 'datos_contrato';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cedula, numero_contrato, fecha_contrato, fecha_inicio, fecha_fin, contrato_actual', 'required'),
			array('numero_contrato', 'length', 'max'=>10),
			array('fecha_extension', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_pers_contrato, id_cedula, numero_contrato, fecha_contrato, fecha_inicio, fecha_fin, fecha_extension, contrato_actual', 'safe', 'on'=>'search'),
			array('fecha_inicio', 'compruebaFechaInicio'),
			array('fecha_inicio', 'compruebaFechaFin'),
			array('id_cedula', 'compruebaContrato'),
			array('fecha_extension', 'compruebaFechaExt'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function  compruebaFechaInicio($attribute,$params){
		if(!$this->hasErrors()){
			$datosInput=Yii::app()->input->post();
			$dias	= (strtotime($datosInput["DatosContrato"]["fecha_inicio"])-strtotime($datosInput["DatosContrato"]["fecha_contrato"]))/86400;
			//$dias 	= abs($dias); 
			$dias = floor($dias);	
			if($dias<0){
				$this->addError($attribute,'La fecha de inicio no puede ser menor a la fecha del contrato');
			}
		}				
	}
	public function  compruebaFechaFin($attribute,$params){
		if(!$this->hasErrors()){
			$datosInput=Yii::app()->input->post();
			$dias	= (strtotime($datosInput["DatosContrato"]["fecha_fin"])-strtotime($datosInput["DatosContrato"]["fecha_inicio"]))/86400;
			//$dias 	= abs($dias); 
			$dias = floor($dias);	
			if($dias<0){
				$this->addError($attribute,'La fecha de inicio no puede ser menor a la fecha del contrato');
			}
		}				
	}
	public function compruebaContrato($attribute,$params){
		if(!$this->hasErrors()){
			if(Yii::app()->controller->action->id=="asociarContratoFuncionario"){
				$datosInput=Yii::app()->input->post();
				$this->id_cedula=$datosInput["DatosContrato"]["id_cedula"];
				$contrato=$this->consultaContratoAct();
				if(!empty($contrato)){
					$this->addError($attribute,'El funcionario tienen un contrato vigente');
				}
			}
		}				
	}
	public function compruebaFechaExt($attribute,$params){
		if(!$this->hasErrors()){
			if(Yii::app()->controller->action->id=="realizaExtContratoFuncionario"){
				$datosInput=Yii::app()->input->post();
				$this->fecha_extension=$datosInput["DatosContrato"]["fecha_extension"];
				//$contrato=$this->consultaContratoAct();
				if(empty($this->fecha_extension)){
					$this->addError($attribute,'Fecha extensión no puede ser nula');
				}
			}
		}				
	}
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idCedula' => array(self::BELONGS_TO, 'Persona', 'id_cedula'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_pers_contrato' => 'Id Pers Contrato',
			'id_cedula' => 'Persona',
			'numero_contrato' => 'Numero Contrato',
			'fecha_contrato' => 'Fecha Contrato',
			'fecha_inicio' => 'Fecha Inicio',
			'fecha_fin' => 'Fecha Fin',
			'fecha_extension' => 'Fecha Extension',
			'contrato_actual' => 'Contrato Actual',
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

		$criteria->compare('id_pers_contrato',$this->id_pers_contrato);
		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('numero_contrato',$this->numero_contrato,true);
		$criteria->compare('fecha_contrato',$this->fecha_contrato,true);
		$criteria->compare('fecha_inicio',$this->fecha_inicio,true);
		$criteria->compare('fecha_fin',$this->fecha_fin,true);
		$criteria->compare('fecha_extension',$this->fecha_extension,true);
		$criteria->compare('contrato_actual',$this->contrato_actual);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DatosContrato the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaContratoAct(){
		$conect= Yii::app()->db;
		$sqlConsContrato="select * from datos_contrato where id_cedula=:id_cedula and contrato_actual='true'";
		$consContrato=$conect->createCommand($sqlConsContrato);		
		$consContrato->bindParam(":id_cedula",$this->id_cedula);
		$readContrato=$consContrato->query();
		$resContrato=$readContrato->read();
		$readContrato->close();
		$dias	= (strtotime($resContrato['fecha_fin'])-strtotime(date("Y-m-d")))/86400;
		$dias = floor($dias);			
		if($dias<0){
			if(!empty($resContrato['fecha_extension'])){
				$diasExt	= (strtotime($resContrato['fecha_extension'])-strtotime(date("Y-m-d")))/86400;
				$diasExt = floor($diasExt);			
				if($diasExt<0){
					$this->contrato_actual='false';
					$this->cambiaEstadoContrato(); 
				}						
			}
			else{
				$this->contrato_actual='false';
				$this->cambiaEstadoContrato(); 
			}
		}
		return $resContrato;
	}
	public function consUltimoContrato(){
		$conect= Yii::app()->db;
		$sqlConsContrato="select * from datos_contrato where id_cedula=:id_cedula order by fecha_fin desc limit 1";
		$consContrato=$conect->createCommand($sqlConsContrato);		
		$consContrato->bindParam(":id_cedula",$this->id_cedula);
		$readContrato=$consContrato->query();
		$resContrato=$readContrato->read();
		$readContrato->close();
		return $resContrato;
	}
	
	public function registraExtContrato(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegExtContrato="update datos_contrato set fecha_extension=:fecha_extension, contrato_actual=:contrato_actual where id_cedula=:id_cedula and numero_contrato=:numero_contrato";
			$regExtContrato=$conect->createCommand($sqlRegExtContrato);
			$regExtContrato->bindParam(":id_cedula",$this->id_cedula,PDO::PARAM_INT);
			$regExtContrato->bindParam(":numero_contrato",$this->numero_contrato,PDO::PARAM_STR);
			$regExtContrato->bindParam(":fecha_extension",$this->fecha_extension,PDO::PARAM_STR);
			$regExtContrato->bindParam(":contrato_actual",$this->contrato_actual,PDO::PARAM_STR);
			$regExtContrato->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;			
		}		
	}
	public function modificaContratoAct(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlModifContrato="update datos_contrato set 
				fecha_contrato=:fecha_contrato,
				fecha_inicio=:fecha_inicio,
				fecha_fin=:fecha_fin
			where 
				id_cedula=:id_cedula 
				and numero_contrato=:numero_contrato";
			$modifContrato=$conect->createCommand($sqlModifContrato);
			$modifContrato->bindParam(":id_cedula",$this->id_cedula,PDO::PARAM_INT);
			$modifContrato->bindParam(":numero_contrato",$this->numero_contrato,PDO::PARAM_STR);
			$modifContrato->bindParam(":fecha_contrato",$this->fecha_contrato,PDO::PARAM_STR);
			$modifContrato->bindParam(":fecha_inicio",$this->fecha_inicio,PDO::PARAM_STR);
			$modifContrato->bindParam(":fecha_fin",$this->fecha_fin,PDO::PARAM_STR);
			$modifContrato->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;			
		}		
	}
	public function cambiaEstadoContrato(){
		$conect= Yii::app()->db;
		$sqlActEstado="update datos_contrato set contrato_actual=:contrato_actual where id_cedula=:id_cedula";
		$actEstado=$conect->createCommand($sqlActEstado);
		$actEstado->bindParam(":contrato_actual",$this->contrato_actual,PDO::PARAM_BOOL);
		$actEstado->bindParam(":id_cedula",$this->id_cedula,PDO::PARAM_INT);
		$actEstado->execute();		
	}
	
	public function registraContratoFuncionario(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegContratoFunc="insert into datos_contrato (
				id_pers_contrato,
				id_cedula,
				numero_contrato,
				fecha_contrato,
				fecha_inicio,
				fecha_fin,
				contrato_actual
			) values (
				default,
				:id_cedula,
				:numero_contrato,
				:fecha_contrato,
				:fecha_inicio,
				:fecha_fin,
				'true'
			)";
			$regContratoFunc=$conect->createCommand($sqlRegContratoFunc);
			$regContratoFunc->bindParam(":id_cedula",$this->id_cedula,PDO::PARAM_INT);
			$regContratoFunc->bindParam(":numero_contrato",$this->numero_contrato,PDO::PARAM_STR);
			$regContratoFunc->bindParam(":fecha_contrato",$this->fecha_contrato,PDO::PARAM_STR);
			$regContratoFunc->bindParam(":fecha_inicio",$this->fecha_inicio,PDO::PARAM_STR);
			$regContratoFunc->bindParam(":fecha_fin",$this->fecha_fin,PDO::PARAM_STR);
			$regContratoFunc->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;			
		}		
	}
}
