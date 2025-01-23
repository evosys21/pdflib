<?php

/**
 * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */

namespace EvoSys21\PdfLib\Tests\Utils;

use EvoSys21\PdfLib\Examples\Tfpdf\MyPdf;
use EvoSys21\PdfLib\Fpdf\Pdf;

/**
 * TestPdf Class
 * Used for testing
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
