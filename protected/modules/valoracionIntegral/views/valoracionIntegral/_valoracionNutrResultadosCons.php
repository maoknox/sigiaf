<div id="formNutrResultados">
	<?php $formularioDiagnClasifNutr=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioDiagnClasifNutr',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divProcPadres" class="form-group">
    	<div class="col-sm-12">
            <?php echo $formularioDiagnClasifNutr->labelEx($modeloValNutr,'diagnostico_clasif_nutr',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<div class='cont-infoval'><?php echo $modeloValNutr->diagnostico_clasif_nutr;?></div>												
        	<?php echo $formularioDiagnClasifNutr->error($modeloValNutr,'diagnostico_clasif_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
   <hr />
	<?php $formularioConceptoNutr=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioConceptoNutr',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divProcPadres" class="form-group">
    	<div class="col-sm-12">
            <?php echo $formularioConceptoNutr->labelEx($modeloValNutr,'concepto_nutr',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<div class='cont-infoval'><?php echo $modeloValNutr->concepto_nutr;?></div>												
        	<?php echo $formularioConceptoNutr->error($modeloValNutr,'concepto_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
   <hr />
	<?php $formularioEstratInterv=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioEstratInterv',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divProcPadres" class="form-group">
    	<div class="col-sm-12">
            <?php echo $formularioEstratInterv->labelEx($modeloValNutr,'estrategia_intervencion',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<div class='cont-infoval'><?php echo $modeloValNutr->estrategia_intervencion;?></div>												
        	<?php echo $formularioEstratInterv->error($modeloValNutr,'estrategia_intervencion',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
   <hr />
	<?php $formularioObjAlimNutr=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioObjAlimNutr',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divProcPadres" class="form-group">
    	<div class="col-sm-12">
            <?php echo $formularioObjAlimNutr->labelEx($modeloValNutr,'objetivo_aliment_nutr',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<div class='cont-infoval'><?php echo $modeloValNutr->objetivo_aliment_nutr;?></div>												
        	<?php echo $formularioObjAlimNutr->error($modeloValNutr,'objetivo_aliment_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptRestuladoCons','		
	$(document).ready(function(){
		$("#formNutrResultados").find(":input").attr("disabled","disabled");
	});
',CClientScript::POS_END);
?>
