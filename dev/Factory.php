<?php
/**
 * Pdf Advanced Multicell - Example
 * Copyright (c), Interpid, http://www.interpid.eu
 */
require_once __DIR__ . '/../autoload.php';

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

        // Set the styles for the advanced multicell
        // Notice: 'base' style is always inherited
        $multicell->setStyle('base', 11, '', '130,0,30', 'helvetica');
        $multicell->setStyle('p', null);
        $multicell->setStyle('b', null, 'B');
        $multicell->setStyle('i', null, 'I', '80,80,260');
        $multicell->setStyle('u', null, 'U', '80,80,260');
        $multicell->setStyle('h1', 14, 'B', '203,0,48');
        $multicell->setStyle('h3', 12, 'B', '203,0,48');
        $multicell->setStyle('h4', 11, 'BI', '0,151,200');
        $multicell->setStyle('hh', 11, 'B', '255,189,12');
        $multicell->setStyle('ss', 7, '', '203,0,48');
        $multicell->setStyle('font', 10, '', '0,0,255');
        $multicell->setStyle('style', 10, 'BI', '0,0,220');
        $multicell->setStyle('size', 12, 'BI', '0,0,120');
        $multicell->setStyle('color', 12, 'BI', '0,255,255');

        //set the style for utf8 texts, use 'dejavusans' fonts
        $multicell->setStyle('u8', null, '', [0, 45, 179], 'dejavusans');
        $multicell->setStyle('u8b', null, 'B', null, null, 'u8');

        return $multicell;
    }
    public static function table()
    {
        //get the PDF object
        $pdf = PdfFactory::newPdf('table', false, false);

        $table = new Table($pdf);

        $table->setStyle('p', 6, '', '130,0,30', 'helvetica');
        $table->setStyle('b', 6, 'B', '130,0,30', 'helvetica');
        $table->setStyle('bi', 6, 'BI', '0,0,120', 'helvetica');
        $table->setStyle('s1', 6, 'I', '0,0,120', 'helvetica');
        $table->setStyle('s2', 10, '', '110,50,120', 'helvetica');

        return $table;
    }
}

