<?php

/**
 * Pdf Advanced Multicell - Example
 */
require_once __DIR__ . '/autoload.php';

use EvoSys21\PdfLib\Examples\Fpdf\PdfFactory;
use EvoSys21\PdfLib\Examples\Fpdf\PdfSettings;
use EvoSys21\PdfLib\Multicell;

//get the PDF object
$pdf = PdfFactory::newPdf('multicell');

// Create the Advanced Multicell Object and inject the PDF object
$multicell = new Multicell($pdf);

// Set the styles for the advanced multicell
PdfSettings::setMulticellStyles($multicell);

$txt = 'This is a demo of <b>NON BREAKING > S P>A C E EXAMPLE</b>';

//create an advanced multicell
$multicell->multiCell(0, 5, 'Default line breaking characters:  ,.:;');
$multicell->multiCell(100, 5, $txt, 1, 'R', 0, 0, 1);
$pdf->Ln(10); //new line

//create an advanced multicell
$multicell->multiCell(0, 5, 'Setting > as line breaking character');
$multicell->setLineBreakingCharacters('>');
$multicell->multiCell(100, 5, $txt, 1);
$pdf->Ln(10); //new line

//create an advanced multicell
$multicell->multiCell(0, 5, 'Reseting the line breaking characters');
$multicell->resetLineBreakingCharacters();
$multicell->multiCell(100, 5, $txt, 1);
$pdf->Ln(10); //new line

//send the pdf to the browser
$pdf->Output();
