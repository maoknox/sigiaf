<?php
Yii::import('application.modules.modIdenReg.models.ForjarAdol');	
 
class ActionVerifEgresoSinCump extends CFilter{
	public $num_doc;
    protected function preFilter($filterChain){
		$modeloForjarAdol=new ForjarAdol();
		$modeloForjarAdol->num_doc=$this->num_doc;
		$estadoAdol=$modeloForjarAdol->consultaDatosForjarAdol();		
			if($estadoAdol["id_estado_adol"]>2){
				Yii::app()->user->setFlash('egresoAdolSinCump', "El adolescente está en este momento ".$estadoAdol["estado_adol"]);									
			}
			elseif(empty($estadoAdol)){
				Yii::app()->user->setFlash('egresoAdolSinCump', "El adolescente no se encuentra activo en el servicio, debe cambiar el estado a activo.");									
			}
		$filterChain->run();
       // return false; // false if the action should not be executed
    }
 
    protected function postFilter($filterChain){
        // logic being applied after the action is executed
    }
}
?>