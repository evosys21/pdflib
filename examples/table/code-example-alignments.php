<?php

if ( !isset( $pdf ) )
{
    $pdf = new myPdf();
}

$table = new PdfTable( $pdf );

$table->setStyle( "p", 'Helvetica', "", 6, "130,0,30" );
$table->setStyle( "b", 'Helvetica', "B", 6, "130,0,30" );
$table->setStyle( "bi", 'Helvetica', "BI", 6, "0,0,120" );

require( 'settings.php' );

$columns = 5;

/**
 * Set the tag styles
 */

$table->initialize( array( 20, 30, 40, 50 ) );


$table->addHeader( $headerRow );

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


    $table->addRow( $aRow );
}

//close the table
$table->close();
