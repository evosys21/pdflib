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

namespace evosys21\PdfLib\Tests\Feature;

use Generator;
use evosys21\PdfLib\Tests\BaseTestCase;
use evosys21\PdfLib\Tests\Helper\Helper;
use evosys21\PdfLib\Tests\Helper\TestPdf;

/**
 * Class TableTest
 * @group functional
 */
class TableTest extends BaseTestCase
{

    /**
     * Returns the pdf object
     *
     * @return TestPdf
     */
    protected function getPdfObject1()
    {
        return Helper::pdfObject1();
    }


    protected function runTestModelSimple($require, $name)
    {
        $pdf = $this->getPdfObject1();

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
        $this->assertComparePdf($sPdfFile, $sResultFile, "FAILED: " . basename($sResultFile) . " / $require");

        if (!defined('GENERATE_RESULT_FILES')) {
            unlink($sPdfFile);
        }
    }

    protected function runTestModel1($require)
    {
        $pdf = $this->getPdfObject1();
        $name = str_replace('.php', '', basename($require));

        $height = $pdf->h - 60;
        $y = $pdf->GetY();

        while ($y < $height) {
            Helper::setFontStyle1($pdf);
            $pdf->Cell(0, 5, "Current Y: $y");
            $pdf->SetY($y);

            require $require;

            $pdf->AddPage();
            $y += 2;
        }

        $expected = TEST_PATH . '/data/' . $name . '.pdf';

        if (defined('GENERATE_RESULT_FILES')) {
            $generated = $expected;
        } else {
            $generated = tempnam(sys_get_temp_dir(), 'pdf_test');
        }

        //send the pdf to the browser
        $pdf->saveToFile($generated);

        $this->assertTrue(file_exists($generated));

        // $this->assertFileEquals($sPdfFile, $sResultFile);
        $this->assertComparePdf($expected, $generated, "FAILED: " . basename($expected) . " / $require");

        if (!defined('GENERATE_RESULT_FILES')) {
            unlink($generated);
        }
    }

    protected function runTestModel2($require, $name, $y)
    {
        $pdf = $this->getPdfObject1();

        $pdf->SetY($y);

        require $require;

        $sResultFile = TEST_PATH . '/data/' . $name . '.pdf';

        if (defined('GENERATE_RESULT_FILES')) {
            $sPdfFile = $sResultFile;
        } else {
            $sPdfFile = tempnam(sys_get_temp_dir(), 'pdf_test');
        }

        $pdf->saveToFile($sPdfFile);

        $this->assertTrue(file_exists($sPdfFile));

        // $this->assertFileEquals($sPdfFile, $sResultFile);
        $this->assertComparePdf($sPdfFile, $sResultFile, "FAILED: " . basename($sResultFile) . " / $require");

        if (!defined('GENERATE_RESULT_FILES')) {
            unlink($sPdfFile);
        }
    }

    /**
     * @dataProvider getTestModelSources
     */
    public function testTableModels($source)
    {
        $this->runTestModel1($source);
    }

    public function getTestModelSources(): Generator
    {
        yield [__DIR__ . '/table/draw-table-model1.php'];
        yield [__DIR__ . '/table/draw-table-model2.php'];
        yield [__DIR__ . '/table/draw-table-model3.php'];
    }

    /**
     * Tests testExample1
     */
    public function testDisablePageBreak()
    {
        $this->runTestModelSimple(__DIR__ . '/table/disable-page-break.php', __FUNCTION__);
    }
}