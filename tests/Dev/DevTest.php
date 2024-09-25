<?php

namespace evosys21\PdfLib\Tests\Dev;

use evosys21\PdfLib\Tests\BaseExamplesTestCase;
use evosys21\PdfLib\Tests\Feature\ProviderTrait;

class DevTest extends BaseExamplesTestCase
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

    public function testDevSources()
    {
        $context = 'Tcpdf';
        $file = 'example-multicell-1-overview.php';

        $source = "examples/$context/example-multicell-1-overview.php";
        global $pdfContext;
        $pdfContext = $context;

        $filename = pathinfo($file, PATHINFO_FILENAME);
        $expected = TEST_PATH . "/_dev/$context/$filename.pdf";

        $this->runTestWithExample($source, $expected);
    }
}
