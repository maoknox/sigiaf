<?php

class DefaultController extends Controller
{
	public function filterEnforcelogin($filterChain){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403,"Debe loguearse primero");
		}
		$filterChain->run();
	}
	
	public function filters(){
		return array('enforcelogin -error');
	}
	public function actionIndex(){
		throw new CHttpException(403,"Módulo Asistencia");
	}

}
?>