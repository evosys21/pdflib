<?php

namespace evosys21\PdfLib\Tests;

use evosys21\PdfLib\Tests\Utils\TestUtils;

/**
 * Class BaseExamplesTestCase\Tests
 */
class BaseExamplesTestCase extends BaseTestCase
{
    protected array $unlink = [];

    public function __destruct()
    {
        foreach ($this->unlink as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    protected function runTestWithExample($require, $expected): void
    {
        $content = TestUtils::execRequire($require);

        $generated = TestUtils::tmpFile();
        file_put_contents($generated, $content);
        $this->unlink[] = $generated;
        TestUtils::toFile($expected, $content);

        $this->assertTrue(file_exists($generated), $require);
        $this->assertComparePdf($expected, $generated, "FAILED: " . basename($expected) . " / $require");
    }

    protected function runTestPdf($pdf, $expected, $message): void
    {
        $generated = TestUtils::tmpFile();

        //send the pdf to the browser
        $pdf->saveToFile($generated);
        $this->unlink[] = $generated;

        TestUtils::toFile($expected, $generated);

        $this->assertTrue(file_exists($generated), $message);
        $this->assertComparePdf($expected, $generated, "FAILED: " . basename($expected) . " / $message");
    }
}
