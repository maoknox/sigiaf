<?php

/**
 * This is the model class for table "labclin_valnutr".
 *
 * The followings are the available columns in table 'labclin_valnutr':
 * @property integer $id_laboratorio
 * @property integer $id_val_nutricion
 * @property string $resultado_labclin
 * @property string $fecha_reslabclin
 */
class LabclinValnutr extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $_labExtr;
	public $contHist;
	public $id_campovalnutr;			
	public $nombreCampoValoracion;

	public function tableName()
	{
		return 'labclin_valnutr';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_laboratorio, id_val_nutricion, resultado_labclin, fecha_reslabclin', 'required'),
			array('id_laboratorio, id_val_nutricion', 'numerical', 'integerOnly'=>true),
			array('_labExtr', 'length', 'max'=>50),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_laboratorio, id_val_nutricion, resultado_labclin, fecha_reslabclin', 'safe', 'on'=>'search'),
			array('id_laboratorio', 'validaLaboratorio'),			
		);
	}
	public function validaLaboratorio($attribute=NULL,$params=NULL){
		if(!$this->hasErrors()){
			$datosInput=Yii::app()->input->post();
			//$var=false;
			if($datosInput["LabclinValnutr"]["id_laboratorio"]==0 && empty($datosInput["LabclinValnutr"]["_labExtr"])){
				$this->addError("_labExtr","Si seleccionó añadir debe digitar el nombre del laboratorio.");
			}	
		}				
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
			'id_laboratorio' => 'Id Laboratorio',
			'id_val_nutricion' => 'Id Val Nutricion',
			'resultado_labclin' => 'Resultado Labclin',
			'fecha_reslabclin' => 'Fecha Reslabclin',
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

		$criteria->compare('id_laboratorio',$this->id_laboratorio);
		$criteria->compare('id_val_nutricion',$this->id_val_nutricion);
		$criteria->compare('resultado_labclin',$this->resultado_labclin,true);
		$criteria->compare('fecha_reslabclin',$this->fecha_reslabclin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LabclinValnutr the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consLabClinicosExtra(){		
		$conect=Yii::app()->db;
		$sqlConsLabClinExt="select id_laboratorio,laboratorio_clin from laboratorio_clinico where id_laboratorio<>1 and id_laboratorio<>2 except 
			select b.id_laboratorio,laboratorio_clin from labclin_valnutr as a 
				left join laboratorio_clinico as b on b.id_laboratorio=a.id_laboratorio 
				where id_val_nutricion=:id_val_nutricion";
		$consLabClinEx=$conect->createCommand($sqlConsLabClinExt);
		$consLabClinEx->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$readLabClinExt=$consLabClinEx->query();
		$resLabClinExt=$readLabClinExt->readAll();
		$readLabClinExt->close();
		return $resLabClinExt;		
	}
	public function creaExamenLab(){
		if(!empty($this->_labExtr)){
			$conect=Yii::app()->db;
			$transaction=$conect->beginTransaction();
			$sqlCreExamLab="insert into laboratorio_clinico (
				id_laboratorio,
				laboratorio_clin
			) values (
				default,
				:laboratorio_clin
			) returning id_laboratorio";
			try{
				$creaExamLab=$conect->createCommand($sqlCreExamLab);
				$creaExamLab->bindParam(":laboratorio_clin",$this->_labExtr,PDO::PARAM_STR);
				$readExamLab=$creaExamLab->query();
				$resExamLab=$readExamLab->read();
				$readExamLab->close();
				$transaction->commit();
				return $resExamLab["id_laboratorio"];			
			}
			catch(CDbCommand $e){
				$transaction->rollBack();
				return "";
			}
		}
	}
	public function registraLabClinico(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		$sqlRegLabClin="insert into labclin_valnutr (
			id_laboratorio,
			id_val_nutricion,
			resultado_labclin,
			fecha_reslabclin		
		) values (
			:id_laboratorio,
			:id_val_nutricion,
			:resultado_labclin,
			:fecha_reslabclin		
		)";
		try{
			$regLabClin=$conect->createCommand($sqlRegLabClin);
			$regLabClin->bindParam(":id_laboratorio",$this->id_laboratorio,PDO::PARAM_INT);
			$regLabClin->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
			$regLabClin->bindParam(":resultado_labclin",$this->resultado_labclin,PDO::PARAM_STR);
			$regLabClin->bindParam(":fecha_reslabclin",$this->fecha_reslabclin,PDO::PARAM_STR);			
			$regLabClin->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}		
	}
	public function modificaLabClinico(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		$sqlModLabClin="update labclin_valnutr set
			resultado_labclin=:resultado_labclin,fecha_reslabclin=:fecha_reslabclin
		where
			id_laboratorio=:id_laboratorio and id_val_nutricion=:id_val_nutricion
		";
		try{
			$modLabClin=$conect->createCommand($sqlModLabClin);
			$modLabClin->bindParam(":id_laboratorio",$this->id_laboratorio,PDO::PARAM_INT);
			$modLabClin->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
			$modLabClin->bindParam(":resultado_labclin",$this->resultado_labclin,PDO::PARAM_STR);
			$modLabClin->bindParam(":fecha_reslabclin",$this->fecha_reslabclin,PDO::PARAM_STR);			
			$modLabClin->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}		
	}

	public function consLabClinicosAdol(){
		$conect=Yii::app()->db;
		$sqlConsLabClin="select * from labclin_valnutr where id_val_nutricion=:id_val_nutricion";
		$consLabClin=$conect->createCommand($sqlConsLabClin);
		$consLabClin->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_STR);
		$readLabClin=$consLabClin->query();
		$resLabClin=$readLabClin->readAll();
		$readLabClin->close();
		return $resLabClin;		
	}
	public function consLabClinicoAdol(){
		$conect=Yii::app()->db;
		$sqlConsLabClin="select * from labclin_valnutr where id_val_nutricion=:id_val_nutricion and id_laboratorio=:id_laboratorio";
		$consLabClin=$conect->createCommand($sqlConsLabClin);
		$consLabClin->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$consLabClin->bindParam(":id_laboratorio",$this->id_laboratorio,PDO::PARAM_INT);
		$readLabClin=$consLabClin->query();
		$resLabClin=$readLabClin->read();
		$readLabClin->close();
		return $resLabClin;		
	}
	public function regHistoricoLabClin(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegHist="insert into modificacion_valnutr (
				id_modvalnutr,
				id_val_nutricion,
				id_cedula,						
				modvnutr,
				nomb_entidadvalnutr,
				nomb_campovnutr,
				fecha_mod_valnutr
			) values (
				default,
				:id_val_nutricion,
				:id_cedula,						
				:modvnutr,
				:nomb_entidadvalnutr,
				:nomb_campovnutr,
				:fecha_mod_valnutr
			)";//
			$regHist=$conect->createCommand($sqlRegHist);
			$fecha=date("Y-m-d H:i:s");
			$regHist->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
			$regHist->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regHist->bindParam(":modvnutr",$this->contHist,PDO::PARAM_STR);
			$regHist->bindParam(":nomb_entidadvalnutr",$this->id_campovalnutr,PDO::PARAM_STR);			
			$regHist->bindParam(":nomb_campovnutr",$this->nombreCampoValoracion,PDO::PARAM_STR);
			$regHist->bindParam(":fecha_mod_valnutr",$fecha,PDO::PARAM_STR);
			$regHist->execute();
			$transaction->commit();
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
		}
	}
}
