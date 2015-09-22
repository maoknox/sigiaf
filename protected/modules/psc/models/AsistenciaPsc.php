<?php

/**
 * This is the model class for table "asistencia_psc".
 *
 * The followings are the available columns in table 'asistencia_psc':
 * @property integer $id_asist_psc
 * @property integer $id_hora_dia
 * @property integer $id_seguimiento_ind
 * @property string $fecha_asist_psc
 *
 * The followings are the available model relations:
 * @property DiaHora $idHoraDia
 * @property SeguimientoPsc $idSeguimientoInd
 */
class AsistenciaPsc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'asistencia_psc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha_asist_psc', 'required'),
			array('id_hora_dia, id_seguimiento_ind', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_asist_psc, id_hora_dia, id_seguimiento_ind, fecha_asist_psc', 'safe', 'on'=>'search'),
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
			'idHoraDia' => array(self::BELONGS_TO, 'DiaHora', 'id_hora_dia'),
			'idSeguimientoInd' => array(self::BELONGS_TO, 'SeguimientoPsc', 'id_seguimiento_ind'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_asist_psc' => 'Id Asist Psc',
			'id_hora_dia' => 'Id Hora Dia',
			'id_seguimiento_ind' => 'Id Seguimiento Ind',
			'fecha_asist_psc' => 'Fecha Asist Psc',
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

		$criteria->compare('id_asist_psc',$this->id_asist_psc);
		$criteria->compare('id_hora_dia',$this->id_hora_dia);
		$criteria->compare('id_seguimiento_ind',$this->id_seguimiento_ind);
		$criteria->compare('fecha_asist_psc',$this->fecha_asist_psc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AsistenciaPsc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
