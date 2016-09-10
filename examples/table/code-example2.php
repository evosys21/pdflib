<?php

require( 'settings.php' );

$oTable = new Pdf_Table( $oPdf );

$oTable->SetStyle( "p", $oPdf->getDefaultFontName(), "", 7, "130,0,30" );
$oTable->SetStyle( "b", $oPdf->getDefaultFontName(), "B", 7, "130,0,30" );
$oTable->setStyle( "bi", $oPdf->getDefaultFontName(), "BI", 7, "0,0,120" );

$nColumns = 3;

/**
 * Set the tag styles
 */

$oTable->initialize( array( 20, 30, 80 ) );


$aHeader = array(
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
$oTable->addHeader( $aHeader );

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
$oTable->addRow( $aRow );

//row 2 - add data as Objects
$aRow = array();

//alternatively you can create directly the cell object
$aRow[ 0 ] = new Pdf_Table_Cell_Image( $oPdf, PDF_RESOURCES_IMAGES . '/blog.jpg', 10 );
$aRow[ 1 ] = array(
    'TEXT' => "<p>This is another <b>Multicell</b></p>",
    'BACKGROUND_COLOR' => $aColor[ 0 ] );
$aRow[ 2 ] = new Pdf_Table_Cell_Image( $oPdf, PDF_RESOURCES_IMAGES . '/pensil.jpg', 10 );
$aRow[ 2 ]->setAlign( "L" );

//add the data row
$oTable->addRow( $aRow );

//close the table
$oTable->close();
