<?php
namespace evosys21\PdfLib\Tests;

use evosys21\PdfLib\Examples\Tfpdf\MyPdf;
use evosys21\PdfLib\Examples\Tfpdf\PdfFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseExamplesTestCase\Tests
 */
class BaseExamplesTestCase extends BaseTestCase
{
    /**
     * Returns the pdf object
     *
     * @return MyPdf
     */
    protected function getPdfObject()
    {
        //create the pdf object and do some initialization
        $pdf = new MyPdf();

        $factory = PdfFactory::initPdf($pdf);

        //disable compression for testing
        $pdf->SetCompression(false);

        return $pdf;
    }


    protected function runTestWithExample($require, $name)
    {
        //remove the .php extension
        $name = str_replace('.php', '', $name);

        ob_start();
        require $require;
        $content = ob_get_clean();

        $expectedFile = TEST_PATH . '/data/' . $name . '.pdf';

        if (defined('GENERATE_RESULT_FILES')) {
            $generatedFile = $expectedFile;
        } else {
            $generatedFile = tempnam(sys_get_temp_dir(), 'pdf_test');
        }

        //CreationDate (D:20170101010000)
        $content = preg_replace("#CreationDate \(D:[0-9]+#", "CreationDate (D:20170101010000", $content);
        $content = preg_replace("#LastModified \(D:[0-9]+#", "LastModified (D:20170101010000", $content);

        file_put_contents($generatedFile, $content);

        $this->assertTrue(file_exists($generatedFile), $require);
        $this->assertComparePdf($expectedFile, $generatedFile, "FAILED: " . basename($expectedFile) . " / $require");

        if (!defined('GENERATE_RESULT_FILES')) {
            unlink($generatedFile);
        }
    }
}
