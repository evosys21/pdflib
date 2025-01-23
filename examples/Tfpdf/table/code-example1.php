<?php

use EvoSys21\PdfLib\Examples\Tfpdf\MyPdf;
use EvoSys21\PdfLib\Table;

if (! isset($pdf)) {
    $pdf = new MyPdf();
}
if (! isset($table)) {
    $table = new Table($pdf);
}

$table->setStyle('p', 7, '', '130,0,30', 'helvetica');
$table->setStyle('b', 7, 'B', '130,0,30', 'helvetica');

$columns = 3;

/**
 * Set the tag styles
 */
$table->initialize([20, 30, 50]);

$header = [
    ['TEXT' => 'Header #1'],
    ['TEXT' => 'Header #2'],
    ['TEXT' => 'Header #3'],
];

//add the header row
$table->addHeader($header);

for ($j = 1; $j < 3; $j++) {
    $row = [];
    $row[0]['TEXT'] = "Line $j";
    $row[1]['TEXT'] = 'Lorem ipsum dolor sit amet...';
    $row[2]['TEXT'] = "<p>Simple text\n<b>Bold text</b></p>";

    //add the data row
    $table->addRow($row);
}

//close the table
$table->close();
