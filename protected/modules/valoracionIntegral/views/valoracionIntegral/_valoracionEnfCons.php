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
    	'Valoracion enfermería'=>$this->renderPartial('_valoracionEnfTabCons', 
			array(
				'numDocAdol'=>$numDocAdol,
				'modeloValEnf'=>$modeloValEnf,
				'modeloSgsss'=>$modeloSgsss,
				'idValEnf'=>$idValEnf,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'eps'=>$eps,
				'regSalud'=>$regSalud
			),true,false),
		'Estado valoración'=> $this->renderPartial('_valoracionEstadoValEnfCons', 
			array(
				'numDocAdol'=>$numDocAdol,
				'modeloValEnf'=>$modeloValEnf,
				'idValEnf'=>$idValEnf,
				'estadoCompVal'=>$estadoCompVal,
			),true,false),
    ),
    'options'=>array('collapsible'=>false),
)); 

?>
</fieldset>
<?php Yii::app()->getClientScript()->registerScript('scriptValEnf_0','
$(document).ready(function(){
	$("form").find("textArea").each(function(){
		$(this).css("height","200px");
	});
});	        
;'
,CClientScript::POS_END);
?>

<?php endif;?>