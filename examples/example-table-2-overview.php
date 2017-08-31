<?php
/**
 * Pdf Advanced Table - Example
 * Copyright (c), Interpid, http://www.interpid.eu
 */

require_once __DIR__ . "/../autoload.php";

use Interpid\PdfLib\Table;
use Interpid\PdfExamples\pdfFactory;

$factory = new pdfFactory();

//get the PDF object
$pdf = pdfFactory::newPdf( 'table' );

//define some background colors
$aBgColor1 = [ 234, 255, 218 ];
$aBgColor2 = [ 165, 250, 220 ];
$aBgColor3 = [ 255, 252, 249 ];
/**
 * Create the pdf Table object
 * Alternative you can use the Singleton Instance
 *
 * @example : $table = Table::getInstance($pdf);
 */
$table = new Table( $pdf );

/**
 * Set the tag styles
 */
$table->setStyle( "p", $pdf->getDefaultFontName(), "", 10, "130,0,30" );
$table->setStyle( "b", $pdf->getDefaultFontName(), "", 9, "80,80,260" );
$table->setStyle( "h1", $pdf->getDefaultFontName(), "", 10, "0,151,200" );
$table->setStyle( "bi", $pdf->getDefaultFontName(), "BI", 12, "0,0,120" );

$txt1 = $title = file_get_contents( PDF_APPLICATION_PATH . '/content/table-cell-text.txt' );

//Initialize the table class, 5 columns with the specified widths
$table->initialize( [ 20, 30, 40, 40, 20 ] );

$header = [
    [ 'TEXT' => 'Header 1' ],
    [ 'TEXT' => 'Header 2' ],
    [ 'TEXT' => 'Header 3' ],
    [ 'TEXT' => 'Header 4' ],
    [ 'TEXT' => 'Header 5' ]
];

//add the header line
$table->addHeader( $header );

//do some adjustments in the header
$header[ 2 ][ 'TEXT' ] = 'Header Colspan/Rowspan';
$header[ 2 ][ 'COLSPAN' ] = 2;
$header[ 2 ][ 'ROWSPAN' ] = 2;
$header[ 2 ][ 'TEXT_COLOR' ] = [ 10, 20, 100 ];
$header[ 2 ][ 'BACKGROUND_COLOR' ] = $aBgColor2;

$table->addHeader( $header );

//add an empty header line
$table->addHeader();

$fsize = 5;
$colspan = 2;
$rowspan = 2;

$rgb_r = 255;
$rgb_g = 255;
$rgb_b = 255;

