<?php
 if(!empty($numDocAdol) && !empty($consultaGestionAdol)):
?>
<div class="panel-heading color-sdis">Información de la gestión</div>
<?php if(empty($consultaGestionAdol["tipo_gestionsj"])){$consultaGestionAdol["tipo_gestionsj"]="No aplica";}if(empty($consultaGestionAdol["dependencia_entidadsj"])){$consultaGestionAdol["dependencia_entidadsj"]="No aplica";}	if(empty($consultaGestionAdol["nombre_contactosj"])){$consultaGestionAdol["nombre_contactosj"]="No aplica";}if(empty($consultaGestionAdol["telefono_contactosj"])){$consultaGestionAdol["telefono_contactosj"]="No aplica";}?>
<div style="text-align:center">
    <strong>Motivo de la asesoría:</strong> <?php echo $consultaGestionAdol["motivo_asesoriasj"];?><br />
    <strong> A donde remite:</strong> <?php echo $consultaGestionAdol["remision_sj"];?><br />
    <strong> Dependencia-Entidad:</strong> <?php echo $consultaGestionAdol["dependencia_entidadsj"];?><br />
    <strong> Tipo de gestión:</strong> <?php echo $consultaGestionAdol["tipo_gestionsj"];?><br />
    <strong> Nombre del contacto:</strong> <?php echo $consultaGestionAdol["nombre_contactosj"];?><br />
    <strong>Telefono del contacto:</strong> <?php echo $consultaGestionAdol["telefono_contactosj"];?><br />
    <strong>Fecha de la gestión:</strong> <?php echo $consultaGestionAdol["fecha_gestionsj"];?><br />
</div>                
<?php $formSegGSJAdol=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioSegGSJAdol',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
<?php echo  $formSegGSJAdol->errorSummary($modeloSegAsesoriasSJ,'','',array('style' => 'font-size:14px;color:#F00')); ?>
    <div class="panel-heading color-sdis">Diligenciamiento del seguimiento</div>
    <br />
       	<div class="form-group">
		<?php echo $formSegGSJAdol->labelEx($modeloSegAsesoriasSJ,'fecha_seguimientogsj',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    	<div class="col-md-4">
            <?php //
                $this->widget('zii.widgets.jui.CJuiDatePicker',
					array('model'=>$modeloSegAsesoriasSJ,
					'attribute'=>'fecha_seguimientogsj',
					'value'=>$modeloSegAsesoriasSJ->fecha_seguimientogsj,
					'language'=>'es',
					'htmlOptions'=>	array('readonly'=>'readonly','class'=>'col-md-4 form-control'),
					'options'=>array('autoSize'=>true,
							'defaultDate'=>$modeloSegAsesoriasSJ->fecha_seguimientogsj,
							'dateFormat'=>'yy-mm-dd',
							//'buttonImageOnly'=>false,
							//'buttonText'=>'Seleccione Fecha',
							'selectOtherMonths'=>true,
							'showAnim'=>'slide',
							//'showButtonPanel'=>false,
							//'showOn'=>'button',
							'showOtherMonths'=>true,
							'changeMonth'=>'true',
							'changeYear'=>'true',
							'maxDate'=>date("Y-m-d")					
					),
				));
			?>
			<?php echo $formSegGSJAdol->error($modeloSegAsesoriasSJ,'fecha_seguimientogsj',array('style' => 'color:#F00'));?>
    	</div>
	</div>   
	<div class="form-group">
        <div class="col-md-12">
		<?php echo $formSegGSJAdol->labelEx($modeloSegAsesoriasSJ,'seguimiento_gestionsj',array('class'=>'control-label','for'=>'searchinput'));?></br>
        <?php echo $formSegGSJAdol->textArea($modeloSegAsesoriasSJ,'seguimiento_gestionsj',array('class'=>'form-control')) ?>
        <?php echo $formSegGSJAdol->error($modeloSegAsesoriasSJ,'seguimiento_gestionsj',array('style' => 'color:#F00'));?>
        </div> 
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $modeloSegAsesoriasSJ->id_gestionsj=$modeloGestionSJ->id_gestionsj;
				$modeloSegAsesoriasSJ->fecha_registrosegsj=date("Y-m-d");
				$modeloSegAsesoriasSJ->id_cedula=0000000000;
                echo $formSegGSJAdol->hiddenField($modeloSegAsesoriasSJ,'id_gestionsj');
				echo $formSegGSJAdol->hiddenField($modeloSegAsesoriasSJ,'fecha_registrosegsj');
				echo $formSegGSJAdol->hiddenField($modeloSegAsesoriasSJ,'id_cedula');
                $boton=CHtml::ajaxSubmitButton (
					'Registrar Seguimiento',   
					array('realizarSeguimientoSJ'),
					array(				
						'dataType'=>'json',
						'type' => 'post',
						'beforeSend'=>'function (){
							$("#btnFormSeg").hide();
							Loading.show();
						}',
						'success' => 'function(datosSeg) {	
							Loading.hide();
							if(datosSeg.estadoComu=="exito"){
								if(datosSeg.resultado=="exito"){									
									//mensajeStripped=mensajeStripped.replace(/(<([^>]+)>)/ig,"");
									jAlert("Seguimiento registrado satisfactoriamente", "Mensaje");
									//$("#MensajeSeguimiento").text("Seguimiento registrado satisfactoriamente");
									$("#formularioSegGSJAdol #formularioSegGSJAdol_es_").html("");   
								}
								else{
									jAlert("Ha habido un error en la creación del registro. Comuníquese con el ingeniero encargado ","Mensaje");
									$("#formularioSegGSJAdol #formularioSegGSJAdol_es_").html("");                                                    
									//$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
								}
							}
							else{						
								$("#btnFormSeg").show();
								var errores="Por favor tenga en cuenta las siguientes validaciones<br/><ul>";
								$.each(datosSeg, function(key, val) {
									errores+="<li>"+val+"</li>";
									$("#formularioSegGSJAdol #"+key+"_em_").text(val);                                                    
									$("#formularioSegGSJAdol #"+key+"_em_").show();                                                
								});
								errores+="</ul>";
								$("#formularioSegGSJAdol #formularioSegGSJAdol_es_").html(errores);                                                    
								$("#formularioSegGSJAdol #formularioSegGSJAdol_es_").show(); 
								
							}
							
						}',
						'error'=>'function (xhr, ajaxOptions, thrownError) {
							Loading.hide();
							//0 para error en comunicación
							//200 error en lenguaje o motor de base de datos
							//500 Internal server error
							if(xhr.status==0){
								jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema","Mensaje");
								$("#btnFormSeg").show();
							}
							else{
								if(xhr.status==500){
									jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información","Mensaje");
								}
								else{//No se ha creado el registro del adolescente debido 
									jAlert("No se ha creado el registro del seguimiento. Comuníquese con el ingeniero encargado","Mensaje");
								}	
							}
							
						}'
					),
					array('id'=>'btnFormSeg','class'=>'btn btn-default btn-sdis','name'=>'btnFormSeg')
				);
            ?>
        	<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div> 
	</div>
	<?php $this->endWidget();?>
