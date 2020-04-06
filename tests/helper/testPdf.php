<?php

/**
 * This file is part of the Interpid PDF Addon package.
 *
 * @author Interpid <office@interpid.eu>
 * @copyright (c) Interpid, http://www.interpid.eu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Interpid\PdfLib\Tests\Helper;

use Interpid\PdfExamples\MyPdf;

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
