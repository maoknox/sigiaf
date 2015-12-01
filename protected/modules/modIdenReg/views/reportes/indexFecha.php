
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
//$comando = "ping 192.168.0.1";
//$output = shell_exec($comando);
//echo $output;?>
<?php if(!empty($mensaje)):?>
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
                    <?php echo $mensaje;?>
                </div>
            </div>
        </div>
    </div>
    <hr />

	
<?php endif?>