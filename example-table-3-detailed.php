<?php
/**
 * Pdf Advanced Table - Example
 * Copyright (c), Interpid, http://www.interpid.eu
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
$pdf = new myPdfTable();
$factory->initPdfObject( $pdf );


//define some background colors
$aBgColor1 = array( 234, 255, 218 );
$aBgColor2 = array( 165, 250, 220 );
$aBgColor3 = array( 255, 252, 249 );
$aBgColor4 = array( 86, 155, 225 );
$aBgColor5 = array( 207, 247, 239 );
$aBgColor6 = array( 246, 211, 207 );
$bg_color7 = array( 216, 243, 228 );

/**
 * Create the pdf Table object
 * Alternative you can use the Singleton Instance
 *
 * @example : $table = PdfTable::getInstance($pdf);
 */
$table = new PdfTable( $pdf );

/**
 * Set the tag styles
 */
$table->setStyle( "p", 'Helvetica', "", 10, "130,0,30" );
$table->setStyle( "b", 'Helvetica', "", 9, "80,80,260" );
$table->setStyle( "h1", 'Helvetica', "", 10, "0,151,200" );
$table->setStyle( "bi", 'Helvetica', "BI", 12, "0,0,120" );

//default text color
$pdf->SetTextColor( 118, 0, 3 );

//create an advanced multicell    
$multicell = PdfMulticell::getInstance( $pdf );
$multicell->setStyle( "s1", 'Helvetica', "", 8, "118,0,3" );
$multicell->setStyle( "s2", 'Helvetica', "", 6, "0,49,159" );

$multicell->multiCell( 100, 4, "<s1>Example 1 - Very Simple Table</s1>", 0 );
$pdf->Ln( 1 );

require( 'table_example1.inc' );

$pdf->Ln( 10 );

$txt = "<s1>Example 2 - More detailed Table</s1>\n<s2>\t- Table Align = Center\n\t- The header has multiple lines\n\t- Colspanning Example\n\t- Rowspanning Example\n\t- Text Alignments\n\t- Properties overwriting</s2>";

$pdf->SetX( 60 );
$multicell->multiCell( 100, 2.5, $txt, 0 );
$pdf->Ln( 1 );
require( 'table_example2.inc' );

$pdf->Ln( 10 );

$txt = "<s1>Example 3 - Table split end of the page</s1>\n<s2>\t- This is the table from Example 2 at the end of the page\n\t- Splitting mode = ON, you can see that the cells are splitted</s2>";

$pdf->SetXY( 60, 215 );
$multicell->multiCell( 100, 2.5, $txt, 0 );
$pdf->Ln( 1 );
$tableSplitMode = true;
require( 'table_example2.inc' );

$pdf->Ln( 10 );

$txt = "<s1>Example 4 - Table split end of the page</s1>\n<s2>\t- This is the table from Example 2 at the end of the page\n\t- Splitting mode = OFF. In this case the cells are NOT splitted</s2>";

$pdf->SetXY( 60, 215 );
$multicell->multiCell( 100, 2.5, $txt, 0 );
$pdf->Ln( 1 );
$tableSplitMode = false;
require( 'table_example2.inc' );

//send the pdf to the browser
$pdf->Output();
