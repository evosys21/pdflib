<?php

use EvoSys21\PdfLib\Dev\DevFactory;

require_once __DIR__ . '/autoload.php';

$factory = new DevFactory();

$multicell = $factory->multicell();
$pdf = $multicell->getPdfObject();

$txt = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';

$multicell->multiCell(100, 5, $txt, 1, 'J', 1, 3, 3, 3, 3, 50);

// output the pdf
$pdf->Output();
