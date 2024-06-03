<?php
/**
 * Pdf Advanced Multicell - Example
 */

require_once 'autoload.php';

use evosys21\PdfLib\Multicell;
use evosys21\PdfLib\Examples\Fpdf\PdfFactory;
use evosys21\PdfLib\Examples\Fpdf\PdfSettings;

$factory = new PdfFactory();

//get the PDF object
$pdf = PdfFactory::newPdf('multicell');

// Create the Advanced Multicell Object and inject the PDF object
$multicell = new Multicell($pdf);

// Set the styles for the advanced multicell
PdfSettings::setMulticellStyles($multicell);

$pdf->Ln(5); //line break
$multicell->multiCell(120, 5, "<h1>Multicell text shrinking feature</h1>");
$pdf->Ln(10); //line break

$txt = <<<EOL
This <b>TCPDF addon</b> allows creation of an <b>Advanced Multicell</b> which uses as input a <b>TAG based formatted string</b> instead of a simple string. The use of tags allows to change the font, the style (<b>bold</b>, <i>italic</i>, <u>underline</u>), the size, and the color of characters and many other features.

<h3>Features:</h3>
  - Text can be <hh>aligned</hh>, <hh>centered</hh> or <hh>justified</hh>
  - Different <font>Font</font>, <size>Sizes</size>, <style>Styles</style>, <color>Colors</color> can be used
EOL;

foreach(range(50, 10, 10) as $height){
    $multicell->multiCell(130, 5, "Height: $height");
    $pdf->Ln(1);
    $multicell->maxHeight($height)->shrinkToFit();
    $multicell->multiCell(140, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);
    $pdf->Ln(5);
}

$pdf->AddPage();

foreach(range(50, 10, 10) as $height){
    $width = 130 - $height;
    $multicell->multiCell(120, 5, "Height: <b>$height</b> Width: <b>$width</b>");
    $pdf->Ln(1);
    $multicell->maxHeight($height)->shrinkToFit();
    $multicell->multiCell($width, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);
    $pdf->Ln(5);
}

$pdf->AddPage();

$txt = <<<EOL
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
EOL;

foreach(range(50, 10, 10) as $height){
    $multicell->maxHeight($height)->shrinkToFit();
    $multicell->multiCell(100, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);
}

// output the pdf
$pdf->Output();
