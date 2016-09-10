<?php
/**
 * Class Pdf_Table_Cell_AbstractTest
 */


require_once 'AbstractMock.php';

class Pdf_Table_Cell_AbstractTest extends BaseTestCase
{

    public function testConstructor()
    {
        //case 1
        $pdf = $this->getPdfObject();

        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $this->assertInstanceOf( 'Pdf_Table_Cell_AbstractMock', $o );

        //case 2
        $pdfi = new Pdf_Interface( $pdf );

        $o = new Pdf_Table_Cell_AbstractMock( $pdfi );

        $this->assertInstanceOf( 'Pdf_Table_Cell_AbstractMock', $o );
    }

    public function testSimpleGettersAndSetters()
    {
        //rowspan/colspan
        $this->doTestPositiveInteger( 'setColSpan', 'getColSpan' );
        $this->doTestPositiveInteger( 'setRowSpan', 'getRowSpan' );

        //backgroundcolor
        $this->doTestColor( 'setBackgroundColor', 'getBackgroundColor' );

        //border
        $this->doTestColor( 'setBorderColor', 'getBorderColor' );
        $this->doTestFloatGT0( 'setBorderSize', 'getBorderSize' );
        $this->doTestAnyValue( 'setBorderType', 'getBorderType' );

        //padding
        $this->doTestFloatGT0( 'setPaddingTop', 'getPaddingTop' );
        $this->doTestFloatGT0( 'setPaddingRight', 'getPaddingRight' );
        $this->doTestFloatGT0( 'setPaddingBottom', 'getPaddingBottom' );
        $this->doTestFloatGT0( 'setPaddingLeft', 'getPaddingLeft' );

        $this->doTestBoolean( 'setSkipped', 'getSkipped' );

        $this->doTestFloatGT0( 'setContentWidth', 'getContentWidth' );
        $this->doTestFloatGT0( 'setContentHeight', 'getContentHeight' );

        $this->doTestFloatGT0( 'setCellDrawWidth', 'getCellDrawWidth' );
        $this->doTestFloatGT0( 'setCellDrawHeight', 'getCellDrawHeight' );

        $this->doTestFloatGT0( 'setCellWidth', 'getCellWidth' );
        $this->doTestFloatGT0( 'setCellHeight', 'getCellHeight' );
    }


//    public function testRowSpan() {
//
//        $this->doTestPositiveInteger( 'setRowSpan', 'getRowSpan' );
//
//    }

    public function testAlignVertical()
    {
        $pdf = $this->getPdfObject();

        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $o->setAlignVertical( '' );
        $this->assertEquals( 'M', $o->getAlignVertical() );

        $a = array( 'T', 'B', 'M' );
        foreach ( $a as $val )
        {
            $o->setAlignVertical( $val );
            $this->assertEquals( $val, $o->getAlignVertical() );
        }

        $o->setAlignVertical( 'X' );
        $this->assertEquals( 'M', $o->getAlignVertical() );
    }

    public function testSetAlign()
    {
        $pdf = $this->getPdfObject();

        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $o->setAlign( '' );
    }

    public function testSetPadding()
    {
        $pdf = $this->getPdfObject();

        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $aValues = array(
            array( array( 0, 0, 0, 0 ), array( 0, 0, 0, 0 ) ),
            array( array( -1, -1, -1, -1 ), array( 0, 0, 0, 0 ) ),
            array( array( 1, 1, 1, 1 ), array( 1, 1, 1, 1 ) ),
            array( array( 1.123, 1.2321, 1.1234, 1.123412 ), array( 1.123, 1.2321, 1.1234, 1.123412 ) ),
            array( array( -1, 1, -1, 1 ), array( 0, 1, 0, 1 ) ),
        );

        foreach ( $aValues as $val )
        {
            list( $set, $get ) = $val;
            $o->setPadding( $set[ 0 ], $set[ 1 ], $set[ 2 ], $set[ 3 ] );
            $this->assertEquals( $get[ 0 ], $o->getPaddingTop() );
            $this->assertEquals( $get[ 1 ], $o->getPaddingRight() );
            $this->assertEquals( $get[ 2 ], $o->getPaddingBottom() );
            $this->assertEquals( $get[ 3 ], $o->getPaddingLeft() );
        }
    }


//    public function testBackgroundColor() {
//
//        $this->doTestColor( 'setBackgroundColor', 'getBackgroundColor' );
//
//    }
//
//    public function testBorderColor() {
//
//        $this->doTestColor( 'setBorderColor', 'getBorderColor' );
//
//    }
//
//    public function testBorderSize() {
//
//        $this->doTestFloatGT0( 'setBorderSize', 'getBorderSize' );
//
//    }
//
//    public function testBorderType() {
//
//        $this->doTestAnyValue( 'setBorderType', 'getBorderType' );
//
//    }


