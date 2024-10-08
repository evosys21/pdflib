 FPDF / TCPDF / tFPDF Advanced Multicell User Manual
 ======================================================

<!-- TOC -->
* [FPDF / TCPDF / tFPDF Advanced Multicell User Manual](#fpdf--tcpdf--tfpdf-advanced-multicell-user-manual)
  * [Installation](#installation)
    * [Include the library into the project](#include-the-library-into-the-project)
      * [Using "require_once"](#using-require_once)
      * [With composer.json](#with-composerjson)
  * [Download](#download)
  * [Usage](#usage)
  * [Why use the \evosys21\PdfLib\Fpdf\Pdf object instead of FPDF](#why-use-the-evosys21pdflibfpdfpdf-object-instead-of-fpdf)
  * [Create the Pdf object](#create-the-pdf-object)
  * [Create the Advanced Multicell object](#create-the-advanced-multicell-object)
  * [Tag styling](#tag-styling)
    * [Style Inheritance](#style-inheritance)
  * [Text Formatting](#text-formatting)
    * [No formatting](#no-formatting)
    * [Simple formatting](#simple-formatting)
    * [Nested tags](#nested-tags)
    * [Subscripts and superscripts](#subscripts-and-superscripts)
    * [Strikethrough](#strikethrough)
    * [Links](#links)
    * [Paragraphs](#paragraphs)
  * [Tag Attributes](#tag-attributes)
    * [href](#href)
    * [width](#width)
    * [align](#align)
      * [Example with `width` and `align`](#example-with-width-and-align)
    * [size](#size)
    * [nowrap](#nowrap)
  * [FEATURES](#features)
    * [Height Limitations](#height-limitations)
      * [Max Lines](#max-lines)
      * [Max Height](#max-height)
    * [Text shrinking](#text-shrinking)
      * [Change shrinking units](#change-shrinking-units)
    * [Apply features to all cells and reset](#apply-features-to-all-cells-and-reset)
<!-- TOC -->

## Installation

The PHP Pdf Addons will work right out of the box. All you need is a webserver with Php 5.5 (or greater). No further
configurations are required.

Just download the files, extract the content in a directory where your webserver is configured and call the url.

Every add-on has multiple example files that cover the full functionality.

### Include the library into the project

Normally, from the downloaded package you need only the files from `library\evosys21\PdfLib` folder in order to run it.

#### Using "require_once"

In order to include the full interpid library, just include the `autoload.php` provided in the root folder. This will
provide you the FPDF and all Interpid PdfLib library classes.

Assuming you downloaded `fpdf-multicell-3.0.0` and placed in your project `libs` folder:

```php
<?php
require_once 'libs/fpdf-multicell-3.0.0/autoload.php';
```

#### With composer.json

If your project uses composer, then include the pdf library path to your composer file:

In `composer.json`

```json
    "autoload": {
"classmap": [
"libs/fpdf-multicell-3.0.0/library/interpid"
],
},
```

or you can use the PSR-4 autoload capabilities

In `composer.json`

```json
    "autoload": {
"psr-4": {
"Interpid\\PdfLib\\": "libs/fpdf-multicell-3.0.0/library/interpid/PdfLib/"
}
},
```

then run `composer dump-autoload` to regenerate the autoload classmap.

## Download

Please go to your account on https://www.interpid.eu/my-account to download the latest versions of the addons.

## Usage

To generate an "Advanced Multicell" the followings are required:

* have a valid FPDF/PDF object
* create the advanced multicell object instance
* add the multicells to the pdf document

```php
use evosys21\PdfLib\Multicell;
use evosys21\PdfLib\Fpdf\Pdf; // Pdf extends FPDF

// create the Pdf Object
$pdf = new Pdf();

// do some pdf initialization settings
// $pdf->SetMargins(20, 20, 20);
...

// create the Multicell Object
$multicell = new Multicell($pdf);

// set the style definitions
// `default` is applied to all tags
$multicell->setStyle('default', 11, '', '130,0,30', 'helvetica');
$multicell->setStyle('p', 11, '', '130,0,30', 'helvetica');
$multicell->setStyle('b', null, 'B', null, null);

// create the advanced multicells
$multicell->multiCell(0, 5, 'This is a simple cell');
$multicell->multiCell(0, 5, '<p>This is a <b>BOLD</b> text</p>');
```

## Why use the \evosys21\PdfLib\Fpdf\Pdf object instead of FPDF

To implement the FPDF Add-on, we need access to private/protected properties from the FPDF class like widths, margins,
fonts etc... As these properties are not provided by setters and getters the FPDF class was extended and these
properties made public.

```php
namespace evosys21\PdfLib;

class Pdf extends \FPDF
{
    public $images;
    public $w;
    public $tMargin;
    ...
}
```

## Create the Pdf object

Please refer to the FPDF class manual in order to get this done correctly. Example:

```php
use evosys21\PdfLib\Fpdf\Pdf;

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

```

## Create the Advanced Multicell object

```php
// Create the Advanced Multicell Object and inject the PDF object
use evosys21\PdfLib\Multicell;
$multicell = new Multicell($pdf);
```

## Tag styling

A tag style is used specify the text display properties. The following properties can be set:

* size/font_size: `8`, `9`, `10` ...
* style/font_style: one or a combination of the following values:
    * `B` (Bold), `U` (Underline), `I` (Italic)
    * examples: ` "B" `, `"BI"`
* color/text_color: specify a string or array: `'130,0,30'` or `[130,0,30]`
* family/font_family: example `'Arial'`, `'helvetica'` or any other font family
* inherit: the **style name** that will be inherited.

Examples:

```php
// define a tag style using associative array
$multicell->setStyleAssoc('p', ['size' => 11, 'style' => '', 'color' => '130,0,30', 'family' => 'helvetica']);

// define only a few properties
$multicell->setStyleAssoc('b', ['style' => 'B']);
$multicell->setStyleAssoc('fancy-bi', ['style' => 'BI', 'color' => '130,0,30']);

// Set the styles for the advanced multicell using `setStyle`
$multicell->setStyle('p', 11, '', '130,0,30', 'helvetica');
$multicell->setStyle('b', 11, 'B', '130,0,30', 'helvetica');
$multicell->setStyle('i', 11, 'I', '80,80,260', 'helvetica');
```

### Style Inheritance

Styles can be inherited if specified so.

```php
<?php
// you can specify which style should be inherited
// example: define a base "h" style and h1, h2, h3, h4 will inherit h
$multicell->setStyle('h', null, 'B', '203,0,48');
$multicell->setStyle('h1', 16, null, null, null, 'h');
$multicell->setStyle('h2', 14, null, null, null, 'h');
$multicell->setStyle('h3', 12, null, null, null, 'h');
$multicell->setStyle('h4', 11, 'B', null, null, 'h');

// a more simple approach: use the `style` function
$multicell->setStyleAssoc('h1', ['size' => 16], 'h');
$multicell->setStyleAssoc('h2', ['size' => 14], 'h');
$multicell->setStyleAssoc('h3', ['size' => 12], 'h');
$multicell->setStyleAssoc('h4', ['size' => 11, 'style' => 'B'], 'h');
```

## Text Formatting

### No formatting

The default PDF formatting is used in this case(font, font-size and color)

```php
// no formatting - the default

//t pdf font, font-size, colors are used
$s = "This is a simple text";
$multicell->multiCell(0, 5, $s);
```

### Simple formatting

```php
// simple formatting
$s = "<p>This is a paragraph</p>";
$multicell->multiCell(0, 5, $s);
```

### Nested tags

In case of nested tags, the styles are NOT inherited

```php
// nested tags
$s = "<p>This is <b>BOLD</b> text, this is <i>ITALIC</i></p>";
$multicell->multiCell(0, 5, $s);
``` 

### Subscripts and superscripts

Subscript and superscripts can be adjusted with the y attribute. See example:

```php
$s = "<p>The following is <s y='-1'>Subscript</s> and <s y='1'>Superscript</s></p>";
```

![Sub-Superscript](https://tracker.interpid.eu/attachments/download/2560/text-sub-superscript.png)

<br/><br/>

### Strikethrough

Text strikethrough can be defined using the `strike` attribute in any tag:

- `<p strike=''>...` - default strikethrough line width - `<p strike='0.6'>...` - strikethrough line width: 0.6

```php
$s = "<p>The following is <n strike=''>Text Strikethrough</n> and <bi strike='.5'>Text Strikethrough bolder line</bi></p>";
$multicell->multiCell(0, 5, $s);
```

<img src="https://tracker.interpid.eu/attachments/download/2561/text-strikethrough.png" width="500" alt=""/>

<br/><br/>

### Links

You can create links by using the href attribute in a tag.

```php
$s = "<p>Created by <h1 href='mailto:office@interpid.eu'>Interpid Office</h1>
<h1 href='www.interpid.eu'>www.interpid.eu</h1></p>";
$multicell->multiCell(0, 5, $s);
```

### Paragraphs

Paragraphs can be created by using the size attribute and the ~~~ reserved pattern for paragraphs. See the following
example:

```php
$s = "<size size='50' >Paragraph Example:~~~</size><font> - Paragraph 1</font>
<p size='60' > ~~~</p><font> - Paragraph 2</font>
<p size='60' > ~~~</p> - Paragraph 2
<p size='70' >Sample text~~~</p><p> - Paragraph 3</p>
<p size='50' >Sample text~~~</p> - Paragraph 1
<p size='60' > ~~~</p><h4> - Paragraph 2</h4>";
$multicell->multiCell(0, 5, $s);
```

## Tag Attributes

### href

The `href` attribute will provide you a link in the pdf document.

```html
<h1 href="www.interpid.eu">Visit our website</h1>
```

### width

By default, the width of a tag is calculated. Use `width` to set a fixed width for your tag. No checks are being done
for text-overflow!

### align

`align` is to be used only in combination width `width`, to specify where the text should be aligned.

Valid values are: `left|center|right|L|C|R`

#### Example with `width` and `align`

```html
<p width="100" align="left"> Align Left </p>
<p width="100" align="center"> Align Center </p>
<p width="100" align="right"> Align Right </p>
```

### size

`size` is used in case of paragraphs. This value will become deprecated in future versions and `width` is to be
preferred instead.

### nowrap

`nowrap` is used if you the text in a paragraph to break or be separated on a new line

For example, you want the price to always be written on the same line:

```php
$s = "The price is <b nowrap='1'>USD 5.344,23</b>";
$multicell->multiCell(50, 5, $s);
```

## FEATURES

### Height Limitations

#### Max Lines

Limit the number of lines that will be in the multicell

```php
//set a limit to the maximum number of lines 
$multicell->maxLines(10);
$multicell->multiCell(0, 5, "...Some text...");
```

#### Max Height

Limit the height that a multicell can have

```php
//set a limit to the maximum number of lines 
$multicell->maxHeight(50);
$multicell->multiCell(0, 5, "...Some text...");
```

If height limits are hit, the following text is cut-off from the multicell.

### Text shrinking

Text and line height will shrink in order to fit into a specific `maxHeight` or `maxLines`
If the text doesn't fit the `font-size` will be decreased with `1` and the `line-height` with `0.5` units until the text
fits.

**Notice**

There is a possibility that the shrinking fails if the input and shrinking settings are invalid.

For example: you set maxLines to `5` and your input text has 10 EOLs in it `$multicell->maxLines(5)`

**Limit the number of lines that will be in the multicell**

```php
$multicell->maxLines(10)->shrinkToFit();
$multicell->multiCell(0, 5, "...Some text...");
```

**Limit the height that a multicell can have**

```php
$multicell->maxHeight(50)->shrinkToFit();
$multicell->multiCell(0, 5, "...Some text...");
```

```php
// shrink, max-height and all cells 
$multicell->maxHeight(50)->shrinkToFit()->applyAll();
$multicell->multiCell(0, 5, "...Some text...");

...
$multicell->reset();
```

#### Change shrinking units

```php
$multicell->shrinkToFit()->shrinkFontStep(2)->shrinkLineHeightStep(0.2)->maxHeight(50);
$multicell->multiCell(0, 5, "...Some text...");

...
$multicell->reset();
```

### Apply features to all cells and reset

Features like: `maxHeight`,  `maxLines`, `shrinkToFit`, `shrinkLineHeightStep`, `shrinkFontStep` are applied to the next
cell only.

In order to apply these features to all following cells, use `$multicell->applyAll();`<br>
In order to reset these features use `$multicell->reset();`
