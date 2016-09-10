<?php

require_once '../dev-includes.php';

$oPdf = new myPdfTable();
$oPdf->Open();
$oPdf->SetAutoPageBreak( true, 20 );
$oPdf->SetMargins( 20, 20, 20 );
$oPdf->AddPage();
$oPdf->AliasNbPages();

$oMulticell = new PdfMulticell( $oPdf );
$oMulticell->SetStyle( "p", $oPdf->getDefaultFontName(), "", 7, "130,0,30" );
$oMulticell->SetStyle( "b", $oPdf->getDefaultFontName(), "B", 7, "130,0,30" );

require( APPLICATION_PATH . '/examples/table/code-example-transparent.php' );
//require( APPLICATION_PATH . '/examples/table/code-example3.php' );

//send the pdf to the browser
$oPdf->Output();
