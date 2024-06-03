<?php
/**
 * Pdf Advanced Multicell - Example
 */

require_once 'autoload.php';

use Interpid\PdfLib\Multicell;
use Interpid\PdfLib\Pdf;

// Pdf extends TCPDF
$pdf = new Pdf();

// use the default TCPDF configuration
$pdf->SetAuthor('Interpid');
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
$multicell->setStyle('default', 11, '', [0, 0, 77], 'helvetica');
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
$multicell->setStyle('u8', null, '', [0, 45, 179], 'dejavusans');
$multicell->setStyle('u8b', null, 'B', null, null, 'u8');

$utf8Text = file_get_contents(PDF_APPLICATION_PATH . '/content/utf8-sample.txt');

$s = <<<HEREDOC
<f>•	<p ww="1">Perfect cleaning performance and short batch times in the smallest space - only 90 cm wide: Fast high-performance drying, shortest filling and emptying times, most powerful pump leads to capacity up to 18 DIN trays in less than 40 minutes.</p>
</f>
HEREDOC;

$html = '
<style>
    h1 {
        font-size: 24px;
        color: #0000ff;
    }
    .red {
        font-size: 24px;
        color:#FF8000;
    }
    
    th,td{
        border: 1px solid black;
        margin: 5px;    
    }
    th:first-child {
        width:30%;
    }
</style>
<h1>Test TCPDF Methods in HTML</h1>
<h2 style="color:red;">IMPORTANT:</h2>
<span style="color:red;">If you are using user-generated content, the tcpdf tag can be unsafe.<br />
You can disable this tag by setting to false the <b>K_TCPDF_CALLS_IN_HTML</b> constant on TCPDF configuration file.</span>
<h2>write1DBarcode method in HTML</h2>
<div class="red">write1DBarcode method in HTML</div>
<ul>
  <li>Coffee<br>foo bar</li>
  <li>Tea</li>
  <li>Milk</li>
</ul>
<table>
  <tr>
    <th style="width: 30%">Company</th>
    <th>Contact</th>
    <th>Country</th>
  </tr>
  <tr>
    <td>Alfreds Futterkiste</td>
    <td>Maria Anders</td>
    <td>Germany</td>
  </tr>
  <tr>
    <td>Centro comercial Moctezuma</td>
    <td>Francisco Chang</td>
    <td>Mexico</td>
  </tr>
</table>

';

$pdf->setXY(50, 50);
$pdf->SetMargins(100, 20, 20);
$pdf->writeHTML($html, true, 0, true, 0);

$multicell->multiCell(0, 5, $s);

// output the pdf
$pdf->Output();
