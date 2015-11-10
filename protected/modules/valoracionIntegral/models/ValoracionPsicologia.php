<?php

/**
 * This is the model class for table "valoracion_psicologia".
 *
 * The followings are the available columns in table 'valoracion_psicologia':
 * @property integer $id_valoracion_psicol
 * @property integer $id_estado_val
 * @property integer $id_patron_consumo
 * @property string $num_doc
 * @property boolean $vinc_prev_srpa
 * @property string $historia_vida
 * @property string $dn_fn_familiar
 * @property string $hist_conducta
 * @property string $analisis_est_mental
 * @property string $juicio_valpsicol
 * @property boolean $examen_toxic
 * @property string $resultado_examtox
 * @property string $patron_consumo_desc
 * @property string $caract_relev_comp
 * @property string $concl_gen_vpsicol
 * @property string $pry_plan_interv
 * @property boolean $remis_psiquiatria
 * @property string $objetivo_remitpsiq
 * @property string $fecha_iniciovalpsicol
 * @property boolean $estado_valpsicol
 * @property string $ultimo_ep_cons
 * @property string $interv_prev_spa
 * @property string $fecha_modifvalpsic
 * @property string $fecha_rem_psiq_psic
 * @property boolean $consumo_spa
 * @property boolean $val_hab_ps
 * @property boolean $val_act_psicol
 * @property string $observ_estvalpsicol
 *
 * The followings are the available model relations:
 * @property DelitoPorVinc[] $delitoPorVincs
 * @property ModificacionValpsicol[] $modificacionValpsicols
 * @property ProfesionalValpsicol[] $profesionalValpsicols
 * @property EstadoValoracion $idEstadoVal
 * @property PatronConsumo $idPatronConsumo
 * @property Adolescente $numDoc
 * @property ConsumoDrogas[] $consumoDrogases
 */
