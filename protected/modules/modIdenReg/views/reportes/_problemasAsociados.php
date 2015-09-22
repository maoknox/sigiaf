<?php
	header("Content-type: application/vnd.ms-excel; name='excel'");  
	header("Content-Disposition: filename=repProblemasAsociados-".date("Y-m-d").".xls");  
	header("Pragma: no-cache");  
	header("Expires: 0"); 
	
	$problemasAsoc=$consultaGeneral->contulaProblemasAsociados();
$tabla="<table>
	<tr>
		<td style='border:1px solid #003'>Nombre</td>
		<td style='border:1px solid #003'>Número documento</td>
		<td style='border:1px solid #003'>Número carpeta</td>";
	if(!empty($problemasAsoc)){
		foreach($problemasAsoc as $problema){
			$tabla.="<td style='border:1px solid #003'>".$problema["problema_asoc"]."</td>";
		}
	}	
		
	$tabla.="</tr>";	
	$adolescentesForjar=$consultaGeneral->consultaForjarAdol();
	if(!empty($adolescentesForjar)){
		
		
		foreach($adolescentesForjar as $adolescente){
			$tabla.="<tr>";
			$tabla.="<td style='border:1px solid #003'>".$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"]."</td>";	
			$tabla.="<td style='border:1px solid #003'>".$adolescente["num_doc"]."</td>";	
			$tabla.="<td style='border:1px solid #003'>".$adolescente["id_numero_carpeta"]."</td>";	

			$consultaGeneral->numDocAdol=$adolescente["num_doc"];			
			$valoracionAdol="";
			$valoracionAdol=$consultaGeneral->consultaValoracionTrSoc();
			if(!empty($valoracionAdol)){
							$tabla.="<td style='border:1px solid #003'>".$valoracionAdol["id_valtsoc"]."</td>";
				$link=$consultaGeneral->conectaBDSinPdo();
				$sqlConsProbAdol="select * from problema_valtsocial where id_valtsoc=$1";
				$queryProbAdol=pg_prepare($link,"consProbAdol".$adolescente["id_numero_carpeta"],$sqlConsProbAdol);
				$queryProbAdol=pg_execute($link, "consProbAdol".$adolescente["id_numero_carpeta"], array($valoracionAdol["id_valtsoc"]));
				if(pg_num_rows($queryProbAdol)>0){
					while($resProbAsoc=pg_fetch_array($queryProbAdol)){
						$check="";
						foreach($problemasAsoc as $problema){
							if($problema["id_problema_asoc"]==$resProbAsoc["id_problema_asoc"]){
								if($resProbAsoc["vinc_act_prob"]=='t'){
									$check=1;
								}
							}							
						}
						$tabla.="<td style='border:1px solid #003'>".$check."</td>";
					}
					
				}
				else{
					$tabla.="<td style='border:1px solid #003' colspan='".count($problemasAsoc)."'>Sin información</td>";
				}	
			}
			else{
				$tabla.="<td style='border:1px solid #003' colspan='".count($problemasAsoc)."'>Adolescente sin valoración</td>";
			}
			$tabla.="</tr>";
		}
	}
	$tabla.="</table>";
	echo utf8_decode($tabla);
?>