<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
//Yii::app()->getSession()->add('cedula', 80760766);
//Yii::app()->getSession()->remove('cedula');
if(!Yii::app()->user->isGuest){
	Yii::app()->user->returnUrl = array("controlAp/index"); 
	$this->redirect(Yii::app()->user->returnUrl);	
	Yii::app()->getSession()->remove('cedula');
}
else{
echo Yii::app()->getSession()->get('nombreVariable');
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<fieldset>

<!-- Form Name -->
<legend>Acceso</legend>


<p>Por favor acceda con su nombre de usuario y contraseña</p>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')

)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<div class="form-group">
		<?php echo $form->labelEx($model,'nombreusuario',array('class'=>'col-md-4 control-label')); ?>
        <div class="col-md-4">
			<?php echo $form->textField($model,'nombreusuario',array('class'=>'form-control input-md')); ?>
            <?php echo $form->error($model,'nombreusuario',array('style' => 'color:#F00')); ?>
		</div>
   </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'claveusr',array('class'=>'col-md-4 control-label')); ?>
        <div class="col-md-4">
			<?php echo $form->passwordField($model,'claveusr',array('class'=>'form-control input-md')); ?>
            <?php echo $form->error($model,'claveusr',array('style' => 'color:#F00')); ?>
		</div>
    </div>
    <div class="row">
		<?php $model->id_forjar="0"; ?>
		<?php echo $form->hiddenField($model,'id_forjar'); ?>
		<?php echo $form->error($model,'id_forjar',array('style' => 'color:#F00')); ?>
	</div>
    <div class="row">
		<?php $model->id_forjar="0"; ?>
		<?php echo $form->hiddenField($model,'contrato'); ?>
		<?php echo $form->error($model,'contrato',array('style' => 'color:#F00')); ?>
	</div>
    
    <div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
		<?php echo CHtml::submitButton('Acceder',array('id'=>'btnCreaSede','name'=>'btnCreaAdolN','class'=>'btn btn-default btn-sdis')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
</fieldset>
<?php } ?>

<?php

/* $hash=  hash_init('sha1',HASH_HMAC,Yii::app()->params["hash_key"]);
        hash_update($hash, '1234');
		echo hash_final($hash)."<br>";
		echo sha1('mauricio');
*/?>
