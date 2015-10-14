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
			<?php echo $formularioProcPadres->textArea($modeloValNutr,'procedencia_padres',array('class'=>'form-control','onkeyup'=>'js:$("#divProcPadres").addClass("has-warning");'));?>
        	<?php echo $formularioProcPadres->error($modeloValNutr,'procedencia_padres',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Modificar',   
					array('id'=>'btnFormProcPadr','class'=>'btn btn-default btn-sdis','name'=>'btnFormProcPadr','onclick'=>'js:enviaFormNutr("formularioProcPadres","divProcPadres")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
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
			<?php echo $formularioAlimPref->textArea($modeloValNutr,'alimentos_preferidos',array('class'=>'form-control','onkeyup'=>'js:$("#divAlimPref").addClass("has-warning");'));?>
        	<?php echo $formularioAlimPref->error($modeloValNutr,'alimentos_preferidos',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Modificar',   					
					array('id'=>'btnFormAdolAlimPref','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolAlimPref','onclick'=>'js:enviaFormNutr("formularioAlimPref","divAlimPref")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
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
			<?php echo $formularioAlimRech->textArea($modeloValNutr,'alimentos_rechazados',array('class'=>'form-control','onkeyup'=>'js:$("#divAlimRech").addClass("has-warning");'));?>
        	<?php echo $formularioAlimRech->error($modeloValNutr,'alimentos_rechazados',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Modificar',   
					array('id'=>'btnFormAdolAlimRech','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolAlimRech','onclick'=>'js:enviaFormNutr("formularioAlimRech","divAlimRech")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
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
			<?php echo $formularioAlimInt->textArea($modeloValNutr,'alimentos_intolerados',array('class'=>'form-control','onkeyup'=>'js:$("#divAlimInt").addClass("has-warning");'));?>
        	<?php echo $formularioAlimInt->error($modeloValNutr,'alimentos_intolerados',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Modificar',   
					array('id'=>'btnFormAdolAlimInt','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolAlimInt','onclick'=>'js:enviaFormNutr("formularioAlimInt","divAlimInt")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
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
			<?php echo $formularioSupComplNtr->textArea($modeloValNutr,'supl_compl_nutr',array('class'=>'form-control','onkeyup'=>'js:$("#divAlimInt").addClass("has-warning");'));?>
        	<?php echo $formularioSupComplNtr->error($modeloValNutr,'supl_compl_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Modificar',   
					array('id'=>'btnFormAdolSuplComplNtr','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolSuplComplNtr','onclick'=>'js:enviaFormNutr("formularioSupComplNtr","divSupComplNtr")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
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
            <div class="col-sm-2">	
				<?php
                    $boton=CHtml::Button (
                        'Registrar',   
                        array('id'=>'btnFormAdolLechMat','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolLechMat'.$pk,'onclick'=>'js:validaLMBIB("formularioLechMat","divLechMat","ValoracionNutricional[recibio_leche_mat]","ValoracionNutricional_tiempo_lactancia_em_","ValoracionNutricional_tiempo_lactancia")')
                    );
                ?>
                <?php echo $boton; //CHtml::submitButton('Crear');?>
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
            <div class="col-sm-2">	
				<?php
                    $boton=CHtml::Button (
                        'Registrar',   
                        array('id'=>'btnFormAdolBiberon','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolBiberon','onclick'=>'js:validaLMBIB("formularioBiberon","divBiberon","ValoracionNutricional[recibio_biberon]","ValoracionNutricional_tiempo_biberon_em_","ValoracionNutricional_tiempo_biberon")')
                    );
                ?>
                <?php echo $boton; //CHtml::submitButton('Crear');?>
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
        <div class="form-group">
        <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));	?>
            <div class="col-sm-2">	
				<?php
                    $boton=CHtml::Button (
                        'Registrar',   
                        array('id'=>'btnFormAdolAlimHogar','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolAlimHogar','onclick'=>'js:enviaFormNutrGrupo("formularioAlimHogar","fieldRecibeAlim")')
                    );
                ?>
                <?php echo $boton; //CHtml::submitButton('Crear');?>
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
        <div class="form-group">
       		<?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));	?>
            <div class="col-sm-2">	
				<?php
                    $boton=CHtml::Button (
                        'Registrar',   
                        array('id'=>'btnFormAdolHabitos','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolHabitos','onclick'=>'js:enviaFormNutrGrupo("formularioHabitos","formularioHabitos")')
                    );
                ?>
                <?php echo $boton; //CHtml::submitButton('Crear');?>
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
				<?php echo $formularioFisico->textArea($modeloValNutr,'desarrollo_psicomotor',array('class'=>'form-control input-md','onkeyup'=>'js:$("#formularioFisico").addClass("has-warning");'));?>
    		</div>
        </div>
        <div class="form-group">
        <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));	?>
            <div class="col-sm-2">	
				<?php
                    $boton=CHtml::Button (
                        'Registrar',   
                        array('id'=>'btnFormAdolFisico','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolFisico','onclick'=>'js:enviaFormNutrGrupo("formularioFisico","formularioFisico")')
                    );
                ?>
                <?php echo $boton; //CHtml::submitButton('Crear');?>
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
            <div class="col-sm-1">
				<strong></strong>
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
			<div class="col-sm-1">
				<?php echo $formularioFrecConsGrCom->hiddenField($modeloGrupocomidaValnutr,'id_val_nutricion');?>
				<?php echo $formularioFrecConsGrCom->hiddenField($modeloGrupocomidaValnutr,'id_grupo_comida');?>
				<?php				
                    $boton=CHtml::Button (
                        'Registrar',   
                        array('id'=>'btnFormAdolFrecCons'.$comida["id_grupo_comida"],'class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolFrecCons'.$comida["id_grupo_comida"],'onclick'=>'js:enviaFormFrecCons("formularioFrecConsGrCom'.$comida["id_grupo_comida"].'","'.$comida["id_grupo_comida"].'")')
                    );
                ?>
                <?php echo $boton; //CHtml::submitButton('Crear');?>
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
		$("#formNutrAntAlim").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
		$("#labExtr").hide()
	});
	
	function validaLMBIB(formId,divId,objetoLMB){
		jAlert(objetoLMB.value);
		
	}
	function validaLMBIB(formId,divId,nameCampo,idError,idCampoTiempo){
		//jAlert($("#"+formId+" #ValoracionNutricional_obs_crec_des").val().length);
		$("#"+formId+" #"+idError).text("");                                                    
		$("#"+formId+" #"+idError).show(); 
		var opcion =$("input[name=\'"+nameCampo+"\']:checked").val();
		if(opcion=="true" && $("#"+formId+" #"+idCampoTiempo).val().length==0){
			$("#"+formId+" #"+idError).text("Debe digitar un tiempo");                                                    
			$("#"+formId+" #"+idError).show(); 
		}
		else{
			if(opcion=="false"){
				$("#"+formId+" #"+idCampoTiempo).val("");	
			}
			enviaFormNutrGrupo(formId,divId);		
		}
		
	}
	function enviaFormFrecCons(nombreForm,idComida){
		$("#"+nombreForm+" .errorMessage").text("");	
		//jAlert($("#formularioFrecConsGrCom"+idComida).serialize());
			$.ajax({
				url: "registraFrecCons",
				data:$("#formularioFrecConsGrCom"+idComida).serialize(),
				dataType:"json",
				type: "post",
				beforeSend:function (){Loading.show();},
				success: function(datos){
					Loading.hide();
					if(datos.estadoComu=="exito"){
						//$("#"+btnForm).css("color","#000");
						if(datos.resultado=="exito"){
							$("#"+nombreForm).removeClass("has-warning");
							$("#"+nombreForm).removeClass("unsavedForm");
							jAlert("Registro realizado satisfactoriamente","Mensaje");														
						}
						else{
							jAlert("Error en la creación del registro.  Motivo "+datos.resultado,"Mensaje");
						}
					}
					else{
						$.each(datos, function(key, val) {						                                                    						
							$("#"+nombreForm+" #"+key+"_em_").text(val);                                                    
							$("#"+nombreForm+" #"+key+"_em_").show();                                                
						});
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					Loading.hide();
					//0 para error en comunicación
					//200 error en lenguaje o motor de base de datos
					//500 Internal server error
					if(xhr.status==0){
						jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema","Mensaje");
					}
					else{
						if(xhr.status==500){
							jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información","Mensaje");
						}
						else{
							jAlert("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado","Mensaje");
						}	
					}	
				}
			});
		}
'
,CClientScript::POS_END);
?>
