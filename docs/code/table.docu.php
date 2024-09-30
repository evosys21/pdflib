<?php
/** @noinspection ALL */

use evosys21\PdfLib\Fpdf\Pdf;
use evosys21\PdfLib\Table;
use evosys21\PdfLib\Table;

$pdf = new Pdf();
$table = new Table($pdf);

//header row configuration
$header = [
    ['TEXT' => 'Header 1'],
    ['TEXT' => 'Header 2'],
    ['TEXT' => 'Header 3'],
];

//add the first header row
$table->addHeader($header);

//header row configuration
$header = [
    [
        'TEXT' => 'Header Row 2'
    ],
    [
        'TEXT' => 'Header Row 2 / 2-3',
        'COLSPAN' => 2,
    ],
    //due to the colspan, the third header can be ignored
];

//add the second header row
$table->addHeader($header);

//you can even add the same header again...
$table->addHeader($header);

//add an empty header line
$table->addHeader();


$header = [
    [
        'TEXT' => 'Header 1', //header text
        'PADDING_TOP' => 5, //add some padding,
        'TEXT_TYPE' => 'B', //bold text
    ],
    ['TEXT' => 'Header 2'],
    ['TEXT' => 'Header 3'],
];


//add some table rows
for ($i = 1; $i < 5; $i++) {
    $row = [];
    $row[0]['TEXT'] = "Line $i Text 1";    //text for column 0
    $row[1]['TEXT'] = "Line $i Text 2";    //text for column 1
    $row[2]['TEXT'] = "Line $i Text 3";    //text for column 2

    //override some settings for row 2
    if (2 == $i) {
        $row[1]['TEXT_ALIGN'] = 'L';
        $row[1]['TEXT'] = "<pp>This is a <b>Multicell</b></pp>";
    }
    //add the row
    $table->addRow($row);
}


$row = [
    ['TEXT' => 'I am cell 1'],
    ['TEXT' => 'I am cell 2'],
    ['TEXT' => 'I am cell 3'],
];

$row = [
    'I am cell 1',
    'I am cell 2',
    'I am cell 3',
];

//add the row to the table
$table->addRow($row);


$row = [
    [
        'TEXT' => 'I am cell 1',
        'TEXT_ALIGN' => 'L'
    ],
    ['TEXT' => 'I am cell 2'],
    ['TEXT' => 'I am cell 3'],
];

//add the row to the table
$table->addRow($row);

$row = [
    [
        'TEXT' => '<p>This is a <b>Multicell</b></p>',
        'TEXT_ALIGN' => 'L'
    ],
    ['TEXT' => '<p>This is a <b>Multicell</b></p>'],
    ['TEXT' => '<p>This is a <b>Multicell</b></p>'],
];

//add the row to the table
$table->addRow($row);


//row 2 - add data as Objects
$row = [];

//alternatively you can create directly the cell object
$row[0] = new \evosys21\PdfLib\Table\Cell\Image($pdf, '/blog.jpg', 10);
$row[1] = new \evosys21\PdfLib\Table\Cell\Multicell($pdf, "<p>This is another <b>Multicell</b></p>");
$row[2]['TEXT'] = "<p>All <b>table cells</b> are fully functional <bi>Advanced Multicells</bi>\nDetails on <bi href='https://github.com/evosys21/pdflib'>www.interpid.eu</bi></p>";
$row[2]['BACKGROUND_COLOR'] = $aColor[1];



