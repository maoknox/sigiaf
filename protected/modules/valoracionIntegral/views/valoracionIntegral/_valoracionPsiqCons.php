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
    	'Valoración en psiquiatría'=>$this->renderPartial('_valoracionPsiqTabCons', 
			array(
				'numDocAdol'=>$numDocAdol,
				'modeloValPsiq'=>$modeloValPsiq,
				'idValPsicol'=>$idValPsiq,
			),true,false),
		'Estado de la Valoración'=> $this->renderPartial('_valoracionEstadoValPsiqCons', 
			array(
				'numDocAdol'=>$numDocAdol,
				'modeloValPsiq'=>$modeloValPsiq,
				'idValPsiq'=>$idValPsiq,
				'estadoCompVal'=>$estadoCompVal
			),true,false),
    ),
    'options'=>array('collapsible'=>false),
)); 

?>
</fieldset>
<?php endif;?>