<?php

require( 'settings.php' );

if ( !isset( $pdf ) ) {
    $pdf = new myPdf();
}

$table = new PdfTable( $pdf );

$table->setStyle( "p", 'Helvetica', "", 6, "130,0,30" );
$table->setStyle( "b", 'Helvetica', "B", 6, "130,0,30" );
$table->setStyle( "bi", 'Helvetica', "BI", 6, "0,0,120" );
$table->setStyle( "s1", 'Helvetica', "I", 6, "0,0,120" );
$table->setStyle( "s2", 'Helvetica', "", 7, "110,50,120" );
$table->setStyle( "h1", 'Helvetica', "", 10, "255,0,0" );

$columns = 5;

/**
 * Set the tag styles
 */

//$table->initialize( array( 20, 30, 40, 50 ) );
$table->initialize( array( 10, 15, 20, 25, 10, 15, 20, 25 ) );


for ( $i = 0; $i < 4; $i++ ) {
    if ( 0 == $i ) {
        $aRow[ 0 ][ 'TEXT' ] = "<h1>UNIVASA</h1>\n <b>Convenient topup across all networks (MTN, Airtel, Etisalat, Glo)</b>";
        $aRow[ 0 ][ 'COLSPAN' ] = 4;
        $aRow[ 0 ][ 'ALIGN' ] = "C";
        $aRow[ 0 ][ 'LINE_SIZE' ] = 5;
        $aRow[ 4 ][ 'TEXT' ] = "<h1>UNIVASA</h1>\n <b>Convenient topup across all networks (MTN, Airtel, Etisalat, Glo)</b>";
        $aRow[ 4 ][ 'COLSPAN' ] = 4;
        $aRow[ 4 ][ 'ALIGN' ] = "C";
        $aRow[ 4 ][ 'LINE_SIZE' ] = 5;
    }
    if ( 1 == $i ) {
        $aRow[ 0 ][ 'TEXT' ] = '<b>Amount:</b> =N= 100.00';;
        $aRow[ 0 ][ 'COLSPAN' ] = 3;
        $aRow[ 0 ][ 'ALIGN' ] = "C";
        $aRow[ 0 ][ 'LINE_SIZE' ] = 5;
    }
    if ( 1 == $i ) {
        $aRow[ 3 ][ 'TEXT' ] = '<b>USSD Menu: </b>*578#';;
        $aRow[ 1 ][ 'COLSPAN' ] = 2;
        $aRow[ 1 ][ 'ALIGN' ] = "C";
        $aRow[ 1 ][ 'LINE_SIZE' ] = 5;
    }
    if ( 2 == $i ) {
        $aRow[ 0 ][ 'TEXT' ] = "<b>PIN:</b> 1234 5678 9999\n<b>Usage instructions:</b>\n<b>Self Topup:</b> *578*11*PIN*Amount#\n<b>Topup your friend:</b>*578*12*PIN*Amount*Number#";
        $aRow[ 0 ][ 'COLSPAN' ] = 4;
        $aRow[ 0 ][ 'BORDER_TYPE' ] = 'LT';
        $aRow[ 4 ][ 'TEXT' ] = "<b>PIN:</b> 1234 5678 9999\n<b>Usage instructions:</b>\n<b>Self Topup:</b> *578*11*PIN*Amount#\n<b>Topup your friend:</b>*578*12*PIN*Amount*Number#";
        $aRow[ 4 ][ 'COLSPAN' ] = 4;
        $aRow[ 4 ][ 'BORDER_TYPE' ] = 'RT';
    }

//     from row 3 dump image into column zero
    if ( 3 == $i ) {
        $aImageCell[ 'BORDER_TYPE' ] = 0;
        $aImageCell1 = $aImageCell;
        $aRow[ 0 ] = $aImageCell;
        $aRow[ 1 ][ 'COLSPAN' ] = 3;
        $aRow[ 1 ][ 'BORDER_TYPE' ] = 0;
        $aRow[ 1 ][ 'TEXT' ] = "<b>Serial ID 989000292827289099</b>\npowered by UNIVASA";
        $aRow[ 4 ] = $aImageCell;
        $aRow[ 5 ][ 'COLSPAN' ] = 3;
        $aRow[ 5 ][ 'BORDER_TYPE' ] = 0;
        $aRow[ 5 ][ 'TEXT' ] = "<b>Serial ID 989000292827289099</b>\npowered by UNIVASA";
    }


    $table->addRow( $aRow );
}

//close the table
$table->close();
