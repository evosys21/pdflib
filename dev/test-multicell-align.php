<?php

require_once 'Factory.php';

$factory = new DevFactory();

// Create the Advanced Multicell Object and inject the PDF object
$multicell = DevFactory::multicell();
$pdf = $multicell->getPdfObject();

$short = "Lorem ipsum dolor sit amet";

$txt = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";

foreach (range(5,0) as $key => $padding) {

    if ($key) {
        $pdf->AddPage();
    }

    $multicell->multiCell(0, 5, $txt, 1, 'J', 1, $padding, $padding, $padding, $padding);
    $pdf->MultiCell(0, 5, $short, '', 'L');

    foreach (range(50, 150, 20) as $width) {
        $multicell->multiCell($width, 5, $txt, 1, 'J', 1, $padding, $padding, $padding, $padding);
    }
}


// output the pdf
$pdf->Output();