    public function testSetColSpan1()
    {
        $pdf = $this->getPdfObject();

        $aProps[ 'COLSPAN' ] = 0;
        $o = new Pdf_Table_Cell_AbstractMock( $pdf );
        $o->setProperties( $aProps );
        $this->assertEquals( 1, $o->getColSpan() );

        $aProps[ 'COLSPAN' ] = 1;
        $o = new Pdf_Table_Cell_AbstractMock( $pdf );
        $o->setProperties( $aProps );
        $this->assertEquals( 1, $o->getColSpan() );

        $aProps[ 'COLSPAN' ] = 2;
        $o = new Pdf_Table_Cell_AbstractMock( $pdf );
        $o->setProperties( $aProps );
        $this->assertEquals( $aProps[ 'COLSPAN' ], $o->getColSpan() );
    }


    public function testSetProperties()
    {
        $pdf = $this->getPdfObject();
        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $aProps = array(
            'ALIGN' => 'R',
            'VERTICAL_ALIGN' => 'T',
            'COLSPAN' => 5,
            'ROWSPAN' => 6,
            'PADDING' => array( 1, 2, 3, 4 ),
            'BORDER_TYPE' => 0,
            'BORDER_SIZE' => 2.5,
            'BORDER_COLOR' => array( 1, 2, 3 ),
            'BACKGROUND_COLOR' => array( 5, 6, 7 ),
        );

        $o->setProperties( $aProps );
        //$this->assertEquals($aProps['ALIGN'], $o->getAlignVertical())
        $this->assertEquals( $aProps[ 'VERTICAL_ALIGN' ], $o->getAlignVertical() );
        $this->assertEquals( $aProps[ 'COLSPAN' ], $o->getColSpan() );
        $this->assertEquals( $aProps[ 'ROWSPAN' ], $o->getRowSpan() );
        $this->assertEquals( $aProps[ 'PADDING' ][ 0 ], $o->getPaddingTop() );
        $this->assertEquals( $aProps[ 'PADDING' ][ 1 ], $o->getPaddingRight() );
        $this->assertEquals( $aProps[ 'PADDING' ][ 2 ], $o->getPaddingBottom() );
        $this->assertEquals( $aProps[ 'PADDING' ][ 3 ], $o->getPaddingLeft() );
        $this->assertEquals( $aProps[ 'BORDER_TYPE' ], $o->getBorderType() );
        $this->assertEquals( $aProps[ 'BORDER_SIZE' ], $o->getBorderSize() );
        $this->assertEquals( $aProps[ 'BORDER_COLOR' ], $o->getBorderColor() );
        $this->assertEquals( $aProps[ 'BACKGROUND_COLOR' ], $o->getBackgroundColor() );
    }

    public function testSetInternValue()
    {
        $pdf = $this->getPdfObject();
        $o = new Pdf_Table_Cell_AbstractMock( $pdf );
        $o->setProperties( array( 'someValue' => 1, 'TEST' => 2 ) );

        $this->assertEquals( 1, $o->getSomeValue() );
        $this->assertEquals( 2, $o->TEST );
    }

