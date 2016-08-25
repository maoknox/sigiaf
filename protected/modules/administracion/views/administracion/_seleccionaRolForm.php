<fieldset>  
    <legend>Modificar Acceso a roles</legend>
	<?php $formularioSeleccRol=$this->beginWidget('CActiveForm', array(
        'id'=>'formularioSeleccRol',
		'action'=>'modificaAccesosRolForm',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>false,
        ),
        'htmlOptions' => array('class' => 'form-horizontal')
    ));
    ?>
    <div class="form-group"> 
                <?php echo $formularioSeleccRol->labelEx($modeloRol,'id_rol',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
           <?php echo $formularioSeleccRol->dropDownList($modeloRol,'id_rol',CHtml::listData($roles,'id_rol', 'nombre_rol'), 
                    array(
                        //'multiple'=>'multiple',
                        'prompt'=>'Seleccione...',
                        'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true'
                        ,'onChange'=>'js:$("#formularioSeleccRol").addClass("has-warning");$("#Rol_nombre_rol").val($("#Rol_id_rol option:selected").html())'							
                    )); ?>
            <?php echo $formularioSeleccRol->error($modeloRol,'id_rol',array('style' => 'color:#F00')); ?>     
            
			<?php //echo $formularioLabClinicos->labelEx($modeloLabclinValnutr,'resultado_labclin',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <?php echo $formularioSeleccRol->hiddenField($modeloRol,'nombre_rol'); ?>     
        </div>
    </div>
        <div class="form-group"> 
                <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
        	<?php
				echo CHtml::submitButton('Consultar',array('id'=>'btnAsocContr','class'=>'btn btn-default btn-sdis','name'=>'btnAsocContr'));
			?>
        </div>
    </div>

<?php $this->endWidget();?>   
	
</fieldset>

