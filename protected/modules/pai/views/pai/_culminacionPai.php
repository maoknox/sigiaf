<?php 
if($modeloPAI->culminacion_pai!=1):
?>
<fieldset>
<div class="panel-heading color-sdis">Registrar culminación</div> 
<?php $formCulmPai=$this->beginWidget('CActiveForm', array(
	'id'=>'formCulmPai',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));?>
<div id="MensajeCulm" style="font-size:14px;"></div>
	<?php echo  $formCulmPai->errorSummary($modeloPAI,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<div class="form-group">
        <div class="col-md-4">	
			<?php echo $formCulmPai->labelEx($modeloPAI,'culminacion_pai');?>
            <?php echo $formCulmPai->radioButton($modeloPAI,'culminacion_pai'); ?>
            <?php echo $formCulmPai->error($modeloPAI,'culminacion_pai',array('style' => 'color:#F00'));?>    
        </div>
    </div>
	<div class="form-group">
        <div class="col-md-12">	
			<?php echo $formCulmPai->textArea($modeloPAI,'recomend_posegreso',array('class'=>'form-control'));?>    
            <?php echo $formCulmPai->error($modeloPAI,'recomend_posegreso',array('style' => 'color:#F00'));?>
        </div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php echo $formCulmPai->hiddenField($modeloPAI,'num_doc');?>    
            <?php echo $formCulmPai->hiddenField($modeloPAI,'id_pai');?>    
            <?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormCulmPai','class'=>'btn btn-default btn-sdis','name'=>'btnFormCulmPai','onclick'=>'js:enviaFormOpt()')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</fieldset>
<?php
Yii::app()->getClientScript()->registerScript('scriptPai_3','
function enviaFormOpt(){
			$.ajax({
				url: "regCulmPai",
				data:$("#formCulmPai").serialize(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){
						$("#formCulmPai #formCulmPai_es_").html("");                                                    
						$("#formCulmPai #formCulmPai_es_").hide(); 
						if(datos.resultado=="\'exito\'"){
							$("#MensajeCulm").text("exito");							
						}
						else{
							$("#MensajeCulm").text("Error en la creación del registro.  Motivo "+datos.resultado);
						}
					}
					else{
						var errores="Por favor corrija los siguientes errores<br/><ul>";
						$.each(datos, function(key, val) {
							errores+="<li>"+val+"</li>";
							$("#formCulmPai #"+key+"_em_").text(val);                                                    
							$("#formCulmPai #"+key+"_em_").show();                                                
						});
						errores+="</ul>";
						$("#formCulmPai #formCulmPai_es_").html(errores);                                                    
						$("#formCulmPai #formCulmPai_es_").show(); 
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					Loading.hide();
					//0 para error en comunicación
					//200 error en lenguaje o motor de base de datos
					//500 Internal server error
					if(xhr.status==0){
						$("#MensajeCulm").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
					}
					else{
						if(xhr.status==500){
							$("#MensajeCulm").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
						}
						else{
							$("#MensajeCulm").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
						}	
					}	
				}
			});
		}		
',CClientScript::POS_END);?>

	<?php else:?>
		El PAI ya ha culminado
<?php endif; ?>
