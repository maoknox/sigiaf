<?php
Yii::import('application.modules.modIdenReg.models.ForjarAdol');	

class ValoracionIntegralController extends Controller{
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
		$datosInput=Yii::app()->input->post();
		if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
			$numDocAdol=$datosInput["numDocAdol"];
			Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
		}
		else{
			$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
		}
		return array(//ActionVerifEstadoFilter
			'enforcelogin',
			array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()),
			array('application.filters.ActionVerifEstadoFilter + valoracionPsicolForm conceptoIntegral valoracionTrSocForm valoracionTOForm valoracionEnfForm valoracionPsiqForm valoracionNutrForm perfilOcupacionalForm','num_doc'=>Yii::app()->getSession()->get('numDocAdol'))
		);
	}
	
	
	public function actionIndex(){
		$this->render('index');
	}
	
	/**
	 *	Acción que renderiza la vista que contiene el formulario para el diligenciamiento o consulta de la valoracion en psicología.
	 *
	 *	Vista a renderizar:
	 *		- _valoracionPsicolForm 
	 *		- _valoracionPsicolFormCons.
	 *	 
	 *	Vistas relacionadas
	 *		- _valoracionPsicolTab
	 *		- _valoracionSusPsicoActTab
	 *		- _valoracionConcPlanIntPsicolTab
	 *		- _valoracionEstadoValPsicolTab
	 *		- _valoracionPsicolTabCons
	 *		- _valoracionSusPsicoActCons
	 *		- _valoracionConcPlanIntPsicolCons
	 *		- _valoracionEstadoValPsicolCons.
	 *	 
	 *	Modelos instanciados: //             
	 *		- ForjarAdol
	 * 		- OperacionesGenerales
	 * 		- ConsultasGenerales
	 * 		- ValoracionPsicologia
	 * 		- DerechoAdol.
	 *
	 *	@param string 	$numDocAdol,	
	 *	@param array 	$datosAdol,
	 *	@param string 	$formularioCargaDerechos,
	 *	@param object 	$modeloVerifDerechos,
	 *	@param array 	$derechos,
	 *	@param array 	$participacion,
	 *	@param array 	$proteccion,
	 *	@param object 	$modeloValPsicol,
	 *	@param id	 	$idValPsicol,
	 *	@param array 	$consDelitoVinc,
	 *	@param array 	$delitos,
	 *	@param array 	$sancionImp,
	 *	@param int	 	$edad,
	 *	@param array 	$tipoSpa,
	 *	@param array 	$viaAdmon,
	 *	@param array 	$frecUso,
	 *	@param array 	$consConsumoSPA,
	 *	@param array 	$patronCons,
	 *	@param boolean 	$estadoCompVal,
	 *	@param int	 	$estadoAdol
	 */		
	public function actionValoracionPsicolForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsicolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloValPsicol=new ValoracionPsicologia();
			$modeloVerifDerechos=new DerechoAdol();		
			$consGen=new ConsultasGenerales();
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$modeloForjarAdol=new ForjarAdol(); // ForjarAdol OperacionesGenerales ConsultasGenerales ValoracionPsicologia DerechoAdol
				$modeloForjarAdol->num_doc=$numDocAdol;
				$estadoAdol=$modeloForjarAdol->consultaDatosForjarAdol();								
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloValPsicol->num_doc=$numDocAdol;
				$valPsicol=$modeloValPsicol->consultaIdValPsicol();
				
				$modeloValPsicol->attributes=$valPsicol;
				if(empty($valPsicol)){
					$idValPsicol=$modeloValPsicol->creaRegValPsicol();
				}
				else{
					$idValPsicol=$valPsicol["id_valoracion_psicol"];
				}
				$modeloValPsicol->id_valoracion_psicol=$idValPsicol;
				$consDelitoVinc=$modeloValPsicol->consultaDelitoVinc();
				$consConsumoSPA=$modeloValPsicol->consultaConsumoSPA();
				$delitos=$consGen->consutlaDelito();
				$sancionImp=$consGen->consutlaTipoSancion();
				$estadoCompVal=$consGen->consutlaEstadoCompVal();
				$tipoSpa=$consGen->consutlaTipoSpa();
				$viaAdmon=$consGen->consutlaViaAdmon();
				$patronCons=$consGen->consutlaPatronConsumo();
				$frecUso=$consGen->frecuanciaUso();
				$derechos=$consultaGeneral->consultaDerechos();
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
				if(!$consultaDerechoAdol){
					$formularioCargaDerechos="_formVerificacionDerForjar";
				}
				else{
					$formularioCargaDerechos="_formVerificacionDerForjarMod";//_formVerificacionDerForjarCons
				}
				if(!empty($modeloValPsicol->fecha_iniciovalpsicol)){
					$consultaGeneral->numDocAdol=$numDocAdol;
					$tiempoAct=$consultaGeneral->consultaTiempoActuacion();
					$dias	= (strtotime($modeloValPsicol->fecha_iniciovalpsicol)-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if($dias<=$tiempoAct["tiempo_valoraciones"]){
						$formRender="_valoracionPsicolForm";
					}
					else{
						$consultaValHab=$modeloValPsicol->consValHab();
						if(empty($consultaValHab["val_hab_ps"])){
							$formRender="_valoracionPsicolFormCons";
							$formularioCargaDerechos="_formVerificacionDerForjarCons";
						}
						else{						
							$formRender="_valoracionPsicolForm";
							$modeloValPsicol->modValHabFalse();
						}
					}
				}
				else{
					$formRender="_valoracionPsicolForm";
				}
			}	
			else{
				$formRender="_valoracionPsicolFormCons";
			}
			
			$this->render($formRender,array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'formularioCargaDerechos'=>$formularioCargaDerechos,
				'modeloVerifDerechos'=>$modeloVerifDerechos,
				'derechos'=>$derechos,
				'participacion'=>$participacion,
				'proteccion'=>$proteccion,
				'modeloValPsicol'=>$modeloValPsicol,
				'idValPsicol'=>$idValPsicol,
				'consDelitoVinc'=>$consDelitoVinc,
				'delitos'=>$delitos,
				'sancionImp'=>$sancionImp,
				'edad'=>$edad,
				'tipoSpa'=>$tipoSpa,
				'viaAdmon'=>$viaAdmon,
				'frecUso'=>$frecUso,
				'consConsumoSPA'=>$consConsumoSPA,
				'patronCons'=>$patronCons,
				'estadoCompVal'=>$estadoCompVal,
				'render'=>'valoracionPsicolForm',
				'estadoAdol'=>$estadoAdol
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Acción que renderiza la vista que contiene el formulario de consulta de la valoracion en psicología.
	 *
	 *	Vista a renderizar:
	 *		- _valoracionPsicolFormCons
	 *
	 *	Modelos instanciados: //             
	 *		- ForjarAdol
	 * 		- OperacionesGenerales
	 * 		- ConsultasGenerales
	 * 		- ValoracionPsicologia
	 * 		- DerechoAdol
	 *
	 *	@param string 	$numDocAdol,	
	 *	@param array 	$datosAdol,
	 *	@param string 	$formularioCargaDerechos,
	 *	@param object 	$modeloVerifDerechos,
	 *	@param array 	$derechos,
	 *	@param array 	$participacion,
	 *	@param array 	$proteccion,
	 *	@param object 	$modeloValPsicol,
	 *	@param id	 	$idValPsicol,
	 *	@param array 	$consDelitoVinc,
	 *	@param array 	$delitos,
	 *	@param array 	$sancionImp,
	 *	@param int	 	$edad,
	 *	@param array 	$tipoSpa,
	 *	@param array 	$viaAdmon,
	 *	@param array 	$frecUso,
	 *	@param array 	$consConsumoSPA,
	 *	@param array 	$patronCons,
	 *	@param boolean 	$estadoCompVal,
	 *	@param int	 	$estadoAdol
	 */		
	public function actionConsultaValPsic(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultaValPsic";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloValPsicol=new ValoracionPsicologia();
			$modeloVerifDerechos=new DerechoAdol();		
			$consGen=new ConsultasGenerales();
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
				$modeloValPsicol->num_doc=$numDocAdol;
				$valPsicol=$modeloValPsicol->consultaIdValPsicol();
				$modeloValPsicol->attributes=$valPsicol;
				if(empty($valPsicol)){
					$idValPsicol=$modeloValPsicol->creaRegValPsicol();
				}
				else{
					$idValPsicol=$valPsicol["id_valoracion_psicol"];
				}
				$modeloValPsicol->id_valoracion_psicol=$idValPsicol;
				$consDelitoVinc=$modeloValPsicol->consultaDelitoVinc();
				$consConsumoSPA=$modeloValPsicol->consultaConsumoSPA();
				$delitos=$consGen->consutlaDelito();
				$sancionImp=$consGen->consutlaTipoSancion();
				$estadoCompVal=$consGen->consutlaEstadoCompVal();
				$tipoSpa=$consGen->consutlaTipoSpa();
				$viaAdmon=$consGen->consutlaViaAdmon();
				$patronCons=$consGen->consutlaPatronConsumo();
				$frecUso=$consGen->frecuanciaUso();
				$derechos=$consultaGeneral->consultaDerechos();
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
			}				
			$this->render('_valoracionPsicolFormCons',array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'formularioCargaDerechos'=>'_formVerificacionDerForjarCons',
				'modeloVerifDerechos'=>$modeloVerifDerechos,
				'derechos'=>$derechos,
				'participacion'=>$participacion,
				'proteccion'=>$proteccion,
				'modeloValPsicol'=>$modeloValPsicol,
				'idValPsicol'=>$idValPsicol,
				'consDelitoVinc'=>$consDelitoVinc,
				'delitos'=>$delitos,
				'sancionImp'=>$sancionImp,
				'edad'=>$edad,
				'tipoSpa'=>$tipoSpa,
				'viaAdmon'=>$viaAdmon,
				'frecUso'=>$frecUso,
				'consConsumoSPA'=>$consConsumoSPA,
				'patronCons'=>$patronCons,
				'estadoCompVal'=>$estadoCompVal,
				'render'=>'consultaValPsic'
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario de vinculación previa al srpa e instancia a modelo para registrar la información de srpa.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionPsicologia
	 *
	 *	@param array $dataInput	de datos del formulario vinculaciónes previas al srpa.
	 *	@param string $modeloValPsicol->msnValPsicol.
	 *	@return json resultado de la transacción.
	 */		
	public function actionCreaVincPrevSrpa(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsicolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			$modeloValPsicol=new ValoracionPsicologia();
			if(empty($dataInput["numDocAdolValPsicol"])&&empty($dataInput["idValPsicol"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$modeloValPsicol->num_doc=$dataInput["numDocAdolValPsicol"];
				$modeloValPsicol->id_valoracion_psicol=$dataInput["idValPsicol"];
				$modeloValPsicol->idDelRc=$dataInput["delito"];
				$modeloValPsicol->medidaIntPrev=$dataInput["intPrev"];
				$modeloValPsicol->sancImp=$dataInput["sancion"];
				$modeloValPsicol->idTipoSancion=$dataInput["tipoSancion"];
				$modeloValPsicol->msnValPsicol=$modeloValPsicol->creaVincPrevSrpa();
				//$modeloValPsicol->idCasoDelito;
				if($modeloValPsicol->msnValPsicol=="exito"){
					$valPsicol=$modeloValPsicol->consultaIdValPsicol();
					if(empty($valPsicol["fecha_iniciovalpsicol"])){
						$modeloValPsicol->campoFecha="fecha_iniciovalpsicol";
						$modeloValPsicol->fecha=date("Y-m-d");
						$accion=1;
					}
					else{
						$modeloValPsicol->campoFecha="fecha_modifvalpsic";
						$modeloValPsicol->fecha=date("Y-m-d");
						$accion=2;
					}
					
					$modeloValPsicol->modFechaActuacion($accion);
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($modeloValPsicol->msnValPsicol)),'idcasodelito'=>CHtml::encode($modeloValPsicol->idCasoDelito)));
			}
			//print_r($dataInput); 
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}	
	/**
	 *	Recibe datos del formulario de vinculación previa al srpa e instancia a modelo para modificar la información de srpa.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionPsicologia
	 *
	 *	@param array $dataInput	de datos del formulario vinculaciónes previas al srpa.
	 *	@param string $modeloValPsicol->msnValPsicol.
	 *	@return json resultado de la transacción.
	 */		
	public function actionModificaVincPrevSrpa(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsicolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["numDocAdolValPsicol"])&&empty($dataInput["idValPsicol"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$modeloValPsicol=new ValoracionPsicologia();
				$modeloValPsicol->num_doc=$dataInput["numDocAdolValPsicol"];
				$modeloValPsicol->id_valoracion_psicol=$dataInput["idValPsicol"];
				$modeloValPsicol->idDelRc=$dataInput["delito"];
				$modeloValPsicol->medidaIntPrev=$dataInput["intPrev"];
				$modeloValPsicol->sancImp=$dataInput["sancion"];
				$modeloValPsicol->idTipoSancion=$dataInput["tipoSancion"];
				$modeloValPsicol->idCasoDelito=$dataInput["idVincPrSrpa"];
				$modeloValPsicol->msnValPsicol=$modeloValPsicol->modificaVincPrevSrpa();
				if($modeloValPsicol->msnValPsicol=="exito"){
					$valPsicol=$modeloValPsicol->consultaIdValPsicol();
					if(empty($valPsicol["fecha_iniciovalpsicol"])){
						$modeloValPsicol->campoFecha="fecha_iniciovalpsicol";
						$modeloValPsicol->fecha=date("Y-m-d");
						$accion=1;
					}
					else{
						$modeloValPsicol->campoFecha="fecha_modifvalpsic";
						$modeloValPsicol->fecha=date("Y-m-d");
						$accion=2;
					}
					$modeloValPsicol->modFechaActuacion($accion);
				}				
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($modeloValPsicol->msnValPsicol))));
			}
			//print_r($dataInput); 	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario de consumo de sustancias psicoactivas e instancia a modelo para modificar estado.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionPsicologia
	 *
	 *	@param array $dataInput	de datos del formulario de verificación de consumo de sustancias psicoactivas.
	 *	@param string $modeloValPsicol->msnValPsicol.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionModConsSpa(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsicolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(isset($_POST["consSpa"])&&!empty($_POST["consSpa"])&&isset($_POST["idValPsic"])&&!empty($_POST["idValPsic"])&&isset($_POST["numDocAdolValPsicol"])&&!empty($_POST["numDocAdolValPsicol"])){
				$modeloValPsicol=new ValoracionPsicologia();
				$modeloValPsicol->num_doc=$dataInput["numDocAdolValPsicol"];
				$modeloValPsicol->id_valoracion_psicol=$dataInput["idValPsic"];
				$modeloValPsicol->consumo_spa=$dataInput["consSpa"];
				$resultado=$modeloValPsicol->modEstadoConsSpa();
				if($resultado=="exito"){
					$valPsicol=$modeloValPsicol->consultaIdValPsicol();
					if(empty($valPsicol["fecha_iniciovalpsicol"])){
						$modeloValPsicol->campoFecha="fecha_iniciovalpsicol";
						$modeloValPsicol->fecha=date("Y-m-d");
						$accion=1;
					}
					else{
						$modeloValPsicol->campoFecha="fecha_modifvalpsic";
						$modeloValPsicol->fecha=date("Y-m-d");
						$accion=2;
					}
					$modeloValPsicol->modFechaActuacion($accion);
				}	
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la modificación"))));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	/**
	 *	Recibe datos del formulario de consumo de sustancias psicoactivas e instancia a modelo para crear registro de consumo.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionPsicologia
	 *
	 *	@param array $dataInput	de datos del formulario de verificación de consumo de sustancias psicoactivas.
	 *	@param string $modeloValPsicol->msnValPsicol.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionCreaConsSpa(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsicolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["numDocAdolValPsicol"])&&empty($dataInput["idValPsicol"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$modeloValPsicol=new ValoracionPsicologia();	
				$modeloValPsicol->num_doc=$dataInput["numDocAdolValPsicol"];
				$modeloValPsicol->id_valoracion_psicol=$dataInput["idValPsicol"];
				$modeloValPsicol->tipo_spa=$dataInput["spa"];
				$modeloValPsicol->frec_uso=$dataInput["frecUso"];
				$modeloValPsicol->cons_ult_anio=$dataInput["consAnio"];
				$modeloValPsicol->via_admon=explode(",",$dataInput["viaAdmon"]);
				$modeloValPsicol->edad_ini=$dataInput["edadIni"];
				$modeloValPsicol->edad_fin=$dataInput["edadFin"];
				$modeloValPsicol->spa_may_imp=$dataInput["spaMayImp"];
				$modeloValPsicol->motivos_cons=$dataInput["motivoConsSPA"];
				$modeloValPsicol->spa_ini=$dataInput["spaInicio"];
				$modeloValPsicol->msnValPsicol=$modeloValPsicol->creaConsSpa();	
				if($modeloValPsicol->msnValPsicol=="exito"){
					$valPsicol=$modeloValPsicol->consultaIdValPsicol();
					if(empty($valPsicol["fecha_iniciovalpsicol"])){
						$modeloValPsicol->campoFecha="fecha_iniciovalpsicol";
						$modeloValPsicol->fecha=date("Y-m-d");
						$accion=1;
					}
					else{
						$modeloValPsicol->campoFecha="fecha_modifvalpsic";
						$modeloValPsicol->fecha=date("Y-m-d");
						$accion=2;
					}
					$modeloValPsicol->modFechaActuacion($accion);
				}			
				echo CJSON::encode(
					array("estadoComu"=>"exito",
						'resultado'=>CJavaScript::encode(CJavaScript::quote($modeloValPsicol->msnValPsicol)),
						'idConsSpa'=>$modeloValPsicol->idConsSpa
					)
				);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario de consumo de sustancias psicoactivas e instancia a modelo para modificar registro de consumo.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionPsicologia
	 *
	 *	@param array $dataInput	de datos del formulario de verificación de consumo de sustancias psicoactivas.
	 *	@param string $modeloValPsicol->msnValPsicol.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionModificaConsSPA(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsicolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["numDocAdolValPsicol"])&&empty($dataInput["idValPsicol"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$modeloValPsicol=new ValoracionPsicologia();	
				$modeloValPsicol->num_doc=$dataInput["numDocAdolValPsicol"];
				$modeloValPsicol->id_valoracion_psicol=$dataInput["idValPsicol"];
				$modeloValPsicol->tipo_spa=$dataInput["spa"];
				$modeloValPsicol->frec_uso=$dataInput["frecUso"];
				$modeloValPsicol->cons_ult_anio=$dataInput["consAnio"];
				$modeloValPsicol->via_admon=explode(",",$dataInput["viaAdmon"]);
				$modeloValPsicol->edad_ini=$dataInput["edadIni"];
				$modeloValPsicol->edad_fin=$dataInput["edadFin"];
				$modeloValPsicol->spa_may_imp=$dataInput["spaMayImp"];
				$modeloValPsicol->motivos_cons=$dataInput["motivoConsSPA"];
				$modeloValPsicol->spa_ini=$dataInput["spaInicio"];
				$modeloValPsicol->idConsSpa=$dataInput["idSpaCons"];
				$modeloValPsicol->msnValPsicol=$modeloValPsicol->modificaConsSPA();
				if($modeloValPsicol->msnValPsicol=="exito"){
					$valPsicol=$modeloValPsicol->consultaIdValPsicol();
					if(empty($valPsicol["fecha_iniciovalpsicol"])){
						$modeloValPsicol->campoFecha="fecha_iniciovalpsicol";
						$modeloValPsicol->fecha=date("Y-m-d");
						$accion=1;
					}
					else{
						$modeloValPsicol->campoFecha="fecha_modifvalpsic";
						$modeloValPsicol->fecha=date("Y-m-d");	
						$accion=2;				
					}
					$modeloValPsicol->modFechaActuacion($accion);
				}
				echo CJSON::encode(
					array("estadoComu"=>"exito",
						'resultado'=>CJavaScript::encode(CJavaScript::quote($modeloValPsicol->msnValPsicol)),
					)
				);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de campo en específico de valoración e intancia a modelo para realizar registro y guardar backup de histórico de campo.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionPsicologia
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param string $modeloValPsicol->msnValPsicol.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionModificaValoracionPsicol(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsicolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["numDocAdolValPsicol"])&&empty($dataInput["idValPsicol"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$variables=array_keys($dataInput);			
				$variablesii=array_keys($dataInput[$variables[0]]);
				if(!empty($dataInput["ValoracionPsicologia"][$variablesii[0]])){
					$modeloValPsicol=new ValoracionPsicologia();
					$modeloValPsicol->id_valoracion_psicol=$dataInput["idValPsicol"];
					$modeloValPsicol->num_doc=$dataInput["numDocAdolValPsicol"];
					$valPsicol=$modeloValPsicol->consultaIdValPsicol();
					if($dataInput["ValoracionPsicologia"][$variablesii[0]]!==$valPsicol[$variablesii[0]]){
						$modeloValPsicol->nombreCampoValoracion=$variablesii[0];
						$modeloValPsicol->contenidoValoracion=$dataInput["ValoracionPsicologia"][$variablesii[0]];
						if(empty($valPsicol["fecha_iniciovalpsicol"])){
							$modeloValPsicol->campoFecha="fecha_iniciovalpsicol";
							$modeloValPsicol->fecha=date("Y-m-d");
							$accion=1;
						}
						else{
							$modeloValPsicol->campoFecha="fecha_modifvalpsic";
							$modeloValPsicol->fecha=date("Y-m-d");
							$accion=2;
							if(!empty($valPsicol[$variablesii[0]])){
								$modeloValPsicol->contHist=$valPsicol[$variablesii[0]];
								$modeloValPsicol->regHistoricoValPsic(); 
							}
						}
						$modeloValPsicol->msnValPsicol=$modeloValPsicol->modificaValoracionPsicol($accion); 
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($modeloValPsicol->msnValPsicol))));
					}
					else{
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
					}
				}
				else
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de campo en específico de valoración e intancia a modelo para realizar registro y guardar backup de histórico de campo.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionPsicologia
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param string $modeloValPsicol->msnValPsicol.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionModificaValoracionPsicolOpt(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsicolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["numDocAdolValPsicol"])&&empty($dataInput["idValPsicol"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$variables=array_keys($dataInput);			
				$variablesii=array_keys($dataInput[$variables[0]]);
				if(!empty($dataInput["ValoracionPsicologia"][$variablesii[0]])){
					$modeloValPsicol=new ValoracionPsicologia();
					$modeloValPsicol->id_valoracion_psicol=$dataInput["idValPsicol"];
					$modeloValPsicol->num_doc=$dataInput["numDocAdolValPsicol"];
					$valPsicol=$modeloValPsicol->consultaIdValPsicol();
					if($dataInput["ValoracionPsicologia"][$variablesii[0]]!==$valPsicol[$variablesii[0]] || $dataInput["ValoracionPsicologia"][$variablesii[1]]!==$valPsicol[$variablesii[1]]){
						if(empty($valPsicol["fecha_iniciovalpsicol"])){
							$modeloValPsicol->campoFecha="fecha_iniciovalpsicol";
							$modeloValPsicol->fecha=date("Y-m-d");
							$accion=1;
						}
						else{
							$modeloValPsicol->campoFecha="fecha_modifvalpsic";
							$modeloValPsicol->fecha=date("Y-m-d");
							$accion=2;
						}
						$modeloValPsicol->nombreCampoValoracion=$variablesii[0];
						$modeloValPsicol->contenidoValoracion=$dataInput["ValoracionPsicologia"][$variablesii[0]];
						if($dataInput["ValoracionPsicologia"][$variablesii[0]]!=$valPsicol[$variablesii[0]]){
							if($dataInput["ValoracionPsicologia"][$variablesii[0]]=='false' && empty($valPsicol[$variablesii[0]])){
								
							}
							else{
								if(!empty($valPsicol[$variablesii[0]])){
									$modeloValPsicol->contHist=$valPsicol[$variablesii[0]];
									$modeloValPsicol->regHistoricoValPsic(); 
								}
							}
						}
						if(empty($variablesii[1])){						
							$modeloValPsicol->msnValPsicol=$modeloValPsicol->modificaValoracionPsicol($accion); 
						}
						else{
							$modeloValPsicol->nombreCampoValoracioni=$variablesii[1];
							$modeloValPsicol->contenidoValoracioni=$dataInput["ValoracionPsicologia"][$variablesii[1]];							
							$modeloValPsicol->msnValPsicol=$modeloValPsicol->modificaValoracionPsicolOpt($accion); 
							if($dataInput["ValoracionPsicologia"][$variablesii[1]]!=$valPsicol[$variablesii[1]]){
								if(!empty($valPsicol[$variablesii[1]])){
									$modeloValPsicol->nombreCampoValoracion=$variablesii[1];
									$modeloValPsicol->contHist=$valPsicol[$variablesii[1]];
									$modeloValPsicol->regHistoricoValPsic(); 
								}
							}
						}
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($modeloValPsicol->msnValPsicol))));
					}
					else{
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
					}
				}
				else
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}

	/**
	 *	Acción que renderiza la vista que contiene el formulario para el diligenciamiento o consulta de la valoracion en trabajo social.
	 *
	 *	Vista a renderizar:
	 *		- _valoracionTrSocForm 
	 *		- _valoracionTrSocCons.
	 *	 
	 *	Vistas relacionadas
	 *		- _valoracionTrSocTab
	 *		- _valoracionEscolaridadTab
	 *		- _valoracionConcPlanIntTrSocTab
	 *		- _valoracionEstadoValTrSoc
	 *		- _valoracionTrSocTabCons
	 *		- _valoracionEscolaridadCons
	 *		- _valoracionConcPlanIntTrSocCons
	 *		- _valoracionEstadoValTrSocCons.
	 *	 
	 *	Modelos instanciados:              ConsultasGenerales          
	 *		- ValoracionTrabajoSocial
	 * 		- DerechoAdol
	 * 		- Familiar
	 * 		- Familia
	 * 		- Telefono.
	 * 		- AntFFamilia.
	 * 		- ProblemaValtsocial.
	 * 		- ServprotecValtsocial.
	 * 		- EscolaridadAdolescente.
	 * 		- Adolescente.
	 * 		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 *
	 *	
	 *	@param object 	$modelValTrSoc,
	 *	@param int	 	$idValTrSoc,
	 *	@param array 	$formularioCargaDerechos,
	 *	@param object 	$modeloVerifDerechos,
	 *	@param string 	$numDocAdol,
	 *	@param int	 	$estadoCompVal,
	 *	@param array 	$datosAdol,
	 *	@param int	 	$edad,
	 *	@param array 	$derechos,
	 *	@param array 	$participacion,
	 *	@param array 	$proteccion,
	 *	@param object 	$modeloFamiliar,
	 *	@param array 	$grupoFamiliar,
	 *	@param array 	$otroRef,
	 *	@param array 	$parentesco,
	 *	@param array 	$nivelEduc,
	 *	@param object 	$modeloTelefono,
	 *	@param object 	$modeloEscAdol,
	 *	@param array 	$escolaridadAdol,
	 *	@param array 	$jornadaEduc,
	 *	@param int	 	$estadoEsc,
	 *	@param array 	$munCiudad,
	 *	@param array 	$probAsoc,//problemas asociados al adolescente en la verificación de derechos
	 *	@param array 	$servProt,//servicios de protección
	 *	@param array 	$probAsocAdol,
	 *	@param array 	$servProtAdol,
	 *	@param array 	$antFam,
	 *	@param array 	$antFamAdol,
	 *	@param object 	$modeloFamilia,
	 *	@param array 	$tipoFamilia,
	 *	@param array 	$tipoFamiliaAdol,
	 *	@param object 	$modeloAntFFamilia,
	 *	@param object 	$modeloProblemaValtsocial,
	 *	@param object 	$modeloServprotecValtsocial,
	 *	@param object 	$modeloSgsss,				
	 *	@param array 	$eps,
	 *	@param array 	$regSalud,
	 *	@param array 	$sgs,
	 */		
	public function actionValoracionTrSocForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modelValTrSoc=new ValoracionTrabajoSocial();
			$modeloVerifDerechos=new DerechoAdol();
			$modeloFamiliar=new Familiar();
			$modeloFamilia=new Familia();
			$modeloTelefono=new Telefono();
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$modeloAntFFamilia=new AntFFamilia();
				$modeloProblemaValtsocial=new ProblemaValtsocial();
				$modeloServprotecValtsocial=new ServprotecValtsocial();
				$modeloEscAdol=new EscolaridadAdolescente();
				$modeloAdolescente=new Adolescente();
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				
				$estadoCompVal=$consultaGeneral->consutlaEstadoCompVal();
				//$eps=$consultaGeneral->consultaEntidades('eps_adol','id_eps_adol');
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modelValTrSoc->num_doc=$numDocAdol;
				$modeloFamiliar->num_docAdolFam=$numDocAdol;
				$modeloAdolescente->num_doc=$numDocAdol;
				$datosAdolValtr=$modeloAdolescente->consultaDatosAdolValTrSoc();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$valTrSoc=$modelValTrSoc->consultaIdValTrSoc();
				$modelValTrSoc->attributes=$valTrSoc;
				if(empty($valTrSoc)){
					$idValTrSoc=$modelValTrSoc->creaRegValTrSoc();
				}
				else{
					$idValTrSoc=$valTrSoc["id_valtsoc"];
				}
				$modelValTrSoc->id_valtsoc=$idValTrSoc;
				$antFamAdol=$modelValTrSoc->consAntFamiliares();
				//print_r($antFamAdol);
						//Consulta derechos
				$derechos=$consultaGeneral->consultaDerechos();
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
				if(!$consultaDerechoAdol){
					$formularioCargaDerechos="_formVerificacionDerForjar";
				}
				else{
					$formularioCargaDerechos="_formVerificacionDerForjarMod";
				}
				$grupoFamiliar=$modeloFamiliar->consultaFamiliarAdol();
				$otroRef=$modeloFamiliar->consultaOtrRef();
				$parentesco=$consultaGeneral->consultaEntidades('parentesco','id_parentesco');
				$modeloEscAdol->num_doc=$numDocAdol;
				$escolaridadAdol=$modeloEscAdol->consultaEscolaridad();
				$nivelEduc=$consultaGeneral->consultaEntidades('nivel_educativo','id_nivel_educ');
				$jornadaEduc=$consultaGeneral->consultaEntidades('jornada_educ','id_jornada_educ');
				$estadoEsc=$consultaGeneral->consultaEntidades('estado_escolarizacion','id_estado_escol');
				$probAsoc=$consultaGeneral->consultaEntidades('problemas_asociados','id_problema_asoc');
				$servProt=$consultaGeneral->consultaEntidades('servicios_proteccion','id_serv_protec');
				$antFam=$consultaGeneral->consultaEntidades('antecedentes_familiares','id_ant_fam');
				$probAsocAdol=$modelValTrSoc->consultaProbAsoc($idValTrSoc);
				$servProtAdol=$modelValTrSoc->consultaServProt($idValTrSoc);
				$tipoFamilia=$consultaGeneral->consultaEntidades('tipo_familia','id_tipo_familia');
				$tipoFamiliaAdol=$modelValTrSoc->consultaTipoFamilia();
				$munCiudad=$consultaGeneral->consultaEntidades('municipio','id_municipio');
				//consulta seguridad social				
				$modeloSgsss= new Sgsss();
				$eps=$consultaGeneral->consultaEntidades('eps_adol','id_eps_adol');
				$regSalud=$consultaGeneral->consultaEntidades('regimen_salud','id_regimen_salud');
				$modeloSgsss->num_doc=$numDocAdol;
				$sgs=$modeloSgsss->consultaSegSocial();
				$modeloSgsss->attributes=$sgs;
				if(!empty($modelValTrSoc->fecha_inicio_valtsoc)){
					$consultaGeneral->numDocAdol=$numDocAdol;
					$tiempoAct=$consultaGeneral->consultaTiempoActuacion();
					$dias	= (strtotime($modelValTrSoc->fecha_inicio_valtsoc)-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if($dias<=$tiempoAct["tiempo_valoraciones"]){
						$formRender="_valoracionTrSocForm";
					}
					else{
						$consultaValHab=$modelValTrSoc->consValHabTrSoc();
						if(empty($consultaValHab["val_hab_ts"])){
							$formRender="_valoracionTrSocCons";
							$formularioCargaDerechos="_formVerificacionDerForjarCons";

						}
						else{						
							$formRender="_valoracionTrSocForm";
							$modelValTrSoc->modValHabFalseTrSoc();
						}
					}
				}
				else{
					$formRender="_valoracionTrSocForm";
				}
			}		
			else{
				$formRender="_valoracionTrSocCons";
			}
			$this->render($formRender,array(				
				'modelValTrSoc'=>$modelValTrSoc,
				'idValTrSoc'=>$idValTrSoc,
				'formularioCargaDerechos'=>$formularioCargaDerechos,
				'modeloVerifDerechos'=>$modeloVerifDerechos,
				'numDocAdol'=>$numDocAdol,
				'estadoCompVal'=>$estadoCompVal,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'derechos'=>$derechos,
				'participacion'=>$participacion,
				'proteccion'=>$proteccion,
				'modeloFamiliar'=>$modeloFamiliar,
				'grupoFamiliar'=>$grupoFamiliar,
				'otroRef'=>$otroRef,
				'parentesco'=>$parentesco,
				'nivelEduc'=>$nivelEduc,
				'modeloTelefono'=>$modeloTelefono,
				'modeloEscAdol'=>$modeloEscAdol,
				'escolaridadAdol'=>$escolaridadAdol,
				'jornadaEduc'=>$jornadaEduc,
				'estadoEsc'=>$estadoEsc,
				'munCiudad'=>$munCiudad,
				'probAsoc'=>$probAsoc,//problemas asociados al adolescente en la verificación de derechos
				'servProt'=>$servProt,//servicios de protección
				'probAsocAdol'=>$probAsocAdol,
				'servProtAdol'=>$servProtAdol,
				'antFam'=>$antFam,
				'antFamAdol'=>$antFamAdol,
				'modeloFamilia'=>$modeloFamilia,
				'tipoFamilia'=>$tipoFamilia,
				'tipoFamiliaAdol'=>$tipoFamiliaAdol,
				'modeloAntFFamilia'=>$modeloAntFFamilia,
				'modeloProblemaValtsocial'=>$modeloProblemaValtsocial,
				'modeloServprotecValtsocial'=>$modeloServprotecValtsocial,
				'modeloSgsss'=>$modeloSgsss,				
				'eps'=>$eps,
				'regSalud'=>$regSalud,
				'sgs'=>$sgs,
				'render'=>'valoracionTrSocForm',
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	//consulta valoración en trabajo social.
	
	/**
	 *	Acción que renderiza la vista que contiene el formulario para la consulta de la valoracion en trabajo social.
	 *
	 *	Vista a renderizar:
	 *		- _valoracionTrSocForm 
	 *		- _valoracionTrSocCons.
	 *	 
	 *	Vistas relacionadas
	 *		- _valoracionTrSocTab
	 *		- _valoracionEscolaridadTab
	 *		- _valoracionConcPlanIntTrSocTab
	 *		- _valoracionEstadoValTrSoc
	 *		- _valoracionTrSocTabCons
	 *		- _valoracionEscolaridadCons
	 *		- _valoracionConcPlanIntTrSocCons
	 *		- _valoracionEstadoValTrSocCons.
	 *	 
	 *	Modelos instanciados:              ConsultasGenerales          
	 *		- ValoracionTrabajoSocial
	 * 		- DerechoAdol
	 * 		- Familiar
	 * 		- Familia
	 * 		- Telefono.
	 * 		- AntFFamilia.
	 * 		- ProblemaValtsocial.
	 * 		- ServprotecValtsocial.
	 * 		- EscolaridadAdolescente.
	 * 		- Adolescente.
	 * 		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 *
	 *	
	 *	@param object 	$modelValTrSoc,
	 *	@param int	 	$idValTrSoc,
	 *	@param array 	$formularioCargaDerechos,
	 *	@param object 	$modeloVerifDerechos,
	 *	@param string 	$numDocAdol,
	 *	@param int	 	$estadoCompVal,
	 *	@param array 	$datosAdol,
	 *	@param int	 	$edad,
	 *	@param array 	$derechos,
	 *	@param array 	$participacion,
	 *	@param array 	$proteccion,
	 *	@param object 	$modeloFamiliar,
	 *	@param array 	$grupoFamiliar,
	 *	@param array 	$otroRef,
	 *	@param array 	$parentesco,
	 *	@param array 	$nivelEduc,
	 *	@param object 	$modeloTelefono,
	 *	@param object 	$modeloEscAdol,
	 *	@param array 	$escolaridadAdol,
	 *	@param array 	$jornadaEduc,
	 *	@param int	 	$estadoEsc,
	 *	@param array 	$munCiudad,
	 *	@param array 	$probAsoc,//problemas asociados al adolescente en la verificación de derechos
	 *	@param array 	$servProt,//servicios de protección
	 *	@param array 	$probAsocAdol,
	 *	@param array 	$servProtAdol,
	 *	@param array 	$antFam,
	 *	@param array 	$antFamAdol,
	 *	@param object 	$modeloFamilia,
	 *	@param array 	$tipoFamilia,
	 *	@param array 	$tipoFamiliaAdol,
	 *	@param object 	$modeloAntFFamilia,
	 *	@param object 	$modeloProblemaValtsocial,
	 *	@param object 	$modeloServprotecValtsocial,
	 *	@param object 	$modeloSgsss,				
	 *	@param array 	$eps,
	 *	@param array 	$regSalud,
	 *	@param array 	$sgs,
	 */		
	public function actionConsultaValTrSoc(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultaValTrSoc";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modelValTrSoc=new ValoracionTrabajoSocial();
			$modeloVerifDerechos=new DerechoAdol();
			$modeloFamiliar=new Familiar();
			$modeloFamilia=new Familia();
			$modeloTelefono=new Telefono();
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$modeloAntFFamilia=new AntFFamilia();
				$modeloProblemaValtsocial=new ProblemaValtsocial();
				$modeloServprotecValtsocial=new ServprotecValtsocial();
				$modeloEscAdol=new EscolaridadAdolescente();
				$modeloAdolescente=new Adolescente();
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				
				$estadoCompVal=$consultaGeneral->consutlaEstadoCompVal();
				//$eps=$consultaGeneral->consultaEntidades('eps_adol','id_eps_adol');
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modelValTrSoc->num_doc=$numDocAdol;
				$modeloFamiliar->num_docAdolFam=$numDocAdol;
				$modeloAdolescente->num_doc=$numDocAdol;
				$datosAdolValtr=$modeloAdolescente->consultaDatosAdolValTrSoc();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$valTrSoc=$modelValTrSoc->consultaIdValTrSoc();
				$modelValTrSoc->attributes=$valTrSoc;
				if(empty($valTrSoc)){
					$idValTrSoc=$modelValTrSoc->creaRegValTrSoc();
				}
				else{
					$idValTrSoc=$valTrSoc["id_valtsoc"];
				}
				$modelValTrSoc->id_valtsoc=$idValTrSoc;
				$antFamAdol=$modelValTrSoc->consAntFamiliares();
						//Consulta derechos
				$derechos=$consultaGeneral->consultaDerechos();
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
				//consulta seguridad social				
				$modeloSgsss= new Sgsss();
				$eps=$consultaGeneral->consultaEntidades('eps_adol','id_eps_adol');
				$regSalud=$consultaGeneral->consultaEntidades('regimen_salud','id_regimen_salud');
				$modeloSgsss->num_doc=$numDocAdol;
				$sgs=$modeloSgsss->consultaSegSocial();
				$modeloSgsss->attributes=$sgs;
				$formularioCargaDerechos="_formVerificacionDerForjarCons";
				$grupoFamiliar=$modeloFamiliar->consultaFamiliarAdol();
				$otroRef=$modeloFamiliar->consultaOtrRef();
				$parentesco=$consultaGeneral->consultaEntidades('parentesco','id_parentesco');
				$modeloEscAdol->num_doc=$numDocAdol;
				$escolaridadAdol=$modeloEscAdol->consultaEscolaridad();
				$nivelEduc=$consultaGeneral->consultaEntidades('nivel_educativo','id_nivel_educ');
				$jornadaEduc=$consultaGeneral->consultaEntidades('jornada_educ','id_jornada_educ');
				$estadoEsc=$consultaGeneral->consultaEntidades('estado_escolarizacion','id_estado_escol');
				$probAsoc=$consultaGeneral->consultaEntidades('problemas_asociados','id_problema_asoc');
				$servProt=$consultaGeneral->consultaEntidades('servicios_proteccion','id_serv_protec');
				$antFam=$consultaGeneral->consultaEntidades('antecedentes_familiares','id_ant_fam');
				$probAsocAdol=$modelValTrSoc->consultaProbAsoc($idValTrSoc);
				$servProtAdol=$modelValTrSoc->consultaServProt($idValTrSoc);
				$tipoFamilia=$consultaGeneral->consultaEntidades('tipo_familia','id_tipo_familia');
				$tipoFamiliaAdol=$modelValTrSoc->consultaTipoFamilia();
				$munCiudad=$consultaGeneral->consultaEntidades('municipio','id_municipio');
	
			}		
			$this->render('_valoracionTrSocCons',array(
				'modelValTrSoc'=>$modelValTrSoc,
				'idValTrSoc'=>$idValTrSoc,
				'formularioCargaDerechos'=>$formularioCargaDerechos,
				'modeloVerifDerechos'=>$modeloVerifDerechos,
				'numDocAdol'=>$numDocAdol,
				'estadoCompVal'=>$estadoCompVal,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'derechos'=>$derechos,
				'participacion'=>$participacion,
				'proteccion'=>$proteccion,
				'modeloFamiliar'=>$modeloFamiliar,
				'grupoFamiliar'=>$grupoFamiliar,
				'otroRef'=>$otroRef,
				'parentesco'=>$parentesco,
				'nivelEduc'=>$nivelEduc,
				'modeloTelefono'=>$modeloTelefono,
				'modeloEscAdol'=>$modeloEscAdol,
				'escolaridadAdol'=>$escolaridadAdol,
				'jornadaEduc'=>$jornadaEduc,
				'estadoEsc'=>$estadoEsc,
				'munCiudad'=>$munCiudad,
				'probAsoc'=>$probAsoc,//problemas asociados al adolescente en la verificación de derechos
				'servProt'=>$servProt,//servicios de protección
				'probAsocAdol'=>$probAsocAdol,
				'servProtAdol'=>$servProtAdol,
				'antFam'=>$antFam,
				'antFamAdol'=>$antFamAdol,
				'modeloFamilia'=>$modeloFamilia,
				'tipoFamilia'=>$tipoFamilia,
				'tipoFamiliaAdol'=>$tipoFamiliaAdol,
				'modeloAntFFamilia'=>$modeloAntFFamilia,
				'modeloProblemaValtsocial'=>$modeloProblemaValtsocial,
				'modeloServprotecValtsocial'=>$modeloServprotecValtsocial,
				'modeloSgsss'=>$modeloSgsss,				
				'eps'=>$eps,
				'regSalud'=>$regSalud,
				'sgs'=>$sgs,
				'render'=>'consultaValTrSoc'
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}

	/**
	 *	Recibe datos de campo en específico de valoración e intancia a modelo para realizar registro y guardar backup de histórico de campo.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionTrabajoSocial
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param string $modeloValTrSoc->msnValTrSoc.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionModificaValoracionTrSoc(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["numDocAdolValTrSoc"])&&empty($dataInput["idValTrSoc"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$variables=array_keys($dataInput);
				$variablesii=array_keys($dataInput[$variables[0]]);
				if(!empty($dataInput["ValoracionTrabajoSocial"][$variablesii[0]])){
					$modeloValTrSoc=new ValoracionTrabajoSocial();
					$modeloValTrSoc->id_valtsoc=$dataInput["idValTrSoc"];
					$modeloValTrSoc->num_doc=$dataInput["numDocAdolValTrSoc"];	
					$valTrSoc=$modeloValTrSoc->consultaIdValTrSoc();			
					if($dataInput["ValoracionTrabajoSocial"][$variablesii[0]]!==$valTrSoc[$variablesii[0]]){					
						$modeloValTrSoc->nombreCampoValoracion=$variablesii[0];
						$modeloValTrSoc->contenidoValoracion=$dataInput["ValoracionTrabajoSocial"][$variablesii[0]];
						if(!empty($valTrSoc[$variablesii[0]])){						
							$modeloValTrSoc->contHist=$valTrSoc[$variablesii[0]];
							$modeloValTrSoc->regHistoricoValTrSoc(); 
						}
						if($valTrSoc[$modeloValTrSoc->nombreCampoValoracion]!==$dataInput["ValoracionTrabajoSocial"][$variablesii[0]] && !empty($dataInput["ValoracionTrabajoSocial"][$variablesii[0]])){	
							
							if(empty($valTrSoc["fecha_inicio_valtsoc"])){
								$modeloValTrSoc->campoFecha="fecha_inicio_valtsoc";
								$modeloValTrSoc->fecha=date("Y-m-d");
								$accion=1;
							}
							else{
								$modeloValTrSoc->campoFecha="fecha_modifvaltrabsoc";
								$modeloValTrSoc->fecha=date("Y-m-d");
								$accion=2;
							}			
							$modeloValTrSoc->msnValTrSoc=$modeloValTrSoc->modificaValoracionTrSoc($accion); 
						}
						else{
							$modeloValTrSoc->msnValTrSoc="exito";
						}
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($modeloValTrSoc->msnValTrSoc))));
					}
					else{
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
					}
				}
				else
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de campo en específico de valoración e intancia a modelo para realizar registro y guardar backup de histórico de campo.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionTrabajoSocial
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param string $modeloValTrSoc->msnValTrSoc.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionModificaValoracionTrSocOpt(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["numDocAdolValTrSoc"])&&empty($dataInput["idValTrSoc"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$variables=array_keys($dataInput);			
				$variablesii=array_keys($dataInput[$variables[0]]);
				if(!empty($dataInput["ValoracionTrabajoSocial"][$variablesii[0]])){
					$modeloValTrSoc=new ValoracionTrabajoSocial();
					$modeloValTrSoc->id_valtsoc=$dataInput["idValTrSoc"];
					$modeloValTrSoc->num_doc=$dataInput["numDocAdolValTrSoc"];
					$valTrSoc=$modeloValTrSoc->consultaIdValTrSoc();
					if($dataInput["ValoracionTrabajoSocial"][$variablesii[0]]!==$valTrSoc[$variablesii[0]] || $dataInput["ValoracionTrabajoSocial"][$variablesii[1]]!==$valTrSoc[$variablesii[1]]){
						
						if(empty($valTrSoc["fecha_inicio_valtsoc"])){
							$modeloValTrSoc->campoFecha="fecha_inicio_valtsoc";
							$modeloValTrSoc->fecha=date("Y-m-d");
							$accion=1;
						}
						else{
							$modeloValTrSoc->campoFecha="fecha_modifvaltrabsoc";
							$modeloValTrSoc->fecha=date("Y-m-d");
							$accion=2;
						}
						$modeloValTrSoc->nombreCampoValoracion=$variablesii[0];
						$modeloValTrSoc->contenidoValoracion=$dataInput["ValoracionTrabajoSocial"][$variablesii[0]];
						if($dataInput["ValoracionTrabajoSocial"][$variablesii[0]]!=$valTrSoc[$variablesii[0]]){
							if($dataInput["ValoracionTrabajoSocial"][$variablesii[0]]=='false' && empty($valTrSoc[$variablesii[0]])){
								
							}
							else{
								if(!empty($variablesii[0])){
									$modeloValTrSoc->contHist=$valTrSoc[$variablesii[0]];
									$modeloValTrSoc->regHistoricoValTrSoc(); 
								}
							}
						}
						if(empty($variablesii[1])){						
							$resultado=$modeloValTrSoc->modificaValoracionTrSoc($accion); 
						}
						else{
							$modeloValTrSoc->nombreCampoValoracioni=$variablesii[1];
							$modeloValTrSoc->contenidoValoracioni=$dataInput["ValoracionTrabajoSocial"][$variablesii[1]];
							$resultado=$modeloValTrSoc->modificaValoracionTrSocOpt($accion);	
							if($dataInput["ValoracionTrabajoSocial"][$variablesii[1]]!=$valTrSoc[$variablesii[1]]){
								if(!empty($variablesii[1])){
									$modeloValTrSoc->contHist=$valTrSoc[$variablesii[1]];
									$modeloValTrSoc->regHistoricoValTrSoc(); 
								}
							}
						}
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
					}
					else{
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
					}
				}
				else
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}

	/**
	 *	Recibe datos de formulario de antecedentes familiares y llama a modelo para registrar.
	 *
	 *	Modelos instanciados:
	 *		- AntFFamilia
	 *
	 *	@param array $dataInput.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionRegistraAntFam(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			$modeloAntFFamilia=new AntFFamilia();
			if(isset($dataInput["AntFFamilia"]["intprev"])&&!empty($dataInput["AntFFamilia"]["intprev"])){
				$modeloAntFFamilia->id_ant_fam=1;
			}
			$modeloAntFFamilia->id_valtsoc=$dataInput["AntFFamilia"]["id_valtsoc"];
			if($modeloAntFFamilia->validate()){
				$modeloAntFFamilia->antFamiliares=$dataInput["AntFFamilia"]["intprev"];
				$resultado=$modeloAntFFamilia->registraAntFam();
				if($resultado=="exito"){
					$modeloValTrSoc=new ValoracionTrabajoSocial();
					$modeloValTrSoc->id_valtsoc=$dataInput["AntFFamilia"]["id_valtsoc"];
					$modeloValTrSoc->num_doc=$dataInput["numDocAdol"];
					$valTrSoc=$modeloValTrSoc->consultaIdValTrSoc();
					if(empty($valTrSoc["fecha_inicio_valtsoc"])){
						$modeloValTrSoc->campoFecha="fecha_inicio_valtsoc";
						$modeloValTrSoc->fecha=date("Y-m-d");
						$accion=1;
					}
					else{
						$modeloValTrSoc->campoFecha="fecha_modifvaltrabsoc";
						$modeloValTrSoc->fecha=date("Y-m-d");
						$accion=2;
					}
					$modeloValTrSoc->modFechaActuacion($accion);
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloAntFFamilia);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de formulario de problemas asociados y llama a modelo para registrar.
	 *
	 *	Modelos instanciados:
	 *		- ProblemaValtsocial
	 *
	 *	@param array $dataInput.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionRegistraProbAsoc(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			$modeloProblemaValtsocial=new ProblemaValtsocial();
			if(isset($dataInput["ProblemaValtsocial"]["probasoc"])&&!empty($dataInput["ProblemaValtsocial"]["probasoc"])){
				$modeloProblemaValtsocial->id_problema_asoc=1;
			}
			$modeloProblemaValtsocial->id_valtsoc=$dataInput["ProblemaValtsocial"]["id_valtsoc"];
			if($modeloProblemaValtsocial->validate()){
				$modeloProblemaValtsocial->vincPand=false;
				$modeloProblemaValtsocial->vincBarrFut=false;
				if(isset($dataInput["vinc_pand"])&&!empty($dataInput["vinc_pand"])){
					$modeloProblemaValtsocial->vincPand=$dataInput["vinc_pand"];
				}
				if(isset($dataInput["vinc_barr_fut"])&&!empty($dataInput["vinc_barr_fut"])){
					$modeloProblemaValtsocial->vincBarrFut=$dataInput["vinc_barr_fut"];
				}
				//echo $modeloProblemaValtsocial->vincPand;
				//echo $modeloProblemaValtsocial->vincBarrFut;
				//print_r($dataInput["ProblemaValtsocial"]["probasoc"]);
				$modeloProblemaValtsocial->probAsoc=$dataInput["ProblemaValtsocial"]["probasoc"];
				$resultado=$modeloProblemaValtsocial->registraProbAsoc();
				if($resultado=="exito"){
					$modeloValTrSoc=new ValoracionTrabajoSocial();
					$modeloValTrSoc->id_valtsoc=$dataInput["ProblemaValtsocial"]["id_valtsoc"];
					$modeloValTrSoc->num_doc=$dataInput["numDocAdol"];
					$valTrSoc=$modeloValTrSoc->consultaIdValTrSoc();
					if(empty($valTrSoc["fecha_inicio_valtsoc"])){
						$modeloValTrSoc->campoFecha="fecha_inicio_valtsoc";
						$modeloValTrSoc->fecha=date("Y-m-d");
						$accion=1;
					}
					else{
						$modeloValTrSoc->campoFecha="fecha_modifvaltrabsoc";
						$modeloValTrSoc->fecha=date("Y-m-d");
						$accion=2;
					}
					$modeloValTrSoc->modFechaActuacion($accion);
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloProblemaValtsocial);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de formulario de Servicios de protección y llama a modelo para registrar.
	 *
	 *	Modelos instanciados:
	 *		- ServprotecValtsocial
	 *
	 *	@param array $dataInput.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionRegistraServProtec(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			$modeloServprotecValtsocial=new ServprotecValtsocial();
			if(isset($dataInput["ServprotecValtsocial"]["sevprot"])&&!empty($dataInput["ServprotecValtsocial"]["sevprot"])){
				$modeloServprotecValtsocial->id_serv_protec=1;
			}
			$modeloServprotecValtsocial->id_valtsoc=$dataInput["ServprotecValtsocial"]["id_valtsoc"];
			if($modeloServprotecValtsocial->validate()){
				$modeloServprotecValtsocial->sevprot=$dataInput["ServprotecValtsocial"]["sevprot"];
				$resultado=$modeloServprotecValtsocial->registraServProtec();
				if($resultado=="exito"){
					$modeloValTrSoc=new ValoracionTrabajoSocial();
					$modeloValTrSoc->id_valtsoc=$dataInput["ServprotecValtsocial"]["id_valtsoc"];
					$modeloValTrSoc->num_doc=$dataInput["numDocAdol"];
					$valTrSoc=$modeloValTrSoc->consultaIdValTrSoc();
					if(empty($valTrSoc["fecha_inicio_valtsoc"])){
						$modeloValTrSoc->campoFecha="fecha_inicio_valtsoc";
						$modeloValTrSoc->fecha=date("Y-m-d");
						$accion=1;
					}
					else{
						$modeloValTrSoc->campoFecha="fecha_modifvaltrabsoc";
						$modeloValTrSoc->fecha=date("Y-m-d");
						$accion=2;
					}
					$modeloValTrSoc->modFechaActuacion($accion);
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloServprotecValtsocial);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de formulario de Tipos de familia y llama a modelo para registrar.
	 *
	 *	Modelos instanciados:
	 *		- Familia
	 *
	 *	@param array $dataInput.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionCreaTipoFam(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			$modeloFamilia=new Familia();
			$modeloFamilia->attributes=$dataInput["Familia"];
			$modeloFamilia->num_doc=$dataInput["Familia"]["num_doc"];
			if($modeloFamilia->validate()){
				$resultado=$modeloFamilia->creaTipoFam();
				echo CJSON::encode(array("estadoComu"=>"exito",
					'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado)),
					'id_familia'=>CHtml::encode($modeloFamilia->id_familia)
				));
			}
			else{
				echo CActiveForm::validate($modeloFamilia);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de formulario de Tipos de familia y llama a modelo para modificar.
	 *
	 *	Modelos instanciados:
	 *		- Familia
	 *
	 *	@param array $dataInput.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionModTipoFam(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			$modeloFamilia=new Familia();
			$modeloFamilia->attributes=$dataInput["Familia"];
			$modeloFamilia->num_doc=$dataInput["Familia"]["num_doc"];
			if($modeloFamilia->validate()){
				$resultado=$modeloFamilia->modTipoFam();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloFamilia);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de formulario de Registro de famiiliar y llama a modelo para registrar.
	 *
	 *	Modelos instanciados:
	 *		- Familiar
	 *
	 *	@param array $dataInput.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionCreaRegFam(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["numDocAdolValTrSoc"])&&empty($dataInput["id_tipo_doc"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$modeloFamiliar=new Familiar();
				$modeloFamiliar->attributes=$dataInput;
				$modeloFamiliar->numDocAdol=$dataInput["numDocAdolValTrSoc"];
				$modeloFamiliar->telefonoPrincipal=$dataInput["telefono"];
				$modeloFamiliar->convive_adol=$dataInput["convAdol"];
				$resultado=$modeloFamiliar->creaRegFamiliarAdol();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado)),'idFamiliar'=>CHtml::encode($modeloFamiliar->id_doc_familiar)));
				//print_r($modeloFamiliar->attributes);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de formulario de Registro de famiiliar y llama a modelo para modificar.
	 *	La modificación se realiza por campo del familiar.
	 *
	 *	Modelos instanciados:
	 *		- Familiar
	 *
	 *	@param array $dataInput.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionModificaDatosFam(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["numDocAdolValTrSoc"])&&empty($dataInput["id_doc_familiar"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro")),'idFamiliar'=>2));
			}
			else{
				$modeloFamiliar=new Familiar();
				$modeloFamiliar->attributes=$dataInput;			
				$modeloFamiliar->numDocAdol=$dataInput["numDocAdolValTrSoc"];
				$modeloFamiliar->telefonoPrincipal=$dataInput["telefono"];
				$modeloFamiliar->convive_adol=$dataInput["convAdol"];
				$datosFamiliar=$modeloFamiliar->consultaFamiliarAdolInd();
				$resultado="exito";
				if($modeloFamiliar->nombres_familiar!=$datosFamiliar["nombres_familiar"]){
					$modeloFamiliar->nombreCampo="nombres_familiar";
					$modeloFamiliar->datosCampo=$modeloFamiliar->nombres_familiar;
					$modeloFamiliar->tipoDato=PDO::PARAM_STR;
					$resultado=$modeloFamiliar->modificaRegFam();				
				}
				if($modeloFamiliar->apellidos_familiar!=$datosFamiliar["apellidos_familiar"]){
					$modeloFamiliar->nombreCampo="apellidos_familiar";
					$modeloFamiliar->datosCampo=$modeloFamiliar->apellidos_familiar;
					$modeloFamiliar->tipoDato=PDO::PARAM_STR;
					$resultado=$modeloFamiliar->modificaRegFam();				
				}
				if($modeloFamiliar->edad_familiar!=$datosFamiliar["edad_familiar"]){
					$modeloFamiliar->nombreCampo="edad_familiar";
					$modeloFamiliar->datosCampo=$modeloFamiliar->edad_familiar;
					$modeloFamiliar->tipoDato=PDO::PARAM_STR;
					$resultado=$modeloFamiliar->modificaRegFam();				
				}
				if($modeloFamiliar->id_parentesco!=$datosFamiliar["id_parentesco"]){
					$modeloFamiliar->nombreCampo="id_parentesco";
					$modeloFamiliar->datosCampo=$modeloFamiliar->id_parentesco;
					$modeloFamiliar->tipoDato=PDO::PARAM_INT;
					$resultado=$modeloFamiliar->modificaRegFam();				
				}
				if($modeloFamiliar->ocupacion_familiar!=$datosFamiliar["ocupacion_familiar"]){
					$modeloFamiliar->nombreCampo="ocupacion_familiar";
					$modeloFamiliar->datosCampo=$modeloFamiliar->ocupacion_familiar;
					$modeloFamiliar->tipoDato=PDO::PARAM_STR;
					$resultado=$modeloFamiliar->modificaRegFam();				
				}
				if($modeloFamiliar->id_nivel_educ!=$datosFamiliar["id_nivel_educ"]){
					$modeloFamiliar->nombreCampo="id_nivel_educ";
					$modeloFamiliar->datosCampo=$modeloFamiliar->id_nivel_educ;
					$modeloFamiliar->tipoDato=PDO::PARAM_INT;
					$resultado=$modeloFamiliar->modificaRegFam();				
				}
/*				if($modeloFamiliar->id_nivel_educ!=$datosFamiliar["id_nivel_educ"]){
					$modeloFamiliar->nombreCampo="id_nivel_educ";
					$modeloFamiliar->datosCampo=$modeloFamiliar->id_nivel_educ;
					$modeloFamiliar->tipoDato=PDO::PARAM_INT;
					$resultado=$modeloFamiliar->modificaRegFam();				
				}*/				
				if($datosFamiliar["convive_adol"]==1){$datosFamiliar["convive_adol"]='true';}else{$datosFamiliar["convive_adol"]='false';}
				if($modeloFamiliar->convive_adol!=$datosFamiliar["convive_adol"]){
					$modeloFamiliar->nombreCampo="convive_adol";
					$modeloFamiliar->datosCampo=$modeloFamiliar->convive_adol;
					$modeloFamiliar->tipoDato=PDO::PARAM_BOOL;
					$resultado=$modeloFamiliar->modificaRegFamAdol();				
				}
				if($modeloFamiliar->telefonoPrincipal!=$datosFamiliar["telefono"]){				
					$resultado=$modeloFamiliar->modificaTelFam();				
				}
				//$resultado=$modeloFamiliar->creaRegFamiliarAdol();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
				//print_r($modeloFamiliar->attributes);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de formulario de Registro de otro referente y llama a modelo para registrar.
	 *
	 *	Modelos instanciados:
	 *		- Familiar
	 *
	 *	@param array $dataInput.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionCreaOtrRef(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();		
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			$modeloFamiliar=new Familiar();
			$modeloFamiliar->attributes=$dataInput["Familiar"];	
			$modeloFamiliar->datos_compl_fam=$dataInput["Familiar"]["datos_compl_fam"];
			$modeloFamiliar->numDocAdol=$dataInput["numDocAdol"];
			$modeloFamiliar->telefonoPrincipal=$dataInput["telefonoOtrRef"];
			if($modeloFamiliar->validate()){
				$resultado=$modeloFamiliar->creaOtrRef();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloFamiliar);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de formulario de Registro de otro referente y llama a modelo para modificar.
	 *	La modificación se realiza por campo de otro referente.
	 *
	 *	Modelos instanciados:
	 *		- Familiar
	 *
	 *	@param array $dataInput.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionModifOtrRef(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			$modeloFamiliar=new Familiar();
			$modeloFamiliar->attributes=$dataInput["Familiar"];	
			$modeloFamiliar->datos_compl_fam=$dataInput["Familiar"]["datos_compl_fam"];
			$modeloFamiliar->numDocAdol=$dataInput["numDocAdol"];
			$modeloFamiliar->num_docAdolFam=$dataInput["numDocAdol"];
			$modeloFamiliar->telefonoPrincipal=$dataInput["telefonoOtrRef"];
			if($modeloFamiliar->validate()){
				$datosOtrRef=$modeloFamiliar->consultaOtrRef();
				if($modeloFamiliar->nombres_familiar!=$datosOtrRef["nombres_familiar"]){
					$modeloFamiliar->nombreCampo="nombres_familiar";
					$modeloFamiliar->datosCampo=$modeloFamiliar->nombres_familiar;
					$modeloFamiliar->tipoDato=PDO::PARAM_STR;
					$resultado=$modeloFamiliar->modificaRegFam();				
				}
				if($modeloFamiliar->apellidos_familiar!=$datosOtrRef["apellidos_familiar"]){
					$modeloFamiliar->nombreCampo="apellidos_familiar";
					$modeloFamiliar->datosCampo=$modeloFamiliar->apellidos_familiar;
					$modeloFamiliar->tipoDato=PDO::PARAM_STR;
					$resultado=$modeloFamiliar->modificaRegFam();				
				}
				if($modeloFamiliar->id_parentesco!=$datosOtrRef["id_parentesco"]){
					$modeloFamiliar->nombreCampo="id_parentesco";
					$modeloFamiliar->datosCampo=$modeloFamiliar->id_parentesco;
					$modeloFamiliar->tipoDato=PDO::PARAM_INT;
					$resultado=$modeloFamiliar->modificaRegFam();				
				}
				if($modeloFamiliar->datos_compl_fam!=$datosOtrRef["datos_compl_fam"]){
					$modeloFamiliar->nombreCampo="datos_compl_fam";
					$modeloFamiliar->datosCampo=$modeloFamiliar->datos_compl_fam;
					$modeloFamiliar->tipoDato=PDO::PARAM_STR;
					$resultado=$modeloFamiliar->modificaRegFamAdol();				
				}
				if($modeloFamiliar->telefonoPrincipal!=$datosOtrRef["telefono"]){				
					$resultado=$modeloFamiliar->modificaTelFam();				
				}
				//$resultado=$modeloFamiliar->creaOtrRef();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloFamiliar);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de formulario de Registro de otro referente y llama a modelo para registrar.
	 *
	 *	Modelos instanciados:
	 *		- Familiar
	 *
	 *	@param array $dataInput.
	 *	@return json $resultado de la transacción.
	 */		
	public function actionCreaRegEscAdol(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["numDocAdolValTrSoc"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$modeloEscAdol=new EscolaridadAdolescente();
				$modeloEscAdol->attributes=$dataInput;
				$modeloEscAdol->num_doc=$dataInput["numDocAdolValTrSoc"];
				$resultado=$modeloEscAdol->creaRegEscAdol();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado)),'idEsc'=>CHtml::encode($modeloEscAdol->id_escolaridad)));
				//print_r($modeloEscAdol->attributes); 
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos de formulario de Registro de formulario de escolaridad adolescente llama a modelo para modificar.
	 *	Se verifica cada campo si ha sido modificado y se procede a modificar.
	 *
	 *	Modelos instanciados:
	 *		- EscolaridadAdolescente
	 *
	 *	@param array $dataInput.    
	 *	@param int $id_nivel_educ
	 *	@param string $anio_escolaridad
	 *	@param string $instituto_escolaridad
	 *	@param int $id_municipio
	 *	@param int $id_jornada_educ
	 *	@return json $resultado de la transacción.
	 */		
	public function actionModificaEscAdol(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			$modeloEscAdol=new EscolaridadAdolescente();
			$modeloEscAdol->attributes=$dataInput;
			$modeloEscAdol->id_escolaridad=$dataInput["id_escolaridad"];
			$modeloEscAdol->num_doc=$dataInput["numDocAdolValTrSoc"];
			$datosAnioEsc=$modeloEscAdol->consultaAnioEsc();
			if($modeloEscAdol->id_nivel_educ!=$datosAnioEsc["id_nivel_educ"]){
				$modeloEscAdol->tipoDato=PDO::PARAM_INT;
				$modeloEscAdol->nombreCampo="id_nivel_educ";
				$modeloEscAdol->datosCampo=$modeloEscAdol->id_nivel_educ;
				$resultado=$modeloEscAdol->modificaEscolAdol();
			}
			if($modeloEscAdol->anio_escolaridad!=$datosAnioEsc["anio_escolaridad"]){
				$modeloEscAdol->tipoDato=PDO::PARAM_STR;
				$modeloEscAdol->nombreCampo="anio_escolaridad"; 
				$modeloEscAdol->datosCampo=$modeloEscAdol->anio_escolaridad;
				$resultado=$modeloEscAdol->modificaEscolAdol();
			}
			if($modeloEscAdol->instituto_escolaridad!=$datosAnioEsc["instituto_escolaridad"]){
				$modeloEscAdol->tipoDato=PDO::PARAM_STR;
				$modeloEscAdol->nombreCampo="instituto_escolaridad";
				$modeloEscAdol->datosCampo=$modeloEscAdol->instituto_escolaridad;
				$resultado=$modeloEscAdol->modificaEscolAdol();
			}
			if($modeloEscAdol->id_municipio!=$datosAnioEsc["id_municipio"]){
				$modeloEscAdol->tipoDato=PDO::PARAM_INT;
				$modeloEscAdol->nombreCampo="id_municipio";
				$modeloEscAdol->datosCampo=$modeloEscAdol->id_municipio;
				$resultado=$modeloEscAdol->modificaEscolAdol();
			}
			if($modeloEscAdol->id_jornada_educ!=$datosAnioEsc["id_jornada_educ"]){
				$modeloEscAdol->tipoDato=PDO::PARAM_INT;
				$modeloEscAdol->nombreCampo="id_jornada_educ";
				$modeloEscAdol->datosCampo=$modeloEscAdol->id_jornada_educ;
				$resultado=$modeloEscAdol->modificaEscolAdol();
			}
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Acción que renderiza la vista que contiene el formulario para el diligenciamiento o consulta de la valoracion en psiquiatría.
	 *
	 *	Vista a renderizar:
	 *		- _valoracionPsiqForm 
	 *		- _valoracionPsiqCons.
	 *	 
	 *	Vistas relacionadas
	 *		- _valoracionPsiqTab
	 *		- _valoracionEstadoValPsiqTab.
	 *	 
	 *	Modelos instanciados:          
	 *		- ValoracionPsiquiatria
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales
	 *	
	 *	@param object 	$modeloValPsiq
	 *	@param string 	$numDocAdol
	 *	@param array 	$datosAdol
	 *	@param int	 	$edad
	 *	@param boolean 	$estadoCompVal
	 */		
	public function actionValoracionPsiqForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsiqForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloValPsiq=new ValoracionPsiquiatria();
			$consGen=new ConsultasGenerales();
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
				$estadoCompVal=$consGen->consutlaEstadoCompVal();
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloValPsiq->num_doc=$numDocAdol;
				$valPsiq=$modeloValPsiq->consultaIdValPsiq();
				$modeloValPsiq->attributes=$valPsiq;
				if(empty($valPsiq)){
					$idValPsiq=$modeloValPsiq->creaRegValPsiq();
				}
				else{
					$idValPsiq=$valPsiq["id_val_psiquiatria"];
				}
				$modeloValPsiq->id_val_psiquiatria=$idValPsiq;
				if(!empty($modeloValPsiq->fecha_ini_vpsiq)){
					$consultaGeneral->numDocAdol=$numDocAdol;
					$tiempoAct=$consultaGeneral->consultaTiempoActuacion();
					$dias	= (strtotime($modeloValPsiq->fecha_ini_vpsiq)-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if($dias<=$tiempoAct["tiempo_valoraciones"]){
						$formRender="_valoracionPsiqForm";
					}
					else{
						$consultaValHab=$modeloValPsiq->consValHabPsiq();
						if(empty($consultaValHab["val_hab_psq"])){
							$formRender="_valoracionPsiqCons";
						}
						else{						
							$formRender="_valoracionPsiqForm";
							$modeloValPsiq->modValHabFalsePsiq();
						}
					}
				}
				else{
					$formRender="_valoracionPsiqForm";
				}
			}
			else{
				$formRender="_valoracionPsiqCons";
			}
			$this->render($formRender,array(
				'modeloValPsiq'=>$modeloValPsiq,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'estadoCompVal'=>$estadoCompVal,
				'render'=>'valoracionPsiqForm'
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Acción que renderiza la vista que contiene el formulario para la consulta de la valoracion en psiquiatría.
	 *
	 *	Vista a renderizar:
	 *		- _valoracionPsiqForm 
	 *		- _valoracionPsiqCons.
	 *	 
	 *	Vistas relacionadas
	 *		- _valoracionPsiqTab
	 *		- _valoracionEstadoValPsiqTab.
	 *	 
	 *	Modelos instanciados:          
	 *		- ValoracionPsiquiatria
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales
	 *	
	 *	@param object 	$modeloValPsiq
	 *	@param string 	$numDocAdol
	 *	@param array 	$datosAdol
	 *	@param int	 	$edad
	 *	@param boolean 	$estadoCompVal
	 */		
	public function actionConsultaValPsiq(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultaValPsiq";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloValPsiq=new ValoracionPsiquiatria();
			$consGen=new ConsultasGenerales();
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
				$estadoCompVal=$consGen->consutlaEstadoCompVal();
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloValPsiq->num_doc=$numDocAdol;
				$valPsiq=$modeloValPsiq->consultaIdValPsiq();
				$modeloValPsiq->attributes=$valPsiq;
				if(empty($valPsiq)){
					$idValPsiq=$modeloValPsiq->creaRegValPsiq();
				}
				else{
					$idValPsiq=$valPsiq["id_val_psiquiatria"];
				}
				$modeloValPsiq->id_val_psiquiatria=$idValPsiq;
			}
			$this->render('_valoracionPsiqCons',array(
				'modeloValPsiq'=>$modeloValPsiq,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'estadoCompVal'=>$estadoCompVal,
				'render'=>'consultaValPsiq'
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos por campo de valoración e instancia a modelo para realizar la modificación.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionPsiquiatria
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $variables contiene el nombre de las variables enviadas por post
	 *	@param array $variablesii contiene un array del nombre de variables del subarray de variables.
	 *	@param string $modeloValTrSoc->msnValTrSoc.
	 *	@return json $resultado de la transacción.
	 */
	public function actionModificaValoracionPsiq(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsiqForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["num_doc"])&&empty($dataInput["id_val_psiquiatria"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$variables=array_keys($dataInput);
				$variablesii=array_keys($dataInput[$variables[0]]);
				if(!empty($dataInput["ValoracionPsiquiatria"][$variablesii[0]])){
					$modeloValPsiq=new ValoracionPsiquiatria();
					$modeloValPsiq->id_val_psiquiatria=$dataInput["id_val_psiquiatria"];
					$modeloValPsiq->num_doc=$dataInput["num_doc"];				
					$valPsiq=$modeloValPsiq->consultaIdValPsiq();
					if($dataInput["ValoracionPsiquiatria"][$variablesii[0]]!==$valPsiq[$variablesii[0]]){					
						$modeloValPsiq->nombreCampoValoracion=$variablesii[0];
						$modeloValPsiq->contenidoValoracion=$dataInput["ValoracionPsiquiatria"][$variablesii[0]];	
						if(!empty($variablesii[0])){
							$modeloValPsiq->contHist=$valPsiq[$variablesii[0]];
							$modeloValPsiq->regHistoricoValPsiq(); 
						}
						if($valPsiq[$modeloValPsiq->nombreCampoValoracion]!==$dataInput["ValoracionPsiquiatria"][$variablesii[0]] && !empty($dataInput["ValoracionPsiquiatria"][$variablesii[0]])){							
							if(empty($valPsiq["fecha_ini_vpsiq"])){
								$modeloValPsiq->campoFecha="fecha_ini_vpsiq";
								$modeloValPsiq->fecha=date("Y-m-d");
								$accion=1;
							}
							else{
								$modeloValPsiq->campoFecha="fecha_modifvalpsiq";
								$modeloValPsiq->fecha=date("Y-m-d");
								$accion=2;
							}			
							$resultado=$modeloValPsiq->modificaValoracionPsiq($accion); 
						}
						else{
							$resultado="exito";
						}
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
					}
					else{
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
					}
				}
				else
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos por campo de valoración e instancia a modelo para realizar la modificación.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionPsiquiatria
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $variables contiene el nombre de las variables enviadas por post
	 *	@param array $variablesii contiene un array del nombre de variables del subarray de variables.
	 *	@return json $resultado de la transacción.
	 */
	public function actionModificaValoracionPsiqOpt(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsiqForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["num_doc"])&&empty($dataInput["id_val_psiquiatria"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$variables=array_keys($dataInput);			
				$variablesii=array_keys($dataInput[$variables[0]]);
				if(!empty($dataInput["ValoracionPsiquiatria"][$variablesii[0]])){
					$modeloValPsiq=new ValoracionPsiquiatria();
					$modeloValPsiq->id_val_psiquiatria=$dataInput["id_val_psiquiatria"];
					$modeloValPsiq->num_doc=$dataInput["num_doc"];
					$valPsiq=$modeloValPsiq->consultaIdValPsiq();
					if($dataInput["ValoracionPsiquiatria"][$variablesii[0]]!==$valPsiq[$variablesii[0]] || $dataInput["ValoracionPsiquiatria"][$variablesii[1]]!==$valPsiq[$variablesii[1]]){
						if(empty($valPsiq["fecha_ini_vpsiq"])){
							$modeloValPsiq->campoFecha="fecha_ini_vpsiq";
							$modeloValPsiq->fecha=date("Y-m-d");
							$accion=1;
						}
						else{
							$modeloValPsiq->campoFecha="fecha_modifvalpsiq";
							$modeloValPsiq->fecha=date("Y-m-d");
							$accion=1;
						}
						$modeloValPsiq->nombreCampoValoracion=$variablesii[0];
						$modeloValPsiq->contenidoValoracion=$dataInput["ValoracionPsiquiatria"][$variablesii[0]];
						if($dataInput["ValoracionPsiquiatria"][$variablesii[0]]!=$valPsiq[$variablesii[0]]){
							if($dataInput["ValoracionPsiquiatria"][$variablesii[0]]=='false' && empty($valPsiq[$variablesii[0]])){
								
							}
							else{
								if(!empty($variablesii[0])){
									$modeloValPsiq->contHist=$valPsiq[$variablesii[0]];
									$modeloValPsiq->regHistoricoValPsiq(); 
								}
							}
						}
						if(empty($variablesii[1])){						
							$resultado=$modeloValPsiq->modificaValoracionPsiq($accion); 
						}
						else{
							$modeloValPsiq->nombreCampoValoracioni=$variablesii[1];
							$modeloValPsiq->contenidoValoracioni=$dataInput["ValoracionPsiquiatria"][$variablesii[1]];
							$resultado=$modeloValPsiq->modificaValoracionPsiqOpt($accion); 
							if($dataInput["ValoracionPsiquiatria"][$variablesii[1]]!=$valPsiq[$variablesii[1]]){
								if(!empty($variablesii[1])){
									$modeloValPsiq->contHist=$valPsiq[$variablesii[1]];
									$modeloValPsiq->regHistoricoValPsiq(); 
								}							
							}
						}
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
					}
					else{
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
					}
				}
				else
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Acción que renderiza la vista que contiene el formulario para el diligenciamiento o consulta de la valoración en terapia ocupacional.
	 *
	 *	Vista a renderizar:
	 *		- _valoracionTOForm 
	 *		- _valoracionTOCons.
	 *	 
	 *	Vistas relacionadas
	 *		 _valoracionTOTab
	 *		 _valoracionConcPlanIntTOTab
	 *		 _valoracionEstadoValTO
	 *		- _valoracionTOTabCons
	 *		- _valoracionConcPlanIntTOCons
	 *		- _valoracionEstadoValTOCons.
	 *	 
	 *	Modelos instanciados:          
	 *		- ValoracionTeo
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales
	 *	
	 *	@param string	$numDocAdol,
	 *	@param object 	$modeloValTO,
	 *	@param int	 	$idValTO,
	 *	@param boolean 	$estadoCompVal,
	 *	@param array 	$datosAdol,
	 *	@param int	 	$edad,
	 *	@param array 	$tipoTrabajador,
	 *	@param array 	$sectorLaboral,
	 */		
	public function actionValoracionTOForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTOForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloValTO=new ValoracionTeo();
			$consGen=new ConsultasGenerales();
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
				$tipoTrabajador=$consultaGeneral->consultaEntidades('tipo_trabajador','id_tipo_trab');
				$sectorLaboral=$consultaGeneral->consultaEntidades('sector_laboral','id_sector_lab');
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$estadoCompVal=$consGen->consutlaEstadoCompVal();
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloValTO->num_doc=$numDocAdol;
				$valTO=$modeloValTO->consultaIdValTO();
				$modeloValTO->attributes=$valTO;
				if(empty($valTO)){
					$idValTO=$modeloValTO->creaRegValTO();
				}
				else{
					$idValTO=$valTO["id_valor_teo"];
				}
				$modeloValTO->id_valor_teo=$idValTO;
				$consultaGeneral->numDocAdol=$numDocAdol;
				if(!empty($modeloValTO->fecha_inicio_valteo)){
					$tiempoAct=$consultaGeneral->consultaTiempoActuacion();
					$dias	= (strtotime($modeloValTO->fecha_inicio_valteo)-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if($dias<=$tiempoAct["tiempo_valoraciones"]){
						$formRender="_valoracionTOForm";
					}
					else{
						$consultaValHab=$modeloValTO->consValHabTO();
						if(empty($consultaValHab["val_hab_to"])){
							$formRender="_valoracionTOCons";
						}
						else{						
							$formRender="_valoracionTOForm";
							$modeloValTO->modValHabFalseTO();
						}
					}
				}
				else{
					$formRender="_valoracionTOForm";
				}			
			}	
			else{
				$formRender="_valoracionTOCons";
			}	
			$this->render($formRender,array(
				'numDocAdol'=>$numDocAdol,
				'modeloValTO'=>$modeloValTO,
				'idValTO'=>$idValTO,
				'estadoCompVal'=>$estadoCompVal,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'tipoTrabajador'=>$tipoTrabajador,
				'sectorLaboral'=>$sectorLaboral,
				'render'=>'valoracionTOForm',
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	//consulta valoracion en terapia ocupacional
	/**
	 *	Acción que renderiza la vista que contiene el formulario para la consulta de la valoración en terapia ocupacional.
	 *
	 *	Vista a renderizar:
	 *		- _valoracionTOForm 
	 *		- _valoracionTOCons.
	 *	 
	 *	Vistas relacionadas
	 *		 _valoracionTOTab
	 *		 _valoracionConcPlanIntTOTab
	 *		 _valoracionEstadoValTO
	 *		- _valoracionTOTabCons
	 *		- _valoracionConcPlanIntTOCons
	 *		- _valoracionEstadoValTOCons.
	 *	 
	 *	Modelos instanciados:          
	 *		- ValoracionTeo
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales
	 *	
	 *	@param string	$numDocAdol,
	 *	@param object 	$modeloValTO,
	 *	@param int	 	$idValTO,
	 *	@param boolean 	$estadoCompVal,
	 *	@param array 	$datosAdol,
	 *	@param int	 	$edad,
	 *	@param array 	$tipoTrabajador,
	 *	@param array 	$sectorLaboral,
	 */		
	public function actionConsultaValTO(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultaValTO";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloValTO=new ValoracionTeo();
			$consGen=new ConsultasGenerales();
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
				$tipoTrabajador=$consultaGeneral->consultaEntidades('tipo_trabajador','id_tipo_trab');				
				$sectorLaboral=$consultaGeneral->consultaEntidades('sector_laboral','id_sector_lab');
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$estadoCompVal=$consGen->consutlaEstadoCompVal();
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloValTO->num_doc=$numDocAdol;
				$valTO=$modeloValTO->consultaIdValTO();
				$modeloValTO->attributes=$valTO;
				if(empty($valTO)){
					$idValTO=$modeloValTO->creaRegValTO();
				}
				else{
					$idValTO=$valTO["id_valor_teo"];
				}
				$modeloValTO->id_valor_teo=$idValTO;
				$consultaGeneral->numDocAdol=$numDocAdol;
			}	
			$this->render('_valoracionTOCons',array(
				'numDocAdol'=>$numDocAdol,
				'modeloValTO'=>$modeloValTO,
				'idValTO'=>$idValTO,
				'estadoCompVal'=>$estadoCompVal,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'tipoTrabajador'=>$tipoTrabajador,
				'sectorLaboral'=>$sectorLaboral,
				'render'=>'consultaValTO'
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	/**
	 *	Recibe datos por campo de valoración e instancia a modelo para realizar la modificación.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionTeo
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $variables contiene el nombre de las variables enviadas por post
	 *	@param array $variablesii contiene un array del nombre de variables del subarray de variables.
	 *	@return json $resultado de la transacción.
	 */
	public function actionModificaValoracionTO(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTOForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["num_doc"])&&empty($dataInput["id_valor_teo"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$variables=array_keys($dataInput);
				$variablesii=array_keys($dataInput[$variables[0]]);
				if(!empty($dataInput["ValoracionTeo"][$variablesii[0]])){
					$modeloValTO=new ValoracionTeo();
					$modeloValTO->id_valor_teo=$dataInput["id_valor_teo"];
					$modeloValTO->num_doc=$dataInput["num_doc"];				
					$valTO=$modeloValTO->consultaIdValTO();
					if($dataInput["ValoracionTeo"][$variablesii[0]]!==$valTO[$variablesii[0]]){					
						$modeloValTO->nombreCampoValoracion=$variablesii[0];
						$modeloValTO->contenidoValoracion=$dataInput["ValoracionTeo"][$variablesii[0]];	
						if(!empty($variablesii[0])){					
							$modeloValTO->contHist=$valTO[$variablesii[0]];
							$modeloValTO->regHistoricoValTO(); 
						}
						if($valTO[$modeloValTO->nombreCampoValoracion]!==$dataInput["ValoracionTeo"][$variablesii[0]] && !empty($dataInput["ValoracionTeo"][$variablesii[0]])){							
							if(empty($valTO["fecha_inicio_valteo"])){
								$modeloValTO->campoFecha="fecha_inicio_valteo";
								$modeloValTO->fecha=date("Y-m-d");
								$accion=1;
							}
							else{
								$modeloValTO->campoFecha="fecha_modifvalteo";
								$modeloValTO->fecha=date("Y-m-d");
								$accion=2;
							}			
							$resultado=$modeloValTO->modificaValoracionTO($accion); 
						}
						else{
							$resultado="exito";
						}
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
					}
					else{
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
					}
				}
				else
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos por campo de valoración e instancia a modelo para realizar la modificación.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionTeo
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $variables contiene el nombre de las variables enviadas por post
	 *	@param array $variablesii contiene un array del nombre de variables del subarray de variables.
	 *	@return json $resultado de la transacción.
	 */
	public function actionModificaValoracionTOOpt(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTOForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["num_doc"])&&empty($dataInput["id_valor_teo"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$variables=array_keys($dataInput);			
				$variablesii=array_keys($dataInput[$variables[0]]);
				if(!empty($dataInput["ValoracionTeo"][$variablesii[0]])){
					$modeloValTO=new ValoracionTeo();
					$modeloValTO->id_valor_teo=$dataInput["id_valor_teo"];
					$modeloValTO->num_doc=$dataInput["num_doc"];				
					$valTO=$modeloValTO->consultaIdValTO();
					if($dataInput["ValoracionTeo"][$variablesii[0]]!==$valTO[$variablesii[0]] || $dataInput["ValoracionTeo"][$variablesii[1]]!==$valTO[$variablesii[1]]){
						if(empty($valTO["fecha_inicio_valteo"])){
							$modeloValTO->campoFecha="fecha_inicio_valteo";
							$modeloValTO->fecha=date("Y-m-d");
							$accion=1;
						}
						else{
							$modeloValTO->campoFecha="fecha_modifvalteo";
							$modeloValTO->fecha=date("Y-m-d");
							$accion=2;
						}
						$modeloValTO->nombreCampoValoracion=$variablesii[0];
						$modeloValTO->contenidoValoracion=$dataInput["ValoracionTeo"][$variablesii[0]];
						if($dataInput["ValoracionTeo"][$variablesii[0]]!=$valTO[$variablesii[0]]){
							if($dataInput["ValoracionTeo"][$variablesii[0]]=='false' && empty($valTO[$variablesii[0]])){
								
							}
							else{
								if(!empty($variablesii[0])){
									$modeloValTO->contHist=$valTO[$variablesii[0]];
									$modeloValTO->regHistoricoValTO(); 
								}
							}
						}

						if(empty($variablesii[1])){						
							$resultado=$modeloValTO->modificaValoracionTO($accion); 
						}
						else{
							$modeloValTO->nombreCampoValoracioni=$variablesii[1];
							$modeloValTO->contenidoValoracioni=$dataInput["ValoracionTeo"][$variablesii[1]];
							$resultado=$modeloValTO->modificaValoracionTOOpt($accion); 
							if($dataInput["ValoracionTeo"][$variablesii[1]]!=$valTO[$variablesii[1]]){
								if(!empty($variablesii[1])){
									$modeloValTO->contHist=$valTO[$variablesii[1]];
									$modeloValTO->regHistoricoValTO(); 
								}
							}							
						}
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
					}
					else{
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
					}
				}
				else
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Acción que renderiza la vista que contiene el formulario para el diligenciamiento o consulta de la valoración en enfermería.
	 *
	 *	Vista a renderizar:
	 *		- _valoracionEnfForm 
	 *		- _valoracionEnfCons.
	 *	 
	 *	Vistas relacionadas
	 *		- _valoracionEnfTab
	 *		- _valoracionEstadoValEnf
	 *		- _valoracionEnfTabCons
	 *		- _valoracionEstadoValEnfCons.
	 *	 
	 *	Modelos instanciados:          
	 *		- ValoracionEnfermeria
	 *		- Sgsss
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales.
	 *	
	 *	@param string	$numDocAdol,
	 *	@param object	$modeloValEnf,
	 *	@param object	$modeloSgsss,
	 *	@param int		$idValEnf,
	 *	@param boolean	$estadoCompVal,
	 *	@param array	$datosAdol,
	 *	@param int		$edad,
	 *	@param array	$eps,
	 *	@param array	$regSalud,
	 *	@param array	$sgs,
	 */		
	public function actionValoracionEnfForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionEnfForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloValEnf=new ValoracionEnfermeria();
			$modeloSgsss= new Sgsss();
			$consGen=new ConsultasGenerales();
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
				$estadoCompVal=$consGen->consutlaEstadoCompVal();
				$eps=$consGen->consultaEntidades('eps_adol','id_eps_adol');
				$regSalud=$consGen->consultaEntidades('regimen_salud','id_regimen_salud');
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloValEnf->num_doc=$numDocAdol;
				$valEnf=$modeloValEnf->consultaIdValEnf();
				$modeloValEnf->attributes=$valEnf;
				if(empty($valEnf)){
					$idValEnf=$modeloValEnf->creaRegValEnf();
				}
				else{
					$idValEnf=$valEnf["id_valor_enf"];
				}
				$modeloValEnf->id_valor_enf=$idValEnf;
				$modeloSgsss->num_doc=$numDocAdol;
				$sgs=$modeloSgsss->consultaSegSocial();
				$modeloSgsss->attributes=$sgs;
				if(!empty($modeloValEnf->fecha_ini_venf)){
					$consultaGeneral->numDocAdol=$numDocAdol;
					$tiempoAct=$consultaGeneral->consultaTiempoActuacion();
					$dias=(strtotime($modeloValEnf->fecha_ini_venf)-strtotime(date("Y-m-d")))/86400;
					$dias=abs($dias); $dias = floor($dias);	
					if($dias<=$tiempoAct["tiempo_valoraciones"]){
						$formRender="_valoracionEnfForm";
					}
					else{
						$consultaValHab=$modeloValEnf->consValHabEnf();
						if(empty($consultaValHab["val_hab_enf"])){
							$formRender="_valoracionEnfCons";
						}
						else{						
							$formRender="_valoracionEnfForm";
							$modeloValEnf->modValHabFalseEnf();
						}
					}
				}
				else{
					$formRender="_valoracionEnfForm";
				}
			}		
			else{
				$formRender="_valoracionEnfCons";
			}
			$this->render($formRender,array(
				'numDocAdol'=>$numDocAdol,
				'modeloValEnf'=>$modeloValEnf,
				'modeloSgsss'=>$modeloSgsss,
				'idValEnf'=>$idValEnf,
				'estadoCompVal'=>$estadoCompVal,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'eps'=>$eps,
				'regSalud'=>$regSalud,
				'sgs'=>$sgs,
				'render'=>'valoracionEnfForm'
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Acción que renderiza la vista que contiene el formulario la consulta de la valoración en enfermería.
	 *
	 *	Vista a renderizar:
	 *		- _valoracionEnfForm 
	 *		- _valoracionEnfCons.
	 *	 
	 *	Vistas relacionadas
	 *		- _valoracionEnfTab
	 *		- _valoracionEstadoValEnf
	 *		- _valoracionEnfTabCons
	 *		- _valoracionEstadoValEnfCons.
	 *	 
	 *	Modelos instanciados:          
	 *		- ValoracionEnfermeria
	 *		- Sgsss
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales.
	 *	
	 *	@param string	$numDocAdol
	 *	@param object	$modeloValEnf
	 *	@param object	$modeloSgsss
	 *	@param int		$idValEnf
	 *	@param boolean	$estadoCompVal
	 *	@param array	$datosAdol
	 *	@param int		$edad
	 *	@param array	$eps
	 *	@param array	$regSalud
	 *	@param array	$sgs
	 */		
	public function actionConsultaValEnf(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultaValEnf";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloValEnf=new ValoracionEnfermeria();
			$modeloSgsss= new Sgsss();
			$consGen=new ConsultasGenerales();
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
				$estadoCompVal=$consGen->consutlaEstadoCompVal();
				$eps=$consGen->consultaEntidades('eps_adol','id_eps_adol');
				$regSalud=$consGen->consultaEntidades('regimen_salud','id_regimen_salud');
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloValEnf->num_doc=$numDocAdol;
				$valEnf=$modeloValEnf->consultaIdValEnf();
				$modeloValEnf->attributes=$valEnf;
				if(empty($valEnf)){
					$idValEnf=$modeloValEnf->creaRegValEnf();
				}
				else{
					$idValEnf=$valEnf["id_valor_enf"];
				}
				$modeloValEnf->id_valor_enf=$idValEnf;
				$modeloSgsss->num_doc=$numDocAdol;
				$sgs=$modeloSgsss->consultaSegSocial();
				$modeloSgsss->attributes=$sgs;
			}		
			$this->render('_valoracionEnfCons',array(
				'numDocAdol'=>$numDocAdol,
				'modeloValEnf'=>$modeloValEnf,
				'modeloSgsss'=>$modeloSgsss,
				'idValEnf'=>$idValEnf,
				'estadoCompVal'=>$estadoCompVal,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'eps'=>$eps,
				'regSalud'=>$regSalud,
				'sgs'=>$sgs,
				'render'=>'consultaValEnf'
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario de afiliación a salud e instancia a modelo para registrar seguridad social del adolescente.
	 *
	 *	Modelos instanciados:
	 *		- Sgsss
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $modeloSgsss->attributes contiene los datos de régimen de salud y eps
	 *	@return json $resultado de la transacción.
	 */
	public function actionRegistraSgsss(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloSgsss= new Sgsss();
			$modeloSgsss->attributes=$datosInput["Sgsss"];
			//print_r($modeloSgsss->attributes);
			if($modeloSgsss->validate()){
				$restulado=$modeloSgsss->registraSgss();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($restulado))));
			}
			else{
				echo CActiveForm::validate($modeloSgsss);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario de afiliación a salud e instancia a modelo para modificar seguridad social del adolescente.
	 *
	 *	Modelos instanciados:
	 *		- Sgsss
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $modeloSgsss->attributes contiene los datos de régimen de salud y eps
	 *	@return json $resultado de la transacción.
	 */
	public function actionModificaSgsss(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloSgsss= new Sgsss();
			$modeloSgsss->attributes=$datosInput["Sgsss"];
			//print_r($modeloSgsss->attributes);
			if($modeloSgsss->validate()){
				$resultado="exito";
				$sgs=$modeloSgsss->consultaSegSocial();
				if($modeloSgsss->id_eps_adol!=$sgs["id_eps_adol"]){
					$modeloSgsss->nombreCampoValoracion="id_eps_adol";
					$modeloSgsss->contenidoValoracion=$modeloSgsss->id_eps_adol;
					$resultado=$modeloSgsss->modificaSgsss();
				}
				if($modeloSgsss->id_regimen_salud!=$sgs["id_regimen_salud"]){
					$modeloSgsss->nombreCampoValoracion="id_regimen_salud";
					$modeloSgsss->contenidoValoracion=$modeloSgsss->id_regimen_salud;
					$resultado=$modeloSgsss->modificaSgsss();
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
			else{
				echo CActiveForm::validate($modeloSgsss);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos por campo de valoración e instancia a modelo para realizar la modificación.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionEnfermeria
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $variables contiene el nombre de las variables enviadas por post
	 *	@param array $variablesii contiene un array del nombre de variables del subarray de variables.
	 *	@return json $resultado de la transacción.
	 */
	public function actionModificaValoracionEnf(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionEnfForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["num_doc"])&&empty($dataInput["id_valor_enf"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$variables=array_keys($dataInput);
				$variablesii=array_keys($dataInput[$variables[0]]);
				if(!empty($dataInput["ValoracionEnfermeria"][$variablesii[0]])){
					$modeloValEnf=new ValoracionEnfermeria();
					$modeloValEnf->id_valor_enf=$dataInput["id_valor_enf"];
					$modeloValEnf->num_doc=$dataInput["num_doc"];				
					$valEnf=$modeloValEnf->consultaIdValEnf();
					if($dataInput["ValoracionEnfermeria"][$variablesii[0]]!==$valEnf[$variablesii[0]]){					
						$modeloValEnf->nombreCampoValoracion=$variablesii[0];
						$modeloValEnf->contenidoValoracion=$dataInput["ValoracionEnfermeria"][$variablesii[0]];	
						if(!empty($variablesii[0])){
							$modeloValEnf->contHist=$valEnf[$variablesii[0]];
							$modeloValEnf->regHistoricoValEnf(); 
						}
						if($valEnf[$modeloValEnf->nombreCampoValoracion]!==$dataInput["ValoracionEnfermeria"][$variablesii[0]] && !empty($dataInput["ValoracionEnfermeria"][$variablesii[0]])){							
							if(empty($valEnf["fecha_ini_venf"])){
								$modeloValEnf->campoFecha="fecha_ini_venf";
								$modeloValEnf->fecha=date("Y-m-d");
								$accion=1;
							}
							else{
								$modeloValEnf->campoFecha="fecha_modifvalenf";
								$modeloValEnf->fecha=date("Y-m-d");
								$accion=2;
							}			
							$resultado=$modeloValEnf->modificaValoracionEnf($accion); 
						}
						else{
							$resultado="exito";
						}
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
					}
					else{
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
					}
				}
				else
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos por campo de valoración e instancia a modelo para realizar la modificación.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionEnfermeria
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $variables contiene el nombre de las variables enviadas por post
	 *	@param array $variablesii contiene un array del nombre de variables del subarray de variables.
	 *	@return json $resultado de la transacción.
	 */
	public function actionModificaValoracionEnfOpt(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionEnfForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["num_doc"])&&empty($dataInput["id_valor_enf"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
			}
			else{
				$variables=array_keys($dataInput);			
				$variablesii=array_keys($dataInput[$variables[0]]);
				if(!empty($dataInput["ValoracionEnfermeria"][$variablesii[0]])){
					$modeloValEnf=new ValoracionEnfermeria();
					$modeloValEnf->id_valor_enf=$dataInput["id_valor_enf"];
					$modeloValEnf->num_doc=$dataInput["num_doc"];				
					$valEnf=$modeloValEnf->consultaIdValEnf();
					if($dataInput["ValoracionEnfermeria"][$variablesii[0]]!==$valEnf[$variablesii[0]] || $dataInput["ValoracionTeo"][$variablesii[1]]!==$valEnf[$variablesii[1]]){
						if(empty($valEnf["fecha_ini_venf"])){
							$modeloValEnf->campoFecha="fecha_ini_venf";
							$modeloValEnf->fecha=date("Y-m-d");
							$accion=1;
						}
						else{
							$modeloValEnf->campoFecha="fecha_modifvalenf";
							$modeloValEnf->fecha=date("Y-m-d");
							$accion=2;
						}
						$modeloValEnf->nombreCampoValoracion=$variablesii[0];
						$modeloValEnf->contenidoValoracion=$dataInput["ValoracionEnfermeria"][$variablesii[0]];
						if($dataInput["ValoracionEnfermeria"][$variablesii[0]]!=$valEnf[$variablesii[0]]){
							if($dataInput["ValoracionEnfermeria"][$variablesii[0]]=='false' && empty($valEnf[$variablesii[0]])){
								
							}
							else{
								if(!empty($variablesii[0])){
									$modeloValEnf->contHist=$valEnf[$variablesii[0]];
									$modeloValEnf->regHistoricoValEnf(); 
								}
							}
						}
						if(empty($variablesii[1])){						
							$resultado=$modeloValEnf->modificaValoracionEnf($accion); 
						}
						else{
							$modeloValEnf->nombreCampoValoracioni=$variablesii[1];
							$modeloValEnf->contenidoValoracioni=$dataInput["ValoracionEnfermeria"][$variablesii[1]];
							$resultado=$modeloValEnf->modificaValoracionEnfOpt($accion);
							if($dataInput["ValoracionEnfermeria"][$variablesii[1]]!=$valEnf[$variablesii[1]]){
								if(!empty($variablesii[1])){
									$modeloValEnf->contHist=$valEnf[$variablesii[1]];
									$modeloValEnf->regHistoricoValEnf(); 
								}
							}							
						}
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
					}
					else{
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
					}
				}
				else
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("exito"))));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario de verificación de derechos del adolescente e instancia a modelo para crear registro de verificación de derechos.
	 *
	 *	Modelos instanciados:
	 *		- DerechoAdol
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $variables contiene el nombre de las variables enviadas por post
	 *	@param array $variablesii contiene un array del nombre de variables del subarray de variables.
	 *	@return json $resultado de la transacción.
	 */
	public function actionCreaVerifDerAdol(){
		$modeloVerifDerechos=new DerechoAdol();
		$this->performAjaxValidation('formularioVerifDer',$modeloVerifDerechos);
		
		if(isset($_POST["DerechoAdol"]) && !empty($_POST["DerechoAdol"])){ 
			$datosInput=Yii::app()->input->post(); 
			$modeloVerifDerechos->attributes=$datosInput["DerechoAdol"];
			if($modeloVerifDerechos->validate()){
				$modeloVerifDerechos->atributos=$datosInput["DerechoAdol"];
				$resultado=$modeloVerifDerechos->registraDerechos();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>'exito','msnError'=>$modeloVerifDerechos->msnErrorDerecho));
			}
			else{
				echo CActiveForm::validate($modeloVerifDerechos);
			}
		}
	}
	/**
	 *	Recibe datos del formulario de verificación de derechos del adolescente e instancia a modelo para modificar la verificación de derechos.
	 *
	 *	Modelos instanciados:
	 *		- DerechoAdol
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $variables contiene el nombre de las variables enviadas por post
	 *	@param array $variablesii contiene un array del nombre de variables del subarray de variables.
	 *	@return json $resultado de la transacción.
	 */
	public function actionModVerifDerAdol(){
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
	
	
	public function actionBuscaAdolGen(){
		$datos=Yii::app()->input->post();
		$consAdol=new ConsultasGenerales();
		$consAdol->searchTerm=$datos["search_term"];
		$res=$consAdol->buscaAdolGen();
		echo CJSON::encode($res);
	}	
	//Consulta el nombre de los campos de una entidad y su identificador en la base de datos
	public function actionConsultaDatosForm(){
		$datosInput=Yii::app()->input->post();
		$consGen=new ConsultasGenerales();
		echo CJSON::encode($consGen->consultaEntidadesAjax($datosInput["nombreEntidad"],$datosInput["campoId"],$datosInput["nombCampo"]));
	}
	public function performAjaxValidation($formId,$model){
		if(isset($_POST['ajax']) && $_POST['ajax']===$formId){
			if(Yii::app()->request->isAjaxRequest){
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
		}
	}
	/**
	 *	Acción que renderiza la vista que contiene el formulario para el registro y consulta del concepto integral
	 *
	 *	Vista a renderizar:
	 *		- _conceptoIntegralFormCrea 
	 *		- _conceptoIntegralFormMod.
	 *		- _conceptoIntegralFormCons.
	 *	 
	 *	Modelos instanciados:          
	 *		- ConceptoIntegral
	 *		- DerechoAdol
	 * 		- OperacionesGenerales
	 * 		- ConsultasGenerales.
	 *	
	 *	@param object	$modeloConInt,
	 *	@param object	$modeloVerifDerechos,
	 *	@param array	$formularioConcInt,
	 *	@param string	$numDocAdol,
	 *	@param array	$datosAdol,
	 *	@param int		$edad,
	 *	@param array	$derechos,
	 *	@param array	$participacion,
	 *	@param array	$proteccion,
	 *	@param boolean	$consEstPsicol,
	 *	@param boolean	$consEstTrSocial,
	 *	@param array	$datosConcInt 
	 */		
	public function actionConceptoIntegral(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="conceptoIntegral";
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
				$modeloConInt=new ConceptoIntegral();
				$modeloVerifDerechos=new DerechoAdol();
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$consultaGeneral->numDocAdol=$numDocAdol;
				$datosProf=$consultaGeneral->consultaProfesionalAdol();
				$modeloConInt->num_doc=$numDocAdol;
				$datosConcInt=$modeloConInt->consultaConcInt();
				if(!empty($datosConcInt)){
					$modeloConInt->attributes=$datosConcInt;
					$formularioConcInt="_conceptoIntegralFormMod";
				}
				else{
					$formularioConcInt="_conceptoIntegralFormCrea";
				}
				if($datosProf["responsable_caso"]!="1"){
						$formularioConcInt="_conceptoIntegralFormCons";
				}
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				//Consulta derechos
				$derechos=$consultaGeneral->consultaDerechos();
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
				$consultaGeneral->numDocAdol=$numDocAdol;
				$consultaGeneral->searchTerm="valoracion_psicologia";
				$consEstPsicol=$consultaGeneral->consEstadoVal();
				$consultaGeneral->searchTerm="valoracion_trabajo_social";
				$consEstTrSocial=$consultaGeneral->consEstadoVal();
			}
			$this->render('_conceptoIntegral',array(
				'modeloConInt'=>$modeloConInt,
				'modeloVerifDerechos'=>$modeloVerifDerechos,
				'formularioConcInt'=>$formularioConcInt,
				'numDocAdol'=>$numDocAdol,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'derechos'=>$derechos,
				'participacion'=>$participacion,
				'proteccion'=>$proteccion,
				'consEstPsicol'=>$consEstPsicol,
				'consEstTrSocial'=>$consEstTrSocial,
				'datosConcInt'=>$datosConcInt
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario concepto integral e instancia a modelo para registrar el concepto
	 *
	 *	Modelos instanciados:
	 *		- ConceptoIntegral
	 *
	 *	@param array $dataInput	contiene datos de adolescente y datos del concepto integral
	 *	@return json $resultado de la transacción.
	 */
	public function actionRegistraConcInt(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="conceptoIntegral";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			if(isset($_POST["ConceptoIntegral"]) &&!empty($_POST["ConceptoIntegral"])){
				$datosInput=Yii::app()->input->post();
				$modeloConcInt=new ConceptoIntegral();
				$modeloConcInt->attributes=$datosInput["ConceptoIntegral"];
				if($modeloConcInt->validate()){
					$respuesta=$modeloConcInt->registraConcInt();
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($respuesta))));
				}
				else{
					echo CActiveForm::validate($modeloConcInt);
				}
			}	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario concepto integral e instancia a modelo para modificar el concepto
	 *
	 *	Modelos instanciados:
	 *		- ConceptoIntegral
	 *
	 *	@param array $dataInput	contiene datos de adolescente y datos del concepto integral
	 *	@return json $resultado de la transacción.
	 */
	public function actionModificaConcInt(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="conceptoIntegral";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			if(isset($_POST["ConceptoIntegral"]) &&!empty($_POST["ConceptoIntegral"])){
				$datosInput=Yii::app()->input->post();				
				$modeloConcInt=new ConceptoIntegral();
				$modeloConcInt->attributes=$datosInput["ConceptoIntegral"];
				if($modeloConcInt->validate()){
					$respuesta=$modeloConcInt->modificaConcInt();
					//print_r($modeloConcInt->attributes);exit;
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($respuesta))));
				}
				else{
					echo CActiveForm::validate($modeloConcInt);
				}
			}	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Valida si los campos están adecuadamente diligenciados al momento de marcar la valoración de psicología como completa.
	 *	si tienen el número de carácteres mínimos para marcar el campo como diligenciado
	 *
	 *	Modelos instanciados:
	 *		- ValoracionPsicologia
	 *
	 *	@param int Yii::app()->params['num_caracteres'] número de carácteres definidos en la configuración del sistema.
	 *	@return json $resultado de la transacción.
	 */
	public function actionValidaDilValoracionPsicol(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsicolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["idValPsicol"]) && !empty($datosInput["idValPsicol"])){
				$modeloValPsicol=new ValoracionPsicologia();
				$modeloValPsicol->id_valoracion_psicol=$datosInput["idValPsicol"];
				$valPsicol=$modeloValPsicol->consultaValPsicol();
				$estado="true";
				$numCaracteres=Yii::app()->params['num_caracteres'];
				if(strlen($valPsicol['historia_vida'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valPsicol['dn_fn_familiar'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valPsicol['hist_conducta'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valPsicol['analisis_est_mental'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valPsicol['resultado_examtox'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valPsicol['ultimo_ep_cons'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valPsicol['interv_prev_spa'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valPsicol['concl_gen_vpsicol'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valPsicol['pry_plan_interv'])<$numCaracteres){
					$estado="false";
				}
				if($valPsicol['remis_psiquiatria']==1){
					if(strlen($valPsicol['objetivo_remitpsiq'])<$numCaracteres){
						$estado="false";
					}
				}
				if($valPsicol['consumo_spa']==1){
					if(strlen($valPsicol['patron_consumo_desc'])<$numCaracteres){
						$estado="false";
					}
				}
				
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$estado));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	/**
	 *	Valida si los campos están adecuadamente diligenciados al momento de marcar la valoración de trabajo social como completa.
	 *	si tienen el número de carácteres mínimos para marcar el campo como diligenciado
	 *
	 *	Modelos instanciados:
	 *		- ValoracionTrabajoSocial
	 *
	 *	@param int Yii::app()->params['num_caracteres'] número de carácteres definidos en la configuración del sistema.
	 *	@return json $resultado de la transacción.
	 */
	public function actionValidaDilValoracionTrSoc(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTrSocForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["idValTrSoc"]) && !empty($datosInput["idValTrSoc"])){
				$modeloValTrSoc=new ValoracionTrabajoSocial();
				$modeloValTrSoc->id_valtsoc=$datosInput["idValTrSoc"];
				$valTrSoc=$modeloValTrSoc->consultaValTrSoc();
				$estado="true";
				$numCaracteres=Yii::app()->params['num_caracteres'];
				if(strlen($valTrSoc['obs_familiares_ts'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valTrSoc['historia_famvaltsic'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valTrSoc['pa_f_dc'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valTrSoc['dr_hist_escolar'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valTrSoc['perfil_gener_vuln'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valTrSoc['concepto_social'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valTrSoc['pry_pl_int_tsocial'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valTrSoc['pry_pl_int_tsocial'])<$numCaracteres){
					$estado="false";
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$estado));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	/**
	 *	Valida si los campos están adecuadamente diligenciados al momento de marcar la valoración de terapia ocupacional como completa.
	 *	si tienen el número de carácteres mínimos para marcar el campo como diligenciado
	 *
	 *	Modelos instanciados:
	 *		- ValoracionTrabajoSocial
	 *
	 *	@param int Yii::app()->params['num_caracteres'] número de carácteres definidos en la configuración del sistema.
	 *	@return json $resultado de la transacción.
	 */
	public function actionValidaDilValoracionTO(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionTOForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["id_valor_teo"]) && !empty($datosInput["id_valor_teo"])){
				$modeloValTO=new ValoracionTeo();
				$modeloValTO->id_valor_teo=$datosInput["id_valor_teo"];
				$valTO=$modeloValTO->consultaValTO();
				$estado="true";
				$numCaracteres=Yii::app()->params['num_caracteres'];
				if(strlen($valTO['desemp_area_ocup'])<$numCaracteres){
					$estado="false";
				}
/*				if(strlen($valTO['desemp_laboral'])<$numCaracteres){
					$estado="false";
				}
*/				if(strlen($valTO['patron_desemp'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valTO['interes_expect_ocup'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valTO['aptit_habilid_destrezas'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valTO['criterios_area_int'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valTO['concepto_teo'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valTO['plan_interv_teo'])<$numCaracteres){
					$estado="false";
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$estado));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Valida si los campos están adecuadamente diligenciados al momento de marcar la valoración de enfermería como completa.
	 *	si tienen el número de carácteres mínimos para marcar el campo como diligenciado
	 *
	 *	Modelos instanciados:
	 *		- ValoracionTrabajoSocial
	 *
	 *	@param int Yii::app()->params['num_caracteres'] número de carácteres definidos en la configuración del sistema.
	 *	@return json $resultado de la transacción.
	 */
	public function actionValidaDilValoracionEnf(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionEnfForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["id_valor_enf"]) && !empty($datosInput["id_valor_enf"])){
				$modeloValEnf=new ValoracionEnfermeria();
				$modeloValEnf->id_valor_enf=$datosInput["id_valor_enf"];
				$valEnf=$modeloValEnf->consultaValEnf();
				$estado="true";
				$numCaracteres=Yii::app()->params['num_caracteres'];
				if(strlen($valEnf['antecedentes_clinic'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valEnf['examen_fisico_fisiol'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valEnf['obs_gen_enferm'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valEnf['recom_aten_salud'])<$numCaracteres){
					$estado="false";
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$estado));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Valida si los campos están adecuadamente diligenciados al momento de marcar la valoración de enfermería como completa.
	 *	si tienen el número de carácteres mínimos para marcar el campo como diligenciado
	 *
	 *	Modelos instanciados:
	 *		- ValoracionTrabajoSocial
	 *
	 *	@param int Yii::app()->params['num_caracteres'] número de carácteres definidos en la configuración del sistema.
	 *	@return json $resultado de la transacción.
	 */
	public function actionValidaDilValoracionPsiq(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionPsiqForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["id_val_psiquiatria"]) && !empty($datosInput["id_val_psiquiatria"])){
				$modeloValPsiq=new ValoracionPsiquiatria();
				$modeloValPsiq->id_val_psiquiatria=$datosInput["id_val_psiquiatria"];
				$valPsiq=$modeloValPsiq->consultaValPsiq();
				$estado="true";
				$numCaracteres=Yii::app()->params['num_caracteres'];
				if(strlen($valPsiq['hist_psiq_ant'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valPsiq['examen_mental'])<$numCaracteres){
					$estado="false";
				}	
				if(strlen($valPsiq['analisis_psiq'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valPsiq['diagnostico_psiq'])<$numCaracteres){
					$estado="false";
				}
				if(strlen($valPsiq['recomend_psic'])<$numCaracteres){
					$estado="false";
				}			
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$estado));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
//************************************************* Valoración en nutrición *********************************************************************************//
	/**
	 *	Acción que renderiza la vista que contiene el formulario de registro o consulta de la valoración en nutrición.
	 *
	 *	Vista a renderizar:
	 *		- _valoracionNutrForm 
	 *		- _valoracionNutrFormCons.
	 *	 
	 *	Vistas relacionadas
	 *		- _valoracionNutrAntSalud
	 *		- _valoracionNutrExamenes
	 *		- _valoracionNutrAntAlim
	 *		- _valoracionNutrEstadoActual.
	 *		- _valoracionNutrResultados.
	 *		- _valoracionNutrPlanDietario.
	 *		- _valoracionNutrEstado.
	 *		- _valoracionNutrEstadoActual.
	 *		- _valoracionNutrAntSaludCons.
	 *		- _valoracionNutrExamenesCons.
	 *		- _valoracionNutrAntAlimCons.
	 *		- _valoracionNutrEstadoActualCons.
	 *		- _valoracionNutrResultadosCons.
	 *		- _valoracionNutrPlanDietarioCons.
	 *		- _valoracionNutrEstadoCons.
	 *	 
	 *	Modelos instanciados:   				
	 *		- ForjarAdol
	 *		- Telefono
	 * 		- LabclinValnutr
	 * 		- TipodiscValnutr.
	 * 		- OrigenalimValnutr.
	 * 		- GrupocomidaValnutr.
	 * 		- GrupocomidaNutradol.
	 * 		- Antropometria.
	 * 		- PorcionesComida.
	 * 		- NutricionAdol.
	 * 		- EsquemaVacunacion.
	 * 		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 * 		- Familia.
	 * 		- Familiar.
	 *	
	 *	@param string	$numDocAdol,	
	 *	@param array	$datosAdol,
	 *	@param object	$modeloValNutr,
	 *	@param int		$idValNutr,
	 *	@param int		$edad,
	 *	@param boolean	$estadoCompVal,
	 *	@param int		$estadoAdol,
	 *	@param array	$tipoParto,
	 *	@param object	$modeloFamilia,
	 *	@param object	$modeloFamiliar,
	 *	@param array	$grupoFamiliar,
	 *	@param object	$modeloTelefono,
	 *	@param array	$nivelEduc,
	 *	@param array	$parentesco,
	 *		//laboratorios clinicos
	 *	@param object	$modeloLabclinValnutr,
	 *	@param array	$labClinicosAdol,
	 *	@param array	$laboratorios,
	 *	@param array	$laboratoriosExtra,
	 *	@param array	$esquemasVac,
	 *	@param array	$tiposDiscapacidad,
	 *	@param object	$modeloTipodiscValnutr,
	 *	@param array	$tiposDiscAdol,
	 *	@param array	$consLecheMat,
	 *	@param array	$consBiberon,
	 *	@param object	$modeloOrigenalimValnutr,
	 *	@param array	$origenAlimentosHogar,
	 *	@param array	$origenAlimentos,
	 *	@param array	$apetito,
	 *	@param array	$ingesta,
	 *	@param array	$masticacion,
	 *	@param array	$digestion,
	 *	@param array	$habitoIntestinal,
	 *	@param array	$nivelActFisica,
	 *	@param array	$frecConsumo,
	 *	@param array	$grupoComida,
	 *	frecuencia de consumo
	 *	@param object	$modeloGrupocomidaValnutr,
	 *	//estado actual
	 *	@param object	$modeloAntropometria,
	 *	@param array	$antropometriaAdol,
	 *	//plan dietario
	 *	@param object	$modeloNutricionAdol,
	 *	@param array	$tiempoAlimento,	
	 *	@param array	$planDietario,	
	 *	@param object	$modeloGrupocomidaNutradol,	
	 *	@param object	$modeloPorcionesComida,
	 *	@param int		$estadoCompVal,
	 *	@param object	$modeloEsquemaVacunacion,
	 */		
	 public function actionValoracionNutrForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloValNutr=new ValoracionNutricional();
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
				$modeloTelefono=new Telefono();
				$modeloLabclinValnutr=new LabclinValnutr();
				$modeloTipodiscValnutr=new TipodiscValnutr();
				$modeloOrigenalimValnutr=new OrigenalimValnutr();
				$modeloGrupocomidaValnutr=new GrupocomidaValnutr();
				$modeloGrupocomidaNutradol=new GrupocomidaNutradol();
				$modeloAntropometria= new Antropometria();
				$modeloNutricionAdol= new NutricionAdol();
				$modeloPorcionesComida=new PorcionesComida();
				$modeloEsquemaVacunacion=new EsquemaVacunacion();
				$modeloForjarAdol->num_doc=$numDocAdol;
				$modeloValNutr->num_doc=$numDocAdol;
				$estadoAdol=$modeloForjarAdol->consultaDatosForjarAdol();								
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));				
				$valNutr=$modeloValNutr->consultaIdValNutr();
				$modeloValNutr->attributes=$valNutr;
				//consulta tablas primarias
				$tipoParto=$consultaGeneral->consultaEntidades('tipo_parto','id_tipo_parto');
				$parentesco=$consultaGeneral->consultaEntidades('parentesco','id_parentesco');
				$laboratorios=$consultaGeneral->consultaEntidades('laboratorio_clinico','id_laboratorio');				
				$esquemasVac=$consultaGeneral->consultaEntidades('esquema_vacunacion','id_esquema_vac');
				$tiposDiscapacidad=$consultaGeneral->consultaEntidades('tipo_discapacidad','id_tipo_discap');
				$origenAlimentos=$consultaGeneral->consultaEntidades('origen_alimentos','id_origen_alim');
				$apetito=$consultaGeneral->consultaEntidades('apetito','id_apetito');
				$ingesta=$consultaGeneral->consultaEntidades('ingesta','id_ingesta');
				$masticacion=$consultaGeneral->consultaEntidades('masticacion','id_masticacion');
				$digestion=$consultaGeneral->consultaEntidades('digestion','id_digestion');
				$habitoIntestinal=$consultaGeneral->consultaEntidades('habito_intestinal','id_hab_intest');
				$nivelActFisica=$consultaGeneral->consultaEntidades('nivel_act_fis','id_nivel_act_fis');
				$frecConsumo=$consultaGeneral->consultaEntidades('frecuencia_consumo','id_frec_cons');
				$grupoComida=$consultaGeneral->consultaEntidades('grupo_comida','id_grupo_comida');
				$tiempoAlimento=$consultaGeneral->consultaEntidades('tiempo_alimento','id_tiempo_alimento');
				$estadoCompVal=$consultaGeneral->consutlaEstadoCompVal();
				//consulta grupo familiar
				$modeloFamilia=new Familia();
				$modeloFamiliar=new Familiar();
				$modeloFamiliar->num_docAdolFam=$numDocAdol;
				$grupoFamiliar=$modeloFamiliar->consultaFamiliarAdol();
				$nivelEduc=$consultaGeneral->consultaEntidades('nivel_educativo','id_nivel_educ');
				//registrar valoración del adolescente si no tiene
				if(empty($valNutr)){
					$idValNutr=$modeloValNutr->creaRegValNutrAdol();
				}
				else{
					$idValNutr=$valNutr["id_val_nutricion"];
				}
				$modeloValNutr->id_val_nutricion=$idValNutr;
				//consulta tablas secundarias valnutr				
				//consulta si recibió leche materan
				$modeloTipodiscValnutr->id_val_nutricion=$idValNutr;
				$consLecheMat=$modeloValNutr->consRecibLecheMat();
				//consulta si recibió bibierón
				$consBiberon=$modeloValNutr->consRecibBiberon();
				//consulta tipos de discapacidad del adolescente
				$tiposDiscAdol=$modeloTipodiscValnutr->consultaTiposDiscAdol();
				//consulta origen alimentos en el hogar
				$modeloOrigenalimValnutr->id_val_nutricion=$idValNutr;
				$origenAlimentosHogar=$modeloOrigenalimValnutr->consultaOrigenAlimentosHogar();
				//consulta antropometría de la valoración
				$modeloAntropometria->id_val_nutricion=$idValNutr;
				$antropometriaAdol=$modeloAntropometria->consultaAntropValNutr();
				//consulta plan dietario
				$modeloNutricionAdol->id_val_nutricion=$idValNutr;
				$modeloNutricionAdol->id_tipoact_pld=1;
				$planDietario=$modeloNutricionAdol->consultaPlanDietario();								
				$modeloLabclinValnutr->id_val_nutricion=$idValNutr;
				$laboratoriosExtra=$modeloLabclinValnutr->consLabClinicosExtra();
				$labClinicosAdol=$modeloLabclinValnutr->consLabClinicosAdol();
				//consulta tiempo de valoración si ya está caduco.
				if(!empty($modeloValNutr->fecha_ini_vnutr)){
					$consultaGeneral->numDocAdol=$numDocAdol;
					$tiempoAct=$consultaGeneral->consultaTiempoActuacion();
					$dias	= (strtotime($modeloValNutr->fecha_ini_vnutr)-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if($dias<=$tiempoAct["tiempo_valoraciones"]){
						$formRender="_valoracionNutrForm";
					}
					else{
						$consultaValHab=$modeloValNutr->consValHab();
						if($consultaValHab["val_hab_nutr"]=='f' || empty($consultaValHab["val_hab_nutr"])){
							$formRender="_valoracionNutrFormCons";
						}
						else{						
							$formRender="_valoracionNutrForm";
							$modeloValNutr->modValHabFalse();
						}
					}
				}
				else{
					$formRender="_valoracionNutrForm";
				}
			}	
			else{
				$formRender="_valoracionNutrFormCons";
			}
			
			$this->render($formRender,array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'modeloValNutr'=>$modeloValNutr,
				'idValNutr'=>$idValNutr,
				'edad'=>$edad,
				'estadoCompVal'=>$estadoCompVal,
				'render'=>'valoracionNutrForm',
				'estadoAdol'=>$estadoAdol,
				'tipoParto'=>$tipoParto,
				'modeloFamilia'=>$modeloFamilia,
				'modeloFamiliar'=>$modeloFamiliar,
				'grupoFamiliar'=>$grupoFamiliar,
				'modeloTelefono'=>$modeloTelefono,
				'nivelEduc'=>$nivelEduc,
				'parentesco'=>$parentesco,
				//laboratorios clinicos
				'modeloLabclinValnutr'=>$modeloLabclinValnutr,
				'labClinicosAdol'=>$labClinicosAdol,
				'laboratorios'=>$laboratorios,
				'laboratoriosExtra'=>$laboratoriosExtra,
				'esquemasVac'=>$esquemasVac,
				'tiposDiscapacidad'=>$tiposDiscapacidad,
				'modeloTipodiscValnutr'=>$modeloTipodiscValnutr,
				'tiposDiscAdol'=>$tiposDiscAdol,
				'consLecheMat'=>$consLecheMat,
				'consBiberon'=>$consBiberon,
				'modeloOrigenalimValnutr'=>$modeloOrigenalimValnutr,
				'origenAlimentosHogar'=>$origenAlimentosHogar,
				'origenAlimentos'=>$origenAlimentos,
				'apetito'=>$apetito,
				'ingesta'=>$ingesta,
				'masticacion'=>$masticacion,
				'digestion'=>$digestion,
				'habitoIntestinal'=>$habitoIntestinal,
				'nivelActFisica'=>$nivelActFisica,
				'frecConsumo'=>$frecConsumo,
				'grupoComida'=>$grupoComida,
				//frecuencia de consumo
				'modeloGrupocomidaValnutr'=>$modeloGrupocomidaValnutr,
				//estado actual
				'modeloAntropometria'=>$modeloAntropometria,
				'antropometriaAdol'=>$antropometriaAdol,
				//plan dietario
				'modeloNutricionAdol'=>$modeloNutricionAdol,
				'tiempoAlimento'=>$tiempoAlimento,	
				'planDietario'=>$planDietario,	
				'modeloGrupocomidaNutradol'=>$modeloGrupocomidaNutradol,	
				'modeloPorcionesComida'=>$modeloPorcionesComida,
				'estadoCompVal'=>$estadoCompVal,
				'modeloEsquemaVacunacion'=>$modeloEsquemaVacunacion,
				'render'=>'valoracionNutrForm',
			));			
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos por campo de valoración e instancia a modelo para realizar la modificación.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionNutricional
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $variables contiene el nombre de las variables enviadas por post
	 *	@param array $variablesii contiene un array del nombre de variables del subarray de variables.
	 *	@return json $resultado de la transacción.
	 */
	public function actionRegistraCampoTextoValNutr(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(empty($dataInput["numDocAdolValNutr"])&&empty($dataInput["idValNutr"])){
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>"Datos inválidos para la creación del registro"));
			}
			else{
				$variables=array_keys($dataInput);			
				$variablesii=array_keys($dataInput[$variables[0]]);
				if(!empty($dataInput["ValoracionNutricional"][$variablesii[0]])){
					$modeloValNutr=new ValoracionNutricional();
					$modeloValNutr->id_val_nutricion=$dataInput["idValNutr"];
					$modeloValNutr->num_doc=$dataInput["numDocAdolValNutr"];
					$valNutr=$modeloValNutr->consultaIdValNutr();
					if($dataInput["ValoracionNutricional"][$variablesii[0]]!==$valNutr[$variablesii[0]]){
						$modeloValNutr->nombreCampoValoracion=$variablesii[0];
						$modeloValNutr->contenidoValoracion=$dataInput["ValoracionNutricional"][$variablesii[0]];
						if(empty($valNutr["fecha_ini_vnutr"])){
							$modeloValNutr->campoFecha="fecha_ini_vnutr";
							$modeloValNutr->fecha=date("Y-m-d");
							$accion=1;
						}
						else{
							$modeloValNutr->campoFecha="fecha_modif_vnutr";
							$modeloValNutr->fecha=date("Y-m-d");
							$accion=2;
							if(!empty($variablesii[0])){
								$modeloValNutr->contHist=$valNutr[$variablesii[0]];
								$modeloValNutr->regHistoricoValNutr(); 
							}							
						}
						$restultado=$modeloValNutr->modificaValoracionNutr($accion); 
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$restultado));
					}
					else{
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>"exito"));
					}
				}
				else
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>"exito"));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	/**
	 *	Recibe datos por campo de valoración e instancia a modelo para realizar la modificación.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionNutricional
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $variables contiene el nombre de las variables enviadas por post
	 *	@param array $variablesii contiene un array del nombre de variables del subarray de variables.
	 *	@return json $resultado de la transacción.
	 */
	public function actionRegistraFrecCons(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){						
			$datosInput=Yii::app()->input->post();
			$modeloGrupocomidaValnutr=new GrupocomidaValnutr();
			$modeloGrupocomidaValnutr->attributes=$datosInput["GrupocomidaValnutr"];
			if($modeloGrupocomidaValnutr->validate()){
				$consultaFrecGrCom=$modeloGrupocomidaValnutr->consultaFrecuenciaConsObs();
				if(!empty($consultaFrecGrCom)){
					$resultado=$modeloGrupocomidaValnutr->modificaFrecCons();
					$resultado="exito";
				}
				else{
					$resultado=$modeloGrupocomidaValnutr->registraFrecCons();	
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado));
				
			}	
			else{
				echo CActiveForm::validate($modeloGrupocomidaValnutr);
			}		
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}

	/**
	 *	Recibe datos formulario de registro del plan dietario instancia a modelo para crear los registros en base de datos.
	 *	Si ha habido modificación en el campo, se registra en base de datos y es guardado un histórico del a información anterior.
	 *
	 *	Modelos instanciados:
	 *		- GrupocomidaNutradol
	 *		- NutricionAdol
	 *		- PorcionesComida
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entidades.
	 *	@return json $resultado de la transacción.
	 */
	public function actionRegistraPlanDietario(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			//print_r($datosInput);exit;
			$modeloGrupocomidaNutradol=new GrupocomidaNutradol();
			$modeloNutricionAdol= new NutricionAdol();
			$modeloPorcionesComida=new PorcionesComida();		
			$modeloGrupocomidaNutradol->attributes=$datosInput["GrupocomidaNutradol"];	
			//$modeloGrupocomidaNutradol->id_nutradol=$datosInput["idNutrAdol"];	
			$porciones=$datosInput["GrupocomidaNutradol"]["grupo_comida"];	
			foreach($porciones as $porcion){
				if(!empty($porcion)){
					$modeloGrupocomidaNutradol->num_porciones=1;
				}				
			}		
			$modeloNutricionAdol->id_cedula='0';	
			$modeloPorcionesComida->attributes=$datosInput["PorcionesComida"];
			if($modeloGrupocomidaNutradol->validate() && $modeloPorcionesComida->validate()){
				//print_r($modeloGrupocomidaNutradol->attributes);exit;

				if(empty($datosInput["idNutrAdol"]) && $datosInput["idTipoActividad"]==1){					
					$modeloNutricionAdol->id_val_nutricion=$datosInput["GrupocomidaNutradol"]["id_val_nutricion"];
					$modeloNutricionAdol->id_tipoact_pld=$datosInput["idTipoActividad"];					
					$resultado=$modeloNutricionAdol->creaRegNutricion();
					if($resultado!="exito"){
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado));
						exit;
					}
					else{
						$modeloGrupocomidaNutradol->id_nutradol=$modeloNutricionAdol->id_nutradol;	
						$modeloPorcionesComida->id_nutradol=$modeloNutricionAdol->id_nutradol;
					}
				}
				else{
					$modeloGrupocomidaNutradol->id_nutradol=$datosInput["idNutrAdol"];
					$modeloPorcionesComida->id_nutradol=$datosInput["idNutrAdol"];	
					$modeloNutricionAdol->id_nutradol=$datosInput["idNutrAdol"];							
				}
				//print_r($porciones);
				//print_r($modeloPorcionesComida->attributes);exit;
				$confirmaPorciones=$modeloGrupocomidaNutradol->consultaConsumPorciones();
				$accion="crear";
				if(!empty($confirmaPorciones)){
					$modeloGrupocomidaNutradol->eliminaPorcionComida();
					$accion="modificar";
				}
				$modeloGrupocomidaNutradol->_porciones=$porciones;
				//print_r($modeloGrupocomidaNutradol->attributes);
				//print_r($modeloGrupocomidaNutradol->_porciones);exit;				
				$resultado=$modeloGrupocomidaNutradol->creaRegPorciones();
				if($resultado=='exito'){
					if($accion=='crear'){
						$resultado=$modeloPorcionesComida->registraPorcionesRec();
					}
					else{
						$resultado=$modeloPorcionesComida->modificaPorcionesRec();
					}
				}				
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado,'idNutrAdol'=>$modeloNutricionAdol->id_nutradol));
			}
			else{
				echo CActiveForm::validate(array($modeloGrupocomidaNutradol,$modeloPorcionesComida,$modeloNutricionAdol));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos por campo de valoración nutricional e instancia a modelo para realizar la modificación.
	 *
	 *	Modelos instanciados:
	 *		- OrigenalimValnutr
	 *		- ValoracionNutricional
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entdiad.
	 *	@param array $variables contiene el nombre de las variables enviadas por post
	 *	@param array $variablesii contiene un array del nombre de variables del subarray de variables.
	 *	@return json $resultado de la transacción.
	 */
	public function actionRegistraCampoGrupoValNutr(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$restultado="Campo(s) vacío(s)";
			//print_r($datosInput);
			$variables=array_keys($datosInput);	
			//print_r($variables);
			$variablesii=array_keys($datosInput["ValoracionNutricional"]);
			if(!empty($datosInput["OrigenalimValnutr"])){
				$modeloOrigenalimValnutr=new OrigenalimValnutr();
				$modeloOrigenalimValnutr->id_val_nutricion=$datosInput["idValNutr"];
				$modeloOrigenalimValnutr->_origenAlimentos=$datosInput["OrigenalimValnutr"]["id_origen_alim"];
				$respuesta=$modeloOrigenalimValnutr->registraOrigenAlimentos();
				//print_r($datosInput["OrigenalimValnutr"]["id_origen_alim"]);				
			}
			
			if(!empty($datosInput["ValoracionNutricional"])){
				foreach($datosInput["ValoracionNutricional"] as $pk=>$contenidoVar){					
					$modeloValNutr=new ValoracionNutricional();
					$modeloValNutr->attributes=$datosInput["ValoracionNutricional"];
					$modeloValNutr->id_val_nutricion=$datosInput["idValNutr"];
					$modeloValNutr->num_doc=$datosInput["numDocAdolValNutr"];
					if($modeloValNutr->validate()){
						$valNutr=$modeloValNutr->consultaIdValNutr();
						//echo $pk." = ".$datosInput["ValoracionNutricional"][$pk]."<br/>";
						if($datosInput["ValoracionNutricional"][$pk]=="false"){
							$datosInput["ValoracionNutricional"][$pk]='f';
						}
						elseif($datosInput["ValoracionNutricional"][$pk]=="true"){
							$datosInput["ValoracionNutricional"][$pk]='t';						
						}
						if($datosInput["ValoracionNutricional"][$pk]!=$valNutr[$pk]){
							$modeloValNutr->nombreCampoValoracion=$pk;
							$modeloValNutr->contenidoValoracion=$datosInput["ValoracionNutricional"][$pk];
							if(empty($valNutr["fecha_ini_vnutr"])){
								$modeloValNutr->campoFecha="fecha_ini_vnutr";
								$modeloValNutr->fecha=date("Y-m-d");
								$accion=1;
							}
							else{
								$modeloValNutr->campoFecha="fecha_modif_vnutr";
								$modeloValNutr->fecha=date("Y-m-d");
								$accion=2;
								$modeloValNutr->contHist=$valNutr[$pk];
								if(!empty($modeloValNutr->contHist)){
									$modeloValNutr->regHistoricoValNutr(); 
								}
							}
							$restultado=$modeloValNutr->modificaValoracionNutr($accion); 							
						}
						else{
							$restultado="exito";
						}
					}
					else{
						echo CActiveForm::validate($modeloValNutr);
						exit;
					}					
				}				
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$restultado));
				//print_r($variablesii);
			}
			else{
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>"No hay datos para registrar"));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos formulario de registro de laboratorios clínicos e instancia a modelo para crear los registros en base de datos.
	 *	Si ha habido modificación en el campo, se registra en base de datos y es guardado un histórico del a información anterior.
	 *
	 *	Modelos instanciados:
	 *		- LabclinValnutr
	 *
	 *	@param array $dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entidades.
	 *	@return json $resultado de la transacción.
	 */
	public function actionRegistraLabClinico(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloLabclinValnutr=new LabclinValnutr();
			$modeloLabclinValnutr->attributes=$datosInput["LabclinValnutr"];
			$modeloLabclinValnutr->id_val_nutricion=$datosInput["idValNutr"];
			if($modeloLabclinValnutr->validate()){
				if($modeloLabclinValnutr->id_laboratorio==0){
					$modeloLabclinValnutr->_labExtr=$datosInput["LabclinValnutr"]["_labExtr"];
					$modeloLabclinValnutr->id_laboratorio=$modeloLabclinValnutr->creaExamenLab();
					$resultado=$modeloLabclinValnutr->registraLabClinico();		
				}
				else{
					$labClinicosAdol=$modeloLabclinValnutr->consLabClinicoAdol();
					if(!empty($labClinicosAdol)){
						$resultado="exito";
						if($labClinicosAdol["resultado_labclin"]!=$modeloLabclinValnutr->resultado_labclin || $labClinicosAdol["fecha_reslabclin"]!=$modeloLabclinValnutr->fecha_reslabclin){
							$modeloLabclinValnutr->contHist=serialize($labClinicosAdol);
							$modeloLabclinValnutr->id_campovalnutr="laboratorio_clinico";			
							$modeloLabclinValnutr->nombreCampoValoracion="entidad";
							if(!empty($modeloLabclinValnutr->contHist)){
								$modeloLabclinValnutr->regHistoricoLabClin(); 
							}
							$resultado=$modeloLabclinValnutr->modificaLabClinico();						
						}
					}
					else{
						$resultado=$modeloLabclinValnutr->registraLabClinico();		
					}
				}									
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado));
			}
			else{
				echo CActiveForm::validate($modeloLabclinValnutr);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos formulario de registro tipos de discapacidad e instancia a modelo para crear los registros en base de datos.
	 *	Si ha habido modificación en el campo, se registra en base de datos y es guardado un histórico del a información anterior.
	 *
	 *	Modelos instanciados:
	 *		- TipodiscValnutr
	 *
	 *	@param array	$dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entidades.
	 *	@param int		$modeloTipodiscValnutr->_grupoDiscapacidad código de tipo de discapacidad.s
	 *	@return json 	$resultado de la transacción.
	 */
	public function actionRegistraDiscapacidadValNutr(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();					
			$modeloTipodiscValnutr=new TipodiscValnutr();			
			if(isset($datosInput["TipodiscValnutr"]["id_tipo_discap"]) && !empty($datosInput["TipodiscValnutr"]["id_tipo_discap"])){
				$modeloTipodiscValnutr->id_tipo_discap=1;
			}
			$modeloTipodiscValnutr->id_val_nutricion=$datosInput["TipodiscValnutr"]["id_val_nutricion"];
			if($modeloTipodiscValnutr->validate()){
				$modeloTipodiscValnutr->_grupoDiscapacidad=$datosInput["TipodiscValnutr"]["id_tipo_discap"];
				$resultado=$modeloTipodiscValnutr->registraDiscapacidad();	
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado));
			}
			else{
				echo CActiveForm::validate($modeloTipodiscValnutr);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario esquema de vacunación de la valoración en nutrición e instancia a modelo para crear los registros en base de datos.
	 *	Si ha habido modificación en el campo, se registra en base de datos y es guardado un histórico del a información anterior.
	 *
	 *	Modelos instanciados:
	 *		- EsquemaVacunacion
	 *
	 *	@param array	$dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entidades.
	 *	@return json 	$resultado de la transacción.
	 */
	public function actionRegistraEsquemaVac(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();	
			$modeloEsquemaVacunacion=new EsquemaVacunacion();
			$modeloEsquemaVacunacion->attributes=$datosInput["ValoracionNutricional"];
			$modeloValNutr=new ValoracionNutricional();
			if($modeloEsquemaVacunacion->validate()){
				foreach($datosInput["ValoracionNutricional"] as $pk=>$contenidoVar){
					//if(!empty($contenidoVar)){
						$modeloValNutr->id_val_nutricion=$datosInput["idValNutr"];
						$modeloValNutr->num_doc=$datosInput["numDocAdolValNutr"];
						$valNutr=$modeloValNutr->consultaIdValNutr();
						//echo $pk." = ".$datosInput["ValoracionNutricional"][$pk]."<br/>";
						if($datosInput["ValoracionNutricional"][$pk]!=$valNutr[$pk]){
							$modeloValNutr->nombreCampoValoracion=$pk;
							$modeloValNutr->contenidoValoracion=$datosInput["ValoracionNutricional"][$pk];
							if(empty($valNutr["fecha_ini_vnutr"])){
								$modeloValNutr->campoFecha="fecha_ini_vnutr";
								$modeloValNutr->fecha=date("Y-m-d");
								$accion=1;
							}
							else{
								$modeloValNutr->campoFecha="fecha_modif_vnutr";
								$modeloValNutr->fecha=date("Y-m-d");
								$accion=2;
								$modeloValNutr->contHist=$valNutr[$pk];
								if(!empty($modeloValNutr->contHist)){
									$modeloValNutr->regHistoricoValNutr(); 
								}
							}
							$restultado=$modeloValNutr->modificaValoracionNutr($accion); 							
						}
						else{
							$restultado="exito";
						}
					//}
				}				
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$restultado));
			}
			else{
				echo CActiveForm::validate($modeloEsquemaVacunacion);
			}				
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario esquema de vacunación de la valoración en nutrición e instancia a modelo para crear los registros en base de datos.
	 *	Si ha habido modificación en el campo, se registra en base de datos y es guardado un histórico del a información anterior.
	 *
	 *	Modelos instanciados:
	 *		- EsquemaVacunacion
	 *
	 *	@param array	$dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entidades.
	 *	@return json 	$resultado de la transacción.
	 */
	public function actionRegistraAntropometriaValIni(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();	
			$modeloAntropometria=new Antropometria();
			$modeloAntropometria->attributes=$datosInput["Antropometria"];	
			$modeloAntropometria->id_val_nutricion=$datosInput["idValNutr"];
			//print_r($modeloAntropometria->attributes);	
			if($modeloAntropometria->validate()){
				$resultado=$modeloAntropometria->registraAntropometria();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado,'idNutricion'=>$modeloAntropometria->id_antropometria));
			}
			else{
				echo CActiveForm::validate($modeloAntropometria);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario antropometría de la valoración en nutrición e instancia a modelo para crear los registros en base de datos.
	 *	Si ha habido modificación en el campo, se registra en base de datos y es guardado un histórico del a información anterior.
	 *
	 *	Modelos instanciados:
	 *		- Antropometria
	 *
	 *	@param array	$dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entidades.
	 *	@return json 	$resultado de la transacción.
	 */
	public function actionModifAntropometriaValIni(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();	
			$modeloAntropometria=new Antropometria();
			$modeloAntropometria->attributes=$datosInput["Antropometria"];	
			$modeloAntropometria->id_val_nutricion=$datosInput["idValNutr"];
			$modeloAntropometria->id_antropometria=$datosInput["Antropometria"]["id_antropometria"];
			//print_r($antropometriaAdol);		
			//print_r($datosInput["Antropometria"]);			
			$resultado="exito";
			if($modeloAntropometria->validate()){
				$antropometriaAdol=$modeloAntropometria->consultaAntropValNutr();
				foreach($datosInput["Antropometria"] as $pk=>$antrop){
					//echo "<pre>".$pk." ".$datosInput["Antropometria"][$pk]." ".$antropometriaAdol[$pk]."</pre>";	
					if($datosInput["Antropometria"][$pk]!=$antropometriaAdol[$pk]){
						//echo $pk." cambia a ".$datosInput["Antropometria"][$pk]."<br>";	
						$modeloAntropometria->nombreCampo=$pk;
						$modeloAntropometria->contenido=$datosInput["Antropometria"][$pk];
						$resultado=$modeloAntropometria->modificaAntropometria();
						if($resultado!="exito"){
							echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado));		
							exit;
						}		
					}								
				}
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado,"idNutricion"=>$modeloAntropometria->id_antropometria));		
			}
			else{
				echo CActiveForm::validate($modeloAntropometria);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario antropometría de la valoración en nutrición e instancia a modelo para crear los registros en base de datos.
	 *	Si ha habido modificación en el campo, se registra en base de datos y es guardado un histórico del a información anterior.
	 *
	 *	Modelos instanciados:
	 *		- ValoracionNutricional
	 *
	 *	@param array	$dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entidades.
	 *	@return json 	$resultado de la transacción.
	 */
	public function actionValidaDilValoracionNutr(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="valoracionNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloValNutr=new ValoracionNutricional();			
			$modeloValNutr->id_val_nutricion=$datosInput["idValNutr"];
			$consultaInfEsch=$modeloValNutr->conultaInfEsch();			
			$estado="true";
			$numCaracteres=Yii::app()->params['num_caracteres'];
			foreach($consultaInfEsch as $esquema){
				$modeloValNutr->nombreCampoValoracion="";
				$modeloValNutr->nombreCampoValoracion=$esquema["column_name"];
				$contenidoVal=$modeloValNutr->consultaContenidoCampo();
				$nombresCampos=$modeloValNutr->attributeLabels();				
				if($esquema["udt_name"]=='text'){
					if($esquema["column_name"]!='observ_estvalnutr' && $esquema["column_name"]!='obs_esquema_vac' && $esquema["column_name"]!='obs_crec_des'){
						if(strlen($contenidoVal[$modeloValNutr->nombreCampoValoracion])<$numCaracteres){
							$estado="false";
							$camposVacios[]=$nombresCampos[$modeloValNutr->nombreCampoValoracion];
						}
					}
					else{
						$camposEsp[$modeloValNutr->nombreCampoValoracion]=$contenidoVal[$modeloValNutr->nombreCampoValoracion];
						//echo $modeloValNutr->nombreCampoValoracion." ".$camposEsp[$modeloValNutr->nombreCampoValoracion]."<br>";
					}
				}						
			}
			foreach($consultaInfEsch as $esquema){			
				$modeloValNutr->nombreCampoValoracion="";
				$modeloValNutr->nombreCampoValoracion=$esquema["column_name"];
				$contenidoVal=$modeloValNutr->consultaContenidoCampo();
				$nombresCampos=$modeloValNutr->attributeLabels();
				if($esquema["data_type"]=='integer'){
					if(empty($contenidoVal[$modeloValNutr->nombreCampoValoracion]) && $modeloValNutr->nombreCampoValoracion!="id_estado_val"){
						$estado="false";
						$camposVacios[]=$nombresCampos[$modeloValNutr->nombreCampoValoracion];
					}
					elseif($modeloValNutr->nombreCampoValoracion=='id_esquema_vac' && $contenidoVal[$modeloValNutr->nombreCampoValoracion]==3 && strlen($camposEsp['obs_esquema_vac'])<$numCaracteres){
						$estado="false";
						$camposVacios[]=$camposEsp['obs_esquema_vac'];						
					}
				}		
			}
			foreach($consultaInfEsch as $esquema){			
				$modeloValNutr->nombreCampoValoracion="";
				$modeloValNutr->nombreCampoValoracion=$esquema["column_name"];
				$contenidoVal=$modeloValNutr->consultaContenidoCampo();
				$nombresCampos=$modeloValNutr->attributeLabels();
				if($esquema["udt_name"]=='varchar'){
					if($esquema["column_name"]!='tiempo_lactancia' && $esquema["column_name"]!='tiempo_biberon'){
						if(empty($contenidoVal[$modeloValNutr->nombreCampoValoracion])){
							$estado="false";
							$camposVacios[]=$nombresCampos[$modeloValNutr->nombreCampoValoracion];
						}
					}
				}		
			}
			
			
			$consultasGenerales=new ConsultasGenerales();
			$linkBd=$consultasGenerales->conectaBDSinPdo();
			foreach($consultaInfEsch as $esquema){
				$modeloValNutr->nombreCampoValoracion="";
				$modeloValNutr->nombreCampoValoracion=$esquema["column_name"];
				$contenidoVal=$modeloValNutr->consultaContenidoCampoBool($linkBd,$esquema["column_name"]);
				$nombresCampos=$modeloValNutr->attributeLabels();
				if($esquema["udt_name"]=='bool'){
					//print_r($contenidoVal);
					if($modeloValNutr->nombreCampoValoracion!="estado_val_nutr"){
						if(empty($contenidoVal[$modeloValNutr->nombreCampoValoracion]) && $modeloValNutr->nombreCampoValoracion!="val_hab_nutr"){
							$estado="false";
							$camposVacios[]=$nombresCampos[$modeloValNutr->nombreCampoValoracion];
						}
						elseif($contenidoVal[$modeloValNutr->nombreCampoValoracion]=='f' && strlen($camposEsp['obs_crec_des'])<$numCaracteres && $modeloValNutr->nombreCampoValoracion=='control_crec_des'){
							$estado="false";
							$camposVacios[]=$nombresCampos["obs_crec_des"];						
						}
					}
				}		
			}
			pg_close($linkBd);
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$estado,'camposVacios'=>$camposVacios));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
		$numCaracteres=Yii::app()->params['num_caracteres'];
	}
	
	
	//consulta valoraciones
	
	/**
	 *	Acción que renderiza la vista que contiene el formulario de consulta de la valoración en nutrición.
	 *
	 *	Vista a renderizar:
	 *		- _valoracionNutrForm 
	 *		- _valoracionNutrFormCons.
	 *	 
	 *	Vistas relacionadas
	 *		- _valoracionNutrAntSalud
	 *		- _valoracionNutrExamenes
	 *		- _valoracionNutrAntAlim
	 *		- _valoracionNutrEstadoActual.
	 *		- _valoracionNutrResultados.
	 *		- _valoracionNutrPlanDietario.
	 *		- _valoracionNutrEstado.
	 *		- _valoracionNutrEstadoActual.
	 *		- _valoracionNutrAntSaludCons.
	 *		- _valoracionNutrExamenesCons.
	 *		- _valoracionNutrAntAlimCons.
	 *		- _valoracionNutrEstadoActualCons.
	 *		- _valoracionNutrResultadosCons.
	 *		- _valoracionNutrPlanDietarioCons.
	 *		- _valoracionNutrEstadoCons.
	 *	 
	 *	Modelos instanciados:   				
	 *		- ForjarAdol
	 *		- Telefono
	 * 		- LabclinValnutr
	 * 		- TipodiscValnutr.
	 * 		- OrigenalimValnutr.
	 * 		- GrupocomidaValnutr.
	 * 		- GrupocomidaNutradol.
	 * 		- Antropometria.
	 * 		- PorcionesComida.
	 * 		- NutricionAdol.
	 * 		- EsquemaVacunacion.
	 * 		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 * 		- Familia.
	 * 		- Familiar.
	 *	
	 *	@param string	$numDocAdol,	
	 *	@param array	$datosAdol,
	 *	@param object	$modeloValNutr,
	 *	@param int		$idValNutr,
	 *	@param int		$edad,
	 *	@param boolean	$estadoCompVal,
	 *	@param int		$estadoAdol,
	 *	@param array	$tipoParto,
	 *	@param object	$modeloFamilia,
	 *	@param object	$modeloFamiliar,
	 *	@param array	$grupoFamiliar,
	 *	@param object	$modeloTelefono,
	 *	@param array	$nivelEduc,
	 *	@param array	$parentesco,
	 *		//laboratorios clinicos
	 *	@param object	$modeloLabclinValnutr,
	 *	@param array	$labClinicosAdol,
	 *	@param array	$laboratorios,
	 *	@param array	$laboratoriosExtra,
	 *	@param array	$esquemasVac,
	 *	@param array	$tiposDiscapacidad,
	 *	@param object	$modeloTipodiscValnutr,
	 *	@param array	$tiposDiscAdol,
	 *	@param array	$consLecheMat,
	 *	@param array	$consBiberon,
	 *	@param object	$modeloOrigenalimValnutr,
	 *	@param array	$origenAlimentosHogar,
	 *	@param array	$origenAlimentos,
	 *	@param array	$apetito,
	 *	@param array	$ingesta,
	 *	@param array	$masticacion,
	 *	@param array	$digestion,
	 *	@param array	$habitoIntestinal,
	 *	@param array	$nivelActFisica,
	 *	@param array	$frecConsumo,
	 *	@param array	$grupoComida,
	 *	frecuencia de consumo
	 *	@param object	$modeloGrupocomidaValnutr,
	 *	//estado actual
	 *	@param object	$modeloAntropometria,
	 *	@param array	$antropometriaAdol,
	 *	//plan dietario
	 *	@param object	$modeloNutricionAdol,
	 *	@param array	$tiempoAlimento,	
	 *	@param array	$planDietario,	
	 *	@param object	$modeloGrupocomidaNutradol,	
	 *	@param object	$modeloPorcionesComida,
	 *	@param int		$estadoCompVal,
	 *	@param object	$modeloEsquemaVacunacion,
	 */		
	 public function actionConsultaValNutr(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultaValNutr";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloValNutr=new ValoracionNutricional();
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
				$modeloTelefono=new Telefono();
				$modeloLabclinValnutr=new LabclinValnutr();
				$modeloTipodiscValnutr=new TipodiscValnutr();
				$modeloOrigenalimValnutr=new OrigenalimValnutr();
				$modeloGrupocomidaValnutr=new GrupocomidaValnutr();
				$modeloGrupocomidaNutradol=new GrupocomidaNutradol();
				$modeloAntropometria= new Antropometria();
				$modeloNutricionAdol= new NutricionAdol();
				$modeloPorcionesComida=new PorcionesComida();
				$modeloEsquemaVacunacion=new EsquemaVacunacion();
				$modeloForjarAdol->num_doc=$numDocAdol;
				$modeloValNutr->num_doc=$numDocAdol;
				$estadoAdol=$modeloForjarAdol->consultaDatosForjarAdol();								
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));				
				$valNutr=$modeloValNutr->consultaIdValNutr();
				$modeloValNutr->attributes=$valNutr;
				//consulta tablas primarias
				$tipoParto=$consultaGeneral->consultaEntidades('tipo_parto','id_tipo_parto');
				$parentesco=$consultaGeneral->consultaEntidades('parentesco','id_parentesco');
				$laboratorios=$consultaGeneral->consultaEntidades('laboratorio_clinico','id_laboratorio');				
				$esquemasVac=$consultaGeneral->consultaEntidades('esquema_vacunacion','id_esquema_vac');
				$tiposDiscapacidad=$consultaGeneral->consultaEntidades('tipo_discapacidad','id_tipo_discap');
				$origenAlimentos=$consultaGeneral->consultaEntidades('origen_alimentos','id_origen_alim');
				$apetito=$consultaGeneral->consultaEntidades('apetito','id_apetito');
				$ingesta=$consultaGeneral->consultaEntidades('ingesta','id_ingesta');
				$masticacion=$consultaGeneral->consultaEntidades('masticacion','id_masticacion');
				$digestion=$consultaGeneral->consultaEntidades('digestion','id_digestion');
				$habitoIntestinal=$consultaGeneral->consultaEntidades('habito_intestinal','id_hab_intest');
				$nivelActFisica=$consultaGeneral->consultaEntidades('nivel_act_fis','id_nivel_act_fis');
				$frecConsumo=$consultaGeneral->consultaEntidades('frecuencia_consumo','id_frec_cons');
				$grupoComida=$consultaGeneral->consultaEntidades('grupo_comida','id_grupo_comida');
				$tiempoAlimento=$consultaGeneral->consultaEntidades('tiempo_alimento','id_tiempo_alimento');
				$estadoCompVal=$consultaGeneral->consutlaEstadoCompVal();
				//consulta grupo familiar
				$modeloFamilia=new Familia();
				$modeloFamiliar=new Familiar();
				$modeloFamiliar->num_docAdolFam=$numDocAdol;
				$grupoFamiliar=$modeloFamiliar->consultaFamiliarAdol();
				$nivelEduc=$consultaGeneral->consultaEntidades('nivel_educativo','id_nivel_educ');
				//registrar valoración del adolescente si no tiene
				if(empty($valNutr)){
					$idValNutr=$modeloValNutr->creaRegValNutrAdol();
				}
				else{
					$idValNutr=$valNutr["id_val_nutricion"];
				}
				$modeloValNutr->id_val_nutricion=$idValNutr;
				//consulta tablas secundarias valnutr				
				//consulta si recibió leche materan
				$modeloTipodiscValnutr->id_val_nutricion=$idValNutr;
				$consLecheMat=$modeloValNutr->consRecibLecheMat();
				//consulta si recibió bibierón
				$consBiberon=$modeloValNutr->consRecibBiberon();
				//consulta tipos de discapacidad del adolescente
				$tiposDiscAdol=$modeloTipodiscValnutr->consultaTiposDiscAdol();
				//consulta origen alimentos en el hogar
				$modeloOrigenalimValnutr->id_val_nutricion=$idValNutr;
				$origenAlimentosHogar=$modeloOrigenalimValnutr->consultaOrigenAlimentosHogar();
				//consulta antropometría de la valoración
				$modeloAntropometria->id_val_nutricion=$idValNutr;
				$antropometriaAdol=$modeloAntropometria->consultaAntropValNutr();
				//consulta plan dietario
				$modeloNutricionAdol->id_val_nutricion=$idValNutr;
				$modeloNutricionAdol->id_tipoact_pld=1;
				$planDietario=$modeloNutricionAdol->consultaPlanDietario();								
				$modeloLabclinValnutr->id_val_nutricion=$idValNutr;
				$laboratoriosExtra=$modeloLabclinValnutr->consLabClinicosExtra();
				$labClinicosAdol=$modeloLabclinValnutr->consLabClinicosAdol();
				//consulta tiempo de valoración si ya está caduco.
			}	
			
			$this->render("_valoracionNutrFormCons",array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'modeloValNutr'=>$modeloValNutr,
				'idValNutr'=>$idValNutr,
				'edad'=>$edad,
				'estadoCompVal'=>$estadoCompVal,
				'render'=>'valoracionNutrForm',
				'estadoAdol'=>$estadoAdol,
				'tipoParto'=>$tipoParto,
				'modeloFamilia'=>$modeloFamilia,
				'modeloFamiliar'=>$modeloFamiliar,
				'grupoFamiliar'=>$grupoFamiliar,
				'modeloTelefono'=>$modeloTelefono,
				'nivelEduc'=>$nivelEduc,
				'parentesco'=>$parentesco,
				//laboratorios clinicos
				'modeloLabclinValnutr'=>$modeloLabclinValnutr,
				'labClinicosAdol'=>$labClinicosAdol,
				'laboratorios'=>$laboratorios,
				'laboratoriosExtra'=>$laboratoriosExtra,
				'esquemasVac'=>$esquemasVac,
				'tiposDiscapacidad'=>$tiposDiscapacidad,
				'modeloTipodiscValnutr'=>$modeloTipodiscValnutr,
				'tiposDiscAdol'=>$tiposDiscAdol,
				'consLecheMat'=>$consLecheMat,
				'consBiberon'=>$consBiberon,
				'modeloOrigenalimValnutr'=>$modeloOrigenalimValnutr,
				'origenAlimentosHogar'=>$origenAlimentosHogar,
				'origenAlimentos'=>$origenAlimentos,
				'apetito'=>$apetito,
				'ingesta'=>$ingesta,
				'masticacion'=>$masticacion,
				'digestion'=>$digestion,
				'habitoIntestinal'=>$habitoIntestinal,
				'nivelActFisica'=>$nivelActFisica,
				'frecConsumo'=>$frecConsumo,
				'grupoComida'=>$grupoComida,
				//frecuencia de consumo
				'modeloGrupocomidaValnutr'=>$modeloGrupocomidaValnutr,
				//estado actual
				'modeloAntropometria'=>$modeloAntropometria,
				'antropometriaAdol'=>$antropometriaAdol,
				//plan dietario
				'modeloNutricionAdol'=>$modeloNutricionAdol,
				'tiempoAlimento'=>$tiempoAlimento,	
				'planDietario'=>$planDietario,	
				'modeloGrupocomidaNutradol'=>$modeloGrupocomidaNutradol,	
				'modeloPorcionesComida'=>$modeloPorcionesComida,
				'estadoCompVal'=>$estadoCompVal,
				'modeloEsquemaVacunacion'=>$modeloEsquemaVacunacion,
				'render'=>'consultaValNutr',
			));			
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
//*********************************************************** PERFIL OCUPACIONAL ***************************************************************//

	/**
	 *	Acción que renderiza la vista que contiene el formulario de registro del perfil ocupacional del adolescente.
	 *
	 *	Vista a renderizar:
	 *		- _perfilOcupacionalForm 
	 *	 
	 *	Vistas relacionadas
	 *		- _valoracionNutrAntSalud
	 *		- _valoracionNutrExamenes
	 *	 
	 *	Modelos instanciados:   				
	 *		- AspectoValteo
	 *		- FactorVteo
	 * 		- ValoracionTeo
	 * 		- OperacionesGenerales
	 * 		- ConsultasGenerales
	 *	
	 *	@param object	$modeloAspectoValTO,
	 *	@param object	$modeloValTO,
	 *	@param string	$numDocAdol,
	 *	@param array	$datosAdol,					
	 *	@param int		$edad,
	 *	@param array	$valTO,
	 *	@param array	$aspectosPerfOc,
	 *	@param object	$modeloFactorVteo,
	 *	@param array	$consultaAspectoValTO
	 */		
	public function actionPerfilOcupacionalForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="perfilOcupacionalForm";
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
				$modeloAspectoValTO=new AspectoValteo();
				$modeloFactorVteo=new FactorVteo();
				$modeloValTO=new ValoracionTeo();
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);					
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));				
		
				$modeloValTO->num_doc=$numDocAdol;
				$valTO=$modeloValTO->consultaIdValTO();
				$modeloValTO->attributes=$valTO;
				
				$aspectosPerfOc=$modeloAspectoValTO->consultaAspectoPerfOc();
				if(!empty($valTO)){					
					$modeloValTO->id_valor_teo=$valTO["id_valor_teo"];
					$modeloAspectoValTO->id_valor_teo=$modeloValTO->id_valor_teo;
					$consultaAspectoValTO=$modeloAspectoValTO->consultaAspectosValTo();
					if(empty($consultaAspectoValTO)){
						$modeloAspectoValTO->creaAspectoValTo();
						$consultaAspectoValTO=$modeloAspectoValTO->consultaAspectosValTo();
					}
				}	
			}
			$this->render("_perfilOcupacionalForm",array(
				'modeloAspectoValTO'=>$modeloAspectoValTO,
				'modeloValTO'=>$modeloValTO,
				'numDocAdol'=>$numDocAdol,
				'datosAdol'=>$datosAdol,					
				'edad'=>$edad,
				'valTO'=>$valTO,
				'aspectosPerfOc'=>$aspectosPerfOc,
				'modeloFactorVteo'=>$modeloFactorVteo,
				'consultaAspectoValTO'=>$consultaAspectoValTO
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}


	/**
	 *	Recibe datos del formulario perfil ocupacional e instancia a modelo para crear los registros en base de datos.
	 *
	 *	Modelos instanciados:
	 *		- FactorVteo
	 *		- AspectoValteo
	 *
	 *	@param array	$dataInput	contiene datos de adolescente, id de valoración, nombre de campo, texto de campo y nombre de entidades.
	 *	@return json 	$resultado de la transacción.
	 */
	public function actionRegistraAspectoValTo(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="perfilOcupacionalForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){			
			$modeloFactorVteo=new FactorVteo();
			$datosInput=Yii::app()->input->post();
			//print_r($datosInput);exit;
			$modeloFactorVteo->attributes=$datosInput["FactorVteo"];
			$modeloAspectoValTO=new AspectoValteo();
			$modeloAspectoValTO->id_aspectovteo=$datosInput["FactorVteo"]["id_aspectovteo"];
			$modeloAspectoValTO->observacion_aspecto=$datosInput["obsAspectoValTO"];
			$modeloAspectoValTO->porcentaje_factor=$datosInput["porcentaje"];						
			$modeloFactorVteo->id_aspectovteo=$datosInput["FactorVteo"]["id_aspectovteo"];
			
			$modeloFactorVteo->factorGrado=$datosInput["factorGrado"];

			//print_r($modeloFactorVteo->factorGrado);exit;
			$modeloFactorVteo->delAspectoFactVto();
			$resultado=$modeloFactorVteo->creaFactorAspectoVTeo();
			if($resultado=="exito"){
				$resultado=$modeloAspectoValTO->actDatosAspectoValTO();
			}
			echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));		
		}	
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}


	// Uncomment the following methods and override them if needed
	/*
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