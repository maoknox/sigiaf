<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->

<div id="divFormConPlanIntTO" >
<fieldset id="conceptoTeo">
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
			<?php echo $formConcOc->textArea($modeloValTO,
                'concepto_teo',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioConcOc","conceptoTeo")',
                    'onkeyup'=>'js:$("#conceptoTeo").addClass("has-warning")'
                ));
            ?>
			<?php echo $formConcOc->error($modeloValTO,'concepto_teo',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div class="form-group">
        <div class="col-md-12">
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormConcOc','class'=>'btn btn-default btn-sdis','name'=>'btnFormConcOc','onclick'=>'js:enviaForm("formularioConcOc","conceptoTeo")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
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
			<?php echo $formPryPlInt->textArea($modeloValTO,
                'plan_interv_teo',
                array('style'=>'width:99.5%;',
                    'onblur'=>'js:enviaForm("formularioPryPlInt","planIntervTeo")',
                    'onkeyup'=>'js:$("#planIntervTeo").addClass("has-warning")'
                ));
            ?>
            <?php echo $formPryPlInt->error($modeloValTO,'plan_interv_teo',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormPryPlInt','class'=>'btn btn-default btn-sdis','name'=>'btnFormPryPlInt','onclick'=>'js:enviaForm("formularioPryPlInt","planIntervTeo")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scripValTO_2','
	$(document).ready(function(){
		$("#divFormConPlanIntTO").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
	});',CClientScript::POS_END);
?>


