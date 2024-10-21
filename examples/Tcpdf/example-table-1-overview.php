<?php
/**
 * Pdf Advanced Table - Example
 */

require_once __DIR__ . '/autoload.php';

use EvoSys21\PdfLib\Multicell;
use EvoSys21\PdfLib\Examples\Tcpdf\PdfFactory;
use EvoSys21\PdfLib\Examples\Tcpdf\PdfSettings;

//get the PDF object
$pdf = PdfFactory::newPdf('table');

// Create the Advanced Multicell Object and inject the PDF object
$multicell = new Multicell($pdf);

// Set the styles for the advanced multicell
PdfSettings::setMulticellStyles($multicell);

//simple table
$multicell->multiCell(0, 5, "<p size='10' > ~~~Simple table:</p>");
require(__DIR__ . '/table/code-example1.php');

//cells can be multicells and images
$pdf->Ln(10);
$multicell->multiCell(0, 5, "<p size='10' > ~~~Cells can be <b>advanced multicells</b> and <b>images</b>:</p>");
require(__DIR__ . '/table/code-example2.php');

//example -   Multiple header rows, rowspans, colspans
$pdf->Ln(10);
$multicell->multiCell(0, 5, "<p size='10' > ~~~Multiple header rows, rowspans, colspans:</p>");
require(__DIR__ . '/table/code-example3.php');

//example - Transparent background
$pdf->Ln(10);
$multicell->multiCell(0, 5, "<p size='10' > ~~~ Transparent Background:</p>");
require(__DIR__ . '/table/code-example-transparent.php');


//example - all parameters can be overwritten
$pdf->Ln(10);
$multicell->multiCell(0, 5, "<p size='10' > ~~~Different alignments:</p>");
require(__DIR__ . '/table/code-example-alignments.php');

//send the pdf to the browser
$pdf->Output();
