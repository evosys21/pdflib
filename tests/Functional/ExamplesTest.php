<?php

namespace evosys21\PdfLib\Tests;

use PHPUnit\Framework\TestCase;

class ExamplesTest extends TestCase
{
    /**
     * @dataProvider exampleProvider
     * @return void
     */
    public function testExamples(string $path): void
    {
        $url = "http://localhost:8070/examples/$path";
        $response = file_get_contents($url);

        $this->assertNotFalse($response, 'Failed to fetch the PDF.');
        $this->assertEquals('%PDF-', substr($response, 0, 5), "Invalid Pdf $url");

    }

    public function exampleProvider()
    {
        $files = [
            'example-multicell.php',
            'example-multicell-1-overview.php',
            'example-multicell-2-overview-page-break.php',
            'example-multicell-3-line-breaking.php',
            'example-multicell-4-page-break.php',
            'example-multicell-5-max-lines.php',
            'example-multicell-6-shrinking.php',
            'example-table-1-overview.php',
            'example-table-2-overview.php',
            'example-table-3-detailed.php',
            'example-table-4-override.php',
            'example-table-5-row-height.php',
        ];

        $dirs = [
            'Fpdf',
            'Tfpdf',
            'Tcpdf',
        ];

        foreach ($dirs as $dir) {
            foreach ($files as $file) {
                yield ["$dir/$file"];
            }
        }
    }
}
