<?php

use EvoSys21\PdfLib\Dev\DevFactory;

require_once __DIR__ . '/autoload.php';

$factory = new DevFactory();

$multicell = $factory->multicell();
$pdf = $multicell->getPdfObject();

$txt = <<<'EOL'
This <b>TCPDF addon</b> allows creation of an <b>Advanced Multicell</b> which uses as input a <b>TAG based formatted string</b> instead of a simple string. The use of tags allows to change the font, the style (<b>bold</b>, <i>italic</i>, <u>underline</u>), the size, and the color of characters and many other features.

<h3>Features:</h3>
  - Text can be <hh>aligned</hh>, <hh>centered</hh> or <hh>justified</hh>
  - Different <font>Font</font>, <size>Sizes</size>, <style>Styles</style>, <color>Colors</color> can be used
EOL;

$multicell->maxHeight(30)->shrinkToFit();
$multicell->multiCell(100, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);
$multicell->multiCell(100, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);
$pdf->Ln();

$multicell->maxLines(8)->shrinkToFit();
$multicell->multiCell(100, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);
$multicell->multiCell(100, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);

$pdf->AddPage();

$multicell->maxLines(8)->shrinkToFit()->applyAll();
$multicell->multiCell(100, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);
$multicell->multiCell(100, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);
$multicell->reset();
$multicell->multiCell(100, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);

// output the pdf
$pdf->Output();
