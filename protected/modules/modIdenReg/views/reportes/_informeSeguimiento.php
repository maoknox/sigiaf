<?php //Yii::import('application.vendors.*'); require_once('pdftable/lib/pdftable.inc.php');
		require_once(Yii::getPathOfAlias('webroot').'/protected/vendors/pdftable/lib/pdftable.inc.php');
		//echo dirname(__FILE__);
		define('FPDF_FONTPATH','font/');
$pdf = new PDFTable('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->defaultFontFamily = 'Arial';
$pdf->defaultFontStyle  = '';
$pdf->defaultFontSize   = 9;
$edadActual=$operaciones->hallaEdad($adolescente["fecha_nacimiento"],date("Y-m-d"));
if(empty($adolescente["direccion"])){$adolescente["direccion"]="Sin Inf.";}
if(empty($adolescente["localidad"])){$adolescente["localidad"]="Sin Inf.";}
if(empty($adolescente["barrio"])){$adolescente["barrio"]="Sin Inf.";}
if(empty($adolescente["eps_adol"])){$adolescente["eps_adol"]="Sin Inf.";}
if(empty($adolescente["regimen_salud"])){$adolescente["regimen_salud"]="Sin Inf.";}


if(empty($adolescente["fecha_primer_ingreso"])){$adolescente["fecha_primer_ingreso"]="Sin Inf.";}
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
}
$consAcud=$consultaGeneral->consultaAcudiente();
if(empty($consAcud["nombres_familiar"])){$consAcud["nombres_familiar"]="Sin Inf.";}
if(empty($consAcud["apellidos_familiar"])){$consAcud["apellidos_familiar"]="Sin Inf.";}
if(empty($consAcud["tipo_doc"])){$consAcud["tipo_doc"]="Sin Inf.";}
if(empty($consAcud["num_doc_fam"])){$consAcud["num_doc_fam"]="Sin Inf.";}
if(empty($consAcud["parentesco"])){$consAcud["parentesco"]="Sin Inf.";}
if(empty($consAcud["localidad"])){$consAcud["localidad"]="Sin Inf.";}
if(empty($consAcud["barrio"])){$consAcud["barrio"]="Sin Inf.";}
if(empty($consAcud["direccion"])){$consAcud["direccion"]="Sin Inf.";}
if(empty($consAcud["estrato"])){$consAcud["estrato"]="Sin Inf.";}



if(!empty($consAcud)){
	$consultaGeneral->searchTerm=$consAcud["id_doc_familiar"];
	$telsAcud=$consultaGeneral->consultaTelAcud();
}			
$modeloPai->num_doc=$adolescente["num_doc"];
$paiActual=$modeloPai->consultaPAIActual();
//print_r($paiActual);
$modeloPai->id_pai=$paiActual["id_pai"];
//echo $modeloPai->id_pai;
$sancion="";
	$modeloInfJud->num_doc=$adolescente["num_doc"];
	$infJudicial=$modeloInfJud->consultaInfJudCabezote();
	if(!empty($infJudicial)){
		foreach($infJudicial as $pk=>$infJudicialNov){
			$infJud=$modeloInfJud->consultaNovInfJudCabezote($infJudicialNov["id_inf_judicial"]);
			if(!empty($infJud)){
				$infJudicial[$pk]=$infJud;
			}			
		}
		
		if(!empty($paiActual)){
			foreach($infJudicial as $infJudicialCompSan){				
				$resInfJud=$modeloCompSanc->consultaPaiSanc($infJudicialCompSan["id_inf_judicial"]);
				if(!empty($resInfJud)){
					if($paiActual["id_pai"]==$resInfJud["id_pai"]){
						$compSancInfJud[]=$infJudicialCompSan;
					}
				}
			}
		}
		else{
			$compSancInfJud=$infJudicial;
		}
		foreach($compSancInfJud as $infJudCab){
			$modeloInfJud->id_inf_judicial=$infJudCab["id_inf_judicial"];
			$delitos=$modeloInfJud->consultaDelito();
			foreach($delitos as $delito){
				$delRem.=$delito["del_remcespa"]." ";
			}
			$sancion.='
			<tr>
				<td colspan="3">'.utf8_decode("Remisión por:").' '.utf8_decode($infJudCab["nombre_instancia_rem"]).'</td>
			</tr>
			<tr>
				<td>'.utf8_decode("Sanción:").' '.utf8_decode($infJudCab["tipo_sancion"]).'</td>
				<td colspan="2">Delito: <br> '.utf8_decode($delRem).'</td>
			</tr><tr>
				<td>'.utf8_decode("Num. Juzgado:").' '.utf8_decode($infJudCab["juzgado"]).'</td>
				<td>Num. Proceso: '.utf8_decode($infJudCab["no_proceso"]).'</td>
				<td>'.utf8_decode("Tiempo sanción Meses:").' '.utf8_decode($infJudCab["tiempo_sancion"]).' - '.utf8_decode("Días:").' '.utf8_decode($infJudCab["tiempo_sancion_dias"]).' </td>
			</tr>
			<tr>
				<td >Juez: '.utf8_decode($infJudCab["juez"]).' </td>
				<td colspan="2">Defensor: '.utf8_decode($infJudCab["defensor"]).' </td>
			</tr>
		  ';
		}
	}
