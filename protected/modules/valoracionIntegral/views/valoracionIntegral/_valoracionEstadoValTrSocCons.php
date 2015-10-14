<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="estadoValTrSoc">
<fieldset id="estValTrSoc">
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
                    if($modelValTrSoc->id_estado_val==$estadoCompVal["id_estado_val"]){$selOpt=true;}
                    echo CHtml::radioButton('ValoracionTrabajoSocial[id_estado_val]',$selOpt,
                        array(
							'value'=>$estadoCompVal["id_estado_val"],
                            'id'=>'estValTrSoc'.$estadoCompVal["id_estado_val"],
                            'onclick'=>'js:$("#estValTrSoc").addClass("has-warning");enviaFormOpt("formularioEstVal","estValTrSoc")'
                        )
                    )."".$estadoCompVal["estado_val"]."<br/>";
                    $selOpt=false;
                }
            ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-md-12">
        <?php echo $formEstVal->textArea($modelValTrSoc,
            'observ_estvaltsoc',
            array('class'=>'form-control'));
        ?>    
        <?php echo $formEstVal->error($modelValTrSoc,'observ_estvaltsoc',array('style' => 'color:#F00'));?>
    </div>
</div>
<?php $this->endWidget();?>
<hr />
</fieldset></div>
<?php
Yii::app()->getClientScript()->registerScript('scriptEstValTrSoc','
	$("#estadoValTrSoc").find(":input").attr("disabled","true");	
'
,CClientScript::POS_END);
?>
