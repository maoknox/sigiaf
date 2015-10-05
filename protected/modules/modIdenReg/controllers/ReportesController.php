<?php
Yii::import('application.modules.seguimientoAdol.models.SeguimientoPsc');	
Yii::import('application.modules.modIdenReg.models.ForjarAdol');	
Yii::import('application.modules.gestionSeguimSJ.models.SeguimientoAsesoriasj');	
Yii::import('application.modules.gestionSeguimSJ.models.GestionSociojuridica');	
Yii::import('application.modules.valoracionIntegral.models.NutricionAdol');	
Yii::import('application.modules.valoracionIntegral.models.ValoracionNutricional');	

class ReportesController extends Controller{
	public function filterEnforcelogin($filterChain){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403,"Debe loguearse primero");
		}
		$filterChain->run();
	}
	
	public function filters(){
		return array('enforcelogin',array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()));
	}

	public function actionReporteVII()
	{	
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="reporteVII";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($_POST["numDocAdol"]) && !empty($_POST["numDocAdol"])){
				$consultaGeneral=new ConsultasGenerales();
				$operaciones=new OperacionesGenerales();
				$modeloVerifDerechos=new DerechoAdol();		
				$modeloPai=new Pai();
				$modeloInfJud=new InformacionJudicial();
				$modeloCompSanc=new ComponenteSancion();
				$consultaGeneral->numDocAdol=$datosInput["numDocAdol"];
				$adolescente=$consultaGeneral->consultaAdolescenteSede();	
				$this->renderPartial('_informeVII',
					array(
						'adolescente'=>$adolescente,
						'consultaGeneral'=>$consultaGeneral,
						'operaciones'=>$operaciones,
						'modeloPai'=>$modeloPai,
						'modeloInfJud'=>$modeloInfJud,
						'modeloCompSanc'=>$modeloCompSanc,												
					)
				);
			}
			else{
				$this->render('index',array('accion'=>$controlAcceso->accion));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}

	public function actionInformePAI(){	
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="informePAI";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($_POST["numDocAdol"]) && !empty($_POST["numDocAdol"])){
				$consultaGeneral=new ConsultasGenerales();
				$operaciones=new OperacionesGenerales();
				$modeloPai=new Pai();
				$modeloCompDer=new ComponenteDerecho();
				$modeloCompSanc=new ComponenteSancion();
				$modeloInfJud=new InformacionJudicial();
				$consultaGeneral->numDocAdol=$datosInput["numDocAdol"];
				$adolescente=$consultaGeneral->consultaAdolescenteSede();	
				$derechos=$consultaGeneral->consultaDerechos();
				$modeloPai->num_doc=$datosInput["numDocAdol"];
				$paiActual=$modeloPai->consultaPAIActual();
				$modeloPai->attributes=$paiActual;
				$idPai=$modeloPai->id_pai;
				$modeloCompDer->id_pai=$idPai;
				$modeloCompSanc->id_pai=$idPai;
				//consulta Participación
				$participacion=$consultaGeneral->consultaParticipacion();
				//consulta Protección
				$proteccion=$consultaGeneral->consultaProteccion();
				$modeloInfJud->num_doc=$datosInput["numDocAdol"];
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
						if($modeloPai->id_pai==$resInfJud["id_pai"]){
							$compSancInfJud[]=$resInfJud;
						}
					}
				}
				$this->renderPartial('_informePAI',
					array(
						'adolescente'=>$adolescente,
						'consultaGeneral'=>$consultaGeneral,
						'operaciones'=>$operaciones,
						'modeloPai'=>$modeloPai,
						'modeloInfJud'=>$modeloInfJud,
						'modeloCompSanc'=>$modeloCompSanc,
						'modeloCompDer'=>$modeloCompDer,
						'numDocAdol'=>$datosInput["numDocAdol"],	
						'derechos'=>$derechos,
						'participacion'=>$participacion,
						'proteccion'=>$proteccion,
						'modeloInfJud'=>$modeloInfJud,
						'infJudicialSanPai'=>$compSancInfJud,
						'compSancInfJud'=>$compSancInfJud,
						'infJudicialPai'=>$infJudicialPai,
						'consultaDerechoAdol'=>$consultaDerechoAdol,
						'accion'=>$controlAcceso->accion
					)
				);
			}
			else{
				$this->render('index',array('accion'=>$controlAcceso->accion));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionInformeSeguimiento()
	{	
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="informeSeguimiento";
		$permiso=$controlAcceso->controlAccesoAcciones();
		$mensaje="";
		//echo $mes;
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($_POST["numDocAdol"]) && !empty($_POST["numDocAdol"]) && isset($_POST["fecha_reporte"]) && !empty($_POST["fecha_reporte"])){
				$consultaGeneral=new ConsultasGenerales();
				$operaciones=new OperacionesGenerales();
				$modeloVerifDerechos=new DerechoAdol();		
				$modeloPai=new Pai();
				$modeloInfJud=new InformacionJudicial();
				$modeloCompSanc=new ComponenteSancion();
				$consultaGeneral->numDocAdol=$datosInput["numDocAdol"];
				$adolescente=$consultaGeneral->consultaAdolescenteSede();	
				$modeloSeguimiento=new SeguimientoAdol();
				$modeloSegRefer=new SeguimientoRefer();
				$modeloSeguimiento->fecha_inicial=$datosInput["fecha_reporte"];
				$modeloSeguimiento->num_doc=$datosInput["numDocAdol"];
				$fecha=split("-",$modeloSeguimiento->fecha_inicial);
				$diaFin=date("d",(mktime(0,0,0,$fecha[1]+1,1,$fecha[0])-1));
				$modeloSeguimiento->fecha_fin=$fecha[0]."-".$fecha[1]."-".$diaFin;
				$modeloSeguimiento->seg_posegreso='false';
				$modeloSeguimiento->seg_extraordinario='false';
				$seguimientos=$modeloSeguimiento->consultaSeguimiento();
				//SEGUIMIENTO POST EGRESO
				$seguimientoPEgreso="";
				$modeloForjarAdol=new ForjarAdol();
				$modeloForjarAdol->num_doc=$datosInput["numDocAdol"];
				$datosForjarAdol=$modeloForjarAdol->consultaDatosForjarAdol();
				if(!empty($datosForjarAdol) && $datosForjarAdol["id_estado_adol"]==2){
					$modeloSeguimiento->seg_posegreso='true';
					$seguimientoPEgreso=$modeloSeguimiento->consultaSeguimiento();
				}
				//seguimiento psc
				$modeloPsc=new Psc();
				$modeloPsc->num_doc=$datosInput["numDocAdol"];
				$pscAdol=$modeloPsc->consultaPscInformeSeg();
				$modeloSegPsc=new SeguimientoPsc();
				//Seguimiento referenciación
				$modeloRef=new ReferenciacionAdol();
				$modeloRef->numDocRef=$datosInput["numDocAdol"];
				$servicios=$modeloRef->consultaReferenciacionAdol();
				$modeloSegRefer=new SeguimientoRefer();
				//Seguimiento de gestiones socio jurídicas.
				$modeloGestionSociojuridica= new GestionSociojuridica();
				$modeloSeguimientoAsesoriasj=new SeguimientoAsesoriasj();
				$modeloGestionSociojuridica->num_doc=$datosInput["numDocAdol"];
				$gestionesSJAdol=$modeloGestionSociojuridica->consultaGestionesSJAdol();	
				//seguimiento nutricional
				$modeloValNutr=new ValoracionNutricional();
				$modeloValNutr->num_doc=$datosInput["numDocAdol"];
				$valNutr=$modeloValNutr->consultaIdValNutr();
				if(!empty($valNutr)){
					$modeloValNutr->id_val_nutricion=$valNutr["id_val_nutricion"];
					$modeloNutricionAdol= new NutricionAdol();
					$modeloNutricionAdol->id_val_nutricion=$valNutr["id_val_nutricion"];
					$modeloNutricionAdol->id_tipoact_pld=2;				
					$seguimientosNutr=$modeloNutricionAdol->consultaNutricionAdolSeg();
				}
				$this->renderPartial('_informeSeguimiento',
					array(
						'adolescente'=>$adolescente,
						'consultaGeneral'=>$consultaGeneral,
						'operaciones'=>$operaciones,
						'modeloPai'=>$modeloPai,
						'modeloInfJud'=>$modeloInfJud,
						'modeloCompSanc'=>$modeloCompSanc,	
						'fecha_reporte'=>$datosInput["fecha_reporte"],
						'seguimientos'=>$seguimientos,
						'fecha_inicial'=>$modeloSeguimiento->fecha_inicial,
						'fecha_fin'=>$modeloSeguimiento->fecha_fin,
						'modeloSeguimiento'=>$modeloSeguimiento,
						'servicios'=>$servicios,
						'modeloRef'=>$modeloRef,
						'modeloSegRefer'=>$modeloSegRefer,
						'pscAdol'=>$pscAdol,
						'modeloSegPsc'=>$modeloSegPsc,
						'seguimientoPEgreso'=>$seguimientoPEgreso,
						'gestionesSJAdol'=>$gestionesSJAdol,
						'modeloGestionSociojuridica'=>$modeloGestionSociojuridica,
						'seguimientosNutr'=>$seguimientosNutr,
						'valNutr'=>$valNutr,
					)
				);
			}
			else{
				$this->render('indexFecha',array('accion'=>$controlAcceso->accion));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}

	public function actionReporteAdolescentes(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="reporteAdolescentes";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$consultaGeneral=new ConsultasGenerales();
			$operaciones=new OperacionesGenerales();
			$modeloVerifDerechos=new DerechoAdol();				
			$adolescentes=$consultaGeneral->consultaAdolescentesSede();		
			$this->renderPartial('_reporteAdolescentes',array(
				'adolescentes'=>$adolescentes,
				'consultaGeneral'=>$consultaGeneral,
				'operaciones'=>$operaciones,
				'modeloVerifDerechos'=>$modeloVerifDerechos,
			));	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	public function actionReporteAdolCambioDoc(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="reporteAdolCambioDoc";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$consultaGeneral=new ConsultasGenerales();
			$operaciones=new OperacionesGenerales();
			$adolescentes=$consultaGeneral->consultaAdolescentesSede();		
			$this->renderPartial('_consultaAdolCamDoc',array(
				'adolescentes'=>$adolescentes,
				'consultaGeneral'=>$consultaGeneral,
				'operaciones'=>$operaciones,
			));	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
		
	}
	public function actionConsumoSPARep(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consumoSPARep";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$consultaGeneral=new ConsultasGenerales();
			$operaciones=new OperacionesGenerales();
			$this->renderPartial('_consumoSPA',array(
				'consultaGeneral'=>$consultaGeneral,
				'operaciones'=>$operaciones
			));	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionProblematicasAsoc(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="problematicasAsoc";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$consultaGeneral=new ConsultasGenerales();
			$operaciones=new OperacionesGenerales();
			$this->renderPartial('_problemasAsociados',array(
				'consultaGeneral'=>$consultaGeneral,
				'operaciones'=>$operaciones
			));	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	public function actionAntecedentesFam(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="antecedentesFam";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$consultaGeneral=new ConsultasGenerales();
			$operaciones=new OperacionesGenerales();
			$this->renderPartial('_antecedentesFamiliares',array(
				'consultaGeneral'=>$consultaGeneral,
				'operaciones'=>$operaciones
			));	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionAfiliacionSalud(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="afiliacionSalud";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$consultaGeneral=new ConsultasGenerales();
			$operaciones=new OperacionesGenerales();
			$this->renderPartial('_afiliacionSGSS',array(
				'consultaGeneral'=>$consultaGeneral,
				'operaciones'=>$operaciones
			));	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	public function actionConsultarEstadoValsForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultarEstadoValsForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		$modeloPersona=new Persona();
		$funcionarios=$modeloPersona->consultaFuncionarioValoracion();
		if($permiso["acceso_rolmenu"]==1){
			if(!empty($_POST)){
				$datosInput=Yii::app()->input->post();
				$idCedula=$datosInput["Persona"]["id_cedula"];
				$fechaIniRep=$datosInput["fecha_inicio"];
				$fechaFinRep=$datosInput["fecha_fin_reporte"];
				$modeloUsuario=new Usuario();
				$modeloUsuario->id_cedula=$idCedula;
				$datosUsuario=$modeloUsuario->consultaUsuarioVal();
				$modeloConsultasGenerales=new ConsultasGenerales();
			}			
			$this->render("_consultarEstadoValsForm",
				array(
					"funcionarios"=>$funcionarios,
					"modeloPersona"=>$modeloPersona,
					"idCedula"=>$idCedula,
					"fechaIniRep"=>$fechaIniRep,
					"fechaFinRep"=>$fechaFinRep,
					"datosUsuario"=>$datosUsuario,
					"modeloConsultasGenerales"=>$modeloConsultasGenerales
				)
			);
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