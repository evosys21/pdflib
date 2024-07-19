<?php

namespace evosys21\PdfLib\Tests\Feature;

use evosys21\PdfLib\Tests\BaseExamplesTestCase;

/**
 */
class ExamplesTest extends BaseExamplesTestCase
{

    use ProviderTrait;

    /**
     * Tests testExample1
     * @dataProvider examplesProvider
     */
    public function testExamples($dir, $file)
    {
        $source = "examples/$dir/$file";
        $this->runTestWithExample($source, $dir, $file);
    }
}
