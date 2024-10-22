<?php

/**
 * Pdf Advanced Table - Example
 */

require_once __DIR__ . '/autoload.php';

use EvoSys21\PdfLib\Multicell;
use EvoSys21\PdfLib\Table;
use EvoSys21\PdfLib\Examples\Fpdf\PdfFactory;
use EvoSys21\PdfLib\Examples\Fpdf\PdfSettings;

//get the PDF object
$pdf = PdfFactory::newPdf('table');

//define some background colors
$bgColor1 = [234, 255, 218];
$bgColor2 = [165, 250, 220];
$bgColor3 = [255, 252, 249];
$bgColor4 = [86, 155, 225];
$bgColor5 = [207, 247, 239];
$bgColor6 = [246, 211, 207];
$bgColor7 = [216, 243, 228];

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
$multicell->setStyle('s1', 8, '', '118,0,3', 'helvetica');
$multicell->setStyle('s2', 6, '', '0,49,159', 'helvetica');

$multicell->multiCell(100, 4, "<s1>Example 1 - Very Simple Table</s1>");
$pdf->Ln(1);

require('table_example1.php');

$pdf->Ln(10);

$txt = "<s1>Example 2 - More detailed Table</s1>\n<s2>\t- Table Align = Center\n\t- The header has multiple lines\n\t- Colspanning Example\n\t- Rowspanning Example\n\t- Text Alignments\n\t- Properties overwriting</s2>";

$pdf->SetX(60);
$multicell->multiCell(100, 2.5, $txt);
$pdf->Ln(1);
require('table_example2.php');

$pdf->Ln(10);

$txt = "<s1>Example 3 - Table split end of the page</s1>\n<s2>\t- This is the table from Example 2 at the end of the page\n\t- Splitting mode = ON, you can see that the cells are splitted</s2>";

$pdf->SetXY(60, 215);
$multicell->multiCell(100, 2.5, $txt);
$pdf->Ln(1);
$tableSplitMode = true;
require('table_example2.php');

$pdf->Ln(10);

$txt = "<s1>Example 4 - Table split end of the page</s1>\n<s2>\t- This is the table from Example 2 at the end of the page\n\t- Splitting mode = OFF. In this case the cells are NOT splitted</s2>";

$pdf->SetXY(60, 215);
$multicell->multiCell(100, 2.5, $txt);
$pdf->Ln(1);
$tableSplitMode = false;
require('table_example2.php');

//send the pdf to the browser
$pdf->Output();
