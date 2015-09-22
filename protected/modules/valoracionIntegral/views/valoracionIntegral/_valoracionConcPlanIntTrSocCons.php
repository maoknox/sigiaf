<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="concPIntTrSoc">
<?php $formPerfGV=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioPerfGV',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formPerfGV->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="form-group">
    	<div class="col-md-12">
       		<?php echo $formPerfGV->labelEx($modelValTrSoc,'perfil_gener_vuln',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formPerfGV->textArea($modelValTrSoc,
                'perfil_gener_vuln',
                array('class'=>'form-control'));
            ?>
            <?php echo $formPerfGV->error($modelValTrSoc,'perfil_gener_vuln',array('style' => 'color:#F00'));?>
   		</div>
    </div>
<?php $this->endWidget();?>
<hr />
<?php $formConcSoc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioConcSoc',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formConcSoc->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="form-group">
    	<div class="col-md-12">
       		<?php echo $formConcSoc->labelEx($modelValTrSoc,'concepto_social',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formConcSoc->textArea($modelValTrSoc,
                'concepto_social',
                array('class'=>'form-control'));
            ?>
            <?php echo $formConcSoc->error($modelValTrSoc,'concepto_social',array('style' => 'color:#F00'));?>
        </div>
    </div>
<?php $this->endWidget();?>
<hr />
<?php $formPrInt=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioPrInt',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formPrInt->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="form-group">
    	<div class="col-md-12">
       		<?php echo $formPrInt->labelEx($modelValTrSoc,'pry_pl_int_tsocial',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formPrInt->textArea($modelValTrSoc,
                'pry_pl_int_tsocial',
                array('class'=>'form-control'));
            ?>
			<?php echo $formPrInt->error($modelValTrSoc,'pry_pl_int_tsocial',array('style' => 'color:#F00'));?>
        </div>
    </div>
<?php $this->endWidget();?>
<hr />
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptConcPIntTrSoc','
	$("#concPIntTrSoc").find(":input").attr("disabled","true");	
'
,CClientScript::POS_END);
?>