$table1='<table width="100%" border="1" cellpadding="0px" cellspacing="0px">
  <tr>
    <td colspan="2">Nombre: '.utf8_decode($adolescente["nombres"]).' '.utf8_decode($adolescente["apellido_1"]).' '.utf8_decode($adolescente["apellido_2"]).'</td>
	<td>'.utf8_decode("Número de carpeta").':'.CHtml::decode($adolescente["id_numero_carpeta"]).'</td>
  </tr>
  <tr>
    <td>
		Lugar y fecha de nacimiento<br>
		'.CHtml::encode($adolescente["departamento"]).'/'.CHtml::encode($adolescente["municipio"]).' - '.CHtml::encode($adolescente["fecha_nacimiento"]).'
	</td>
    <td colspan="2">Etnia: '.CHtml::encode($adolescente["etnia"]).'</td>
  </tr>
  <tr>
    <td > Edad: '.$edadActual.'</td>
    <td colspan="2">'.utf8_decode("Documento de identificación: ").' '.CHtml::encode($adolescente["num_doc"]).'</td>
  </tr>
  <tr>
    <td colspan="3">'.utf8_decode("Dirección: ").'
		'.utf8_decode($adolescente["direccion"]).' Localidad: '.utf8_decode($adolescente["localidad"]).' Barrio: '.utf8_decode($adolescente["barrio"]).' - '.utf8_decode("Teléfono: ").' '.$telefono.'
	</td>
  </tr>
  <tr>
    <td colspan="3">'.utf8_decode("Régimen de salud: ").'<div id="consRegSaludAdol" style="display:inline;">'.CHtml::encode($adolescente["regimen_salud"]).'</div>  - EPS: <div id="consEpsAdol" style="display:inline;">'.CHtml::encode($adolescente["eps_adol"]).'</div></td>
  </tr>
  <tr>
    <td colspan="3">Fecha de ingreso: '.CHtml::decode($adolescente["fecha_primer_ingreso"]).'</td>
  </tr>
  '.$sancion.'
   <tr>
    <td >'.utf8_decode("Psicólogo:").' '.utf8_decode($psicologo).'</td>
    <td colspan="2">Trabajador Social:  '.utf8_decode($trsoc).' </td>
  </tr>
	<tr>
    <td colspan="3">Nombre acudiente: '.utf8_decode($consAcud["nombres_familiar"]).' '.utf8_decode($consAcud["apellidos_familiar"]).'</td>
  </tr>
  <tr>
    <td colspan="3">'.utf8_decode("Dirección acudiente: ").'
		'.utf8_decode($consAcud["direccion"]).' Localidad: '.utf8_decode($consAcud["localidad"]).' Barrio: '.utf8_decode($consAcud["barrio"]).'|| '.utf8_decode("Teléfono: ").' '.$telefonoAcud.'
	</td>
  </tr>

