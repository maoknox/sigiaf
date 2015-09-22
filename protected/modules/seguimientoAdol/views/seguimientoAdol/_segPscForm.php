<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('seguimientoAdol/seguimientoAdol/consultarPsc'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>

<?php if(!empty($pscSinCulm)):?>
        <fieldset class="form-horizontal">
        <div class="panel-heading color-sdis">Informaci&oacute;n y seguimiento de prestaci&oacute;n de servicios a la comunidad</div><br />
        <div class="form-group">
            <?php echo CHtml::label('Fecha inicio:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
                <p class="cont-inf">
                    <?php echo $pscSinCulm[0]["fecha_inicio_psc"];?>
                </p>
            </div>
        </div>   
        <div class="form-group">
            <?php echo CHtml::label('Fecha finalizaci&oacute;n:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
                <p class="cont-inf">
                    <?php echo $pscSinCulm[0]["fecha_fin_psc"];?>
                </p>
            </div>
        </div>   
        <div class="form-group">
            <?php echo CHtml::label('Escenario:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
                <p class="cont-inf">
                    <?php 
                        $instituto=$modeloSeguimientoPsc->consultaInstituto($pscSinCulm[0]["id_institucionpsc"]);
                        echo $instituto["institucionpsc"];
                    ?>
                </p>
            </div>
        </div>   
        <div class="form-group">
            <?php echo CHtml::label('Facilitador:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
                <p class="cont-inf">
                    <?php if(empty($pscSinCulm[0]["responsable_psc"])){$pscSinCulm[0]["responsable_psc"]="Sin Inf.";} ?>
                    <?php echo $pscSinCulm[0]["responsable_psc"];?>
                </p>
            </div>
        </div>   
        <div class="form-group">
            <?php echo CHtml::label('Tel&eacute;fono:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
                <p class="cont-inf">
                    <?php if(empty($pscSinCulm[0]["telefono_resp"])){$pscSinCulm[0]["telefono_resp"]="Sin Inf.";} ?>
                    <?php echo $pscSinCulm[0]["telefono_resp"];?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <?php echo CHtml::label('Horario:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <?php 
                $modeloPsc->num_doc=$numDocAdol;
                $horario=$modeloPsc->consultaDiaHorario($pscSinCulm[0]["id_psc"]);
            ?>
            <div class="col-md-4">
                <div class="col-md-6">            
                    Día
                </div>
                <div class="col-md-6">
                    Horario
                </div>
                <?php if(!empty($horario)): ?>
                    <?php foreach($horario as $pk=>$horario): $dias[$pk]=$horario["id_dia"];?>
                        <div class="col-md-6">
                            <p class="cont-inf">
                                <?php echo $horario["nomb_dia"];?>
                            </p>                                    
                        </div>
                        <div class="col-md-6">
                            <p class="cont-inf">
                                <?php echo $horario["hora_inicio"]."-".$horario["hora_inicio_m"]." ".$horario["hora_fin"]."-".$horario["hora_fin_m"];?>
                            </p>                                     
                        </div>
                    <?php endforeach;  ?>
                 <?php endif;  ?>
            </div>
        </div>  
        <div class="form-group">
            <?php echo CHtml::label('Horas de cumplimiento:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
                <p class="cont-inf">
                    <?php 
                        $modeloSeguimientoPsc->id_psc=$pscSinCulm[0]["id_psc"];
                        $modeloSeguimientoPsc->num_doc=$numDocAdol;
                        //echo $modeloSeguimientoPsc->id_psc;
                        $horasCumpPsc=$modeloSeguimientoPsc->consHorasCumpPsc();
                        $numHoras=0;
                        if(!empty($horasCumpPsc)){
                            foreach($horasCumpPsc as $horaCumpPsc){
                                $numHoras+=$horaCumpPsc["num_hora"];
                            }
                        }
                    ?>
                    Ha cuplido <strong><?php echo $numHoras;?></strong> horas
                </p>
            </div>
        </div>
         
        
        </fieldset>
        <div id="MensajeSeguimientoPS" style="font-size:14px;"></div>
        
        <fieldset>
        <div class="panel-heading color-sdis">Registro de asistencia a PSC  formato de fecha AAAA-mm-dd</div>
        <div id="MensajeSeguimientoPsc" style="font-size:14px;"></div><br />
                <?php 
                    $formSegPsc=$this->beginWidget('CActiveForm', array(
                        'id'=>'formularioSegAdolPs',
                        'enableAjaxValidation'=>false,
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                        'htmlOptions' => array('class' => 'form-horizontal')
                    ));// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
               ?>
            <?php echo  $formSegPsc->errorSummary($modeloSeguimientoPsc,'','',array('style' => 'font-size:14px;color:#F00')); ?>                       
         
        <div class="form-group">
            <?php echo $formSegPsc->labelEx($modeloAsistenciaPsc,'fecha_asist_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
            <?php 
                $diasSuma	= (strtotime($pscSinCulm[0]["fecha_fin_psc"])-strtotime(date("Y-m-d")))/86400;
                if($diasSuma<=0){
                    $fechaMax=$pscSinCulm[0]["fecha_fin_psc"];
                }
                else{
                    $fechaMax=date("Y-m-d");
                }
            ?>
            <?php //
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array('model'=>$modeloAsistenciaPsc,
                    'attribute'=>'fecha_asist_psc',
                    'value'=>$modeloAsistenciaPsc->fecha_asist_psc,
                    'language'=>'es',
                    'htmlOptions'=>	array('readonly'=>'readonly','class'=>'col-md-4 form-control'),
                    'options'=>array('autoSize'=>true,
                        'defaultDate'=>$modeloAsistenciaPsc->fecha_asist_psc,
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
                        'minDate'=>$pscSinCulm[0]["fecha_inicio_psc"],
                        'maxDate'=>$fechaMax,
                        'onSelect'=>new CJavaScriptExpression("function(a,b){
                            var diasem=".CJavaScript::encode($dias).";	
                            var date=new Date(a);
                            dia=date.getDay();
                            dia=dia+1;
                            if(diasem.indexOf(dia)==-1){
                                jAlert('No puede seleccionar este día pues no corresponde a los asignados para asistencia', 'Mensaje');
                                $('#AsistenciaPsc_fecha_asist_psc').val('');
                            }	
                            else{
                                if($('.'+a).length){
                                    jAlert('Este día ya está seleccionado', 'Mensaje');
                                    $('#AsistenciaPsc_fecha_asist_psc').val('');
                                }
                                else{
                                    var fecha='".$pscSinCulm[0]["id_psc"]."';
                                    $.ajax({
                                        type:'post', //request type
                                        datatype:'json',
                                        data:'date='+a+'&id_psc='+fecha+'&num_doc='+".$numDocAdol.",
                                        url:'".CController::createUrl("compFechaAsistencia")."', //url to call.
                                        beforeSend:function(){
                                            Loading.show();			
                                        },
                                        success:function(datos){
                                            Loading.hide();
                                            var datos = jQuery.parseJSON(datos);
                                            if(datos.resultado=='\'false\''){
                                                $('#AsistenciaPsc_fecha_asist_psc').val('');
                                                jAlert('Esta fecha ya ha sido registrada en un seguimiento anterior', 'Mensaje');
                                            }
                                        },
                                        error:function (xhr, ajaxOptions, thrownError){
                                            Loading.hide();
                                            jAlert(thrownError, 'Mensaje');
                                        }	
                                    });	
                                    
                                }
                            }							
                        }")					
                    ),
                ));
                
                ?>
                    <?php echo CHtml::hiddenField('numFechas','0');?>
                </div>
            </div>  
        <div class="form-group">
            <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
                <div class="col-md-6">            
                    <div align="center" onclick="javascript:agregaFecha();" style=" float:left; cursor:pointer; border:1px solid #000;width:100px;" >Agrega fecha</div>
                </div>
                <div class="col-md-6">
                    <div align="center" onclick="javascript:quitaFecha();" style="float:left; cursor:pointer; border:1px solid #000;width:100px;" >Quita fecha</div>  
                </div>
            </div>
        </div> 
        <div class="form-group">
            <?php echo CHtml::label('Fechas:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
                <div id="divFechas"></div>
            </div>
        </div>  
                <?php echo $formSegPsc->error($modeloAsistenciaPsc,'fecha_asist_psc',array('style' => 'color:#F00'));?>
        
        <div class="form-group">
            <div class="col-md-12">
                <?php echo $formSegPsc->labelEx($modeloSeguimientoPsc,'desarrollo_act_psc');?></br>
                <?php echo $formSegPsc->textArea($modeloSeguimientoPsc,'desarrollo_act_psc',array('class'=>'col-md-12 form-control')) ?>
                <?php echo $formSegPsc->error($modeloSeguimientoPsc,'desarrollo_act_psc',array('style' => 'color:#F00'));?>
            </div>
        </div>    
        <div class="form-group">
            <div class="col-md-12">
                <?php echo $formSegPsc->labelEx($modeloSeguimientoPsc,'reporte_nov_psc');?></br>
                <?php echo $formSegPsc->textArea($modeloSeguimientoPsc,'reporte_nov_psc',array('class'=>'col-md-12 form-control')) ?>
                <?php echo $formSegPsc->error($modeloSeguimientoPsc,'reporte_nov_psc',array('style' => 'color:#F00'));?>
            </div>  
        </div>  
        <div class="form-group">
            <div class="col-md-12">
                <?php echo $formSegPsc->labelEx($modeloSeguimientoPsc,'cump_acu_psc');?></br>
                <?php echo $formSegPsc->textArea($modeloSeguimientoPsc,'cump_acu_psc',array('class'=>'col-md-12 form-control')) ?>
                <?php echo $formSegPsc->error($modeloSeguimientoPsc,'cump_acu_psc',array('style' => 'color:#F00'));?>
            </div>
        </div>       
            <?php /*$micro_date = microtime();
        $date_array = explode(" ",$micro_date);
        $date = date("Y-m-d H:i:s",$date_array[1]); $milisec=explode(".",$date_array[0]);
        echo "Date: $date.".$milisec[1]*/?>
        <div class="form-group">
            <div class="col-md-4">
                <?php $modeloSeguimientoPsc->id_psc=$pscSinCulm[0]["id_psc"];$modeloSeguimientoPsc->num_doc=$numDocAdol;//.$tiempo;?> 
                <?php echo $formSegPsc->hiddenField($modeloSeguimientoPsc,'id_psc');?>
                <?php echo $formSegPsc->hiddenField($modeloSeguimientoPsc,'num_doc');?>
                <?php
                    $boton=CHtml::ajaxSubmitButton (
                        'Registrar Seguimiento',   
                        array('registraSegimientoPSC'),
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
                                        jAlert("Seguimiento registrado satisfactoriamente", "Mensaje");	
                                        //$("#MensajeSeguimientoPS").text("Seguimiento registrado satisfactoriamente");
                                        $("#formularioSegAdolPs #formularioSegAdolPs_es_").html(""); 
                                        //$("#formularioSegAdol #fecha_set_pe").hide(); 
                                    }
                                    else{
                                        jAlert("Ha habido un error en la creación del registro. Código del error: "+datosSeg.resultado, "Mensaje");	
                                        //$("#MensajeSeguimientoPS").text("Ha habido un error en la creación del registro. Código del error: "+datosSeg.resultado);
                                        $("#formularioSegAdolPs #formularioSegAdolPs_es_").html("");                                                    
                                        //$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
                                    }
                                }
                                else{						
                                    $("#btnFormSegPS").show();
                                    var errores="Por favor corrija los siguientes errores<br/><ul>";
                                    $.each(datosSeg, function(key, val) {
                                        errores+="<li>"+val+"</li>";
                                        $("#formularioSegAdolPs #"+key+"_em_").text(val);                                                    
                                        $("#formularioSegAdolPs #"+key+"_em_").show();                                                
                                    });
                                    errores+="</ul>";
                                    $("#formularioSegAdolPs #formularioSegAdolPs_es_").html(errores);                                                    
                                    $("#formularioSegAdolPs #formularioSegAdolPs_es_").show(); 
                                    
                                }
                                
                            }',
                            'error'=>'function (xhr, ajaxOptions, thrownError) {
                                Loading.hide();
                                //0 para error en comunicación
                                //200 error en lenguaje o motor de base de datos
                                //500 Internal server error
                                if(xhr.status==0){
                                    jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema", "Mensaje");	
                                    //$("#MensajeSeguimientoPS").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
                                    $("#btnFormSegPS").show();
                                }
                                else{
                                    if(xhr.status==500){
                                        jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información", "Mensaje");	
                                        //$("#MensajeSeguimientoPS").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
                                    }
                                    else{
                                        jAlert("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado", "Mensaje");	
                                        //$("#MensajeSeguimientoPS").html("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
                                    }	
                                }
                                
                            }'
                        ),
                        array('id'=>'btnFormSegPS','class'=>'btn btn-default btn-sdis','name'=>'btnFormSegPS')
                );
                ?>
                <?php echo $boton; //CHtml::submitButton('Crear');?>
            </div>
        </div>
            
           <?php $this->endWidget()?>
                                
        </fieldset>
        <fieldset>
        <div class="panel-heading color-sdis">Hist&oacute;rico de seguimientos</div>
        <br />
            <table style=" padding:0 0 0 0; margin:0 0 0 0;;width:100%;">
                <tr >
                    <td style="width:75%">
                     <div class="cont-seg">
                        <?php 
                        $segsPsc=$modeloSeguimientoPsc->consSeguimientosPsc();
                        if(!empty($segsPsc)):?>
                            <?php foreach($segsPsc as $pk=>$segPsc):?>
                                <a name="segpsc_<?php echo $pk;?>"><strong>Fecha del seguimiento: <?php echo $segPsc["fecha_seg_ind"] ?>
                               || Institución: <?php echo $segPsc["institucionpsc"]; ?> || Nombre del profesional <?php echo $segPsc["nombrespersona"]?> || Profesión: <?php echo $segPsc["nombre_rol"]?></strong></a><br /><br />
                                <p style="margin:0px 10px 0px 0px"><strong>Desarrollo de actividades:</strong><br /><?php echo CHtml::encode($segPsc["desarrollo_act_psc"]); ?></p>
                                <p style="margin:0px 10px 0px 0px"><strong>Reportes de novedad de la prestación de servicios a la comunidad:</strong><br /><?php echo CHtml::encode($segPsc["reporte_nov_psc"]); ?></p>
                                <p style="margin:0px 10px 0px 0px"><strong>Cumplimiento de acuerdos:</strong><br /><?php echo CHtml::encode($segPsc["cump_acu_psc"]); ?></p> 
                                <br />
                                <hr />
                            <?php endforeach;?>					
                        <?php endif;?>
                    </div>
                    </td>
                    <td valign="top" style="width:20%">
                        <div  class="cont-f-seg">
                            <?php if(!empty($segsPsc)):?>
                                <?php foreach($segsPsc as $pk=>$segPsc): ?>
                                    <a href="#segpsc_<?php echo $pk;?>">Fecha:<?php echo $segPsc["fecha_seg_ind"]; ?></a><br />
                                <?php endforeach;?>					
                            <?php endif;?>
                        </div>
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php Yii::app()->getClientScript()->registerScript('script_asignaref','
                function agregaFecha(){
                    //jAlert($("#AsistenciaPsc_fecha_asist_psc").val(),"epa");
                    if($("#AsistenciaPsc_fecha_asist_psc").length){
                        if($("#AsistenciaPsc_fecha_asist_psc").val().length){
                            if($("."+$("#AsistenciaPsc_fecha_asist_psc").val()).length){
                                jAlert("Este día ya está seleccionado", "Mensaje");						
                                return;
                            }
                            if($("#AsistenciaPsc_fecha_asist_psc").val().length){		
                                var numFechas=parseInt($("#numFechas").val());
                                numFechas+=1;
                                $("#divFechas").append("<div id=\"horaFecha_"+numFechas+"\">Fecha "+$("#AsistenciaPsc_fecha_asist_psc").val()+"</div>");
                                $("form").append("<input type=\"hidden\" id=\"inpFecha_"+numFechas+"\" class=\""+$("#AsistenciaPsc_fecha_asist_psc").val()+"\" value=\""+$("#AsistenciaPsc_fecha_asist_psc").val()+"\" name=\"AsistenciaPsc[inpFecha_"+numFechas+"]\"/>");	
                                $("#numFechas").val(numFechas);
                                $("#AsistenciaPsc_fecha_asist_psc").val("");
                            }
                            else{
                                alert("debe seleccionar una fecha");
                            }
                        }
                    }
                }
                function quitaFecha(){		
                    var numFechas=parseInt($("#numFechas").val());
                    if(numFechas>0){
                        $("#horaFecha_"+numFechas).remove();
                        $("form #inpFecha_"+numFechas).remove();	
                        numFechas-=1;
                        $("#numFechas").val(numFechas);
                    }
                }
            '
        ,CClientScript::POS_END);
        ?>
<?php else:?>
El adolescente no tiene creado un Servicio de Prestación a la Comunidad
<?php endif;?>        