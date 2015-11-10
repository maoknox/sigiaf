<?php

/**
 * This is the model class for table "acciones_egreso".
 *
 * The followings are the available columns in table 'acciones_egreso':
 * @property string $id_acceg
 * @property string $id_planpostegerso
 * @property string $objetivo_acceg
 * @property string $actividaes_acceg
 * @property string $fuente_verif_acceg
 * @property string $responsable_acceg
 *
 * The followings are the available model relations:
 * @property PlanPostegreso $idPlanpostegerso
 */
class AccionesEgreso extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $nombreCampo;
	public $datoCampo;
	public function tableName()
	{
		return 'acciones_egreso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('objetivo_acceg, actividaes_acceg, tiempo_acceg,fuente_verif_acceg, responsable_acceg', 'required'),
			array('id_planpostegerso', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_acceg, id_planpostegerso, objetivo_acceg, actividaes_acceg,tiempo_acceg, fuente_verif_acceg, responsable_acceg', 'safe', 'on'=>'search'),
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
			'idPlanpostegerso' => array(self::BELONGS_TO, 'PlanPostegreso', 'id_planpostegerso'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_acceg' => 'Acción egreso',
			'id_planpostegerso' => 'Plan post egreso',
			'objetivo_acceg' => 'Objetivo acción del egreso',
			'actividaes_acceg' => 'Actividaes',
			'fuente_verif_acceg' => 'Fuente verificación',
			'responsable_acceg' => 'Responsable',
			'tiempo_acceg'=>'Tiempo'
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

		$criteria->compare('id_acceg',$this->id_acceg,true);
		$criteria->compare('id_planpostegerso',$this->id_planpostegerso,true);
		$criteria->compare('objetivo_acceg',$this->objetivo_acceg,true);
		$criteria->compare('actividaes_acceg',$this->actividaes_acceg,true);
		$criteria->compare('fuente_verif_acceg',$this->fuente_verif_acceg,true);
		$criteria->compare('responsable_acceg',$this->responsable_acceg,true);
		$criteria->compare('tiempo_acceg',$this->tiempo_acceg,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccionesEgreso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaAccPlanPe(){
		$conect=Yii::app()->db;
		$sqlConsAccPlanPe="select * from acciones_egreso where id_planpostegreso=:id_planpostegreso";
		$consAccPlanPe=$conect->createCommand($sqlConsAccPlanPe);
		$consAccPlanPe->bindParam(":id_planpostegreso",$this->id_planpostegreso,PDO::PARAM_STR);
		$readAccPlanPe=$consAccPlanPe->query();
		$resAccPlanPe=$readAccPlanPe->readAll();
		$readAccPlanPe->close();
		return $resAccPlanPe;				
	}
	public function consultaAccPlanPeComp(){
		$conect=Yii::app()->db;
		$sqlConsAccPlanPe="select * from acciones_egreso where id_acceg=:id_acceg and id_planpostegreso=:id_planpostegreso and id_pai=:id_pai and num_doc=:num_doc";
		$consAccPlanPe=$conect->createCommand($sqlConsAccPlanPe);
		$consAccPlanPe->bindParam(":id_acceg",$this->id_acceg,PDO::PARAM_STR);
		$consAccPlanPe->bindParam(":id_planpostegreso",$this->id_planpostegreso,PDO::PARAM_STR);
		$consAccPlanPe->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
		$consAccPlanPe->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readAccPlanPe=$consAccPlanPe->query();
		$resAccPlanPe=$readAccPlanPe->read();
		$readAccPlanPe->close();
		return $resAccPlanPe;				
	}
	public function creaActPPEg(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$micro_date = microtime();
			$date_array = explode(" ",$micro_date);
			$date = date("Y-m-d H:i:s.",$date_array[1]); $milisec=explode(".",round($date_array[0],6));
			$fechaRegistroId=$date.$milisec[1];
			$fechaRegistro=date("Y-m-d");
			$sqlCreaAccPEg="insert into acciones_egreso (
				id_acceg,
				id_planpostegreso,
				id_pai,
				num_doc,
				objetivo_acceg,
				actividaes_acceg,
				fuente_verif_acceg,
				responsable_acceg,
				tiempo_acceg
			) values (
				:id_acceg,
				:id_planpostegreso,
				:id_pai,
				:num_doc,
				:objetivo_acceg,
				:actividaes_acceg,
				:fuente_verif_acceg,
				:responsable_acceg,
				:tiempo_acceg
			)";
			$creaAccPEg=$conect->createCommand($sqlCreaAccPEg);
			$creaAccPEg->bindParam(":id_acceg",$fechaRegistroId,PDO::PARAM_STR);
			$creaAccPEg->bindParam(":id_planpostegreso",$this->id_planpostegreso,PDO::PARAM_STR);
			$creaAccPEg->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
			$creaAccPEg->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$creaAccPEg->bindParam(":objetivo_acceg",$this->objetivo_acceg,PDO::PARAM_STR);
			$creaAccPEg->bindParam(":actividaes_acceg",$this->actividaes_acceg,PDO::PARAM_STR);
			$creaAccPEg->bindParam(":fuente_verif_acceg",$this->fuente_verif_acceg,PDO::PARAM_STR);
			$creaAccPEg->bindParam(":responsable_acceg",$this->responsable_acceg,PDO::PARAM_STR);
			$creaAccPEg->bindParam(":tiempo_acceg",$this->tiempo_acceg,PDO::PARAM_STR);
			$creaAccPEg->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function modifAccPPeg(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlModifAccPPEg="update acciones_egreso 
				set ".$this->nombreCampo." =:datoCampo 
				where id_acceg=:id_acceg and id_planpostegreso=:id_planpostegreso and id_pai=:id_pai and num_doc=:num_doc"; 
			$modifAccPPEg=$conect->createCommand($sqlModifAccPPEg);
			$modifAccPPEg->bindParam(":id_acceg",$this->id_acceg,PDO::PARAM_STR);
			$modifAccPPEg->bindParam(":id_planpostegreso",$this->id_planpostegreso,PDO::PARAM_STR);
			$modifAccPPEg->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
			$modifAccPPEg->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$modifAccPPEg->bindParam(":datoCampo",$this->datoCampo,PDO::PARAM_STR);
			$modifAccPPEg->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
}
