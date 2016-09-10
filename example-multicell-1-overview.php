<?php
/**
 * Pdf Advanced Multicell - Example
 * Copyright (c) 2014, Andrei Bintintan, http://www.interpid.eu
 */

// include the pdf factory
require_once( "pdfFactory.php" );

// Include the Advanced Multicell Class
require_once( "classes/pdfmulticell.php" );

/**
 * Include my Custom PDF class This is required only to overwrite the header
 */
require_once( "mypdf-multicell.php" );

$factory = new pdfFactory();

// create new PDF document
$oPdf = new myPdfMulticell();
$factory->initPdfObject( $oPdf );

/**
 * Create the Advanced Multicell Object and pass the PDF object as a parameter to the constructor
 */
$oMulticell = new PdfMulticell( $oPdf );

/**
 * Set the styles for the advanced multicell
 */
$oMulticell->SetStyle( "p", $oPdf->getDefaultFontName(), "", 11, "130,0,30" );
$oMulticell->SetStyle( "b", $oPdf->getDefaultFontName(), "B", 11, "130,0,30" );
$oMulticell->setStyle( "i", $oPdf->getDefaultFontName(), "I", 11, "80,80,260" );
$oMulticell->setStyle( "u", $oPdf->getDefaultFontName(), "U", 11, "80,80,260" );
$oMulticell->SetStyle( "h1", $oPdf->getDefaultFontName(), "", 11, "80,80,260" );
$oMulticell->SetStyle( "h3", $oPdf->getDefaultFontName(), "B", 12, "203,0,48" );
$oMulticell->SetStyle( "h4", $oPdf->getDefaultFontName(), "BI", 11, "0,151,200" );
$oMulticell->SetStyle( "hh", $oPdf->getDefaultFontName(), "B", 11, "255,189,12" );
$oMulticell->SetStyle( "ss", $oPdf->getDefaultFontName(), "", 7, "203,0,48" );
$oMulticell->SetStyle( "font", $oPdf->getDefaultFontName(), "", 10, "0,0,255" );
$oMulticell->SetStyle( "style", $oPdf->getDefaultFontName(), "BI", 10, "0,0,220" );
$oMulticell->SetStyle( "size", $oPdf->getDefaultFontName(), "BI", 12, "0,0,120" );
$oMulticell->SetStyle( "color", $oPdf->getDefaultFontName(), "BI", 12, "0,255,255" );

//read TAG formatted text from files
$sTxt1 = file_get_contents( __DIR__ . '/content/createdby.txt' );
$sTxt2 = file_get_contents( __DIR__ . '/content/multicell.txt' );

//create an advanced multicell
$oMulticell->multiCell( 150, 5, $sTxt1, 1, "L", 1, 5, 5, 5, 5 );
$oPdf->Ln( 10 ); //new line


//create an advanced multicell
$oMulticell->multiCell( 0, 5, $sTxt2, 1, "J", 1, 3, 3, 3, 3 );
$oPdf->Ln( 10 ); //new line


//send the pdf to the browser
$oPdf->Output();
