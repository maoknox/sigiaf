<?php

/**
 * This is the model class for table "familia".
 *
 * The followings are the available columns in table 'familia':
 * @property integer $id_familia
 * @property integer $id_tipo_familia
 * @property string $historia_familiar
 *
 * The followings are the available model relations:
 * @property TipoFamilia $idTipoFamilia
 * @property Adolescente[] $adolescentes
 */
class Familia extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $num_doc;
	public function tableName()
	{
		return 'familia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipo_familia,id_familia', 'required'),
			array('id_tipo_familia,id_familia', 'numerical', 'integerOnly'=>true),
			array('historia_familiar', 'safe'),
			array('num_doc', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_familia, id_tipo_familia, historia_familiar', 'safe', 'on'=>'search'),
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
			'idTipoFamilia' => array(self::BELONGS_TO, 'TipoFamilia', 'id_tipo_familia'),
			'adolescentes' => array(self::HAS_MANY, 'Adolescente', 'id_familia'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_familia' => 'Familia',
			'id_tipo_familia' => 'Tipo Familia',
			'historia_familiar' => 'Historia Familiar',
			'num_doc'=>'Documento del adolescente'
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

		$criteria->compare('id_familia',$this->id_familia);
		$criteria->compare('id_tipo_familia',$this->id_tipo_familia);
		$criteria->compare('historia_familiar',$this->historia_familiar,true);
		$criteria->compare('num_doc',$this->num_doc,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Familia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function creaTipoFam(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaTipoFam="insert into familia (
				id_familia,
				id_tipo_familia
			) values (
				default,
				:id_tipo_familia
			) returning id_familia";
			$creaTipoFam=$conect->createCommand($sqlCreaTipoFam);
			$creaTipoFam->bindParam(":id_tipo_familia",$this->id_tipo_familia,PDO::PARAM_INT);
			$readTipoFam=$creaTipoFam->query();
			$resTipoFam=$readTipoFam->read();
			$readTipoFam->close();
			//asocia el registro de familia con el registro del adolescente.
			$sqlRegTipoFamAdol="update adolescente set id_familia=:id_familia where num_doc=:num_doc";
			$regTipoFamAdol=$conect->createCommand($sqlRegTipoFamAdol);
			$regTipoFamAdol->bindParam(":id_familia",$resTipoFam["id_familia"],PDO::PARAM_INT);
			$regTipoFamAdol->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$regTipoFamAdol->execute();
			$this->id_familia=$resTipoFam["id_familia"];
			$transaction->commit();
			return "exito";
			
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	
	public function modTipoFam(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlActTipoFam="update familia set id_tipo_familia=:id_tipo_familia where id_familia=:id_familia";
			$actTipoFam=$conect->createCommand($sqlActTipoFam);
			$actTipoFam->bindParam(":id_familia",$this->id_familia,PDO::PARAM_INT);
			$actTipoFam->bindParam(":id_tipo_familia",$this->id_tipo_familia,PDO::PARAM_INT);
			$actTipoFam->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
}
