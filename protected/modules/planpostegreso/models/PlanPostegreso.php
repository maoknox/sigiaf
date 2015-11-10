<?php

/**
 * This is the model class for table "plan_postegreso".
 *
 * The followings are the available columns in table 'plan_postegreso':
 * @property string $id_planpostegerso
 * @property integer $id_pai
 * @property string $num_doc
 * @property string $fecha_registroplan
 * @property string $concepto_egreso
 * @property string $proyeccion_pegreso
 *
 * The followings are the available model relations:
 * @property AccionesEgreso[] $accionesEgresos
 * @property Pai $idPai
 * @property Pai $numDoc
 */
class PlanPostegreso extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'plan_postegreso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $nombreCampo;
	public $datoCampo; 
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pai,num_doc, concepto_egreso, proyeccion_pegreso', 'required'),
			array('id_pai', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_planpostegerso, id_pai, num_doc, fecha_registroplan, concepto_egreso, proyeccion_pegreso', 'safe', 'on'=>'search'),
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
			'accionesEgresos' => array(self::HAS_MANY, 'AccionesEgreso', 'id_planpostegerso'),
			'idPai' => array(self::BELONGS_TO, 'Pai', 'id_pai'),
			'numDoc' => array(self::BELONGS_TO, 'Pai', 'num_doc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_planpostegerso' => 'Plan postegerso',
			'id_pai' => 'Pai',
			'num_doc' => 'Número de documento',
			'fecha_registroplan' => 'Fecha registro del plan',
			'concepto_egreso' => 'Concepto al egreso',
			'proyeccion_pegreso' => 'Proyección',
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

		$criteria->compare('id_planpostegerso',$this->id_planpostegerso,true);
		$criteria->compare('id_pai',$this->id_pai);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('fecha_registroplan',$this->fecha_registroplan,true);
		$criteria->compare('concepto_egreso',$this->concepto_egreso,true);
		$criteria->compare('proyeccion_pegreso',$this->proyeccion_pegreso,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlanPostegreso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaPlanPe(){
		$conect=Yii::app()->db;
		$sqlConsPlanPe="select * from plan_postegreso where num_doc=:num_doc and plan_peactual='true'";
		$consPlanPe=$conect->createCommand($sqlConsPlanPe);
		$consPlanPe->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readPlanPe=$consPlanPe->query();
		$resPlanPe=$readPlanPe->read();
		$readPlanPe->close();
		return $resPlanPe;				
	}
	public function creaPlanPe(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaRegPlanPe="insert into plan_postegreso (
				id_planpostegreso,
				id_pai,
				num_doc,
				fecha_registroplan,
				concepto_egreso,
				proyeccion_pegreso,
				planpe_hab,
				plan_peactual
			) values (
				:id_planpostegreso,
				:id_pai,
				:num_doc,
				:fecha_registroplan,
				:concepto_egreso,
				:proyeccion_pegreso,
				'true',
				'true'
			)";
			$micro_date = microtime();
			$date_array = explode(" ",$micro_date);
			$date = date("Y-m-d H:i:s.",$date_array[1]); $milisec=explode(".",round($date_array[0],6));
			$fechaRegistroId=$date.$milisec[1];
			$fechaRegistro=date("Y-m-d");
			$this->id_planpostegreso=$fechaRegistroId;
			$creaRegPlanPe=$conect->createCommand($sqlCreaRegPlanPe);
			$creaRegPlanPe->bindParam(":id_planpostegreso",$this->id_planpostegreso,PDO::PARAM_STR);
			$creaRegPlanPe->bindParam(":id_pai",$this->id_pai,PDO::PARAM_STR);
			$creaRegPlanPe->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$creaRegPlanPe->bindParam(":fecha_registroplan",$fechaRegistro,PDO::PARAM_STR);
			$creaRegPlanPe->bindParam(":concepto_egreso",$this->concepto_egreso,PDO::PARAM_STR);
			$creaRegPlanPe->bindParam(":proyeccion_pegreso",$this->proyeccion_pegreso,PDO::PARAM_STR);
			$creaRegPlanPe->execute();			
			//Cambia la vigencia del pai a false, es decir el pai culminado ya no es actual, si se crea otro pai será completamente nuevo.
			$sqlActualizaVigenciaPai="update pai set pai_actual='false' where num_doc=:num_doc and pai_actual='true'";
			$actualizaVigenciaPai=$conect->createCommand($sqlActualizaVigenciaPai);
			$actualizaVigenciaPai->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$actualizaVigenciaPai->execute();
			
			$transaction->commit();
			return "exito";
			
		}
		catch(CDbCommand $e){
			$transaction->commit();
			return $e;
		}
	}
	public function modifPlanPeg(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlModifPlanPe="update plan_postegreso set ".$this->nombreCampo."=:datosCampo where id_planpostegreso=:id_planpostegreso and id_pai=:id_pai and num_doc=:num_doc";
			$modifPlanPe=$conect->createCommand($sqlModifPlanPe);
			$modifPlanPe->bindParam(":datosCampo",$this->datoCampo,PDO::PARAM_STR);
			$modifPlanPe->bindParam(":id_planpostegreso",$this->id_planpostegreso,PDO::PARAM_STR);
			$modifPlanPe->bindParam(":id_pai",$this->id_pai,PDO::PARAM_STR);
			$modifPlanPe->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$modifPlanPe->execute();
			$transaction->commit();	
			return "exito";		
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;			
		}	
	}
}
