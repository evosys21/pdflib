<?php

/**
 * Created by PhpStorm.
 * User: andy
 * Date: 10/20/2014
 * Time: 10:21 PM
 */

use Interpid\PdfExamples\pdfFactory;
use Interpid\PdfLib\Pdf;

class Helper
{

    /**
     * Returns the pdf object
     *
     * @return testPdf
     */
    public static function pdfObject1()
    {
        require_once(__DIR__ . '/testPdf.php');

        //create the pdf object and do some initialization
        $pdf = new testPdf('P', 'mm', array(
            130,
            180
        ));

        pdfFactory::initPdf($pdf);

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
