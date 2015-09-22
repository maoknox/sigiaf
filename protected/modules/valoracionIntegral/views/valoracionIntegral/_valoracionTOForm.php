<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/valoracionTOForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>
	<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')):?>

        <div id="Mensaje" style="font-size:14px;" ></div>
        <fieldset >
        <?php
        $this->widget('zii.widgets.jui.CJuiTabs', array(
            'id'=>'article_tab',
            'htmlOptions'=>array('style'=>'display: block;font-size:11px'),  // INVISIBLE..
            'tabs'=>array(
                'Valoración Terapia Ocupacional'=>$this->renderPartial('_valoracionTOTab', 
                    array(
                        'numDocAdol'=>$numDocAdol,
                        'modeloValTO'=>$modeloValTO,
                        'idValTO'=>$idValTO,
                        'estadoCompVal'=>$estadoCompVal,
						'tipoTrabajador'=>$tipoTrabajador,
						'sectorLaboral'=>$sectorLaboral
                    ),true,false),
                'Concepto ocupacional y plan de intervención'=>$this->renderPartial('_valoracionConcPlanIntTOTab', 
                    array(
                        'numDocAdol'=>$numDocAdol,
                        'modeloValTO'=>$modeloValTO,
                        'idValTO'=>$idValTO,
                        'estadoCompVal'=>$estadoCompVal
                    ),true,false),
                'Estado valoración'=> $this->renderPartial('_valoracionEstadoValTO', 
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
        var campoText=0;
        $(window).bind("beforeunload", function(){
            if($(".unsavedForm").size()){
                return "va a cerrar";
            }
        });'
        ,CClientScript::POS_END);
        ?>
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
                        <img src="/login_sdis/public/img/logo.svg" />
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
