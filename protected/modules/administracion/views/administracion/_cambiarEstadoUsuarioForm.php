<div id="Mensaje" style="font-size:14px; color:#F00" ></div>
<fieldset>    
    <!-- Form Name -->
    <legend>Habilitar/Deshabilitar usuarios</legend>
    <div id="estadoUsr" style="font-size:14px; color:#F00"></div>
    <?php $formHabDeshabUsr=$this->beginWidget('CActiveForm', 
			array(
				'id'=>'formHabDeshabUsr',
				'enableAjaxValidation'=>false,
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
					'validateOnChange' => true,
                    'validateOnType' => true
				),
				'htmlOptions' => array('class' => 'form-horizontal')
				)
			);
        ?>
		<?php echo  $formHabDeshabUsr->errorSummary($modeloUsuario,'','',array('style' => 'font-size:14px;color:#F00')); ?>
    	<div class="form-group">
			<?php echo $formHabDeshabUsr->labelEx($modeloUsuario,'id_cedula',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
            <div class="col-md-4">
                    <?php echo $formHabDeshabUsr->dropDownList($modeloUsuario,'id_cedula',CHtml::listData($funcionarios, 'id_cedula', 'nombres'),
						array(
							'prompt'=>'Seleccione Funcionario',
							'class'=>'selectpicker form-control',
							'data-hide-disabled'=>'true',
							'data-live-search'=>'true',
							'onchange'=>'js:consultaDatosFuncionario(this);'
							
						)); ?>
                	<?php echo $formHabDeshabUsr->error($modeloUsuario,'id_cedula',array('style' => 'color:#F00')); ?>
                    
               
            </div>
		</div>  
         <div class="form-group">
			<?php 
				$estadosUsuario=array(array('estado'=>'true','nombestado'=>'habilitar'),array('estado'=>'false','nombestado'=>'deshabilitar'));
				echo $formHabDeshabUsr->labelEx($modeloUsuario,'pers_habilitado',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
            <div class="col-md-4"> 
               <?php echo $formHabDeshabUsr->radioButtonList($modeloUsuario,'pers_habilitado',CHtml::listData($estadosUsuario, 'estado', 'nombestado'),
			   		array('class'=>'radio-inline')); 
				?>
    	        <?php echo $formHabDeshabUsr->error($modeloUsuario,'pers_habilitado',array('style' => 'color:#F00')); ?>
                
            </div>
        </div>
           	<div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
      	
		<?php
		$boton=CHtml::ajaxSubmitButton (
						'Registrar',   
						array('administracion/cambiarEstadoFuncionario'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="\'exito\'"){
										$("#formHabDeshabUsr #formHabDeshabUsr_es_").html("");                                                    
										$("#formHabDeshabUsr #formHabDeshabUsr_es_").hide(); 
										$("#Mensaje").text("Se registró el estado satisfactoriamente");
										$("#formHabDeshabUsr").removeClass("unsavedForm");   
									}
									else{
										$("#formHabDeshabUsr #formHabDeshabUsr_es_").html("");                                                    
										$("#formHabDeshabUsr #formHabDeshabUsr_es_").hide(); 
										$("#Mensaje").text("No se ha cambiado el estado del usuario, el código del error es el siguiente: "+datos.resultado);
									}
								}
								else{						
									$("#btnFormReg").show();
									var errores="Por favor tenga en cuenta las siguientes validaciones:<br/><ul>";
									$.each(datos, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formHabDeshabUsr #"+key+"_em_").text(val);                                                    
										$("#formHabDeshabUsr #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formHabDeshabUsr #formHabDeshabUsr_es_").html(errores);                                                    
									$("#formHabDeshabUsr #formHabDeshabUsr_es_").show(); 
								}
								
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								$("#btnFormReg").hide();
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
										$("#Mensaje").html("No se ha registrado la información debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
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

<?php
$this->endWidget();
?>
 
</fieldset>
<?php Yii::app()->getClientScript()->registerScript('tratamientoForm','
		$(document).ready(function(){
			$("#formHabDeshabUsr").find(":input").change(function(){
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
	function consultaDatosFuncionario(elemento){
		//$("#estadoUsr").text("El estado del usuario es deshabilitado");
		//$("#radios-0").attr("checked","true");
		 $.ajax({
            url: "'.Yii::app()->createUrl('administracion/administracion/consultaEstadoUsuario').'", 
			type: "post", 
            data: {id_cedula:$("#Usuario_id_cedula").val()},
			dataType: "json",
			beforeSend:function(){Loading.show();},
            success: function(datos){
				Loading.hide();
				$("#estadoUsr").text("El estado del usuario es "+datos.estadousuario)	
			}, 
            error: function(e,ajaxOptions, thrownError){
                $("#Mensaje").html(e.responseText);
            }
        });    
	}	
',CClientScript::POS_END);		
?>


