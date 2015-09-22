<div id="divFormLocAdol">
<?php 
	if(!empty($telefonoAdol)){
		foreach($telefonoAdol as $telefono){
			if($telefono["id_tipo_telefono"]==1){
				$modeloTelefono->telefono=$telefono["telefono"];
			}
			elseif($telefono["id_tipo_telefono"]==2){
				$modeloTelefono->tel_sec=$telefono["telefono"];
			}
			else{
				$modeloTelefono->celular=$telefono["telefono"];
			}
		}	
	}
?>
<?php $formLoc=$this->beginWidget('CActiveForm', array(
	'id'=>'formLocalizacion',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
<?php echo  $formLoc->errorSummary($modeloLocalizacion,'','' ,array('style' => 'font-size:14px;color:#F00')); ?>

	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group"> 
	<?php echo $formLoc->labelEx($modeloLocalizacion,'id_localidad',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formLoc->dropDownList($modeloLocalizacion,'id_localidad',CHtml::listData($localidad,'id_localidad', 'localidad'), array('prompt'=>'Seleccione Localidad','class'=>'form-control input-md')); ?>
            <?php echo $formLoc->error($modeloLocalizacion,'id_tipo_doc',array('style' => 'color:#F00')); ?>
		</div>
    </div>
    <div class="form-group">                                       
	<?php echo $formLoc->labelEx($modeloLocalizacion,'barrio',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formLoc->textField($modeloLocalizacion,'barrio',array('class'=>'form-control input-md'));?>
            <?php echo $formLoc->error($modeloLocalizacion,'barrio',array('style' => 'color:#F00'));?>
   		</div>
    </div>
	<div class="form-group">                                       
	<?php echo $formLoc->labelEx($modeloLocalizacion,'direccion',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formLoc->textField($modeloLocalizacion,'direccion',array('class'=>'form-control input-md'));?>
            <?php echo $formLoc->error($modeloLocalizacion,'direccion',array('style' => 'color:#F00'));?>
        </div>
    </div>
	<div class="form-group">                                       
    <?php echo $formLoc->labelEx($modeloLocalizacion,'id_estrato',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
			<?php echo $formLoc->dropDownList($modeloLocalizacion,'id_estrato',CHtml::listData($estrato,'id_estrato', 'estrato'), array('prompt'=>'Seleccione Estrato','class'=>'form-control input-md')); ?>
            <?php echo $formLoc->error($modeloLocalizacion,'id_estrato',array('style' => 'color:#F00')); ?>
		</div>
    </div>
	<div class="form-group">                                       
	<?php echo $formLoc->labelEx($modeloTelefono,'telefono',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
            <?php echo $formLoc->textField($modeloTelefono,'telefono',array('class'=>'form-control input-md'));?>
           <?php echo $formLoc->error($modeloTelefono,'telefono',array('style' => 'color:#F00'));?>
        </div>    
	</div>
	<div class="form-group">                                       
	<?php echo $formLoc->labelEx($modeloTelefono,'tel_sec',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formLoc->textField($modeloTelefono,'tel_sec',array('class'=>'form-control input-md'));?>
            <?php echo $formLoc->error($modeloTelefono,'tel_sec',array('style' => 'color:#F00'));?>
        </div>    
	</div>
	<div class="form-group">                                       
	<?php echo $formLoc->labelEx($modeloTelefono,'celular',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formLoc->textField($modeloTelefono,'celular',array('class'=>'form-control input-md'));?>
            <?php echo $formLoc->error($modeloTelefono,'celular',array('style' => 'color:#F00'));?>
        </div>    
	</div>
    <hr />
     <div class="row">
	<?php 
		if(!empty($numDocAdol)){
			$modeloLocalizacion->num_doc=$numDocAdol;
		}
		echo $formLoc->labelEx($modeloLocalizacion,'num_doc');?>
	<?php echo CHtml::label($numDocAdol,'numDocLbl',array('id'=>'numDocLblLoc'));?>
	<?php echo $formLoc->hiddenField($modeloLocalizacion,'num_doc');?>
	<?php echo $formLoc->error($modeloLocalizacion,'num_doc',array('style' => 'color:#F00'));?>
	</div>
<?php $this->endWidget();?>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptConsLocAdol','
	$("#divFormLocAdol").find(":input").attr("disabled","true");	
'
,CClientScript::POS_END);
?>
