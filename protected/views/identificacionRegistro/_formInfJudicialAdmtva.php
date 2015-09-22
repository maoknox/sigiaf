<div id="MensajeInfJud" style="border:1px solid #003"></div>
<?php $formInfJud=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioInfJud',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
	<!--campo de texto para nombre -->	
	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'no_proceso');?></br>
	<?php echo $formInfJud->textField($modeloInfJudAdmon,'no_proceso');?></br>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'no_proceso');?>

	<?php echo $formInfJud->labelEx($modeloInfJudAdmon,'juez');?></br>
	<?php echo $formInfJud->textField($modeloInfJudAdmon,'juez');?></br>
	<?php echo $formInfJud->error($modeloInfJudAdmon,'juez');?>
    <?php
		$botonInfJud=CHtml::ajaxSubmitButton (
						'Crear Registro',   
						array('identificacionRegistro/creaRegInfJudAdmon'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'success' => 'function(datos) {		
							alert(datos);						
								if(datos.estado=="exito"){
									$("#MensajeInfJud").html("Los datos se han envioado satisfactoriamente");
								}
								else{						
									$.each(datos, function(key, val) {
										$("#formularioInfJud #"+key+"_em_").text(val);                                                    
                       					$("#formularioInfJud #"+key+"_em_").show();                                                
									});
								}									
							}'
						),
						array('id'=>'btnCreaInfJudId','name'=>'btnCreaInfJudN')
				);
    ?>
    <?php echo $botonInfJud; //CHtml::submitButton('Crear');?>
<?php $this->endWidget();?>
