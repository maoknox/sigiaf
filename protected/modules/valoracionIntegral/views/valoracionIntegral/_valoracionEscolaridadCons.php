<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="valEscolar">
<fieldset>
<div class="panel-heading color-sdis">Historia Escolar</div> 
<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="datosEscAdolTab">
<tr>
	<td style=" border:1px solid #000; width:15%">Grado</td>
    <td style=" border:1px solid #000;width:15%">Año</td>
    <td style=" border:1px solid #000;width:10%">Institución educativa</td>
    <td style=" border:1px solid #000;width:10%">Ciudad</td>
    <td style=" border:1px solid #000;width:10%">Jornada</td>
    <td style=" border:1px solid #000;width:10%"></td>
</tr>
<?php
	//$escolaridadAdol=array('id'=>1);
	if(!empty($escolaridadAdol)):?>
		<?php foreach($escolaridadAdol as $pk=>$escolaridadAdol): $pk+=1;	?>
			<tr id="<?php echo $pk;?>">
            	<td style=" border:1px solid #000;width:15%">
					<?php
                        $opGradoEsc[$escolaridadAdol["id_nivel_educ"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('nivel_ed_adol_'.$pk,'nivel_es_adol_'.$pk,CHtml::listData($nivelEduc,'id_nivel_educ','nivel_educ'),
                     		array(
								'prompt'=>'Seleccione nivel educativo',
                       	 		'options' => $opGradoEsc,
								'style'=>'width:100%'
                       		)
                    	);
						$opGradoEsc="";
					?>                                     
                </td>
                <td style=" border:1px solid #000;width:15%"><?php echo CHtml::textField('anio_es_adol_'.$pk,$escolaridadAdol["anio_escolaridad"]); ?></td>
                <td style=" border:1px solid #000;width:10%"><?php echo CHtml::textField('inst_es_adol_'.$pk,$escolaridadAdol["instituto_escolaridad"]); ?></td>
                <td style=" border:1px solid #000;width:10%">
                	<?php
                        $opMunEsc[$escolaridadAdol["id_municipio"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('mun_es_adol_'.$pk,'mun_es_adol_'.$pk,CHtml::listData($munCiudad,'id_municipio','municipio'),
                     		array(
								'prompt'=>'Seleccione Municipio',
                       	 		'options' => $opMunEsc,
								'style'=>'width:100%'
                       		)
                    	);
						$opMunEsc="";
					?>      
                </td>
                <td style=" border:1px solid #000;width:10%">
                	<?php
                        $opJornada[$escolaridadAdol["id_jornada_educ"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('jor_es_adol_'.$pk,'jor_es_adol_'.$pk,CHtml::listData($jornadaEduc,'id_jornada_educ','jornada_educ'),
                     		array(
								'prompt'=>'Seleccione Jornada',
                       	 		'options' => $opJornada,
								'style'=>'width:100%'
                       		)
                    	);
						$opJornada="";
					?>      
                </td>                            
                <td>
                	<?php 
                        echo CHtml::hiddenField('id_es_adol_'.$pk,$escolaridadAdol["id_escolaridad"]);
                        echo CHtml::Button (
                            'Modificar',   
                            array('id'=>'btn_es_adol_'.$pk,'name'=>'btn_es_adol_'.$pk,'onclick'=>'js:modificaEscAdol('.$pk.')')
                        );
                        echo Chtml::hiddenField('numEscAdol',$pk);
                    ?>
                </td>
              </tr>
		<?php endforeach;?>
	<?php endif; ?>
</table>
</fieldset>
<hr />
<fieldset id="histEscolar">
<?php $formHistEsc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioHistEsc',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formHistEsc->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="form-group">
    	<div class="col-md-12">
       		<?php echo $formHistEsc->labelEx($modelValTrSoc,'dr_hist_escolar',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formHistEsc->textArea($modelValTrSoc,
                'dr_hist_escolar',
                array('class'=>'form-control'));
            ?>
            <?php echo $formHistEsc->error($modelValTrSoc,'dr_hist_escolar',array('style' => 'color:#F00'));?>
        </div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptValEscolar','
	$("#valEscolar").find(":input").attr("disabled","true");	
'
,CClientScript::POS_END);
?>
