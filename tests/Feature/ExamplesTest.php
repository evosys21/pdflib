<?php

namespace evosys21\PdfLib\Tests\Feature;

use evosys21\PdfLib\Tests\BaseExamplesTestCase;

/**
 */
class ExamplesTest extends BaseExamplesTestCase
{
    use ProviderTrait;

    /**
     * @dataProvider examplesProvider
     */
    public function testExampleSources($dir, $file)
    {
        $source = "examples/$dir/$file";

        $filename = pathinfo($file, PATHINFO_FILENAME);
        $expected = TEST_PATH . "/_files/src/$dir/$filename.pdf";

        $this->runTestWithExample($source, $expected);
    }

    /**
     * @dataProvider getDevSources
     */
    public function testDevSources($context, $file)
    {
        $source = "dev/$file";
        global $pdfContext;
        $pdfContext = $context;

        $filename = pathinfo($file, PATHINFO_FILENAME);
        $expected = TEST_PATH . "/_files/dev/$context/$filename.pdf";

        $this->runTestWithExample($source, $expected);
    }
}
