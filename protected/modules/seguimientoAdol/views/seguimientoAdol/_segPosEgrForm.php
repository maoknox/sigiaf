<div id="MensajeSeguimientoPE" style="font-size:14px;"></div>

<?php $formSegPe=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioSegAdolPE',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
	// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
?>
	<?php echo  $formSegPe->errorSummary($modeloSeguimiento,'','',array('style' => 'font-size:14px;color:#F00')); ?>
		<fieldset>
    	<div class="panel-heading color-sdis">Registrar Seguimiento</div> <br />
       	<div class="form-group">
			<?php echo $formSegPe->labelEx($modeloSeguimiento,'fecha_seguimiento',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
				<?php //echo $formSegPe->textField($formSegPeAdol,'fecha_nacimiento');?>
                <?php //
                    $this->widget('zii.widgets.jui.CJuiDatePicker',
                        array('model'=>$modeloSeguimiento,
                        'attribute'=>'fecha_seguimiento',
                        'value'=>$modeloSeguimiento->fecha_seguimiento,
                        'language'=>'es',
                        'htmlOptions'=>	array('readonly'=>'readonly','class'=>'col-md-4 form-control'),
                        'options'=>array('autoSize'=>true,
                                'defaultDate'=>$modeloSeguimiento->fecha_seguimiento,
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
                        'id'=>'fecha_set_pe'
                    ));
                    
                ?>
                <?php echo $formSegPe->error($modeloSeguimiento,'fecha_seguimiento',array('style' => 'color:#F00'));?>
        	</div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
				<?php echo $formSegPe->labelEx($modeloSeguimiento,'seguimiento_adol',array('class'=>'control-label','for'=>'searchinput'));?></br>
				<?php echo $formSegPe->textArea($modeloSeguimiento,'seguimiento_adol',array('class'=>'form-control')) ?>
                <?php echo $formSegPe->error($modeloSeguimiento,'seguimiento_adol',array('style' => 'color:#F00'));?>
        	</div>
        </div>
<?php
	$modeloSeguimiento->num_doc=$numDocAdol;
	echo $formSegPe->hiddenField($modeloSeguimiento,'num_doc');
	$modeloSeguimiento->id_tipo_seguim=1;
	echo $formSegPe->hiddenField($modeloSeguimiento,'id_tipo_seguim');
	$modeloSeguimiento->id_area_seguimiento=1;
	echo $formSegPe->hiddenField($modeloSeguimiento,'id_area_seguimiento');
	$modeloSeguimiento->seguim_conj=1;
	echo $formSegPe->hiddenField($modeloSeguimiento,'seguim_conj');
	$boton=CHtml::ajaxSubmitButton (
						'Registrar Seguimiento',   
						array('registraSegimientoPe'),
						array(				
							'dataType'=>'json',
							'type' => 'post',
							'beforeSend'=>'function (){
								$("#btnFormSegPE").hide();
								Loading.show();
							}',
							'success' => 'function(datosSeg) {	
								Loading.hide();
								if(datosSeg.estadoComu=="exito"){
									if(datosSeg.resultado=="\'exito\'"){
										$("#MensajeSeguimientoPE").text("Seguimiento registrado satisfactoriamente");
										$("#formularioSegAdolPE #formularioSegAdolPE_es_").html(""); 
										$("#formularioSegAdolPE #fecha_set_pe").hide(); 
									}
									else{
										$("#MensajeSeguimientoPE").text("Ha habido un error en la creación del registro. Código del error: "+datosSeg.resultado);
										$("#formularioSegAdolPE #formularioSegAdolPE_es_").html("");                                                    
										//$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
									}
								}
								else{						
									$("#btnFormSegPE").show();
									var errores="Por favor corrija los siguientes errores<br/><ul>";
									$.each(datosSeg, function(key, val) {
										errores+="<li>"+val+"</li>";
										$("#formularioSegAdolPE #"+key+"_em_").text(val);                                                    
										$("#formularioSegAdolPE #"+key+"_em_").show();                                                
									});
									errores+="</ul>";
									$("#formularioSegAdolPE #formularioSegAdolPE_es_").html(errores);                                                    
									$("#formularioSegAdolPE #formularioSegAdolPE_es_").show(); 
									
								}
								
							}',
							'error'=>'function (xhr, ajaxOptions, thrownError) {
								Loading.hide();
								//0 para error en comunicación
								//200 error en lenguaje o motor de base de datos
								//500 Internal server error
								if(xhr.status==0){
									$("#MensajeSeguimientoPE").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
									$("#btnFormSegPE").show();
								}
								else{
									if(xhr.status==500){
										$("#MensajeSeguimientoPE").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
									}
									else{
										$("#MensajeSeguimientoPE").html("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
									}	
								}
								
							}'
						),
						array('id'=>'btnFormSegPE','class'=>'btn btn-default btn-sdis','name'=>'btnFormSegPE')
				);
    ?>
	<div class="form-group">
        <div class="col-md-4">	
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
				if(!empty($seguimientosPosEgreso)):?>
					<?php foreach($seguimientosPosEgreso as $pk=>$seguimientoPosEgreso):?>
                    	<?php $profSeg=$modeloSeguimiento->consultaProfSegPE('true',$seguimientoPosEgreso["fecha_registro_seg"],$seguimientoPosEgreso["id_seguimientoadol"]);?>
						<a name="segpe_<?php echo $pk;?>"><strong>Fecha del seguimiento: <?php echo $seguimientoPosEgreso["fecha_seguimiento"] ?>
                        || Nombre del profesional <?php echo $profSeg["nombrespersonal"]?> || Profesión: <?php echo $profSeg["nombre_rol"]?></strong></a><br /><br />
                        <p style="margin:0px 10px 0px 0px"><?php echo CHtml::encode($seguimientoPosEgreso["seguimiento_adol"]); ?></p><br />
                         <?php $actModificacion=$operaciones->comparaFecha(date("Y-m-d"),$segPsc["fecha_seg_ind"]); 
								if($actModificacion==true):?>
                              		<?php echo CHtml::link("Modificar este seguimiento","Modificar este seguimiento",array('submit'=>array('modificarSegPscForm'),'params'=>array('Psc[id_psc]'=>$modeloSeguimientoPsc->id_psc,'Psc[id_seguimiento_ind]'=>$segPsc["id_seguimiento_ind"]))); ?><br />
                                <?php endif?>
                               <br />
                               <br />
                        <hr />
					<?php endforeach;?>					
				<?php endif;?>
            </div>
        </td>
        <td valign="top" style="width:20%">
            <div class="cont-f-seg">
            	<?php if(!empty($seguimientosPosEgreso)):?>
					<?php foreach($seguimientosPosEgreso as $pk=>$seguimientoPosEgreso): ?>
						<a href="#segpe_<?php echo $pk;?>">Fecha:<?php echo $pk."-".$seguimientoPosEgreso["fecha_seguimiento"] ?></a><br />
					<?php endforeach;?>					
				<?php endif;?>
            </div>
        </td>
    </tr>
</table>
</fieldset>
