<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="formConsTrSoc" >
<fieldset id="afSalud">
<div class="panel-heading color-sdis">Afiliación a salud</div> 
<?php $formSgsssAdol=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioSgsssAdol',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="vincPrevSrpaTable">
	<tr>
        <td style=" border:1px solid #000; width:25%"><label class="control-label">Regimen salud</label></td>
        <td style=" border:1px solid #000;width:25%"><label class="control-label">EPS</label></td>
	</tr>
    <tr>        
        <td style=" border:1px solid #000;width:25%">
            <div class="form-group">
                <div class="col-md-12">		
					<?php 
                        $opTipoRegSal[$modeloSgsss->id_regimen_salud]=array('selected'=>true);
                        echo $formSgsssAdol->dropDownList($modeloSgsss,'id_regimen_salud',CHtml::listData($regSalud,'id_regimen_salud','regimen_salud'),
                            array(
                                'prompt'=>"seleccione un régimen",
                                'options' => $opTipoRegSal,
                                'class'=>' form-control','data-hide-disabled'=>'true','data-live-search'=>'true',
                            )
                        );
                        $opTipoRegSal="";
                    ?> 
                    <?php echo $formSgsssAdol->error($modeloSgsss,'id_regimen_salud',array('style' => 'color:#F00'));?>
                </div>
        	</div>
        </td>
        <td style=" border:1px solid #000;width:25%">
            <div class="form-group">
                <div class="col-md-12">		
					<?php 
                        $opTipoEps[$modeloSgsss->id_eps_adol]=array('selected'=>true);
                        echo $formSgsssAdol->dropDownList($modeloSgsss,'id_eps_adol',CHtml::listData($eps,'id_eps_adol','eps_adol'),
                            array(
                                'prompt'=>"seleccione eps",
                                'options' => $opTipoEps,
                                'class'=>'form-control','data-hide-disabled'=>'true','data-live-search'=>'true',
                            )
                        );
                        $opTipoEps="";
                    ?> 
                    <?php echo $formSgsssAdol->error($modeloSgsss,'id_eps_adol',array('style' => 'color:#F00'));?>
                </div>
        	</div>
        </td>
	</tr>
</table>
<?php $this->endWidget();?>
</fieldset>
<hr />

<fieldset id="grupoFam">
<div class="panel-heading color-sdis">Grupo Familiar</div> 
<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="datosFamiliarTab">
<tr>
	<td style=" border:1px solid #000; width:15%">Nombre</td>
    <td style=" border:1px solid #000;width:15%">Apellidos</td>
    <td style=" border:1px solid #000;width:5%">Edad</td>
    <td style=" border:1px solid #000;width:10%">Parentesco</td>
    <td style=" border:1px solid #000;width:15%">Ocupación</td>
    <td style=" border:1px solid #000;width:10%">Escolaridad</td>
    <td style=" border:1px solid #000;width:10%">Teléfono principal</td>
    <td style=" border:1px solid #000;width:10%">¿Vive con el adolescente?</td>
</tr>
<?php
	//$grupoFamiliar=array('id'=>1);
	//print_r($grupoFamiliar);
	if(!empty($grupoFamiliar)):?>
		<?php foreach($grupoFamiliar as $pk=>$grupoFamiliar): $pk+=1;	//revisar?>
			<tr id="<?php echo $pk;?>">
            	<td style=" border:1px solid #000;width:15%"><?php echo CHtml::textField('nomb_fam_'.$pk,$grupoFamiliar["nombres_familiar"]); ?></td>
                <td style=" border:1px solid #000;width:15%"><?php echo CHtml::textField('ap_fam_'.$pk,$grupoFamiliar["apellidos_familiar"]); ?></td>
                <td style=" border:1px solid #000;width:10%"><?php echo CHtml::textField('edad_fam_'.$pk,$grupoFamiliar["edad_familiar"],array('style'=>'width:60%')); ?></td>
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
						echo CHtml::textField('telefono_'.$pk,$telefonoFam["telefono"],array('style'=>'width:90%')); 
					?>                    
               	</td>
                <td style=" border:1px solid #000;width:10%">
					<?php 
						$convAdol=false;
						if($grupoFamiliar["convive_adol"]==1){$convAdol=true;}else{$convAdol=false;}
						echo CHtml::CheckBox('conv_adol_'.$pk,$grupoFamiliar["convive_adol"],array("value"=>'true'));
					?>
                </td>
              </tr>
		<?php endforeach;?>
	<?php endif; ?>
