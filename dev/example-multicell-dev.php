<?php

/**
 * Pdf Advanced Multicell - Example
 */

require_once __DIR__ . '/../autoload.php';

use EvoSys21\PdfLib\Fpdf\Pdf;
use EvoSys21\PdfLib\Multicell;

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


// Create the Advanced Multicell Object and inject the PDF object
$multicell = new Multicell($pdf);

// Set the styles for the advanced multicell
$multicell->setStyle('p', 11, '', '130,0,30', 'helvetica');
$multicell->setStyle('b', 11, 'B', '130,0,30', 'helvetica');
$multicell->setStyle('i', 11, 'I', '80,80,260', 'helvetica');
$multicell->setStyle('u', 11, 'U', '80,80,260', 'helvetica');
$multicell->setStyle('h1', 14, 'B', '203,0,48', 'helvetica');
$multicell->setStyle('h3', 12, 'B', '203,0,48', 'helvetica');
$multicell->setStyle('h4', 11, 'BI', '0,151,200', 'helvetica');
$multicell->setStyle('hh', 11, 'B', '255,189,12', 'helvetica');
$multicell->setStyle('super', null, null, 8);

//$s = "This is a simple text";
////// no formatting - the default pdf font, font-size, colors are used
//$multicell->multiCell(0, 5, $s);
//
//$pdf->ln(10);

//// simple formatting
//$s ="<p>This is a paragraph</super></p>";
//$multicell->multiCell(0, 5, $s);
//
//$pdf->ln(10);
//
//// nested tags
//$s = "<p>This is <b>BOLD</b> text, this is <i>ITALIC</i></p>";
//$multicell->multiCell(0, 5, $s);
//
//$pdf->ln(10);
//
//// subscripts and superscripts (the ypos can be adjusted)
//$s = "<p><super y='-0.8'>Subscript</super> or <super y='1.1'>Superscript</super></p>";
//$multicell->multiCell(0, 5, $s);
//
//$s = "<p><i><super ypos='-0.8'>Subscript</super></i> or <super ypos='1.1'>Superscript</super></p>";
//$multicell->multiCell(0, 5, $s);
//
//$pdf->ln(10);

$s = "The price is <b nowrap='1'>USD 5.344,23</b>";
$s1 = "The price is <b>USD 5.344,23</b>";
foreach ([40, 45, 50] as $width) {
    $multicell->multiCell($width, 5, $s, 0, 'L');
    $multicell->multiCell($width, 5, $s1, 0, 'L');
    $pdf->ln(5);
}

//
//$s = "<size size='100' >Paragraph Example:~~~</size><font> - Paragraph 1</font>
//<p width='50' align='left'>This is a text: </p><font> - Paragraph 2</font>
//<p width='50' align='center'>This is a text: </p><font> - Paragraph 2</font>
//<p width='50' align='right'>This is a text: </p><font> - Paragraph 2</font>
//<p width='50'> </p><font> - Paragraph 3</font>
//<p width='50'> </p><font> - Paragraph 4</font>
//<p size='60'> ~~~</p> - Paragraph 2
//<p size='70'>Sample text~~~</p><p> - Paragraph 3</p>
//<p width='50'>Sample text50</p> - Paragraph 1
//<p size='60'> ~~~</p><h4> - Paragraph 2</h4>";
//$multicell->multiCell(0, 5, $s);
//
//$s = "<p size='100'> ~~~</p> - Paragraph 2
//<p width='50'>xxx</p><font> - Paragraph 2</font>";
//$multicell->multiCell(0, 5, $s);


// output the pdf
$pdf->Output();
