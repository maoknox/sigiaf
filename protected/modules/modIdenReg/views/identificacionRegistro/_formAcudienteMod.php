<div id="MensajeFam" style="font-size:14px;"></div>
<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>
<?php 
	if(!empty($telefonoAcud)){
		foreach($telefonoAcud as $telefono){
			if($telefono["id_tipo_telefono"]==1){
				$modeloTelefono->telefono=$telefono["telefono"];
			}
			elseif($telefono["id_tipo_telefono"]==2){
				$modeloTelefono->tel_sec=$telefono["telefono"];
			}
			else{
				$modeloTelefono->celular=$telefono["telefono"];
			}
		}	
	}
?>
<?php $formAcudiente=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioAcudiente',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>

	<!--campo de texto para nombres del adolescente -->	
    <?php echo  $formAcudiente->errorSummary($modeloAcudiente,'','',array('style' => 'font-size:14px;color:#F00')); ?>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloAcudiente,'nombres_familiar',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloAcudiente,'nombres_familiar',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloAcudiente,'nombres_familiar',array('style' => 'color:#F00'));?>
		</div>
    </div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloAcudiente,'apellidos_familiar',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloAcudiente,'apellidos_familiar',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloAcudiente,'apellidos_familiar',array('style' => 'color:#F00'));?>
        </div>    
    </div>    
    <div class="form-group">                                       
    <?php echo $formAcudiente->labelEx($modeloAcudiente,'id_tipo_doc',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
			<?php echo $formAcudiente->dropDownList($modeloAcudiente,'id_tipo_doc',CHtml::listData($tipoDocBd,'id_tipo_doc', 'tipo_doc'), array('prompt'=>'Seleccione Tipo documento','class'=>'form-control input-md')); ?>
            <?php echo $formAcudiente->error($modeloAcudiente,'id_tipo_doc',array('style' => 'color:#F00')); ?>
        </div>
	</div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloAcudiente,'num_doc_fam',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloAcudiente,'num_doc_fam',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloAcudiente,'num_doc_fam',array('style' => 'color:#F00'));?>
        </div>
    </div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloAcudiente,'id_parentesco',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->dropDownList(
                $modeloAcudiente,
                'id_parentesco',
                CHtml::listData($parentesco,'id_parentesco', 'parentesco'), 
                array('prompt'=>'Seleccione parentesco','class'=>'form-control input-md')); 
            ?>
            <?php echo $formAcudiente->error($modeloAcudiente,'id_parentesco',array('style' => 'color:#F00'));?>
        </div>
    </div> 
    <div class="form-group">                                       
    <?php echo $formAcudiente->labelEx($modeloLocalizacion,'id_localidad',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
			<?php echo $formAcudiente->dropDownList($modeloLocalizacion,'id_localidad',CHtml::listData($localidad,'id_localidad', 'localidad'), array('prompt'=>'Seleccione Localidad','class'=>'form-control input-md')); ?>
            <?php echo $formAcudiente->error($modeloLocalizacion,'id_tipo_doc',array('style' => 'color:#F00')); ?>
        </div>

	</div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloLocalizacion,'barrio',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloLocalizacion,'barrio',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloLocalizacion,'barrio',array('style' => 'color:#F00'));?>
		</div>
    </div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloLocalizacion,'direccion',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloLocalizacion,'direccion',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloLocalizacion,'direccion',array('style' => 'color:#F00'));?>
		</div>
    </div>
    <div class="form-group">                                       
    <?php echo $formAcudiente->labelEx($modeloLocalizacion,'id_estrato',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
			<?php echo $formAcudiente->dropDownList($modeloLocalizacion,'id_estrato',CHtml::listData($estrato,'id_estrato', 'estrato'), array('prompt'=>'Seleccione Estrato','class'=>'form-control input-md')); ?>
            <?php echo $formAcudiente->error($modeloLocalizacion,'id_estrato',array('style' => 'color:#F00')); ?>
		</div>
	</div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloTelefono,'telefono',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloTelefono,'telefono',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloTelefono,'telefono',array('style' => 'color:#F00'));?>
		</div>            
	</div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloTelefono,'tel_sec',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloTelefono,'tel_sec',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloTelefono,'tel_sec',array('style' => 'color:#F00'));?>
        </div>
	</div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloTelefono,'celular',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloTelefono,'celular',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloTelefono,'celular',array('style' => 'color:#F00'));?>
		</div>
    </div>   
    <hr />
     <div class="row">
	<?php
		if(!empty($numDocAdol)){
			$modeloLocalizacion->num_doc=$numDocAdol;
		} 
		echo $formAcudiente->labelEx($modeloLocalizacion,'num_doc');?>
	<?php echo CHtml::label($numDocAdol,'numDocLbl',array('id'=>'numDocAdolAcud'));?>
	<?php echo $formAcudiente->hiddenField($modeloLocalizacion,'num_doc');?>
	<?php echo $formAcudiente->error($modeloLocalizacion,'num_doc',array('style' => 'color:#F00'));?>
	</div>
    <?php
				$boton=CHtml::ajaxSubmitButton (
						'Crear Registro',   
						array('identificacionRegistro/modAcudiente'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnFormAcud").hide();Loading.show();}',
							'success' => 'function(datosAcud) {	
								Loading.hide();
								if(datosAcud.estadoComu=="exito"){
									if(datosAcud.resultado=="exito"){
										var errorLoc=datosAcud.mensajeErrorLocAcud.trim();
										var errorTel=datosAcud.mensajeErrorTel.trim();
										if(errorLoc.length !== 0){
											errorLoc="Aunque ha habido un error en el registro de la localización del acudiente. El código del error es:" +errorLoc;
										}
										if(errorTel.length !== 0){
											errorTel="Aunque ha habido un error en el registro de los teléfonos del acudiente. El código del error es:" +errorTel;											
										}
										$("#MensajeFam").html("Se ha creado el registro del acudiente<br/>"+errorLoc+"<br/>"+errorTel);
										$("#formularioAcudiente").find("input, textarea, button, select").attr("disabled",true);	
										$("#formularioAcudiente").removeClass("unsavedForm");										
									}
									else{
										$("#MensajeFam").html("Ha habido un error en la creación del registro. Código del error: "+datosAcud.msnError.errorInfo);
										$("#formularioAcudiente #formularioAcudiente_es_").html("");                                                    
										$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
									}
								}
								else{						
									$("#btnFormAcud").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datosAcud, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioAcudiente #"+key+"_em_").text(val);                                                    
										$("#formularioAcudiente #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioAcudiente #formularioAcudiente_es_").html(errores);                                                    
									$("#formularioAcudiente #formularioAcudiente_es_").show(); 
								}
								
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#MensajeFam").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormAcud").show();
								}
								else{
									if(xhr.status==500){
										$("#MensajeFam").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
									}
									else{
										$("#MensajeFam").html("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
								
							}'
						),
						array('id'=>'btnFormAcud','name'=>'btnFormAcud','class'=>'btn btn-default btn-sdis')
				);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
<?php $this->endWidget();?>
<?php //script de seguridad que previene dejar la página si no se han guardado los datos
Yii::app()->getClientScript()->registerScript('dejaVentana','
		var numDocAdol="'.$numDocAdol.'";
		if(numDocAdol==""){
			$("#btnFormAcud").hide();
			$("#formularioAcudiente").find("input, textarea, button, select").attr("disabled",true);
		}
		//$(window).bind("beforeunload", function(){
			//return "Va a dejar la página"
		//});
	'
,CClientScript::POS_END); ?>
