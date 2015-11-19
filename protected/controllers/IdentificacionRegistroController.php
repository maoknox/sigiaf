<?php
///!  IdentificacionRegistroController.  
/**
	Clase para generar las alertas de gestión de atención del adolescente respecto al rol de usuario.
*/

class IdentificacionRegistroController extends Controller
{
	public function actionIndex(){
		$this->render('index');
	}
	
	/** Método actionCargaFormAdol.       
	*  Se ejecuta en segunda instancia para comprobar si el usuario está logueado o no.  
	*/		
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
}