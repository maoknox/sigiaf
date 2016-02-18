<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="formNutrAntExamenes">
<?php
//print_r($parentesco);
?>
	<div id="Mensaje" style="font-size:14px;" ></div>
	<?php /* $this->widget('application.extensions.magnific-popup.EMagnificPopup', array('target' => '.test-popup-link'));*/?>
    
    <div class="panel-heading color-sdis"> LABORATORIOS CLÍNICOS <code data-toggle="tooltip" title='Si el Adolescente trae laboratorios registre la fecha y el resultado.'>Ayuda</code> </div> 
    <fieldset id="fieldLabClin">
       
         <div class="form-group"> 
       			<?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));	?>            
				<?php //echo $formularioLabClinicos->labelEx($modeloLabclinValnutr,'resultado_labclin',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
                <div class="col-sm-2">
                	Resultado
                </div>
                <div class="col-sm-2">
                	Fecha
                </div>
                <div>
                
                </div>
            </div>

<br />
    	<?php foreach($laboratorios as $pk=>$laboratorio):	?>
        	<?php
				if(!empty($labClinicosAdol) and is_array($labClinicosAdol)){
					foreach($labClinicosAdol as $labClinicoAdol){
						if($labClinicoAdol["id_laboratorio"]==$laboratorio["id_laboratorio"]){
							$modeloLabclinValnutr->resultado_labclin=$labClinicoAdol["resultado_labclin"];
							$modeloLabclinValnutr->fecha_reslabclin=$labClinicoAdol["fecha_reslabclin"];
						}
					}		
				}
			?>
            <?php
				$imprime=false;
				if($laboratorio["id_laboratorio"]==1 || $laboratorio["id_laboratorio"]==2){
					$imprime=true;
				}
				else{
					if($laboratorio["id_laboratorio"]>2 && !empty($modeloLabclinValnutr->resultado_labclin)){
						$imprime=true;
					}
				}
			?>                        
			<?php if($imprime):?>            
				<?php $formularioLabClinicos=$this->beginWidget('CActiveForm', array(
                    'id'=>'formularioLabClinicos'.$pk,
                    'enableAjaxValidation'=>false,
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>false,
                    ),
                    'htmlOptions' => array('class' => 'form-horizontal')
                ));
                ?>
               <div class="form-group"> 
                    <?php echo CHtml::label($laboratorio["laboratorio_clin"],$laboratorio["laboratorio_clin"],array('class'=>'col-md-4 control-label','for'=>'searchinput'));	?>
                    <?php //echo $formularioLabClinicos->labelEx($modeloLabclinValnutr,'resultado_labclin',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
                    <div class="col-sm-2">
                        <?php echo $formularioLabClinicos->textArea($modeloLabclinValnutr,'resultado_labclin',array('class'=>'form-control input-md','onchange'=>'js:$("#formularioLabClinicos'.$pk.'").addClass("has-warning");'));?>
                        <?php echo $formularioLabClinicos->error($modeloLabclinValnutr,'resultado_labclin',array('style' => 'color:#F00'));?>
                    </div>
                    <div class="col-sm-2">
                        <?php //
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                                array('model'=>$modeloLabclinValnutr,
								'id'=>'fecha_reslabclin'.$pk,
                                'attribute'=>'fecha_reslabclin',
                                'value'=>$modeloLabclinValnutr->fecha_reslabclin,
                                'language'=>'es',			
                                'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control','onchange'=>'js:$("#formularioLabClinicos'.$pk.'").addClass("has-warning");'),			
                                'options'=>array('autoSize'=>true,
                                        'defaultDate'=>$modeloLabclinValnutr->fecha_reslabclin,
                                        'dateFormat'=>'yy-mm-dd',
                                        'buttonText'=>'Seleccione Fecha',
                                        'selectOtherMonths'=>true,
                                        'showAnim'=>'slide',
                                        'showOtherMonths'=>true,
                                        'changeMonth'=>'true',
                                        'changeYear'=>'true',
                                        'minDate'=>'',//fecha minima
                                        'maxDate'=>'date("Y-m-d")',//fecha maxima
                                ),
                            ));
                            
                        ?>
                        <?php echo $formularioLabClinicos->error($modeloLabclinValnutr,'fecha_reslabclin',array('style' => 'color:#F00'));?>    	
                    </div>
                    <div class="col-sm-2">	
                        <?php 
							$modeloLabclinValnutr->id_laboratorio=$laboratorio["id_laboratorio"];
							echo $formularioLabClinicos->hiddenField($modeloLabclinValnutr,'id_laboratorio',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldDatosNacim").addClass("has-warning");'));
							$modeloLabclinValnutr->id_val_nutricion=$modeloValNutr->id_val_nutricion;
							echo $formularioLabClinicos->hiddenField($modeloLabclinValnutr,'id_val_nutricion',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldDatosNacim").addClass("has-warning");'));
						?>
               		</div>
                </div>
                <?php
                    $modeloLabclinValnutr->unsetAttributes();
                    $this->endWidget();
                ?>  
                <?php endif;?>
		<?php   endforeach;?>
    
	</fieldset>
    <hr />
    <div class="panel-heading color-sdis"> ESQUEMA DE VACUNACIÓN <code data-toggle="tooltip" title='Solicite al padre, madre o cuidador el carné de vacunas y verifique si tiene el esquema al día o adecuado para la edad, completo (todas las vacunas del esquema), incompleto, y marque con X de acuerdo al hallazgo. Y registre cuaéles vacunas le hacen falta.'>Ayuda</code> </div> 
<fieldset id="fieldEsqVac">
<?php $formEsquemaVac=$this->beginWidget('CActiveForm', array(
	'id'=>'formEsquemaVac',
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
				<?php 
                    $selOpt=false;
                    foreach($esquemasVac as $esquemaVac){
                        if($modeloValNutr->id_esquema_vac==$esquemaVac["id_esquema_vac"]){$selOpt=true;}
                        echo "<div>".CHtml::radioButton('ValoracionNutricional[id_esquema_vac]',
                            $selOpt,array('id'=>'ValoracionNutricional_id_esquema_vac_'.$esquemaVac["id_esquema_vac"],
                            'onclick'=>'js:$("#fieldEsqVac").addClass("has-warning");',
                            'value'=>$esquemaVac["id_esquema_vac"]
                            )				
                        )."".$esquemaVac["esquema_vac"]."</div>";
                        $selOpt=false;
                    }
                ?>   			
                <?php echo $formEsquemaVac->error($modeloEsquemaVacunacion,'id_esquema_vac',array('style' => 'color:#F00'));?>

    	</div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
			<div class='cont-infoval'><?php echo $modeloValNutr->obs_esquema_vac;?></div>												
            <?php echo $formEsquemaVac->error($modeloValNutr,'obs_esquema_vac',array('style' => 'color:#F00'));?>
        </div>
    </div>    
<?php $this->endWidget();?>
</fieldset>
<hr />


<div class="panel-heading color-sdis">ASISTE ACTUALMENTE CONTROL DE CRECIMIENTO Y DESARROLLO <code data-toggle="tooltip" title='marque con una X la respuesta y coloque la fecha del último control, si la respuesta es NO, verifique  por qué.'>Ayuda</code> </div> 
<fieldset id="fieldControlCrecim">
<?php $formControlCrecim=$this->beginWidget('CActiveForm', array(
	'id'=>'formControlCrecim',
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
				<?php 
                    $selOptSi=false;
					$selOptNo=false;
					if($modeloValNutr->control_crec_des=='t'){
						$selOptSi=true;
					}
					elseif($modeloValNutr->control_crec_des=='f'){
						$selOptNo=true;
					}
					echo "<div>".CHtml::radioButton('ValoracionNutricional[control_crec_des]',
						$selOptSi,array('id'=>'ValoracionNutricional_control_crec_des_si',
						'onclick'=>'js:$("#fieldControlCrecim").addClass("has-warning");',
						'value'=>'true'
						)				
					)."Si"."</div>";
					 echo "<div>".CHtml::radioButton('ValoracionNutricional[control_crec_des]',
						$selOptNo,array('id'=>'ValoracionNutricional_id_esquema_vac_no',
						'onclick'=>'js:$("#fieldControlCrecim").addClass("has-warning");',
						'value'=>'false'
						)				
					)."No"."</div>";
                       
                ?>
           		<?php echo $formControlCrecim->error($modeloValNutr,'control_crec_des',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-12">
			<div class='cont-infoval'><?php echo $modeloValNutr->obs_crec_des;?></div>									
            <?php echo $formControlCrecim->error($modeloValNutr,'obs_crec_des',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    
<?php $this->endWidget();?>
</fieldset>
<hr />
<div class="panel-heading color-sdis">¿PRESENTA ALGÚN TIPO DE DISCAPACIDAD? <code data-toggle="tooltip" title='Seleccione una o varias discapacidades identificadas en el adolescente'>Ayuda</code> </div> 
<br />
<?php
	$formTipoDiscAdol=$this->beginWidget('CActiveForm',array(
		//'action'=>'asociarSedeUsuario',
		'id'=>'formTipoDiscAdol',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			'validateOnChange' => true,
			'validateOnType' => true
		),
		'htmlOptions' => array('class' => 'form-horizontal')
		)
	);
		?>
		<?php echo  $formTipoDiscAdol->errorSummary($modeloTipodiscValnutr,'','',array('style' => 'font-size:14px;color:#F00')); ?>
		<?php
			//$modeloPersona->id_cedula=$id_cedula;
			$op=array();			
			foreach($tiposDiscapacidad as $tipoDiscapacidad){
				if(!empty($tiposDiscAdol) && is_array($tiposDiscAdol)){
					foreach($tiposDiscAdol as $tipoDiscAdol){						
						if($tipoDiscapacidad["id_tipo_discap"]==$tipoDiscAdol["id_tipo_discap"]){
							$op[$tipoDiscAdol["id_tipo_discap"]]=array('selected'=>true);
						}
					}
				}
			}			
        ?>
        <div class="form-group">
			<?php echo $formTipoDiscAdol->labelEx($modeloTipodiscValnutr,'id_tipo_discap',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
            <div class="col-md-4">
                <?php echo $formTipoDiscAdol->dropDownList($modeloTipodiscValnutr,'id_tipo_discap',CHtml::listData($tiposDiscapacidad,'id_tipo_discap', 'tipo_discapacidad'), 
				array(
					'title'=>'Seleccione una o varias opciones',
					'multiple'=>'multiple',
					'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true',
					'options'=>$op,
					'onchange'=>'js:$("#formTipoDiscAdol").addClass("has-warning");$("#formTipoDiscAdol").addClass("unsavedForm");'								
				)); ?>
           		<?php echo $formControlCrecim->error($modeloTipodiscValnutr,'id_tipo_discap',array('style' => 'color:#F00'));?>
           		<?php 
					$modeloTipodiscValnutr->id_val_nutricion=$modeloValNutr->id_val_nutricion;
					echo $formControlCrecim->hiddenField($modeloTipodiscValnutr,'id_val_nutricion');					
				?>
           		<?php echo $formControlCrecim->error($modeloTipodiscValnutr,'id_val_nutricion',array('style' => 'color:#F00'));?>
            </div>
		</div>        
    <?php $this->endWidget();?>
<hr />
<div class="panel-heading color-sdis">MEDICAMENTOS ACTUALES Y EFECTOS ADVERSOS <code data-toggle="tooltip" title='Consulte los medicamentos actuales y regístrelos, en especial aquellos que generan efectos adversos de tipo gastrointestinal o modificación sobre el estado nutricional.'>Ayuda</code> </div>     
	<?php $formularioMedicamentos=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioMedicamentos',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divMedicamentos" class="form-group"> 
    	<div class="col-md-12">
			<div class='cont-infoval'><?php echo $modeloValNutr->medicamentos_nutr;?></div>									
        	<?php echo $formularioMedicamentos->error($modeloValNutr,'medicamentos_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>

</div>

<?php
Yii::app()->getClientScript()->registerScript('scriptValExamenes','
$(document).ready(function(){
	$("#formNutrAntExamenes").find(":input").attr("disabled","disabled");
});

'
,CClientScript::POS_END);
?>
