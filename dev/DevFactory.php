<?php

namespace evosys21\PdfLib\Dev;

use evosys21\PdfLib\Multicell;
use evosys21\PdfLib\Table;
use evosys21\PdfLib\Examples\Fpdf\PdfFactory as FpdfFactory;
use evosys21\PdfLib\Examples\Fpdf\PdfSettings as FpdfSettings;
use evosys21\PdfLib\Examples\Tcpdf\PdfFactory as TcpdfFactory;
use evosys21\PdfLib\Examples\Tcpdf\PdfSettings as TcpdfSettings;
use evosys21\PdfLib\Examples\Tfpdf\PdfFactory as TfpdfFactory;
use evosys21\PdfLib\Examples\Tfpdf\PdfSettings as TfpdfSettings;

class DevFactory
{
    protected $context = null;

    public function __construct(?string $context = null)
    {
        $this->context = $context;
        if (empty($this->context)) {
            $this->context = self::getGlobalContext();
        }
        $this->context = strtolower($this->context);
    }

    protected function getGlobalContext()
    {
        global $pdfContext;
        return empty($pdfContext) ? 'fpdf' : $pdfContext;
    }

    protected function getFactory()
    {
        return match ($this->context) {
            'tcpdf' => TcpdfFactory::class,
            'tfpdf' => TfpdfFactory::class,
            default => FpdfFactory::class,
        };
    }

    protected function getSettings()
    {
        return match ($this->context) {
            'tcpdf' => TcpdfSettings::class,
            'tfpdf' => TfpdfSettings::class,
            default => FpdfSettings::class,
        };
    }

    public function multicell(): Multicell
    {

        $factory = self::getFactory();
        $settings = self::getSettings();

        //get the PDF object
        $pdf = $factory::newPdf('multicell', false, false);

        // Create the Advanced Multicell Object and inject the PDF object
        $multicell = new Multicell($pdf);
        $settings::setMulticellStyles($multicell);

        return $multicell;
    }

    public function table(): Table
    {
        $factory = self::getFactory();
        $settings = self::getSettings();

        //get the PDF object
        $pdf = $factory::newPdf('table', false, false);

        $table = new Table($pdf);
        $settings::setTableStyles($table);

        return $table;
    }
}

