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
	foreach($infJudicial as $pk=>$infJudicialAdol){
		$pk+1;
		$numInf=$pk+1;
		$op['Informacion judicial #'.$numInf]=$this->renderPartial("_infJudAdmon", 
			array(
				'instanciaRem'=>$instanciaRem,
				'espProcJud'=>$espProcJud,
				'delitoRem'=>$delitoRem,
				'modeloInfJud'=>$modeloInfJud,
				'infJudicial'=>$infJudicialAdol,
				'tipoSancion'=>$tipoSancion
         ),true,false);
	}
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

?>