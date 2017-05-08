<?php

if ( !isset( $pdf ) ) {
    $pdf = new myPdf();
}

use \Interpid\PdfLib\Table;
use \Interpid\PdfLib\Tools;

$table = new Table( $pdf );


$table->setStyle( "p", 'helvetica', "", 6, "130,0,30" );
$table->setStyle( "b", 'helvetica', "B", 6, "130,0,30" );
$table->setStyle( "bi", 'helvetica', "BI", 6, "0,0,120" );

require( 'settings.php' );

$columns = 5;

/**
 * Set the tag styles
 */

$table->initialize( [ 20, 30, 40, 50 ] );


$table->addHeader( $headerRow );

for ( $i = 0; $i < 6; $i++ ) {
    $aRow = $dataRow;

    if ( $i >= 0 && $i < 3 ) {
        $aRow[ 0 ][ 'TEXT' ] = "Forced\nLine\nBreaks";
        $align = Tools::getNextValue( $alignments, $k );
        $aRow[ 1 ][ 'TEXT' ] = "Align: <b>$align</b>";
        $aRow[ 1 ][ 'ALIGN' ] = "$align";
        $align = Tools::getNextValue( $alignments, $k );
        $aRow[ 2 ][ 'TEXT' ] = "Align: <b>$align</b>";
        $aRow[ 2 ][ 'ALIGN' ] = "$align";
        $align = Tools::getNextValue( $alignments, $k );
        $aRow[ 3 ][ 'TEXT' ] = "Align: <b>$align</b>";
        $aRow[ 3 ][ 'ALIGN' ] = "$align";
    }

    if ( $i >= 3 && $i <= 5 ) {
        $aRow[ 0 ][ 'TEXT' ] = "Forced\nLine\nForced\nLine\nForced\nLine";
        $aRow[ 1 ] = $imageCell;
        $aRow[ 1 ][ 'ALIGN' ] = Tools::getNextValue( $alignments, $k );

        $aRow[ 2 ] = $imageCell;
        $aRow[ 2 ][ 'ALIGN' ] = Tools::getNextValue( $alignments, $k );

        $aRow[ 3 ] = $imageCell;
        $aRow[ 3 ][ 'ALIGN' ] = Tools::getNextValue( $alignments, $k );
    }


    $table->addRow( $aRow );
}

//close the table
$table->close();
