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
// Notice: 'base' style is always inherited
$multicell->setStyle('base', 11, '', '130,0,30', 'helvetica');
$multicell->setStyle('p', null);
$multicell->setStyle('b', null, 'B');
$multicell->setStyle('i', null, 'I', '80,80,260');
$multicell->setStyle('u', null, 'U', '80,80,260');
$multicell->setStyle('h1', 14, 'B', '203,0,48');
$multicell->setStyle('h3', 12, 'B', '203,0,48');
$multicell->setStyle('h4', 11, 'BI', '0,151,200');
$multicell->setStyle('hh', 11, 'B', '255,189,12');
$multicell->setStyle('ss', 7, '', '203,0,48');
$multicell->setStyle('font', 10, '', '0,0,255');
$multicell->setStyle('style', 10, 'BI', '0,0,220');
$multicell->setStyle('size', 12, 'BI', '0,0,120');
$multicell->setStyle('color', 12, 'BI', '0,255,255');

$txt = '<p>';
for ($i = 0; $i < 100; $i++) {
    $txt .= "Line <b>$i</b>\n";
}

$txt .= '</p>';

//create an advanced multicell
$multicell->multiCell(0, 5, $txt, 1, 'J', 1, 0, 0, 0, 0);

$pdf->Ln(10); // new line

// send the pdf to the browser
$pdf->Output();
