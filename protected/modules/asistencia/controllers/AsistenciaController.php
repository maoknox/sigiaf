<?php
Yii::import('application.modules.administracion.models.AreainscrCforjar');	

class AsistenciaController extends Controller{
	
	public function filterEnforcelogin($filterChain){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403,"Debe loguearse primero");
		}
		$filterChain->run();
	}
	
	public function filters(){
		return array('enforcelogin',array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()));
	}

	public function actionRegAsistenciaForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="regAsistenciaForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloAsistencia=new Asistencia();
			$operaciones=new OperacionesGenerales();
			$consultaGeneral=new ConsultasGenerales();
			$areaPresc=$consultaGeneral->consultaEntidades('area_presencial','id_areapresencial');
			$areaInscripcion=$consultaGeneral->consultaAreaInscr();
			$tipoAreaInscripcion=$consultaGeneral->consultaEntidades('tipo_areainscr','id_areainscr');
			$this->render('_regAsistenciaForm',array(
				'areaPresc'=> $areaPresc,
				'areaInscripcion'=>$areaInscripcion,
				'tipoAreaInscripcion'=>$tipoAreaInscripcion,
				'modeloAsistencia'=>$modeloAsistencia,
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionAgregaAdol(){
		echo "adol";
		
	}
	
	public function actionRegAsistencia(){
		
		if(isset($_POST["Asistencia"]) && !empty($_POST["Asistencia"])){
			$dataInputi=Yii::app()->input->post();
			$modeloAsistencia=new Asistencia();
			$modeloAsistencia->attributes=$dataInputi["Asistencia"];
			/*$variables=array_keys($dataInput);
				foreach($variables as $variable){
					//print_r($dataInput[$variable]);
				}*/
			if($modeloAsistencia->validate()){
				$modeloAsistencia->attributes=$dataInputi["Asistencia"];
				$variables=array_keys($dataInputi);
				//print_r($variables);
				$modeloAsistencia->fecha_asistencia=$dataInputi["Asistencia"]["fecha_asistencia"];
				foreach($variables as $variable){
					//$subVariable=array_keys($dataInputi[$variable]);				
					if($variable!="Asistencia"){
						$modeloAsistencia->num_doc=$variable;
						$subVariable=array_keys($dataInputi[$variable]);
						foreach($subVariable as $subVariablei){
							//if(!empty($dataInput[$variable][$subVariablei]))
								//$numAreaInt+=1;
							$modeloAsistencia->id_areapresencial=null;
							$modeloAsistencia->id_areainteres=null;	
							if(mb_stristr ($subVariablei,"arPr_")!=""){
								$modeloAsistencia->id_areapresencial=$dataInputi[$variable][$subVariablei];							
								$resultado=$modeloAsistencia->registraAsistencia();
								//echo $areaPresencial;
							}
							else{
								if(!empty($dataInputi[$variable][$subVariablei])){								
									$modeloAsistencia->id_areainteres=$dataInputi[$variable][$subVariablei];
									$resultado=$modeloAsistencia->registraAsistencia();
									//echo $areainteres;
								}
							}			
							//echo $subVariablei." ";								
						}			
					}
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloAsistencia);		
			}
		}
	}
	
	public function actionReporteAsistencia(){
		$modeloRepAsistencia=new ReporteAsistencia();
		$this->render("_reporteAsistencia",array('modeloRepAsistencia'=>$modeloRepAsistencia));
		
	}
	
	
	public function actionReporteAsistenciaExcel(){
		$dataInput=Yii::app()->input->post();
		$modeloRepAsistencia=new ReporteAsistencia();
		$modeloRepAsistencia->attributes=$dataInput["ReporteAsistencia"];
		if($modeloRepAsistencia->validate()){
			$modeloAsistencia=new Asistencia();
			$modeloAsistencia->mes=$modeloRepAsistencia->mes;
			$modeloAsistencia->anio=$modeloRepAsistencia->anio;
			$modeloAsistencia->reporteAsistencia();

		}
		else{
			$this->render("_reporteAsistencia",array('modeloRepAsistencia'=>$modeloRepAsistencia));
		}
	}
	
	public function actionVinculaAreaIntDeporteForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="vinculaAreaIntDeporteForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){		
			$modeloAreainscrCforjar=new AreainscrCforjar();
			$areaIntSinVinc=$modeloAreainscrCforjar->consultaAreaInscrSinVinc();
			$this->render("_vinculaAreaInteresForm",array('areaIntSinVinc'=>$areaIntSinVinc,'modeloAreainscrCforjar'=>$modeloAreainscrCforjar));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionVinculaArIntDep(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="vinculaAreaIntDeporteForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){		
			$datosInput=Yii::app()->input->post();
			$modeloAreainscrCforjar=new AreainscrCforjar();
			$modeloAreainscrCforjar->attributes=$datosInput["AreainscrCforjar"];
			//print_r($datosInput);
			if(!empty($datosInput["AreainscrCforjar"]["id_areainteres"])){
				$modeloAreainscrCforjar->id_areainteres=0;
			}
			if($modeloAreainscrCforjar->validate()){
				$modeloAreainscrCforjar->areasInteresDeportes=$datosInput["AreainscrCforjar"]["id_areainteres"];
				$resultado=$modeloAreainscrCforjar->vinculaAIntDepForjar();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado));	
			}
			else{
				echo CActiveForm::validate($modeloAreainscrCforjar);		
			}	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	
	public function actionDeshabilitaAreaIntDeporteForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="deshabilitaAreaIntDeporteForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){		
			$modeloAreainscrCforjar=new AreainscrCforjar();
			$modeloAreainscrCforjar->areacforjar_activa='true';
			$modeloAreainscrCforjar->idAreainscr=1;
			$areaInt=$modeloAreainscrCforjar->consultaAreaInteresDeportes();
			$modeloAreainscrCforjar->idAreainscr=2;
			$deportes=$modeloAreainscrCforjar->consultaAreaInteresDeportes();
			$this->render("_deshabilitaAreaInteresDeporteForm",array(
				'modeloAreainscrCforjar'=>$modeloAreainscrCforjar,
				'areaInt'=>$areaInt,
				'deportes'=>$deportes,
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	
	public function actionHabilitaAreaIntDeporteForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="habilitaAreaIntDeporteForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){		
			$modeloAreainscrCforjar=new AreainscrCforjar();
			$modeloAreainscrCforjar->areacforjar_activa='false';
			$modeloAreainscrCforjar->idAreainscr=1;
			$areaInt=$modeloAreainscrCforjar->consultaAreaInteresDeportes();
			$modeloAreainscrCforjar->idAreainscr=2;
			$deportes=$modeloAreainscrCforjar->consultaAreaInteresDeportes();
			$this->render("_habilitaAreaInteresDeporteForm",array(
				'modeloAreainscrCforjar'=>$modeloAreainscrCforjar,
				'areaInt'=>$areaInt,
				'deportes'=>$deportes,
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionDesHabilitaAreaIntDeporte(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="deshabilitaAreaIntDeporteForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){		
			$datosInput=Yii::app()->input->post();
			$modeloAreainscrCforjar=new AreainscrCforjar();
			$modeloAreainscrCforjar->attributes=$datosInput["AreainscrCforjar"];
			//print_r($datosInput);
			if(!empty($datosInput["AreainscrCforjar"]["id_areainteres"])){
				$modeloAreainscrCforjar->id_areainteres=0;
			}
			if($modeloAreainscrCforjar->validate()){
				$modeloAreainscrCforjar->areasInteresDeportes=$datosInput["AreainscrCforjar"]["id_areainteres"];
				$resultado=$modeloAreainscrCforjar->deshabHabAIntDepForjar();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado));	
			}
			else{
				echo CActiveForm::validate($modeloAreainscrCforjar);		
			}	
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