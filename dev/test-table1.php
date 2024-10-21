<?php

use EvoSys21\PdfLib\Dev\DevFactory;

require_once __DIR__ . '/autoload.php';

$factory = new DevFactory();

$table = $factory->table();
$pdf = $table->getPdfObject();

require __DIR__ . '/table/draw-table-model1.php';

$pdf->Output();
