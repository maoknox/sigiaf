<?php 
	if(!empty($telefonoAcud)){
		foreach($telefonoAcud as $telefono){
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
<div id="divFormFamiliar">
<?php $formAcudiente=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioAcudiente',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>

	<!--campo de texto para nombres del adolescente -->	
    <?php echo  $formAcudiente->errorSummary($modeloAcudiente,'','',array('style' => 'font-size:14px;color:#F00')); ?>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloAcudiente,'nombres_familiar',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloAcudiente,'nombres_familiar',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloAcudiente,'nombres_familiar',array('style' => 'color:#F00'));?>
		</div>
    </div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloAcudiente,'apellidos_familiar',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloAcudiente,'apellidos_familiar',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloAcudiente,'apellidos_familiar',array('style' => 'color:#F00'));?>
        </div>    
    </div>    
    <div class="form-group">                                       
    <?php echo $formAcudiente->labelEx($modeloAcudiente,'id_tipo_doc',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
			<?php echo $formAcudiente->dropDownList($modeloAcudiente,'id_tipo_doc',CHtml::listData($tipoDocBd,'id_tipo_doc', 'tipo_doc'), array('prompt'=>'Seleccione Tipo documento','class'=>'form-control input-md')); ?>
            <?php echo $formAcudiente->error($modeloAcudiente,'id_tipo_doc',array('style' => 'color:#F00')); ?>
        </div>
	</div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloAcudiente,'num_doc_fam',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloAcudiente,'num_doc_fam',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloAcudiente,'num_doc_fam',array('style' => 'color:#F00'));?>
        </div>
    </div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloAcudiente,'id_parentesco',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->dropDownList(
                $modeloAcudiente,
                'id_parentesco',
                CHtml::listData($parentesco,'id_parentesco', 'parentesco'), 
                array('prompt'=>'Seleccione parentesco','class'=>'form-control input-md')); 
            ?>
            <?php echo $formAcudiente->error($modeloAcudiente,'id_parentesco',array('style' => 'color:#F00'));?>
        </div>
    </div> 
    <div class="form-group">                                       
    <?php echo $formAcudiente->labelEx($modeloLocalizacion,'id_localidad',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
			<?php echo $formAcudiente->dropDownList($modeloLocalizacion,'id_localidad',CHtml::listData($localidad,'id_localidad', 'localidad'), array('prompt'=>'Seleccione Localidad','class'=>'form-control input-md')); ?>
            <?php echo $formAcudiente->error($modeloLocalizacion,'id_tipo_doc',array('style' => 'color:#F00')); ?>
        </div>
	</div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloLocalizacion,'barrio',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloLocalizacion,'barrio',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloLocalizacion,'barrio',array('style' => 'color:#F00'));?>
		</div>
    </div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloLocalizacion,'direccion',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloLocalizacion,'direccion',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloLocalizacion,'direccion',array('style' => 'color:#F00'));?>
		</div>
    </div>
    <div class="form-group">                                       
    <?php echo $formAcudiente->labelEx($modeloLocalizacion,'id_estrato',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
			<?php echo $formAcudiente->dropDownList($modeloLocalizacion,'id_estrato',CHtml::listData($estrato,'id_estrato', 'estrato'), array('prompt'=>'Seleccione Estrato','class'=>'form-control input-md')); ?>
            <?php echo $formAcudiente->error($modeloLocalizacion,'id_estrato',array('style' => 'color:#F00')); ?>
		</div>
	</div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloTelefono,'telefono',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloTelefono,'telefono',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloTelefono,'telefono',array('style' => 'color:#F00'));?>
		</div>            
	</div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloTelefono,'tel_sec',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloTelefono,'tel_sec',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloTelefono,'tel_sec',array('style' => 'color:#F00'));?>
        </div>
	</div>
    <div class="form-group">                                       
	<?php echo $formAcudiente->labelEx($modeloTelefono,'celular',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo $formAcudiente->textField($modeloTelefono,'celular',array('class'=>'form-control input-md'));?>
            <?php echo $formAcudiente->error($modeloTelefono,'celular',array('style' => 'color:#F00'));?>
		</div>
    </div>   
    <hr />
     <div class="row">
	<?php
		if(!empty($numDocAdol)){
			$modeloLocalizacion->num_doc=$numDocAdol;
		} 
		echo $formAcudiente->labelEx($modeloLocalizacion,'num_doc');?>
	<?php echo CHtml::label($numDocAdol,'numDocLbl',array('id'=>'numDocAdolAcud'));?>
	<?php echo $formAcudiente->hiddenField($modeloLocalizacion,'num_doc');?>
	<?php echo $formAcudiente->error($modeloLocalizacion,'num_doc',array('style' => 'color:#F00'));?>
	</div>
<?php $this->endWidget();?>
</div>
<?php //script de seguridad que previene dejar la página si no se han guardado los datos
Yii::app()->getClientScript()->registerScript('scriptConsDatosFam','
	$("#divFormFamiliar").find(":input").attr("disabled","true");	
'
,CClientScript::POS_END); ?>