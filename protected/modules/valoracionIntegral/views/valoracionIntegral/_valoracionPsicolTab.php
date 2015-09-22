<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div  id="formPsicolPrinc">
<div id="Mensaje" style="font-size:14px;" ></div>
<?php 

/* $this->widget('application.extensions.magnific-popup.EMagnificPopup', array('target' => '.test-popup-link'));*/
?>
<fieldset>
<div class="panel-heading color-sdis">VINCULACIÓN PREVIA AL SRPA</div>

<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="vincPrevSrpaTable"><tr>
	<td style=" border:1px solid #000; width:25%">Delito</td>
    <td style=" border:1px solid #000;width:25%">Medida de internamiento preventivo</td>
    <td style=" border:1px solid #000;width:25%">Sanción impuesta</td>
    <td style=" border:1px solid #000;width:25%"></td>
</tr>


	
	<?php
		//$consDelitoVinc[]=array('1'=>'1');$consDelitoVinc[]=array('1'=>'1');
	 if(!empty($consDelitoVinc)):?>
    	
		<?php  foreach($consDelitoVinc as $pk=>$consDelitoVinc): $pk+=1;?>
			<tr>
            	<td style=" border:1px solid #000; width:25%">
					<?php echo $pk;
                        $op[$consDelitoVinc["id_del_rc"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('delito_'.$pk,'delito_'.$pk,CHtml::listData($delitos,'id_del_rc','del_remcespa'),
                     		array(
								'prompt'=>'Seleccione Delito',
                       	 		'options' => $op,
								'style'=>'width:100%',
								'onchange'=>'js:$("#btnDelVinc_'.$pk.'").addClass("unsavedForm");$("#btnDelVinc_'.$pk.'").css("color","#F00");'
                       		)
                    	);
						$op="";
					?>               
               </td>
               <td style=" border:1px solid #000; width:20%">
					<?php 
                        if($consDelitoVinc["medida_int_prev"]==1){$consDelitoVinc["medida_int_prev"]=true;}else{$consDelitoVinc["medida_int_prev"]=false;}
                            echo CHtml::CheckBox('intprev_'.$pk,$consDelitoVinc["medida_int_prev"], array (
                                'value'=>'true',
								'onchange'=>'js:$("#btnDelVinc_'.$pk.'").addClass("unsavedForm");$("#btnDelVinc_'.$pk.'").css("color","#F00");'
                         )); 
                    ?> Si
            	</td>
                <td style=" border:1px solid #000; width:30%">
                	<?php 
                        if($consDelitoVinc["sancion_impuesta_vinc"]==1){$consDelitoVinc["sancion_impuesta_vinc"]=true;}else{$consDelitoVinc["sancion_impuesta_vinc"]=false;}
                            echo CHtml::CheckBox('sansImp_'.$pk,$consDelitoVinc["sancion_impuesta_vinc"], array (
                                'value'=>'true',
								'onchange'=>'js:$("#btnDelVinc_'.$pk.'").addClass("unsavedForm");$("#btnDelVinc_'.$pk.'").css("color","#F00");'
                         )); 
                    ?>Si
                    <?php 
                        $opTipoSanc[$consDelitoVinc["id_tipo_sancion"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('tipoSanImp_'.$pk,'tipoSanImp_'.$pk,CHtml::listData($sancionImp,'id_tipo_sancion','tipo_sancion'),
                     		array(
								'prompt'=>"seleccione una sanción",
                       	 		'options' => $opTipoSanc,
								'style'=>'width:100%',
								'onchange'=>'js:$("#btnDelVinc_'.$pk.'").addClass("unsavedForm");$("#btnDelVinc_'.$pk.'").css("color","#F00");'
                       		)
                    	);
						$opTipoSanc="";
					?>   
                </td>
                <td style=" border:1px solid #000; width:25%">
               <?php 
			   		echo CHtml::hiddenField('idVincPrSrpa_'.$pk,$consDelitoVinc["id_casodelito"]);
			   		echo CHtml::Button (
						'Modificar',   
						array('id'=>'btnDelVinc_'.$pk,'name'=>'btnDelVinc_'.$pk,'onclick'=>'js:modificaVincPrevSrpa('.$pk.')')
					);
					echo Chtml::hiddenField('numDelito',$pk);
                ?>
                
                </td>
			</tr>
		<?php endforeach;?>	
      <?php endif;?>
</table>
<?php
if(empty($pk)){$pk=0;}
echo Chtml::hiddenField('numDelitoGen',$pk);
echo CHtml::Button('Agregar Delito',
	array('id'=>'btnAgregaDel','class'=>'btn btn-default btn-sdis','name'=>'btnAgregaDel','onclick'=>'js:agregaDelVincPrevSRPA()')
);
?>
</fieldset>
<hr />

<fieldset>
<div class="panel-heading color-sdis">RECUPERACIÓN BIOGRÁFICA</div>
<?php $formHisVida=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioHistVida',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<?php echo  $formHisVida->errorSummary($modeloValPsicol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<div id="divGrHV" class="form-group"> 
    	<div class="col-md-12">
	<!--campo de texto para nombres del adolescente -->	
		<?php echo $formHisVida->labelEx($modeloValPsicol,'historia_vida',array('class'=>'control-label','for'=>'searchinput'));?><code data-toggle="tooltip" title='Indagar con la familia: Describir gestación, dificultades en el parto. Primera Infancia: lactancia, pérdidas relevantes, vínculo relevantes materno/paterno, profundizar en problematicas asociadas: relevante ASI, desplazamiento, MI; "castigo" con quien vivio, como se relacionaba con otros niños-as, actividades compartidas, a que le gustaba jugar, quien era la figura de autoriadad/// educacion inicial Jardin Infantil, con quien permanecia Adolescencia: pubertad 8 a 12 años, actividades en las que participaba, socialización con pares, relacion y cambios con referentes fmiliares de autoridad,etc.. Indagar con el o la Adolescente: Indagar recuerdos positivos; cuando se trate de ASI/MI/Desplazamiento/ se retoma textual el relato de los hechos, si este esta descrito en documentos CESPA no se pregunta. La valoración en estos aspectos implica determinar si estas vulneraciones de derechos o problemáticas asociadas, tuvieron algun tipo de atención para determinar superación del daño, de lo contrario deberá generar las hipotesis, tratamiento terapeutico (en los casos que asi o requieran) y referenciacion pertinentes. Iniciación y atividad sexual, consumo SPA en general, relaciones afectivas...Identficar pares actuales significativos, que puedan ser vinculados al proceso. Paternidad y maternidad cuando sean adolescentes con hijos-as o en gestación.'>Ayuda</code>
		<?php echo $formHisVida->textArea($modeloValPsicol,'historia_vida',array('class'=>'form-control','onblur'=>'js:enviaForm("formularioHistVida","divGrHV")','onkeyup'=>'js:$("#divGrHV").addClass("has-warning");'));?>
        <?php echo $formHisVida->error($modeloValPsicol,'historia_vida',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   	<div class="form-group">
            <div class="col-md-4">	
<?php
$boton=CHtml::Button (
	'Modificar',   
	array('id'=>'btnFormAdolHisVid','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolHisVid','onclick'=>'js:enviaForm("formularioHistVida","btnFormAdolHisVid")')
);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
    </div></div>
<?php $this->endWidget();?>
<hr />
<?php $formDinFunFam=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDinFunFam',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>	
<?php echo  $formDinFunFam->errorSummary($modeloValPsicol,'','',array('style' => 'font-size:14px;color:#F00')); ?>

	<div id="dn_fn_familiar" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formDinFunFam->labelEx($modeloValPsicol,'dn_fn_familiar',array('class'=>'control-label','for'=>'searchinput'));?><code data-toggle="tooltip" title='Indagar desde el enfoque sistémico con la familia y con el o la adolescente: efectos de la dinámica fliar en el adolescente, limites, colaiciones, alianzas, profundizar en comunicación, percepción de vínculos por subsitemas, funcion del rol del adolescente, manifestaciones de afecto, disciplina, comunicación. Lectura de roles por asignacion de género (etica del cuidado). Profundizar en problematicas asociadas como VIF, antecedentes judiciales de la familia, consumo de SPA; referentes + o - no familiares, afectación desplazamiento, ASI; resolucion de conflictos;'>Ayuda</code>
            <?php echo $formDinFunFam->textArea($modeloValPsicol,'dn_fn_familiar',array('class'=>'form-control','onblur'=>'js:enviaForm("formularioDinFunFam","dn_fn_familiar")','onkeyup'=>'js:$("#dn_fn_familiar").addClass("has-warning");'));?>
            <?php echo $formDinFunFam->error($modeloValPsicol,'dn_fn_familiar',array('style' => 'color:#F00'));?>
    	</div>
    </div>
       	<div class="form-group">
            <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                        'Modificar',   
                        array('id'=>'btnFormAdolDinFunFam','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdol','onclick'=>'js:enviaForm("formularioDinFunFam","btnFormAdolDinFunFam")')
                );
            ?>
   			<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
     </div>
<?php $this->endWidget();?>
<hr />

<?php $formHistCond=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioHisCon',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formHistCond->errorSummary($modeloValPsicol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<div id="hist_conducta" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formHistCond->labelEx($modeloValPsicol,'hist_conducta',array('class'=>'control-label','for'=>'searchinput'));?><code data-toggle="tooltip" title='Relato de los hechos y Análisis de: desarrollo moral (responsabilidad) - perspectiva de género; percepción de la o las victimas; percepción de reparación de daño; motivaciones; referentes de influencia: pares o adultos; factores precipitantes, relacionar historia de vida y demás aspectos indagados en apartados anteriores, que permitan preconfigura hipotesis iniciales, frente al desencademaniento de la conducta "delictiva" o del motivo que lo vinculo al SRPA. Incluir conductas delictivas pasdas que no le han vincualdo al SRPA. Ampliar: 1. Contexto del delito (circunstancias en que ocurrió, características, si fue planeado u ocasional, si fue cometido sólo o en grupo, bajo el efecto de SPA, quien o quienes fueron las víctimas etc.) 2. Posición subjetiva del adolescente frente al delito (si se justifica, se siente culpable o acepta la responsabilidad, si estaría dispuesto a reparar, qué percepción tiene de la víctima, etc.) 3. Relación del adolescente con la víctima (si ha tenido contacto con ella durante el proceso, si la conocía, si tenía algún tipo de relación con ella, etc.). 4. Tipo de víctima (si es natural o jurídica, individual o colectiva, conocida o desconocida, hombre o mujer, mayor de edad o menor de edad). 6. Adicionalmente, es importante permitir que el adolescente construya una narrativa sobre el delito, ya que la intervención debe orientarse por la postura que el adolescente asuma ante el hecho y variará según las características del mismo. 6. Con esta misma perspectiva, se sugiere valorar las conductas de riesgo'>Ayuda</code>
            <?php echo $formHistCond->textArea($modeloValPsicol,'hist_conducta',array('class'=>'form-control','onblur'=>'js:enviaForm("formularioHisCon","hist_conducta")','onkeyup'=>'js:$("#hist_conducta").addClass("has-warning");'));?>
            <?php echo $formHistCond->error($modeloValPsicol,'hist_conducta',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::submitButton (
                    'Modificar',   
                    array('id'=>'btnFormAdolHistCond','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdol','onclick'=>'js:enviaForm("formularioHisCon","btnFormAdolHistCond")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>

<fieldset>
<div class="panel-heading color-sdis">ANÁLISIS DEL ESTADO MENTAL</div>
<?php $formEstMental=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioAnEstMen',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')

));
?>
	<?php echo  $formDinFunFam->errorSummary($modeloValPsicol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div id="analisis_est_mental" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formEstMental->labelEx($modeloValPsicol,'analisis_est_mental',array('class'=>'control-label','for'=>'searchinput'));?><code data-toggle="tooltip" title='Identificación de aspectos relevante o posibles alteraciones: 1. Porte y actitud; 2. Orientación; 3. Atención; 4. Alteraciones ritmo vitales ; 5. Sensopercepción; 6. Pensamiento ; 7. Conducta motora ; 8. Lenguaje; 9. Afectividad; 10. Juicio; 11. Prospección '>Ayuda</code>
			<?php echo $formEstMental->textArea($modeloValPsicol,'analisis_est_mental',array('class'=>'form-control','onblur'=>'js:enviaForm("formularioAnEstMen","analisis_est_mental")','onkeyup'=>'js:$("#analisis_est_mental").addClass("has-warning");'));?>
            <?php echo $formEstMental->error($modeloValPsicol,'analisis_est_mental',array('style' => 'color:#F00'));?>
   		</div>
    </div>
    <div class="form-group">
        <div class="col-md-4">	
			<?php
            $boton=CHtml::submitButton (
					'Modificar',   
					array('id'=>'btnFormAdolAnEstMen','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdol','onclick'=>'js:enviaForm("formularioAnEstMen","btnFormAdolAnEstMen")')
			);
            ?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
        </div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<?php 
	echo CHtml::hiddenField('idValPsicol',$idValPsicol);
	echo CHtml::hiddenField('numDocAdolValPsicol',$numDocAdol);
?>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptValpsic_1','
		$(document).ready(function(){
		$("#formPsicolPrinc").find(":input").change(function(){
  var dirtyForm = $(this).parents("form");
  // change form status to dirty
  dirtyForm.addClass("unsavedForm");
});});	
		function enviaForm(nombreForm,divGr,campo){
			$.ajax({
				url: "modificaValoracionPsicol",
				data:$("#"+nombreForm).serialize()+"&idValPsicol="+$("#idValPsicol").val()+"&numDocAdolValPsicol="+$("#numDocAdolValPsicol").val(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){
						if(datos.resultado=="\'exito\'"){
							$("#Mensaje").text("exito");
							$("#"+divGr).removeClass("has-warning");		
							 $("#"+nombreForm).removeClass("unsavedForm");					
						}
						else{
							$("#Mensaje").text("Error en la creación del registro.  Motivo "+datos.resultado);
						}
					}
					else{
						$("#Mensaje").text("no exito");
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					Loading.hide();
					//0 para error en comunicación
					//200 error en lenguaje o motor de base de datos
					//500 Internal server error
					if(xhr.status==0){
						$("#Mensaje").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
					}
					else{
						if(xhr.status==500){
							$("#Mensaje").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
						}
						else{
							$("#Mensaje").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
						}	
					}	
				}
			});
		}
	function agregaDelVincPrevSRPA(){
		numDel= parseInt($("#numDelitoGen").val());
		numDel=numDel+1;
		var agregaReg="<tr id=\'"+numDel+"\'><td style=\"border:1px solid #000;\">"+numDel;
		agregaReg=agregaReg+"<select id=\'delito_"+numDel+"\' name=\'delito_"+numDel+"\' style=\'width:200px;\'";
		agregaReg =	agregaReg+" onchange=\'javascript:$(\"#btnDelVinc_"+numDel+"\").addClass(\"unsavedForm\");$(\"#btnDelVinc_"+numDel+"\").css(\"color\",\"#F00\");\'></select>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td style=\'border:1px solid #000;\'><input type=\'checkbox\' id=\'intprev_"+numDel+"\' value=\'true\' onclick=\'javascript:$(\"#btnDelVinc_"+numDel+"\").addClass(\"unsavedForm\");$(\"#btnDelVinc_"+numDel+"\").css(\"color\",\"#F00\");\'>Si</td>";
		agregaReg=agregaReg+"<td style=\'border:1px solid #000;\'><input type=\'checkbox\' id=\'sansImp_"+numDel+"\' value=\'true\' onclick=\'javascript:$(\"#btnDelVinc_"+numDel+"\").addClass(\"unsavedForm\");$(\"#btnDelVinc_"+numDel+"\").css(\"color\",\"#F00\");\'>Si";
		agregaReg=agregaReg+"<select id=\'tipoSanImp_"+numDel+"\' name=\'tipoSanImp_"+numDel+"\'";
		agregaReg =	agregaReg+" onchange=\'javascript:$(\"#btnDelVinc_"+numDel+"\").addClass(\"unsavedForm\");$(\"#btnDelVinc_"+numDel+"\").css(\"color\",\"#F00\");\'></select></td>";
		agregaReg=agregaReg+"<td style=\'border:1px solid #000;\'>";
		agregaReg=agregaReg+"<input id=\'idVincPrSrpa_"+numDel+"\' type=\'hidden\' name=\'idVincPrSrpa_"+numDel+"\' value=\'\'>";
		agregaReg=agregaReg+"<input type=\'button\' onclick=\'js:quitaDelVinPrevSrpa("+numDel+")\' id=\'btnQuitaDel_"+numDel+"\' value=\'Quitar delito\'>";
		agregaReg=agregaReg+"<input type=\'button\' onclick=\'javascript:creaVincPrevSrpa("+numDel+")\'";
		agregaReg=agregaReg+"style=\'padding:0px 0px 0px 0px; margin:0px 0px 0px 0px;\' id=\'btnDelVinc_"+numDel+"\' value=\'Crear Registro\'>";
		agregaReg=agregaReg+"</td></tr>";
		$("#numDelitoGen").val(numDel);
		cargaDatosSelect("delito_rem_cespa","id_del_rc","del_remcespa","","delito_"+numDel,"vincPrevSrpaTable");
		cargaDatosSelect("tipo_sancion","id_tipo_sancion","tipo_sancion","","tipoSanImp_"+numDel,"vincPrevSrpaTable");
		$("#vincPrevSrpaTable").append(agregaReg);
		$("#btnAgregaDel").attr("disabled",true);
	}
	function creaVincPrevSrpa(numDel){
		var del=$("#delito_"+numDel+" option:selected").val();
		var mIntPrev=$("input:checkbox[id=intprev_"+numDel+"]");
		var sancion=$("input:checkbox[id=sansImp_"+numDel+"]");
		var tipoSancion=$("#tipoSanImp_"+numDel+" option:selected").val();
		if(del.length==0){
			alert("Debe seleccionar un delito");
			return;
		}
		else{
			if(sancion.is(":checked")==true && tipoSancion.length==0){
				alert("Si selecciona sanción impuesta debe seleccionar el tipo de sanción");
				return;
			}
		}
		$.ajax({
			url: "creaVincPrevSrpa",			
			data:"delito="+del+"&intPrev="+mIntPrev.is(":checked")+"&sancion="+sancion.is(":checked")+"&tipoSancion="+tipoSancion+"&idValPsicol="+$("#idValPsicol").val()+"&numDocAdolValPsicol="+$("#numDocAdolValPsicol").val(),
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				//$("#"+btnForm).css("color","#000");
				if(datos.estadoComu=="exito"){
					$("#btnDelVinc_"+numDel).removeClass("unsavedForm");
					$("#btnDelVinc_"+numDel).css("color","#000");
					$("#Mensaje").text("exito");
					$("#btnQuitaDel_"+numDel).remove();
					$("#btnDelVinc_"+numDel).attr( "value","Modificar");
					$("#btnDelVinc_"+numDel).removeAttr( "onclick");
					$("#btnDelVinc_"+numDel).bind( "click", function() {
						modificaVincPrevSrpa(numDel);
					});
					$("#idVincPrSrpa_"+numDel).val(datos.idcasodelito);
					$("#btnAgregaDel").attr("disabled",false);					
				}
				else{
					$("#Mensaje").text("no exito");
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#Mensaje").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#Mensaje").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#Mensaje").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});
	}
	
	function modificaVincPrevSrpa(numDel){
		var del=$("#delito_"+numDel+" option:selected").val();
		var mIntPrev=$("input:checkbox[id=intprev_"+numDel+"]");
		var sancion=$("input:checkbox[id=sansImp_"+numDel+"]");
		var tipoSancion=$("#tipoSanImp_"+numDel+" option:selected").val();
		var idVincPrSrpa=$("#idVincPrSrpa_"+numDel).val()
		if(del.length==0){
			alert("Debe seleccionar un delito");
			return;
		}
		else{
			if(sancion.is(":checked")==true && tipoSancion.length==0){
				alert("Si selecciona sanción impuesta debe seleccionar el tipo de sanción");
				return;
			}
		}
		$.ajax({
			url: "modificaVincPrevSrpa",			
			data:"delito="+del+"&intPrev="+mIntPrev.is(":checked")+"&sancion="+sancion.is(":checked")+"&tipoSancion="+tipoSancion+"&idValPsicol="+$("#idValPsicol").val()+"&numDocAdolValPsicol="+$("#numDocAdolValPsicol").val()+"&idVincPrSrpa="+idVincPrSrpa,
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				//$("#"+btnForm).css("color","#000");
				if(datos.estadoComu=="exito"){
					if(datos.resultado=="\'exito\'"){
						$("#btnDelVinc_"+numDel).removeClass("unsavedForm");
						$("#btnDelVinc_"+numDel).css("color","#000");
						$("#Mensaje").text("exito");
					}
					else{
						$("#Mensaje").text("error");
					}
					
					//$($("#vincPrevSrpaTable").find("tbody > tr")[numDel]).children("td")[3].innerHTML = agregaReg;
				}
				else{
					$("#Mensaje").text("no exito");
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#Mensaje").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#Mensaje").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#Mensaje").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});
	}
	
	function quitaDelVinPrevSrpa(numDel){
		numDelAct= parseInt($("#numDelitoGen").val());
		$("#vincPrevSrpaTable #"+numDel).remove();
		numDelAct -=1;
		$("#numDelitoGen").val(numDelAct);
		$("#btnAgregaDel").attr("disabled",false);
	}
	function cargaDatosSelect(nombreEntidad,campoId,nombCampo,campo,idSelect,idTabla){
		data = "&nombreEntidad="+nombreEntidad+"&campoId="+campoId+"&nombCampo="+nombCampo;
		$.ajax({
			url:"consultaDatosForm",
			data:data,
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				if($("#"+idSelect).attr("multiple")!="multiple"){
					var contenidoSelect="<option value=\"\">Seleccione</option>";
				}
				else{
					var contenidoSelect="";	
				}
				$.each(datos,function(key,val){
					contenidoSelect=contenidoSelect+"<option value=\""+val.id+"\">"+val.contenido+"</option>";	
				});
				$("#"+idSelect).html(contenidoSelect);
			},
			
		});
	}
	//script para tooltip
	$( document ).ready(function() {		
        $("[data-toggle=\"tooltip\"]").tooltip();
    });
'
,CClientScript::POS_END);
?>
