<?php
/**
 * Pdf Advanced Multicell - Example
 */

use Interpid\PdfExamples\PdfSettings;

$factory = new DevFactory();

// Create the Advanced Multicell Object and inject the PDF object
$multicell = DevFactory::multicell();
$pdf = $multicell->getPdfObject();

$txt = file_get_contents(CONTENT_PATH . '/multicell.txt');

$txt = PdfSettings::$textExtraLong . "\n\n" . PdfSettings::$textSubSuperscript;

$multicell->multiCell(0, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);

//$multicell->maxLines(3)->shrinkToFit();

$txt = <<<EOL
This <b>TCPDF addon</b> allows creation of an <b>Advanced Multicell</b> which uses as input a <b>TAG based formatted string</b> instead of a simple string. The use of tags allows to change the font, the style (<b>bold</b>, <i>italic</i>, <u>underline</u>), the size, and the color of characters and many other features.

<h3>Features:</h3>
  - Text can be <hh>aligned</hh>, <hh>centered</hh> or <hh>justified</hh>
  - Different <font>Font</font>, <size>Sizes</size>, <style>Styles</style>, <color>Colors</color> can be used
EOL;

$multicell->maxHeight(20)->shrinkToFit();
$multicell->multiCell(100, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);

//$multicell->maxHeight(20)->shrinkToFit();
$pdf->Ln(10);
$multicell->multiCell(100, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);

//foreach(range(100, 50, 50) as $maxHeight){
//    $multicell->maxHeight($maxHeight)->shrinkToFit();
//    $multicell->multiCell(0, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);
//}

// output the pdf
$pdf->Output();
