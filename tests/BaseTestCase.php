<?php

require_once( __DIR__ . "/bootstrap.php" );

use Interpid\PdfLib\Pdf;
use Interpid\PdfExamples\pdfFactory;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
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
        $factory->initPdf( $pdf );

        //disable compression for testing
        $pdf->SetCompression( false );

        return $pdf;
    }
}

