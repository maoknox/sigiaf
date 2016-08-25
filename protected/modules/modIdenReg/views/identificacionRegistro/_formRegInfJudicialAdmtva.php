
<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/creaRegInfJudicialAdmtvaForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php
if(!empty($numDocAdol)):
	$modeloInfJudAdmon->num_doc=$numDocAdol;
	$modeloDatosForjarAdol->num_doc=$numDocAdol;
?>
<fieldset id="fieldRegInfJud">
<div class="panel panel-default">
<div class="panel-heading color-sdis">Información Judicial-Administrativa</div>
<div class="panel-body">
<div id="MensajeInfJud" style="font-size:14px;"></div>

<legend>Datos e historia de vinculación al programa</legend>
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
<?php echo  $formInfJud->errorSummary($modeloDatosForjarAdol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<div class="form-group"> 
	<?php echo $formInfJud->labelEx($modeloDatosForjarAdol,'fecha_primer_ingreso',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
    <?php //
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array('model'=>$modeloDatosForjarAdol,
			'attribute'=>'fecha_primer_ingreso',
			'value'=>"",
			'language'=>'es',
			'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control input-md'),
			'options'=>array('autoSize'=>true,
					//'defaultDate'=>$formAdol->modeloDatosForjarAdol,
					'dateFormat'=>'yy-mm-dd',
					//'buttonImageOnly'=>false,
					//'buttonText'=>'Seleccione Fecha',
					'selectOtherMonths'=>true,
					'showAnim'=>'slide',
					//'showButtonPanel'=>false,
					//'showOn'=>'button',
					'showOtherMonths'=>true,
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'minDate'=>'date("Y-m-d")-10Y',//fecha minima
					'maxDate'=>'date("Y-m-d")',//fecha maxima
			),
		));
		
	?>
	<?php echo $formInfJud->error($modeloDatosForjarAdol,'fecha_primer_ingreso',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    	<div class="form-group"> 
		<?php echo $formInfJud->labelEx($modeloDatosForjarAdol,'fecha_vinc_forjar',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
       		<div class="col-md-4">
			<?php //
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array('model'=>$modeloDatosForjarAdol,
                    'attribute'=>'fecha_vinc_forjar',
                    'value'=>"",
                    'language'=>'es',
                    'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control input-md'),
                    'options'=>array('autoSize'=>true,
                            //'defaultDate'=>$formAdol->modeloDatosForjarAdol,
                            'dateFormat'=>'yy-mm-dd',
                            //'buttonImageOnly'=>false,
                            //'buttonText'=>'Seleccione Fecha',
                            'selectOtherMonths'=>true,
                            'showAnim'=>'slide',
                            //'showButtonPanel'=>false,
                            //'showOn'=>'button',
                            'showOtherMonths'=>true,
                            'changeMonth'=>'true',
                            'changeYear'=>'true',
                            'minDate'=>'date("Y-m-d")-4Y',//fecha minima
                            'maxDate'=>'date("Y-m-d")',//fecha maxima
                    ),
                ));
                
            ?>
			<?php echo $formInfJud->error($modeloDatosForjarAdol,'fecha_vinc_forjar',array('style' => 'color:#F00'));?>
        </div>
    </div>
   	<div class="form-group"> 
		<?php echo $formInfJud->labelEx($modeloDatosForjarAdol,'num_ingresos',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
       		<div class="col-md-4">
            <?php echo $formInfJud->textField($modeloDatosForjarAdol,'num_ingresos',array('class'=>'form-control input-md'));?>
            <?php echo $formInfJud->error($modeloDatosForjarAdol,'num_ingresos',array('style' => 'color:#F00'));?>
        </div>
	</div>
	<legend>Información Judicial Administrativa</legend>
	<!--campo de texto para nombre -->	
    	<div class="form-group"> 
     <?php echo $formInfJud->labelEx($modeloInfJudAdmon,'fecha_remision',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
    <?php //
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array('model'=>$modeloInfJudAdmon,
			'attribute'=>'fecha_remision',
			'value'=>"",
			'language'=>'es',
			'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control input-md'),
			'options'=>array('autoSize'=>true,
					//'defaultDate'=>$formAdol->modeloDatosForjarAdol,
					'dateFormat'=>'yy-mm-dd',
					//'buttonImageOnly'=>false,
					//'buttonText'=>'Seleccione Fecha',
					'selectOtherMonths'=>true,
					'showAnim'=>'slide',
					//'showButtonPanel'=>false,
					//'showOn'=>'button',
					'showOtherMonths'=>true,
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'minDate'=>'date("Y-m-d")-4Y',//fecha minima
					'maxDate'=>'date("Y-m-d")',//fecha maxima
			),
		));		
	?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'fecha_remision',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   	<div class="form-group"> 
	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'id_instancia_rem',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formInfJud->dropDownList($modeloInfJudAdmon,'id_instancia_rem',CHtml::listData($instanciaRem,'id_instancia_rem', 'nombre_instancia_rem'),array('onChange'=>'muestraInstRem();','prompt'=>'Seleccione quien remite','class'=>'form-control input-md')); ?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'id_instancia_rem',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   	<div class="form-group"> 
	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'defensor',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formInfJud->textField($modeloInfJudAdmon,'defensor',array('class'=>'form-control input-md'));?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'defensor',array('style' => 'color:#F00'));?>
    	</div>
    </div>

   	<div class="form-group"> 
	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'defensor_publico',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formInfJud->textField($modeloInfJudAdmon,'defensor_publico',array('class'=>'form-control input-md'));?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'defensor_publico',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   	<div class="form-group"> 
		<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'juez',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
        	<?php echo $formInfJud->textField($modeloInfJudAdmon,'juez',array('class'=>'form-control input-md'));?>
			<?php echo $formInfJud->error($modeloInfJudAdmon,'juez',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   	<div class="form-group"> 
		<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'juzgado',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formInfJud->textField($modeloInfJudAdmon,'juzgado',array('class'=>'form-control input-md'));?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'juzgado',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <hr />
   	<div class="form-group"> 
     	<?php echo CHtml::activeLabel($modeloInfJudAdmon,'no_proceso',array('required'=>true,'class'=>'col-md-4 control-label','for'=>'searchinput'));?>   
        <div class="col-md-4">
			<?php echo $formInfJud->textField($modeloInfJudAdmon,'no_proceso',array('required'=>true,'class'=>'form-control input-md'));?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'no_proceso',array('style' => 'color:#F00'));?><br />
    	</div>
    </div>
   	<div class="form-group"> 
	 	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'fecha_aprehension',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php //
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array('model'=>$modeloInfJudAdmon,
                    'attribute'=>'fecha_aprehension',
                    'value'=>"",
                    'language'=>'es',
                    'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control input-md'),
                    'options'=>array('autoSize'=>true,
                            //'defaultDate'=>$formAdol->modeloDatosForjarAdol,
                            'dateFormat'=>'yy-mm-dd',
                            //'buttonImageOnly'=>false,
                            //'buttonText'=>'Seleccione Fecha',
                            'selectOtherMonths'=>true,
                            'showAnim'=>'slide',
                            //'showButtonPanel'=>false,
                            //'showOn'=>'button',
                            'showOtherMonths'=>true,
                            'changeMonth'=>'true',
                            'changeYear'=>'true',
                            'minDate'=>'date("Y-m-d")-4Y',//fecha minima
                            'maxDate'=>'date("Y-m-d")',//fecha maxima
                    ),
                ));
                
            ?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'fecha_aprehension',array('style' => 'color:#F00'));?><br />   
    	</div>
    </div>
   	<div class="form-group"> 
		<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'infjudDelRemcesps',array('required'=>true,'class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formInfJud->dropDownList($modeloInfJudAdmon,'infjudDelRemcesps',CHtml::listData($modeloInfJudAdmon->consultaEntidadesPrimarias('delito_rem_cespa','del_remcespa'),'id_del_rc', 'del_remcespa'),
				array('multiple'=>true,'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true')); ?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'infjudDelRemcesps',array('style' => 'color:#F00'));?><br />
    	</div>
    </div>
   	<div class="form-group" id="estProcDiv"> 
		<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'id_proc_jud',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formInfJud->radioButtonList($modeloInfJudAdmon,'id_proc_jud',CHtml::listData($estadoProceso,'id_proc_jud','proc_jud'));?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'id_proc_jud',array('style' => 'color:#F00'));?>
    	</div>
	</div>
   	<div class="form-group"> 			
		<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'pard',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">	
        	<?php echo $formInfJud->checkBox($modeloInfJudAdmon,'pard',array('value'=>"true"));?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'pard',array('style' => 'color:#F00'));?>
    	</div>
	</div>
   	<div class="form-group"> 			
		<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'id_tipo_sancion',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">	
			<?php echo $formInfJud->dropDownList($modeloInfJudAdmon,'id_tipo_sancion',CHtml::listData($modeloInfJudAdmon->consultaEntidadesPrimarias('tipo_sancion','id_tipo_sancion'),'id_tipo_sancion', 'tipo_sancion'),array('prompt'=>'Seleccione una sanción','class'=>'form-control','data-hide-disabled'=>'true','data-live-search'=>'true')); ?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'id_tipo_sancion',array('style' => 'color:#F00'));?><br />
    	</div>
	</div>
   	<div class="form-group"> 			
		<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'mec_sust_lib',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">	
			<?php echo $formInfJud->checkBox($modeloInfJudAdmon,'mec_sust_lib',array('value'=>"true"));?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'mec_sust_lib',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   	<div class="form-group"> 			
		<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'fecha_imposicion',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">	
			<?php //
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array('model'=>$modeloInfJudAdmon,
                    'attribute'=>'fecha_imposicion',
                    'value'=>"",
                    'language'=>'es',
                    'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control input-md'),
                    'options'=>array('autoSize'=>true,
                            //'defaultDate'=>$formAdol->modeloDatosForjarAdol,
                            'dateFormat'=>'yy-mm-dd',
                            //'buttonImageOnly'=>false,
                            //'buttonText'=>'Seleccione Fecha',
                            'selectOtherMonths'=>true,
                            'showAnim'=>'slide',
                            //'showButtonPanel'=>false,
                            //'showOn'=>'button',
                            'showOtherMonths'=>true,
                            'changeMonth'=>'true',
                            'changeYear'=>'true',
                            'minDate'=>'date("Y-m-d")-4Y',//fecha minima
                            'maxDate'=>'date("Y-m-d")',//fecha maxima
                    ),
                ));
            ?>
			<?php echo $formInfJud->error($modeloInfJudAdmon,'fecha_imposicion',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   	<div class="form-group"> 			
		<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'tiempo_sancion',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">	
			<?php echo $formInfJud->textField($modeloInfJudAdmon,'tiempo_sancion',array('class'=>'form-control input-md'));?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'tiempo_sancion',array('style' => 'color:#F00'));?><br />
    	</div>
    </div>
   	<div class="form-group"> 			
		<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'tiempo_sancion_dias',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">	
			<?php echo $formInfJud->textField($modeloInfJudAdmon,'tiempo_sancion_dias',array('class'=>'form-control input-md'));?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'tiempo_sancion_dias',array('style' => 'color:#F00'));?><br />
    	</div>
    </div>
   	<div class="form-group"> 			
		<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'observaciones_sancion',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">	
			<?php echo $formInfJud->textArea($modeloInfJudAdmon,'observaciones_sancion',array('class'=>'form-control input-md'));?>
            <?php echo $formInfJud->error($modeloInfJudAdmon,'observaciones_sancion',array('style' => 'color:#F00'));?><br />
    	</div>
    </div>
	<?php echo $formInfJud->hiddenField($modeloInfJudAdmon,'num_doc');?>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'num_doc',array('style' => 'color:#F00'));?><br />

	<?php echo $formInfJud->hiddenField($modeloDatosForjarAdol,'num_doc');?>
	<?php echo $formInfJud->error($modeloDatosForjarAdol,'num_doc',array('style' => 'color:#F00'));?><br />

	<?php echo $formInfJud->hiddenField($modeloDatosForjarAdol,'id_estado_adol');?>
	<?php echo $formInfJud->hiddenField($modeloDatosForjarAdol,'id_forjar');?>



   	<div class="form-group">
				<label class="col-md-4 control-label" for="button1id"></label>
            <div class="col-md-4">	
			
	<?php
				$boton=CHtml::ajaxSubmitButton (
						'Crear Registro',   
						array('identificacionRegistro/creaRegInfJudAdmon'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnFormInfJud").hide();Loading.show();}',
							'success' => 'function(datosInfJud) {	
								Loading.hide();
								if(datosInfJud.estadoComu=="exito"){
									if(datosInfJud.resultado=="exito"){										
										$("#formularioInfJudAdol").find("input, textarea, button, select").attr("disabled",true);
										$("#MensajeInfJud").text("Se ha registrado la información judicial administrativa satisfactoriamente");
										$("#formularioInfJudAdol #formularioInfJudAdol_es_").html("");                                                    
										$("#formularioInfJudAdol #formularioInfJudAdol_es_").hide();	
										$("#formularioInfJudAdol").removeClass("unsavedForm");																														
									}
									else{
	$("#MensajeInfJud").text("Ha habido un error en la creación del registro. Código del error: "+datosInfJud.msnError);
										$("#formularioInfJudAdol #formularioInfJudAdol_es_").html("");                                                    
										$("#formularioInfJudAdol #formularioInfJudAdol_es_").hide(); 	
									}
								}
								else{						
									$(".errorMessage").html("");
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
						array('id'=>'btnFormInfJud','name'=>'btnFormInfJud','class'=>'btn btn-default btn-sdis')
				);
    ?>

    <?php echo $boton; //CHtml::submitButton('Crear');?>
    </div>
   </div>
<?php $this->endWidget();?>
</div>
</div>
</fieldset>
<?php Yii::app()->getClientScript()->registerScript('tratamientoForm','
		$(document).ready(function(){
			$("#fieldRegInfJud").find(":input").change(function(){
				var dirtyForm = $(this).parents("form");
				// change form status to dirty
				dirtyForm.addClass("unsavedForm");
			});
		});	
		var campoText=0;
		$(window).bind("beforeunload", function(){
			if($(".unsavedForm").size()){
				return "Aún no ha guardado cambios.  Los perderá si abandona.";
			}
		});
		
		function muestraInstRem(){
			var idInstRem=$("#InformacionJudicial_id_instancia_rem").val();
			if(idInstRem==1){
				habilitaCampos();				
			}
			if(idInstRem==2){
				deshabilitaCampos();
			}
		}				
		function deshabilitaCampos(){	
			$(".errorMessage").html("");
			$("#InformacionJudicial_id_tipo_sancion").attr("disabled",true);
			$("#InformacionJudicial_tiempo_sancion").attr("disabled",true);
			$("#InformacionJudicial_tiempo_sancion_dias").attr("disabled",true);
			$("#InformacionJudicial_juzgado").attr("disabled",true);
			$("#InformacionJudicial_no_proceso").attr("disabled",true);
			$("#InformacionJudicial_fecha_imposicion").attr("disabled",true);
			$("#InformacionJudicial_id_proc_jud").attr("disabled",true);
			$("#InformacionJudicial_juez").attr("disabled",true);
			$("#InformacionJudicial_mec_sust_lib").attr("disabled",true);
			$("input[name=\'InformacionJudicial[id_proc_jud]\']").attr("disabled",true);
		}
		function habilitaCampos(){
			$(".errorMessage").html("");
			$("#InformacionJudicial_id_tipo_sancion").attr("disabled",false);
			$("#InformacionJudicial_tiempo_sancion").attr("disabled",false);
			$("#InformacionJudicial_tiempo_sancion_dias").attr("disabled",false);
			$("#InformacionJudicial_juzgado").attr("disabled",false);
			$("#InformacionJudicial_no_proceso").attr("disabled",false);
			$("#InformacionJudicial_fecha_imposicion").attr("disabled",false);
			$("#InformacionJudicial_id_proc_jud").attr("disabled",false);
			$("#InformacionJudicial_juez").attr("disabled",false);
			$("#InformacionJudicial_mec_sust_lib").attr("disabled",false);
			$("input[name=\'InformacionJudicial[id_proc_jud]\']").attr("disabled",false);
		}

',CClientScript::POS_END);		
?>
<?php endif;?>
