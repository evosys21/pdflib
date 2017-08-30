<?php

require( 'settings.php' );

if ( !isset( $pdf ) ) {
    $pdf = new \Interpid\PdfExamples\myPdf();
}

use Interpid\PdfLib\Table;

$table = new Table( $pdf );

$table->setStyle( "p", 'helvetica', "", 6, "130,0,30" );
$table->setStyle( "b", 'helvetica', "B", 6, "130,0,30" );
$table->setStyle( "bi", 'helvetica', "BI", 6, "0,0,120" );
$table->setStyle( "s1", 'helvetica', "I", 6, "0,0,120" );
$table->setStyle( "s2", 'helvetica', "", 7, "110,50,120" );

$nColumns = 5;

/**
 * Set the tag styles
 */

$table->initialize( [ 20, 30, 40, 50 ] );


$header1 = $headerRow;
$header1[ 2 ][ 'TEXT' ] = 'Colspan in Header';
$header1[ 2 ][ 'COLSPAN' ] = 2;

$header2 = $headerRow;
$header3 = $headerRow;

$header2[ 1 ][ 'TEXT' ] = "Colspan/Rowspan in Header";
$header2[ 1 ][ 'COLSPAN' ] = 2;
$header2[ 1 ][ 'ROWSPAN' ] = 2;

$table->addHeader( $header1 );
$table->addHeader( $header2 );
$table->addHeader( $header3 );


for ( $i = 0; $i < 8; $i++ ) {
    $aRow = $dataRow;

    if ( 0 == $i ) {
        $aRow[ 1 ][ 'COLSPAN' ] = 2;
    }

    if ( 1 == $i ) {
        $aRow[ 1 ][ 'COLSPAN' ] = 3;
    }

    if ( 2 == $i ) {
        $aRow[ 1 ][ 'TEXT' ] = $sTextExtraLong . "\n\n" . $sTextSubSuperscript;
        $aRow[ 1 ][ 'ALIGN' ] = "J";
        $aRow[ 1 ][ 'COLSPAN' ] = 3;
        $aRow[ 1 ][ 'ROWSPAN' ] = 3;
    }

    if ( 3 == $i ) {
        $aRow[ 0 ] = $imageCell;
    }

    if ( 5 == $i ) {
        $aRow[ 1 ] = $imageCell;
        $aRow[ 1 ][ 'COLSPAN' ] = 2;
        $aRow[ 1 ][ 'ROWSPAN' ] = 2;
    }


    $table->addRow( $aRow );
}

//close the table
$table->close();