class ValoracionPsicologia extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $searchTerm;
	public $msnValPsicol;
	public $idCasoDelito;
	public $idTipoSancion;
	public $idDelRc;
	public $medidaIntPrev;
	public $sancImp;
	public $nombreCampoValoracion;
	public $contenidoValoracion;
	public $nombreCampoValoracioni;
	public $contenidoValoracioni;
	public $campoFecha;
	public $fecha;
	public $idSPACons;
	public $tipo_spa;
	public $frec_uso;
	public $cons_ult_anio;
	public $via_admon;
	public $edad_ini;
	public $edad_fin;
	public $spa_may_imp;
	public $motivos_cons;
	public $spa_ini;
	public $idConsSpa;
	public $campoObs;
	public $contHist;
	
	public function tableName()
	{
		return 'valoracion_psicologia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_doc','required'),
			array('id_patron_consumo, id_estado_val', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('contHist,vinc_prev_srpa, historia_vida, dn_fn_familiar, hist_conducta, analisis_est_mental, juicio_valpsicol, examen_toxic, resultado_examtox, patron_consumo_desc, caract_relev_comp, concl_gen_vpsicol, pry_plan_interv, remis_psiquiatria, objetivo_remitpsiq, fecha_iniciovalpsicol, estado_valpsicol, ultimo_ep_cons, interv_prev_spa, fecha_modifvalpsic, fecha_rem_psiq_psic, consumo_spa, val_hab_ps, val_act_psicol, observ_estvalpsicol', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('contHist,id_valoracion_psicol,id_estado_val, id_patron_consumo, num_doc, vinc_prev_srpa, historia_vida, dn_fn_familiar, hist_conducta, analisis_est_mental, juicio_valpsicol, examen_toxic, resultado_examtox, patron_consumo_desc, caract_relev_comp, concl_gen_vpsicol, pry_plan_interv, remis_psiquiatria, objetivo_remitpsiq, fecha_iniciovalpsicol, estado_valpsicol, ultimo_ep_cons, interv_prev_spa, fecha_modifvalpsic, fecha_rem_psiq_psic, consumo_spa, val_hab_ps, val_hab_ps, val_act_psicol, observ_estvalpsicol', 'safe', 'on'=>'search'),
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
			'delitoPorVincs' => array(self::HAS_MANY, 'DelitoPorVinc', 'id_valoracion_psicol'),
			'modificaValpsicols' => array(self::HAS_MANY, 'ModificaValpsicol', 'id_valoracion_psicol'),
			'idEstadoVal' => array(self::BELONGS_TO, 'EstadoValoracion', 'id_estado_val'),
			'idPatronConsumo' => array(self::BELONGS_TO, 'PatronConsumo', 'id_patron_consumo'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'consumoDrogases' => array(self::HAS_MANY, 'ConsumoDrogas', 'id_valoracion_psicol'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_valoracion_psicol' => 'Valoración en psicología',
			'id_estado_val' => 'Estado de la valoración',
			'id_patron_consumo' => 'Patrón de consumo',
			'num_doc' => 'Número de documento del adolescente',
			'vinc_prev_srpa' => 'Vinculación previa al sistema de responsabilidad penal adolescente (SRPA)',
			'historia_vida' => 'Historia de Vida',
			'dn_fn_familiar' => 'Dinámica y funcionamiento Familiar',
			'hist_conducta' => 'Historia analítica de la conducta del/la adolescente que lo vinculó al SRPA, Justicia restaurativa',
			'analisis_est_mental' => 'Análisis del estado mental',
			'juicio_valpsicol' => 'Juicio Valpsicol',
			'examen_toxic' => 'Examen Toxicológico',
			'resultado_examtox' => 'Resultado del examen toxicológico',
			'patron_consumo_desc' => 'Descripción del patron de consumo',
			'caract_relev_comp' => 'Caract Relev Comp',
			'concl_gen_vpsicol' => 'Conclusiones Generales',
			'pry_plan_interv' => 'Proyección y plan de intervención',
			'remis_psiquiatria' => 'Remisión a psiquiatria',
			'objetivo_remitpsiq' => 'Objetivo de la remisión',
			'fecha_iniciovalpsicol' => 'Fecha inicio de la valoración',
			'estado_valpsicol' => 'Estado de la valoración',
			'ultimo_ep_cons' => 'Último episodio de consumo',
			'interv_prev_spa' => 'Intervenciones previas al manejo del consumo',
			'fecha_modifvalpsic' => 'Fecha de modificación de la valoración',
			'fecha_rem_psiq_psic' => 'Fecha remisión a psiquatría',
			'consumo_spa' => 'Consumo Spa',
			'val_hab_ps' => 'Valoración habilitada?',
			'val_act_psicol' => 'Valoración actual?',
			'observ_estvalpsicol' => 'Observaciones del estado de la valoración',
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

		$criteria->compare('id_valoracion_psicol',$this->id_valoracion_psicol);
		$criteria->compare('id_estado_val',$this->id_estado_val);	
		$criteria->compare('id_patron_consumo',$this->id_patron_consumo);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('vinc_prev_srpa',$this->vinc_prev_srpa);
		$criteria->compare('historia_vida',$this->historia_vida,true);
		$criteria->compare('dn_fn_familiar',$this->dn_fn_familiar,true);
		$criteria->compare('hist_conducta',$this->hist_conducta,true);
		$criteria->compare('analisis_est_mental',$this->analisis_est_mental,true);
		$criteria->compare('juicio_valpsicol',$this->juicio_valpsicol,true);
		$criteria->compare('examen_toxic',$this->examen_toxic);
		$criteria->compare('resultado_examtox',$this->resultado_examtox,true);
		$criteria->compare('patron_consumo_desc',$this->patron_consumo_desc,true);
		$criteria->compare('caract_relev_comp',$this->caract_relev_comp,true);
		$criteria->compare('concl_gen_vpsicol',$this->concl_gen_vpsicol,true);
		$criteria->compare('pry_plan_interv',$this->pry_plan_interv,true);
		$criteria->compare('remis_psiquiatria',$this->remis_psiquiatria);
		$criteria->compare('objetivo_remitpsiq',$this->objetivo_remitpsiq,true);
		$criteria->compare('fecha_iniciovalpsicol',$this->fecha_iniciovalpsicol,true);
		$criteria->compare('estado_valpsicol',$this->estado_valpsicol);
		$criteria->compare('ultimo_ep_cons',$this->ultimo_ep_cons,true);
		$criteria->compare('interv_prev_spa',$this->interv_prev_spa,true);
		$criteria->compare('fecha_modifvalpsic',$this->fecha_modifvalpsic,true);
		$criteria->compare('fecha_rem_psiq_psic',$this->fecha_rem_psiq_psic,true);
		$criteria->compare('consumo_spa',$this->consumo_spa);
		$criteria->compare('val_hab_ps',$this->val_hab_ps);
		$criteria->compare('observ_estvalpsicol',$this->observ_estvalpsicol);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ValoracionPsicologia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaIdValPsicol(){
/*		$conect=Yii::app()->db;
		$sqlConsIdValPsicol="select * from valoracion_psicologia where num_doc=:numDoc and val_act_psicol='true'" ;
		$consIdValPsicol=$conect->createCommand($sqlConsIdValPsicol);
		$consIdValPsicol->bindParam(":numDoc",$this->num_doc,PDO::PARAM_STR);
		$readIdValPsicol=$consIdValPsicol->query();
		$resConsIdValPsicol=$readIdValPsicol->read();
		$readIdValPsicol->close();
		return $resConsIdValPsicol;
*/		
		
		$consultasGenerales=new ConsultasGenerales();
		$linkBd=$consultasGenerales->conectaBDSinPdo();
		$sqlConsEstadoUsuario="select * from valoracion_psicologia where num_doc=$1 and val_act_psicol='true'";
		$res=pg_prepare($linkBd,"consValPsic",$sqlConsEstadoUsuario);
		$res=pg_execute($linkBd, "consValPsic", array($this->num_doc));
		$consEstUsr=array();
		$consEstUsr=pg_fetch_array($res);
		pg_close($linkBd);	
		return $consEstUsr;		

		
		
	}
	public function consultaDelitoVinc(){
		$conect=Yii::app()->db;
		$sqlConsVincPrevSRPA = "select * from delito_por_vinc where id_valoracion_psicol=:idValoracion order by id_casodelito asc";
		$consVincPrevSRPA=$conect->createCommand($sqlConsVincPrevSRPA);
		$consVincPrevSRPA->bindParam(":idValoracion",$this->id_valoracion_psicol,PDO::PARAM_INT);
		$readVincPrevSRPA=$consVincPrevSRPA->query();
		$resVincPrevSRPA=$readVincPrevSRPA->readAll();
		$readVincPrevSRPA->close();
		return $resVincPrevSRPA;	
	}
	public function consultaConsumoSPA(){
		$conect=Yii::app()->db;
		$sqlConsConsSPA = "select * from consumo_drogas where id_valoracion_psicol=:idValoracion order by id_tipo_conspa asc";
		$consConsSPA=$conect->createCommand($sqlConsConsSPA);
		$consConsSPA->bindParam(":idValoracion",$this->id_valoracion_psicol,PDO::PARAM_INT);
		$readConsSPA=$consConsSPA->query();
		$resConsSPA=$readConsSPA->readAll();
		$readConsSPA->close();
		return $resConsSPA;	
	}
	public function consultaViasAdmonAdol(){
		$conect=Yii::app()->db;
		$sqlConsConsSPA = "select * from viaadmon_consumo where id_tipo_conspa=:idSPACons order by id_viaadmon_spa asc";
		$consConsSPA=$conect->createCommand($sqlConsConsSPA);
		$consConsSPA->bindParam(":idSPACons",$this->idSPACons,PDO::PARAM_INT);
		$readConsSPA=$consConsSPA->query();
		$resConsSPA=$readConsSPA->readAll();
		$readConsSPA->close();
		return $resConsSPA;	
	
	}
	public function creaRegValPsicol(){
		$conect=Yii::app()->db;
		$sqlCreaValPsicol="insert into valoracion_psicologia (id_valoracion_psicol,num_doc,val_act_psicol) values (default,:numDoc,'true') returning id_valoracion_psicol";
		$creaValPsicol=$conect->createCommand($sqlCreaValPsicol);
		$creaValPsicol->bindParam(":numDoc",$this->num_doc,PDO::PARAM_STR);
		$readValPsicol=$creaValPsicol->query();
		$resValPsicol=$readValPsicol->read();
		$readValPsicol->close();
		return $resValPsicol["id_valoracion_psicol"];
	}
	public function creaVincPrevSrpa(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaVincPrevSrpa="insert into delito_por_vinc (
				id_casodelito,
				id_valoracion_psicol,
				id_tipo_sancion,
				id_del_rc,
				medida_int_prev,
				sancion_impuesta_vinc
			) 
			values (
				default,
				:idValPsicol,
				:idTipoSanc,
				:idDelRc,
				:medIntPrev,
				:sancImp
			)returning id_casodelito";
			if(empty($this->idTipoSancion)){$this->idTipoSancion=null;}
			$queryCreaVincPrevSrpa=$conect->createCommand($sqlCreaVincPrevSrpa);
			$queryCreaVincPrevSrpa->bindParam(':idValPsicol',$this->id_valoracion_psicol,PDO::PARAM_INT);
			$queryCreaVincPrevSrpa->bindParam(':idTipoSanc',$this->idTipoSancion,PDO::PARAM_NULL);
			$queryCreaVincPrevSrpa->bindParam(':idDelRc',$this->idDelRc,PDO::PARAM_INT);
			$queryCreaVincPrevSrpa->bindParam(':medIntPrev',$this->medidaIntPrev,PDO::PARAM_BOOL);
			$queryCreaVincPrevSrpa->bindParam(':sancImp',$this->sancImp,PDO::PARAM_BOOL);
			$readVincPrevSrpa=$queryCreaVincPrevSrpa->query();
			$resVincPrevSrpa=$readVincPrevSrpa->read();
			$readVincPrevSrpa->close();
			$transaction->commit();
			$this->idCasoDelito=$resVincPrevSrpa["id_casodelito"];
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function modificaVincPrevSrpa(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlModVincPrevSrpa="update delito_por_vinc set 
				id_tipo_sancion=:idTipoSanc,
				id_del_rc=:idDelRc,
				medida_int_prev=:medIntPrev,
				sancion_impuesta_vinc=:sancImp
				where id_casodelito=:idCasoDelito and id_valoracion_psicol=:idValPsicol
			";
			if($this->sancImp==="false"){$this->idTipoSancion=null;}
			if(empty($this->idTipoSancion)){$this->idTipoSancion=null;}
			$queryModVincPrevSrpa=$conect->createCommand($sqlModVincPrevSrpa);
			$queryModVincPrevSrpa->bindParam(':idTipoSanc',$this->idTipoSancion,PDO::PARAM_NULL);
			$queryModVincPrevSrpa->bindParam(':idDelRc',$this->idDelRc,PDO::PARAM_INT);
			$queryModVincPrevSrpa->bindParam(':medIntPrev',$this->medidaIntPrev,PDO::PARAM_BOOL);
			$queryModVincPrevSrpa->bindParam(':sancImp',$this->sancImp,PDO::PARAM_BOOL);
			$queryModVincPrevSrpa->bindParam(':idCasoDelito',$this->idCasoDelito,PDO::PARAM_INT);
			$queryModVincPrevSrpa->bindParam(':idValPsicol',$this->id_valoracion_psicol,PDO::PARAM_INT);
			$queryModVincPrevSrpa->execute();
			$transaction->commit();
			return "exito";			
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function regHistoricoValPsic(){
		if(!empty($this->nombreCampoValoracioni)){
			$this->nombreCampoValoracion=$this->nombreCampoValoracioni;
		}
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegHist="insert into modificacion_valpsicol (
				id_modvalpsicol,
				id_valoracion_psicol,
				id_cedula,						
				modvalpsicol,
				nomb_campopsicol,
				fecha_mod_valpsic
			) values (
				default,
				:id_valoracion_psicol,
				:id_cedula,						
				:modvalpsicol,
				:campo_vnutr,
				:fecha_mod_valpsic
			)";//
			$regHist=$conect->createCommand($sqlRegHist);
			$fecha=date("Y-m-d H:i:s");
			$regHist->bindParam(":id_valoracion_psicol",$this->id_valoracion_psicol,PDO::PARAM_INT);
			$regHist->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regHist->bindParam(":modvalpsicol",$this->contHist,PDO::PARAM_STR);
			$regHist->bindParam(":campo_vnutr",$this->nombreCampoValoracion,PDO::PARAM_STR);
			$regHist->bindParam(":fecha_mod_valpsic",$fecha,PDO::PARAM_STR);
			$regHist->execute();
			$transaction->commit();
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			
			
		}
	}
	
	
	public function modificaValoracionPsicol($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->contenidoValoracion)){$this->contenidoValoracion=null;}
			$sqlModValPsicol="update valoracion_psicologia 
				set ".$this->nombreCampoValoracion."=:contVal,
				".$this->campoFecha."=:fecha 
				where id_valoracion_psicol=:idValPsicol";
			$modValPsicol=$conect->createCommand($sqlModValPsicol);
			$modValPsicol->bindParam(':fecha',$this->fecha,PDO::PARAM_STR);
			$modValPsicol->bindParam(':contVal',$this->contenidoValoracion,PDO::PARAM_NULL);
			$modValPsicol->bindParam(':idValPsicol',$this->id_valoracion_psicol,PDO::PARAM_INT);
			$modValPsicol->execute();
			$this->creaRegProfVal($this->id_valoracion_psicol,$accion);
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function modificaValoracionPsicolOpt($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->contenidoValoracion)){$this->contenidoValoracion=null;}
			$sqlModValPsicol="update valoracion_psicologia 
				set ".$this->nombreCampoValoracion."=:contVal,
				".$this->nombreCampoValoracioni."=:contVali,
				".$this->campoFecha."=:fecha 
				where id_valoracion_psicol=:idValPsicol and num_doc=:num_doc";
			$modValPsicol=$conect->createCommand($sqlModValPsicol);
			$modValPsicol->bindParam(':fecha',$this->fecha,PDO::PARAM_STR);
			$modValPsicol->bindParam(':contVal',$this->contenidoValoracion,PDO::PARAM_NULL);
			$modValPsicol->bindParam(':contVali',$this->contenidoValoracioni,PDO::PARAM_NULL);
			$modValPsicol->bindParam(':idValPsicol',$this->id_valoracion_psicol,PDO::PARAM_INT);
			$modValPsicol->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
			$modValPsicol->execute();
			$this->creaRegProfVal($this->id_valoracion_psicol,$accion);
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function creaConsSpa(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if($this->spa_may_imp=="true"){
				$sqlModSpaMayImp="update consumo_drogas set droga_mayor_impacto='false' where id_valoracion_psicol=:idValPsicol";
				$modSpaMayImp=$conect->createCommand($sqlModSpaMayImp);
				$modSpaMayImp->bindParam(":idValPsicol",$this->id_valoracion_psicol,PDO::PARAM_INT);
				$modSpaMayImp->execute();
			}
			$sqlCreaConsSpa="insert into consumo_drogas (
				id_tipo_conspa,
				id_frecuencia_uso,
				id_tipo_droga,
				id_valoracion_psicol,
				consumo_ult_anio,
				edad_inicio_cons,
				edad_fin_cons,
				droga_inicio,
				droga_mayor_impacto,
				motivo_inicio_cons
			) values (
				default,
				:idFrecuenciaUso,
				:idTipoDroga,
				:idValPsicol,
				:consUltAn,
				:edadIni,
				:edadFin,
				:spaIni,
				:spaMayImp,
				:motivoCons
			) returning id_tipo_conspa";
			if(empty($this->edad_fin)){$this->edad_fin=null;}
			$creaConsSpa=$conect->createCommand($sqlCreaConsSpa);
			$creaConsSpa->bindParam(":idFrecuenciaUso",$this->frec_uso,PDO::PARAM_INT);
			$creaConsSpa->bindParam(":idTipoDroga",$this->tipo_spa,PDO::PARAM_INT);
			$creaConsSpa->bindParam(":idValPsicol",$this->id_valoracion_psicol,PDO::PARAM_INT);
			$creaConsSpa->bindParam(":consUltAn", $this->cons_ult_anio,PDO::PARAM_BOOL);
			$creaConsSpa->bindParam(":edadIni",$this->edad_ini,PDO::PARAM_INT);
			$creaConsSpa->bindParam(":edadFin",$this->edad_fin,PDO::PARAM_INT);
			$creaConsSpa->bindParam(":spaIni", $this->spa_ini,PDO::PARAM_BOOL);
			$creaConsSpa->bindParam(":spaMayImp",$this->spa_may_imp,PDO::PARAM_BOOL);
			$creaConsSpa->bindParam(":motivoCons",$this->motivos_cons,PDO::PARAM_STR);
			$readCreaConsSpa=$creaConsSpa->query();
			$resCreaConsSpa=$readCreaConsSpa->read();
			$readCreaConsSpa->close();
			$this->idConsSpa=$resCreaConsSpa["id_tipo_conspa"];
			foreach($this->via_admon as $viaAdmon){
				$sqlViaAdminCons="insert into viaadmon_consumo (
					id_viaadmon_spa,
					id_tipo_conspa
				) values (
					:idViaAdmon,
					:idConsSpa
				)";
				$viaAdminCons=$conect->createCommand($sqlViaAdminCons);
				$viaAdminCons->bindParam(':idViaAdmon',$viaAdmon,PDO::PARAM_INT);
				$viaAdminCons->bindParam(':idConsSpa',$this->idConsSpa,PDO::PARAM_INT);
				$viaAdminCons->execute();
			}
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}	
	}
	public function modEstadoConsSpa(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlModEstConsSpa="update valoracion_psicologia set consumo_spa=:consumo_spa where id_valoracion_psicol=:id_valoracion_psicol and num_doc=:num_doc";
			$modEstConsSpa=$conect->createCommand($sqlModEstConsSpa);
			$modEstConsSpa->bindParam(":consumo_spa",$this->consumo_spa,PDO::PARAM_BOOL);
			$modEstConsSpa->bindParam(":id_valoracion_psicol",$this->id_valoracion_psicol,PDO::PARAM_INT);
			$modEstConsSpa->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$modEstConsSpa->execute();
			
			
			
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
			
		}
	}
	public function modificaConsSPA(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if($this->spa_may_imp=="true"){
				$sqlModSpaMayImp="update consumo_drogas set droga_mayor_impacto='false' where id_valoracion_psicol=:idValPsicol";
				$modSpaMayImp=$conect->createCommand($sqlModSpaMayImp);
				$modSpaMayImp->bindParam(":idValPsicol",$this->id_valoracion_psicol,PDO::PARAM_INT);
				$modSpaMayImp->execute();
			}//id_tipo_conspa,id_valoracion_psicol,
			$sqlCreaConsSpa="update consumo_drogas set
				id_frecuencia_uso=:idFrecuenciaUso,
				id_tipo_droga=:idTipoDroga,				
				consumo_ult_anio=:consUltAn,
				edad_inicio_cons=:edadIni,
				edad_fin_cons=:edadFin,
				droga_mayor_impacto=:spaMayImp,
				motivo_inicio_cons=:motivoCons 
				where id_tipo_conspa=:idConsSpa and id_valoracion_psicol=:idValPsicol				
			";
			if(empty($this->edad_fin)){$this->edad_fin=null;}
			$creaConsSpa=$conect->createCommand($sqlCreaConsSpa);
			$creaConsSpa->bindParam(":idConsSpa",$this->idConsSpa,PDO::PARAM_INT);
			$creaConsSpa->bindParam(":idFrecuenciaUso",$this->frec_uso,PDO::PARAM_INT);
			$creaConsSpa->bindParam(":idTipoDroga",$this->tipo_spa,PDO::PARAM_INT);
			$creaConsSpa->bindParam(":idValPsicol",$this->id_valoracion_psicol,PDO::PARAM_INT);
			$creaConsSpa->bindParam(":consUltAn", $this->cons_ult_anio,PDO::PARAM_BOOL);
			$creaConsSpa->bindParam(":edadIni",$this->edad_ini,PDO::PARAM_INT);
			$creaConsSpa->bindParam(":edadFin",$this->edad_fin,PDO::PARAM_INT);
			$creaConsSpa->bindParam(":spaMayImp",$this->spa_may_imp,PDO::PARAM_BOOL);
			$creaConsSpa->bindParam(":motivoCons",$this->motivos_cons,PDO::PARAM_STR);
			$creaConsSpa->execute();
			//elimina vias admin
			$sqlDelViaAdmon="delete from viaadmon_consumo where  id_tipo_conspa=:idConsSpa";
			$delViaAdmon=$conect->createCommand($sqlDelViaAdmon);
			$delViaAdmon->bindParam(':idConsSpa',$this->idConsSpa,PDO::PARAM_INT);
			$delViaAdmon->execute();
			//vuelve a registra vias admin
			foreach($this->via_admon as $viaAdmon){
				$sqlViaAdminCons="insert into viaadmon_consumo (
					id_viaadmon_spa,
					id_tipo_conspa
				) values (
					:idViaAdmon,
					:idConsSpa
				)";
				$viaAdminCons=$conect->createCommand($sqlViaAdminCons);
				$viaAdminCons->bindParam(':idViaAdmon',$viaAdmon,PDO::PARAM_INT);
				$viaAdminCons->bindParam(':idConsSpa',$this->idConsSpa,PDO::PARAM_INT);
				$viaAdminCons->execute();
			}
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}	
	}
	
	public function modFechaActuacion($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlModFechaAct="update valoracion_psicologia set ".pg_escape_string($this->campoFecha)."=:fecha 
				where id_valoracion_psicol=:id_valoracion_psicol and num_doc=:num_doc";
			$modFechaAct=$conect->createCommand($sqlModFechaAct);
			$modFechaAct->bindParam(":fecha",$this->fecha,PDO::PARAM_STR);
			$modFechaAct->bindParam(":id_valoracion_psicol",$this->id_valoracion_psicol,PDO::PARAM_INT);
			$modFechaAct->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$modFechaAct->execute();
			$this->creaRegProfVal($this->id_valoracion_psicol,$accion);
			$transaction->commit();
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
		}
	}
	public function consValHab(){
		$conect=Yii::app()->db;
		$sqlConsHabVal="select val_hab_ps from valoracion_psicologia where num_doc=:num_doc";
		$consHabVal=$conect->createCommand($sqlConsHabVal);
		$consHabVal->bindParam(":num_doc",Yii::app()->getSession()->get('numDocAdol'),PDO::PARAM_STR);
		$readHabVal=$consHabVal->query();
		$resHabVal=$readHabVal->read();
		$readHabVal->close();
		return $resHabVal;
	}
	public function modValHabFalse(){
		$conect=Yii::app()->db;
		$sqlActHabVal="update valoracion_psicologia set val_hab_ps='false' where num_doc=:num_doc";
		$actHabVal=$conect->createCommand($sqlActHabVal);
		$actHabVal->bindParam(":num_doc",Yii::app()->getSession()->get('numDocAdol'),PDO::PARAM_STR);
		$actHabVal->execute();		
	}
	//crea el registro en el caso que el 
	public function creaRegProfVal($idValoracion,$accion){
		$conect=Yii::app()->db;
		$fechaRegistro=date("Y-m-d");
		$sqlConsFechaMod="select fecha_regprvps from profesional_valpsicol where id_valoracion_psicol=:id_valoracion_psicol and id_accval=:id_accval order by fecha_regprvps desc limit 1";
		$consFechaMod=$conect->createCommand($sqlConsFechaMod);
		$consFechaMod->bindParam(":id_valoracion_psicol",$idValoracion,PDO::PARAM_INT);
		$consFechaMod->bindParam(":id_accval",$accion,PDO::PARAM_INT);
		$readFechaMod=$consFechaMod->query();
		$resFechaMod=$readFechaMod->read();
		$readFechaMod->close();
		$creaRegistro=false;
		
		if(empty($resFechaMod["fecha_regprvps"])){
			$creaRegistro=true;
		}
		elseif($resFechaMod["fecha_regprvps"]!=$fechaRegistro){
			$creaRegistro=true;
		}
		if($creaRegistro==true){
			$sqlCreaRegProfVal="insert into profesional_valpsicol (
				id_cedula,
				id_valoracion_psicol,
				id_accval,
				fecha_regprvps
			) values (
				:id_cedula,
				:id_valoracion_psicol,
				:id_accval,
				:fecha_regprvps			
			)";	
			$creaRegProfVal=$conect->createCommand($sqlCreaRegProfVal);	
			$creaRegProfVal->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":id_valoracion_psicol",$idValoracion,PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":id_accval",$accion,PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":fecha_regprvps",$fechaRegistro,PDO::PARAM_STR);
			$creaRegProfVal->execute();		
		}					
	}
	public function consultaValPsicol(){
		$conect=Yii::app()->db;
		$sqlConsValPsicol="select * from valoracion_psicologia where id_valoracion_psicol=:id_valoracion_psicol";
		$consValPsicol=$conect->createCommand($sqlConsValPsicol);
		$consValPsicol->bindParam(":id_valoracion_psicol",$this->id_valoracion_psicol);
		$readValPsicol=$consValPsicol->query();
		$resValPsicol=$readValPsicol->read();
		$readValPsicol->close();
		return $resValPsicol;
	}

