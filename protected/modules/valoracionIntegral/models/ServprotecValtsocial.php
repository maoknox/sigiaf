<?php

/**
 * This is the model class for table "servprotec_valtsocial".
 *
 * The followings are the available columns in table 'servprotec_valtsocial':
 * @property integer $id_serv_protec
 * @property integer $id_valtsoc
 */
class ServprotecValtsocial extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $sevprot;
	public function tableName()
	{
		return 'servprotec_valtsocial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_serv_protec, id_valtsoc', 'required'),
			array('id_serv_protec, id_valtsoc', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_serv_protec, id_valtsoc', 'safe', 'on'=>'search'),
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
			'id_serv_protec' => 'servicio protección',
			'id_valtsoc' => 'Valoración trabajo social',
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

		$criteria->compare('id_serv_protec',$this->id_serv_protec);
		$criteria->compare('id_valtsoc',$this->id_valtsoc);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServprotecValtsocial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function registraServProtec(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlDelServProt="delete from servprotec_valtsocial where id_valtsoc=:id_valtsoc";
			$delServProt=$conect->createCommand($sqlDelServProt);
			$delServProt->bindParam(":id_valtsoc",$this->id_valtsoc,PDO::PARAM_INT);
			$delServProt->execute();
			
			$sqlRegServProt="insert into servprotec_valtsocial (
				id_serv_protec,
				id_valtsoc
			) values (
				:id_serv_protec,
				:id_valtsoc
			)";
			foreach($this->sevprot as $servProt){
				$regServProt=$conect->createCommand($sqlRegServProt);
				$regServProt->bindParam(":id_serv_protec",$servProt,PDO::PARAM_INT);
				$regServProt->bindParam(":id_valtsoc",$this->id_valtsoc,PDO::PARAM_INT);
				$regServProt->execute();				
			}
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
		
	}
}
