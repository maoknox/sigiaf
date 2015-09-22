<?php
	header("Content-type: application/vnd.ms-excel; name='excel'");  
	header("Content-Disposition: filename=repConsumoSpa-".date("Y-m-d").".xls");  
	header("Pragma: no-cache");  
	header("Expires: 0"); 
	
	
$tabla="<table>
	<tr>
		<td style='border:1px solid #003'>Nombre</td>
		<td style='border:1px solid #003'>Número documento</td>
		<td style='border:1px solid #003'>Número carpeta</td>
		<td style='border:1px solid #003'>Tipo Spa</td>
		<td style='border:1px solid #003'>Spa Mayor Impacto</td>
		<td style='border:1px solid #003'>edad inicio</td>
		<td style='border:1px solid #003'>Motivos asociados al inicio de consumo</td>
		<td style='border:1px solid #003'>Patrón consumo</td>
		<td style='border:1px solid #003'>Descripción patrón consumo</td>
	</tr>";
	$adolescentesForjar=$consultaGeneral->consultaForjarAdol();
	if(!empty($adolescentesForjar)){
		foreach($adolescentesForjar as $adolescente){
			$consultaGeneral->numDocAdol=$adolescente["num_doc"];
			$valoracionAdol="";
			$valoracionAdol=$consultaGeneral->consultaValoracionPsicol();
			if(!empty($valoracionAdol)){
				//consulta si tiene consumo
				$link=$consultaGeneral->conectaBDSinPdo();
				$sqlConsPatCons="select b.patron_consumo,a.patron_consumo_desc from valoracion_psicologia as a 
					left join patron_consumo as b on a.id_patron_consumo=b.id_patron_consumo 
					where id_valoracion_psicol=$1";
				$queryPatCons=pg_prepare($link,"consPatCons".$adolescente["id_numero_carpeta"],$sqlConsPatCons);
				$queryPatCons=pg_execute($link, "consPatCons".$adolescente["id_numero_carpeta"], array($valoracionAdol["id_valoracion_psicol"]));
				$resPatCons=pg_fetch_array($queryPatCons);			
				//pg_free_result($resPatCons);
				$sqlConsTipoSpa="select * from consumo_drogas as a 
					left join tipo_droga as b on b.id_tipo_droga=a.id_tipo_droga left 
					join frecuencia_uso as c on c.id_frecuencia_uso=a.id_frecuencia_uso 
					where id_valoracion_psicol=$1";
				$queryTipoSpa=pg_prepare($link,"spa".$adolescente["id_numero_carpeta"],$sqlConsTipoSpa);
				$queryTipoSpa=pg_execute($link, "spa".$adolescente["id_numero_carpeta"], array($valoracionAdol["id_valoracion_psicol"]));
				$count=0;
				$tipoSpaII="";
				$tipoSpaI="";
				if(pg_num_rows($queryTipoSpa)>0){
					while($resTipoSpa=pg_fetch_array($queryTipoSpa)){
						$spaMayImp="No";
						if($resTipoSpa["droga_mayor_impacto"]=='t'){
							$spaMayImp="Si";
						}
						if($count==0){
							$tipoSpaI="<td style='border:1px solid #003'>".$resTipoSpa["nombre_droga"]."</td><td style='border:1px solid #003'>".$spaMayImp."</td><td style='border:1px solid #003'>".$resTipoSpa["edad_inicio_cons"]."</td><td style='border:1px solid #003'>".$resTipoSpa["motivo_inicio_cons"]."</td>";
						}
						else{
							$tipoSpaII.="<tr><td style='border:1px solid #003'>".$resTipoSpa["nombre_droga"]."</td><td style='border:1px solid #003'>".$spaMayImp."</td><td style='border:1px solid #003'>".$resTipoSpa["edad_inicio_cons"]."</td><td style='border:1px solid #003'>".$resTipoSpa["motivo_inicio_cons"]."</td></tr>";
						}
						$count++;
					}
				}
				else{
					$tipoSpaI="<td style='border:1px solid #003'>Sin consumo</td><td style='border:1px solid #003'>Sin consumo</td><td style='border:1px solid #003'>Sin consumo</td><td style='border:1px solid #003'>Sin consumo</td>";
				}
			}
			else{
				$tipoSpaI="<td style='border:1px solid #003' colspan='4'>Adolescente sin valoración</td>";			
			}
			$tabla.="<tr>";
				$tabla.="<td rowspan='".$count."' style='border:1px solid #003'>".$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"]."</td>";	
				$tabla.="<td rowspan='".$count."' style='border:1px solid #003'>".$adolescente["num_doc"]."</td>";	
				$tabla.="<td rowspan='".$count."' style='border:1px solid #003'>".$adolescente["id_numero_carpeta"]."</td>";	
				$tabla.=$tipoSpaI;
				$tabla.="<td  rowspan='".$count."' style='border:1px solid #003'>".$resPatCons["patron_consumo"]."</td><td style='border:1px solid #003' rowspan='".$count."'>".$resPatCons["patron_consumo_desc"]."</td>";
			$tabla.="</tr>";
			$tabla.=$tipoSpaII;	
		}
	}
	$tabla.="</table>";
	echo utf8_decode($tabla);
?>