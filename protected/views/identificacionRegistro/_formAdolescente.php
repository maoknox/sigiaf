<div id="Mensaje" style="border:1px solid #003"></div>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioAdol',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
	<!--campo de texto para nombre -->	
	<?php echo $form->labelEx($formAdol,'num_doc');?></br>
	<?php echo $form->textField($formAdol,'num_doc');?></br>
	<?php echo $form->error($formAdol,'num_doc');?>

	<?php echo $form->labelEx($formAdol,'apellido_1');?></br>
	<?php echo $form->textField($formAdol,'apellido_1');?></br>
	<?php echo $form->error($formAdol,'apellido_1');?>
    <?php
		$boton=CHtml::ajaxSubmitButton (
						'Crear Registro',   
						array('identificacionRegistro/creaRegAdol'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'success' => 'function(datos) {		
							alert(datos);						
								if(datos.estado=="exito"){
									$("#Mensaje").html("Los datos se han envioado satisfactoriamente");
								}
								else{						
									$.each(datos, function(key, val) {
										$("#formularioAdol #"+key+"_em_").text(val);                                                    
                       					$("#formularioAdol #"+key+"_em_").show();                                                
									});
								}									
							}'
						),
						array('id'=>'btnCreaAdolId','name'=>'btnCreaAdolN')
				);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
<?php $this->endWidget();?>
