<?php
namespace evosys21\PdfLib\Tests;

use evosys21\PdfLib\Examples\Tfpdf\MyPdf;
use evosys21\PdfLib\Examples\Tfpdf\PdfFactory;
use evosys21\PdfLib\Tests\Utils\TestUtils;
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


    protected function runTestWithExample($require, $folder, $name): void
    {
//        echo "Running test for $require - $folder\n";
        //remove the .php extension
        $name = str_replace('.php', '', $name);

        ob_start();
        require $require;
        $content = ob_get_clean();

        $expectedFile = TEST_PATH . "/data/$folder/$name.pdf";

        $tmpFile = tempnam(sys_get_temp_dir(), 'pdf_test');
        $generatedFile  = TestUtils::generateOn() ? $expectedFile : $tmpFile;

        //CreationDate (D:20240101010000)
        $content = preg_replace("#CreationDate \(D:[0-9]+#", "CreationDate (D:20240101010000", $content);
        $content = preg_replace("#LastModified \(D:[0-9]+#", "LastModified (D:20240101010000", $content);

        $uuid = '00620d33-a584-cac6-0d9c-4c1aec6e67b8';
        foreach (['DocumentID', 'InstanceID'] as $id) {
            $content = preg_replace("#<xmpMM:$id>uuid:[0-9a-f-]+</xmpMM:$id>#", "<xmpMM:$id>uuid:$uuid</xmpMM:$id>", $content);
        }

        TestUtils::toFile($generatedFile, $content, true);

        $this->assertTrue(file_exists($generatedFile), $require);
        $this->assertComparePdf($expectedFile, $generatedFile, "FAILED: " . basename($expectedFile) . " / $require");

        if (is_readable($tmpFile)) {
            unlink($tmpFile);
        }
    }
}
