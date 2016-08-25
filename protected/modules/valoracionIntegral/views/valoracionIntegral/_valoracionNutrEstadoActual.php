<div id="formNutrEstadoActual">
	<?php $formularioExamenFisico=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioExamenFisico',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
<code  onclick="js:muestraTablaExamen();" style="cursor:help">Ver tabla</code>
	<div id="divProcPadres" class="form-group">
    	<div class="col-sm-12">
            <?php echo $formularioExamenFisico->labelEx($modeloValNutr,'examen_fisico',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioExamenFisico->textArea($modeloValNutr,'examen_fisico',array('class'=>'form-control','onchange'=>'js:$("#formularioExamenFisico").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloValNutr,'examen_fisico',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Modificar',   
					array('id'=>'btnFormExamFis','class'=>'btn btn-default btn-sdis','name'=>'btnFormExamFis','onclick'=>'js:enviaFormNutr("formularioExamenFisico","formularioExamenFisico")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
	</div>    
   <?php $this->endWidget();?>
   <hr />
	<?php $formularioAntrValIni=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioAntrValIni',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
    <?php
		if(!empty($antropometriaAdol)){
			$modeloAntropometria->attributes=$antropometriaAdol;
			$modeloAntropometria->id_antropometria=$antropometriaAdol["id_antropometria"];
			$accion='modifAntropometriaValIni';
		}
		else{
			$accion='registraAntropometriaValIni';			
		}
	?>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'antr_peso_kgs',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'antr_peso_kgs',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");hallaImc();'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'antr_peso_kgs',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'antr_talla_cms',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'antr_talla_cms',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");hallaImc();'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'antr_talla_cms',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'antr_imc',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'antr_imc',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'antr_imc',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <hr />
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'antr_peso_ideal',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'antr_peso_ideal',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'antr_peso_ideal',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'antr_talla_ideal',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'antr_talla_ideal',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'antr_talla_ideal',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'antr_ind_p_t_imc_ed',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'antr_ind_p_t_imc_ed',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'antr_ind_p_t_imc_ed',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'indice_talla_edad',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'indice_talla_edad',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'indice_talla_edad',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
            <?php echo CHtml::label('','',array('class'=>'col-md-5 control-label','for'=>'searchinput'));	?>            
    	<div class="col-md-4">
        	<?php echo $formularioExamenFisico->hiddenField($modeloAntropometria,'id_antropometria',array('style' => 'color:#F00'));?>	
			<?php
				$boton=CHtml::Button (
					'Registrar',   
					array('id'=>'btnFormAntrMtria','class'=>'btn btn-default btn-sdis','name'=>'btnFormAntrMtria','onclick'=>'js:regAntropometria("formularioAntrValIni","formularioAntrValIni")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
	</div>    
   <?php $this->endWidget();?>
   <hr />
   
</div>
       <?php 
		$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
			'id'=>'juiDialogExam',
			'options'=>array(				
				'title'=>'Tabla examen físico',
				'autoOpen'=>false,
				'width'=>'60%',
				'show'=>array(
	                'effect'=>'blind',
	                'duration'=>500,
	            ),
				'hide'=>array(
					'effect'=>'explode',
					'duration'=>500,
				),				
			),
		));
		$this->endWidget('zii.widgets.jui.CJuiDialog');
	?>     
<?php
	Yii::app()->getClientScript()->registerScript('scriptTablaEstadoActual','		
		var accionAntrop="'.$accion.'";
	'
	,CClientScript::POS_BEGIN);
	Yii::app()->getClientScript()->registerScript('scriptTablaEstadoActual','		
	$(document).ready(function(){
		$("#formNutrEstadoActual").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
		$("#labExtr").hide();
	});

	function regAntropometria(nombreForm,nombreDiv){
		$("#"+nombreForm+" .errorMessage").text("");		
		//jAlert($("#"+nombreForm).serialize()+"&idValNutr="+$("#idValNutr").val()+"&numDocAdolValNutr="+$("#num_doc").val());return;
			$.ajax({
				url:accionAntrop,
				data:$("#"+nombreForm).serialize()+"&idValNutr="+$("#idValNutr").val()+"&numDocAdolValNutr="+$("#num_doc").val(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){
						//$("#"+btnForm).css("color","#000");
						if(datos.resultado=="exito"){
							jAlert("Registro exitoso","mensaje");
							$("#"+nombreForm+" .errorMessage").text("");
							$("#"+nombreForm).removeClass("has-warning");
							$("#"+nombreForm).removeClass("unsavedForm");
							//$("#btnFormAntrMtria").hide();
							$("#"+nombreForm+" #Antropometria_id_antropometria").val(datos.idNutricion);
							accionAntrop="modifAntropometriaValIni";
						}
						else{
							jAlert("Error en la creación del registro.  Motivo "+datos.resultado,"Mensaje");
						}
					}
					else{
						$.each(datos, function(key, val) {						                                                    						
							$("#"+nombreForm+" #"+key+"_em_").text(val);                                                    
							$("#"+nombreForm+" #"+key+"_em_").show();                                                
						});
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					Loading.hide();
					//0 para error en comunicación
					//200 error en lenguaje o motor de base de datos
					//500 Internal server error
					if(xhr.status==0){
						jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema","Mensaje");
					}
					else{
						if(xhr.status==500){
							jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información","Mensaje");
						}
						else{
							jAlert("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado","Mensaje");
						}	
					}	
				}
			});
		}
		function hallaImc(){
			$("#Antropometria_antr_imc").val("");
			if($("#Antropometria_antr_peso_kgs").val().length!=0 && $("#Antropometria_antr_talla_cms").val()!=0){
				if(!isNaN($("#Antropometria_antr_peso_kgs").val()) && !isNaN($("#Antropometria_antr_talla_cms").val())){
					var imc=0;
					var peso=0;
					var talla=0;					
					peso=$("#Antropometria_antr_peso_kgs").val();					
					talla=$("#Antropometria_antr_talla_cms").val();
					if(peso!=0 && talla!=0){
						tallMts=talla/60;
						imc=peso/Math.pow(tallMts,2);
						$("#Antropometria_antr_imc").val(imc.toFixed(3));
					}
					else{
						jAlert("Debe digitar números mayores a cero");
					}
				}
				else{
					jAlert("Debe digitar solo números en peso y talla");
				}
			}		
		}
		function muestraTablaExamen(){
			var table="<table class=\"table table-striped table-bordered table-responsive\" style=\"font-size:12px\">";
			table+="<thead><tr>";
			table+="<td c>ÁREA DE EXAMEN</td>";
			table+="<\tr>";
			table+="<td>ÁREA DE EXAMEN</td>";
			table+="<td>SIGNOS</td>";
			table+="<td>PROBABLE DEFICIT</td>";				
			table+="</tr></thead><tbody>";	
			table+="<tr>";
			table+="<td>1- PELO Y UÑAS </td>";
			table+="<td> Pelo escaso, pelo desprendible, pelo despigmentado. <br/>   Coiloniquia, uñas quebradizas, blandas.</td>";
			table+="<td>Coiloniquia, uñas quebradizas, blandas. <br/>Hierro</td>";
			table+="</tr>";
			table+="<tr>";
			table+="<td>2- PIEL</td>";
			table+="<td>Escamosa.<br/>Palidez<br/>Agrietada<br/>Descamación<br/>Hiperqueratosis folicular<br/>Seborrea naso-labial/escrotal.</td>";
			table+="<td>Vit. A, Zn, Ácidos Grasos Esenciales <br/>Hierro, folato, B12, proteínas. <br/>Proteínas <br/>Niacina, Zn <br/>lípidos, Vit.A, C <br/>Vit. B2</td>";
			table+="</tr>";
			table+="<tr>";
			table+="<td>3- OJOS</td>";
			table+="<td> Lagrimeo/ardor/picor.<br/>Xeroftalmia, Ceguera nocturna, manchas de Bitot.<br/>Palidez conjuntiva</td>";
			table+="<td>Vit B2<br/>Vit.A<br/>Hierro, B6-12, Proteína</td>";
			table+="</tr>";
			table+="<tr>";
			table+="<td>4. PERIORAL Y ORAL</td>";
			table+="<td>Estomatitis angular,  glositis/escarlata, lengua lisa.<br/>Gingivitis, encías sangrantes<br/>Caries dental<br/>Hipogeusia,<br/>Queilosís</td>";
			table+="<td>Vit B2<br/>Vit.A<br/>Hierro, B6-12, Proteína</td>";
			table+="</tr>";
			table+="<tr>";
			table+="<td>5. MUSC. ESQUELETICO </td>";
			table+="<td>Atrofia muscular.<br/>Debilidad muscular<br/>Costillas prominentes<br/>Osteomalacia.</td>";
			table+="<td>Proteína, Calorías<br/>Proteína, Calorías, Fosforo<br/>Vit.D, Proteína, Calorías<br/>Vit.D, calcio, fosforo.</td>";
			table+="</tr>";
			table+="<tr>";
			table+="<td>6- OTROS </td>";
			table+="<td>Retraso cicatrización<br/>Ascitis grado<br/>Edema grado</td>";
			table+="<td>Proteína, Vit C, Zn<br/>Proteínas<br/>Proteínas</td>";
			table+="</tr>";
			table+="</tbody></table>";
			$("#ui-id-1").text("Tabla examen físico");$("#juiDialog").addClass("panel panel-default"); $("#juiDialogExam").html(table); $("#juiDialogExam").dialog("open");
		}

	'
	,CClientScript::POS_END);
?>
