<?php

require_once( __DIR__ . "/bootstrap.php" );

use \Interpid\Pdf\Pdf;
use \Interpid\PdfExamples\pdfFactory;

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
     * @return Pdf
     */
    protected function getPdfObject()
    {
        //create the pdf object and do some initialization
        $pdf = new Pdf();

        $factory = new pdfFactory();
        $factory->initPdfObject( $pdf );

        //disable compression for testing
        $pdf->SetCompression( false );

        return $pdf;
    }
}

