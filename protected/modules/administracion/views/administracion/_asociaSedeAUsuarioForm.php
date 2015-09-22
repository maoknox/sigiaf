<fieldset>  
    <legend>Vincular/Desvincular Sedes</legend>
       

<?
	if(!empty($id_cedula)){?>
		 Nombre funcionario:<strong> <?php echo $persona['nombre_personal']." ".$persona['apellidos_personal'];?></strong>
		<?php $modeloCForjarPersonal->id_cedula=$id_cedula;
			$formAsociaSede=$this->beginWidget('CActiveForm', 
		array(
			//'action'=>'asociarSedeUsuario',
			'id'=>'formularioTrasladoFunc',
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
		<?php echo  $formAsociaSede->errorSummary($modeloCForjarPersonal,'','',array('style' => 'font-size:14px;color:#F00')); ?>
		<?php
			//$modeloPersona->id_cedula=$id_cedula;
			$op=array();
			if(!empty($sedesForjarUsuario) && is_array($sedesForjarUsuario)){
				foreach($sedesForjarUsuario as $forjarUsuario){
					$modeloCForjarPersonal->id_forjar=$forjarUsuario["id_forjar"];
					$validaRelSede=$modeloCForjarPersonal->validarAsocAdolForjar();
					$validaEstVal=$modeloCForjarPersonal->validarEstadoVal();
					if($validaRelSede>0 || $validaEstVal>0){
						$sedeConPendientes[]=$forjarUsuario["nombre_sede"];
						$op[$forjarUsuario["id_forjar"]]=array('selected'=>true,'disabled'=>'disabled');
					}
					else{									
						$op[$forjarUsuario["id_forjar"]]=array('selected'=>true);
					}
				}
			}
        ?>
        <div align="center">
		<?php 
			if(!empty($sedeConPendientes)){
				?>
                	<div>Sedes con pendientes: (No se pueden desvincular)</div>
                <?php 
				foreach($sedeConPendientes as $sede){
					?>
                    	<div>- <?php echo $sede?></div>
                    <?php
				}				
			}
        ?>
        </div>
        <div class="form-group">
			<?php echo $formAsociaSede->labelEx($modeloCForjarPersonal,'id_forjar',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
            <div class="col-md-4">
                <?php echo $formAsociaSede->dropDownList($modeloCForjarPersonal,'id_forjar',CHtml::listData($sedesForjar,'id_forjar', 'nombre_sede'), 
				array(
					'multiple'=>'multiple',
					'prompt'=>'Seleccione...',
					'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true'
					,'options'=>$op								
				)); ?>
                <?php echo $formAsociaSede->hiddenField($modeloCForjarPersonal,'id_cedula')?> 
              	<?php echo $formAsociaSede->error($modeloCForjarPersonal,'id_forjar',array('style' => 'color:#F00')); ?>
            </div>
		</div>        
		<div class="form-group">
            <label class="col-md-4 control-label" for="button1id"></label>
            <div class="col-md-8">
               <?php $boton=CHtml::ajaxSubmitButton (
					'Asociar Sedes',   
					array('asociarSedeUsuario'),
					array(				
						'dataType'=>'json',
						'type' => 'post',
						'beforeSend'=>'function (){
							$("#btnAsocSede").hide();
							Loading.show();
						}',
						'success' => 'function(datosSeg) {	
							Loading.hide();
							if(datosSeg.estadoComu=="exito"){
								if(datosSeg.resultado=="exito"){
									//mensajeStripped=mensajeStripped.replace(/(<([^>]+)>)/ig,"");
									jAlert("Asociación de sedes realizada", "Mensaje");
								}
								else{
									jAlert("Ha habido un error en la creación del registro. Código del error: "+datosSeg.resultado, "Mensaje");
								}
							}
							else{						
								$("#btnAsocSede").show();
								var errores="Por favor corrija los siguientes errores<br/><ul>";
								$.each(datosSeg, function(key, val) {
									errores+="<li>"+val+"</li>";
									$("#formularioTrasladoFunc #"+key+"_em_").text(val);                                                    
									$("#formularioTrasladoFunc #"+key+"_em_").show();                                                
								});
								errores+="</ul>";
								$("#formularioTrasladoFunc #formularioTrasladoFunc_es_").html(errores);                                                    
								$("#formularioTrasladoFunc #formularioTrasladoFunc_es_").show(); 
								
							}
							
						}',
						'error'=>'function (xhr, ajaxOptions, thrownError) {
							Loading.hide();
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
					array('id'=>'btnAsocSede','class'=>'btn btn-default btn-sdis','name'=>'btnAsocSede')
				);
            ?>
        	<?php echo $boton; //CHtml::submitButton('Crear');?>
            
            
            
			</div>
		</div>
		<?php
		$this->endWidget();
		//print_r($personas);
	
	}
	else{
	$formAsociaSede=$this->beginWidget('CActiveForm', 
		array(
			'action'=>'asociarSedeUsuarioForm',
			'id'=>'formularioTrasladoFunc',
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
		<?php echo  $formAsociaSede->errorSummary($modeloPersona,'','',array('style' => 'font-size:14px;color:#F00')); ?>
		
        <div class="form-group">
			<?php echo $formAsociaSede->labelEx($modeloPersona,'id_cedula',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
            <div class="col-md-4">
                <?php echo $formAsociaSede->dropDownList($modeloPersona,'id_cedula',CHtml::listData($personas,'id_cedula', 'nombres'), 
				array(
					//'multiple'=>'multiple',
					'prompt'=>'Seleccione...',
					'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true'
					//,'options'=>$op								
				)); ?>
            </div>
		</div>        
		<div class="form-group">
            <label class="col-md-4 control-label" for="button1id"></label>
            <div class="col-md-8">
            <?php echo CHtml::submitButton('Consultar Sedes Usuario',array('class'=>'btn btn-default btn-sdis'));?>
			</div>
		</div>
		<?php
		$this->endWidget();
		//print_r($personas);
	}
	
?>
</fieldset>

