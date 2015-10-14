<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="divFormTrSoc">
<div id="Mensaje" style="font-size:14px;" ></div>
<?php 

/* $this->widget('application.extensions.magnific-popup.EMagnificPopup', array('target' => '.test-popup-link'));*/
?>
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
                                'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true',
                                'onchange'=>'js:$("#afSalud").addClass("has-warning");$("#formularioSgsssAdol").addClass("unsavedForm");'
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
                                'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true',
                                'onchange'=>'js:$("#afSalud").addClass("has-warning");$("#formularioSgsssAdol").addClass("unsavedForm");'
                            )
                        );
                        $opTipoEps="";
                    ?> 
                    <?php echo $formSgsssAdol->error($modeloSgsss,'id_eps_adol',array('style' => 'color:#F00'));?>
                </div>
        	</div>
        </td>
	</tr>
    <tr>        
        <td style=" border:1px solid #000;width:25%" colspan="2">
 <?php
 		//$modeloSgsss->num_doc=$modeloValEnf->num_doc;
		if(!empty($sgs)){
			$accion="modificaSgsss";
		}
		else{
			$accion="registraSgsss";
		}
		echo $formSgsssAdol->hiddenField($modeloSgsss,'num_doc');
		$boton=CHtml::ajaxSubmitButton (
						'Crear Registro',   
						array('valoracionIntegral/'.$accion),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="\'exito\'"){
										$("#Mensaje").html("Registro realizado satisfactoriamente");	
										$("#formularioSgsssAdol").removeClass("unsavedForm");
										$("#afSalud").removeClass("has-warning")
									}
									else{
										$("#Mensaje").html("Ha habido un error en la creación del registro. Código del error: "+datos.resultado);
									}
								}
								else{						
									$("#btnFormSgsss").show();
									$.each(datos, function(key, val) {
										$("#formularioSgsssAdol #"+key+"_em_").text(val);                                                    
										$("#formularioSgsssAdol #"+key+"_em_").show();                                                
									});
								}
								
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#Mensaje").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormAdolId").show();
								}
								else{
									if(xhr.status==500){
										$("#Mensaje").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
									}
									else{
										$("#Mensaje").html("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
								
							}'
						),
						array('id'=>'btnFormSgsss','class'=>'btn btn-default btn-sdis','name'=>'btnFormSgsss')
				);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>        
        
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
    <td style=" border:1px solid #000;width:10%"></td>
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
                <td>
                	<?php 
                        echo CHtml::hiddenField('id_fam_'.$pk,$grupoFamiliar["id_doc_familiar"]);
                        echo CHtml::Button (
                            'Modificar',   
                            array('id'=>'btnFam_'.$pk,'class'=>'btn btn-default btn-sdis','name'=>'btnFam_'.$pk,'onclick'=>'js:modificaDatosFam('.$pk.')')
                        );
                        echo Chtml::hiddenField('numDelito',$pk);
                    ?>
                </td>
              </tr>
		<?php endforeach;?>
	<?php endif; ?>
</table>

