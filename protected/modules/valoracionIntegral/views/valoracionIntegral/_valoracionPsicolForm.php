<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/valoracionPsicolForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>


<?php if(!empty($numDocAdol)):?>
<fieldset >
<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')):?>
	<?php //Yii::app()->user->setFlash('verifEstadoAdolForjar', "El adolescente no se encuentra activo en el servicio, debe cambiar el estado a activo");									
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
				'Valoración en psicología'=>$this->renderPartial('_valoracionPsicolTab', 
					array(
						'numDocAdol'=>$numDocAdol,
						'modeloValPsicol'=>$modeloValPsicol,
						'idValPsicol'=>$idValPsicol,
						'consDelitoVinc'=>$consDelitoVinc,
						'delitos'=>$delitos,
						'sancionImp'=>$sancionImp
					),true,false),
				'Valoración consumo sustancias psicoativas'=>$this->renderPartial('_valoracionSusPsicoActTab', 
					array(
						'numDocAdol'=>$numDocAdol,
						'modeloValPsicol'=>$modeloValPsicol,
						'idValPsicol'=>$idValPsicol,
						'tipoSpa'=>$tipoSpa,
						'viaAdmon'=>$viaAdmon,
						'frecUso'=>$frecUso,
						'consConsumoSPA'=>$consConsumoSPA,
						'patronCons'=>$patronCons
					),true,false),
				'Concepto y plan de intervención'=>$this->renderPartial('_valoracionConcPlanIntPsicolTab', 
					array(
						'numDocAdol'=>$numDocAdol,
						'modeloValPsicol'=>$modeloValPsicol,
						'idValPsicol'=>$idValPsicol
					),true,false),
				'Estado de la Valoración'=> $this->renderPartial('_valoracionEstadoValPsicolTab', 
					array(
						'numDocAdol'=>$numDocAdol,
						'modeloValPsicol'=>$modeloValPsicol,
						'idValPsicol'=>$idValPsicol,
						'estadoCompVal'=>$estadoCompVal
					),true,false),
			),
			'options'=>array('collapsible'=>false),
		)); 
		?>
		</fieldset>
		<?php Yii::app()->getClientScript()->registerScript('scriptValpsic_0','
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
