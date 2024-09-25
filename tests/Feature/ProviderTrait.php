<?php

namespace evosys21\PdfLib\Tests\Feature;

trait ProviderTrait
{
    public function examplesProvider(): array
    {
        $files = [
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

        $contexts = [
            'Fpdf',
            'Tfpdf',
            'Tcpdf',
        ];

        return $this->provideSamples($files, $contexts);
    }

    public function getDevSources(): array
    {
        $files = [
            'test-multicell-align.php',
            'test-multicell-shrinking.php',
            'test-multicell-shrinking2.php',
            'test-multicell-style.php',
        ];

        $contexts = [
            'Fpdf',
            'Tfpdf',
            'Tcpdf',
        ];

        return $this->provideSamples($files, $contexts);
    }

    protected function provideSamples($files, $contexts): array
    {
        $result = [];

        foreach ($contexts as $context) {
            foreach ($files as $file) {
                $result["$context - $file"] = [$context, $file];
            }
        }

        return $result;
    }
}
