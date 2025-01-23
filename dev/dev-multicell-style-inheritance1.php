<?php

/**
 * Pdf Advanced Multicell - Example
 */
require_once __DIR__ . '/../autoload.php';

use EvoSys21\PdfLib\Fpdf\Pdf;
use EvoSys21\PdfLib\Multicell;

// Pdf extends FPDF
$pdf = new Pdf();

// use the default FPDF configuration
$pdf->SetAuthor('EvoSys21');
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
$multicell->setStyle('h', null, 'B', '203,0,48');
$multicell->setStyleAssoc('b', ['style' => 'B']);
$multicell->setStyleAssoc('i', ['style' => 'I']);
$multicell->setStyleAssoc('bi', ['style' => 'BI']);
$multicell->setStyleAssoc('u', ['style' => 'U']);
$multicell->setStyleAssoc('red', ['color' => '255,0,0']);
$multicell->setStyleAssoc('green', ['color' => '0,255,0']);
$multicell->setStyleAssoc('h1', ['size' => 16], 'default');
$multicell->setStyleAssoc('h2', ['size' => 14], 'default');
$multicell->setStyleAssoc('h3', ['size' => 12], 'default');

$multicell->setStyleAssoc('p', ['size' => 11, 'style' => '', 'color' => '130,0,30', 'family' => 'helvetica']);

// Set the styles for the advanced multicell
$multicell->setStyle('p', 11, '', '130,0,30', 'helvetica');
$multicell->setStyle('b', 11, 'B', '130,0,30', 'helvetica');
$multicell->setStyle('i', 11, 'I', '80,80,260', 'helvetica');

$s = "<h1><red>H1r<u>u</u><b>b</b><b><u>bu</u></b></red></h1>\n";
$s .= "<h2><green>H1r<u>u</u><b>b</b><b><u>bu</u></b></green></h2>\n";
$s .= "<h3><red>H1r<u>u</u><b>b</b><b><u>bu<green>g</green></u></b></red></h3>\n";
$multicell->multiCell(0, 5, $s);

// output the pdf
$pdf->Output();
