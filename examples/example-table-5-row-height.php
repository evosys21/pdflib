<?php
/**
 * Pdf Advanced Table - Example
 * Copyright (c), Interpid, http://www.interpid.eu
 */

require_once __DIR__ . "/../autoload.php";

use Interpid\PdfLib\Multicell;
use Interpid\PdfLib\Table;
use Interpid\PdfExamples\PdfFactory;

$factory = new PdfFactory();

//get the PDF object
$pdf = PdfFactory::newPdf('table');
/**
 * Create the pdf Table object
 * Alternative you can use the Singleton Instance
 *
 * @example : $table = Table::getInstance($pdf);
 */
$table = new Table($pdf);

/**
 * Set the tag styles
 */
$table->setStyle('p', 10, '', '130,0,30', 'helvetica');
$table->setStyle('b', 9, '', '80,80,260', 'helvetica');
$table->setStyle('h1', 10, '', '0,151,200', 'helvetica');
$table->setStyle('bi', 12, 'BI', '0,0,120', 'helvetica');
$table->setStyle('size', 13, 'BI', '0,0,120', 'helvetica');

//default text color
$pdf->SetTextColor(118, 0, 3);

//create an advanced multicell
$multicell = Multicell::getInstance($pdf);
$multicell->setStyle('s1', 8, '', '118,0,3', 'helvetica');
$multicell->setStyle('s2', 6, '', '0,49,159', 'helvetica');
$multicell->multiCell(100, 4, "<s1>Example - Override Default Configuration Values</s1>", 0);

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
        $row[1]['VERTICAL_ALIGN'] = 'T';
        $row[1]['PADDING_TOP'] = 5;
        $row[1]['PADDING_LEFT'] = 5;
        $row[1]['TEXT'] = "<p>This is a <b>Multicell</b>\n\nRow Height: 30</p>";
        $row[1]['HEIGHT'] = 30; //enforce height:30
    }

    //add the row
    $table->addRow($row);
}

//close the table
$table->close();

//send the pdf to the browser
$pdf->Output();