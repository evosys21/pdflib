<?php
namespace evosys21\PdfLib\Tests;

use evosys21\PdfLib\Fpdf\Pdf;
use evosys21\PdfLib\Examples\Tfpdf\PdfFactory;
use evosys21\PdfLib\Tests\Helper\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseTestCase
 * @package Interpid\PdfLib
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

    public function assertComparePdf($expected, $generated, $message)
    {
        $shaGenerated = sha1_file($generated);
        $shaExpected = is_readable($expected) ? sha1_file($expected) : $shaGenerated;

        $basename = basename($expected);
        $coreName = substr($basename, 0, strrpos($basename, "."));

        if (($shaExpected !== $shaGenerated) && getenv('FAILED_SCREENSHOTS')) {
            $screenshotExpect = dirname($expected) . "/expected/$coreName.png";
            $screenshotIs = dirname($expected) . "/is/$coreName.png";
            Helper::pdfScreenshot($expected, $screenshotExpect);
            Helper::pdfScreenshot($generated, $screenshotIs);
            copy($generated, dirname($expected) . "/is/" . basename($expected));
            copy($expected, dirname($expected) . "/expected/" . basename($expected));
        }

        $this->assertSame($shaExpected, $shaGenerated, $message);

        if (getenv('SCREENSHOTS')) {
            $screenshot = dirname($expected) . "/$coreName.png";
            Helper::pdfScreenshot($generated, $screenshot);
        }
    }
}
