<?php
/**
 * Pdf Advanced Table - Example
 * Copyright (c) 2014, Andrei Bintintan, http://www.interpid.eu
 */

// include the pdf factory
require_once( "pdfFactory.php" );

// Include the Advanced Table Class
require_once( "classes/pdftable.php" );

/**
 * Include my Custom PDF class This is required only to overwrite the header
 */
require_once( "mypdf-table.php" );

$factory = new pdfFactory();

// create new PDF document
$oPdf = new myPdfTable();
$factory->initPdfObject( $oPdf );

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
$oTable->SetStyle( "size", $oPdf->getDefaultFontName(), "BI", 13, "0,0,120" );

//default text color
$oPdf->SetTextColor( 118, 0, 3 );

//create an advanced multicell    
$oMulticell = PdfMulticell::getInstance( $oPdf );
$oMulticell->SetStyle( "s1", $oPdf->getDefaultFontName(), "", 8, "118,0,3" );
$oMulticell->SetStyle( "s2", $oPdf->getDefaultFontName(), "", 6, "0,49,159" );
$oMulticell->multiCell( 100, 4, "<s1>Example - Override Default Configuration Values</s1>", 0 );

$nColumns = 3;

$aCustomConfiguration = array(
    'TABLE' => array(
        'TABLE_ALIGN' => 'L', //left align
        'BORDER_COLOR' => array( 0, 0, 0 ), //border color
        'BORDER_SIZE' => '0.5', //border size
    ),

    'HEADER' => array(
        'TEXT_COLOR' => array( 25, 60, 170 ), //text color
        'TEXT_SIZE' => 9, //font size
        'LINE_SIZE' => 6, //line size for one row
        'BACKGROUND_COLOR' => array( 182, 240, 0 ), //background color
        'BORDER_SIZE' => 0.5, //border size
        'BORDER_TYPE' => 'B', //border type, can be: 0, 1 or a combination of: "LRTB"
        'BORDER_COLOR' => array( 0, 0, 0 ), //border color
    ),

    'ROW' => array(
        'TEXT_COLOR' => array( 225, 20, 0 ), //text color
        'TEXT_SIZE' => 6, //font size
        'BACKGROUND_COLOR' => array( 232, 255, 209 ), //background color
        'BORDER_COLOR' => array( 150, 255, 56 ), //border color
    ),
);

//Initialize the table class, 3 columns
$oTable->initialize( array( 40, 50, 30 ), $aCustomConfiguration );

$aHeader = array();

//Table Header
for ( $i = 0; $i < $nColumns; $i++ )
{
    $aHeader[ $i ][ 'TEXT' ] = "Header #" . ( $i + 1 );
}

//add the header
$oTable->addHeader( $aHeader );

for ( $j = 1; $j < 5; $j++ )
{
    $aRow = Array();
    $aRow[ 0 ][ 'TEXT' ] = "Line $j Text 1"; //text for column 0
    $aRow[ 1 ][ 'TEXT' ] = "Line $j Text 2"; //text for column 1
    $aRow[ 2 ][ 'TEXT' ] = "Line $j Text 3"; //text for column 2


    //override some settings for row 2
    if ( 2 == $j )
    {
        $aRow[ 1 ][ 'TEXT_ALIGN' ] = 'L';
        $aRow[ 1 ][ 'TEXT' ] = "<p>This is a <b>Multicell</b></p>";
    }

    //add the row
    $oTable->addRow( $aRow );
}

//close the table
$oTable->close();

//send the pdf to the browser
$oPdf->Output();
