<?php


class MulticellExamplesTest extends BaseExamplesTestCase
{

    /**
     * Tests testExample1
     */
    public function testExamples()
    {
        $aSources = array(
            'example-multicell-1-overview.php',
            'example-multicell-2-overview-page-break.php',
            'example-multicell-3-line-breaking.php',
            'example-multicell-4-page-break.php',
        );

        foreach ( $aSources as $source ) {
            $require = APPLICATION_PATH . '/examples/' . $source;
            $this->runTestWithExample( $require, basename( $require ) );
        }
    }
}

