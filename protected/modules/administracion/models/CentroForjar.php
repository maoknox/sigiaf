<?php

/**
 * This is the model class for table "centro_forjar".
 *
 * The followings are the available columns in table 'centro_forjar':
 * @property string $id_forjar
 * @property integer $id_tiempoact
 * @property string $nombre_sede
 * @property string $direccion_forjar
 *
 * The followings are the available model relations:
 * @property Persona[] $personas
 * @property Adolescente[] $adolescentes
 * @property NumeroCarpeta[] $numeroCarpetas
 * @property TelefonoForjar[] $telefonoForjars
 * @property TiempoActuacion $idTiempoact
 */
class CentroForjar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'centro_forjar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_sede, direccion_forjar', 'required'),
			array('id_tiempoact', 'numerical', 'integerOnly'=>true),
			array('id_forjar', 'length', 'max'=>10),
			array('nombre_sede', 'length', 'max'=>100),
			array('direccion_forjar', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_forjar, id_tiempoact, nombre_sede, direccion_forjar', 'safe', 'on'=>'search'),
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
			'personas' => array(self::MANY_MANY, 'Persona', 'cforjar_personal(id_forjar, id_cedula)'),
			'adolescentes' => array(self::MANY_MANY, 'Adolescente', 'forjar_adol(id_forjar, num_doc)'),
			'numeroCarpetas' => array(self::HAS_MANY, 'NumeroCarpeta', 'id_forjar'),
			'telefonoForjars' => array(self::HAS_MANY, 'TelefonoForjar', 'id_forjar'),
			'idTiempoact' => array(self::BELONGS_TO, 'TiempoActuacion', 'id_tiempoact'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_forjar' => 'Id Forjar',
			'id_tiempoact' => 'Id Tiempoact',
			'nombre_sede' => 'Nombre Sede',
			'direccion_forjar' => 'Dirección Forjar',
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

		$criteria->compare('id_forjar',$this->id_forjar,true);
		$criteria->compare('id_tiempoact',$this->id_tiempoact);
		$criteria->compare('nombre_sede',$this->nombre_sede,true);
		$criteria->compare('direccion_forjar',$this->direccion_forjar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CentroForjar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function consultaSedesCreadas(){
		$conect=Yii::app()->db;
		$sqlConsSedes="select * from centro_forjar order by id_forjar asc";
		$consSedes=$conect->createCommand($sqlConsSedes);
		$consSedes->execute();
		$readSedes=$consSedes->query();
		$resSedes=$readSedes->readAll();
		$readSedes->close();
		return $resSedes;		
	}
	
	public function consultaSedes($idSedeActual=null){
		$conect=Yii::app()->db;
		$sqlConsSedes="select * from centro_forjar where id_forjar<>:id_forjar";
		$consSedes=$conect->createCommand($sqlConsSedes);
		$consSedes->bindParam(":id_forjar",$idSedeActual);
		$consSedes->execute();
		$readSedes=$consSedes->query();
		$resSedes=$readSedes->readAll();
		$readSedes->close();
		return $resSedes;
	}
	public function consultaTelefonoSede(){
		$conect=Yii::app()->db;
		$sqlConsTelSede="select * from telefono_forjar where id_forjar=:id_forjar";
		$consTelSede=$conect->createCommand($sqlConsTelSede);
		$consTelSede->bindParam(":id_forjar",$this->id_forjar);
		$consTelSede->execute();
		$readTelSede=$consTelSede->query();
		$resTelSede=$readTelSede->readAll();
		$readTelSede->close();
		return $resTelSede;
	}
}
