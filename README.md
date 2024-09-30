# Fpdf, TCPDF, tFpdf - Advanced Multicell and Table 

`evosys21/pdflib` is a collection of PHP classes facilitating developers to create [Advanced Multicells]() and [Tables]() in [FPDF](http://www.fpdf.org), [TCPDF](https://github.com/tecnickcom/TCPDF) or 
[tFPDF](http://fpdf.org/en/script/script92.php).


[![Build status](https://github.com/evosys21/pdflib/workflows/build/badge.svg)](https://github.com/evosys21/pdflib/actions) [![Latest Stable Version](https://poser.pugx.org/evosys21/phplib/v/stable)](https://packagist.org/packages/evosys21/phplib)

## Contents

<!-- TOC -->
* [Fpdf, TCPDF, tFpdf - Advanced Multicell and Table](#fpdf-tcpdf-tfpdf---advanced-multicell-and-table-)
  * [Contents](#contents)
  * [Installation with Composer](#installation-with-composer)
  * [Example and Documentation](#example-and-documentation)
    * [Advanced Multicell](#advanced-multicell)
    * [Advanced table](#advanced-table)
  * [FAQ 🔮](#faq-)
    * [Where do I report issues?](#where-do-i-report-issues)
  * [Contribute 🚀](#contribute-)
  * [License 📗](#license-)
<!-- TOC -->

***

## Installation with Composer

`evosys21/pdflib` can be used with FPDF, TCPDF or tFPDF. Because of this we haven't added a fixed dependency in the main composer.json file. You need to add the dependency to the PDF generation library of your choice yourself.

To use `evosys21/pdflib` with FPDF, install it via Composer:

```shell
composer require evosys21/pdflib
composer require setasign/fpdf
```

If you want to use TCPDF:

```shell
composer require evosys21/pdflib
composer require tecnickcom/tcpdf
```

If you want to use tFPDF:

```shell
composer require evosys21/pdflib
composer require setasign/tfpdf
```

## Example and Documentation

### Advanced Multicell

A full end-user documentation for Advanced Multicell is available [here](docs/multicell.md).

### Advanced table

A full end-user documentation for Advanced Table is available [here](docs/table.md).

## FAQ 🔮

### Where do I report issues?

If something is not working as expected, please check or open an 
[issue](https://github.com/evosys21/pdflib/issues).

If you would like to discuss your use case or ask a general question, please use the discussions board:
[discussions](https://github.com/evosys21/pdflib/discussions).

## Contribute 🚀

We welcome contributors to the project.
- Before opening a pull request, please create an issue to
  [discuss the scope of your proposal](https://github.com/evosys21/pdflib/issues).
- Never send PR to `main` unless you want to contribute to the development
  version of the client (`main` represents the next major version).
- Each PR should include a **unit test** using [PHPUnit](https://phpunit.de/).
Thanks in advance for your contribution! :heart:

## License 📗

MIT License. For more information, please see the [LICENSE](LICENSE.TXT) file.
