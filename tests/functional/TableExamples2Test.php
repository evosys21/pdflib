<?php

require_once( TEST_PATH . '/helper/testPdf.php' );

class TableExamples2Test extends PHPUnit_Framework_TestCase
{
    /**
     * Returns the pdf object
     *
     * @return testPdf
     */
    protected function getPdfObject()
    {
        //create the pdf object and do some initialization
        $pdf = new testPdf();

        $factory = new pdfFactory();
        $factory->initPdfObject( $pdf );

        //disable compression for testing
        $pdf->SetCompression( false );

        return $pdf;
    }


    protected function runTestWithExample( $require, $name )
    {
        //remove the .php extention
        $name = str_replace( ".php", '', $name );

        $pdf = $this->getPdfObject();

        require $require;

        $sResultFile = TEST_PATH . '/data/' . $name . '.pdf';

        if ( defined( 'GENERATE_RESULT_FILES' ) )
        {
            $sPdfFile = $sResultFile;
        }
        else
        {
            $sPdfFile = tempnam( sys_get_temp_dir(), 'pdf_test' );
        }

        //send the pdf to the browser
        $pdf->Output( $sPdfFile, 'F' );

        $this->assertTrue( file_exists( $sPdfFile ) );

        $this->assertFileEquals( $sPdfFile, $sResultFile );

        if ( !defined( 'GENERATE_RESULT_FILES' ) )
        {
            unlink( $sPdfFile );
        }
    }

    /**
     * Tests testExample1
     */
    public function testExample1()
    {
        $require = APPLICATION_PATH . '/examples/table/code-example1.php';

        $this->runTestWithExample( $require, 'table-' . basename( $require ) );
    }


    /**
     * Tests testExample2
     */
    public function testExample2()
    {
        $require = APPLICATION_PATH . '/examples/table/code-example2.php';

        $this->runTestWithExample( $require, 'table-' . basename( $require ) );
    }


    public function testExample3()
    {
        $require = APPLICATION_PATH . '/examples/table/code-example3.php';

        $this->runTestWithExample( $require, 'table-' . basename( $require ) );
    }


    public function testExampleAlignments()
    {
        $require = APPLICATION_PATH . '/examples/table/code-example-alignments.php';

        $this->runTestWithExample( $require, 'table-' . basename( $require ) );
    }


    public function testExampleTransparent()
    {
        $require = APPLICATION_PATH . '/examples/table/code-example-transparent.php';

        $this->runTestWithExample( $require, 'table-' . basename( $require ) );
    }
}

