<?php

/**
 * This is the model class for table "seguimiento_psc".
 *
 * The followings are the available columns in table 'seguimiento_psc':
 * @property integer $id_seguimiento_ind
 * @property integer $id_psc
 * @property string $id_cedula
 * @property string $desarrollo_act_psc
 * @property string $reporte_nov_psc
 * @property string $cump_acu_psc
 * @property string $fecha_seg_ind
 *
 * The followings are the available model relations:
 * @property AsistenciaPsc[] $asistenciaPscs
 * @property Persona $idCedula
 * @property Psc $idPsc
 */
class SeguimientoPsc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seguimiento_psc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('desarrollo_act_psc, reporte_nov_psc, cump_acu_psc, fecha_seg_ind', 'required'),
			array('id_psc', 'numerical', 'integerOnly'=>true),
			array('id_cedula', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_seguimiento_ind, id_psc, id_cedula, desarrollo_act_psc, reporte_nov_psc, cump_acu_psc, fecha_seg_ind', 'safe', 'on'=>'search'),
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
			'asistenciaPscs' => array(self::HAS_MANY, 'AsistenciaPsc', 'id_seguimiento_ind'),
			'idCedula' => array(self::BELONGS_TO, 'Persona', 'id_cedula'),
			'idPsc' => array(self::BELONGS_TO, 'Psc', 'id_psc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_seguimiento_ind' => 'Id Seguimiento Ind',
			'id_psc' => 'Id Psc',
			'id_cedula' => 'Id Cedula',
			'desarrollo_act_psc' => 'Desarrollo Act Psc',
			'reporte_nov_psc' => 'Reporte Nov Psc',
			'cump_acu_psc' => 'Cump Acu Psc',
			'fecha_seg_ind' => 'Fecha Seg Ind',
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

		$criteria->compare('id_seguimiento_ind',$this->id_seguimiento_ind);
		$criteria->compare('id_psc',$this->id_psc);
		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('desarrollo_act_psc',$this->desarrollo_act_psc,true);
		$criteria->compare('reporte_nov_psc',$this->reporte_nov_psc,true);
		$criteria->compare('cump_acu_psc',$this->cump_acu_psc,true);
		$criteria->compare('fecha_seg_ind',$this->fecha_seg_ind,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeguimientoPsc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
