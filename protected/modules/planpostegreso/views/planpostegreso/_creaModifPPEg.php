<?php if(!empty($numDocAdol)):?>
	<?php if($modeloPAI->culminacion_pai==1):?>
    	<?php foreach($infJudicial as $procJudicial):
			$sancion=false;
			if($procJudicial["id_proc_jud"]==4){
				$sancion=true;
			}	     
		endforeach;?>   
        <?php if($sancion==true):?> 
			<?php $formularioPlanPE=$this->beginWidget('CActiveForm', array(
                'id'=>'formularioPlanPE',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>false,
                ),
            ));
            ?>
            <?php if(!empty($planPEgreso)){$nombreBoton="Modificar";$accion="registraPlanPe('modificarPlanPe')";}else{$nombreBoton="Registrar";$accion="registraPlanPe('crearPlanPe')";}?>	    
       		<div class="panel-heading color-sdis">Plan Post-egreso</div><br />
            <?php echo  $formularioPlanPE->errorSummary($modeloPlanPe,'','',array('style' => 'font-size:14px;color:#F00')); ?>
                <div id="MensajePPEg" style="font-size:14px;" ></div>
                <div class="form-group">
            		
            		<div class="col-md-12">
<!--                    <a  href="javascript:abreAyuda('concEgr')"  onmousemover="javascript:abreAyuda('concEgr')" >ayuda</a>
-->                    <div id="concEgr" style="display:none;"></div>
						<?php echo $formularioPlanPE->labelEx($modeloPlanPe,'concepto_egreso',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
                        <?php echo $formularioPlanPE->textArea($modeloPlanPe,"concepto_egreso",array('class'=>'form-control')); ?>
                        <?php echo $formularioPlanPE->error($modeloPlanPe,'concepto_egreso',array('style' => 'color:#F00'));?>
                	</div> 
                </div>   
                <div class="form-group">    
            		<div class="col-md-12">
<!--                    <a  href="javascript:abreAyuda('concEgr')"  onmousemover="javascript:abreAyuda('concEgr')" >ayuda</a>
-->                    <div id="concEgr" style="display:none;"></div>
						<?php echo $formularioPlanPE->labelEx($modeloPlanPe,'proyeccion_pegreso',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
                        <?php echo $formularioPlanPE->textArea($modeloPlanPe,"proyeccion_pegreso",array('class'=>'form-control')); ?>
                        <?php echo $formularioPlanPE->error($modeloPlanPe,'proyeccion_pegreso',array('style' => 'color:#F00'));?>
               </div></div>              
            <?php 
                echo $formularioPlanPE->hiddenField($modeloPlanPe,'id_planpostegreso');
                echo $formularioPlanPE->hiddenField($modeloPlanPe,'id_pai');
                $modeloPlanPe->num_doc=$numDocAdol;
                echo $formularioPlanPE->hiddenField($modeloPlanPe,'num_doc');
                echo CHtml::Button (
                    $nombreBoton,   
                    array('id'=>'btnPlanPe','class'=>'btn btn-default btn-sdis','name'=>'btnPlanPe','onclick'=>'javascript:'.$accion.';')
                );
                $this->endWidget();?>
            <?php
				//print_r($planPEgreso);
				//print_r($accionesEgreso);
			 $muestraAcc="block";$$btnDis="block"; if(!empty($planPEgreso)):$muestraAcc="block";$numAcc=0;$btnDis=false;?>       
            <?php else:$muestraAcc="none";$muestraBtnAgAcc="none";$numAcc=0;$btnDis=false;?>
                <div id="mensajeAcc">Debe crear primero el concepto al egreso y proyección para realizar las acciones al post-egreso</div>
            <?php endif;?>
            <?php if(!empty($planPEgreso) && empty($accionesEgreso)): $btnDis=true; endif;?>
            <div id="formAccPPEg" style="display:<?php echo $muestraAcc;?>;">
                <div id="MensajeAccPeg" style="font-size:14px;" ></div>
                    <table cellpadding="0px" cellspacing="0px" style="border-collapse:collapse; border:1px solid #006; width:100%">
                        <tr>
                            <td style="border:1px solid #006; width:20%;">OBJETIVO</td>
                            <td style="border:1px solid #006; width:20%;">ACTIVIDADES</td>
                            <td style="border:1px solid #006; width:10%;">TIEMPO </td>
                            <td style="border:1px solid #006; width:20%;">FUENTE DE VERIFICACIÓN</td>
                            <td style="border:1px solid #006; width:20%;">RESPONSABLE</td>
                            <td style="border:1px solid #006; width:10%;"></td>
                        </tr>
                    </table>                                       
                    <?php if(empty($accionesEgreso)):$accionesEgreso[0]=1;$funcion="registraAccPeg(this,this.form,'creaAccPEg');"?>
                        <?php else:$funcion="registraAccPeg(this,this.form,'modAccPEg')";?><?php endif;?>
                        <?php foreach($accionesEgreso as $pk=>$accionEgreso):$numAcc=$pk;$modeloAccEgr->attributes=$accionEgreso;?>
                            <?php $formularioAccPPEg=$this->beginWidget('CActiveForm', array(
                                'id'=>'formularioAccPPEg_'.$numAcc,
                                'enableAjaxValidation'=>false,
                                'enableClientValidation'=>true,
                                'clientOptions'=>array(
                                    'validateOnSubmit'=>false,
                                ),
                            ));
                        ?>
                        <?php echo  $formularioAccPPEg->errorSummary($modeloAccEgr,'','',array('style' => 'font-size:14px;color:#F00')); ?>
                         <table cellpadding="0px" cellspacing="0px" style="border-collapse:collapse; border:1px solid #006; width:100%">
                            <tr>
                                <td style="border:1px solid #006; width:20%;">
                                    <?php echo $formularioAccPPEg->textArea($modeloAccEgr,"objetivo_acceg"); ?>
                                    <?php echo $formularioAccPPEg->error($modeloAccEgr,"objetivo_acceg",array("style" => "color:#F00"));?> 
                                </td>
                                <td style="border:1px solid #006; width:20%;">
                                    <?php echo $formularioAccPPEg->textArea($modeloAccEgr,"actividaes_acceg"); ?>
                                    <?php echo $formularioAccPPEg->error($modeloAccEgr,"actividaes_acceg",array("style" => "color:#F00"));?> 
                                </td>
                                <td style="border:1px solid #006; width:10%;">
                                    <?php echo $formularioAccPPEg->textArea($modeloAccEgr,"tiempo_acceg"); ?>
                                    <?php echo $formularioAccPPEg->error($modeloAccEgr,"tiempo_acceg",array("style" => "color:#F00"));?> 
                                </td>
                                <td style="border:1px solid #006; width:20%;">
                                    <?php echo $formularioAccPPEg->textArea($modeloAccEgr,"fuente_verif_acceg"); ?>
                                    <?php echo $formularioAccPPEg->error($modeloAccEgr,"fuente_verif_acceg",array("style" => "color:#F00"));?> 
                                </td>
                                <td style="border:1px solid #006; width:20%;">
                                    <?php echo $formularioAccPPEg->textArea($modeloAccEgr,"responsable_acceg"); ?>
                                    <?php echo $formularioAccPPEg->error($modeloAccEgr,"responsable_acceg",array("style" => "color:#F00"));?> 
                                </td>
    
                                <td style="border:1px solid #006; width:10%;">
                                    <?php 
                                        $modeloAccEgr->num_doc=$numDocAdol;
                                        $modeloAccEgr->id_pai=$modeloPlanPe->id_pai;
                                        $modeloAccEgr->id_planpostegreso=$modeloPlanPe->id_planpostegreso;
                                        if(!empty($accionEgreso["id_acceg"])){
                                            $modeloAccEgr->id_acceg=$accionEgreso["id_acceg"];
                                            echo $formularioAccPPEg->hiddenField($modeloAccEgr,"id_acceg");
                                        }
                                        echo $formularioAccPPEg->hiddenField($modeloAccEgr,"id_planpostegreso");
                                        echo $formularioAccPPEg->hiddenField($modeloAccEgr,"id_pai");
                                        echo $formularioAccPPEg->hiddenField($modeloAccEgr,"num_doc");
                                        echo CHtml::Button (
                                            "Registrar",   
                                            array("id"=>"btnRegAccion_".$numAcc,'class'=>'btn btn-default btn-sdis',"name"=>"btnRegAccion_".$numAcc,"onclick"=>$funcion)
                                        );
    
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <?php $this->endWidget();?>	
                    <?php endforeach;?>                                                            
                </div>
            <?php 
                $modeloAccEgr->num_doc=$numDocAdol;
                $modeloAccEgr->id_pai=$modeloPlanPe->id_pai;
                echo $formularioAccPPEg->hiddenField($modeloAccEgr,"id_pai");
                echo $formularioAccPPEg->hiddenField($modeloAccEgr,"num_doc");
                echo CHtml::hiddenField("idPlanPe",$modeloPlanPe->id_planpostegreso);    ?>
            <?php 
                echo CHtml::Button (
                    'Agregar otro registro',   
                    array('id'=>'btnAgrReg','class'=>'btn btn-default btn-sdis','name'=>'btnAgrReg','onclick'=>'javascript:agregarRegistro('.$modeloAccEgr->num_doc.','.$modeloAccEgr->id_pai.')','style'=>'display:'.$muestraBtnAgAcc,'disabled'=>$btnDis)
                );
            ?>
            <?php echo CHtml::hiddenField("numAccPeeg",$numAcc);?>
            <?php            
             Yii::app()->getClientScript()->registerScript('script_ppeg_1','
                    function abreAyuda(idAyuda){
                        $("#"+idAyuda).dialog("open");
                    }
                    function  registraPlanPe(accion){
                        $.ajax({
                            url: accion,
                            data:$("#formularioPlanPE").serialize(),
                            dataType:"json",
                            type: "post",
                            beforeSend:function (){$("#btnPlanPe").hide();Loading.show();},
                            success: function(datos){
                                Loading.hide();
                                if(datos.estadoComu=="exito"){
                                    //$("#"+btnForm).css("color","#000");
                                    if(datos.resultado=="\'exito\'"){
                                        $("#MensajePPEg").text("exito");										
                                        $("#formAccPPEg").show("slow");
                                        if(accion==\'crearPlanPe\'){
                                            $("#btnAgrReg").attr("disabled",true);
                                            $("#btnAgrReg").show();
                                            $("#AccionesEgreso_id_planpostegreso").val(datos.idPlanpostegreso);
                                            $("#idPlanPe").val(datos.idPlanpostegreso);
                                        }
                                        $("#formularioPlanPE #formularioPlanPE_es_").html("");                                                    
                                        $("#formularioPlanPE #formularioPlanPE_es_").hide(); 
                                    }
                                    else{
                                        $("#MensajePPEg").text("Error en la creación del registro.  Motivo "+datos.resultado);
                                    }
                                }
                                else{
                                    $("#btnPlanPe").show();
                                    var errores="Por favor corrija lo siguiente<br/><ul>";
                                    $.each(datos, function(key, val) {
                                        errores+="<li>"+val+"</li>";
                                        $("#formularioPlanPE #"+key+"_em_").text(val);                                                    
                                        $("#formularioPlanPE #"+key+"_em_").show();                                                
                                    });
                                    errores+="</ul>";
                                    $("#formularioPlanPE #formularioPlanPE_es_").html(errores);                                                    
                                    $("#formularioPlanPE #formularioPlanPE_es_").show();                                     
                                }
                            },
                            error:function (xhr, ajaxOptions, thrownError){
                                Loading.hide();
                                //0 para error en comunicación
                                //200 error en lenguaje o motor de base de datos
                                //500 Internal server error
                                if(xhr.status==0){
                                    $("#MensajePPEg").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
                                }
                                else{
                                    if(xhr.status==500){
                                        $("#MensajePPEg").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
                                    }
                                    else{
                                        $("#MensajePPEg").text("No se ha creado el registro debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
                                    }	
                                }	
                            }
                        });						
                    }
                    function registraAccPeg(idBoton,idForm,accion){
                        var numForm=idForm.id.split("_");
                        //alert(numForm[1]);return;
                        $.ajax({
                            url: accion,
                            data:$("#"+idForm.id).serialize(),
                            dataType:"json",
                            type: "post",
                            beforeSend:function (){$("#"+idBoton.id).attr("disabled",true);Loading.show();},
                            success: function(datos){
                                Loading.hide();
                                if(datos.estadoComu=="exito"){
                                    //$("#"+btnForm).css("color","#000");
                                    if(datos.resultado=="\'exito\'"){
                                        if(accion==\'creaAccPEg\'){
                                            $("#"+idBoton.id).attr("disabled",false);
                                            $("#"+idBoton.id).removeAttr("onclick");
                                            $("#"+idBoton.id).click(
                                                function(){
                                                    registraAccPeg(idBoton,idForm,\'modAccPEg\');	
                                                }
                                            );
                                        }
                                        $("#MensajeAccPeg").text("exito");										
                                        $("#btnAgrReg").attr("disabled",false);
                                        $("#formularioAccPPEg_"+numForm[1]+" #formularioAccPPEg_"+numForm[1]+"_es_").html("");                                                 
                                        $("#formularioAccPPEg_"+numForm[1]+" #formularioAccPPEg_"+numForm[1]+"_es_").hide();                                                 
                                    }
                                    else{
                                        $("#MensajeAccPeg").text("Error en la creación del registro.  Motivo "+datos.resultado);
                                    }
                                }
                                else{
                                    $("#"+idBoton.id).attr("disabled",false);
                                    var errores="Por favor corrija los siguientes errores<br/><ul>";
                                    $.each(datos, function(key, val) {
                                        errores+="<li>"+val+"</li>";
                                    });
                                    errores+="</ul>";
                                    $("#formularioAccPPEg_"+numForm[1]+" #formularioAccPPEg_"+numForm[1]+"_es_").html(errores);                                                 
                                    $("#formularioAccPPEg_"+numForm[1]+" #formularioAccPPEg_"+numForm[1]+"_es_").show();                                                 
                                    $("#MensajeAccPeg").text("no exito");
                                }
                            },
                            error:function (xhr, ajaxOptions, thrownError){
                                Loading.hide();
                                //0 para error en comunicación
                                //200 error en lenguaje o motor de base de datos
                                //500 Internal server error
                                if(xhr.status==0){
                                    $("#MensajePPEg").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
                                }
                                else{
                                    if(xhr.status==500){
                                        $("#MensajePPEg").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
                                    }
                                    else{
                                        $("#MensajePPEg").text("No se ha creado el registro debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
                                    }	
                                }	
                            }
                        });						
                    }
                    function agregarRegistro(numDoc,idPai){
                        $("#btnAgrReg").attr("disabled",true);
                        var numAcc=$("#numAccPeeg").val();
                        var idPlanPe=$("#idPlanPe").val();
                        numAcc=parseInt(numAcc)+1;
                        $("#numAccPeeg").val(numAcc);
                        //alert(numAcc);						
                        var formAcc="<form id=\"formularioAccPPEg_"+numAcc+"\"  method=\"post\">";
                        formAcc=formAcc+"<div id=\"formularioAccPPEg_"+numAcc+"_es_\" class=\"errorSummary\" style=\"font-size:14px;color:#F00;display:none\"></div>";
                        formAcc=formAcc+"<table cellpadding=\"0px\" cellspacing=\"0px\" style=\"border-collapse:collapse; border:1px solid #006; width:100%\"><tr>";
                        formAcc=formAcc+"<td style=\"border:1px solid #006; width:20%;\">";
                        formAcc=formAcc+"<textarea name=\"AccionesEgreso[objetivo_acceg]\" id=\"AccionesEgreso_objetivo_acceg\"></textarea>";
                        formAcc=formAcc+"</td>";
                        formAcc=formAcc+"<td style=\"border:1px solid #006; width:20%;\">";
                        formAcc=formAcc+"<textarea name=\"AccionesEgreso[actividaes_acceg]\" id=\"AccionesEgreso_actividaes_acceg\"></textarea>";
                        formAcc=formAcc+"</td>";
                        formAcc=formAcc+"<td style=\"border:1px solid #006; width:20%;\">";
                        formAcc=formAcc+"<textarea name=\"AccionesEgreso[tiempo_acceg]\" id=\"AccionesEgreso_tiempo_acceg\"></textarea>";
                        formAcc=formAcc+"</td>";
                        formAcc=formAcc+"<td style=\"border:1px solid #006; width:20%;\">";
                        formAcc=formAcc+"<textarea name=\"AccionesEgreso[fuente_verif_acceg]\" id=\"AccionesEgreso_fuente_verif_acceg\"></textarea>";
                        formAcc=formAcc+"</td>";
                        formAcc=formAcc+"<td style=\"border:1px solid #006; width:20%;\">";
                        formAcc=formAcc+"<textarea name=\"AccionesEgreso[responsable_acceg]\" id=\"AccionesEgreso_responsable_acceg\"></textarea>";
                        formAcc=formAcc+"</td>";
                        formAcc=formAcc+"<td style=\"border:1px solid #006; width:20%;\">";
                        formAcc=formAcc+"<input id=\"AccionesEgreso_id_planpostegreso\" type=\"hidden\" name=\"AccionesEgreso[id_planpostegreso]\" value=\""+idPlanPe+"\">";
                        formAcc=formAcc+"<input name=\"AccionesEgreso[id_pai]\" id=\"AccionesEgreso_id_pai\" type=\"hidden\" value=\""+idPai+"\" />";
                        formAcc=formAcc+"<input name=\"AccionesEgreso[num_doc]\" id=\"AccionesEgreso_num_doc\" type=\"hidden\" value=\""+numDoc+"\" />";
                        formAcc=formAcc+"<input id=\"btnRegAccion_"+numAcc+"\" name=\"btnRegAccion_"+numAcc+"\" type=\"button\" value=\"Registrar\" onclick=\"javascript:registraAccPeg(this,this.form,\'creaAccPEg\');\" />";
                        formAcc=formAcc+"<input id=\"quitaReg_"+numAcc+"\" name=\"quitaReg_"+numAcc+"\" type=\"button\" value=\"Quitar\" onclick=\"javascript:quitarRegAcc("+numAcc+")\"/>";
                        formAcc=formAcc+"</td></tr></table> </form>";
                        $("#formAccPPEg").append(formAcc);	
                    }
                    function quitarRegAcc(numAcc){
                        $("#formularioAccPPEg_"+numAcc).remove();
                        numAcc=parseInt(numAcc)-1;
                        $("#numAccPeeg").val(numAcc);
                        $("#btnAgrReg").attr("disabled",false);
                    }
                '
            ,CClientScript::POS_END);
            ?>
       	<?php else:?>
        	<div>El adolescente no tiene un proceso con sanción</div>
        <?php endif;?>
    <?php else:?>
    	<div>El adolesente no ha culminado el preceso de sanción, por tanto no puede realizar el plan post-egreso</div>
    <?php endif;?>
<?php endif;?>