<?php

require_once( dirname( __FILE__ ) . "/bootstrap.php" );

class BaseTestCase extends PHPUnit_Framework_TestCase
{


    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {

        parent::setUp();
    }


    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {

        parent::tearDown();
    }


    /**
     * Returns the pdf object
     *
     * @return myPdf
     */
    protected function getPdfObject()
    {

        //create the pdf object and do some initialization
        $oPdf = new Pdf();

        $factory = new pdfFactory();
        $factory->initPdfObject( $oPdf );

        //disable compression for testing
        $oPdf->SetCompression( false );

        return $oPdf;
    }
}

