<div id="divFormVerifDer">
<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>
<?php
	$modeloVerifDerechos->num_doc=$numDocAdol;
	$modeloVerifDerechos->id_instanciader=1; 
	$derechos=$modeloVerifDerechos->consultaDerechos();//id_derechocespa
?>
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
<?php foreach($derechos as $pk=>$derecho):?>
<?php if(strpos($derecho["derechocespa"],"Protecc")!==FALSE): 
	
?>
<tr><td style="border:1px solid #000">
<label for="DerechoAdol_id_derechocespa_Nombre<?php echo $pk;?>"><?php echo $derecho["derechocespa"];?></label>
</td><td style="border:1px solid #000"><label for="DerechoAdol_id_derechocespa_<?php echo $pk;?>"><?php echo $derecho["situacion_derecho"];?></label><hr />
	<input id="DerechoAdol_id_derechocespa_<?php echo $pk;?>" onclick="javascript:habilitaSitRiesgo(this);" type="checkbox" name="DerechoAdol[id_derechocespa][]" value="<?php echo $derecho["id_derechocespa"];?>" <?php if($derecho["estado_derecho"]==1){echo "checked";}?> />
	<label for="DerechoAdol_id_derechocespa_obs_<?php echo $pk;?>">Seleccione si cumple</label><br />
    <hr />
  
  	<div class="row">
    <?php
    	$reisgos=$modeloVerifDerechos->consultaProteccion($derecho["id_derecho_adol"]);
		foreach($reisgos as $reisgosAdol){
			$op[$reisgosAdol["id_sit_riesgo"]]=array('selected'=>true);
		}
	?>
    <?php echo $formAdolDerechos->dropDownList($modeloVerifDerechos,'situacionesRiesgos',CHtml::listData($proteccion,'id_sit_riesgo', 'sit_riesgo'), array('multiple'=>true,'disabled'=>false,'style'=>';width:80%','options' => $op)); ?></br>
    <?php echo $formAdolDerechos->error($modeloVerifDerechos,'situacionesRiesgos',array('style' => 'color:#F00')); ?>
	</div>
    </td><td style="border:1px solid #000">    
	<?php echo CHtml::textArea('DerechoAdol[observaciones_derecho_'.$derecho["id_derechocespa"].']',$derecho["observaciones_derecho"],array('id'=>'DerechoAdol_observaciones_derecho_'.$derecho["id_derechocespa"])); ?>
</td></tr>
<?php elseif(strpos($derecho["derechocespa"],"Participac")!==FALSE): ?>
<tr>
<td style="border:1px solid #000">
<label for="DerechoAdol_id_derechocespa_Nombre<?php echo $pk;?>"><?php echo $derecho["derechocespa"];?></label>
</td>
<td style="border:1px solid #000">
<label for="DerechoAdol_id_derechocespa_<?php echo $pk;?>"><?php echo $derecho["situacion_derecho"];?></label><hr />
<input id="DerechoAdol_id_derechocespa_<?php echo $pk;?>" onclick="javascript:habilitaAltPart(this);" type="checkbox" name="DerechoAdol[id_derechocespa][]" value="<?php echo $derecho["id_derechocespa"];?>" <?php if($derecho["estado_derecho"]==1){echo "checked";}?>/>
	<label for="DerechoAdol_id_derechocespa_obs_<?php echo $pk;?>">Seleccione si cumple</label><br />

<hr />
<?php
	$consPart=$modeloVerifDerechos->consultaParticipacion($derecho["id_derecho_adol"]);
	foreach($consPart as $consPartAdol){
		$op[$consPartAdol["id_alternativaproc"]]=array('selected'=>true);
	}
?>
    <div class="row">
    <?php echo $formAdolDerechos->dropDownList($modeloVerifDerechos,'alternativasParticipacions',CHtml::listData($participacion,'id_alternativaproc', 'alternativaproc'), array('multiple'=>true,'disabled'=>false,'style'=>';width:80%','options' => $op)); ?></br>
    <?php echo $formAdolDerechos->error($modeloVerifDerechos,'alternativasParticipacions',array('style' => 'color:#F00')); ?>
	</div>
    </td><td style="border:1px solid #000"><?php echo CHtml::textArea('DerechoAdol[observaciones_derecho_'.$derecho["id_derechocespa"].']',$derecho["observaciones_derecho"],array('id'=>'DerechoAdol_observaciones_derecho_'.$derecho["id_derechocespa"])); ?></td></tr>
<?php else:?>
<tr><td style="border:1px solid #000">
<label for="DerechoAdol_id_derechocespa_Nombre<?php echo $pk;?>"><?php echo $derecho["derechocespa"];?></label>
</td><td style="border:1px solid #000">
<label for="DerechoAdol_id_derechocespa_<?php echo $pk;?>"><?php echo $derecho["situacion_derecho"];?></label><hr />
<input id="DerechoAdol_id_derechocespa_<?php echo $pk;?>"  type="checkbox" name="DerechoAdol[id_derechocespa][]" value="<?php echo $derecho["id_derechocespa"];?>"
<?php if($derecho["estado_derecho"]==1){echo "checked";}?> />
<label for="DerechoAdol_id_derechocespa_obs_<?php echo $pk;?>">Seleccione si cumple</label><br />
</td><td style="border:1px solid #000">
<?php echo CHtml::textArea('DerechoAdol[observaciones_derecho_'.$derecho["id_derechocespa"].']',$derecho["observaciones_derecho"],array('id'=>'DerechoAdol_observaciones_derecho_'.$derecho["id_derechocespa"])); ?>
</td>
</tr>
<?php endif;?>
<?php endforeach;?>
 <tr><td colspan="3" align="center" style="border:1px solid #000">
<?php echo $formAdolDerechos->error($modeloVerifDerechos,'id_derechocespa',array('style' => 'color:#F00'));?>
<div class="row" >
                    <?php
                        $modeloVerifDerechos->id_instanciader=2; 
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
                        // $modeloVerifDerechos->num_doc='2342342';
                        echo $formAdolDerechos->hiddenField($modeloVerifDerechos,'num_doc');?>
                    <?php echo $formAdolDerechos->error($modeloVerifDerechos,'num_doc',array('style' => 'color:#F00'));?></div>
    </td></tr>
</table>
<?php $this->endWidget();?>
</div>
<?php //script de seguridad que previene dejar la página si no se han guardado los datos
Yii::app()->getClientScript()->registerScript('scriptDivFormVerifDer','
	$("#divFormVerifDer").find(":input").attr("disabled","true");	
',CClientScript::POS_END);
 ?>
 
