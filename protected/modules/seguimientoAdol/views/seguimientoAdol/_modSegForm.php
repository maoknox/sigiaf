<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('seguimientoAdol/seguimientoAdol/registrarSeg'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>

<div id="MensajeSeguimiento" style="font-size:14px;"></div>

<?php 

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioSegAdol',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
<?php echo  $form->errorSummary($modeloSeguimiento,'','',array('style' => 'font-size:14px;color:#F00')); ?>
<fieldset>
    <div class="panel-heading color-sdis">Diligenciamiento del seguimiento</div>
    <br />
       	<div class="form-group">
		<?php echo $form->labelEx($modeloSeguimiento,'fecha_seguimiento',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    	<div class="col-md-4">
            <?php $modeloSeguimiento->fecha_seguimiento=$seguimientoAModificar["fecha_seguimiento"];
                $this->widget('zii.widgets.jui.CJuiDatePicker',
					array('model'=>$modeloSeguimiento,
					'attribute'=>'fecha_seguimiento',
					'value'=>$seguimientoAModificar["fecha_seguimiento"],
					'language'=>'es',
					'htmlOptions'=>	array('readonly'=>'readonly','class'=>'col-md-4 form-control'),
					'options'=>array('autoSize'=>true,
							'defaultDate'=>$modeloSeguimiento->fecha_seguimiento,
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
							'maxDate'=>date("Y-m-d")					
					),
				));
			?>
			<?php echo $form->error($modeloSeguimiento,'fecha_seguimiento',array('style' => 'color:#F00'));?>
    	</div>
	</div>   
	<div class="form-group">
        <div class="col-md-12">
		<?php echo $form->labelEx($modeloSeguimiento,'seguimiento_adol',array('class'=>'control-label','for'=>'searchinput'));?></br>
        <?php 
			$modeloSeguimiento->seguimiento_adol=$seguimientoAModificar["seguimiento_adol"];
			echo $form->textArea($modeloSeguimiento,'seguimiento_adol',array('class'=>'form-control')) 
		?>
        <?php echo $form->error($modeloSeguimiento,'seguimiento_adol',array('style' => 'color:#F00'));?>
        </div> 
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
				$modeloSeguimiento->id_tipo_seguim=$seguimientoAModificar["id_tipo_seguim"];
				$modeloSeguimiento->id_area_seguimiento=$seguimientoAModificar["id_area_seguimiento"];
				$modeloSeguimiento->seguim_conj=1;
				$modeloSeguimiento->id_area_seguimiento=$seguimientoAModificar["id_area_seguimiento"];
				$modeloSeguimiento->id_seguimientoadol=$seguimientoAModificar["id_seguimientoadol"];
                $modeloSeguimiento->num_doc=$numDocAdol;
                echo $form->hiddenField($modeloSeguimiento,'num_doc');
				echo $form->hiddenField($modeloSeguimiento,'id_tipo_seguim');
				echo $form->hiddenField($modeloSeguimiento,'id_area_seguimiento');
				echo $form->hiddenField($modeloSeguimiento,'seguim_conj');
				echo $form->hiddenField($modeloSeguimiento,'id_seguimientoadol');
				echo $form->hiddenField($modeloSeguimiento,'fecha_registro_seg');
                $boton=CHtml::ajaxSubmitButton (
					'Modificar Seguimiento',   
					array('registraModSegimiento'),
					array(				
						'dataType'=>'json',
						'type' => 'post',
						'beforeSend'=>'function (){
							$("#btnFormSeg").hide();
							Loading.show();
						}',
						'success' => 'function(datosSeg) {	
							Loading.hide();
							if(datosSeg.estadoComu=="exito"){
								if(datosSeg.resultado=="\'exito\'"){
									var mensaje="Seguimiento registrado satisfactoriamente"+alert(document.cookie);
									var mensajeStripped=mensaje.replace(alert,"");
									mensajeStripped=mensajeStripped.replace(/(<([^>]+)>)/ig,"");
									jAlert("Seguimiento modificado satisfactoriamente", "Mensaje");
									//$("#MensajeSeguimiento").text("Seguimiento registrado satisfactoriamente");
									$("#formularioSegAdol #formularioSegAdol_es_").html("");   
									$("#formularioSegAdol").removeClass("unsavedForm");
								}
								else{
									$("#MensajeSeguimiento").text("Ha habido un error en la creación del registro. Código del error: "+datosSeg.resultado);
									$("#formularioSegAdol #formularioSegAdol_es_").html("");                                                    
									//$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
								}
							}
							else{						
								$("#btnFormSeg").show();
								var errores="Por favor corrija los siguientes errores<br/><ul>";
								$.each(datosSeg, function(key, val) {
									errores+="<li>"+val+"</li>";
									$("#formularioSegAdol #"+key+"_em_").text(val);                                                    
									$("#formularioSegAdol #"+key+"_em_").show();                                                
								});
								errores+="</ul>";
								$("#formularioSegAdol #formularioSegAdol_es_").html(errores);                                                    
								$("#formularioSegAdol #formularioSegAdol_es_").show(); 
								
							}
							
						}',
						'error'=>'function (xhr, ajaxOptions, thrownError) {
							Loading.hide();
							//0 para error en comunicación
							//200 error en lenguaje o motor de base de datos
							//500 Internal server error
							if(xhr.status==0){
								$("#MensajeSeguimiento").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
								$("#btnFormSeg").show();
							}
							else{
								if(xhr.status==500){
									$("#MensajeSeguimiento").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
								}
								else{
									$("#MensajeSeguimiento").html("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
								}	
							}
							
						}'
					),
					array('id'=>'btnFormSeg','class'=>'btn btn-default btn-sdis','name'=>'btnFormSeg')
				);
            ?>
        	<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div> 
	</div>
	<?php $this->endWidget();?>

<?php Yii::app()->getClientScript()->registerScript('script_asignaref','
		$(document).ready(function(){
			$("form").find("textArea").each(function(){
				$(this).css("height","200px");
			});
		});	
		$(document).ready(function(){
			$("#formularioSegAdol").find(":input").change(function(){
		  	var dirtyForm = $(this).parents("form");
		  // change form status to dirty
		  	dirtyForm.addClass("unsavedForm");
		});});			
		var campoText=0;
		$(window).bind("beforeunload", function(){
			if($(".unsavedForm").size()){
				return "va a cerrar";
			}
		});
		function consProf(idSegConj){
			$.ajax({
				type:"post", //request type
				datatype:"json",
				data:"idSegConj="+idSegConj,
				url:"'.CController::createUrl("consProf").'", //url to call.
				beforeSend:function(){
					if(idSegConj==1){
						$("#SeguimientoAdol_idCedula").attr("disabled",true);
						$("#formularioSegAdol #SeguimientoAdol_idCedula_em_").hide(""); 
						return;  
					}
					else{
						$("#SeguimientoAdol_idCedula").attr("disabled",false);	
					}					
				},
				success:function(datos){
					var datos = jQuery.parseJSON(datos);
					var contenido="<option value=\'\'>Seleccione</option>";
					var benef="";
					$.each(datos,function(key,value){
						contenido+="<option value=\'"+key+"\'>"+value+"</option>";
						benef=value.idben;
					})					
					$("#SeguimientoAdol_idCedula").html("");
					$("#SeguimientoAdol_idCedula").append(contenido);
					
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert(thrownError);	
				}
			})
		}
	'
,CClientScript::POS_END);
?>

		