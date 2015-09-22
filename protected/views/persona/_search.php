<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_cedula'); ?>
		<?php echo $form->textField($model,'id_cedula'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre_personal'); ?>
		<?php echo $form->textField($model,'nombre_personal',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'apellidos_personal'); ?>
		<?php echo $form->textField($model,'apellidos_personal',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->