<?php

require_once("../dev-includes.php");

//create the pdf object and do some initialization
$oPdf = new myPdfTable();
$oPdf->SetAutoPageBreak(true, 20);
$oPdf->SetMargins(20, 20, 20);
$oPdf->AddPage();
$oPdf->AliasNbPages();

require('draw-table1.php');

//send the pdf to the browser
$oPdf->Output();
