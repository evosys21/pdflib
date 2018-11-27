<?php

use Interpid\PdfExamples\myPdf;
use Interpid\PdfExamples\pdfFactory;
use PHPUnit\Framework\TestCase;

class BaseExamplesTestCase extends TestCase
{
    /**
     * Returns the pdf object
     *
     * @return myPdf
     */
    protected function getPdfObject()
    {
        //create the pdf object and do some initialization
        $pdf = new myPdf();

        $factory = pdfFactory::initPdf($pdf);

        //disable compression for testing
        $pdf->SetCompression(false);

        return $pdf;
    }


    protected function runTestWithExample($require, $name)
    {
        //remove the .php extension
        $name = str_replace(".php", '', $name);

        ob_start();
        require $require;
        $content = ob_get_clean();

        $sResultFile = TEST_PATH . '/data/' . $name . '.pdf';

        if (defined('GENERATE_RESULT_FILES')) {
            $sPdfFile = $sResultFile;
        } else {
            $sPdfFile = tempnam(sys_get_temp_dir(), 'pdf_test');
        }

        file_put_contents($sPdfFile, $content);

        $this->assertTrue(file_exists($sPdfFile), $require);
        $this->assertFileEquals($sResultFile, $sPdfFile, $require);
        $this->assertSame(sha1_file($sResultFile), sha1_file($sPdfFile), $require);

        if (!defined('GENERATE_RESULT_FILES')) {
            unlink($sPdfFile);
        }
    }
}
