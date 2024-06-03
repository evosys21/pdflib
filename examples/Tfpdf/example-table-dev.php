<?php
/**
 * Pdf Advanced Table - Example
 */

require_once __DIR__ . '/../autoload.php';

use Interpid\PdfLib\Table;
use Interpid\PdfLib\Pdf;

// Pdf extends FPDF
$pdf = new Pdf();

// use the default FPDF configuration
$pdf->SetAuthor('Interpid');
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
$table->setStyle('base', 11, '', [0, 0, 77], 'helvetica');
$table->setStyle('p');
$table->setStyle('b', null, 'B');
$table->setStyle('i', null, 'I');
$table->setStyle('bi', null, 'BI');
$table->setStyle('u', null, 'U');
$table->setStyle('h', null, 'B', '203,0,48');
$table->setStyle('s', 8);
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
    new Table\Cell\Image($pdf, PDF_RESOURCES_IMAGES . '/blog.jpg', 10),
    "<p><b>Images</b> are supported\n<bi></bi></p>",
    new Table\Cell\Image($pdf, PDF_RESOURCES_IMAGES . '/telescope.jpg', 35, 35)
];

//add the row to the table
$table->addRow($row);

$row = [
    new Table\Cell\Image($pdf, PDF_RESOURCES_IMAGES . '/blog.jpg', 10),
    "<p><b>Images</b> are supported\n<bi></bi></p>",
    [
        'TYPE' => 'Image',
        'FILE' => PDF_RESOURCES_IMAGES . '/telescope.jpg',
        'WIDTH' => 35,
        'HEIGHT' => 35,
    ]
];

//add the data row
$table->addRow($row);

$table->close();

$pdf->output();
