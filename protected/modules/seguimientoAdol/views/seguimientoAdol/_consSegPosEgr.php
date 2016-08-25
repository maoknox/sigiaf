<div id="MensajeSeguimientoPE" style="font-size:14px;"></div>

   <fieldset>
    	<div class="panel-heading color-sdis">Histórico de seguimientos</div> <br />
<table style="border:0px; width:100%;">
    <tr>
        <td style="width:80%">
            <div class="cont-seg">
	        	<?php 
				if(!empty($seguimientosPosEgreso)):?>
					<?php foreach($seguimientosPosEgreso as $pk=>$seguimientoPosEgreso):?>
                    	<?php $profSeg=$modeloSeguimiento->consultaProfSegPE('true',$seguimientoPosEgreso["fecha_registro_seg"],$seguimientoPosEgreso["id_seguimientoadol"]);?>
						<a name="segpe_<?php echo $pk;?>"><strong>Fecha del seguimiento: <?php echo $seguimientoPosEgreso["fecha_seguimiento"] ?>
                        || Nombre del profesional <?php echo $profSeg["nombrespersonal"]?> || Profesión: <?php echo $profSeg["nombre_rol"]?></strong></a><br /><br />
                        <p style="margin:0px 10px 0px 0px"><?php echo CHtml::encode($seguimientoPosEgreso["seguimiento_adol"]); ?></p><br />
                        <hr />
					<?php endforeach;?>					
				<?php endif;?>
            </div>
        </td>
        <td valign="top" style="width:20%">
            <div class="cont-f-seg">
            	<?php if(!empty($seguimientosPosEgreso)):?>
					<?php foreach($seguimientosPosEgreso as $pk=>$seguimientoPosEgreso): ?>
						<a href="#segpe_<?php echo $pk;?>">Fecha:<?php echo $pk."-".$seguimientoPosEgreso["fecha_seguimiento"] ?></a><br />
					<?php endforeach;?>					
				<?php endif;?>
            </div>
        </td>
    </tr>
</table>
</fieldset>
