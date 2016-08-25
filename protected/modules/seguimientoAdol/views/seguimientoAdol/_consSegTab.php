<div id="MensajeSeguimiento" style="font-size:14px;"></div>
    <fieldset>
	    <div class="panel-heading color-sdis">Histórico de seguimientos</div> <br />
            <table style="border:0px; width:100%;">
                <tr>
                    <td style="width:80%">
                        <div class="cont-seg">
                            <?php 
                            if(!empty($seguimientos)):?>
                                <?php foreach($seguimientos as $pk=>$seguimiento): ?>
                                    <?php $profSeg=$modeloSeguimiento->consultaProfSeg('true',$seguimiento["fecha_registro_seg"],$seguimiento["id_seguimientoadol"]);?>
                                    <a name="<?php echo $pk;?>"><strong>Fecha del seguimiento: <?php echo $seguimiento["fecha_seguimiento"] ?>
                                    || Nombre del profesional <?php echo $profSeg["nombrespersonal"]?> || Profesión: <?php echo $profSeg["nombre_rol"]?></strong></a><br /><br />
                                    <p style="margin:0px 10px 0px 0px"><?php echo CHtml::encode($seguimiento["seguimiento_adol"]); ?></p><br />
                                    <?php if($seguimiento["seguim_conj"]==1):?>
                                         <p style="margin:0px 10px 0px 0px">Seguimiento realizado en conjunción con:</p>
                                        <?php $profSeg=$modeloSeguimiento->consultaProfSeg('false',$seguimiento["fecha_registro_seg"],$seguimiento["id_seguimientoadol"]);?>	
                                        <strong>Nombre del profesional <?php echo $profSeg["nombrespersonal"]?> || Profesión: <?php echo $profSeg["nombre_rol"]?></strong>
                                    <?php	endif;?>
                                    <hr />
                                <?php endforeach;?>					
                            <?php endif;?>
                        </div>
                    </td>
                    <td valign="top" style="width:20%">
                        <div class="cont-f-seg">
                            <?php if(!empty($seguimientos)):?>
                                <?php foreach($seguimientos as $pk=>$seguimiento): ?>
                                    <a href="#<?php echo $pk;?>">Fecha: <?php echo $pk."-".$seguimiento["fecha_seguimiento"] ?></a><br />
                                <?php endforeach;?>					
                            <?php endif;?>
                        </div>
                    </td>
                </tr>
            </table>
    </fieldset>


