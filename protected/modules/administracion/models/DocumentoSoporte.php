<?php

/**
 * This is the model class for table "documento_soporte".
 *
 * The followings are the available columns in table 'documento_soporte':
 * @property integer $id_doc_soporte
 * @property string $nombre_doc_ds
 * @property string $ruta_acceso_ds
 * @property string $fecha_reg_ds
 *
 * The followings are the available model relations:
 * @property CambioSede[] $cambioSedes
 */
class DocumentoSoporte extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $nombreDocAux;
	public function tableName()
	{
		return 'documento_soporte';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_doc_ds, ruta_acceso_ds, fecha_reg_ds', 'required'),
			array('nombre_doc_ds,nombreDocAux', 'length', 'max'=>100),
			array('nombre_doc_ds', 'file', 'types'=>'pdf','message'=>'Solo puede adjuntar archivos pdf'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_doc_soporte,nombreDocAux, nombre_doc_ds, ruta_acceso_ds, fecha_reg_ds', 'safe', 'on'=>'search'),
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
			'cambioSedes' => array(self::HAS_MANY, 'CambioSede', 'id_doc_soporte'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_doc_soporte' => 'id Doc soporte',
			'nombre_doc_ds' => 'Documento Soporte',
			'ruta_acceso_ds' => 'Ruta de Acceso',
			'fecha_reg_ds' => 'Fecha Registro',
			'nombreDocAux'=>'nombreauxdoc'
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

		$criteria->compare('id_doc_soporte',$this->id_doc_soporte);
		$criteria->compare('nombre_doc_ds',$this->nombre_doc_ds,true);
		$criteria->compare('ruta_acceso_ds',$this->ruta_acceso_ds,true);
		$criteria->compare('fecha_reg_ds',$this->fecha_reg_ds,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DocumentoSoporte the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
