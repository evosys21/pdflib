<?php
/**
 * Pdf Advanced Multicell - Example
 */

require_once __DIR__ . '/../autoload.php';

use evosys21\PdfLib\Fpdf\Pdf;
use evosys21\PdfLib\Multicell;

// Pdf extends FPDF
$pdf = new Pdf();

// use the default FPDF configuration
$pdf->SetAuthor('Interpid');
$pdf->SetMargins(20, 20, 20);
$pdf->SetAutoPageBreak(true, 20);

$pdf->SetFont('helvetica', '', 11);
$pdf->SetTextColor(200, 10, 10);
$pdf->SetFillColor(254, 255, 245);

// add a page
$pdf->AddPage();


// Create the Advanced Multicell Object and inject the PDF object
$multicell = new Multicell($pdf);

// Set the styles for the advanced multicell
$multicell->setStyle('default', 11, '', [0, 0, 77], 'helvetica');
$multicell->setStyle('b', null, 'B');
$multicell->setStyle('i', null, 'I');
$multicell->setStyle('bi', null, 'BI');
$multicell->setStyle('u', null, 'U');
$multicell->setStyle('h', null, 'B', '203,0,48');
$multicell->setStyle('red', null, null, '255,0,0');
$multicell->setStyle('green', null, null, '0,255,0');
$multicell->setStyle('h1', 16, null, null, null, 'h');
$multicell->setStyle('h2', 14, null, null, null, 'h');
$multicell->setStyle('h3', 12, null, null, null, 'h');
$multicell->setStyle('h4', 11, null, null, null, 'h');

$s = "<h1><red>H1r<u>u</u><b>b</b><b><u>bu</u></b></red></h1>\n";
$s .= "<h2><green>H1r<u>u</u><b>b</b><b><u>bu</u></b></green></h2>\n";
$s .= "<h3><red>H1r<u>u</u><b>b</b><b><u>bu<green>g</green></u></b></red></h3>\n";
$multicell->multiCell(0, 5, $s);

// output the pdf
$pdf->Output();