</table>';
$pdf->htmltable($table1);
//INFORME GENERAL
if(!empty($seguimientos)){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('INFORME DE SEGUIMIENTO GENERAL'),0,0,'C');
	$pdf->Ln();
	foreach($seguimientos as $pk=>$seguimiento){
		$modeloSeguimiento->id_seguimientoadol="";
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'- Fecha del seguimiento: '.utf8_decode($seguimiento["fecha_seguimiento"]),0,0,'C');
		$pdf->Ln();	
		$pdf->Cell(0,5,'Tipo de seguimiento: '.utf8_decode($seguimiento["tipo_seguim"]),0,0,'J');
		$pdf->Ln(10);	
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(0,5,utf8_decode($seguimiento["seguimiento_adol"]));
		$pdf->Ln();	
		
		$modeloSeguimiento->id_seguimientoadol=$seguimiento["id_seguimientoadol"];
		$profAutorBool='true';
		$profAutor=$modeloSeguimiento->consultaProfSeg($profAutorBool,$seguimiento["fecha_registro_seg"],$seguimiento["id_seguimientoadol"]);
		if(!empty($profAutor)){
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,'Seguimiento realizado por: '.utf8_decode($profAutor["nombrespersonal"]));
			$pdf->Ln();	
			$pdf->Cell(0,5,'Cargo: '.utf8_decode($profAutor["nombre_rol"]));
			$pdf->Ln();	

		}
		$profAutorBool='false';
		$profApoyo=$modeloSeguimiento->consultaProfSeg($profAutorBool,$seguimiento["fecha_registro_seg"],$seguimiento["id_seguimientoadol"]);
		if(!empty($profApoyo)){
			$pdf->Ln();	
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,utf8_decode('Seguimiento apoyado por: '.$profApoyo["nombrespersonal"]));
			$pdf->Ln();	
			$pdf->Cell(0,5,'Cargo: '.utf8_decode($profApoyo["nombre_rol"]));
			$pdf->Ln();	
		}
		$pdf->Ln(10);
	}		
}
//INFORME SEGUIMIENTO POST-EGRESO
$seguimiento="";
if(!empty($seguimientoPEgreso)){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('INFORME DE SEGUIMIENTO POST-EGRESO'),0,0,'C');
	$pdf->Ln();
	foreach($seguimientoPEgreso as $pk=>$seguimiento){
		$modeloSeguimiento->id_seguimientoadol="";
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'- Fecha del seguimiento: '.utf8_decode($seguimiento["fecha_seguimiento"]),0,0,'C');
		$pdf->Ln();	
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(0,5,utf8_decode(htmlspecialchars($seguimiento["seguimiento_adol"])));
		$pdf->Ln();	
		
		$modeloSeguimiento->id_seguimientoadol=$seguimiento["id_seguimientoadol"];
		$profAutorBool='true';
		$profAutor=$modeloSeguimiento->consultaProfSeg($profAutorBool,$seguimiento["fecha_registro_seg"],$seguimiento["id_seguimientoadol"]);
		if(!empty($profAutor)){
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,'Seguimiento realizado por: '.utf8_decode($profAutor["nombrespersonal"]));
			$pdf->Ln();	
			$pdf->Cell(0,5,'Cargo: '.utf8_decode($profAutor["nombre_rol"]));
			$pdf->Ln();	

		}
		$profAutorBool='false';
		$profApoyo=$modeloSeguimiento->consultaProfSeg($profAutorBool,$seguimiento["fecha_registro_seg"],$seguimiento["id_seguimientoadol"]);
		if(!empty($profApoyo)){
			$pdf->Ln();	
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,utf8_decode('Seguimiento apoyado por: '.$profApoyo["nombrespersonal"]));
			$pdf->Ln();	
			$pdf->Cell(0,5,'Cargo: '.utf8_decode($profApoyo["nombre_rol"]));
			$pdf->Ln();	
		}
		$pdf->Ln(10);
	}		
}


