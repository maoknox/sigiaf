<fieldset>
	<legend>Datos de remisión</legend>
    Fecha de remisión (aaaa/mm/dd): <?php if(!empty($infJudicial["fecha_remision"])): echo CHtml::encode($infJudicial["fecha_remision"]); else:?>Sin Inf. <?php   endif;?> <br />
    Remitido por: <?php 
		if(!empty($infJudicial["id_instancia_rem"])): 
			foreach($instanciaRem as $id=>$instanciaRem){
				if($instanciaRem["id_instancia_rem"]===$infJudicial["id_instancia_rem"]){
					echo CHtml::encode($instanciaRem["nombre_instancia_rem"]);
				}
			}
			
		else:?>Sin Inf. <?php   endif;?> <br />
    Defensor de familia: <?php if(!empty($infJudicial["defensor"])): echo CHtml::encode($infJudicial["defensor"]); else:?>Sin Inf. <?php   endif;?><br />
    Defensor Público: <?php if(!empty($infJudicial["defensor_publico"])): echo CHtml::encode($infJudicial["defensor_publico"]); else:?>Sin Inf. <?php   endif;?><br />
    Juez: <?php if(!empty($infJudicial["juez"])): echo CHtml::encode($infJudicial["juez"]); else:?>Sin Inf. <?php   endif;?><br />
    Juzgado: <?php if(!empty($infJudicial["juzgado"])): echo CHtml::encode($infJudicial["juzgado"]); else:?>Sin Inf. <?php   endif;?><br />
</fieldset>
<fieldset>
	<legend>Proceso Actual</legend>
    Número de proceso: <?php if(!empty($infJudicial["no_proceso"])): echo $infJudicial["no_proceso"]; else:?>Sin Inf. <?php   endif;?><br />
    Fecha de aprehensión (aaaa/mm/dd): <?php if(!empty($infJudicial["fecha_primer_ingreso"])): echo CHtml::encode($infJudicial["fecha_primer_ingreso"]); else:?>Sin Inf. <?php   endif;?><br />
    Delito: <?php //echo $infJudicial["id_inf_judicial"];
		$modeloInfJud->id_inf_judicial=$infJudicial["id_inf_judicial"];
		$delitosAdol=$modeloInfJud->consultaDelito();
		foreach($delitosAdol as  $delitosAdol){
			echo CHtml::encode($delitosAdol["del_remcespa"]);
		}
	
	?><br />
    Estado del proceso: <?php 
		if(!empty($infJudicial["id_proc_jud"])): 
			foreach($espProcJud as $id=>$espProcJud){
				if($espProcJud["id_proc_jud"]===$infJudicial["id_proc_jud"]){
					echo CHtml::encode($espProcJud["proc_jud"]);
				}
			}			
		else:?>Sin Inf. <?php   endif;?> <br />
    PARD con vinculación al SRP:<?php if(!empty($infJudicial["pard"])): ?> Si <?php else:?>No <?php   endif;?> <br />
    Id Tipo Sancion: <?php 
		if(!empty($infJudicial["id_tipo_sancion"])): 
			foreach($tipoSancion as $id=>$tipoSancion){
				if($tipoSancion["id_tipo_sancion"]===$infJudicial["id_tipo_sancion"]){
					echo CHtml::encode($tipoSancion["tipo_sancion"]);
				}
			}			
		else:?>Sin Inf. <?php   endif;?><br />
    Mecanismo sustitutivo de privación de la libertad: <?php if(!empty($infJudicial["mec_sust_lib"])): ?> Si <?php else:?>No <?php   endif;?><br />
    Fecha Imposición: <?php if(!empty($infJudicial["fecha_imposicion"])): echo CHtml::encode($infJudicial["fecha_imposicion"]); else:?>Sin Inf.<?php   endif;?><br />
    Tiempo sanción en meses: <?php if(!empty($infJudicial["tiempo_sancion"])): echo CHtml::encode($infJudicial["tiempo_sancion"]); else:?>Sin Inf.<?php   endif;?><br />
    Tiempo sancion en días: <?php if(!empty($infJudicial["tiempo_sancion_dias"])): echo CHtml::encode($infJudicial["tiempo_sancion_dias"]); else:?>Sin Inf.<?php   endif;?><br />
    Observaciones Sanción:<?php if(!empty($infJudicial["observaciones_ingreso"])): echo CHtml::encode($infJudicial["observaciones_ingreso"]);  endif;?><br />
    
</fieldset>