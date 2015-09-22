<?php
	header("Content-type: application/vnd.ms-excel; name='excel'");  
	header("Content-Disposition: filename=repAntecendentesFamiliares-".date("Y-m-d").".xls");  
	header("Pragma: no-cache");  
	header("Expires: 0"); 
	
	$antecedentesFam=$consultaGeneral->contulaAntecedentesFam();
$tabla="<table>
	<tr>
		<td style='border:1px solid #003'>Nombre</td>
		<td style='border:1px solid #003'>Número documento</td>
		<td style='border:1px solid #003'>Número carpeta</td>";
	if(!empty($antecedentesFam)){
		foreach($antecedentesFam as $antecedente){
			$tabla.="<td style='border:1px solid #003'>".$antecedente["ant_fam"]."</td>";
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
				foreach($antecedentesFam as $antecedente){
				$link=$consultaGeneral->conectaBDSinPdo();
					$sqlConsAntFamAdol="select * from ant_f_familia where id_valtsoc=$1 and id_ant_fam=$2";
					$queryAntFamAdol=pg_prepare($link,"consAntFamAdol".$adolescente["id_numero_carpeta"].$antecedente["id_ant_fam"],$sqlConsAntFamAdol);
					$queryAntFamAdol=pg_execute($link, "consAntFamAdol".$adolescente["id_numero_carpeta"].$antecedente["id_ant_fam"], array($valoracionAdol["id_valtsoc"],$antecedente["id_ant_fam"]));
					if(pg_num_rows($queryAntFamAdol)>0){
						$tabla.="<td style='border:1px solid #003'>1</td>";					
					}
					else{
						$tabla.="<td style='border:1px solid #003'></td>";
					}
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