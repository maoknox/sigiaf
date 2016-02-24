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
						<?php
                            $boton=CHtml::Button (
                                'Registrar',   
                                array('id'=>'btnFormAdolLabClin_'.$pk,'class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolLabClin_'.$pk,'onclick'=>'js:regLabClinico("formularioLabClinicos'.$pk.'","formularioLabClinicos'.$pk.'")')
                            );
                        ?>
                        <?php echo $boton; //CHtml::submitButton('Crear');?>
               		</div>
                </div>
                <?php
                    $modeloLabclinValnutr->unsetAttributes();
                    $this->endWidget();
                ?>  
                <?php endif;?>
		<?php   endforeach;?>
		<?php $formularioLabClinicosExtra=$this->beginWidget('CActiveForm', array(
                'id'=>'formularioLabClinicosExtra',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>false,
                ),
                'htmlOptions' => array('class' => 'form-horizontal')
            ));
            ?>
            <?php
				array_unshift($laboratoriosExtra, array("id_laboratorio"=>0,"laboratorio_clin"=>"Añadir")); 						
			?>
           <div class="form-group"> 
       				<?php echo CHtml::label('','labelLabExtr',array('id'=>'labelLabExtr','class'=>'col-sm-2 control-label','for'=>'searchinput'));	?>
                <div class="col-sm-2">
				   <?php				   							
				   		echo CHtml::dropDownList('LabclinValnutr[id_laboratorio]','lab_clinico',CHtml::listData($laboratoriosExtra,'id_laboratorio', 'laboratorio_clin'),						    				
                                array(									
                                    'prompt'=>'Seleccione...',
                                    'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true',
									'onChange'=>'js:mostrarLabExtr(this)'
                                //array('prompt'=>'Seleccione Departamento'),
                                )
                            ); 								
                    ?>
                    <?php echo $formularioLabClinicosExtra->error($modeloLabclinValnutr,'id_laboratorio',array('style' => 'color:#F00')); ?>     
                    <?php //echo $formularioLabClinicos->labelEx($modeloLabclinValnutr,'resultado_labclin',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
                </div>
                <div class="col-sm-2" id="labExtr">
                    <?php echo $formularioLabClinicosExtra->textField($modeloLabclinValnutr,'_labExtr',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldDatosNacim").addClass("has-warning");'));?>
                    <?php echo $formularioLabClinicosExtra->error($modeloLabclinValnutr,'_labExtr',array('style' => 'color:#F00')); ?>     
                </div>
                <div class="col-sm-2">
                    <?php echo $formularioLabClinicosExtra->textArea($modeloLabclinValnutr,'resultado_labclin',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldDatosNacim").addClass("has-warning");'));?>
                    <?php echo $formularioLabClinicosExtra->error($modeloLabclinValnutr,'resultado_labclin',array('style' => 'color:#F00'));?>
                </div>
                <div class="col-sm-2">
					<?php //
                        $this->widget('zii.widgets.jui.CJuiDatePicker',
                            array('model'=>$modeloLabclinValnutr,	
							'id'=>'fecha_reslabclinExt',		
                            'attribute'=>'fecha_reslabclin',
                            'value'=>$modeloLabclinValnutr->fecha_reslabclin,
                            'language'=>'es',			
                            'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control'),			
                            'options'=>array('autoSize'=>true,
                                    'defaultDate'=>$formAdol->fecha_nacimiento,
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
   					<?php echo $formularioLabClinicosExtra->error($modeloLabclinValnutr,'fecha_reslabclin',array('style' => 'color:#F00'));?>    	
                </div>
                <div class="col-sm-2">	
                <?php
					$modeloLabclinValnutr->id_val_nutricion=$modeloValNutr->id_val_nutricion;
					echo $formularioLabClinicosExtra->hiddenField($modeloLabclinValnutr,'id_val_nutricion',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldDatosNacim").addClass("has-warning");'));
				?>
                <?php
                    $boton=CHtml::Button (
                        'Registrar',   
                        array('id'=>'btnFormAdolLabClinExtra','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolLabClinExtra','onclick'=>'js:regLabClinico("formularioLabClinicosExtra","formularioLabClinicosExtra")')
                    );
                ?>
                <?php echo $boton; //CHtml::submitButton('Crear');?>
            </div>
            
        </div>
        <?php $this->endWidget();?>   
    
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
    
			<?php echo $formEsquemaVac->textArea($modeloValNutr,
                'obs_esquema_vac',
                array('class'=>'form-control',
                //'onblur'=>'js:enviaFormOpt("formEsquemaVac","fieldEsqVac")',
                'onkeyup'=>'js:$("#fieldEsqVac").addClass("has-warning");'));
            ?>
            <?php echo $formEsquemaVac->error($modeloValNutr,'obs_esquema_vac',array('style' => 'color:#F00'));?>
        </div>
    </div>
    
   	<div class="form-group">
        <div class="col-md-4">	

<?php
$boton=CHtml::Button (
		'Registrar',   
		array('id'=>'btnFormEsqVac','class'=>'btn btn-default btn-sdis','name'=>'btnFormEsqVac','onclick'=>'js:registraEsquemaVac("formEsquemaVac","fieldEsqVac")')
);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
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
			<?php echo $formControlCrecim->textArea($modeloValNutr,
                'obs_crec_des',
                array('class'=>'form-control',
                //'onblur'=>'js:enviaFormOpt("formControlCrecim","fieldControlCrecim")',
                'onkeyup'=>'js:$("#fieldControlCrecim").addClass("has-warning");'));
            ?>
            
            <?php echo $formControlCrecim->error($modeloValNutr,'obs_crec_des',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    
   	<div class="form-group">
        <div class="col-md-4">	

<?php
$boton=CHtml::Button (
		'Registrar',   
		array('id'=>'btnFormContrCrec','class'=>'btn btn-default btn-sdis','name'=>'btnFormContrCrec','onclick'=>'js:validaOpContrCrec("formControlCrecim","fieldControlCrecim")')
);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
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
		<div class="form-group">
            <label class="col-md-4 control-label" for="button1id"></label>
            <div class="col-md-8">
               <?php $boton=CHtml::ajaxSubmitButton (
					'Registrar',   
					array('registraDiscapacidadValNutr'),
					array(				
						'dataType'=>'json',
						'type' => 'post',
						'beforeSend'=>'function (){							
							Loading.show();
						}',
						'success' => 'function(datosDisc) {	
							Loading.hide();
							if(datosDisc.estadoComu=="exito"){
								if(datosDisc.resultado=="exito"){
									//mensajeStripped=mensajeStripped.replace(/(<([^>]+)>)/ig,"");
									jAlert("Registro exitoso", "Mensaje");
									$("#formTipoDiscAdol").removeClass("has-warning");
									$("#formTipoDiscAdol").removeClass("unsavedForm");		
									$("#formTipoDiscAdol #TipodiscValnutr_id_tipo_discap_em_").text("");                                                    
									$("#formTipoDiscAdol #TipodiscValnutr_id_tipo_discap_em_").hide();  						
								}
								else{
									jAlert("Ha habido un error en la creación del registro. Código del error: "+ datosDisc.resultado, "Mensaje");
								}
							}
							else{						
								$("#btnAsocTipoDisc").show();
								var errores="Por favor corrija los siguientes errores<br/><ul>";
								$.each(datosDisc, function(key, val) {
									errores+="<li>"+val+"</li>";
									$("#formTipoDiscAdol #"+key+"_em_").text(val);                                                    
									$("#formTipoDiscAdol #"+key+"_em_").show();                                                
								});
								errores+="</ul>";
							}
							
						}',
						'error'=>'function (xhr, ajaxOptions, thrownError) {
							Loading.hide();
							//$("#btnAsocTipoDisc").hide();
							//0 para error en comunicación
							//200 error en lenguaje o motor de base de datos
							//500 Internal server error
							if(xhr.status==0){
								jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema", "Mensaje");
								$("#btnFormSeg").show();
							}
							else{
								if(xhr.status==500){
									jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información", "Mensaje");
								}
								else{
									jAlert("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado", "Mensaje");
								}	
							}
							
						}'
					),
					array('id'=>'btnAsocTipoDisc','class'=>'btn btn-default btn-sdis','name'=>'btnAsocTipoDisc')
				);
            ?>
        	<?php echo $boton; //CHtml::submitButton('Crear');?>
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
			<?php echo $formularioMedicamentos->textArea($modeloValNutr,'medicamentos_nutr',array('class'=>'form-control','onkeyup'=>'js:$("#divMedicamentos").addClass("has-warning");'));?>
        	<?php echo $formularioMedicamentos->error($modeloValNutr,'medicamentos_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>
    <div class="form-group">
    	<div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Modificar',   
					array('id'=>'btnFormAdolMedic','class'=>'btn btn-default btn-sdis','name'=>'btnFormAdolMedic','onclick'=>'js:enviaFormNutr("formularioMedicamentos","divMedicamentos")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
	</div>    
   <?php $this->endWidget();?>

</div>

<?php
Yii::app()->getClientScript()->registerScript('scriptValExamenes','
	$(document).ready(function(){
		$("#formNutrAntExamenes").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
		$("#labExtr").hide()
	});
	function mostrarLabExtr(objeto){
		if(objeto.value==0){
			$("#labelLabExtr").removeClass("col-sm-2");
			$("#labelLabExtr").addClass("col-sm-0");
			$("#labExtr").show();
		}
		else{
			$("#labelLabExtr").removeClass("col-sm-0");
			$("#labelLabExtr").addClass("col-sm-2");
			$("#labExtr").hide();
		}
	}
	
	function validaOpContrCrec(formId,fieldId){
		var nameInput=$("#"+formId+" input:first").attr("name");
		//jAlert($("#"+nombreForm+" input:radio:checked").val());return;
		if(!$("#"+formId+" input:radio:checked").is(":empty")){
			if($("#"+formId+" textarea:first").val().length==0){
				jAlert("El campo no puede estar en blanco");return;
				$("#"+nombreForm).removeClass("unsavedForm");
			}
			else{
				jAlert("Debe seleccionar una opción");return;
				$("#"+formId).removeClass("unsavedForm");
			}
		}
		
		//jAlert($("#"+formId+" #ValoracionNutricional_obs_crec_des").val().length);
		$("#"+formId+" #ValoracionNutricional_control_crec_des_em_").text("");                                                    
		$("#"+formId+" #ValoracionNutricional_control_crec_des_em_").show(); 
		var opcion =$("input[name=\'ValoracionNutricional[control_crec_des]\']:checked").val();
		if(opcion=="false" && $("#"+formId+" #ValoracionNutricional_obs_crec_des").val().length<=15){
			$("#"+formId+" #ValoracionNutricional_control_crec_des_em_").text("Debe realizar la verificación de la no asistencia a control de crecimiento y desarrollo");                                                    
			$("#"+formId+" #ValoracionNutricional_control_crec_des_em_").show(); 
		}
		else{
			enviaFormNutrGrupo(formId,fieldId);		
		}
		//jAlert($("input[name=\'ValoracionNutricional[control_crec_des]\']:checked").val());
		
	}
	function registraEsquemaVac(formId,fieldId){
			var nameInput=$("#"+formId+" input:first").attr("name");
		//jAlert($("#"+nombreForm+" input:radio:checked").val());return;
		if(!$("#"+formId+" input:radio:checked").is(":empty")){
			if($("#"+formId+" textarea:first").val().length==0){
				jAlert("El campo no puede estar en blanco");return;
				$("#"+nombreForm).removeClass("unsavedForm");
			}
			else{
				jAlert("Debe seleccionar una opción");return;
				$("#"+formId).removeClass("unsavedForm");
			}
		}
	//jAlert($("#"+formId).serialize()+"&idValNutr="+$("#idValNutr").val()+"&numDocAdolValNutr="+$("#num_doc").val());return;
		$.ajax({
			url: "registraEsquemaVac",
			data:$("#"+formId).serialize()+"&idValNutr="+$("#idValNutr").val()+"&numDocAdolValNutr="+$("#num_doc").val(),
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				if(datos.estadoComu=="exito"){
					//$("#"+btnForm).css("color","#000");
					if(datos.resultado=="exito"){
						jAlert("Registro exitoso","mensaje");
						$("#"+formId).removeClass("has-warning");
						$("#"+formId+" #EsquemaVacunacion_id_esquema_vac_em_").text("");                                                    
						$("#"+formId+" #EsquemaVacunacion_id_esquema_vac_em_").hide(); 
						$("#"+formId).removeClass("unsavedForm");
					}
					else{
						jAlert("Error en el registro  Motivo "+datos.resultado,"Mensaje");
					}
				}
				else{					
					//$("#btnFormAcud").show();
					var errores="Por favor Tenga en cuenta lo siguiente<br/><ul>";
					$.each(datos, function(key, val) {
						errores+="<li>"+val+"</li>";
						$("#"+formId+" #"+key+"_em_").text(val);                                                    
						$("#"+formId+" #"+key+"_em_").show();                                                
					});
					errores+="</ul>";
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
						jAlert("Error en el registro \n"+xhr.responseText+" Comuníquese con el ingeniero encargado","Mensaje");
					}	
				}	
			}
		});
	}
	
	function regLabClinico(formId,formId){
		$("#"+formId+" .errorMessage").text(""); 
	//jAlert($("#"+formId).serialize());
		$.ajax({
			url: "registraLabClinico",
			data:$("#"+formId).serialize()+"&idValNutr="+$("#idValNutr").val()+"&numDocAdolValNutr="+$("#num_doc").val(),
			dataType:"json",
			type: "post",
			beforeSend:function (){
				Loading.show();				 
			},
			success: function(datos){
				Loading.hide();
				if(datos.estadoComu=="exito"){
					//$("#"+btnForm).css("color","#000");
					if(datos.resultado=="exito"){
						jAlert("Registro exitoso","mensaje");
						$("#"+formId).removeClass("has-warning");
						$("#"+formId+" .errorMessage").text(""); 
						$("#"+formId+" .errorMessage").hide(""); 
						$("#"+formId).removeClass("unsavedForm");
					}
					else{
						jAlert("Error en el registro  Motivo "+datos.resultado,"Mensaje");
					}
				}
				else{										
					$.each(datos, function(key, val) {						                                                    						
						$("#"+formId+" #"+key+"_em_").text(val);                                                    
						$("#"+formId+" #"+key+"_em_").show();                                                
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
						jAlert("Error en el registro \n"+xhr.responseText+" Comuníquese con el ingeniero encargado","Mensaje");
					}	
				}	
			}
		});
	}

'
,CClientScript::POS_END);
?>
