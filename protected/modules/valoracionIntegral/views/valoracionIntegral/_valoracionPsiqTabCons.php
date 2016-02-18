<div id="valPsiq">
<fieldset id="diagnostico">
<?php $formDiagnostico=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDiagnostico',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formDiagnostico->errorSummary($modeloValPsiq,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formDiagnostico->labelEx($modeloValPsiq,'diagnostico_psiq',array('class'=>'control-label','for'=>'searchinput'));?>
        	<div class="cont-infoval"><?php echo $modeloValPsiq->diagnostico_psiq?></div>        												
            <?php echo $formDiagnostico->error($modeloValPsiq,'diagnostico_psiq',array('style' => 'color:#F00'));?>
   		</div>
	</div>    
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="recomendaciones">
<?php $formRecomendaciones=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioRecomendaciones',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formRecomendaciones->errorSummary($modeloValPsiq,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formRecomendaciones->labelEx($modeloValPsiq,'recomend_psic',array('class'=>'control-label','for'=>'searchinput'));?>
        	<div class="cont-infoval"><?php echo $modeloValPsiq->recomend_psic?></div>        									
            <?php echo $formDiagnostico->error($modeloValPsiq,'recomend_psic',array('style' => 'color:#F00'));?>
        </div>
	</div>  
<?php $this->endWidget();?>
</fieldset>

</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptValPsiq','
	$("#valPsiq").find(":input").attr("disabled","true");	
'
,CClientScript::POS_END);
?>