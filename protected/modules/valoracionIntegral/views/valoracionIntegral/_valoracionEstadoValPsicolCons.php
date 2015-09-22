<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="estadoValPsic" >

<fieldset id="patronCons">
<legend><strong>Estado de la valoración</strong></legend>
<?php $formEstVal=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioEstVal',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
));
?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="row">
    <?php 
		$selOpt=false;
		foreach($estadoCompVal as $estadoCompVal){
			if($modeloValPsicol->id_estado_val==$estadoCompVal["id_estado_val"]){$selOpt=true;}
			echo CHtml::radioButton('ValoracionPsicologia[id_estado_val]',$selOpt,array('id'=>'patronCons_'.$estadoCompVal["id_estado_val"],
			'onclick'=>'js:$("#btnFormEstVal").css("color","#F00")'))."".$estadoCompVal["estado_val"]."<br/>";
			$selOpt=false;
		}
	?>
    <?php echo $formEstVal->textArea($modeloValPsicol,
		'observ_estvalpsicol',
		array('style'=>'width:99.5%;',
		'onkeyup'=>'js:$("#btnFormEstVal").css("color","#F00")'));
	?>    
	<?php echo $formEstVal->error($modeloValPsicol,'observ_estvalpsicol',array('style' => 'color:#F00'));?>

    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
</div>
<?php

Yii::app()->getClientScript()->registerScript('scriptEstValPsic_1','
	$("#estadoValPsic").find(":input").attr("disabled","true");		
'
,CClientScript::POS_END);
?>