<?php
if(empty($pk)){$pk=0;}
echo Chtml::hiddenField('numFamGen',$pk);
echo CHtml::Button('Agregar Familiar',
	array('id'=>'btnAgregaFam','class'=>'btn btn-default btn-sdis','name'=>'btnAgregaFam','onclick'=>'js:agregaRegDatosFam()')
);
?>
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
            array('class'=>'form-control',
                'onblur'=>'js:enviaForm("formularioObsFam","obsGrFam")',
                'onkeyup'=>'js:$("#obsGrFam").addClass("has-warning")'
            ));
        ?>
	<?php echo $formObsFam->error($modelValTrSoc,'obs_familiares_ts',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Registrar',   
					array('id'=>'btnFormObsFam','class'=>'btn btn-default btn-sdis','name'=>'btnFormObsFam','onclick'=>'js:enviaForm("formularioObsFam","btnFormObsFam")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
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
    <td style=" border:1px solid #000;width:10%"></td>
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
    <td>
		<?php		
		echo $formOtrRef->hiddenField($modeloFamiliar,'id_doc_familiar');
        $boton=CHtml::Button (
            'Registrar',   
            array('id'=>'btnOtrRef','class'=>'btn btn-default btn-sdis','name'=>'btnOtrRef','onclick'=>'js:'.$funcion)
        );
        ?>
        <?php echo $boton; //CHtml::submitButton('Crear');?>
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
                                'onclick'=>'js:$("#antFamilia").addClass("has-warning")'
                            ))." ".$antFam["ant_fam"];
							?>
                          </label>
                     </div>
                 </div>
        <?php
			}
		?>
        <?php
			$modeloAntFFamilia->id_valtsoc=$idValTrSoc;
			echo $formAntFam->hiddenField($modeloAntFFamilia,'id_valtsoc');
			echo CHtml::hiddenField('numDocAdol' ,$numDocAdol, array('id' => 'numDoc'));
        	$boton=CHtml::Button (
				'Registrar',   
				array('id'=>'btnAntFam','class'=>'btn btn-default btn-sdis','name'=>'btnAntFam','onclick'=>'js:registraAntecVincServProt("formAntFam","registraAntFam","antFamilia");')
			);
        ?>
        <?php echo $boton; //CHtml::submitButton('Crear');?>
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
			foreach($probAsoc as $pkPrA=>$probAsoci){
				$checked=false;
				$checkedVinc=false;
				if(!empty($probAsocAdol)){
					foreach($probAsocAdol as $probAsocAdoli){
						if($probAsocAdoli["id_problema_asoc"]==$probAsoci["id_problema_asoc"]){	
							$checked=true;											
							if(!empty($probAsocAdoli["vinc_act_prob"])){
								$checkedVinc=true;	
							}
						}
					}
				}
				if(strpos($probAsoci["problema_asoc"],'pandillas')>0){
					?>
                    <div class="col-md-12">
                    	<div class="checkbox">
                         <label for="checkboxes-0">
							<?php
                            echo CHtml::CheckBox('ProblemaValtsocial[probasoc][prob_asoc_'.$pkPrA.']',$checked, array (
                                'id'=>'prob_asoc_'.$pkPrA,
                                'value'=>$probAsoci["id_problema_asoc"],
                                'onclick'=>'js:$("#btnProbAsoc").css("color","#F00")'
                            ))." ".$probAsoci["problema_asoc"]."<br/>-".
                            CHtml::CheckBox('vinc_pand',$checkedVinc, array (
                                'value'=>'true',
                                'onclick'=>'js:$("#btnProbAsoc").css("color","#F00")'
                            ))."Vinculado actualmente";
                            ?>
                    	</label>
                      </div>
                    </div>
                    <?php 	
				}
				elseif(strpos($probAsoci["problema_asoc"],'futbolistas')>0){		
					?>
                    <div class="col-md-12">
                    	<div class="checkbox">
                         <label for="checkboxes-0">
							<?php			
                            echo CHtml::CheckBox('ProblemaValtsocial[probasoc][prob_asoc_'.$pkPrA.']',$checked, array (
                                'id'=>'prob_asoc_'.$pkPrA,
                                'value'=>$probAsoci["id_problema_asoc"],
                                'onclick'=>'js:$("#btnProbAsoc").css("color","#F00")'
                            ))." ".$probAsoci["problema_asoc"]."<br/> -".
                            CHtml::CheckBox('vinc_barr_fut',$checkedVinc, array (
                                'value'=>'true',
                                'onclick'=>'js:$("#btnProbAsoc").css("color","#F00")'
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
                                'onclick'=>'js:$("#btnProbAsoc").css("color","#F00")'
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
        <?php
			$modeloProblemaValtsocial->id_valtsoc=$idValTrSoc;
			echo $formProbAsoc->hiddenField($modeloProblemaValtsocial,'id_valtsoc');
			echo CHtml::hiddenField('numDocAdol' ,$numDocAdol, array('id' => 'numDoc'));
        	$boton=CHtml::Button (
				'Registrar',   
				array('id'=>'btnProbAsoc','class'=>'btn btn-default btn-sdis','name'=>'btnProbAsoc','onclick'=>'js:registraAntecVincServProt("formProbAsoc","registraProbAsoc","btnProbAsoc")')
			);
        ?>
        <?php echo $boton; //CHtml::submitButton('Crear');?>
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
                                'onclick'=>'js:$("#btnServProt").css("color","#F00")'
                            ))." ".$servProt["serv_protec"]; 		
                            ?>
                           </label>
                      	</div>
               		</div> 
                <?php
			}
		?>
        <?php
			$modeloServprotecValtsocial->id_valtsoc=$idValTrSoc;
			echo $formServProt->hiddenField($modeloServprotecValtsocial,'id_valtsoc');
			echo CHtml::hiddenField('numDocAdol' ,$numDocAdol, array('id' => 'numDoc'));
        	$boton=CHtml::Button (
				'Registrar',   
				array('id'=>'btnServProt','class'=>'btn btn-default btn-sdis','name'=>'btnServProt','onclick'=>'js:registraAntecVincServProt("formServProt","registraServProtec","btnServProt")')
			);
        ?>
        <?php echo $boton; //CHtml::submitButton('Crear');?>
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
        <div class="form-group">
      		<label class="col-md-4 control-label" for="button1id"></label>
            <div class="col-md-4">	
				<?php echo $formTipoFam->hiddenField($modeloFamilia,'id_familia');
                $modeloFamilia->num_doc=$numDocAdol;
                echo $formTipoFam->hiddenField($modeloFamilia,'num_doc');
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnTipoFam','class'=>'btn btn-default btn-sdis','name'=>'btnTipoFam','onclick'=>'js:registraFam("'.$accion.'")')
                );
                ?>
       			<?php echo $boton; //CHtml::submitButton('Crear');?>
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
     		<code data-toggle="tooltip" title='Descripción de situaciones o antecedentes familiares relevantes que se presenten o se hayan presentado en la familia o en alguno de sus integrantes, específicamente relacionadas con alcoholismo, uso de drogas, prostitución, conductas delictivas, violencia intrafamiliar, desplazamiento forzado entre otras. Además describir las las relaciones interpersonales al interior de la familia, la comunicación entre sus miembros, pautas y manejo de autoridad. De igual manera describir los antecedentes o problemas asociados presentados por el adolescente como intentos suicidas, vinculación a pandillas, vinculación a barras futboleras, discapacidad y vinculación a servicios de protección.'>Ayuda</code>       
			<?php echo $formHistFam->textArea($modelValTrSoc,
                'historia_famvaltsic',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioHistFam","histFam")',
                    'onkeyup'=>'js:$("#histFam").addClass("has-warning")'
                ));
            ?>
            <?php echo $formHistFam->error($modelValTrSoc,'historia_famvaltsic',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
            $boton=CHtml::Button (
                'Registrar',   
                array('id'=>'btnFormHistFam','class'=>'btn btn-default btn-sdis','name'=>'btnFormHistFam','onclick'=>'js:enviaForm("formularioHistFam","btnFormObsFam")')
            );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
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
     		<code data-toggle="tooltip" title='En este aspecto, se debe tener en cuenta la participación de la familia frente al proceso; su reacción ante la situación que vinculó al adolescente al SRPA, el compromiso establecido frente a la reparación del daño causado al adolescente, a la víctima y a la sociedad.'>Ayuda</code>       
			<?php echo $formPerc->textArea($modelValTrSoc,
                'pa_f_dc',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioPerc","paFDc")',
                    'onkeyup'=>'js:$("#paFDc").addClass("has-warning")'
                ));
            ?>
			<?php echo $formPerc->error($modelValTrSoc,'pa_f_dc',array('style' => 'color:#F00'));?>
       </div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
			$boton=CHtml::Button (
				'Registrar',   
				array('id'=>'btnFormPerc','class'=>'btn btn-default btn-sdis','name'=>'btnFormPerc','onclick'=>'js:enviaForm("formularioPerc","paFDc")')
			);
			?>
			<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
