<div id="Mensaje" style="font-size:14px;" ></div>
<?php $formCreaSede=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioRegSede',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<fieldset>

<!-- Form Name -->
<legend>Datos de la Sede</legend>
	<?php echo  $formCreaSede->errorSummary($modeloCForjar,'','',array('style' => 'font-size:14px;color:#F00')); ?>

<!-- Text input-->
    <div class="form-group">
	   	<?php echo $formCreaSede->labelEx($modeloCForjar,'nombre_sede',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formCreaSede->textField($modeloCForjar,'nombre_sede',array('class'=>'form-control input-md'));?>
            <?php echo $formCreaSede->error($modeloCForjar,'nombre_sede',array('style' => 'color:#F00'));?>     
    	</div>
     </div>
     <div class="form-group">
	   	<?php echo $formCreaSede->labelEx($modeloCForjar,'direccion_forjar',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formCreaSede->textField($modeloCForjar,'direccion_forjar',array('class'=>'form-control input-md'));?>
            <?php echo $formCreaSede->error($modeloCForjar,'direccion_forjar',array('style' => 'color:#F00'));?>     
    	</div>
     </div>
     <div class="form-group">
	   	<?php echo $formCreaSede->labelEx($modeloTelForjar,'num_tel_forjar',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
        	<?php $modeloTelForjar->id_tipo_telefono=1;?>
            <?php $modeloTelForjar->id_forjar=Yii::app()->user->getState('sedeForjar');?>
            <?php echo $formCreaSede->textField($modeloTelForjar,'num_tel_forjar',array('class'=>'form-control input-md'));?>
            <?php echo $formCreaSede->hiddenField($modeloTelForjar,'id_tipo_telefono');?>
            <?php echo $formCreaSede->hiddenField($modeloTelForjar,'id_forjar');?>
            <?php echo $formCreaSede->error($modeloTelForjar,'num_tel_forjar',array('style' => 'color:#F00'));?>     
    	</div>
     </div>
     <div class="form-group">
	   	<?php echo $formCreaSede->labelEx($modeloTelForjar,'numCelular',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
        	<?php $modeloTelForjar->id_tipo_telefono=2;?>
            <?php $modeloTelForjar->id_forjar=Yii::app()->user->getState('sedeForjar');?>
            <?php echo $formCreaSede->textField($modeloTelForjar,'numCelular',array('class'=>'form-control input-md'));?>
            <?php echo $formCreaSede->hiddenField($modeloTelForjar,'id_tipo_telefono');?>
            <?php echo $formCreaSede->hiddenField($modeloTelForjar,'id_forjar');?>
            <?php echo $formCreaSede->error($modeloTelForjar,'numCelular',array('style' => 'color:#F00'));?>     
    	</div>
     </div>
     <!-- Button (Double) -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
     
<?php
		$boton=CHtml::ajaxSubmitButton (
						'Crear Sede',   
						array('administracion/creaSedeforjar'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnCreaSede").hide();Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="\'exito\'"){
										
									}
									else{
									}
								}
								else{						
									$("#btnCreaSede").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datos, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioRegSede #"+key+"_em_").text(val);                                                    
										$("#formularioRegSede #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioRegSede #formularioRegSede_es_").html(errores);                                                    
									$("#formularioRegSede #formularioRegSede_es_").show(); 
								}
								
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#Mensaje").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormAdolId").show();
								}
								else{
									if(xhr.status==500){
										$("#Mensaje").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
									}
									else{
										$("#Mensaje").html("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
								
							}'
						),
						array('id'=>'btnCreaSede','name'=>'btnCreaAdolN','class'=>'btn btn-default btn-sdis')
				);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
   </div>
    </div>
    </fieldset>
<?php $this->endWidget();?>

<?php Yii::app()->getClientScript()->registerScript('validaForm','
$(document).ready(function(){
	$("form").find(":input").change(function(){
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