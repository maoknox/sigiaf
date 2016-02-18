<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="valTO">
<fieldset id="desempAreaOcup">
<?php $formDesArOc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDesArOc',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formDesArOc->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
			<?php echo $formDesArOc->labelEx($modeloValTO,'desemp_area_ocup',array('class'=>'control-label','for'=>'searchinput'));?>
			<div class="cont-infoval"><?php echo $modeloValTO->desemp_area_ocup?></div>											                    
            <?php echo $formDesArOc->error($modeloValTO,'desemp_area_ocup',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="desempLaboral">
<?php $formDesLab=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDesLab',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formDesLab->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
       <div class="col-md-4">
    		<?php echo $formDesLab->labelEx($modeloValTO,'desemp_laboral',array('class'=>'control-label','for'=>'searchinput'));?><br />
			<?php echo $formDesLab->labelEx($modeloValTO,'id_tipo_trab',array('class'=>'control-label','for'=>'searchinput'));?><br />
			<?php 
                $selOpt=false;
                foreach($tipoTrabajador as $tipoTrabajadorVal){
                    if($modeloValTO->id_tipo_trab==$tipoTrabajadorVal["id_tipo_trab"]){$selOpt=true;}
                    echo CHtml::radioButton('ValoracionTeo[id_tipo_trab]',$selOpt,
                        array(
                            'value'=>$tipoTrabajadorVal["id_tipo_trab"],
                            'id'=>'ValoracionTeo_id_tipo_trab_'.$tipoTrabajadorVal["id_tipo_trab"],
                            'onclick'=>'js:$("#desempLaboral").addClass("has-warning");enviaFormOpt("formularioDesLab","desempLaboral");'))."".$tipoTrabajadorVal["tipo_trab"]."<br/>";
                    $selOpt=false;
                }
            ?>
            <?php echo $formDesLab->error($modeloValTO,'id_tipo_trab',array('style' => 'color:#F00'));?>
    	</div>    
        <div class="col-md-4">
			<?php echo $formDesLab->labelEx($modeloValTO,'id_sector_lab',array('class'=>'control-label','for'=>'searchinput'));?><br />
			<?php 
                $selOpt=false;
                foreach($sectorLaboral as $sectorLaboralVal){
                    if($modeloValTO->id_sector_lab==$sectorLaboralVal["id_sector_lab"]){$selOpt=true;}
                    echo CHtml::radioButton('ValoracionTeo[id_sector_lab]',$selOpt,
                        array(
                            'value'=>$sectorLaboralVal["id_sector_lab"],
                            'id'=>'ValoracionTeo_id_sector_lab_'.$sectorLaboralVal["id_sector_lab"],
                            'onclick'=>'js:$("#desempLaboral").addClass("has-warning");enviaFormOpt("formularioDesLab","desempLaboral");'))."".$sectorLaboralVal["sector_lab"]."<br/>";
                    $selOpt=false;
                }
            ?>
            <?php echo $formDesLab->error($modeloValTO,'id_sector_lab',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="desempLaboralTxt">
<?php $formularioDesLabTxt=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDesLabTxt',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formularioDesLabTxt->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
			<?php echo $formularioDesLabTxt->labelEx($modeloValTO,'desemp_laboral',array('class'=>'control-label','for'=>'searchinput'));?> - Observaciones
			<div class="cont-infoval"><?php echo $modeloValTO->desemp_laboral?></div>											                    			
            <?php echo $formularioDesLabTxt->error($modeloValTO,'desemp_laboral',array('style' => 'color:#F00'));?>
        </div>    
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="patronDesemp">
<?php $formPatDes=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioPatDes',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formPatDes->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
			<?php echo $formPatDes->labelEx($modeloValTO,'patron_desemp',array('class'=>'control-label','for'=>'searchinput'));?>
			<div class="cont-infoval"><?php echo $modeloValTO->patron_desemp?></div>											                    						
            <?php echo $formPatDes->error($modeloValTO,'patron_desemp',array('style' => 'color:#F00'));?>
        </div>    
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="interesExpectOcup">
<?php $formIntExp=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioIntExp',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formIntExp->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
			<?php echo $formIntExp->labelEx($modeloValTO,'interes_expect_ocup',array('class'=>'control-label','for'=>'searchinput'));?>
			<div class="cont-infoval"><?php echo $modeloValTO->interes_expect_ocup?></div>											                    									
            <?php echo $formIntExp->error($modeloValTO,'interes_expect_ocup',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="aptitHabilidDestrezas">
<?php $formApHabDes=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioApHabDes',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formApHabDes->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
			<?php echo $formApHabDes->labelEx($modeloValTO,'aptit_habilid_destrezas',array('class'=>'control-label','for'=>'searchinput'));?>
			<div class="cont-infoval"><?php echo $modeloValTO->aptit_habilid_destrezas?></div>			
            <?php echo $formApHabDes->error($modeloValTO,'aptit_habilid_destrezas',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="criteriosAreaInt">
<?php $formUbArInt=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioUbArInt',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formUbArInt->errorSummary($modeloValTO,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
			<?php echo $formUbArInt->labelEx($modeloValTO,'criterios_area_int',array('class'=>'control-label','for'=>'searchinput'));?>
			<div class="cont-infoval"><?php echo $modeloValTO->criterios_area_int?></div>						
            <?php echo $formUbArInt->error($modeloValTO,'criterios_area_int',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptValTO','
	$("#valTO").find(":input").attr("disabled","true");	
'
,CClientScript::POS_END);
?>
