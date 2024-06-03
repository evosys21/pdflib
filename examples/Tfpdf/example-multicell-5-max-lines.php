<?php
/**
 * Pdf Advanced Multicell - Example
 */

require_once 'autoload.php';

use evosys21\PdfLib\Multicell;
use evosys21\PdfLib\Examples\Tfpdf\PdfFactory;
use evosys21\PdfLib\Examples\Tfpdf\PdfSettings;

$factory = new PdfFactory();

//get the PDF object
$pdf = PdfFactory::newPdf('multicell');

// Create the Advanced Multicell Object and inject the PDF object
$multicell = new Multicell($pdf);

// Set the styles for the advanced multicell
PdfSettings::setMulticellStyles($multicell);

$pdf->Ln(10); //line break

// create the advanced multicell
$title = file_get_contents(__DIR__ . '/content/multicell-title.txt');
$multicell->multiCell(0, 5, $title, 1, 'J', 1, 3, 3, 3, 3);

$pdf->Ln(10); //line break

//read TAG formatted text from file
$txt = file_get_contents(__DIR__ . '/content/multicell.txt');

$multicell->maxLines(7);
$multicell->multiCell(0, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);

$pdf->Ln(10); //line break

$multicell->maxHeight(30);
$multicell->multiCell(0, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);

// output the pdf
$pdf->Output();
