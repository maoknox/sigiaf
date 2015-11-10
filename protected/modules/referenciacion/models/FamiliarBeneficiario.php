<?php

/**
 * This is the model class for table "familiar_beneficiario".
 *
 * The followings are the available columns in table 'familiar_beneficiario':
 * @property integer $id_fam_benef
 * @property integer $id_referenciacion
 * @property string $id_doc_fam_ben
 * @property string $nombres_fam_ben
 * @property string $apellidos_fam_ben
 *
 * The followings are the available model relations:
 * @property ReferenciacionAdol $idReferenciacion
 */
class FamiliarBeneficiario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'familiar_beneficiario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id_referenciacion', 'required'),
			array('id_referenciacion', 'numerical', 'integerOnly'=>true),
			array('id_doc_fam_ben', 'length', 'max'=>20),
			array('nombres_fam_ben, apellidos_fam_ben', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_fam_benef, id_referenciacion, id_doc_fam_ben, nombres_fam_ben, apellidos_fam_ben', 'safe', 'on'=>'search'),
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
			'idReferenciacion' => array(self::BELONGS_TO, 'ReferenciacionAdol', 'id_referenciacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_fam_benef' => 'Familiar beneficiario',
			'id_referenciacion' => 'Referenciacion',
			'id_doc_fam_ben' => 'Documento del familiar',
			'nombres_fam_ben' => 'Nombres del familiar',
			'apellidos_fam_ben' => 'Apellidos del familiar',
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

		$criteria->compare('id_fam_benef',$this->id_fam_benef);
		$criteria->compare('id_referenciacion',$this->id_referenciacion);
		$criteria->compare('id_doc_fam_ben',$this->id_doc_fam_ben,true);
		$criteria->compare('nombres_fam_ben',$this->nombres_fam_ben,true);
		$criteria->compare('apellidos_fam_ben',$this->apellidos_fam_ben,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FamiliarBeneficiario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function creaRegFamBen(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaFamBen="insert into familiar_beneficiario(
				id_fam_benef,
				id_referenciacion,
				id_doc_fam_ben,
				nombres_fam_ben,
				apellidos_fam_ben
			) values (
				default,
				:id_referenciacion,
				:id_doc_fam_ben,
				:nombres_fam_ben,
				:apellidos_fam_ben
			)";
			if(empty($this->id_doc_fam_ben)){$this->id_doc_fam_ben=null;}
			if(empty($this->nombres_fam_ben)){$this->nombres_fam_ben=null;}
			if(empty($this->apellidos_fam_ben)){$this->apellidos_fam_ben=null;}
			$creaFamBen=$conect->createCommand($sqlCreaFamBen);
			$creaFamBen->bindParam(':id_referenciacion',$this->id_referenciacion,PDO::PARAM_INT);
			$creaFamBen->bindParam(':id_doc_fam_ben',$this->id_doc_fam_ben,PDO::PARAM_NULL);
			$creaFamBen->bindParam(':nombres_fam_ben',$this->nombres_fam_ben,PDO::PARAM_NULL);
			$creaFamBen->bindParam(':apellidos_fam_ben',$this->apellidos_fam_ben,PDO::PARAM_NULL);
			$creaFamBen->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function consultaRefFamBenef(){
		$conect=Yii::app()->db;
		$sqlConsRef="select * from familiar_beneficiario where id_referenciacion=:id_referenciacion";
		$consRef=$conect->createCommand($sqlConsRef);
		$consRef->bindParam(':id_referenciacion',$this->id_referenciacion,PDO::PARAM_INT);
		$readConsRef=$consRef->query();
		$resConsRef=$readConsRef->read();
		$readConsRef->close();
		return $resConsRef;
	}

}
