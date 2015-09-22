<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('pai/pai/crearModificarPAI'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>
	<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')):?>
		<?php if(!empty($conceptoInt) && !empty($consultaDerechoAdol)):?>
            <fieldset >
            
            <?php 
			 //consulta en número de días que se han estiulado para realizar el pai, 
			 //se compara con la diferencia de días entre la creación del pai y la fecha en la cual intentan acceder
				$consultaGeneral->numDocAdol=$numDocAdol;
				$formPai="_paiCreaModForm";
				$tiempoDias=$consultaGeneral->consultaTiempoActuacionPai();
				
				$dias	= (strtotime($modeloPAI->fecha_creacion_pai)-strtotime(date("Y-m-d")))/86400;
				$dias 	= abs($dias); $dias = floor($dias);
				if($dias<=$tiempoDias["tiempo_pai"]){
					$formPai="_paiCreaModForm";//$formRender="_valoracionPsicolForm";
				}
				else{
					$modeloPAI->pai_habilitado='false';
					$modeloPAI->actualizaEstadoPai();
					//$formRender="_valoracionPsicolFormCons";
					//$formularioCargaDerechos="_formVerificacionDerForjarCons";
					$formPai="_paiConsForm";//$formRender="_valoracionPsicolForm";
				}

			?>
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
				  'Análisis de situación de derechos Forjar'=>$this->renderPartial("_formVerificacionDerForjarCons", 
                        array(
                            'modeloVerifDerechos'=>$modeloVerifDerechos,
                            'derechos'=>$derechos,
                            'participacion'=>$participacion,
                            'proteccion'=>$proteccion,
                            'numDocAdol'=>$numDocAdol
                        ),true,false),				 
                    'Plan de Atención integral'=>$this->renderPartial($formPai, 
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
							//'compSancInfJud'=>$compSancInfJud			
                        ),true,false),
                    'Seguimiento al PAI'=>$this->renderPartial("_paiSeguimiento", 
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
                            'modeloSegComDer'=>$modeloSegComDer,
                            'modeloSegComSanc'=>$modeloSegComSanc	
                        ),true,false),
                    'Culminación del PAI'=>$this->renderPartial("_culminacionPai", 
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
                            'modeloSegComDer'=>$modeloSegComDer,
                            'modeloSegComSanc'=>$modeloSegComSanc	
                        ),true,false),
                ),
                'options'=>array('collapsible'=>false),
            )); 
            
            ?>
            </fieldset>
        <?php else:?>		

         <?php if(empty($conceptoInt)):?>
            <fieldset>
                Aún no se ha creado el concpeto integral del adolescente.
            </fieldset>
        <?php endif;?>
         <?php if(empty($consultaDerechoAdol)):?>
            <fieldset>
                No se ha hecho la verificación de derechos del adolescente.
            </fieldset>
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