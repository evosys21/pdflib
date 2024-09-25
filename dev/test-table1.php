<?php

use evosys21\PdfLib\Dev\DevFactory;

require_once __DIR__ . '/autoload.php';

$factory = new DevFactory();

$multicell = $factory->table();
$pdf = $multicell->getPdfObject();

require __DIR__ . '/table/draw-table-model1.php';

$pdf->Output();
