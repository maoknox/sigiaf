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
		foreach($infJudicial as $infJudCab){
			$modeloInfJud->id_inf_judicial=$infJudCab["id_inf_judicial"];
			$delitos=$modeloInfJud->consultaDelito();
			$delRem="";
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
			</tr>
			<tr>
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
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('INFORME PLAN DE ATENCIÓN INTEGRAL (PAI)'),0,0,'C');
	$pdf->Ln();
	
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
	$pdf->Ln();
$fechaPai=$modeloPai->fecha_modif_pai;

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,utf8_decode('- Derechos:'),0,0,'J');
$pdf->Ln();
$pdf->SetFont('Arial','',12);

$tablaPAI='<table width="100%" border="1" cellpadding="0px" cellspacing="0px"><tr>'.
'<td>'.utf8_decode("COMPONENTE / SITUACIÓN").'</td>'.
'<td>OBJETIVO</td>'.
'<td>ACTIVIDADES</td>'.
'<td>INDICADOR</td>.
<td>RESPONSABLE</td></tr></table>';
foreach($derechos as $pk=>$derecho){
	$idPai=$modeloCompDer->id_pai;
	$modeloCompDer->unsetAttributes();
	$modeloCompDer->id_pai=$idPai;
	$modeloCompDer->id_derechocespa=$derecho["id_derechocespa"];
	$modeloCompDer->num_doc=$numDocAdol;
	$derechoAdolPai="";
	$derechoAdolPai=$modeloCompDer->consultaPaiDerechoAdol();
	$modeloCompDer->attributes=$derechoAdolPai;
	$modeloCompDer->fecha_estab_compderecho=$derechoAdolPai["fecha_estab_compderecho"];
	if(!empty($derechoAdolPai)){
		$tablaPAI.='<tr>';
		$tablaPAI.='<td>'.utf8_decode($derecho["derechocespa"]).'<br /> <hr />'.utf8_decode($modeloCompDer->derecho_compderecho).'</td>';
		$tablaPAI.='<td>'.str_replace("?","-",utf8_decode($modeloCompDer->objetivo_compderecho)).'</td>';
		$tablaPAI.='<td>'.str_replace("?","-",utf8_decode($modeloCompDer->actividades_compderecho)).'</td>';
		$tablaPAI.='<td>'.str_replace("?","-",utf8_decode($modeloCompDer->indicadores_compderecho)).'</td>';
		$tablaPAI.='<td>'.str_replace("?","-",utf8_decode($modeloCompDer->responsable_compderecho)).'</td>';	
		$tablaPAI.='</tr>';
	}
}
$pdf->htmltable($tablaPAI);
$pdf->Ln(10);
if(!empty($infJudicialSanPai)){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,utf8_decode('- Sanción:'),0,0,'J');
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$tablaPAISanc='<table width="100%" border="1" cellpadding="0px" cellspacing="0px"><tr>'.
	'<td>'.utf8_decode("SANCIÓN / SITUACIÓN").'</td>'.
	'<td>OBJETIVO</td>'.
	'<td>ACTIVIDADES</td>'.
	'<td>INDICADOR</td>.
	<td>RESPONSABLE</td></tr></table>';
	
	foreach($infJudicialSanPai as $infJudicialPai){
		$modeloCompSanc->id_inf_judicial=$infJudicialPai["id_inf_judicial"];
		$modeloCompSanc->num_doc=$numDocAdol;
		$consCompSancPai=$modeloCompSanc->consultaPaiSancAdol();	
		$modeloCompSanc->attributes=$consCompSancPai;
		$modeloCompSanc->fecha_establec_compsanc=$consCompSancPai["fecha_establec_compsanc"];
			//print_r($consCompSancPai);
			if(!empty($modeloCompSanc->objetivo_compsanc)){
	
				$tablaPAISanc.='<tr>';
				$tablaPAISanc.='<td>';
				$modeloInfJud->id_inf_judicial=$modeloCompSanc->id_inf_judicial;
				$delitos=$modeloInfJud->consultaDelito();  
				foreach($delitos as $delito){
					$tablaPAISanc.=utf8_decode($delito["del_remcespa"])."<br/>";
				}
				$tablaPAISanc.='</td>';
				$tablaPAISanc.='<td>'.utf8_decode($modeloCompSanc->objetivo_compsanc).'</td>';
				$tablaPAISanc.='<td>'.utf8_decode($modeloCompSanc->actividades_compsanc).'</td>';
				$tablaPAISanc.='<td>'.utf8_decode($modeloCompSanc->indicador_compsanc).'</td>';
				$tablaPAISanc.='<td>'.utf8_decode($modeloCompSanc->responsable_compsancion).'</td>';
				$tablaPAISanc.='</tr>';
			}
	}
	
	$pdf->htmltable($tablaPAISanc);
	$pdf->Ln();
}

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,utf8_decode('-----------------------------------------------------------------------------------------------------------'),0,0,'J');
$pdf->Ln();

$tablaFirmas='<table width="100%" border="1"  cellpadding="0px" cellspacing="0px" align="center">'.
'<tr><td>'.utf8_decode($resConsAdol["nombres"]).' '.utf8_decode($resConsAdol["apellido_1"]).' '.utf8_decode($resConsAdol["apellido_2"]).'
</td>'.
'<td></td></tr>'.
'<tr><td align="center">Adolescente</td><td align="center">Acudiente</td></tr>'.
'<tr><td></td><td></td></tr>'.
'<tr><td align="center">'.utf8_decode("Psicólogo").'</td><td align="center">Trabajador social</td></tr>'.
'<tr><td colspan="2"></td></tr>'.
'<tr><td colspan="2" align="center">Otro profesional</td></tr>'.
'<tr><td colspan="2">'.utf8_decode("fecha de la actuación: ").$fechaPai.'</td></tr>'.
'</table>';
$pdf->htmltable($tablaFirmas);

$pdf->Output(utf8_decode("Informe_PAI_".$adolescente["nombres"])." ".utf8_decode($adolescente["apellido_1"].".pdf"),"D");
?>
