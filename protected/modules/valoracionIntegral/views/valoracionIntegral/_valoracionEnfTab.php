<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="divFormValEnf">
<fieldset id="afSalud">
<div class="panel-heading color-sdis">Afiliación a salud</div> 
<?php $formSgsssAdol=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioSgsssAdol',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="vincPrevSrpaTable">
	<tr>
        <td style=" border:1px solid #000; width:25%"><label class="control-label">Regimen salud</label></td>
        <td style=" border:1px solid #000;width:25%"><label class="control-label">EPS</label></td>
	</tr>
    <tr>        
        <td style=" border:1px solid #000;width:25%">
            <div class="form-group">
                <div class="col-md-12">		
					<?php 
                        $opTipoRegSal[$modeloSgsss->id_regimen_salud]=array('selected'=>true);
                        echo $formSgsssAdol->dropDownList($modeloSgsss,'id_regimen_salud',CHtml::listData($regSalud,'id_regimen_salud','regimen_salud'),
                            array(
                                'prompt'=>"seleccione un régimen",
                                'options' => $opTipoRegSal,
                                'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true',
                                'onchange'=>'js:$("#afSalud").addClass("has-warning");$("#formularioSgsssAdol").addClass("unsavedForm");'
                            )
                        );
                        $opTipoRegSal="";
                    ?> 
                    <?php echo $formSgsssAdol->error($modeloSgsss,'id_regimen_salud',array('style' => 'color:#F00'));?>
                </div>
        	</div>
        </td>
        <td style=" border:1px solid #000;width:25%">
            <div class="form-group">
                <div class="col-md-12">		
					<?php 
                        $opTipoEps[$modeloSgsss->id_eps_adol]=array('selected'=>true);
                        echo $formSgsssAdol->dropDownList($modeloSgsss,'id_eps_adol',CHtml::listData($eps,'id_eps_adol','eps_adol'),
                            array(
                                'prompt'=>"seleccione eps",
                                'options' => $opTipoEps,
                                'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true',
                                'onchange'=>'js:$("#afSalud").addClass("has-warning");$("#formularioSgsssAdol").addClass("unsavedForm");'
                            )
                        );
                        $opTipoEps="";
                    ?> 
                    <?php echo $formSgsssAdol->error($modeloSgsss,'id_eps_adol',array('style' => 'color:#F00'));?>
                </div>
        	</div>
        </td>
	</tr>
    <tr>        
        <td style=" border:1px solid #000;width:25%" colspan="2">
 <?php
 		//$modeloSgsss->num_doc=$modeloValEnf->num_doc;
		if(!empty($sgs)){
			$accion="modificaSgsss";
		}
		else{
			$accion="registraSgsss";
		}
		echo $formSgsssAdol->hiddenField($modeloSgsss,'num_doc');
		$boton=CHtml::ajaxSubmitButton (
						'Crear Registro',   
						array('valoracionIntegral/'.$accion),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="\'exito\'"){
										$("#Mensaje").html("Registro realizado satisfactoriamente");	
										$("#formularioSgsssAdol").removeClass("unsavedForm");
										$("#afSalud").removeClass("has-warning")
									}
									else{
										$("#Mensaje").html("Ha habido un error en la creación del registro. Código del error: "+datos.resultado);
									}
								}
								else{						
									$("#btnFormSgsss").show();
									$.each(datos, function(key, val) {
										$("#formularioSgsssAdol #"+key+"_em_").text(val);                                                    
										$("#formularioSgsssAdol #"+key+"_em_").show();                                                
									});
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
						array('id'=>'btnFormSgsss','class'=>'btn btn-default btn-sdis','name'=>'btnFormSgsss')
				);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>        
        
        </td>
	</tr>
</table>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="antClFam">
<?php $formAntCl=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioAntCl',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formAntCl->errorSummary($modeloValEnf,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formAntCl->labelEx($modeloValEnf,'antecedentes_clinic',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formAntCl->textArea($modeloValEnf,
                'antecedentes_clinic',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioAntCl","antClFam")',
                    'onkeyup'=>'js:$("#antClFam").addClass("has-warning")'
                ));
            ?>
            <?php echo $formAntCl->error($modeloValEnf,'antecedentes_clinic',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormAntCl','class'=>'btn btn-default btn-sdis','name'=>'btnFormAntCl','onclick'=>'js:enviaForm("formularioAntCl","antClFam")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
		</div>
	</div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<hr />

<fieldset id="examFis">
<?php $formExFis=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioExFis',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formExFis->errorSummary($modeloValEnf,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formExFis->labelEx($modeloValEnf,'examen_fisico_fisiol',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formExFis->textArea($modeloValEnf,
                'examen_fisico_fisiol',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioExFis","examFis")',
                    'onkeyup'=>'js:$("#examFis").addClass("has-warning")'
                ));
            ?>
            <?php echo $formExFis->error($modeloValEnf,'examen_fisico_fisiol',array('style' => 'color:#F00'));?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormExFis','class'=>'btn btn-default btn-sdis','name'=>'btnFormExFis','onclick'=>'js:enviaForm("formularioExFis","examFis")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
		</div>
	</div>        
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="obsGenEnferm">
<?php $formObs=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioObs',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formObs->errorSummary($modeloValEnf,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formObs->labelEx($modeloValEnf,'obs_gen_enferm',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formObs->textArea($modeloValEnf,
                'obs_gen_enferm',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioObs","obsGenEnferm")',
                    'onkeyup'=>'js:$("#obsGenEnferm").addClass("has-warning")'
                ));
            ?>
            <?php echo $formObs->error($modeloValEnf,'obs_gen_enferm',array('style' => 'color:#F00'));?>
   		</div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
            $boton=CHtml::Button (
                'Registrar',   
                array('id'=>'btnFormObs','class'=>'btn btn-default btn-sdis','name'=>'btnFormObs','onclick'=>'js:enviaForm("formularioObs","obsGenEnferm")')
            );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="recSalud">
<?php $formRecom=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioRecom',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formRecom->errorSummary($modeloValEnf,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formRecom->labelEx($modeloValEnf,'recom_aten_salud',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formRecom->textArea($modeloValEnf,
                'recom_aten_salud',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioRecom","recSalud")',
                    'onkeyup'=>'js:$("#recSalud").addClass("has-warning")'
                ));
            ?>
            <?php echo $formRecom->error($modeloValEnf,'recom_aten_salud',array('style' => 'color:#F00'));?>
    	</div>
	</div>        
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormRecom','class'=>'btn btn-default btn-sdis','name'=>'btnFormRecom','onclick'=>'js:enviaForm("formularioRecom","recSalud")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<?php
	echo CHtml::hiddenField('num_doc',$modeloValEnf->num_doc);
	echo CHtml::hiddenField('id_valor_enf',$modeloValEnf->id_valor_enf);
?>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptValEnf','
	$(document).ready(function(){
		$("#divFormValEnf").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
	});	
		function enviaForm(nombreForm,btnForm){
			if($("#"+nombreForm+" textarea:first").val().length==0){
				jAlert("El campo no puede estar vacío");
				 $("#"+nombreForm).removeClass("unsavedForm");								
				return;	
			}
			$.ajax({
				url: "modificaValoracionEnf",
				data:$("#"+nombreForm).serialize()+"&id_valor_enf="+$("#id_valor_enf").val()+"&num_doc="+$("#num_doc").val(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){						
						if(datos.resultado=="\'exito\'"){							
							$("#Mensaje").text("exito");
							$("#"+nombreForm).removeClass("unsavedForm");
							$("#"+btnForm).removeClass("has-warning")
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
