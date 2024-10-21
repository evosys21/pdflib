<?php

use EvoSys21\PdfLib\Examples\Tfpdf\MyPdf;
use EvoSys21\PdfLib\Table;
use EvoSys21\PdfLib\Examples\Tfpdf\PdfSettings;

if (!isset($pdf)) {
    $pdf = new MyPdf();
}

$y = $pdf->GetY();
$pdf->SetX(50);
$pdf->Image(CONTENT_PATH . "/images/sample-pdf.jpg");

$pdf->SetY($y);

$table = new Table($pdf);

$table->setStyle('p', 7, '', '130,0,30', 'helvetica');
$table->setStyle('b', 7, 'B', '130,0,30', 'helvetica');
$table->setStyle('bi', 7, 'BI', '0,0,120', 'helvetica');

$columns = 3;

/**
 * Set the tag styles
 */

$table->initialize([20, 30, 80]);
$table->setRowConfig(array(
    'BACKGROUND_COLOR' => false
));


$header = array(
    array(
        'TEXT' => 'Header #1'
    ),
    array(
        'TEXT' => 'Header #2'
    ),
    array(
        'TEXT' => 'Header #3'
    )
);

//add the header row
$table->addHeader($header);

PdfSettings::$imageCell = PdfSettings::$imageCell;

//row 1 - add data as Array
$row = [];
$row[0]['TEXT'] = "Line <b>1</b>";

$row[1] = PdfSettings::$imageCell;

$row[2]['TEXT'] = "<p>All <b>table cells</b> are fully functional <bi>Advanced Multicells</bi>\nDetails on <bi href='https://github.com/evosys21/pdflib'>https://github.com/evosys21/pdflib</bi></p>";
$row[2]['ALIGN'] = 'L';

//add the data row
$table->addRow($row);

//row 2 - add data as Objects
$row = [];

//alternatively you can create directly the cell object
$row[0] = new \EvoSys21\PdfLib\Table\Cell\Image($pdf, CONTENT_PATH . '/images/blog.jpg', 10);
$row[1] = new \EvoSys21\PdfLib\Table\Cell\Multicell($pdf, "<p>This is another <b>Multicell</b></p>");
$row[2]['TEXT'] = "<p>All <b>table cells</b> are fully functional <bi>Advanced Multicells</bi>\nDetails on <bi href='https://github.com/evosys21/pdflib'>https://github.com/evosys21/pdflib</bi></p>";
$row[2]['BACKGROUND_COLOR'] = PdfSettings::$colors[1];

//add the data row
$table->addRow($row);

//close the table
$table->close();
