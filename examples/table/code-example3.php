<?php

require( 'settings.php' );

if ( !isset( $oPdf ) )
{
    $oPdf = new myPdf();
}

$oTable = new PdfTable( $oPdf );

$oTable->setStyle( "p", $oPdf->getDefaultFontName(), "", 6, "130,0,30" );
$oTable->setStyle( "b", $oPdf->getDefaultFontName(), "B", 6, "130,0,30" );
$oTable->setStyle( "bi", $oPdf->getDefaultFontName(), "BI", 6, "0,0,120" );
$oTable->setStyle( "s1", $oPdf->getDefaultFontName(), "I", 6, "0,0,120" );
$oTable->setStyle( "s2", $oPdf->getDefaultFontName(), "", 7, "110,50,120" );

$nColumns = 5;

/**
 * Set the tag styles
 */

$oTable->initialize( array( 20, 30, 40, 50 ) );


$aHeader1 = $aHeaderRow;
$aHeader1[ 2 ][ 'TEXT' ] = 'Colspan in Header';
$aHeader1[ 2 ][ 'COLSPAN' ] = 2;

$aHeader2 = $aHeaderRow;
$aHeader3 = $aHeaderRow;

$aHeader2[ 1 ][ 'TEXT' ] = "Colspan/Rowspan in Header";
$aHeader2[ 1 ][ 'COLSPAN' ] = 2;
$aHeader2[ 1 ][ 'ROWSPAN' ] = 2;

$oTable->addHeader( $aHeader1 );
$oTable->addHeader( $aHeader2 );
$oTable->addHeader( $aHeader3 );


for ( $i = 0; $i < 8; $i++ )
{
    $aRow = $aDataRow;

    if ( 0 == $i )
    {
        $aRow[ 1 ][ 'COLSPAN' ] = 2;
    }

    if ( 1 == $i )
    {
        $aRow[ 1 ][ 'COLSPAN' ] = 3;
    }

    if ( 2 == $i )
    {
        $aRow[ 1 ][ 'TEXT' ] = $sTextExtraLong . "\n\n" . $sTextSubSuperscript;
        $aRow[ 1 ][ 'ALIGN' ] = "J";
        $aRow[ 1 ][ 'COLSPAN' ] = 3;
        $aRow[ 1 ][ 'ROWSPAN' ] = 3;
    }

    if ( 3 == $i )
    {
        $aRow[ 0 ] = $aImageCell;
    }

    if ( 5 == $i )
    {
        $aRow[ 1 ] = $aImageCell;
        $aRow[ 1 ][ 'COLSPAN' ] = 2;
        $aRow[ 1 ][ 'ROWSPAN' ] = 2;
    }


    $oTable->addRow( $aRow );
}

//close the table
$oTable->close();
