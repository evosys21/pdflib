# Fpdf, TCPDF, tFpdf - Advanced Table

<!-- TOC -->
* [Fpdf, TCPDF, tFpdf - Advanced Table](#fpdf-tcpdf-tfpdf---advanced-table)
  * [Installation](#installation)
    * [Include the library into the project](#include-the-library-into-the-project)
      * [Using "require_once"](#using-require_once)
      * [With composer.json](#with-composerjson)
  * [Why use the `EvoSys21\PdfLib\Fpdf\Pdf` object instead of FPDF?](#why-use-the-evosys21pdflibfpdfpdf-object-instead-of-fpdf)
  * [Create the Pdf object](#create-the-pdf-object)
  * [Create the Advanced Table object](#create-the-advanced-table-object)
  * [Styling](#styling)
  * [Initialize the table](#initialize-the-table)
  * [Table configuration](#table-configuration)
    * [Default configuration File](#default-configuration-file)
    * [Overwriting the default configuration values](#overwriting-the-default-configuration-values)
  * [Table Header(s)](#table-headers)
    * [No Header](#no-header)
    * [Single Header row](#single-header-row)
    * [Multiple Header rows](#multiple-header-rows)
    * [Header configuration values](#header-configuration-values)
  * [Table Row(s)](#table-rows)
    * [Adding table rows](#adding-table-rows)
    * [A simple row](#a-simple-row)
    * [A more complex row](#a-more-complex-row)
    * [Row cells are by default Advanced Multicells](#row-cells-are-by-default-advanced-multicells)
    * [Row height](#row-height)
  * [Table Cells](#table-cells)
    * [Text](#text)
    * [Images](#images)
      * [Images as array](#images-as-array)
    * [Objects](#objects)
  * [Finalize the table](#finalize-the-table)
<!-- TOC -->


## Installation

`evosys21/pdflib` can be used with FPDF, TCPDF or tFPDF. Because of this we haven't
added a fixed dependency in the main composer.json file.
You need to add the dependency to the PDF generation library of your choice yourself.

To use `evosys21/pdflib` with FPDF, install it via Composer:

```bash
composer require evosys21/pdflib
composer require setasign/fpdf
```

If you want to use TCPDF:

```bash
composer require evosys21/pdflib
composer require tecnickcom/tcpdf
```

If you want to use tFPDF:

```shell
composer require evosys21/pdflib
composer require setasign/tfpdf
```

## Create the Pdf object

Use the provided `Pdf` classes to create the PDF object.

For example, if you want to use `FPDF`, use the `EvoSys21\PdfLib\Fpdf\Pdf` class.

Why? [Read here](../README.md#why-use-the-custom-pdf-class-instead-of-fpdftcpdftfpdf)

```php
# use one of the following classes
use EvoSys21\PdfLib\Fpdf\Pdf; // Pdf extends FPDF

// use EvoSys21\PdfLib\TCPDF\Pdf; // Pdf extends TCPDF
// use EvoSys21\PdfLib\tFpdf\Pdf; // Pdf extends tFPDF

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

## Create the Advanced Table object

```php
// Create the Advanced Multicell Object and inject the PDF object
use EvoSys21\PdfLib\Table;
$table = new Table($pdf);
```

## Styling

All the table cells(header and rows) are fully functional FPDF / TCPDF / tFPDF Advanced Multicells. This adds a lot of flexibility when
creating your table. Please have a look at the multicell documentation for details about styling and text formatting.

Examples:

```php
// Set the styles for the advanced table
$table->setStyle('p', 11, '', '130,0,30', 'helvetica');
$table->setStyle('b', 11, 'B', '130,0,30', 'helvetica');
$table->setStyle('i', 11, 'I', '80,80,260', 'helvetica');
```

## Initialize the table

Just specify an `array` with the column widths. The size of the `array` will be used as the number of columns.

```php
//Initialize the table, 5 columns with the specified widths
$table->initialize([20, 30, 40, 40, 20]);

//Initialize the table, 3 columns with the specified widths
$table->initialize([50, 50, 40]);
```

Optionally you can pass a configuration array to the table `initialize` function.

```php
$config = [
    'TABLE' => [
        'TABLE_ALIGN' => 'L', //left align
        'BORDER_COLOR' => [0, 0, 0], //border color
        'BORDER_SIZE' => '0.5', //border size
    ],

    'HEADER' => [
        'TEXT_COLOR' => [25, 60, 170], //text color
        'TEXT_SIZE' => 9, //font size
        'LINE_SIZE' => 6, //line size for one row
        'BACKGROUND_COLOR' => [182, 240, 0], //background color
        'BORDER_SIZE' => 0.5, //border size
        'BORDER_TYPE' => 'B', //border type, can be: 0, 1 or a combination of: 'LRTB'
        'BORDER_COLOR' => [0, 0, 0], //border color
    ],

    'ROW' => [
        'TEXT_COLOR' => [225, 20, 0], //text color
        'TEXT_SIZE' => 6, //font size
        'BACKGROUND_COLOR' => [232, 255, 209], //background color
        'BORDER_COLOR' => [150, 255, 56], //border color
    ],
);

//Initialize the table, 3 columns
$table->initialize([40, 50, 30], $config);
```

## Table configuration

### Default configuration File

The table requires a "default" configuration file in order to run. The configuration file contains information regarding
basic table styling.

The default table configuration file can be found in: `table.config.php` file, but can be specified in the table
constructor:

```php
$table = new Table($pdf, 'path/to/my-table.config.php');
```

If `PDF_TABLE_CONFIG_PATH` value is defined, then the `table.config.php` is being looked up in that folder too.

The values specified in this file are used by default. The configuration file content looks like the following, and it
contains all the values that you can specify for a header/row.

```php
/**
 * Default configuration values for the PDF Advanced table
 */
return [

    'TABLE' => [
        'TABLE_ALIGN' => 'L', //table align on page
        'TABLE_LEFT_MARGIN' => 10, //space to the left margin
        'BORDER_COLOR' => [0, 92, 177], //border color
        'BORDER_SIZE' => '0.3', //border size
        'BORDER_TYPE' => '1', //border type, can be: 0, 1
    ],

    'HEADER' => [
        'TEXT_COLOR' => [220, 230, 240], //text color
        'TEXT_SIZE' => 8, //font size
        'TEXT_FONT' => 'helvetica', //font family
        'TEXT_ALIGN' => 'C', //horizontal alignment, possible values: LRCJ (left, right, center, justified)
        'VERTICAL_ALIGN' => 'M', //vertical alignment, possible values: TMB(top, middle, bottom)
        'TEXT_TYPE' => 'B', //font type
        'LINE_SIZE' => 4, //line size for one row
        'HEIGHT' => '', //enforced row height for row cell
        'BACKGROUND_COLOR' => [41, 80, 132], //background color
        'BORDER_COLOR' => [0, 92, 177], //border color
        'BORDER_SIZE' => 0.2, //border size
        'BORDER_TYPE' => '1', //border type, can be: 0, 1 or a combination of: 'LRTB'
        'TEXT' => ' ', //default text
        //padding
        'PADDING_TOP' => 0, //padding top
        'PADDING_RIGHT' => 1, //padding right
        'PADDING_LEFT' => 1, //padding left
        'PADDING_BOTTOM' => 0, //padding bottom
    ],

    'ROW' => [
        'TEXT_COLOR' => [0, 0, 0], //text color
        'TEXT_SIZE' => 6, //font size
        'TEXT_FONT' => 'helvetica', //font family
        'TEXT_ALIGN' => 'C', //horizontal alignment, possible values: LRCJ (left, right, center, justified)
        'VERTICAL_ALIGN' => 'M', //vertical alignment, possible values: TMB(top, middle, bottom)
        'TEXT_TYPE' => '', //font type
        'LINE_SIZE' => 4, //line size for one row
        'HEIGHT' => '', //enforced row height for row cell
        'BACKGROUND_COLOR' => [255, 255, 255], //background color
        'BORDER_COLOR' => [0, 92, 177], //border color
        'BORDER_SIZE' => 0.1, //border size
        'BORDER_TYPE' => '1', //border type, can be: 0, 1 or a combination of: 'LRTB'
        'TEXT' => ' ', //default text
        //padding
        'PADDING_TOP' => 1,
        'PADDING_RIGHT' => 1,
        'PADDING_LEFT' => 1,
        'PADDING_BOTTOM' => 1,
    ],
];

```

### Overwriting the default configuration values

The second parameter of the table initialization can be an array similar to the one from the Table Configuration File.
This array does not need to contain the complete configuration structure, only the values that are overwritten.

```php
//changing header text color and row text color and size
$config = [
    'HEADER' => [
        'TEXT_COLOR'        => [25, 60, 170],  //text color
    ],
    'ROW' => [
        'TEXT_COLOR'        => [225, 20, 0],   //text color
        'TEXT_SIZE'         => 6,                   //font size
    ],
);

$table->initialize([40, 50, 30], $config);
```

## Table Header(s)

You can add **none**, **one** or **multiple** header rows to a table. The header rows are added to the table on every
new page by default.

### No Header

Do not any header row. The table will have no header.

### Single Header row

```php
$header = [
    ['TEXT' => 'Header 1'],
    ['TEXT' => 'Header 2'],
    ['TEXT' => 'Header 3'],
    ['TEXT' => 'Header 4'],
    ['TEXT' => 'Header 5']
];

//add the header line
$table->addHeader($header);
```

### Multiple Header rows

```php
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
    ], [
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
```

### Header configuration values

All the possible configuration values for the header can be found in the Table Configuration File. See the HEADER
section.

The configuration values can be overwritten in the configuration array:

```php
$header = [
    [
        'TEXT' => 'Header 1', //header text
        'PADDING_TOP' => 5, //add some padding,
        'TEXT_TYPE' => 'B', //bold text
    ],
    ['TEXT' => 'Header 2'],
    ['TEXT' => 'Header 3'],
];
```

## Table Row(s)

Table rows are added with ```php $table->addRow()``` function. The input is an array. The array elements correspond to
the [Table Cells](#table-cells).

A table cell can be a `text`, `array` or `object` that represents the table cell.

### Adding table rows

```php
//add table rows
for ($i=1; $i<5; $i++)
{
    $row = [];
    $row[0]['TEXT'] = "Line $i Text 1";    //text for column 0
    $row[1]['TEXT'] = "Line $i Text 2";    //text for column 1
    $row[2]['TEXT'] = "Line $i Text 3";    //text for column 2

    //override some settings for row 2
    if (2 == $i){
        $row[1]['TEXT_ALIGN'] = 'L';
        $row[1]['TEXT'] = "<p>This is a <b>Multicell</b></p>";
    }
    //add the row
    $table->addRow($row);
}
```

### A simple row

```php

$row = [
    'I am cell 1',
    'I am cell 2',
    'I am cell 3',
];

//the upper is identical to the following

$row = [
    ['TEXT' => 'I am cell 1'],
    ['TEXT' => 'I am cell 2'],
    ['TEXT' => 'I am cell 3'],
];

//add the row to the table
$table->addRow($row);
```

### A more complex row

```php
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
```

### Row cells are by default Advanced Multicells

```php
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
```

### Row height

The row height is determined by the cell heights. The cell height depends on the cell content and cell type.

A fixed height can be set by specifying the `HEIGHT` parameter for a cell. In this case no content overflow checks are
done. The user has to make sure that the cell content fits the specified area.

For example:

```php
$row = [
    [
        'TEXT' => '<p>This is <b>Fixed Height Cell</b></p>',
        'HEIGHT' => '30'
    ],
    ['TEXT' => '<p>This is a <b>Multicell</b></p>'],
    ['TEXT' => '<p>This is a <b>Multicell</b></p>'],
];

//add the row to the table
$table->addRow($row);
```

## Table Cells

By default table cells are Advanced Multicells.

### Text

```php
$row = [
    'I am a cell', 
    '<p> I am also a cell</p>' // this is an Advanced Multicell
];
```

If you want to add some configuration values, like alignment, color etc... pass it to the configuration array:

```php
$row = [
    [
        'TEXT' => 'I am Right Aligned', 
        'TEXT_ALIGN' => 'R'
    ],
    '<p> I am also a cell</p>'
];
```

### Images

Images are passed as objects

```php
use EvoSys21\PdfLib\Table;

$imageCell = new Table\Cell\Image($pdf, 'blog.jpg', 10);
$svgImageCell = new Table\Cell\ImageSVG($pdf, 'tiger.svg', 10);
$table->addRow([$imageCell, $svgImageCell])
```

#### Images as array

Alternatively, you can specify an image as an array:

```php
$cell = [
  'TYPE' => 'ImageSVG',
  'FILE' => 'Tiger.svg',
  'WIDTH' => 35,
  'HEIGHT' => 35,
];
```

this is equivalent to:

```php
$cell = new Table\Cell\ImageSVG($pdf, 'tiger.svg', 35, 35);
```

### Objects

All input values for cells are converted into objects. The following objects are available in the distributed package.

```php
use EvoSys21\PdfLib\Table\Cell\EmptyCell;
use EvoSys21\PdfLib\Table\Cell\Multicell;
use EvoSys21\PdfLib\Table\Cell\Image;
use EvoSys21\PdfLib\Table\Cell\ImageSVG;
```

## Finalize the table

In order to add/render the table to the PDF document you have to close it.

```php
//close the table, add it to the pdf document
$table->close();
```
