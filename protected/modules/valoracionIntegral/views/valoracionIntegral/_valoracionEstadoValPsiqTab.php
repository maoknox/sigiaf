<div id="divFormEsTadoValPsiq">
<fieldset id="estValPsiq">
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
                foreach($estadoCompVal as $estadoCompVal){
                    if($modeloValPsiq->id_estado_val==$estadoCompVal["id_estado_val"]){$selOpt=true;}
                    echo CHtml::radioButton('ValoracionPsiquiatria[id_estado_val]',$selOpt,array(
                        'id'=>'ValoracionPsiquiatria_id_estado_val_'.$estadoCompVal["id_estado_val"],
                        'value'=>$estadoCompVal["id_estado_val"],
                        'onclick'=>'js:$("#estValPsiq").addClass("has-warning");validaDilValoracion("formularioEstVal","estValPsiq")'
                        ))."".$estadoCompVal["estado_val"]."<br/>";
                    $selOpt=false;
                }
            ?>
        </div>
    </div>
</div>
<div class="form-group">
        <div class="col-md-12">
        <?php echo $formEstVal->textArea($modeloValPsiq,
            'observ_estvalpsiq',
            array('class'=>'form-control',
            'onblur'=>'js:validaDilValoracion("formularioEstVal","estValPsiq")',
            'onkeyup'=>'js:$("#estValPsiq").addClass("has-warning");'));
        ?>    
        <?php echo $formEstVal->error($modeloValPsiq,'observ_estvalpsiq',array('style' => 'color:#F00'));?>
    </div>
</div>
<div class="form-group">
    <div class="col-md-4">	
		<?php
            $boton=CHtml::Button (
				'Registrar',   
				array('id'=>'btnFormEstVal','class'=>'btn btn-default btn-sdis','name'=>'btnFormEstVal','onclick'=>'js:enviaFormOpt("formularioEstVal","estValPsiq")')
            );
        ?>
		<?php echo $boton; //CHtml::submitButton('Crear');?>
    </div>
</div>
<?php $this->endWidget();?>
</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scripEstValPsiq','
$(document).ready(function(){
	$("#divFormEsTadoValPsiq").find(":input").change(function(){
		var dirtyForm = $(this).parents("form");
		// change form status to dirty
		dirtyForm.addClass("unsavedForm");
	});
});
function validaDilValoracion(nombreForm,btnForm){//coment: función ajax que llamará al modelo de valoración en psicología para corroborar el diligenciamiento de las valoraciones.
	var valueEst=$("#formularioEstVal input[type=\'radio\']:checked").val();
	$.ajax({
		url: "validaDilValoracionPsiq",			
		data:"id_val_psiquiatria="+$("#id_val_psiquiatria").val(),
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
					jAlert("Hay campos que no cumplen con el criterio para designar como completa esta valoración. Revise que los campos tengan una redacción mayor a '.Yii::app()->params['num_caracteres'].' carácteres.","Mensaje");
				}
				else{
					enviaFormOpt(nombreForm,btnForm);
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
					jAlert("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado","Mensaje");
				}	
			}	
		}
	});		
}


function enviaFormOpt(nombreForm,btnForm){
	$.ajax({
		url: "modificaValoracionPsiqOpt",
		data:$("#"+nombreForm).serialize()+"&id_val_psiquiatria="+$("#id_val_psiquiatria").val()+"&num_doc="+$("#num_doc").val(),
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
