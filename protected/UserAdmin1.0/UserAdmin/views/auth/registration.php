<div class='registrationForm'>
        <?php $form = $this->beginWidget('CActiveForm', array(
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                        'validateOnChange'=>false,
                ),
        )); ?>
        
                <?php echo $form->labelEx($model, 'login'); ?>
                <?php echo $form->textField($model, 'login', array('autocomplete'=>'off')); ?>
                <?php echo $form->error($model, 'login'); ?>

                <?php echo $form->labelEx($model, 'password'); ?>
                <?php echo $form->passwordField($model, 'password'); ?>
                <?php echo $form->error($model, 'password'); ?>

                <?php echo $form->labelEx($model, 'repeat_password'); ?>
                <?php echo $form->passwordField($model, 'repeat_password'); ?>
                <?php echo $form->error($model, 'repeat_password'); ?>

                <?php echo $form->labelEx($model,'captcha'); ?>
                <?php $this->widget('CCaptcha', array(
                        'clickableImage'=>true,
                        'showRefreshButton'=>false,
                )) ?>
                <?php echo $form->textField($model, 'captcha') ?>
                <?php echo $form->error($model, 'captcha'); ?>

        
                <br>
                <?php echo CHtml::submitButton(Yii::t('UserAdminModule.LoginForm', 'Register'),array('class'=>'btn')); ?>
        
        <?php $this->endWidget(); ?>
</div>
