<?php

use evosys21\PdfLib\Table;

if (!isset($bSplitMode)) {
    $bSplitMode = true;
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
$table->initialize([20, 20, 20, 20], $tableConfig);

$table->setSplitMode($bSplitMode);

$header = [];

//Table Header
for ($i = 0; $i < $columns; $i++) {
    $header[$i]['TEXT'] = "Header #" . ($i + 1);
}

$header1 = $header;

$header[0]['COLSPAN'] = 2;

$header[2]['COLSPAN'] = 2;
$header[2]['ROWSPAN'] = 2;

//add the header
$table->addHeader($header);
$table->addHeader($header1);

$sDefaultText = "Lorem ipsum;, dolor sit amet";
$sDefaultText2 = "<p>Some Line</p>\n<b>Some text</b>";
$sDefaultLongText = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
$sDefaultLongText2 = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur";

$aDefaultRow = [];
for ($i = 0; $i < $columns; $i++) {
    $aDefaultRow[$i]['TEXT'] = $sDefaultText;
}
$aDefaultRow[0]['TEXT'] = $sDefaultText2;

for ($i = 1; $i < 10; $i++) {
    $row = $aDefaultRow;

    switch ($i) {
        case 1:
            $row[0]['TEXT_ALIGN'] = 'L';
            $row[1]['TEXT_ALIGN'] = 'C';
            $row[2]['TEXT_ALIGN'] = 'R';
            break;
        case 2:
            $row[0]['TEXT_ALIGN'] = 'L';
            $row[0]['TEXT'] = $sDefaultText2;
            $row[1]['TEXT_ALIGN'] = 'C';
            $row[1]['VERTICAL_ALIGN'] = 'T';
            $row[2]['TEXT_ALIGN'] = 'R';
            $row[2]['VERTICAL_ALIGN'] = 'B';
            break;
        case 3:
            $row[0]['COLSPAN'] = 2;
            $row[0]['TEXT_ALIGN'] = 'L';
            $row[2]['COLSPAN'] = 2;
            $row[2]['TEXT_ALIGN'] = 'R';
            break;
        case 4:
            $row[1]['COLSPAN'] = 2;
            $row[1]['TEXT_ALIGN'] = 'J';
            $row[1]['TEXT'] = $sDefaultLongText;
            $row[1]['LINE_SIZE'] = 2;
            break;
        case 5:
            $row = $rowLast;
            $row[1]['COLSPAN'] = 3;
            $row[1]['VERTICAL_ALIGN'] = 'B';
            $row[1]['TEXT_ALIGN'] = 'R';
            break;
        case 6:
            $row[0]['ROWSPAN'] = 2;
            $row[1]['ROWSPAN'] = 2;
            break;
        case 7:
//            $row[ 3 ][ 'ROWSPAN' ] = 3;
            break;
        case 8:
            $row[0]['ROWSPAN'] = 2;
            $row[0]['TEXT'] = $sDefaultLongText;
            break;

        case 10:
            break;
    }

    $table->addRow($row);
    $rowLast = $row;
}

//close the table
$table->close();