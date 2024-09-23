<?php

namespace evosys21\PdfLib\Tests;

use evosys21\PdfLib\Tests\Utils\TestUtils;

/**
 * Class BaseExamplesTestCase\Tests
 */
class BaseExamplesTestCase extends BaseTestCase
{

    protected function runTestWithExample($require, $folder, $name): void
    {
//        echo "Running test for $require - $folder\n";
        $name = str_replace('.php', '', $name);

        ob_start();
        require $require;
        $content = ob_get_clean();

        $expectedFile = TEST_PATH . "/_files/$folder/$name.pdf";

        $generatedFile = tempnam(sys_get_temp_dir(), 'pdf_test');

        //CreationDate (D:20240101010000)
        $content = preg_replace("#CreationDate \(D:[0-9]+#", "CreationDate (D:20240101010000", $content);
        $content = preg_replace("#LastModified \(D:[0-9]+#", "LastModified (D:20240101010000", $content);

        file_put_contents($generatedFile, $content);
        TestUtils::toFile($expectedFile, $content);

        $this->assertTrue(file_exists($generatedFile), $require);
        $this->assertComparePdf($expectedFile, $generatedFile, "FAILED: " . basename($expectedFile) . " / $require");

        if (is_readable($generatedFile)) {
            unlink($generatedFile);
        }
    }
}
