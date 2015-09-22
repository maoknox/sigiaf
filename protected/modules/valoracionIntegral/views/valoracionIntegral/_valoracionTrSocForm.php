<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/valoracionTrSocForm'),
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
                'Análisis situación de derechos'=>$this->renderPartial($formularioCargaDerechos, 
                    array(
                        'modeloVerifDerechos'=>$modeloVerifDerechos,
                        'derechos'=>$derechos,
                        'participacion'=>$participacion,
                        'proteccion'=>$proteccion,
                        'numDocAdol'=>$numDocAdol
                    ),true,false),
                'Valoración Trabajo Social'=>$this->renderPartial('_valoracionTrSocTab', 
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
                    ),true,false),
                'Valoración Escolaridad'=>$this->renderPartial('_valoracionEscolaridadTab', 
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
                'Concepto y plan de intervención'=>$this->renderPartial('_valoracionConcPlanIntTrSocTab', 
                    array(
                        'idValTrSoc'=>$idValTrSoc,
                        'modelValTrSoc'=>$modelValTrSoc,
                        'numDocAdol'=>$numDocAdol
                    ),true,false),
                'Estado de la Valoración'=>$this->renderPartial('_valoracionEstadoValTrSoc', 
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
        <?php Yii::app()->getClientScript()->registerScript('scriptValTrsoc_0','
        var campoText=0;
        $(window).bind("beforeunload", function(){
            if($(".unsavedForm").size()){
                return "va a cerrar";
            }
        });'
        ,CClientScript::POS_BEGIN);
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