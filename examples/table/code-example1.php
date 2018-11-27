<?php

use Interpid\PdfLib\Table;

$table = new Table($pdf);

$table->setStyle("p", $pdf->getDefaultFontName(), "", 7, "130,0,30");
$table->setStyle("b", $pdf->getDefaultFontName(), "B", 7, "130,0,30");

$columns = 3;

/**
 * Set the tag styles
 */
$table->initialize([20, 30, 50]);

$header = array(
    ['TEXT' => 'Header #1'],
    ['TEXT' => 'Header #2'],
    ['TEXT' => 'Header #3'],
);

//add the header row
$table->addHeader($header);

for ($j = 1; $j < 3; $j++) {
    $row = [];
    $row[ 0 ][ 'TEXT' ] = "Line $j";
    $row[ 1 ][ 'TEXT' ] = "Lorem ipsum dolor sit amet...";
    $row[ 2 ][ 'TEXT' ] = "<p>Simple text\n<b>Bold text</b></p>";

    //add the data row
    $table->addRow($row);
}

//close the table
$table->close();
