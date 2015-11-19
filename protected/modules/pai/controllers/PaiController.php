<?php
///!  Clase controlador del módulo Pai (Plan de atención integral).  
/**
 * @author Félix Mauricio Vargas Hincapié <femauro@gmail.com>
 * @copyright Copyright &copy; Félix Mauricio Vargas Hincapié 2015
 */

Yii::import('application.modules.modIdenReg.models.ForjarAdol');	

class PaiController extends Controller{
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
		return array(
			'enforcelogin',
			array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()),
			array('application.filters.ActionVerifEstadoFilter + actualizarPAI','num_doc'=>Yii::app()->getSession()->get('numDocAdol'))
		);
	}
	
	/**
	 * renderiza vista index
	 */
	public function actionIndex()
	{
		$this->render('index');
	}
	
	/**
	 *	Acción que renderiza la vista que contiene los formularios para registrar el plan de atención integral del adolescente.
	 *
	 *	Vista a renderizar:
	 *		- _creaModifPai.
	 *
	 *	Formularios contenidos:
	 *		- _consInfJudAdmonAc				formulario consulta de la información judicial del adolescente
	 *		- _formVerificacionDerForjarCons	formulario de verificación de derechos realizada en la valoración psicosocial.
	 *		- _paiCreaModForm/_paiConsForm 		formulario de diligenciamiento del plan de atención integral por componentes de derecho y sanción
	 *		- _paiSeguimiento					formulario para hacer seguimiento de cada uno de los componentes del pai
	 *		- _culminacionPai					formulario para diligenciar la culminación del PAI.
	 *
	 *	Modelos instanciados:
	 *		- ForjarAdol
	 * 		- DerechoAdol
	 * 		- ComponenteDerecho
	 * 		- InformacionJudicial
	 * 		- ComponenteSancion
	 * 		- OperacionesGenerales
	 * 		- SeguimientoCompderecho.
	 * 		- SeguimientoCompsancion.
	 *
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
	 *	@param string	$instanciaRem
	 *	@param int 		$espProcJud estado del proceso judicial
	 *	@param array	$delitoRem
	 *	@param object	$modeloInfJud
	 *	@param array	$infJudicial
	 *	@param array	$compSancInfJud
	 *	@param int		$tipoSancion'=>$tipoSancion,
	 *	@param array	$infJudicialPai
	 *	@param object	$modeloSegComDer
	 *	@param object	$modeloSegComSanc
	 *	@param array	$consultaDerechoAdol
	 *	@param array	$consultaGeneral
	 */		
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
					//$infJudSinPai=$modeloInfJud->consultaInfJudPai();
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
								//print_r($resInfJud);
								$compSancInfJud[]=$resInfJud;
							}
						}
						else{
							$compSancInfJud[]=$infJudicialCompSan;
						}
					}
					/*if(!empty($infJudSinPai)){
						foreach($infJudSinPai as $infJud){
							$compSancInfJud[]=$infJud;							
						}						
					}*/
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
	/**
	 *	Acción que renderiza la vista que contiene la información del plan de atención integral para consulta.
	 *
	 *	Vista a renderizar:
	 *		- _consultaPAITabs.
	 *
	 *	Formularios contenidos:
	 *		- _consInfJudAdmonAc				formulario consulta de la información judicial del adolescente
	 *		- _formVerificacionDerForjarCons	formulario de verificación de derechos realizada en la valoración psicosocial.
	 *		- _paiConsForm				 		formulario de diligenciamiento del plan de atención integral por componentes de derecho y sanción
	 *		- _paiSeguientoCons					formulario para hacer seguimiento de cada uno de los componentes del pai
	 *
	 *	Modelos instanciados:
	 *		- ForjarAdol
	 * 		- DerechoAdol
	 * 		- ComponenteDerecho
	 * 		- InformacionJudicial
	 * 		- ComponenteSancion
	 * 		- OperacionesGenerales
	 * 		- SeguimientoCompderecho.
	 * 		- SeguimientoCompsancion.
	 *
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
	 *	@param string	$instanciaRem
	 *	@param int 		$espProcJud estado del proceso judicial
	 *	@param array	$delitoRem
	 *	@param object	$modeloInfJud
	 *	@param array	$infJudicial
	 *	@param array	$compSancInfJud
	 *	@param int		$tipoSancion'=>$tipoSancion,
	 *	@param array	$infJudicialPai
	 *	@param object	$modeloSegComDer
	 *	@param object	$modeloSegComSanc
	 *	@param array	$consultaDerechoAdol
	 *	@param array	$consultaGeneral
	 */		
	public function actionConsultarPAITabs(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultarPAITabs";
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
					$modeloInfJud->idPai=$idPai;
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
			$this->render('_consultaPAITabs',array(
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
	/**
	 *	Recibe datos del formulario de registro de un componente de derecho del plan de atención integral, instancia a modelo para registrar en base de datos.
	 *
	 *	Modelos instanciados:
	 *		- ComponenteDerecho
	 *
	 *	@param array $dataInput array de datos del formulario por componente derecho de pai
	 *	@return json resultado de la transacción.
	 */		
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
	/**
	 *	Recibe datos del formulario de registro del plan de atención integral e instancia a modelo para registrar-modificar en base de datos
	 *	si la información del campo en específico no ha cambiado no realiza registro de actualización. 
	 *
	 *	Modelos instanciados:
	 *		- ComponenteDerecho
	 *
	 *	@param array $_POST["ComponenteSancion"] array de datos del formulario pai haciendo referencia a un componente derecho del adolescente
	 *	@return json resultado de la transacción.
	 */		
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
	/**
	 *	Recibe datos del formulario de registro del plan de atención integral e instancia a modelo para modificar en base de datos, recibe los datos de componente de sanción
	 *
	 *	Modelos instanciados:
	 *		- ComponenteSancion
	 *
	 *	@param array $_POST["ComponenteSancion"] array de datos del formulario pai haciendo referencia a un componente sanción del pai
	 *	@return json resultado de la transacción.
	 */		
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
	/**
	 *	Recibe datos del formulario de registro del plan de atención integral e instancia a modelo para registrar-modificar en base de datos, recibe los datos de componente de sanción
	 *	si la información del campo en específico no ha cambiado no realiza registro de actualización. 
	 *
	 *	Modelos instanciados:
	 *		- ComponenteSancion
	 *
	 *	@param array $_POST["ComponenteSancion"] array de datos del formulario pai haciendo referencia a un componente sanción del pai
	 *	@return json resultado de la transacción.
	 */		
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
	/**
	 *	Recibe datos del formulario de registro del seguimiento del componente derecho al cual se le realiza el seguimiento e instancia a modelo para modificar en base de datos
	 *
	 *	Modelos instanciados:
	 *		- SeguimientoCompderecho
	 *
	 *	@param array $dataInput["SeguimientoCompderecho"] array de datos del formulario pai array de datos proveniente de Yii::app()->input->post()
	 *	@return json resultado de la transacción.
	 */		
	public function actionRegSegPaiDer(){
		$dataInput=Yii::app()->input->post();
			if(!isset($dataInput["SeguimientoCompderecho"]["id_pai"])&&empty($dataInput["SeguimientoCompderecho"]["id_pai"])||!isset($dataInput["SeguimientoCompderecho"]["id_derechocespa"])&&empty($dataInput["SeguimientoCompderecho"]["id_derechocespa"])||!isset($dataInput["SeguimientoCompderecho"]["fecha_estab_compderecho"])&&empty($dataInput["SeguimientoCompderecho"]["fecha_estab_compderecho"])){
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
		}
		else{
			$modeloSegCompDer=new SeguimientoCompderecho();
			$modeloSegCompDer->attributes=$dataInput["SeguimientoCompderecho"];
			$modeloSegCompDer->fecha_estab_compderecho=$dataInput["SeguimientoCompderecho"]["fecha_estab_compderecho"];
			$modeloSegCompDer->fecha_seguim_compderecho="aux";
			//print_r($modeloSegCompDer->attributes);exit;
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
	/**
	 *	Recibe datos del formulario de registro del seguimiento del componente sanción al cual se le realiza el seguimiento e instancia a modelo para modificar en base de datos
	 *
	 *	Modelos instanciados:
	 *		- SeguimientoCompsancion
	 *
	 *	@param array $dataInput["SeguimientoCompsancion"] array de datos del formulario pai array de datos proveniente de Yii::app()->input->post()
	 *	@return json resultado de la transacción.
	 */		
	public function actionRegSegPaiSanc(){
		$dataInput=Yii::app()->input->post();
			if(!isset($dataInput["SeguimientoCompsancion"]["id_pai"])&&empty($dataInput["SeguimientoCompsancion"]["id_pai"])||!isset($dataInput["SeguimientoCompsancion"]["id_inf_judicial"])&&empty($dataInput["SeguimientoCompsancion"]["id_inf_judicial"])||!isset($dataInput["SeguimientoCompsancion"]["fecha_establec_compsanc"])&&empty($dataInput["SeguimientoCompsancion"]["fecha_establec_compsanc"])){
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("Datos inválidos para la creación del registro"))));
		}
		else{
			$modeloSegComSanc=new SeguimientoCompsancion();
			$modeloSegComSanc->attributes=$dataInput["SeguimientoCompsancion"];
			//$modeloSegComSanc->fecha_establec_compsanc=$dataInput["SeguimientoCompderecho"]["fecha_establec_compsanc"];
			$modeloSegComSanc->fecha_seguim_compsancion="aux";
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
	
	/**
	 *	Recibe datos del formulario de culminación de pai y llama a modelo para registrar la culminación
	 *
	 *	Modelos instanciados:
	 *		- SeguimientoCompsancion
	 *
	 *	@param array $dataInput["Pai"] 
	 *	@param array $dataInput["num_doc"] 
	 *	@return json resultado de la transacción.
	 */		
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
	/**
	 *	Acción que renderiza la vista que contiene los formularios para registrar el plan de atención integral del adolescente.
	 *
	 *	Vista a renderizar:
	 *		- _actualizaPai.
	 *
	 *	Formularios contenidos:
	 *		- _consInfJudAdmonAc				formulario consulta de la información judicial del adolescente
	 *		- _formVerificacionDerForjarCons	formulario de verificación de derechos realizada en la valoración psicosocial.
	 *		- _paiCreaModForm/_paiConsForm 		formulario de diligenciamiento del plan de atención integral por componentes de derecho y sanción
	 *		- _paiSeguimiento					formulario para hacer seguimiento de cada uno de los componentes del pai
	 *		- _culminacionPai					formulario para diligenciar la culminación del PAI.
	 *
	 *	Modelos instanciados:
	 *		- ForjarAdol
	 * 		- DerechoAdol
	 * 		- ComponenteDerecho
	 * 		- InformacionJudicial
	 * 		- ComponenteSancion
	 * 		- OperacionesGenerales
	 * 		- SeguimientoCompderecho.
	 * 		- SeguimientoCompsancion.
	 *
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
	 *	@param string	$instanciaRem
	 *	@param int 		$espProcJud estado del proceso judicial
	 *	@param array	$delitoRem
	 *	@param object	$modeloInfJud
	 *	@param array	$infJudicial
	 *	@param array	$compSancInfJud
	 *	@param int		$tipoSancion'=>$tipoSancion,
	 *	@param array	$infJudicialPai
	 *	@param object	$modeloSegComDer
	 *	@param object	$modeloSegComSanc
	 *	@param array	$consultaDerechoAdol
	 *	@param array	$consultaGeneral
	 */		
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