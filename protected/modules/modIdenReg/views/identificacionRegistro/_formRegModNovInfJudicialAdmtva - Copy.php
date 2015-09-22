<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
if($accion=="modificar"){
	$nombreBoton="Modificación";
	$accionControllerReg="registraModifInfJud";
	$mensaje="MODIFICACIÓN";
}
elseif($accion=="regNovedad"){
	$nombreBoton="Novedad";
	$accionControllerReg="registraNovInfJud";
	$mensaje="NOVEDAD";
}

?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/'.$accionController),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php
if(!empty($numDocAdol)):
	$modeloInfJudAdmon->num_doc=$numDocAdol;
?>
<fieldset>
<div class="panel panel-default">
<div class="panel-heading color-sdis">Información Judicial Administrativa || <?php echo $mensaje;?></div>
<div class="panel-body">
<div id="MensajeInfJud" style="font-size:14px;"></div>
<?php $formInfJud=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioInfJudAdol',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
<?php echo  $formInfJud->errorSummary($modeloInfJudAdmon,'','',array('style' => 'font-size:14px;color:#F00')); ?>
<legend></legend>

	<!--campo de texto para nombre -->	
     <?php echo $formInfJud->labelEx($modeloInfJudAdmon,'fecha_remision');?>
    <?php //
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array('model'=>$modeloInfJudAdmon,
			'attribute'=>'fecha_remision',
			'value'=>"",
			'language'=>'es',
			'htmlOptions'=>	array('readonly'=>"readonly"),
			'options'=>array('autoSize'=>true,
					//'defaultDate'=>$formAdol->modeloDatosForjarAdol,
					'dateFormat'=>'yy-mm-dd',
					'buttonImageOnly'=>false,
					'buttonText'=>'Seleccione Fecha',
					'selectOtherMonths'=>true,
					'showAnim'=>'slide',
					'showButtonPanel'=>false,
					'showOn'=>'button',
					'showOtherMonths'=>true,
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'minDate'=>'date("Y-m-d")-4Y',//fecha minima
					'maxDate'=>'date("Y-m-d")',//fecha maxima
			),
		));		
	?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'fecha_remision',array('style' => 'color:#F00'));?><br />
    
	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'id_instancia_rem');?>
    <?php echo $formInfJud->dropDownList($modeloInfJudAdmon,'id_instancia_rem',CHtml::listData($instanciaRem,'id_instancia_rem', 'nombre_instancia_rem'),array('prompt'=>'Seleccione quien remite')); ?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'id_instancia_rem',array('style' => 'color:#F00'));?><br />
    
	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'defensor');?>
	<?php echo $formInfJud->textField($modeloInfJudAdmon,'defensor');?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'defensor',array('style' => 'color:#F00'));?><br />

	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'defensor_publico');?>
	<?php echo $formInfJud->textField($modeloInfJudAdmon,'defensor_publico');?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'defensor_publico',array('style' => 'color:#F00'));?><br />
        
	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'juez');?>
	<?php echo $formInfJud->textField($modeloInfJudAdmon,'juez');?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'juez',array('style' => 'color:#F00'));?><br />
    
	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'juzgado');?>
	<?php echo $formInfJud->textField($modeloInfJudAdmon,'juzgado');?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'juzgado',array('style' => 'color:#F00'));?>
    <hr />
    
	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'no_proceso');?>
	<?php echo $formInfJud->textField($modeloInfJudAdmon,'no_proceso');?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'no_proceso',array('style' => 'color:#F00'));?><br />
    
 	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'fecha_aprehension');?>
    <?php //
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array('model'=>$modeloInfJudAdmon,
			'attribute'=>'fecha_aprehension',
			'value'=>"",
			'language'=>'es',
			'htmlOptions'=>	array('readonly'=>"readonly"),
			'options'=>array('autoSize'=>true,
					//'defaultDate'=>$formAdol->modeloDatosForjarAdol,
					'dateFormat'=>'yy-mm-dd',
					'buttonImageOnly'=>false,
					'buttonText'=>'Seleccione Fecha',
					'selectOtherMonths'=>true,
					'showAnim'=>'slide',
					'showButtonPanel'=>false,
					'showOn'=>'button',
					'showOtherMonths'=>true,
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'minDate'=>'date("Y-m-d")-4Y',//fecha minima
					'maxDate'=>'date("Y-m-d")',//fecha maxima
			),
		));
		
	?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'fecha_aprehension',array('style' => 'color:#F00'));?><br />   
    <?php 
		$deiltos=$modeloInfJudAdmon->consultaDelito();
		if(!empty($deiltos)){
			foreach($deiltos as $delito){
				$op[$delito["id_del_rc"]]=array('selected'=>true);
				$delitoAdol=$delito["del_remcespa"]." ";
			}
		}
	
	?>
    <p>Delito actual: <?php echo $delitoAdol; ?></p>
	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'infjudDelRemcesps');?>
    <?php echo $formInfJud->dropDownList($modeloInfJudAdmon,'infjudDelRemcesps',CHtml::listData($modeloInfJudAdmon->consultaEntidadesPrimarias('delito_rem_cespa','del_remcespa'),'id_del_rc', 'del_remcespa'),array('multiple'=>true,'style'=>'width:60%','options'=>$op)); ?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'infjudDelRemcesps',array('style' => 'color:#F00'));?><br />

	<div class="row">
	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'id_proc_jud');?><br />
	<?php echo $formInfJud->radioButtonList($modeloInfJudAdmon,'id_proc_jud',CHtml::listData($estadoProceso,'id_proc_jud','proc_jud'));?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'id_proc_jud',array('style' => 'color:#F00'));?>
    </div>

	<div class="row">
	<?php echo $formInfJud->checkBox($modeloInfJudAdmon,'pard',array('value'=>"true"));?>
    <?php echo $formInfJud->labelEx($modeloInfJudAdmon,'pard');?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'pard',array('style' => 'color:#F00'));?>
    </div>

	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'id_tipo_sancion');?>
    <?php echo $formInfJud->dropDownList($modeloInfJudAdmon,'id_tipo_sancion',CHtml::listData($modeloInfJudAdmon->consultaEntidadesPrimarias('tipo_sancion','id_tipo_sancion'),'id_tipo_sancion', 'tipo_sancion'),array('prompt'=>'Seleccione una sanción')); ?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'id_tipo_sancion',array('style' => 'color:#F00'));?><br />

	<div class="row">
	<?php echo $formInfJud->checkBox($modeloInfJudAdmon,'mec_sust_lib',array('value'=>"true"));?>
	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'mec_sust_lib');?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'mec_sust_lib',array('style' => 'color:#F00'));?>
    </div>
    
