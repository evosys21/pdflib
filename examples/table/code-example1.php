<?php

$oTable = new Pdf_Table( $oPdf );

$oTable->setStyle( "p", $oPdf->getDefaultFontName(), "", 7, "130,0,30" );
$oTable->setStyle( "b", $oPdf->getDefaultFontName(), "B", 7, "130,0,30" );

$nColumns = 3;

/**
 * Set the tag styles
 */

$oTable->initialize( array( 20, 30, 50 ) );


$aHeader = array(
    array( 'TEXT' => 'Header #1' ),
    array( 'TEXT' => 'Header #2' ),
    array( 'TEXT' => 'Header #3' ),
);

//add the header row
$oTable->addHeader( $aHeader );

for ( $j = 1; $j < 3; $j++ )
{
    $aRow = array();
    $aRow[ 0 ][ 'TEXT' ] = "Line $j";
    $aRow[ 1 ][ 'TEXT' ] = "Lorem ipsum dolor sit amet...";
    $aRow[ 2 ][ 'TEXT' ] = "<p>Simple text\n<b>Bold text</b></p>";

    //add the data row
    $oTable->addRow( $aRow );
}

//close the table
$oTable->close();
