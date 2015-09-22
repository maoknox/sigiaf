<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="formConsTrSoc" >
<?php 

/* $this->widget('application.extensions.magnific-popup.EMagnificPopup', array('target' => '.test-popup-link'));*/
?>
<fieldset>
<legend><strong>Grupo Familiar</strong></legend>
<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="datosFamiliarTab">
<tr>
	<td style=" border:1px solid #000; width:15%">Nombre</td>
    <td style=" border:1px solid #000;width:15%">Apellidos</td>
    <td style=" border:1px solid #000;width:10%">Edad</td>
    <td style=" border:1px solid #000;width:10%">Parentesco</td>
    <td style=" border:1px solid #000;width:10%">Ocupación</td>
    <td style=" border:1px solid #000;width:10%">Escolaridad</td>
    <td style=" border:1px solid #000;width:10%">Teléfono principal</td>
    <td style=" border:1px solid #000;width:10%">¿Vive con el adolescente?</td>
</tr>
<?php
	//$grupoFamiliar=array('id'=>1);
	if(!empty($grupoFamiliar)):?>
		<?php foreach($grupoFamiliar as $pk=>$grupoFamiliar): $pk+=1;	?>
			<tr>
            	<td style=" border:1px solid #000;width:15%"><?php echo CHtml::textField('nomb_fam_'.$pk,$grupoFamiliar["nombres_familiar"]); ?></td>
                <td style=" border:1px solid #000;width:15%"><?php echo CHtml::textField('ap_fam_'.$pk,$grupoFamiliar["apellidos_familiar"]); ?></td>
                <td style=" border:1px solid #000;width:10%"><?php echo CHtml::textField('edad_fam_'.$pk,$grupoFamiliar["edad_familiar"]); ?></td>
                <td style=" border:1px solid #000;width:10%">
                	<?php
                        $op[$grupoFamiliar["id_parentesco"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('parentesco_'.$pk,'parentesco_'.$pk,CHtml::listData($parentesco,'id_parentesco','parentesco'),
                     		array(
								'prompt'=>'Seleccione Parentesco',
                       	 		'options' => $op,
								'style'=>'width:100%'
                       		)
                    	);
						$op="";
					?>      
                </td>
                <td style=" border:1px solid #000;width:10%"><?php echo CHtml::textField('ocup_fam_'.$pk,$grupoFamiliar["ocupacion_familiar"]); ?></td>
                <td style=" border:1px solid #000;width:10%">
                	<?php
                        $opEsc[$grupoFamiliar["id_nivel_educ"]]=array('selected'=>true);
                    	echo CHtml::dropDownList('nivel_ed_'.$pk,'nivel_ed_'.$pk,CHtml::listData($nivelEduc,'id_nivel_educ','nivel_educ'),
                     		array(
								'prompt'=>'Seleccione Nivel educativo',
                       	 		'options' => $opEsc,
								'style'=>'width:100%'
                       		)
                    	);
						$opEsc="";
					?>      
                </td>
                <td style=" border:1px solid #000;width:10%">
					<?php						
						$modeloTelefono->idFamiliar=$grupoFamiliar["id_doc_familiar"];
						$telefonoFam=$modeloTelefono->consultaTelFamiliar(); 
						echo CHtml::textField('telefono_'.$pk,$telefonoFam["telefono"]); 
					?>                    
               	</td>
                <td style=" border:1px solid #000;width:10%">
					<?php 
						$convAdol=false;
						if($grupoFamiliar["convive_adol"]===1){$convAdol=true;}else{$convAdol=false;}
						echo CHtml::CheckBox('conv_adol_'.$pk,$grupoFamiliar["convive_adol"],array("value"=>'true'));
					?>
                </td>
              </tr>
		<?php endforeach;?>
	<?php endif; ?>
</table>

<hr />
<legend>Observaciones</legend>
<?php $formObsFam=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioObsFam',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
));
?>
	<?php echo  $formObsFam->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="row">
	<?php echo $formObsFam->textArea($modelValTrSoc,
		'obs_familiares_ts',
		array('style'=>'width:99.5%;',
			'onblur'=>'js:enviaForm("formularioObsFam","btnFormObsFam")',
			'onkeyup'=>'js:$("#btnFormObsFam").css("color","#F00")'
		));
	?>
	<?php echo $formObsFam->error($modelValTrSoc,'obs_familiares_ts',array('style' => 'color:#F00'));?>
    </div>
<?php $this->endWidget();?>
<hr />
<legend>Otro referente</legend>
<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="datosFamiliarTab">
<tr>
	<td style=" border:1px solid #000; width:15%">Nombre</td>
    <td style=" border:1px solid #000;width:15%">Apellidos</td>
    <td style=" border:1px solid #000;width:10%">Parentesco</td>
    <td style=" border:1px solid #000;width:10%">Dirección</td>
    <td style=" border:1px solid #000;width:10%"></td>
