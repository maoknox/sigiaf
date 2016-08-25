<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<div class="panel-heading color-sdis">Actualización del Plan de Atención Integral</div>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('pai/pai/actualizarPAI'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>
	<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')):?>
		<?php if($modeloPAI->culminacion_pai==1):?>
        <fieldset>
           El PAI ya se culminó
        </fieldset>
        <?php else:?>
            <?php if(!empty($modeloPAI->id_pai)):?>
                        <?php 
                         //consulta en número de días que se han estiulado para realizar el pai, 
                         //se compara con la diferencia de días entre la creación del pai y la fecha en la cual intentan acceder
                            $consultaGeneral->numDocAdol=$numDocAdol;
                            $modeloPAI->pai_habilitado="";
                            $tiempoDias=$consultaGeneral->consultaTiempoActuacionPai();
                            $dias	= (strtotime($modeloPAI->fecha_creacion_pai)-strtotime(date("Y-m-d")))/86400;
                            $dias 	= abs($dias); $dias = floor($dias);	
                            
                                if(empty($modeloPAI->pai_habilitado)){
                                    if($dias<=$tiempoDias["tiempo_pai"]){
                                        $modeloPAI->pai_habilitado='true';
                                        $formPai="_paiActualizaForm";//$formRender="_valoracionPsicolForm";
                                    }
                                    else{
                                        $modeloPAI->pai_habilitado='false';
                                        $modeloPAI->actualizaEstadoPai();
                                        //$formRender="_valoracionPsicolFormCons";
                                        //$formularioCargaDerechos="_formVerificacionDerForjarCons";
                                        $formPai="_paiActualizaForm";//$formRender="_valoracionPsicolForm";
                                    }
                                }
                            
                        ?>
                       
                        <?php if($modeloPAI->pai_habilitado=="false"):?>
                        
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
										'numDocAdol'=>$numDocAdol,
										'modeloCompSanc'=>$modeloCompSanc,
                                    ),true,false),
                              'Análisis de situación de derechos Forjar'=>$this->renderPartial("_formVerificacionDerForjarCons", 
                                    array(
                                        'modeloVerifDerechos'=>$modeloVerifDerechos,
                                        'derechos'=>$derechos,
                                        'participacion'=>$participacion,
                                        'proteccion'=>$proteccion,
                                        'numDocAdol'=>$numDocAdol
                                    ),true,false),				 
                                'Actualizar Plan de Atención integral'=>$this->renderPartial($formPai, 
                                    array(
                                        'modeloPAI'=>$modeloPAI,
                                        'modeloCompDer'=>$modeloCompDer,
                                        'modeloCompSanc'=>$modeloCompSanc,
                                        'infJudicial'=>$infJudicial,
                                        'derechos'=>$derechos,
                                        'conceptoInt'=>$conceptoInt,
                                        'infJudicialPai'=>$infJudicialPai,
                                        'modeloInfJud'=>$modeloInfJud,
                                        'numDocAdol'=>$numDocAdol			
                                    ),true,false),
                                
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
                                        AVISO
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-3 text-center">
                                            <!--<img src="<?php //echo Yii::app()->baseUrl?>/images/centroForjar.png" />-->
                                        </div>
                                        <div class="col-lg-9 text-justify">
                                             El PAI actual no se ha cerrado para su modificación.  Nota: La actualización del PAI se podrá hacer una vez haya pasado el tiempo permitido de creación del PAI.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <hr />
                <?php endif;?>
                    <?php else:?>		
                           <hr />
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        AVISO
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-3 text-center">
                                            <!--<img src="<?php //echo Yii::app()->baseUrl?>/images/centroForjar.png" />-->
                                        </div>
                                        <div class="col-lg-9 text-justify">
                                            No se ha creado un PAI hasta el momento.  Vaya a menú-Plan de Atención Integral-Crear/Modificar PAI
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <hr />
                  <?php endif;?>   
            <?php endif;?>      
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