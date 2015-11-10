<?php

/**
 * This is the model class for table "novedad_inf_judicial".
 *
 * The followings are the available columns in table 'novedad_inf_judicial':
 * @property integer $id_inf_judicial
 * @property integer $nov_id_inf_judicial
 * @property string $fecha_reg_novedad
 *
 * The followings are the available model relations:
 * @property InformacionJudicial $idInfJudicial
 * @property InformacionJudicial $novIdInfJudicial
 */
class NovedadInfJudicial extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'novedad_inf_judicial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_inf_judicial, nov_id_inf_judicial', 'required'),
			array('id_inf_judicial, nov_id_inf_judicial', 'numerical', 'integerOnly'=>true),
			array('fecha_reg_novedad', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_inf_judicial, nov_id_inf_judicial, fecha_reg_novedad', 'safe', 'on'=>'search'),
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
			'idInfJudicial' => array(self::BELONGS_TO, 'InformacionJudicial', 'id_inf_judicial'),
			'novIdInfJudicial' => array(self::BELONGS_TO, 'InformacionJudicial', 'nov_id_inf_judicial'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_inf_judicial' => 'Información judicial',
			'nov_id_inf_judicial' => 'Nov información Judicial',
			'fecha_reg_novedad' => 'Fecha registro Novedad',
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

		$criteria->compare('id_inf_judicial',$this->id_inf_judicial);
		$criteria->compare('nov_id_inf_judicial',$this->nov_id_inf_judicial);
		$criteria->compare('fecha_reg_novedad',$this->fecha_reg_novedad,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NovedadInfJudicial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
