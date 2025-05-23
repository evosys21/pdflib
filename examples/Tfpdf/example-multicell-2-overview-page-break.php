<?php

/**
 * Pdf Advanced Multicell - Example
 */
require_once __DIR__ . '/autoload.php';

use EvoSys21\PdfLib\Examples\Tfpdf\PdfFactory;
use EvoSys21\PdfLib\Examples\Tfpdf\PdfSettings;
use EvoSys21\PdfLib\Multicell;

//get the PDF object
$pdf = PdfFactory::newPdf('multicell');

// Create the Advanced Multicell Object and inject the PDF object
$multicell = new Multicell($pdf);

// Set the styles for the advanced multicell
PdfSettings::setMulticellStyles($multicell);

$pdf->Ln(10); //line break

// create the advanced multicell
$title = file_get_contents(CONTENT_PATH . '/multicell-title.txt');
$multicell->multiCell(0, 5, $title, 1, 'J', 1, 3, 3, 3, 3);

$pdf->Ln(10); //line break

//read TAG formatted text from file
$txt = file_get_contents(CONTENT_PATH . '/multicell.txt');
$s = $txt . "\n\n\n\nRepeat the text to trigger a page break \n\n\n" . $txt;

//create an advanced multicell
$multicell->multiCell(0, 5, $s, 1, 'J', 1, 3, 3, 3, 3);

$pdf->Ln(10); //new line

// output the pdf
$pdf->Output();
