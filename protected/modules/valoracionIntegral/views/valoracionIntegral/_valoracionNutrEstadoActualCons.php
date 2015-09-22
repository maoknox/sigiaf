<div id="formNutrEstadoActual">
	<?php $formularioExamenFisico=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioExamenFisico',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
<code  onclick="js:muestraTablaExamen();" style="cursor:help">Ver tabla</code>
	<div id="divProcPadres" class="form-group">
    	<div class="col-sm-12">
            <?php echo $formularioExamenFisico->labelEx($modeloValNutr,'examen_fisico',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioExamenFisico->textArea($modeloValNutr,'examen_fisico',array('class'=>'form-control','onchange'=>'js:$("#formularioExamenFisico").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloValNutr,'examen_fisico',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
   <hr />
	<?php $formularioAntrValIni=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioAntrValIni',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
    <?php
		if(!empty($antropometriaAdol)){
			$modeloAntropometria->attributes=$antropometriaAdol;
			$modeloAntropometria->id_antropometria=$antropometriaAdol["id_antropometria"];
			$accion='modifAntropometriaValIni';
		}
		else{
			$accion='registraAntropometriaValIni';			
		}
	?>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'antr_peso_kgs',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'antr_peso_kgs',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'antr_peso_kgs',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'antr_talla_cms',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'antr_talla_cms',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'antr_talla_cms',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'antr_imc',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'antr_imc',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'antr_imc',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'circunf_cefalica',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'circunf_cefalica',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'circunf_cefalica',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <hr />
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'antr_peso_ideal',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'antr_peso_ideal',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'antr_peso_ideal',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'antr_talla_ideal',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'antr_talla_ideal',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'antr_talla_ideal',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'antr_ind_p_t_imc_ed',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'antr_ind_p_t_imc_ed',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'antr_ind_p_t_imc_ed',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div id="divProcPadres" class="form-group">
        <?php echo $formularioExamenFisico->labelEx($modeloAntropometria,'indice_talla_edad',array('class'=>'control-label col-md-5','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
    	<div class="col-md-2">
			<?php echo $formularioExamenFisico->textField($modeloAntropometria,'indice_talla_edad',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioAntrValIni").addClass("has-warning");'));?>
        	<?php echo $formularioExamenFisico->error($modeloAntropometria,'indice_talla_edad',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
   <hr />
   
</div>
       <?php 
		$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
			'id'=>'juiDialogExam',
			'options'=>array(				
				'title'=>'Tabla examen',
				'autoOpen'=>false,
				'width'=>'60%',
				'show'=>array(
	                'effect'=>'blind',
	                'duration'=>500,
	            ),
				'hide'=>array(
					'effect'=>'explode',
					'duration'=>500,
				),				
			),
		));
		$this->endWidget('zii.widgets.jui.CJuiDialog');
	?>     
<?php
Yii::app()->getClientScript()->registerScript('scriptTablaEstadoActualCons','		
	$(document).ready(function(){
		$("#formNutrEstadoActual").find(":input").attr("disabled","disabled");
	});
',CClientScript::POS_END);
?>



