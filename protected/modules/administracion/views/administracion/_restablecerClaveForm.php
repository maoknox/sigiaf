<div class="panel-heading color-sdis">Digite nombre de usuario</div> 
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
		<?php echo $formCambiaClave->labelEx($modeloUsuario,'nombre_usuario',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formCambiaClave->textField($modeloUsuario,'nombre_usuario',array('class'=>'form-control input-md'));?>
            <?php echo $formCambiaClave->error($modeloUsuario,'nombre_usuario',array('style' => 'color:#F00'));?>     
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <?php 
				$modeloUsuario->id_cedula="aux";
				$modeloUsuario->id_rol=-1;
				$modeloUsuario->pers_habilitado="aux";
				$modeloUsuario->clave="aux";
				$modeloUsuario->pers_habilitado="aux";
			 ?>   
            <?php echo $formCambiaClave->hiddenField($modeloUsuario,'id_cedula',array('class'=>'form-control input-md'));?>
            <?php echo $formCambiaClave->hiddenField($modeloUsuario,'id_rol',array('class'=>'form-control input-md'));?>
            <?php echo $formCambiaClave->hiddenField($modeloUsuario,'clave',array('class'=>'form-control input-md'));?>
            <?php echo $formCambiaClave->hiddenField($modeloUsuario,'pers_habilitado',array('class'=>'form-control input-md'));?>
              
        </div>
    </div>
	<div class="form-group">
    <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4"> 
    	<?php
		        $boton=CHtml::ajaxSubmitButton (
					'Restablecer Clave',   
					array('administracion/restablecerClave'),
					array(				
						'dataType'=>'json',
						'type' => 'post',
						'beforeSend'=>'function (){$("#btnFormCambiaClave").hide();Loading.show();}',
						'success' => 'function(datosRef) {	
							Loading.hide();
							if(datosRef.estadoComu=="exito"){
								if(datosRef.resultado=="exito"){									
									jAlert("La clave fue modificada satisfactoriamente y fue enviada al correo: "+datosRef.correo, "Mensaje");
									$("#formularioCambiaClave").removeClass("unsavedForm");
									$("#formularioCambiaClave #Usuario_clave_em_").html("");
									$("#formularioCambiaClave #formularioCambiaClave_es_").html("");      
								}
								else
									if(datosRef.resultado=="nocorreo"){
										jAlert("El usuario no existe o no tiene relacionado un correo, comuníquese con la/el lider administrativo.", "Mensaje");
										$("#btnFormCambiaClave").show();
										$("#formularioCambiaClave").removeClass("unsavedForm");
										$("#formularioCambiaClave #Usuario_clave_em_").html("");
										$("#formularioCambiaClave #formularioCambiaClave_es_").html("");   
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
									jAlert("Acción no satisfactoria debido al siguiente error: \n"+xhr.responseText+" Comuníquese con el ingeniero encargado", "Mensaje");
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


