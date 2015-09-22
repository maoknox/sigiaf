<?php

/**
 * This is the model class for table "origenalim_valnutr".
 *
 * The followings are the available columns in table 'origenalim_valnutr':
 * @property integer $id_origen_alim
 * @property integer $id_val_nutricion
 */
class OrigenalimValnutr extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $_origenAlimentos;
	public function tableName()
	{
		return 'origenalim_valnutr';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_origen_alim, id_val_nutricion', 'required'),
			array('id_origen_alim, id_val_nutricion', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_origen_alim, id_val_nutricion', 'safe', 'on'=>'search'),
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
			'id_origen_alim' => 'Origen de los alimentos',
			'id_val_nutricion' => 'Id Val Nutricion',
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

		$criteria->compare('id_origen_alim',$this->id_origen_alim);
		$criteria->compare('id_val_nutricion',$this->id_val_nutricion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrigenalimValnutr the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function consultaOrigenAlimentosHogar(){
		$conect=Yii::app()->db;
		$sqlConsOrigenAlim="select * from origenalim_valnutr where id_val_nutricion=:id_val_nutricion";
		$consOrigenAlim=$conect->createCommand($sqlConsOrigenAlim);
		$consOrigenAlim->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_STR);
		$readOrigenAlim=$consOrigenAlim->query();
		$resLabOrigenAlim=$readOrigenAlim->readAll();
		$readOrigenAlim->close();
		return $resLabOrigenAlim;		
	}
	public function registraOrigenAlimentos(){
		if(!empty($this->_origenAlimentos)){
			$conect= Yii::app()->db;
			$transaction=$conect->beginTransaction();
			$sqlDelOrAlim="delete from origenalim_valnutr where id_val_nutricion=:id_val_nutricion";
			$delOrAl=$conect->createCommand($sqlDelOrAlim);
			$delOrAl->bindParam(":id_val_nutricion",$this->id_val_nutricion);
			$delOrAl->execute();
			$sqlRegOrAl="insert into origenalim_valnutr (
				id_origen_alim,
			 	id_val_nutricion
			) values (
				:id_origen_alim,
			 	:id_val_nutricion
			)";
			//foreach($this->_grupoDiscapacidad as $discapacidad){			
			try{
				foreach($this->_origenAlimentos as $origen){
					$regOrAlim=$conect->createCommand($sqlRegOrAl);						
					$regOrAlim->bindParam(":id_origen_alim",$origen);
					$regOrAlim->bindParam(":id_val_nutricion",$this->id_val_nutricion);
					$regOrAlim->execute();						
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
