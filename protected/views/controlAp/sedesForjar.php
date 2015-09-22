<?php
$sedesForjar=Yii::app()->user->getState('sedesForjar');
?>

 <div class="panel panel-default">
 	<div class="panel-heading">
		<div class="panel-title">
			CENTRO FORJAR
        </div>
    </div>
  	<div class="panel-body">
		<div class="row">
        	 <div class="col-lg-3 text-center">
             	<img src="/login_sdis/public/img/logo.svg" />
             </div>
             <div class="col-lg-9 text-justify">
                Tiene asociado <?php echo count($sedesForjar);?> sedes de forjar, a continuación se listan.  Selecciona al cual desea acceder:<br />
					<?php
                        foreach($sedesForjar as $sedeForjar):
                    ?>
                	<?php echo CHtml::link($sedeForjar["nombre_sede"],$sedeForjar["id_forjar"],array('submit'=>array('controlAp/seleccionSede'),'params'=>array('sedeForjar'=>$sedeForjar["id_forjar"], 'nombreSedeForjar' => $sedeForjar["nombre_sede"]))); ?><br />
                <?php endforeach;?>
             
             </div>
        </div> 
 	</div>
 </div>