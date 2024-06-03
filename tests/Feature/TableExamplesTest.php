<?php
namespace evosys21\PdfLib\Tests\Feature;

use Generator;
use evosys21\PdfLib\Tests\BaseExamplesTestCase;


/**
 * Class TableExamplesTest
 * @package Interpid\PdfLib\Tests\Functional
 * @group functional
 */
class TableExamplesTest extends BaseExamplesTestCase
{
    /**
     * Tests testExample1
     * @dataProvider getTestSources
     */
    public function testExamples($source)
    {
        $this->runTestWithExample($source, basename($source));
    }

    public function getTestSources(): Generator
    {
        $sources = array(
            'example-table-1-overview.php',
            'example-table-2-overview.php',
            'example-table-3-detailed.php',
            'example-table-4-override.php',
            'example-table-5-row-height.php',
        );

        foreach ($sources as $source) {
            $source = APPLICATION_PATH . '/examples/Fpdf/' . $source;
            yield [$source];
        }
    }
}
