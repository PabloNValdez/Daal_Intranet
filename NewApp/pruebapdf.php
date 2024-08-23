<?php
require 'vendor/autoload.php';
use Fpdf\Fpdf;

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, '¡Hola, Mundo!');
$pdf->Output('I', 'hola_mundo.pdf');