    public function testSetDefaultValues()
    {
        $pdf = $this->getPdfObject();
        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $aProps = array(
            'ALIGN' => 'R',
            'VERTICAL_ALIGN' => 'T',
            'COLSPAN' => 5,
            'ROWSPAN' => 6,
            'BACKGROUND_COLOR' => array( 5, 6, 7 ),
        );

        $aDefault = array(
            'ALIGN' => 'M',
            'VERTICAL_ALIGN' => 'M',
            'COLSPAN' => 1,
            'ROWSPAN' => 1,
            'PADDING' => array( 3, 3, 3, 3 ),
            'BORDER_TYPE' => 1,
            'BORDER_SIZE' => 1,
            'BORDER_COLOR' => array( 2, 2, 2 ),
            'BACKGROUND_COLOR' => array( 3, 3, 3 ),
        );


        $o->setProperties( $aProps );
        $o->setDefaultValues( $aDefault );

        //$this->assertEquals($aProps['ALIGN'], $o->getAlignVertical())
        $this->assertEquals( $aProps[ 'VERTICAL_ALIGN' ], $o->getAlignVertical() );
        $this->assertEquals( $aProps[ 'COLSPAN' ], $o->getColSpan() );
        $this->assertEquals( $aProps[ 'ROWSPAN' ], $o->getRowSpan() );
        $this->assertEquals( $aDefault[ 'PADDING' ][ 1 ], $o->getPaddingRight() );
        $this->assertEquals( $aDefault[ 'PADDING' ][ 2 ], $o->getPaddingBottom() );
        $this->assertEquals( $aDefault[ 'PADDING' ][ 3 ], $o->getPaddingLeft() );
        $this->assertEquals( $aDefault[ 'BORDER_TYPE' ], $o->getBorderType() );
        $this->assertEquals( $aDefault[ 'BORDER_SIZE' ], $o->getBorderSize() );
        $this->assertEquals( $aDefault[ 'BORDER_COLOR' ], $o->getBorderColor() );
        $this->assertEquals( $aProps[ 'BACKGROUND_COLOR' ], $o->getBackgroundColor() );
    }

    public function testCellWidth()
    {
        $pdf = $this->getPdfObject();
        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $o->setCellWidth( -1 );
        $this->assertEquals( 0, $o->getCellWidth() );

        $o->setCellWidth( 0 );
        $this->assertEquals( 0, $o->getCellWidth() );

        $o->setCellWidth( 10 );
        $this->assertEquals( 10, $o->getCellWidth() );
    }

    public function testIsPropertySet()
    {
        $pdf = $this->getPdfObject();
        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $this->assertFalse( $o->isPropertySet( 'TEST' ) );

        $o->TEST = 2;

        $this->assertTrue( $o->isPropertySet( 'TEST' ) );

        $this->setExpectedException( 'PHPUnit_Framework_Error_Notice' );
        $this->assertInstanceOf( 'PHPUnit_Framework_Error_Notice', $o->TEST2 );
    }

    public function testIsPropertySetReturnValue()
    {
        $pdf = $this->getPdfObject();
        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        PHPUnit_Framework_Error_Notice::$enabled = false;
        $error_level = ini_get( 'error_reporting' );

        error_reporting( 0 );

        $this->assertEquals( null, $o->TEST2 );

        error_reporting( $error_level );
    }


    protected function doTestAnyValue( $setter, $getter )
    {
        $pdf = $this->getPdfObject();

        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $aValues = array( -1, 0, 1, 2, '', 'bla', 'test' );
        foreach ( $aValues as $val )
        {
            $o->$setter( $val );
            $this->assertEquals( $val, $o->$getter() );
        }
    }

    protected function doTestPositiveInteger( $setter, $getter )
    {
        $pdf = $this->getPdfObject();

        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $o->$setter( -1 );
        $this->assertEquals( 1, $o->$getter() );

        $o->$setter( 0 );
        $this->assertEquals( 1, $o->$getter() );

        $o->$setter( 1 );
        $this->assertEquals( 1, $o->$getter() );

        $o->$setter( 2 );
        $this->assertEquals( 2, $o->$getter() );
    }


    public function testRenderCellLayout()
    {
        $pdf = $this->getPdfObject();
        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $o->setCellWidth( 10 );
        $o->setCellHeight( 10 );
        $o->setCellDrawWidth( 20 );
        $o->setCellDrawHeight( 20 );

        $o->renderCellLayout();

        $filename = tempnam( sys_get_temp_dir(), 'fpdf' );

        $pdf->Output( "F", $filename );

        $finfo = finfo_open( FILEINFO_MIME_TYPE );

        $this->assertEquals( 'application/pdf', finfo_file( $finfo, $filename ) );

        unlink( $filename );
    }

