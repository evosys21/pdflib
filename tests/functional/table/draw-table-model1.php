<?php

use Interpid\PdfLib\Table;

if (!isset($bSplitMode)) {
    $bSplitMode = true;
}

require __DIR__ . '/table.config.php';

$pdf->SetFontSize(7);

$table = new Table($pdf);

$table->setStyle('p', 6, '', '130,0,30', $pdf->getDefaultFontName());
$table->setStyle('b', 8, '', '80,80,260', $pdf->getDefaultFontName());
$table->setStyle('h1', 10, '', '0,151,200', $pdf->getDefaultFontName());
$table->setStyle('bi', 12, 'BI', '0,0,120', $pdf->getDefaultFontName());

//default text color
$pdf->SetTextColor(118, 0, 3);

$columns = 4;

$pdf->Ln(30);

//Initialize the table, 3 columns
$table->initialize(array(
    20,
    40,
    20
), $aDefaultConfiguration);

$table->setSplitMode($bSplitMode);

$header = [];

//Table Header
for ($i = 0; $i < $columns; $i++) {
    $header[ $i ][ 'TEXT' ] = "Header #" . ($i + 1);
}

$header1 = $header;

$header[ 0 ][ 'COLSPAN' ] = 2;

$header[ 2 ][ 'COLSPAN' ] = 2;
$header[ 2 ][ 'ROWSPAN' ] = 2;

//add the header
$table->addHeader($header);
$table->addHeader($header1);

$sDefaultText = "Lorem ipsum;, dolor sit amet";
$sDefaultText2 = "<p>Some Line</p>\n<b>Some text</b>";
$sDefaultLongText = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
$sDefaultLongText2 = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur";

$aDefaultRow = [];
for ($i = 0; $i < $columns; $i++) {
    $aDefaultRow[ $i ][ 'TEXT' ] = $sDefaultText;
}
$aDefaultRow[ 0 ][ 'TEXT' ] = $sDefaultText2;

for ($i = 1; $i < 10; $i++) {
    $row = $aDefaultRow;

    switch ($i) {
        case 1:
            $row[ 0 ][ 'TEXT_ALIGN' ] = 'L';
            $row[ 1 ][ 'TEXT_ALIGN' ] = 'C';
            $row[ 2 ][ 'TEXT_ALIGN' ] = 'R';
            break;
        case 2:
            $row[ 0 ][ 'TEXT_ALIGN' ] = 'L';
            $row[ 0 ][ 'PADDING_LEFT' ] = 5;
            $row[ 0 ][ 'PADDING_RIGHT' ] = 5;
            $row[ 0 ][ 'PADDING_TOP' ] = 5;
            $row[ 1 ][ 'TEXT' ] = $sDefaultLongText;
            $row[ 1 ][ 'TEXT_ALIGN' ] = 'J';
            $row[ 1 ][ 'VERTICAL_ALIGN' ] = 'T';
            $row[ 2 ][ 'TEXT_ALIGN' ] = 'R';
            $row[ 2 ][ 'VERTICAL_ALIGN' ] = 'B';
            break;
        case 3:
            $row = $rowLast;
            $row[ 1 ][ 'PADDING_TOP' ] = 0;
            break;
        case 4:
            $row = $rowLast;
            $row[ 2 ][ 'PADDING_BOTTOM' ] = 0;
            break;
    }

    $table->addRow($row);
    $rowLast = $row;
}

//close the table
$table->close();
