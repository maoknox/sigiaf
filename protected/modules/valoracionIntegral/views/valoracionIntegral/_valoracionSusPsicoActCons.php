<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="MensajeConsSPA" style="font-size:14px;" ></div>
<?php 
//echo $modeloValPsicol->consumo_spa;
/* $this->widget('application.extensions.magnific-popup.EMagnificPopup', array('target' => '.test-popup-link'));*/
?>
<fieldset id="valSustCons">
<div class="panel-heading color-sdis">SUSTANCIAS PSICOACTIVAS</div> 
<label class="control-label" for="radios">¿El adolescente ha consumido sustancias psicoactivas?</label><br />
         <label class="radio-inline" for="radios-0">
			<?php	
				$siConsume=false;
				$noConsume=false;
				if($modeloValPsicol->consumo_spa=="1"){$siConsume=true;}else{$noConsume=true;}
					?>
            		Si<?php echo CHtml::radioButton('verifCons',$siConsume,array('id'=>'siConsume','value'=>"true"));
					?>
            </label>
            <label class="radio-inline" for="radios-0">
            No<?php echo CHtml::radioButton('verifCons',$noConsume,array('id'=>'noConsume','value'=>"false"));			
			?>
    		</label>
</fieldset>
<br />
<fieldset id="sustCons">

<label class="control-label">Sustancias psicoactivas que ha consumido</label>
<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="consumoSpaTab"><tr>
	<td style=" border:1px solid #000; width:10%">No.</td>
    <td style=" border:1px solid #000;width:10%">Tipo SPA</td>
    <td style=" border:1px solid #000;width:10%">Frecuencia Uso</td>
    <td style=" border:1px solid #000;width:10%">¿La ha consumido durante el último año?</td>
    <td style=" border:1px solid #000;width:10%">Vía de administración más frecuente</td>
    <td style=" border:1px solid #000;width:10%">Edad en la cual la usó por primera vez</td>
    <td style=" border:1px solid #000;width:10%">Edad en la que dejó de consumirla</td>
    <td style=" border:1px solid #000;width:10%">¿SPA de mayor impacto?</td>
    <td style=" border:1px solid #000;width:20%">Motivos/Circunstancias asociadas al inicio del consumo</td>
    <td style=" border:1px solid #000;width:10%"></td>
