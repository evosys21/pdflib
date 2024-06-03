<?php
/**
 * Pdf Advanced Multicell - Example
 */
require_once __DIR__ . '/../autoload.php';

use evosys21\PdfLib\Multicell;
use evosys21\PdfLib\Table;
use evosys21\PdfLib\Examples\Fpdf\PdfFactory;
use evosys21\PdfLib\Examples\Fpdf\PdfSettings;

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

