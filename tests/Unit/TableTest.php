<?php
namespace evosys21\PdfLib\Tests\Unit;

use evosys21\PdfLib\Table;
use evosys21\PdfLib\Tests\Utils\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class TableTest
 */
class TableTest extends TestCase
{
    public function testSetStyle()
    {
        $pdf = Helper::pdfObject1();
        $table = new Table($pdf);
        $table->setStyle('default', 11, '', '0,0,0', 'helvetica');
        $table->setStyle('p', 12);
        $table->setStyle('b', 12, 'B', '10,10,10', 'arial');

        $multicell = $table->getMulticellInstance();

        $this->assertSame('helvetica', $multicell->getTagFont('p'));
        $this->assertSame('0,0,0', $multicell->getTagColor('p'));
        $this->assertSame('12', $multicell->getTagSize('p'));
        $this->assertSame('', $multicell->getTagFontStyle('p'));

        $this->assertSame('arial', $multicell->getTagFont('b'));
        $this->assertSame('10,10,10', $multicell->getTagColor('b'));
        $this->assertSame('12', $multicell->getTagSize('b'));
        $this->assertSame('B', $multicell->getTagFontStyle('b'));
    }
}

