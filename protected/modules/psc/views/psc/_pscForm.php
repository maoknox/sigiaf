<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('psc/psc/creaPsc'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>
	<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')):?>
    <div class="panel-heading color-sdis">Prestación de servicios a la comunidad</div> <br />
		<?php
        //print_r($infJudicial);
        $psc=false;
        foreach($infJudicial as $infJudicialPsc){
            if($infJudicialPsc["id_tipo_sancion"]==3){
                $psc=true;
            }
        }
        if($psc==true):?>		
            <?php $formularioPsc=$this->beginWidget('CActiveForm', array(
                'id'=>'formularioPsc',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>false,
                ),
				'htmlOptions' => array('class' => 'form-horizontal')
            ));
            ?>	
        <div id="MensajePsc" style="font-size:14px;"></div>
        <?php echo  $formularioPsc->errorSummary($modeloPsc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
		<div class="form-group">
			<?php echo $formularioPsc->labelEx($modeloPsc,'id_sector_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php 									
                    echo $formularioPsc->dropDownList($modeloPsc,'id_sector_psc',CHtml::listData($sectorPsc,'id_sector_psc','sector_psc'),
                        array(
                            'prompt'=>'Seleccione Sector',
                            'class'=>'selectpicker form-control','data-live-search'=>'false',
							'onChange'=>'js:consOrganizacion(this);$("#formularioPsc").addClass("unsavedForm");',
                        )
                    );						
                ?>  
                <?php echo $formularioPsc->error($modeloPsc,'id_sector_psc',array('style' => 'color:#F00'));?>
        	</div>
       </div>
		<div class="form-group">
			<?php echo $formularioPsc->labelEx($modeloPsc,'id_institucionpsc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4" id="divInst">		
				<?php echo $formularioPsc->dropDownList($modeloPsc,'id_institucionpsc',
					array(''=>'Debe seleccionar un sector'),
                    array(
						'onchange'=>'js:habilitaCampo(this);$("#formularioPsc").addClass("unsavedForm");'
						,'class'=>'form-control','data-live-search'=>'true')
					); ?>
                <?php echo $formularioPsc->error($modeloPsc,'id_institucionpsc',array('style' => 'color:#F00'));?> 
             </div>  
        </div>                       
		<div class="form-group" id="nuevaInst" style="display:none">
			<?php echo $formularioPsc->labelEx($modeloPsc,'nueva_institucionpsc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
                    <?php echo $formularioPsc->textField($modeloPsc,'nueva_institucionpsc',array('class'=>'form-control'));?>
                    <?php echo $formularioPsc->error($modeloPsc,'nueva_institucionpsc',array('style' => 'color:#F00'));?>
            </div>
        </div>    
		<div class="form-group">
			<?php echo $formularioPsc->labelEx($modeloPsc,'responsable_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php echo $formularioPsc->textField($modeloPsc,'responsable_psc',array('class'=>'form-control')); ?>
                <?php echo $formularioPsc->error($modeloPsc,'responsable_psc',array('style' => 'color:#F00'));?>
            </div>
        </div>    
		<div class="form-group">
			<?php echo $formularioPsc->labelEx($modeloPsc,'telefono_resp',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php echo $formularioPsc->textField($modeloPsc,'telefono_resp',array('class'=>'form-control')); ?>
                <?php echo $formularioPsc->error($modeloPsc,'telefono_resp',array('style' => 'color:#F00'));?>
            </div>
        </div>    
		<div class="form-group">
			<?php echo $formularioPsc->labelEx($modeloPsc,'num_dias_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php echo $formularioPsc->dropDownList($modeloPsc,'num_dias_psc',array(
                    '1'=>1,
                    '2'=>2,
                    '3'=>3,
                    '4'=>4,
                    '5'=>5,								
                ),
                array('prompt'=>'Seleccione días','class'=>'form-control','data-live-search'=>'true')
				
                ); ?>
                <?php echo $formularioPsc->error($modeloPsc,'num_dias_psc',array('style' => 'color:#F00'));?> 
            </div>
        </div>    
       	<div class="form-group">
   			<?php echo CHtml::label('Horario de prestación','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
                <hr />
                <table border="1px" cellpadding="0" cellspacing="0" id="tabHorarioPres">
                </table>
            </div>
        </div>    
       	<div class="form-group">
        	<?php echo CHtml::label('Tiempo de la prestación del servicio','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">
              <hr />
         	</div>
        </div>		
       	<div class="form-group">
			<?php echo $formularioPsc->labelEx($modeloPsc,'fecha_inicio_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php //
                        $this->widget('zii.widgets.jui.CJuiDatePicker',
                            array('model'=>$modeloPsc,
                            'attribute'=>'fecha_inicio_psc',
                            'value'=>'',
                            'language'=>'es',
                            'htmlOptions'=>	array('readonly'=>"readonly","class"=>"form-control"),
                            'options'=>array('autoSize'=>true,
                                    'defaultDate'=>'',
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
                                    'minDate'=>'',//fecha minima
                                    'maxDate'=>'',//fecha maxima
                            ),
                        ));
                        
                    ?>
                    <?php echo $formularioPsc->error($modeloPsc,'fecha_inicio_psc',array('style' => 'color:#F00'));?>
            	</div>
        	</div>   
            <div class="form-group">
				<?php echo $formularioPsc->labelEx($modeloPsc,'fecha_fin_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
	                <div class="col-md-4">		
						<?php //
                                $this->widget('zii.widgets.jui.CJuiDatePicker',
                                    array('model'=>$modeloPsc,
                                    'attribute'=>'fecha_fin_psc',
                                    'value'=>'',
                                    'language'=>'es',
                                    'htmlOptions'=>	array('readonly'=>"readonly","class"=>"form-control"),
                                    'options'=>array('autoSize'=>true,
                                            'defaultDate'=>'',
                                            'dateFormat'=>'yy-mm-dd',
                                            'selectOtherMonths'=>true,
                                            'showAnim'=>'slide',
                                            'showOtherMonths'=>true,
                                            'changeMonth'=>'true',
                                            'changeYear'=>'true',
                                            'minDate'=>'',//fecha minima
                                            'maxDate'=>'',//fecha maxima
                                    ),
                                ));
                                
                            ?>
                            <?php echo $formularioPsc->error($modeloPsc,'fecha_fin_psc',array('style' => 'color:#F00'));?>
            	</div>
        	</div>   
            <div class="form-group">
				<?php echo $formularioPsc->labelEx($modeloPsc,'observaciones_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
	        	<div class="col-md-4">		
					<?php echo $formularioPsc->textArea($modeloPsc,'observaciones_psc',array(''=>'Debe seleccionar un sector',"class"=>"form-control")); ?></br>
                    <?php echo $formularioPsc->error($modeloPsc,'observaciones_psc',array('style' => 'color:#F00'));?>
            	</div>
        	</div> 
            <div class="form-group">
   				<?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
	        	<div class="col-md-4">		
					<?php $modeloPsc->num_doc=$numDocAdol;echo $formularioPsc->hiddenField($modeloPsc,'num_doc');?>
					<?php
                    $boton=CHtml::Button (
                        'Registrar',   
                        array('id'=>'btnFormCreaPsc','class'=>'btn btn-default btn-sdis','name'=>'btnFormCreaPsc','onclick'=>'js:enviaForm()')
                    );
                        ?>
                   <?php echo $boton;?>
            	</div>
        	</div> 
                           
        <?php $this->endWidget();?>
        <?php
        Yii::app()->getClientScript()->registerScript('scripPai_1','
		$(document).ready(function(){
			$("#formularioPsc").find(":input").change(function(){
				var dirtyForm = $(this).parents("form");
				// change form status to dirty
				dirtyForm.addClass("unsavedForm");
			});
		});	
		
		var campoText=0;
		$(window).bind("beforeunload", function(){
			if($(".unsavedForm").size()){
				return "va a cerrar";
			}
		});
		function consOrganizacion(objetoSel){
				 var idSector =$("#"+objetoSel.id).find("option:selected").val();
				 var datos="Psc[id_sector_psc]="+idSector;
				 if(idSector!=""){
				 
					 $.ajax({
						url: "consInstitutoPsc",			
						data:datos,
						dataType:"json",
						type: "post",
						beforeSend:function (){Loading.show();},
						success: function(datosResp){
							Loading.hide();
							$("#Psc_id_institucionpsc").empty();
							$.each(datosResp,function(key,val){
								$("#Psc_id_institucionpsc").append($("<option></option>").attr("value", val.valor).text(val.contenido));
							});
						},
						error:function (xhr, ajaxOptions, thrownError){
							Loading.hide();
							alert(thrownError)
						}
					});
				}
				else{
					$("#Psc_id_institucionpsc").empty();	
					$("#Psc_id_institucionpsc").append($("<option></option>").attr("value", "").text("Debe seleccionar un sector"));				
					$("#nuevaInst").hide();
				}
			}		
        function habilitaCampo(campo){
					if(campo.value==0){						
						$("#nuevaInst").show();
					}
					else{
						$("#nuevaInst").hide();	
					}
					
				}
                /*$(window).bind("beforeunload", function(){
                    //return "Va a dejar la página"
                });*/
                $( document ).ready(function(){
                    $("#formularioPsc #Psc_num_dias_psc").change(function (){
                        diasPrestacion($("#formularioPsc #Psc_num_dias_psc option:selected").val(),"tabHorarioPres");
                    });
                    $("#formularioPsc input:checkbox[id=CulmSi]").click(
                        function(){
                            $("#formularioPsc input:checkbox[id=CulmNo]").attr("checked","");
                        }
                    );
                    $("#formularioPsc input:checkbox[id=CulmNo]").click(
                        function(){
                            $("#formularioPsc input:checkbox[id=CulmSi]").attr("checked","");
                        }
                    );
                    $("#formularioPsc #sectorpsc").change(
                        function(){
                            if($("#formularioPsc #sectorpsc option:selected").val()=="0"){
                                $("#formularioPsc #divNuevoSector").css("display","block");
                                $("#formularioPsc input#nuevoSector").attr("class","required");
                                $("#formularioPsc input#nuevoSector").attr("disabled",false);
                                $("#formularioPsc #divNuevInst").css("display","block");
                                $("#formularioPsc input#nuevaInst").attr("class","required");
                                $("#formularioPsc #divInst").css("display","none");
                            }
                            else{
                                $("#formularioPsc #divNuevoSector").css("display","none");
                                $("#formularioPsc #divNuevInst").css("display","none");
                                $("#formularioPsc input#nuevaInst").attr("class","");
                                $("#formularioPsc input#nuevaInst").val("");
                                $("#formularioPsc input#nuevoSector").val("");
                                $("#formularioPsc input#nuevoSector").attr("class","");
                                consultaInstitucion($("#formularioPsc #sectorpsc option:selected").val(),"divInst",interfaz);
                            }
                        }
                    );
                });
                
                function diasPrestacion(numDiasPrestacion,divDias){
                    var tabDias="<tr><td>D\xeda</td><td>Horas</td><td>Hora inicio</td><td>Hora Final</td></tr>";
                        for(var diaPres=0;diaPres<=numDiasPrestacion-1;diaPres++){
                            dia=diaPres+1;
                            tabDias +="<tr><td>Día "+dia+" <select id=\"dia"+dia+"\"  name=\"DiaHora[dia"+dia+"]\" onchange=\"javascript:muestraDia("+dia+",\'horaIniDia"+dia+"\',\'meridHI"+dia+"\',\'horaFinDia"+dia+"\',\'meridHF"+dia+"\',\'horas"+dia+"\');\"  >"+optionDias()+"</select></td>";
                            tabDias +="<td><select id=\"horas"+dia+"\" name=\"DiaHora[horas"+dia+"]\" disabled=disabled>"+optionHoras()+"</select></td>";
                            tabDias +="<td><input id=\"horaIniDia"+dia+"\" name=\"DiaHora[horaIniDia"+dia+"]\" size=\"5px\" disabled=disabled />";	
                            tabDias +="<select id=\"meridHI"+dia+"\" name=\"DiaHora[meridHI"+dia+"]\" disabled=disabled >";	
                            tabDias +="<option value=\"\">seleccione</option><option value=\"a.m\">a.m</option><option value=\"p.m\">p.m</option></select></td>";
                            tabDias +="<td><div id=\"hmfin"+dia+"\"></div><input type=\"hidden\" id=\"horaFinDia"+dia+"\" name=\"DiaHora[horaFinDia"+dia+"]\" size=\"5px\" />";
                            tabDias +="<input type=\"hidden\" id=\"meridHF"+dia+"\"  name=\"DiaHora[meridHF"+dia+"]\" size=\"5px\" /></td></tr>";
        
                        }
                    $("#formularioPsc #"+divDias).find("tr").remove();
                    $("#formularioPsc #"+divDias).append(tabDias);
                }
        function optionDias(){
            var dias ="<option value=\"\">Seleccione un día</option>";
            dias +="<option value=\"1\">Lunes</option>";	
            dias +="<option value=\"2\">Martes</option>";	
            dias +="<option value=\"3\">Miércoles</option>";	
            dias +="<option value=\"4\">Jueves</option>";	
            dias +="<option value=\"5\">Viernes</option>";	
            dias +="<option value=\"6\">Sábado</option>";
			dias +="<option value=\"7\">Domingo</option>";	
            return dias;
        }
        function optionHoras(){
            var horas ="<option value=\"\">Seleccione horas</option>";
            horas +="<option value=\"1\">1</option>";	
            horas +="<option value=\"2\">2</option>";	
            horas +="<option value=\"3\">3</option>";	
            horas +="<option value=\"4\">4</option>";	
            horas +="<option value=\"5\">5</option>";	
            return horas;
        }
        function muestraDia(numDia,objHini,objmeriIni,objHoraFin,objMeriFin,horasDia){
            $("#formularioPsc #horas"+numDia).attr("disabled",false);
            $("#formularioPsc #horas"+numDia).change(function(){
                $("#formularioPsc #horaIniDia"+numDia).attr("disabled",false);
                $("#formularioPsc #horaIniDia"+numDia).keyup(function (){
                        if($("#formularioPsc #horaIniDia"+numDia).val()>=1&&$("#formularioPsc #horaIniDia"+numDia).val()<=12){
                            $("#formularioPsc #meridHI"+numDia).attr("disabled",false);
                            $("#formularioPsc #meridHI"+numDia).change(function (){calculaHoraFin(objHini,objmeriIni,objHoraFin,objMeriFin,horasDia,numDia)});
                        }
                        else{
                            alert("debe digitar una hora en formato a.m - p.m");
                            $("#formularioPsc input#"+objHini).val("");
                        }
                    });
            });
        }
        function calculaHoraFin(objHini,objmeriIni,objHoraFin,objMeriFin,horasDia,numDia){
            varHoraini=$("#formularioPsc input#"+objHini).val()*10/10;
            if($("#formularioPsc #"+objmeriIni+" option:selected").val()==""){
                alert("debe especificar la jornada");
                return;
            }
            else{
                if($("#formularioPsc #"+horasDia+" option:selected").val()==""){
                    alert("debe seleccionar el numero de horas");
                    return;
                }
                else{
                    
                    numHoras = $("#formularioPsc #"+horasDia+" option:selected").val()*10/10;
                    horaFin=varHoraini+numHoras;
                    meriD=$("#formularioPsc #"+objmeriIni+" option:selected").val();
                    if(horaFin>=12){
                        if(meriD=="a.m"){
                            $("#formularioPsc input#"+objMeriFin).val("p.m");
                        }
                        else{
                            $("#formularioPsc input#"+objMeriFin).val("a.m");
                        }
                        horaFin = horaFin-12;
                        if(horaFin==0){horaFin=12;}
                        $("#formularioPsc input#"+objHoraFin).val(horaFin);
                    }
                    else{
                        $("#formularioPsc input#"+objMeriFin).val(meriD);
                        $("#formularioPsc input#"+objHoraFin).val(horaFin);
                    }
                    var horaMFin=horaFin+" "+meriD;
                    $("#formularioPsc #hmfin"+numDia).text(horaMFin);
                }
            }
        }
        function enviaForm(){
            $.ajax({
                url: "regPsc",
                data:$("#formularioPsc").serialize(),
                dataType:"json",
                type: "post",
                beforeSend:function (){Loading.show();},
                success: function(datos){
                    Loading.hide();
                    if(datos.estadoComu=="exito"){
                        $("#formularioPsc #formularioPsc_es_").html("");                                                    
                        $("#formularioPsc #formularioPsc_es_").hide(); 
                        if(datos.resultado=="\'exito\'"){
                            $("#MensajePsc").text("exito");
							jAlert("PSC registrada","Mensaje");
                            $("#formularioPsc #btnFormCreaPsc").remove();
                            $("#formularioPsc #formularioPsc_es_").html("");                                                    
                            $("#formularioPsc #formularioPsc_es_").hide(); 	
							$("#formularioPsc").removeClass("unsavedForm");						
                        }
                        else{
                            $("#MensajePsc").text("Error en la creación del registro.  Motivo "+datos.resultado);
                        }
                    }
                    else{
                        var errores="Por favor tenga en cuenta lo siguiente<br/><ul>";
                        $.each(datos, function(key, val) {
                            errores+="<li>"+val+"</li>";
                            $("#formularioPsc #"+key+"_em_").text(val);                                                    
                            $("#formularioPsc #"+key+"_em_").show();                                                
                        });
                        errores+="</ul>";
                        $("#formularioPsc #formularioPsc_es_").html(errores);                                                    
                        $("#formularioPsc #formularioPsc_es_").show(); 
						jAlert(errores,"Mensaje");
                    }
                },
                error:function (xhr, ajaxOptions, thrownError){
                    Loading.hide();
                    //0 para error en comunicación
                    //200 error en lenguaje o motor de base de datos
                    //500 Internal server error
                    if(xhr.status==0){
                        $("#MensajePsc").text("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
                    }
                    else{
                        if(xhr.status==500){
                            $("#MensajePsc").text("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
                        }
                        else{
                            $("#MensajePsc").text("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
                        }	
                    }	
                }
            });
        }		
        '
        ,CClientScript::POS_END);
        
        ?>     
            <?php else:?>
                El adolescente no tiene una sanción de Prestación de servicios a la comunidad.
            <?php endif;?>
	<?php else:?>
        <hr />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    Mensaje
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-3 text-center">
                        <img src="<?php echo Yii::app()->baseUrl?>/images/centroForjar.png" />
                    </div>
                    <div class="col-lg-9 text-justify">
                        <?php echo Yii::app()->user->getFlash('verifEstadoAdolForjar'); ?>
                    </div>
                </div>
            </div>
        </div>
        <hr />
	<?php endif;?>	
<?php endif?>   
        
        