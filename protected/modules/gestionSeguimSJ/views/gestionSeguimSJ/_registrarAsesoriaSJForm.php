<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('gestionSeguimSJ/gestionSeguimSJ/registrarAsesoriaSJForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<div class="panel-heading color-sdis">Registrar gestión</div><br />
<?php if(!empty($numDocAdol)): ?>
	<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')): ?>
		<?php $formularioRegGestSJ=$this->beginWidget('CActiveForm', array(
				'id'=>'formularioRegGestionSJ',
				'enableAjaxValidation'=>false,
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
				'htmlOptions' => array('class' => 'form-horizontal')
			));
		?>	
        <?php echo  $formularioRegGestSJ->errorSummary($modeloGestionSJ,'','',array('style' => 'font-size:14px;color:#F00')); ?>
		<div class="form-group">
			<?php echo $formularioRegGestSJ->labelEx($modeloGestionSJ,'id_motivoasesoriasj',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php 									
                    echo $formularioRegGestSJ->dropDownList($modeloGestionSJ,'id_motivoasesoriasj',CHtml::listData($motivoAsesoria,'id_motivoasesoriasj','motivo_asesoriasj'),
                        array(
                            'prompt'=>'Seleccione motivo',
                            'class'=>'selectpicker form-control','data-live-search'=>'true',
							'onChange'=>'js:$("#formularioRegGestionSJ").addClass("unsavedForm");'
							//'onChange'=>'js:consOrganizacion(this)',
                        )
                    );						
                ?>  
                <?php echo $formularioRegGestSJ->error($modeloGestionSJ,'id_motivoasesoriasj',array('style' => 'color:#F00'));?>
        	</div>
       </div>
       <div class="form-group">
			<?php echo $formularioRegGestSJ->labelEx($modeloGestionSJ,'id_remisionsj',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php 									
                    echo $formularioRegGestSJ->dropDownList($modeloGestionSJ,'id_remisionsj',CHtml::listData($remisionA,'id_remisionsj','remision_sj'),
                        array(
                            'prompt'=>'Seleccione a donde remite',
                            'class'=>'selectpicker form-control','data-live-search'=>'true',
							'onChange'=>'js:$("#formularioRegGestionSJ").addClass("unsavedForm");habDeshCampos(this);'
							//'onChange'=>'js:consOrganizacion(this)',
                        )
                    );						
                ?>  
                <?php echo $formularioRegGestSJ->error($modeloGestionSJ,'id_remisionsj',array('style' => 'color:#F00'));?>
        	</div>
       </div>
       <div class="form-group">
			<?php echo $formularioRegGestSJ->labelEx($modeloGestionSJ,'dependencia_entidadsj',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php 									
                    echo $formularioRegGestSJ->textField($modeloGestionSJ,'dependencia_entidadsj',array('class'=>'form-control'));						
                ?>  
                <?php echo $formularioRegGestSJ->error($modeloGestionSJ,'dependencia_entidadsj',array('style' => 'color:#F00'));?>
        	</div>
       </div>
       <div class="form-group">
			<?php echo $formularioRegGestSJ->labelEx($modeloGestionSJ,'id_tipogestionsj',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php 									
                    echo $formularioRegGestSJ->dropDownList($modeloGestionSJ,'id_tipogestionsj',CHtml::listData($tipoGestion,'id_tipogestionsj','tipo_gestionsj'),
                        array(
                            'prompt'=>'Seleccione a tipo de gestión',
                            'class'=>'selectpicker form-control','data-live-search'=>'true',
							'onChange'=>'js:$("#formularioRegGestionSJ").addClass("unsavedForm");'
							//'onChange'=>'js:consOrganizacion(this)',
                        )
                    );						
                ?>  
                <?php echo $formularioRegGestSJ->error($modeloGestionSJ,'id_tipogestionsj',array('style' => 'color:#F00'));?>
        	</div>
       </div>
       <div class="form-group">
			<?php echo $formularioRegGestSJ->labelEx($modeloGestionSJ,'nombre_contactosj',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php 									
                    echo $formularioRegGestSJ->textField($modeloGestionSJ,'nombre_contactosj',array('class'=>'form-control'));						
                ?>  
                <?php echo $formularioRegGestSJ->error($modeloGestionSJ,'nombre_contactosj',array('style' => 'color:#F00'));?>
        	</div>
       </div>
       <div class="form-group">
			<?php echo $formularioRegGestSJ->labelEx($modeloGestionSJ,'telefono_contactosj',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php 									
                    echo $formularioRegGestSJ->textField($modeloGestionSJ,'telefono_contactosj',array('class'=>'form-control'));						
                ?>  
                <?php echo $formularioRegGestSJ->error($modeloGestionSJ,'telefono_contactosj',array('style' => 'color:#F00'));?>
        	</div>
       </div>
       	<div class="form-group">
			<?php echo $formularioRegGestSJ->labelEx($modeloGestionSJ,'fecha_gestionsj',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
			<div class="col-md-4">		
				<?php //
                        $this->widget('zii.widgets.jui.CJuiDatePicker',
                            array('model'=>$modeloGestionSJ,
                            'attribute'=>'fecha_gestionsj',
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
                                    'minDate'=>'date("Y-m-d")-1m',//fecha minima
                                    'maxDate'=>date("Y-m-d"),//fecha maxima
                            ),
                        ));
                        
                    ?>
                    <?php echo $formularioRegGestSJ->error($modeloGestionSJ,'fecha_gestionsj',array('style' => 'color:#F00'));?>
            	</div>
        	</div>   
            <div class="form-group">
				<?php echo $formularioRegGestSJ->labelEx($modeloGestionSJ,'observaciones_gestionsj',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
                <div class="col-md-4">		
                    <?php 									
                        echo $formularioRegGestSJ->textArea($modeloGestionSJ,'observaciones_gestionsj',array('class'=>'form-control'));						
                    ?>  
                    <?php echo $formularioRegGestSJ->error($modeloGestionSJ,'observaciones_gestionsj',array('style' => 'color:#F00'));?>
                </div>
           </div>            
            <div class="form-group">
   			 <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label'));?>
                <div class="col-md-4">		
                <?php
                    $modeloGestionSJ->num_doc=$numDocAdol;
					$modeloGestionSJ->fecha_regsitrogestionsj=date("Y-m-d");
                    echo $formularioRegGestSJ->hiddenField($modeloGestionSJ,'num_doc');	
					echo $formularioRegGestSJ->hiddenField($modeloGestionSJ,'fecha_regsitrogestionsj');					
                    echo $formularioRegGestSJ->error($modeloGestionSJ,'num_doc',array('style' => 'color:#F00'));
					echo $formularioRegGestSJ->error($modeloGestionSJ,'fecha_regsitrogestionsj',array('style' => 'color:#F00'));
                    $boton=CHtml::ajaxSubmitButton (
                                    'Crear Registro',   
                                    array('gestionSeguimSJ/registrarAsesoriaSJ'),
                                    array(				
                                        'dataType'=>'json',
                                        'type' => 'post',
                                        'beforeSend'=>'function (){$("#btnFormGSJ").hide();Loading.show();}',
                                        'success' => 'function(datos) {	
                                            Loading.hide();
                                            if(datos.estadoComu=="exito"){
                                                if(datos.resultado=="exito"){                                             
                                                     jAlert("Gestión creada satisfactoriamente","Mensaje");                                               
                                                    $("#formularioRegGestionSJ #formularioRegGestionSJ_es_").html("");    
													$("#formularioRegGestionSJ").removeClass("unsavedForm");  
                                                }
                                                else{
                                                    jAlert("Ha habido un error en la creación del registro. Código del error: "+datos.resultado,"Mensaje");
                                                    $("#formularioRegGestionSJ #formularioRegGestionSJ_es_").html("");                                                    
                                                    //$("#formularioAcudiente #formularioAcudiente_es_").hide(); 	
                                                }
                                            }
                                            else{						
												$("#formularioRegGestionSJ #GestionSociojuridica_id_motivoasesoriasj_em_").text("");
												$("#formularioRegGestionSJ #GestionSociojuridica_id_remisionsj_em_").text("");
												$("#formularioRegGestionSJ #GestionSociojuridica_dependencia_entidadsj_em_").text("");
												$("#formularioRegGestionSJ #GestionSociojuridica_id_tipogestionsj_em_").text("");
												$("#formularioRegGestionSJ #GestionSociojuridica_nombre_contactosj_em_").text("");
												$("#formularioRegGestionSJ #GestionSociojuridica_telefono_contactosj_em_").text("");
												$("#formularioRegGestionSJ #GestionSociojuridica_fecha_gestionsj_em_").text("");
                                                $("#btnFormGSJ").show();
                                                var errores="Por favor tenga en cuenta lo siguiente<br/><ul>";
                                                $.each(datos, function(key, val) {
                                                    errores+="<li>"+val+"</li>";
                                                    $("#formularioRegGestionSJ #"+key+"_em_").text(val);                                                    
                                                    $("#formularioRegGestionSJ #"+key+"_em_").show();                                                
                                                });
                                                errores+="</ul>";
                                                $("#formularioRegGestionSJ #formularioRegGestionSJ_es_").html(errores);                                                    
                                                $("#formularioRegGestionSJ #formularioRegGestionSJ_es_").show(); 
                                                
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
		<?php $this->endWidget();?>
        <?php
Yii::app()->getClientScript()->registerScript('scriptValpsic_1','
	$(document).ready(function(){
		$("#formularioRegGestionSJ").find(":input").change(function(){
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
	function habDeshCampos(nombreElemento){
		if($("#"+nombreElemento.id).val()==11){
			$("#GestionSociojuridica_dependencia_entidadsj").attr("disabled",true);
			$("#GestionSociojuridica_id_tipogestionsj").attr("disabled",true);
			$("#GestionSociojuridica_nombre_contactosj").attr("disabled",true);
			$("#GestionSociojuridica_telefono_contactosj").attr("disabled",true);
		}
		else{
			$("#GestionSociojuridica_dependencia_entidadsj").attr("disabled",false);
			$("#GestionSociojuridica_id_tipogestionsj").attr("disabled",false);
			$("#GestionSociojuridica_nombre_contactosj").attr("disabled",false);
			$("#GestionSociojuridica_telefono_contactosj").attr("disabled",false);
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
                    <img src="/login_sdis/public/img/logo.svg" />
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
