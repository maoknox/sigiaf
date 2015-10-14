<?php

class AsignacionServicioController extends Controller{
	public function filterEnforcelogin($filterChain){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403,"Debe loguearse primero");
		}
		$filterChain->run();
	}
	public function filters(){
		return array('enforcelogin',array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()));
	}
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionAsignacionServicioForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="asignacionServicioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloRef=new ReferenciacionAdol();
			$modeloFamBenef=new FamiliarBeneficiario();
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$modeloRef->num_doc=$numDocAdol;
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$tipoRef=$consultaGeneral->consultaEntidades('tiporeferenciacion','id_tipo_referenciacion');
				$espNi=$consultaGeneral->consultaEntidades('esp_sol_ni','id_esp_sol');//consulta especificación de nivel i
				$beneficiario=$consultaGeneral->consultaEntidades('beneficiarios','id_beneficiario');//consulta especificación de nivel i
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
			}	
			$this->render('_asignacionServicioForm',array(
				'modeloRef'=>$modeloRef,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'tipoRef'=>$tipoRef,	
				'espNi'=>$espNi,
				'beneficiario'=>$beneficiario,
				'modeloFamBenef'=>$modeloFamBenef
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionBuscaAdolGen(){
		$datos=Yii::app()->input->post();
		$consAdol=new ConsultasGenerales();
		$consAdol->searchTerm=$datos["search_term"];
		$res=$consAdol->buscaAdolGen();
		echo CJSON::encode($res);
	}	//Consulta Municipio segun departamento
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
	public function actionConsEspNiv(){
		if(isset($_POST["id_tiporef"])){
			$datosInput=Yii::app()->input->post();
			$consGen=new ConsultasGenerales();
			$consEspNi=$consGen->consultaNivelEsp($datosInput["id_tiporef"]);
			$consBen=$consGen->consultaBeneficiario($datosInput["id_tiporef"]);
			//echo CHtml::tag('option',array('value'=>''),CHtml::encode('Seleccione un Municipio'),true);
			foreach($consEspNi as $consEspNi){//revsiar
				$consEsp[$consEspNi["id_esp_sol"]]=array("cont"=>$consEspNi["esp_sol"],"idben"=>$consBen["id_beneficiario"]);
    		}
			echo json_encode($consEsp);			
		}
	}
	public function actionConsEspNivii(){
		//print_r($_POST["id_esp_sol"];
		if(isset($_POST["ReferenciacionAdol"]["id_esp_sol"]) && !empty($_POST["ReferenciacionAdol"]["id_esp_sol"])){
			$datosInput=Yii::app()->input->post();
			$consGen=new ConsultasGenerales();
			$consEspNii=$consGen->consultaNivelEspii($datosInput["ReferenciacionAdol"]["id_esp_sol"]);
			if(!empty($consEspNii)){
				echo CHtml::tag('option',array('value'=>''),CHtml::encode('Seleccione una espnii'),true);
				foreach($consEspNii as $consEspNii){//revisar
					echo CHtml::tag('option',array('value'=>$consEspNii["id_esp_solii"]),CHtml::encode($consEspNii["esp_solii"]),true);
				}
			}
			else{
				echo CHtml::tag('option',array('value'=>""),CHtml::encode('Opción sin nivel de especificación'),true);
			}
		}
	}
	public function actionConsEspNiviii(){
		//print_r($_POST["id_esp_sol"];
		if(isset($_POST["ReferenciacionAdol"]["id_esp_solii"]) && !empty($_POST["ReferenciacionAdol"]["id_esp_solii"])){
			$datosInput=Yii::app()->input->post();
			$consGen=new ConsultasGenerales();
			$consEspNii=$consGen->consultaNivelEspiii($datosInput["ReferenciacionAdol"]["id_esp_solii"]);
			if(!empty($consEspNii)){
				echo CHtml::tag('option',array('value'=>''),CHtml::encode('Seleccione una espniii'),true);
				foreach($consEspNii as $consEspNii){//revisar
					echo CHtml::tag('option',array('value'=>$consEspNii["id_esp_solii"]),CHtml::encode($consEspNii["esp_solii"]),true);
				}
			}
			else{
				echo CHtml::tag('option',array('value'=>""),CHtml::encode('Opción sin nivel de especificación'),true);
			}
		}
	}

	public function actionCreaRegRef(){
		$datosInput=Yii::app()->input->post();
		$modeloRef=new ReferenciacionAdol();
		$modeloFamBenef=new FamiliarBeneficiario();
		if(isset($_POST["ReferenciacionAdol"]) && isset($_POST["ReferenciacionAdol"]["num_doc"])){
			$modeloRef->attributes=$_POST["ReferenciacionAdol"];
			$modeloRef->id_referenciacion=0;
			$modeloFamBenef->attributes=$_POST["FamiliarBeneficiario"];
			if($modeloRef->validate()&&$modeloFamBenef->validate()){
				if(!empty($_POST["ReferenciacionAdol"]["id_esp_soliii"])){
					$consSolRef=$modeloRef->consultaSolRefNiii();
				}
				elseif(!empty($_POST["ReferenciacionAdol"]["id_esp_solii"])){
					$consSolRef=$modeloRef->consultaSolRefNii();
				}
				else{
					$consSolRef=$modeloRef->consultaSolRefNi();
				}
				if(empty($consSolRef)){
					$idRef=$modeloRef->creaRegRef();
					if($modeloRef->id_beneficiario!=1&&!empty($modeloFamBenef->nombres_fam_ben)){
						if($idRef!=0){
							$modeloFamBenef->id_referenciacion=$idRef;
							$resultadoFam=$modeloFamBenef->creaRegFamBen();					
						}
					}
					else{
						$resultadoFam="exito";
					}
					echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$modeloRef->mensajeRef,'resultadofam'=>$resultadoFam));
				}
				else{
					echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>"Ya hay una referenciación creada con estas características y cuyo estado es ".$consSolRef["estado_ref"]));
				}
			}
			else{
				echo CActiveForm::validate(array($modeloRef,$modeloFamBenef));
			}
		}
		else{
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>'error','msnError'=>'Ha habido un error en el envío del formulario, comuníquese con el área encargada del Sistema de información'));
		}
	}
	
	
	public function actionConsultaServicioModForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultaServicioModForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloRef=new ReferenciacionAdol();
			$modeloFamBenef=new FamiliarBeneficiario();
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				if(isset($datosInput["offset"]) && !empty($datosInput["offset"])){
					$offset=$datosInput["offset"];
				}
				else{
					$offset=0;
				}				
				$modeloRef->num_doc=$numDocAdol;
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$tipoRef=$consultaGeneral->consultaEntidades('tiporeferenciacion','id_tipo_referenciacion');
				$espNi=$consultaGeneral->consultaEntidades('esp_sol_ni','id_esp_sol');//consulta especificación de nivel i
				$beneficiario=$consultaGeneral->consultaEntidades('beneficiarios','id_beneficiario');//consulta especificación de nivel i
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$datosRef=$modeloRef->consultaRefMod($offset);
			}	
			$this->render('_consultaServicioModForm',array(
				'modeloRef'=>$modeloRef,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'tipoRef'=>$tipoRef,	
				'espNi'=>$espNi,
				'beneficiario'=>$beneficiario,
				'modeloFamBenef'=>$modeloFamBenef,
				'datosRef'=>$datosRef,
				'offset'=>$offset
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionServicioModForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultaServicioModForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloRef=new ReferenciacionAdol();
			$modeloFamBenef=new FamiliarBeneficiario();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$modeloRef->num_doc=$numDocAdol;
				$modeloRef->id_referenciacion=$datosInput["id_referenciacion"];
				$modeloFamBenef->id_referenciacion=$datosInput["id_referenciacion"];
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$modeloRef->attributes=$modeloRef->consultaRefModAdol();
				$datosFamBenef=$modeloFamBenef->consultaRefFamBenef();
				$tipoRef=$consultaGeneral->consultaEntidades('tiporeferenciacion','id_tipo_referenciacion');
				$espNi=$consultaGeneral->consultaEntidades('esp_sol_ni','id_esp_sol');//consulta especificación de nivel i
				$espNii=$consultaGeneral->consultaEntidades('esp_sol_nii','id_esp_solii');
				$espNiii=$consultaGeneral->consultaEntidades('esp_sol_niii','id_esp_soliii');
				$beneficiario=$consultaGeneral->consultaEntidades('beneficiarios','id_beneficiario');//consulta especificación de nivel i
				$estadoRef=$consultaGeneral->consultaEntidades('estado_referenciacion','id_estadoref');
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$profesional=$consultaGeneral->consultaDatosProfesional($modeloRef->id_cedula);
				$rol=$consultaGeneral->consultaEntidades('rol','id_rol');
	
			}	
			$this->render('_servicioModForm',array(
				'modeloRef'=>$modeloRef,
				'numDocAdol'=>$numDocAdol,
				'datosFamBenef'=>$datosFamBenef,
				'tipoRef'=>$tipoRef,
				'espNi'=>$espNi,
				'espNii'=>$espNii,
				'espNiii'=>$espNiii,
				'beneficiario'=>$beneficiario,
				'estadoRef'=>$estadoRef,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'profesional'=>$profesional,
				'rol'=>$rol
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionModificaEstadoRef(){
		$datosInput=Yii::app()->input->post();
		$modeloRef=new ReferenciacionAdol();
		$modeloRef->num_doc=$datosInput["numDocAdol"];
		$modeloRef->id_estadoref=$datosInput["id_estadoref"];
		$modeloRef->id_referenciacion=$datosInput["id_referenciacion"];
		$resultado=$modeloRef->modificaEstadoRef();
		echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>CJavaScript::encode($resultado)));
	}
	public function actionConsultaSegServicioForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultaSegServicioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloRef=new ReferenciacionAdol();
			$modeloFamBenef=new FamiliarBeneficiario();
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				if(isset($datosInput["offset"]) && !empty($datosInput["offset"])){
					$offset=$datosInput["offset"];
				}
				else{
					$offset=0;
				}
				$modeloRef->num_doc=$numDocAdol;
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$tipoRef=$consultaGeneral->consultaEntidades('tiporeferenciacion','id_tipo_referenciacion');
				$espNi=$consultaGeneral->consultaEntidades('esp_sol_ni','id_esp_sol');//consulta especificación de nivel i
				$beneficiario=$consultaGeneral->consultaEntidades('beneficiarios','id_beneficiario');//consulta especificación de nivel i
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$datosRef=$modeloRef->consultaRefSeg($offset);
			}	
			$this->render('_consultaSegServicioForm',array(
				'modeloRef'=>$modeloRef,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'tipoRef'=>$tipoRef,	
				'espNi'=>$espNi,
				'beneficiario'=>$beneficiario,
				'modeloFamBenef'=>$modeloFamBenef,
				'datosRef'=>$datosRef,
				'offset'=>$offset
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
public function actionSegServicioForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultaSegServicioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloRef=new ReferenciacionAdol();
			$modeloFamBenef=new FamiliarBeneficiario();
			$modeloSegRefer=new SeguimientoRefer();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$modeloRef->num_doc=$numDocAdol;
				$modeloRef->id_referenciacion=$datosInput["id_referenciacion"];
				$modeloFamBenef->id_referenciacion=$datosInput["id_referenciacion"];
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$modeloRef->attributes=$modeloRef->consultaRefModAdol();
				$datosFamBenef=$modeloFamBenef->consultaRefFamBenef();
				$tipoRef=$consultaGeneral->consultaEntidades('tiporeferenciacion','id_tipo_referenciacion');
				$espNi=$consultaGeneral->consultaEntidades('esp_sol_ni','id_esp_sol');//consulta especificación de nivel i
				$espNii=$consultaGeneral->consultaEntidades('esp_sol_nii','id_esp_solii');
				$espNiii=$consultaGeneral->consultaEntidades('esp_sol_niii','id_esp_soliii');
				$beneficiario=$consultaGeneral->consultaEntidades('beneficiarios','id_beneficiario');//consulta especificación de nivel i
				$estadoRef=$consultaGeneral->consultaEntidades('estado_referenciacion','id_estadoref');
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$profesional=$consultaGeneral->consultaDatosProfesional($modeloRef->id_cedula);
				$rol=$consultaGeneral->consultaEntidades('rol','id_rol');
				$modeloSegRefer->id_referenciacion=$modeloFamBenef->id_referenciacion;
				$seguimientos=$modeloSegRefer->consSegReferAdol();
			}	
			$this->render('_seguimientoForm',array(
				'modeloRef'=>$modeloRef,
				'numDocAdol'=>$numDocAdol,
				'datosFamBenef'=>$datosFamBenef,
				'tipoRef'=>$tipoRef,
				'espNi'=>$espNi,
				'espNii'=>$espNii,
				'espNiii'=>$espNiii,
				'beneficiario'=>$beneficiario,
				'estadoRef'=>$estadoRef,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'profesional'=>$profesional,
				'rol'=>$rol,
				'modeloSegRefer'=>$modeloSegRefer,
				'seguimientos'=>$seguimientos
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	//Consulta los servicios a los cuales fue referenciado el adolescente
	public function actionConsultaServicioForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultaServicioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloRef=new ReferenciacionAdol();
			$modeloFamBenef=new FamiliarBeneficiario();
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				if(isset($datosInput["offset"]) && !empty($datosInput["offset"])){
					$offset=$datosInput["offset"];
				}
				else{
					$offset=0;
				}
				$modeloRef->num_doc=$numDocAdol;
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$tipoRef=$consultaGeneral->consultaEntidades('tiporeferenciacion','id_tipo_referenciacion');
				$espNi=$consultaGeneral->consultaEntidades('esp_sol_ni','id_esp_sol');//consulta especificación de nivel i
				$beneficiario=$consultaGeneral->consultaEntidades('beneficiarios','id_beneficiario');//consulta especificación de nivel i
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$datosRef=$modeloRef->consultaRefSeg($offset);
			}	
			$this->render('_consultaServicioForm',array(
				'modeloRef'=>$modeloRef,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'tipoRef'=>$tipoRef,	
				'espNi'=>$espNi,
				'beneficiario'=>$beneficiario,
				'modeloFamBenef'=>$modeloFamBenef,
				'datosRef'=>$datosRef,
				'offset'=>$offset
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionMuestraServicio(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultaServicioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloRef=new ReferenciacionAdol();
			$modeloFamBenef=new FamiliarBeneficiario();
			$modeloSegRefer=new SeguimientoRefer();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$modeloRef->num_doc=$numDocAdol;
				$modeloRef->id_referenciacion=$datosInput["id_referenciacion"];
				$modeloFamBenef->id_referenciacion=$datosInput["id_referenciacion"];
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$modeloRef->attributes=$modeloRef->consultaRefModAdol();
				$datosFamBenef=$modeloFamBenef->consultaRefFamBenef();
				$tipoRef=$consultaGeneral->consultaEntidades('tiporeferenciacion','id_tipo_referenciacion');
				$espNi=$consultaGeneral->consultaEntidades('esp_sol_ni','id_esp_sol');//consulta especificación de nivel i
				$espNii=$consultaGeneral->consultaEntidades('esp_sol_nii','id_esp_solii');
				$espNiii=$consultaGeneral->consultaEntidades('esp_sol_niii','id_esp_soliii');
				$beneficiario=$consultaGeneral->consultaEntidades('beneficiarios','id_beneficiario');//consulta especificación de nivel i
				$estadoRef=$consultaGeneral->consultaEntidades('estado_referenciacion','id_estadoref');
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$profesional=$consultaGeneral->consultaDatosProfesional($modeloRef->id_cedula);
				$rol=$consultaGeneral->consultaEntidades('rol','id_rol');
				$modeloSegRefer->id_referenciacion=$modeloFamBenef->id_referenciacion;
				$seguimientos=$modeloSegRefer->consSegReferAdol();
			}	
			$this->render('_muestraServicio',array(
				'modeloRef'=>$modeloRef,
				'numDocAdol'=>$numDocAdol,
				'datosFamBenef'=>$datosFamBenef,
				'tipoRef'=>$tipoRef,
				'espNi'=>$espNi,
				'espNii'=>$espNii,
				'espNiii'=>$espNiii,
				'beneficiario'=>$beneficiario,
				'estadoRef'=>$estadoRef,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'profesional'=>$profesional,
				'rol'=>$rol,
				'modeloSegRefer'=>$modeloSegRefer,
				'seguimientos'=>$seguimientos
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	public function actionRegistraSegimiento(){
		if(isset($_POST["SeguimientoRefer"])&& !empty($_POST["SeguimientoRefer"])){
			$datosInput=Yii::app()->input->post();
			$modeloSegRefer=new SeguimientoRefer();
			$modeloSegRefer->attributes=$datosInput["SeguimientoRefer"];
			if($modeloSegRefer->validate()){
				$resultado=$modeloSegRefer->registraSegimiento();
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>CJavaScript::encode($resultado)));
			}
			else{
				echo CActiveForm::validate($modeloSegRefer);
			}
		}
		
	}
	public function actionConsultaSolicitudesForm(){
		$modeloReferenciacion=new ReferenciacionAdol();
		$consultaSol=$modeloReferenciacion->consultaSolicitudes();
		$this->render('_consultaSolicitudesForm',array('modeloReferenciacion'=>$modeloReferenciacion,'consultaSol'=>$consultaSol));
		
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
?>