</table>

</fieldset>
<hr />
<fieldset id="obsGrFam">
<?php $formObsFam=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioObsFam',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formObsFam->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="form-group">
    	<div class="col-md-12">
       	<?php echo $formObsFam->labelEx($modelValTrSoc,'obs_familiares_ts',array('class'=>'control-label','for'=>'searchinput'));?>
		<?php echo $formObsFam->textArea($modelValTrSoc,
            'obs_familiares_ts',
            array('class'=>'form-control'));
        ?>
		<?php echo $formObsFam->error($modelValTrSoc,'obs_familiares_ts',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="otrRef">
<div class="panel-heading color-sdis">Otro Referente</div> 
<?php  
if(!empty($otroRef)){
	$funcion='modifOtrRef("btnOtrRef")';
	$modeloFamiliar->id_doc_familiar=$otroRef["id_doc_familiar"];
}
else{
	$funcion='creaOtrRef("btnOtrRef")';
	$modeloFamiliar->id_doc_familiar=-1;
}
?>
<div id="MensajeOtrRef" style="font-size:14px;" ></div>
<?php $formOtrRef=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioOtrRef',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<?php echo  $formOtrRef->errorSummary($modeloFamiliar,'','',array('style' => 'font-size:14px;color:#F00')); ?>
<table style="border-collapse:collapse; border:1px solid #000; width:100%" id="datosOtrRef">
<tr>
	<td style=" border:1px solid #000; width:15%">Nombre</td>
    <td style=" border:1px solid #000;width:15%">Apellidos</td>
    <td style=" border:1px solid #000;width:10%">Parentesco</td>
    <td style=" border:1px solid #000;width:10%">Dirección</td>
</tr>
<tr>
    <td style=" border:1px solid #000;width:15%"><?php 
		$modeloFamiliar->nombres_familiar=$otroRef["nombres_familiar"];
		echo $formOtrRef->textField($modeloFamiliar,'nombres_familiar');
		echo $formOtrRef->error($modeloFamiliar,'nombres_familiar',array('style' => 'color:#F00'));
	?></td>
    <td style=" border:1px solid #000;width:15%"><?php 
		$modeloFamiliar->apellidos_familiar=$otroRef["apellidos_familiar"];
		echo $formOtrRef->textField($modeloFamiliar,'apellidos_familiar');
		echo $formOtrRef->error($modeloFamiliar,'apellidos_familiar',array('style' => 'color:#F00'));
	?></td>
    <td>
		<?php $modeloFamiliar->id_parentesco=$otroRef["id_parentesco"];?>
		<?php echo $formOtrRef->dropDownList($modeloFamiliar,'id_parentesco',CHtml::listData($parentesco,'id_parentesco', 'parentesco'), array('prompt'=>'Seleccione Parenesco')); ?>
        <?php echo $formOtrRef->error($modeloFamiliar,'id_parentesco',array('style' => 'color:#F00')); ?>     
    </td>
    <td style=" border:1px solid #000;width:15%"><?php 
		$modeloFamiliar->datos_compl_fam=$otroRef["datos_compl_fam"];
		echo $formOtrRef->textField($modeloFamiliar,'datos_compl_fam');
		echo $formOtrRef->error($modeloFamiliar,'datos_compl_fam',array('style' => 'color:#F00'));?>
    </td>
</tr>
</table>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="antecedentes">
<div class="panel-heading color-sdis">Antecedentes</div> 
<div id="MensajeAntVincProt" style="font-size:14px;" ></div>
<table style="border-collapse:collapse; border:0px ; width:100%">
    <tr>
		<td width="33%">Antecendentes familiares</td>
        <td width="33%">Antecedentes adolescente/Problemas asociados</td>
        <td width="33%">Vinculación a servicios de protección</td>    
    </tr>
    <td valign="top" id="antFamilia">
		<?php $formAntFam=$this->beginWidget('CActiveForm', array(
            'id'=>'formAntFam',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>false,
            ),
			'htmlOptions' => array('class' => 'form-horizontal')
        ));
        ?>
		<?php echo  $formAntFam->errorSummary($modeloAntFFamilia,'','',array('style' => 'font-size:14px;color:#F00')); ?>
		<?php 
			foreach($antFam as $pkAnt=>$antFam){//revisar
				$checked=false;
				if(!empty($antFamAdol)){
					foreach($antFamAdol as $antFamAdoli){
						if($antFamAdoli["id_ant_fam"]==$antFam["id_ant_fam"]){
							$checked=true;
						}					
					}
				}	
				?>
                <div class="col-md-12">
                    <div class="checkbox">
                         <label for="checkboxes-0">
							<?php			
                            echo CHtml::CheckBox('AntFFamilia[intprev][int_prev_'.$pkAnt.']',$checked, array (
                                'id'=>'intprev_'.$pkAnt,
                                'value'=>$antFam["id_ant_fam"],
                            ))." ".$antFam["ant_fam"];
							?>
                          </label>
                     </div>
                 </div>
        <?php
			}
		?>
        <?php $this->endWidget();?>
    </td>
     <td>
		<?php $formProbAsoc=$this->beginWidget('CActiveForm', array(
            'id'=>'formProbAsoc',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>false,
            ),
			'htmlOptions' => array('class' => 'form-horizontal')
        ));
        ?>		
		<?php echo  $formProbAsoc->errorSummary($modeloProblemaValtsocial,'','',array('style' => 'font-size:14px;color:#F00')); ?>
		<?php 
		//print_r($probAsocAdol);
			foreach($probAsoc as $pkPrA=>$probAsoc){//revisar
				$checked=false;
				$checkedVinc=false;
				if(!empty($probAsocAdol)){
					foreach($probAsocAdol as $probAsocAdoli){
						if($probAsocAdoli["id_problema_asoc"]==$probAsoc["id_problema_asoc"]){	
							$checked=true;											
							if(!empty($probAsocAdoli["vinc_act_prob"])){
								$checkedVinc=true;	
							}
						}
					}
				}
				if(strpos($probAsoc["problema_asoc"],'pandillas')>0){
					?>
                    <div class="col-md-12">
                    	<div class="checkbox">
                         <label for="checkboxes-0">
							<?php
                            echo CHtml::CheckBox('ProblemaValtsocial[probasoc][prob_asoc_'.$pkPrA.']',$checked, array (
                                'id'=>'prob_asoc_'.$pkPrA,
                                'value'=>$probAsoc["id_problema_asoc"],
                            ))." ".$probAsoc["problema_asoc"]."<br/>-".
                            CHtml::CheckBox('vinc_pand',$checkedVinc, array (
                                'value'=>'true',
                            ))."Vinculado actualmente";
                            ?>
                    	</label>
                      </div>
                    </div>
                    <?php 	
				}
				elseif(strpos($probAsoc["problema_asoc"],'futbolistas')>0){		
					?>
                    <div class="col-md-12">
                    	<div class="checkbox">
                         <label for="checkboxes-0">
							<?php			
                            echo CHtml::CheckBox('ProblemaValtsocial[probasoc][prob_asoc_'.$pkPrA.']',$checked, array (
                                'id'=>'prob_asoc_'.$pkPrA,
                                'value'=>$probAsoc["id_problema_asoc"],
                                'onclick'=>'js:$("#btnProbAsoc").css("color","#F00")'
                            ))." ".$probAsoc["problema_asoc"]."<br/> -".
                            CHtml::CheckBox('vinc_barr_fut',$checkedVinc, array (
                                'value'=>'true',
                            ))
                            ."Vinculado actualmente"; 
							?>
                           </label>
                      	</div>
               		</div> 
                  <?php
				}
				else{
					?>
                    <div class="col-md-12">
                    	<div class="checkbox">
                         <label for="checkboxes-0">
							<?php
                            echo CHtml::CheckBox('ProblemaValtsocial[probasoc][prob_asoc_'.$pkPrA.']',$checked, array (
                                'id'=>'prob_asoc_'.$pkPrA,
                                'value'=>$probAsoc["id_problema_asoc"],
                            ))." ".$probAsoc["problema_asoc"]; 	
							?>
                           </label>
                      	</div>
               		</div> 
                   	<?php		
				}
				?>
                 <?php
			}
		?>
        <?php $this->endWidget();?>
    </td>
    <td valign="top">
		<?php $formServProt=$this->beginWidget('CActiveForm', array(
            'id'=>'formServProt',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>false,
            ),
			'htmlOptions' => array('class' => 'form-horizontal')
        ));
        ?>
		<?php echo  $formServProt->errorSummary($modeloServprotecValtsocial,'','',array('style' => 'font-size:14px;color:#F00')); ?>
     	<?php 
			//print_r($servProt);
			
			foreach($servProt as $pkSrPr=>$servProt){//revisar
				$checked=false;
				if(!empty($servProtAdol)){
					foreach($servProtAdol as $servProtAdoli){
						if($servProtAdoli["id_serv_protec"]==$servProt["id_serv_protec"]){
							$checked=true;
						}					
					}
				}
				?>
                    <div class="col-md-12">
                    	<div class="checkbox">
                         <label for="checkboxes-0">
							<?php				
                            echo CHtml::CheckBox('ServprotecValtsocial[sevprot][serv_protec_'.$pkSrPr.']',$checked, array (
                                'id'=>'sevprot_serv_protec_'.$pkSrPr,
                                'value'=>$servProt["id_serv_protec"],
                            ))." ".$servProt["serv_protec"]; 		
                            ?>
                           </label>
                      	</div>
               		</div> 
                <?php
			}
		?>
        <?php $this->endWidget();?>
    </td>