<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'fecha_imposicion');?>
    <?php //
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array('model'=>$modeloInfJudAdmon,
			'attribute'=>'fecha_imposicion',
			'value'=>"",
			'language'=>'es',
			'htmlOptions'=>	array('readonly'=>"readonly"),
			'options'=>array('autoSize'=>true,
					//'defaultDate'=>$formAdol->modeloDatosForjarAdol,
					'dateFormat'=>'yy-mm-dd',
					'buttonImageOnly'=>false,
					'buttonText'=>'Seleccione Fecha',
					'selectOtherMonths'=>true,
					'showAnim'=>'slide',
					'showButtonPanel'=>false,
					'showOn'=>'button',
					'showOtherMonths'=>true,
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'minDate'=>'date("Y-m-d")-4Y',//fecha minima
					'maxDate'=>'date("Y-m-d")',//fecha maxima
			),
		));
	?> <br />
	<?php echo $formInfJud->error($modeloInfJudAdmon,'fecha_imposicion',array('style' => 'color:#F00'));?>

	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'tiempo_sancion');?>
	<?php echo $formInfJud->textField($modeloInfJudAdmon,'tiempo_sancion');?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'tiempo_sancion',array('style' => 'color:#F00'));?><br />

	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'tiempo_sancion_dias');?>
	<?php echo $formInfJud->textField($modeloInfJudAdmon,'tiempo_sancion_dias');?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'tiempo_sancion_dias',array('style' => 'color:#F00'));?><br />

	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'observaciones_sancion');?>
	<?php echo $formInfJud->textArea($modeloInfJudAdmon,'observaciones_sancion');?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'observaciones_sancion',array('style' => 'color:#F00'));?><br />

	<?php echo $formInfJud->hiddenField($modeloInfJudAdmon,'num_doc');?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'num_doc',array('style' => 'color:#F00'));?><br />
    <?php 
		$modeloInfJudAdmon->id_inf_actual=$modeloInfJudAdmon->id_inf_judicial;
		$modeloInfJudAdmon->id_inf_judicial=$id_inf_jud_primaria; ?>
	<?php echo $formInfJud->hiddenField($modeloInfJudAdmon,'id_inf_judicial');?>
    <?php echo $formInfJud->hiddenField($modeloInfJudAdmon,'id_inf_actual');?>
    <?php echo $formInfJud->error($modeloInfJudAdmon,'id_inf_judicial',array('style' => 'color:#F00'));?><br />

	<?php
				$boton=CHtml::ajaxSubmitButton (
						'Registrar '.$nombreBoton,   
						array('identificacionRegistro/'.$accionControllerReg),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){/*$("#btnFormInfJud").hide();*/Loading.show();}',
							'success' => 'function(datosInfJud) {	
								Loading.hide();
								if(datosInfJud.estadoComu=="exito"){
									if(datosInfJud.resultado=="exito"){										
										$("#formularioInfJudAdol").find("input, textarea, button, select").attr("disabled",true);
										$("#MensajeInfJud").text("Se ha registrado la información judicial administrativa satisfactoriamente");
										$("#formularioInfJudAdol #formularioInfJudAdol_es_").html("");                                                    
										$("#formularioInfJudAdol #formularioInfJudAdol_es_").hide();											
									}
									else{
	$("#MensajeInfJud").text("Ha habido un error en la creación del registro. Código del error: "+datosInfJud.msnError);
										$("#formularioInfJudAdol #formularioInfJudAdol_es_").html("");                                                    
										$("#formularioInfJudAdol #formularioInfJudAdol_es_").hide(); 	
									}
								}
								else{						
									$("#btnFormInfJud").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datosInfJud, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioInfJudAdol #"+key+"_em_").text(val);                                                    
										$("#formularioInfJudAdol #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioInfJudAdol #formularioInfJudAdol_es_").html(errores);                                                    
									$("#formularioInfJudAdol #formularioInfJudAdol_es_").show(); 
								}
								
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#MensajeInfJud").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormInfJud").show();
								}
								else{
									if(xhr.status==500){
										$("#MensajeInfJud").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
									}
									else{
										$("#MensajeInfJud").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
								
							}'
						),
						array('id'=>'btnFormInfJud','name'=>'btnFormInfJud')
				);
    ?>

    <?php echo $boton; //CHtml::submitButton('Crear');?>
<?php $this->endWidget();?>
<?php endif;?>
</div></div>
</fieldset>
