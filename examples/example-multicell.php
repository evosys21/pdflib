<?php
/**
 * Pdf Advanced Multicell - Example
 * Copyright (c), Interpid, http://www.interpid.eu
 */

require_once __DIR__ . "/../autoload.php";

use Interpid\PdfLib\Multicell;
use Interpid\PdfExamples\pdfFactory;
use Interpid\PdfLib\Pdf;

// Pdf extends FPDF
$pdf = new Pdf();

// Initialize the pdf object. Set the margins, adds a page, set default fonts etc...
pdfFactory::initPdf( $pdf );

// Create the Advanced Multicell Object and pass the PDF object as a parameter to the constructor
$multicell = new Multicell( $pdf );

// Set the styles for the advanced multicell
$multicell->setStyle( "p", 'helvetica', "", 11, "130,0,30" );
$multicell->setStyle( "b", 'helvetica', "B", 11, "130,0,30" );
$multicell->setStyle( "i", 'helvetica', "I", 11, "80,80,260" );
$multicell->setStyle( "u", 'helvetica', "U", 11, "80,80,260" );
$multicell->setStyle( "h1", 'helvetica', "B", 14, "203,0,48" );
$multicell->setStyle( "h3", 'helvetica', "B", 12, "203,0,48" );
$multicell->setStyle( "h4", 'helvetica', "BI", 11, "0,151,200" );
$multicell->setStyle( "hh", 'helvetica', "B", 11, "255,189,12" );
$multicell->setStyle( "ss", 'helvetica', "", 7, "203,0,48" );
$multicell->setStyle( "font", 'helvetica', "", 10, "0,0,255" );
$multicell->setStyle( "style", 'helvetica', "BI", 10, "0,0,220" );
$multicell->setStyle( "size", 'helvetica', "BI", 12, "0,0,120" );
$multicell->setStyle( "color", 'helvetica', "BI", 12, "0,255,255" );

$pdf->Ln( 10 ); //line break

// create the advanced multicell
$multicell->multiCell( 0, 5, "<h1>Fpdf Advanced Multicell</h1>", 1, "J", 1, 3, 3, 3, 3 );

$pdf->Ln( 10 ); //line break

$txt = <<<EOF
<h3>Description:</h3>
<p>
	This <b>FPDF addon</b> allows creation of an <b>Advanced Multicell</b> which uses as input a <b>TAG based formatted string</b> instead of a simple string. The use of tags allows to change the font, the style (<b>bold</b>, <i>italic</i>, <u>underline</u>), the size, and the color of characters and many other features.
	The call of the function is pretty similar to the Multicell function in the FPDF base class with some extended parameters.

<h3>Features:</h3>

	- Text can be <hh>aligned</hh>, <hh>centered</hh> or <hh>justified</hh>
	- Different <font>Font</font>, <size>Sizes</size>, <style>Styles</style>, <color>Colors</color> can be used 
	- The cell block can be framed and the background painted
	- <style href='www.fpdf.org'>Links</style> can be used in any tag
	- <h4>TAB</h4> spaces (<b>\	</b>) can be used
	- Variable Y relative positions can be used for <ss ypos='-0.8'>Subscript</ss> or <ss ypos='1.1'>Superscript</ss>
	- Cell padding (left, right, top, bottom)
	- Controlled Tag Sizes can be used</p>

	<size size='50' >Paragraph Example:~~~</size><font> - Paragraph 1</font>
	<p size='60' > ~~~</p><font> - Paragraph 2</font>
	<p size='60' > ~~~</p> - Paragraph 2
	<p size='70' >Sample text~~~</p><p> - Paragraph 3</p>
	<p size='50' >Sample text~~~</p> - Paragraph 1
	<p size='60' > ~~~</p><h4> - Paragraph 2</h4>

<h3>Observations:</h3><p>

	- If no <h4><TAG></h4> is specified then the FPDF current settings(font, style, size, color) are used
	- The <h4>ttags</h4> tag name is reserved for the TAB SPACES
</p>
EOF;

$multicell->multiCell( 0, 5, $txt, 1, "J", 1, 3, 3, 3, 3 );

// output the pdf
$pdf->Output();
