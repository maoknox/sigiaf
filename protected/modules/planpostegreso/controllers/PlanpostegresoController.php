<?php
Yii::import('application.modules.modIdenReg.models.ForjarAdol');	
class PlanpostegresoController extends Controller{
	public function filterEnforcelogin($filterChain){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403,"Debe loguearse primero");
		}
		$filterChain->run();
	}
	
	public function filters(){
		return array('enforcelogin',array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()));
	}
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
					Yii::app()->user->setFlash('verifderechoegreso', "Debe primero realizar la verificación de derechos antes de realizar el plan post-egreso");									
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
				'consultaDerechoAdol'=>$consultaDerechoAdol
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
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