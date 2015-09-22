<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'persona-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_cedula'); ?>
		<?php echo $form->textField($model,'id_cedula'); ?>
		<?php echo $form->error($model,'id_cedula'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre_personal'); ?>
		<?php echo $form->textField($model,'nombre_personal',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'nombre_personal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apellidos_personal'); ?>
		<?php echo $form->textField($model,'apellidos_personal',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'apellidos_personal'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->