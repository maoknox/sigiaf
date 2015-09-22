<div id="Mensaje" style="font-size:14px;color:#F00" ></div>
    <fieldset>
    
    <!-- Form Name -->
    <legend>Traslados de sede (Funcionarios)</legend>

		<?php $formTrasladoSede=$this->beginWidget('CActiveForm', 
			array(
				'id'=>'formularioTrasladoFunc',
				'enableAjaxValidation'=>false,
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
					'validateOnChange' => true,
                    'validateOnType' => true
				),
				'htmlOptions' => array('class' => 'form-horizontal')
				)
			);
        ?>
		<?php echo  $formTrasladoSede->errorSummary($modeloCforjarPersonal,'','',array('style' => 'font-size:14px;color:#F00')); ?>
		<div class="form-group">
			<?php echo $formTrasladoSede->labelEx($modeloCforjarPersonal,'id_cedula',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
            <div class="col-md-4">
                <?php echo $formTrasladoSede->dropDownList($modeloCforjarPersonal,'id_cedula',CHtml::listData($funcionarios,'id_cedula', 'nombres'), 
					array(
						'prompt'=>'Seleccione...',
						'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true',								
					)); 
				?>
            </div>
		</div>        
		<div class="form-group">
			<?php echo $formTrasladoSede->labelEx($modeloCforjarPersonal,'id_forjar',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
            <div class="col-md-4">
                <?php echo $formTrasladoSede->dropDownList($modeloCforjarPersonal,'id_forjar',CHtml::listData($sedes,'id_forjar', 'nombre_sede'), array('prompt'=>'Seleccione sede','class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true')); ?>
            </div>
		</div>        
        <div class="form-group">
            <label class="col-md-4 control-label" for="button1id"></label>
            <div class="col-md-8">
			<?php
				$boton=CHtml::ajaxSubmitButton (
						'Trasladar',   
						array('administracion/trasladoFuncionario'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnForm").hide();Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="\'exito\'"){
										$("#Mensaje").html("Se ha realizado el traslado del funcionario");	
										$("#formularioTrasladoFunc #formularioTrasladoFunc_es_").html("");                                                    
										$("#formularioTrasladoFunc #formularioTrasladoFunc_es_").hide(); 
									}
									else if(datos.resultado=="\'novalidado\'"){
										$("#Mensaje").html("El funcionario seleccionado no cumple con los requisitos para el traslado</br> <ul><li>Tiene asociado(s) "+datos.adolsasoc+" adolescente(s) en la sede actual</li></ul>");	
										$("#btnForm").show();
									}
									else{
										$("#Mensaje").html("Ha habido un error en la creación del registro. Código del error: ");
										$("#formularioTrasladoFunc #formularioTrasladoFunc_es_").html("");                                                    
										$("#formularioTrasladoFunc #formularioTrasladoFunc_es_").hide(); 	
									}
								}								
								else{						
									$("#btnForm").show();
									var errores="Por favor tenga en cuenta las siguientes validaciones:<br/><ul>";
									$.each(datos, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioTrasladoFunc #"+key+"_em_").text(val);                                                    
										$("#formularioTrasladoFunc #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioTrasladoFunc #formularioTrasladoFunc_es_").html(errores);                                                    
									$("#formularioTrasladoFunc #formularioTrasladoFunc_es_").show(); 
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

    <?php $this->endWidget();?>
    </fieldset>