<?php 
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('administracion/administracion/activarCasoAdolForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)): ?>
	<?php if($datosForjarAdol["id_estado_adol"]==2): ?>
	<div class="panel-heading color-sdis">Activar caso adolescente</div> 
	<br />
		<?php $formActivaCaso=$this->beginWidget('CActiveForm', array(
            //'action'=>'creaRol',
            'id'=>'formActivaCaso',
            //'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions' => array('class' => 'form-horizontal')
        ));
        ?>
        <?php echo  $formActivaCaso->errorSummary($modeloForjarAdol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
            <div class="form-group">
                <?php //echo $formCambiaClave->labelEx($modeloForjarAdol,'clave',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
                <div class="col-md-4">
                    <?php //echo $formCambiaClave->passwordField($modeloForjarAdol,'clave',array('class'=>'form-control input-md'));?>
                    <?php //echo $formCambiaClave->error($modeloForjarAdol,'clave',array('style' => 'color:#F00'));?>     
                </div>
            </div>
            <div class="form-group">
            	<?php
					$modeloForjarAdol->id_forjar=$datosForjarAdol["id_forjar"];
					$modeloForjarAdol->num_doc=$numDocAdol;
					$modeloForjarAdol->id_estado_adol=1;
				?>
           		<?php echo $formActivaCaso->hiddenField($modeloForjarAdol,'id_forjar',array('class'=>'form-control input-md'));?>
           		<?php echo $formActivaCaso->hiddenField($modeloForjarAdol,'num_doc',array('class'=>'form-control input-md'));?>
           		<?php echo $formActivaCaso->hiddenField($modeloForjarAdol,'id_estado_adol',array('class'=>'form-control input-md'));?>
            <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4"> 
                <?php
                        $boton=CHtml::ajaxSubmitButton (
                            'Activar caso adolescente',   
                            array('administracion/activarCasoAdol'),
                            array(				
                                'dataType'=>'json',
                                'type' => 'post',
                                'beforeSend'=>'function (){$("#btnForm").hide();Loading.show();}',
                                'success' => 'function(datosRef) {	
                                    Loading.hide();
                                    if(datosRef.estadoComu=="exito"){
                                        if(datosRef.resultado=="exito"){
                                            //$("#MensajeRef").text("Rol creado satisfactoriamente");
                                            jAlert("Caso adolescente activado", "Mensaje");
                                            $("#formActivaCaso").removeClass("unsavedForm");
                                        }
                                        else{
                                            jAlert("Ha habido un error en la creación del registro. Código del error: "+datosRef.resultado, "Mensaje");
                                           // $("#MensajeRef").text("Ha habido un error en la creación del registro. Código del error: "+datosRef.resultado);
                                            //$("#formActivaCaso #formActivaCaso_es_").html("");                                                    
                                            //$("#formActivaCaso #formActivaCaso_es_").hide(); 	
                                        }
                                    }
                                    else{						
                                        $("#btnForm").show();
                                        var errores="Por favor corrija los siguientes errores<br/><ul>";
                                        $.each(datosRef, function(key, val) {
                                            errores+="<li>"+val+"</li>";
                                            $("#formActivaCaso #"+key+"_em_").text(val);                                                    
                                            $("#formActivaCaso #"+key+"_em_").show();                                                
                                        });
                                        errores+="</ul>";
                                        $("#formActivaCaso #formActivaCaso_es_").html(errores);                                                    
                                        $("#formActivaCaso #formActivaCaso_es_").show(); 
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
                            array('id'=>'btnForm','class'=>'btn btn-default btn-sdis','name'=>'btnForm')
                    );
        
                
                ?>
            
                
                <?php echo $boton; ?>     
            </div>
        </div>
        
        <?php
        $this->endWidget();
        ?>
        <?php Yii::app()->getClientScript()->registerScript('tratamientoForm','
                $(document).ready(function(){
                    $("#formActivaCaso").find(":input").change(function(){
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
        ',CClientScript::POS_END);		
        ?>
      <?php else:?>
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
               El adolescente no está inactivo en el sistema o no ha egresado del servicio.             
             </div>
        </div> 
 	</div>
 </div>        

      <?php endif;?>
<?php endif;?>


