<?php
/**
 * Pdf Advanced Table - Example
 * Copyright (c), Andrei Bintintan, http://www.interpid.eu
 */

// include the pdf factory
require_once( "pdfFactory.php" );

// Include the Advanced Table Class
require_once( "classes/pdftable.php" );

/**
 * Include my Custom PDF class This is required only to overwrite the header
 */
require_once( "mypdf-table.php" );

$factory = new pdfFactory();

// create new PDF document
$oPdf = new myPdfTable();
$factory->initPdfObject( $oPdf );

/**
 * Create the pdf Table object
 * Alternative you can use the Singleton Instance
 *
 * @example : $oTable = PdfTable::getInstance($oPdf);
 */
$oMulticell = new PdfMulticell( $oPdf );
$oMulticell->SetStyle( "p", $oPdf->getDefaultFontName(), "", 7, "130,0,30" );
$oMulticell->SetStyle( "b", $oPdf->getDefaultFontName(), "B", 7, "130,0,30" );

//simple table
$oMulticell->multiCell( 0, 5, "<p size='10' > ~~~Simple table:</p>" );
require( 'examples/table/code-example1.php' );

//cells can be multicells and images
$oPdf->Ln( 10 );
$oMulticell->multiCell( 0, 5, "<p size='10' > ~~~Cells can be <b>advanced multicells</b> and <b>images</b>:</p>" );
require( 'examples/table/code-example2.php' );

//example -   Multiple header rows, rowspans, colspans
$oPdf->Ln( 10 );
$oMulticell->multiCell( 0, 5, "<p size='10' > ~~~Multiple header rows, rowspans, colspans:</p>" );
require( 'examples/table/code-example3.php' );

//example - Transparent background
$oPdf->Ln( 10 );
$oMulticell->multiCell( 0, 5, "<p size='10' > ~~~ Transparent Background:</p>" );
require( 'examples/table/code-example-transparent.php' );


//example 3 - all parameters can be overwritten
$oPdf->Ln( 10 );
$oMulticell->multiCell( 0, 5, "<p size='10' > ~~~Different alignments:</p>" );
require( 'examples/table/code-example-alignments.php' );


//send the pdf to the browser
$oPdf->Output();
