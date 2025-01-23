<?php

use EvoSys21\PdfLib\Dev\DevFactory;

require_once __DIR__ . '/autoload.php';

$factory = new DevFactory();

$multicell = $factory->multicell();
$pdf = $multicell->getPdfObject();

$txt = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';

$pdf->AutoPageBreak = false;
$multicell->disablePageBreak();

for ($i = 0; $i < 25; $i++) {
    $multicell->multiCell(100, 5, $txt);
}

// output the pdf
$pdf->Output();
