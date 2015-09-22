<div id="divFromDocsAdol">
<?php $formAdolDoc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDocCespa',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
	<!--campo de texto para nombres del adolescente -->	
    <?php echo  $formAdolDoc->errorSummary($modeloDocCespa,'','',array('style' => 'font-size:14px;color:#F00')); ?>
		<div class="row">
        <?php
		/*$reisgos=$modeloVerifDerechos->consultaProteccion($derecho["id_derecho_adol"]);*/
		foreach($docsCespa as $pk=>$docsCespaAdol){
			if($docsCespaAdol["doc_presentado"]=='t'){
				$preSelectedCategories[]='DocumentoCespa_id_doccespa_'.$pk;
				$op[$docsCespaAdol["id_doccespa"]]=array('selected'=>true);
			}
		}
		?>
            <?php echo $formAdolDoc->labelEx($modeloDocCespa,'id_doccespa'); ?><br />
            <?php if(!empty($docsCespa)):?>
				<?php 
                    foreach($docsCespa as $pk=>$docsCespaAdol){
                        if($docsCespaAdol["doc_presentado"]=='t'):?>
                        <input type="checkbox" name="DocumentoCespa[id_doccespa][]" value="<?php echo $docsCespaAdol["id_doccespa"]?>" id="DocumentoCespa_id_doccespa_<?php echo $pk;?>" checked="checked">
                        <?php else:?>
                            <input type="checkbox" name="DocumentoCespa[id_doccespa][]" value="<?php echo $docsCespaAdol["id_doccespa"]?>" id="DocumentoCespa_id_doccespa_<?php echo $pk;?>">
                        <?php endif;?>
                    <label for="DocumentoCespa_id_doccespa_<?php echo $pk;?>"><?php echo $docsCespaAdol["doccespa"];?></label><br />
                    <?php }?>
        	<?php else:?>
            	<div>No se han registrado los documentos aún</div>
            <?php endif;?>
    	</div>
        <hr />
        <div class="row">
		<?php 
			if(!empty($numDocAdol)){
				$modeloDocCespa->numDocAdol=$numDocAdol;
			}
			echo $formAdolDoc->labelEx($modeloDocCespa,'numDocAdol');?>
		<?php echo CHtml::label($numDocAdol,'numDocLbl',array('id'=>'numDocLblDocC'));?>
        <?php echo $formAdolDoc->hiddenField($modeloDocCespa,'numDocAdol');?>
        <?php echo $formAdolDoc->error($modeloDocCespa,'numDocAdol',array('style' => 'color:#F00'));?>
        </div>
<?php $this->endWidget();?>
</div>
<?php 
Yii::app()->getClientScript()->registerScript('scriptDocsAdol','
	$("#divFromDocsAdol").find(":input").attr("disabled","true");	
	'
,CClientScript::POS_END);
 ?>