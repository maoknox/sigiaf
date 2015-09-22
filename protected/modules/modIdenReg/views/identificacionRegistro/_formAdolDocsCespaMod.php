<div id="MensajeDocAdol" style="font-size:14px;"></div>
<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>
<?php $formAdolDoc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDocCespa',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
	<!--campo de texto para nombres del adolescente -->	
    <?php echo  $formAdolDoc->errorSummary($modeloDocCespa,'','',array('style' => 'font-size:14px;color:#F00')); ?>
		<div class="row">
        <?php
		/*$reisgos=$modeloVerifDerechos->consultaProteccion($derecho["id_derecho_adol"]);*/
		foreach($docsCespa as $pk=>$docsCespaAdol){
			if($docsCespaAdol["doc_presentado"]=='t'){
				$preSelectedCategories[]='DocumentoCespa_id_doccespa_'.$pk;
				$op[$docsCespaAdol["id_doccespa"]]=array('selected'=>true);
			}
		}
		?>
            <?php echo $formAdolDoc->labelEx($modeloDocCespa,'id_doccespa'); ?><br />
			<?php 
				foreach($docsCespa as $pk=>$docsCespaAdol){
					if($docsCespaAdol["doc_presentado"]=='t'):?>
                    <input type="checkbox" name="DocumentoCespa[id_doccespa][]" value="<?php echo $docsCespaAdol["id_doccespa"]?>" id="DocumentoCespa_id_doccespa_<?php echo $pk;?>" checked="checked">
					<?php else:?>
                    	<input type="checkbox" name="DocumentoCespa[id_doccespa][]" value="<?php echo $docsCespaAdol["id_doccespa"]?>" id="DocumentoCespa_id_doccespa_<?php echo $pk;?>">
                    <?php endif;?>
                <label for="DocumentoCespa_id_doccespa_<?php echo $pk;?>"><?php echo $docsCespaAdol["doccespa"];?></label><br />
				<?php }?>
            <?php echo $formAdolDoc->error($modeloDocCespa,'id_doccespa',array('style' => 'color:#F00')); ?>
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
						'Modificar',   
						array('identificacionRegistro/modDocCespa'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){Loading.show();}',
							'success' => 'function(datosDocAdol) {
								Loading.hide();		
								if(datosDocAdol.estadoComu=="exito"){
									if(datosDocAdol.resultado=="\'exito\'"){
										$("#MensajeDocAdol").html("Los datos se han enviado satisfactoriamente<br/>");	
										$("#formularioDocCespa #formularioDocCespa_es_").html("");                                                    
										$("#formularioDocCespa #formularioDocCespa_es_").hide();
										$("#formularioDocCespa").removeClass("unsavedForm");
									}
									else{
										$("#MensajeDocAdol").html("Ha habido un error en la creación del registro. Código del error: "+datosDocAdol.msnError.errorInfo);
										$("#formularioDocCespa #formLocalizacion_es_").html("");                                                    
										$("#formularioDocCespa #formLocalizacion_es_").hide(); 	
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
						array('id'=>'btnFormDocAdol','name'=>'btnFormDocAdol')
				);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
<?php $this->endWidget();?>
<?php //script de seguridad que previene dejar la página si no se han guardado los datos
/*Yii::app()->getClientScript()->registerScript('prepFormDocAdol','
	'
,CClientScript::POS_END);
*/ ?>