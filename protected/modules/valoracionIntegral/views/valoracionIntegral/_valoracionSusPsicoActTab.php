<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="formValSPA">
<div id="MensajeConsSPA" style="font-size:14px;" ></div>
<?php 
//echo $modeloValPsicol->consumo_spa;
/* $this->widget('application.extensions.magnific-popup.EMagnificPopup', array('target' => '.test-popup-link'));*/
?>
<fieldset>
<div class="panel-heading color-sdis">SUSTANCIAS PSICOACTIVAS</div> 
<label class="control-label" for="radios">¿El adolescente ha consumido sustancias psicoactivas?</label><br />
         <label class="radio-inline" for="radios-0">
			<?php	
				$siConsume=false;
				$noConsume=false;
				if($modeloValPsicol->consumo_spa=="1"){$siConsume=true;}else{$noConsume=true;}
					?>
            		Si<?php echo CHtml::radioButton('verifCons',$siConsume,array('id'=>'siConsume','value'=>"true",'onclick'=>'js:modConsSpa()'));
					?>
            </label>
            <label class="radio-inline" for="radios-0">
            No<?php echo CHtml::radioButton('verifCons',$noConsume,array('id'=>'noConsume','value'=>"false",'onclick'=>'js:modConsSpa()'));			
			?>
    		</label>
</fieldset>
<br />
<fieldset id="sustCons">

<label class="control-label">Sustancias psicoactivas que ha consumido</label>
<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="consumoSpaTab"><tr>
	<td style=" border:1px solid #000; width:10%">No.</td>
    <td style=" border:1px solid #000;width:10%">Tipo SPA</td>
    <td style=" border:1px solid #000;width:10%">Frecuencia Uso</td>
    <td style=" border:1px solid #000;width:10%">¿La ha consumido durante el último año?</td>
    <td style=" border:1px solid #000;width:10%">Vía de administración más frecuente</td>
    <td style=" border:1px solid #000;width:10%">Edad en la cual la usó por primera vez</td>
    <td style=" border:1px solid #000;width:10%">Edad en la que dejó de consumirla</td>
    <td style=" border:1px solid #000;width:10%">¿SPA de mayor impacto?</td>
    <td style=" border:1px solid #000;width:20%">Motivos/Circunstancias asociadas al inicio del consumo</td>
    <td style=" border:1px solid #000;width:10%"></td>
