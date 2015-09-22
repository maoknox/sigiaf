<?php

class IdentificacionRegistroController extends Controller
{
	public function actionIndex(){
		$this->render('index');
	}
	public function actionCargaFormAdol(){
		$formAdol=new Adolescente();
		$modeloInfJudAdmon=new InformacionJudicial();	
		$this->render('registrarDatos',array('formAdol'=>$formAdol,'modeloInfJudAdmon'=>$modeloInfJudAdmon));
	}	
	public function actionCreaRegAdol(){
		$formPr=new Adolescente();             
		$this->performAjaxValidation($formPr);  
		if(isset($_POST["Adolescente"])){
			$formPr->attributes=$_POST["Adolescente"];
			$valido=$formPr->validate();   
			if($formPr->validate()){
				echo CJSON::encode(array("estado"=>"exito"));
			}else{
				echo CActiveForm::validate($formPr);
			}
		}
	}
	public function actionCreaRegInfJudAdmon(){
		$modeloInfJudAdmon=new InformacionJudicial();             
		//$this->performAjaxValidation($modeloInfJudAdmon);  
		if(isset($_POST["InformacionJudicial"])){
			$modeloInfJudAdmon->attributes=$_POST["InformacionJudicial"];
			$valido=$modeloInfJudAdmon->validate();   
			if($modeloInfJudAdmon->validate()){
				echo CJSON::encode(array("estado"=>"exito"));
			}else{
				echo CActiveForm::validate($modeloInfJudAdmon);
			}
		}
	}
	public function performAjaxValidation($formPr){
		if(isset($_POST['ajax']) && $_POST['ajax']==='formularioAdol'){
			if(Yii::app()->request->isAjaxRequest){
				echo CActiveForm::validate($formAdol);
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