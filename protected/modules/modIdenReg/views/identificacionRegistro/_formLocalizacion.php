<div id="MensajeLoc" style="font-size:14px;" ></div>
<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>
<?php $formLoc=$this->beginWidget('CActiveForm', array(
	'id'=>'formLocalizacion',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
<?php echo  $formLoc->errorSummary($modeloLocalizacion,'','' ,array('style' => 'font-size:14px;color:#F00')); ?>

	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group"> 
	<?php echo $formLoc->labelEx($modeloLocalizacion,'id_localidad',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formLoc->dropDownList($modeloLocalizacion,'id_localidad',CHtml::listData($localidad,'id_localidad', 'localidad'), array('prompt'=>'Seleccione Localidad','class'=>'form-control input-md')); ?>
            <?php echo $formLoc->error($modeloLocalizacion,'id_tipo_doc',array('style' => 'color:#F00')); ?>
		</div>
    </div>
    <div class="form-group">                                       
	<?php echo $formLoc->labelEx($modeloLocalizacion,'barrio',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formLoc->textField($modeloLocalizacion,'barrio',array('class'=>'form-control input-md'));?>
            <?php echo $formLoc->error($modeloLocalizacion,'barrio',array('style' => 'color:#F00'));?>
   		</div>
    </div>
	<div class="form-group">                                       
	<?php echo $formLoc->labelEx($modeloLocalizacion,'direccion',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formLoc->textField($modeloLocalizacion,'direccion',array('class'=>'form-control input-md'));?>
            <?php echo $formLoc->error($modeloLocalizacion,'direccion',array('style' => 'color:#F00'));?>
        </div>
    </div>
	<div class="form-group">                                       
    <?php echo $formLoc->labelEx($modeloLocalizacion,'id_estrato',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
			<?php echo $formLoc->dropDownList($modeloLocalizacion,'id_estrato',CHtml::listData($estrato,'id_estrato', 'estrato'), array('prompt'=>'Seleccione Estrato','class'=>'form-control input-md')); ?>
            <?php echo $formLoc->error($modeloLocalizacion,'id_estrato',array('style' => 'color:#F00')); ?>
		</div>
    </div>
	<div class="form-group">                                       
	<?php echo $formLoc->labelEx($modeloTelefono,'telefono',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formLoc->textField($modeloTelefono,'telefono',array('class'=>'form-control input-md'));?>
           <?php echo $formLoc->error($modeloTelefono,'telefono',array('style' => 'color:#F00'));?>
        </div>    
	</div>
	<div class="form-group">                                       
	<?php echo $formLoc->labelEx($modeloTelefono,'tel_sec',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formLoc->textField($modeloTelefono,'tel_sec',array('class'=>'form-control input-md'));?>
            <?php echo $formLoc->error($modeloTelefono,'tel_sec',array('style' => 'color:#F00'));?>
        </div>    
	</div>
	<!--<div class="form-group">                                       
	<?php //echo $formLoc->labelEx($modeloTelefono,'celular',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php //echo $formLoc->textField($modeloTelefono,'celular',array('class'=>'form-control input-md'));?>
            <?php //echo $formLoc->error($modeloTelefono,'celular',array('style' => 'color:#F00'));?>
        </div>    
	</div>-->
    <hr />
     <div class="row">
	<?php 
		if(!empty($numDocAdol)){
			$modeloLocalizacion->num_doc=$numDocAdol;
		}
		echo $formLoc->labelEx($modeloLocalizacion,'num_doc');?>
	<?php echo CHtml::label($numDocAdol,'numDocLbl',array('id'=>'numDocLblLoc'));?>
	<?php echo $formLoc->hiddenField($modeloLocalizacion,'num_doc');?>
	<?php echo $formLoc->error($modeloLocalizacion,'num_doc',array('style' => 'color:#F00'));?>
	</div>
    <?php
		$boton=CHtml::ajaxSubmitButton (
						'Crear Registro',   
						array('identificacionRegistro/creaLocAdol'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){Loading.show();$("#btnFormLocaliz").hide();}',
							'success' => 'function(datosLoc) {	
								Loading.hide();
								if(datosLoc.estadoComu=="exito"){
									if(datosLoc.resultado=="exito"){
										var errorTelefono=datosLoc.msnErrorTel;
										if(errorTelefono!="\'exito\'"){
											var mensajeTel="Aunque ha habido un error en el registro de los teléfonos.  Este es el código del error "+ datosLoc.msnErrorTel.errorInfo;
										}
										else{
											var mensajeTel="Los telefonos se han registrado satisfactoriamente";
										}
										$("#MensajeLoc").html("Los datos de localización se han enviado satisfactoriamente.<br/>"+mensajeTel);	
										$("#formLocalizacion #formLocalizacion_es_").html("");                                                    
										$("#formLocalizacion #formLocalizacion_es_").hide();
										$("#formLocalizacion").find("input, textarea, button, select").attr("disabled",true);
										$("#formLocalizacion").removeClass("unsavedForm");
									}
									else{
										$("#MensajeLoc").html("Ha habido un error en la creación del registro. Código del error: "+datosLoc.msnError);
										$("#formLocalizacion #formLocalizacion_es_").html("");                                                    
										$("#formLocalizacion #fformLocalizacion_es_").hide(); 	
									}
								}
								else{						
									$("#btnFormLocaliz").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datosLoc, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formLocalizacion #"+key+"_em_").text(val);                                                    
										$("#formLocalizacion #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formLocalizacion #formLocalizacion_es_").html(errores);                                                    
									$("#formLocalizacion #formLocalizacion_es_").show(); 
								}
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#MensajeLoc").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormLocaliz").show();
								}
								else{
									if(xhr.status==500){
										$("#MensajeLoc").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información.<br/> El código del error es el siguiente: <br/> "+xhr.responseText);
									}
									else{
										$("#MensajeLoc").html("No se ha creado el registro de la localización debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
							}'
						),
						array('id'=>'btnFormLocaliz','name'=>'btnFormLocaliz','class'=>'btn btn-default btn-sdis')
				);		
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
<?php $this->endWidget();?>
<?php //script de seguridad que previene dejar la página si no se han guardado los datos
/*Yii::app()->getClientScript()->registerScript('dejaVentana','
	
		$(window).bind("beforeunload", function(){
			//return "Va a dejar la página"
		});
	'
,CClientScript::POS_END);*/

Yii::app()->getClientScript()->registerScript('prepFormLoc','
		var numDocAdol="";
		numDocAdol="'.$numDocAdol.'";
		$("#formLocalizacion #LocalizacionViv_barrio").keyup(
			function(){
				$("#formularioAcudiente #LocalizacionViv_barrio").val($("#formLocalizacion #LocalizacionViv_barrio").val());
			}
		);
		$("#formLocalizacion #LocalizacionViv_direccion").keyup(
			function(){
				$("#formularioAcudiente #LocalizacionViv_direccion").val($("#formLocalizacion #LocalizacionViv_direccion").val());
			}
		);
		$("#formLocalizacion #Telefono_telefono").keyup(
			function(){
				$("#formularioAcudiente #Telefono_telefono").val($("#formLocalizacion #Telefono_telefono").val());
			}
		);
		if(numDocAdol==""){
			$("#btnFormLocaliz").hide();
			$("#formLocalizacion").find("input, textarea, button, select").attr("disabled",true);
		}
	'
,CClientScript::POS_END);

 ?>