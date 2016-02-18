<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<div class="panel-heading color-sdis">Valoración Enfermería</div><br /> 
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/valoracionEnfForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>
	<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')):?>
        <fieldset >
        <div id="Mensaje" style="font-size:14px;" ></div>
        <?php
        $this->widget('zii.widgets.jui.CJuiTabs', array(
            'id'=>'article_tab',
            'htmlOptions'=>array('style'=>'display: block;font-size:11px'),  // INVISIBLE..
            'tabs'=>array(
                'Valoracion enfermería'=>$this->renderPartial('_valoracionEnfTab', 
                    array(
                        'numDocAdol'=>$numDocAdol,
                        'modeloValEnf'=>$modeloValEnf,
                        'modeloSgsss'=>$modeloSgsss,
                        'idValEnf'=>$idValEnf,
                        'datosAdol'=>$datosAdol,
                        'edad'=>$edad,
                        'eps'=>$eps,
                        'regSalud'=>$regSalud,
                        'sgs'=>$sgs
                    ),true,false),
                'Estado valoración'=> $this->renderPartial('_valoracionEstadoValEnf', 
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
                        <img src="<?php echo Yii::app()->baseUrl?>/images/centroForjar.png" />
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