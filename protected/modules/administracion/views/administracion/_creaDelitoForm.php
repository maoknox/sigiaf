<div id="Mensaje" style="font-size:14px;" ></div>
<?php $formularioCreaDelito=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioCreaDelito',
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
<div class="panel-heading color-sdis">Crear Delito</div><br />
	<?php echo  $formularioCreaDelito->errorSummary($modeloDelitoRemCespa,'','',array('style' => 'font-size:14px;color:#F00')); ?>

<!-- Text input-->
    <div class="form-group">
		<?php echo $formularioCreaDelito->labelEx($modeloDelitoRemCespa,'del_remcespa',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formularioCreaDelito->textField($modeloDelitoRemCespa,'del_remcespa',array('class'=>'form-control input-md'));?>
            <?php echo $formularioCreaDelito->error($modeloDelitoRemCespa,'del_remcespa',array('style' => 'color:#F00'));?>     
    	</div>
     </div>
     <!-- Button (Double) -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
     
<?php	

		$boton=CHtml::ajaxSubmitButton (
						'Crear delito',   
						array('administracion/creaDelito'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnCrear").hide();Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="exito"){
										$("#formularioCreaDelito").removeClass("unsavedForm");
										jAlert("Registro creado","Mensaje");
									}
									else{
										jAlert("No ha sido posible crear el delito","Mensaje");
									}
								}
								else{						
									$("#btnCrear").show();
									var errores="Por favor tenga en cuenta lo siguiente<br/><ul>";
									$.each(datos, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioCreaDelito #"+key+"_em_").text(val);                                                    
										$("#formularioCreaDelito #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioCreaDelito #formularioCreaDelito_es_").html(errores);                                                    
									$("#formularioCreaDelito #formularioCreaDelito_es_").show(); 
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
						array('id'=>'btnCrear','name'=>'btnCrear','class'=>'btn btn-default btn-sdis')
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