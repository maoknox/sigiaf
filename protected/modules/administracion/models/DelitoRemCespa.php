<?php

/**
 * This is the model class for table "delito_rem_cespa".
 *
 * The followings are the available columns in table 'delito_rem_cespa':
 * @property integer $id_del_rc
 * @property string $del_remcespa
 *
 * The followings are the available model relations:
 * @property DelitoPorVinc[] $delitoPorVincs
 * @property InformacionJudicial[] $informacionJudicials
 */
class DelitoRemCespa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'delito_rem_cespa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('del_remcespa', 'required'),
			array('del_remcespa', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_del_rc, del_remcespa', 'safe', 'on'=>'search'),
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
			'delitoPorVincs' => array(self::HAS_MANY, 'DelitoPorVinc', 'id_del_rc'),
			'informacionJudicials' => array(self::MANY_MANY, 'InformacionJudicial', 'infjud_del_remcesp(id_del_rc, id_inf_judicial)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_del_rc' => 'Id Del Rc',
			'del_remcespa' => 'Delito',
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

		$criteria->compare('id_del_rc',$this->id_del_rc);
		$criteria->compare('del_remcespa',$this->del_remcespa,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DelitoRemCespa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function creaDelito(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaDelito="insert into delito_rem_cespa (
				id_del_rc,
				del_remcespa
			) values (
				default,
				:del_remcespa
			)";
			$creaDelito=$conect->createCommand($sqlCreaDelito);
			$creaDelito->bindParam(":del_remcespa",$this->del_remcespa,PDO::PARAM_STR);		
			$creaDelito->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollback();
			return $e;
			
		}
	}
}
