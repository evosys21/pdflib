<?php

namespace EvoSys21\PdfLib\Tests\Feature;

use EvoSys21\PdfLib\Dev\DevFactory;
use EvoSys21\PdfLib\Tests\BaseExamplesTestCase;
use EvoSys21\PdfLib\Tests\Utils\Helper;

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

    /**
     * @dataProvider codeSnippetsProvider
     */
    public function testMultiPageSnippets($context, $require): void
    {
        $factory = new DevFactory($context);
        $table = $factory->table();
        global $pdf;
        $pdf = $table->getPdfObject();
        $pdf->drawMargins = true;

        $name = pathinfo($require, PATHINFO_FILENAME);

        $height = $pdf->h - 60;
        $y = $pdf->GetY();

        while ($y < $height) {
            Helper::setFontStyle1($pdf);
            $pdf->Cell(0, 5, "Current Y: $y");
            $pdf->SetY($y);

            require $require;

            $pdf->AddPage();
            $y += 5;
        }

        $expected = TEST_PATH . "/_files/dev/$context/multi-page-$name.pdf";

        $this->runTestPdf($pdf, $expected, $require);
    }
}
