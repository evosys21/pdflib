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

namespace Interpid\PdfLib\Tests\Functional;

use Interpid\PdfExamples\PdfFactory;
use Interpid\PdfLib\Tests\Helper\TestPdf;
use PHPUnit\Framework\TestCase;

/**
 * Class TableExamples2Test
 * @package Interpid\PdfLib\Tests\Functional
 */
class TableExamples2Test extends TestCase
{
    /**
     * Returns the pdf object
     *
     * @return TestPdf
     */
    protected function getPdfObject()
    {
        //create the pdf object and do some initialization
        $pdf = new TestPdf();

        $factory = new PdfFactory();
        $factory->initPdf($pdf);

        //disable compression for testing
        $pdf->SetCompression(false);

        return $pdf;
    }


    protected function runTestWithExample($require, $name)
    {
        //remove the .php extension
        $name = str_replace('.php', '', $name);

        $pdf = $this->getPdfObject();

        require $require;

        $sResultFile = TEST_PATH . '/data/' . $name . '.pdf';

        if (defined('GENERATE_RESULT_FILES')) {
            $sPdfFile = $sResultFile;
        } else {
            $sPdfFile = tempnam(sys_get_temp_dir(), 'pdf_test');
        }

        //send the pdf to the browser
        $pdf->saveToFile($sPdfFile);

        $this->assertTrue(file_exists($sPdfFile));

        // $this->assertFileEquals($sPdfFile, $sResultFile);
        $this->assertSame(sha1_file($sPdfFile), sha1_file($sResultFile), "FAILED: " . basename($sResultFile) . " / $require");

        if (!defined('GENERATE_RESULT_FILES')) {
            unlink($sPdfFile);
        }
    }

    /**
     * Tests testExample1
     */
    public function testExample1()
    {
        $require = APPLICATION_PATH . '/examples/table/code-example1.php';

        $this->runTestWithExample($require, 'table-' . basename($require));
    }


    /**
     * Tests testExample2
     */
    public function testExample2()
    {
        $require = APPLICATION_PATH . '/examples/table/code-example2.php';

        $this->runTestWithExample($require, 'table-' . basename($require));
    }


    public function testExample3()
    {
        $require = APPLICATION_PATH . '/examples/table/code-example3.php';

        $this->runTestWithExample($require, 'table-' . basename($require));
    }


    public function testExampleAlignments()
    {
        $require = APPLICATION_PATH . '/examples/table/code-example-alignments.php';

        $this->runTestWithExample($require, 'table-' . basename($require));
    }


    public function testExampleTransparent()
    {
        $require = APPLICATION_PATH . '/examples/table/code-example-transparent.php';

        $this->runTestWithExample($require, 'table-' . basename($require));
    }
}
