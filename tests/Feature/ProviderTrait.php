<?php

namespace EvoSys21\PdfLib\Tests\Feature;

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

    public function codeSnippetsProvider(): array
    {
        $files = [
            APP_PATH . '/dev/table/draw-table-model1.php',
            APP_PATH . '/dev/table/draw-table-model2.php',
            APP_PATH . '/dev/table/draw-table-model3.php',
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
                $name = str_replace(APP_PATH, '', $file);
                $result["$context - $name"] = [$context, $file];
            }
        }

        return $result;
    }
}
