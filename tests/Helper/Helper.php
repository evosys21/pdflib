<?php

/**
 * This file is part of the Interpid PDF Addon package.
 *
 * @author Interpid <office@interpid.eu>
 * @copyright (c) Interpid, http://www.interpid.eu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Interpid\PdfLib\Tests\Helper;

use evosys21\PdfLib\Fpdf\Pdf;
use evosys21\PdfLib\Examples\Fpdf\PdfFactory;
use Symfony\Component\Process\Process;


class Helper
{

    /**
     * Returns the pdf object
     *
     * @return TestPdf
     */
    public static function pdfObject1()
    {
        //create the pdf object and do some initialization
        $pdf = new TestPdf('P', 'mm', array(
            130,
            180
        ));

        PdfFactory::initPdf($pdf);

        //disable compression for testing
        $pdf->SetCompression(false);

        return $pdf;
    }

    /**
     * @param Pdf $pdf
     */
    public static function setFontStyle1($pdf)
    {
        $pdf->SetFont('helvetica', 'I', 7);
        $pdf->SetTextColor(170, 170, 170);
    }

    public static function pdfScreenshot($pdf, $dest, $page = 0)
    {
        $process = new Process([
            'magick',
            '-background',
            'white',
            '-density',
            '300',
            $pdf . "[$page]",
            '-flatten',
            $dest
        ]);

        // print_r($process->getCommandLine());

        $dir = dirname($dest);
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $process->run();
        if (!$process->isSuccessful()) {
            echo $process->getErrorOutput() . PHP_EOL;
        }
        return $dest;
    }
}
