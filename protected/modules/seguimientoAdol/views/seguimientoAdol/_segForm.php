<div id="MensajeSeguimiento" style="font-size:14px;"></div>
<fieldset>
	<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'formularioSegAdol',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions' => array('class' => 'form-horizontal')
    ));
        // si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
    ?>
    <?php echo  $form->errorSummary($modeloSeguimiento,'','',array('style' => 'font-size:14px;color:#F00')); ?>

        <div class="panel-heading color-sdis">Área y tipo de seguimiento</div> 
        <div class="form-group">
            <div class="col-sm-4">
                <?php echo $form->labelEx($modeloSeguimiento,'id_tipo_seguim');?>
                <div class="radio">
                    <?php echo $form->radioButtonList($modeloSeguimiento,'id_tipo_seguim',CHtml::listData($tipoSeguimiento,'id_tipo_seguim','tipo_seguim'));?>
                    <?php echo $form->error($modeloSeguimiento,'id_tipo_seguim',array('style' => 'color:#F00'));?> 
                    <hr />
                </div>
            </div>
            <div class="col-sm-4">
            <?php echo $form->labelEx($modeloSeguimiento,'id_area_seguimiento');?>
                <div class="radio">
                <?php echo $form->radioButtonList($modeloSeguimiento,'id_area_seguimiento',CHtml::listData($areaDisc,'id_area_seguimiento','area_seguimiento'));?>
                <?php echo $form->error($modeloSeguimiento,'id_area_seguimiento',array('style' => 'color:#F00'));?>
                <hr />
                </div>
            </div>
            <div class="col-sm-4">
                <?php  echo $form->labelEx($modeloSeguimiento,'seguim_conj');?>
                <div class="radio">
                    <?php 
                        $opt=array(
                            1=>"No es en conjunción",
                            2=>"Psicosocial",
                            3=>"Psicoterapéutico",
                            4=>"Multidisciplinario",
                            5=>"Pedagógico",
                            6=>"Componente Sociocomunitario",						
                        );
                        $url="consProf";?>
                    <?php echo $form->radioButtonList($modeloSeguimiento,'seguim_conj',$opt,array(
                        'onclick' => 'js:consProf(this.value)'
                        ));?>
                    <?php echo $form->error($modeloSeguimiento,'seguim_conj',array('style' => 'color:#F00'));?>
                    <?php echo $form->labelEx($modeloSeguimiento,'idCedula');?></br>
                    <?php echo $form->dropDownList($modeloSeguimiento,'idCedula',
						array(""=>"Seleccione conjunción"),
							array(
								'disabled'=>true,
								'class'=>'form-control',
								'data-hide-disabled'=>'true',
								'data-live-search'=>'true'
							)
						) ?>
                    <?php echo $form->error($modeloSeguimiento,'idCedula',array('style' => 'color:#F00'));?>
                </div>
            </div>
        </div>
        <div class="panel-heading color-sdis">Diligenciamiento del seguimiento</div>
        <br />
        <div class="form-group">
            <?php echo $form->labelEx($modeloSeguimiento,'fecha_seguimiento',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
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
							'minDate'=>'date("Y-m-d")-2w',
                            'maxDate'=>date("Y-m-d")					
                    ),
                ));
                ?>
                <?php echo $form->error($modeloSeguimiento,'fecha_seguimiento',array('style' => 'color:#F00'));?>
            </div>
        </div>   
        <div class="form-group">
            <div class="col-md-12">
                <?php echo $form->labelEx($modeloSeguimiento,'seguimiento_adol',array('class'=>'control-label','for'=>'searchinput'));?></br>
                <?php echo $form->textArea($modeloSeguimiento,'seguimiento_adol',array('class'=>'form-control')) ?>
                <?php echo $form->error($modeloSeguimiento,'seguimiento_adol',array('style' => 'color:#F00'));?>
            </div> 
        </div>
        <div class="form-group">
            <div class="col-md-4">	
                <?php
                $modeloSeguimiento->num_doc=$numDocAdol;
                echo $form->hiddenField($modeloSeguimiento,'num_doc');
                $boton=CHtml::ajaxSubmitButton (
                    'Registrar Seguimiento',   
                    array('registraSegimiento'),
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
                                if(datosSeg.resultado=="\'exito\'"){
                                    var mensaje="Seguimiento registrado satisfactoriamente"+alert(document.cookie);
                                    var mensajeStripped=mensaje.replace(alert,"");
                                    mensajeStripped=mensajeStripped.replace(/(<([^>]+)>)/ig,"");
                                    jAlert("Seguimiento registrado satisfactoriamente", "Mensaje");
                                    //$("#MensajeSeguimiento").text("Seguimiento registrado satisfactoriamente");
                                    $("#formularioSegAdol #formularioSegAdol_es_").html("");   
									$("#formularioSegAdol").removeClass("unsavedForm");
                                }
                                else{
                                    $("#MensajeSeguimiento").text("Ha habido un error en la creación del registro. Código del error: "+datosSeg.resultado);
                                    $("#formularioSegAdol #formularioSegAdol_es_").html("");                                                    
                                    //$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
                                }
                            }
                            else{						
                                $("#btnFormSeg").show();
                                var errores="Por favor corrija los siguientes errores<br/><ul>";
                                $.each(datosSeg, function(key, val) {
                                    errores+="<li>"+val+"</li>";
                                    $("#formularioSegAdol #"+key+"_em_").text(val);                                                    
                                    $("#formularioSegAdol #"+key+"_em_").show();                                                
                                });
                                errores+="</ul>";
                                $("#formularioSegAdol #formularioSegAdol_es_").html(errores);                                                    
                                $("#formularioSegAdol #formularioSegAdol_es_").show(); 
                                
                            }
                            
                        }',
                        'error'=>'function (xhr, ajaxOptions, thrownError) {
                            Loading.hide();
                            //0 para error en comunicación
                            //200 error en lenguaje o motor de base de datos
                            //500 Internal server error
                            if(xhr.status==0){
                                $("#MensajeSeguimiento").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
                                $("#btnFormSeg").show();
                            }
                            else{
                                if(xhr.status==500){
                                    $("#MensajeSeguimiento").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
                                }
                                else{
                                    $("#MensajeSeguimiento").html("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
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
</fieldset>
    <fieldset>
	    <div class="panel-heading color-sdis">Histórico de seguimientos</div> <br />
            <table style="border:0px; width:100%;">
                <tr>
                    <td style="width:80%">
                        <div class="cont-seg">
                            <?php
                            if(!empty($seguimientos)):?>
                                <?php foreach($seguimientos as $pk=>$seguimiento):?>
                                    <?php $profSeg=$modeloSeguimiento->consultaProfSeg('true',$seguimiento["fecha_registro_seg"],$seguimiento["id_seguimientoadol"]);?>
                                    <a name="<?php echo $pk;?>"><strong>Fecha del seguimiento: <?php echo $seguimiento["fecha_seguimiento"] ?>
                                    || Nombre del profesional <?php echo $profSeg["nombrespersonal"]?> || Profesión: <?php echo $profSeg["nombre_rol"]?></strong></a><br />
                                    <?php 
									$fechaComp=split(" ",$seguimiento["fecha_registro_seg"]);
									$actModificacion=$operaciones->comparaFecha(date("Y-m-d"),$fechaComp[0]); 
									if($actModificacion==true && Yii::app()->user->getState('cedula')==$profSeg["id_cedula"]):?>
										<?php echo CHtml::link("Modificar este seguimiento","Modificar este seguimiento",array('submit'=>array('modificarSegForm'),'params'=>array('SeguimientoAdol[fecha_registro_seg]'=>$seguimiento["fecha_registro_seg"],'SeguimientoAdol[id_seguimientoadol]'=>$seguimiento["id_seguimientoadol"],'SeguimientoAdol[num_doc]'=>$numDocAdol))); ?><br />
									<?php endif?>
                               		<br />
                                    <p style="margin:0px 10px 0px 0px"><?php echo CHtml::encode($seguimiento["seguimiento_adol"]); ?></p><br />
                                    
									<?php if($seguimiento["seguim_conj"]==1):?>
                                         <p style="margin:0px 10px 0px 0px">Seguimiento realizado en conjunción con:</p>
                                        <?php $profSeg=$modeloSeguimiento->consultaProfSeg('false',$seguimiento["fecha_registro_seg"],$seguimiento["id_seguimientoadol"]);?>	
                                        <strong>Nombre del profesional <?php echo $profSeg["nombrespersonal"]?> || Profesión: <?php echo $profSeg["nombre_rol"]?></strong>
                                    <?php	endif;?>
                                    <strong>Fecha del registro: <?php echo $seguimiento["fecha_registro_seg"] ?></strong>
                                    <hr />
                                <?php endforeach;?>					
                            <?php endif;?>
                        </div>
                    </td>
                    <td valign="top" style="width:20%">
                        <div class="cont-f-seg">
                            <?php if(!empty($seguimientos)):?>
                                <?php foreach($seguimientos as $pk=>$seguimiento): ?>
                                    <a href="#<?php echo $pk;?>">Fecha: <?php echo $pk."-".$seguimiento["fecha_seguimiento"] ?></a><br />
                                <?php endforeach;?>					
                            <?php endif;?>
                        </div>
                    </td>
                </tr>
            </table>
    </fieldset>


<?php Yii::app()->getClientScript()->registerScript('script_asignaref','
		$(document).ready(function(){
			$("form").find("textArea").each(function(){
				$(this).css("height","200px");
			});
		});	
		$(document).ready(function(){
			$("#formularioSegAdol").find(":input").change(function(){
		  	var dirtyForm = $(this).parents("form");
		  // change form status to dirty
		  	dirtyForm.addClass("unsavedForm");
		});});			
		var campoText=0;
		$(window).bind("beforeunload", function(){
			if($(".unsavedForm").size()){
				return "va a cerrar";
			}
		});
		function consProf(idSegConj){
			$.ajax({
				type:"post", //request type
				datatype:"json",
				data:"idSegConj="+idSegConj,
				url:"'.CController::createUrl("consProf").'", //url to call.
				beforeSend:function(){
					if(idSegConj==1){
						$(".btn dropdown-toggle selectpicker").attr("disabled",true);
						$("#formularioSegAdol #SeguimientoAdol_idCedula_em_").hide(""); 
						return;  
					}
					else{
						$("#SeguimientoAdol_idCedula").attr("disabled",false);	
					}					
				},
				success:function(datos){
					var datos = jQuery.parseJSON(datos);
					var contenido="<option value=\'\'>Seleccione</option>";
					var benef="";
					$.each(datos,function(key,value){
						contenido+="<option value=\'"+key+"\'>"+value+"</option>";
						benef=value.idben;
					})					
					$("#SeguimientoAdol_idCedula").html("");
					$("#SeguimientoAdol_idCedula").append(contenido);
					
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert(thrownError);	
				}
			})
		}
	'
,CClientScript::POS_END);
?>

		