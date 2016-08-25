<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/perfilOcupacionalForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>

<?php if(!empty($numDocAdol)):?>
	<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')):?>
		<?php if(!empty($valTO)):?>
			<fieldset id="perfilOcupacional">
                <div class="panel-heading color-sdis">PERFIL OCUPACIONAL</div> 
                <table border="1px" cellpadding="0px" cellspacing="0px" style="border-collapse:collapse;margin:0px 0px 0px 0px; padding:0px 0px 0px 0px;width:100%;" id="tabPerfOc" name="tabPerfOc">
                <tr>
                <td rowspan="2" style="border:1px solid #000000" width="20%">Aspecto</td>
                <td rowspan="2" style="border:1px solid #000000" width="20%">Factor</td>
                <td colspan="5" style="border:1px solid #000000" width="20%">Grados</td>
                <td rowspan="2" style="border:1px solid #000000" width="20%">Observaciones</td>
                <td rowspan="2" style="border:1px solid #000000" width="10%">Porcentaje</td>
                <td rowspan="2" style="border:1px solid #000000" width="10%">Guardar</td>
                </tr>
                <tr>
                <td align="center" style="border:1px solid #000000">0</td>
                <td align="center" style="border:1px solid #000000">1</td>
                <td align="center" style="border:1px solid #000000">2</td>
                <td align="center" style="border:1px solid #000000">3</td>
                <td align="center" style="border:1px solid #000000">4</td>                
                </tr>	
                </table>
                <?php
					$gradosFactor=array();
					$gradosFactor=$modeloAspectoValTO->consultaGradoFactor();					
				?>
                <?php foreach($aspectosPerfOc as $aspectoPerfOc):?>
                 <?php 
					$modeloAspectoValTO->id_aspecto_perfoc=$aspectoPerfOc["id_aspecto_perfoc"];
					$factoresPerfOcAspVto=$modeloAspectoValTO->consultaFactorPerfOc();
					$aspectoValToAdol=$modeloAspectoValTO->consultaAspectoValTo();
					$modeloFactorVteo->id_aspectovteo=$aspectoValToAdol["id_aspectovteo"];
				?>
                
                <?php
					$formPerfilOc=""; 
					$formPerfilOc=$this->beginWidget('CActiveForm', array(
					'id'=>'form'.$aspectoValToAdol["id_aspectovteo"],
					'enableAjaxValidation'=>false,
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>false,
					),
					'htmlOptions' => array('class' => 'form-horizontal')
				));
				?>
                <table border="1px" cellpadding="0px" cellspacing="0px" style="border-collapse:collapse;margin:0px 0px 0px 0px; padding:0px 0px 0px 0px;width:100%;" id="tabPerfOc" name="tabPerfOc">
                <tr>
                	<td width="20%" rowspan="<?php echo count($factoresPerfOcAspVto)?>"  style="border:1px solid #000000"><?php echo $aspectoPerfOc["aspecto_perfoc"];?></td>
                    <td width="20%" style="border:1px solid #000000"><?php echo $factoresPerfOcAspVto[0]["factor_perfoc"]?></td>
                    <?php foreach ($gradosFactor as $gradoFactor):?>
                    	<?php 
							$select=false;
							$color="";
						?>
                        <?php 
							$modeloFactorVteo->id_gradofact=$gradoFactor["id_gradofact"];
							$modeloFactorVteo->id_factorperfoc=$factoresPerfOcAspVto[0]["id_factorperfoc"];
							$resConsGradoFactor=$modeloFactorVteo->consGradoFactor();
							if(!empty($resConsGradoFactor)){
								$select='true';
								$color="background-color:#FC9;";
							}
						?>
                    	<td width="4%" align="center" style="<?php echo $color ?>"><?php echo CHtml::radioButton("factorGrado"."[".$factoresPerfOcAspVto[0]["id_factorperfoc"]."]", $select, array('value'=>$gradoFactor["id_gradofact"], 'id'=>$aspectoPerfOc["id_aspecto_perfoc"]."_".$factoresPerfOcAspVto[0]["id_factorperfoc"]."_".$gradoFactor["grado_factor"])); ?></td>
                    <?php endforeach ?>
                    <td width="20%" rowspan="<?php echo count($factoresPerfOcAspVto)?>"  style="border:1px solid #000000">
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo CHtml::textarea('obsAspectoValTO',$aspectoValToAdol["observacion_aspecto"],array('class'=>'form-control'));?>
                            </div>
                        </div>    
                    </td>
                    <td width="10%" rowspan="<?php echo count($factoresPerfOcAspVto)?>" id="porcentaje<?php echo $aspectoValToAdol["id_aspectovteo"] ?>"  style="border:1px solid #000000"><?php echo $aspectoValToAdol["porcentaje_factor"]?></td>
                    <td width="10%" rowspan="<?php echo count($factoresPerfOcAspVto)?>"  style="border:1px solid #000000">
                    <?php
						echo $formPerfilOc->hiddenField($modeloFactorVteo,"id_aspectovteo");
						$boton=CHtml::Button (
							'Registrar',   
							array('id'=>'btnPerfOc'.$aspectoPerfOc["id_aspecto_perfoc"],'class'=>'btn btn-default btn-sdis','name'=>'btnFormUbArInt'.$aspectoPerfOc["id_aspecto_perfoc"],'onclick'=>'js:guardaAspFacAdol("'.count($factoresPerfOcAspVto).'","'.$aspectoValToAdol["id_aspectovteo"].'","'.count($gradosFactor).'","'.$modeloAspectoValTO->id_valor_teo.'","'.$aspectoPerfOc["id_aspecto_perfoc"].'","'.$factoresPerfOcAspVto[0]["id_factorperfoc"].'")')
						);
						echo $boton;
					?>
                    </td>                	
                </tr>
                <?php foreach($factoresPerfOcAspVto as $pk=>$factorPerfOcAspVto):?>  
                  	<?php if($pk>0):?>
                      <tr> 
                      	<td  style="border:1px solid #000000"><?php echo $factorPerfOcAspVto["factor_perfoc"]?></td>                            
						<?php foreach ($gradosFactor as $gradoFactor):?>
							<?php 
                                $select=false;
								$color="";
                            ?>
                            <?php 
                                $modeloFactorVteo->id_gradofact=$gradoFactor["id_gradofact"];
                                $modeloFactorVteo->id_factorperfoc=$factorPerfOcAspVto["id_factorperfoc"];
                                $resConsGradoFactor=$modeloFactorVteo->consGradoFactor();
                                if(!empty($resConsGradoFactor)){
                                    $select='true';
									$color="background-color:#FC9;";
                                }
                            ?>
                            <td align="center" style="<?php echo $color;?>"><?php echo CHtml::radioButton("factorGrado"."[".$factorPerfOcAspVto["id_factorperfoc"]."]", $select, array('value'=>$gradoFactor["id_gradofact"], 'id'=>$aspectoPerfOc["id_aspecto_perfoc"]."_".$factorPerfOcAspVto["id_factorperfoc"]."_".$gradoFactor["grado_factor"])); ?></td>
                        <?php endforeach ?>
                       </tr>
                   	<?php endif;?>                    
                	<?php endforeach;?>
                    </table>
                    <?php $this->endWidget();?>
                <?php endforeach;?>
                </table>
		</fieldset>
