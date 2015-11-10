<?php

/**
 * This is the model class for table "tipodisc_valnutr".
 *
 * The followings are the available columns in table 'tipodisc_valnutr':
 * @property integer $id_tipo_discap
 * @property integer $id_val_nutricion
 */
class TipodiscValnutr extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $_grupoDiscapacidad;
	public function tableName()
	{
		return 'tipodisc_valnutr';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipo_discap, id_val_nutricion', 'required'),
			array('id_tipo_discap, id_val_nutricion', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_tipo_discap, id_val_nutricion', 'safe', 'on'=>'search'),
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
			'id_tipo_discap' => 'Tipo de discapacidad',
			'id_val_nutricion' => 'Valoración nutricional',
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

		$criteria->compare('id_tipo_discap',$this->id_tipo_discap);
		$criteria->compare('id_val_nutricion',$this->id_val_nutricion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TipodiscValnutr the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaTiposDiscAdol(){
		$conect=Yii::app()->db;
		$sqlConsTipoDiscAdol="select * from tipodisc_valnutr where id_val_nutricion=:id_val_nutricion";
		$consTipoDiscAdol=$conect->createCommand($sqlConsTipoDiscAdol);
		$consTipoDiscAdol->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_STR);
		$readTipoDiscAdol=$consTipoDiscAdol->query();
		$resTipoDiscAdol=$readTipoDiscAdol->readAll();
		$readTipoDiscAdol->close();
		return $resTipoDiscAdol;				
	}
	public function registraDiscapacidad(){
		if(!empty($this->_grupoDiscapacidad)){
			$conect= Yii::app()->db;
			$transaction=$conect->beginTransaction();
			$sqlDelDisc="delete from tipodisc_valnutr where id_val_nutricion=:id_val_nutricion";
			$delDisc=$conect->createCommand($sqlDelDisc);
			$delDisc->bindParam(":id_val_nutricion",$this->id_val_nutricion);
			$delDisc->execute();
			$sqlRegDisc="insert into tipodisc_valnutr (
				id_tipo_discap,
			 	id_val_nutricion
			) values (
				:id_tipo_discap,
			 	:id_val_nutricion
			)";
			//foreach($this->_grupoDiscapacidad as $discapacidad){			
			try{
				foreach($this->_grupoDiscapacidad as $discapacidad){
					$regDisc=$conect->createCommand($sqlRegDisc);						
					$regDisc->bindParam(":id_tipo_discap",$discapacidad);
					$regDisc->bindParam(":id_val_nutricion",$this->id_val_nutricion);
					$regDisc->execute();						
				}
				$transaction->commit();
				return "exito";
			}										
			catch(CDbCommand $e){
				$transaction->rollBack();
				return $mensaje;				
			}
		}		
	}
}
