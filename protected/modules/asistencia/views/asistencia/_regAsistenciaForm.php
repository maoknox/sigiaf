<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearchAs.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/IdentificacionRegistro/buscaAdolAsistencia'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('asistencia/asistencia/_regAsistenciaForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
 <div id="MensajeAsist" style="font-size:14px;"></div>         

<div id="listaAdolescentes" style="overflow-x:scroll">
<fieldset>
<legend>Registro de asistencia</legend>

<?php
	//print_r($areaPresc);
?>
 <?php $formularioAsist=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioAsist',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array(
		'class' => 'form-horizontal',
	)
 ));
?>	
<?php //echo  $formularioAsist->errorSummary($modeloAsistencia,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<div class="form-group">
		<?php echo $formularioAsist->labelEx($modeloAsistencia,'fecha_asistencia',array('class'=>'col-md-4 control-label'));?>
       	<div class="col-md-4">     
             <?php //
			$this->widget('zii.widgets.jui.CJuiDatePicker',
				array('model'=>$modeloAsistencia,
				'attribute'=>'fecha_asistencia',
				'value'=>'',
				'language'=>'es',
				'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control'),
				'options'=>array('autoSize'=>true,
						'defaultDate'=>'',
						'dateFormat'=>'yy-mm-dd',
						'selectOtherMonths'=>true,
						'showAnim'=>'slide',
						'showOtherMonths'=>true,
						'changeMonth'=>'true',
						'changeYear'=>'true',
						'minDate'=>'',//fecha minima
						'maxDate'=>'',//fecha maxima
				),
			));
			
		?></br>
		<?php echo $formularioAsist->error($modeloAsistencia,'fecha_asistencia',array('style' => 'color:#F00'));?>
		<?php echo $formularioAsist->error($modeloAsistencia,'areaAsistencia',array('style' => 'color:#F00'));?>
        </div>
        </div>
<table><tr>
	<td style="border:1px solid #003">Nombres del Adolescente</td>
   	<?php foreach($areaPresc as $pk=>$areaPrescencial):?>
		<td style="border:1px solid #003"><?php echo $areaPrescencial["area_presencial"]?></td>
	<?php endforeach;?>
   	<?php foreach($tipoAreaInscripcion as $pk=>$tipoAreaIns):?>
		<td style="border:1px solid #003"><?php echo $tipoAreaIns["area_inscr"]?></td>
	<?php endforeach;?>
	<?php $areaPresc=CJSON::encode($areaPresc);?>
    <?php $areaInscripcion=CJSON::encode($areaInscripcion);?>
    <?php $tipoAreaInscripcion=CJSON::encode($tipoAreaInscripcion);?>
    <td style="border:1px solid #003">boton</td>
	</tr>
</table>
<?php
$boton=CHtml::ajaxSubmitButton (
						'CargarAsistencia',   
						array('asistencia/regAsistencia'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnFormRegAsist").hide();Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="\'exito\'"){
										$("#MensajeAsist").text("Asistencia registrada satisfactoriamente");
										$("#Asistencia_areaAsistencia_em_").html("");                                                    
										$("#Asistencia_areaAsistencia_em_").hide();
										    
									}
									else{
										$("#MensajeAsist").text("Ha habido un error en la creación del registro. Código del error: "+datosRef.resultado);
										$("#formularioAsist #formularioAsist_es_").html("");                                                    
										//$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
									}
								}
								else{						
									$("#btnFormRegAsist").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datos, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioAsist #"+key+"_em_").text(val);                                                    
										$("#formularioAsist #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioAsist #formularioAsist_es_").html(errores);                                                    
									$("#formularioAsist #formularioAsist_es_").show(); 
								}
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#MensajeAsist").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormRef").show();
								}
								else{
									if(xhr.status==500){
										$("#MensajeAsist").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
									}
									else{
										$("#MensajeAsist").html("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
								
							}'
						),
						array('id'=>'btnFormRegAsist','name'=>'btnFormRegAsist','class'=>'btn btn-default btn-sdis',)
				);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?><?php //echo CHtml::endForm(); ?>
        <?php $this->endWidget();?>     
    </fieldset>

</div>
        <?php
	Yii::app()->getClientScript()->registerScript('scripAsist_1','
		function agregaAdol(numDoc,nombreAdol){
			var areaPres=jQuery.parseJSON('.CJavaScript::encode($areaPresc).');
			var tipoAreaInscripcion=jQuery.parseJSON('.CJavaScript::encode($tipoAreaInscripcion).');
			var areaInscripcion=jQuery.parseJSON('.CJavaScript::encode($areaInscripcion).');				
			var registro="<tr id=\""+numDoc+"\"><td style=\"border:1px solid #003\">"+nombreAdol+"</td>";
			$.each(areaPres,function(key,val){
				registro+="<td style=\"border:1px solid #003\"><input id=\""+numDoc+"\" type=\"checkbox\" value=\""+val.id_areapresencial+"\" name=\""+numDoc+"[arPr_"+val.id_areapresencial+"]\"></td>";
				//$("#listaAdolescentes").append("<div id=\""+val.id_areapresencial+"\">"+val.id_areapresencial+" "+val.area_presencial+"</div>");
			});
			$.each(tipoAreaInscripcion,function(key,val){
				registro+="<td style=\"border:1px solid #003\"><select id=\"areaInteres_"+val.id_areainscr+"_"+numDoc+"\" name=\""+numDoc+"[areaInteres_"+val.id_areainscr+"]\">";
				registro+="<option value=\"\">Seleccione</option>";
				$.each(areaInscripcion,function(keyA,valA){
						
					if(valA.id_areainscr==val.id_areainscr){
						registro+="<option value=\""+valA.id_areainteres+"\">"+valA.area_interes+"</option>";
					}
				});
				registro+="</select></td>";
				//$("#listaAdolescentes").append("<div id=\""+val.id_areapresencial+"\">"+val.id_areainscr+" "+val.area_inscr+"</div>");
			});
			registro+="<td style=\"border:1px solid #003\"><input type=\"button\" onclick=\"javascript:quitaRegistro(\'"+numDoc+"\');\" value=\"Quitar\"/></td>";
			registro=registro+"</tr>";
			$("#listaAdolescentes table").append(registro);
			$("#search_term_").val("");
		};
		function quitaRegistro(idTr){
			$("#"+idTr).remove();				
		}    
	'
	,CClientScript::POS_END);
?>