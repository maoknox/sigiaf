<?php
	header("Content-type: application/vnd.ms-excel; name='excel'");  
	header("Content-Disposition: filename=repAdolescentes.xls");  
	header("Pragma: no-cache");  
	header("Expires: 0"); 
	$tabla='<table width="1024px" border="1">
		<tr>
			<td colspan="17" align="center" style="border:1px solid #000;background:#00CC66;">Datos b&aacute;sicos</td>
			<td colspan="5" align="center"  style="border:1px solid #000;background:#00CC66;">Localizaci&oacute;n</td>
			<!--<td colspan="17" align="center" style="border:1px solid #000;background:#00CC66;">Informaci&oacute;n judicial/Administrativa</td>-->
			<td colspan="4" align="center"  style="border:1px solid #000;background:#00CC66;">Vinculaci&oacute;n</td>
			<td colspan="6" align="center"  style="border:1px solid #000;background:#00CC66;">Derechos Forjar</td>
			<td colspan="6" align="center"  style="border:1px solid #000;background:#00CC66;">Derechos Defensor&iacute;a</td>
			<td colspan="9" align="center"  style="border:1px solid #000;background:#00CC66;">Documentos enviados</td>
			<td colspan="12" align="center"  style="border:1px solid #000;background:#00CC66;">Datos Acudiente</td>
			<td colspan="2" align="center"  style="border:1px solid #000;background:#00CC66;">Bina</td>
			<td colspan="5" align="center"  style="border:1px solid #000;background:#00CC66;">Estado Valoraciones</td>
		</tr>
  		<tr>
		<td>N&uacute;mero Carpeta</td>
		<td>Primer apellido</td>
		<td>Segundo apellido</td>
		<td>Nombres</td>
		<td>Tipo Documento</td>
		<td>Num. Identificaci&oacute;n</td>
		<td>Fecha Nacimiento</td>
		<td>Departamento Nacimento</td>
		<td>Municipio Nacimiento</td>
		<td>Sexo</td>
		<td>Edad Actual</td>
		<td>Edad al ingreso al centro</td>
		<td>Etnia</td>
		<td>&Uacute;ltimo a&ntilde;o aprobado</td>
		<td>Jornada educativa</td>
		<td>Seguridad Social</td>
		<td>Observaciones de registro</td>
		<td>Localidad</td>
		<td>Barrio</td>
		<td>Direcci&oacute;n</td>
		<td>Estrato socioecon&oacute;mico</td>
		<td>Telefonos</td>
		<!--<td>Remitido por</td>
		<td>Defensor de familia</td>
		<td>Defensor P&uacute;blico</td>
		<td>Juez</td>
		<td>Juzgado</td>
		<td>Numero de proceso</td>
		<td>Fecha de aprehensi&oacute;n </td>
		<td>Delito</td>
		<td>Estado del Proceso</td>
		<td>Tipo sanci&oacute;n</td>
		<td>Fecha imposici&oacute;n</td>
		<td>Fecha de remisi&oacute;n del CESPA</td>
		<td>Tiempo de la sanci&oacute;n meses</td>
		<td>Tiempo de la sanci&oacute;n d&iacute;as</td>
		<td>Observaciones</td>-->
		<td>Estado SIRBE</td>
		<td>Fecha primer ingreso al SRPA</td>
		<td>N&uacute;mero de ingresos</td>
		<td>Fecha de vinculaci&oacute;n al programa</td>
		<td>Identidad</td>
		<td>Salud</td>
		<td>Educaci&oacute;n</td>
		<td>Tener una familia</td>
		<td>Protecci&oacute;n</td>
		<td>Participaci&oacute;n</td>  
		<td>Identidad</td>
		<td>Salud</td>
		<td>Educaci&oacute;n</td>
		<td>Tener una familia</td>
		<td>Protecci&oacute;n</td>
		<td>Participaci&oacute;n</td>  
		<td>Formato de remisión del CESPA</td>
		<td>Copia documento de identificación</td>
		<td>Copia identificación de padres o acudiente</td>  
		<td>Copia de recibo de servicios públicos</td>
		<td>Carné de afiliación a seguridad social</td>
		<td>Acta de verificación de derechos</td>
		<td>Oficio remisorio del defensor de familia</td>
		<td>Tiene historia de atención del CESPA</td>
		<td>Acta de remisión del juzgado para cumplimento de sanción</td>
		<td>Apellidos acudiente</td>
		<td>Nombres</td>
		<td>Tipo documento</td>
		<td>Identificaci&oacute;n</td>  
		<td>Parentesco</td>
		<td>Localidad</td>
		<td>Barrio</td>
		<td>Direcci&oacute;n</td>
		<td>Estrato</td>
		<td>Tel&eacute;fono Principal</td>
		<td>Tel&eacute;fono Secundario</td>
		<td>Celular</td>
		<td>Psic&oacute;logo</td>
		<td>Trabajador social</td>
		<td>Psicolog&iacute;a</td>
		<td>Trabajo Social</td>
		<td>Terapia ocupacional</td>
		<td>Enfermer&iacute;a</td>
		<td>Psiquiatr&iacute;a</td>
	</tr>
