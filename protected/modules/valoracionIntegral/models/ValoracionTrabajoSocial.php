<?php

/**
 * This is the model class for table "valoracion_trabajo_social".
 *
 * The followings are the available columns in table 'valoracion_trabajo_social':
 * @property integer $id_valtsoc
 * @property string $num_doc
 * @property integer $id_estado_val
 * @property string $perfil_gener_vuln
 * @property string $dr_hist_escolar
 * @property string $pa_f_dc
 * @property string $concepto_social
 * @property string $pry_pl_int_tsocial
 * @property boolean $estado_val_tsoc
 * @property string $fecha_inicio_valtsoc
 * @property string $historia_famvaltsic
 * @property string $obs_familiares_ts
 * @property string $fecha_modifvaltrabsoc
 * @property boolean $val_hab_ts
 * @property string $observ_estvaltsoc
 * @property boolean $val_act_trsoc
 *
 * The followings are the available model relations:
 * @property ModificacionValtsocial[] $modificacionValtsocials
 * @property ProblemasAsociados[] $problemasAsociadoses
 * @property ServiciosProteccion[] $serviciosProteccions
 * @property EstadoValoracion $idEstadoVal
 * @property Adolescente $numDoc
 */
class ValoracionTrabajoSocial extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $campoFecha;
	public $fecha;
	public $nombreCampoValoracion;
	public $contenidoValoracion;
	public $nombreCampoValoracioni;
	public $contenidoValoracioni;
	public $msnValTrSoc;
	public $contHist;
	public function tableName()
	{
		return 'valoracion_trabajo_social';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_estado_val', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('contHist,perfil_gener_vuln, dr_hist_escolar, pa_f_dc, concepto_social, pry_pl_int_tsocial, estado_val_tsoc, fecha_inicio_valtsoc, historia_famvaltsic, obs_familiares_ts, fecha_modifvaltrabsoc, val_hab_ts, observ_estvaltsoc, val_act_trsoc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('contHist,id_valtsoc, num_doc, id_estado_val, perfil_gener_vuln, dr_hist_escolar, pa_f_dc, concepto_social, pry_pl_int_tsocial, estado_val_tsoc, fecha_inicio_valtsoc, historia_famvaltsic, obs_familiares_ts, fecha_modifvaltrabsoc, val_hab_ts, observ_estvaltsoc, val_act_trsoc', 'safe', 'on'=>'search'),
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
			'modificacionValtsocials' => array(self::HAS_MANY, 'ModificacionValtsocial', 'id_valtsoc'),
			'problemasAsociadoses' => array(self::MANY_MANY, 'ProblemasAsociados', 'problema_valtsocial(id_valtsoc, id_problema_asoc)'),
			'serviciosProteccions' => array(self::MANY_MANY, 'ServiciosProteccion', 'servprotec_valtsocial(id_valtsoc, id_serv_protec)'),
			'idEstadoVal' => array(self::BELONGS_TO, 'EstadoValoracion', 'id_estado_val'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_valtsoc' => 'Id Valtsoc',
			'num_doc' => 'Num Doc',
			'id_estado_val' => 'Id Estado Val',
			'perfil_gener_vuln' => 'Perfil generatividad vulnerabilidad',
			'dr_hist_escolar' => 'Datos relevantes de la historia escolar',
			'pa_f_dc' => 'Percepción y análisis de la familia frente al delito o conducta del/la adolescente que lo vinculó al SRPA, Justicia restaurativa',
			'concepto_social' => 'Concepto social',
			'pry_pl_int_tsocial' => 'Proyección y plan de intervención',
			'estado_val_tsoc' => 'Estado Val Tsoc',
			'fecha_inicio_valtsoc' => 'Fecha Inicio Valtsoc',
			'historia_famvaltsic' => 'Historia familiar',
			'obs_familiares_ts' => 'Observaciones de la familia',
			'fecha_modifvaltrabsoc' => 'Fecha Modifvaltrabsoc',
			'val_hab_ts' => 'Val Hab Ts',
			'observ_estvaltsoc' => 'Observ Estvaltsoc',
			'val_act_trsoc' => 'Val Act Trsoc',
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

		$criteria->compare('id_valtsoc',$this->id_valtsoc);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_estado_val',$this->id_estado_val);
		$criteria->compare('perfil_gener_vuln',$this->perfil_gener_vuln,true);
		$criteria->compare('dr_hist_escolar',$this->dr_hist_escolar,true);
		$criteria->compare('pa_f_dc',$this->pa_f_dc,true);
		$criteria->compare('concepto_social',$this->concepto_social,true);
		$criteria->compare('pry_pl_int_tsocial',$this->pry_pl_int_tsocial,true);
		$criteria->compare('estado_val_tsoc',$this->estado_val_tsoc);
		$criteria->compare('fecha_inicio_valtsoc',$this->fecha_inicio_valtsoc,true);
		$criteria->compare('historia_famvaltsic',$this->historia_famvaltsic,true);
		$criteria->compare('obs_familiares_ts',$this->obs_familiares_ts,true);
		$criteria->compare('fecha_modifvaltrabsoc',$this->fecha_modifvaltrabsoc,true);
		$criteria->compare('val_hab_ts',$this->val_hab_ts);
		$criteria->compare('observ_estvaltsoc',$this->observ_estvaltsoc,true);
		$criteria->compare('val_act_trsoc',$this->val_act_trsoc);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ValoracionTrabajoSocial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaIdValTrSoc(){
		$conect=Yii::app()->db;
		$sqlConsIdValTrSoc="select * from valoracion_trabajo_social where num_doc=:numDoc and val_act_trsoc='true'" ;
		$consIdValTrSoc=$conect->createCommand($sqlConsIdValTrSoc);
		$consIdValTrSoc->bindParam(":numDoc",$this->num_doc,PDO::PARAM_STR);
		$readIdValTrSoc=$consIdValTrSoc->query();
		$resConsIdValTrSoc=$readIdValTrSoc->read();
		$readIdValTrSoc->close();
		return $resConsIdValTrSoc;
	}
	public function creaRegValTrSoc(){
		$conect=Yii::app()->db;
		$sqlCreaValTrSoc="insert into valoracion_trabajo_social (id_valtsoc,num_doc,val_act_trsoc) values (default,:numDoc,'true') returning id_valtsoc";
		$creaValTrSoc=$conect->createCommand($sqlCreaValTrSoc);
		$creaValTrSoc->bindParam(":numDoc",$this->num_doc,PDO::PARAM_STR);
		$readValTrSoc=$creaValTrSoc->query();
		$resValTrSoc=$readValTrSoc->read();
		$readValTrSoc->close();
		return $resValTrSoc["id_valtsoc"];
	}
	public function consultaProbAsoc($idValTrSoc){
		$conect=Yii::app()->db;
		$sqlConsProv="select * from problema_valtsocial where id_valtsoc=:idValTreSoc";
		$consProv=$conect->createCommand($sqlConsProv);
		$consProv->bindParam(':idValTreSoc',$idValTrSoc,PDO::PARAM_INT);
		$readConsProc=$consProv->query();
		$resConsProc=$readConsProc->readAll();
		$readConsProc->close();
		return $resConsProc;
		
	}
	public function consultaServProt($idValTrSoc){
		$conect=Yii::app()->db;
		$sqlConsProb="select * from servprotec_valtsocial where id_valtsoc=:idValTreSoc";
		$consProb=$conect->createCommand($sqlConsProb);
		$consProb->bindParam(':idValTreSoc',$idValTrSoc,PDO::PARAM_INT);
		$readConsProb=$consProb->query();
		$resConsProb=$readConsProb->readAll();
		$readConsProb->close();
		return $resConsProb;
		
	}
	public function modificaValoracionTrSoc($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->contenidoValoracion)){$this->contenidoValoracion=null;}
			$sqlModValTrSoc="update valoracion_trabajo_social 
				set ".pg_escape_string($this->nombreCampoValoracion)."=:contVal,
				".$this->campoFecha."=:fecha 
				where id_valtsoc=:idValTrSoc";
			$modValTrSoc=$conect->createCommand($sqlModValTrSoc);
			$modValTrSoc->bindParam(':fecha',$this->fecha,PDO::PARAM_STR);
			$modValTrSoc->bindParam(':contVal',$this->contenidoValoracion,PDO::PARAM_NULL);
			$modValTrSoc->bindParam(':idValTrSoc',$this->id_valtsoc,PDO::PARAM_INT);
			$modValTrSoc->execute();
			$this->creaRegProfVal($this->id_valtsoc,$accion);
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function regHistoricoValTrSoc(){
		if(!empty($this->nombreCampoValoracioni)){
			$this->nombreCampoValoracion=$this->nombreCampoValoracioni;
		}
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegHist="insert into modificacion_valtsocial (
				id_modvaltrosc,
				id_cedula,
				id_valtsoc,
				modvaltrsoc,
				nombre_campotrsoc,
				fecha_mod_valtrsoc
			) values (
				default,
				:id_cedula,
				:id_valtsoc,
				:modvaltrsoc,
				:nombre_campotrsoc,
				:fecha_mod_valtrsoc
			)";//
			$regHist=$conect->createCommand($sqlRegHist);
			$fecha=date("Y-m-d H:i:s");
			$regHist->bindParam(":id_valtsoc",$this->id_valtsoc,PDO::PARAM_INT);
			$regHist->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regHist->bindParam(":modvaltrsoc",$this->contHist,PDO::PARAM_STR);
			$regHist->bindParam(":nombre_campotrsoc",$this->nombreCampoValoracion,PDO::PARAM_STR);
			$regHist->bindParam(":fecha_mod_valtrsoc",$fecha,PDO::PARAM_STR);
			$regHist->execute();
			$transaction->commit();
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			
			
		}
	}

	public function modificaValoracionTrSocOpt($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->contenidoValoracion)){$this->contenidoValoracion=null;}
			$sqlModValTrsSoc="update valoracion_trabajo_social 
				set ".pg_escape_string($this->nombreCampoValoracion)."=:contVal,
				".$this->nombreCampoValoracioni."=:contVali,
				".$this->campoFecha."=:fecha 
				where id_valtsoc=:idValTrSoc and num_doc=:num_doc";
			$modValTrSoc=$conect->createCommand($sqlModValTrsSoc);
			$modValTrSoc->bindParam(':fecha',$this->fecha,PDO::PARAM_STR);
			$modValTrSoc->bindParam(':contVal',$this->contenidoValoracion,PDO::PARAM_NULL);
			$modValTrSoc->bindParam(':contVali',$this->contenidoValoracioni,PDO::PARAM_NULL);
			$modValTrSoc->bindParam(':idValTrSoc',$this->id_valtsoc,PDO::PARAM_INT);
			$modValTrSoc->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
			$modValTrSoc->execute();
			$this->creaRegProfVal($this->id_valtsoc,$accion);
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}

	public function consultaTipoFamilia(){
		$conect=Yii::app()->db;
		$sqlConsTipoFam="select * from adolescente as a 
			left join familia as b on b.id_familia=a.id_familia 
			where a.id_familia is not null and a.num_doc=:num_doc";
		$consTipoFam=$conect->createCommand($sqlConsTipoFam);	
		$consTipoFam->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);	
		$readTipoFam=$consTipoFam->query();
		$resTipoFam=$readTipoFam->read();
		$readTipoFam->close();
		return $resTipoFam;
	}
	public function consAntFamiliares(){
		$conect= Yii::app()->db;
		$sqlConsultaAdol="select * from ant_f_familia where id_valtsoc=:id_valtsoc";
		$queryConsultaAdol=$conect->createCommand($sqlConsultaAdol);
		$queryConsultaAdol->bindParam(':id_valtsoc',$this->id_valtsoc,PDO::PARAM_INT);
		$readConsultaAdol=$queryConsultaAdol->query();
		$resConsultaAdol=$readConsultaAdol->readAll();
		$readConsultaAdol->close();			
		return $resConsultaAdol;
	}	
	public function modFechaActuacion($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlModFechaAct="update valoracion_trabajo_social set ".pg_escape_string($this->campoFecha)."=:fecha 
				where id_valtsoc=:id_valtsoc and num_doc=:num_doc";
			$modFechaAct=$conect->createCommand($sqlModFechaAct);
			$modFechaAct->bindParam(":fecha",$this->fecha,PDO::PARAM_STR);
			$modFechaAct->bindParam(":id_valtsoc",$this->id_valtsoc,PDO::PARAM_INT);
			$modFechaAct->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);//id_valtsoc
			$modFechaAct->execute();
			$this->creaRegProfVal($this->id_valtsoc,$accion);
			$transaction->commit();
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
		}
	}
	public function consValHabTrSoc(){
		$conect=Yii::app()->db;
		$sqlConsHabVal="select val_hab_ts from valoracion_trabajo_social where num_doc=:num_doc";
		$consHabVal=$conect->createCommand($sqlConsHabVal);
		$consHabVal->bindParam(":num_doc",Yii::app()->getSession()->get('numDocAdol'),PDO::PARAM_STR);
		$readHabVal=$consHabVal->query();
		$resHabVal=$readHabVal->read();
		$readHabVal->close();
		return $resHabVal;
	}
	public function modValHabFalseTrSoc(){
		$conect=Yii::app()->db;
		$sqlActHabVal="update valoracion_trabajo_social set val_hab_ts='false' where num_doc=:num_doc";
		$actHabVal=$conect->createCommand($sqlActHabVal);
		$actHabVal->bindParam(":num_doc",Yii::app()->getSession()->get('numDocAdol'),PDO::PARAM_STR);
		$actHabVal->execute();		
	}
	public function creaRegProfVal($idValoracion,$accion){		
		$conect=Yii::app()->db;
		$fechaRegistro=date("Y-m-d");
		$sqlConsFechaMod="select fecha_regprvtrsoc from profesional_trsoc where id_valtsoc=:id_valtsoc and id_accval=:id_accval order by fecha_regprvtrsoc desc limit 1";
		$consFechaMod=$conect->createCommand($sqlConsFechaMod);
		$consFechaMod->bindParam(":id_valtsoc",$idValoracion,PDO::PARAM_INT);
		$consFechaMod->bindParam(":id_accval",$accion,PDO::PARAM_INT);
		$readFechaMod=$consFechaMod->query();
		$resFechaMod=$readFechaMod->read();
		$readFechaMod->close();
		$creaRegistro=false;
		if(empty($resFechaMod["fecha_regprvtrsoc"])){
			$creaRegistro=true;
		}
		elseif($resFechaMod["fecha_regprvtrsoc"]!=$fechaRegistro){
			$creaRegistro=true;
		}
		if($creaRegistro==true){
			$sqlCreaRegProfVal="insert into profesional_trsoc (
				id_cedula,
				id_valtsoc,
				id_accval,
				fecha_regprvtrsoc
			) values (
				:id_cedula,
				:id_valtsoc,
				:id_accval,
				:fecha_regprvtrsoc
			)";	
			$creaRegProfVal=$conect->createCommand($sqlCreaRegProfVal);	
			$creaRegProfVal->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":id_valtsoc",$idValoracion,PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":id_accval",$accion,PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":fecha_regprvtrsoc",$fechaRegistro,PDO::PARAM_STR);
			$creaRegProfVal->execute();
		}
	}
	public function consultaValTrSoc(){
		$conect=Yii::app()->db;
		$sqlConsValTrSoc="select * from valoracion_trabajo_social where id_valtsoc=:id_valtsoc";
		$consValTrSoc=$conect->createCommand($sqlConsValTrSoc);
		$consValTrSoc->bindParam(":id_valtsoc",$this->id_valtsoc);
		$readValTrSoc=$consValTrSoc->query();
		$resValTrSoc=$readValTrSoc->read();
		$readValTrSoc->close();
		return $resValTrSoc;
	}

}
