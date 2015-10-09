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
    	'Valoración Trabajo Social'=>$this->renderPartial('_valoracionTrSocTabCons', 
			array(
				'idValTrSoc'=>$idValTrSoc,
				'modelValTrSoc'=>$modelValTrSoc,
				'numDocAdol'=>$numDocAdol,
				'modeloFamiliar'=>$modeloFamiliar,
				'grupoFamiliar'=>$grupoFamiliar,
				'otroRef'=>$otroRef,
				'parentesco'=>$parentesco,
				'nivelEduc'=>$nivelEduc,
				'modeloTelefono'=>$modeloTelefono,
				'probAsoc'=>$probAsoc,
				'servProt'=>$servProt,
				'probAsocAdol'=>$probAsocAdol,
				'servProtAdol'=>$servProtAdol,
				'antFam'=>$antFam,
				'antFamAdol'=>$antFamAdol,
				'modeloFamilia'=>$modeloFamilia,
				'tipoFamilia'=>$tipoFamilia,
				'tipoFamiliaAdol'=>$tipoFamiliaAdol,
				'modeloAntFFamilia'=>$modeloAntFFamilia,
				'modeloProblemaValtsocial'=>$modeloProblemaValtsocial,
				'modeloServprotecValtsocial'=>$modeloServprotecValtsocial,
				'modeloSgsss'=>$modeloSgsss,				
				'eps'=>$eps,
				'regSalud'=>$regSalud,
				'sgs'=>$sgs
			),true,false),
    	'Valoración Escolaridad'=>$this->renderPartial('_valoracionEscolaridadCons', 
			array(
				'idValTrSoc'=>$idValTrSoc,
				'modelValTrSoc'=>$modelValTrSoc,
				'numDocAdol'=>$numDocAdol,
				'nivelEduc'=>$nivelEduc,
				'modeloEscAdol'=>$modeloEscAdol,
				'escolaridadAdol'=>$escolaridadAdol,
				'jornadaEduc'=>$jornadaEduc,
				'estadoEsc'=>$estadoEsc,
				'munCiudad'=>$munCiudad,
			),true,false),
		'Concepto y plan de intervención'=>$this->renderPartial('_valoracionConcPlanIntTrSocCons', 
			array(
				'idValTrSoc'=>$idValTrSoc,
				'modelValTrSoc'=>$modelValTrSoc,
				'numDocAdol'=>$numDocAdol
			),true,false),
		'Estado de la Valoración'=>$this->renderPartial('_valoracionEstadoValTrSocCons', 
			array(
				'numDocAdol'=>$numDocAdol,
				'modelValTrSoc'=>$modelValTrSoc,
				'idValPsicol'=>$idValPsicol,
				'estadoCompVal'=>$estadoCompVal
			),true,false),
    ),
    'options'=>array('collapsible'=>false),
)); 

?>
</fieldset>
<?php endif;?>