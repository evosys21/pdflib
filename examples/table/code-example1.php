<?php

$table = new Pdf_Table( $pdf );

$table->setStyle( "p", 'Helvetica', "", 7, "130,0,30" );
$table->setStyle( "b", 'Helvetica', "B", 7, "130,0,30" );

$columns = 3;

/**
 * Set the tag styles
 */

$table->initialize( array( 20, 30, 50 ) );


$header = array(
    array( 'TEXT' => 'Header #1' ),
    array( 'TEXT' => 'Header #2' ),
    array( 'TEXT' => 'Header #3' ),
);

//add the header row
$table->addHeader( $header );

for ( $j = 1; $j < 3; $j++ )
{
    $aRow = array();
    $aRow[ 0 ][ 'TEXT' ] = "Line $j";
    $aRow[ 1 ][ 'TEXT' ] = "Lorem ipsum dolor sit amet...";
    $aRow[ 2 ][ 'TEXT' ] = "<p>Simple text\n<b>Bold text</b></p>";

    //add the data row
    $table->addRow( $aRow );
}

//close the table
$table->close();
