<?php

namespace evosys21\PdfLib\Tests\Feature;

use evosys21\PdfLib\Tests\BaseExamplesTestCase;
use evosys21\PdfLib\Tests\Utils\Helper;

/**
 */
class GenericTest extends BaseExamplesTestCase
{
    use ProviderTrait;

    protected function runTestModelSimple($require, $name): void
    {
        $pdf = $this->getPdfObject1();

        require $require;

        $sResultFile = TEST_PATH . '/data/' . $name . '.pdf';

        if (getenv('RESULT_WRITE')) {
            $sPdfFile = $sResultFile;
        } else {
            $sPdfFile = tempnam(sys_get_temp_dir(), 'pdf_test');
        }

        //send the pdf to the browser
        $pdf->saveToFile($sPdfFile);

        $this->assertTrue(file_exists($sPdfFile));

        // $this->assertFileEquals($sPdfFile, $sResultFile);
        $this->assertComparePdf($sPdfFile, $sResultFile, "FAILED: " . basename($sResultFile) . " / $require");

        if (!getenv('RESULT_WRITE')) {
            unlink($sPdfFile);
        }
    }

    protected function runTestModel1($require): void
    {
        $pdf = $this->getPdfObject1();
        $name = str_replace('.php', '', basename($require));

        $height = $pdf->h - 60;
        $y = $pdf->GetY();

        while ($y < $height) {
            Helper::setFontStyle1($pdf);
            $pdf->Cell(0, 5, "Current Y: $y");
            $pdf->SetY($y);

            require $require;

            $pdf->AddPage();
            $y += 2;
        }

        $expected = TEST_PATH . '/data/' . $name . '.pdf';

        if (getenv('RESULT_WRITE')) {
            $generated = $expected;
        } else {
            $generated = tempnam(sys_get_temp_dir(), 'pdf_test');
        }

        //send the pdf to the browser
        $pdf->saveToFile($generated);

        $this->assertTrue(file_exists($generated));

        // $this->assertFileEquals($sPdfFile, $sResultFile);
        $this->assertComparePdf($expected, $generated, "FAILED: " . basename($expected) . " / $require");

        if (!getenv('RESULT_WRITE')) {
            unlink($generated);
        }
    }
}
