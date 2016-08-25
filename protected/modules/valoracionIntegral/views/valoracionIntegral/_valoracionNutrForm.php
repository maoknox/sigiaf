<div class="panel-heading color-sdis">Valoración en Nutrición</div><br /> 
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/valoracionNutrForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>

<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')):?>
<fieldset >
	<?php  //Yii::app()->user->setFlash('verifEstadoAdolForjar', "El adolescente no se encuentra activo en el servicio, debe cambiar el estado a activo");									
		$this->widget('zii.widgets.jui.CJuiTabs', array(
			'id'=>'valoracionNutricionTab',
			'htmlOptions'=>array('style'=>'display: block;font-size:11px'),  // INVISIBLE..
			'tabs'=>array(
				'ANTECEDENTES DE SALUD'=>$this->renderPartial('_valoracionNutrAntSalud',array(
					'modeloValNutr'=>$modeloValNutr,
					'tipoParto'=>$tipoParto,
					'modeloFamilia'=>$modeloFamilia,
					'modeloFamiliar'=>$modeloFamiliar,				
					'grupoFamiliares'=>$grupoFamiliar,
					'modeloTelefono'=>$modeloTelefono,
					'nivelEduc'=>$nivelEduc,
					'parentesco'=>$parentesco
				),true,false),
				'EXÁMENES Y VACUNAS'=>$this->renderPartial('_valoracionNutrExamenes',array(
					'modeloValNutr'=>$modeloValNutr,
					'modeloLabclinValnutr'=>$modeloLabclinValnutr,
					'labClinicosAdol'=>$labClinicosAdol,
					'laboratorios'=>$laboratorios,
					'laboratoriosExtra'=>$laboratoriosExtra,
					'esquemasVac'=>$esquemasVac,
					'tiposDiscapacidad'=>$tiposDiscapacidad,
					'modeloTipodiscValnutr'=>$modeloTipodiscValnutr,
					'tiposDiscAdol'=>$tiposDiscAdol,
					'modeloEsquemaVacunacion'=>$modeloEsquemaVacunacion
				),true,false),//_valoracionNutrAntAlim
				'ANTECEDENTES ALIMENTARIOS'=>$this->renderPartial('_valoracionNutrAntAlim',array(
					'modeloValNutr'=>$modeloValNutr,
					'consLecheMat'=>$consLecheMat,
					'consBiberon'=>$consBiberon,
					'modeloOrigenalimValnutr'=>$modeloOrigenalimValnutr,
					'origenAlimentosHogar'=>$origenAlimentosHogar,
					'origenAlimentos'=>$origenAlimentos,
					'apetito'=>$apetito,
					'ingesta'=>$ingesta,
					'masticacion'=>$masticacion,
					'digestion'=>$digestion,
					'habitoIntestinal'=>$habitoIntestinal,
					'nivelActFisica'=>$nivelActFisica,
					'frecConsumo'=>$frecConsumo,
					'grupoComida'=>$grupoComida,
					'modeloGrupocomidaValnutr'=>$modeloGrupocomidaValnutr,//_valoracionNutrEstadoActual
					'idValNutr'=>$idValNutr									
				),true,false),
				'ESTADO ACTUAL'=>$this->renderPartial('_valoracionNutrEstadoActual',array(
					'modeloValNutr'=>$modeloValNutr,
					'modeloAntropometria'=>$modeloAntropometria,
					'antropometriaAdol'=>$antropometriaAdol
				),true,false),
				'RESULTADOS'=>$this->renderPartial('_valoracionNutrResultados',array(
					'modeloValNutr'=>$modeloValNutr,
				),true,false),
				'PLAN DIETARIO'=> $this->renderPartial('_valoracionNutrPlanDietario',array(
					'modeloValNutr'=>$modeloValNutr,
					'modeloNutricionAdol'=>$modeloNutricionAdol,
					'tiempoAlimento'=>$tiempoAlimento,	
					'planDietario'=>$planDietario,	
					'grupoComida'=>$grupoComida,
					'modeloGrupocomidaNutradol'=>$modeloGrupocomidaNutradol,//_valoracionNutrEstadoActual
					'modeloPorcionesComida'=>$modeloPorcionesComida,				
				),true,false),
				'ESTADO VALORACIÓN'=> $this->renderPartial('_valoracionNutrEstado',array(
					'modeloValNutr'=>$modeloValNutr,
					'estadoCompVal'=>$estadoCompVal,			
				),true,false),//_valoracionNutrEstado
			),
			
			'options'=>array('collapsible'=>false),
		)); 		
		?>
	</fieldset>
		<?php Yii::app()->getClientScript()->registerScript('scriptValnutr_0','
		$(document).ready(function(){
			$("form").find("textArea").each(function(){
				$(this).css("height","200px");
			});
		});	        		
		$(window).bind("beforeunload", function(){
			if($(".unsavedForm").size()){
				return "Aún hay datos sin guardar si abandona la página estos no se guardaran";//va a cerrar
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
