<?php
	header("Content-type: application/vnd.ms-excel; name='excel'");  
	header("Content-Disposition: filename=repRegimenSalud-".date("Y-m-d").".xls");  
	header("Pragma: no-cache");  
	header("Expires: 0"); 
	
	$antecedentesFam=$consultaGeneral->contulaAntecedentesFam();
$tabla="<table>
	<tr>
		<td style='border:1px solid #003'>Nombre</td>
		<td style='border:1px solid #003'>Número documento</td>
		<td style='border:1px solid #003'>Número carpeta</td>
		<td style='border:1px solid #003'>Régimen</td>
		<td style='border:1px solid #003'>EPS</td>
	</tr>	
	";
		
	$adolescentesForjar=$consultaGeneral->consultaForjarAdol();
	if(!empty($adolescentesForjar)){
		foreach($adolescentesForjar as $adolescente){
			$tabla.="<tr>";
			$tabla.="<td style='border:1px solid #003'>".$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"]."</td>";	
			$tabla.="<td style='border:1px solid #003'>".$adolescente["num_doc"]."</td>";	
			$tabla.="<td style='border:1px solid #003'>".$adolescente["id_numero_carpeta"]."</td>";	

			$consultaGeneral->numDocAdol=$adolescente["num_doc"];			
			$valoracionAdol="";
			$link=$consultaGeneral->conectaBDSinPdo();
			$sqlSGSSS="select * from sgsss as a left join regimen_salud as b on b.id_regimen_salud=a.id_regimen_salud left join eps_adol as c on c.id_eps_adol=a.id_eps_adol where num_doc=$1";
			$querySGSSS=pg_prepare($link,"consAntFamAdol".$adolescente["id_numero_carpeta"],$sqlSGSSS);
			$querySGSSS=pg_execute($link, "consAntFamAdol".$adolescente["id_numero_carpeta"], array($adolescente["num_doc"]));
			if(pg_num_rows($querySGSSS)>0){
				$resSGSSS=pg_fetch_array($querySGSSS);
				$tabla.="<td style='border:1px solid #003'>".$resSGSSS["regimen_salud"]."</td>";	
				$tabla.="<td style='border:1px solid #003'>".$resSGSSS["eps_adol"]."</td>";					
			}
			else{
				$tabla.="<td style='border:1px solid #003'>Sin Inf.</td>";
				$tabla.="<td style='border:1px solid #003'>Sin Inf.</td>";
			}				
			$tabla.="</tr>";
		}
	}
	$tabla.="</table>";
	echo utf8_decode($tabla);
?>