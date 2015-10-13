<?php
Yii::import('application.modules.modIdenReg.models.ForjarAdol');	
Yii::import('application.modules.planpostegreso.models.PlanPostegreso');	
Yii::import('application.modules.valoracionIntegral.models.Antropometria');	
Yii::import('application.modules.valoracionIntegral.models.NutricionAdol');	
Yii::import('application.modules.valoracionIntegral.models.PorcionesComida');	
Yii::import('application.modules.valoracionIntegral.models.GrupocomidaNutradol');	
Yii::import('application.modules.valoracionIntegral.models.ValoracionNutricional');	

class SeguimientoAdolController extends Controller{
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
			array('application.filters.ActionVerifEstadoFilter + consPscSeg seguimientoNutrForm','num_doc'=>Yii::app()->getSession()->get('numDocAdol'))
		);
	}
	public function actionRegistrarSeg(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="registrarSeg";
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
				$modeloPlanPostegreso=new PlanPostegreso();
				$modeloSeguimiento=new SeguimientoAdol();
				$modeloPsc=new Psc();
				$modeloAsistenciaPsc=new AsistenciaPsc();
				$modeloSeguimientoPsc=new SeguimientoPsc();
				$modeloInfJud=new InformacionJudicial();
				$modeloPai= new Pai();
				$modeloPai->num_doc=$numDocAdol;				
				$paiAdol=$modeloPai->consultaPAIActual();													
				if(empty($paiAdol)){					
					$modeloPlanPostegreso->num_doc=$numDocAdol;
					$planPEgreso=$modeloPlanPostegreso->consultaPlanPe();	
					$modeloPlanPostegreso->attributes=$planPEgreso;
					$modeloPai->id_pai=$modeloPlanPostegreso->id_pai;
					$paiAdol=$modeloPai->consultaPAIPlanPE();
					$modeloPai->attributes=$paiAdol;						
				}						
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloInfJud->num_doc=$numDocAdol;
				$modeloSeguimiento->num_doc=$numDocAdol;
				$infJudicial=$modeloInfJud->consultaInfJud();
				/*if(!empty($infJudicial)){
					foreach($infJudicial as $pk=>$infJudicialNov){
						$infJud=$modeloInfJud->consultaInfJudNov($infJudicialNov["id_inf_judicial"]);
						if(!empty($infJud)){
							$infJudicial[$pk]=$infJud;
						}			
					}
				}*/
				$tipoSeguimiento=$consultaGeneral->consTipoSeguimiento();
				$areaDisc=$consultaGeneral->consAreaDisciplina();
				$seguimientos=$modeloSeguimiento->consSegAdol();
				$seguimientoPosEgreso=$modeloSeguimiento->consSegAdolPosEgreso();
				$modeloPsc->num_doc=$numDocAdol;
				$pscSinCulm=$modeloPsc->consultaPscSinCulm();	
				$seguimientoPsc=$modeloSeguimientoPsc->consSeguimientosPsc();
				$pscDes=$modeloPsc->consultaPscSeg(0);
				$offset=0;
	
			//Yii::app()->user->getState('rol');
			}
			$this->render('_registrarSegForm',array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'modeloInfJud'=>$modeloInfJud,
				'infJudicial'=>$infJudicial,
				'modeloSeguimiento'=>$modeloSeguimiento,
				'tipoSeguimiento'=>$tipoSeguimiento,
				'areaDisc'=>$areaDisc,
				'seguimientos'=>$seguimientos,
				'seguimientoPosEgreso'=>$seguimientoPosEgreso,
				'modeloPsc'=>$modeloPsc,
				'pscSinCulm'=>$pscSinCulm,
				'modeloSeguimientoPsc'=>$modeloSeguimientoPsc,
				'modeloAsistenciaPsc'=>$modeloAsistenciaPsc,
				'pscDes'=>$pscDes,
				'offset'=>$offset,
				'paiAdol'=>$paiAdol
					
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionConsProf(){
		$dataInput=Yii::app()->input->post();
		if(isset($_POST["idSegConj"]) && !empty($_POST["idSegConj"])){
			if($dataInput["idSegConj"]!=1){
				$consultaGeneral=new ConsultasGenerales();
				$consultaGeneral->searchTerm=$dataInput["idSegConj"];
				$prof=$consultaGeneral->consultaProfSeg();
				if(!empty($prof)){
					echo CJSON::encode($prof);
				}
				else{
					echo CJSON::encode(array(""=>""));	
				}
			}
			else{
				echo CJSON::encode(array(""=>""));	
			}
		}
	}
	
	public function actionRegistraSegimiento(){
		$dataInput=Yii::app()->input->post();
		if(isset($_POST["SeguimientoAdol"]) && !empty($_POST["SeguimientoAdol"])){
			$modeloSeguimiento=new SeguimientoAdol();
			$modeloSeguimiento->attributes=$dataInput["SeguimientoAdol"];
			if($modeloSeguimiento->validate()){
				if($_POST["SeguimientoAdol"]["seguim_conj"]==1){$modeloSeguimiento->seguim_conj='false';}else{$modeloSeguimiento->seguim_conj='true';}
				$resultado=$modeloSeguimiento->registraSeguimiento();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloSeguimiento);
			}
		}
	}
		public function actionRegistraSegimientoPe(){
		$dataInput=Yii::app()->input->post();
		if(isset($_POST["SeguimientoAdol"]) && !empty($_POST["SeguimientoAdol"])){
			$modeloSeguimiento=new SeguimientoAdol();
			$modeloSeguimiento->attributes=$dataInput["SeguimientoAdol"];
			if($modeloSeguimiento->validate()){
				if($_POST["SeguimientoAdol"]["seguim_conj"]==1){$modeloSeguimiento->seguim_conj='false';}else{$modeloSeguimiento->seguim_conj='true';}
				$resultado=$modeloSeguimiento->registraSeguimientoPe();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloSeguimiento);
			}
		}
	}
	public function actionCompFechaAsistencia(){
		$dataInput=Yii::app()->input->post();
		if(!empty($_POST["date"]) && !empty($_POST["id_psc"])&& !empty($_POST["num_doc"])){
			$modeloSegPsc=new SeguimientoPsc();
			$modeloSegPsc->id_psc=$dataInput["id_psc"];
			$modeloSegPsc->num_doc=$dataInput["num_doc"];			
			$modeloSegPsc->fechaAsistencia=$dataInput["date"];	
			$resultado=$modeloSegPsc->compFechaAsistencia();	
			if(!empty($resultado)){
				echo CJSON::encode(array("resultado"=>CJavaScript::encode(CJavaScript::quote("false"))));
			}
			else{
				echo CJSON::encode(array("resultado"=>CJavaScript::encode(CJavaScript::quote("true"))));
			}	
		}
	}
	public function actionRegistraSegimientoPSC(){
		$dataInput=Yii::app()->input->post();
		if(isset($_POST["SeguimientoPsc"]) && !empty($_POST["SeguimientoPsc"]) && isset($_POST["AsistenciaPsc"]) && !empty($_POST["AsistenciaPsc"])){
			$modeloSeguimientoPsc=new SeguimientoPsc();
			$modeloAsistenciaPsc=new AsistenciaPsc();		
			$consultaGeneral=new ConsultasGenerales();
			$modeloSeguimientoPsc->attributes=$dataInput["SeguimientoPsc"];
			$modeloAsistenciaPsc->attributes=$dataInput["AsistenciaPsc"];
			//print_r($_POST);
			if($dataInput["numFechas"]==0){
				$modeloAsistenciaPsc->fecha_asist_psc="";
			}
			else{
				for($i=1;$i<=$dataInput["numFechas"];$i++){
					$fecha = date('w', strtotime($dataInput["AsistenciaPsc"]["inpFecha_".$i]));
					$numHoras=$consultaGeneral->consultaNumHoras($dataInput["SeguimientoPsc"]["id_psc"],$dataInput["SeguimientoPsc"]["num_doc"],$fecha);
					$modeloSeguimientoPsc->fechas[]=array('fecha'=>$dataInput["AsistenciaPsc"]["inpFecha_".$i],'horas'=>$numHoras);
				}
			}
			//print_r($modeloAsistenciaPsc->attributes);
			if($modeloSeguimientoPsc->validate() && $modeloAsistenciaPsc->validate()){
				//if($_POST["SeguimientoAdolPsc"]["seguim_conj"]==1){$modeloSeguimiento->seguim_conj='false';}else{$modeloSeguimiento->seguim_conj='true';}
				$resultado=$modeloSeguimientoPsc->registraSeguimientoPsc();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate(array($modeloSeguimientoPsc,$modeloAsistenciaPsc));
			}
		}
	}
	public function actionConsultarPsc(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultarPsc";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloPsc=new Psc();
			$modeloDatosTelefono=new Telefono();
			$consGen=new ConsultasGenerales();	
			$operaciones=new OperacionesGenerales();
			$datosAdol="";
			$edad="";
			$telefono="";
			$dataInput=Yii::app()->input->post();
			if(isset($dataInput["offset"]) && !empty($dataInput["offset"])){
				$offset=$dataInput["offset"];
			}
			else{
				$offset=0;
			}
			if(isset($_POST["numDocAdol"]) && !empty($_POST["numDocAdol"])){
				$numDocAdol=htmlspecialchars(strip_tags(trim($_POST["numDocAdol"])));
				Yii::app()->getSession()->add('numDocAdol',htmlspecialchars(strip_tags(trim($_POST["numDocAdol"]))));
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$datosAdol=$consGen->consultaDatosAdol($numDocAdol);
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$telefono=$modeloDatosTelefono->consultaTelefono($numDocAdol);
				$modeloPsc->num_doc=$numDocAdol;
				$pscDes=$modeloPsc->consultaPscSeg($offset);
			}
			//consulta Instancia remisora
			$this->render('_consultaPSC',
				array(
					'modeloPsc'=>$modeloPsc,
					'pscDes'=>$pscDes,
					'numDocAdol'=>$numDocAdol,
					'datosAdol'=>$datosAdol,
					'edad'=>$edad,
					'telefono'=>$telefono,
					'offset'=>$offset
				)
			);		
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	public function actionConsPscSeg(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consPscSeg";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloPsc=new Psc();
			$modeloInfJud=new InformacionJudicial();					
			$modeloDatosTelefono=new Telefono();
			$consGen=new ConsultasGenerales();	
			$operaciones=new OperacionesGenerales();
			$datosAdol="";
			$edad="";
			$telefono="";
			$dataInput=Yii::app()->input->post();
			if(isset($dataInput["offset"]) && !empty($dataInput["offset"])){
				$offset=$dataInput["offset"];
			}
			else{
				$offset=0;
			}
			if(isset($_POST["numDocAdol"]) && !empty($_POST["numDocAdol"])){
				$numDocAdol=htmlspecialchars(strip_tags(trim($_POST["numDocAdol"])));
				Yii::app()->getSession()->add('numDocAdol',htmlspecialchars(strip_tags(trim($_POST["numDocAdol"]))));
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$datosAdol=$consGen->consultaDatosAdol($numDocAdol);
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$telefono=$modeloDatosTelefono->consultaTelefono($numDocAdol);
				$modeloPsc->num_doc=$numDocAdol;
				$pscDes=$modeloPsc->consultaPscSeg($offset);
				$modeloInfJud->num_doc=$numDocAdol;
				$modeloSeguimiento->num_doc=$numDocAdol;
				$infJudicial=$modeloInfJud->consultaInfJud();
				if(!empty($infJudicial)){
					foreach($infJudicial as $pk=>$infJudicialNov){
						$infJud=$modeloInfJud->consultaInfJudNov($infJudicialNov["id_inf_judicial"]);
						if(!empty($infJud)){
							$infJudicial[$pk]=$infJud;
						}			
					}
				}
			}
			//consulta Instancia remisora
			$this->render('_consultaPSC',
				array(
					'modeloPsc'=>$modeloPsc,
					'pscDes'=>$pscDes,
					'numDocAdol'=>$numDocAdol,
					'datosAdol'=>$datosAdol,
					'edad'=>$edad,
					'telefono'=>$telefono,
					'offset'=>$offset,
					'infJudicial'=>$infJudicial
				)
			);
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionCargaFormSegPsc(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consPscSeg";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(isset($dataInput["offset"]) && !empty($dataInput["offset"])){
				$offset=$dataInput["offset"];
			}
			else{
				$offset=0;
			}
			if(isset($_POST["numDocAdol"]) && !empty($_POST["numDocAdol"])){
				$numDocAdol=htmlspecialchars(strip_tags(trim($_POST["numDocAdol"])));
				Yii::app()->getSession()->add('numDocAdol',htmlspecialchars(strip_tags(trim($_POST["numDocAdol"]))));
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$modeloPsc=new Psc();
				$modeloInfJud=new InformacionJudicial();					
				$modeloDatosTelefono=new Telefono();
				$modeloAsistenciaPsc=new AsistenciaPsc();
				$modeloSeguimientoPsc=new SeguimientoPsc();
				$consGen=new ConsultasGenerales();	
				$operaciones=new OperacionesGenerales();
				$datosAdol="";
				$edad="";
				$telefono="";			
				$datosAdol=$consGen->consultaDatosAdol($numDocAdol);
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$telefono=$modeloDatosTelefono->consultaTelefono($numDocAdol);
				$modeloPsc->num_doc=$numDocAdol;
				$pscDes=$modeloPsc->consultaPscSeg($offset);
				$modeloInfJud->num_doc=$numDocAdol;
				$modeloSeguimiento->num_doc=$numDocAdol;
				$infJudicial=$modeloInfJud->consultaInfJud();
				if(!empty($infJudicial)){
					foreach($infJudicial as $pk=>$infJudicialNov){
						$infJud=$modeloInfJud->consultaInfJudNov($infJudicialNov["id_inf_judicial"]);
						if(!empty($infJud)){
							$infJudicial[$pk]=$infJud;
						}			
					}
				}
				$modeloPsc->num_doc=$numDocAdol;
				$modeloPsc->id_psc=$dataInput["Psc"]["id_psc"];
				$pscSinCulm=$modeloPsc->consultaPscSegForm();	
				$seguimientoPsc=$modeloSeguimientoPsc->consSeguimientosPsc();
			}
			//consulta Instancia remisora
			$this->render('_segPscForm',
				array(
					'numDocAdol'=>$numDocAdol,	
					//'modeloInfJud'=>$modeloInfJud,
					//'infJudicial'=>$infJudicial,
					//'modeloSeguimiento'=>$modeloSeguimiento,
					'modeloPsc'=>$modeloPsc,
					'pscSinCulm'=>$pscSinCulm,
					'modeloSeguimientoPsc'=>$modeloSeguimientoPsc,
					'modeloPsc'=>$modeloPsc,
					'modeloAsistenciaPsc'=>$modeloAsistenciaPsc,
					'pscDes'=>$pscDes,
					'datosAdol'=>$datosAdol,
					'edad'=>$edad,
					'telefono'=>$telefono,
					'offset'=>$offset
				)
			);		
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
/*************************************************** SEGUIMIENTO PLA DIETARIO ****************************************************************/

	public function actionSeguimientoNutrForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="seguimientoNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloValNutr=new ValoracionNutricional();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$modeloAntropometria= new Antropometria();
				$modeloNutricionAdol= new NutricionAdol();
				$modeloPorcionesComida=new PorcionesComida();
				$modeloForjarAdol=new ForjarAdol();
				$modeloGrupocomidaNutradol=new GrupocomidaNutradol();
				$modeloForjarAdol->num_doc=$numDocAdol;
				$modeloValNutr->num_doc=$numDocAdol;
				$estadoAdol=$modeloForjarAdol->consultaDatosForjarAdol();								
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));				
				$valNutr=$modeloValNutr->consultaIdValNutr();
				$idValNutr=$valNutr["id_val_nutricion"];
				$modeloValNutr->attributes=$valNutr;
				//consulta tablas primarias
				$grupoComida=$consultaGeneral->consultaEntidades('grupo_comida','id_grupo_comida');
				$tiempoAlimento=$consultaGeneral->consultaEntidades('tiempo_alimento','id_tiempo_alimento');
				$estadoCompVal=$consultaGeneral->consutlaEstadoCompVal();
				//consulta antropometría de la valoración
				$modeloAntropometria->id_val_nutricion=$idValNutr;
				$antropometriaAdol=$modeloAntropometria->consultaAntropValNutrSeg();
				//consulta plan dietario
				$modeloNutricionAdol->id_val_nutricion=$idValNutr;
				$modeloNutricionAdol->id_tipoact_pld=2;				
				$seguimientosNutr=$modeloNutricionAdol->consultaNutricionAdolSeg();
				$seguimPlanDietario=$modeloNutricionAdol->consultaPlanDietarioSeg();
						
			}
			$this->render('_segNutrForm',array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'modeloValNutr'=>$modeloValNutr,
				'valNutr'=>$valNutr,
				'idValNutr'=>$idValNutr,
				'edad'=>$edad,
				'estadoAdol'=>$estadoAdol,
				//laboratorios clinicos
				'grupoComida'=>$grupoComida,
				//frecuencia de consumo
				'modeloGrupocomidaValnutr'=>$modeloGrupocomidaValnutr,
				//estado actual
				'modeloAntropometria'=>$modeloAntropometria,
				'antropometriaAdol'=>$antropometriaAdol,
				//plan dietario
				'modeloNutricionAdol'=>$modeloNutricionAdol,
				'tiempoAlimento'=>$tiempoAlimento,	
				'seguimPlanDietario'=>$seguimPlanDietario,	
				'modeloGrupocomidaNutradol'=>$modeloGrupocomidaNutradol,	
				'modeloPorcionesComida'=>$modeloPorcionesComida,
				'estadoCompVal'=>$estadoCompVal,
				'seguimientosNutr'=>$seguimientosNutr,
				'seguimPlanDietario'=>$seguimPlanDietario				
			));			
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}	
	}
	
	public function actionRegistraSeguimientoNutr(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="seguimientoNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloAntropometria= new Antropometria();
			$modeloNutricionAdol= new NutricionAdol();
			$modeloAntropometria->attributes=$datosInput["Antropometria"];
			$modeloAntropometria->id_antropometria=$datosInput["Antropometria"]["id_antropometria"];
			$modeloNutricionAdol->attributes=$datosInput["NutricionAdol"];
			$modeloNutricionAdol->id_cedula='0';				
			//print_r($datosInput);exit;
			if($modeloNutricionAdol->validate() && $modeloAntropometria->validate()){
				$accion="";
				if($modeloNutricionAdol->id_nutradol=="aux"){
					//crea el registro
					$accion="crea";
					$resultado=$modeloNutricionAdol->creaRegNutricionSeguimiento();
					if($resultado=="exito"){
						$resultado=$modeloAntropometria->registraAntropometria();
						if($resultado="exito"){		
							$modeloAntropometria->idNutricion=$modeloNutricionAdol->id_nutradol;
							$resultado=$modeloAntropometria->registraAntropometriaNutrAdol();	
						}						
					}
				}
				else{
					//modifica el registro
					$accion="modifica";
					/*$restulado=$modeloNutricionAdol->modRegNutricionSeguimiento();
					if($resultado=="exito"){
						$resultado=$modeloAntropometria->modificaAntropometria();						
					}*/
					$resultado="exito";
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado,'accion'=>$accion,"idNutricion"=>$modeloNutricionAdol->id_nutradol,'idAntropometria'=>$modeloAntropometria->id_antropometria));
			}
			else{
				echo CActiveForm::validate(array($modeloAntropometria,$modeloNutricionAdol));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}	
	}
	public function actionConsSegAdol(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consSegAdol";
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
				$modeloPlanPostegreso=new PlanPostegreso();
				$modeloSeguimiento=new SeguimientoAdol();
				$modeloPsc=new Psc();
				$modeloAsistenciaPsc=new AsistenciaPsc();
				$modeloSeguimientoPsc=new SeguimientoPsc();
				$modeloInfJud=new InformacionJudicial();
				$modeloPai= new Pai();
				$modeloPai->num_doc=$numDocAdol;				
				$paiAdol=$modeloPai->consultaPAIActual();													
				if(empty($paiAdol)){					
					$modeloPlanPostegreso->num_doc=$numDocAdol;
					$planPEgreso=$modeloPlanPostegreso->consultaPlanPe();	
					$modeloPlanPostegreso->attributes=$planPEgreso;
					$modeloPai->id_pai=$modeloPlanPostegreso->id_pai;
					$paiAdol=$modeloPai->consultaPAIPlanPE();
					$modeloPai->attributes=$paiAdol;						
				}						
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloInfJud->num_doc=$numDocAdol;
				$modeloSeguimiento->num_doc=$numDocAdol;
				$infJudicial=$modeloInfJud->consultaInfJud();
				/*if(!empty($infJudicial)){
					foreach($infJudicial as $pk=>$infJudicialNov){
						$infJud=$modeloInfJud->consultaInfJudNov($infJudicialNov["id_inf_judicial"]);
						if(!empty($infJud)){
							$infJudicial[$pk]=$infJud;
						}			
					}
				}*/
				$tipoSeguimiento=$consultaGeneral->consTipoSeguimiento();
				$areaDisc=$consultaGeneral->consAreaDisciplina();
				$seguimientos=$modeloSeguimiento->consSegAdol();
				$seguimientoPosEgreso=$modeloSeguimiento->consSegAdolPosEgreso();
				$modeloPsc->num_doc=$numDocAdol;
				$pscSinCulm=$modeloPsc->consultaPscSinCulm();	
				$seguimientoPsc=$modeloSeguimientoPsc->consSeguimientosPsc();
				$pscDes=$modeloPsc->consultaPscSeg(0);
				$offset=0;
	
			//Yii::app()->user->getState('rol');
			}
			$this->render('_consSegForm',array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'modeloInfJud'=>$modeloInfJud,
				'infJudicial'=>$infJudicial,
				'modeloSeguimiento'=>$modeloSeguimiento,
				'tipoSeguimiento'=>$tipoSeguimiento,
				'areaDisc'=>$areaDisc,
				'seguimientos'=>$seguimientos,
				'seguimientoPosEgreso'=>$seguimientoPosEgreso,
				'modeloPsc'=>$modeloPsc,
				'pscSinCulm'=>$pscSinCulm,
				'modeloSeguimientoPsc'=>$modeloSeguimientoPsc,
				'modeloAsistenciaPsc'=>$modeloAsistenciaPsc,
				'pscDes'=>$pscDes,
				'offset'=>$offset,
				'paiAdol'=>$paiAdol
					
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