</table>
</fieldset>
<hr />
<fieldset id="tipoFamilia">
<?php 
	if(empty($tipoFamiliaAdol)){
		$modeloFamilia->id_familia=-1;
		$accion="creaTipoFam";
	}
	else{
		$modeloFamilia->id_familia=$tipoFamiliaAdol["id_familia"];	
		$accion="modTipoFam";		
	}
?>
<div id="MensajeTipoFam" style="font-size:14px;" ></div>
<?php $formTipoFam=$this->beginWidget('CActiveForm', array(
            'id'=>'formTipoFam',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>false,
            ),
			'htmlOptions' => array('class' => 'form-horizontal')
        ));
        ?>
        <?php $modeloFamilia->id_tipo_familia=$tipoFamiliaAdol["id_tipo_familia"];	?>
		<div class="form-group">
        	<?php echo $formTipoFam->labelEx($modeloFamilia,'id_tipo_familia',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php echo $formTipoFam->dropDownList($modeloFamilia,'id_tipo_familia',CHtml::listData($tipoFamilia,'id_tipo_familia', 'tipo_familia'), array('prompt'=>'Seleccione Tipo familia','onchange'=>'js:$("#btnTipoFam").css("color","#F00")','class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true')); ?>
                <?php echo $formTipoFam->error($modeloFamilia,'id_tipo_familia',array('style' => 'color:#F00')); ?>   
           </div>
       </div>
	<?php $this->endWidget();?>
</fieldset>

<fieldset id="histFam">
<?php $formHistFam=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioHistFam',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formHistFam->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formHistFam->labelEx($modelValTrSoc,'historia_famvaltsic',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formHistFam->textArea($modelValTrSoc,
                'historia_famvaltsic',
                array('class'=>'form-control'));
            ?>
            <?php echo $formHistFam->error($modelValTrSoc,'historia_famvaltsic',array('style' => 'color:#F00'));?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />

</fieldset>
<fieldset id="paFDc">
<?php $formPerc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioPerc',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formPerc->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
	<div class="form-group">
        <div class="col-md-12">
       		<?php echo $formPerc->labelEx($modelValTrSoc,'pa_f_dc',array('class'=>'control-label','for'=>'searchinput'));?>
			<?php echo $formPerc->textArea($modelValTrSoc,
                'pa_f_dc',
                array('class'=>'form-control'));
            ?>
			<?php echo $formPerc->error($modelValTrSoc,'pa_f_dc',array('style' => 'color:#F00'));?>
       </div>
    </div>
<?php $this->endWidget();?>


</fieldset></div>
<?php
Yii::app()->getClientScript()->registerScript('scripValTrSoc_1','
	$("#formConsTrSoc").find(":input").attr("disabled","true");
'
,CClientScript::POS_END);
?>