//INFORME DE SEGUIMIENTO EN REFERENCIACIÓN
$countRef=0;
if(!empty($servicios)){
	
	foreach($servicios as $pk=>$servicio){
		$modeloRef->idRef=$servicio["id_referenciacion"];
		$consultaServicio=$modeloRef->consultaReferenciacion();	
		$modeloSegRefer->id_referenciacion=$servicio["id_referenciacion"];
		$seguimientosRefer=$modeloSegRefer->consSegReferAdol();
		if(!empty($seguimientosRefer)){
			$countRef+=1;
			if($countRef==1){
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,10,utf8_decode('INFORME SEGUIMIENTO DE REFERENCIACIÓN'),0,0,'C');
				$pdf->Ln();
			}
			
			$ind=$pk+1;
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,utf8_decode('Servicio '.$ind.":"),0,0,'J');
			$pdf->Ln();
			$pdf->SetFont('Arial','',12);
			$pdf->MultiCell(0,5,utf8_decode('Línea de acción: '.$consultaServicio["tipo_referenciacion"]));
			$pdf->Ln();	
			$pdf->MultiCell(0,5,utf8_decode('Especificación de nivel 1: '.$consultaServicio["esp_sol"]));
			$pdf->Ln();	
			if(empty($consultaServicio["esp_solii"])){
				$consultaServicio["esp_solii"]="N.A";
			}
			$pdf->MultiCell(0,5,utf8_decode('Especificación de nivel 2: '.$consultaServicio["esp_solii"]));
			$pdf->Ln();	
			if(empty($consultaServicio["esp_soliii"])){
				$consultaServicio["esp_soliii"]="N.A";
			}
			$pdf->MultiCell(0,5,utf8_decode('Especificación de nivel 3: '.$consultaServicio["esp_soliii"]));
			$pdf->Ln();	
			$pdf->MultiCell(0,5,utf8_decode('Beneficiario(s): '.$consultaServicio["beneficiario"]));
			$pdf->Ln();
			$pdf->MultiCell(0,5,utf8_decode('Estado de la referenciación: '.$consultaServicio["estado_ref"]));
			$pdf->Ln();	

			foreach($seguimientosRefer as $id=>$seguimientoRefer){
				$indI=$id+1;
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,10,utf8_decode($indI.' Fecha del seguimiento '.$seguimientoRefer["fecha_seg"].":"),0,0,'C');
				$pdf->Ln();
				$pdf->SetFont('Arial','',12);
				$pdf->MultiCell(0,5,utf8_decode($seguimientoRefer["seg_refer"]));
				$pdf->Ln();	
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,5,'Seguimiento realizado por: '.utf8_decode($seguimientoRefer["nombrespersonal"]));
				$pdf->Ln();	
				$pdf->Cell(0,5,'Cargo: '.utf8_decode($seguimientoRefer["nombre_rol"]));
				$pdf->Ln(10);	
			}
		}
		else{
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,utf8_decode('El adolescente no tiene seguimientos en esta referenciación '.$fecha_inicial.' y '.$fecha_fin),0,0,'C');
			$pdf->Ln();
		}
		
		$pdf->Ln(10);	
	}
}
//INFORME DE SEGUIMIENTO POST EGRESO SI TIENE.


