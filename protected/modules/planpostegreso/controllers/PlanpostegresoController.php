<?php
///!  Clase controlador del módulo Plan post egreso.
/**
 * @author Félix Mauricio Vargas Hincapié <femauro@gmail.com>
 * @copyright Copyright &copy; Félix Mauricio Vargas Hincapié 2015
 */

Yii::import('application.modules.modIdenReg.models.ForjarAdol');	
class PlanpostegresoController extends Controller{
	
	/**
	 * Acción que se ejecuta en segunda instancia para verificar si el usuario tiene sesión activa.
	 * En caso contrario no podrá acceder a los módulos del aplicativo y generará error de acceso.
	 */
	public function filterEnforcelogin($filterChain){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403,"Debe loguearse primero");
		}
		$filterChain->run();
	}
	
	/**
	 * Acción que se ejecuta en primera instancia que llama a verificar la sesión de usuario y llama a los filtros secundarios
	 * Los filtros no se ejecutan cuando se llaman a las acciones que van seguidas del guión.
	 */
	public function filters(){
		return array('enforcelogin',array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()));
	}

	/**
	 *	Acción que renderiza la vista que contiene los formularios para registrar el plan de atención integral del adolescente.
	 *
	 *	Vista a renderizar:
	 *		- _datosConsPPEg.
	 *
	 *	Formularios contenidos:
	 *		- _consInfJudAdmonAc					formulario consulta de la información judicial del adolescente
	 *		- _formVerificacionDerForjarEgresoCons	formulario de verificación de derechos que se debe diligenciar al egreso del adolescente.
	 *		- _paiConsForm 							formulario de consulta del plan de atención integral.
	 *		- _creaModifPPEg						formulario de diligenciamiento del plan de atención integral en caso que el adolescente haya culminado el pai y cumplido su sanción.
	 *
	 *	Modelos instanciados:        
	 *		- DerechoAdol
	 * 		- InformacionJudicial
	 * 		- ComponenteDerecho
	 * 		- ComponenteSancion
	 * 		- PlanPostegreso
	 * 		- AccionesEgreso
	 * 		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 *	 
	 *	@param object	$modeloPlanPe		
	 *	@param array	$planPEgreso
	 *	@param object	$modeloAccEgr
	 *	@param array	$accionesEgreso
	 *	@param object	$modeloPAI
	 *	@param object	$modeloCompDer
	 *	@param object	$modeloCompSanc
	 *	@param object	$modeloVerifDerechos
	 *	@param string	$numDocAdol
	 *	@param array	$datosAdol
	 *	@param int		$edad
	 *	@param string	$conceptoInt
	 *	@param array	$derechos
	 *	@param array	$participacion
	 *	@param array	$proteccion
	 *	@param array	$instanciaRem
	 *	@param int		$espProcJud
	 *	@param array	$delitoRem
	 *	@param object	$modeloInfJud
	 *	@param object	$compSancInfJud
	 *	@param object	$compSancInfJud
	 *	@param int		$tipoSancion
	 *	@param array	$infJudicialPai
	 *	@param object	$modeloSegComDer
	 *	@param object	$modeloSegComSanc
	 *	@param array	$consultaDerechoAdol
	 *	@param array	$consultaGeneral
	 *	@param object	$modeloPlanPe
	 *	@param object	$modeloAccEgr
	 *	@param int		$idMomentoVerif
	 */		
	public function actionCreaModificaPlanPe(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="creaModificaPlanPe";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}		
			if(!empty($numDocAdol)){ 
				$modeloVerifDerechos=new DerechoAdol();	
				$modeloVerifDerechos->num_doc=$numDocAdol;
				$modeloVerifDerechos->id_instanciader=1; 
				$modeloVerifDerechos->id_momento_verif=2; 
				$verifDerEgreso=$modeloVerifDerechos->consultaDerechos();//id_derechocespa
				if(empty($verifDerEgreso)){								
					Yii::app()->user->setFlash('verifderechoegreso', "Debe primero realizar la verificación de derechos al egreso antes de realizar el plan post-egreso");									
				}
				$modeloPAI=new Pai();
				$modeloInfJud=new InformacionJudicial();
				$modeloCompDer=new ComponenteDerecho();
				$modeloCompSanc=new ComponenteSancion();
				$modeloPlanPe=new PlanPostegreso();
				$modeloAccEgr=new AccionesEgreso();
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));			
				$consultaGeneral->numDocAdol=$numDocAdol;
				$conceptoInt=$consultaGeneral->consultaConcInt();//Consulta el concepto integral
				$derechos=$consultaGeneral->consultaDerechos();
				$modeloPAI->num_doc=$numDocAdol;
				$modeloPlanPe->num_doc=$numDocAdol;				
				$planPEgreso=$modeloPlanPe->consultaPlanPe();				
				if(!empty($planPEgreso)){
					$modeloPlanPe->attributes=$planPEgreso;
					$modeloPlanPe->id_planpostegreso=$planPEgreso["id_planpostegreso"];
					$modeloAccEgr->id_planpostegreso=$planPEgreso["id_planpostegreso"];
					$modeloPlanPe->fecha_registroplan=$planPEgreso["fecha_registroplan"];
					$modeloPAI->id_pai=$modeloPlanPe->id_pai;
					$accionesEgreso=$modeloAccEgr->consultaAccPlanPe();
					$paiActual=$modeloPAI->consultaPAIPlanPE();
					$modeloPAI->attributes=$paiActual;	
					//$modeloPAI->id_pai=$modeloPlanPe->id_pai;
				}
				else{
					$paiActual=$modeloPAI->consultaPAIActual();
					$modeloPAI->attributes=$paiActual;					
				}	
				$idMomentoVerif=1;
				$idPai=$modeloPAI->id_pai;
				$modeloCompDer->id_pai=$idPai;
				$modeloCompSanc->id_pai=$idPai;
								//asigna el identificador de pai al modelo del plan post-egreso
				$modeloPlanPe->id_pai=$modeloPAI->id_pai;
				$participacion=$consultaGeneral->consultaParticipacion();
					//consulta Protección
				$proteccion=$consultaGeneral->consultaProteccion();
				$idInstanciaDer=1;
				$consultaDerechoAdol=$modeloVerifDerechos->findAll('num_doc=:numDoc and id_instanciader=:id_instanciader and id_momento_verif=1',
					array(
						':numDoc'=>$numDocAdol,
						':id_instanciader'=>$idInstanciaDer
					)
				);	
				/*-----------------------------------------*/
				//consulta Participación
				$participacion=$consultaGeneral->consultaParticipacion();
				//consulta Protección
				$proteccion=$consultaGeneral->consultaProteccion();
				$idInstanciaDer=1;
				//consulta información judicial
				$instanciaRem=$consultaGeneral->consultaEntidades('instancia_remisora','id_instancia_rem');
				$espProcJud=$consultaGeneral->consultaEntidades('estado_proc_judicial','id_proc_jud');
				$tipoSancion=$consultaGeneral->consultaEntidades('tipo_sancion','id_tipo_sancion');
				$delitoRem=$consultaGeneral->consultaEntidades('delito_rem_cespa','id_del_rc');
				$modeloInfJud->num_doc=$numDocAdol;
				$infJudicial=$modeloInfJud->consultaInfJud();
				$infJudicialPai=$modeloInfJud->consultaInfJud();
				if(!empty($infJudicial)){
					foreach($infJudicial as $pk=>$infJudicialNov){
						$infJud=$modeloInfJud->consultaInfJudNov($infJudicialNov["id_inf_judicial"]);
						if(!empty($infJud)){
							$infJudicial[$pk]=$infJud;
						}			
					}
				}
				foreach($infJudicial as $infJudicialCompSan){
					//echo $infJudicial["id_inf_judicial"];
					$resInfJud=$modeloCompSanc->consultaPaiSanc($infJudicialCompSan["id_inf_judicial"]);
					if(!empty($resInfJud)){
						if($modeloPAI->id_pai==$resInfJud["id_pai"]){
							$compSancInfJud[]=$resInfJud;
						}
					}
					else{
						$compSancInfJud[]=$infJudicialCompSan;
					}
				}
						
					//$compSancInfJud="";
			}
			$this->render('_datosConsPPEg',array(
				'modeloPlanPe'=>$modeloPlanPe,		
				'planPEgreso'=>$planPEgreso,
				'modeloAccEgr'=>$modeloAccEgr,
				'accionesEgreso'=>$accionesEgreso,
				'modeloPAI'=>$modeloPAI,
				'modeloCompDer'=>$modeloCompDer,
				'modeloCompSanc'=>$modeloCompSanc,
				'modeloVerifDerechos'=>$modeloVerifDerechos,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'conceptoInt'=>$conceptoInt	,
				'derechos'=>$derechos,
				'participacion'=>$participacion,
				'proteccion'=>$proteccion,
				'instanciaRem'=>$instanciaRem,
				'espProcJud'=>$espProcJud	,
				'delitoRem'=>$delitoRem,
				'modeloInfJud'=>$modeloInfJud,
				'infJudicial'=>$compSancInfJud,
				'compSancInfJud'=>$compSancInfJud,
				'tipoSancion'=>$tipoSancion,
				'infJudicialPai'=>$infJudicialPai,
				'modeloSegComDer'=>$modeloSegComDer,
				'modeloSegComSanc'=>$modeloSegComSanc,
				'consultaDerechoAdol'=>$consultaDerechoAdol,
				'consultaGeneral'=>$consultaGeneral,
				'modeloPlanPe'=>$modeloPlanPe,
				'modeloAccEgr'=>$modeloAccEgr,
				'idMomentoVerif'=>$idMomentoVerif
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario de registrol plan post egreso e instancia a modelo para registrar en base de datos.
	 *
	 *	Modelos instanciados:
	 *		- ComponenteDerecho
	 *
	 *	@param array $dataInput array de datos del formulario plan post egreso
	 *	@return json resultado de la transacción.
	 */		
	public function actionCrearPlanPe(){
		$dataInput=Yii::app()->input->post();
		if(isset($_POST["PlanPostegreso"]["id_pai"])&&!empty($_POST["PlanPostegreso"]["id_pai"])&&isset($_POST["PlanPostegreso"]["num_doc"])&&!empty($_POST["PlanPostegreso"]["num_doc"])){			
			$modeloPlanPe=new PlanPostegreso();	
			$modeloPlanPe->attributes=$dataInput["PlanPostegreso"];
			if($modeloPlanPe->validate()){
				$resultado=$modeloPlanPe->creaPlanPe();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado)),'idPlanpostegreso'=>CHtml::encode($modeloPlanPe->id_planpostegreso)));
			}
			else{
				echo CActiveForm::validate($modeloPlanPe);
			}			
		}
	}
	/**
	 *	Recibe datos del formulario de registrol plan post egreso e instancia a modelo para modificar en base de datos en base de datos.
	 *
	 *	Modelos instanciados:
	 *		- ComponenteDerecho
	 *
	 *	@param array $dataInput array de datos del formulario del plan post egreso
	 *	@return json resultado de la transacción.
	 */		
	public function actionModificarPlanPe(){
		$dataInput=Yii::app()->input->post();
		if(isset($_POST["PlanPostegreso"]["id_pai"])&&!empty($_POST["PlanPostegreso"]["id_pai"])&&isset($_POST["PlanPostegreso"]["num_doc"])&&!empty($_POST["PlanPostegreso"]["num_doc"])){			
			$modeloPlanPe=new PlanPostegreso();	
			$modeloPlanPe->attributes=$dataInput["PlanPostegreso"];
			$modeloPlanPe->id_planpostegreso=$dataInput["PlanPostegreso"]["id_planpostegreso"];
			if($modeloPlanPe->validate()){
				$resultado="exito";
				$planPEgreso=$modeloPlanPe->consultaPlanPe();
				if($modeloPlanPe->concepto_egreso!=$planPEgreso["concepto_egreso"]){
					$modeloPlanPe->nombreCampo='concepto_egreso';
					$modeloPlanPe->datoCampo=$modeloPlanPe->concepto_egreso;
					$resultado=$modeloPlanPe->modifPlanPeg();
				}
				if($modeloPlanPe->proyeccion_pegreso!=$planPEgreso["proyeccion_pegreso"]){
					$modeloPlanPe->nombreCampo='proyeccion_pegreso';
					$modeloPlanPe->datoCampo=$modeloPlanPe->proyeccion_pegreso;
					$resultado=$modeloPlanPe->modifPlanPeg();
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloPlanPe);
			}			
		}
	}
	/**
	 *	Recibe datos del formulario de registro de acciones del plan post egreso e instancia a modelo para registrar en base de datos
	 *
	 *	Modelos instanciados:
	 *		- AccionesEgreso
	 *
	 *	@param array $dataInput array de datos del formulario del plan post egreso
	 *	@return json resultado de la transacción.
	 */		
	public function actionCreaAccPEg(){
		$dataInput=Yii::app()->input->post();
		$modeloAccEgr=new AccionesEgreso();
		$modeloAccEgr->attributes=$dataInput["AccionesEgreso"];
		$modeloAccEgr->id_planpostegreso=$dataInput["AccionesEgreso"]["id_planpostegreso"];
		$modeloAccEgr->id_pai=$dataInput["AccionesEgreso"]["id_pai"];
		$modeloAccEgr->num_doc=$dataInput["AccionesEgreso"]["num_doc"];
		if($modeloAccEgr->validate()){
			$resultado=$modeloAccEgr->creaActPPEg();
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
		}
		else{
			echo CActiveForm::validate($modeloAccEgr);
		}
	}
	/**
	 *	Recibe datos del formulario de registro de acciones del plan post egreso e instancia a modelo para modificar en base de datos
	 *	Si los datos del campo son los mismos que registrados en base de datos entonces no actualiza campo.
	 *
	 *	Modelos instanciados:
	 *		- AccionesEgreso
	 *
	 *	@param array $dataInput array de datos del formulario del plan post egreso
	 *	@return json resultado de la transacción.
	 */		
	public function actionModAccPEg(){
		$dataInput=Yii::app()->input->post();
		$modeloAccEgr=new AccionesEgreso();
		$modeloAccEgr->attributes=$dataInput["AccionesEgreso"];
		$modeloAccEgr->id_acceg=$dataInput["AccionesEgreso"]["id_acceg"];
		$modeloAccEgr->id_planpostegreso=$dataInput["AccionesEgreso"]["id_planpostegreso"];
		$modeloAccEgr->id_pai=$dataInput["AccionesEgreso"]["id_pai"];
		$modeloAccEgr->num_doc=$dataInput["AccionesEgreso"]["num_doc"];
		$restulado="exito";
		if($modeloAccEgr->validate()){
			$datosActAccEgr=$modeloAccEgr->consultaAccPlanPeComp();
			if($modeloAccEgr->objetivo_acceg!=$datosActAccEgr["objetivo_acceg"]){
				$modeloAccEgr->nombreCampo="objetivo_acceg";
				$modeloAccEgr->datoCampo=$modeloAccEgr->objetivo_acceg;
				$restulado=$modeloAccEgr->modifAccPPeg();				
			}
			if($modeloAccEgr->actividaes_acceg!=$datosActAccEgr["actividaes_acceg"]){
				$modeloAccEgr->nombreCampo="actividaes_acceg";
				$modeloAccEgr->datoCampo=$modeloAccEgr->actividaes_acceg;
				$restulado=$modeloAccEgr->modifAccPPeg();				
			}
			if($modeloAccEgr->fuente_verif_acceg!=$datosActAccEgr["fuente_verif_acceg"]){
				$modeloAccEgr->nombreCampo="fuente_verif_acceg";
				$modeloAccEgr->datoCampo=$modeloAccEgr->fuente_verif_acceg;
				$restulado=$modeloAccEgr->modifAccPPeg();				
			}
			if($modeloAccEgr->responsable_acceg!=$datosActAccEgr["responsable_acceg"]){
				$modeloAccEgr->nombreCampo="responsable_acceg";
				$modeloAccEgr->datoCampo=$modeloAccEgr->responsable_acceg;
				$restulado=$modeloAccEgr->modifAccPPeg();				
			}
			if($modeloAccEgr->tiempo_acceg!=$datosActAccEgr["tiempo_acceg"]){
				$modeloAccEgr->nombreCampo="tiempo_acceg";
				$modeloAccEgr->datoCampo=$modeloAccEgr->tiempo_acceg;
				$restulado=$modeloAccEgr->modifAccPPeg();				
			}
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($restulado))));
		}
		else{
			echo CActiveForm::validate($modeloAccEgr);
		}
	}
	/**
	 *	Acción que renderiza la vista que contiene el formulario para diligenciar la verificación de derechos al egreso.
	 *
	 *	Vista a renderizar:
	 *		- _formVerificacionDerForjarEgreso.
	 *
	 *	Modelos instanciados:        
	 *		- DerechoAdol
	 * 		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 *	 
	 *	@param string	$numDocAdol
	 *	@param array	$datosAdol
	 *	@param object	$modeloVerifDerechos		
	 *	@param array	$derechos
	 *	@param array	$participacion
	 *	@param array	$proteccion
	 *	@param int		$edad
	 *	@param array	$consultaDerechoAdol
	 */		
	public function actionVerificacionDerechosEgresoForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="verificacionDerechosEgresoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloVerifDerechos=new DerechoAdol();		
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$modeloPai=new Pai();
				$modeloPai->num_doc=$numDocAdol;
				$consPaiAct=$modeloPai->consultaPAIActual();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$derechos=$consultaGeneral->consultaDerechos();
				//consulta Participación
				$participacion=$consultaGeneral->consultaParticipacion();
				//consulta Protección
				$proteccion=$consultaGeneral->consultaProteccion();
				$idInstanciaDer=1;
				$consultaDerechoAdol=$modeloVerifDerechos->findAll('num_doc=:numDoc and id_instanciader=:id_instanciader and id_momento_verif=2',
					array(
					':numDoc'=>$numDocAdol,
					':id_instanciader'=>$idInstanciaDer
					)
				);
				if(!$consultaDerechoAdol){
					$formularioCargaDerechos="_formVerificacionDerForjarEgreso";
				}
				else{
					//print_r($consultaDerechoAdol);
					$dias	= (strtotime($consultaDerechoAdol[0]["fecha_reg_derecho"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if($dias<Yii::app()->params["tiempo_verifder"]){
						$formularioCargaDerechos="_formVerificacionDerForjarEgresoMod";//_formVerificacionDerForjarCons
					}
					else{
						$formularioCargaDerechos="_formVerificacionDerForjarEgresoCons";//_formVerificacionDerForjarCons						
					}
				}
			}	
			else{
				$formularioCargaDerechos="_formVerificacionDerForjarEgreso";
			}
			$this->render($formularioCargaDerechos,array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'modeloVerifDerechos'=>$modeloVerifDerechos,
				'derechos'=>$derechos,
				'participacion'=>$participacion,
				'proteccion'=>$proteccion,
				'edad'=>$edad,
				'consultaDerechoAdol'=>$consultaDerechoAdol,
				'consPaiAct'=>$consPaiAct
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario de registro la verificación de derechos del adolescente al egreso e instancia a modelo para registrar en base de datos
	 *
	 *	Modelos instanciados:
	 *		- DerechoAdol
	 *
	 *	@param array $dataInput array de datos del formulario de la verificación de derechos al egreso.
	 *	@return json resultado de la transacción.
	 */		
	public function actionCreaVerifDerAdolEgreso(){
		$modeloForjarAdol=new ForjarAdol();
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="verificacionDerechosEgresoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){					
			$modeloVerifDerechos=new DerechoAdol();
			$this->performAjaxValidation('formularioVerifDer',$modeloVerifDerechos);		
			if(isset($_POST["DerechoAdol"]) && !empty($_POST["DerechoAdol"])){ 
				$datosInput=Yii::app()->input->post(); 
				$modeloVerifDerechos->attributes=$datosInput["DerechoAdol"];
				if($modeloVerifDerechos->validate()){
					$modeloVerifDerechos->atributos=$datosInput["DerechoAdol"];
					$resultado=$modeloVerifDerechos->registraDerechos();
					if($resultado=="exito"){
						$modeloForjarAdol->num_doc=$modeloVerifDerechos->num_doc;
						$modeloForjarAdol->id_estado_adol=2;
						$resultado=$modeloForjarAdol->cambiaEstadoAdol();
					}
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado,'msnError'=>$modeloVerifDerechos->msnErrorDerecho));
				}
				else{
					echo CActiveForm::validate($modeloVerifDerechos);
				}
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario de registro la verificación de derechos del adolescente al egreso e instancia a modelo para modificar en base de datos
	 *
	 *	Modelos instanciados:
	 *		- DerechoAdol
	 *
	 *	@param array $dataInput array de datos del formulario de la verificación de derechos al egreso.
	 *	@return json resultado de la transacción.
	 */		
	public function actionModVerifDerAdolEgreso(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="verificacionDerechosEgresoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){		
			$modeloVerifDerechos=new DerechoAdol();
			$derechosAdol=Yii::app()->input->post();
			if(isset($_POST["DerechoAdol"]) && !empty($_POST["DerechoAdol"])){  
				$modeloVerifDerechos->attributes=$derechosAdol["DerechoAdol"];
				if($modeloVerifDerechos->validate()){
					$modeloVerifDerechos->atributos=$derechosAdol["DerechoAdol"];
					$resultado=$modeloVerifDerechos->modVerifDerAdol();
					$modeloForjarAdol=new ForjarAdol();		
					$modeloForjarAdol->num_doc=$modeloVerifDerechos->num_doc;
					$modeloForjarAdol->id_estado_adol=2;
					$resultado=$modeloForjarAdol->cambiaEstadoAdol();
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>'exito','msnError'=>$modeloVerifDerechos->msnErrorDerecho));
				}
				else{
					echo CActiveForm::validate($modeloVerifDerechos);
				}
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function performAjaxValidation($formId,$model){
		if(isset($_POST['ajax']) && $_POST['ajax']===$formId){
			if(Yii::app()->request->isAjaxRequest){
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
		}
	}
}