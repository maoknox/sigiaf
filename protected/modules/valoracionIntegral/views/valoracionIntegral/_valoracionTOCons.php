<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<div class="panel-heading color-sdis">Valoración Terapia Ocupacional</div> <br />
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
    	'Valoración Terapia Ocupacional'=>$this->renderPartial('_valoracionTOTabCons', 
			array(
				'numDocAdol'=>$numDocAdol,
				'modeloValTO'=>$modeloValTO,
				'idValTO'=>$idValTO,
				'estadoCompVal'=>$estadoCompVal,
				'tipoTrabajador'=>$tipoTrabajador,
				'sectorLaboral'=>$sectorLaboral
			),true,false),
		'Concepto ocupacional y plan de intervención'=>$this->renderPartial('_valoracionConcPlanIntTOCons', 
			array(
				'numDocAdol'=>$numDocAdol,
				'modeloValTO'=>$modeloValTO,
				'idValTO'=>$idValTO,
				'estadoCompVal'=>$estadoCompVal
			),true,false),
		'Estado valoración'=> $this->renderPartial('_valoracionEstadoValTOCons', 
			array(
				'numDocAdol'=>$numDocAdol,
				'modeloValTO'=>$modeloValTO,
				'idValTO'=>$idValTO,
				'estadoCompVal'=>$estadoCompVal
			),true,false),
    ),
    'options'=>array('collapsible'=>false),
)); 

?>
</fieldset>
<?php Yii::app()->getClientScript()->registerScript('scriptValTO_0','
$(document).ready(function(){
	$("form").find("textArea").each(function(){
		$(this).css("height","200px");
	});
});	
'
,CClientScript::POS_END);
?>

<?php endif;?>