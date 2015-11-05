<?php

/**
 * This is the model class for table "concepto_integral".
 *
 * The followings are the available columns in table 'concepto_integral':
 * @property string $fecha_concint
 * @property string $id_cedula
 * @property string $num_doc
 * @property string $concepto_integral
 * @property boolean $aprueba_psicol
 * @property boolean $aprueba_tsocial
 *
 * The followings are the available model relations:
 * @property Adolescente $numDoc
 * @property Persona $idCedula
 */
class ConceptoIntegral extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'concepto_integral';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_doc, concepto_integral,fecha_concint', 'required'),
			array('num_doc', 'length', 'max'=>15),
			array('aprueba_psicol, aprueba_tsocial', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fecha_concint, id_cedula, num_doc, concepto_integral, aprueba_psicol, aprueba_tsocial', 'safe', 'on'=>'search'),
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
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'idCedula' => array(self::BELONGS_TO, 'Persona', 'id_cedula'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fecha_concint' => 'Fecha Concint',
			'id_cedula' => 'Id Cedula',
			'num_doc' => 'Num Doc',
			'concepto_integral' => 'Concepto Integral',
			'aprueba_psicol' => 'Aprueba Psicol',
			'aprueba_tsocial' => 'Aprueba Tsocial',
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

		$criteria->compare('fecha_concint',$this->fecha_concint,true);
		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('concepto_integral',$this->concepto_integral,true);
		$criteria->compare('aprueba_psicol',$this->aprueba_psicol);
		$criteria->compare('aprueba_tsocial',$this->aprueba_tsocial);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ConceptoIntegral the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaConcInt(){
		$conect= Yii::app()->db;
		$sqlConsConcInt="select * from concepto_integral where num_doc=:num_doc";
		$consConcInt=$conect->createCommand($sqlConsConcInt);
		$consConcInt->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readConcInt=$consConcInt->query();
		$resConcInt=$readConcInt->read();
		$readConcInt->close();
		return $resConcInt;		
	}
	public function registraConcInt(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{//		$consProfAdol->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$sqlRegConcInt="insert into concepto_integral (
				fecha_concint,
				id_cedula,
				num_doc,
				concepto_integral
			) values (
				:fecha_concint,
				:id_cedula,
				:num_doc,
				:concepto_integral
			)";
			//$fechaRegistro=date("Y-m-d");
			$regConcInt=$conect->createCommand($sqlRegConcInt);
			$regConcInt->bindParam(":fecha_concint",$this->fecha_concint,PDO::PARAM_STR);
			$regConcInt->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regConcInt->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$regConcInt->bindParam(":concepto_integral",$this->concepto_integral,PDO::PARAM_STR);
			$regConcInt->execute();
			$transaction->commit($sqlRegConcInt);
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function modificaConcInt(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{//		$consProfAdol->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$sqlRegConcInt="update concepto_integral set concepto_integral=:concepto_integral where num_doc=:num_doc and fecha_concint=:fecha_concint";
			$regConcInt=$conect->createCommand($sqlRegConcInt);
			$regConcInt->bindParam(":fecha_concint",$this->fecha_concint,PDO::PARAM_STR);
			$regConcInt->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$regConcInt->bindParam(":concepto_integral",$this->concepto_integral,PDO::PARAM_STR);
			$regConcInt->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
		
	}
}
