<?php

/**
 * This is the model class for table "telefono_forjar".
 *
 * The followings are the available columns in table 'telefono_forjar':
 * @property integer $id_telefono_forjar
 * @property integer $id_tipo_telefono
 * @property string $id_forjar
 * @property string $num_tel_forjar
 *
 * The followings are the available model relations:
 * @property CentroForjar $idForjar
 * @property TipoTelefono $idTipoTelefono
 */
class TelefonoForjar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $numCelular;
	public function tableName()
	{
		return 'telefono_forjar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipo_telefono, id_forjar, num_tel_forjar', 'required'),
			array('id_tipo_telefono', 'numerical', 'integerOnly'=>true),
			array('id_forjar', 'length', 'max'=>10),
			array('num_tel_forjar,numCelular', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_telefono_forjar, id_tipo_telefono, id_forjar, num_tel_forjar,numCelular', 'safe', 'on'=>'search'),
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
			'idForjar' => array(self::BELONGS_TO, 'CentroForjar', 'id_forjar'),
			'idTipoTelefono' => array(self::BELONGS_TO, 'TipoTelefono', 'id_tipo_telefono'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_telefono_forjar' => 'Teléfono Forjar',
			'id_tipo_telefono' => 'Tipo Teléfono',
			'id_forjar' => 'Forjar',
			'num_tel_forjar' => 'Número Telefóncio',
			'numCelular'=>'Número Celular'
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

		$criteria->compare('id_telefono_forjar',$this->id_telefono_forjar);
		$criteria->compare('id_tipo_telefono',$this->id_tipo_telefono);
		$criteria->compare('id_forjar',$this->id_forjar,true);
		$criteria->compare('num_tel_forjar',$this->num_tel_forjar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TelefonoForjar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
