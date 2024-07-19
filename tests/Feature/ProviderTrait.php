<?php

namespace evosys21\PdfLib\Tests\Feature;

use Generator;

trait ProviderTrait
{
    public function examplesProvider(): Generator
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
                yield [$dir, $file];
            }
        }
    }

    public function getDevSources(): Generator
    {
        $sources = array(
            'test-multicell-align.php',
            'test-multicell-shrinking.php',
            'test-multicell-shrinking2.php',
            'test-multicell-style.php',
        );

        foreach ($sources as $source) {
            yield [$source];
        }
    }
}
