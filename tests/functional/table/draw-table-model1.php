<?php

if ( !isset( $bSplitMode ) )
{
    $bSplitMode = true;
}

require dirname( __FILE__ ) . '/table.config.php';

$oPdf->SetFontSize( 7 );

$oTable = new PdfTable( $oPdf );

$oTable->setStyle( "p", $oPdf->getDefaultFontName(), "", 6, "130,0,30" );
$oTable->setStyle( "b", $oPdf->getDefaultFontName(), "", 8, "80,80,260" );
$oTable->setStyle( "h1", $oPdf->getDefaultFontName(), "", 10, "0,151,200" );
$oTable->setStyle( "bi", $oPdf->getDefaultFontName(), "BI", 12, "0,0,120" );

//default text color
$oPdf->SetTextColor( 118, 0, 3 );

$nColumns = 4;

$oPdf->Ln( 30 );

//Initialize the table class, 3 columns
$oTable->initialize( array(
    20,
    40,
    20
), $aDefaultConfiguration );

$oTable->setSplitMode( $bSplitMode );

$aHeader = array();

//Table Header
for ( $i = 0; $i < $nColumns; $i++ )
{
    $aHeader[ $i ][ 'TEXT' ] = "Header #" . ( $i + 1 );
}

$aHeader1 = $aHeader;

$aHeader[ 0 ][ 'COLSPAN' ] = 2;

$aHeader[ 2 ][ 'COLSPAN' ] = 2;
$aHeader[ 2 ][ 'ROWSPAN' ] = 2;

//add the header
$oTable->addHeader( $aHeader );
$oTable->addHeader( $aHeader1 );

$sDefaultText = "Lorem ipsum;, dolor sit amet";
$sDefaultText2 = "<p>Some Line</p>\n<b>Some text</b>";
$sDefaultLongText = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
$sDefaultLongText2 = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur";

$aDefaultRow = Array();
for ( $i = 0; $i < $nColumns; $i++ )
{
    $aDefaultRow[ $i ][ 'TEXT' ] = $sDefaultText;
}
$aDefaultRow[ 0 ][ 'TEXT' ] = $sDefaultText2;

for ( $i = 1; $i < 10; $i++ )
{
    $aRow = $aDefaultRow;

    switch ( $i )
    {
        case 1:
            $aRow[ 0 ][ 'TEXT_ALIGN' ] = 'L';
            $aRow[ 1 ][ 'TEXT_ALIGN' ] = 'C';
            $aRow[ 2 ][ 'TEXT_ALIGN' ] = 'R';
            break;
        case 2:
            $aRow[ 0 ][ 'TEXT_ALIGN' ] = 'L';
            $aRow[ 0 ][ 'PADDING_LEFT' ] = 5;
            $aRow[ 0 ][ 'PADDING_RIGHT' ] = 5;
            $aRow[ 0 ][ 'PADDING_TOP' ] = 5;
            $aRow[ 1 ][ 'TEXT' ] = $sDefaultLongText;
            $aRow[ 1 ][ 'TEXT_ALIGN' ] = 'J';
            $aRow[ 1 ][ 'VERTICAL_ALIGN' ] = 'T';
            $aRow[ 2 ][ 'TEXT_ALIGN' ] = 'R';
            $aRow[ 2 ][ 'VERTICAL_ALIGN' ] = 'B';
            break;
        case 3:
            $aRow = $aRowLast;
            $aRow[ 1 ][ 'PADDING_TOP' ] = 0;
            break;
        case 4:
            $aRow = $aRowLast;
            $aRow[ 2 ][ 'PADDING_BOTTOM' ] = 0;
            break;
    }

    $oTable->addRow( $aRow );
    $aRowLast = $aRow;
}

//close the table
$oTable->close();

