<?php

/**
 * This is the model class for table "forjar_adol".
 *
 * The followings are the available columns in table 'forjar_adol':
 * @property string $id_forjar
 * @property string $num_doc
 * @property string $fecha_primer_ingreso
 * @property string $fecha_vinc_forjar
 * @property integer $num_ingresos
 * @property string $observaciones_ingreso
 * @property integer $tiempo_modificacion
 */
class ForjarAdol extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'forjar_adol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(' num_doc', 'required'),
			array('num_ingresos, tiempo_modificacion', 'numerical', 'integerOnly'=>true),
			array('id_forjar', 'length', 'max'=>10),
			array('num_doc', 'length', 'max'=>15),
			array('fecha_primer_ingreso, fecha_vinc_forjar, observaciones_ingreso', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_forjar, num_doc, fecha_primer_ingreso, fecha_vinc_forjar, num_ingresos, observaciones_ingreso, tiempo_modificacion', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_forjar' => 'Id Forjar',
			'num_doc' => 'Num Doc',
			'fecha_primer_ingreso' => 'Fecha primer ingreso',
			'fecha_vinc_forjar' => 'Fecha vinculación a Forjar',
			'num_ingresos' => 'No. de ingresos',
			'observaciones_ingreso' => 'Observaciones ingreso',
			'tiempo_modificacion' => 'Tiempo Modificacion',
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
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('fecha_primer_ingreso',$this->fecha_primer_ingreso,true);
		$criteria->compare('fecha_vinc_forjar',$this->fecha_vinc_forjar,true);
		$criteria->compare('num_ingresos',$this->num_ingresos);
		$criteria->compare('observaciones_ingreso',$this->observaciones_ingreso,true);
		$criteria->compare('tiempo_modificacion',$this->tiempo_modificacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ForjarAdol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaDatosForjarAdol(){
		$conect=Yii::app()->db;
		$sqlConsForjarAdol="select * from forjar_adol where num_doc=:num_doc";
		$consForjarAdol=$conect->createCommand($sqlConsForjarAdol);	
		$consForjarAdol->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readForjarAdol=$consForjarAdol->query();
		$resForjarAdol=$readForjarAdol->read();
		$readForjarAdol->close();
		return $resForjarAdol;
	}
}
