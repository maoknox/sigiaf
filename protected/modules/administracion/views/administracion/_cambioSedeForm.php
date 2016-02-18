<?php 
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('administracion/administracion/cambioSedeAdol'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php
	if(!empty($numDocAdol)):
?>
<div id="Mensaje" style="font-size:14px;" ></div>

<?php
	$solCambioSede=true;
	if(!empty($infoSolicitud)){
		if($infoSolicitud["vbno_coord"]==""){
			$solCambioSede=false;
			$mensaje="El adolescente tine una solcitud de cambio de sede vigente que no ha sido confirmada por el coordinador.";
		}
		elseif($infoSolicitud["vbno_coord"]=="t"){
			$estado='Aprobada';
		}
		else{
			$estado='Denegada';
		}
	}
		if($solCambioSede==true):
?>
<?php
	if($infoSolicitud["vbno_coord"]!=""):
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
               El adolescente tiene una gestión de cambio de sede solicitada en la fecha <?php echo $infoSolicitud["fecha_cambio_sede"]; ?> y fue en su momento <?php echo $estado; ?>
             
             </div>
        </div> 
 	</div>
 </div>        

<?php endif;?>


		<fieldset>
		
		<!-- Form Name -->
		<legend>Solicitud cambio de Sede - sede actual <?php echo $sedeActual["nombre_sede"];?></legend>
		<?php 
			//$modeloDocSoporte->ruta_acceso_ds='{677368164-2015-03-25-1003558897}-ebrcmdr.pdf';
			//echo CHtml::link(CHtml::encode(Yii::app()->params["subirArchivos"]), Yii::app()->params["verArchivos"].$modeloDocSoporte->ruta_acceso_ds,array('target'=>'_blank'))?>
		<?php $formCreaSede=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioSolCS',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
			'htmlOptions' => array('class' => 'form-horizontal','enctype' => 'multipart/form-data')
		));
		?>
		
		<?php echo  $formCreaSede->errorSummary($modeloDocSoporte,'','',array('style' => 'font-size:14px;color:#F00')); ?>
                <div class="form-group">
					<?php echo $formCreaSede->labelEx($modeloDocSoporte,'nombre_doc_ds',array('class'=>'col-md-4 control-label','for'=>'filebutton'));?>
                    <div class="col-md-4">
						<?php echo $formCreaSede->fileField($modeloDocSoporte, 'nombre_doc_ds',array('class'=>'filestyle','data-buttonBefore'=>'true','data-buttonName'=>'btn-sdis','data-buttonText'=>'Examinar')); ?>
                        <?php echo $formCreaSede->error($modeloDocSoporte,'nombre_doc_ds',array('style' => 'color:#F00'));?>     
                        <?php 
                        $modeloDocSoporte->fecha_reg_ds=date("Y-m-d");
                        echo $formCreaSede->hiddenField($modeloDocSoporte,'fecha_reg_ds')						
                        ?>
                    </div>
                </div>
			  <div class="form-group">
			<?php echo $formCreaSede->labelEx($modeloCambioSede,'sede_nueva',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
				<div class="col-md-4">
					<?php echo $formCreaSede->dropDownList($modeloCambioSede,'sede_nueva',CHtml::listData($sedes,'id_forjar', 'nombre_sede'), 
						array('prompt'=>'Seleccione Sede','class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true')); 
					?>
					<?php echo $formCreaSede->error($modeloCambioSede,'sede_nueva',array('style' => 'color:#F00')); ?>
					<?php 
						$modeloCambioSede->num_doc=$numDocAdol;
						$modeloCambioSede->sede_anterior=$sedeActual["id_forjar"];
						$modeloCambioSede->fecha_cambio_sede=date("Y-m-d");
					?>
					<?php echo $formCreaSede->hiddenField($modeloCambioSede,'num_doc')?>
					<?php echo $formCreaSede->hiddenField($modeloCambioSede,'sede_anterior')?>
                    <?php echo $formCreaSede->hiddenField($modeloCambioSede,'fecha_cambio_sede')?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="button1id"></label>
				<div class="col-md-8">
					<?php echo CHtml::button("Generar Solicitud",array('title'=>"generar",'onclick'=>'js:upload(this);','class'=>'btn btn-default btn-sdis','id'=>'btnCambioSede'));?>
				</div>
			</div>       
		<?php				
			$this->endWidget();
		?>
		
		</fieldset>
		<?php Yii::app()->getClientScript()->registerScript('tratamientoForm','
		$(document).ready(function(){
			$("#formularioSolCS").find(":input").change(function(){
				var dirtyForm = $(this).parents("form");
				// change form status to dirty
				dirtyForm.addClass("unsavedForm");
			});
		});	
		var campoText=0;
		$(window).bind("beforeunload", function(){
			if($(".unsavedForm").size()){
				return "Aún no ha guardado cambios.  Los perderá si abandona.";
			}
		});
		
		function upload(){
			var fd = new FormData($("#formularioSolCS")[0]);
			$.ajax({
				url: "solicitarCambioSede",
				datatype: "json",	
				type: "post",
				data: fd,     
				beforeSend:function (){$("#btnCambioSede").hide();Loading.show();},
				success: function(datosRet){ 
					Loading.hide();
					var jsonObj = JSON.parse(datosRet);
					if(jsonObj.estadoComu=="exito"){
						if(jsonObj.resultado=="\'exito\'"){
							$("#formularioSolCS").removeClass("unsavedForm");    
							$("#formularioSolCS #formularioSolCS_es_").html("");                                                    
							$("#formularioSolCS #formularioSolCS_es_").hide(); 
							$("#formularioSolCS #DocumentoSoporte_nombre_doc_ds_em_").text("");                                                    
							$("#formularioSolCS #DocumentoSoporte_nombre_doc_ds_em_").hide();
							$("#formularioSolCS #CambioSede_sede_nueva_em_").text("");                                                    
							$("#formularioSolCS #CambioSede_sede_nueva_em_").hide(); 
							$("#Mensaje").html("Solicitud de cambio de sede registrada satisfactoriamente");								
						}
						else{
							$("#Mensaje").html("Hubo un error al momento de registrar la solicitud.  El error es el siguiente: "+jsonObj.resultado);
						}
					}
					else{						
						$("#btnCambioSede").show();
						var errores="Por favor corrija los siguientes errores<br/><ul>";
						$.each(jsonObj, function(key, val) {
							errores+="<li>"+val+"</li>";
							$("#formularioSolCS #"+key+"_em_").text(val);                                                    
							$("#formularioSolCS #"+key+"_em_").show();                                                
						});
						errores+="</ul>";
						$("#formularioSolCS #formularioSolCS_es_").html(errores);                                                    
						$("#formularioSolCS #formularioSolCS_es_").show(); 
					}
				},
				error: function(xhr, ajaxOptions, thrownError){
					Loading.hide();
					$("#btnCambioSede").show();
					//0 para error en comunicación
					//200 error en lenguaje o motor de base de datos
					//500 Internal server error
					if(xhr.status==0){
						$("#Mensaje").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
						$("#btnFormAdolId").show();
					}
					else{
						if(xhr.status==500){
							$("#Mensaje").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada.  El error es el siguiente: "+xhr.responseText);
						}
						else{
							$("#Mensaje").html("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
						}	
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		}
		
		'
		,CClientScript::POS_END);
		?>
        <?php else: ?>
        
 <div class="panel panel-default">
 	<div class="panel-heading">
		<div class="panel-title">
			AVISO
        </div>
    </div>
  	<div class="panel-body">
		<div class="row">
        	 <div class="col-lg-3 text-center">
             	<img src="<?php echo Yii::app()->baseUrl?>/images/centroForjar.png" />
             </div>
             <div class="col-lg-9 text-justify">
               El adolescente tine una solcitud de cambio de sede vigente que no ha sido confirmada por el coordinador.
             
             </div>
        </div> 
 	</div>
 </div>        
 <?php endif;?>
<?php else:?>

Seleccione adolescente

<?php endif;?>