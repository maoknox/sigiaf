<?php
 if(!empty($numDocAdol) && !empty($consultaGestionAdol)):
?>
<div class="panel-heading color-sdis">Información de la gestión</div>
<?php if(empty($consultaGestionAdol["tipo_gestionsj"])){$consultaGestionAdol["tipo_gestionsj"]="No aplica";}if(empty($consultaGestionAdol["dependencia_entidadsj"])){$consultaGestionAdol["dependencia_entidadsj"]="No aplica";}	if(empty($consultaGestionAdol["nombre_contactosj"])){$consultaGestionAdol["nombre_contactosj"]="No aplica";}if(empty($consultaGestionAdol["telefono_contactosj"])){$consultaGestionAdol["telefono_contactosj"]="No aplica";}?>
<div style="text-align:center">
    <strong>Motivo de la asesoría:</strong> <?php echo $consultaGestionAdol["motivo_asesoriasj"]; $modeloGestionSJ->id_motivoasesoriasj=$consultaGestionAdol["id_motivoasesoriasj"]?><br />
    <strong> A donde remite:</strong> <?php echo $consultaGestionAdol["remision_sj"];$modeloGestionSJ->id_remisionsj=$consultaGestionAdol["id_remisionsj"];?><br />
    <strong> Dependencia-Entidad:</strong> <?php echo $consultaGestionAdol["dependencia_entidadsj"];$modeloGestionSJ->dependencia_entidadsj=$consultaGestionAdol["dependencia_entidadsj"];?><br />
    <strong> Tipo de gestión:</strong> <?php echo $consultaGestionAdol["tipo_gestionsj"];$modeloGestionSJ->id_tipogestionsj=$consultaGestionAdol["id_tipogestionsj"];?><br />
    <strong> Nombre del contacto:</strong> <?php echo $consultaGestionAdol["nombre_contactosj"];$modeloGestionSJ->nombre_contactosj=$consultaGestionAdol["nombre_contactosj"];?><br />
    <strong>Telefono del contacto:</strong> <?php echo $consultaGestionAdol["telefono_contactosj"];$modeloGestionSJ->telefono_contactosj=$consultaGestionAdol["telefono_contactosj"];?><br />
    <strong>Fecha de la gestión:</strong> <?php echo $consultaGestionAdol["fecha_gestionsj"];$modeloGestionSJ->fecha_gestionsj=$consultaGestionAdol["fecha_gestionsj"];?><br />
