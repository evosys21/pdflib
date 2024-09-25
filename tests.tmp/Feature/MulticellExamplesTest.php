<?php

use evosys21\PdfLib\Tests\BaseExamplesTestCase;

/**
 * Class MulticellExamplesTest
 * @group functional
 */
class MulticellExamplesTest extends BaseExamplesTestCase
{

    /**
     * Tests testExamples
     * @dataProvider getExampleSources
     */
    public function testExamples($source)
    {
        $require = \evosys21\PdfLib\Tests\Feature\APPLICATION_PATH . '/examples/Fpdf/' . $source;
        $this->runTestWithExample($require, basename($require));
    }

    public function getExampleSources(): Generator
    {
        $sources = [
            // 'example-multicell.php',
            'example-multicell-1-overview.php',
            'example-multicell-2-overview-page-break.php',
            'example-multicell-3-line-breaking.php',
            'example-multicell-4-page-break.php',
            'example-multicell-5-max-lines.php',
            'example-multicell-6-shrinking.php',
        ];

        foreach ($sources as $source) {
            yield [$source];
        }
    }

    /**
     * Tests testDevSamples
     * @dataProvider getDevSources
     */
    public function testDevSamples($source)
    {
        $require = \evosys21\PdfLib\Tests\Feature\APPLICATION_PATH . '/dev/' . $source;
        $this->runTestWithExample($require, 'dev-' . basename($require));
    }

    public function getDevSources(): Generator
    {
        $sources = array(
            'test-multicell-align.php',
            'test-multicell-shrinking.php',
            'test-multicell-shrinking2.php',
            'test-multicell-style.php',
        );

        foreach ($sources as $source) {
            yield [$source];
        }
    }
}
