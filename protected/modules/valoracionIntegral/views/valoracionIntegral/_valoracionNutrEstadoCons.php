<div id="divFormEstValPsicol">
<fieldset id="estadoVal">
<?php $formEstVal=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioEstVal',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<!--campo de texto para nombres del adolescente -->	
<div class="form-group">
    <div class="col-md-12">	
	<label class="control-label" for="radios">Estado de la valoración</label>
    <div class="radio">
    <?php 
		$selOpt=false;
		foreach($estadoCompVal as $estadoCompVal){//revisar
			if($modeloValNutr->id_estado_val==$estadoCompVal["id_estado_val"]){$selOpt=true;}
			echo CHtml::radioButton('ValoracionNutricional[id_estado_val]',$selOpt,array('value'=>$estadoCompVal["id_estado_val"],'id'=>'estValPsic'.$estadoCompVal["id_estado_val"]))."".$estadoCompVal["estado_val"]."<br/>";
			$selOpt=false;
		}
	?></div>
    </div>
    </div>
    <div class="form-group">
    	<div class="col-md-12">
   		<div class='cont-infoval'><?php echo $modeloValNutr->observ_estvalnutr;?></div>												   
	<?php echo $formEstVal->error($modeloValNutr,'observ_estvalnutr',array('style' => 'color:#F00'));?>
</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
</div>

<?php
Yii::app()->getClientScript()->registerScript('scriptEstadoValCons','		
	$(document).ready(function(){
		$("#divFormEstValPsicol").find(":input").attr("disabled","disabled");
	});
',CClientScript::POS_END);
?>
