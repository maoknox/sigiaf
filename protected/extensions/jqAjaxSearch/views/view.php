
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
	Yii::import('application.models.ComponenteSancion');	
	Yii::import('application.models.ConsultasGenerales');	
	$modeloConsultasGen=new ConsultasGenerales();
	$modeloComponenteSancion=new ComponenteSancion();
	$modeloConsultasGen->numDocAdol=$numDocAdol;
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
        	<?php 
				$telefonosAdol=$modeloConsultasGen->consultaTelefono();
				if(!empty($telefonosAdol)):?>
            	<?php foreach($telefonosAdol as $pk=>$telefonoAdol):
					echo $telefonoAdol["tipo_telefono"].": ".$telefonoAdol["telefono"]." ";				
				 endforeach;?>
        	<?php else:?>
            	Sin Información
            <?php endif;?>
        </td>
        </tr>
        <tr>
        <td>
        	<?php
				$salud=$modeloConsultasGen->consultaSgsss();
				if(empty($salud)){
					$salud["regimen_salud"]="Sin Inf.";
					$salud["eps_adol"]="Sin Inf.";
				}
			?>
        	Régimen: <?= $salud["regimen_salud"]; ?> 
        </td>
        <td>
        	EPS: <?= $salud["eps_adol"]; ?>
        </td>
        </tr>
        <tr>
        	<td>
            	<?php
					$datosVinc=$modeloConsultasGen->consultaDatosRemision();
					if(empty($datosVinc)){
						$datosVinc["fecha_vinc_forjar"]="Sin Inf.";
					}
				?>
                Fecha de ingreso: <?= $datosVinc["fecha_vinc_forjar"];?>     
            </td>
            <td>
            
            </td>
            </tr>
        <?php
			$infsJudicial=$modeloConsultasGen->consultaInfJudicial();
			$infJudiciali=array();
			 if(!empty($infsJudicial)){
				foreach($infsJudicial as $pk=>$infJudiciali){
					$consNovedadInfJud=$modeloConsultasGen->consultaInfJudNov($infJudiciali["id_inf_judicial"]);
					if(!empty($consNovedadInfJud)){
						//print_r($consNovedadInfJud);
						$infsJudicial[$pk]=$consNovedadInfJud;
					}
				}
			 }
		?> 
        <?php
			if(!empty($infsJudicial)):
			//$infJudicial=array(); 			
				$modeloComponenteSancion->num_doc=$numDocAdol;
				foreach($infsJudicial as $infJudicial):?>   
                 	<?php 
						$infJudActual=array();					 
						$modeloComponenteSancion->id_inf_judicial=$infJudicial["id_inf_judicial"];
						//echo $modeloComponenteSancion->num_doc."||".$modeloComponenteSancion->id_inf_judicial."-";
						$infJudActual=$modeloComponenteSancion->consultaInfJudComponenteSanc();
						if($infJudActual["pai_actual"]=="true" or empty($infJudActual)):?>
                         <tr>
                            <td>
                                Remisión por: <?= $infJudicial["nombre_instancia_rem"]?>
                            </td>
                            <td>
                                Sanción Actual: <?= $infJudicial["tipo_sancion"]?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                    $consDelitos=$modeloConsultasGen->consDelitos($infJudicial["id_inf_judicial"]);
                                ?>
                                Delito(s):
                                <?php foreach($consDelitos as $delito):?>
                                    <div>-<?= $delito["del_remcespa"]?></div>
                                <?php endforeach;?>
                            </td>
                            <td>
                                Número de proceso: <?= $infJudicial["no_proceso"]?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Juez: <?= $infJudicial["juez"]?>
                            </td>
                            <td>
                                Defensor: <?= $infJudicial["defensor"]?>
                            </td>
                        </tr>
                <?php endif; ?>
                
			<?php endforeach;
			endif;?>
</table>
</fieldset>
<?php endif;?>




