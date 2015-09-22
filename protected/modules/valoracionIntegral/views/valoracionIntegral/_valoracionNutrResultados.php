<div id="formNutrResultados">
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
			<?php echo $formularioConceptoNutr->textArea($modeloValNutr,'concepto_nutr',array('class'=>'form-control','onkeyup'=>'js:$("#formularioConceptoNutr").addClass("has-warning");'));?>
        	<?php echo $formularioConceptoNutr->error($modeloValNutr,'concepto_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Modificar',   
					array('id'=>'btnFormConcNutr','class'=>'btn btn-default btn-sdis','name'=>'btnFormConcNutr','onclick'=>'js:enviaFormNutr("formularioConceptoNutr","formularioConceptoNutr")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
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
			<?php echo $formularioEstratInterv->textArea($modeloValNutr,'estrategia_intervencion',array('class'=>'form-control','onkeyup'=>'js:$("#formularioEstratInterv").addClass("has-warning");'));?>
        	<?php echo $formularioEstratInterv->error($modeloValNutr,'estrategia_intervencion',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Modificar',   
					array('id'=>'btnFormEstrInt','class'=>'btn btn-default btn-sdis','name'=>'btnFormEstrInt','onclick'=>'js:enviaFormNutr("formularioEstratInterv","formularioEstratInterv")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
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
			<?php echo $formularioObjAlimNutr->textArea($modeloValNutr,'objetivo_aliment_nutr',array('class'=>'form-control','onkeyup'=>'js:$("#formularioObjAlimNutr").addClass("has-warning");'));?>
        	<?php echo $formularioObjAlimNutr->error($modeloValNutr,'objetivo_aliment_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Modificar',   
					array('id'=>'btnFormObjAlimNutr','class'=>'btn btn-default btn-sdis','name'=>'btnFormObjAlimNutr','onclick'=>'js:enviaFormNutr("formularioObjAlimNutr","formularioObjAlimNutr")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
	</div>    
   <?php $this->endWidget();?>
   <hr />
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
			<?php echo $formularioDiagnClasifNutr->textArea($modeloValNutr,'diagnostico_clasif_nutr',array('class'=>'form-control','onkeyup'=>'js:$("#formularioDiagnClasifNutr").addClass("has-warning");'));?>
        	<?php echo $formularioDiagnClasifNutr->error($modeloValNutr,'diagnostico_clasif_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Modificar',   
					array('id'=>'btnFormDiagClNutr','class'=>'btn btn-default btn-sdis','name'=>'btnFormDiagClNutr','onclick'=>'js:enviaFormNutr("formularioDiagnClasifNutr","formularioDiagnClasifNutr")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
	</div>    
   <?php $this->endWidget();?>

</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptResultados_1','		
	$(document).ready(function(){
		$("#formNutrResultados").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			dirtyForm.addClass("unsavedForm");
		});
		$("#labExtr").hide()
	});
',CClientScript::POS_END);
?>

