<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="formNutrAntSalud">
<?php
//print_r($parentesco);
?>
	<div id="Mensaje" style="font-size:14px;" ></div>
	<?php /* $this->widget('application.extensions.magnific-popup.EMagnificPopup', array('target' => '.test-popup-link'));*/?>
    <div class="panel-heading color-sdis">GRUPO FAMILIAR</div> 
	
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="grupoFamiliarTable">
    <thead>
        <tr>
            <th>Nombres del familiar</th>
            <th>Apellidos del familiar</th>
            <th>Edad</th>
            <th>Parentesco</th>
            <th>Ocupación</th>
            <th>Escolaridad</th>
            <th>Teléfono</th>
            <th>¿Vive con el adolescente?</th>
        </tr>
    </thead>
 	<tbody>
	<?php if(!empty($grupoFamiliares)):?>
		<?php foreach($grupoFamiliares as $pk=>$grupoFamiliar):?>
			<tr id="<?php echo $pk;?>">
            	<td style=" border:1px solid #000;width:15%"><?php echo $grupoFamiliar["nombres_familiar"] ?></td>
                <td style=" border:1px solid #000;width:15%"><?php echo $grupoFamiliar["apellidos_familiar"] ?></td>
                <td style=" border:1px solid #000;width:10%"><?php echo $grupoFamiliar["edad_familiar"]?></td>
                <td style=" border:1px solid #000;width:10%">
				<?php 
					foreach($parentesco as $parent){
						if($grupoFamiliar["id_parentesco"]==$parent["id_parentesco"]){
							echo $parent["parentesco"];
						}
					}				
				?>
                </td>
                <td style=" border:1px solid #000;width:10%"><?php echo $grupoFamiliar["ocupacion_familiar"] ?></td>
                <td style=" border:1px solid #000;width:10%">
				<?php
					foreach($nivelEduc as $nivEd){
						if($grupoFamiliar["id_nivel_educ"]==$nivEd["id_nivel_educ"]){
							echo $nivEd["nivel_educ"];
						}
					}	
				?>
                </td>
                <td style=" border:1px solid #000;width:10%">
					<?php						
						$modeloTelefono->idFamiliar=$grupoFamiliar["id_doc_familiar"];
						$telefonoFam=$modeloTelefono->consultaTelFamiliar(); 
						echo $telefonoFam["telefono"]; 
					?>                    
               	</td>
                <td style=" border:1px solid #000;width:10%">
					<?php 
						$convAdol=false;
						if($grupoFamiliar["convive_adol"]==1){echo 'si';}else{echo 'no';}
					?>
                </td>
              </tr>
		<?php endforeach;?>
	<?php endif; ?>         
    </tbody>
