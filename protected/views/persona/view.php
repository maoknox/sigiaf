<?php
/* @var $this PersonaController */
/* @var $model Persona */

$this->breadcrumbs=array(
	'Personas'=>array('index'),
	$model->id_cedula,
);

$this->menu=array(
	array('label'=>'List Persona', 'url'=>array('index')),
	array('label'=>'Create Persona', 'url'=>array('create')),
	array('label'=>'Update Persona', 'url'=>array('update', 'id'=>$model->id_cedula)),
	array('label'=>'Delete Persona', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_cedula),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Persona', 'url'=>array('admin')),
);
?>

<h1>View Persona #<?php echo $model->id_cedula; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_cedula',
		'nombre_personal',
		'apellidos_personal',
	),
)); ?>
