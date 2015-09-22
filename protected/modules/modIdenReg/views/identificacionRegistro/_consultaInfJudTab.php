<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/consultarInfJudAdmon'),
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
        'Información Judicial/Administrativa'=>$this->renderPartial("_consInfJudAdmonAc", 
                array(
                    'instanciaRem'=>$instanciaRem,
                    'espProcJud'=>$espProcJud	,
                    'delitoRem'=>$delitoRem,
                    'modeloInfJud'=>$modeloInfJud,
                    'infJudicial'=>$infJudicial,
                    'tipoSancion'=>$tipoSancion
                ),true,false),
          
        ),
        'options'=>array('collapsible'=>false),
    )); 
    
    ?>
    </fieldset>
<?php endif;?>
