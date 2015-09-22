<?php 
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('administracion/administracion/habilitarValoracionForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php
	if(!empty($numDocAdol)):
?>
	<div id="Mensaje" style="font-size:14px;" ></div>
    <fieldset>
		
		<!-- Form Name -->
	<legend>Habilitar valoraciones</legend>

    <?php $formHabVal=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioHabVal',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
			'htmlOptions' => array('class' => 'form-horizontal','enctype' => 'multipart/form-data')
		));
	?>
    	<?php echo  $formHabVal->errorSummary($modeloJustHabVal,'','',array('style' => 'font-size:14px;color:#F00')); ?>

         <div class="form-group">
            <?php echo $formHabVal->labelEx($modeloJustHabVal,'valoracion_hab',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
            <div class="col-md-4">
                <?php echo $formHabVal->dropDownList($modeloJustHabVal,'valoracion_hab',CHtml::listData($valoraciones,'valoracion', 'nombre_valoracion'),
					array(
						'prompt'=>'Seleccione...',
						'class'=>'form-control',
						'ajax' => array(
							'dataType'=>'json',
							'type'=>'POST', 
							'data'=>array('num_doc'=>$numDocAdol,'valoracion'=>'js:this.value'),
							'url'=>Yii::app()->createUrl('administracion/administracion/cargaCedulas'), //or $this->createUrl('loadcities') if '$this' extends CController
							'success' => 'function(datos) {									
								if(datos.estadoVal=="\'habilitada\'"){		
									$("#JustificacionHabVal_id_cedula").empty();
									$("#JustificacionHabVal_id_cedula").append("<option value=\"\" selected=\"selected\">Seleccione una Valoración</option>");											
									alert("Esta valoración está habilitada");																					
								}
								else if(datos.estadoVal=="\'deshabilitada\'"){
									$("#JustificacionHabVal_id_cedula").empty();
									$("#JustificacionHabVal_id_cedula").append("<option value=\"\" selected=\"selected\">Seleccione una valoración inactiva...</option>");											
									$.each(datos.cedulas, function(key, val) {
										var idCedula=val.id_cedula.replace(/\'/g,"");
										var nombreProf=val.nombre_prof.replace(/\'/g,"");
										$("#JustificacionHabVal_id_cedula").append("<option value=\""+idCedula+"\">"+nombreProf+"</option>");																				                                              
									});		
									var idValoracion=datos.idvaloracion;
									idValoracion=idValoracion.replace(/\'/g,"");
									$("#JustificacionHabVal_id_val_hab").val(idValoracion);											
								}
								else if(datos.estadoVal=="\'noexiste\'"){
									$("#JustificacionHabVal_id_cedula").empty();
									$("#JustificacionHabVal_id_cedula").append("<option value=\"\" selected=\"selected\">Seleccione una Valoración</option>");											
									alert("Adolescente sin valoración");																					
								}
								else{
									$("#JustificacionHabVal_id_cedula").empty();
									$("#JustificacionHabVal_id_cedula").append("<option value=\"\" selected=\"selected\">Seleccione una Valoración</option>");											
								}
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								alert(thrownError);
							}'
													
						//'update'=>'#city_name', //or 'success' => 'function(data){...handle the data in the way you want...}',					  	
  						)
					)); ?>               
                <?php echo $formHabVal->error($modeloJustHabVal,'valoracion_hab',array('style' => 'color:#F00')); ?>
            </div>
         </div>
        <div class="form-group">
		<?php echo $formHabVal->labelEx($modeloJustHabVal,'id_cedula',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
            <div class="col-md-4">
                <?php echo $formHabVal->dropDownList($modeloJustHabVal,'id_cedula',array(''=>'Seleccione una valoración'),array('class'=>'form-control')); ?>
                <?php echo $formHabVal->error($modeloJustHabVal,'id_cedula',array('style' => 'color:#F00')); ?>
            </div>
    	</div> 
        <div class="form-group">
		<?php echo $formHabVal->labelEx($modeloJustHabVal,'justificacion_habval',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
            <div class="col-md-4">
                <?php echo $formHabVal->textArea($modeloJustHabVal,'justificacion_habval',array('class'=>'selectpicker form-control')); ?>
            	<?php echo $formHabVal->error($modeloJustHabVal,'justificacion_habval',array('style' => 'color:#F00')); ?>
            </div>
    	</div>    
        <div class="form-group">
            <label class="col-md-4 control-label" for="button1id"></label>
            <div class="col-md-8">
            <?php 
				$modeloJustHabVal->fecha_hab_val=date("Y-m-d");
				echo $formHabVal->hiddenField($modeloJustHabVal,'fecha_hab_val',array('class'=>'selectpicker form-control')); 
			?>
            <?php echo $formHabVal->hiddenField($modeloJustHabVal,'id_val_hab'); ?>
            <?php 
				$modeloJustHabVal->numDoc=$numDocAdol;
				echo $formHabVal->hiddenField($modeloJustHabVal,'numDoc'); 				
			?>
			<?php
				$boton=CHtml::ajaxSubmitButton (
						'Habilitar',   
						array('administracion/habilitarValoracion'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnForm").hide();Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="\'exito\'"){
										$("#Mensaje").html("La valoración ha sido habilitada");	
										$("#formularioHabVal #formularioHabVal_es_").html("");                                                    
										$("#formularioHabVal #formularioHabVal_es_").hide(); 
									}
									else{
										$("#Mensaje").html("Ha habido un error en la creación del registro. Código del error: ");
										$("#formularioHabVal #formularioHabVal_es_").html("");                                                    
										$("#formularioHabVal #formularioHabVal_es_").hide(); 	
									}
								}
								else{						
									$("#btnForm").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datos, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioHabVal #"+key+"_em_").text(val);                                                    
										$("#formularioHabVal #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioHabVal #formularioHabVal_es_").html(errores);                                                    
									$("#formularioHabVal #formularioHabVal_es_").show(); 
								}
								
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#Mensaje").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnForm").show();
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
						array('id'=>'btnForm','name'=>'btnForm','class'=>'btn btn-default btn-sdis')
				);

		
		?>
        <?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
    <?php
		$this->endWidget();	
	?>
    </fieldset>
	<?php
		
		//print_r($modeloJustHabVal->attributes);
		//$contenidoArchivo
		//$file = CUploadedFile::getInstance($modeloDocSoporte,'nombre_doc_ds');
	?>
<?php else:?>
	
Seleccione adolescente

<?php endif;?>