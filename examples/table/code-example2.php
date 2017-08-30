<?php

require( 'settings.php' );

use Interpid\PdfLib\Table;

$table = new Table( $pdf );

$table->setStyle( "p", 'helvetica', "", 7, "130,0,30" );
$table->setStyle( "b", 'helvetica', "B", 7, "130,0,30" );
$table->setStyle( "bi", 'helvetica', "BI", 7, "0,0,120" );

$columns = 3;

/**
 * Set the tag styles
 */

$table->initialize( [ 20, 30, 80 ] );

$header = [
    [ 'TEXT' => 'Header #1' ],
    [ 'TEXT' => 'Header #2' ],
    [ 'TEXT' => 'Header #3' ]
];

//add the header row
$table->addHeader( $header );

$imageCell = [
    'TYPE' => 'IMAGE',
    'FILE' => PDF_RESOURCES_IMAGES . '/dice.jpg',
    'WIDTH' => 10
];

//row 1 - add data as Array
$aRow = [];
$aRow[ 0 ][ 'TEXT' ] = "Line <b>1</b>";

$aRow[ 1 ] = array(
    'TYPE' => 'IMAGE',
    'FILE' => PDF_RESOURCES_IMAGES . '/dice.jpg',
    'WIDTH' => 10
);

$aRow[ 2 ][ 'TEXT' ] = "<p>All <b>table cells</b> are fully functional <bi>Advanced Multicells</bi>\nDetails on <bi href='http://www.interpid.eu'>www.interpid.eu</bi></p>";
$aRow[ 2 ][ 'ALIGN' ] = "L";

//add the data row
$table->addRow( $aRow );

//row 2 - add data as Objects
$aRow = [];

//alternatively you can create directly the cell object
$aRow[ 0 ] = new Table\Cell\Image( $pdf, PDF_RESOURCES_IMAGES . '/blog.jpg', 10 );
$aRow[ 1 ] = array(
    'TEXT' => "<p>This is another <b>Multicell</b></p>",
    'BACKGROUND_COLOR' => $aColor[ 0 ]
);
$aRow[ 2 ] = new Table\Cell\Image( $pdf, PDF_RESOURCES_IMAGES . '/pensil.jpg', 10 );
$aRow[ 2 ]->setAlign( "L" );

//add the data row
$table->addRow( $aRow );

//close the table
$table->close();
