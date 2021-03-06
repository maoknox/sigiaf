<?php

/**
 * This is the model class for table "esquema_vacunacion".
 *
 * The followings are the available columns in table 'esquema_vacunacion':
 * @property integer $id_esquema_vac
 * @property string $esquema_vac
 *
 * The followings are the available model relations:
 * @property ValoracionNutricional[] $valoracionNutricionals
 */
class EsquemaVacunacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'esquema_vacunacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('esquema_vac', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_esquema_vac, esquema_vac', 'safe', 'on'=>'search'),
			array('id_esquema_vac','validaObs', $this->id_esquema_vac),
		);
	}
	public function validaObs($attribute=NULL,$params=NULL){
		$datosInput=Yii::app()->input->post();
		//$var=false;
		if($datosInput["ValoracionNutricional"]["id_esquema_vac"]==3 && strlen($datosInput["ValoracionNutricional"]["obs_esquema_vac"])<Yii::app()->params['num_caracteres']){
			$this->addError($attribute,"Si seleccionó esquema incompleto, debe mencionar cuáles vacunas hacen falta en el campo siguiente.");
		}				
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'valoracionNutricionals' => array(self::HAS_MANY, 'ValoracionNutricional', 'id_esquema_vac'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_esquema_vac' => 'Esquema vacunación',
			'esquema_vac' => 'Esquema vacunación',
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

		$criteria->compare('id_esquema_vac',$this->id_esquema_vac);
		$criteria->compare('esquema_vac',$this->esquema_vac,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EsquemaVacunacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
