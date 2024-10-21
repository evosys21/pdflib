<?php
/**
 * Pdf Advanced Table - Example
 */

require_once __DIR__ . '/../autoload.php';

use EvoSys21\PdfLib\Fpdf\Pdf;
use EvoSys21\PdfLib\Table;
use EvoSys21\PdfLib\Table\Cell\Image;

// Pdf extends FPDF
$pdf = new Pdf();

// use the default FPDF configuration
$pdf->SetAuthor('EvoSys21');
$pdf->SetMargins(20, 20, 20);
$pdf->SetAutoPageBreak(true, 20);

$pdf->SetFont('helvetica', '', 11);
$pdf->SetTextColor(200, 10, 10);
$pdf->SetFillColor(254, 255, 245);

// add a page
$pdf->AddPage();

// Create the Advanced Table Object and inject the PDF Tablet
$table = new Table($pdf);

// Set the styles for the advanced table
$table->setStyle('default', 11, '', [0, 0, 77], 'helvetica');
$table->setStyle('p', null, null);
$table->setStyle('b', null, 'B');
$table->setStyle('i', null, 'I');
$table->setStyle('bi', null, 'BI');
$table->setStyle('u', null, 'U');
$table->setStyle('h', null, 'B', '203,0,48');
$table->setStyle('s', 8, null);
$table->setStyle('title', 14, null, [102, 0, 0], null, 'h');
$table->setStyle('h1', 16, null, null, null, 'h');
$table->setStyle('h2', 14, null, null, null, 'h');
$table->setStyle('h3', 12, null, null, null, 'h');
$table->setStyle('h4', 11, null, null, null, 'h');
$table->setStyle('super', 8, null, [255, 102, 153]);

//Initialize the table, 3 columns with the specified widths
$table->initialize([50, 50, 40]);

$row = [
    'I am cell 1',
    'I am cell 2',
    [
        'TEXT' => 'I am cell 3',
        'TEXT_ALIGN' => 'R'
    ],
];

//add the row to the table
$table->addRow($row);

$row = [
    'I am cell 1',
    'I am cell 2',
    [
        'TEXT' => 'I am cell 3',
        'TEXT_ALIGN' => 'R'
    ],
];

//add the row to the table
$table->addRow($row);

$row = [
    new Image($pdf, CONTENT_PATH . '/images/blog.jpg', 10),
    "<p><b>Images</b> are supported\n<bi></bi></p>",
    new Image($pdf, CONTENT_PATH . '/images/telescope.jpg', 35, 35)
];

//add the row to the table
$table->addRow($row);

$row = [
    new Image($pdf, CONTENT_PATH . '/images/blog.jpg', 10),
    "<p><b>Images</b> are supported\n<bi></bi></p>",
    [
        'TYPE' => 'Image',
        'FILE' => CONTENT_PATH . '/images/telescope.jpg',
        'WIDTH' => 35,
        'HEIGHT' => 35,
    ]
];

//add the data row
$table->addRow($row);

$row = [[
    'TEXT' => 'some text',
    'PADDING_TOP' => 0,
    'PADDING_BOTTOM' => 0,
    'LINE_SIZE' => 42.3
],[
    'PADDING_TOP' => 0,
    'PADDING_BOTTOM' => 0,
    'TEXT' => '<h1>Second Column</h1>',
]];
//add the data row
$table->addRow($row);

$row = [[
    'TEXT' => 'some text',
    'PADDING_TOP' => 0,
    'LINE_SIZE' => 20
]];
//add the data row
$table->addRow($row);


$table->close();

$pdf->output();
