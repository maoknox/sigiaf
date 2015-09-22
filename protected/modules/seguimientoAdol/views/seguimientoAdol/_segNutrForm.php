<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('seguimientoAdol/seguimientoAdol/seguimientoNutrForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>
<?php
//print_r($seguimientosNutr);
?>
<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')):?>
<div id="formSegNutr">

    <div class="panel-heading color-sdis"> SEGUIMIENTO NUTRICIONAL </div> <br />
	<?php $formularioAntrValSeg=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioAntrValSeg',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioAntrValSeg->labelEx($modeloAntropometria,'antr_peso_kgs',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioAntrValSeg->textField($modeloAntropometria,'antr_peso_kgs',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioAntrValSeg").addClass("has-warning");'));?>
        	<?php echo $formularioAntrValSeg->error($modeloAntropometria,'antr_peso_kgs',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioAntrValSeg->labelEx($modeloAntropometria,'antr_talla_cms',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioAntrValSeg->textField($modeloAntropometria,'antr_talla_cms',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioAntrValSeg").addClass("has-warning");'));?>
        	<?php echo $formularioAntrValSeg->error($modeloAntropometria,'antr_talla_cms',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioAntrValSeg->labelEx($modeloAntropometria,'antr_imc',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioAntrValSeg->textField($modeloAntropometria,'antr_imc',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioAntrValSeg").addClass("has-warning");'));?>
        	<?php echo $formularioAntrValSeg->error($modeloAntropometria,'antr_imc',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioAntrValSeg->labelEx($modeloAntropometria,'circunf_cefalica',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioAntrValSeg->textField($modeloAntropometria,'circunf_cefalica',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioAntrValSeg").addClass("has-warning");'));?>
        	<?php echo $formularioAntrValSeg->error($modeloAntropometria,'circunf_cefalica',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <hr />
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioAntrValSeg->labelEx($modeloAntropometria,'antr_peso_ideal',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioAntrValSeg->textField($modeloAntropometria,'antr_peso_ideal',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioAntrValSeg").addClass("has-warning");'));?>
        	<?php echo $formularioAntrValSeg->error($modeloAntropometria,'antr_peso_ideal',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioAntrValSeg->labelEx($modeloAntropometria,'antr_talla_ideal',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioAntrValSeg->textField($modeloAntropometria,'antr_talla_ideal',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioAntrValSeg").addClass("has-warning");'));?>
        	<?php echo $formularioAntrValSeg->error($modeloAntropometria,'antr_talla_ideal',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioAntrValSeg->labelEx($modeloAntropometria,'antr_ind_p_t_imc_ed',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioAntrValSeg->textField($modeloAntropometria,'antr_ind_p_t_imc_ed',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioAntrValSeg").addClass("has-warning");'));?>
        	<?php echo $formularioAntrValSeg->error($modeloAntropometria,'antr_ind_p_t_imc_ed',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioAntrValSeg->labelEx($modeloAntropometria,'indice_talla_edad',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioAntrValSeg->textField($modeloAntropometria,'indice_talla_edad',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioAntrValSeg").addClass("has-warning");'));?>
        	<?php echo $formularioAntrValSeg->error($modeloAntropometria,'indice_talla_edad',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div id="divProcPadres" class="form-group">
    	<div class="col-sm-12">
       		<?php echo $formularioAntrValSeg->labelEx($modeloNutricionAdol,'ant_salud_al_cl',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioAntrValSeg->textArea($modeloNutricionAdol,'ant_salud_al_cl',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioAntrValSeg").addClass("has-warning");'));?>
        	<?php echo $formularioAntrValSeg->error($modeloNutricionAdol,'ant_salud_al_cl',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
    	<div class="col-sm-12">
        	<?php echo $formularioAntrValSeg->labelEx($modeloNutricionAdol,'eval_cumpl_obj_alim',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioAntrValSeg->textArea($modeloNutricionAdol,'eval_cumpl_obj_alim',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioAntrValSeg").addClass("has-warning");'));?>
        	<?php echo $formularioAntrValSeg->error($modeloNutricionAdol,'eval_cumpl_obj_alim',array('style' => 'color:#F00'));?>
    	</div>
    </div> 
    <div id="divProcPadres" class="form-group">
    	<div class="col-sm-12">
			<?php echo $formularioAntrValSeg->labelEx($modeloNutricionAdol,'diagnostico_clasif_nutr_na',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioAntrValSeg->textArea($modeloNutricionAdol,'diagnostico_clasif_nutr_na',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioAntrValSeg").addClass("has-warning");'));?>
        	<?php echo $formularioAntrValSeg->error($modeloNutricionAdol,'diagnostico_clasif_nutr_na',array('style' => 'color:#F00'));?>
    	</div>
    </div>        
    <div id="divProcPadres" class="form-group">
    	<div class="col-sm-12">
			<?php echo $formularioAntrValSeg->labelEx($modeloNutricionAdol,'plan_nutr',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioAntrValSeg->textArea($modeloNutricionAdol,'plan_nutr',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioAntrValSeg").addClass("has-warning");'));?>
        	<?php echo $formularioAntrValSeg->error($modeloNutricionAdol,'plan_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>        
    <div class="form-group">
            <?php echo CHtml::label('','',array('class'=>'col-md-5 control-label','for'=>'searchinput'));	?>            
    	<div class="col-md-4">	
			<?php				
				$modeloNutricionAdol->id_tipoact_pld=2;
				$modeloNutricionAdol->id_nutradol="aux";
				echo $formularioAntrValSeg->hiddenField($modeloNutricionAdol,'id_val_nutricion');
				echo $formularioAntrValSeg->error($modeloNutricionAdol,'id_val_nutricion',array('style' => 'color:#F00'));
				echo $formularioAntrValSeg->hiddenField($modeloAntropometria,'id_val_nutricion');
				echo $formularioAntrValSeg->error($modeloAntropometria,'id_val_nutricion',array('style' => 'color:#F00'));
				echo $formularioAntrValSeg->hiddenField($modeloNutricionAdol,'id_tipoact_pld');
				echo $formularioAntrValSeg->error($modeloNutricionAdol,'id_tipoact_pld',array('style' => 'color:#F00'));
				echo $formularioAntrValSeg->hiddenField($modeloNutricionAdol,'id_nutradol');
				echo $formularioAntrValSeg->hiddenField($modeloAntropometria,'id_antropometria');
				echo $formularioAntrValSeg->error($modeloNutricionAdol,'id_nutradol',array('style' => 'color:#F00'));
				$boton=CHtml::Button (
					'Regitrar',   
					array('id'=>'btnFormAntrMtria','class'=>'btn btn-default btn-sdis','name'=>'btnFormAntrMtria','onclick'=>'js:enviaFormSegNutr("formularioAntrValSeg")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
	</div>    
   <?php $this->endWidget();?>
<hr />    <fieldset id="fieldFreCons" style="display:block;">

    <div class="panel-heading color-sdis"> SEGUIMIENTO AL COMPORTAMIENTO ALIMENTARIO </div> <br />
		<div class="form-group"> 
            <?php echo CHtml::label('Tiempo de comida / Grupo de alimentos','',array('class'=>'col-sm-2 control-label','for'=>'searchinput'));	?>            
            <?php //echo $formularioLabClinicos->labelEx($modeloLabclinValnutr,'resultado_labclin',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <?php
                foreach($tiempoAlimento as $tiempo):
            ?>
                <div class="col-sm-1">
                    <strong><?php echo $tiempo["tiempo_alimento"];?></strong>
                </div>
           <?php endforeach;?>
           <div class="col-sm-1" align="center">
				<strong>Número de porciones consumidas diariamente</strong>
        	</div>
           <div class="col-sm-1" align="center">
				<strong>Número de porciones recomendada</strong>
        	</div>
            <div class="col-sm-1" align="center">
				<strong>Porciones de diferencia entre lo consumido y lo recomendado </strong>
        	</div>
            <div class="col-sm-1">
				<strong> acción</strong>
        	</div>
        </div><br /><br /><br /><br /><br /><br /><br /><br />
<?php		
//print_r($seguimPlanDietario);
		//seguimPlanDietario
	$tiempo="";
	$modeloGrupocomidaNutradol->id_val_nutricion=$valNutr["id_val_nutricion"];
	$modeloGrupocomidaNutradol->id_nutradol=$seguimPlanDietario["id_nutradol"];
	$modeloPorcionesComida->id_val_nutricion=$valNutr["id_val_nutricion"];
	$modeloPorcionesComida->id_nutradol=$seguimPlanDietario["id_nutradol"];
	foreach($grupoComida as $comida){
		$modeloGrupocomidaNutradol->id_grupo_comida=$comida["id_grupo_comida"];
		$modeloPorcionesComida->id_grupo_comida=$comida["id_grupo_comida"];
		$consultaPorcionesGen=$modeloPorcionesComida->consultaConsumPorcionesGen();
		//print_r($consultaPorcionesGen);
		$modeloPorcionesComida->num_porc_cons_diario="";
		$modeloPorcionesComida->num_porc_recomendadas="";
		$modeloPorcionesComida->dif_num_porc_cons_rec="";
		if(!empty($consultaPorcionesGen)){
			$modeloPorcionesComida->num_porc_cons_diario=$consultaPorcionesGen["num_porc_cons_diario"];
			$modeloPorcionesComida->num_porc_recomendadas=$consultaPorcionesGen["num_porc_recomendadas"];
			$modeloPorcionesComida->dif_num_porc_cons_rec=$consultaPorcionesGen["dif_num_porc_cons_rec"];
		}
		
		?>
       	<?php $formularioPorcionesComida=$this->beginWidget('CActiveForm', array(
                'id'=>'formularioPorcionesComida'.$comida["id_grupo_comida"],
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>false,
                ),
                'htmlOptions' => array('class' => 'form-horizontal')
            ));
        ?>
    	<?php echo  $formularioPorcionesComida->errorSummary(array($modeloGrupocomidaNutradol,$modeloPorcionesComida),'','',array('style' => 'font-size:14px;color:#F00')); ?>
		<div class="form-group"> 
			<?php echo CHtml::label($comida["grupo_comida"],'',array('class'=>'col-sm-2 control-label','for'=>'searchinput'));	?>
			<?php foreach($tiempoAlimento as $tiempo):?>
			<?php 
				$modeloGrupocomidaNutradol->num_porciones=0;
				$modeloGrupocomidaNutradol->id_tiempo_alimento=$tiempo["id_tiempo_alimento"];
				$consultaComidaTiempoPorc=$modeloGrupocomidaNutradol->consultaConsumPorcionesTiempo();
				if(!empty($consultaComidaTiempoPorc)){
					$modeloGrupocomidaNutradol->num_porciones=$consultaComidaTiempoPorc["num_porciones"];
				}		
			?>
			<div class="col-sm-1" align="center">
					<?php echo $formularioPorcionesComida->textField($modeloGrupocomidaNutradol,'num_porciones',array('name'=>'GrupocomidaNutradol[grupo_comida]['.$tiempo["id_tiempo_alimento"].']','class'=>'form-control input-md','onChange'=>'js:$("#formularioPorcionesComida'.$comida["id_grupo_comida"].'").addClass("has-warning");calculaPorcionesRec("'.$tiempo["id_tiempo_alimento"].'","'.$comida["id_grupo_comida"].'")'));?>
			 </div>  
			<?php endforeach; ?>
				<div class="col-sm-1">
					<?php echo $formularioPorcionesComida->textField($modeloPorcionesComida,'num_porc_cons_diario',array('class'=>'form-control input-md','readOnly'=>true,'onChange'=>'js:$("#formularioPorcionesComida'.$comida["id_grupo_comida"].'").addClass("has-warning");'));?>
                    <?php echo $formularioPorcionesComida->error($modeloPorcionesComida,'num_porc_cons_diario',array('style' => 'color:#F00'));?>
				</div>
                <div class="col-sm-1">
					<?php echo $formularioPorcionesComida->textField($modeloPorcionesComida,'num_porc_recomendadas',array('class'=>'form-control input-md','onChange'=>'js:$("#formularioPorcionesComida'.$comida["id_grupo_comida"].'").addClass("has-warning");calculaPorcionesRec("'.$tiempo["id_tiempo_alimento"].'","'.$comida["id_grupo_comida"].'")'));?>
                    <?php echo $formularioPorcionesComida->error($modeloPorcionesComida,'num_porc_recomendadas',array('style' => 'color:#F00'));?>
				</div>                
				<div class="col-sm-1">
					<?php echo $formularioPorcionesComida->textField($modeloPorcionesComida,'dif_num_porc_cons_rec',array('class'=>'form-control input-md','readOnly'=>true,'onChange'=>'js:$("#formularioPorcionesComida'.$comida["id_grupo_comida"].'").addClass("has-warning");'));?>
                    <?php echo $formularioPorcionesComida->error($modeloPorcionesComida,'dif_num_porc_cons_rec',array('style' => 'color:#F00'));?>
				</div>                
                
			<div class="col-sm-1">
				<?php 
					if(empty($modeloGrupocomidaNutradol->id_nutradol)){
						$modeloGrupocomidaNutradol->id_nutradol=date("Y-m-d");	
						$modeloPorcionesComida->id_nutradol=date("Y-m-d");	
					}				
					echo $formularioPorcionesComida->hiddenField($modeloGrupocomidaNutradol,'id_nutradol');	
					echo $formularioPorcionesComida->hiddenField($modeloPorcionesComida,'id_nutradol');					
				?>
                <?php 
					$modeloGrupocomidaNutradol->id_tiempo_alimento=0;					
					echo $formularioPorcionesComida->hiddenField($modeloGrupocomidaNutradol,'id_tiempo_alimento');?>
				<?php echo $formularioPorcionesComida->hiddenField($modeloGrupocomidaNutradol,'id_val_nutricion');?>
				<?php echo $formularioPorcionesComida->hiddenField($modeloGrupocomidaNutradol,'id_grupo_comida');?>
				<?php echo $formularioPorcionesComida->hiddenField($modeloPorcionesComida,'id_val_nutricion');?>
				<?php echo $formularioPorcionesComida->hiddenField($modeloPorcionesComida,'id_grupo_comida');?>
				<?php				
                    $boton=CHtml::Button (
                        'Registrar',   
                        array('id'=>'btnFormAdolPorcCom'.$comida["id_grupo_comida"],'class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolPorCom'.$comida["id_grupo_comida"],'onclick'=>'js:enviaFormPlanDietario("formularioPorcionesComida'.$comida["id_grupo_comida"].'","'.$comida["id_grupo_comida"].'")')
                    );
                ?>
                <?php echo $boton; //CHtml::submitButton('Crear');?>
			</div>
		</div>
        <?php $this->endWidget();?>
	<?php				
	}
	?>
	</fieldset>
           <fieldset>
    	<div class="panel-heading color-sdis">HISTÓRICO DE SEGUIMIENTOS</div> <br />
<table style="border:0px; width:100%;">
    <tr>
        <td style="width:80%">
            <div class="cont-seg">
	        	<?php 
				if(!empty($seguimientosNutr)):?>
					<?php foreach($seguimientosNutr as $pk=>$seguimiento):?>
						<a name="segpe_<?php echo $pk;?>"><strong>Fecha del seguimiento: <?php echo $seguimiento["fecha_segnutr"] ?>
                        || Nombre del profesional: <?php echo $seguimiento["nombre_personal"]?> <?php echo $seguimiento["apellidos_personal"]?>  || Profesión: <?php echo $seguimiento["nombre_rol"]?></strong></a><br /><br />
                       <strong>Antropometría:</strong><br />
                       Peso:<?php echo $seguimiento["antr_peso_kgs"]?><br />
                       Talla:<?php echo $seguimiento["antr_talla_cms"]?><br />
                       IMC:<?php echo $seguimiento["antr_imc"]?><br />
                       Circunferencia cefálica:<?php echo $seguimiento["circunf_cefalica"]?><br />
                       Peso ideal:<?php echo $seguimiento["antr_peso_ideal"]?><br />
                       Talla ideal:<?php echo $seguimiento["antr_talla_ideal"]?><br />
                       Índice peso/talla o IMC/edad:<?php echo $seguimiento["antr_ind_p_t_imc_ed"]?><br />
                       Índice Talla/Edad: <?php echo $seguimiento["indice_talla_edad"]?><br />
                       
                       <p style="margin:0px 10px 0px 0px"><strong>Modificación antecedentes de salud, alimentarios o clínicos:</strong><br /><?php echo CHtml::encode($seguimiento["ant_salud_al_cl"]); ?></p><br />
                       <p style="margin:0px 10px 0px 0px"><strong>Evaluación de cumplimiento a los objetivos alimentarios y nutricionales propuestaos:</strong><br /><?php echo CHtml::encode($seguimiento["eval_cumpl_obj_alim"]); ?></p><br />
                       <p style="margin:0px 10px 0px 0px"><strong>Diagnostico/Clasificación nutricional:</strong><br /><?php echo CHtml::encode($seguimiento["diagnostico_clasif_nutr_na"]); ?></p><br />
                       <p style="margin:0px 10px 0px 0px"><strong>Plan nutricional:</strong><br /><?php echo CHtml::encode($seguimiento["plan_nutr"]); ?></p><br />
                       <hr />
					<?php endforeach;?>					
				<?php endif;?>
            </div>
        </td>
        <td valign="top" style="width:20%">
            <div class="cont-f-seg">
            	<?php if(!empty($seguimientosNutr)):?>
					<?php foreach($seguimientosNutr as $pk=>$seguimiento): ?>
						<a href="#segpe_<?php echo $pk;?>"><?php  echo $pk."-";?>Fecha:<?php echo $seguimiento["fecha_segnutr"] ?></a><br />
					<?php endforeach;?>					
				<?php endif;?>
            </div>
        </td>
    </tr>
</table>
</fieldset>

</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptSegNutricional','
	$(document).ready(function(){
		$("#formSegNutr").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
		$("#labExtr").hide()
	});
	$(window).bind("beforeunload", function(){
		if($(".unsavedForm").size()){
			return "Aún hay datos sin guardar si abandona la página estos no se guardaran";//va a cerrar
		}
	});
	function enviaFormSegNutr(formId){
		$("#"+formId+" .errorMessage").text("");
		$.ajax({
			url: "registraSeguimientoNutr",
			data:$("#"+formId).serialize(),
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				if(datos.estadoComu=="exito"){
					//$("#"+btnForm).css("color","#000");
					if(datos.resultado=="exito"){
						jAlert("Registro exitoso","mensaje");
						$("#"+formId).removeClass("has-warning");
						$("#"+formId).removeClass("unsavedForm");
						if(datos.accion=="crea"){
							$("#"+formId+" #NutricionAdol_id_nutradol").val(datos.idNutricion);
							$("#"+formId+" #Antropometria_id_antropometria").val(datos.idAntropometria);							
						}
						$("#fieldFreCons").css("display","block");
					}
					else{
						jAlert("Error en el registro  Motivo "+datos.resultado,"Mensaje");
					}
				}
				else{
					//$("#btnFormAcud").show();
					$.each(datos, function(key, val) {
						$("#"+formId+" #"+key+"_em_").text(val);                                                    
						$("#"+formId+" #"+key+"_em_").show();                                                
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
						jAlert("Error en el registro \n"+xhr.responseText+" Comuníquese con el ingeniero encargado","Mensaje");
					}	
				}	
			}
		});		
	}
	
	function enviaFormPlanDietario(nombreForm,idComida){
		//jAlert($("#formularioPorcionesComida"+idComida).serialize());
			$("#"+nombreForm+" .errorMessage").text("");
			$.ajax({
				url: "'.Yii::app()->createAbsoluteUrl('valoracionIntegral/valoracionIntegral/registraPlanDietario').'",
				data:$("#formularioPorcionesComida"+idComida).serialize()+"&idNutrAdol="+$("#NutricionAdol_id_nutradol").val()+"&idTipoActividad="+$("#NutricionAdol_id_tipoact_pld").val(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){
						//$("#"+btnForm).css("color","#000");
						if(datos.resultado=="exito"){
							jAlert("Registro exitoso","mensaje");
							$("#formularioPorcionesComida"+idComida).removeClass("has-warning");
							$("#formularioPorcionesComida"+idComida+" #formularioPorcionesComida"+idComida+"_es_").html(""); 							
							$("#formularioPorcionesComida"+idComida+" #formularioPorcionesComida"+idComida+"_es_").hide();
							$("#formularioPorcionesComida"+idComida).removeClass("unsavedForm");
						}
						else{
							jAlert("Error en el registro  Motivo "+datos.resultado,"Mensaje");
						}
					}
					else{
						//$("#btnFormAcud").show();
						var errores="Por favor Tenga en cuenta lo siguiente<br/><ul>";
						$.each(datos, function(key, val) {
							errores+="<li>"+val+"</li>";
							$("#formularioPorcionesComida"+idComida+" #"+key+"_em_").text(val);                                                    
							$("#formularioPorcionesComida"+idComida+" #"+key+"_em_").show();                                                
						});
						errores+="</ul>";
						$("#formularioPorcionesComida"+idComida+" #formularioPorcionesComida"+idComida+"_es_").html(errores);                                                    
						$("#formularioPorcionesComida"+idComida+" #formularioPorcionesComida"+idComida+"_es_").show(); 
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
							jAlert("Error en el registro \n"+xhr.responseText+" Comuníquese con el ingeniero encargado","Mensaje");
						}	
					}	
				}
			});
		}
		function calculaPorcionesRec(idTiempoComida,idComida){
			//jAlert($("#formularioPorcionesComida"+idComida+" #GrupocomidaNutradol_grupo_comida_"+idTiempoComida).val(),"Mensaje");
			if(isNaN($("#formularioPorcionesComida"+idComida+" #GrupocomidaNutradol_grupo_comida_"+idTiempoComida).val())){
				jAlert("Debe digitar solo números","Mensaje");
				$("#formularioPorcionesComida"+idComida+" #GrupocomidaNutradol_grupo_comida_"+idTiempoComida).val("");
			}
			else{
				$("#formularioPorcionesComida"+idComida+" #PorcionesComida_num_porc_cons_diario").val("");
				var porciones=0;
				for (i = 1; i <= 6; i++) {
					porciones=porciones*1+$("#formularioPorcionesComida"+idComida+" #GrupocomidaNutradol_grupo_comida_"+i).val()*1;
				}
				$("#formularioPorcionesComida"+idComida+" #PorcionesComida_num_porc_cons_diario").val(porciones);	
				//porciones diferencia		
				var porcionesRec=$("#formularioPorcionesComida"+idComida+" #PorcionesComida_num_porc_recomendadas").val();	
				var diferenciaPCPR=(porciones-porcionesRec)*1;
				$("#formularioPorcionesComida"+idComida+" #PorcionesComida_dif_num_porc_cons_rec").val(diferenciaPCPR);	
			}
		}

'
,CClientScript::POS_END);
?>
	<?php else:?>
    <hr />
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                Mensaje
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-3 text-center">
                    <img src="/login_sdis/public/img/logo.svg" />
                </div>
                <div class="col-lg-9 text-justify">
                    <?php echo Yii::app()->user->getFlash('verifEstadoAdolForjar'); ?>
                </div>
            </div>
        </div>
    </div>
    <hr />
	<?php endif;?>
<?php endif;?>