</div>                
<?php $formModGSJAdol=$this->beginWidget('CActiveForm', array(
	'id'=>'formModGSJAdol',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
        <?php echo  $formModGSJAdol->errorSummary($modeloGestionSJ,'','',array('style' => 'font-size:14px;color:#F00')); ?>
<hr />
       <div class="form-group">
			<?php echo $formModGSJAdol->labelEx($modeloGestionSJ,'nombre_contactosj',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php 									
                    echo $formModGSJAdol->textField($modeloGestionSJ,'nombre_contactosj',array('class'=>'form-control'));						
                ?>  
                <?php echo $formModGSJAdol->error($modeloGestionSJ,'nombre_contactosj',array('style' => 'color:#F00'));?>
        	</div>
       </div>
       <div class="form-group">
			<?php echo $formModGSJAdol->labelEx($modeloGestionSJ,'telefono_contactosj',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php 									
                    echo $formModGSJAdol->textField($modeloGestionSJ,'telefono_contactosj',array('class'=>'form-control'));						
                ?>  
                <?php echo $formModGSJAdol->error($modeloGestionSJ,'telefono_contactosj',array('style' => 'color:#F00'));?>
        	</div>
       </div>
            <div class="form-group">
   			 <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label'));?>
                <div class="col-md-4">		
                <?php
                    $modeloGestionSJ->num_doc=$numDocAdol;
					$modeloGestionSJ->fecha_regsitrogestionsj=date("Y-m-d");
					$modeloGestionSJ->id_gestionsj=$consultaGestionAdol["id_gestionsj"];
                    echo $formModGSJAdol->hiddenField($modeloGestionSJ,'num_doc');	
					echo $formModGSJAdol->hiddenField($modeloGestionSJ,'fecha_regsitrogestionsj');
					echo $formModGSJAdol->hiddenField($modeloGestionSJ,'id_motivoasesoriasj');	
					echo $formModGSJAdol->hiddenField($modeloGestionSJ,'id_remisionsj');	
					echo $formModGSJAdol->hiddenField($modeloGestionSJ,'fecha_gestionsj');
					echo $formModGSJAdol->hiddenField($modeloGestionSJ,'dependencia_entidadsj');
					echo $formModGSJAdol->hiddenField($modeloGestionSJ,'id_tipogestionsj');
					echo $formModGSJAdol->hiddenField($modeloGestionSJ,'id_gestionsj');
                    echo $formModGSJAdol->error($modeloGestionSJ,'num_doc',array('style' => 'color:#F00'));
					echo $formModGSJAdol->error($modeloGestionSJ,'fecha_regsitrogestionsj',array('style' => 'color:#F00'));
                    $boton=CHtml::ajaxSubmitButton (
                                    'Modificar',   
                                    array('gestionSeguimSJ/modificaRegistroSJ'),
                                    array(				
                                        'dataType'=>'json',
                                        'type' => 'post',
                                        'beforeSend'=>'function (){$("#btnFormGSJ").hide();Loading.show();}',
                                        'success' => 'function(datos) {	
                                            Loading.hide();
                                            if(datos.estadoComu=="exito"){
                                                if(datos.resultado=="exito"){                                             
                                                     jAlert("Gestión modificada satisfactoriamente","Mensaje");                                               
                                                    $("#formModGSJAdol #formModGSJAdol_es_").html("");    
													$("#formModGSJAdol").removeClass("unsavedForm");  
                                                }
                                                else{
                                                    jAlert("Ha habido un error en la creación del registro. Código del error: "+datos.resultado,"Mensaje");
                                                    $("#formModGSJAdol #formModGSJAdol_es_").html("");                                                    
                                                    //$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
                                                }
                                            }
                                            else{						
												$("#formModGSJAdol #GestionSociojuridica_id_motivoasesoriasj_em_").text("");
												$("#formModGSJAdol #GestionSociojuridica_id_remisionsj_em_").text("");
												$("#formModGSJAdol #GestionSociojuridica_dependencia_entidadsj_em_").text("");
												$("#formModGSJAdol #GestionSociojuridica_id_tipogestionsj_em_").text("");
												$("#formModGSJAdol #GestionSociojuridica_nombre_contactosj_em_").text("");
												$("#formModGSJAdol #GestionSociojuridica_telefono_contactosj_em_").text("");
												$("#formModGSJAdol #GestionSociojuridica_fecha_gestionsj_em_").text("");
                                                $("#btnFormGSJ").show();
                                                var errores="Por favor tenga en cuenta lo siguiente<br/><ul>";
                                                $.each(datos, function(key, val) {
                                                    errores+="<li>"+val+"</li>";
                                                    $("#formModGSJAdol #"+key+"_em_").text(val);                                                    
                                                    $("#formModGSJAdol #"+key+"_em_").show();                                                
                                                });
                                                errores+="</ul>";
                                                $("#formModGSJAdol #formModGSJAdol_es_").html(errores);                                                    
                                                $("#formModGSJAdol #formModGSJAdol_es_").show(); 
                                                
                                            }
                                            
                                        }',
                                        'error'=>'function (xhr, ajaxOptions, thrownError) {
                                            Loading.hide();
                                            //0 para error en comunicación
                                            //200 error en lenguaje o motor de base de datos
                                            //500 Internal server error
                                            if(xhr.status==0){
                                                jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema","Mensaje");
                                                $("#btnFormRef").show();
                                            }
                                            else{
                                                if(xhr.status==500){
                                                    jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información","Mensaje");
                                                }
                                                else{
                                                    jAlert("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado","Mensaje");
                                                }	
                                            }
                                            
                                        }'
                                    ),
                                    array('id'=>'btnFormGSJ','class'=>'btn btn-default btn-sdis','name'=>'btnFormGSJ')
                            );
                ?>
                <?php echo $boton; //CHtml::submitButton('Crear');?>
                </div>
        </div>

<?php
	$this->endWidget();
?>
<?php Yii::app()->getClientScript()->registerScript('script_modGSJAdol','
		$(document).ready(function(){
		$("#formModGSJAdol").find(":input").change(function(){
		  var dirtyForm = $(this).parents("form");
		  // change form status to dirty
		  dirtyForm.addClass("unsavedForm");
		});
		$(window).bind("beforeunload", function(){
			if($(".unsavedForm").size()){
				return "No ha guardado cambios, si cierra la aplicación los perderá";
			}
		});
	});	
	
'
,CClientScript::POS_END);
?>
<?php endif;?>
		