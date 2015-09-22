<?php if(!empty($numDocAdol)):?>
    <div id="MensajeConcInt" style="font-size:14px;"></div>
    <fieldset id="concIntegral" >
	<div class="panel-heading color-sdis">Concepto Integral</div> 
    <?php $formConcInt=$this->beginWidget('CActiveForm', array(
        'id'=>'formularioConcInt',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>false,
        ),
		'htmlOptions' => array('class' => 'form-horizontal')
    ));
    ?>
    <?php echo  $formConcInt->errorSummary($modeloConInt,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<div class="form-group">
        <div class="col-md-12">
			<?php 
                $modeloConInt->num_doc=$numDocAdol;
                $modeloConInt->fecha_concint=date("Y-m-d");
			 	echo $formConcInt->textArea($modeloConInt,
                'concepto_integral',
                array('class'=>'form-control',
                    'onkeyup'=>'js:$("#concIntegral").addClass("has-warning")'
                ));
				
                echo $formConcInt->hiddenField($modeloConInt,'num_doc');
                echo $formConcInt->hiddenField($modeloConInt,'fecha_concint');?>
       </div>
    </div>
	<div class="form-group">
        <div class="col-md-4">
			<?php $boton=CHtml::ajaxSubmitButton (
				'Registrar Concepto',   
				array('valoracionIntegral/modificaConcInt'),
				array(				
					'dataType'=>'json',
					'type' => 'post',
					'beforeSend'=>'function (){$("#btnFormRef").hide();Loading.show();}',
					'success' => 'function(datosRef) {	
						Loading.hide();
						if(datosRef.estadoComu=="exito"){
							if(datosRef.resultado=="\'exito\'"){
								$("#concIntegral").removeClass("has-warning");
								$("#formularioConcInt").removeClass("unsavedForm")
								$("#MensajeConcInt").text("Concepto registrado satisfactoriamente");
								$("#formularioConcInt #formularioConcInt_es_").html("");      
							}
							else{
								$("#MensajeConcInt").text("Ha habido un error en la creación del registro. Código del error: "+datosRef.resultado);
								$("#formularioConcInt #formularioConcInt_es_").html("");                                                    
								//$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
							}
						}
						else{						
							$("#btnFormRef").show();
							var errores="Por favor corrija los siguientes errores<br/><ul>";
							$.each(datosRef, function(key, val) {
								errores+="<li>"+val+"</li>";
								$("#formularioConcInt #"+key+"_em_").text(val);                                                    
								$("#formularioConcInt #"+key+"_em_").show();                                                
							});
							errores+="</ul>";
							$("#formularioConcInt #formularioConcInt_es_").html(errores);                                                    
							$("#formularioConcInt #formularioConcInt_es_").show(); 
							
						}
						
					}',
					'error'=>'function (xhr, ajaxOptions, thrownError) {
						Loading.hide();
						//0 para error en comunicación
						//200 error en lenguaje o motor de base de datos
						//500 Internal server error
						if(xhr.status==0){
							$("#MensajeConcInt").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
							$("#btnFormRef").show();
						}
						else{
							if(xhr.status==500){
								$("#MensajeConcInt").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
							}
							else{
								$("#MensajeConcInt").html("No se ha creado el registro debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
							}	
						}
						
					}'
				),
				array('id'=>'btnFormRef','class'=>'btn btn-default btn-sdis','name'=>'btnFormRef')
			);
			?>
			<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
        <?php $this->endWidget();
    ?>
    
<?php
Yii::app()->getClientScript()->registerScript('scripValTrSoc_1','
	$(window).bind("beforeunload", function(){
		if($(".unsavedForm").size()){
			return "va a cerrar";
		}
	});
	$(document).ready(function(){
		$("#concIntegral").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
	});
	',CClientScript::POS_END);
?>

</fieldset>
<?php endif;?>