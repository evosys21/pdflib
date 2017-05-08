<?php


class TableExamplesTest extends BaseExamplesTestCase
{

    /**
     * Tests testExample1
     */
    public function testExamples()
    {
        $aSources = array(
            'example-table-1-overview.php',
            'example-table-2-overview.php',
            'example-table-3-detailed.php',
            'example-table-4-override.php',
        );

        foreach ( $aSources as $source ) {
            $require = APPLICATION_PATH . '/examples/' . $source;
            $this->runTestWithExample( $require, basename( $require ) );
        }
    }
}

