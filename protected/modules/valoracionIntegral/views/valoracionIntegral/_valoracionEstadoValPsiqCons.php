<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="estValPsiq">
<fieldset id="estValPsiq">
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
                    if($modeloValPsiq->id_estado_val==$estadoCompVal["id_estado_val"]){$selOpt=true;}
                    echo CHtml::radioButton('ValoracionPsiquiatria[id_estado_val]',$selOpt,array(
                        'id'=>'ValoracionPsiquiatria_id_estado_val_'.$estadoCompVal["id_estado_val"],
                        'value'=>$estadoCompVal["id_estado_val"],
                        ))."".$estadoCompVal["estado_val"]."<br/>";
                    $selOpt=false;
                }
            ?>
        </div>
    </div>
</div>
<div class="form-group">
        <div class="col-md-12">
        <?php echo $formEstVal->textArea($modeloValPsiq,
            'observ_estvalpsiq',
            array('class'=>'form-control'));
        ?>    
        <?php echo $formEstVal->error($modeloValPsiq,'observ_estvalpsiq',array('style' => 'color:#F00'));?>
    </div>
</div>
<?php $this->endWidget();?>
</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptEstValPsiq','
	$("#estValPsiq").find(":input").attr("disabled","true");	
'
,CClientScript::POS_END);
?>