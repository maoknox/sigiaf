<fieldset>
<?php echo CHtml::beginForm($action,'post',array("id"=>"searchform_".$numDocAdol,'class' => 'form-horizontal')); ?>
	<div class="form-group"> 
	<?php echo CHtml::label("Digite el nombre del adolescente","search_term",array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">
			<?php echo CHtml::textField("search_term","",array('id'=>'search_term_'.$numDocAdol,'class'=>'form-control input-md','autocomplete'=>'off'));?>
            <?php echo CHtml::hiddenField("numDocAdol","",array('id'=>'numDocAdol'));?>
            <div id="resultado" style="position:absolute; border:1px solid #006; max-height: 200px; overflow-y: auto; min-height: 0px; background:#FFF; z-index:100"></div>
    	</div>   
        <div class="col-md-4">
			<?php echo CHtml::endForm(); ?>
            <?php echo CHtml::beginForm($url,'post',array("id"=>"datosAdol")); ?>
            <?php echo CHtml::hiddenField("numDocAdol","",array('id'=>'numDocAdol'));?>
            <?php
            echo CHtml::submitButton('Cargar',array(
                          "id"=>"btnConsulta",
                          'class'=>'btn btn-default btn-sdis'
                    )); 
            ?>
            <?php echo CHtml::endForm(); ?>
       </div>
</div> 

</fieldset>
<?php
	if(!empty($numDocAdol)):
?>
<div class="panel-heading color-sdis">Datos del Adolescente</div>
<fieldset>
<table style="width:100%;border-collapse:collapse" cellpadding="0px" cellspacing="0px" border="1px">
	<tr>
    	<td style="border:1px solid #003;">
        	Nombre: <?php echo $datosAdol["nombres"]." ".$datosAdol["apellidos"];?>
        </td>
        <td style="border:1px solid #003;">
        	Número de carpeta: <?php echo $datosAdol["id_numero_carpeta"];?>
        </td>
    </tr>
    <tr>
    	<td style="border:1px solid #003;">
        	Lugar y fecha de nacimiento: <br /><?php echo $datosAdol["municipio"]." | | ".$datosAdol["fecha_nacimiento"];?>
        </td>
        <td style="border:1px solid #003;">
        	Etnia: <?php 
			echo $datosAdol["etnia"];?>
        </td>
    </tr>
     <tr>
    	<td style="border:1px solid #003;">
        	Edad: <?php echo $edad;?>
        </td>
        <td style="border:1px solid #003;">
        	Número de identificación: <?php echo $datosAdol["num_doc"];?>
        </td>
    </tr>
    <tr>
    	<td style="border:1px solid #003;">
        	Dirección: 
			<?php 
			if(!empty($datosAdol["direccion"])):
				echo $datosAdol["direccion"];
			else:?>
				Sin información
			<?php endif;?>
        </td>
        <td style="border:1px solid #003;">
         Telefono: 
        	<?php if(!empty($telefonoAdol)):?>
            	<?php foreach($telefonoAdol as $pk=>$telefono):
					echo $telefono["tipo_telefono"].": ".$telefono["telefono"]." ";				
				 endforeach;?>
        	<?php else:?>
            	Sin Información
            <?php endif;?>
        </td>
    </tr>
</table>
</fieldset>
<?php endif;?>