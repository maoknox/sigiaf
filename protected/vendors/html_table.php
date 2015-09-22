<?php
require('C:\AppServ\www\implementacionCentroForjar\complementos\fpdf.php');
class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('C:\AppServ\www\implementacionCentroForjar\imagenes\SDIS.png',10,13,20);
	$this->Image('C:\AppServ\www\implementacionCentroForjar\imagenes\SDIS.png',31,13,20);

    // Arial bold 15
    $this->SetFont('Arial','B',12);
    // Movernos a la derecha
    $this->Cell(100);
    // Título
    $this->Cell(30,10,'CENTRO FORJAR',0,0,'C');
	$this->Ln();
    $this->Cell(50);
	$this->MultiCell(0,5,utf8_decode('Estregia de atención integral especializada para jóvenes que han sido vinculados al Sistema de Responsabilidad Penal Adolescente'),0,'C',false);

    // Salto de línea
    $this->Ln(10);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}
}


?>