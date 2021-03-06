<div id="Mensaje" style="font-size:14px;" ></div>
<?php $formularioCreaAreaInt=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioCreaAreaInt',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<fieldset>

<!-- Form Name -->
<div class="panel-heading color-sdis">Vincular área de interés/deportes</div><br />
	<?php echo  $formularioCreaAreaInt->errorSummary($modeloAreainscrCforjar,'','',array('style' => 'font-size:14px;color:#F00')); ?>

<!-- Text input-->
    <div class="form-group">
    	<label class="col-md-4 control-label">Área de Interés/Deportes</label>
        <div class="col-md-4">
            <?php echo $formularioCreaAreaInt->dropDownList($modeloAreainscrCforjar,'id_areainteres',CHtml::listData($areaIntSinVinc,'id_areainteres', 'area_interes'), 
            array(
                'multiple'=>'multiple',
				'title'=>"Seleccione uno o varios",
                'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true',
				//'onChange'=>'js:jAlert($("#AreainscrCforjar_id_areainteres").val(),"Mensaje")'
            )); ?>
            <?php echo $formularioCreaAreaInt->error($modeloAreainscrCforjar,'id_areainteres',array('style' => 'color:#F00')); ?>
        </div>
    </div>        

     <!-- Button (Double) -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
     
<?php	
	$modeloAreainscrCforjar->areacforjar_activa="true";
	$modeloAreainscrCforjar->id_forjar="aux";
    echo $formularioCreaAreaInt->hiddenField($modeloAreainscrCforjar,'areacforjar_activa');
    echo $formularioCreaAreaInt->hiddenField($modeloAreainscrCforjar,'id_forjar');
		$boton=CHtml::ajaxSubmitButton (
						'Vincular',   
						array('asistencia/vinculaArIntDep'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnCreaArInt").hide();Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="exito"){
										jAlert("Área de interés - deporte vinculado","Mensaje");
										$("#formularioCreaAreaInt #formularioCreaAreaInt_es_").html("");
										$("#formularioCreaAreaInt #AreaInscripcion_area_interes_em_").text("");    
										$("#formularioCreaAreaInt #AreainscrCforjar_id_forjar_em_").text("");    
										$("#formularioCreaAreaInt").removeClass("unsavedForm");
									}
									else{
										jAlert("No ha sido posible crear el área de interés","Mensaje");
									}
								}
								else{						
									$("#btnCreaArInt").show();
									var errores="Por favor tenga en cuenta lo siguiente<br/><ul>";
									$.each(datos, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioCreaAreaInt #"+key+"_em_").text(val);                                                    
										$("#formularioCreaAreaInt #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioCreaAreaInt #formularioCreaAreaInt_es_").html(errores);                                                    
									$("#formularioCreaAreaInt #formularioCreaAreaInt_es_").show(); 
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
						array('id'=>'btnCreaArInt','name'=>'btnCreaArInt','class'=>'btn btn-default btn-sdis')
				);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
   </div>
    </div>
    </fieldset>
<?php $this->endWidget();?>

<?php Yii::app()->getClientScript()->registerScript('validaForm','
$(document).ready(function(){
	$("form").find(":input").change(function(){
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
});'
,CClientScript::POS_END);

?>