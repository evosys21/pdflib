<?php

if ( !isset( $bSplitMode ) ) {
    $bSplitMode = true;
}

require __DIR__ . '/table.config.php';

$pdf->SetFontSize( 7 );

$table = new Table( $pdf );

$table->setStyle( "p", 'Helvetica', "", 6, "130,0,30" );
$table->setStyle( "b", 'Helvetica', "", 8, "80,80,260" );
$table->setStyle( "h1", 'Helvetica', "", 10, "0,151,200" );
$table->setStyle( "bi", 'Helvetica', "BI", 12, "0,0,120" );

//default text color
$pdf->SetTextColor( 118, 0, 3 );

$columns = 4;

$pdf->Ln( 30 );

//Initialize the table class, 3 columns
$table->initialize( array(
    20,
    20,
    20,
    20
), $aDefaultConfiguration );

$table->setSplitMode( $bSplitMode );

$header = [];

//Table Header
for ( $i = 0; $i < $columns; $i++ ) {
    $header[ $i ][ 'TEXT' ] = "Header #" . ( $i + 1 );
}

$header1 = $header;

$header[ 0 ][ 'COLSPAN' ] = 2;

$header[ 2 ][ 'COLSPAN' ] = 2;
$header[ 2 ][ 'ROWSPAN' ] = 2;

//add the header
$table->addHeader( $header );
$table->addHeader( $header1 );

$sDefaultText = "Lorem ipsum;, dolor sit amet";
$sDefaultText2 = "<p>Some Line</p>\n<b>Some text</b>";
$sDefaultLongText = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
$sDefaultLongText2 = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur";

$aDefaultRow = [];
for ( $i = 0; $i < $columns; $i++ ) {
    $aDefaultRow[ $i ][ 'TEXT' ] = $sDefaultText;
}
$aDefaultRow[ 0 ][ 'TEXT' ] = $sDefaultText2;

for ( $i = 1; $i < 10; $i++ ) {
    $aRow = $aDefaultRow;

    switch ( $i ) {
        case 1:
            $aRow[ 0 ][ 'TEXT_ALIGN' ] = 'L';
            $aRow[ 1 ][ 'TEXT_ALIGN' ] = 'C';
            $aRow[ 2 ][ 'TEXT_ALIGN' ] = 'R';
            break;
        case 2:
            $aRow[ 0 ][ 'TEXT_ALIGN' ] = 'L';
            $aRow[ 0 ][ 'TEXT' ] = $sDefaultText2;
            $aRow[ 1 ][ 'TEXT_ALIGN' ] = 'C';
            $aRow[ 1 ][ 'VERTICAL_ALIGN' ] = 'T';
            $aRow[ 2 ][ 'TEXT_ALIGN' ] = 'R';
            $aRow[ 2 ][ 'VERTICAL_ALIGN' ] = 'B';
            break;
        case 3:
            $aRow[ 0 ][ 'COLSPAN' ] = 2;
            $aRow[ 0 ][ 'TEXT_ALIGN' ] = 'L';
            $aRow[ 2 ][ 'COLSPAN' ] = 2;
            $aRow[ 2 ][ 'TEXT_ALIGN' ] = 'R';
            break;
        case 4:
            $aRow[ 1 ][ 'COLSPAN' ] = 2;
            $aRow[ 1 ][ 'TEXT_ALIGN' ] = 'J';
            $aRow[ 1 ][ 'TEXT' ] = $sDefaultLongText;
            $aRow[ 1 ][ 'LINE_SIZE' ] = 2;
            break;
        case 5:
            $aRow = $aRowLast;
            $aRow[ 1 ][ 'COLSPAN' ] = 3;
            $aRow[ 1 ][ 'VERTICAL_ALIGN' ] = 'B';
            $aRow[ 1 ][ 'TEXT_ALIGN' ] = 'R';
            break;
        case 6:
            $aRow[ 0 ][ 'ROWSPAN' ] = 2;
            $aRow[ 1 ][ 'ROWSPAN' ] = 2;
            break;
        case 7:
//            $aRow[ 3 ][ 'ROWSPAN' ] = 3;
            break;
        case 8:
            $aRow[ 0 ][ 'ROWSPAN' ] = 2;
            $aRow[ 0 ][ 'TEXT' ] = $sDefaultLongText;
            break;

        case 10:
            break;
    }

    $table->addRow( $aRow );
    $aRowLast = $aRow;
}

//close the table
$table->close();

