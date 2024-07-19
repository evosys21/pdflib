<?php

namespace evosys21\PdfLib\Tests\Feature;

use evosys21\PdfLib\Tests\BaseExamplesTestCase;
use evosys21\PdfLib\Tests\Functional\ProviderTrait;

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
