<div id="valPsiq">
<fieldset id="histPsiqAnt">
<?php 
$formHistPsiq=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioHistPsiq',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formHistPsiq->errorSummary($modeloValPsiq,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formHistPsiq->labelEx($modeloValPsiq,'hist_psiq_ant',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formHistPsiq->textArea($modeloValPsiq,
                'hist_psiq_ant',
                array('class'=>'form-control'));
            ?>
            <?php echo $formHistPsiq->error($modeloValPsiq,'hist_psiq_ant',array('style' => 'color:#F00'));?>
    	</div>
	</div>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="examen">
<?php $formExaMent=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioExaMent',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formExaMent->errorSummary($modeloValPsiq,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formExaMent->labelEx($modeloValPsiq,'examen_mental',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formExaMent->textArea($modeloValPsiq,
                'examen_mental',
                array('class'=>'form-control'));
            ?>
            <?php echo $formExaMent->error($modeloValPsiq,'examen_mental',array('style' => 'color:#F00'));?>
   		</div>
	</div>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="analisis">
<?php $formAnalisis=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioAnalisis',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formAnalisis->errorSummary($modeloValPsiq,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formAnalisis->labelEx($modeloValPsiq,'analisis_psiq',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formAnalisis->textArea($modeloValPsiq,
                'analisis_psiq',
                array('class'=>'form-control'));
            ?>
            <?php echo $formAnalisis->error($modeloValPsiq,'analisis_psiq',array('style' => 'color:#F00'));?>
        </div>
	</div>      
<?php $this->endWidget();?>
</fieldset>
<hr />
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
			<?php echo $formDiagnostico->textArea($modeloValPsiq,
                'diagnostico_psiq',
                array('class'=>'form-control'));
            ?>
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
			<?php echo $formRecomendaciones->textArea($modeloValPsiq,
                'recomend_psic',
                array('class'=>'form-control'));
            ?>
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