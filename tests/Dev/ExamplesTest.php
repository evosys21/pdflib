<?php

namespace evosys21\PdfLib\Tests\Dev;

use evosys21\PdfLib\Tests\Feature\ProviderTrait;
use PHPUnit\Framework\TestCase;

class ExamplesTest extends TestCase
{

    use ProviderTrait;

    /**
     * @dataProvider examplesProvider
     * @param string $dir
     * @param string $file
     * @return void
     */
    public function testExamples(string $dir, string $file): void
    {
        $url = "http://localhost:8070/examples/$dir/$file";
        echo "Fetching $url\n";
        $response = file_get_contents($url);

        $this->assertNotFalse($response, 'Failed to fetch the PDF.');
        $this->assertEquals('%PDF-', substr($response, 0, 5), "Invalid Pdf $url");

    }
}
