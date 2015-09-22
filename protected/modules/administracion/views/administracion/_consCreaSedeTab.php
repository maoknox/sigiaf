<?php 
	if(!empty($sedes)):
?>
<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'id'=>'infoSedes',
    'htmlOptions'=>array('style'=>'display: block;font-size:11px'),  // INVISIBLE..
    'tabs'=>array(
	'Consulta de Sedes'=>$this->renderPartial('_consultaSede', 
			array(
				'sedes'=>$sedes,
				'modeloCForjar'=>$modeloCForjar,
			),true,false),
		'Crear Sede'=>$this->renderPartial('_creaSede', 
			array(
				'modeloCForjar'=>$modeloCForjar,
				'modeloTelForjar'=>$modeloTelForjar
			),true,false),
    ),
    'options'=>array('collapsible'=>false),
)); 

?>


<?php
else:
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            AVISO!!!
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
        	<div class="col-lg-9 text-justify">No hay creada aún una sede </div>
        </div>
    </div>
</div>
<?php endif;?>
