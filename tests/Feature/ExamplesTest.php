<?php

namespace EvoSys21\PdfLib\Tests\Feature;

use EvoSys21\PdfLib\Tests\BaseExamplesTestCase;

/**
 * @covers \EvoSys21\PdfLib\Multicell
 * @covers \EvoSys21\PdfLib\MulticellOptions
 * @covers \EvoSys21\PdfLib\Table
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
        $expected = "examples/$dir/$filename.pdf";

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
