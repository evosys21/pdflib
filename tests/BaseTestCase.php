<?php

namespace EvoSys21\PdfLib\Tests;

use EvoSys21\PdfLib\Examples\Fpdf\PdfFactory;
use EvoSys21\PdfLib\Fpdf\Pdf;
use EvoSys21\PdfLib\Tests\Utils\Helper;
use EvoSys21\PdfLib\Tests\Utils\TestUtils;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseTestCase
 */
class BaseTestCase extends TestCase
{
    /**
     * Returns the pdf object
     */
    protected function getPdfObject(): object
    {
        //create the pdf object and do some initialization
        $pdf = new Pdf();
        PdfFactory::initPdf($pdf);

        //disable compression for testing
        $pdf->SetCompression(false);

        return $pdf;
    }

    public function assertComparePdf($pdfExpected, $pdfGenerated, $message): void
    {
        if (! file_exists($pdfExpected)) {
            TestUtils::toFile($pdfExpected, $pdfGenerated, true);
        }

        $shaGenerated = sha1_file($pdfGenerated);
        $shaExpected = is_readable($pdfExpected) ? sha1_file($pdfExpected) : null;

        $basename = basename($pdfExpected);
        $coreName = substr($basename, 0, strrpos($basename, '.'));

        if (($shaExpected !== $shaGenerated) && getenv('TRACK_FAILED')) {
            $pdf = TestUtils::failPath($pdfExpected);
            TestUtils::copy($pdfGenerated, $pdf);
            if (getenv('SCREENSHOTS')) {
                Helper::pdfScreenshot($pdf);
            }
        }

        if (TestUtils::isDebug()) {
            $this->assertSame(file_get_contents($pdfExpected), file_get_contents($pdfGenerated), $message);
        }
        $this->assertSame($shaExpected, $shaGenerated, $message);

        if (getenv('SCREENSHOTS')) {
            $screenshot = dirname($pdfExpected) . "/$coreName.png";
            Helper::pdfScreenshot($pdfGenerated, $screenshot);
        }
    }
}
