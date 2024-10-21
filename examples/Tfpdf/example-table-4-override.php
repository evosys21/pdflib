<?php
/**
 * Pdf Advanced Table - Example
 */

require_once __DIR__ . '/autoload.php';

use EvoSys21\PdfLib\Multicell;
use EvoSys21\PdfLib\Table;
use EvoSys21\PdfLib\Examples\Tfpdf\PdfFactory;
use EvoSys21\PdfLib\Examples\Tfpdf\PdfSettings;

//get the PDF object
$pdf = PdfFactory::newPdf('table');
/**
 * Create the pdf Table object
 * Alternative you can use the Singleton Instance
 *
 * @example : $table = Table::getInstance($pdf);
 */
$table = new Table($pdf);

// Set the styles for the advanced table
PdfSettings::setTableStyles($table);

//default text color
$pdf->SetTextColor(118, 0, 3);

//create an advanced multicell
$multicell = Multicell::getInstance($pdf);
PdfSettings::setMulticellStyles($multicell);

$multicell->multiCell(100, 4, "<s1>Example - Override Default Configuration Values</s1>");

$columns = 3;

$config = array(
    'TABLE' => array(
        'TABLE_ALIGN' => 'L', //left align
        'BORDER_COLOR' => [0, 0, 0], //border color
        'BORDER_SIZE' => '0.5', //border size
    ),

    'HEADER' => array(
        'TEXT_COLOR' => [25, 60, 170], //text color
        'TEXT_SIZE' => 9, //font size
        'LINE_SIZE' => 6, //line size for one row
        'BACKGROUND_COLOR' => [182, 240, 0], //background color
        'BORDER_SIZE' => 0.5, //border size
        'BORDER_TYPE' => 'B', //border type, can be: 0, 1 or a combination of: 'LRTB'
        'BORDER_COLOR' => [0, 0, 0], //border color
    ),

    'ROW' => array(
        'TEXT_COLOR' => [225, 20, 0], //text color
        'TEXT_SIZE' => 6, //font size
        'BACKGROUND_COLOR' => [232, 255, 209], //background color
        'BORDER_COLOR' => [150, 255, 56], //border color
    ),
);

//Initialize the table, 3 columns
$table->initialize([40, 50, 30], $config);

$header = [];

//Table Header
for ($i = 0; $i < $columns; $i++) {
    $header[$i]['TEXT'] = "Header #" . ($i + 1);
}

//add the header
$table->addHeader($header);

for ($j = 1; $j < 5; $j++) {
    $row = [];
    $row[0]['TEXT'] = "Line $j Text 1"; //text for column 0
    $row[1]['TEXT'] = "Line $j Text 2"; //text for column 1
    $row[2]['TEXT'] = "Line $j Text 3"; //text for column 2


    //override some settings for row 2
    if (2 == $j) {
        $row[1]['TEXT_ALIGN'] = 'L';
        $row[1]['TEXT'] = "<p>This is a <b>Multicell</b></p>";
    }

    //add the row
    $table->addRow($row);
}

//close the table
$table->close();

//send the pdf to the browser
$pdf->Output();
