<?php

/**
 * This is the model class for table "problema_valtsocial".
 *
 * The followings are the available columns in table 'problema_valtsocial':
 * @property integer $id_problema_asoc
 * @property integer $id_valtsoc
 * @property boolean $vinc_act_prob
 * @property boolean $asociado_probvts
 */
class ProblemaValtsocial extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $probAsoc;
	public $vincPand;
	public $vincBarrFut;
	public function tableName()
	{
		return 'problema_valtsocial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_problema_asoc, id_valtsoc', 'required'),
			array('id_problema_asoc, id_valtsoc', 'numerical', 'integerOnly'=>true),
			array('vinc_act_prob, asociado_probvts', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_problema_asoc, id_valtsoc, vinc_act_prob, asociado_probvts', 'safe', 'on'=>'search'),
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
			'id_problema_asoc' => 'Problemas asociados',
			'id_valtsoc' => 'Id Valtsoc',
			'vinc_act_prob' => 'Vinc Act Prob',
			'asociado_probvts' => 'Asociado Probvts',
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

		$criteria->compare('id_problema_asoc',$this->id_problema_asoc);
		$criteria->compare('id_valtsoc',$this->id_valtsoc);
		$criteria->compare('vinc_act_prob',$this->vinc_act_prob);
		$criteria->compare('asociado_probvts',$this->asociado_probvts);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProblemaValtsocial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function registraProbAsoc(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlDelProb="delete from problema_valtsocial where id_valtsoc=:id_valtsoc";
			$delProb=$conect->createCommand($sqlDelProb);
			$delProb->bindParam(":id_valtsoc",$this->id_valtsoc,PDO::PARAM_INT);
			$delProb->execute();
			$sqlRegProb="insert into problema_valtsocial (
				id_problema_asoc,
				id_valtsoc,
				vinc_act_prob
			) values(
				:id_problema_asoc,
				:id_valtsoc,
				:vinc_act_prob
			)";
			foreach($this->probAsoc as $probAsoc){
				$vincAct=false;
				if($probAsoc==12){
					if(!empty($this->vincPand)){
						$vincAct=true;
					}						
				}
				if($probAsoc==13){
					if(!empty($this->vincBarrFut)){
						$vincAct=true;
					}						
				}
				$regProb=$conect->createCommand($sqlRegProb);
				$regProb->bindParam(":id_problema_asoc",$probAsoc,PDO::PARAM_INT);
				$regProb->bindParam(":id_valtsoc",$this->id_valtsoc,PDO::PARAM_INT);
				$regProb->bindParam(":vinc_act_prob",$vincAct,PDO::PARAM_BOOL);
				$regProb->execute();				
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
