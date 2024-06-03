<?php
/**
 * Pdf Advanced Multicell - Example
 */

require_once 'autoload.php';

use Interpid\PdfLib\Multicell;
use Interpid\PdfExamples\PdfFactory;
use Interpid\PdfExamples\PdfSettings;

$factory = new PdfFactory();

//get the PDF object
$pdf = PdfFactory::newPdf('multicell');

// Create the Advanced Multicell Object and inject the PDF object
$multicell = new Multicell($pdf);

// Set the styles for the advanced multicell
PdfSettings::setMulticellStyles($multicell);

$pdf->Ln(10); //line break

// create the advanced multicell
$title = file_get_contents(PDF_APPLICATION_PATH . '/content/multicell-title.txt');
$multicell->multiCell(0, 5, $title, 1, 'J', 1, 3, 3, 3, 3);

$pdf->Ln(10); //line break


//read TAG formatted text from file
$txt = file_get_contents(PDF_APPLICATION_PATH . '/content/multicell.txt');
$s = $txt . "\n\n\n\nRepeat the text to trigger a page break \n\n\n" . $txt;

//create an advanced multicell
$multicell->multiCell(0, 5, $s, 1, 'J', 1, 3, 3, 3, 3);

$pdf->Ln(10); //new line

// output the pdf
$pdf->Output();
