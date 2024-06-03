<?php
namespace evosys21\PdfLib\Tests\Feature;

use evosys21\PdfLib\Examples\Fpdf\PdfFactory;
use evosys21\PdfLib\Tests\BaseTestCase;
use evosys21\PdfLib\Tests\Helper\TestPdf;
use Generator;

/**
 * Class TableExamples2Test
 * @package Interpid\PdfLib\Tests\Functional
 */
class TableExamples2Test extends BaseTestCase
{
    /**
     * Returns the pdf object
     *
     * @return TestPdf
     */
    protected function getPdfObject()
    {
        //create the pdf object and do some initialization
        $pdf = new TestPdf();

        $factory = new PdfFactory();
        $factory->initPdf($pdf);

        //disable compression for testing
        $pdf->SetCompression(false);

        return $pdf;
    }


    /**
     * @dataProvider getExampleSources
     * @return void
     */
    protected function runTestWithExample($require)
    {
        $name = basename($require);
        //remove the .php extension
        $name = str_replace('.php', '', $name);

        $pdf = $this->getPdfObject();

        require $require;

        $sResultFile = TEST_PATH . '/data/' . $name . '.pdf';

        if (defined('GENERATE_RESULT_FILES')) {
            $sPdfFile = $sResultFile;
        } else {
            $sPdfFile = tempnam(sys_get_temp_dir(), 'pdf_test');
        }

        //send the pdf to the browser
        $pdf->saveToFile($sPdfFile);

        $this->assertTrue(file_exists($sPdfFile));

        $this->assertComparePdf($sPdfFile, $sResultFile, "FAILED: " . basename($sResultFile) . " / $require");

        if (!defined('GENERATE_RESULT_FILES')) {
            unlink($sPdfFile);
        }
    }

    public static function getExampleSources(): Generator
    {
        $files = [
            "code-example1.php",
            "code-example2.php",
            "code-example3.php",
            "code-example-transparent.php",
            "code-example-alignments.php",
            "settings.php"
        ];
        foreach ($files as $file) {
            yield [APPLICATION_PATH . "/examples/Fpdf/table/$file"];
        }
    }
}
