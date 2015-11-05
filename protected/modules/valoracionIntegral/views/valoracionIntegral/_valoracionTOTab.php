<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<?php
//print_r($tipoTrabajador);
//print_r($sectorLaboral);

?>
<div id="divFormTO">
<fieldset id="desempAreaOcup">
<?php $formDesArOc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDesArOc',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formDesArOc->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
			<?php echo $formDesArOc->labelEx($modeloValTO,'desemp_area_ocup',array('class'=>'control-label','for'=>'searchinput'));?>
     		<code data-toggle="tooltip" title='Actividades de la vida diaria (personales e instrumentales), educación, trabajo, ocio y participación social. Se debe evaluar cómo es el desempeño en las actividades básicas o personales de la vida diaria (alimentación, higiene, vestido, sueño/descanso, actividad sexual), actividades instrumentales de la vida diaria (cuidado de otros, movilidad en la comunidad, manejo de dinero, cuidado de la salud), educación (participación en educación formal e informal), trabajo (desempeño / participación en actividades productivas), juego/ocio (exploración y participación) y participación social (desempeño de actividades para la interacción con pares, familia y comunidad).'>Ayuda</code>       
            <?php echo $formDesArOc->textArea($modeloValTO,
                'desemp_area_ocup',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioDesArOc","desempAreaOcup")',
                    'onkeyup'=>'js:$("#desempAreaOcup").addClass("has-warning")'
                ));
            ?>
            <?php echo $formDesArOc->error($modeloValTO,'desemp_area_ocup',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormDesArOc','class'=>'btn btn-default btn-sdis','name'=>'btnFormDesArOc','onclick'=>'js:enviaForm("formularioDesArOc","desempAreaOcup")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
        </div>
 	</div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="desempLaboral">
<label class="control-label">Desempeño Laboral</label>
<?php $formDesLab=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDesLab',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formDesLab->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">   
    	<div class="col-md-4">
			<?php echo $formDesLab->labelEx($modeloValTO,'id_tipo_trab',array('class'=>'control-label','for'=>'searchinput'));?><br />
			<?php 
                $selOpt=false;
                foreach($tipoTrabajador as $tipoTrabajadorVal){
                    if($modeloValTO->id_tipo_trab==$tipoTrabajadorVal["id_tipo_trab"]){$selOpt=true;}
                    echo CHtml::radioButton('ValoracionTeo[id_tipo_trab]',$selOpt,
                        array(
                            'value'=>$tipoTrabajadorVal["id_tipo_trab"],
                            'id'=>'ValoracionTeo_id_tipo_trab_'.$tipoTrabajadorVal["id_tipo_trab"],
                            'onclick'=>'js:$("#desempLaboral").addClass("has-warning");enviaFormOpt("formularioDesLab","desempLaboral");'))."".$tipoTrabajadorVal["tipo_trab"]."<br/>";
                    $selOpt=false;
                }
            ?>
            <?php echo $formDesLab->error($modeloValTO,'id_tipo_trab',array('style' => 'color:#F00'));?>
    	</div>    
        <div class="col-md-4">
			<?php echo $formDesLab->labelEx($modeloValTO,'id_sector_lab',array('class'=>'control-label','for'=>'searchinput'));?><br />
			<?php 
                $selOpt=false;
                foreach($sectorLaboral as $sectorLaboralVal){
                    if($modeloValTO->id_sector_lab==$sectorLaboralVal["id_sector_lab"]){$selOpt=true;}
                    echo CHtml::radioButton('ValoracionTeo[id_sector_lab]',$selOpt,
                        array(
                            'value'=>$sectorLaboralVal["id_sector_lab"],
                            'id'=>'ValoracionTeo_id_sector_lab_'.$sectorLaboralVal["id_sector_lab"],
                            'onclick'=>'js:$("#desempLaboral").addClass("has-warning");enviaFormOpt("formularioDesLab","desempLaboral");'))."".$sectorLaboralVal["sector_lab"]."<br/>";
                    $selOpt=false;
                }
            ?>
            <?php echo $formDesLab->error($modeloValTO,'id_sector_lab',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormDesLab','class'=>'btn btn-default btn-sdis','name'=>'btnFormDesLab','onclick'=>'js:enviaFormOpt("formularioDesLab","desempLaboral")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
        </div>
   </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="desempLaboralTxt">
<?php $formularioDesLabTxt=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDesLabTxt',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formularioDesLabTxt->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
			<?php echo $formularioDesLabTxt->labelEx($modeloValTO,'desemp_laboral',array('class'=>'control-label','for'=>'searchinput'));?> - Observaciones
			<?php echo $formularioDesLabTxt->textArea($modeloValTO,
                'desemp_laboral',
                array('style'=>'width:99.5%;',
                    'onblur'=>'js:enviaForm("formularioDesLabTxt","desempLaboralTxt")',
                    'onkeyup'=>'js:$("#desempLaboralTxt").addClass("has-warning")'
                ));
            ?>
            <?php echo $formularioDesLabTxt->error($modeloValTO,'desemp_laboral',array('style' => 'color:#F00'));?>
        </div>    
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormDesemLabTxt','class'=>'btn btn-default btn-sdis','name'=>'btnFormDesemLabTxt','onclick'=>'js:enviaForm("formularioDesLabTxt","desempLaboralTxt")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="patronDesemp">
<?php $formPatDes=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioPatDes',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formPatDes->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
			<?php echo $formPatDes->labelEx($modeloValTO,'patron_desemp',array('class'=>'control-label','for'=>'searchinput'));?>
     		<code data-toggle="tooltip" title='Explorar tipo de hábitos (útiles o funcionales, improvisados - en proceso de introyección-, dominantes - que interfieren en el desempeño-. Se indagan los roles ocupacionales ejecutados y observaciones significativas respecto a su ejercicio (conflictos, confusión+C189 de roles).'>Ayuda</code>       
			<?php echo $formPatDes->textArea($modeloValTO,
                'patron_desemp',
                array('style'=>'width:99.5%;',
                    'onblur'=>'js:enviaForm("formularioPatDes","patronDesemp")',
                    'onkeyup'=>'js:$("#patronDesemp").addClass("has-warning")'
                ));
            ?>
            <?php echo $formPatDes->error($modeloValTO,'patron_desemp',array('style' => 'color:#F00'));?>
        </div>    
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormPatDes','class'=>'btn btn-default btn-sdis','name'=>'btnFormPatDes','onclick'=>'js:enviaForm("formularioPatDes","patronDesemp")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="interesExpectOcup">
<?php $formIntExp=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioIntExp',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formIntExp->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
			<?php echo $formIntExp->labelEx($modeloValTO,'interes_expect_ocup',array('class'=>'control-label','for'=>'searchinput'));?>
     		<code data-toggle="tooltip" title='Se debe indagar por las actividades de interés, es decir que sean significativas o vinculantes para el adolescente, el patrón o tipo de intereses. Se exploran las expectativas ocupacionales que pueden proyectarse como objetivos y metas ocupacionales. Se pueden incluir acciones adelantadas para el logro de éstos.'>Ayuda</code>       
			<?php echo $formIntExp->textArea($modeloValTO,
                'interes_expect_ocup',
                array('style'=>'width:99.5%;',
                    'onblur'=>'js:enviaForm("formularioIntExp","interesExpectOcup")',
                    'onkeyup'=>'js:$("#interesExpectOcup").addClass("has-warning")'
                ));
            ?>
            <?php echo $formIntExp->error($modeloValTO,'interes_expect_ocup',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormIntExp','class'=>'btn btn-default btn-sdis','name'=>'btnFormIntExp','onclick'=>'js:enviaForm("formularioIntExp","interesExpectOcup")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
		</div>
    </div>        
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="aptitHabilidDestrezas">
<?php $formApHabDes=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioApHabDes',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formApHabDes->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
			<?php echo $formApHabDes->labelEx($modeloValTO,'aptit_habilid_destrezas',array('class'=>'control-label','for'=>'searchinput'));?>
     		<code data-toggle="tooltip" title='Se puede explorar la identificación de habilidades, aptitudes, talentos mediante entrevista. No obstante, mediante la observación del desempeño del adolescente en la participación en diversas actividades o muestras de actividad, se pueden identificar dichas habilidades. Se puede analizar el desempeño en habilidades motoras, de procesamiento e interacción /comunicación.'>Ayuda</code>       
			<?php echo $formApHabDes->textArea($modeloValTO,
                'aptit_habilid_destrezas',
                array('style'=>'width:99.5%;',
                    'onblur'=>'js:enviaForm("formularioApHabDes","aptitHabilidDestrezas")',
                    'onkeyup'=>'js:$("#aptitHabilidDestrezas").addClass("has-warning")'
                ));
            ?>
            <?php echo $formApHabDes->error($modeloValTO,'aptit_habilid_destrezas',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormApHabDes','class'=>'btn btn-default btn-sdis','name'=>'btnFormApHabDes','onclick'=>'js:enviaForm("formularioApHabDes","aptitHabilidDestrezas")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
   		</div>
    </div>            
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="criteriosAreaInt">
<?php $formUbArInt=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioUbArInt',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formUbArInt->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
			<?php echo $formUbArInt->labelEx($modeloValTO,'criterios_area_int',array('class'=>'control-label','for'=>'searchinput'));?>
     		<code data-toggle="tooltip" title='A partir de los aspectos explorados anteriormente, se establece el área de formación a la que podría vincularse el adolescente, argumentando criterios mínimos que sustenten dicha decisión.'>Ayuda</code>       
			<?php echo $formUbArInt->textArea($modeloValTO,
                'criterios_area_int',
                array('style'=>'width:99.5%;',
                    'onblur'=>'js:enviaForm("formularioUbArInt","criteriosAreaInt")',
                    'onkeyup'=>'js:$("#criteriosAreaInt").addClass("has-warning")'
                ));
            ?>
            <?php echo $formUbArInt->error($modeloValTO,'criterios_area_int',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormUbArInt','class'=>'btn btn-default btn-sdis','name'=>'btnFormUbArInt','onclick'=>'js:enviaForm("formularioUbArInt","criteriosAreaInt")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
        </div>
    </div>            
<?php $this->endWidget();?>
<hr />
</fieldset>
<?php
	echo CHtml::hiddenField('num_doc',$modeloValTO->num_doc);
	echo CHtml::hiddenField('id_valor_teo',$modeloValTO->id_valor_teo);
?>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptValTO','
	$(document).ready(function(){
		$("#divFormTO").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
	});	
		function enviaForm(nombreForm,btnForm){
			$.ajax({
				url: "modificaValoracionTO",
				data:$("#"+nombreForm).serialize()+"&id_valor_teo="+$("#id_valor_teo").val()+"&num_doc="+$("#num_doc").val(),
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
		$( document ).ready(function() {		
			$("[data-toggle=\"tooltip\"]").tooltip();
		});
	function enviaFormOpt(nombreForm,btnForm){
	$.ajax({
		url: "modificaValoracionTOOpt",
		data:$("#"+nombreForm).serialize()+"&id_valor_teo="+$("#id_valor_teo").val()+"&num_doc="+$("#num_doc").val(),
		dataType:"json",
		type: "post",
		beforeSend:function (){Loading.show();},
		success: function(datos){
			Loading.hide();
			if(datos.estadoComu=="exito"){
				
				if(datos.resultado=="\'exito\'"){
					$("#"+nombreForm).removeClass("unsavedForm");
					$("#"+btnForm).removeClass("has-warning");
					$("#Mensaje").text("exito");
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