<fieldset>
	    <div class="panel-heading color-sdis">Histórico de seguimientos</div> <br />
            <table style="border:0px; width:100%;">
                <tr>
                    <td style="width:80%">
                        <div class="cont-seg">
                            <?php 
                            if(!empty($consultaHistSeg)):?>
                                <?php foreach($consultaHistSeg as $pk=>$seguimiento):?>
                                    <?php //$profSeg=$modeloSeguimiento->consultaProfSeg('true',$seguimiento["fecha_registro_seg"],$seguimiento["id_seguimientoadol"]);?>
                                    <a name="<?php echo $pk;?>"><strong>Fecha del seguimiento: <?php echo $seguimiento["fecha_seguimientogsj"] ?>
                                    || Nombre del profesional <?php echo $seguimiento["nombre_personal"]." ".$seguimiento["apellidos_personal"];?> || Profesión: <?php echo $seguimiento["nombre_rol"]?></strong></a><br /><br />
                                    <p style="margin:0px 10px 0px 0px"><?php echo CHtml::encode($seguimiento["seguimiento_gestionsj"]); ?></p><br />                                    
                                    <hr />
                                <?php endforeach;?>					
                            <?php endif;?>
                        </div>
                    </td>
                    <td valign="top" style="width:20%">
                        <div class="cont-f-seg">
                            <?php if(!empty($consultaHistSeg)):?>
                                <?php foreach($consultaHistSeg as $pk=>$fechaSeguimientoS): ?>
                                    <a href="#<?php echo $pk;?>">Fecha: <?php echo $pk."-".$fechaSeguimientoS["fecha_seguimientogsj"] ?></a><br />
                                <?php endforeach;?>					
                            <?php endif;?>
                        </div>
                    </td>
                </tr>
            </table>
    </fieldset>


<?php Yii::app()->getClientScript()->registerScript('script_segGSJAdol','
		
'
,CClientScript::POS_END);
?>
<?php endif;?>
		