<?php

require_once("../classes/pdf.php");
require_once("../mypdf-table.php");
require_once("../classes/pdftable.php");

//create the pdf object and do some initialization
$oPdf = new myPdfTable('P', 'mm', array(
    130,
    180
));

$oPdf->SetAutoPageBreak(true, 20);
$oPdf->SetMargins(20, 20, 20);
$oPdf->AddPage();
$oPdf->AliasNbPages();

$nHeight = $oPdf->h - 20;
$y = $oPdf->GetY();

while ($y < $nHeight) {
    //require dirname(__FILE__) . '/tests/draw-table-model1.php';
    require PDF_APPLICATION_PATH . '/tests/functional/table/draw-table-model2.php';
    $oPdf->AddPage();
    $oPdf->SetY($y += 4);
}

//send the pdf to the browser
$oPdf->Output();