</table>
    <div class="panel-heading color-sdis"> DATOS DE NACIMIENTO </div> 
    <fieldset id="fieldDatosNacim">
		<?php $formularioDatosNacim=$this->beginWidget('CActiveForm', array(
            'id'=>'formularioDatosNacim',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>false,
            ),
            'htmlOptions' => array('class' => 'form-horizontal')
        ));
        ?>
 		<div class="form-group">
            <?php echo $formularioDatosNacim->labelEx($modeloValNutr,'id_tipo_parto',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <div class="col-md-4">
				<?php 
                    $selOpt=false;
                    foreach($tipoParto as $pk=>$tipoPartoR){
                        if($modeloValNutr->id_tipo_parto==$tipoPartoR["id_tipo_parto"]){$selOpt=true;}
                        ?>
                        <div class="radio">
                            <label for="radios-<?php echo $pk;?>">
								<?php
                                echo CHtml::radioButton('ValoracionNutricional[id_tipo_parto]',
                                    $selOpt,array('id'=>'ValoracionNutricional_id_tipo_parto_'.$tipoPartoR["id_tipo_parto"],
                                    'value'=>$tipoPartoR["id_tipo_parto"]
                                    )				
                                )."".$tipoPartoR["tipo_parto"]."<br/>";
                                $selOpt=false;?>
                             </label>
                         </div>
              <?php } ?> 
            </div>
        </div>        
        <div class="form-group"> 
            <?php echo $formularioDatosNacim->labelEx($modeloValNutr,'semanas_gestacion',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <div class="col-md-4">
                <?php echo $formularioDatosNacim->textField($modeloValNutr,'semanas_gestacion',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldDatosNacim").addClass("has-warning");'));?>
                <?php echo $formularioDatosNacim->error($modeloValNutr,'semanas_gestacion',array('style' => 'color:#F00'));?>
            </div>
        </div>
        <div class="form-group"> 
            <?php echo $formularioDatosNacim->labelEx($modeloValNutr,'talla_nacim_cms',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <div class="col-md-4">
                <?php echo $formularioDatosNacim->textField($modeloValNutr,'talla_nacim_cms',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldDatosNacim").addClass("has-warning");'));?>
                <?php echo $formularioDatosNacim->error($modeloValNutr,'talla_nacim_cms',array('style' => 'color:#F00'));?>
            </div>
        </div>
        <div class="form-group"> 
                <?php echo $formularioDatosNacim->labelEx($modeloValNutr,'peso_nacim_kgs',array('class'=>'col-md-4 control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
            <div class="col-md-4">
                <?php echo $formularioDatosNacim->textField($modeloValNutr,'peso_nacim_kgs',array('class'=>'form-control input-md','onkeyup'=>'js:$("#fieldDatosNacim").addClass("has-warning");'));?>
                <?php echo $formularioDatosNacim->error($modeloValNutr,'peso_nacim_kgs',array('style' => 'color:#F00'));?>
            </div>
        </div>
       <?php $this->endWidget();?>
    </fieldset>
    <hr />
	<?php $formularioObsNacim=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioObsNacim',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divObsNacim" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formularioObsNacim->labelEx($modeloValNutr,'observaciones_nacim',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioObsNacim->textArea($modeloValNutr,'observaciones_nacim',array('class'=>'form-control'));?>
        	<?php echo $formularioObsNacim->error($modeloValNutr,'observaciones_nacim',array('style' => 'color:#F00'));?>
    	</div>
    </div>
	<?php $this->endWidget();?>
	<?php $formularioPatologicos=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioPatologicos',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divPatologicos" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formularioPatologicos->labelEx($modeloValNutr,'patologicos',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioPatologicos->textArea($modeloValNutr,'patologicos',array('class'=>'form-control'));?>
        	<?php echo $formularioPatologicos->error($modeloValNutr,'patologicos',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
	<?php $formularioQuirurgicos=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioQuirurgicos',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
	<div id="divQuirurgicos" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formularioQuirurgicos->labelEx($modeloValNutr,'quirurgicos',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioQuirurgicos->textArea($modeloValNutr,'quirurgicos',array('class'=>'form-control'));?>
        	<?php echo $formularioQuirurgicos->error($modeloValNutr,'quirurgicos',array('style' => 'color:#F00'));?>
    	</div>
    </div>    
   <?php $this->endWidget();?>
	<?php $formularioHospitCausas=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioHospitCausas',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
    <div id="divHospitCausas" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formularioHospitCausas->labelEx($modeloValNutr,'hospitaliz_causas',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioHospitCausas->textArea($modeloValNutr,'hospitaliz_causas',array('class'=>'form-control'));?>
        	<?php echo $formularioHospitCausas->error($modeloValNutr,'hospitaliz_causas',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
	<?php $formularioAlergicos=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioAlergicos',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
    <div id="divAlergicos" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formularioAlergicos->labelEx($modeloValNutr,'alergicos',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioAlergicos->textArea($modeloValNutr,'alergicos',array('class'=>'form-control'));?>
        	<?php echo $formularioAlergicos->error($modeloValNutr,'alergicos',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
	<?php $formularioFamiliares=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioFamiliares',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
    <div id="divFamiliares" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formularioFamiliares->labelEx($modeloValNutr,'familiares_nutr',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioFamiliares->textArea($modeloValNutr,'familiares_nutr',array('class'=>'form-control'));?>
        	<?php echo $formularioFamiliares->error($modeloValNutr,'familiares_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
	<?php $formularioOtrosAntNutr=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioOtrosAntNutr',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
    ?>
    <div id="divFOtrosAntNutr" class="form-group"> 
    	<div class="col-md-12">
			<?php echo $formularioOtrosAntNutr->labelEx($modeloValNutr,'otros_nutr',array('class'=>'control-label','for'=>'searchinput'));//'onblur'=>'js:enviaFormNutr("formularioHistVida","divObsNacim")'?>
			<?php echo $formularioOtrosAntNutr->textArea($modeloValNutr,'otros_nutr',array('class'=>'form-control'));?>
        	<?php echo $formularioOtrosAntNutr->error($modeloValNutr,'otros_nutr',array('style' => 'color:#F00'));?>
    	</div>
    </div>
   <?php $this->endWidget();?>
    <hr />
</div>


<?php
Yii::app()->getClientScript()->registerScript('scriptValNutr_1','
$(document).ready(function(){
	$("#formNutrAntSalud").find(":input").attr("disabled","disabled");
});
'
,CClientScript::POS_END);
?>
