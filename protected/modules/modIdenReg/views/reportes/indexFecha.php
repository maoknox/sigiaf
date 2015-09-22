
<?php
echo $accion;
$this->widget('application.extensions.jqAjaxSearchDate.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('modIdenReg/reportes/'.$accion),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol,
		'fecha'=>''
	)
);
?>