/*	public function buscaAdolGen(){
		$nombres=mb_strtoupper($this->searchTerm,"UTF-8");
		$nombres=split(" ",$nombres);
		$conect=Yii::app()->db;
		$compConsSql="";
		$compCondicion="";
		
		if(Yii::app()->user->getState('rol')==4 or Yii::app()->user->getState('rol')==5){
			$compConsSql=", hist_personal_adol as c ";
			$compCondicion="and c.num_doc=a.num_doc and c.id_cedula=:idCedula";
		}
		if(count($nombres)==1 && !empty($nombres[0])){
			$sqlCons = "select distinct(b.num_doc), nombres,apellido_1,apellido_2,b.num_doc ";
			$sqlCons .= "from (select num_doc from adolescente where nombres like '%".$nombres[0]."%' or apellido_1 like '%".$nombres[0]."%' ";
			$sqlCons .= "or apellido_2 like '%".$nombres[0]."%' limit 20) as a,";
			$sqlCons .= "adolescente as b where ";
			$sqlCons .= "a.num_doc=b.num_doc order by nombres asc";
		}
		elseif(count($nombres)==2&&!empty($nombres[1])){
			$nomb = $nombres[0]." ".$nombres[1];
			$sqlCons = "select  distinct(b.num_doc), nombres,apellido_1,apellido_2,b.num_doc ";
			$sqlCons .="from (select num_doc from adolescente where nombres like '%".$nombres[0]." ".$nombres[1]."%' or apellido_1 like '%".$nombres[0]."%' ";
			$sqlCons .= "and apellido_2 like '%".$nombres[1]."%' or nombres like '%".$nombres[0]."%' and apellido_1 like '%".$nombres[1]."%' or nombres like '%".$nombres[1]."%' and apellido_1 like '%".$nombres[0]."%' order by nombres asc limit 20) as a,";
			$sqlCons .= "adolescente as b  where a.num_doc=b.num_doc ";		
		}
		elseif(count($nombres)==3&&!empty($nombres[1])&&!empty($nombres[2])){
			$nomb = $strCons[0]." ".$strCons[1];
			$sqlCons = "select  distinct(b.num_doc), nombres,apellido_1,apellido_2,b.num_doc ";
			$sqlCons .="from (select num_doc from adolescente where nombres like '%".$nomb."%' and apellido_1 like '%".$nombres[2]."%' or nombres like '%".$nombres[2]."%' ";
			$sqlCons .= "and apellido_1 like '%".$nombres[0]."%' and apellido_2 like '%".$nombres[1]."%' order by nombres asc limit 20) as a,";
			$sqlCons .= "adolescente as b where a.num_doc=b.num_doc";
		}
		elseif(count($nombres)==4&&$nombres[1]!=""&&$nombres[2]!=""&&$nombres[3]!=""){
			$nomb = $nombres[0]." ".$nombres[1];
			$nombi = $nombres[2]." ".$nombres[3];
			$sqlCons = "select  distinct(b.num_doc), nombres,apellido_1,apellido_2,b.num_doc ";
			$sqlCons .="from (select num_doc from adolescente where nombres like '%".$nomb."%' and apellido_1 like '%".$nombres[2]."%' ";
			$sqlCons .= "and apellido_2 like '%".$nombres[3]."%' or nombres like '%".$nombi."%' and apellido_1 like '%".$nombres[0]."%' and apellido_2 like '%".$nombres[1]."%' order by nombres asc limit 20) as a,";
			$sqlCons .= "adolescente as b where a.num_doc=b.num_doc and a.num_doc=b.num_doc";
		}
		$consultaAdol=$conect->createCommand($sqlCons);
		if(Yii::app()->user->getState('rol')==4 or Yii::app()->user->getState('rol')==5){
			$consultaAdol->bindParam(':idCedula',Yii::app()->user->hasState('cedula'),PDO::PARAM_INT);
		}
		$queryConsulta=$consultaAdol->query();
		while($readConsulta=$queryConsulta->read()){
			$res[]=array( "numDocAdol" =>$readConsulta["num_doc"], "nombre"=>$readConsulta["nombres"]." ".$readConsulta["apellido_1"]." ".$readConsulta["apellido_2"]);
		}
		$queryConsulta->close();
		return $res;	
	}
*/}
