<?php

namespace Tests\Unit\EvoSys21\PdfLib;

namespace EvoSys21\PdfLib\Tests\Unit;

use EvoSys21\PdfLib\Tools;
use PHPUnit\Framework\TestCase;

/**
 * Class ToolsTest.
 *
 * @covers \EvoSys21\PdfLib\Tools
 */
class ToolsTest extends TestCase
{
    public function testParseHtmlAttribute(): void
    {
        $this->assertSame([], Tools::parseHtmlAttribute(''));
        $this->assertSame([
            'color' => '#0000BB',
            'font-size' => '20px',
        ], Tools::parseHtmlAttribute('color: #0000BB; font-size: 20px'));
    }

    public function testParseColor(): void
    {
        $this->assertSame([255, 255, 255], Tools::parseColor([255, 255, 255]));
        $this->assertSame([255, 255, 255], Tools::parseColor('255,255,255'));
        $this->assertSame([0, 0, 0], Tools::parseColor('0,0,0'));
        $this->assertSame([255, 255, 255], Tools::parseColor('255,255,255'));
        $this->assertSame([0, 0, 0], Tools::parseColor('rgb(0,0,0)'));
        $this->assertSame([255, 255, 255], Tools::parseColor('rgb(255,255,255)'));
        $this->assertSame([255, 68, 204], Tools::parseColor('#ff44cc'));
        $this->assertSame([255, 68, 204], Tools::parseColor('ff44cc'));
        $this->assertSame([255, 68, 204], Tools::parseColor('#f4c'));
        $this->assertSame([255, 68, 204], Tools::parseColor('f4c'));
        $this->assertSame(['#f4'], Tools::parseColor('#f4'));
        $this->assertSame(['f489'], Tools::parseColor('f489'));
    }

    public function testHex2rgb(): void
    {
        $this->assertSame([255, 68, 204], Tools::hex2rgb('#ff44cc'));
        $this->assertSame([255, 68, 204], Tools::hex2rgb('ff44cc'));
        $this->assertSame([255, 68, 204], Tools::hex2rgb('#f4c'));
        $this->assertSame([255, 68, 204], Tools::hex2rgb('f4c'));
        $this->assertSame(null, Tools::hex2rgb('#f4'));
        $this->assertSame(null, Tools::hex2rgb('f489'));
    }
}
