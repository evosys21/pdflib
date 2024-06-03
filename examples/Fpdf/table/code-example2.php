<?php

use evosys21\PdfLib\Table;
use evosys21\PdfLib\Examples\Fpdf\MyPdf;
use evosys21\PdfLib\Examples\Fpdf\PdfSettings;

if (!isset($pdf)) {
    $pdf = new MyPdf();
}

$table = new Table($pdf);

$table->setStyle('p', 7, '', '130,0,30', 'helvetica');
$table->setStyle('b', 7, 'B', '130,0,30', 'helvetica');
$table->setStyle('bi', 7, 'BI', '0,0,120', 'helvetica');

$columns = 3;

/**
 * Set the tag styles
 */

$table->initialize([20, 30, 80]);

$header = [
    ['TEXT' => 'Header #1'],
    ['TEXT' => 'Header #2'],
    ['TEXT' => 'Header #3']
];

//add the header row
$table->addHeader($header);

$imageCell = PdfSettings::$imageCell;

//row 1 - add data as Array
$row = [];
$row[0]['TEXT'] = "Line <b>1</b>";

$row[1] = PdfSettings::$imageCell;

$row[2]['TEXT'] = "<p>All <b>table cells</b> are fully functional <bi>Advanced Multicells</bi>\nDetails on <bi href='http://www.interpid.eu'>www.interpid.eu</bi></p>";
$row[2]['ALIGN'] = 'L';

//add the data row
$table->addRow($row);

//row 2 - add data as Objects
$row = [];

//alternatively you can create directly the cell object
$row[0] = new \evosys21\PdfLib\Table\Cell\Image($pdf, PDF_RESOURCES_IMAGES . '/blog.jpg', 10);
$row[1] = array(
    'TEXT' => "<p>This is another <b>Multicell</b></p>",
    'BACKGROUND_COLOR' => PdfSettings::$colors[0]
);

$row[2] = new \evosys21\PdfLib\Table\Cell\Image($pdf, PDF_RESOURCES_IMAGES . '/pensil.jpg', 10);
$row[2]->setAlign("R");

//add the data row
$table->addRow($row);

//close the table
$table->close();
