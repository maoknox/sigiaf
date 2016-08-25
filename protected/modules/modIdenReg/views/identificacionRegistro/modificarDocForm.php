<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<fieldset>
<legend>Modificar documento del adolescente</legend>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/modificarDocForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>


<?php if(!empty($numDocAdol)):?>

<div id="Mensaje" style="font-size:14px;" ></div>
<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioAdolMod',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
	<?php echo  $form->errorSummary($formAdol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="form-group">
	<?php echo $form->labelEx($formAdol,'id_doc_adol',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
	    <div class="col-md-4">
			<?php echo $form->textField($formAdol,'id_doc_adol',array('prompt'=>'Seleccione Tipo documento','class'=>'form-control'));?>
            <?php echo $form->error($formAdol,'id_doc_adol',array('style' => 'color:#F00'));?>
		</div>
    </div>

    <?php
		$boton=CHtml::ajaxSubmitButton (
						'Modificar',   
						array('identificacionRegistro/modifDocAdol'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){/*$("#btnFormAdolId").hide();*/Loading.show();
									$("#formularioAdolMod .errorMessage").text("");                                                    
									$("#formularioAdolMod .errorMessage").hide();
									$("#formularioAdolMod #formularioAdolMod_es_").html("");                                                    
									$("#formularioAdolMod #formularioAdolMod_es_").hide();		
							}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="\'exito\'"){
										jAlert("Los datos se han modificado satisfactoriamente","Mensaje");	
										$("#formularioAdolMod #formularioAdolMod_es_").html("");                                                    
										$("#formularioAdolMod #formularioAdolMod_es_").hide();
										$("#formularioAdolMod .errorMessage").text("");                                                    
										$("#formularioAdolMod .errorMessage").hide();
										$("#formularioAdolMod").removeClass("unsavedForm");
									}
									else{
										$("#Mensaje").html("Ha habido un error en la creación del registro. Código del error: "+datos.msnError);
										$("#formularioAdolMod #formularioAdolMod_es_").html("");                                                    
										$("#formularioAdolMod #formularioAdolMod_es_").hide(); 	
									}
								}
								else{						
									$("#btnFormAdolId").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datos, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioAdolMod #"+key+"_em_").text(val);                                                    
										$("#formularioAdolMod #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioAdolMod #formularioAdolMod_es_").html(errores);                                                    
									$("#formularioAdolMod #formularioAdolMod_es_").show(); 
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
						array('id'=>'btnFormAdolId','name'=>'btnCreaAdolN','class'=>'btn btn-default btn-sdis')
				);
    ?>
	<?php echo CHtml::hiddenField('Adolescente[num_doc]',$formAdol->num_doc,array('id'=>'Adolescente_num_doc'));?>
	<?php $formAdol->escIngEgrs=0; echo CHtml::hiddenField('Adolescente[escIngEgrs]',$formAdol->escIngEgrs,array('id'=>'Adolescente_escIngEgrs'));?>
	<?php echo CHtml::hiddenField('Adolescente[id_sexo]',$formAdol->id_sexo,array('id'=>'Adolescente_id_sexo'));?>
	<?php echo CHtml::hiddenField('Adolescente[id_tipo_doc]',$formAdol->id_tipo_doc,array('id'=>'Adolescente_id_tipo_doc'));?>
	<?php echo CHtml::hiddenField('Adolescente[id_municipio]',$formAdol->id_municipio,array('id'=>'Adolescente_id_municipio'));?>
	<?php echo CHtml::hiddenField('Adolescente[apellido_1]',$formAdol->apellido_1,array('id'=>'Adolescente_apellido_1'));?>
	<?php echo CHtml::hiddenField('Adolescente[nombres]',$formAdol->nombres,array('id'=>'Adolescente_nombres'));?>
	<?php echo CHtml::hiddenField('Adolescente[fecha_nacimiento]',$formAdol->fecha_nacimiento,array('id'=>'Adolescente_fecha_nacimiento'));?>
    	    <div class="form-group">
            <label class="col-md-4 control-label"></label>
            	<div class="col-md-4"><?php echo $boton; //CHtml::submitButton('Crear');?></div>
            </div>
<?php $this->endWidget();?>
<?php //script de seguridad que previene dejar la página si no se han guardado los datos
/*Yii::app()->getClientScript()->registerScript('dejaVentana','
	
		$(window).bind("beforeunload", function(){
			//return "Va a dejar la página"
		});
	'
,CClientScript::POS_END);*/ 
?>
<?php Yii::app()->getClientScript()->registerScript('scriptRegistraDatos','
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

<?php endif;?>
</fieldset>
