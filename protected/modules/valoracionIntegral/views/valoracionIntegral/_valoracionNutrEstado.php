<div id="divFormEstValPsicol">
<fieldset id="estadoVal">
<?php $formEstVal=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioEstVal',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<!--campo de texto para nombres del adolescente -->	
<div class="form-group">
    <div class="col-md-12">	
	<label class="control-label" for="radios">Estado de la valoración</label>
    <div class="radio">
    <?php 
		$selOpt=false;
		foreach($estadoCompVal as $estadoCompVal){//revisar
			if($modeloValNutr->id_estado_val==$estadoCompVal["id_estado_val"]){$selOpt=true;}
			echo CHtml::radioButton('ValoracionNutricional[id_estado_val]',$selOpt,array('value'=>$estadoCompVal["id_estado_val"],'id'=>'estValPsic'.$estadoCompVal["id_estado_val"],
			'onclick'=>'js:$("#estadoVal").addClass("has-warning");validaDilValoracion("formularioEstVal","estadoVal")'))."".$estadoCompVal["estado_val"]."<br/>";
			$selOpt=false;
		}
	?></div>
    </div>
    </div>
    <div class="form-group">
    	<div class="col-md-12">
    <?php echo $formEstVal->textArea($modeloValNutr,
		'observ_estvalnutr',
		array('class'=>'form-control',
		'onblur'=>'js:validaDilValoracion("formularioEstVal","estadoVal")',
		'onkeyup'=>'js:$("#estadoVal").addClass("has-warning");'));
	?>    
	<?php echo $formEstVal->error($modeloValNutr,'observ_estvalnutr',array('style' => 'color:#F00'));?>
</div>
    </div>
   	<div class="form-group">
        <div class="col-md-4">	
<?php
$boton=CHtml::Button (
			'Registrar',   
			array('id'=>'btnFormEstVal','class'=>'btn btn-default btn-sdis','name'=>'btnFormEstVal','onclick'=>'js:validaDilValoracion("formularioEstVal","estadoVal")')
	);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
    </div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
</div>

<?php

Yii::app()->getClientScript()->registerScript('scripVapsic_estValNutr','
	function validaDilValoracion(nombreForm,btnForm){//coment: función ajax que llamará al modelo de valoración en psicología para corroborar el diligenciamiento de las valoraciones.
		$("#formularioEstVal #ValoracionNutricional_observ_estvalpsicol_em_").text("");
		var valueEst=$("#formularioEstVal input[type=\'radio\']:checked").val();
		if(valueEst==3 && $("#formularioEstVal #ValoracionNutricional_observ_estvalnutr").val().length<=15){
			$("#formularioEstVal #ValoracionNutricional_observ_estvalpsicol_em_").text("Debe justificar por qué no fue realizada la valoración");
			$("#formularioEstVal #ValoracionNutricional_observ_estvalpsicol_em_").show();
			return;
		}
		$.ajax({
			url: "validaDilValoracionNutr",	
			data:"idValNutr="+$("#idValNutr").val(),
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				if(datos.estadoComu=="exito"){
					if(datos.resultado=="false" && valueEst==1){
						$("#"+nombreForm).removeClass("unsavedForm");
						$("#"+btnForm).removeClass("has-warning");
						$("#formularioEstVal input[type=\'radio\']:checked").attr("checked",false);
						var camposInvalidos="";
						$.each(datos.camposVacios, function(key, val) {
							camposInvalidos=camposInvalidos+"-"+val+"\n";
						});
						jAlert("Hay campos que no cumplen con el criterio para designar como completa esta valoración. \n Revise que los campos de texto o textArea tengan una redacción mayor a '.Yii::app()->params['num_caracteres'].' carácteres. \n Los campos son los siguientes \n "+camposInvalidos,"Mensaje");
					}
					else{
						enviaFormNutrGrupo(nombreForm,btnForm);
					}
				}
				else{
					jAlert(datos,"Mensaje")
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema","Mensaje");
				}
				else{
					if(xhr.status==500){
						jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información","Mensaje");
					}
					else{
						jAlert("No se ha creado el registro al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado","Mensaje");
					}	
				}	
			}
		});		
	}
	$(document).ready(function(){
	$("#divFormEstValPsicol").find(":input").change(function(){
  var dirtyForm = $(this).parents("form");
  // change form status to dirty
  dirtyForm.addClass("unsavedForm");
});});	',CClientScript::POS_END);
?>
