<?php

/**
 * This file is part of the Interpid PDF Addon package.
 *
 * @author Interpid <office@interpid.eu>
 * @copyright (c) Interpid, http://www.interpid.eu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Interpid\PdfLib\Tests;

use Interpid\PdfExamples\PdfFactory;
use Interpid\PdfLib\Pdf;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseTestCase
 * @package Interpid\PdfLib
 */
class BaseTestCase extends TestCase
{


    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }


    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
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

        $factory = new PdfFactory();
        $factory->initPdf($pdf);

        //disable compression for testing
        $pdf->SetCompression(false);

        return $pdf;
    }
}
