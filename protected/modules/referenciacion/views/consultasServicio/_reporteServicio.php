<?php
	header("Content-type: application/vnd.ms-excel; name='excel'");  
	header("Content-Disposition: filename=repReferenciacion".date("Y-m-d").".xls");  
	header("Pragma: no-cache");  
	header("Expires: 0"); 
	if(!empty($referenciados)):?>
		<?php
		$tabla='<table width="1024px" border="1">
		<tr>
			<td align="center" style="border:1px solid #000;background:#F96;">Fecha de la referenciación</td>
			<td align="center"  style="border:1px solid #000;background:#F96;">Nombre del Adolescente</td>
			<td align="center" style="border:1px solid #000;background:#F96;">Línea de acción</td>
			<td align="center"  style="border:1px solid #000;background:#F96;">Especificación de nivel 1</td>
			<td align="center"  style="border:1px solid #000;background:#F96;">Especificación de nivel 2</td>
			<td align="center"  style="border:1px solid #000;background:#F96;">Especificación de nivel 3</td>
			<td align="center"  style="border:1px solid #000;background:#F96;">Usuario beneficiario</td>
			<td align="center"  style="border:1px solid #000;background:#F96;">Profesional que referencia</td>
			<td align="center"  style="border:1px solid #000;background:#F96;">Estado de la referenciación</td>
		</tr>';
		foreach($referenciados as $referenciado){
			$modeloReferenciacion->numDocRef=$referenciado["num_doc"];
			$refsAdols=$modeloReferenciacion->consultaReferenciacionAdol();
			foreach($refsAdols as $pk=>$refAdol){
				$modeloReferenciacion->idRef=$refAdol["id_referenciacion"];
				$referenciacion=$modeloReferenciacion->consultaReferenciacion();
				$tabla.='<tr>';
				$tabla.='<td>'.$refAdol["fecha_referenciacion"].'</td>';
				$tabla.='<td>'.$referenciado["nombres"].' '.$referenciado["apellidos"].'</td>';
				$tabla.='<td>'.$referenciacion["tipo_referenciacion"].'</td>';
				$tabla.='<td>'.$referenciacion["esp_sol"].'</td>';
				$tabla.='<td>'.$referenciacion["esp_solii"].'</td>';
				$tabla.='<td>'.$referenciacion["esp_soliii"].'</td>';
				$tabla.='<td>'.$refAdol["fecha_referenciacion"].'</td>';
				$tabla.='<td>'.$referenciacion["nombre_personal"].' '.$referenciacion["apellidos_personal"].'</td>';
				$tabla.='<td>'.$referenciacion["estado_ref"].'</td>';
				$tabla.='</tr>';	
			}
		}	
		
	$tabla.="</table>";
	echo utf8_decode($tabla);?>
		<?php
		$tabla='<table width="1024px" border="1">
		<tr>
			<td align="center" style="border:1px solid #000;background:#F96;">No hay adolescentes hasta el momento con referenciación</td>
		</tr>';
	$tabla.="</table>";?>
    <?php else:?>
    	
	<?php endif;?>