';
	if(!empty($adolescentes)){
		foreach($adolescentes as $pk=>$adolescente){
			$estadoEscol="Escolarizado";
			if(empty($adolescente["estado_escol"])){
				$estadoEscol="No escolarizado";
			}
			$edadActual=$operaciones->hallaEdad($adolescente["fecha_nacimiento"],date("Y-m-d"));
			$tabla.="<tr>";
			$tabla.="<td>".$adolescente["id_numero_carpeta"]."</td>";
			$tabla.="<td>".$adolescente["apellido_1"]."</td>";
			$tabla.="<td>".$adolescente["apellido_2"]."</td>";
			$tabla.="<td>".$adolescente["nombres"]."</td>";
			$tabla.="<td>".$adolescente["tipo_doc"]."</td>";
			$tabla.="<td>".$adolescente["num_doc"]."</td>";
			$tabla.="<td>".$adolescente["fecha_nacimiento"]."</td>";
			$tabla.="<td>".$adolescente["departamento"]."</td>";
			$tabla.="<td>".$adolescente["municipio"]."</td>";
			$tabla.="<td>".$adolescente["sexo"]."</td>";
			$tabla.="<td>".$edadActual."</td>";
			$tabla.="<td>".$adolescente["edad_ingreso"]."</td>";			
			$tabla.="<td>".$adolescente["etnia"]."</td>";
			$tabla.="<td>".$estadoEscol."</td>";
			$tabla.="<td>N.A</td>";
			$tabla.="<td>".$adolescente["eps_adol"]."</td>";
			$tabla.="<td>N.A</td>";
			//consultar localización del adolescente
			$consultaGeneral->numDocAdol=$adolescente["num_doc"];			
			$locAdol=$consultaGeneral->consultaLocalAdol();
			if(empty($locAdol["localidad"])){$locAdol["localidad"]="Sin Inf.";}
			if(empty($locAdol["barrio"])){$locAdol["barrio"]="Sin Inf.";}
			if(empty($locAdol["direccion"])){$locAdol["direccion"]="Sin Inf.";}
			if(empty($locAdol["estrato"])){$locAdol["estrato"]="Sin Inf.";}
			$tabla.="<td>".$locAdol["localidad"]."</td>";
			$tabla.="<td>".$locAdol["barrio"]."</td>";
			$tabla.="<td>".$locAdol["direccion"]."</td>";
			$tabla.="<td>".$locAdol["estrato"]."</td>";
			//consulta telefonos
			$telAdol=$consultaGeneral->consultaTelefono();
			if(!empty($telAdol)){
				$tabla.="<td>".$telAdol[0]["tipo_telefono"].":".$telAdol[0]["telefono"]."</td>";	
			}
			else{
				$tabla.="<td>Sin Inf.</td>";
			}
			//consulta datos de remision
			$datosRemision==$consultaGeneral->consultaDatosRemision();
			if(empty($datosRemision["fecha_primer_ingreso"])){$datosRemision["fecha_primer_ingreso"]="Sin Inf.";}
			if(empty($datosRemision["num_ingresos"])){$datosRemision["num_ingresos"]="Sin Inf.";}
			if(empty($datosRemision["fecha_vinc_forjar"])){$datosRemision["fecha_vinc_forjar"]="Sin Inf.";}
			$tabla.="<td>Estado SIRBE</td>";
			$tabla.="<td>".$datosRemision["fecha_primer_ingreso"]."</td>";
			$tabla.="<td>".$datosRemision["num_ingresos"]."</td>";
			$tabla.="<td>".$datosRemision["fecha_vinc_forjar"]."</td>";
			$idInstanciaDer=1;
			$consultaDerechoAdolForjar=$modeloVerifDerechos->findAll('num_doc=:numDoc and id_instanciader=:id_instanciader',
				array(
				':numDoc'=>$adolescente["num_doc"],
				':id_instanciader'=>$idInstanciaDer
				)
			);	
			if(!empty($consultaDerechoAdolForjar)){		
				foreach($consultaDerechoAdolForjar as $derechoForjar){
					if($derechoForjar["estado_derecho"]==1){
						$tabla.="<td>Cumple</td>";					
					}
					else{
						$tabla.="<td>No cumple</td>";					
					}
				}
			}
			else{
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
			}

			$idInstanciaDer=2;
			$consultaDerechoAdolCespa=$modeloVerifDerechos->findAll('num_doc=:numDoc and id_instanciader=:id_instanciader',
				array(
				':numDoc'=>$adolescente["num_doc"],
				':id_instanciader'=>$idInstanciaDer
				)
			);
			if(!empty($consultaDerechoAdolCespa)){		
				foreach($consultaDerechoAdolCespa as $derechoCespa){
					if($derechoCespa["estado_derecho"]==1){
						$tabla.="<td>Cumple</td>";					
					}
					else{
						$tabla.="<td>No cumple</td>";					
					}
					
				}
			}
			else{
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
			}
			
			$consDocumentos=$consultaGeneral->consultaDocumentos();
			if(!empty($consDocumentos)){
				foreach($consDocumentos as $documento){
					$consultaGeneral->idDoccespa=$documento["id_doccespa"];
					$consDocRem=$consultaGeneral->consultaDocRemitido();
					if(!empty($consDocRem)){
						if($docRem["doc_presentado"]==1){
							$tabla.="<td>Presentado</td>";
						}
						else{
							$tabla.="<td>No presentado</td>";
						}
					}
					else{
						$tabla.="<td>Sin Inf.</td>";
					}					
				}			
			}
			$consAcud=$consultaGeneral->consultaAcudiente();
			if(!empty($consAcud)){
				if(empty($consAcud["nombres_familiar"])){$consAcud["nombres_familiar"]="Sin Inf.";}
				if(empty($consAcud["apellidos_familiar"])){$consAcud["apellidos_familiar"]="Sin Inf.";}
				if(empty($consAcud["tipo_doc"])){$consAcud["tipo_doc"]="Sin Inf.";}
				if(empty($consAcud["num_doc_fam"])){$consAcud["num_doc_fam"]="Sin Inf.";}
				if(empty($consAcud["parentesco"])){$consAcud["parentesco"]="Sin Inf.";}
				if(empty($consAcud["localidad"])){$consAcud["localidad"]="Sin Inf.";}
				if(empty($consAcud["barrio"])){$consAcud["barrio"]="Sin Inf.";}
				if(empty($consAcud["direccion"])){$consAcud["direccion"]="Sin Inf.";}
				if(empty($consAcud["estrato"])){$consAcud["estrato"]="Sin Inf.";}
								
				$tabla.="<td>".$consAcud["apellidos_familiar"]."</td>";
				$tabla.="<td>".$consAcud["nombres_familiar"]."</td>";
				$tabla.="<td>".$consAcud["tipo_doc"]."</td>";
				$tabla.="<td>".$consAcud["num_doc_fam"]."</td>";
				$tabla.="<td>".$consAcud["parentesco"]."</td>";
				$tabla.="<td>".$consAcud["localidad"]."</td>";
				$tabla.="<td>".$consAcud["barrio"]."</td>";
				$tabla.="<td>".$consAcud["direccion"]."</td>";
				$tabla.="<td>".$consAcud["estrato"]."</td>";
				$consultaGeneral->searchTerm=$consAcud["id_doc_familiar"];
				$telsAcud=$consultaGeneral->consultaTelAcud();
				if(!empty($telsAcud)){					
					$tabla.="<td>".$telsAcud[0]["telefono"]."</td>";
					$tabla.="<td>".$telsAcud[1]["telefono"]."</td>";
					$tabla.="<td>".$telsAcud[2]["telefono"]."</td>";				
				}
				else{
					$tabla.="<td>Sin Inf.</td>";
					$tabla.="<td>Sin Inf.</td>";
					$tabla.="<td>Sin Inf.</td>";
				}
			}
			else{
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
				$tabla.="<td>Sin Inf.</td>";
			}
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
			$estadoVal="";
			$consultaGeneral->term="valoracion_psicologia";
			$estadoVal=$consultaGeneral->consultaEstadoValoracion();
			if(!empty($estadoVal)){
				if(empty($estadoVal["estado_val"])){$estadoVal["estado_val"]="Sin Inf.";}
				$tabla.="<td>".$estadoVal["estado_val"]."</td>";
			}
			else{
				$tabla.="<td>Sin Inf.</td>";
			}
			$consultaGeneral->term="valoracion_trabajo_social";
			$estadoVal=$consultaGeneral->consultaEstadoValoracion();
			if(!empty($estadoVal)){
				if(empty($estadoVal["estado_val"])){$estadoVal["estado_val"]="Sin Inf.";}
				$tabla.="<td>".$estadoVal["estado_val"]."</td>";
			}
			else{
				$tabla.="<td>Sin Inf.</td>";
			}
			$consultaGeneral->term="valoracion_teo";
			$estadoVal=$consultaGeneral->consultaEstadoValoracion();
			if(!empty($estadoVal)){
				if(empty($estadoVal["estado_val"])){$estadoVal["estado_val"]="Sin Inf.";}
				$tabla.="<td>".$estadoVal["estado_val"]."</td>";
			}
			else{
				$tabla.="<td>Sin Inf.</td>";
			}
			$consultaGeneral->term="valoracion_enfermeria";
			$estadoVal=$consultaGeneral->consultaEstadoValoracion();
			if(!empty($estadoVal)){
				if(empty($estadoVal["estado_val"])){$estadoVal["estado_val"]="Sin Inf.";}
				$tabla.="<td>".$estadoVal["estado_val"]."</td>";
			}
			else{
				$tabla.="<td>Sin Inf.</td>";
			}
			$consultaGeneral->term="valoracion_psiquiatria";
			$estadoVal=$consultaGeneral->consultaEstadoValoracion();
			if(!empty($estadoVal)){
				if(empty($estadoVal["estado_val"])){$estadoVal["estado_val"]="Sin Inf.";}
				$tabla.="<td>".$estadoVal["estado_val"]."</td>";
			}
			else{
				$tabla.="<td>Sin Inf.</td>";
			}
			$tabla.="</tr>";
		}	
	}
	$tabla.="</table>";
	echo utf8_decode($tabla);
?>