<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="concPIntTO">

<fieldset id="conceptoTeo">
<legend><strong>Concepto ocupacional</strong></legend>
<?php $formConcOc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioConcOc',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formConcOc->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formConcOc->labelEx($modeloValTO,'concepto_teo',array('class'=>'control-label','for'=>'searchinput'));?>
			<div class="cont-infoval"><?php echo $modeloValTO->concepto_teo?></div>									
			<?php echo $formConcOc->error($modeloValTO,'concepto_teo',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="planIntervTeo">
<?php $formPryPlInt=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioPryPlInt',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formPryPlInt->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formPryPlInt->labelEx($modeloValTO,'plan_interv_teo',array('class'=>'control-label','for'=>'searchinput'));?>
			<div class="cont-infoval"><?php echo $modeloValTO->plan_interv_teo?></div>												
            <?php echo $formPryPlInt->error($modeloValTO,'plan_interv_teo',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptConcPIntTO','
	$("#concPIntTO").find(":input").attr("disabled","true");	
'
,CClientScript::POS_END);
?>

