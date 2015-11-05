<?php
/*$instanciaRem,
$espProcJud	,
$delitoRem,
$modeloInfJud,
$infJudicial,
$tipoSancion
*/
if(empty($infJudicial)){
	echo "Aún no se ha registrado la información Judicial del adolescente";
}
else{
	$op=array();
	$modeloCompSanc->num_doc=$numDocAdol;	
	$existeInfJud='false';	
	foreach($infJudicial as $pk=>$infJudicialAdol){
		$infJudActual=array();					 
		$modeloCompSanc->id_inf_judicial=$infJudicialAdol["id_inf_judicial"];
		//echo $modeloComponenteSancion->num_doc."||".$modeloComponenteSancion->id_inf_judicial."-";
		$infJudActual=$modeloCompSanc->consultaInfJudComponenteSanc();
		if($infJudActual["pai_actual"]=="true" or empty($infJudActual)){
			$existeInfJud='true';
			$pk+1;
			$numInf=$pk+1;		
			$op['Informacion judicial #'.$numInf]=$this->renderPartial("_infJudAdmon", 
				array(
					'instanciaRem'=>$instanciaRem,
					'espProcJud'=>$espProcJud,
					'delitoRem'=>$delitoRem,
					'modeloInfJud'=>$modeloInfJud,
					'infJudicial'=>$infJudicialAdol,
					'tipoSancion'=>$tipoSancion,
			 ),true,false);
		}		 
	}
	if($existeInfJud=='false'){
		echo "Aún no se ha registrado la información Judicial del adolescente";
	}
	else{
		$this->widget('zii.widgets.jui.CJuiAccordion', array(
			'panels'=>$op,
			// additional javascript options for the accordion plugin
			'options'=>array(
			 'active'=>false,
			'animated'=>'bounceslide',
			'autoHeight' => true,
			'collapsible' => true,
			'navigation'=>'true',
	
			),
		));
	}
}

?>