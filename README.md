Fpdf - TCPDF - tFpdf - Advanced Multicell and Table 
=================================

`evosys21/pdflib` is a collection of PHP classes facilitating developers to create [Advanced Multicells]() and [Tables]() in [FPDF](http://www.fpdf.org), [TCPDF](https://github.com/tecnickcom/TCPDF) or 
[tFPDF](http://fpdf.org/en/script/script92.php).

## Installation with Composer

`evosys21/pdflib` can be used with FPDF, TCPDF or tFPDF we haven't added a fixed dependency in the main
composer.json file. You need to add the dependency to the PDF generation library of your choice
yourself.

To use FPDI with FPDF include following in your composer.json file:

```json
{
  "require": {
    "setasign/fpdf": "1.8.*",
    "evosys21/pdflib": "^1.0"
  }
}
```

If you want to use TCPDF, you have to update your composer.json to:

```json
{
  "require": {
    "tecnickcom/tcpdf": "6.6.*",
    "evosys21/pdflib": "^1.0"
  }
}
```

If you want to use tFPDF, you have to update your composer.json to:

```json
{
  "require": {
    "setasign/tfpdf": "1.33.*",
    "evosys21/pdflib": "^1.0"
  }
}
```

## Manual Installation

If you do not use composer, just require the autoload.php in the /src folder:

```php
require_once('src/autoload.php');
```


## Example and Documentation

```

A full end-user documentation and API reference is available [here](...).
