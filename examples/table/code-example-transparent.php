<?php

$y = $pdf->GetY();
$pdf->SetX( 50 );
$pdf->Image( PDF_RESOURCES_IMAGES . "/sample-pdf.jpg" );

$pdf->SetY( $y );

require( 'settings.php' );

use Interpid\PdfLib\Table;

$table = new Table( $pdf );

$table->setStyle( "p", $pdf->getDefaultFontName(), "", 7, "130,0,30" );
$table->setStyle( "b", $pdf->getDefaultFontName(), "B", 7, "130,0,30" );
$table->setStyle( "bi", $pdf->getDefaultFontName(), "BI", 7, "0,0,120" );

$columns = 3;

/**
 * Set the tag styles
 */

$table->initialize( [ 20, 30, 80 ] );
$table->setRowConfig( array(
    'BACKGROUND_COLOR' => false
) );


$header = array(
    array(
        'TEXT' => 'Header #1'
    ),
    array(
        'TEXT' => 'Header #2'
    ),
    array(
        'TEXT' => 'Header #3'
    )
);

//add the header row
$table->addHeader( $header );

$imageCell = array(
    'TYPE' => 'IMAGE',
    'FILE' => PDF_RESOURCES_IMAGES . '/dice.jpg',
    'WIDTH' => 10
);

//row 1 - add data as Array
$row = [];
$row[ 0 ][ 'TEXT' ] = "Line <b>1</b>";

$row[ 1 ] = array(
    'TYPE' => 'IMAGE',
    'FILE' => PDF_RESOURCES_IMAGES . '/dice.jpg',
    'WIDTH' => 10
);

$row[ 2 ][ 'TEXT' ] = "<p>All <b>table cells</b> are fully functional <bi>Advanced Multicells</bi>\nDetails on <bi href='http://www.interpid.eu'>www.interpid.eu</bi></p>";
$row[ 2 ][ 'ALIGN' ] = "L";

//add the data row
$table->addRow( $row );

//row 2 - add data as Objects
$row = [];

//alternatively you can create directly the cell object
$row[ 0 ] = new \Interpid\PdfLib\Table\Cell\Image( $pdf, PDF_RESOURCES_IMAGES . '/blog.jpg', 10 );
$row[ 1 ] = new \Interpid\PdfLib\Table\Cell\Multicell( $pdf, "<p>This is another <b>Multicell</b></p>" );
$row[ 2 ][ 'TEXT' ] = "<p>All <b>table cells</b> are fully functional <bi>Advanced Multicells</bi>\nDetails on <bi href='http://www.interpid.eu'>www.interpid.eu</bi></p>";
$row[ 2 ][ 'BACKGROUND_COLOR' ] = $aColor[ 1 ];

//add the data row
$table->addRow( $row );

//close the table
$table->close();
