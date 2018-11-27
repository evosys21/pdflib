<?php

if (!isset($pdf)) {
    $pdf = new myPdf();
}

use Interpid\PdfLib\Table;
use Interpid\PdfLib\Tools;

$table = new Table($pdf);

$table->setStyle("p", $pdf->getDefaultFontName(), "", 6, "130,0,30");
$table->setStyle("b", $pdf->getDefaultFontName(), "B", 6, "130,0,30");
$table->setStyle("bi", $pdf->getDefaultFontName(), "BI", 6, "0,0,120");

require('settings.php');

$columns = 5;

/**
 * Set the tag styles
 */

$table->initialize([20, 30, 40, 50]);

$table->addHeader($headerRow);

for ($i = 0; $i < 6; $i++) {
    $row = $dataRow;

    if ($i >= 0 && $i < 3) {
        $row[ 0 ][ 'TEXT' ] = "Forced\nLine\nBreaks";
        $align = Tools::getNextValue($alignments, $k);
        $row[ 1 ][ 'TEXT' ] = "Align: <b>$align</b>";
        $row[ 1 ][ 'ALIGN' ] = "$align";
        $align = Tools::getNextValue($alignments, $k);
        $row[ 2 ][ 'TEXT' ] = "Align: <b>$align</b>";
        $row[ 2 ][ 'ALIGN' ] = "$align";
        $align = Tools::getNextValue($alignments, $k);
        $row[ 3 ][ 'TEXT' ] = "Align: <b>$align</b>";
        $row[ 3 ][ 'ALIGN' ] = "$align";
    }

    if ($i >= 3 && $i <= 5) {
        $row[ 0 ][ 'TEXT' ] = "Forced\nLine\nForced\nLine\nForced\nLine";
        $row[ 1 ] = $imageCell;
        $row[ 1 ][ 'ALIGN' ] = Tools::getNextValue($alignments, $k);

        $row[ 2 ] = $imageCell;
        $row[ 2 ][ 'ALIGN' ] = Tools::getNextValue($alignments, $k);

        $row[ 3 ] = $imageCell;
        $row[ 3 ][ 'ALIGN' ] = Tools::getNextValue($alignments, $k);
    }


    $table->addRow($row);
}

//close the table
$table->close();
