<?php

use EvoSys21\PdfLib\Examples\Tfpdf\MyPdf;
use EvoSys21\PdfLib\Examples\Tfpdf\PdfSettings;
use EvoSys21\PdfLib\Table;

if (!isset($pdf)) {
    $pdf = new MyPdf();
}

$table = new Table($pdf);

$table->setStyle('p', 6, '', '130,0,30', 'helvetica');
$table->setStyle('b', 6, 'B', '130,0,30', 'helvetica');
$table->setStyle('bi', 6, 'BI', '0,0,120', 'helvetica');
$table->setStyle('s1', 6, 'I', '0,0,120', 'helvetica');
$table->setStyle('s2', 7, '', '110,50,120', 'helvetica');

$nColumns = 5;

/**
 * Set the tag styles
 */

$table->initialize([20, 30, 40, 50]);

$header1 = PdfSettings::headerRow();
$header1[2]['TEXT'] = 'Colspan in Header';
$header1[2]['COLSPAN'] = 2;

$header2 = PdfSettings::headerRow();
$header3 = PdfSettings::headerRow();

$header2[1]['TEXT'] = "Colspan/Rowspan in Header";
$header2[1]['COLSPAN'] = 2;
$header2[1]['ROWSPAN'] = 2;

$table->addHeader($header1);
$table->addHeader($header2);
$table->addHeader($header3);


for ($i = 0; $i < 8; $i++) {
    $row = PdfSettings::dataRow();

    if (0 == $i) {
        $row[1]['COLSPAN'] = 2;
    }

    if (1 == $i) {
        $row[1]['COLSPAN'] = 3;
    }

    if (2 == $i) {
        $row[1]['TEXT'] = PdfSettings::$textExtraLong . "\n\n" . PdfSettings::$textSubSuperscript;
        $row[1]['ALIGN'] = 'J';
        $row[1]['COLSPAN'] = 3;
        $row[1]['ROWSPAN'] = 3;
    }

    if (3 == $i) {
        $row[0] = PdfSettings::$imageCell;
    }

    if (5 == $i) {
        $row[1] = PdfSettings::$imageCell;
        $row[1]['COLSPAN'] = 2;
        $row[1]['ROWSPAN'] = 2;
    }


    $table->addRow($row);
}

//close the table
$table->close();
