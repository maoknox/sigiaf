<?php
$table1 = "
<table border=1 align=center>
  <tr> 
    <td rowspan=2 valign=middle border=0>rowspan=2, valign=middle</td>
    <td>Normal</td>
    <td>Normal</td>
    <td>Normal</td>
    <td colspan=2 rowspan=2 valign=bottom bgcolor=#FF00FF>colspan=2<br>rowspan=2<br>valign=bottom</td>
  </tr>
  <tr> 
    <td height=15>Normal</td>
    <td rowspan=2 align=right bgcolor=#aaaaaa border=0>rowspan=2</td>
    <td border=0>border=0</td>
  </tr>
  <tr> 
    <td>Normal</td>
    <td>Normal</td>
    <td>Normal</td>
    <td rowspan=3 valign=top bgcolor=#CC3366>rowspan=3</td>
    <td>Normal</td>
  </tr>
  <tr bgcolor=#cccccc> 
    <td>Normal</td>
    <td colspan=3 align=center>align center, colspan=3</td>
    <td>Normal</td>
  </tr>
  <tr> 
    <td align=right valign=bottom>align=right<br>valign=bottom</td>
    <td>Normal</td>
    <td>&nbsp;</td>
    <td>Normal</td>
    <td height=20>height=20</td>
  </tr>
</table>
";
define('FPDF_FONTPATH','font/');
require('C:\AppServ\www\implementacionCentroForjar\complementos\pdftable\lib\pdftable.inc.php');
$pdf = new PDFTable();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);

$pdf->Cell(0,10,utf8_decode('INFORME VALORACIÓN INICIAL INTEGRAL'),0,0,'C');
$pdf->Ln();
$pdf->htmltable($table1);
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,5,utf8_decode('La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar! La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar La primavera besaba suavemente la arboleda, y el verde nuevo brotaba como una verde humareda.  Las nubes iban pasando sobre el campo juvenil... Yo vi en las hojas temblando las frescas lluvias de abril.  Bajo ese almendro florido, todo cargado de flor -recordé-, yo he maldecido mi juventud sin amor. Hoy en mitad de la vida,me he parado a meditar... ¡Juventud nunca vivida,quién te volviera a soñar'));
$pdf->Output();
?>