<?php
/**
 * Pdf Advanced Multicell - Example
 */

require_once __DIR__ . '/autoload.php';

use evosys21\PdfLib\Multicell;
use evosys21\PdfLib\Examples\Tcpdf\PdfFactory;
use evosys21\PdfLib\Examples\Tcpdf\PdfSettings;

$factory = new PdfFactory();

//get the PDF object
$pdf = PdfFactory::newPdf('multicell');

// Create the Advanced Multicell Object and inject the PDF object
$multicell = new Multicell($pdf);

// Set the styles for the advanced multicell
PdfSettings::setMulticellStyles($multicell);

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
