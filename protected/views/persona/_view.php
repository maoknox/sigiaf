<?php
/* @var $this PersonaController */
/* @var $data Persona */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cedula')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_cedula), array('view', 'id'=>$data->id_cedula)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_personal')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_personal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apellidos_personal')); ?>:</b>
	<?php echo CHtml::encode($data->apellidos_personal); ?>
	<br />


</div>