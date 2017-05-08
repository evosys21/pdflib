<?php
/**
 * Pdf Advanced Multicell - Example
 * Copyright (c), Interpid, http://www.interpid.eu
 */

require_once __DIR__ . "/../autoload.php";

use Interpid\PdfLib\Multicell;
use Interpid\PdfExamples\pdfFactory;

$factory = new pdfFactory();

//get the FPDF Object
$pdf = pdfFactory::newPdf( 'multicell' );

// Create the Advanced Multicell Object and pass the PDF object as a parameter to the constructor
$multicell = new Multicell( $pdf );

// Set the styles for the advanced multicell
$multicell->setStyle( "p", 'helvetica', "", 11, "130,0,30" );
$multicell->setStyle( "b", 'helvetica', "B", 11, "130,0,30" );
$multicell->setStyle( "i", 'helvetica', "I", 11, "80,80,260" );
$multicell->setStyle( "u", 'helvetica', "U", 11, "80,80,260" );
$multicell->setStyle( "h1", 'helvetica', "", 14, "203,0,48" );
$multicell->setStyle( "h3", 'helvetica', "B", 12, "203,0,48" );
$multicell->setStyle( "h4", 'helvetica', "BI", 11, "0,151,200" );
$multicell->setStyle( "hh", 'helvetica', "B", 11, "255,189,12" );
$multicell->setStyle( "ss", 'helvetica', "", 7, "203,0,48" );
$multicell->setStyle( "font", 'helvetica', "", 10, "0,0,255" );
$multicell->setStyle( "style", 'helvetica', "BI", 10, "0,0,220" );
$multicell->setStyle( "size", 'helvetica', "BI", 12, "0,0,120" );
$multicell->setStyle( "color", 'helvetica', "BI", 12, "0,255,255" );

$pdf->Ln( 10 ); //line break

// create the advanced multicell
$multicell->multiCell( 0, 5, "<h1>Fpdf Advanced Multicell</h1>", 1, "J", 1, 3, 3, 3, 3 );

$pdf->Ln( 10 ); //line break

//read TAG formatted text from file
$txt = file_get_contents( PDF_APPLICATION_PATH . '/content/multicell.txt' );
$multicell->multiCell( 0, 5, $txt, 1, "J", 1, 3, 3, 3, 3 );

// output the pdf
$pdf->Output();