for ( $j = 0; $j < 45; $j++ ) {
    $aRow = [];
    $aRow[ 0 ][ 'TEXT' ] = "Row No - $j";
    $aRow[ 0 ][ 'TEXT_SIZE' ] = $fsize;
    $aRow[ 1 ][ 'TEXT' ] = "Test Text Column 1- $j";
    $aRow[ 1 ][ 'TEXT_SIZE' ] = 13 - $fsize;
    $aRow[ 2 ][ 'TEXT' ] = "Test Text Column 2- $j";
    $aRow[ 3 ][ 'TEXT' ] = "Longer text, this will split sometimes...";
    $aRow[ 3 ][ 'TEXT_SIZE' ] = 15 - $fsize;
    $aRow[ 4 ][ 'TEXT' ] = "Short 4- $j";
    $aRow[ 4 ][ 'TEXT_SIZE' ] = 7;

    if ( $j == 0 ) {
        $aRow[ 1 ][ 'TEXT' ] = $txt1;
        $aRow[ 1 ][ 'COLSPAN' ] = 4;
        $aRow[ 1 ][ 'ALIGN' ] = "C";
        $aRow[ 1 ][ 'LINE_SIZE' ] = 5;
    } elseif ( $j == 1 ) {
        $aRow[ 0 ][ 'TEXT' ] = "Top Right Align <p>Align Top</p> Right Right Align";
        $aRow[ 0 ][ 'ALIGN' ] = "RT";

        $aRow[ 1 ][ 'TEXT' ] = "Middle Center Align Bold Italic";
        $aRow[ 1 ][ 'TEXT_TYPE' ] = "BI";
        $aRow[ 1 ][ 'ALIGN' ] = "MC";

        $aRow[ 2 ][ 'TEXT' ] = "\n\n\n\n\nBottom Left Align";
        $aRow[ 2 ][ 'ALIGN' ] = "BL";

        $aRow[ 3 ][ 'TEXT' ] = "Middle Justified Align Longer text";
        $aRow[ 3 ][ 'ALIGN' ] = "MJ";

        $aRow[ 4 ][ 'TEXT' ] = "TOP RIGHT Align with top padding(5)";
        $aRow[ 4 ][ 'ALIGN' ] = "TR";
        $aRow[ 4 ][ 'PADDING_TOP' ] = 5;
    }

    if ( $j == 2 ) {
        $aRow[ 1 ][ 'TEXT' ] = "Cells can be images -->>>";
        $aRow[ 2 ] = array(
            'TYPE' => 'IMAGE',
            'FILE' => PDF_RESOURCES_IMAGES . '/dice.jpg',
            'WIDTH' => 15
        );
    }

    if ( $j > 0 ) {
        $aRow[ 0 ][ 'BACKGROUND_COLOR' ] = [ 255 - $rgb_b, $rgb_g, $rgb_r ];
        $aRow[ 1 ][ 'BACKGROUND_COLOR' ] = [ $rgb_r, $rgb_g, $rgb_b ];
    }

    if ( $j > 3 && $j < 7 ) {
        $aRow[ 1 ][ 'TEXT' ] = "Colspan Example - Center Align";
        $aRow[ 1 ][ 'COLSPAN' ] = $colspan;
        $aRow[ 1 ][ 'BACKGROUND_COLOR' ] = [ $rgb_b, 50, 50 ];
        $aRow[ 1 ][ 'TEXT_COLOR' ] = [ 255, 255, $rgb_g ];
        $aRow[ 1 ][ 'TEXT_ALIGN' ] = "C";
        $colspan++;
        if ( $colspan > 4 ) {
            $colspan = 2;
        }
    }

    if ( $j == 7 ) {
        $aRow[ 3 ][ 'TEXT' ] = "Rowspan Example";
        $aRow[ 3 ][ 'BACKGROUND_COLOR' ] = [ $rgb_b, $rgb_b, 250 ];
        $aRow[ 3 ][ 'ROWSPAN' ] = 4;
    }

    if ( $j == 8 ) {
        $aRow[ 1 ][ 'TEXT' ] = "Rowspan Example";
        $aRow[ 1 ][ 'BACKGROUND_COLOR' ] = [ $rgb_b, 50, 50 ];
        $aRow[ 1 ][ 'ROWSPAN' ] = 6;
    }

    if ( $j == 9 ) {
        $aRow[ 2 ][ 'TEXT' ] = "Rowspan Example";
        $aRow[ 2 ][ 'BACKGROUND_COLOR' ] = [ $rgb_r, $rgb_r, $rgb_r ];
        $aRow[ 2 ][ 'ROWSPAN' ] = 3;
    }

    if ( $j == 12 ) {
        $aRow[ 2 ][ 'TEXT' ] = "Rowspan && Colspan Example\n\nCenter/Middle Allignment";
        $aRow[ 2 ][ 'TEXT_ALIGN' ] = 'C';
        $aRow[ 2 ][ 'VERTICAL_ALIGN' ] = 'M';
        $aRow[ 2 ][ 'BACKGROUND_COLOR' ] = [ 234, 255, 218 ];
        $aRow[ 2 ][ 'ROWSPAN' ] = 5;
        $aRow[ 2 ][ 'COLSPAN' ] = 2;
    }

    if ( $j == 17 ) {
        $aRow[ 0 ][ 'TEXT' ] = $txt1;
        $aRow[ 0 ][ 'TEXT_ALIGN' ] = 'C';
        $aRow[ 0 ][ 'VERTICAL_ALIGN' ] = 'M';
        $aRow[ 0 ][ 'BACKGROUND_COLOR' ] = [ 234, 255, 218 ];
        $aRow[ 0 ][ 'ROWSPAN' ] = 5;
        $aRow[ 0 ][ 'COLSPAN' ] = 4;
    }

    $fsize += 0.5;

    if ( $fsize > 10 ) {
        $fsize = 5;
    }

    $rgb_b -= 10;
    $rgb_g -= 5;
    $rgb_b -= 20;

    if ( $rgb_b < 150 ) {
        $rgb_b = 255;
    }
    if ( $rgb_g < 150 ) {
        $rgb_g = 255;
    }
    if ( $rgb_b < 150 ) {
        $rgb_b = 255;
    }

    $table->addRow( $aRow );
}

//close the table
$table->close();

//send the pdf to the browser
$pdf->Output();
