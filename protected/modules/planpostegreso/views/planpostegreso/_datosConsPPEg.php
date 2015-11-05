<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('planpostegreso/planpostegreso/creaModificaPlanPe'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>
	
		<?php if(!empty($conceptoInt) && !empty($consultaDerechoAdol) && !Yii::app()->user->hasFlash('verifderechoegreso') && !empty($modeloPAI->id_pai)):?>
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
                            'tipoSancion'=>$tipoSancion,
							'modeloCompSanc'=>$modeloCompSanc,
                            'numDocAdol'=>$numDocAdol,																	
                        ),true,false),
				  'Análisis de situación de derechos Forjar Egreso'=>$this->renderPartial("_formVerificacionDerForjarEgresoCons", 
                        array(
                            'modeloVerifDerechos'=>$modeloVerifDerechos,
                            'derechos'=>$derechos,
                            'participacion'=>$participacion,
                            'proteccion'=>$proteccion,
                            'numDocAdol'=>$numDocAdol,
							'idMomentoVerif'=>$idMomentoVerif
                        ),true,false),				 
                    'Plan de Atención integral'=>$this->renderPartial('_paiConsForm', 
                        array(
                            'modeloPAI'=>$modeloPAI,
                            'modeloCompDer'=>$modeloCompDer,
                            'modeloCompSanc'=>$modeloCompSanc,
                            'infJudicial'=>$infJudicial,
                            'derechos'=>$derechos,
                            'conceptoInt'=>$conceptoInt,
                            'infJudicialPai'=>$infJudicialPai,
                            'modeloInfJud'=>$modeloInfJud,
                            'numDocAdol'=>$numDocAdol,
							'compSancInfJud'=>$compSancInfJud			
                        ),true,false),
						'Plan Post-egreso'=>$this->renderPartial('_creaModifPPEg', 
                        array(
                            'modeloPAI'=>$modeloPAI,
                            'procJudicial'=>$procJudicial,
                            'infJudicial'=>$infJudicial,
                            'numDocAdol'=>$numDocAdol,
							'modeloPlanPe'=>$modeloPlanPe,		
							'planPEgreso'=>$planPEgreso,
							'modeloAccEgr'=>$modeloAccEgr,
							'accionesEgreso'=>$accionesEgreso,
                        ),true,false),
                ),
                'options'=>array('collapsible'=>false),
            )); 
            
            ?>
            </fieldset>
        <?php else:?>		

         <?php if(empty($conceptoInt)):?>
            <fieldset>
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
                                Aún no se ha creado el concpeto integral del adolescente.
                            </div>
                        </div>
                    </div>
                </div>     
            </fieldset>
        <?php endif;?>
         <?php if(empty($consultaDerechoAdol)):?>
            <fieldset>
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
                                No se ha hecho la verificación de derechos del adolescente.
                            </div>
                        </div>
                    </div>
                </div>                                       
            </fieldset>
        <?php endif;?>
         <?php if(Yii::app()->user->hasFlash('verifderechoegreso')):?>
            <fieldset>
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
                                <?php  echo Yii::app()->user->getFlash('verifderechoegreso')?>
                            </div>
                        </div>
                    </div>
                </div>                	              
            </fieldset>
        <?php endif;?>     
         <?php if(empty($modeloPAI->id_pai)):?>
            <fieldset>
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
                                El adolescente no tiene un PAI actual
                            </div>
                        </div>
                    </div>
                </div>                	              
            </fieldset>
        <?php endif;?>     
        <?php endif;?>
<?php endif;?>