</tr>
	<?php
		//$consConsumoSPA[]=array('1'=>'1');$consDelitoVinc[]=array('1'=>'1');
	 if(!empty($consConsumoSPA)):?>
    	
		<?php  foreach($consConsumoSPA as $pk=>$consConsumoSPA): $pk+=1; //revisar?>
			<tr>
            	<td style=" border:1px solid #000; width:10%">
					<?php
					if($consConsumoSPA["droga_inicio"]==1){
						echo "SPA inicio";	
						$consConsumoSPA["droga_inicio"]=true;
					}
					else{
						echo $pk;	
						$consConsumoSPA["droga_inicio"]=false;
					}?>
                   </td>
                   <td style=" border:1px solid #000; width:10%">
                   <?php
                        $op[$consConsumoSPA["id_tipo_droga"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('tipoSpa_'.$pk,'tipoSpa_'.$pk,CHtml::listData($tipoSpa,'id_tipo_droga','nombre_droga'),
                     		array(
								'prompt'=>'Seleccione SPA',
                       	 		'options' => $op,
								'style'=>'width:100%'
                       		)
                    	);
						$op="";
					?>               
               </td>
               <td style=" border:1px solid #000; width:10%">
                   <?php
                        $opFrecUso[$consConsumoSPA["id_frecuencia_uso"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('frecUso_'.$pk,'frecUso_'.$pk,CHtml::listData($frecUso,'id_frecuencia_uso','frecuencia_uso'),
                     		array(
								'prompt'=>'Seleccione frecuencia de uso',
                       	 		'options' => $opFrecUso,
								'style'=>'width:100%'
                       		)
                    	);
						$opFrecUso="";
					?>               
               </td>
               <td style=" border:1px solid #000; width:20%">
					<?php 
                        if($consConsumoSPA["consumo_ult_anio"]==1){$consConsumoSPA["consumo_ult_anio"]=true;}else{$consConsumoSPA["consumo_ult_anio"]=false;}
                            echo CHtml::CheckBox('consUltAnio_'.$pk,$consConsumoSPA["consumo_ult_anio"], array (
                                'value'=>'true'
                         )); 
                    ?> Si
            	</td>
               <td style=" border:1px solid #000; width:10%">
                    <?php 
						$modeloValPsicol->idSPACons=$consConsumoSPA["id_tipo_conspa"];
						$viaAdmonAdol=$modeloValPsicol->consultaViasAdmonAdol();
							foreach($viaAdmonAdol as $viaAdmonAdol){//revisar
								$opViaAdomon[$viaAdmonAdol["id_viaadmon_spa"]]=array('selected'=>true);
							}                  
						echo CHtml::dropDownList('viaAdmon_'.$pk,'viaAdmon_'.$pk,CHtml::listData($viaAdmon,'id_viaadmon_spa','viaadmon_spa'),
                     		array(
                       	 		'options' => $opViaAdomon,
								'style'=>'width:100%',
								'multiple'=>'multiple'
                       		)
                    	);
						$opViaAdomon="";
					?>   
                </td>
                <td style=" border:1px solid #000; width:10%">
                	<?php
						echo CHtml::textField('edadIni_'.$pk,$consConsumoSPA["edad_inicio_cons"],array('style'=>'width:80%'));
					?>
                </td>
                <td style=" border:1px solid #000; width:10%">
                	<?php
						echo CHtml::textField('edadFin_'.$pk,$consConsumoSPA["edad_fin_cons"],array('style'=>'width:80%'));
					?>
                </td>
                <td style=" border:1px solid #000; width:10%">
                	<?php
						if($consConsumoSPA["droga_mayor_impacto"]==1){$consConsumoSPA["droga_mayor_impacto"]=true;}else{$consConsumoSPA["droga_mayor_impacto"]=false;}
						echo CHtml::RadioButton('spaMayImp',$consConsumoSPA["droga_mayor_impacto"],array('id'=>'spaMayImp_'.$pk));
					?>
                </td>
                 <td style=" border:1px solid #000; width:10%">
                	<?php
						echo CHtml::textArea('motivoCons_'.$pk,$consConsumoSPA["motivo_inicio_cons"]);
					?>
                </td>
                <td style=" border:1px solid #000; width:15%">
               <?php 
			   		echo CHtml::hiddenField('idSpaCons_'.$pk,$consConsumoSPA["id_tipo_conspa"]);
					if($consConsumoSPA["droga_inicio"]==1){$consConsumoSPA["droga_inicio"]="true";}else{$consConsumoSPA["droga_inicio"]="false";}
					echo CHtml::hiddenField('spaInicio_'.$pk,$consConsumoSPA["droga_inicio"]);
					echo Chtml::hiddenField('numSpaCons',$pk);
                ?>
                
                </td>
			</tr>
		<?php endforeach;?>	
      <?php endif;?>
</table>
<?php $fromBtnAgregaSpa=$this->beginWidget('CActiveForm', array(
	'id'=>'fromBtnAgregaSpa',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
   	<div class="form-group">
            <div class="col-md-4">	

<?php
if(empty($pk)){$pk=0;}
echo Chtml::hiddenField('numSpaConsGen',$pk);
?>
</div>
</div>
<?php $this->endWidget();?>
</fieldset>
<hr />

<fieldset id="patronCons">
<?php $formPatCons=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioPatCons',
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
          	<label class="control-label" for="radios">PATRÓN DE CONSUMO</label>
			<div class="radio">
				<?php 
                    $selOpt=false;
                    foreach($patronCons as $patronCons){
                        if($modeloValPsicol->id_patron_consumo==$patronCons["id_patron_consumo"]){$selOpt=true;}
                        echo CHtml::radioButton('ValoracionPsicologia[id_patron_consumo]',
                            $selOpt,array('id'=>'ValoracionPsicologia_id_patron_consumo_'.$patronCons["id_patron_consumo"],                            
                            'value'=>$patronCons["id_patron_consumo"]
                            )				
                        )."".$patronCons["patron_consumo"]."<br/>";
                        $selOpt=false;
                    }
                ?>
   			</div>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-12">

	<?php echo $formPatCons->textArea($modeloValPsicol,
		'patron_consumo_desc',
		array('class'=>'form-control',
		'onblur'=>'js:enviaFormOpt("formularioPatCons","btnFormPatCons")',
		'onkeyup'=>'js:$("#btnFormPatCons").css("color","#F00")'));
	?>
    
	<?php echo $formPatCons->error($modeloValPsicol,'patron_consumo_desc',array('style' => 'color:#F00'));?>
    </div>
    </div>
    
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="examenToxic">
<?php $formExamenToxic=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioExamenToxic',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<div class="form-group">
    <div class="col-md-12">
    <label class="control-label" for="radios">¿El adolescente realizó el examen toxicológico?</label><br />
        <label class="radio-inline" for="radios-0">
        <?php	
            $siRealizado=false;
            $noRealizado=false;
            if($modeloValPsicol->examen_toxic=="t"){$siRealizado=true;}elseif($modeloValPsicol->examen_toxic=="f"){$noRealizado=true;}
                ?>
                Si<?php echo CHtml::radioButton('ValoracionPsicologia[examen_toxic]',$siRealizado,array('id'=>'ValoracionPsicologia_examen_toxic','value'=>"true",'onclick'=>'js:$("#examenToxic").addClass("has-warning");enviaFormOpt("formularioExamenToxic","examenToxic")'));
                ?>
        </label>
        <label class="radio-inline" for="radios-0">
        No<?php echo CHtml::radioButton('ValoracionPsicologia[examen_toxic]',$noRealizado,array('id'=>'ValoracionPsicologia_examen_toxic','value'=>"false",'onclick'=>'js:$("#examenToxic").addClass("has-warning");enviaFormOpt("formularioExamenToxic","examenToxic")'));			
        ?>
        </label>
    </div>
</div>
    <div class="form-group">
    	<div class="col-md-12">
	<?php echo $formExamenToxic->textArea($modeloValPsicol,
		'resultado_examtox',
		array('class'=>'form-control',
		'onblur'=>'js:enviaFormOpt("formularioExamenToxic","btnFormExamenToxic")',
		'onkeyup'=>'js:$("#btnFormExamenToxic").css("color","#F00")'));
	?>
    
	<?php echo $formExamenToxic->error($modeloValPsicol,'resultado_examtox',array('style' => 'color:#F00'));?>
    </div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="ultEpCons">
<?php $formUltEpCons=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioUltEpCons',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
    <div class="form-group">
    	<div class="col-md-12">
        	<?php echo $formUltEpCons->labelEx($modeloValPsicol,'ultimo_ep_cons',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formUltEpCons->textArea($modeloValPsicol,'ultimo_ep_cons',array('class'=>'form-control',
            'onblur'=>'js:enviaForm("formularioUltEpCons","btnFormUltEpCons")',
            'onkeyup'=>'js:$("#btnFormUltEpCons").css("color","#F00")'));?>
			<?php echo $formUltEpCons->error($modeloValPsicol,'ultimo_ep_cons',array('style' => 'color:#F00'));?>
    	</div>
	</div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<fieldset id="intPrevCons">
<?php $formIntPrevMCons=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioIntPrevMCons',
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
        	<?php echo $formIntPrevMCons->labelEx($modeloValPsicol,'interv_prev_spa',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formIntPrevMCons->textArea($modeloValPsicol,
            'interv_prev_spa',
            array('class'=>'form-control',
            'onblur'=>'js:enviaForm("formularioIntPrevMCons","btnFormIntPrevMCons")',
            'onkeyup'=>'js:$("#btnFormIntPrevMCons").css("color","#F00")'));?>
            <?php echo $formIntPrevMCons->error($modeloValPsicol,'btnFormIntPrevMCons',array('style' => 'color:#F00'));?>
   		</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
<?php 
	//echo CHtml::hiddenField('idValPsicol',$idValPsicol);
	//echo CHtml::hiddenField('numDocAdolValPsicol',$numDocAdol);
?>
<?php
Yii::app()->getClientScript()->registerScript('scriptVaSPsic_1','
	$("#valSustCons").find(":input").attr("disabled","true");
	$("#sustCons").find(":input").attr("disabled","true");
	$("#patronCons").find(":input").attr("disabled","true");
	$("#examenToxic").find(":input").attr("disabled","true");
	$("#ultEpCons").find(":input").attr("disabled","true");
	$("#intPrevCons").find(":input").attr("disabled","true");
'
,CClientScript::POS_END);
?>
