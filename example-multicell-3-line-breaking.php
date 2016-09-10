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
$oMulticell->setStyle( "b", $oPdf->getDefaultFontName(), "B", 11, "130,0,30" );

$sTxt = "This is a demo of <b>NON BREAKING > S P>A C E EXAMPLE</b>";

//create an advanced multicell
$oMulticell->multiCell( 0, 5, "Default line breaking characters:  ,.:;", 0 );
$oMulticell->multiCell( 100, 5, $sTxt, 1, 'R', 0, 0, 1 );
$oPdf->Ln( 10 ); //new line


//create an advanced multicell
$oMulticell->multiCell( 0, 5, "Setting > as line breaking character", 0 );
$oMulticell->setLineBreakingCharacters( ">" );
$oMulticell->multiCell( 100, 5, $sTxt, 1 );
$oPdf->Ln( 10 ); //new line


//create an advanced multicell
$oMulticell->multiCell( 0, 5, "Reseting the line breaking characters", 0 );
$oMulticell->resetLineBreakingCharacters();
$oMulticell->multiCell( 100, 5, $sTxt, 1 );
$oPdf->Ln( 10 ); //new line


//send the pdf to the browser
$oPdf->Output();