<?php
Yii::app()->getClientScript()->registerScript('scriptPerfilOcup','
	$(document).ready(function(){
		$("#perfilOcupacional").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
		$(window).bind("beforeunload", function(){
            if($(".unsavedForm").size()){
                return "va a cerrar";
            }
        });
	});	
	
	
function guardaAspFacAdol(numFactores,idAspVteoAdol,numGrados,idValorTo,idAspectoPerfOc,idFactorPerfOc){
	var j=0;
	var vecFactor=new Array();
	var vecGrado = new Array();
	var factorGrado=0;
	var porcentajeAsp=0;
	var totPorcentaje=0;
	totPorcentaje=numFactores*5;
	//$("#form"+idAspVteoAdol).serialize()
	$("#form"+idAspVteoAdol+" input[type=\'radio\']:checked").each(function(){
		factorGrado=factorGrado+parseInt($(this).val());	
	});
	//jAlert(factorGrado);
	//jAlert($("#form"+idAspVteoAdol+" input:radio[name=\'1[1]\']").is(":checked"));
	//jAlert(idFactorPerfOc);return;
	totalFactores=idFactorPerfOc+numFactores;
	if(factorGrado>0){
		porcentajeAsp=(factorGrado*100)/totPorcentaje;
		$("#porcentaje"+idAspVteoAdol).text(porcentajeAsp.toFixed(2));
		//jAlert("porcentaje del aspecto es: "+porcentajeAsp.toFixed(2));
		var variables=$("#form"+idAspVteoAdol).serialize()+"&idValorTo="+idValorTo+"&idAspVteoAdol="+idAspVteoAdol+"&porcentaje="+porcentajeAsp.toFixed(2);
		$.ajax({
			url: "registraAspectoValTo",
			data:variables,
			dataType:"json",
			type: "post",
			beforeSend:function (){Loading.show();},
			success: function(datos){
				Loading.hide();
				if(datos.estadoComu=="exito"){
					if(datos.resultado=="exito"){
						jAlert("Registro exitoso","Mensaje");
						$("#perfilOcupacional").removeClass("has-warning");		
						 $("#form"+idAspVteoAdol).removeClass("unsavedForm");					
					}
					else{
						jAlert("Error en la creación del registro.  Motivo "+datos.resultado,"Mensaje");
					}
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Loading.hide();
				//0 para error en comunicación
				//200 error en lenguaje o motor de base de datos
				//500 Internal server error
				if(xhr.status==0){
					jAlert("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema","Mensaje");
				}
				else{
					if(xhr.status==500){
						jAlert("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información","Mensaje");
					}
					else{
						jAlert("No se ha creado el registro \n"+xhr.responseText+" Comuníquese con el ingeniero encargado","Mensaje");
					}	
				}	
			}
		});
	}
	else{
		jAlert("Debe realizar la selección de grados por factor");
	}
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
                        El adolescente aún no tiene una valoración creada.
                    </div>
                </div>
            </div>
        </div>
        <hr />
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

<?php endif;?>