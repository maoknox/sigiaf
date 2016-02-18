<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('referenciacion/asignacionServicio/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('referenciacion/asignacionServicio/asignacionServicioForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>
<div id="MensajeRef" style="font-size:14px;"></div>
<div class="panel-heading color-sdis">Asignación de la referenciación</div> 

<?php $formRef=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioRef',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<?php echo  $formRef->errorSummary($modeloRef,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<div class="form-group">
        	<?php echo $formRef->labelEx($modeloRef,'id_tipo_referenciacion',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="checkbox">
            <div class="col-md-6">	
				<?php 
                    $url="consEspNiv";
                    echo $formRef->radioButtonList($modeloRef,
                    'id_tipo_referenciacion',
                    CHtml::listData($tipoRef,'id_tipo_referenciacion','tipo_referenciacion'),array(
                    'onclick' => 'js:$.ajax({
                            type:"post", //request type
                            datatype:"json",
                            data:"id_tiporef="+this.value,
                            url:"'.CController::createUrl($url).'", //url to call.
                            success:function(datos){
                                $("#ReferenciacionAdol_id_esp_sol").html("");
                                $("#ReferenciacionAdol_id_esp_solii").html("");
                                $("#ReferenciacionAdol_id_esp_soliii").html("");
                                var datos = jQuery.parseJSON(datos);
                                var contenido="<option value=\'\'>Seleccione</option>";
                                var benef="";
                                $.each(datos,function(key,value){
                                    contenido+="<option value=\'"+key+"\'>"+value.cont+"</option>";
                                    benef=value.idben;
                                })
                                habBeneficiario(benef);
                                $("#ReferenciacionAdol_id_esp_sol").html("");
                                $("#ReferenciacionAdol_id_esp_sol").append(contenido);
                                
                            },
                            error:function (xhr, ajaxOptions, thrownError){
                                alert(thrownError);	
                            }
                        })'
                    ));?>
                <?php echo $formRef->error($modeloRef,'id_tipo_referenciacion',array('style' => 'color:#F00'));?>
       		</div>  
        </div>  
 </div>
