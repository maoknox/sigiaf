<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="concPlIntPsicol">
<div id="Mensaje" style="font-size:14px;" ></div>

<fieldset id="conclGenVpsicol">
<?php $formConcGen=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioConcGen',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formConcGen->errorSummary($modeloValPsicol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
<div class="form-group">
    <div class="col-md-12">	
    <?php echo $formConcGen->labelEx($modeloValPsicol,'concl_gen_vpsicol',array('class'=>'control-label','for'=>'searchinput'));?><code data-toggle="tooltip" title='Definir las Hipotesis de trabajo relacionando la conducta delictiva y las problematicas asociadas, entre otras.'>Ayuda</code>
	<?php echo $formConcGen->textArea($modeloValPsicol,
		'concl_gen_vpsicol',
		array('class'=>'form-control',
			'onblur'=>'js:enviaForm("formularioConcGen","conclGenVpsicol");',
			'onkeyup'=>'js:$("#conclGenVpsicol").addClass("has-warning")'
		));
	?>
	<?php echo $formConcGen->error($modeloValPsicol,'concl_gen_vpsicol',array('style' => 'color:#F00'));?>
    </div>
</div>
	<div class="form-group">
        <div class="col-md-4">	

<?php
	$boton=CHtml::Button (
		'Registrar',   
		array('id'=>'btnFormConcGen','class'=>'btn btn-default btn-sdis','name'=>'btnFormConcGen','onclick'=>'js:enviaForm("formularioConcGen","conclGenVpsicol")')
	);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
    </div> 
   </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="pryPlanInterv">
<?php $formProyPlInt=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioProyPlInt',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formProyPlInt->errorSummary($modeloValPsicol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
<div class="form-group">
    <div class="col-md-12">	
    <?php echo $formConcGen->labelEx($modeloValPsicol,'pry_plan_interv',array('class'=>'control-label','for'=>'searchinput'));?><code data-toggle="tooltip" title='Definir si el adolescentes y su familia requieren atención psicosocial o intervención psicoterapéutica. Señalar si se debe vincular a pares o referentes significativos, entre otras.'>Ayuda</code>
	<?php echo $formProyPlInt->textArea($modeloValPsicol,
		'pry_plan_interv',
		array('class'=>'form-control',
			'onblur'=>'js:enviaForm("formularioProyPlInt","pryPlanInterv")',
			'onkeyup'=>'js:$("#pryPlanInterv").addClass("has-warning")'
		));
	?>
	<?php echo $formProyPlInt->error($modeloValPsicol,'pry_plan_interv',array('style' => 'color:#F00'));?>
    </div>
</div>
	<div class="form-group">
        <div class="col-md-4">	

<?php
	$boton=CHtml::Button (
		'Registrar',   
		array('id'=>'btnFormProyPlInt','class'=>'btn btn-default btn-sdis','name'=>'btnFormProyPlInt','onclick'=>'js:enviaForm("formularioProyPlInt","pryPlanInterv")')
	);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
    </div>
    
</div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="remisPsiquiatria" >
<?php $formRemPsiq=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioRemPsiq',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<!--campo de texto para nombres del adolescente -->	
<div class="form-group">
    <div class="col-md-12">
    <label class="control-label" for="radios">¿Se remite el adolescente a Psiquiatría?</label><br />
        <label class="radio-inline" for="radios-0">
        <?php	
            $siRemite=false;
            $noRemite=false;
            if($modeloValPsicol->remis_psiquiatria=="t"){$siRemite=true;}elseif($modeloValPsicol->remis_psiquiatria=="f"){$noRemite=true;}
                ?>
                Si<?php echo CHtml::radioButton('ValoracionPsicologia[remis_psiquiatria]',$siRemite,array('id'=>'ValoracionPsicologia_remis_psiquiatria','value'=>"true",'onclick'=>'js:$("#remisPsiquiatria").addClass("has-warning");enviaFormOpt("formularioRemPsiq","remisPsiquiatria")'));
                ?>
        </label>
        <label class="radio-inline" for="radios-0">
        No<?php echo CHtml::radioButton('ValoracionPsicologia[remis_psiquiatria]',$noRemite,array('id'=>'ValoracionPsicologia_remis_psiquiatria','value'=>"false",'onclick'=>'js:$("#remisPsiquiatria").addClass("has-warning");enviaFormOpt("formularioRemPsiq","remisPsiquiatria")'));			
        ?>
        </label>
    </div>
    </div>
    <div class="form-group">
    	<div class="col-md-12">
	<?php echo $formRemPsiq->textArea($modeloValPsicol,
		'objetivo_remitpsiq',
		array('class'=>'form-control',
		'onblur'=>'js:enviaFormOpt("formularioRemPsiq","remisPsiquiatria")',
		'onkeyup'=>'js:$("#remisPsiquiatria").addClass("has-warning")'));
	?>
	<?php echo $formRemPsiq->error($modeloValPsicol,'objetivo_remitpsiq',array('style' => 'color:#F00'));?>
</div></div>
    <div class="form-group">
    	<div class="col-md-4">
<?php
		$boton=CHtml::Button (
			'Registrar',   
			array('id'=>'btnFormRemPsiq','class'=>'btn btn-default btn-sdis','name'=>'btnFormRemPsiq','onclick'=>'js:enviaFormOpt("formularioRemPsiq","remisPsiquiatria")')
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
Yii::app()->getClientScript()->registerScript('scriptConcPIPsicol_1','
	$(document).ready(function(){
		$("#concPlIntPsicol").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			dirtyForm.addClass("unsavedForm");
		});
	});
',CClientScript::POS_END);
?>