</tr>
	<?php
		//$consConsumoSPA[]=array('1'=>'1');$consDelitoVinc[]=array('1'=>'1');
	 if(!empty($consConsumoSPA)):?>
    	
		<?php  foreach($consConsumoSPA as $pk=>$consConsumoSPA): $pk+=1; //revisar?>
			<tr>
            	<td style=" border:1px solid #000; width:10%">
					<?php
					if($consConsumoSPA["droga_inicio"]==1){
						echo "SPA inicio";	
						$consConsumoSPA["droga_inicio"]=true;
					}
					else{
						echo $pk;	
						$consConsumoSPA["droga_inicio"]=false;
					}?>
                   </td>
                   <td style=" border:1px solid #000; width:10%">
                   <?php
                        $op[$consConsumoSPA["id_tipo_droga"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('tipoSpa_'.$pk,'tipoSpa_'.$pk,CHtml::listData($tipoSpa,'id_tipo_droga','nombre_droga'),
                     		array(
								'prompt'=>'Seleccione SPA',
                       	 		'options' => $op,
								'style'=>'width:100%'
                       		)
                    	);
						$op="";
					?>               
               </td>
               <td style=" border:1px solid #000; width:10%">
                   <?php
                        $opFrecUso[$consConsumoSPA["id_frecuencia_uso"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('frecUso_'.$pk,'frecUso_'.$pk,CHtml::listData($frecUso,'id_frecuencia_uso','frecuencia_uso'),
                     		array(
								'prompt'=>'Seleccione frecuencia de uso',
                       	 		'options' => $opFrecUso,
								'style'=>'width:100%'
                       		)
                    	);
						$opFrecUso="";
					?>               
               </td>
               <td style=" border:1px solid #000; width:20%">
					<?php 
                        if($consConsumoSPA["consumo_ult_anio"]==1){$consConsumoSPA["consumo_ult_anio"]=true;}else{$consConsumoSPA["consumo_ult_anio"]=false;}
                            echo CHtml::CheckBox('consUltAnio_'.$pk,$consConsumoSPA["consumo_ult_anio"], array (
                                'value'=>'true'
                         )); 
                    ?> Si
            	</td>
               <td style=" border:1px solid #000; width:10%">
                    <?php 
						$modeloValPsicol->idSPACons=$consConsumoSPA["id_tipo_conspa"];
						$viaAdmonAdol=$modeloValPsicol->consultaViasAdmonAdol();
							foreach($viaAdmonAdol as $viaAdmonAdol){//revisar
								$opViaAdomon[$viaAdmonAdol["id_viaadmon_spa"]]=array('selected'=>true);
							}                  
						echo CHtml::dropDownList('viaAdmon_'.$pk,'viaAdmon_'.$pk,CHtml::listData($viaAdmon,'id_viaadmon_spa','viaadmon_spa'),
                     		array(
                       	 		'options' => $opViaAdomon,
								'style'=>'width:100%',
								'multiple'=>'multiple'
                       		)
                    	);
						$opViaAdomon="";
					?>   
                </td>
                <td style=" border:1px solid #000; width:10%">
                	<?php
						echo CHtml::textField('edadIni_'.$pk,$consConsumoSPA["edad_inicio_cons"],array('style'=>'width:80%'));
					?>
                </td>
                <td style=" border:1px solid #000; width:10%">
                	<?php
						echo CHtml::textField('edadFin_'.$pk,$consConsumoSPA["edad_fin_cons"],array('style'=>'width:80%'));
					?>
                </td>
                <td style=" border:1px solid #000; width:10%">
                	<?php
						if($consConsumoSPA["droga_mayor_impacto"]==1){$consConsumoSPA["droga_mayor_impacto"]=true;}else{$consConsumoSPA["droga_mayor_impacto"]=false;}
						echo CHtml::RadioButton('spaMayImp',$consConsumoSPA["droga_mayor_impacto"],array('id'=>'spaMayImp_'.$pk));
					?>
                </td>
                 <td style=" border:1px solid #000; width:10%">
                	<?php
						echo CHtml::textArea('motivoCons_'.$pk,$consConsumoSPA["motivo_inicio_cons"]);
					?>
                </td>
                <td style=" border:1px solid #000; width:15%">
               <?php 
			   		echo CHtml::hiddenField('idSpaCons_'.$pk,$consConsumoSPA["id_tipo_conspa"]);
					if($consConsumoSPA["droga_inicio"]==1){$consConsumoSPA["droga_inicio"]="true";}else{$consConsumoSPA["droga_inicio"]="false";}
					echo CHtml::hiddenField('spaInicio_'.$pk,$consConsumoSPA["droga_inicio"]);
			   		echo CHtml::Button (
						'Modificar',   
						array('id'=>'btnCreaSpa_'.$pk,'name'=>'btnCreaSpa_'.$pk,'onclick'=>'js:modificaConsSPA('.$pk.')')
					);
					echo Chtml::hiddenField('numSpaCons',$pk);
                ?>
                
                </td>
			</tr>
		<?php endforeach;?>	
      <?php endif;?>
</table>
<?php $fromBtnAgregaSpa=$this->beginWidget('CActiveForm', array(
	'id'=>'fromBtnAgregaSpa',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<div class="form-group">
    <div class="col-md-4">	
        <?php
        if(empty($pk)){$pk=0;}
        echo Chtml::hiddenField('numSpaConsGen',$pk);
        echo CHtml::Button('Agregar SPA',
            array('id'=>'btnAgregaSPA','class'=>'btn btn-default btn-sdis','name'=>'btnAgregaSPA','onclick'=>'js:agregaSPA()')
        );
        ?>
    </div>
</div>
<?php $this->endWidget();?>
</fieldset>
<hr />

<fieldset id="patronCons">
<?php $formPatCons=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioPatCons',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
    <div class="form-group">
    	<div class="col-md-12">
          	<label class="control-label" for="radios">PATRÓN DE CONSUMO</label><code data-toggle="tooltip" title='Se describen las variaciones identificadas en la historia de consumo respecto a sustancias, dosis, frecuencia, vías, mezclas, rituales de consumo, transiciones y demás aspectos que resulten significativos en dicha historia de consumo.'>Ayuda</code>
			<div class="radio">
				<?php 
                    $selOpt=false;
                    foreach($patronCons as $patronCons){//revisar
                        if($modeloValPsicol->id_patron_consumo==$patronCons["id_patron_consumo"]){$selOpt=true;}
                        echo CHtml::radioButton('ValoracionPsicologia[id_patron_consumo]',
                            $selOpt,array('id'=>'ValoracionPsicologia_id_patron_consumo_'.$patronCons["id_patron_consumo"],
                            'onclick'=>'js:$("#patronCons").addClass("has-warning");enviaFormOpt("formularioPatCons","patronCons")',
                            'value'=>$patronCons["id_patron_consumo"]
                            )				
                        )."".$patronCons["patron_consumo"]."<br/>";
                        $selOpt=false;
                    }
                ?>
   			</div>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-12">

	<?php echo $formPatCons->textArea($modeloValPsicol,
		'patron_consumo_desc',
		array('class'=>'form-control',
		'onblur'=>'js:enviaFormOpt("formularioPatCons","patronCons")',
		'onkeyup'=>'js:$("#patronCons").addClass("has-warning");'));
	?>
    
	<?php echo $formPatCons->error($modeloValPsicol,'patron_consumo_desc',array('style' => 'color:#F00'));?>
    </div>
    </div>
    
   	<div class="form-group">
        <div class="col-md-4">	

<?php
$boton=CHtml::Button (
		'Registrar',   
		array('id'=>'btnFormPatCons','class'=>'btn btn-default btn-sdis','name'=>'btnFormPatCons','onclick'=>'js:enviaFormOpt("formularioPatCons","patronCons")')
);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
   		</div>
    </div>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="examenToxic">
<?php $formExamenToxic=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioExamenToxic',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<div class="form-group">
    <div class="col-md-12">
    <label class="control-label" for="radios">¿El adolescente realizó el examen toxicológico?</label><br />
        <label class="radio-inline" for="radios-0">
        <?php	
            $siRealizado=false;
            $noRealizado=false;
            if($modeloValPsicol->examen_toxic=="t"){$siRealizado=true;}elseif($modeloValPsicol->examen_toxic=="f"){$noRealizado=true;}
                ?>
                Si<?php echo CHtml::radioButton('ValoracionPsicologia[examen_toxic]',$siRealizado,array('id'=>'ValoracionPsicologia_examen_toxic','value'=>"true",'onclick'=>'js:$("#examenToxic").addClass("has-warning");enviaFormOpt("formularioExamenToxic","examenToxic")'));
                ?>
        </label>
        <label class="radio-inline" for="radios-0">
        No<?php echo CHtml::radioButton('ValoracionPsicologia[examen_toxic]',$noRealizado,array('id'=>'ValoracionPsicologia_examen_toxic','value'=>"false",'onclick'=>'js:$("#examenToxic").addClass("has-warning");enviaFormOpt("formularioExamenToxic","examenToxic")'));			
        ?>
        </label>
    </div>
</div>
    <div class="form-group">
    	<div class="col-md-12">

	<?php echo $formExamenToxic->textArea($modeloValPsicol,
		'resultado_examtox',
		array('class'=>'form-control',
		'onblur'=>'js:enviaFormOpt("formularioExamenToxic","examenToxic")',
		'onkeyup'=>'js:$("#examenToxic").addClass("has-warning")'));
	?>
    
	<?php echo $formExamenToxic->error($modeloValPsicol,'resultado_examtox',array('style' => 'color:#F00'));?>
    </div>
    </div>
   	<div class="form-group">
        <div class="col-md-4">	
<?php
		$boton=CHtml::Button (
			'Registrar',   
			array('id'=>'btnFormExamenToxic','class'=>'btn btn-default btn-sdis','name'=>'btnFormExamenToxic','onclick'=>'js:enviaFormOpt("formularioExamenToxic","examenToxic")')
		);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
    </div>   
 </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="ultEpCons">
<?php $formUltEpCons=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioUltEpCons',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
    <div class="form-group">
    	<div class="col-md-12">
        	<?php echo $formUltEpCons->labelEx($modeloValPsicol,'ultimo_ep_cons',array('class'=>'control-label','for'=>'searchinput'));?><code data-toggle="tooltip" title='Se identifica cuándo se dió el último episodio de consumo, en días, semanas, meses o años.'>Ayuda</code>
			<?php echo $formUltEpCons->textArea($modeloValPsicol,'ultimo_ep_cons',array('class'=>'form-control',
            'onblur'=>'js:enviaForm("formularioUltEpCons","ultEpCons")',
            'onkeyup'=>'js:$("#ultEpCons").addClass("has-warning")'));?>
			<?php echo $formUltEpCons->error($modeloValPsicol,'ultimo_ep_cons',array('style' => 'color:#F00'));?>
    	</div>
	</div>
	<div class="form-group">
        <div class="col-md-4">	
		<?php
			$boton=CHtml::Button (
				'Registrar',   
				array('id'=>'btnFormUltEpCons','class'=>'btn btn-default btn-sdis','name'=>'btnFormUltEpCons','onclick'=>'js:enviaForm("formularioUltEpCons","btnFormUltEpCons")')
			);
    	?>
    	<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
	</div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="intPrevCons">
<?php $formIntPrevMCons=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioIntPrevMCons',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="form-group">
    	<div class="col-md-12">
        	<?php echo $formIntPrevMCons->labelEx($modeloValPsicol,'interv_prev_spa',array('class'=>'control-label','for'=>'searchinput'));?><code data-toggle="tooltip" title='Se hace el registro de atenciones previas o intervenciones especializadas o específicas para el consumo, en términos de procesos de desintoxicación, deshabituación, estrategias para autoregulación del consumo o reducción de daños o procesos de rehabilitación.'>Ayuda</code>
			<?php echo $formIntPrevMCons->textArea($modeloValPsicol,
            'interv_prev_spa',
            array('class'=>'form-control',
            'onblur'=>'js:enviaForm("formularioIntPrevMCons","btnFormIntPrevMCons")',
            'onkeyup'=>'js:$("#btnFormIntPrevMCons").css("color","#F00")'));?>
            <?php echo $formIntPrevMCons->error($modeloValPsicol,'btnFormIntPrevMCons',array('style' => 'color:#F00'));?>
   		</div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
<?php
	$boton=CHtml::Button (
		'Registrar',   
		array('id'=>'btnFormIntPrevMCons','class'=>'btn btn-default btn-sdis','name'=>'btnFormIntPrevMCons','onclick'=>'js:enviaForm("formularioIntPrevMCons","btnFormIntPrevMCons")')
	);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<?php 
	//echo CHtml::hiddenField('idValPsicol',$idValPsicol);
	//echo CHtml::hiddenField('numDocAdolValPsicol',$numDocAdol);
?>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scripVapsic_2','
	
		$(document).ready(function(){
		$("#formValSPA").find(":input").change(function(){
  var dirtyForm = $(this).parents("form");
  // change form status to dirty
  dirtyForm.addClass("unsavedForm");
});});	
function enviaFormOpt(nombreForm,btnForm){
	//alert($("#numDocAdolValPsicol").val());return;
	var nameInput=$("#"+nombreForm+" input:first").attr("name");
		//jAlert($("#"+nombreForm+" input:radio:checked").val());return;
		if(!$("#"+nombreForm+" input:radio:checked").is(":empty")){
			jAlert("Debe seleccionar una opción");return;
			$("#"+nombreForm).removeClass("unsavedForm");
		}
		if($("#"+nombreForm+" textarea.form-control:first").val().length==0){
			var valPas="";
			if(nameInput=="ValoracionPsicologia[id_estado_val]" && $("#"+nombreForm+" input:radio:checked").val()==1){
				valPas=false;
			}
			else{
				valPas=true
			}
			if(valPas){
				jAlert("Debe realizar una justificación de la selección de la opción");
				$("#"+nombreForm).removeClass("unsavedForm");								
				return;	
			}
		}
		
	//alert($("#"+nombreForm).serialize());return;
			$.ajax({
				url: "modificaValoracionPsicolOpt",
				data:$("#"+nombreForm).serialize()+"&idValPsicol="+$("#idValPsicol").val()+"&numDocAdolValPsicol="+$("#numDocAdolValPsicol").val(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){
						
						if(datos.resultado=="\'exito\'"){
							$("#"+nombreForm).removeClass("unsavedForm");
							$("#"+btnForm).removeClass("has-warning");
							$("#MensajeConsSPA").text("exito");
						}
						else{
							$("#MensajeConsSPA").text("Error en la creación del registro.  Motivo "+datos.resultado);
						}
					}
					else{
						$("#MensajeConsSPA").text("no exito");
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					Loading.hide();
					//0 para error en comunicación
					//200 error en lenguaje o motor de base de datos
					//500 Internal server error
					if(xhr.status==0){
						$("#MensajeConsSPA").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
					}
					else{
						if(xhr.status==500){
							$("#MensajeConsSPA").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información.  El error es el siguiente: "+xhr.responseText);
						}
						else{
							$("#MensajeConsSPA").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
						}	
					}	
				}
			});
		}		
		
		
	function agregaSPA(){
		numSPA= parseInt($("#numSpaConsGen").val());
		numSPA+=1;
		if(numSPA==1){
			var spa="SPA de inicio";
			var spaIni="true";
		}
		else{
			var spa=numSPA;
			var spaIni="false";
		}
		var agregaReg="<tr id=\'"+numSPA+"\'><td style=\"border:1px solid #000;\">"+spa+"</td>";
		agregaReg=agregaReg+"<td style=\"border:1px solid #000;\">";
		agregaReg=agregaReg+"<select id=\'tipoSpa_"+numSPA+"\' style=\'width:100%\'></select>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td style=\"border:1px solid #000;\">";
		agregaReg=agregaReg+"<select id=\"frecUso_"+numSPA+"\" style=\"width:100%\"></select>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td style=\"border:1px solid #000;\">";
		agregaReg=agregaReg+"<input id=\"consUltAnio_"+numSPA+"\" type=\"checkbox\"  value=\"true\">Si";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td style=\"border:1px solid #000;\">";
		agregaReg=agregaReg+"<select id=\"viaAdmon_"+numSPA+"\" multiple=\"multiple\" style=\"width:100%\"></select>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td style=\"border:1px solid #000;\">";
		agregaReg=agregaReg+"<input id=\"edadIni_"+numSPA+"\" type=\"text\" style=\"width:80%\">";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td style=\"border:1px solid #000;\">";
		agregaReg=agregaReg+"<input id=\"edadFin_"+numSPA+"\" type=\"text\" style=\"width:80%\">";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td style=\"border:1px solid #000;\">";
		agregaReg=agregaReg+"<input id=\"spaMayImp_"+numSPA+"\" type=\"radio\" name=\"spaMayImp\" value=\"1\">";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td style=\"border:1px solid #000;\">";
		agregaReg=agregaReg+"<textarea id=\"motivoCons_"+numSPA+"\"></textarea>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td style=\"border:1px solid #000;\">";
		agregaReg=agregaReg+"<input type=\'button\' onclick=\'js:quitaSPA("+numSPA+")\' id=\'btnQuitaSPA_"+numSPA+"\' value=\'Quitar SPA\'>";
		agregaReg=agregaReg+"<input type=\'button\' onclick=\'javascript:creaConsSPA("+numSPA+")\'";
		agregaReg=agregaReg+"style=\'padding:0px 0px 0px 0px; margin:0px 0px 0px 0px;\' id=\'btnCreaSpa_"+numSPA+"\' value=\'Crear Registro\'>";
		agregaReg=agregaReg+"<input type=\'hidden\' id=\'idSpaCons_"+numSPA+"\'>";
		agregaReg=agregaReg+"<input id=\'spaInicio_"+numSPA+"\' type=\'hidden\' value=\'"+spaIni+"\'>";
		agregaReg=agregaReg+"</td></tr>";
		$("#numSpaConsGen").val(numSPA);
		cargaDatosSelect("tipo_droga","id_tipo_droga","nombre_droga","","tipoSpa_"+numSPA,"consumoSpaTab");
		cargaDatosSelect("frecuencia_uso","id_frecuencia_uso","frecuencia_uso","","frecUso_"+numSPA,"consumoSpaTab");
		cargaDatosSelect("via_admon_spa","id_viaadmon_spa","viaadmon_spa","","viaAdmon_"+numSPA,"vincPrevSrpaTable");
		$("#consumoSpaTab").append(agregaReg);
		$("#btnAgregaSPA").attr("disabled",true);
		$("#btnAgregaSPA").hide();
	}
	function quitaSPA(numSPA){
		numSPAAct= parseInt($("#numSpaConsGen").val());
		$("#consumoSpaTab #"+numSPA).remove();
		numSPAAct -=1;
		$("#numSpaConsGen").val(numSPAAct);
		$("#btnAgregaSPA").attr("disabled",false);
		$("#btnAgregaSPA").show();
	}
	function modConsSpa(){
		//alert($("#idValPsicol").val());
		//alert($("input[name=verifCons]:checked").val())
		if($("input[name=verifCons]:checked").val()=="true"){
			$("#sustCons").show();	
		}
		else{
			$("#sustCons").hide();	
		}
		$.ajax({
			url: "modConsSpa",			
			data:"consSpa="+$("input[name=verifCons]:checked").val()+"&idValPsic="+$("#idValPsicol").val()+"&numDocAdolValPsicol="+$("#numDocAdolValPsicol").val(),
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				//$("#"+btnForm).removeClass("has-warning");
				if(datos.estadoComu=="exito"){
					if(datos.resultado="\'exito\'"){
						$("#MensajeConsSPA").text("Estado del consumo modificado satisfactoriamente");
					}
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#MensajeConsSPA").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#MensajeConsSPA").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#MensajeConsSPA").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});
	}
	function creaConsSPA(numSPA){
		var SPA=$("#tipoSpa_"+numSPA+" option:selected").val();
		var frecUso=$("#frecUso_"+numSPA+" option:selected").val();
		var consAnio=$("input:checkbox[id=consUltAnio_"+numSPA+"]");
		var viaAdmon=$("#viaAdmon_"+numSPA+" option:selected");
		var edadIni=$("#edadIni_"+numSPA).val();
		var edadFin=$("#edadFin_"+numSPA).val();
		var spaMayImp=$("input:radio[id=spaMayImp_"+numSPA+"]");
		var motivoConsSPA=$("#motivoCons_"+numSPA).val();
		var spaInicio=$("#spaInicio_"+numSPA).val();
		var viaAdminSpa=new Array();
		$i=0;
		viaAdmon.each(function() {
			viaAdminSpa[$i]= $(this).val();
			$i++;
		});
		if(!$.isNumeric(edadIni)){
			alert("debe digitar solo números en la edad");
			return;
		}
		if(edadFin.length!=0 && !$.isNumeric(edadFin)){
			alert("debe digitar solo números en la edad");
			return;
		}
		if(SPA.length==0||frecUso.length==0||viaAdmon.length==0||edadIni.length==0||motivoConsSPA.length==0){
			alert("falta algún campo por diligenciar");
			return;
		}
		var datosCreaSpa="spa="+SPA+"&frecUso="+frecUso+"&consAnio="+consAnio.is(":checked")+"&viaAdmon="+viaAdminSpa+"&edadIni="+edadIni+"&edadFin="+edadFin;
		datosCreaSpa+="&spaMayImp="+spaMayImp.is(":checked")+"&motivoConsSPA="+motivoConsSPA+"&spaInicio="+spaInicio;
		datosCreaSpa+="&idValPsicol="+$("#idValPsicol").val()+"&numDocAdolValPsicol="+$("#numDocAdolValPsicol").val()
		$.ajax({
			url: "creaConsSpa",			
			data:datosCreaSpa,
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				//$("#"+btnForm).css("color","#000");
				if(datos.estadoComu=="exito"){
					if(datos.resultado="\'exito\'"){
						$("#MensajeConsSPA").text(datos.resultado);
						$("#btnQuitaSPA_"+numSPA).remove();
						$("#btnCreaSpa_"+numSPA).attr( "value","Modificar");
						$("#btnCreaSpa_"+numSPA).removeAttr( "onclick");
						$("#btnCreaSpa_"+numSPA).bind( "click", function() {
							modificaConsSPA(numSPA);
						});
						$("#idSpaCons_"+numSPA).val(datos.idConsSpa);
						$("#btnAgregaSPA").show();
					}
					else{
						$("#MensajeConsSPA").text(datos.resultado);
					}
				}
				else{
					$("#MensajeConsSPA").text("no exito");
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#MensajeConsSPA").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#MensajeConsSPA").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#MensajeConsSPA").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});		
	}
	function modificaConsSPA(numSPA){
		var SPA=$("#tipoSpa_"+numSPA+" option:selected").val();
		var frecUso=$("#frecUso_"+numSPA+" option:selected").val();
		var consAnio=$("input:checkbox[id=consUltAnio_"+numSPA+"]");
		var viaAdmon=$("#viaAdmon_"+numSPA+" option:selected");
		var edadIni=$("#edadIni_"+numSPA).val();
		var edadFin=$("#edadFin_"+numSPA).val();
		var spaMayImp=$("input:radio[id=spaMayImp_"+numSPA+"]");
		var motivoConsSPA=$("#motivoCons_"+numSPA).val();
		var idSpaCons=$("#idSpaCons_"+numSPA).val();
		var viaAdminSpa=new Array();
		$i=0;
		viaAdmon.each(function() {
			viaAdminSpa[$i]= $(this).val();
			$i++;
		});
		if(!$.isNumeric(edadIni)){
			alert("debe digitar solo números en la edad");
			return;
		}
		if(edadFin.length!=0 && !$.isNumeric(edadFin)){
			alert("debe digitar solo números en la edad");
			return;
		}
		if(SPA.length==0||frecUso.length==0||viaAdmon.length==0||edadIni.length==0||motivoConsSPA.length==0){
			alert("falta algún campo por diligenciar");
		}
		var datosCreaSpa="spa="+SPA+"&frecUso="+frecUso+"&consAnio="+consAnio.is(":checked")+"&viaAdmon="+viaAdminSpa+"&edadIni="+edadIni+"&edadFin="+edadFin;
		datosCreaSpa+="&spaMayImp="+spaMayImp.is(":checked")+"&motivoConsSPA="+motivoConsSPA+"&idSpaCons="+idSpaCons;
		datosCreaSpa+="&idValPsicol="+$("#idValPsicol").val()+"&numDocAdolValPsicol="+$("#numDocAdolValPsicol").val()
		$.ajax({
			url: "modificaConsSPA",			
			data:datosCreaSpa,
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				//$("#"+btnForm).css("color","#000");
				if(datos.estadoComu=="exito"){
					$("#MensajeConsSPA").text("exito");
				}
				else{
					$("#MensajeConsSPA").text("no exito");
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#MensajeConsSPA").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#MensajeConsSPA").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#MensajeConsSPA").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});		
	}
	var consumoSPA="'.$modeloValPsicol->consumo_spa.'";
	if(consumoSPA!=1){
		$("#sustCons").hide();
	}
'
,CClientScript::POS_END);
?>
