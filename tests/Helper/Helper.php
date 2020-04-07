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

use Interpid\PdfExamples\PdfFactory;
use Interpid\PdfLib\Pdf;


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
}
