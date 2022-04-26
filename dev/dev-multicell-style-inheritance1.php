<?php
/**
 * Pdf Advanced Multicell - Example
 * Copyright (c), Interpid, http://www.interpid.eu
 */

require_once __DIR__ . '/../autoload.php';

use Interpid\PdfLib\Multicell;
use Interpid\PdfLib\Pdf;

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
$multicell->setStyle('base', 11, '', [0, 0, 77], 'helvetica');
$multicell->setStyle('h', null, 'B', '203,0,48');
$multicell->setTagStyle('b', ['style' => 'B']);
$multicell->setTagStyle('i', ['style' => 'I']);
$multicell->setTagStyle('bi', ['style' => 'BI']);
$multicell->setTagStyle('u', ['style' => 'U']);
$multicell->setTagStyle('red', ['color' => '255,0,0']);
$multicell->setTagStyle('green', ['color' => '0,255,0']);
$multicell->setTagStyle('h1', ['size' => 16], 'base');
$multicell->setTagStyle('h2', ['size' => 14], 'base');
$multicell->setTagStyle('h3', ['size' => 12], 'base');

$multicell->setTagStyle('p', ['size' => 11, 'style' => '', 'color' => '130,0,30', 'family' => 'helvetica']);

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
