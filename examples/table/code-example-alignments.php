<?php

if ( !isset( $oPdf ) )
{
    $oPdf = new myPdf();
}

$oTable = new PdfTable( $oPdf );

$oTable->setStyle( "p", $oPdf->getDefaultFontName(), "", 6, "130,0,30" );
$oTable->setStyle( "b", $oPdf->getDefaultFontName(), "B", 6, "130,0,30" );
$oTable->setStyle( "bi", $oPdf->getDefaultFontName(), "BI", 6, "0,0,120" );

require( 'settings.php' );

$nColumns = 5;

/**
 * Set the tag styles
 */

$oTable->initialize( array( 20, 30, 40, 50 ) );


$oTable->addHeader( $aHeaderRow );

for ( $i = 0; $i < 6; $i++ )
{
    $aRow = $aDataRow;

    if ( $i >= 0 && $i < 3 )
    {
        $aRow[ 0 ][ 'TEXT' ] = "Forced\nLine\nBreaks";
        $align = Pdf_Tools::getNextValue( $aAlignments, $k );
        $aRow[ 1 ][ 'TEXT' ] = "Align: <b>$align</b>";
        $aRow[ 1 ][ 'ALIGN' ] = "$align";
        $align = Pdf_Tools::getNextValue( $aAlignments, $k );
        $aRow[ 2 ][ 'TEXT' ] = "Align: <b>$align</b>";
        $aRow[ 2 ][ 'ALIGN' ] = "$align";
        $align = Pdf_Tools::getNextValue( $aAlignments, $k );
        $aRow[ 3 ][ 'TEXT' ] = "Align: <b>$align</b>";
        $aRow[ 3 ][ 'ALIGN' ] = "$align";
    }

    if ( $i >= 3 && $i <= 5 )
    {

        $aRow[ 0 ][ 'TEXT' ] = "Forced\nLine\nForced\nLine\nForced\nLine";
        $aRow[ 1 ] = $aImageCell;
        $aRow[ 1 ][ 'ALIGN' ] = Pdf_Tools::getNextValue( $aAlignments, $k );

        $aRow[ 2 ] = $aImageCell;
        $aRow[ 2 ][ 'ALIGN' ] = Pdf_Tools::getNextValue( $aAlignments, $k );

        $aRow[ 3 ] = $aImageCell;
        $aRow[ 3 ][ 'ALIGN' ] = Pdf_Tools::getNextValue( $aAlignments, $k );
    }


    $oTable->addRow( $aRow );
}

//close the table
$oTable->close();
