<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="valEnf">
<fieldset id="afSalud">
<div class="panel-heading color-sdis">Afiliación a salud</div> 
<?php $formSgsssAdol=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioSgsssAdol',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="vincPrevSrpaTable">
	<tr>
        <td style=" border:1px solid #000; width:25%"><label class="control-label">Regimen salud</label></td>
        <td style=" border:1px solid #000;width:25%"><label class="control-label">EPS</label></td>
	</tr>
    <tr>        
        <td style=" border:1px solid #000;width:25%">
            <div class="form-group">
                <div class="col-md-12">		
					<?php 
                        $opTipoRegSal[$modeloSgsss->id_regimen_salud]=array('selected'=>true);
                        echo $formSgsssAdol->dropDownList($modeloSgsss,'id_regimen_salud',CHtml::listData($regSalud,'id_regimen_salud','regimen_salud'),
                            array(
                                'prompt'=>"seleccione un régimen",
                                'options' => $opTipoRegSal,
                                'class'=>' form-control','data-hide-disabled'=>'true','data-live-search'=>'true',
                            )
                        );
                        $opTipoRegSal="";
                    ?> 
                    <?php echo $formSgsssAdol->error($modeloSgsss,'id_regimen_salud',array('style' => 'color:#F00'));?>
                </div>
        	</div>
        </td>
        <td style=" border:1px solid #000;width:25%">
            <div class="form-group">
                <div class="col-md-12">		
					<?php 
                        $opTipoEps[$modeloSgsss->id_eps_adol]=array('selected'=>true);
                        echo $formSgsssAdol->dropDownList($modeloSgsss,'id_eps_adol',CHtml::listData($eps,'id_eps_adol','eps_adol'),
                            array(
                                'prompt'=>"seleccione eps",
                                'options' => $opTipoEps,
                                'class'=>'form-control','data-hide-disabled'=>'true','data-live-search'=>'true',
                            )
                        );
                        $opTipoEps="";
                    ?> 
                    <?php echo $formSgsssAdol->error($modeloSgsss,'id_eps_adol',array('style' => 'color:#F00'));?>
                </div>
        	</div>
        </td>
	</tr>
</table>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="antClFam">
<?php $formAntCl=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioAntCl',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formAntCl->errorSummary($modeloValEnf,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formAntCl->labelEx($modeloValEnf,'antecedentes_clinic',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formAntCl->textArea($modeloValEnf,
                'antecedentes_clinic',
                array('class'=>'form-control'));
            ?>
            <?php echo $formAntCl->error($modeloValEnf,'antecedentes_clinic',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<hr />

<fieldset id="examFis">
<?php $formExFis=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioExFis',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formExFis->errorSummary($modeloValEnf,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formExFis->labelEx($modeloValEnf,'examen_fisico_fisiol',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formExFis->textArea($modeloValEnf,
                'examen_fisico_fisiol',
                array('class'=>'form-control'));
            ?>
            <?php echo $formExFis->error($modeloValEnf,'examen_fisico_fisiol',array('style' => 'color:#F00'));?>
        </div>
    </div>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="obsGenEnferm">
<?php $formObs=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioObs',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formObs->errorSummary($modeloValEnf,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formObs->labelEx($modeloValEnf,'obs_gen_enferm',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formObs->textArea($modeloValEnf,
                'obs_gen_enferm',
                array('class'=>'form-control'));
            ?>
            <?php echo $formObs->error($modeloValEnf,'obs_gen_enferm',array('style' => 'color:#F00'));?>
   		</div>
    </div>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="recSalud">
<?php $formRecom=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioRecom',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formRecom->errorSummary($modeloValEnf,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formRecom->labelEx($modeloValEnf,'recom_aten_salud',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formRecom->textArea($modeloValEnf,
                'recom_aten_salud',
                array('class'=>'form-control'));
            ?>
            <?php echo $formRecom->error($modeloValEnf,'recom_aten_salud',array('style' => 'color:#F00'));?>
    	</div>
	</div>        
<?php $this->endWidget();?>
<hr />
</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptValEnf','
	$("#valEnf").find(":input").attr("disabled","true");	
'
,CClientScript::POS_END);
?>