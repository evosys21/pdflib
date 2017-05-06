<?php

require( 'settings.php' );

$table = new Pdf_Table( $pdf );

$table->setStyle( "p", 'Helvetica', "", 7, "130,0,30" );
$table->setStyle( "b", 'Helvetica', "B", 7, "130,0,30" );
$table->setStyle( "bi", 'Helvetica', "BI", 7, "0,0,120" );

$columns = 3;

/**
 * Set the tag styles
 */

$table->initialize( array( 20, 30, 80 ) );


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

$aImageCell = array(
    'TYPE' => 'IMAGE',
    'FILE' => PDF_APPLICATION_PATH . '/images/dice.jpg',
    'WIDTH' => 10
);

//row 1 - add data as Array
$aRow = array();
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
$aRow = array();

//alternatively you can create directly the cell object
$aRow[ 0 ] = new Table\Cell\Image( $pdf, PDF_RESOURCES_IMAGES . '/blog.jpg', 10 );
$aRow[ 1 ] = array(
    'TEXT' => "<p>This is another <b>Multicell</b></p>",
    'BACKGROUND_COLOR' => $aColor[ 0 ] );
$aRow[ 2 ] = new Table\Cell\Image( $pdf, PDF_RESOURCES_IMAGES . '/pensil.jpg', 10 );
$aRow[ 2 ]->setAlign( "L" );

//add the data row
$table->addRow( $aRow );

//close the table
$table->close();
