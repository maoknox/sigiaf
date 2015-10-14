<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('referenciacion/asignacionServicio/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('referenciacion/asignacionServicio/consultaSegServicioForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($modeloRef->id_referenciacion)):?>
<div class="panel-heading color-sdis">Información de la referenciación</div> 
<fieldset class="form-horizontal"><br />
<div class="form-group">
    <?php echo CHtml::label('Línea de acción','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
        <p class="col-md-4 form-control">
            <?php foreach($tipoRef as $linaAccion){
                if($linaAccion["id_tipo_referenciacion"]==$modeloRef->id_tipo_referenciacion){
                    echo $linaAccion["tipo_referenciacion"];
                }
            }?>  
        </p>     
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Beneficiario','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
    	<p class="col-md-4 form-control">
			<?php 
            if(!empty($modeloRef->id_beneficiario)){
                foreach($beneficiario as $beneficiario){//revisar
                    if($beneficiario["id_beneficiario"]==$modeloRef->id_beneficiario){
						echo $beneficiario["beneficiario"];
                    }
                }
            }
            else{
                echo "N.A";	
            }
            ?>        
        </p>      
    </div>
</div>   

<div class="form-group">
    <?php echo CHtml::label('Especificación de nivel I:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
    	<p class="col-md-4 form-control">
			<?php 
            if(!empty($modeloRef->id_esp_sol)){
                foreach($espNi as $espNi){//revisar
                    if($espNi["id_esp_sol"]==$modeloRef->id_esp_sol){
                        echo $espNi["esp_sol"];
                    }
                }
            }
            else{
                echo "N.A";	
            }
            ?>        
        </p>      
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Especificación de nivel II:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
    	<p class="col-md-4 form-control">
			<?php 
            if(!empty($modeloRef->id_esp_solii)){
                foreach($espNii as $espNii){//revisar
                    if($espNii["id_esp_solii"]===$modeloRef->id_esp_solii){
                        echo $espNii["esp_solii"];
                    }
                }
            }
            else{
                echo "N.A";	
            }
            ?>        
        </p>      
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Especificación de nivel III:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
    	<p class="col-md-4 form-control">
			<?php 
            if(!empty($modeloRef->id_esp_soliii)){//revisar
                foreach($espNiii as $espNiii){
                    if($espNiii["id_esp_soliii"]===$modeloRef->id_esp_soliii){
                        echo $espNiii["esp_soliii"];
                    }
                }
            }
            else{
                echo "N.A";	
            }
            ?>
        </p>      
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Instituto','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
    	<p class="col-md-4 form-control">
			<?php
				if(!empty($modeloRef->institucion_ref)){
					echo $modeloRef->institucion_ref;
				}
				else{
					echo "N.A";
				}
			?>
        </p>      
    </div>
</div> 
<div class="form-group">
    <?php echo CHtml::label('Observaciones','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
			<?php
                if(!empty($modeloRef->observaciones_refer)){
					echo CHtml::textArea('',$modeloRef->observaciones_refer,array('class'=>'col-md-4 form-control','for'=>'searchinput'));
                   // echo $modeloRef->observaciones_refer;
                }
                else{
                    echo "N.A";
                }
            ?>
    </div>
</div> 
<div class="form-group">
    <?php echo CHtml::label('Estado','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
    	<p class="col-md-4 form-control">
			<?php
            foreach($estadoRef as $estadoRef){//revisar
                if($estadoRef["id_estadoref"]===$modeloRef->id_estadoref){
                    echo $estadoRef["estado_ref"];
                }
            }
            
            ?>
        </p>      
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Referenciacion realizada por:','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-6">
      <hr />
    </div>
</div>	
<div class="form-group">
    <?php echo CHtml::label('Nombre del profesional','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
    	<p class="col-md-4 form-control">
        	<?php
               echo $profesional["nombre"];
			?>
        </p>       
    </div>
</div>   
<div class="form-group">
    <?php echo CHtml::label('Cargo','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
    <div class="col-md-4">
    	<p class="col-md-4 form-control">
			<?php 
			foreach($rol as $rol)://revisar
				if($rol["id_rol"]===$profesional["id_rol"]):
					echo $rol["nombre_rol"];
				 endif;?>
			<?php endforeach;?>	  
        </p>     
    </div>
</div>
</fieldset>
<?php endif;?>
