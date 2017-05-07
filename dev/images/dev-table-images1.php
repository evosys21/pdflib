<?php
/**
 * Pdf Advanced Table - Example
 * Copyright (c), Andrei Bintintan, http://www.interpid.eu
 */

/**
 * mypdf extends pdf class, it is used to draw the header and footer
 */
require_once( "../dev-pdf.php" );

//create the pdf object and do some initialization

$oPdf = new devPdf( 'P', 'mm', array( 130, 180 ) );

$oPdf->SetAutoPageBreak( true, 20 );
$oPdf->SetMargins( 20, 20, 20 );
$oPdf->AddPage();
$oPdf->AliasNbPages();

/**
 * Create the pdf Table object
 * Alternative you can use the Singleton Instance
 *
 * @example : $oTable = PdfTable::getInstance($oPdf);
 */
$oTable = new PdfTable( $oPdf );

/**
 * Set the tag styles
 */
$oTable->setStyle( "p", $oPdf->getDefaultFontName(), "", 10, "130,0,30" );
$oTable->setStyle( "b", $oPdf->getDefaultFontName(), "", 9, "80,80,260" );
$oTable->setStyle( "h1", $oPdf->getDefaultFontName(), "", 10, "0,151,200" );
$oTable->setStyle( "bi", $oPdf->getDefaultFontName(), "BI", 12, "0,0,120" );

//create an advanced multicell
$oMulticell = PdfMulticell::getInstance( $oPdf );
$oMulticell->setStyle( "s1", $oPdf->getDefaultFontName(), "", 8, "118,0,3" );
$oMulticell->setStyle( "s2", $oPdf->getDefaultFontName(), "", 6, "0,49,159" );

$oMulticell->multiCell( 100, 4, "<s1>Example 1 - Very Simple Table</s1>", 0 );

$nColumns = 5;

//Initialize the table class, 3 columns
$oTable->initialize( array(
    20,
    20,
    20,
    20
) );

//$oTable->setSplitMode(false);
$oTable->setSplitMode( true );

$aHeader = array();

//Table Header
for ( $i = 0; $i < $nColumns; $i++ ) {
    $aHeader[ $i ][ 'TEXT' ] = "Header #" . ( $i + 1 );
}

$aHeader1 = $aHeader;

$aHeader[ 0 ][ 'COLSPAN' ] = 2;

$aHeader[ 2 ][ 'COLSPAN' ] = 2;
$aHeader[ 2 ][ 'ROWSPAN' ] = 2;

//add the header
$oTable->addHeader( $aHeader );
$oTable->addHeader( $aHeader1 );

$aImageCell1 = array(
    'TYPE' => 'IMAGE',
    'FILE' => PDF_APPLICATION_PATH . '/images/dice.jpg',
    'WIDTH' => 10
);

$aAlignments = array(
    'TL',
    'TC',
    'TR',
    'ML',
    'MC',
    'MR',
    'BL',
    'BC',
    'BR'
);

$nAlign = 0;

for ( $i = 1; $i < 25; $i++ ) {

    $aRow = Array();

    $oImage = new Pdf_Table_Cell_Image( $oPdf );
    $oImage->setImage( PDF_APPLICATION_PATH . '/images/camaro_128.jpg', 19, 19 );

    $aRow[ 0 ] = $oImage;

    for ( $j = 1; $j < 4; $j++ ) {
        if ( $nAlign >= count( $aAlignments ) ) {
            $nAlign = 0;
        }
        $aRow[ $j ] = $aImageCell1;
        $aRow[ $j ][ 'ALIGN' ] = $aAlignments[ $nAlign++ ];
    }

    $aRow[ 2 ] = array(
        'TEXT' => 'SDG'
    );

    //add the row
    $oTable->addRow( $aRow );
}

//close the table
$oTable->close();

//send the pdf to the browser
$oPdf->Output();
