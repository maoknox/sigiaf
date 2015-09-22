<?php
Yii::import('application.modules.modIdenReg.models.ForjarAdol');	

class PaiController extends Controller{
	public function filterEnforcelogin($filterChain){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403,"Debe loguearse primero");
		}
		$filterChain->run();
	}
	
	public function filters(){
		$datosInput=Yii::app()->input->post();
		if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
			$numDocAdol=$datosInput["numDocAdol"];
			Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
		}
		else{
			$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
		}
		return array(
			'enforcelogin',
			array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()),
			array('application.filters.ActionVerifEstadoFilter + actualizarPAI','num_doc'=>Yii::app()->getSession()->get('numDocAdol'))
		);
	}
	
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionCrearModificarPAI(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="crearModificarPAI";
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
				$modeloForjarAdol=new ForjarAdol();
				$modeloForjarAdol->num_doc=$numDocAdol;
				$estadoAdol=$modeloForjarAdol->consultaDatosForjarAdol();	
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));			
				$consultaGeneral->numDocAdol=$numDocAdol;
	
				if($estadoAdol["id_estado_adol"]==2){
					Yii::app()->user->setFlash('verifEstadoAdolForjar', "El adolescente está en este momento egresado del servicio.");									
				}
				else{
					$modeloPAI=new Pai();
					$modeloVerifDerechos=new DerechoAdol();			
					$modeloCompDer=new ComponenteDerecho();
					$modeloCompSanc=new ComponenteSancion();
					$modeloInfJud=new InformacionJudicial();
					$operaciones=new OperacionesGenerales();
					$modeloSegComDer=new SeguimientoCompderecho();
					$modeloSegComSanc=new SeguimientoCompsancion();
					$conceptoInt=$consultaGeneral->consultaConcInt();//Consulta el concepto integral
					$derechos=$consultaGeneral->consultaDerechos();
					$modeloPAI->num_doc=$numDocAdol;
					$paiActual=$modeloPAI->consultaPAIActual();
					$modeloPAI->attributes=$paiActual;
					if(empty($paiActual)){
						$pai=$modeloPAI->consultaPAI();
						if(empty($pai)){
							$modeloPAI->id_pai=1;
						}
						else{				
							$modeloPAI->estadoPaiActual();
							$modeloPAI->id_pai=(int)$pai["id_pai"]+1;
						}
						$modeloPAI->creaPAI();
					}
					$idPai=$modeloPAI->id_pai;
					$modeloCompDer->id_pai=$idPai;
					$modeloCompSanc->id_pai=$idPai;
					//consulta Participación
					$participacion=$consultaGeneral->consultaParticipacion();
					//consulta Protección
					$proteccion=$consultaGeneral->consultaProteccion();
					$idInstanciaDer=1;
					$consultaDerechoAdol=$modeloVerifDerechos->findAll('num_doc=:numDoc and id_instanciader=:id_instanciader',
						array(
						':numDoc'=>$numDocAdol,
						':id_instanciader'=>$idInstanciaDer
						)
					);
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
					//$compSancInfJud="";
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
				}
			}
			$this->render('_creaModifPai',array(
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
				'consultaGeneral'=>$consultaGeneral
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionCreaDerPai(){
		$dataInput=Yii::app()->input->post();
		if(!isset($dataInput["ComponenteDerecho"]["id_pai"])&&empty($dataInput["ComponenteDerecho"]["id_pai"])||!isset($dataInput["ComponenteDerecho"]["id_derechocespa"])&&empty($dataInput["ComponenteDerecho"]["id_derechocespa"])){
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
		}
		else{
			$modeloCompDer=new ComponenteDerecho();
			$modeloCompDer->attributes=$dataInput["ComponenteDerecho"];
			if($modeloCompDer->validate()){
				$resultado=$modeloCompDer->creaDerechoPai();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado)),'fechaRegPai'=>CHtml::encode($modeloCompDer->fecha_estab_compderecho)));
			}
			else{
				echo CActiveForm::validate($modeloCompDer);
			}
			//echo $dataInput["ComponenteDerecho"]["id_pai"]." ".$dataInput["ComponenteDerecho"]["id_derechocespa"];
		}
	}
	public function actionModificaRegPai(){
		$dataInput=Yii::app()->input->post();
		if(!isset($dataInput["ComponenteDerecho"]["id_pai"])&&empty($dataInput["ComponenteDerecho"]["id_pai"])||!isset($dataInput["ComponenteDerecho"]["id_derechocespa"])&&empty($dataInput["ComponenteDerecho"]["id_derechocespa"])||!isset($dataInput["ComponenteDerecho"]["fecha_estab_compderecho"])&&empty($dataInput["ComponenteDerecho"]["fecha_estab_compderecho"])){
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
		}
		else{
			$modeloCompDer=new ComponenteDerecho();
			$modeloCompDer->attributes=$dataInput["ComponenteDerecho"];
			if($modeloCompDer->validate()){
				$modeloCompDer->id_pai=$dataInput["ComponenteDerecho"]["id_pai"];
				$modeloCompDer->id_derechocespa=$dataInput["ComponenteDerecho"]["id_derechocespa"];
				$modeloCompDer->fecha_estab_compderecho=$dataInput["ComponenteDerecho"]["fecha_estab_compderecho"];
				$derechoAdolPai=$modeloCompDer->consultaPaiDerechoAdol();
				$modeloCompDer->attributes=$derechoAdolPai;
				if(!empty($dataInput["ComponenteDerecho"]["derecho_compderecho"])){
					if($dataInput["ComponenteDerecho"]["derecho_compderecho"]!==$modeloCompDer->derecho_compderecho){
						$resultado=$modeloCompDer->modificaRegPai("derecho_compderecho",$dataInput["ComponenteDerecho"]["derecho_compderecho"]);
					}
				}
				if(!empty($dataInput["ComponenteDerecho"]["objetivo_compderecho"])){
					if($dataInput["ComponenteDerecho"]["objetivo_compderecho"]!==$modeloCompDer->objetivo_compderecho){
						$resultado=$modeloCompDer->modificaRegPai("objetivo_compderecho",$dataInput["ComponenteDerecho"]["objetivo_compderecho"]);
					}
				}
				if(!empty($dataInput["ComponenteDerecho"]["actividades_compderecho"])){
					if($dataInput["ComponenteDerecho"]["actividades_compderecho"]!==$modeloCompDer->actividades_compderecho){
						$resultado=$modeloCompDer->modificaRegPai("actividades_compderecho",$dataInput["ComponenteDerecho"]["actividades_compderecho"]);
					}
				}
				if(!empty($dataInput["ComponenteDerecho"]["indicadores_compderecho"])){
					if($dataInput["ComponenteDerecho"]["indicadores_compderecho"]!==$modeloCompDer->indicadores_compderecho){
						$resultado=$modeloCompDer->modificaRegPai("indicadores_compderecho",$dataInput["ComponenteDerecho"]["indicadores_compderecho"]);
					}
				}
				if(!empty($dataInput["ComponenteDerecho"]["responsable_compderecho"])){
					if($dataInput["ComponenteDerecho"]["responsable_compderecho"]!==$modeloCompDer->responsable_compderecho){
						$resultado=$modeloCompDer->modificaRegPai("responsable_compderecho",$dataInput["ComponenteDerecho"]["responsable_compderecho"]);
					}
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloCompDer);
			}
			//echo $dataInput["ComponenteDerecho"]["id_pai"]." ".$dataInput["ComponenteDerecho"]["id_derechocespa"];
		}
		
	}
	public function actionCreaRegPaiSanc(){
		$dataInput=Yii::app()->input->post();
		if(!isset($dataInput["ComponenteSancion"]["id_pai"])&&empty($dataInput["ComponenteSancion"]["id_pai"])||!isset($dataInput["ComponenteSancion"]["id_inf_judicial"])&&empty($dataInput["ComponenteSancion"]["id_inf_judicial"])){
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
		}
		else{
			$modeloCompSanc=new ComponenteSancion();
			$modeloCompSanc->attributes=$dataInput["ComponenteSancion"];
			if($modeloCompSanc->validate()){
				$resultado=$modeloCompSanc->creaSancionPai();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado)),'fechaRegPaiSanc'=>CHtml::encode($modeloCompSanc->fecha_establec_compsanc)));
			}
			else{
				echo CActiveForm::validate($modeloCompSanc);
			}
			//echo $dataInput["ComponenteDerecho"]["id_pai"]." ".$dataInput["ComponenteDerecho"]["id_derechocespa"];
		}
	}
	public function actionModificaRegPaiSanc(){
		$dataInput=Yii::app()->input->post();
		//print_r($dataInput);
		if(!isset($dataInput["ComponenteSancion"]["id_pai"])&&empty($dataInput["ComponenteSancion"]["id_pai"])||!isset($dataInput["ComponenteSancion"]["id_inf_judicial"])&&empty($dataInput["ComponenteSancion"]["id_inf_judicial"])||!isset($dataInput["ComponenteSancion"]["fecha_establec_compsanc"])&&empty($dataInput["ComponenteSancion"]["fecha_establec_compsanc"])){
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
		}
		else{
			$modeloCompSanc=new ComponenteSancion();
			$modeloCompSanc->attributes=$dataInput["ComponenteSancion"];
			if($modeloCompSanc->validate()){				
				$sancAdolPai=$modeloCompSanc->consultaPaiSancAdol();
				$modeloCompSanc->attributes=$sancAdolPai;
				$modeloCompSanc->id_pai=$dataInput["ComponenteSancion"]["id_pai"];
				$modeloCompSanc->id_inf_judicial=$dataInput["ComponenteSancion"]["id_inf_judicial"];
				$modeloCompSanc->fecha_establec_compsanc=$dataInput["ComponenteSancion"]["fecha_establec_compsanc"];
				if(!empty($dataInput["ComponenteSancion"]["objetivo_compsanc"])){
					if($dataInput["ComponenteSancion"]["objetivo_compsanc"]!==$sancAdolPai["objetivo_compsanc"]){
						$resultado=$modeloCompSanc->modificaRegPaiSanc("objetivo_compsanc",$dataInput["ComponenteSancion"]["objetivo_compsanc"]);
					}
				}
				if(!empty($dataInput["ComponenteSancion"]["actividades_compsanc"])){
					if($dataInput["ComponenteSancion"]["actividades_compsanc"]!==$modeloCompSanc->actividades_compsanc){
						$resultado=$modeloCompSanc->modificaRegPaiSanc("actividades_compsanc",$dataInput["ComponenteSancion"]["actividades_compsanc"]);
					}
				}
				if(!empty($dataInput["ComponenteSancion"]["indicador_compsanc"])){
					if($dataInput["ComponenteSancion"]["indicador_compsanc"]!==$modeloCompSanc->indicador_compsanc){
						$resultado=$modeloCompSanc->modificaRegPaiSanc("indicador_compsanc",$dataInput["ComponenteSancion"]["indicador_compsanc"]);
					}
				}
				if(!empty($dataInput["ComponenteSancion"]["responsable_compsancion"])){
					if($dataInput["ComponenteSancion"]["responsable_compsancion"]!==$modeloCompSanc->responsable_compsancion){
						$resultado=$modeloCompSanc->modificaRegPaiSanc("responsable_compsancion",$dataInput["ComponenteSancion"]["responsable_compsancion"]);
					}
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloCompSanc);
			}
			//echo $dataInput["ComponenteDerecho"]["id_pai"]." ".$dataInput["ComponenteDerecho"]["id_derechocespa"];
		}
		
	}