    public function testCopyProperties()
    {
        $pdf = $this->getPdfObject();
        $o = new Pdf_Table_Cell_AbstractMock( $pdf );
        $source = new Pdf_Table_Cell_AbstractMock( $pdf );

        $aProps = array(
            'ALIGN' => 'R',
            'VERTICAL_ALIGN' => 'T',
            'COLSPAN' => 5,
            'ROWSPAN' => 6,
            'PADDING' => array( 1, 2, 3, 4 ),
            'BORDER_TYPE' => 0,
            'BORDER_SIZE' => 2.5,
            'BORDER_COLOR' => array( 1, 2, 3 ),
            'BACKGROUND_COLOR' => array( 5, 6, 7 ),
        );

        $source->setProperties( $aProps );
        $o->copyProperties( $source );

        $this->assertEquals( $aProps[ 'VERTICAL_ALIGN' ], $o->getAlignVertical() );
        $this->assertEquals( $aProps[ 'COLSPAN' ], $o->getColSpan() );
        $this->assertEquals( $aProps[ 'ROWSPAN' ], $o->getRowSpan() );
        $this->assertEquals( $aProps[ 'PADDING' ][ 0 ], $o->getPaddingTop() );
        $this->assertEquals( $aProps[ 'PADDING' ][ 1 ], $o->getPaddingRight() );
        $this->assertEquals( $aProps[ 'PADDING' ][ 2 ], $o->getPaddingBottom() );
        $this->assertEquals( $aProps[ 'PADDING' ][ 3 ], $o->getPaddingLeft() );
        $this->assertEquals( $aProps[ 'BORDER_TYPE' ], $o->getBorderType() );
        $this->assertEquals( $aProps[ 'BORDER_SIZE' ], $o->getBorderSize() );
        $this->assertEquals( $aProps[ 'BORDER_COLOR' ], $o->getBorderColor() );
        $this->assertEquals( $aProps[ 'BACKGROUND_COLOR' ], $o->getBackgroundColor() );
    }

    public function testProcessContent()
    {
        $pdf = $this->getPdfObject();
        $o = new Pdf_Table_Cell_AbstractMock( $pdf );
        $o->processContent();
    }


    /**
     * Test float Greater Than 0
     *
     * @param $setter
     * @param $getter
     */
    protected function doTestFloatGT0( $setter, $getter )
    {
        $pdf = $this->getPdfObject();

        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $o->$setter( -1 );
        $this->assertEquals( 0, $o->$getter() );

        $o->$setter( 0 );
        $this->assertEquals( 0, $o->$getter() );

        $o->$setter( 0.1 );
        $this->assertEquals( 0.1, $o->$getter() );


        $o->$setter( 1 );
        $this->assertEquals( 1, $o->$getter() );
    }

    /**
     * Test float Greater Than 0
     *
     * @param $setter
     * @param $getter
     */
    protected function doTestBoolean( $setter, $getter )
    {
        $pdf = $this->getPdfObject();

        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $aTrue = array( 1, "true", true );
        $aFalse = array( 0, false, '' );

        foreach ( $aTrue as $val )
        {
            $o->$setter( $val );
            $this->assertEquals( true, $o->$getter() );
        }

        foreach ( $aFalse as $val )
        {
            $o->$setter( $val );
            $this->assertEquals( false, $o->$getter() );
        }
    }

    protected function doTestColor( $setter, $getter )
    {
        $pdf = $this->getPdfObject();

        $o = new Pdf_Table_Cell_AbstractMock( $pdf );

        $o->$setter( 1, 2, 3 );
        $this->assertEquals( array( 1, 2, 3 ), $o->$getter() );

        $o->$setter( false );
        $this->assertEquals( false, $o->$getter() );

        $o->$setter( array( 1, 2, 3 ) );
        $this->assertEquals( array( 1, 2, 3 ), $o->$getter() );
    }
}
 