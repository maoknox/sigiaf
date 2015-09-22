<?php

/**
 * This is the model class for table "localizacion_viv".
 *
 * The followings are the available columns in table 'localizacion_viv':
 * @property integer $id_loc_adol
 * @property string $num_doc
 * @property integer $id_estrato
 * @property string $id_municipio
 * @property integer $id_localidad
 * @property string $barrio
 * @property string $direccion
 *
 * The followings are the available model relations:
 * @property Estrato $idEstrato
 * @property Adolescente $numDoc
 * @property Municipio $idMunicipio
 * @property Localidad $idLocalidad
 */
class LocalizacionViv extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'localizacion_viv';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barrio,num_doc', 'required'),
			array('id_estrato, id_localidad', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('id_municipio', 'length', 'max'=>10),
			array('barrio', 'length', 'max'=>100),
			array('direccion', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_loc_adol, num_doc, id_estrato, id_municipio, id_localidad, barrio, direccion', 'safe', 'on'=>'search'),
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
			'idEstrato' => array(self::BELONGS_TO, 'Estrato', 'id_estrato'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'idMunicipio' => array(self::BELONGS_TO, 'Municipio', 'id_municipio'),
			'idLocalidad' => array(self::BELONGS_TO, 'Localidad', 'id_localidad'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_loc_adol' => 'Id Loc Adol',
			'num_doc' => 'Documento del adolescente: ',
			'id_estrato' => 'Id Estrato',
			'id_municipio' => 'Id Municipio',
			'id_localidad' => 'Id Localidad',
			'barrio' => 'Barrio',
			'direccion' => 'Direccion',
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

		$criteria->compare('id_loc_adol',$this->id_loc_adol);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_estrato',$this->id_estrato);
		$criteria->compare('id_municipio',$this->id_municipio,true);
		$criteria->compare('id_localidad',$this->id_localidad);
		$criteria->compare('barrio',$this->barrio,true);
		$criteria->compare('direccion',$this->direccion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LocalizacionViv the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}
