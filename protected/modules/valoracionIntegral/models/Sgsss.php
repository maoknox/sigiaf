<?php

/**
 * This is the model class for table "sgsss".
 *
 * The followings are the available columns in table 'sgsss':
 * @property integer $id_eps_adol
 * @property integer $id_regimen_salud
 * @property string $num_doc
 *
 * The followings are the available model relations:
 * @property EpsAdol $idEpsAdol
 * @property RegimenSalud $idRegimenSalud
 * @property Adolescente $numDoc
 */
class Sgsss extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $nombreCampoValoracion;
	public $contenidoValoracion;
	public function tableName()
	{
		return 'sgsss';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_eps_adol, id_regimen_salud, num_doc', 'required'),
			array('id_eps_adol, id_regimen_salud', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_eps_adol, id_regimen_salud, num_doc', 'safe', 'on'=>'search'),
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
			'idEpsAdol' => array(self::BELONGS_TO, 'EpsAdol', 'id_eps_adol'),
			'idRegimenSalud' => array(self::BELONGS_TO, 'RegimenSalud', 'id_regimen_salud'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_eps_adol' => 'Eps del adolescente',
			'id_regimen_salud' => 'Régimen salud',
			'num_doc' => 'Número de documento',
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

		$criteria->compare('id_eps_adol',$this->id_eps_adol);
		$criteria->compare('id_regimen_salud',$this->id_regimen_salud);
		$criteria->compare('num_doc',$this->num_doc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sgsss the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaSegSocial(){
		$conect= Yii::app()->db;
		$sqlSgsssAdol="select * from sgsss where num_doc=:numDoc";
		$querySgsssAdol=$conect->createCommand($sqlSgsssAdol);
		$querySgsssAdol->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);
		$readSgsssAdol=$querySgsssAdol->query();
		$resSgsssAdol=$readSgsssAdol->read();
		$readSgsssAdol->close();
		return $resSgsssAdol;		
	}
	public function registraSgss(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaSgss="insert into sgsss (
				id_eps_adol,
				id_regimen_salud,
				num_doc
			) values (
				:id_eps_adol,
				:id_regimen_salud,
				:num_doc
			)";
			$creaSgss=$conect->createCommand($sqlCreaSgss);
			$creaSgss->bindParam(":id_eps_adol",$this->id_eps_adol,PDO::PARAM_INT);
			$creaSgss->bindParam(":id_regimen_salud",$this->id_regimen_salud,PDO::PARAM_INT);
			$creaSgss->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$creaSgss->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function modificaSgsss(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlModSgss="update sgsss set ".pg_escape_string($this->nombreCampoValoracion)."=:contVal where num_doc=:num_doc";
			$modSgss=$conect->createCommand($sqlModSgss);
			$modSgss->bindParam(":contVal",$this->contenidoValoracion,PDO::PARAM_INT);
			$modSgss->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$modSgss->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}

}
