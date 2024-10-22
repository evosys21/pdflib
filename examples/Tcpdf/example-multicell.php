<?php

/**
 * Pdf Advanced Multicell - Example
 */

require_once __DIR__ . '/autoload.php';

use EvoSys21\PdfLib\Tcpdf\Pdf;
use EvoSys21\PdfLib\Multicell;

// Pdf extends TCPDF
$pdf = new Pdf();

// use the default TCPDF configuration
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
$multicell->setStyle('default', 11, '', [0, 0, 77], 'dejavusans');
$multicell->setStyle('b', null, 'B');
$multicell->setStyle('i', null, 'I');
$multicell->setStyle('bi', null, 'BI');
$multicell->setStyle('u', null, 'U');
$multicell->setStyle('h', null, 'B', '203,0,48');
$multicell->setStyle('s', 8, null);
$multicell->setStyle('title', 14, null, [102, 0, 0], null, 'h');
$multicell->setStyle('h1', 16, null, null, null, 'h');
$multicell->setStyle('h2', 14, null, null, null, 'h');
$multicell->setStyle('h3', 12, null, null, null, 'h');
$multicell->setStyle('h4', 11, null, null, null, 'h');
$multicell->setStyle('super', 8, null, [255, 102, 153]);

//load the required Utf8 Fonts
$pdf->AddFont('dejavusans', '', 'DejaVuSans.ttf', true);
$pdf->AddFont('dejavusans', 'B', 'DejaVuSans-Bold.ttf', true);

// define the utf8 styles
$multicell->setStyle('u8', null, '', [0, 45, 179], 'freeserif');
$multicell->setStyle('u8b', null, 'B', null, null, 'u8');

$utf8Text = file_get_contents(CONTENT_PATH . '/utf8-sample.txt');

$s = <<<HEREDOC
This line is a simple text with no formatting(text-formatting from the pdf defaults)

<p>This line is a paragraph line</p>

<p>This is <b>BOLD</b> text, this is <i>ITALIC</i>, this is <bi>BOLD ITALIC</bi></p>

<p>The following is <b>rendered as bold text.</b></p>

<p>The following is <i>rendered as italicized text.</i></p>

<p>The following is <bi>rendered as bold and italicized text.</bi></p>

<p>The following is <u>rendered as underline text.</u></p>

<p>The following is <s y='-1'>Subscript</s> and <s y='1'>Superscript</s></p>

<p>The following is <n strike=''>Text Strikethrough</n> and <bi strike='.5'>Text Strikethrough bolder line</bi></p>

<u8b>Utf8 text: </u8b><u8>$utf8Text</u8>

This line is a simple text with no formatting(text-formatting from the pdf defaults)
HEREDOC;

$multicell->multiCell(0, 5, $utf8Text);

$pdf->ln(10);

$s = <<<HEREDOC
<title>Typography:</title>

<h1>Heading 1</h1>
<h2>Heading 2</h2>
<h3>Heading 3</h3>
<h4>Heading 4</h4>
HEREDOC;

$multicell->multiCell(0, 7, $s);

$pdf->ln(10);

$multicell->multiCell(0, 10, "<title>Table of Content:</title>");

$s = <<<HEREDOC
<p width='10'> </p><p> - Paragraph 1</p>
<p width='10'> </p><p> - Paragraph 2</p>
<p width='20'> </p><p> - Paragraph 2.1</p>
<p width='20'> </p><p> - Paragraph 2.2</p>
<p width='10'> </p><p> - Paragraph 3</p>
HEREDOC;
$multicell->multiCell(0, 5, $s);

$pdf->ln(10);
$multicell->multiCell(0, 10, "<title>Tag width and alignment:</title>");

$s = <<<HEREDOC
<p width="100" align="left"> Align Left </p>
<p width="100" align="center"> Align Center </p>
<p width="100" align="right"> Align Right </p>
HEREDOC;
$multicell->multiCell(100, 5, $s, 1, '', 1);

$pdf->AddPage();
$multicell->multiCell(0, 10, "<title>No wrap:</title> text will not break on normal separators");

$s = "The price is <b nowrap='1'>USD 5.344,23</b>";
foreach ([40, 45, 50] as $width) {
    $multicell->multiCell($width, 5, $s, 1, 'L');
    $pdf->ln(5);
}

// output the pdf
$pdf->Output();