</tr>
<tr>
    <td style=" border:1px solid #000;width:15%"><?php echo CHtml::textField('nomb_fam_'.$pk,$otroRef["nombres_familiar"]); ?></td>
    <td style=" border:1px solid #000;width:15%"><?php echo CHtml::textField('ap_fam_'.$pk,$otroRef["apellidos_familiar"]); ?></td>
    <td>
		<?php
			$opOtrRef[$otroRef["id_parentesco"]]=array('selected'=>true);
			echo CHtml::dropDownList('parentesco_'.$pk,'parentesco_'.$pk,CHtml::listData($parentesco,'id_parentesco','parentesco'),
				array(
					'prompt'=>'Seleccione Parentesco',
					'options' => $opOtrRef,
					'style'=>'width:100%'
				)
			);
			$opOtrRef="";
		?>      
    </td>
    <td style=" border:1px solid #000;width:15%"><?php echo CHtml::textField('datos_comp_'.$pk,$otroRef["datos_compl_fam"]); ?></td>
</tr>
</table>
</fieldset>
<table style="border-collapse:collapse; border:0px ; width:100%">
    <tr>
		<td>Antecendentes familiares</td>
        <td>Antecedentes adolescente/Problemas asociados</td>
        <td>Vinculación a servicios de protección</td>    
    </tr>
    <td>
		<?php 
			foreach($antFam as $pkAnt=>$antFam){
				echo CHtml::CheckBox('intprev',false, array (
					'id'=>'intprev_'.$pkAnt,
					'value'=>$antFam["id_ant_fam"]
			 	))." ".$antFam["ant_fam"]."<br/><hr/>"; 			
			}
		?>
    </td>
     <td>
		<?php 
			//print_r($probAsoc);
			
			foreach($probAsoc as $pkPrA=>$probAsoc){
				if(strpos($probAsoc["problema_asoc"],'pandillas')>0){
					echo CHtml::CheckBox('prob_asoc',false, array (
						'id'=>'prob_asoc_'.$pkPrA,
						'value'=>$probAsoc["id_problema_asoc"]
					))." ".$probAsoc["problema_asoc"]."<br/>-".
					CHtml::CheckBox('vinc_pand',false, array (
						'value'=>'true'
					))."Vinculado actualmente <br/>"; 			
				}
				elseif(strpos($probAsoc["problema_asoc"],'futbolistas')>0){
					echo CHtml::CheckBox('prob_asoc',false, array (
						'id'=>'prob_asoc_'.$pkPrA,
						'value'=>$probAsoc["id_problema_asoc"]
					))." ".$probAsoc["problema_asoc"]."<br/>-".
					CHtml::CheckBox('vinc_barr_fut',false, array (
						'value'=>'true'
					))
					."Vinculado actualmente <br/>"; 			
				}
				else{
					echo CHtml::CheckBox('prob_asoc',false, array (
						'id'=>'prob_asoc_'.$pkPrA,
						'value'=>$probAsoc["id_problema_asoc"]
					))." ".$probAsoc["problema_asoc"]."<br/>"; 			
				}
				?>
                <hr />
                <?php
			}
		?>
    </td>
    <td>
     	<?php 
			//print_r($servProt);
			foreach($servProt as $pkSrPr=>$servProt){
				echo CHtml::CheckBox('prob_asoc',false, array (
					'id'=>'prob_asoc_'.$pkSrPr,
					'value'=>$servProt["id_serv_protec"]
			 	))." ".$servProt["serv_protec"]."<br/><hr/>"; 			
			}
		?>
    </td>
</table>
<fieldset>
<legend>Historia Familiar</legend>
<?php $formHistFam=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioHistFam',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
));
?>
	<?php echo  $formHistFam->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="row">
	<?php echo $formHistFam->textArea($modelValTrSoc,
		'historia_famvaltsic',
		array('style'=>'width:99.5%;',
			'onblur'=>'js:enviaForm("formularioHistFam","btnFormHistFam")',
			'onkeyup'=>'js:$("#btnFormHistFam").css("color","#F00")'
		));
	?>
	<?php echo $formHistFam->error($modelValTrSoc,'historia_famvaltsic',array('style' => 'color:#F00'));?>
    </div>
<?php $this->endWidget();?>
<hr />

</fieldset>
<fieldset>
<legend>Percepción y análisis de la familia frente al delito o conducta del/la adolescente que lo vinculó al SRPA, Justicia restaurativa</legend>
<?php $formPerc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioPerc',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
));
?>
	<?php echo  $formPerc->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="row">
	<?php echo $formPerc->textArea($modelValTrSoc,
		'pa_f_dc',
		array('style'=>'width:99.5%;',
			'onblur'=>'js:enviaForm("formularioPerc","btnFormPerc")',
			'onkeyup'=>'js:$("#btnFormPerc").css("color","#F00")'
		));
	?>
	<?php echo $formPerc->error($modelValTrSoc,'pa_f_dc',array('style' => 'color:#F00'));?>
    </div>
<?php $this->endWidget();?>
<hr />

</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scripValTrSoc_1','
	$("#formConsTrSoc").find(":input").attr("disabled","true");
'
,CClientScript::POS_END);
?>
