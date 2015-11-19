<?php

/**
 * This is the model class for table "log_acceso".
 *
 * The followings are the available columns in table 'log_acceso':
 * @property integer $id_logacceso
 * @property string $id_cedula
 * @property integer $id_tipoacceso
 * @property string $fecha_logacceso
 * @property string $ip_acceso
 *
 * The followings are the available model relations:
 * @property Persona $idCedula
 * @property TipoAcceso $idTipoacceso
 */
class LogAcceso extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log_acceso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cedula, id_tipoacceso, fecha_logacceso', 'required'),
			array('id_tipoacceso', 'numerical', 'integerOnly'=>true),
			array('ip_acceso', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_logacceso, id_cedula, id_tipoacceso, fecha_logacceso, ip_acceso', 'safe', 'on'=>'search'),
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
			'idCedula' => array(self::BELONGS_TO, 'Persona', 'id_cedula'),
			'idTipoacceso' => array(self::BELONGS_TO, 'TipoAcceso', 'id_tipoacceso'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_logacceso' => 'Id Logacceso',
			'id_cedula' => 'Profesional',
			'id_tipoacceso' => 'Id Tipoacceso',
			'fecha_logacceso' => 'Fecha Logacceso',
			'ip_acceso' => 'Ip Acceso',
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

		$criteria->compare('id_logacceso',$this->id_logacceso);
		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('id_tipoacceso',$this->id_tipoacceso);
		$criteria->compare('fecha_logacceso',$this->fecha_logacceso,true);
		$criteria->compare('ip_acceso',$this->ip_acceso,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogAcceso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Registra la hora de inicio de sesión y terminación de sesión del usuario junto con el número del documento, fecha y hora.
	 */		
	public function registraAcceso(){
		if(!Yii::app()->user->isGuest){
			$conect=Yii::app()->db;
			$transaction=$conect->beginTransaction();
			try{
				$sqlCreaRegAcceso="insert into log_acceso (
					id_logacceso,
					id_cedula,
					id_tipoacceso,
					fecha_logacceso,
					ip_acceso		
				) values (
					default,
					:id_cedula,
					:id_tipoacceso,
					:fecha_logacceso,
					:ip_acceso		
				)";	
				$creaRegAcceso=$conect->createCommand($sqlCreaRegAcceso);
				$creaRegAcceso->bindParam(":id_cedula",$this->id_cedula,PDO::PARAM_INT);
				$creaRegAcceso->bindParam(":id_tipoacceso",$this->id_tipoacceso,PDO::PARAM_INT);
				$creaRegAcceso->bindParam(":fecha_logacceso",$this->fecha_logacceso,PDO::PARAM_STR);
				$creaRegAcceso->bindParam(":ip_acceso",$this->ip_acceso,PDO::PARAM_NULL);
				$creaRegAcceso->execute();
				$transaction->commit();
			}
			catch(CDbCommand $e){
				$transaction->rollBack();
				throw new CHttpException(403,'No tiene acceso a esta acción');
			}
		}
	}
}
