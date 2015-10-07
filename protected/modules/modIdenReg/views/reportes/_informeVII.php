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
			
			$compSancInfJud=$infJudicial;						
					
			if(!empty($infJudicial)){			
				foreach($infJudicial as $pkSan=>$infJudicialCompSan){				
					$resInfJud=$modeloCompSanc->consultaPaiSanc($infJudicialCompSan["id_inf_judicial"]);
					if(!empty($resInfJud)){
						if($paiActual["id_pai"]==$resInfJud["id_pai"]){
							$compSancInfJud[]=$infJudicialCompSan;
						}
					}					
				}
			}
		}
		else{
			$compSancInfJud=$infJudicial;
		}
		foreach($compSancInfJud as $infJudCab){
			$delRem="";
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

$conceptoIntegral=$consultaGeneral->consultaConcInt();
if(!empty($conceptoIntegral)){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('INFORME VALORACIÓN INTEGRAL'),0,0,'C');
	$pdf->Ln();
//consulta Concepto y plan de interveción psicología 
//$consultaGeneral->numDocAdol
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,utf8_decode('- Concepto Psicología:'),0,0,'J');
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$consultaGeneral->searchTerm="valoracion_psicologia";
$consultaGeneral->term="pry_plan_interv";
$proyPlanIntPsicol=$consultaGeneral->consultaCampoVal();	
if(!empty($proyPlanIntPsicol["pry_plan_interv"])){
	$pdf->MultiCell(0,5,utf8_decode($proyPlanIntPsicol["pry_plan_interv"]));
	$pdf->Ln();
	$consultaGeneral->searchTerm="id_valoracion_psicol";
	$consultaGeneral->term="profesional_valpsicol";
	$consultaGeneral->termi="fecha_regprvps";
	$consultaGeneral->termii=$proyPlanIntPsicol["id_valoracion_psicol"];
	$profesionalPsicol=$consultaGeneral->consultaProfValoracion();
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Concepto emitido por: '.utf8_decode($profesionalPsicol["nombres"]),0,0,'J');
}
else{
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('No hay un concepto de psicología definido'),0,0,'J');
}
//concepto trabajo social
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,utf8_decode('- Concepto Trabajo Social:'),0,0,'J');
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$consultaGeneral->searchTerm="valoracion_trabajo_social";
$consultaGeneral->term="pry_pl_int_tsocial";
$proyPlanIntTrSoc=$consultaGeneral->consultaCampoVal();	
if(!empty($proyPlanIntTrSoc["pry_pl_int_tsocial"])){
	$pdf->MultiCell(0,5,utf8_decode($proyPlanIntTrSoc["pry_pl_int_tsocial"]));
	$pdf->Ln();
	$consultaGeneral->searchTerm="id_valtsoc";
	$consultaGeneral->term="profesional_trsoc";
	$consultaGeneral->termi="fecha_regprvtrsoc";
	$consultaGeneral->termii=$proyPlanIntTrSoc["id_valtsoc"];
	$profesionalTrSoc=$consultaGeneral->consultaProfValoracion();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Concepto emitido por: '.utf8_decode($profesionalTrSoc["nombres"]),0,0,'J');
}
else{
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode('No hay un concepto de trabajo social definido'),0,0,'J');
}

//concepto Terapia ocupacional
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,utf8_decode('- Concepto Terapia Ocupacional:'),0,0,'J');
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$consultaGeneral->searchTerm="valoracion_teo";
$consultaGeneral->term="concepto_teo";
$proyPlanIntTO=$consultaGeneral->consultaCampoVal();	
if(!empty($proyPlanIntTO["concepto_teo"])){
	$pdf->MultiCell(0,5,utf8_decode($proyPlanIntTO["concepto_teo"]));
	$pdf->Ln();
	$consultaGeneral->searchTerm="id_valor_teo";
	$consultaGeneral->term="profesional_to";
	$consultaGeneral->termi="fecha_regprvto";
	$consultaGeneral->termii=$proyPlanIntTO["id_valor_teo"];
	$profesionalTO=$consultaGeneral->consultaProfValoracion();

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Concepto emitido por: '.utf8_decode($profesionalTO["nombres"]),0,0,'J');
}
else{
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,5,utf8_decode('No hay un concepto de terapia ocupacional'),0,0,'J');
}

