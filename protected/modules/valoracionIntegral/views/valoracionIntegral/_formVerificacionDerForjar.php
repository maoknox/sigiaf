<div id="MensajeVerifDer" style="font-size:14px;"></div>
<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>
<?php $formAdolDerechos=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioVerifDer',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));?>
<?php echo  $formAdolDerechos->errorSummary($modeloVerifDerechos,'','',array('style' => 'font-size:14px;color:#F00')); ?>
<table cellpadding='0px' cellspacing='0px' border="0px" style="border:0px" align="center" width="80%">
<tr>
	<td style="border:1px solid #000" width="20%">Derecho</td>
	<td style="border:1px solid #000" width="40%">Situación Derecho</td>
	<td style="border:1px solid #000" width="40%">Observaciones</td>
</tr>
<?php 
foreach($derechos as $pk=>$derecho):?>
<?php if(strpos($derecho["derechocespa"],"Protecc")!==FALSE): ?>
<tr>
	<td style="border:1px solid #000">
		<label for="DerechoAdol_id_derechocespa_Nombre<?php echo $pk;?>"><?php echo $derecho["derechocespa"];?></label>
	</td>
    <td style="border:1px solid #000">
    	<label for="DerechoAdol_id_derechocespa_<?php echo $pk;?>"><?php echo $derecho["situacion_derecho"];?></label><hr />
		<input id="DerechoAdol_id_derechocespa_<?php echo $pk;?>" onclick="javascript:habilitaSitRiesgo(this);" type="checkbox" name="DerechoAdol[id_derechocespa][]" value="<?php echo $derecho["id_derechocespa"];?>">
		<label for="DerechoAdol_id_derechocespa_obs_<?php echo $pk;?>">Seleccione si cumple</label><br />
    <hr />
  	<div class="row">
    <?php echo $formAdolDerechos->dropDownList($modeloVerifDerechos,'situacionesRiesgos',CHtml::listData($proteccion,'id_sit_riesgo', 'sit_riesgo'), array('multiple'=>true,'disabled'=>false,'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true')); ?></br>
    <?php echo $formAdolDerechos->error($modeloVerifDerechos,'situacionesRiesgos',array('style' => 'color:#F00')); ?>
	</div>
    </td>
    <td style="border:1px solid #000">    
		<?php echo CHtml::textArea('DerechoAdol[observaciones_derecho_'.$derecho["id_derechocespa"].']','',array('id'=>'DerechoAdol_observaciones_derecho_'.$derecho["id_derechocespa"])); ?>
	</td>
    </tr>
		<?php elseif(strpos($derecho["derechocespa"],"Participac")!==FALSE): ?>
	<tr>
	<td style="border:1px solid #000">
		<label for="DerechoAdol_id_derechocespa_Nombre<?php echo $pk;?>"><?php echo $derecho["derechocespa"];?></label>
	</td>
	<td style="border:1px solid #000">
		<label for="DerechoAdol_id_derechocespa_<?php echo $pk;?>"><?php echo $derecho["situacion_derecho"];?></label><hr />
		<input id="DerechoAdol_id_derechocespa_<?php echo $pk;?>" onclick="javascript:habilitaAltPart(this);" type="checkbox" name="DerechoAdol[id_derechocespa][]" value="<?php 			echo $derecho["id_derechocespa"];?>">
		<label for="DerechoAdol_id_derechocespa_obs_<?php echo $pk;?>">Seleccione si cumple</label><br />
		<hr />
    	<div class="row">
    	<?php echo $formAdolDerechos->dropDownList($modeloVerifDerechos,'alternativasParticipacions',CHtml::listData($participacion,'id_alternativaproc', 'alternativaproc'), array('multiple'=>true,'disabled'=>false,'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true')); ?></br>
    	<?php echo $formAdolDerechos->error($modeloVerifDerechos,'alternativasParticipacions',array('style' => 'color:#F00')); ?>
		</div>
    </td>
    <td style="border:1px solid #000">
		<?php echo CHtml::textArea('DerechoAdol[observaciones_derecho_'.$derecho["id_derechocespa"].']','',array('id'=>'DerechoAdol_observaciones_derecho_'.$derecho["id_derechocespa"])); ?>
    </td>
    </tr>
<?php else:?>
	<tr>
	<td style="border:1px solid #000">
		<label for="DerechoAdol_id_derechocespa_Nombre<?php echo $pk;?>"><?php echo $derecho["derechocespa"];?></label>
	</td>
    <td style="border:1px solid #000">
		<label for="DerechoAdol_id_derechocespa_<?php echo $pk;?>"><?php echo $derecho["situacion_derecho"];?></label><hr />
		<input id="DerechoAdol_id_derechocespa_<?php echo $pk;?>"  type="checkbox" name="DerechoAdol[id_derechocespa][]" value="<?php echo $derecho["id_derechocespa"];?>">
		<label for="DerechoAdol_id_derechocespa_obs_<?php echo $pk;?>">Seleccione si cumple</label><br />
	</td>
    <td style="border:1px solid #000">
		<?php echo CHtml::textArea('DerechoAdol[observaciones_derecho_'.$derecho["id_derechocespa"].']','',array('id'=>'DerechoAdol_observaciones_derecho_'.$derecho["id_derechocespa"])); ?>
	</td>
	</tr>