public function actionRegSegPaiDer(){
		$dataInput=Yii::app()->input->post();
			if(!isset($dataInput["SeguimientoCompderecho"]["id_pai"])&&empty($dataInput["SeguimientoCompderecho"]["id_pai"])||!isset($dataInput["SeguimientoCompderecho"]["id_derechocespa"])&&empty($dataInput["SeguimientoCompderecho"]["id_derechocespa"])||!isset($dataInput["SeguimientoCompderecho"]["fecha_estab_compderecho"])&&empty($dataInput["SeguimientoCompderecho"]["fecha_estab_compderecho"])){
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
		}
		else{
			$modeloSegCompDer=new SeguimientoCompderecho();
			$modeloSegCompDer->attributes=$dataInput["SeguimientoCompderecho"];
			$modeloSegCompDer->fecha_estab_compderecho=$dataInput["SeguimientoCompderecho"]["fecha_estab_compderecho"];
			if($modeloSegCompDer->validate()){
				$resultado=$modeloSegCompDer->regSegSancionPai();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
			else{
				echo CActiveForm::validate($modeloSegCompDer);
			}
			//echo $dataInput["ComponenteDerecho"]["id_pai"]." ".$dataInput["ComponenteDerecho"]["id_derechocespa"];
		}
	}
	public function actionRegSegPaiSanc(){
		$dataInput=Yii::app()->input->post();
			if(!isset($dataInput["SeguimientoCompsancion"]["id_pai"])&&empty($dataInput["SeguimientoCompsancion"]["id_pai"])||!isset($dataInput["SeguimientoCompsancion"]["id_inf_judicial"])&&empty($dataInput["SeguimientoCompsancion"]["id_inf_judicial"])||!isset($dataInput["SeguimientoCompsancion"]["fecha_establec_compsanc"])&&empty($dataInput["SeguimientoCompsancion"]["fecha_establec_compsanc"])){
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
		}
		else{
			$modeloSegComSanc=new SeguimientoCompsancion();
			$modeloSegComSanc->attributes=$dataInput["SeguimientoCompsancion"];
			//$modeloSegComSanc->fecha_establec_compsanc=$dataInput["SeguimientoCompderecho"]["fecha_establec_compsanc"];
			if($modeloSegComSanc->validate()){
				$modeloSegComSanc->fecha_establec_compsanc=$dataInput["SeguimientoCompsancion"]["fecha_establec_compsanc"];
				$resultado=$modeloSegComSanc->regSegSancionPai();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
			else{
				echo CActiveForm::validate($modeloSegComSanc);
			}
			//echo $dataInput["ComponenteDerecho"]["id_pai"]." ".$dataInput["ComponenteDerecho"]["id_derechocespa"];
		}
	}
	
	public function actionRegCulmPai(){
		$dataInput=Yii::app()->input->post();
		if(isset($dataInput["Pai"]["num_doc"])&&!empty($dataInput["Pai"]["num_doc"]) ||isset($dataInput["Pai"]["id_pai"])&&!empty($dataInput["Pai"]["id_pai"]) ||isset($dataInput["Pai"]["recomend_posegreso"])&&!empty($dataInput["Pai"]["recomend_posegreso"])){
			$modeloPAI=new Pai();
			$modeloPAI->attributes=$dataInput["Pai"];
			//print_r($modeloPAI->attributes);
			if($modeloPAI->validate()){
				$resultado=$modeloPAI->regCulmPai();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloPAI);
			}
		}
	}
	public function actionActualizarPAI(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="actualizarPAI";
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
				$modeloPAI=new Pai();
				$modeloVerifDerechos=new DerechoAdol();			
				$modeloCompDer=new ComponenteDerecho();
				$modeloCompSanc=new ComponenteSancion();
				$modeloInfJud=new InformacionJudicial();
				$operaciones=new OperacionesGenerales();
				$modeloSegComDer=new SeguimientoCompderecho();
				$modeloSegComSanc=new SeguimientoCompsancion();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));			
				$consultaGeneral->numDocAdol=$numDocAdol;
				$conceptoInt=$consultaGeneral->consultaConcInt();//Consulta el concepto integral
				$derechos=$consultaGeneral->consultaDerechos();
				$modeloPAI->num_doc=$numDocAdol;
				$pai=$modeloPAI->consultaPAIActual();
				$modeloPAI->attributes=$pai;
				if(empty($pai)){
					$modeloPAI->id_pai="";
				}
				$idPai=$modeloPAI->id_pai;
				$modeloCompDer->id_pai=$idPai;
				$modeloCompSanc->id_pai=$idPai;
				//consulta Participación
				$participacion=$consultaGeneral->consultaParticipacion();
				//consulta Protección
				$proteccion=$consultaGeneral->consultaProteccion();
				$idInstanciaDer=1;
				$consultaDerechoAdol=$modeloVerifDerechos->findAll('num_doc=:numDoc and id_instanciader=:id_instanciader',
					array(
					':numDoc'=>$numDocAdol,
					':id_instanciader'=>$idInstanciaDer
					)
				);
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
				$modeloPAI->attributes=$infJudicial;
			}
			$this->render('_actualizaPai',array(
				'pai'=>$pai,
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
				'infJudicial'=>$infJudicial,
				'tipoSancion'=>$tipoSancion,
				'infJudicialPai'=>$infJudicialPai,
				'modeloSegComDer'=>$modeloSegComDer,
				'modeloSegComSanc'=>$modeloSegComSanc,
				'consultaDerechoAdol'=>$consultaDerechoAdol,
				'consultaGeneral'=>$consultaGeneral
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}