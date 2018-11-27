<?php

/**
 * Custom PDF class extension for Header and Footer Definitions
 *
 * @author office@interpid.eu
 *
 */

require_once(__DIR__ . "/Helper.php");

use Interpid\PdfExamples\MyPdf;

class testPdf extends MyPdf
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
