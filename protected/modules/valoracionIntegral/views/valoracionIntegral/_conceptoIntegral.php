<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/conceptoIntegral'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);


?>
<?php if(!empty($numDocAdol)):?>
<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')):?>
<fieldset >
<?php


$this->widget('zii.widgets.jui.CJuiTabs', array(
	'id'=>'article_tab',
    'htmlOptions'=>array('style'=>'display: block;font-size:11px'),  // INVISIBLE..
    'tabs'=>array(
		'Concepto Integral'=> $this->renderPartial($formularioConcInt, 
			array(
				'modeloConInt'=>$modeloConInt,
				'numDocAdol'=>$numDocAdol,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'consEstPsicol'=>$consEstPsicol,
				'consEstTrSocial'=>$consEstTrSocial,
				'datosConcInt'=>$datosConcInt
			),true,false),
		'Verificación de derechos Forjar'=> $this->renderPartial('_formVerificacionDerForjarCons', 
			array(
				'modeloVerifDerechos'=>$modeloVerifDerechos,
				'derechos'=>$derechos,
				'participacion'=>$participacion,
				'proteccion'=>$proteccion,
				'numDocAdol'=>$numDocAdol
			),true,false)
    ),
    'options'=>array('collapsible'=>false),
)); 
?>
</fieldset>
	<?php else:?>
    <hr />
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                Mensaje
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-3 text-center">
                    <!--<img src="<?php //echo Yii::app()->baseUrl?>/images/centroForjar.png" />-->
                </div>
                <div class="col-lg-9 text-justify">
                    <?php echo Yii::app()->user->getFlash('verifEstadoAdolForjar'); ?>
                </div>
            </div>
        </div>
    </div>
    <hr />
	<?php endif;?>

<?php endif;?>