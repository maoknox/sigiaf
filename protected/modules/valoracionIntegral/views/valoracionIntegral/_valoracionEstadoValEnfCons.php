<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="estValEnf">

<fieldset id="estValEnf">
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
                foreach($estadoCompVal as $estadoCompVal){
                    if($modeloValEnf->id_estado_val==$estadoCompVal["id_estado_val"]){$selOpt=true;}
                    echo CHtml::radioButton('ValoracionEnfermeria[id_estado_val]',$selOpt,
                        array(
                            'id'=>'ValoracionEnfermeria_id_estado_val_'.$estadoCompVal["id_estado_val"],
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
		<?php echo $formEstVal->textArea($modeloValEnf,
            'observ_estvalenf',
            array('class'=>'form-control'));
        ?>    
        <?php echo $formEstVal->error($modeloValEnf,'observ_estvalenf',array('style' => 'color:#F00'));?>
	</div>
</div>
<?php $this->endWidget();?>
<hr />
</fieldset>

</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptEstValEnf','
	$("#estValEnf").find(":input").attr("disabled","true");	
'
,CClientScript::POS_END);
?>