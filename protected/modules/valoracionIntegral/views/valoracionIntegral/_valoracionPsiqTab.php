<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="divFormValPsiq">
<fieldset id="histPsiqAnt">
<?php 
$formHistPsiq=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioHistPsiq',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formHistPsiq->errorSummary($modeloValPsiq,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formHistPsiq->labelEx($modeloValPsiq,'hist_psiq_ant',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formHistPsiq->textArea($modeloValPsiq,
                'hist_psiq_ant',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioHistPsiq","histPsiqAnt")',
                    'onkeyup'=>'js:$("#histPsiqAnt").addClass("has-warning")'
                ));
            ?>
            <?php echo $formHistPsiq->error($modeloValPsiq,'hist_psiq_ant',array('style' => 'color:#F00'));?>
    	</div>
	</div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormHistPsiq','class'=>'btn btn-default btn-sdis','name'=>'btnFormHistPsiq','onclick'=>'js:enviaForm("formularioHistPsiq","histPsiqAnt")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
        </div>
	</div>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="examen">
<?php $formExaMent=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioExaMent',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formExaMent->errorSummary($modeloValPsiq,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formExaMent->labelEx($modeloValPsiq,'examen_mental',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formExaMent->textArea($modeloValPsiq,
                'examen_mental',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioExaMent","examen")',
                    'onkeyup'=>'js:$("#examen").addClass("has-warning")'
                ));
            ?>
            <?php echo $formExaMent->error($modeloValPsiq,'examen_mental',array('style' => 'color:#F00'));?>
   		</div>
	</div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormExaMent','class'=>'btn btn-default btn-sdis','name'=>'btnFormExaMent','onclick'=>'js:enviaForm("formularioExaMent","examen")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
        </div>
    </div>            
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="analisis">
<?php $formAnalisis=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioAnalisis',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formAnalisis->errorSummary($modeloValPsiq,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formAnalisis->labelEx($modeloValPsiq,'analisis_psiq',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formAnalisis->textArea($modeloValPsiq,
                'analisis_psiq',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioAnalisis","analisis")',
                    'onkeyup'=>'js:$("#analisis").addClass("has-warning")'
                ));
            ?>
            <?php echo $formAnalisis->error($modeloValPsiq,'analisis_psiq',array('style' => 'color:#F00'));?>
        </div>
	</div>      
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormAnalisis','class'=>'btn btn-default btn-sdis','name'=>'btnFormAnalisis','onclick'=>'js:enviaForm("formularioAnalisis","analisis")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="diagnostico">
<?php $formDiagnostico=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDiagnostico',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formDiagnostico->errorSummary($modeloValPsiq,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formDiagnostico->labelEx($modeloValPsiq,'diagnostico_psiq',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formDiagnostico->textArea($modeloValPsiq,
                'diagnostico_psiq',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioDiagnostico","diagnostico")',
                    'onkeyup'=>'js:$("#diagnostico").addClass("has-warning")'
                ));
            ?>
            <?php echo $formDiagnostico->error($modeloValPsiq,'diagnostico_psiq',array('style' => 'color:#F00'));?>
   		</div>
	</div>    
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormDiagnostico','class'=>'btn btn-default btn-sdis','name'=>'btnFormDiagnostico','onclick'=>'js:enviaForm("formularioDiagnostico","diagnostico")')
                );
            ?>
        <?php echo $boton; //CHtml::submitButton('Crear');?>
	    </div>        
    </div>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="recomendaciones">
<?php $formRecomendaciones=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioRecomendaciones',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formRecomendaciones->errorSummary($modeloValPsiq,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formRecomendaciones->labelEx($modeloValPsiq,'recomend_psic',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formRecomendaciones->textArea($modeloValPsiq,
                'recomend_psic',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioRecomendaciones","recomendaciones")',
                    'onkeyup'=>'js:$("#recomendaciones").addClass("has-warning")'
                ));
            ?>
            <?php echo $formDiagnostico->error($modeloValPsiq,'recomend_psic',array('style' => 'color:#F00'));?>
        </div>
	</div>  
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormRecom','class'=>'btn btn-default btn-sdis','name'=>'btnFormRecom','onclick'=>'js:enviaForm("formularioRecomendaciones","recomendaciones")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
        </div>
    </div>            
<?php $this->endWidget();?>
</fieldset>
<hr />
<?php
	echo CHtml::hiddenField('num_doc',$modeloValPsiq->num_doc);
	echo CHtml::hiddenField('id_val_psiquiatria',$modeloValPsiq->id_val_psiquiatria);
?>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptValPsiq','
	$(document).ready(function(){
		$("#divFormValPsiq").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
	});	
		function enviaForm(nombreForm,btnForm){
			$.ajax({
				url: "modificaValoracionPsiq",
				data:$("#"+nombreForm).serialize()+"&id_val_psiquiatria="+$("#id_val_psiquiatria").val()+"&num_doc="+$("#num_doc").val(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){						
						if(datos.resultado=="\'exito\'"){	
							$("#"+btnForm).removeClass("has-warning")						
							$("#Mensaje").text("exito");
							$("#"+nombreForm).removeClass("unsavedForm");
						}
						else{
							$("#Mensaje").text("Error en la creación del registro.  Motivo "+datos.resultado);
						}
					}
					else{
						$("#Mensaje").text("no exito");
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					Loading.hide();
					//0 para error en comunicación
					//200 error en lenguaje o motor de base de datos
					//500 Internal server error
					if(xhr.status==0){
						$("#Mensaje").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
					}
					else{
						if(xhr.status==500){
							$("#Mensaje").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
						}
						else{
							$("#Mensaje").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
						}	
					}	
				}
			});
		}
'
,CClientScript::POS_END);
?>

