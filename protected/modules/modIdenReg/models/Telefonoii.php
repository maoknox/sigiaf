<?php

/**
 * This is the model class for table "telefono".
 *
 * The followings are the available columns in table 'telefono':
 * @property integer $id_telefono
 * @property integer $id_tipo_telefono
 * @property string $num_doc
 * @property string $telefono
 *
 * The followings are the available model relations:
 * @property Adolescente $numDoc
 * @property TipoTelefono $idTipoTelefono
 */
class Telefono extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $tel_sec;//Teléfono secundario
	public $celular;//Número de celular del adolescente
	
	public function tableName()
	{
		return 'telefono';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('telefono', 'required'),
			array('id_tipo_telefono', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('telefono,tel_sec,celular', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_telefono, id_tipo_telefono, num_doc, telefono', 'safe', 'on'=>'search'),
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
			'idTipoTelefono' => array(self::BELONGS_TO, 'TipoTelefono', 'id_tipo_telefono'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_telefono' => 'Id Telefono',
			'id_tipo_telefono' => 'Id Tipo Telefono',
			'num_doc' => 'Num Doc',
			'telefono' => 'Telefono',
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

		$criteria->compare('id_telefono',$this->id_telefono);
		$criteria->compare('id_tipo_telefono',$this->id_tipo_telefono);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('telefono',$this->telefono,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Telefono the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
