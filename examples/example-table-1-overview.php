<?php
/**
 * Pdf Advanced Table - Example
 * Copyright (c), Interpid, http://www.interpid.eu
 */

require_once __DIR__ . "/../autoload.php";

use Interpid\PdfLib\Multicell;
use Interpid\PdfExamples\pdfFactory;

$factory = new pdfFactory();

//get the PDF object
$pdf = pdfFactory::newPdf( 'table' );

//Create the Advanced Multicell Object and pass the PDF object as a parameter to the constructor
$multicell = new Multicell( $pdf );

//Set the styles for the advanced multicell
$multicell = new Multicell( $pdf );
$multicell->setStyle( "p", $pdf->getDefaultFontName(), "", 7, "130,0,30" );
$multicell->setStyle( "b", $pdf->getDefaultFontName(), "B", 7, "130,0,30" );

//simple table
$multicell->multiCell( 0, 5, "<p size='10' > ~~~Simple table:</p>" );
require( __DIR__ . '/table/code-example1.php' );

//cells can be multicells and images
$pdf->Ln( 10 );
$multicell->multiCell( 0, 5, "<p size='10' > ~~~Cells can be <b>advanced multicells</b> and <b>images</b>:</p>" );
require( __DIR__ . '/table/code-example2.php' );

//example -   Multiple header rows, rowspans, colspans
$pdf->Ln( 10 );
$multicell->multiCell( 0, 5, "<p size='10' > ~~~Multiple header rows, rowspans, colspans:</p>" );
require( __DIR__ . '/table/code-example3.php' );

//example - Transparent background
$pdf->Ln( 10 );
$multicell->multiCell( 0, 5, "<p size='10' > ~~~ Transparent Background:</p>" );
require( __DIR__ . '/table/code-example-transparent.php' );


//example - all parameters can be overwritten
$pdf->Ln( 10 );
$multicell->multiCell( 0, 5, "<p size='10' > ~~~Different alignments:</p>" );
require( __DIR__ . '/table/code-example-alignments.php' );

//send the pdf to the browser
$pdf->Output();