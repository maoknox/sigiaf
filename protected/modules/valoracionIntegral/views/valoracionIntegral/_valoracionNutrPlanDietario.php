<div id="formNutrPlanDietario">
    <div class="panel-heading color-sdis"> PLAN DIETARIO PROPUESTO </div> <br />
    <fieldset id="fieldFreCons">
		<div class="form-group"> 
            <?php echo CHtml::label('Tiempo de comida / Grupo de alimentos','',array('class'=>'col-sm-3 control-label','for'=>'searchinput'));	?>            
            <?php //echo $formularioLabClinicos->labelEx($modeloLabclinValnutr,'resultado_labclin',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <?php
                foreach($tiempoAlimento as $tiempo):
            ?>
                <div class="col-sm-1">
                    <strong><?php echo $tiempo["tiempo_alimento"];?></strong>
                </div>
           <?php endforeach;?>
           <div class="col-sm-1" align="center">
				<strong>Número de porciones recomendada</strong>
        	</div>
            <div class="col-sm-1">
				<strong> acción</strong>
        	</div>
        </div><br /><br /><br /><br />
<?php		
	$tiempo="";
	//echo $planDietario["id_nutradol"];
	$modeloGrupocomidaNutradol->id_val_nutricion=$modeloValNutr["id_val_nutricion"];
	$modeloGrupocomidaNutradol->id_nutradol=$planDietario["id_nutradol"];
	$modeloPorcionesComida->id_val_nutricion=$modeloValNutr["id_val_nutricion"];
	$modeloPorcionesComida->id_nutradol=$planDietario["id_nutradol"];
	$modeloNutricionAdol->id_nutradol=$planDietario["id_nutradol"];
	
	
	//print_r($planDietario);
	foreach($grupoComida as $comida){
		$modeloGrupocomidaNutradol->id_grupo_comida=$comida["id_grupo_comida"];
		$modeloPorcionesComida->id_grupo_comida=$comida["id_grupo_comida"];
		$consultaComidaFrec=$modeloGrupocomidaNutradol->consultaConsumPorciones();
		$consultaPorcionesRec=$modeloPorcionesComida->consultaConsumPorcionesGen();
		$modeloPorcionesComida->num_porc_recomendadas="";
		if(!empty($consultaPorcionesRec["num_porc_recomendadas"])){
			$modeloPorcionesComida->num_porc_recomendadas=$consultaPorcionesRec["num_porc_recomendadas"];
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
			<?php echo CHtml::label($comida["grupo_comida"],'',array('class'=>'col-sm-3 control-label','for'=>'searchinput'));	?>
			<?php foreach($tiempoAlimento as $tiempo):
				$modeloGrupocomidaNutradol->num_porciones="";
				if(!empty($consultaComidaFrec)){
					foreach($consultaComidaFrec as $porcionesCons){
						if($tiempo["id_tiempo_alimento"]==$porcionesCons["id_tiempo_alimento"]){
							if(!empty($porcionesCons["num_porciones"])){
								$modeloGrupocomidaNutradol->num_porciones=$porcionesCons["num_porciones"];
							}
						}	
					}
				}
			?>
			<div class="col-sm-1" align="center">
					<?php echo $formularioPorcionesComida->textField($modeloGrupocomidaNutradol,'num_porciones',array('name'=>'GrupocomidaNutradol[grupo_comida]['.$tiempo["id_tiempo_alimento"].']','class'=>'form-control input-md','onChange'=>'js:$("#formularioPorcionesComida'.$comida["id_grupo_comida"].'").addClass("has-warning");calculaPorcionesRec("'.$tiempo["id_tiempo_alimento"].'","'.$comida["id_grupo_comida"].'")'));?>
			 </div>  
			<?php endforeach; ?>
				<div class="col-sm-1">
					<?php echo $formularioPorcionesComida->textField($modeloPorcionesComida,'num_porc_recomendadas',array('class'=>'form-control input-md','readonly'=>'true','onChange'=>'js:$("#formularioPorcionesComida'.$comida["id_grupo_comida"].'").addClass("has-warning");'));?>
                    <?php echo $formularioPorcionesComida->error($modeloPorcionesComida,'num_porc_recomendadas',array('style' => 'color:#F00'));?>
				</div>                
			<div class="col-sm-1">
            	<?php 
				//echo $planDietario["id_nutradol"];				
					if(empty($planDietario["id_nutradol"])){
						$modeloGrupocomidaNutradol->id_nutradol=date("Y-m-d");	
						$modeloPorcionesComida->id_nutradol=date("Y-m-d");	
						//$modeloNutricionAdol->id_nutradol=date("Y-m-d");
					}				
					echo $formularioPorcionesComida->hiddenField($modeloGrupocomidaNutradol,'id_nutradol');	
					echo $formularioPorcionesComida->hiddenField($modeloPorcionesComida,'id_nutradol');					
				?>

                <?php $modeloGrupocomidaNutradol->id_tiempo_alimento=0;						
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
</div>
<?php 
	$modeloNutricionAdol->id_tipoact_pld=1;
	echo CHtml::hiddenField('idTipoActividad' , $modeloNutricionAdol->id_tipoact_pld, array('id' => 'idTipoActividad')); 
?>
<?php echo CHtml::hiddenField('idNutrAdol' , $modeloNutricionAdol->id_nutradol, array('id' => 'idNutrAdol')); ?>
<?php
Yii::app()->getClientScript()->registerScript('scriptValPlandietario','
	$(document).ready(function(){
		$("#formNutrPlanDietario").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
		$("#labExtr").hide()
	});
	function enviaFormPlanDietario(nombreForm,idComida){
		$("#"+nombreForm+" .errorMessage").text("");	
		//jAlert($("#formularioPorcionesComida"+idComida).serialize());
			$.ajax({
				url: "registraPlanDietario",
				data:$("#formularioPorcionesComida"+idComida).serialize()+"&idNutrAdol="+$("#idNutrAdol").val()+"&idTipoActividad="+$("#idTipoActividad").val(),
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
							$("#idNutrAdol").val(datos.idNutrAdol);
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
				$("#formularioPorcionesComida"+idComida+" #PorcionesComida_num_porc_recomendadas").val("");
				var porciones=0;
				for (i = 1; i <= 6; i++) {
					porciones=porciones*1+$("#formularioPorcionesComida"+idComida+" #GrupocomidaNutradol_grupo_comida_"+i).val()*1;
				}
				$("#formularioPorcionesComida"+idComida+" #PorcionesComida_num_porc_recomendadas").val(porciones);				
			}
		}

'
,CClientScript::POS_END);
?>
