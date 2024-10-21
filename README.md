<h1>Fpdf, TCPDF, tFpdf - Advanced Multicell and Table</h1>

[![Build status](https://github.com/evosys21/pdflib/workflows/build/badge.svg)](https://github.com/evosys21/pdflib/actions) 
[![Latest Stable Version](https://poser.pugx.org/evosys21/phplib/v/stable)](https://packagist.org/packages/evosys21/phplib)

<!-- TOC -->
  * [Overview](#overview)
  * [Advanced Multicell](#advanced-multicell)
    * [Features](#features)
    * [Examples](#examples)
  * [Advanced table](#advanced-table)
    * [Features](#features-1)
    * [Examples](#examples-1)
  * [FAQ](#faq)
    * [Why use the custom pdf class instead of `FPDF/TCPDF/tFPDF`](#why-use-the-custom-pdf-class-instead-of-fpdftcpdftfpdf)
    * [Where do I report issues?](#where-do-i-report-issues)
  * [Contribute](#contribute)
  * [License](#license)
<!-- TOC -->

---

## Overview

`evosys21/pdflib` is a collection of PHP classes facilitating developers to create [Advanced Multicells](#advanced-multicell) and [Tables](#advanced-table) in [FPDF](http://www.fpdf.org), [TCPDF](https://github.com/tecnickcom/TCPDF) or
[tFPDF](http://fpdf.org/en/script/script92.php).

## Advanced Multicell

This addon class allows creation of an **Advanced Multicell for FPDF/TCPDF/tFPDF** which uses as input a TAG based formatted
string instead of a simple string. The use of tags allows to change the font, the style (bold, italic, underline),
the size, and the color of characters and many other features.

The function is pretty similar to the Multicell function in the tcpdf base class with some extended parameters.

### Features

- Text can be **aligned**, **centered**, or **justified**.
- Different **fonts**, **sizes**, **styles**, and **colors** can be used.
- The cell block can be **framed**, and the **background** can be **colored**.
- **Links** can be used in any tag.
- **TAB** spaces (`\t`) can be used.
- Variable vertical positions can be used for **subscripts** or **superscripts**.
- **Cell padding** (left, right, top, bottom) can be adjusted.
- Controlled **tag sizes** can be used.
  
### Examples

|         | Multicell Example #1 - Overview                                                                                             | multicell Example #1 - Overview                                                                                               | 
|---------|-----------------------------------------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------|
| Code    | [example-multicell-1-overview.php](examples/Tcpdf/example-multicell-1-overview.php)                                         | [example-multicell-6-shrinking.php](examples/Tcpdf/example-multicell-6-shrinking.php)                                         |
| Preview | [<img src="examples/Tcpdf/example-multicell-1-overview.png" height="300">](examples/Tcpdf/example-multicell-1-overview.pdf) | [<img src="examples/Tcpdf/example-multicell-6-shrinking.png" height="300">](examples/Tcpdf/example-multicell-6-shrinking.pdf) |
| Pdf     | [example-multicell-1-overview.pdf](examples/Tcpdf/example-multicell-1-overview.pdf)                                         | [example-multicell-1-overview.pdf](examples/Tcpdf/example-multicell-1-overview.pdf)                                           |      |

Check the [examples](examples) folder for more examples with preview and the associated code.

### Usage and documentation

[Click here](docs/multicell.md) for the end-user documentation for Advanced Multicell.

## Advanced table

This addon class allows creation of an **Advanced Table for FPDF/TCPDF/tFPDF** in the pdf document in a very simple way.

### Features

- Every table cell supports [Advanced Multicell](#advanced-multicell) functionality.
- Table cells can be aligned both **vertically** and **horizontally**.
- Cells can span multiple **columns** and **rows**.
- The table automatically splits on **page breaks**.
- The **header** is automatically added to every new page.
- Default properties for **headers** and **rows** can be set but can be overridden per individual cell.
- **Advanced cell-splitting mode** is available.
- The table supports **transparency**.
- **Images** can be inserted into table cells.

A full end-user documentation for Advanced Table is available [here](docs/table.md).

### Examples

|         | Table Example #1 - Overview                                                                                         | Table Example #1 - Overview                                                                                         | 
|---------|---------------------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------|
| Code    | [example-table-1-overview.php](examples/Tcpdf/example-table-1-overview.php)                                         | [example-table-2-overview.php](examples/Tcpdf/example-table-2-overview.php)                                         |
| Preview | [<img src="examples/Tcpdf/example-table-1-overview.png" height="300">](examples/Tcpdf/example-table-1-overview.pdf) | [<img src="examples/Tcpdf/example-table-2-overview.png" height="300">](examples/Tcpdf/example-table-2-overview.pdf) |
| Pdf     | [example-table-1-overview.pdf](examples/Tcpdf/example-table-1-overview.pdf)                                         | [example-table-1-overview.pdf](examples/Tcpdf/example-table-1-overview.pdf)                                         |      |

### Usage and documentation

[Click here](docs/table.md) for the end-user documentation for Advanced Table.

## FAQ

### Why use the custom pdf class instead of `FPDF/TCPDF/tFPDF`

The custom `evosys21\PdfLib\Fpdf\Pdf` object is used instead of `FPDF` because `FPDF`'s private/protected properties,
like widths, margins, and fonts, need to be accessed to implement add-ons.  
Since `FPDF` doesn't provide setters/getters for these properties, the class was extended to 
access them.

The same is valid for all 3 pdf classes: `FPDF/TCPDF/tFPDF`.

For more details see: 
 - [src/Fpdf/Pdf.php](src/Fpdf/Pdf.php)
 - [src/Tcpdf/Pdf.php](src/Tcpdf/Pdf.php)
 - [src/Tfpdf/Pdf.php](src/Tfpdf/Pdf.php)

### Where do I report issues?

If something is not working as expected, please check or open an
[issue](https://github.com/evosys21/pdflib/issues).

If you would like to discuss your use case or ask a general question, please use the discussions board:
[discussions](https://github.com/evosys21/pdflib/discussions).

## Contribute

We welcome contributors to the project.

- Before opening a pull request, please create an issue to
  [discuss the scope of your proposal](https://github.com/evosys21/pdflib/issues).
- Never send PR to `main` unless you want to contribute to the development
  version of the client (`main` represents the next major version).

Thanks in advance for your contribution! :heart:

## License

MIT License. For more information, please see the [LICENSE](LICENSE.TXT) file.
