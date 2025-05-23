<?php

use EvoSys21\PdfLib\Table;

if (! isset($splitMode)) {
    $splitMode = true;
}

$tableConfig = require __DIR__ . '/table.config.php';

$pdf->SetFontSize(7);

$table = new Table($pdf);

$table->setStyle('p', 6, '', '130,0,30', 'helvetica');
$table->setStyle('b', 8, '', '80,80,260', 'helvetica');
$table->setStyle('h1', 10, '', '0,151,200', 'helvetica');
$table->setStyle('bi', 12, 'BI', '0,0,120', 'helvetica');

//default text color
$pdf->SetTextColor(118, 0, 3);

$columns = 4;

$pdf->Ln(30);

//Initialize the table, 3 columns
$table->initialize([20, 40, 20], $tableConfig);

$table->setSplitMode($splitMode);

$header = [];

//Table Header
for ($i = 0; $i < $columns; $i++) {
    $header[$i]['TEXT'] = 'Header #' . ($i + 1);
}

$header1 = $header;

$header[0]['COLSPAN'] = 2;

$header[2]['COLSPAN'] = 2;
$header[2]['ROWSPAN'] = 2;

//add the header
$table->addHeader($header);
$table->addHeader($header1);

$sDefaultText = 'Lorem ipsum;, dolor sit amet';
$sDefaultText2 = "<p>Some Line</p>\n<b>Some text</b>";
$sDefaultLongText = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
$sDefaultLongText2 = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur';

$aDefaultRow = [];
for ($i = 0; $i < $columns; $i++) {
    $aDefaultRow[$i]['TEXT'] = $sDefaultText;
}
$aDefaultRow[0]['TEXT'] = $sDefaultText2;

$table->setDisablePageBreak(true);

for ($i = 1; $i < 15; $i++) {
    $row = $aDefaultRow;

    $row[0]['TEXT'] = "Line #$i";

    $table->addRow($row);
    $rowLast = $row;
}

//close the table
$table->close();
