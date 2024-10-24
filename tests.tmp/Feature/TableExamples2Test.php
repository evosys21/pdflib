<?php

use EvoSys21\PdfLib\Examples\Tfpdf\PdfFactory;
use EvoSys21\PdfLib\Tests\BaseTestCase;
use EvoSys21\PdfLib\Tests\Utils\TestPdf;

/**
 * Class TableExamples2Test\Tests\Functional
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

        PdfFactory::initPdf($pdf);

        //disable compression for testing
        $pdf->SetCompression(false);

        return $pdf;
    }


    /**
     * @dataProvider getExampleSources
     * @return void
     */
    public function testWithExample($require)
    {
        $name = basename($require);
        //remove the .php extension
        $name = str_replace('.php', '', $name);

        $pdf = $this->getPdfObject();

        require $require;

        $sResultFile = TEST_PATH . '/data/table-' . $name . '.pdf';

        if (getenv('RESULT_WRITE')) {
            $sPdfFile = $sResultFile;
        } else {
            $sPdfFile = tempnam(sys_get_temp_dir(), 'pdf_test');
        }

        //send the pdf to the browser
        $pdf->saveToFile($sPdfFile);

        $this->assertTrue(file_exists($sPdfFile));

        $this->assertComparePdf($sPdfFile, $sResultFile, "FAILED: " . basename($sResultFile) . " / $require");

        if (!getenv('RESULT_WRITE')) {
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
        ];
        foreach ($files as $file) {
            yield [APPLICATION_PATH . "/examples/Fpdf/table/$file"];
        }
    }
}
