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

namespace evosys21\PdfLib\Tests\Unit;

use evosys21\PdfLib\Multicell;
use evosys21\PdfLib\Tests\Helper\Helper;
use PHPUnit\Framework\TestCase;

/**
 * Class MulticellTest
 */
class MulticellTest extends TestCase
{
    public function testSetStyle()
    {
        $pdf = Helper::pdfObject1();
        $multicell = new Multicell($pdf);
        $multicell->setStyle('default', 11, '', '0,0,0', 'helvetica');
        $multicell->setStyle('p', 12);
        $multicell->setStyle('b', 12, 'B', '10,10,10', 'arial');

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

