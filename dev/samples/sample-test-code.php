<?php
/**
 * Pdf Advanced Multicell - Example
 */

require_once __DIR__ . '/../autoload.php';

$factory = new PdfFactory();

//get the PDF object
$pdf = PdfFactory::newPdf('multicell');

// Create the Advanced Multicell Object and inject the PDF object
$multicell = new Multicell($pdf);

// Set the styles for the advanced multicell
// Notice: 'default' style is valid for all tags(if defined)
$multicell->setStyle('default', 11, '', '130,0,30', 'helvetica');
$multicell->setStyle('p', null);
$multicell->setStyle('b', null, 'B');
$multicell->setStyle('i', null, 'I', '80,80,260');
$multicell->setStyle('u', null, 'U', '80,80,260');

//set the style for utf8 texts, use 'dejavusans' fonts
$multicell->setStyle('u8', null, '', [0, 45, 179], 'dejavusans');
$multicell->setStyle('u8b', null, 'B', null, null, 'u8');

$pdf->Ln(10); //line break

// create the advanced multicell
$title = file_get_contents(PDF_APPLICATION_PATH . '/content/multicell-title.txt');
$multicell->multiCell(0, 5, $title, 1, 'J', 1, 3, 3, 3, 3);

$pdf->Ln(10); //line break

//read TAG formatted text from file
$txt = file_get_contents(PDF_APPLICATION_PATH . '/content/multicell.txt');
$multicell->multiCell(0, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);

// output the pdf
$pdf->Output();