<div class="form-group">
        <?php echo $formRef->labelEx($modeloRef,'id_beneficiario',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
     <div class="checkbox">
        <div class="col-md-4">	
            <?php echo $formRef->radioButtonList($modeloRef,'id_beneficiario',CHtml::listData($beneficiario,'id_beneficiario','beneficiario'),
                array('onclick'=>'js:refFamiliar(this.value)'));?>
            <?php echo $formRef->error($modeloRef,'id_beneficiario',array('style' => 'color:#F00'));?>
      </div>
  </div>
</div>
 <div id="beneficiario" style=" display:none">
    <div class="form-group">
		<?php echo $formRef->labelEx($modeloFamBenef,'nombres_fam_ben',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formRef->textField($modeloFamBenef,'nombres_fam_ben',array('class'=>'form-control'));?>
            <?php echo $formRef->error($modeloFamBenef,'nombres_fam_ben',array('style' => 'color:#F00'));?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $formRef->labelEx($modeloFamBenef,'apellidos_fam_ben',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formRef->textField($modeloFamBenef,'apellidos_fam_ben',array('class'=>'form-control'));?>
            <?php echo $formRef->error($modeloFamBenef,'apellidos_fam_ben',array('style' => 'color:#F00'));?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $formRef->labelEx($modeloFamBenef,'id_doc_fam_ben',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formRef->textField($modeloFamBenef,'id_doc_fam_ben',array('class'=>'form-control'));?>
            <?php echo $formRef->error($modeloFamBenef,'id_doc_fam_ben',array('style' => 'color:#F00'));?>
        </div>
   </div>
</div>

<div class="form-group">
    <?php echo CHtml::label('Especificación de la solicitud','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-6">
      <hr />
    </div>
</div>		
<div class="form-group">
    <?php echo $formRef->labelEx($modeloRef,'id_esp_sol',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">		
    <?php echo $formRef->dropDownList(
		$modeloRef,
		'id_esp_sol',
		array(''=>'Seleccione línea de acción'),array('class'=>'form-control','data-hide-disabled'=>'true','data-live-search'=>'true','ajax' => array(
			'type'=>'post', //request type
			'url'=>CController::createUrl('asignacionServicio/consEspNivii'), //url to call.
			//Style: CController::createUrl('currentController/methodToCall')
			//'beforeSend'=>'function (){alert("asdf")}',
			'update'=>'#ReferenciacionAdol_id_esp_solii', //selector to update
			//leave out the data key to pass all form values through
		))) 
	?>
	<?php echo $formRef->error($modeloRef,'id_esp_sol',array('style' => 'color:#F00'));?>
    </div> 
</div>
<div class="form-group">
    <?php echo $formRef->labelEx($modeloRef,'id_esp_solii',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">		
    <?php echo $formRef->dropDownList(
		$modeloRef,
		'id_esp_solii',
		array(''=>'Seleccione'),array('class'=>'form-control','data-hide-disabled'=>'true','data-live-search'=>'true',
		'ajax' => array(
					'type'=>'post', //request type
					'url'=>CController::createUrl('asignacionServicio/consEspNiviii'), //url to call.
					//Style: CController::createUrl('currentController/methodToCall')
					//'beforeSend'=>'function (){alert("asdf")}',
					//'success'=>'function (datos){}',
					'update'=>'#ReferenciacionAdol_id_esp_soliii', //selector to update
					//leave out the data key to pass all form values through
				)
		)) 
	?>
	<?php echo $formRef->error($modeloRef,'id_esp_solii',array('style' => 'color:#F00'));?>
    </div> 
</div>
<div class="form-group">
    <?php echo $formRef->labelEx($modeloRef,'id_esp_soliii',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">		
    <?php echo $formRef->dropDownList(
		$modeloRef,
		'id_esp_soliii',
		array(''=>'Seleccione'),
		array('class'=>'form-control','data-hide-disabled'=>'true','data-live-search'=>'true'))
		?>
	<?php echo $formRef->error($modeloRef,'id_esp_soliii',array('style' => 'color:#F00'));?>
    </div> 
</div>
<div class="form-group">
    <?php echo $formRef->labelEx($modeloRef,'institucion_ref',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">		
        <?php echo $formRef->textField($modeloRef,'institucion_ref',array('class'=>'form-control'));?>
        <?php echo $formRef->error($modeloRef,'institucion_ref',array('style' => 'color:#F00'));?>
    </div>
</div>    
<div class="form-group">
    <?php echo $formRef->labelEx($modeloRef,'observaciones_refer',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">		
        <?php echo $formRef->textArea($modeloRef,'observaciones_refer',array('class'=>'form-control'));?>
        <?php echo $formRef->error($modeloRef,'observaciones_refer',array('style' => 'color:#F00'));?>
    </div>
</div>    
<div class="form-group">
    <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">		
	<?php
		$modeloRef->id_estadoref=1;
		$modeloRef->fecha_referenciacion=date("Y-m-d");
		echo $formRef->hiddenField($modeloRef,'id_estadoref');
		echo $formRef->hiddenField($modeloRef,'fecha_referenciacion');
		echo $formRef->hiddenField($modeloRef,'num_doc');
		echo $formRef->hiddenField($modeloRef,'id_estadoref');

        echo $formRef->error($modeloRef,'num_doc',array('style' => 'color:#F00'));
		$boton=CHtml::ajaxSubmitButton (
						'Crear Registro',   
						array('asignacionServicio/creaRegRef'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnFormRef").hide();Loading.show();}',
							'success' => 'function(datosRef) {	
								Loading.hide();
								if(datosRef.estadoComu=="exito"){
									if(datosRef.resultado=="exito"){
										if(datosRef.resultadofam=="exito"){
											$("#MensajeRef").text("Referenciación creada satisfactoriamente");
											jAlert("Referenciación creada satisfactoriamente","Mensaje");
										}
										else{
											$("#MensajeRef").text("Aunque la referenciación fue creada hubo un error en la asociación del familiar beneficiario. el codigo del error es: "+datosRef.resultadofam);
										}
										$("#formularioRef #formularioRef_es_").html("");      
									}
									else{
										$("#MensajeRef").text("Ha habido un error en la creación del registro. Código del error: "+datosRef.resultado);
										$("#formularioRef #formularioRef_es_").html("");                                                    
										//$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
									}
								}
								else{						
									$("#btnFormRef").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datosRef, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioRef #"+key+"_em_").text(val);                                                    
										$("#formularioRef #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioRef #formularioRef_es_").html(errores);                                                    
									$("#formularioRef #formularioRef_es_").show(); 
									
								}
								
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#MensajeRef").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormRef").show();
								}
								else{
									if(xhr.status==500){
										$("#MensajeRef").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
									}
									else{
										$("#MensajeRef").html("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
								
							}'
						),
						array('id'=>'btnFormRef','class'=>'btn btn-default btn-sdis','name'=>'btnFormRef')
				);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
	</div>
</div>
<?php $this->endWidget();?>
<?php endif;?>
<?php Yii::app()->getClientScript()->registerScript('script_asignaref','
		function refFamiliar(idBenef){
			if(idBenef==1){
				$("#beneficiario").hide("slow");
			}	
			else{
				$("#beneficiario").show("slow");
			}
		}
		function habBeneficiario(idBeneficiario){
			switch(idBeneficiario){
				case 1:
					$("#ReferenciacionAdol_id_beneficiario_0").attr("disabled",false);
					$("#ReferenciacionAdol_id_beneficiario_1").attr("disabled",true);
					$("#ReferenciacionAdol_id_beneficiario_2").attr("disabled",true);
				break;
				case 2:
					$("#ReferenciacionAdol_id_beneficiario_0").attr("disabled",false);
					$("#ReferenciacionAdol_id_beneficiario_1").attr("disabled",false);
					$("#ReferenciacionAdol_id_beneficiario_2").attr("disabled",false);
				break;
				
			}
			
		}
	'
,CClientScript::POS_END);
?>
