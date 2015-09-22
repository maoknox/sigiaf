<div class="panel-heading color-sdis">Asociar contratos</div> 
<?php $formularioContratoFunc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioContratoFunc',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<div class="form-group"> 
			<?php echo $formularioContratoFunc->labelEx($modeloDatosContrato,'id_cedula',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
    <div class="col-md-4">
       <?php echo $formularioContratoFunc->dropDownList($modeloDatosContrato,'id_cedula',CHtml::listData($funcionarios,'id_cedula', 'nombres'), 
				array(
					//'multiple'=>'multiple',
					'prompt'=>'Seleccione...',
					'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true'
					,'onChange'=>'js:$("#formularioContratoFunc").addClass("has-warning");'							
				)); ?>
        <?php echo $formularioContratoFunc->error($modeloDatosContrato,'id_cedula',array('style' => 'color:#F00')); ?>     
        <?php //echo $formularioLabClinicos->labelEx($modeloLabclinValnutr,'resultado_labclin',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    </div>
</div>
<div class="form-group"> 
	<?php echo $formularioContratoFunc->labelEx($modeloDatosContrato,'numero_contrato',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
    <div class="col-md-4">
        <?php echo $formularioContratoFunc->textField($modeloDatosContrato,'numero_contrato',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioContratoFunc").addClass("has-warning");'));?>
        <?php echo $formularioContratoFunc->error($modeloDatosContrato,'numero_contrato',array('style' => 'color:#F00')); ?>     
        <?php //echo $formularioLabClinicos->labelEx($modeloLabclinValnutr,'resultado_labclin',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    </div>
</div>
<div class="form-group">
<?php echo $formularioContratoFunc->labelEx($modeloDatosContrato,'fecha_contrato',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
	<?php //
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array('model'=>$modeloDatosContrato,
			'name'=>'fecha_contrato',
			'attribute'=>'fecha_contrato',
			'value'=>'',
			'language'=>'es',			
			'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control','onChange'=>'js:$("#formularioContratoFunc").addClass("has-warning");'),			
			'options'=>array('autoSize'=>true,
					//'defaultDate'=>$formAdol->fecha_nacimiento,
					'dateFormat'=>'yy-mm-dd',
					//'buttonText'=>'Seleccione Fecha',
					'selectOtherMonths'=>true,
					'showAnim'=>'slide',
					'showOtherMonths'=>true,
					'changeMonth'=>'true',
					'changeYear'=>'true',
				   //'minDate'=>'date("Y-m-d")-19Y',//fecha minima
					//'maxDate'=>'date("Y-m-d")-10Y+6m',//fecha maxima
			),
		));
	?>
	<?php echo $formularioContratoFunc->error($modeloDatosContrato,'fecha_contrato',array('style' => 'color:#F00'));?>
    </div>
</div>
<div class="form-group">
<?php echo $formularioContratoFunc->labelEx($modeloDatosContrato,'fecha_inicio',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
	<?php //
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array('model'=>$modeloDatosContrato,
			'name'=>'fecha_inicio',
			'attribute'=>'fecha_inicio',
			'value'=>"",
			'language'=>'es',			
			'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control','onChange'=>'js:$("#formularioContratoFunc").addClass("has-warning");'),			
			'options'=>array('autoSize'=>true,
					'defaultDate'=>$formAdol->fecha_nacimiento,
					'dateFormat'=>'yy-mm-dd',
					//'buttonText'=>'Seleccione Fecha',
					'selectOtherMonths'=>true,
					'showAnim'=>'slide',
					'showOtherMonths'=>true,
					'changeMonth'=>'true',
					'changeYear'=>'true',
				    'minDate'=>'date("Y-m-d")-2m',//fecha minima
					'maxDate'=>'date("Y-m-d")'//-10Y+6m',//fecha maxima
			),
		));
	?>
	<?php echo $formularioContratoFunc->error($modeloDatosContrato,'fecha_inicio',array('style' => 'color:#F00'));?>
    </div>
</div>
<div class="form-group">
<?php echo $formularioContratoFunc->labelEx($modeloDatosContrato,'fecha_fin',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
	<?php //
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array('model'=>$modeloDatosContrato,
			'name'=>'fecha_fin',
			'attribute'=>'fecha_fin',
			'value'=>"",
			'language'=>'es',			
			'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control','onChange'=>'js:$("#formularioContratoFunc").addClass("has-warning");'),			
			'options'=>array('autoSize'=>true,
					'defaultDate'=>$formAdol->fecha_nacimiento,
					'dateFormat'=>'yy-mm-dd',
					//'buttonText'=>'Seleccione Fecha',
					'selectOtherMonths'=>true,
					'showAnim'=>'slide',
					'showOtherMonths'=>true,
					'changeMonth'=>'true',
					'changeYear'=>'true',
				    'minDate'=>'date("Y-m-d")-2m',//fecha minima
					'maxDate'=>'date("Y-m-d")+1Y',//fecha maxima
			),
		));
	?>
	<?php echo $formularioContratoFunc->error($modeloDatosContrato,'fecha_fin',array('style' => 'color:#F00'));?>
    </div>