<?php $this->endWidget();?>

</fieldset>

<?php 
	echo CHtml::hiddenField('idValTrSoc',$idValTrSoc);
	echo CHtml::hiddenField('numDocAdolValTrSoc',$numDocAdol);
?>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scripValTrSoc_1','
	$(document).ready(function(){
		$("#divFormTrSoc").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
		$("#datosFamiliarTab tr").find(":input").change(function(){
			var dirtyForm = $(this).parents("tr");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
	});
	function enviaForm(nombreForm,btnForm){
		$.ajax({
			url: "modificaValoracionTrSoc",
			data:$("#"+nombreForm).serialize()+"&idValTrSoc="+$("#idValTrSoc").val()+"&numDocAdolValTrSoc="+$("#numDocAdolValTrSoc").val(),
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				if(datos.estadoComu=="exito"){
					if(datos.resultado=="\'exito\'"){
						$("#"+btnForm).removeClass("has-warning");							
						$("#Mensaje").text("exito");
						$("#"+nombreForm).removeClass("unsavedForm");
					}
					else{
						$("#Mensaje").text("Error en la creación del registro.  Motivo "+datos.resultado);
					}
				}
				else{
					$("#Mensaje").text("no exito");
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#Mensaje").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#Mensaje").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#Mensaje").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});
	}
	function agregaRegDatosFam(){
		$("#datosFamiliarTab tr").find(":input").change(function(){var dirtyForm = $(this).parents("tr");dirtyForm.addClass("unsavedForm");});
		numFam= parseInt($("#numFamGen").val());
		numFam=numFam+1;
		var agregaReg="<tr id=\'"+numFam+"\'>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:5%\'>";
		agregaReg=agregaReg+"<input id=\'nomb_fam_"+numFam+"\' type=\'text\' name=\'nomb_fam_"+numFam+"\' style=\'width:100%\' />";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:5%\'>";
		agregaReg=agregaReg+"<input id=\'ap_fam_"+numFam+"\' type=\'text\' name=\'ap_fam_"+numFam+"\' style=\'width:100%\' />";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:10%\'>";
		agregaReg=agregaReg+"<input id=\'edad_fam_"+numFam+"\' type=\'text\' name=\'edad_fam_"+numFam+"\' style=\'width:100%\'/>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:5%\'>";
		agregaReg=agregaReg+"<select id=\'parentesco_"+numFam+"\' name=\'parentesco_"+numFam+"\' style=\'width:100%\'></select>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:5%\'>";
		agregaReg=agregaReg+"<input id=\'ocup_fam_"+numFam+"\' type=\'text\' name=\'ocup_fam_"+numFam+"\' style=\'width:100%\'/>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:5%\'>";
		agregaReg=agregaReg+"<select id=\'nivel_ed_"+numFam+"\' style=\'width:100%\'></select>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:5%\'>";
		agregaReg=agregaReg+"<input id=\'telefono_"+numFam+"\' type=\'text\'>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:5%\'>";
		agregaReg=agregaReg+"<input id=\'conv_adol_"+numFam+"\' type=\'checkbox\'  value=\'true\' style=\'width:100%\'/>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"<td  style=\' border:1px solid #000; width:5%\'>";
		agregaReg=agregaReg+"<input id=\'id_fam_"+numFam+"\' type=\'hidden\'>";
		agregaReg=agregaReg+"<input type=\'button\' onclick=\'js:quitaRegDatosFam("+numFam+")\' id=\'btnQuitaFam_"+numFam+"\' value=\'Quitar Registro\'>";
		agregaReg=agregaReg+"<input type=\'button\' onclick=\'javascript:creaRegFam("+numFam+")\'";
		agregaReg=agregaReg+"style=\'padding:0px 0px 0px 0px; margin:0px 0px 0px 0px;\' id=\'btnFam_"+numFam+"\' value=\'Crear Registro\'>";
		agregaReg=agregaReg+"</td>";
		agregaReg=agregaReg+"</tr>";
		$("#numFamGen").val(numFam);
		cargaDatosSelect("parentesco","id_parentesco","parentesco","","parentesco_"+numFam,"datosFamiliarTab");
		cargaDatosSelect("nivel_educativo","id_nivel_educ","nivel_educ","","nivel_ed_"+numFam,"vincPrevSrpaTable");
		$("#datosFamiliarTab").append(agregaReg);
		$("#btnAgregaFam").attr("disabled",true);
	}
	function quitaRegDatosFam(numFam){
		numFam= parseInt($("#numFamGen").val());
		$("#datosFamiliarTab #"+numFam).remove();
		numFam -=1;
		$("#numFamGen").val(numFam);
		$("#btnAgregaFam").attr("disabled",false);
	}
	function creaRegFam(numFam){
		var nombresFam=$("#nomb_fam_"+numFam).val();
		var apellidosFam=$("#ap_fam_"+numFam).val();
		var edad=$("#edad_fam_"+numFam).val();
		var parentesco=$("#parentesco_"+numFam+" option:selected").val();
		var ocupFam=$("#ocup_fam_"+numFam).val();
		var nivelEd=$("#nivel_ed_"+numFam+" option:selected").val();
		var telefono=$("#telefono_"+numFam).val();
		var convAdol=$("input:checkbox[id=conv_adol_"+numFam+"]");
		if(!/^[0-9]+\.?[0-9]*$/.test(edad)){
			alert("debe digitar solo números en la edad");
			return;
		}
		if(nombresFam.length==0 || apellidosFam.length==0 || edad.length==0 ||  parentesco.length==0 ||  ocupFam.length==0  ||  nivelEd.length==0 ||  telefono.length==0){
			alert("Faltan por diligenciar datos");	
			return;
		}
		var datos="nombres_familiar="+nombresFam+"&apellidos_familiar="+apellidosFam+"&edad_familiar="+edad+"&id_parentesco="+parentesco;
		datos=datos+"&ocupacion_familiar="+ocupFam+"&id_nivel_educ="+nivelEd;
		datos=datos+"&telefono="+telefono+"&convAdol="+convAdol.is(":checked")+"&numDocAdolValTrSoc="+$("#numDocAdolValTrSoc").val();
		$.ajax({
			url: "creaRegFam",			
			data:datos,
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				//$("#"+btnForm).css("color","#000");
				if(datos.estadoComu=="exito"){
					if(datos.resultado=="\'exito\'"){
						$("#Mensaje").text("exito");
						$("#btnQuitaFam_"+numFam).remove();
						$("#btnFam_"+numFam).attr( "value","Modificar");
						$("#btnFam_"+numFam).removeAttr( "onclick");
						$("#btnFam_"+numFam).bind( "click", function() {
							modificaDatosFam(numFam);
						});
						$("#btnAgregaFam").attr("disabled",false);
						$("#id_fam_"+numFam).val(datos.idFamiliar);
						$("#"+numFam).removeClass("unsavedForm");
					}
					else{
						$("#Mensaje").text("Error en la creación del registro.  Motivo "+datos.resultado);
					}
				}
				else{
					$("#Mensaje").text("no exito");
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#Mensaje").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#Mensaje").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#Mensaje").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});
	}
	function modificaDatosFam(numFam){
		var nombresFam=$("#nomb_fam_"+numFam).val();
		var apellidosFam=$("#ap_fam_"+numFam).val();
		var edad=$("#edad_fam_"+numFam).val();
		var parentesco=$("#parentesco_"+numFam+" option:selected").val();
		var ocupFam=$("#ocup_fam_"+numFam).val();
		var nivelEd=$("#nivel_ed_"+numFam+" option:selected").val();
		var telefono=$("#telefono_"+numFam).val();
		var convAdol=$("input:checkbox[id=conv_adol_"+numFam+"]");
		var idFam=$("#id_fam_"+numFam).val();
		if(!/^[0-9]+\.?[0-9]*$/.test(edad)){
			alert("debe digitar solo números en la edad");
			return;
		}
		if(nombresFam.length==0 || apellidosFam.length==0 || edad.length==0 ||  parentesco.length==0 ||  ocupFam.length==0  ||  nivelEd.length==0 ||  telefono.length==0){
			alert("Faltan por diligenciar datos");	
			return;
		}
		var datos="nombres_familiar="+nombresFam+"&apellidos_familiar="+apellidosFam+"&edad_familiar="+edad+"&id_parentesco="+parentesco+"&ocupacion_familiar="+ocupFam;
		datos=datos+"&id_nivel_educ="+nivelEd+"&telefono="+telefono+"&convAdol="+convAdol.is(":checked")+"&id_doc_familiar="+idFam;
		$.ajax({
			url: "modificaDatosFam",			
			data:datos,
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				//$("#"+btnForm).css("color","#000");
				if(datos.estadoComu=="exito"){
					if(datos.resultado=="\'exito\'"){
						$("#Mensaje").text("exito");
						$("#"+numFam).removeClass("unsavedForm");
					}
					else{
						$("#Mensaje").text(datos.resultado);
					}
					
					//$($("#vincPrevSrpaTable").find("tbody > tr")[numDel]).children("td")[3].innerHTML = agregaReg;
				}
				else{
					$("#Mensaje").text("no exito");
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#Mensaje").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#Mensaje").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#Mensaje").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});
	}
	function cargaDatosSelect(nombreEntidad,campoId,nombCampo,campo,idSelect,idTabla){
		data = "&nombreEntidad="+nombreEntidad+"&campoId="+campoId+"&nombCampo="+nombCampo;
		$.ajax({
			url:"consultaDatosForm",
			data:data,
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				if($("#"+idSelect).attr("multiple")!="multiple"){
					var contenidoSelect="<option value=\"\">Seleccione</option>";
				}
				else{
					var contenidoSelect="";	
				}
				$.each(datos,function(key,val){
					contenidoSelect=contenidoSelect+"<option value=\""+val.id+"\">"+val.contenido+"</option>";	
				});
				$("#"+idSelect).html(contenidoSelect);
			},
			
		});
	}
	function creaOtrRef(nomBoton){
		//+"&numDocAdolValTrSoc="+$("#numDocAdolValTrSoc").val();
		//alert($("#formularioOtrRef").serialize()+"&numDocAdol="+$("#numDocAdolValTrSoc").val());
		$.ajax({
			url: "creaOtrRef",			
			data:$("#formularioOtrRef").serialize()+"&numDocAdol="+$("#numDocAdolValTrSoc").val(),
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();$("#"+nomBoton).hide()},
			success: function(datos){
				Loading.hide();
				//$("#"+btnForm).css("color","#000");
				if(datos.estadoComu=="exito"){
					if(datos.resultado=="\'exito\'"){
						$("#MensajeOtrRef").text("exito");
						$("#"+nomBoton).show();
						$("#formularioOtrRef").removeClass("unsavedForm");   
						$("#formularioOtrRef #formularioOtrRef_es_").html("");                                                    
						$("#formularioOtrRef #formularioOtrRef_es_").hide();
						$("#"+nomBoton).attr("value","Modificar");
						$("#"+nomBoton).removeAttr( "onclick");
						$("#"+nomBoton).bind( "click", function() {
							modifOtrRef(nomBoton);
						});
					}
					else{
						$("#MensajeOtrRef").text(datos.resultado);
					}
				}
				else{
					$("#"+nomBoton).show();
					var errores="Por favor corrija los siguientes errores<br/><ul>";
					$.each(datos, function(key, val) {
						errores+="<li>"+val+"</li>";
						$("#formularioOtrRef #"+key+"_em_").text(val);                                                    
						$("#formularioOtrRef #"+key+"_em_").show();                                                
					});
					errores+="</ul>";
					$("#formularioOtrRef #formularioOtrRef_es_").html(errores);                                                    
					$("#formularioOtrRef #formularioOtrRef_es_").show(); 
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#MensajeOtrRef").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#MensajeOtrRef").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#MensajeOtrRef").text("No se ha creado el registro debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});	
	}
	
	function modifOtrRef(nomBoton){
		$.ajax({
			url: "modifOtrRef",			
			data:$("#formularioOtrRef").serialize()+"&numDocAdol="+$("#numDocAdolValTrSoc").val(),
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();$("#"+nomBoton).hide()},
			success: function(datos){
				Loading.hide();
				if(datos.estadoComu=="exito"){
					if(datos.resultado=="\'exito\'"){
						$("#MensajeOtrRef").text("exito");
						$("#"+nomBoton).show();
						$("#formularioOtrRef").removeClass("unsavedForm");   
						$("#formularioOtrRef #formularioOtrRef_es_").html("");                                                    
						$("#formularioOtrRef #formularioOtrRef_es_").hide();
					}
					else{
						$("#MensajeOtrRef").text(datos.resultado);
					}
				}
				else{
					$("#"+nomBoton).show();
					var errores="Por favor corrija los siguientes errores<br/><ul>";
					$.each(datos, function(key, val) {
						errores+="<li>"+val+"</li>";
						$("#formularioOtrRef #"+key+"_em_").text(val);                                                    
						$("#formularioOtrRef #"+key+"_em_").show();                                                
					});
					errores+="</ul>";
					$("#formularioOtrRef #formularioOtrRef_es_").html(errores);                                                    
					$("#formularioOtrRef #formularioOtrRef_es_").show(); 
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#MensajeOtrRef").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#MensajeOtrRef").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#MensajeOtrRef").text("No se ha creado el registro debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});	
	}
	function registraFam(accion){ 
		//alert($("#formTipoFam").serialize());
		$.ajax({
			url: accion,			
			data:$("#formTipoFam").serialize(),
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				//$("#formTipoFam").css("color","#000");
				if(datos.estadoComu=="exito"){
					if(datos.resultado=="\'exito\'"){
						$("#MensajeTipoFam").text("exito");
						$("#formTipoFam").removeClass("unsavedForm"); 
						$("#btnTipoFam").css("color","#000");
						if(accion=="creaTipoFam"){
							$("#btnTipoFam").removeAttr("onclick");
							$("#btnTipoFam").click(function(){
								registraFam("modTipoFam");								
							});
							$("#Familia_id_familia").val(datos.id_familia);
							
						}
						//$("#formTipoFam #formTipoFam_es_").html("");                                                    
						//$("#formTipoFam #formTipoFam_es_").hide(); 
					}
					else{
						$("#MensajeTipoFam").text("Error en el registro.  Motivo "+datos.resultado);
					}
				}
				else{
					$.each(datos, function(key, val) {
						$("#formTipoFam #"+key+"_em_").text(val);                                                    
						$("#formTipoFam #"+key+"_em_").show();
					});
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#MensajeAntVincProt").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#MensajeAntVincProt").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#MensajeAntVincProt").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});
	}
	function registraAntecVincServProt(form,accion,btnForm){
		$.ajax({
			url: accion,			
			data:$("#"+form).serialize(),
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				//$("#"+btnForm).css("color","#000");
				if(datos.estadoComu=="exito"){
					if(datos.resultado=="\'exito\'"){
						$("#MensajeAntVincProt").text("exito");
						$("#"+form).removeClass("unsavedForm"); 
						$("#"+btnForm).removeClass("has-warning")
						$("#"+form+" #"+form+"_es_").html("");                                                    
						$("#"+form+" #"+form+"_es_").hide(); 
					}
					else{
						$("#MensajeAntVincProt").text("Error en el registro.  Motivo "+datos.resultado);
					}
				}
				else{
					var errores="Por favor corrija los siguientes errores<br/><ul>";
					$.each(datos, function(key, val) {
						errores+="<li>"+val+"</li>";
					});
					errores+="</ul>";
					$("#"+form+" #"+form+"_es_").html(errores);                                                    
					$("#"+form+" #"+form+"_es_").show(); 

				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					$("#MensajeAntVincProt").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
				}
				else{
					if(xhr.status==500){
						$("#MensajeAntVincProt").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
					}
					else{
						$("#MensajeAntVincProt").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
					}	
				}	
			}
		});
	}
		//script para tooltip
	$( document ).ready(function() {		
        $("[data-toggle=\"tooltip\"]").tooltip();
    });

	',CClientScript::POS_END);
?>