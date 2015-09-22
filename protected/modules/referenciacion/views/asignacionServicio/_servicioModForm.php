<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('referenciacion/asignacionServicio/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('referenciacion/asignacionServicio/consultaServicioModForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($modeloRef->id_referenciacion)):?>
<div id="MensajeRef" style="font-size:14px;" title="Mensaje"></div>
<div class="panel-heading color-sdis">Información de la referenciación</div> 
<fieldset class="form-horizontal"><br />
<div class="form-group">
    <?php echo CHtml::label('Línea de acción','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="row">
        <p class="col-md-6">
            <?php foreach($tipoRef as $linaAccion){
                if($linaAccion["id_tipo_referenciacion"]==$modeloRef->id_tipo_referenciacion){
                    echo $linaAccion["tipo_referenciacion"];
                }
            }?>  
        </p>     
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Beneficiario','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="row">
    	<p class="col-md-6">
			<?php 
            if(!empty($modeloRef->id_beneficiario)){
                foreach($beneficiario as $beneficiario){
                    if($beneficiario["id_beneficiario"]==$modeloRef->id_beneficiario){
						echo $beneficiario["beneficiario"];
                    }
                }
            }
            else{
                echo "N.A";	
            }
            ?>        
        </p>      
    </div>
</div>   

<div class="form-group">
    <?php echo CHtml::label('Especificación de nivel I:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="row">
    	<p class="col-md-6">
			<?php 
            if(!empty($modeloRef->id_esp_sol)){
                foreach($espNi as $espNi){
                    if($espNi["id_esp_sol"]==$modeloRef->id_esp_sol){
                        echo $espNi["esp_sol"];
                    }
                }
            }
            else{
                echo "N.A";	
            }
            ?>        
        </p>      
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Especificación de nivel II:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="row">
    	<p class="col-md-6">
			<?php 
            if(!empty($modeloRef->id_esp_solii)){
                foreach($espNii as $espNii){
                    if($espNii["id_esp_solii"]===$modeloRef->id_esp_solii){
                        echo $espNii["esp_solii"];
                    }
                }
            }
            else{
                echo "N.A";	
            }
            ?>        
        </p>      
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Especificación de nivel III:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="row">
    	<p class="col-md-6">
			<?php 
            if(!empty($modeloRef->id_esp_soliii)){
                foreach($espNiii as $espNiii){
                    if($espNiii["id_esp_soliii"]===$modeloRef->id_esp_soliii){
                        echo $espNiii["esp_soliii"];
                    }
                }
            }
            else{
                echo "N.A";	
            }
            ?>
        </p>      
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Instituto','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="row">
    	<p class="col-md-6 ">
			<?php
				if(!empty($modeloRef->institucion_ref)){
					echo $modeloRef->institucion_ref;
				}
				else{
					echo "N.A";
				}
			?>
        </p>      
    </div>
</div> 
<div class="form-group">
    <?php echo CHtml::label('Observaciones','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="row">
    	<p class="col-md-6">
			<?php
                if(!empty($modeloRef->observaciones_refer)){
					echo $modeloRef->observaciones_refer;
					//echo CHtml::textArea('',$modeloRef->observaciones_refer,array('class'=>'col-md-6 form-control','for'=>'searchinput'));
                   // echo $modeloRef->observaciones_refer;
                }
                else{
                    echo "N.A";
                }
            ?>
        </p>
    </div>
</div> 
<?php $formModEstRef=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioModEst',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
));
?>
<div class="form-group">
    <?php echo CHtml::label('Estado','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
		<?php
			$option[$modeloRef->id_estadoref]=array("selected"=>true);
			echo CHtml::dropDownList('id_estadoref','id_estadoref',CHtml::listData($estadoRef,"id_estadoref","estado_ref"),array("options"=>$option,'class'=>'form-control','data-live-search'=>'true'));
			echo CHtml::hiddenField('id_referenciacion',$modeloRef->id_referenciacion);
			echo CHtml::hiddenField('numDocAdol',$numDocAdol);
		?>
	</div>
</div>
<div class="form-group">
    <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
	<div class="col-md-6">
    <?php
		$boton=CHtml::ajaxSubmitButton (
			'Modificar Estado',   
			array('asignacionServicio/modificaEstadoRef'),
			array(				
				'dataType'=>'json',
				'type' => 'post',
				'beforeSend'=>'function (){$("#btnFormRef").hide();Loading.show();}',
				'success' => 'function(datosRef) {	
					Loading.hide();
					if(datosRef.estadoComu=="exito"){
						if(datosRef.resultado=="\'exito\'"){
							//$( "#MensajeRef" ).dialog();
							jAlert("Estado modificado satisfactoriamente", "Mensaje");
							//$("#MensajeRef").text("Estado modificado satisfactoriamente");
							$("#formularioRef #formularioRef_es_").html("");      
						}
						else{
							jAlert("Ha habido un error en la creación del registro. Código del error: "+datosRef.resultado, "Mensaje");
							//$("#MensajeRef").text("Ha habido un error en la creación del registro. Código del error: "+datosRef.resultado);
							$("#formularioRef #formularioRef_es_").html("");                                                    
							//$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
						}
					}
					else{						
						$("#btnFormRef").show();
						var errores="Por favor corrija los siguientes errores<br/><ul>";
						$.each(datosRef, function(key, val) {
							errores+="<li>"+val+"</li>";
							$("#formularioRef #"+key+"_em_").text(val);                                                    
							$("#formularioRef #"+key+"_em_").show();                                                
						});
						errores+="</ul>";
						$("#formularioRef #formularioRef_es_").html(errores);                                                    
						$("#formularioRef #formularioRef_es_").show(); 
						
					}
					
				}',
				'error'=>'function (xhr, ajaxOptions, thrownError) {
					Loading.hide();
					//0 para error en comunicación
					//200 error en lenguaje o motor de base de datos
					//500 Internal server error
					if(xhr.status==0){
						jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema", "Mensaje");
						//$("#MensajeRef").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
						$("#btnFormRef").show();
					}
					else{
						if(xhr.status==500){
							jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información", "Mensaje");
							//$("#MensajeRef").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
						}
						else{
							jAlert("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado", "Mensaje");
						}	
					}
					
				}'
			),
			array('id'=>'btnFormRef','class'=>'btn btn-default btn-sdis','name'=>'btnFormRef')
		);
    ?>
    <?php echo $boton; //CHtml::submitButton('Crear');?>
    </div>
</div>
	<?php $this->endWidget();
?>
<div class="form-group">
    <?php echo CHtml::label('Referenciacion realizada por:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-6">
      <hr />
    </div>
</div>	
<div class="form-group">
    <?php echo CHtml::label('Nombre del profesional','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-6">
    	<p class="col-md-12">
        	<?php
               echo $profesional["nombre"];
			?>
        </p>       
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Cargo','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-6 span4">
    	<p class="col-md-12 span4">
			<?php 
			foreach($rol as $rol):
				if($rol["id_rol"]===$profesional["id_rol"]):
					echo $rol["nombre_rol"];
				 endif;?>
			<?php endforeach;?>	  
        </p>    
    </div>
</div>
</fieldset>
<?php Yii::app()->getClientScript()->registerScript('script_consRef','
	$( document ).ready(function() {		
        $("[data-toggle=\"tooltip\"]").tooltip();
    });
'
,CClientScript::POS_END);
?>

<?php endif;?>