<?php endif;?>
<?php endforeach;?>
 	<tr>
    <td colspan="3" align="center" style="border:1px solid #000">
		<?php echo $formAdolDerechos->error($modeloVerifDerechos,'id_derechocespa',array('style' => 'color:#F00'));?>
<div class="row" >
                    <?php
                        $modeloVerifDerechos->id_instanciader=1; 
                        echo $formAdolDerechos->hiddenField($modeloVerifDerechos,'id_instanciader');?>
                    <?php 
                        echo $formAdolDerechos->error($modeloVerifDerechos,'id_instanciader',array('style' => 'color:#F00'));?>
                    </div>
                    <div class="row">
                    <?php 
						if(!empty($numDocAdol)){
							$modeloVerifDerechos->num_doc=$numDocAdol;
						}
						echo $formAdolDerechos->labelEx($modeloVerifDerechos,'num_doc');?>
                    <?php echo CHtml::label($numDocAdol,'numDocVerifDer',array('id'=>'numDocVerifDer'));?>
                    <?php
						$modeloVerifDerechos->id_momento_verif=1;
						$modeloVerifDerechos->estado_derecho="false";
						$modeloVerifDerechos->fecha_reg_derecho=date("Y-m-d");
						echo $formAdolDerechos->hiddenField($modeloVerifDerechos,'estado_derecho');
						echo $formAdolDerechos->hiddenField($modeloVerifDerechos,'id_momento_verif');
						echo $formAdolDerechos->hiddenField($modeloVerifDerechos,'fecha_reg_derecho');
                        // $modeloVerifDerechos->num_doc='2342342';
                        echo $formAdolDerechos->hiddenField($modeloVerifDerechos,'num_doc');?>
                    <?php echo $formAdolDerechos->error($modeloVerifDerechos,'num_doc',array('style' => 'color:#F00'));?></div>
<?php
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
$boton=CHtml::ajaxSubmitButton (
						'Crear Registro',   
						array('valoracionIntegral/creaVerifDerAdol'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){Loading.show();/*$("#btnFormVerifDer").hide();*/}',
							'success' => 'function(datosVerifDer) {
								Loading.hide();		
								if(datosVerifDer.estadoComu=="exito"){
									if(datosVerifDer.resultado=="exito"){
										$("#MensajeVerifDer").text("Se ha creado el registro de la verificación de derechos del Cespa");	
										$("#formularioVerifDer #formularioVerifDer_es_").html("");                                                    
										$("#formularioVerifDer #formularioVerifDer_es_").hide();
										$("#formularioVerifDer").find("input, textarea, button, select").attr("disabled",true);
									}
									else{
										$("#MensajeVerifDer").text("Ha habido un error en la creación del registro. Código del error: "+datosVerifDer.msnError.errorInfo);
										$("#formularioVerifDer #formularioVerifDer_es_").html("");                                                    
										$("#formularioVerifDer #formularioVerifDer_es_").hide(); 	
									}
								}
								else{						
									$("#btnFormVerifDer").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datosVerifDer, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioVerifDer #"+key+"_em_").text(val);                                                    
										$("#formularioVerifDer #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioVerifDer #formularioVerifDer_es_").html(errores);                                                    
									$("#formularioVerifDer #formularioVerifDer_es_").show();
								}									
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#MensajeVerifDer").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormVerifDer").show();
								}
								else{
									if(xhr.status==500){
										$("#MensajeVerifDer").text("Hay un error con el Sistema de información. Comuníquese con el área encargada");
									}
									else{
										$("#MensajeVerifDer").text("No se ha creado el registro de documentos remitidos debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
							}'
						),
						array('id'=>'btnFormVerifDer','class'=>'btn btn-default btn-sdis','name'=>'btnFormVerifDer')
				);	
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
    </td></tr>
</table>
<?php $this->endWidget();?>
<?php //script de seguridad que previene dejar la página si no se han guardado los datos
Yii::app()->getClientScript()->registerScript('prepFormDerechoCespa','
		var numDocAdol="";
		numDocAdol="'.$numDocAdol.'";
		function habilitaSitRiesgo(elemento){
			if($(elemento).is(":checked")) {  
				$("#DerechoAdol_situacionesRiesgos").attr("disabled",false);  
			} else {  
				$("#DerechoAdol_situacionesRiesgos").attr("disabled",true); 
			}   
		}
		function habilitaAltPart(elemento){
			if($(elemento).is(":checked")) {  
				$("#DerechoAdol_alternativasParticipacions").attr("disabled",false);  
			} else {  
				$("#DerechoAdol_alternativasParticipacions").attr("disabled",true); 
			} 			
		}
		if(numDocAdol==""){
			$("#DerechoAdol_situacionesRiesgos").attr("disabled",true);
			$("#DerechoAdol_alternativasParticipacions").attr("disabled",true);
			$("#btnFormVerifDer").attr("align","center");
			$("#btnFormVerifDer").hide();
			$("#formularioVerifDer").find("input, textarea, button, select").attr("disabled",true);
		}
	'
,CClientScript::POS_END);
 ?>
 
