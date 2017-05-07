<?php
/**
 * Pdf Advanced Table - Example
 * Copyright (c), Andrei Bintintan, http://www.interpid.eu
 */

//include pdf class
require_once( "classes/pdf.php" );

/**
 * mypdf extends pdf class, it is used to draw the header and footer
 */
require_once( "mypdf-table.php" );

//Tag Based Multicell Class
require_once( "classes/pdftable.php" );

//define some background colors
$aBgColor1 = array(
    234,
    255,
    218
);
$aBgColor2 = array(
    165,
    250,
    220
);
$aBgColor3 = array(
    255,
    252,
    249
);
$aBgColor4 = array(
    86,
    155,
    225
);
$aBgColor5 = array(
    207,
    247,
    239
);
$aBgColor6 = array(
    246,
    211,
    207
);
$bg_color7 = array(
    216,
    243,
    228
);

//create the pdf object and do some initialization
$oPdf = new myPdfTable();
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

//default text color
$oPdf->SetTextColor( 118, 0, 3 );

//create an advanced multicell
$oMulticell = PdfMulticell::getInstance( $oPdf );
$oMulticell->setStyle( "s1", $oPdf->getDefaultFontName(), "", 8, "118,0,3" );
$oMulticell->setStyle( "s2", $oPdf->getDefaultFontName(), "", 6, "0,49,159" );

$oMulticell->multiCell( 100, 4, "<s1>Example 1 - Very Simple Table</s1>", 0 );
$oPdf->Ln( 1 );

$nColumns = 5;

//Initialize the table class, 3 columns
$oTable->initialize( array(
    20,
    20,
    20,
    20,
    20
) );

$aHeader = array();

//Table Header
for ( $i = 0; $i < $nColumns; $i++ ) {
    $aHeader[ $i ][ 'TEXT' ] = "Header #" . ( $i + 1 );
}

$aHeader1 = $aHeader;

$aHeader[ 0 ][ 'COLSPAN' ] = 2;

//add the header
$oTable->addHeader( $aHeader );
$oTable->addHeader( $aHeader1 );

for ( $j = 1; $j < 5; $j++ ) {
    $aRow = Array();

    for ( $i = 0; $i < $nColumns; $i++ ) {
        $aRow[ $i ][ 'TEXT' ] = "Line $j Text $i";
    }

    $aRow[ 0 ][ 'COLSPAN' ] = 2;
    $aRow[ 0 ][ 'TEXT_ALIGN' ] = "L"; //text align
    //$aRow[0]['LINE_SIZE'] = 7; //text align
    $aRow[ 2 ][ 'TEXT_ALIGN' ] = "R"; //text align


    //add the row
    $oTable->addRow( $aRow );
    //break;
}

//close the table
$oTable->close();

//send the pdf to the browser
$oPdf->Output();
