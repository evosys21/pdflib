<?php
/**
 * Pdf Advanced Multicell - Example
 * Copyright (c), Interpid, http://www.interpid.eu
 */
require_once __DIR__ . '/../autoload.php';

use Interpid\PdfExamples\PdfSettings;
use Interpid\PdfLib\Multicell;
use Interpid\PdfExamples\PdfFactory;
use Interpid\PdfLib\Table;

class DevFactory
{
    public static function multicell()
    {
        //get the PDF object
        $pdf = PdfFactory::newPdf('multicell', false, false);

        // Create the Advanced Multicell Object and inject the PDF object
        $multicell = new Multicell($pdf);
        PdfSettings::setMulticellStyles($multicell);

        return $multicell;
    }
    public static function table()
    {
        //get the PDF object
        $pdf = PdfFactory::newPdf('table', false, false);

        $table = new Table($pdf);
        PdfSettings::setTableStyles($table);

        return $table;
    }
}

