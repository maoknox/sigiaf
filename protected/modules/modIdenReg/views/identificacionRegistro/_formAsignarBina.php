<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<fieldset>
<legend>Asignación de equipo psicosocial</legend>

<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/asignarBina'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>
<div class="form-group">
	<?php echo CHtml::label("Equipo asignado actualmente");?>
    <div class="col-md-4">
    </div>
</div>
<?php if(!empty($equipoPsicoSoc)):?>
<fieldset class="form-horizontal"><br />
<?php foreach($equipoPsicoSoc as $profesional):?>
<div class="form-group">
    <?php echo CHtml::label('Nombre:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-6">
        <p class="col-md-8 form-control">
			 <?php echo $profesional["nombrecomp_pers"];?> ||	Profesión: <?php echo $profesional["nombre_rol"];?>
            <?php if($profesional["responsable_caso"]==1):?>|| Responsable del caso<?php endif;?><br />
        </p>     
    </div>
</div>   
<?php endforeach;?>
</fieldset>
<?php else:
?>
<p>El adolescente no tiene asignado en el momento un equipo psicosocial</p>
<?php
endif;
?>
</fieldset>

    <div id="Mensaje" style="font-size:14px;" ></div>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'formularioAsignaBina',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
		'htmlOptions' => array('class' => 'form-horizontal')	
    ));
        // si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
    ?>
        <?php echo  $form->errorSummary($modeloHistPersAdol,'','',array('style' => 'font-size:14px;color:#F00')); ?>
    <div class="form-group">
    	<?php echo CHtml::label(" Campos con <span class='required'>*</span> son obligatorios.");?>
    <div class="col-md-4"> 

    </div>
</div>
<div class="form-group">
        <?php echo $form->labelEx($modeloHistPersAdol,'psicologosHist',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
            <?php echo $form->dropDownList($modeloHistPersAdol,'psicologosHist',CHtml::listData($psicologo,'id_cedula', 'nombrecomp_pers'),array('prompt'=>'Seleccione Psicólogo','class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true')); ?></br>
            <?php echo $form->error($modeloHistPersAdol,'psicologosHist',array('style' => 'color:#F00')); ?>
            <?php echo $form->radioButtonList($modeloHistPersAdol, 'responsable_caso', array('1'=>'Responsable psicólogo','2'=>'Responsable Trabajador Social')); //responsable del caso del adolescente?>
            <?php echo $form->error($modeloHistPersAdol,'responsable_caso',array('style' => 'color:#F00')); ?>
        </div>
    </div>        
    <div class="form-group">
        <?php echo $form->labelEx($modeloHistPersAdol,'trabSocialsHist',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
        <div class="col-md-4">
			<?php echo $form->dropDownList($modeloHistPersAdol,'trabSocialsHist',CHtml::listData($trabSocial,'id_cedula', 'nombrecomp_pers'),array('prompt'=>'Seleccione Trabajador social','class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true')); ?></br>
			<?php echo $form->error($modeloHistPersAdol,'trabSocialsHist',array('style' => 'color:#F00')); ?>
        </div>
    </div>   
    <div class="form-group">
    	<?php echo CHtml::label("","",array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
         <div class="col-md-4">
       <?php
			$modeloHistPersAdol->num_doc=$numDocAdol;			
			echo $form->hiddenField($modeloHistPersAdol,'num_doc');
            $boton=CHtml::ajaxSubmitButton (
                            'Modificar Bina',   
                            array('identificacionRegistro/registraEquipoPsic'),
                            array(				
                                'dataType'=>'json',
                                'type' => 'post',
                                'beforeSend'=>'function (){Loading.show();}',//$("#btnFormAdolId").hide();
                                'success' => 'function(datos) {	
                                    Loading.hide();
                                    if(datos.estadoComu=="exito"){
                                        if(datos.resultado=="\'exito\'"){
											jAlert("La bina ha sido modificada");
                                            $("#Mensaje").html("Registro realizado satisfacotriamente");
											$("#formularioAsignaBina").removeClass("unsavedForm");
                                            $("#formularioAsignaBina #formularioAsignaBina_es_").html("");                                                    
                                            $("#formularioAsignaBina #formularioAsignaBina_es_").hide(); 	
											$(".errorMessage").html("");
                                        }
                                        else{
                                            $("#Mensaje").html("Ha habido un error en la creación del registro. Código del error: "+datos.msnError);
                                            $("#formularioAsignaBina #formularioAsignaBina_es_").html("");                                                    
                                            $("#formularioAsignaBina #formularioAsignaBina_es_").hide(); 	
                                        }
                                    }
                                    else{						
                                        $("#btnFormAdolId").show();
                                        var errores="Por favor corrija los siguientes errores<br/><ul>";
                                        $.each(datos, function(key, val) {
                                            errores+="<li>"+val+"</li>";
                                            $("#formularioAsignaBina #"+key+"_em_").text(val);                                                    
                                            $("#formularioAsignaBina #"+key+"_em_").show();                                                
                                        });
                                        errores+="</ul>";
                                        $("#formularioAsignaBina #formularioAsignaBina_es_").html(errores);                                                    
                                        $("#formularioAsignaBina #formularioAsignaBina_es_").show(); 
                                    }
                                    
                                }',
                                'error'=>'function (xhr, ajaxOptions, thrownError) {
                                    Loading.hide();
                                    //0 para error en comunicación
                                    //200 error en lenguaje o motor de base de datos
                                    //500 Internal server error
                                    if(xhr.status==0){
                                        $("#Mensaje").html("Se ha perdido la cumunicación con el servidor.  Espere unos instantes y vuelva a intentarlo. <br/> Si el problema persiste comuníquese con el área encargada del Sistema");
                                        $("#btnFormAdolId").show();
                                    }
                                    else{
                                        if(xhr.status==500){
                                            $("#Mensaje").html("Hay un error en el servidor del Sistema de información. Comuníquese con el área encargada del Sistema de información");
                                        }
                                        else{
                                            $("#Mensaje").html("No se ha creado el registro del adolescente debido al siguiente error \n"+xhr.responseText+" Comuníquese con el ingeniero encargado");
                                        }	
                                    }
                                    
                                }'
                            ),
                            array('id'=>'btnFormAdolId','name'=>'btnCreaAdolN','class'=>'btn btn-default btn-sdis')
                    );
        ?>
        <?php echo $boton; //CHtml::submitButton('Crear');?>
        </div></div>
    <?php $this->endWidget();?>
<?php Yii::app()->getClientScript()->registerScript('scriptRegistraDatos','
$(document).ready(function(){
	$("form").find(":input").change(function(){
		var dirtyForm = $(this).parents("form");
		// change form status to dirty
		dirtyForm.addClass("unsavedForm");
	});
});	
var campoText=0;
$(window).bind("beforeunload", function(){
	if($(".unsavedForm").size()){
		return "Aún no ha guardado cambios.  Los perderá si abandona.";
	}
});'
,CClientScript::POS_END);
?>
<?php endif;?>
</fieldset>    
	