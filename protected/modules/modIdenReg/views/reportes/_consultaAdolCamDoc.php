<?php		
	if(!empty($adolescentes)){
		header ('Content-type: text/html; charset=utf-8');
		header("Content-type: application/vnd.ms-excel; name='excel'");
		header("Content-Disposition: filename=repAdolCamDoc".date("d/m/Y")."-".$opt.".xls");
		header("Pragma: no-cache");  
		header("Expires: 0");  
		//calculaEdad($fechaNac,$numCaso,$fechaVincProg)
		//tipo documento
		//1 cédula de ciudadania
		//2 documento de extranjería
		//3 Tarjeta de identidad
		//4	NUIP 
		//5 NIP
		//6 Registro Civil
		//7 No sabe
		//8 No responde
		
		//0 No necesita gestionar nuevo documento
		//1 debe cambiar de registro civil de nacimiento a tarjeta de identidad
		//2 debe cambiar de tarjeta de identidad a cedula.
		$cabezoteTabla ='<div class="formGeneral"><table width="1024px" border="1">
			<tr>
			<td  align="center" style="border:1px solid #000;background:#00CC66;">N&oacute;mero carpeta</td>
			<td  align="center"  style="border:1px solid #000;background:#00CC66;">Nombre Adolescente</td>
			<td  align="center"  style="border:1px solid #000;background:#00CC66;">Tipo de documento</td>
			<td  align="center"  style="border:1px solid #000;background:#00CC66;">N&uacute;mero de documento</td>
			<td  align="center"  style="border:1px solid #000;background:#00CC66;">Cambio de documento</td>
			<td  align="center"  style="border:1px solid #000;background:#00CC66;">Trabajador Social</td>
			<td  align="center"  style="border:1px solid #000;background:#00CC66;">Psic&oacute;logo</td>
			<td  align="center"  style="border:1px solid #000;background:#00CC66;">Edad</td>
			<td  align="center"  style="border:1px solid #000;background:#00CC66;">Fecha Nacimiento</td>
			</tr>';
		$tabla="";
		foreach($adolescentes as $adolescente){
			$edadActual=$operaciones->hallaEdad($adolescente["fecha_nacimiento"],date("Y-m-d"));
			if($adolescente["id_tipo_doc"]==6){
				$cambio=1;
			}
			elseif($resConsAdol["id_tipo_doc"]==3 && $edadActual>=18){
				$cambio=2;
			}
			else{
				$cambio=0;
			}
			$tabla.="<tr><td>".$adolescente["id_numero_carpeta"]."</td>";
			$tabla.="<td>".$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"]."</td>";
			$tabla.="<td>".$adolescente["tipo_doc"]."</td>";
			$tabla.="<td>".$adolescente["num_doc"]."</td>";
			$tabla.="<td>".$cambio."</td>";
			$consultaGeneral->numDocAdol=$adolescente["num_doc"];			
			$equipoPsic=$consultaGeneral->consultaEquipoPsicoSoc();
			if(!empty($equipoPsic)){
				$psicologo="Aún no asignado";
				$trsoc="Aún no asignado";
				foreach($equipoPsic as $persona){
					if($persona["id_rol"]==4){
						$psicologo=$persona["nombre_personal"]." ".$persona["apellidos_personal"];
					}
					else{
						$trsoc=$persona["nombre_personal"]." ".$persona["apellidos_personal"];
					}					
				}
				$tabla.="<td>".$psicologo."</td>";
				$tabla.="<td>".$trsoc."</td>";
			}
			else{
				$tabla.="<td>Aún no asignado</td>";
				$tabla.="<td>Aún no asignado</td>";
			}
			$tabla.="<td>".$edadActual."</td>";
			$tabla.="<td>".$adolescente["fecha_nacimiento"]."</td></tr>";
		}	
		$pieTabla='</table>';
		echo utf8_decode($cabezoteTabla.$tabla.$pieTabla);
	
	}
	else{?>
        <hr />
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        CENTRO FORJAR
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        
                        <div class="col-lg-9 text-justify">
                            No hay registrado aún adolescentes
                        </div>
                    </div>
                </div>
            </div>
        <hr />
		
	<?php }
	
/*	$sqlConsAdol="select a.num_doc,nombres,apellido_1,apellido_2,a.id_tipo_doc,fecha_nacimiento,numero_carpeta,tipo_doc from adolescente as a left join proceso_adol as b on b.num_doc=a.num_doc left join tipo_doc as c on c.id_tipo_doc=a.id_tipo_doc order by numero_carpeta asc";
	$queryConsAdol=pg_query($linkBd,$sqlConsAdol);
	if(pg_num_rows($queryConsAdol)>0){
		while($resConsAdol=pg_fetch_array($queryConsAdol)){
			$edad=$this->calculaEdad($resConsAdol["fecha_nacimiento"],0,"");
			if($resConsAdol["id_tipo_doc"]==6){
				$cambio=1;
			}
			elseif($resConsAdol["id_tipo_doc"]==3 && $edad>=18){
				$cambio=2;
			}
			else{
				$cambio=0;
			}
			$sqlConsProf="select * from personal_adol as a left join personal as b on a.id_cedula=b.id_cedula left join cargo as c on c.id_cargo=b.id_cargo where a.num_doc='".$resConsAdol["num_doc"]."'";
			$queryConsProf=pg_query($linkBd,$sqlConsProf);
			while($resConsProf=pg_fetch_array($queryConsProf)){
				if($resConsProf["id_cargo"]==4){
					$Ps=$resConsProf["nombres_personal"]." ".$resConsProf["apellidos_personal"];
				}
				elseif($resConsProf["id_cargo"]==7){
					$Ts=$resConsProf["nombres_personal"]." ".$resConsProf["apellidos_personal"];
				}
			}
			$cuerpoTabla.='<tr>
				<td>'.$resConsAdol["numero_carpeta"].'</td>
				<td>'.$resConsAdol["nombres"].' '.$resConsAdol["apellido_1"].' '.$resConsAdol["apellido_2"].'</td>
				<td>'.$resConsAdol["tipo_doc"].'</td>
				<td>'.$resConsAdol["num_doc"].'</td>
				<td>'.$cambio.'</td>
				<td>'.$Ts.'</td>
				<td>'.$Ps.'</td>
				<td>'.$edad.'</td>
				<td>'.$resConsAdol["fecha_nacimiento"].'</td>
				</tr>';
		}
		
	}
*/			
?>