<div id="Mensaje" style="font-size:14px; color:#F00" ></div>


<?php $formCreaUsusario=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioCreaUsuario',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')

)); ?>

	<?php echo  $formCreaUsusario->errorSummary($modeloPersona,'','',array('style' => 'font-size:14px;color:#F00')); ?>

<!-- Text input-->
    <div class="form-group">
	   	<?php echo $formCreaUsusario->labelEx($modeloPersona,'nombre_personal',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formCreaUsusario->textField($modeloPersona,'nombre_personal',array('class'=>'form-control input-md'));?>
            <?php echo $formCreaUsusario->error($modeloPersona,'nombre_personal',array('style' => 'color:#F00'));?>     
    	</div>
     </div>
     <div class="form-group">
	   	<?php echo $formCreaUsusario->labelEx($modeloPersona,'apellidos_personal',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formCreaUsusario->textField($modeloPersona,'apellidos_personal',array('class'=>'form-control input-md'));?>
            <?php echo $formCreaUsusario->error($modeloPersona,'apellidos_personal',array('style' => 'color:#F00'));?>     
    	</div>
     </div>
      <div class="form-group">
	   	<?php echo $formCreaUsusario->labelEx($modeloPersona,'id_cedula',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formCreaUsusario->textField($modeloPersona,'id_cedula',array('class'=>'form-control input-md'));?>
            <?php echo $formCreaUsusario->error($modeloPersona,'id_cedula',array('style' => 'color:#F00'));?>     
    	</div>
     </div>
      <div class="form-group">
	   	<?php echo $formCreaUsusario->labelEx($modeloPersona,'numero_tarjetaprof',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formCreaUsusario->textField($modeloPersona,'numero_tarjetaprof',array('class'=>'form-control input-md'));?>
            <?php echo $formCreaUsusario->error($modeloPersona,'numero_tarjetaprof',array('style' => 'color:#F00'));?>     
    	</div>
     </div>
      <div class="form-group">
	   	<?php echo $formCreaUsusario->labelEx($modeloPersona,'correo_electronico',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formCreaUsusario->textField($modeloPersona,'correo_electronico',array('class'=>'form-control input-md'));?>
            <?php echo $formCreaUsusario->error($modeloPersona,'correo_electronico',array('style' => 'color:#F00'));?>     
    	</div>
     </div>
      <div class="form-group">
	   	<?php echo $formCreaUsusario->labelEx($modeloPersona,'confirmaCorreo',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formCreaUsusario->textField($modeloPersona,'confirmaCorreo',array('class'=>'form-control input-md'));?>
            <?php echo $formCreaUsusario->error($modeloPersona,'confirmaCorreo',array('style' => 'color:#F00'));?>     
    	</div>
     </div>
     <hr />
      
     <div class="form-group">
			<?php echo $formCreaUsusario->labelEx($modeloUsuario,'id_rol',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
            <div class="col-md-4">
                <?php echo $formCreaUsusario->dropDownList($modeloUsuario,'id_rol',CHtml::listData($rol,'id_rol', 'nombre_rol'), 
					array(
						'prompt'=>'Seleccione...',
						'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true',								
					)); ?>
                     <?php echo $formCreaUsusario->error($modeloUsuario,'id_rol',array('style' => 'color:#F00'));?>     
            </div>
		</div>  
        <div class="form-group">
	   	<?php echo $formCreaUsusario->labelEx($modeloUsuario,'nombre_usuario',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formCreaUsusario->textField($modeloUsuario,'nombre_usuario',array('class'=>'form-control input-md'));?>
            <?php echo $formCreaUsusario->error($modeloUsuario,'nombre_usuario',array('style' => 'color:#F00'));?>     
    	</div>
     </div>  
   	<div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
      	
		<?php
		$boton=CHtml::ajaxSubmitButton (
						'Crear Usuario',   
						array('administracion/crearUsuario'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnFormReg").hide();Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="\'exito\'"){
										$("#formularioCreaUsuario #formularioCreaUsuario_es_").html("");                                                    
										$("#formularioCreaUsuario #formularioCreaUsuario_es_").hide(); 
										jAlert("Se creo el usuario exitosamente","Mensaje");
										$("#formularioCreaUsuario").removeClass("unsavedForm");   
									}
									else{
										$("#formularioCreaUsuario #formularioCreaUsuario_es_").html("");                                                    
										$("#formularioCreaUsuario #formularioCreaUsuario_es_").hide(); 
										$("#Mensaje").text("No se ha creado el usuario, el código del error es el siguiente: "+datos.resultado);
									}
								}
								else{						
									$("#btnFormReg").show();
									var errores="Por favor tenga en cuenta las siguientes validaciones:<br/><ul>";
									$.each(datos, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioCreaUsuario #"+key+"_em_").text(val);                                                    
										$("#formularioCreaUsuario #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioCreaUsuario #formularioCreaUsuario_es_").html(errores);                                                    
									$("#formularioCreaUsuario #formularioCreaUsuario_es_").show(); 
								}
								
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#Mensaje").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormReg").show();
								}
								else{
									if(xhr.status==500){
										$("#Mensaje").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
									}
									else{
										$("#Mensaje").html("Ha habido un error. \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
								
							}'
						),
						array('id'=>'btnFormReg','name'=>'btnFormReg','class'=>'btn btn-default btn-sdis')
				);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
   </div>
    </div>
<?php $this->endWidget();?>
<?php Yii::app()->getClientScript()->registerScript('validaForm','
$(document).ready(function(){
	$("#formularioCreaUsuario").find(":input").change(function(){
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
});'
,CClientScript::POS_END);

?>
