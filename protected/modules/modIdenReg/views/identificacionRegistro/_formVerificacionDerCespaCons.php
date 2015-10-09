<div id="MensajeVerifDer" style="font-size:14px;"></div>
<?php
	$modeloVerifDerechos->num_doc=$numDocAdol;
	$modeloVerifDerechos->id_instanciader=1; 
	$modeloVerifDerechos->id_momento_verif=1; 	
	$derechos=$modeloVerifDerechos->consultaDerechos();//id_derechocespa
?>
<?php if(!empty($derechos)):?>

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
     <?php  else: ?>
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
                    Al adolescente no se le hizo el análisis de la situación de derechos
                </div>
            </div>
        </div>
    </div>
    <hr />

     <?php endif; ?>
