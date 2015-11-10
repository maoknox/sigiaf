<?php

class ReporteAsistencia extends CFormModel
{

	/**
	 * @return array validation rules for model attributes.
	 */
	public $mes;
	public $anio;
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mes,anio', 'required'),
			array('mes, anio', 'numerical', 'integerOnly'=>true),
			array('mes', 'length', 'max'=>2),
			array('anio', 'length', 'max'=>4),
			array('mes,anio', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mes' => 'Mes',
			'anio' => 'Año',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Asistencia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}