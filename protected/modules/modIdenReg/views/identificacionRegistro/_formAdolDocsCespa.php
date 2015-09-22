<div id="MensajeDocAdol" style="font-size:14px;"></div>
<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>
<?php $formAdolDoc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDocCespa',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
    <?php 
		$docsCespas=$modeloDocCespa->model()->findAll();
		print_r($docsCespas->id_doccespa);
	?>
    <?php echo  $formAdolDoc->errorSummary($modeloDocCespa,'','',array('style' => 'font-size:14px;color:#F00')); ?>
    <div class="form-group">                                       
    	<?php echo $formAdolDoc->labelEx($modeloDocCespa,'id_doccespa',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
			<?php echo $formAdolDoc->checkBoxList($modeloDocCespa, 'id_doccespa', CHtml::listData($modeloDocCespa->model()->findAllBySql('select * from documento_cespa order by id_doccespa asc'), 'id_doccespa', 'doccespa'));?>
            <?php echo $formAdolDoc->error($modeloDocCespa,'id_doccespa',array('style' => 'color:#F00')); ?>
    	</div>
    </div>
        <hr />
        <div class="row">
		<?php 
			if(!empty($numDocAdol)){
				$modeloDocCespa->numDocAdol=$numDocAdol;
			}
			echo $formAdolDoc->labelEx($modeloDocCespa,'numDocAdol');?>
		<?php echo CHtml::label($numDocAdol,'numDocLbl',array('id'=>'numDocLblDocC'));?>
        <?php echo $formAdolDoc->hiddenField($modeloDocCespa,'numDocAdol');?>
        <?php echo $formAdolDoc->error($modeloDocCespa,'numDocAdol',array('style' => 'color:#F00'));?>
        </div>

    <?php
		$boton=CHtml::ajaxSubmitButton (
						'Crear Registro',   
						array('identificacionRegistro/creaRegDocCespa'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){Loading.show();$("#btnFormDocAdol").hide();}',
							'success' => 'function(datosDocAdol) {
								Loading.hide();		
								if(datosDocAdol.estadoComu=="exito"){
									if(datosDocAdol.resultado=="exito"){
										$("#MensajeDocAdol").html("Los datos se han enviado satisfactoriamente<br/>");	
										$("#formularioDocCespa #formularioDocCespa_es_").html("");                                                    
										$("#formularioDocCespa #fformularioDocCespa_es_").hide();
										$("#formularioDocCespa").find("input, textarea, button, select").attr("disabled",true);
										$("#formularioDocCespa").removeClass("unsavedForm");
									}
									else{
										$("#MensajeDocAdol").html("Ha habido un error en la creación del registro. Código del error: "+datosDocAdol.msnError.errorInfo);
										$("#formularioDocCespa #formLocalizacion_es_").html("");                                                    
										$("#formularioDocCespa #fformLocalizacion_es_").hide(); 	
									}
								}
								else{						
									$("#btnFormDocAdol").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datosDocAdol, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioDocCespa #"+key+"_em_").text(val);                                                    
										$("#formularioDocCespa #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioDocCespa #formularioDocCespa_es_").html(errores);                                                    
									$("#formularioDocCespa #formularioDocCespa_es_").show();
								}									
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#MensajeDocAdol").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormDocAdol").show();
								}
								else{
									if(xhr.status==500){
										$("#MensajeDocAdol").html("Hay un error con el Sistema de información. Comuníquese con el área encargada");
									}
									else{
										$("#MensajeDocAdol").html("No se ha creado el registro de documentos remitidos debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
							}'
						),
						array('id'=>'btnFormDocAdol','name'=>'btnFormDocAdol','class'=>'btn btn-default btn-sdis')
				);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
<?php $this->endWidget();?>
<?php //script de seguridad que previene dejar la página si no se han guardado los datos
Yii::app()->getClientScript()->registerScript('prepFormDocAdol','
		var numDocAdol="";
		numDocAdol="'.$numDocAdol.'";
		if(numDocAdol==""){
			$("#btnFormDocAdol").hide();
			$("#formularioDocCespa").find("input, textarea, button, select").attr("disabled",true);
		}
	'
,CClientScript::POS_END);
 ?>