<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="divFormEscTrSoc">
<div id="MensajeEsc" style="font-size:14px;" ></div>
<?php 

/* $this->widget('application.extensions.magnific-popup.EMagnificPopup', array('target' => '.test-popup-link'));*/
?>
<fieldset>
<div class="panel-heading color-sdis">Historia Escolar</div> 
<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="datosEscAdolTab">
<tr>
	<td style=" border:1px solid #000; width:15%">Grado</td>
    <td style=" border:1px solid #000;width:15%">Año</td>
    <td style=" border:1px solid #000;width:10%">Institución educativa</td>
    <td style=" border:1px solid #000;width:10%">Ciudad</td>
    <td style=" border:1px solid #000;width:10%">Jornada</td>
    <td style=" border:1px solid #000;width:10%"></td>
</tr>
<?php
	//$escolaridadAdol=array('id'=>1);
	if(!empty($escolaridadAdol)):?>
		<?php foreach($escolaridadAdol as $pk=>$escolaridadAdol): $pk+=1;	?>
			<tr id="<?php echo $pk;?>">
            	<td style=" border:1px solid #000;width:15%">
					<?php
                        $opGradoEsc[$escolaridadAdol["id_nivel_educ"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('nivel_ed_adol_'.$pk,'nivel_es_adol_'.$pk,CHtml::listData($nivelEduc,'id_nivel_educ','nivel_educ'),
                     		array(
								'prompt'=>'Seleccione nivel educativo',
                       	 		'options' => $opGradoEsc,
								'style'=>'width:100%'
                       		)
                    	);
						$opGradoEsc="";
					?>                                     
                </td>
                <td style=" border:1px solid #000;width:15%"><?php echo CHtml::textField('anio_es_adol_'.$pk,$escolaridadAdol["anio_escolaridad"]); ?></td>
                <td style=" border:1px solid #000;width:10%"><?php echo CHtml::textField('inst_es_adol_'.$pk,$escolaridadAdol["instituto_escolaridad"]); ?></td>
                <td style=" border:1px solid #000;width:10%">
                	<?php
                        $opMunEsc[$escolaridadAdol["id_municipio"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('mun_es_adol_'.$pk,'mun_es_adol_'.$pk,CHtml::listData($munCiudad,'id_municipio','municipio'),
                     		array(
								'prompt'=>'Seleccione Municipio',
                       	 		'options' => $opMunEsc,
								'style'=>'width:100%'
                       		)
                    	);
						$opMunEsc="";
					?>      
                </td>
                <td style=" border:1px solid #000;width:10%">
                	<?php
                        $opJornada[$escolaridadAdol["id_jornada_educ"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('jor_es_adol_'.$pk,'jor_es_adol_'.$pk,CHtml::listData($jornadaEduc,'id_jornada_educ','jornada_educ'),
                     		array(
								'prompt'=>'Seleccione Jornada',
                       	 		'options' => $opJornada,
								'style'=>'width:100%'
                       		)
                    	);
						$opJornada="";
					?>      
                </td>                            
                <td>
                	<?php 
                        echo CHtml::hiddenField('id_es_adol_'.$pk,$escolaridadAdol["id_escolaridad"]);
                        echo CHtml::Button (
                            'Modificar',   
                            array('id'=>'btn_es_adol_'.$pk,'name'=>'btn_es_adol_'.$pk,'onclick'=>'js:modificaEscAdol('.$pk.')')
                        );
                        echo Chtml::hiddenField('numEscAdol',$pk);
                    ?>
                </td>
              </tr>
		<?php endforeach;?>
	<?php endif; ?>
</table>
<?php
if(empty($pk)){$pk=0;}
echo Chtml::hiddenField('numEscAdolGen',$pk);
echo CHtml::Button('Agregar Registro',
	array('id'=>'btnAgregaEscAdol','class'=>'btn btn-default btn-sdis','name'=>'btnAgregaEscAdol','onclick'=>'js:agregaRegEscAdol()')
);
?>
</fieldset>
<hr />
<fieldset id="histEscolar">
<?php $formHistEsc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioHistEsc',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formHistEsc->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="form-group">
    	<div class="col-md-12">
       		<?php echo $formHistEsc->labelEx($modelValTrSoc,'dr_hist_escolar',array('class'=>'control-label','for'=>'searchinput'));?>
     		<code data-toggle="tooltip" title='Tener en cuenta los avances académicos obtenidos, fracasos escolares en caso de haberse presentado, dificultades para acceso al sistema escolar y deserción escolar. '>Ayuda</code>       
			<?php echo $formHistEsc->textArea($modelValTrSoc,
                'dr_hist_escolar',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioHistEsc","histEscolar")',
                    'onkeyup'=>'js:$("#histEscolar").addClass("has-warning")'
                ));
            ?>
            <?php echo $formHistEsc->error($modelValTrSoc,'dr_hist_escolar',array('style' => 'color:#F00'));?>
        </div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormHistEsc','class'=>'btn btn-default btn-sdis','name'=>'btnFormHistEsc','onclick'=>'js:enviaForm("formularioHistEsc","btnFormHistEsc")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />

</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scripValTrSoc_2','
	$(document).ready(function(){
		$("#divFormEscTrSoc").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
	});
	$("#datosEscAdolTab tr").find(":input").change(function(){
		var dirtyForm = $(this).parents("tr");
		// change form status to dirty
		dirtyForm.addClass("unsavedForm");
	});
	function agregaRegEscAdol(){
		numEscAdol= parseInt($("#numEscAdolGen").val());
		numEscAdol=numEscAdol+1;
		var agregaReg="<tr id=\'"+numEscAdol+"\'>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:15%\'>";
		agregaReg=agregaReg+"<select id=\'nivel_ed_adol_"+numEscAdol+"\' style=\'width:100%\'>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:15%\'>";
		agregaReg=agregaReg+"<input id=\'anio_es_adol_"+numEscAdol+"\' type=\'text\' >";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:15%\'>";
		agregaReg=agregaReg+"<input id=\'inst_es_adol_"+numEscAdol+"\' type=\'text\'>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:15%\'>";
		agregaReg=agregaReg+"<select id=\'mun_es_adol_"+numEscAdol+"\' style=\'width:100%\'>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:15%\'>";
		agregaReg=agregaReg+"<select id=\'jor_es_adol_"+numEscAdol+"\' style=\'width:100%\'>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:15%\'>";
		agregaReg=agregaReg+"<input id=\'id_es_adol_"+numEscAdol+"\' type=\'hidden\'>";
		agregaReg=agregaReg+"<input type=\'button\' onclick=\'js:quitaRegEscAdol("+numEscAdol+")\' id=\'btnQuitaEsc_"+numEscAdol+"\' value=\'Quitar Registro\'>";
		agregaReg=agregaReg+"<input type=\'button\' onclick=\'javascript:creaRegEscAdol("+numEscAdol+")\'";
		agregaReg=agregaReg+"style=\'padding:0px 0px 0px 0px; margin:0px 0px 0px 0px;\' id=\'btnEsc_"+numEscAdol+"\' value=\'Crear Registro\'>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"</tr>";
		
		$("#numEscAdolGen").val(numEscAdol);
		cargaDatosSelect("nivel_educativo","id_nivel_educ","nivel_educ","","nivel_ed_adol_"+numEscAdol,"datosEscAdolTab");
		cargaDatosSelect("jornada_educ","id_jornada_educ","jornada_educ","","jor_es_adol_"+numEscAdol,"datosEscAdolTab");
		cargaDatosSelect("municipio","id_municipio","municipio","","mun_es_adol_"+numEscAdol,"datosEscAdolTab");
		$("#datosEscAdolTab").append(agregaReg);
		$("#btnAgregaEscAdol").attr("disabled",true);
		$("#datosEscAdolTab tr").find(":input").change(function(){
			var dirtyForm = $(this).parents("tr");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
	}
	function quitaRegEscAdol(numEscAdol){
		//numEscAdol= parseInt($("#numEscAdol").val());
		$("#datosEscAdolTab #"+numEscAdol).remove();
		numEscAdol -=1;
		$("#numEscAdolGen").val(numEscAdol);
		$("#btnAgregaEscAdol").attr("disabled",false);
	}
	function creaRegEscAdol(numEscAdol){
		var id_nivel_educ=$("#nivel_ed_adol_"+numEscAdol+" option:selected").val();
		var anio_escolaridad=$("#anio_es_adol_"+numEscAdol).val();
		var instituto_escolaridad=$("#inst_es_adol_"+numEscAdol).val();
		var id_municipio=$("#mun_es_adol_"+numEscAdol+" option:selected").val();
		var id_jornada_educ=$("#jor_es_adol_"+numEscAdol+" option:selected").val();
		if(!/^[0-9]*$/.test(anio_escolaridad)){
			alert("debe digitar solo números en la fecha");
			return;
		}
		if(id_nivel_educ.length==0 || anio_escolaridad.length==0 || instituto_escolaridad.length==0 ||  id_municipio.length==0 ||  id_jornada_educ.length==0){
			alert("Faltan por diligenciar datos");	
			return;
		}
		var datos="id_nivel_educ="+id_nivel_educ+"&anio_escolaridad="+anio_escolaridad+"&instituto_escolaridad="+instituto_escolaridad+"&id_municipio="+id_municipio;
		datos=datos+"&id_jornada_educ="+id_jornada_educ+"&numDocAdolValTrSoc="+$("#numDocAdolValTrSoc").val();
		$.ajax({
			url: "creaRegEscAdol",			
			data:datos,
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datosCreaEsc){
				Loading.hide();
				//$("#"+btnForm).css("color","#000");
				if(datosCreaEsc.estadoComu=="exito"){
					if(datosCreaEsc.resultado=="\'exito\'"){
						$("#MensajeEsc").text("exito");
						$("#btnQuitaEsc_"+numEscAdol).remove();
						$("#btnEsc_"+numEscAdol).attr( "value","Modificar");
						$("#btnEsc_"+numEscAdol).removeAttr( "onclick");
						$("#btnEsc_"+numEscAdol).bind( "click", function() {
							modificaEscAdol(numEscAdol);
						});
						$("#id_es_adol_"+numEscAdol).val(datosCreaEsc.idEsc);
						$("#btnAgregaEscAdol").attr("disabled",false);
						$("#"+numEscAdol).removeClass("unsavedForm");
					}
					else{
						$("#MensajeEsc").text("No se creó el registro debido al siguiente error: "+datosCreaEsc.resultado);
					}
				}
				else{
					$("#MensajeEsc").text("no exito");
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#MensajeEsc").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#MensajeEsc").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#MensajeEsc").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});
	}
	
	function modificaEscAdol(numEscAdol){
		var id_nivel_educ=$("#nivel_ed_adol_"+numEscAdol+" option:selected").val();
		var anio_escolaridad=$("#anio_es_adol_"+numEscAdol).val();
		var instituto_escolaridad=$("#inst_es_adol_"+numEscAdol).val();
		var id_municipio=$("#mun_es_adol_"+numEscAdol+" option:selected").val();
		var id_jornada_educ=$("#jor_es_adol_"+numEscAdol+" option:selected").val();
		var id_escolaridad=$("#id_es_adol_"+numEscAdol).val();
		if(!/^[0-9]*$/.test(anio_escolaridad)){
			alert("debe digitar solo números en la fecha");
			return;
		}
		if(id_nivel_educ.length==0 || anio_escolaridad.length==0 || instituto_escolaridad.length==0 ||  id_municipio.length==0 ||  id_jornada_educ.length==0){
			alert("Faltan por diligenciar datos");	
			return;
		}
		var datos="id_nivel_educ="+id_nivel_educ+"&anio_escolaridad="+anio_escolaridad+"&instituto_escolaridad="+instituto_escolaridad+"&id_municipio="+id_municipio;
		datos=datos+"&id_jornada_educ="+id_jornada_educ+"&id_escolaridad="+id_escolaridad;
		datos=datos+"&numDocAdolValTrSoc="+$("#numDocAdolValTrSoc").val();
		$.ajax({
			url: "modificaEscAdol",			
			data:datos,
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				//$("#"+btnForm).css("color","#000");
				if(datos.estadoComu=="exito"){
					if(datos.resultado=="\'exito\'"){
						$("#MensajeEsc").text("exito");
						$("#"+numEscAdol).removeClass("unsavedForm");
					}
					else{
						$("#MensajeEsc").text("error");
					}
					//$($("#vincPrevSrpaTable").find("tbody > tr")[numDel]).children("td")[3].innerHTML = agregaReg;
				}
				else{
					$("#MensajeEsc").text("no exito");
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#MensajeEsc").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#MensajeEsc").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#MensajeEsc").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});
	}
'
,CClientScript::POS_END);
?>
