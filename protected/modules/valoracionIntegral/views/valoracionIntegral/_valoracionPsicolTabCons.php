<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="Mensaje" style="font-size:14px;" ></div>
<?php 

/* $this->widget('application.extensions.magnific-popup.EMagnificPopup', array('target' => '.test-popup-link'));*/
?>
<fieldset>
<div class="panel-heading color-sdis">VINCULACIÓN PREVIA AL SRPA</div>

<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="vincPrevSrpaTable"><tr>
	<td style=" border:1px solid #000; width:25%">Delito</td>
    <td style=" border:1px solid #000;width:25%">Medida de internamiento preventivo</td>
    <td style=" border:1px solid #000;width:25%">Sanción impuesta</td>
</tr>
	<?php
		//$consDelitoVinc[]=array('1'=>'1');$consDelitoVinc[]=array('1'=>'1');
	 if(!empty($consDelitoVinc)):?>
    	
		<?php $disabled="disabled"; foreach($consDelitoVinc as $pk=>$consDelitoVinc): $pk+=1; //revisar?>
			<tr>
            	<td style=" border:1px solid #000; width:25%">
					<?php echo $pk;
                        $op[$consDelitoVinc["id_del_rc"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('delito_'.$pk,'delito_'.$pk,CHtml::listData($delitos,'id_del_rc','del_remcespa'),
                     		array(
								'prompt'=>'Seleccione Delito',
                       	 		'options' => $op,
								'style'=>'width:100%',
								'onchange'=>'js:$("#btnDelVinc_'.$pk.'").addClass("unsavedForm");$("#btnDelVinc_'.$pk.'").css("color","#F00");',
								'disabled'=>$disabled
                       		)
                    	);
						$op="";
					?>               
               </td>
               <td style=" border:1px solid #000; width:20%">
					<?php 
                        if($consDelitoVinc["medida_int_prev"]==1){$consDelitoVinc["medida_int_prev"]=true;}else{$consDelitoVinc["medida_int_prev"]=false;}
                            echo CHtml::CheckBox('intprev_'.$pk,$consDelitoVinc["medida_int_prev"], array (
                                'value'=>'true',
								'disabled'=>$disabled,
								'onchange'=>'js:$("#btnDelVinc_'.$pk.'").addClass("unsavedForm");$("#btnDelVinc_'.$pk.'").css("color","#F00");'
                         )); 
                    ?> Si
            	</td>
                <td style=" border:1px solid #000; width:30%">
                	<?php 
                        if($consDelitoVinc["sancion_impuesta_vinc"]==1){$consDelitoVinc["sancion_impuesta_vinc"]=true;}else{$consDelitoVinc["sancion_impuesta_vinc"]=false;}
                            echo CHtml::CheckBox('sansImp_'.$pk,$consDelitoVinc["sancion_impuesta_vinc"], array (
                                'value'=>'true',
								'disabled'=>$disabled,
								'onchange'=>'js:$("#btnDelVinc_'.$pk.'").addClass("unsavedForm");$("#btnDelVinc_'.$pk.'").css("color","#F00");'
                         )); 
                    ?>Si
                    <?php 
                        $opTipoSanc[$consDelitoVinc["id_tipo_sancion"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('tipoSanImp_'.$pk,'tipoSanImp_'.$pk,CHtml::listData($sancionImp,'id_tipo_sancion','tipo_sancion'),
                     		array(
								'prompt'=>"seleccione una sanción",
								'disabled'=>$disabled,
                       	 		'options' => $opTipoSanc,
								'style'=>'width:100%',
								'onchange'=>'js:$("#btnDelVinc_'.$pk.'").addClass("unsavedForm");$("#btnDelVinc_'.$pk.'").css("color","#F00");'
                       		)
                    	);
						$opTipoSanc="";
					?>   
                </td>
			</tr>
		<?php endforeach;?>	
      <?php endif;?>
</table>
<?php
if(empty($pk)){$pk=0;}
echo Chtml::hiddenField('numDelitoGen',$pk);
?>
</fieldset>
<hr />

<fieldset>
<div class="panel-heading color-sdis">RECUPERACIÓN BIOGRÁFICA</div>

<?php $formHisVida=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioHistVida',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<?php echo  $formHisVida->errorSummary($modeloValPsicol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<div id="divGrHV" class="form-group"> 
    	<div class="col-md-12">
	<!--campo de texto para nombres del adolescente -->	
		<?php echo $formHisVida->labelEx($modeloValPsicol,'historia_vida',array('class'=>'control-label','for'=>'searchinput'));?>
    	<div class="cont-infoval"><?php echo $modeloValPsicol->historia_vida?></div>
		<?php //echo $formHisVida->textArea($modeloValPsicol,'historia_vida',array('class'=>'form-control','disabled'=>'disabled'));?>
        <?php echo $formHisVida->error($modeloValPsicol,'historia_vida',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
<?php $formDinFunFam=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioDinFunFam',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>	
<?php echo  $formDinFunFam->errorSummary($modeloValPsicol,'','',array('style' => 'font-size:14px;color:#F00')); ?>

	<div id="dn_fn_familiar" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formDinFunFam->labelEx($modeloValPsicol,'dn_fn_familiar',array('class'=>'control-label','for'=>'searchinput'));?>
        	<div class="cont-infoval"><?php echo $modeloValPsicol->dn_fn_familiar?></div>        
			<?php //echo $formDinFunFam->textArea($modeloValPsicol,'dn_fn_familiar',array('class'=>'form-control','disabled'=>'disabled'));?>
            <?php echo $formDinFunFam->error($modeloValPsicol,'dn_fn_familiar',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />

<?php $formHistCond=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioHisCon',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formHistCond->errorSummary($modeloValPsicol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<div id="hist_conducta" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formHistCond->labelEx($modeloValPsicol,'hist_conducta',array('class'=>'control-label','for'=>'searchinput'));?>
        	<div class="cont-infoval"><?php echo $modeloValPsicol->hist_conducta?></div>        
            <?php //echo $formHistCond->textArea($modeloValPsicol,'hist_conducta',array('class'=>'form-control','disabled'=>'disabled'));?>
            <?php echo $formHistCond->error($modeloValPsicol,'hist_conducta',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>

<fieldset>
<div class="panel-heading color-sdis">ANÁLISIS DEL ESTADO MENTAL</div>
<?php $formEstMental=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioAnEstMen',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')

));
?>
	<?php echo  $formDinFunFam->errorSummary($modeloValPsicol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div id="analisis_est_mental" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formEstMental->labelEx($modeloValPsicol,'analisis_est_mental',array('class'=>'control-label','for'=>'searchinput'));?>
        	<div class="cont-infoval"><?php echo $modeloValPsicol->analisis_est_mental?></div>        			
			<?php //echo $formEstMental->textArea($modeloValPsicol,'analisis_est_mental',array('class'=>'form-control','disabled'=>'disabled'));?>
            <?php echo $formEstMental->error($modeloValPsicol,'analisis_est_mental',array('style' => 'color:#F00'));?>
   		</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