//concepto Psiquiatría
$consultaGeneral->searchTerm="valoracion_psiquiatria";
$consultaGeneral->term="analisis_psiq";
$proyPlanIntPsiq=$consultaGeneral->consultaCampoVal();	
if(!empty($proyPlanIntPsiq["analisis_psiq"])){
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('- Concepto Psiquiatría:'),0,0,'J');
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0,5,utf8_decode($proyPlanIntPsiq["analisis_psiq"]));
	$pdf->Ln();
	$consultaGeneral->searchTerm="id_val_psiquiatria";
	$consultaGeneral->term="profesional_valpsiq";
	$consultaGeneral->termi="fecha_regprvpsiq";
	$consultaGeneral->termii=$proyPlanIntPsiq["id_val_psiquiatria"];
	$profesionalPsiq=$consultaGeneral->consultaProfValoracion();

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Concepto emitido por: '.utf8_decode($profesionalPsiq["nombres"]),0,0,'J');
}
$consultaGeneral->searchTerm="valoracion_nutricional";
$consultaGeneral->term="concepto_nutr";
$proyConcIntNutr=$consultaGeneral->consultaCampoVal();	
if(!empty($proyConcIntNutr["concepto_nutr"])){
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('- Concepto Nutricional:'),0,0,'J');
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0,5,utf8_decode($proyConcIntNutr["concepto_nutr"]));
	$pdf->Ln();
	$consultaGeneral->searchTerm="id_val_nutricion";
	$consultaGeneral->term="profesional_valnutr";
	$consultaGeneral->termi="fecha_regprvnutr";
	$consultaGeneral->termii=$proyConcIntNutr["id_val_nutricion"];
	$profesionalNutr=$consultaGeneral->consultaProfValoracion();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,'Concepto emitido por: '.utf8_decode($profesionalNutr["nombres"]),0,0,'J');
}

//concepto integral
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,utf8_decode('- Concepto Integral:'),0,0,'J');
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$consultaGeneral->searchTerm="concepto_integral";
$consultaGeneral->term="concepto_integral";
$concInt=$consultaGeneral->consultaCampoVal();	
if(!empty($concInt["concepto_integral"])){
	$pdf->MultiCell(0,5,utf8_decode($concInt["concepto_integral"]));
	$pdf->Ln();
}
else{
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,5,utf8_decode('No hay un concepto integral definido'),0,0,'J');
}

$tablaFirmas='<table width="100%" border="1"  cellpadding="0px" cellspacing="0px" align="center">'.
'<tr><td></td><td></td></tr>'.
'<tr><td align="center">'.utf8_decode("Psicología").'</td><td align="center">Trabajo social</td></tr>'.
'<tr><td></td><td></td></tr>'.
'<tr><td align="center">'.utf8_decode("Psiquiatría").'</td><td align="center">Terapia ocupacional</td></tr>'.
'<tr><td></td><td></td></tr>'.
'<tr><td align="center">Nutricionista</td><td align="center"></td></tr>'.
'<tr><td colspan="2">'.utf8_decode("fecha de la valoración: ").' '.$conceptoIntegral["fecha_concint"].'</td></tr>'.
'</table>';
$pdf->htmltable($tablaFirmas);
}
else{
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,5,utf8_decode("El adolescente aún no tiene un concepto ingegral"),0,0,'J');
	
}
$pdf->Output(utf8_decode("Informe_Valoración_".$adolescente["nombres"])." ".utf8_decode($adolescente["apellido_1"].".pdf"),"D");
?>
