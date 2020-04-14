# FPDF Advanced Multicell User Manual

{{>toc}}

## Installation

The PHP Pdf Addons will work right out of the box. All you need is a webserver with Php 5.5 (or greater). 
No further configurations are required.

Just download the files, extract the content in a directory where your webserver is configured and call the url. 

Every add-on has multiple example files that cover the full functionality.

### Include the library into the project

Normally, from the downloaded package you need only the files from `library\interpid\PdfLib` folder in order to run it. 

#### Using "require_once"

In order to include the full interpid library, just include the `autoload.php` provided in the root folder. This will provide you the FPDF and all Interpid PdfLib library classes.

Assuming you downloaded `fpdf-multicell-3.0.0` and placed in your project `libs` folder:
```
<?php
require_once 'libs/fpdf-multicell-3.0.0/autoload.php';
```

#### With composer.json

If your project uses composer, then include the pdf library path to your composer file:

In `composer.json`
```
    "autoload": {
        "classmap": [
            "libs/fpdf-multicell-3.0.0/library/interpid"
        ],
    },
```

or you can use the PSR-4 autoload capabilities

In `composer.json`
```
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
use Interpid\PdfLib\Multicell;
use Interpid\PdfLib\Pdf; // Pdf extends FPDF

// create the Pdf Object
$pdf = new Pdf();

// do some pdf initialization settings
// $pdf->SetMargins(20, 20, 20);
...

// create the Multicell Object
$multicell = new Multicell($pdf);

// set the style definitions
$multicell->setStyle('p', 11, '', '130,0,30', 'helvetica');
$multicell->setStyle('b', 11, 'B', '130,0,30', 'helvetica');

// create the advanced multicells
$multicell->multiCell(0, 5, 'This is a simple cell');
$multicell->multiCell(0, 5, '<p>This is a <b>BOLD</b> text</p>');

```

## Why use the \Interpid\PdfLib\Pdf object instead of FPDF

To implement the FPDF Add-on, we need access to private/protected properties from the FPDF class like widths, margins, fonts etc... As these properties are not provided by setters and getters the FPDF class was extended and these properties made public. 


```php
namespace Interpid\PdfLib;

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

```

## Create the Advanced Multicell object
```php
// Create the Advanced Multicell Object and inject the PDF object
use Interpid\PdfLib\Multicell;
$multicell = new Multicell($pdf);
```

## Styling

A style can be used to specify the text properties. The following properties can be set:

 * font-size: `8`, `9`, `10` ... 
 * font-style: one or a combination of the following values: 
   * `B` (Bold), `U` (Underline), `I` (Italic)
   * examples: ` "B" `, `"BI"`
 * color: specify a string or array: `'130,0,30'` or `[130,0,30]`
 * font-family: example `'Arial'`, `'helvetica'` or any other font family
 * inherit: the **style name** that will be inherited.

Examples:

```php
// Set the styles for the advanced multicell
$multicell->setStyle('p', 11, '', '130,0,30', 'helvetica');
$multicell->setStyle('b', 11, 'B', '130,0,30', 'helvetica');
$multicell->setStyle('i', 11, 'I', '80,80,260', 'helvetica');
```

### Style Inheritance

Styles are inherited. All styles inherit a "base" style (If it's defined). In order to inherit a "property" set it to `null`

```php
// define the "base" style
$multicell->setStyle('base', 11, '', [0, 0, 77], 'helvetica');

// all styles inherit this style
$multicell->setStyle('p', null, null);
$multicell->setStyle('b', null, 'B');
$multicell->setStyle('i', null, 'I');

// you can specify which style should be inherited
// example: define a base "h" style and h1, h2, h3, h4 will inherit h
$multicell->setStyle('h', null, 'B', '203,0,48');
$multicell->setStyle('h1', 16, null, null, null, 'h');
$multicell->setStyle('h2', 14, null, null, null, 'h');
$multicell->setStyle('h3', 12, null, null, null, 'h');
$multicell->setStyle('h4', 11, null, null, null, 'h');
```

## Text Formatting

### No formatting
The default PDF formatting is used in this case(font, font-size and color)

```php
// no formatting - the defaul

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
// subscripts and superscripts (the y can be adjusted)
$s = "<p y='-0.8'>Subscript</p> or <p y='1.1'>Superscript</p>";
$multicell->multiCell(0, 5, $s)
```

###Links
You can create links by using the href attribute in a tag.

```php
$s = "<p>Created by <h1 href='mailto:office@interpid.eu'>Interpid Office</h1>
<h1 href='www.interpid.eu'>www.interpid.eu</h1></p>";
$multicell->multiCell(0, 5, $s);
```

### Paragraphs
Paragraphs can be created by using the size attribute and the ~~~ reserved pattern for paragraphs. See the following example:

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

By default, the width of a tag is calculated. Use `width` to set a fixed width for your tag. No checks are being done for text-overflow!

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

`size` is used in case of paragraphs. This value will become deprecated in future versions and `width` is to be preferred instead.

