<?php
namespace evosys21\PdfLib\Tests\Helper;

use evosys21\PdfLib\Fpdf\Pdf;
use evosys21\PdfLib\Examples\Tfpdf\MyPdf;

/**
 * TestPdf Class
 * Used for testing
 *
 * @package Interpid\PdfLib\Tests\Helper
 */
class TestPdf extends MyPdf
{
    /**
     * Custom Header
     *
     * @see Pdf::Header()
     */
    public function Header()
    {
    }

    /**
     * Custom Footer
     *
     * @see Pdf::Footer()
     */
    public function Footer()
    {
        $this->SetY(-10);
        Helper::setFontStyle1($this);
        $this->SetTextColor(170, 170, 170);
        $this->MultiCell(0, 4, "Page {$this->PageNo()} / {nb}", 0, 'C');

        $this->drawMarginLines();
    }
}
