<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/'.$render),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>


<?php if(!empty($numDocAdol)):?>
<fieldset >
	<?php  //Yii::app()->user->setFlash('verifEstadoAdolForjar', "El adolescente no se encuentra activo en el servicio, debe cambiar el estado a activo");									
		$this->widget('zii.widgets.jui.CJuiTabs', array(
			'id'=>'valoracionNutricionTab',
			'htmlOptions'=>array('style'=>'display: block;font-size:11px'),  // INVISIBLE..
			'tabs'=>array(
				'ANTECEDENTES DE SALUD'=>$this->renderPartial('_valoracionNutrAntSaludCons',array(
					'modeloValNutr'=>$modeloValNutr,
					'tipoParto'=>$tipoParto,
					'modeloFamilia'=>$modeloFamilia,
					'modeloFamiliar'=>$modeloFamiliar,				
					'grupoFamiliares'=>$grupoFamiliar,
					'modeloTelefono'=>$modeloTelefono,
					'nivelEduc'=>$nivelEduc,
					'parentesco'=>$parentesco
				),true,false),
				'EXÁMENES Y VACUNAS'=>$this->renderPartial('_valoracionNutrExamenesCons',array(
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
				'ANTECEDENTES ALIMENTARIOS'=>$this->renderPartial('_valoracionNutrAntAlimCons',array(
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
				'ESTADO ACTUAL'=>$this->renderPartial('_valoracionNutrEstadoActualCons',array(
					'modeloValNutr'=>$modeloValNutr,
					'modeloAntropometria'=>$modeloAntropometria,
					'antropometriaAdol'=>$antropometriaAdol
				),true,false),
				'RESULTADOS'=>$this->renderPartial('_valoracionNutrResultadosCons',array(
					'modeloValNutr'=>$modeloValNutr,
				),true,false),
				'PLAN DIETARIO'=> $this->renderPartial('_valoracionNutrPlanDietarioCons',array(
					'modeloValNutr'=>$modeloValNutr,
					'modeloNutricionAdol'=>$modeloNutricionAdol,
					'tiempoAlimento'=>$tiempoAlimento,	
					'planDietario'=>$planDietario,	
					'grupoComida'=>$grupoComida,
					'modeloGrupocomidaNutradol'=>$modeloGrupocomidaNutradol,//_valoracionNutrEstadoActual
					'modeloPorcionesComida'=>$modeloPorcionesComida,				
				),true,false),
				'ESTADO VALORACIÓN'=> $this->renderPartial('_valoracionNutrEstadoCons',array(
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
'
,CClientScript::POS_BEGIN);
?>

<?php endif;?>
