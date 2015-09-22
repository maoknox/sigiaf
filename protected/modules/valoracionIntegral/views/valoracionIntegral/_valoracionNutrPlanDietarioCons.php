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
			</div>
		</div>
        <?php $this->endWidget();?>
	<?php				
	}
	?>
	</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptPlanDienCons','		
	$(document).ready(function(){
		$("#formNutrPlanDietario").find(":input").attr("disabled","disabled");
	});
',CClientScript::POS_END);
?>
