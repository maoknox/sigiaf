<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<div class="panel-heading color-sdis">Modificar Registro</div>

<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('psc/psc/consultarPsc'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)&&!empty($modeloPsc->id_psc)):?>
	<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')):?>
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
        <br />
        <?php echo  $formularioPsc->errorSummary($modeloPsc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
            <div class="form-group">
                <?php echo $formularioPsc->labelEx($modeloPsc,'id_sector_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
                <div class="col-md-4">		
                      <?php echo $infPsc["sector_psc"];?>        
                </div>
           </div>   
        <div class="form-group">
            <?php echo $formularioPsc->labelEx($modeloPsc,'id_institucionpsc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                <?php echo $infPsc["institucionpsc"];?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $formularioPsc->labelEx($modeloPsc,'responsable_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                        <?php echo $modeloPsc->responsable_psc; ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $formularioPsc->labelEx($modeloPsc,'telefono_resp',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                <?php echo $modeloPsc->telefono_resp; ?></br>
            </div>
        </div>
        <div class="form-group">
            <?php echo CHtml::label('Horario de prestación','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                <hr />
                <table border="1px" cellpadding="0" cellspacing="0" id="tabHorarioPres" style=" width:80%">
                    <tr><td>Día</td><td>Hora inicio</td><td>Hora fin</td></tr>
                    <?php 
                        $modeloDiaHora->id_psc=$modeloPsc->id_psc;
                        $modeloDiaHora->num_doc=$modeloPsc->num_doc;
                        $horario=$modeloDiaHora->consultaHorario();
                        if(!empty($horario)){
                            foreach($horario as $horario)://revisar?>
                                <tr>
                                    <td><?php echo $horario["nomb_dia"]?></td>
                                    <td><?php echo $horario["hora_inicio"]."-".$horario["hora_inicio_m"];?></td>
                                    <td><?php echo $horario["hora_fin"]."-".$horario["hora_fin_m"];?></td>
                                </tr>
                            <?php endforeach;
                            
                        }
                    ?>
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
                <?php echo $modeloPsc->fecha_inicio_psc; ?>
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
            <?php echo $formularioPsc->labelEx($modeloPsc,'id_estadopsc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
                <?php 
                    $op[$infPsc["idestado"]]=array('selected'=>true);
                    echo $formularioPsc->dropDownList($modeloPsc,'id_estadopsc',CHtml::listData($estadoPsc,'id_estadopsc','estado_psc'),
                array('options'=>$op,'class'=>'form-control','data-live-search'=>'true'))?>
            </div>
        </div>		
        <div class="form-group">
            <?php echo $formularioPsc->labelEx($modeloPsc,'observaciones_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                <?php echo $modeloPsc->observaciones_psc;?>
            </div>
        </div> 
        <div class="form-group">
            <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                <?php echo $formularioPsc->hiddenField($modeloPsc,'num_doc');?>
                <?php echo $formularioPsc->hiddenField($modeloPsc,'id_psc');?>
                <?php echo $formularioPsc->hiddenField($modeloPsc,'fecha_inicio_psc');?>

                <?php
                    $boton=CHtml::Button (
                        'Actualizar estado',   
                        array('id'=>'btnFormActEstado','class'=>'btn btn-default btn-sdis','name'=>'btnFormActEstado','onclick'=>'js:enviaForm()')
                    );
                ?>
                <?php echo $boton;?>
            </div>
        </div>		
                <?php $this->endWidget();?>
                        
                <?php
                Yii::app()->getClientScript()->registerScript('scripPai_1','
                         function enviaForm(){
                    $.ajax({
                        url: "actEstadoPsc",
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
									jAlert("Datos Modificados satisfactoriamente","Mensaje");
                                    $("#formularioPsc #btnFormCreaPsc").remove();
                                    $("#formularioPsc #formularioPsc_es_").html("");                                                    
                                    $("#formularioPsc #formularioPsc_es_").hide(); 							
                                }
                                else{
                                    $("#MensajePsc").text("Error en la actualización.  Motivo "+datos.resultado);
                                }
                            }
                            else{
                                var errores="Por favor corrija los siguientes errores<br/><ul>";
                                $.each(datos, function(key, val) {
                                    errores+="<li>"+val+"</li>";
                                    $("#formularioPsc #"+key+"_em_").text(val);                                                    
                                    $("#formularioPsc #"+key+"_em_").show();                                                
                                });
                                errores+="</ul>";
                                $("#formularioPsc #formularioPsc_es_").html(errores);                                                    
                                $("#formularioPsc #formularioPsc_es_").show(); 
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
                        <!--<img src="<?php //echo Yii::app()->baseUrl?>/images/centroForjar.png" />-->
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
        
        