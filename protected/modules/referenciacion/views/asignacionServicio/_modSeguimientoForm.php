<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('referenciacion/asignacionServicio/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('referenciacion/asignacionServicio/consultaSegServicioForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($modeloRef->id_referenciacion)):?>
<div id="MensajeRef" style="font-size:14px;"></div>
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
                foreach($beneficiario as $beneficiario){//revisar
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
                foreach($espNi as $espNi){//revisar
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
                foreach($espNii as $espNii){//revisar
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
                foreach($espNiii as $espNiii){//revisar
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
<div class="form-group">
    <?php echo CHtml::label('Estado','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="row">
    	<p class="col-md-6">
			<?php
            foreach($estadoRef as $estadoRef){//revisar
                if($estadoRef["id_estadoref"]===$modeloRef->id_estadoref){
                    echo $estadoRef["estado_ref"];
                }
            }
            
            ?>
        </p>      
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Referenciacion realizada por:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-6">
      <hr />
    </div>
</div>	
<div class="form-group">
    <?php echo CHtml::label('Nombre del profesional','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="row">
    	<p class="col-md-6">
        	<?php
               echo $profesional["nombre"];
			?>
        </p>       
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Cargo','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="row">
    	<p class="col-md-6">
			<?php 
			foreach($rol as $rol)://revisar
				if($rol["id_rol"]===$profesional["id_rol"]):
					echo $rol["nombre_rol"];
				 endif;?>
			<?php endforeach;?>	  
        </p>     
    </div>
</div>

</fieldset>
<fieldset>
<div class="panel-heading color-sdis">Seguimiento</div> 
<?php $formModEstRef=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioRef',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
<?php echo  $formModEstRef->errorSummary($modeloSegRefer,'','',array('style' => 'font-size:14px;color:#F00')); ?>
<div class="form-group">
    <div class="col-md-12">
		<?php 
            $modeloSegRefer->id_referenciacion=$modeloRef->id_referenciacion;
            $modeloSegRefer->id_seg_refer=$seguimiento["id_seg_refer"];
            $modeloSegRefer->seg_refer=$seguimiento["seg_refer"];
            $modeloSegRefer->fecha_seg=$seguimiento["fecha_seg"];			
            echo $formModEstRef->textArea($modeloSegRefer,'seg_refer',array('class'=>'col-md-12 form-control'))."<br/>";
            echo $formModEstRef->hiddenField($modeloSegRefer,'id_referenciacion');
            echo $formModEstRef->hiddenField($modeloSegRefer,'id_seg_refer');
            echo $formModEstRef->hiddenField($modeloSegRefer,'fecha_seg');
        ?>
    </div>
</div>
<div class="form-group">
    <div class="col-md-12">
	<?php
        //echo $formModEstRef->hiddenField('numDocAdol',$numDocAdol);
        $boton=CHtml::ajaxSubmitButton (
                            'Registrar Seguimiento',   
                            array('asignacionServicio/registraModSegimiento'),
                            array(				
                                'dataType'=>'json',
                                'type' => 'post',
                                'beforeSend'=>'function (){$("#btnFormRef").hide();Loading.show();}',
                                'success' => 'function(datosRef) {	
                                    Loading.hide();
                                    if(datosRef.estadoComu=="exito"){
                                        if(datosRef.resultado=="\'exito\'"){
                                            //$("#MensajeRef").text("Seguimiento registrado satisfactoriamente");
											jAlert("Seguimiento registrado satisfactoriamente", "Mensaje");
                                            $("#formularioRef #formularioRef_es_").html("");      
                                        }
                                        else{
											jAlert("Ha habido un error en la creación del registro. Código del error: "+datosRef.resultado, "Mensaje");
                                           // $("#MensajeRef").text("Ha habido un error en la creación del registro. Código del error: "+datosRef.resultado);
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
									var StrippedString = xhr.responseText.replace(/(<([^>]+)>)/ig,"");
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
											//var alertaError=alert(document.cookie);
											//var alertaStripped=alertaError.replace(/(<([^>]+)>)/ig,"");										
											jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información <br/>"+StrippedString, "Mensaje");
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
        <?php echo $boton; //CHtml::submitButton('Crear');
        $this->endWidget();
    	?>
    </div>
</div>
</fieldset>
<?php endif;?>
