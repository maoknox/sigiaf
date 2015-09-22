<div class="panel-heading color-sdis">Cambiar Clave</div> 
<br />
<?php $formCambiaClave=$this->beginWidget('CActiveForm', array(
	//'action'=>'creaRol',
	'id'=>'formularioCambiaClave',
	//'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<?php echo  $formCambiaClave->errorSummary($modeloUsuario,'','',array('style' => 'font-size:14px;color:#F00')); ?>
    <div class="form-group">
		<?php echo $formCambiaClave->labelEx($modeloUsuario,'clave',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formCambiaClave->passwordField($modeloUsuario,'clave',array('class'=>'form-control input-md'));?>
            <?php echo $formCambiaClave->error($modeloUsuario,'clave',array('style' => 'color:#F00'));?>     
        </div>
    </div>
    <div class="form-group">
		<?php echo $formCambiaClave->labelEx($modeloUsuario,'verificaClave',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formCambiaClave->passwordField($modeloUsuario,'verificaClave',array('class'=>'form-control input-md'));?>
            <?php echo $formCambiaClave->error($modeloUsuario,'verificaClave',array('style' => 'color:#F00'));?>   
            <?php 
				$modeloUsuario->id_cedula=$datosUsuario["id_cedula"];
				$modeloUsuario->id_rol=$datosUsuario["id_rol"];
				$modeloUsuario->nombre_usuario="default_Cambia_clave";
				$modeloUsuario->pers_habilitado=$datosUsuario["pers_habilitado"];
			 ?>   
            <?php echo $formCambiaClave->hiddenField($modeloUsuario,'id_cedula',array('class'=>'form-control input-md'));?>
            <?php echo $formCambiaClave->hiddenField($modeloUsuario,'id_rol',array('class'=>'form-control input-md'));?>
            <?php echo $formCambiaClave->hiddenField($modeloUsuario,'nombre_usuario',array('class'=>'form-control input-md'));?>
            <?php echo $formCambiaClave->hiddenField($modeloUsuario,'pers_habilitado',array('class'=>'form-control input-md'));?>
              
        </div>
    </div>
	<div class="form-group">
    <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4"> 
    	<?php
		        $boton=CHtml::ajaxSubmitButton (
					'Cambiar Clave',   
					array('administracion/cambiarClave'),
					array(				
						'dataType'=>'json',
						'type' => 'post',
						'beforeSend'=>'function (){$("#btnFormCambiaClave").hide();Loading.show();}',
						'success' => 'function(datosRef) {	
							Loading.hide();
							if(datosRef.estadoComu=="exito"){
								if(datosRef.resultado=="exito"){
									
									//$("#MensajeRef").text("Rol creado satisfactoriamente");
									jAlert("Clave modificada", "Mensaje");
									$("#formularioCambiaClave").removeClass("unsavedForm");
									$("#formularioCambiaClave #Usuario_clave_em_").html("");
									$("#formularioCambiaClave #formularioCambiaClave_es_").html("");      
								}
								else{
									jAlert("Ha habido un error en la creación del registro. Código del error: "+datosRef.resultado, "Mensaje");
								   // $("#MensajeRef").text("Ha habido un error en la creación del registro. Código del error: "+datosRef.resultado);
									//$("#formularioRef #formularioRef_es_").html("");                                                    
									//$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
								}
							}
							else{						
								$("#btnFormCambiaClave").show();
								var errores="Por favor corrija los siguientes errores<br/><ul>";
								$.each(datosRef, function(key, val) {
									errores+="<li>"+val+"</li>";
									$("#formularioCambiaClave #"+key+"_em_").text(val);                                                    
									$("#formularioCambiaClave #"+key+"_em_").show();                                                
								});
								errores+="</ul>";
								$("#formularioCambiaClave #formularioCambiaClave_es_").html(errores);                                                    
								$("#formularioCambiaClave #formularioCambiaClave_es_").show(); 
							}
							
						}',
						'error'=>'function (xhr, ajaxOptions, thrownError) {
							var StrippedString = xhr.responseText.replace(/(<([^>]+)>)/ig,"");
							Loading.hide();
							//0 para error en comunicación
							//200 error en lenguaje o motor de base de datos
							//500 Internal server error
							if(xhr.status==0){
								jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema", "Mensaje");
								//$("#MensajeRef").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
								$("#btnFormRef").show();
							}
							else{
								if(xhr.status==500){	
									//var alertaError=alert(document.cookie);
									//var alertaStripped=alertaError.replace(/(<([^>]+)>)/ig,"");										
									jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información <br/>"+StrippedString, "Mensaje");
									//$("#MensajeRef").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
								}
								else{
									jAlert("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado", "Mensaje");
								}	
							}
						}'
					),
					array('id'=>'btnFormCambiaClave','class'=>'btn btn-default btn-sdis','name'=>'btnFormCambiaClave')
			);

		
		?>
    
        
	    <?php echo $boton; ?>     
    </div>
</div>

<?php
$this->endWidget();
?>
<?php Yii::app()->getClientScript()->registerScript('tratamientoForm','
		$(document).ready(function(){
			$("#formularioCambiaClave").find(":input").change(function(){
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
',CClientScript::POS_END);		
?>


