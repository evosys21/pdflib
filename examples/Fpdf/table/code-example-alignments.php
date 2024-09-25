<?php

use evosys21\PdfLib\Table;
use evosys21\PdfLib\Tools;
use evosys21\PdfLib\Examples\Fpdf\MyPdf;
use evosys21\PdfLib\Examples\Fpdf\PdfSettings;

if (!isset($pdf)) {
    $pdf = new myPdf();
}

$table = new Table($pdf);

$table->setStyle('p', 6, '', '130,0,30', 'helvetica');
$table->setStyle('b', 6, 'B', '130,0,30', 'helvetica');
$table->setStyle('bi', 6, 'BI', '0,0,120', 'helvetica');

$columns = 5;

/**
 * Set the tag styles
 */

$table->initialize([20, 30, 40, 50]);

$table->addHeader(PdfSettings::headerRow());

for ($i = 0; $i < 6; $i++) {
    $row = PdfSettings::dataRow();

    if ($i >= 0 and $i < 3) {
        $row[0]['TEXT'] = "Forced\nLine\nBreaks";
        $align = Tools::getNextValue(PdfSettings::$alignments, $k);
        $row[1]['TEXT'] = "Align: <b>$align</b>";
        $row[1]['ALIGN'] = "$align";
        $align = Tools::getNextValue(PdfSettings::$alignments, $k);
        $row[2]['TEXT'] = "Align: <b>$align</b>";
        $row[2]['ALIGN'] = "$align";
        $align = Tools::getNextValue(PdfSettings::$alignments, $k);
        $row[3]['TEXT'] = "Align: <b>$align</b>";
        $row[3]['ALIGN'] = "$align";
    }

    if ($i >= 3 and $i <= 5) {
        $row[0]['TEXT'] = "Forced\nLine\nForced\nLine\nForced\nLine";
        $row[1] = PdfSettings::$imageCell;
        $row[1]['ALIGN'] = Tools::getNextValue(PdfSettings::$alignments, $k);

        $row[2] = PdfSettings::$imageCell;
        $row[2]['ALIGN'] = Tools::getNextValue(PdfSettings::$alignments, $k);

        $row[3] = PdfSettings::$imageCell;
        $row[3]['ALIGN'] = Tools::getNextValue(PdfSettings::$alignments, $k);
    }


    $table->addRow($row);
}

//close the table
$table->close();
