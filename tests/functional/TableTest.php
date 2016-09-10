<?php

class TableTest extends PHPUnit_Framework_TestCase
{

    /**
     * Returns the pdf object
     *
     * @return testPdf
     */
    protected function getPdfObject1()
    {
        require_once TEST_PATH . '/helper/Helper.php';
        return Helper::pdfObject1();
    }


    protected function runTestModelSimple( $require, $name )
    {
        $oPdf = $this->getPdfObject1();

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
        $oPdf->Output( $sPdfFile, 'F' );

        $this->assertTrue( file_exists( $sPdfFile ) );

        $this->assertFileEquals( $sPdfFile, $sResultFile );

        if ( !defined( 'GENERATE_RESULT_FILES' ) )
        {
            unlink( $sPdfFile );
        }
    }


    protected function runTestModel1( $require, $name )
    {
        $oPdf = $this->getPdfObject1();

        $nHeight = $oPdf->h - 60;
        $y = $oPdf->GetY();

        while ( $y < $nHeight )
        {
            Helper::setFontStyle1( $oPdf );
            $oPdf->Cell( 0, 5, "Current Y: $y" );
            $oPdf->SetY( $y );

            require $require;

            $oPdf->AddPage();
            $y += 2;
        }

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
        $oPdf->Output( $sPdfFile, 'F' );

        $this->assertTrue( file_exists( $sPdfFile ) );

        $this->assertFileEquals( $sPdfFile, $sResultFile );

        if ( !defined( 'GENERATE_RESULT_FILES' ) )
        {
            unlink( $sPdfFile );
        }
    }

    protected function runTestModel2( $require, $name, $y )
    {
        $oPdf = $this->getPdfObject1();

        $oPdf->SetY( $y );

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
        $oPdf->Output( $sPdfFile, 'F' );

        $this->assertTrue( file_exists( $sPdfFile ) );

        $this->assertFileEquals( $sPdfFile, $sResultFile );

        if ( !defined( 'GENERATE_RESULT_FILES' ) )
        {
            unlink( $sPdfFile );
        }
    }


    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }


    /**
     * Tests testTableModel1
     */
    public function testTableModel1()
    {
        $this->runTestModel1( dirname( __FILE__ ) . '/table/draw-table-model1.php', __FUNCTION__ );
    }


    /**
     * Tests testTableModel2
     */
    public function testTableModel2()
    {
        $this->runTestModel1( dirname( __FILE__ ) . '/table/draw-table-model2.php', __FUNCTION__ );
    }

    /**
     * Tests testTableModel3
     */
    public function testTableModel3()
    {
        $this->runTestModel1( dirname( __FILE__ ) . '/table/draw-table-model3.php', __FUNCTION__ );
    }

    /**
     * Tests testExample1
     */
    public function testDisablePageBreak()
    {
        $this->runTestModelSimple( dirname( __FILE__ ) . '/table/disable-page-break.php', __FUNCTION__ );
    }
}

