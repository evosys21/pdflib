<?php

namespace evosys21\PdfLib\Tests;

use evosys21\PdfLib\Fpdf\Pdf;
use evosys21\PdfLib\Examples\Fpdf\PdfFactory;
use evosys21\PdfLib\Tests\Utils\Helper;
use evosys21\PdfLib\Tests\Utils\TestUtils;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseTestCase
 */
class BaseTestCase extends TestCase
{
    /**
     * Returns the pdf object
     *
     * @return Pdf
     */
    protected function getPdfObject()
    {
        //create the pdf object and do some initialization
        $pdf = new Pdf();

        $factory = new PdfFactory();
        $factory->initPdf($pdf);

        //disable compression for testing
        $pdf->SetCompression(false);

        return $pdf;
    }

    public function assertComparePdf($pdfExpected, $pdfGenerated, $message): void
    {
        $shaGenerated = sha1_file($pdfGenerated);
        $shaExpected = is_readable($pdfExpected) ? sha1_file($pdfExpected) : $shaGenerated;

        $basename = basename($pdfExpected);
        $coreName = substr($basename, 0, strrpos($basename, "."));

        if (($shaExpected !== $shaGenerated) && getenv('TRACK_FAILED')) {
            $pdf = TestUtils::failPath($pdfExpected);
            TestUtils::copy($pdfGenerated, $pdf);
            if (getenv('SCREENSHOTS')) {
                Helper::pdfScreenshot($pdf);
            }
        }

        if (TestUtils::isDebug()){
            $this->assertSame(file_get_contents($pdfExpected), file_get_contents($pdfGenerated), $message);
        }
        $this->assertSame($shaExpected, $shaGenerated, $message);

        if (getenv('SCREENSHOTS')) {
            $screenshot = dirname($pdfExpected) . "/$coreName.png";
            Helper::pdfScreenshot($pdfGenerated, $screenshot);
        }
    }
}
