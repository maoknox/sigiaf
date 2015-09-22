<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/'.$render),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>
<fieldset >
<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'id'=>'article_tab',
    'htmlOptions'=>array('style'=>'display: block;font-size:11px'),  // INVISIBLE..

    'tabs'=>array(
	'Análisis situación de derechos'=>$this->renderPartial($formularioCargaDerechos, 
			array(
				'modeloVerifDerechos'=>$modeloVerifDerechos,
				'derechos'=>$derechos,
				'participacion'=>$participacion,
				'proteccion'=>$proteccion,
				'numDocAdol'=>$numDocAdol
			),true,false),
    	'Valoración en psicología'=>$this->renderPartial('_valoracionPsicolTabCons', 
			array(
				'numDocAdol'=>$numDocAdol,
				'modeloValPsicol'=>$modeloValPsicol,
				'idValPsicol'=>$idValPsicol,
				'consDelitoVinc'=>$consDelitoVinc,
				'delitos'=>$delitos,
				'sancionImp'=>$sancionImp
			),true,false),
    	'Valoración consumo sustancias psicoativas'=>$this->renderPartial('_valoracionSusPsicoActCons', 
			array(
				'numDocAdol'=>$numDocAdol,
				'modeloValPsicol'=>$modeloValPsicol,
				'idValPsicol'=>$idValPsicol,
				'tipoSpa'=>$tipoSpa,
				'viaAdmon'=>$viaAdmon,
				'frecUso'=>$frecUso,
				'consConsumoSPA'=>$consConsumoSPA,
				'patronCons'=>$patronCons
			),true,false),
		'Concepto y plan de intervención'=>$this->renderPartial('_valoracionConcPlanIntPsicolCons', 
			array(
				'numDocAdol'=>$numDocAdol,
				'modeloValPsicol'=>$modeloValPsicol,
				'idValPsicol'=>$idValPsicol
			),true,false),
		'Estado de la Valoración'=> $this->renderPartial('_valoracionEstadoValPsicolCons', 
			array(
				'numDocAdol'=>$numDocAdol,
				'modeloValPsicol'=>$modeloValPsicol,
				'idValPsicol'=>$idValPsicol,
				'estadoCompVal'=>$estadoCompVal
			),true,false),
    ),
    'options'=>array('collapsible'=>false),
)); 

?>
</fieldset>


<?php endif;?>