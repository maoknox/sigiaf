<div id="Mensaje" style="font-size:14px;" ></div>
<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioAdol',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
	<?php echo  $form->errorSummary($formAdol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
     <!-- Search input-->
    <div class="form-group">                                       
	   	<?php echo $form->labelEx($formAdol,'nombres',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $form->textField($formAdol,'nombres',array('class'=>'form-control input-md'));?>
            <?php echo $form->error($formAdol,'nombres',array('style' => 'color:#F00'));?>     
        </div>
    </div>

    <div class="form-group">                                       
		<?php echo $form->labelEx($formAdol,'apellido_1',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $form->textField($formAdol,'apellido_1',array('class'=>'form-control input-md'));?>
            <?php echo $form->error($formAdol,'apellido_1',array('style' => 'color:#F00'));?>
        </div>
    </div>

	<div class="form-group">  
		<?php echo $form->labelEx($formAdol,'apellido_2',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $form->textField($formAdol,'apellido_2',array('class'=>'form-control input-md'));?>
            <?php echo $form->error($formAdol,'apellido_2',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    <?php echo $form->labelEx($formAdol,'id_tipo_doc',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
	    <div class="col-md-4">
			<?php echo $form->dropDownList($formAdol,'id_tipo_doc',CHtml::listData($tipoDocBd,'id_tipo_doc', 'tipo_doc'), array('prompt'=>'Seleccione Tipo documento','class'=>'form-control')); ?>
            <?php echo $form->error($formAdol,'id_tipo_doc',array('style' => 'color:#F00')); ?>
		</div>
    </div>
    <div class="form-group">
	<?php echo $form->labelEx($formAdol,'num_doc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
	    <div class="col-md-4">
			<?php echo $form->textField($formAdol,'num_doc',array('prompt'=>'Seleccione Tipo documento','class'=>'form-control'));?>
            <?php echo $form->error($formAdol,'num_doc',array('style' => 'color:#F00'));?>
		</div>
    </div>
    <div class="form-group">
	<?php echo $form->labelEx($formAdol,'fecha_nacimiento',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
	    <div class="col-md-4">
	<?php //
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array('model'=>$formAdol,
			'name'=>'datepicker-showButtonPanel',
			'attribute'=>'fecha_nacimiento',
			'value'=>$formAdol->fecha_nacimiento,
			'language'=>'es',			
			'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control'),			
			'options'=>array('autoSize'=>true,
					'defaultDate'=>$formAdol->fecha_nacimiento,
					'dateFormat'=>'yy-mm-dd',
					'buttonText'=>'Seleccione Fecha',
					'selectOtherMonths'=>true,
					'showAnim'=>'slide',
					'showOtherMonths'=>true,
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'minDate'=>'date("Y-m-d")-19Y',//fecha minima
					'maxDate'=>'date("Y-m-d")-10Y+6m',//fecha maxima
			),
		));
		
	?>
   			<?php echo $form->error($formAdol,'fecha_nacimiento',array('style' => 'color:#F00'));?>
    	</div>
	</div>
    <div class="form-group">
   <?php echo CHtml::label('Departamento de nacimiento','deptoNacimiento',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
	    <div class="col-md-4">
   <?php echo CHtml::dropDownList('id_deptoNacimiento','deptoNacimiento',CHtml::listData($departamento,'id_departamento', 'departamento'),    				
				array(
					'prompt'=>'Seleccione Departamento',
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('identificacionRegistro/consDepto'), //url to call.
						//Style: CController::createUrl('currentController/methodToCall')
						//'beforeSend'=>'function (){alert("asdf")}',
						//'success'=>'function (datos){alert(datos)}',
						'update'=>'#Adolescente_id_municipio', //selector to update
						//'data'=>'js:javascript statement' 
						//leave out the data key to pass all form values through
					),
					'class'=>'form-control input-md'
				//array('prompt'=>'Seleccione Departamento'),
				)
			); 								
	?>
		</div>
    </div>
    <div class="form-group">
    <?php echo $form->labelEx($formAdol,'id_municipio',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
    	<div class="col-md-4">
			<?php echo $form->dropDownList($formAdol,'id_municipio',array(''=>'Debe seleccionar un Departamento'),array('class'=>'form-control input-md')); ?>
            <?php echo $form->error($formAdol,'id_municipio',array('style' => 'color:#F00')); ?>
		</div>
    </div>    
    <div class="form-group">
    <?php echo $form->labelEx($formAdol,'id_sexo',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
    	<div class="col-md-4">
			<?php echo $form->dropDownList($formAdol,'id_sexo',CHtml::listData($sexo,'id_sexo', 'sexo'),array('prompt'=>'Seleccione sexo','class'=>'form-control input-md')); ?></br>
            <?php echo $form->error($formAdol,'id_sexo',array('style' => 'color:#F00')); ?>
		</div>
    </div>
    
    <div class="form-group">
	    <?php echo $form->labelEx($formAdol,'id_etnia',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
   		<div class="col-md-4">
			<?php echo $form->dropDownList($formAdol,'id_etnia',CHtml::listData($etnia,'id_etnia', 'etnia'), array('prompt'=>'Seleccione Etnia','class'=>'form-control input-md')); ?></br>
            <?php echo $form->error($formAdol,'id_etnia',array('style' => 'color:#F00')); ?>
		</div>
    </div>
    <div class="form-group">
	<?php echo $form->labelEx($formAdol,'escIngEgrs',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
   		<div class="col-md-4">
			<?php echo $form->radioButtonList($formAdol,'escIngEgrs',array('true'=>'Escolarizado','false'=>'No escolarizado'));?>
            <?php echo $form->error($formAdol,'escIngEgrs',array('style' => 'color:#F00'));?>
    	</div>
    </div>    
    <hr />Seleccione equipo psicosocial y el responsable del adolescente
   
    <table style="width:100%"><tr>
   <td>
   <div class="form-group">
    <?php echo $form->labelEx($formAdol,'psicologos',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
    <div class="col-md-4">
    	<?php echo $form->dropDownList($formAdol,'psicologos',CHtml::listData($psicologo,'id_cedula', 'nombrecomp_pers'),array('prompt'=>'Seleccione Psocólogo','class'=>'form-control input-md')); ?></br>
    	<?php echo $form->error($formAdol,'psicologos',array('style' => 'color:#F00')); ?>
        </div>
   		 </div>
        </td><td rowspan="2">
         <div class="form-group">
    <div class="col-md-4">
		<?php echo $form->radioButtonList($formAdol, 'responsableAdol', array('1'=>'Responsable psicólogo', '2'=>'Responsable Trabajador Social')); //responsable del caso del adolescente?>
   		<?php echo $form->error($formAdol,'responsableAdol',array('style' => 'color:#F00')); ?>
	</div>	
    </div>
    </td></tr>
   <tr><td>
   <div class="form-group">
   <?php echo $form->labelEx($formAdol,'trabSocials',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
   <div class="col-md-4">
	   <?php echo $form->dropDownList($formAdol,'trabSocials',CHtml::listData($trabSocial,'id_cedula', 'nombrecomp_pers'),array('prompt'=>'Seleccione Trabajador social','class'=>'form-control input-md')); ?>
       <?php echo $form->error($formAdol,'trabSocials',array('style' => 'color:#F00')); ?>
   </div>
   </div>
   </td></tr></table>
   <div class="form-group">
    <?php
		$boton=CHtml::ajaxSubmitButton (
						'Crear Registro',   
						array('identificacionRegistro/creaRegAdol'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnFormAdolId").hide();Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="\'exito\'"){
										jAlert("Los datos se han enviado satisfactoriamente<br/><strong>El número de carpeta asignado por el sistema es: "+datos.num_carpeta+"</strong><br/>"+datos.msnErrorProf","Mensaje")
										$("#Mensaje").html("Los datos se han enviado satisfactoriamente<br/><strong>El número de carpeta asignado por el sistema es: "+datos.num_carpeta+"</strong><br/>"+datos.msnErrorProf);	
										$("#formLocalizacion #LocalizacionViv_num_doc").val($("#Adolescente_num_doc").val());
										$("#formularioDocCespa #DocumentoCespa_numDocAdol").val($("#Adolescente_num_doc").val());
										$("#formularioAcudiente #LocalizacionViv_num_doc").val($("#Adolescente_num_doc").val());
										$("#formularioVerifDer #DerechoAdol_num_doc").val($("#Adolescente_num_doc").val());
										$("#numDocLblLoc").text($("#Adolescente_num_doc").val());
										$("#numDocLblDocC").text($("#Adolescente_num_doc").val());
										$("#numDocAdolAcud").text($("#Adolescente_num_doc").val());
										$("#numDocVerifDer").text($("#Adolescente_num_doc").val());
										$("#btnFormLocaliz").show();
										$("#btnFormDocAdol").show();
										$("#btnFormAcud").show();
										$("#btnFormVerifDer").show();
										$("#formLocalizacion").find("input, textarea, button, select").attr("disabled",false);
										$("#formularioDocCespa").find("input, textarea, button, select").attr("disabled",false);
										$("#formularioAcudiente").find("input, textarea, button, select").attr("disabled",false);
										$("#formularioVerifDer").find("input, textarea, button, select").attr("disabled",false);
										$("#formularioAdol #formularioAdol_es_").html("");                                                    
										$("#formularioAdol #formularioAdol_es_").hide();
										$("#formularioAdol").removeClass("unsavedForm");
										$("#formularioAdol #Adolescente_psicologos_em_").hide();
										$("#formularioAdol #Adolescente_trabSocials_em_").hide();
									}
									else{
										$("#Mensaje").html("Ha habido un error en la creación del registro. Código del error: "+datos.msnError.errorInfo);
										$("#formularioAdol #formularioAdol_es_").html("");                                                    
										$("#formularioAdol #formularioAdol_es_").hide(); 	
									}
								}
								else{						
									$("#btnFormAdolId").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datos, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioAdol #"+key+"_em_").text(val);                                                    
										$("#formularioAdol #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioAdol #formularioAdol_es_").html(errores);                                                    
									$("#formularioAdol #formularioAdol_es_").show(); 
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
    <?php echo $boton; //CHtml::submitButton('Crear');?></div>
<?php $this->endWidget();?>
<?php //script de seguridad que previene dejar la página si no se han guardado los datos
Yii::app()->getClientScript()->registerScript('dejaVentana','	
	
',CClientScript::POS_END); 
?>