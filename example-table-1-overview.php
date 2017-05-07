<?php
/**
 * Pdf Advanced Table - Example
 * Copyright (c), Interpid, http://www.interpid.eu
 */

require_once __DIR__ . "/autoload.php";

use Interpid\Pdf\Multicell;
use Interpid\PdfExamples\pdfFactory;

$factory = new pdfFactory();

//get the FPDF object and initializes it
$pdf = pdfFactory::newPdf( 'table' );

// Create the Advanced Multicell Object and pass the PDF object as a parameter to the constructor
$multicell = new Multicell( $pdf );

// Set the styles for the advanced multicell

/**
 * Create the pdf Table object
 * Alternative you can use the Singleton Instance
 *
 * @example : $table = Table::getInstance($pdf);
 */
$multicell = new Multicell( $pdf );
$multicell->setStyle( "p", 'Helvetica', "", 7, "130,0,30" );
$multicell->setStyle( "b", 'Helvetica', "B", 7, "130,0,30" );

//simple table
$multicell->multiCell( 0, 5, "<p size='10' > ~~~Simple table:</p>" );
//require( 'examples/table/code-example1.php' );

//cells can be multicells and images
$pdf->Ln( 10 );
$multicell->multiCell( 0, 5, "<p size='10' > ~~~Cells can be <b>advanced multicells</b> and <b>images</b>:</p>" );
require( 'examples/table/code-example2.php' );

//example -   Multiple header rows, rowspans, colspans
$pdf->Ln( 10 );
$multicell->multiCell( 0, 5, "<p size='10' > ~~~Multiple header rows, rowspans, colspans:</p>" );
require( 'examples/table/code-example3.php' );

//example - Transparent background
$pdf->Ln( 10 );
$multicell->multiCell( 0, 5, "<p size='10' > ~~~ Transparent Background:</p>" );
require( 'examples/table/code-example-transparent.php' );


//example 3 - all parameters can be overwritten
$pdf->Ln( 10 );
$multicell->multiCell( 0, 5, "<p size='10' > ~~~Different alignments:</p>" );
require( 'examples/table/code-example-alignments.php' );


//send the pdf to the browser
$pdf->Output();
