<?php 
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('administracion/administracion/resolverSolicitudCambioSede'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		//'telefonoAdol'=>$telefonoAdol
	)
);

?>
<?php if(!empty($numDocAdol)): ?>
	<?php if(!empty($infoSolicitud)):?>
		<div id="Mensaje" style="font-size:14px;" ></div>
        <?php
			$regCambioSede=false;
			if($infoSolicitud["vbno_coord"]==""){
				$regCambioSede=true;
			}
			//if($solCambioSede==true):
		?>
        <div id="Mensaje" style="font-size:14px;" ></div>
		<?php
			$modeloDocSoporte->nombre_doc_ds=$infoSolicitud["nombre_doc_ds"];
			if($regCambioSede==true && !empty($modeloDocSoporte->nombre_doc_ds) && file_exists(Yii::app()->params["subirArchivos"].$modeloDocSoporte->nombre_doc_ds)):?>
        	<fieldset>
		
            <!-- Form Name -->
            <legend>Solicitud cambio de Sede</legend>
         <?php $formCambioSede=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioSolCS',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
			'htmlOptions' => array('class' => 'form-horizontal','enctype' => 'multipart/form-data')
		));
		?>
		 		<?php 
				echo  $formCambioSede->errorSummary($modeloDocSoporte,'','',array('style' => 'font-size:14px;color:#F00')); ?>
				<div class="form-group">
					<label class="col-md-4 control-label">Fecha de la solicitud:</label>				
                    	<div class="col-md-4">
							<?php 
								$modeloCambioSede->fecha_cambio_sede=$infoSolicitud["fecha_cambio_sede"];
								echo $formCambioSede->textField($modeloCambioSede,'fecha_cambio_sede', array('class'=>'selectpicker form-control','disabled'=>'disabled')); 
								echo $formCambioSede->hiddenField($modeloCambioSede,'fecha_cambio_sede', array('class'=>'selectpicker form-control')); 								
							?>
                         	<?php echo $formCambioSede->error($modeloCambioSede,'fecha_cambio_sede',array('style' => 'color:#F00')); ?>
                        </div>
				</div>
                <div class="form-group">
					<label class="col-md-4 control-label">Documento Soporte</label>                
                    <div class="col-md-4">
                        <?php 
                            //'{254547119-2015-03-25-1003558897}-ebrcmdr.pdf';							
							$modeloDocSoporte->ruta_acceso_ds= Yii::app()->params["verArchivos"];
                            echo CHtml::link("Ver documento Soporte", $modeloDocSoporte->ruta_acceso_ds.$modeloDocSoporte->nombre_doc_ds,array('target'=>'_blank','class'=>'form-control'));
							echo $formCambioSede->hiddenField($modeloDocSoporte,'nombreDocAux'); 								
							echo $formCambioSede->hiddenField($modeloDocSoporte,'ruta_acceso_ds'); 								
						?>		
                         <?php 
							$modeloDocSoporte->fecha_reg_ds=date("Y-m-d");
							echo $formCambioSede->hiddenField($modeloDocSoporte,'fecha_reg_ds')						
						?>
                    </div>
                </div>
               <div class="form-group">
					<label class="col-md-4 control-label">Sede Actual:</label>				
                    <div class="col-md-4">
                        <?php 
                            $modeloCambioSede->sede_anterior=$infoSolicitud["sede_anterior"];
                            echo $formCambioSede->textField($modeloCambioSede,'sede_anterior', array('class'=>'form-control','disabled'=>'disabled')); 		
                            echo $formCambioSede->hiddenField($modeloCambioSede,'sede_anterior'); 								
                        ?>
                    </div>
				</div>
                <div class="form-group">
					<label class="col-md-4 control-label">Sede de traslado:</label>				
                    <div class="col-md-4">
                        <?php 
                            $modeloCambioSede->sede_nueva=$infoSolicitud["sede_nueva"];
                            echo $formCambioSede->textField($modeloCambioSede,'sede_nueva', array('class'=>'form-control','disabled'=>'disabled')); 
                            echo $formCambioSede->hiddenField($modeloCambioSede,'sede_nueva');
							$modeloCambioSede->id_cambio_sede=$infoSolicitud["id_cambio_sede"];
							echo $formCambioSede->hiddenField($modeloCambioSede,'id_cambio_sede'); 									
                        ?>                      
                    </div>
				</div>
                <div class="form-group">
					<label class="col-md-4 control-label">Aprobación:</label>				
                    	<div class="col-md-4">
							<?php 
							 	$aprobacion = array('false'=>'No', 'true'=>'Si');
               				 	echo $formCambioSede->radioButtonList($modeloCambioSede,'vbno_coord',$aprobacion,array('separator'=>' '));
							?>
                        </div>
				</div>
            	<div class="form-group">
					<label class="col-md-4 control-label" for="button1id"></label>
                    <div class="col-md-8">
                     	<?php $modeloCambioSede->num_doc=$numDocAdol;?>
         	   			<?php echo $formCambioSede->hiddenField($modeloCambioSede,'num_doc')?>
                   		<?php $boton=CHtml::ajaxSubmitButton (
						'Registrar',   
						array('administracion/procedeCambioSede'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){$("#btnFormCambioSede").hide();Loading.show();}',
							'success' => 'function(datos) {	
								Loading.hide();
								if(datos.estadoComu=="exito"){
									if(datos.resultado=="\'exito\'"){
										if(datos.vbno="true"){
											jAlert("Cambio de sede satisfactorio.  El número de carpeta nuevo es: "+datos.numerocarpeta,"Mensaje");	
											$("#formularioSolCS #formularioSolCS_es_").html("");                                                    
											$("#formularioSolCS #formularioSolCS_es_").hide(); 
											$("#formularioSolCS").removeClass("unsavedForm"); 
										}
									}
									else{
										$("#Mensaje").html("Ha habido un error en la creación del registro. El error es:"+datos.resultado);
									}
								}
								else{						
									$("#btnFormCambioSede").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datos, function(key, val) {
										errores+="<li>"+val+"</li>";
									});
									errores+="</ul>";
									$("#formularioSolCS #formularioSolCS_es_").html(errores);                                                    
									$("#formularioSolCS #formularioSolCS_es_").show(); 
								}
								
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#Mensaje").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormCambioSede").show();
								}
								else{
									if(xhr.status==500){
										$("#Mensaje").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
									}
									else{
										$("#Mensaje").html("No se realizado la acción correspondiente debido al siguiente error: <br>"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
								
							}'
						),
						array('id'=>'btnFormCambioSede','name'=>'btnFormCambioSede','class'=>'btn btn-default btn-sdis')
				);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>

                    </div>
				</div>       
            <?php $this->endWidget();?>
            </fieldset>
            <?php
			Yii::app()->getClientScript()->registerScript('scriptValTO','
			$(document).ready(function(){
				$("#formularioSolCS").find(":input").change(function(){
					var dirtyForm = $(this).parents("#formularioSolCS");
					// change form status to dirty
					dirtyForm.addClass("unsavedForm");
				});
			});	
			$(window).bind("beforeunload", function(){
				if($(".unsavedForm").size()){
					return "Aún no ha guardado cambios.  Los perderá si abandona.";
				}
			});
'
,CClientScript::POS_END);
?>
        <?php else:	mostratMensaje();?>
        <?php endif;?>
	<?php else:mostratMensaje()?>
    	
    <?php endif;?>
<?php else:?>

Seleccione adolescente

<?php endif;?>

<?php

function mostratMensaje(){
?>
 <div class="panel panel-default">
 	<div class="panel-heading">
		<div class="panel-title">
			AVISO
        </div>
    </div>
  	<div class="panel-body">
		<div class="row">
        	 <div class="col-lg-3 text-center">
             	
             </div>
             <div class="col-lg-9 text-justify">
	              El adolescente no tiene alguna solicitud de cambio de sede.
             </div>
        </div> 
 	</div>
 </div>        
<?php	
}
?>

