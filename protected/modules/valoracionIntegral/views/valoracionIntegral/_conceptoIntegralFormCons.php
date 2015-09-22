<?php if(!empty($numDocAdol)):?>
<fieldset >
<legend>Concepto Integral</legend>
<?php 
	if(!empty($modeloConInt->concepto_integral)):?>
    
		<p><?php 
			$modeloConInt->concepto_integral=CHtml::encode($modeloConInt->concepto_integral);
		echo $modeloConInt->concepto_integral?></p>
	<?php else: ?>
		<p>Aún el responsable del caso no ha creado un concepto integral</p>		
	<?php endif;?>
</fieldset>
<?php endif;?>