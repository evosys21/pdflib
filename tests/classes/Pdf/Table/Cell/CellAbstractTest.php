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

namespace Interpid\PdfLib\Tests\Classes\Pdf\Table\Cell;

use Interpid\PdfLib\PdfInterface;
use Interpid\PdfLib\Tests\BaseTestCase;
use PHPUnit\Framework\Error\Notice;

/**
 * Class CellAbstractTest
 *
 * @package Interpid\PdfLib\Tests\Classes\Pdf\Table\Cell
 */
class CellAbstractTest extends BaseTestCase
{
    public function testConstructor()
    {
        //case 1
        $pdf = $this->getPdfObject();

        $o = new CellAbstractMock($pdf);

        $this->assertInstanceOf(CellAbstractMock::class, $o);

        //case 2
        $pdfi = new PdfInterface($pdf);

        $o = new CellAbstractMock($pdfi);

        $this->assertInstanceOf(CellAbstractMock::class, $o);
    }

    public function testSimpleGettersAndSetters()
    {
        //rowspan/colspan
        $this->doTestPositiveInteger('setColSpan', 'getColSpan');
        $this->doTestPositiveInteger('setRowSpan', 'getRowSpan');

        //backgroundcolor
        $this->doTestColor('setBackgroundColor', 'getBackgroundColor');

        //border
        $this->doTestColor('setBorderColor', 'getBorderColor');
        $this->doTestFloatGT0('setBorderSize', 'getBorderSize');
        $this->doTestAnyValue('setBorderType', 'getBorderType');

        //padding
        $this->doTestFloatGT0('setPaddingTop', 'getPaddingTop');
        $this->doTestFloatGT0('setPaddingRight', 'getPaddingRight');
        $this->doTestFloatGT0('setPaddingBottom', 'getPaddingBottom');
        $this->doTestFloatGT0('setPaddingLeft', 'getPaddingLeft');

        $this->doTestBoolean('setSkipped', 'getSkipped');

        $this->doTestFloatGT0('setContentWidth', 'getContentWidth');
        $this->doTestFloatGT0('setContentHeight', 'getContentHeight');

        $this->doTestFloatGT0('setCellDrawWidth', 'getCellDrawWidth');
        $this->doTestFloatGT0('setCellDrawHeight', 'getCellDrawHeight');

        $this->doTestFloatGT0('setCellWidth', 'getCellWidth');
        $this->doTestFloatGT0('setCellHeight', 'getCellHeight');
    }


//    public function testRowSpan() {
//
//        $this->doTestPositiveInteger( 'setRowSpan', 'getRowSpan' );
//
//    }

    public function testAlignVertical()
    {
        $pdf = $this->getPdfObject();

        $mock = new CellAbstractMock($pdf);

        $mock->setAlignVertical('');
        $this->assertEquals('M', $mock->getAlignVertical());

        $data = ['T', 'B', 'M'];
        foreach ($data as $val) {
            $mock->setAlignVertical($val);
            $this->assertEquals($val, $mock->getAlignVertical());
        }

        $mock->setAlignVertical('X');
        $this->assertEquals('M', $mock->getAlignVertical());
    }

    public function _testSetAlign()
    {
        $pdf = $this->getPdfObject();
        $o = new CellAbstractMock($pdf);
    }

