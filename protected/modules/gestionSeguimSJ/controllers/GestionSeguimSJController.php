<?php

class GestionSeguimSJController extends Controller
{
	
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
		return array(//ActionVerifEstadoFilter
			'enforcelogin',
			array('application.filters.ActionLogFilter','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()),
			array('application.filters.ActionVerifEstadoFilter +registrarAsesoriaSJForm realizarSeguimientoSJ muestraFormSegGSJ muestraAsesoriasSJ modificarDatosContactoSJForm','num_doc'=>Yii::app()->getSession()->get('numDocAdol'))
		);
	}

	public function actionIndex()
	{
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="index";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$this->render('index');
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}

	}
	public function actionRegistrarAsesoriaSJForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="registrarAsesoriaSJForm";
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
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloGestionSJ=new GestionSociojuridica();
				$motivoAsesoria=$consultaGeneral->consultaEntidades("motivo_asesoriasj","id_motivoasesoriasj");
				$remisionA=$consultaGeneral->consultaEntidades("remision_gestionsj","id_remisionsj");
				$tipoGestion=$consultaGeneral->consultaEntidades("tipo_gestionsj","id_tipogestionsj");							
			}
			$this->render('_registrarAsesoriaSJForm',array(
					'numDocAdol'=>$numDocAdol,	
					'datosAdol'=>$datosAdol,
					'modeloGestionSJ'=>$modeloGestionSJ,
					'edad'=>$edad,
					'motivoAsesoria'=>$motivoAsesoria,
					'remisionA'=>$remisionA,
					'tipoGestion'=>$tipoGestion
				)
			);
			
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}

	}
	
	public function actionRegistrarAsesoriaSJ(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="registrarAsesoriaSJForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloGestionSJ=new GestionSociojuridica();
			$modeloGestionSJ->attributes=$datosInput["GestionSociojuridica"];
			/*if(isset($_POST['ajax']) && $_POST['ajax']=='formularioRegGestionSJ')
			{
				if(Yii::app()->request->isAjaxRequest){
					echo CActiveForm::validate($modeloGestionSJ);
					Yii::app()->end();
				}				
			}*/
			
			if($modeloGestionSJ->validate()){
				$resultado=$modeloGestionSJ->registraGestionSJ();
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));
			}
			else{
				echo CActiveForm::validate($modeloGestionSJ);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	public function actionConsultarAsesoriasSJ()
	{
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultarAsesoriasSJ";
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
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloGestionSJ=new GestionSociojuridica();
				$modeloGestionSJ->num_doc=$numDocAdol;
				$consultaGestionesAdol=$modeloGestionSJ->consultaGestionesSJAdol();
			}						
			$this->render('_consultarAsesoriasSJForm',array(
				'modeloGestionSJ'=>$modeloGestionSJ,
				'consultaGestionesAdol'=>$consultaGestionesAdol,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,				
				'edad'=>$edad,
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}

	}
		public function actionMuestraAsesoriasSJ()
	{
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="muestraAsesoriasSJ";
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
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloGestionSJ=new GestionSociojuridica();
				$modeloGestionSJ->num_doc=$numDocAdol;
				$consultaGestionesAdol=$modeloGestionSJ->consultaGestionesSJAdol();
			}						
			$this->render('_muestraAsesoriasSJ',array(
				'modeloGestionSJ'=>$modeloGestionSJ,
				'consultaGestionesAdol'=>$consultaGestionesAdol,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,				
				'edad'=>$edad,
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	public function actionMuestraFormSegGSJ(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="muestraAsesoriasSJ";
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
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloGestionSJ=new GestionSociojuridica();
				$modeloSegAsesoriasSJ=new SeguimientoAsesoriasj();
				$modeloGestionSJ->num_doc=$numDocAdol;
				$modeloGestionSJ->id_gestionsj=$datosInput["id_gestionsj"];
				$consultaGestionAdol=$modeloGestionSJ->consultaGestionSJAdol();
				$consultaHistSeg=$modeloGestionSJ->consultaHistoricoSegGSJAdol();
				$this->render("_segGSJForm",array(
						'modeloGestionSJ'=>$modeloGestionSJ,
						'modeloSegAsesoriasSJ'=>$modeloSegAsesoriasSJ,
						'consultaGestionesAdol'=>$consultaGestionesAdol,
						'numDocAdol'=>$numDocAdol,	
						'datosAdol'=>$datosAdol,				
						'edad'=>$edad,
						'consultaGestionAdol'=>$consultaGestionAdol,
						'consultaHistSeg'=>$consultaHistSeg											
					)
				);
			}
			else{
				$this->actionMuestraAsesoriasSJ();
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}

	public function actionRealizarSeguimientoSJ()
	{
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="muestraAsesoriasSJ";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloSegAsesoriasSJ=new SeguimientoAsesoriasj();
			$modeloSegAsesoriasSJ->attributes=$datosInput["SeguimientoAsesoriasj"];
			if($modeloSegAsesoriasSJ->validate()){
				$resultado=$modeloSegAsesoriasSJ->registraSegGSJAdol();
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));
			}
			else{
				echo CActiveForm::validate($modeloSegAsesoriasSJ);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}

	}
	public function actionModificarDatosContactoSJForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="modificarDatosContactoSJForm";
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
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloGestionSJ=new GestionSociojuridica();
				$modeloGestionSJ->num_doc=$numDocAdol;
				$consultaGestionesAdolMod=$modeloGestionSJ->consultaGestionesSJAdolMod();

			}
			$this->render("_muestraAsesoriasSJMod",array(
				'modeloGestionSJ'=>$modeloGestionSJ,
				'consultaGestionesAdol'=>$consultaGestionesAdolMod,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,				
				'edad'=>$edad,
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}	
	}
	public function actionMuestraFormModGSJ(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="modificarDatosContactoSJForm";
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
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloGestionSJ=new GestionSociojuridica();
				$modeloSegAsesoriasSJ=new SeguimientoAsesoriasj();
				$modeloGestionSJ->num_doc=$numDocAdol;
				$modeloGestionSJ->id_gestionsj=$datosInput["id_gestionsj"];
				$consultaGestionAdol=$modeloGestionSJ->consultaGestionSJAdol();
				$consultaHistSeg=$modeloGestionSJ->consultaHistoricoSegGSJAdol();
				$this->render("_modGSJForm",array(
						'modeloGestionSJ'=>$modeloGestionSJ,
						'modeloSegAsesoriasSJ'=>$modeloSegAsesoriasSJ,
						'consultaGestionesAdol'=>$consultaGestionesAdol,
						'numDocAdol'=>$numDocAdol,	
						'datosAdol'=>$datosAdol,				
						'edad'=>$edad,
						'consultaGestionAdol'=>$consultaGestionAdol,
						'consultaHistSeg'=>$consultaHistSeg											
					)
				);
			}
			else{
				$this->actionMuestraFormModGSJ();
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}

	public function actionModificaRegistroSJ(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="modificarDatosContactoSJForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloGestionSJ=new GestionSociojuridica();
			$modeloGestionSJ->attributes=$datosInput["GestionSociojuridica"];
			/*if(isset($_POST['ajax']) && $_POST['ajax']=='formularioRegGestionSJ')
			{
				if(Yii::app()->request->isAjaxRequest){
					echo CActiveForm::validate($modeloGestionSJ);
					Yii::app()->end();
				}				
			}*/
			
			if($modeloGestionSJ->validate()){
				$modeloGestionSJ->id_gestionsj=$datosInput["GestionSociojuridica"]["id_gestionsj"];
				//echo $modeloGestionSJ->id_gestionsj;
				$resultado=$modeloGestionSJ->registraModGestionSJ();
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));
			}
			else{
				echo CActiveForm::validate($modeloGestionSJ);
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