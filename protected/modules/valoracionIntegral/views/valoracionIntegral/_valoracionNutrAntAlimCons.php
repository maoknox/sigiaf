<div id="formNutrAntAlim">
	<?php $formularioProcPadres=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioProcPadres',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divProcPadres" class="form-group">
    	<div class="col-sm-12">
            <?php echo $formularioProcPadres->labelEx($modeloValNutr,'procedencia_padres',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<div class='cont-infoval'><?php echo $modeloValNutr->procedencia_padres;?></div>									
        	<?php echo $formularioProcPadres->error($modeloValNutr,'procedencia_padres',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
<hr />
	<?php $formularioAlimPref=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioAlimPref',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divAlimPref" class="form-group">
    	<div class="col-sm-12">
            <?php echo $formularioAlimPref->labelEx($modeloValNutr,'alimentos_preferidos',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<div class='cont-infoval'><?php echo $modeloValNutr->alimentos_preferidos;?></div>									
        	<?php echo $formularioAlimPref->error($modeloValNutr,'alimentos_preferidos',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
<hr />
	<?php $formularioAlimRech=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioAlimRech',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divAlimRech" class="form-group">
    	<div class="col-sm-12">
            <?php echo $formularioAlimRech->labelEx($modeloValNutr,'alimentos_rechazados',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<div class='cont-infoval'><?php echo $modeloValNutr->alimentos_rechazados;?></div>									
        	<?php echo $formularioAlimRech->error($modeloValNutr,'alimentos_rechazados',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
<hr />
	<?php $formularioAlimInt=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioAlimInt',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divAlimInt" class="form-group">
    	<div class="col-sm-12">
            <?php echo $formularioAlimInt->labelEx($modeloValNutr,'alimentos_intolerados',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<div class='cont-infoval'><?php echo $modeloValNutr->alimentos_intolerados;?></div>									
        	<?php echo $formularioAlimInt->error($modeloValNutr,'alimentos_intolerados',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
<hr />
	<?php $formularioSupComplNtr=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioSupComplNtr',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divSupComplNtr" class="form-group">
    	<div class="col-sm-12">
            <?php echo $formularioSupComplNtr->labelEx($modeloValNutr,'supl_compl_nutr',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<div class='cont-infoval'><?php echo $modeloValNutr->supl_compl_nutr;?></div>									
        	<?php echo $formularioSupComplNtr->error($modeloValNutr,'supl_compl_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
    <hr />
	<?php $formularioLechMat=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioLechMat',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
    <?php 
		$recibLecheSI=false;
		$recibLecheNo=false;
		if($consLecheMat["recibio_leche_mat"]=='t'){
			$recibLecheSI=true;
		}
		elseif($consLecheMat["recibio_leche_mat"]=='f'){
			$recibLecheNo=true;
		}
	?>
    <div id="divLechMat" class="form-group">
        <?php echo $formularioLechMat->labelEx($modeloValNutr,'recibio_leche_mat',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
        <div  class="col-sm-2"> 
        
            <label class="radio-inline" for="radios-0">
            <?php
				echo CHtml::radioButton('ValoracionNutricional[recibio_leche_mat]',
					$recibLecheSI,array('id'=>'ValoracionNutricional_recibio_leche_mat_si',
					'value'=>'true'
					)				
				);			
			?>
               Si
            </label> 
            <label class="radio-inline" for="radios-1"><?php
				echo CHtml::radioButton('ValoracionNutricional[recibio_leche_mat]',
					$recibLecheNo,array('id'=>'ValoracionNutricional_recibio_leche_mat_no',
					'value'=>'false'
					)				
				);			
				?>No</label> 
            </div>
            <div class="col-sm-2">
           		<?php echo $formularioLechMat->labelEx($modeloValNutr,'tiempo_lactancia',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            </div>
            <div class="col-sm-2">
				<?php echo $formularioLechMat->textField($modeloValNutr,'tiempo_lactancia',array('class'=>'form-control input-md','onkeyup'=>'js:$("#divLechMat").addClass("has-warning");'));?>
                <?php echo $formularioLechMat->error($modeloValNutr,'tiempo_lactancia',array('style' => 'color:#F00'));?>
    		</div>
         </div>
	<?php $this->endWidget();?>
    <hr />
	<?php $formularioBiberon=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioBiberon',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
    <?php
		$recibBibSi=false;
		$recibBibNo=false;
		if($consBiberon["recibio_biberon"]=='t'){
			$recibBibSi=true;
		}
		elseif($consBiberon["recibio_biberon"]=='f'){
			$recibBibNo=true;
		}
	?>
    <div id="divBiberon" class="form-group">
        <?php echo $formularioBiberon->labelEx($modeloValNutr,'recibio_biberon',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
        <div  class="col-sm-2"> 
        
            <label class="radio-inline" for="radios-0">
            <?php
				echo CHtml::radioButton('ValoracionNutricional[recibio_biberon]',
					$recibBibSi,array('id'=>'ValoracionNutricional_recibio_biberon_si',
					'value'=>'true'
					)				
				);			
			?>
               Si
            </label> 
            <label class="radio-inline" for="radios-1"><?php
				echo CHtml::radioButton('ValoracionNutricional[recibio_biberon]',
					$recibBibNo,array('id'=>'ValoracionNutricional_recibio_biberon_no',
					'value'=>'false'
					)				
				);			
				?>No</label> 
            </div>
            <div class="col-sm-2">
           		<?php echo $formularioBiberon->labelEx($modeloValNutr,'tiempo_biberon',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            </div>
            <div class="col-sm-2">
				<?php echo $formularioBiberon->textField($modeloValNutr,'tiempo_biberon',array('class'=>'form-control input-md','onkeyup'=>'js:$("#divBiberon").addClass("has-warning");'));?>
                <?php echo $formularioBiberon->error($modeloValNutr,'tiempo_biberon',array('style' => 'color:#F00'));?>
    		</div>
         </div>
	<?php $this->endWidget();?>
 <hr />
    <fieldset id="fieldRecibeAlim">
        <?php $formularioAlimHogar=$this->beginWidget('CActiveForm', array(
                'id'=>'formularioAlimHogar',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>false,
                ),
                'htmlOptions' => array('class' => 'form-horizontal')
            ));
        ?>
    	<div class="form-group">
           	<?php echo $formularioAlimHogar->labelEx($modeloValNutr,'personas_alim_olla',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <div class="col-md-4">
				<?php echo $formularioAlimHogar->textField($modeloValNutr,'personas_alim_olla',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldRecibeAlim").addClass("has-warning");'));?>
                <?php echo $formularioAlimHogar->error($modeloValNutr,'personas_alim_olla',array('style' => 'color:#F00'));?>
            </div>
        </div>
        <div class="form-group">
			<?php
                //$modeloPersona->id_cedula=$id_cedula;
                $op=array();
                foreach($origenAlimentos as $origenAlimento){
                    if(!empty($origenAlimentosHogar) && is_array($origenAlimentosHogar)){
                        foreach($origenAlimentosHogar as $origenAlimentoHogar){						
                            if($origenAlimento["id_origen_alim"]==$origenAlimentoHogar["id_origen_alim"]){
                                $op[$origenAlimento["id_origen_alim"]]=array('selected'=>true);
                            }
                        }
                    }
                }
            ?>
           	<?php echo $formularioAlimHogar->labelEx($modeloOrigenalimValnutr,'id_origen_alim',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <div class="col-md-4">
				<?php echo $formularioAlimHogar->dropDownList($modeloOrigenalimValnutr,'id_origen_alim',CHtml::listData($origenAlimentos,'id_origen_alim', 'origen_alimentos'), 
				array(
					'title'=>'Selecciones uno o más',
					'multiple'=>'multiple',					
					'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true'
					,'options'=>$op								
				)); ?>
                <?php echo $formularioAlimHogar->error($modeloOrigenalimValnutr,'id_origen_alim',array('style' => 'color:#F00'));?>
    		</div>
        </div>
    	<div class="form-group">
           	<?php echo $formularioAlimHogar->labelEx($modeloValNutr,'quien_cocina_casa',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <div class="col-md-4">
				<?php echo $formularioAlimHogar->textField($modeloValNutr,'quien_cocina_casa',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldRecibeAlim").addClass("has-warning");'));?>
                <?php echo $formularioAlimHogar->error($modeloValNutr,'quien_cocina_casa',array('style' => 'color:#F00'));?>
            </div>
        </div>
        <div class="form-group">
           	<?php echo $formularioAlimHogar->labelEx($modeloValNutr,'num_comidas_diarias',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <div class="col-md-4">
				<?php echo $formularioAlimHogar->textField($modeloValNutr,'num_comidas_diarias',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldRecibeAlim").addClass("has-warning");'));?>
                <?php echo $formularioAlimHogar->error($modeloValNutr,'num_comidas_diarias',array('style' => 'color:#F00'));?>
            </div>
        </div>
        <div class="form-group">
           	<?php echo $formularioAlimHogar->labelEx($modeloValNutr,'donde_recibe_alim',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <div class="col-md-4">
				<?php echo $formularioAlimHogar->textField($modeloValNutr,'donde_recibe_alim',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldRecibeAlim").addClass("has-warning");'));?>
                 <?php echo $formularioAlimHogar->error($modeloValNutr,'donde_recibe_alim',array('style' => 'color:#F00'));?>   		
            </div>
        </div>
        <div class="form-group">
           	<?php echo $formularioAlimHogar->labelEx($modeloValNutr,'inicio_almient_compl',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <div class="col-md-4">
				<?php echo $formularioAlimHogar->textField($modeloValNutr,'inicio_almient_compl',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldRecibeAlim").addClass("has-warning");'));?>
                <?php echo $formularioAlimHogar->error($modeloValNutr,'inicio_almient_compl',array('style' => 'color:#F00'));?>
            </div>
        </div>
        <?php $this->endWidget();?>
    </fieldset>
    <hr />
    <div class="panel-heading color-sdis"> FACTORES ASOCIADOS AL PROCESO DE ALMENTACIÓN <code data-toggle="tooltip" title='Seleccione las opciones de acuerdo a lo evaluado, apetito, ingesta, masticación, hábito intestital.'>Ayuda</code> </div> 
		<?php $formularioAlimHogar=$this->beginWidget('CActiveForm', array(
                'id'=>'formularioHabitos',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>false,
                ),
                'htmlOptions' => array('class' => 'form-horizontal')
            ));
        ?>
    	<div class="form-group">
        <?php echo $formularioBiberon->labelEx($modeloValNutr,'id_apetito',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
        	<div  class="col-sm-4"> 
            	<?php 
					foreach($apetito as $apetitoAdol):
					$selOpt=false;
					if($apetitoAdol["id_apetito"]==$modeloValNutr->id_apetito){
						$selOpt=true;
					}
				?>
                <label class="radio-inline" for="radios-0">
                <?php
                    echo CHtml::radioButton('ValoracionNutricional[id_apetito]',
                        $selOpt,array('id'=>'ValoracionNutricional_id_apetito_'.$apetitoAdol["id_apetito"],
                        'value'=>$apetitoAdol["id_apetito"],
						'onclick'=>'js:$("#formularioHabitos").addClass("has-warning");'
                        )				
                    )."".$apetitoAdol["habito_apetito"];			
                ?>                   
                </label>  
                <?php endforeach;?>          
            </div>
        </div>
        <div class="form-group">
        <?php echo $formularioBiberon->labelEx($modeloValNutr,'id_ingesta',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
        	<div  class="col-sm-4"> 
            	<?php 
					foreach($ingesta as $ingestaAdol):
					$selOpt=false;
					if($ingestaAdol["id_ingesta"]==$modeloValNutr->id_ingesta){
						$selOpt=true;
					}
				?>
                <label class="radio-inline" for="radios-0">
                <?php
                    echo CHtml::radioButton('ValoracionNutricional[id_ingesta]',
                        $selOpt,array('id'=>'ValoracionNutricional_id_ingesta_'.$ingestaAdol["id_ingesta"],
                        'value'=>$ingestaAdol["id_ingesta"],
						'onclick'=>'js:$("#formularioHabitos").addClass("has-warning");'
                        )				
                    )."".$ingestaAdol["habito_ingesta"];			
                ?>                   
                </label>  
                <?php endforeach;?>          
            </div>
        </div>
        <div class="form-group">
        <?php echo $formularioBiberon->labelEx($modeloValNutr,'id_masticacion',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
        	<div  class="col-sm-4"> 
            	<?php 
					foreach($masticacion as $masticacionAdol):
					$selOpt=false;
					if($masticacionAdol["id_masticacion"]==$modeloValNutr->id_masticacion){
						$selOpt=true;
					}
				?>
                <label class="radio-inline" for="radios-0">
                <?php
                    echo CHtml::radioButton('ValoracionNutricional[id_masticacion]',
                        $selOpt,array('id'=>'ValoracionNutricional_id_masticacion_'.$masticacionAdol["id_masticacion"],
                        'value'=>$masticacionAdol["id_masticacion"],
						'onclick'=>'js:$("#formularioHabitos").addClass("has-warning");'
                        )				
                    )."".$masticacionAdol["habito_mastic"];			
                ?>                   
                </label>  
                <?php endforeach;?>          
            </div>
        </div>
        <div class="form-group">
        <?php echo $formularioBiberon->labelEx($modeloValNutr,'id_digestion',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
        	<div  class="col-sm-4"> 
            	<?php 
					foreach($digestion as $digestionAdol):
					$selOpt=false;
					if($digestionAdol["id_digestion"]==$modeloValNutr->id_digestion){
						$selOpt=true;
					}
				?>
                <label class="radio-inline" for="radios-0">
                <?php
                    echo CHtml::radioButton('ValoracionNutricional[id_digestion]',
                        $selOpt,array('id'=>'ValoracionNutricional_id_digestion_'.$digestionAdol["id_digestion"],
                        'value'=>$digestionAdol["id_digestion"],
						'onclick'=>'js:$("#formularioHabitos").addClass("has-warning");'
                        )				
                    )."".$digestionAdol["habito_digestion"];			
                ?>                   
                </label>  
                <?php endforeach;?>          
            </div>
        </div>
        <div class="form-group">
        <?php echo $formularioBiberon->labelEx($modeloValNutr,'id_hab_intest',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
        	<div  class="col-sm-4"> 
            	<?php 
					foreach($habitoIntestinal as $habitoIntestinalAdol):
					$selOpt=false;
					if($habitoIntestinalAdol["id_hab_intest"]==$modeloValNutr->id_hab_intest){
						$selOpt=true;
					}
				?>
                <label class="radio-inline" for="radios-0">
                <?php
                    echo CHtml::radioButton('ValoracionNutricional[id_hab_intest]',
                        $selOpt,array('id'=>'ValoracionNutricional_id_hab_intest_'.$habitoIntestinalAdol["id_hab_intest"],
                        'value'=>$habitoIntestinalAdol["id_hab_intest"],
						'onclick'=>'js:$("#formularioHabitos").addClass("has-warning");'
                        )				
                    )."".$habitoIntestinalAdol["habito_intestinal"];			
                ?>                   
                </label>  
                <?php endforeach;?>          
            </div>
        </div>

        <?php $this->endWidget();?>
    <div class="panel-heading color-sdis"> FÍSICO </div> 
		<?php $formularioFisico=$this->beginWidget('CActiveForm', array(
                'id'=>'formularioFisico',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>false,
                ),
                'htmlOptions' => array('class' => 'form-horizontal')
            ));
        ?>
        <div class="form-group">
        <?php echo $formularioBiberon->labelEx($modeloValNutr,'id_nivel_act_fis',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
        	<div  class="col-sm-6"> 
            	<?php 
					foreach($nivelActFisica as $actFisica):
					$selOpt=false;
					if($actFisica["id_nivel_act_fis"]==$modeloValNutr->id_nivel_act_fis){
						$selOpt=true;
					}
				?>
                <label class="radio-inline" for="radios-0">
                <?php
                    echo CHtml::radioButton('ValoracionNutricional[id_nivel_act_fis]',
                        $selOpt,array('id'=>'ValoracionNutricional_id_nivel_act_fis_'.$actFisica["id_nivel_act_fis"],
                        'value'=>$actFisica["id_nivel_act_fis"],
						'onclick'=>'js:$("#formularioFisico").addClass("has-warning");'
                        )				
                    )."".$actFisica["nivel_act_fis"];			
                ?>                   
                </label>  
                <?php endforeach;?>          
            </div>
        </div>
        <div class="form-group">
           	<?php echo $formularioFisico->labelEx($modeloValNutr,'horas_sueno',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <div class="col-md-2">
				<?php echo $formularioFisico->textField($modeloValNutr,'horas_sueno',array('class'=>'form-control input-md','onkeyup'=>'js:$("#formularioFisico").addClass("has-warning");'));?>
                <?php echo $formularioFisico->error($modeloValNutr,'horas_sueno',array('style' => 'color:#F00'));?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
           		<?php echo $formularioFisico->labelEx($modeloValNutr,'desarrollo_psicomotor',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
                <div class='cont-infoval'><?php echo $modeloValNutr->desarrollo_psicomotor;?></div>									
    		</div>
        </div>
        <?php $this->endWidget();?>
    <div class="panel-heading color-sdis"> FRECUENCIA DE CONSUMO DE ALIMENTOS </div> <br />
    <fieldset id="fieldFreCons">
		<div class="form-group"> 
            <?php echo CHtml::label('Grupo de alimentos/Tiempo de comida','',array('class'=>'col-sm-3 control-label','for'=>'searchinput'));	?>            
            <?php //echo $formularioLabClinicos->labelEx($modeloLabclinValnutr,'resultado_labclin',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <?php
                foreach($frecConsumo as $frecuencia):
            ?>
                <div class="col-sm-1">
                    <strong><?php echo $frecuencia["frecuencia_cons"];?></strong>
                </div>
           <?php endforeach;?>
           <div class="col-sm-3" align="center">
				<strong>Observaciones</strong>
        	</div>
        </div><br /><br /><br /><br />
<?php		
		
	$frecuencia="";
	$modeloGrupocomidaValnutr->id_val_nutricion=$modeloValNutr->id_val_nutricion;
	foreach($grupoComida as $comida){
		$modeloGrupocomidaValnutr->id_grupo_comida=$comida["id_grupo_comida"];
		$consultaComidaFrec=$modeloGrupocomidaValnutr->consultaFrecuenciaConsObs();
		?>
       	<?php $formularioFrecConsGrCom=$this->beginWidget('CActiveForm', array(
                'id'=>'formularioFrecConsGrCom'.$comida["id_grupo_comida"],
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>false,
                ),
                'htmlOptions' => array('class' => 'form-horizontal')
            ));
        ?>

		<div class="form-group"> 
            <?php echo $formularioFrecConsGrCom->error($modeloGrupocomidaValnutr,'id_frec_cons',array('style' => 'color:#F00','align'=>'center'));?>
			<?php echo CHtml::label($comida["grupo_comida"],'',array('class'=>'col-sm-3 control-label','for'=>'searchinput'));	?>
			<?php foreach($frecConsumo as $frecuencia):?>
			<?php 
				$selOpt=false;
				if($consultaComidaFrec["id_frec_cons"]==$frecuencia["id_frec_cons"]){
					$selOpt=true;							
				}					
			?>
			
			<div class="col-sm-1" align="center">
				<label class="radio-inline" for="radios-0">
					<?php
						echo CHtml::radioButton('GrupocomidaValnutr[id_frec_cons]',
							$selOpt,array('id'=>'GrupocomidaValnutr'.$frecuencia["id_frec_cons"]."_".$comida["id_grupo_comida"],
							'value'=>$frecuencia["id_frec_cons"],
							'onclick'=>'js:$("#formularioFrecConsGrCom'.$comida["id_grupo_comida"].'").addClass("has-warning");'
							)				
						)		
					?>                   
				</label>  
			 </div>   
			<?php endforeach; ?>
			<div class="col-sm-3" align="center">
				<div class="col-sm-12">
					<?php 
						$modeloGrupocomidaValnutr->observ_frec_cons="";
						if(!empty($consultaComidaFrec)){
							$modeloGrupocomidaValnutr->observ_frec_cons=$consultaComidaFrec["observ_frec_cons"];
						}
						echo $formularioFrecConsGrCom->textArea($modeloGrupocomidaValnutr,'observ_frec_cons',array('class'=>'form-control input-md','onkeyup'=>'js:$("#formularioFrecConsGrCom'.$comida["id_grupo_comida"].'").addClass("has-warning");'));						
					?>
				</div>
			</div>
		</div>
        <?php $this->endWidget();?>
	<?php				
	}
	?>
        
	</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scriptValNutrAntAlim','
	$(document).ready(function(){
		$("#formNutrAntAlim").find(":input").attr("disabled","disabled");
	});
'
,CClientScript::POS_END);
?>
