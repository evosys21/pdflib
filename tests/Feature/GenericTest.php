<?php

namespace EvoSys21\PdfLib\Tests\Feature;

use EvoSys21\PdfLib\Dev\DevFactory;
use EvoSys21\PdfLib\Tests\BaseExamplesTestCase;
use EvoSys21\PdfLib\Tests\Utils\Helper;

class GenericTest extends BaseExamplesTestCase
{
    use ProviderTrait;

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
