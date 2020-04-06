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

use Interpid\PdfLib\Tests\Helper\Helper;
use Interpid\PdfLib\Tests\Helper\TestPdf;
use PHPUnit\Framework\TestCase;

/**
 * Class TableTest
 * @group functional
 */
class TableTest extends TestCase
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

        $this->assertFileEquals($sPdfFile, $sResultFile);

        if (!defined('GENERATE_RESULT_FILES')) {
            unlink($sPdfFile);
        }
    }


    protected function runTestModel1($require, $name)
    {
        $pdf = $this->getPdfObject1();

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

        $sResultFile = TEST_PATH . '/data/' . $name . '.pdf';

        if (defined('GENERATE_RESULT_FILES')) {
            $sPdfFile = $sResultFile;
        } else {
            $sPdfFile = tempnam(sys_get_temp_dir(), 'pdf_test');
        }

        //send the pdf to the browser
        $pdf->saveToFile($sPdfFile);

        $this->assertTrue(file_exists($sPdfFile));

        $this->assertFileEquals($sPdfFile, $sResultFile);

        if (!defined('GENERATE_RESULT_FILES')) {
            unlink($sPdfFile);
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

        $this->assertFileEquals($sPdfFile, $sResultFile);

        if (!defined('GENERATE_RESULT_FILES')) {
            unlink($sPdfFile);
        }
    }

    /**
     * Tests testTableModel1
     */
    public function testTableModel1()
    {
        $this->runTestModel1( __DIR__ . '/table/draw-table-model1.php', __FUNCTION__);
    }


    /**
     * Tests testTableModel2
     */
    public function testTableModel2()
    {
        $this->runTestModel1( __DIR__ . '/table/draw-table-model2.php', __FUNCTION__);
    }

    /**
     * Tests testTableModel3
     */
    public function testTableModel3()
    {
        $this->runTestModel1( __DIR__ . '/table/draw-table-model3.php', __FUNCTION__);
    }

    /**
     * Tests testExample1
     */
    public function testDisablePageBreak()
    {
        $this->runTestModelSimple( __DIR__ . '/table/disable-page-break.php', __FUNCTION__);
    }
}