    public function testSetPadding()
    {
        $pdf = $this->getPdfObject();

        $o = new CellAbstractMock($pdf);

        $aValues = array(
            [[0, 0, 0, 0], [0, 0, 0, 0]],
            [[-1, -1, -1, -1], [0, 0, 0, 0]],
            [[1, 1, 1, 1], [1, 1, 1, 1]],
            [[1.123, 1.2321, 1.1234, 1.123412], [1.123, 1.2321, 1.1234, 1.123412]],
            [[-1, 1, -1, 1], [0, 1, 0, 1]],
        );

        foreach ($aValues as $val) {
            list($set, $get) = $val;
            $o->setPadding($set[ 0 ], $set[ 1 ], $set[ 2 ], $set[ 3 ]);
            $this->assertEquals($get[ 0 ], $o->getPaddingTop());
            $this->assertEquals($get[ 1 ], $o->getPaddingRight());
            $this->assertEquals($get[ 2 ], $o->getPaddingBottom());
            $this->assertEquals($get[ 3 ], $o->getPaddingLeft());
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
        $mock = new CellAbstractMock($pdf);
        $mock->setProperties($aProps);
        $this->assertEquals(1, $mock->getColSpan());

        $aProps[ 'COLSPAN' ] = 1;
        $mock = new CellAbstractMock($pdf);
        $mock->setProperties($aProps);
        $this->assertEquals(1, $mock->getColSpan());

        $aProps[ 'COLSPAN' ] = 2;
        $mock = new CellAbstractMock($pdf);
        $mock->setProperties($aProps);
        $this->assertEquals($aProps[ 'COLSPAN' ], $mock->getColSpan());
    }


    public function testSetProperties()
    {
        $pdf = $this->getPdfObject();
        $mock = new CellAbstractMock($pdf);

        $aProps = array(
            'ALIGN' => 'R',
            'VERTICAL_ALIGN' => 'T',
            'COLSPAN' => 5,
            'ROWSPAN' => 6,
            'PADDING' => [1, 2, 3, 4],
            'BORDER_TYPE' => 0,
            'BORDER_SIZE' => 2.5,
            'BORDER_COLOR' => [1, 2, 3],
            'BACKGROUND_COLOR' => [5, 6, 7],
        );

        $mock->setProperties($aProps);
        //$this->assertEquals($aProps['ALIGN'], $o->getAlignVertical())
        $this->assertEquals($aProps[ 'VERTICAL_ALIGN' ], $mock->getAlignVertical());
        $this->assertEquals($aProps[ 'COLSPAN' ], $mock->getColSpan());
        $this->assertEquals($aProps[ 'ROWSPAN' ], $mock->getRowSpan());
        $this->assertEquals($aProps[ 'PADDING' ][ 0 ], $mock->getPaddingTop());
        $this->assertEquals($aProps[ 'PADDING' ][ 1 ], $mock->getPaddingRight());
        $this->assertEquals($aProps[ 'PADDING' ][ 2 ], $mock->getPaddingBottom());
        $this->assertEquals($aProps[ 'PADDING' ][ 3 ], $mock->getPaddingLeft());
        $this->assertEquals($aProps[ 'BORDER_TYPE' ], $mock->getBorderType());
        $this->assertEquals($aProps[ 'BORDER_SIZE' ], $mock->getBorderSize());
        $this->assertEquals($aProps[ 'BORDER_COLOR' ], $mock->getBorderColor());
        $this->assertEquals($aProps[ 'BACKGROUND_COLOR' ], $mock->getBackgroundColor());
    }

    public function testSetInternValue()
    {
        $pdf = $this->getPdfObject();
        $mock = new CellAbstractMock($pdf);
        $mock->setProperties(['someValue' => 1, 'TEST' => 2]);

        $this->assertEquals(1, $mock->getSomeValue());
        $this->assertEquals(2, $mock->TEST);
    }

    public function testSetDefaultValues()
    {
        $pdf = $this->getPdfObject();
        $mock = new CellAbstractMock($pdf);

        $aProps = array(
            'ALIGN' => 'R',
            'VERTICAL_ALIGN' => 'T',
            'COLSPAN' => 5,
            'ROWSPAN' => 6,
            'BACKGROUND_COLOR' => [5, 6, 7],
        );

        $aDefault = array(
            'ALIGN' => 'M',
            'VERTICAL_ALIGN' => 'M',
            'COLSPAN' => 1,
            'ROWSPAN' => 1,
            'PADDING' => [3, 3, 3, 3],
            'BORDER_TYPE' => 1,
            'BORDER_SIZE' => 1,
            'BORDER_COLOR' => [2, 2, 2],
            'BACKGROUND_COLOR' => [3, 3, 3],
        );


        $mock->setProperties($aProps);
        $mock->setDefaultValues($aDefault);

        //$this->assertEquals($aProps['ALIGN'], $o->getAlignVertical())
        $this->assertEquals($aProps[ 'VERTICAL_ALIGN' ], $mock->getAlignVertical());
        $this->assertEquals($aProps[ 'COLSPAN' ], $mock->getColSpan());
        $this->assertEquals($aProps[ 'ROWSPAN' ], $mock->getRowSpan());
        $this->assertEquals($aDefault[ 'PADDING' ][ 1 ], $mock->getPaddingRight());
        $this->assertEquals($aDefault[ 'PADDING' ][ 2 ], $mock->getPaddingBottom());
        $this->assertEquals($aDefault[ 'PADDING' ][ 3 ], $mock->getPaddingLeft());
        $this->assertEquals($aDefault[ 'BORDER_TYPE' ], $mock->getBorderType());
        $this->assertEquals($aDefault[ 'BORDER_SIZE' ], $mock->getBorderSize());
        $this->assertEquals($aDefault[ 'BORDER_COLOR' ], $mock->getBorderColor());
        $this->assertEquals($aProps[ 'BACKGROUND_COLOR' ], $mock->getBackgroundColor());
    }

    public function testCellWidth()
    {
        $pdf = $this->getPdfObject();
        $mock = new CellAbstractMock($pdf);

        $mock->setCellWidth(-1);
        $this->assertEquals(0, $mock->getCellWidth());

        $mock->setCellWidth(0);
        $this->assertEquals(0, $mock->getCellWidth());

        $mock->setCellWidth(10);
        $this->assertEquals(10, $mock->getCellWidth());
    }

    public function testIsPropertySet()
    {
        $pdf = $this->getPdfObject();
        $mock = new CellAbstractMock($pdf);

        $this->assertFalse($mock->isPropertySet('TEST'));

        $mock->TEST = 2;

        $this->assertTrue($mock->isPropertySet('TEST'));

        $this->expectException('PHPUnit\Framework\Error\Notice');
        $this->assertInstanceOf('PHPUnit\Framework\Error\Notice', $mock->TEST2);
    }

    public function testIsPropertySetReturnValue()
    {
        $pdf = $this->getPdfObject();
        $mock = new CellAbstractMock($pdf);

        Notice::$enabled = false;
        $error_level = ini_get('error_reporting');

        error_reporting(0);

        $this->assertEquals(null, $mock->TEST2);

        error_reporting($error_level);
    }


    protected function doTestAnyValue($setter, $getter)
    {
        $pdf = $this->getPdfObject();

        $mock = new CellAbstractMock($pdf);

        $aValues = [-1, 0, 1, 2, '', 'bla', 'test'];
        foreach ($aValues as $val) {
            $mock->$setter($val);
            $this->assertEquals($val, $mock->$getter());
        }
    }

    protected function doTestPositiveInteger($setter, $getter)
    {
        $pdf = $this->getPdfObject();

        $mock = new CellAbstractMock($pdf);

        $mock->$setter(-1);
        $this->assertEquals(1, $mock->$getter());

        $mock->$setter(0);
        $this->assertEquals(1, $mock->$getter());

        $mock->$setter(1);
        $this->assertEquals(1, $mock->$getter());

        $mock->$setter(2);
        $this->assertEquals(2, $mock->$getter());
    }


    public function testRenderCellLayout()
    {
        $pdf = $this->getPdfObject();
        $mock = new CellAbstractMock($pdf);

        $mock->setCellWidth(10);
        $mock->setCellHeight(10);
        $mock->setCellDrawWidth(20);
        $mock->setCellDrawHeight(20);

        $mock->renderCellLayout();

        $filename = tempnam(sys_get_temp_dir(), 'fpdf');

        $pdf->saveToFile($filename);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $this->assertEquals('application/pdf', finfo_file($finfo, $filename));

        unlink($filename);
    }

    public function testCopyProperties()
    {
        $pdf = $this->getPdfObject();
        $mock = new CellAbstractMock($pdf);
        $source = new CellAbstractMock($pdf);

        $aProps = array(
            'ALIGN' => 'R',
            'VERTICAL_ALIGN' => 'T',
            'COLSPAN' => 5,
            'ROWSPAN' => 6,
            'PADDING' => [1, 2, 3, 4],
            'BORDER_TYPE' => 0,
            'BORDER_SIZE' => 2.5,
            'BORDER_COLOR' => [1, 2, 3],
            'BACKGROUND_COLOR' => [5, 6, 7],
        );

        $source->setProperties($aProps);
        $mock->copyProperties($source);

        $this->assertEquals($aProps[ 'VERTICAL_ALIGN' ], $mock->getAlignVertical());
        $this->assertEquals($aProps[ 'COLSPAN' ], $mock->getColSpan());
        $this->assertEquals($aProps[ 'ROWSPAN' ], $mock->getRowSpan());
        $this->assertEquals($aProps[ 'PADDING' ][ 0 ], $mock->getPaddingTop());
        $this->assertEquals($aProps[ 'PADDING' ][ 1 ], $mock->getPaddingRight());
        $this->assertEquals($aProps[ 'PADDING' ][ 2 ], $mock->getPaddingBottom());
        $this->assertEquals($aProps[ 'PADDING' ][ 3 ], $mock->getPaddingLeft());
        $this->assertEquals($aProps[ 'BORDER_TYPE' ], $mock->getBorderType());
        $this->assertEquals($aProps[ 'BORDER_SIZE' ], $mock->getBorderSize());
        $this->assertEquals($aProps[ 'BORDER_COLOR' ], $mock->getBorderColor());
        $this->assertEquals($aProps[ 'BACKGROUND_COLOR' ], $mock->getBackgroundColor());
    }

    public function _testProcessContent()
    {
        $pdf = $this->getPdfObject();
        $mock = new CellAbstractMock($pdf);
        $mock->processContent();
    }


    /**
     * Test float Greater Than 0
     *
     * @param $setter
     * @param $getter
     */
    protected function doTestFloatGT0($setter, $getter)
    {
        $pdf = $this->getPdfObject();

        $mock = new CellAbstractMock($pdf);

        $mock->$setter(-1);
        $this->assertEquals(0, $mock->$getter());

        $mock->$setter(0);
        $this->assertEquals(0, $mock->$getter());

        $mock->$setter(0.1);
        $this->assertEquals(0.1, $mock->$getter());


        $mock->$setter(1);
        $this->assertEquals(1, $mock->$getter());
    }

    /**
     * Test float Greater Than 0
     *
     * @param $setter
     * @param $getter
     */
    protected function doTestBoolean($setter, $getter)
    {
        $pdf = $this->getPdfObject();

        $mock = new CellAbstractMock($pdf);

        $aTrue = [1, 'true', true];
        $aFalse = [0, false, ''];

        foreach ($aTrue as $val) {
            $mock->$setter($val);
            $this->assertEquals(true, $mock->$getter());
        }

        foreach ($aFalse as $val) {
            $mock->$setter($val);
            $this->assertEquals(false, $mock->$getter());
        }
    }

    protected function doTestColor($setter, $getter)
    {
        $pdf = $this->getPdfObject();

        $mock = new CellAbstractMock($pdf);

        $mock->$setter(1, 2, 3);
        $this->assertEquals([1, 2, 3], $mock->$getter());

        $mock->$setter(false);
        $this->assertEquals(false, $mock->$getter());

        $mock->$setter([1, 2, 3]);
        $this->assertEquals([1, 2, 3], $mock->$getter());
    }
}
