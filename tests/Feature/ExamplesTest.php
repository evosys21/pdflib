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
        $this->runTestWithExample($source, "src/$dir", $file);
    }

    /**
     * @dataProvider getDevSources
     */
    public function testDevSources($context, $file)
    {
        $source = "dev/$file";
        global $pdfContext;
        $pdfContext = $context;
        $this->runTestWithExample($source, "dev/$context", $file);
    }
}
