<?php
class ConsultasServicioController extends Controller{
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
	public function actionReporteServicio(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="reporteServicio";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){	
			$modeloReferenciacion=new ReferenciacionAdol();
			$referenciados=$modeloReferenciacion->consultaReferenciados();	
			$this->renderPartial('_reporteServicio',array('referenciados'=>$referenciados,'modeloReferenciacion'=>$modeloReferenciacion));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionMuestraReporteExcel(){
		
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="reporteServicio";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){						
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$this->renderPartial('_reporteServicio');
			}
			else{
				throw new CHttpException(403,'No ha seleccionado un adolescente para el reporte');
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
?>