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

use Interpid\PdfExamples\MyPdf;
use Interpid\PdfExamples\PdfFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseExamplesTestCase
 * @package Interpid\PdfLib\Tests
 */
class BaseExamplesTestCase extends TestCase
{
    /**
     * Returns the pdf object
     *
     * @return MyPdf
     */
    protected function getPdfObject()
    {
        //create the pdf object and do some initialization
        $pdf = new MyPdf();

        $factory = PdfFactory::initPdf($pdf);

        //disable compression for testing
        $pdf->SetCompression(false);

        return $pdf;
    }


    protected function runTestWithExample($require, $name)
    {
        //remove the .php extension
        $name = str_replace('.php', '', $name);

        ob_start();
        require $require;
        $content = ob_get_clean();

        $sResultFile = TEST_PATH . '/data/' . $name . '.pdf';

        if (defined('GENERATE_RESULT_FILES')) {
            $sPdfFile = $sResultFile;
        } else {
            $sPdfFile = tempnam(sys_get_temp_dir(), 'pdf_test');
        }

        file_put_contents($sPdfFile, $content);

        $this->assertTrue(file_exists($sPdfFile), $require);
        $this->assertFileEquals($sResultFile, $sPdfFile, $require);
        $this->assertSame(sha1_file($sResultFile), sha1_file($sPdfFile), $require);

        if (!defined('GENERATE_RESULT_FILES')) {
            unlink($sPdfFile);
        }
    }
}
