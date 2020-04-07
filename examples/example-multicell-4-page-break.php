<?php
/**
 * Pdf Advanced Multicell - Example
 * Copyright (c), Interpid, http://www.interpid.eu
 */

require_once __DIR__ . '/../autoload.php';

use Interpid\PdfLib\Multicell;
use Interpid\PdfExamples\PdfFactory;

$factory = new PdfFactory();

//get the PDF object
$pdf = PdfFactory::newPdf('multicell');

// Create the Advanced Multicell Object and inject the PDF object
$multicell = new Multicell($pdf);

// Set the styles for the advanced multicell
$multicell->setStyle('p', 11, '', '130,0,30', $pdf->getDefaultFontName());
$multicell->setStyle('b', 11, 'B', '130,0,30', $pdf->getDefaultFontName());
$multicell->setStyle('i', 11, 'I', '80,80,260', $pdf->getDefaultFontName());
$multicell->setStyle('u', 11, 'U', '80,80,260', $pdf->getDefaultFontName());
$multicell->setStyle('h1', 14, 'B', '203,0,48', $pdf->getDefaultFontName());
$multicell->setStyle('h3', 12, 'B', '203,0,48', $pdf->getDefaultFontName());
$multicell->setStyle('h4', 11, 'BI', '0,151,200', $pdf->getDefaultFontName());
$multicell->setStyle('hh', 11, 'B', '255,189,12', $pdf->getDefaultFontName());
$multicell->setStyle('ss', 7, '', '203,0,48', $pdf->getDefaultFontName());
$multicell->setStyle('font', 10, '', '0,0,255', $pdf->getDefaultFontName());
$multicell->setStyle('style', 10, 'BI', '0,0,220', $pdf->getDefaultFontName());
$multicell->setStyle('size', 12, 'BI', '0,0,120', $pdf->getDefaultFontName());
$multicell->setStyle('color', 12, 'BI', '0,255,255', $pdf->getDefaultFontName());

$txt2 = '<p>';
for ($i = 0; $i < 100; $i++) {
    $txt2 .= "Line <b>$i</b>\n";
}

$txt2 .= '</p>';

//create an advanced multicell
$multicell->multiCell(0, 5, $txt2, 1, 'J', 1, 0, 0, 0, 0);
$pdf->Ln(10); // new line


// send the pdf to the browser
$pdf->Output();