//INFORME DE SEGUIMIENTO PSC SI TIENE
$count=0;
if(!empty($pscAdol)){
	foreach($pscAdol as $psc){
		$modeloSegPsc->id_psc=$psc["id_psc"];
		$modeloSegPsc->num_doc=$adolescente["num_doc"];
		$consultaSegPsc=$modeloSegPsc->consSeguimientosPsc();
		if(!empty($consultaSegPsc)){
			$count+=1;
			if($count==1){
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,10,utf8_decode('INFORME SEGUIMIENTO DE PRESTACIÓN DE SERVICIOS A LA COMUNIDAD'),0,0,'C');
				$pdf->Ln();
			}
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,utf8_decode(' Sector: '.$psc["sector_psc"]),0,0,'C');//institucionpsc
			$pdf->Ln();
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,utf8_decode(' Institución: '.$psc["institucionpsc"]),0,0,'C');//institucionpsc
			$pdf->Ln();
						
			foreach($consultaSegPsc as $id=>$seguimientoPsc){
				$indI=$id+1;
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,10,utf8_decode(' Fecha del seguimiento '.$seguimientoPsc["fecha_seg_ind"].":"),0,0,'C');
				$pdf->Ln();
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,10,utf8_decode(' Desarrollo de actividades '),0,0,'J');
				$pdf->Ln();
				$pdf->SetFont('Arial','',12);
				$pdf->MultiCell(0,5,utf8_decode($seguimientoPsc["desarrollo_act_psc"]));
				$pdf->Ln();	
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,10,utf8_decode(' Reporte de novedades '),0,0,'J');
				$pdf->Ln();
				$pdf->SetFont('Arial','',12);
				$pdf->MultiCell(0,5,utf8_decode($seguimientoPsc["reporte_nov_psc"]));
				$pdf->Ln();
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,10,utf8_decode(' Cumplimiento de acuerdos '),0,0,'J');
				$pdf->Ln();
				$pdf->SetFont('Arial','',12);
				$pdf->MultiCell(0,5,utf8_decode($seguimientoPsc["cump_acu_psc"]));
				$pdf->Ln();
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,5,'Seguimiento realizado por: '.utf8_decode($seguimientoPsc["nombrespersona"]));
				$pdf->Ln();	
				$pdf->Cell(0,5,'Cargo: '.utf8_decode($seguimientoPsc["nombre_rol"]));
				$pdf->Ln(10);	
			}
		}
	}
}
$countSGSJ=0;//modeloSeguimientoAsesoriasj
if(!empty($gestionesSJAdol)){
	foreach($gestionesSJAdol as $gestion){
		$modeloGestionSociojuridica->id_gestionsj=$gestion["id_gestionsj"];
		$seguimientosGSJ=$modeloGestionSociojuridica->consultaHistoricoSegGSJAdol();
		if(!empty($seguimientosGSJ)){
			$countSGSJ+=1;
			if($countSGSJ==1){
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,10,utf8_decode('INFORME SEGUIMIENTO GESTIÓN SOCIO-JURÍDICA'),0,0,'C');
				$pdf->Ln(10);
			}
			
			if(empty($gestion["remision_sj"])){$gestion["remision_sj"]="No aplica";}
			if(empty($gestion["dependencia_entidadsj"])){$gestion["dependencia_entidadsj"]="No aplica";}
			if(empty($gestion["tipo_gestionsj"])){$gestion["tipo_gestionsj"]="No aplica";}
			
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,utf8_decode('Motivo de la asesoría: '.$gestion["motivo_asesoriasj"]),0,0,'C');//institucionpsc
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,utf8_decode('A donde remite: '.$gestion["remision_sj"]),0,0,'C');//institucionpsc
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,utf8_decode('Dependencia-Entidad: '.$gestion["dependencia_entidadsj"]),0,0,'C');//institucionpsc
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,utf8_decode('Tipo de gestión: '.$gestion["tipo_gestionsj"]),0,0,'C');//institucionpsc
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,utf8_decode('Fecha de la gestión: '.$gestion["fecha_gestionsj"]),0,0,'C');//institucionpsc
			$pdf->Ln();			
			foreach($seguimientosGSJ as $seguimientoGSJ){
				$indI=$id+1;
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,10,utf8_decode('Fecha del seguimiento '.$seguimientoGSJ["fecha_seguimientogsj"].":"),0,0,'C');
				$pdf->Ln();
				$pdf->SetFont('Arial','',12);
				$pdf->MultiCell(0,5,utf8_decode($seguimientoGSJ["seguimiento_gestionsj"]));
				$pdf->Ln();	
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,5,'Seguimiento realizado por: '.utf8_decode($seguimientoGSJ["nombre_personal"]).' '.utf8_decode($seguimientoGSJ["apellidos_personal"]));
				$pdf->Ln();	
				$pdf->Cell(0,5,'Cargo: '.utf8_decode($seguimientoGSJ["nombre_rol"]));
				$pdf->Ln(10);	
			}
		}
	}	
}
$countSNutr=0;
if(!empty($valNutr) && !empty($seguimientosNutr)){
	foreach($seguimientosNutr as $seguimintoNutr){
		$countSNutr+=1;
		if($countSNutr==1){
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,utf8_decode('INFORME SEGUIMIENTO NUTRICIONAL'),0,0,'C');
			$pdf->Ln(10);
		}
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Fecha del seguimiento: '.$seguimintoNutr["fecha_segnutr"]),0,0,'J');//institucionpsc
		$pdf->Ln();	
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Modificación antecedentes de salud, alimentarios o clínicos:'),0,0,'J');//institucionpsc
		$pdf->Ln();
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(0,5,utf8_decode($seguimintoNutr["ant_salud_al_cl"]));
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Evaluación de cumplimiento a los objetivos alimentarios y nutricionales propuestaos: '),0,0,'J');//institucionpsc
		$pdf->Ln();
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(0,5,utf8_decode($seguimintoNutr["eval_cumpl_obj_alim"]));
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Diagnostico/Clasificación nutricional: '),0,0,'J');//institucionpsc
		$pdf->Ln();
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(0,5,utf8_decode($seguimintoNutr["diagnostico_clasif_nutr_na"]));
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,utf8_decode('Plan nutricional: '),0,0,'J');//institucionpsc
		$pdf->Ln();
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(0,5,utf8_decode($seguimintoNutr["plan_nutr"]));
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'Seguimiento realizado por: '.utf8_decode($seguimintoNutr["nombre_personal"]).' '.utf8_decode($seguimintoNutr["apellidos_personal"]));
		$pdf->Ln();	
		$pdf->Cell(0,5,'Cargo: '.utf8_decode($seguimintoNutr["nombre_rol"]));
		$pdf->Ln(10);	
	}
}


$pdf->Output(utf8_decode("Informe_Seguimiento_".$adolescente["nombres"])." ".utf8_decode($adolescente["apellido_1"].".pdf"),"D");
?>
