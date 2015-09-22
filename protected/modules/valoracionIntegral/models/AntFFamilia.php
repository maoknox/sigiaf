<?php

/**
 * This is the model class for table "ant_f_familia".
 *
 * The followings are the available columns in table 'ant_f_familia':
 * @property integer $id_ant_fam
 * @property integer $id_valtsoc
 */
class AntFFamilia extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $antFamiliares;
	public function tableName()
	{
		return 'ant_f_familia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ant_fam, id_valtsoc', 'required'),
			array('id_ant_fam, id_valtsoc', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_ant_fam, id_valtsoc', 'safe', 'on'=>'search'),
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
			'id_ant_fam' => 'Antecedentes familiares',
			'id_valtsoc' => 'Id Valtsoc',
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

		$criteria->compare('id_ant_fam',$this->id_ant_fam);
		$criteria->compare('id_valtsoc',$this->id_valtsoc);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AntFFamilia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function registraAntFam(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			//elimina los antescedentes de la valoración para poder registrar los actuales
			$sqlDelAntFam="delete from ant_f_familia where id_valtsoc=:id_valtsoc";
			$delAntFam=$conect->createCommand($sqlDelAntFam);
			$delAntFam->bindParam(":id_valtsoc",$this->id_valtsoc,PDO::PARAM_INT);
			$delAntFam->execute();
			//registra antescedentes
			$sqlRegAntFam="insert into ant_f_familia (
					id_ant_fam,
					id_valtsoc
				) values (
					:id_ant_fam,
					:id_valtsoc
				)";			
			foreach($this->antFamiliares as $antFamiliares){
				$regAntFam=$conect->createCommand($sqlRegAntFam);
				$regAntFam->bindParam(":id_ant_fam",$antFamiliares,PDO::PARAM_INT);
				$regAntFam->bindParam(":id_valtsoc",$this->id_valtsoc,PDO::PARAM_INT);
				$regAntFam->execute();
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