</div>
<?php 
	$modeloDatosContrato->contrato_actual='true';
	echo $formularioContratoFunc->hiddenField($modeloDatosContrato,'contrato_actual',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioContratoFunc").addClass("has-warning");'));
?>
<div class="form-group">
    <label class="col-md-4 control-label" for="button1id"></label>
    <div class="col-md-8">
       <?php $boton=CHtml::ajaxSubmitButton (
            'Asociar Contrato',   
            array('asociarContratoFuncionario'),
            array(				
                'dataType'=>'json',
                'type' => 'post',
                'beforeSend'=>'function (){
					 $("#formularioContratoFunc .errorMessage").text(""); 
                    $("#btnAsocSede").hide();
                    Loading.show();
                }',
                'success' => 'function(datosSeg) {	
                    Loading.hide();
                    if(datosSeg.estadoComu=="exito"){
                        if(datosSeg.resultado=="exito"){
                            //mensajeStripped=mensajeStripped.replace(/(<([^>]+)>)/ig,"");
                            jAlert("Asociación de contrato realizada", "Mensaje");
							$("#formularioContratoFunc").removeClass("has-warning");
							$("#formularioContratoFunc").removeClass("unsavedForm");	
                        }
                        else{
                            jAlert("Ha habido un error en la creación del registro. Código del error: "+datosSeg.resultado, "Mensaje");
                        }
                    }
                    else{						
                        $("#btnAsocSede").show();
                        $.each(datosSeg, function(key, val) {
                            $("#formularioContratoFunc #"+key+"_em_").text(val);                                                    
                            $("#formularioContratoFunc #"+key+"_em_").show();                                                
                        });
                    }
                    
                }',
                'error'=>'function (xhr, ajaxOptions, thrownError) {
                    Loading.hide();
                    //0 para error en comunicación
                    //200 error en lenguaje o motor de base de datos
                    //500 Internal server error
                    if(xhr.status==0){
                        jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema", "Mensaje");
                        $("#btnFormSeg").show();
                    }
                    else{
                        if(xhr.status==500){
                            jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información", "Mensaje");
                        }
                        else{
                            jAlert("No se ha creado el registro debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado", "Mensaje");
                        }	
                    }
                    
                }'
            ),
            array('id'=>'btnAsocContr','class'=>'btn btn-default btn-sdis','name'=>'btnAsocContr')
        );
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
    </div>
</div>

<?php $this->endWidget();?>   
<?php
Yii::app()->getClientScript()->registerScript('scriptContratoFunc','
$(window).bind("beforeunload", function(){
	if($(".unsavedForm").size()){
		return "Aún hay datos sin guardar si abandona la página estos no se guardaran";//va a cerrar
	}
});
'
,CClientScript::POS_BEGIN);
?>

<?php
Yii::app()->getClientScript()->registerScript('scriptContratoFunc_1','
	$(document).ready(function(){
		$("#formularioContratoFunc").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
	});
'
,CClientScript::POS_END);
?>



		
