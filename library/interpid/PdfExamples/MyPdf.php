<?php

/**
 * Custom PDF class extension for Header and Footer Definitions
 *
 * @author office@interpid.eu
 */

namespace Interpid\PdfExamples;

use Interpid\PdfLib\Pdf;
use Interpid\PdfLib\Multicell;

/**
 * Class MyPdf
 *
 * @package Interpid\PdfExamples
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.Superglobals)
 * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class MyPdf extends Pdf
{
    protected $headerSource = "header.txt";

    /**
     * Custom Header
     *
     * @see Pdf::Header()
     */
    public function Header()
    {
        $this->SetY(10);

        /**
         * yes, even here we can use the multicell tag! this will be a local object
         */
        $multicell = Multicell::getInstance($this);

        $multicell->setStyle("p", $this->getDefaultFontName(), "", 6, "160,160,160");
        $multicell->setStyle("h1", $this->getDefaultFontName(), "", 6, "160,160,160");
        $multicell->setStyle("h2", $this->getDefaultFontName(), "", 6, "0,119,220");
        $multicell->setStyle("h4", $this->getDefaultFontName(), "", 6, "0,151,200");

        $multicell->multiCell(100, 3, file_get_contents(PDF_APPLICATION_PATH . '/content/' . $this->headerSource));

        $this->Image(
            PDF_APPLICATION_PATH . '/content/images/interpid_logo.png',
            160,
            10,
            40,
            0,
            '',
            'http://www.interpid.eu'
        );
        $this->SetY($this->tMargin);
    }


    /**
     * Custom Footer
     *
     * @see Pdf::Footer()
     */
    public function Footer()
    {
        $this->SetY(-10);
        $this->SetFont($this->getDefaultFontName(), 'I', 7);
        $this->SetTextColor(170, 170, 170);
        $this->MultiCell(0, 4, "Page {$this->PageNo()} / {nb}", 0, 'C');
    }

    /**
     * Returns the default Font to be used
     *
     * @return string
     */
    public function getDefaultFontName()
    {
        return 'helvetica';
    }

    /**
     * Draws the margin lines.
     * It's helpful during development
     */
    public function drawMarginLines()
    {
        //draw the top and bottom margins
        $ytop = $this->tMargin;
        $ybottom = $this->h - 20;

        $this->SetLineWidth(0.1);
        $this->SetDrawColor(150, 150, 150);
        $this->Line(0, $ytop, $this->w, $ytop);
        $this->Line(0, $ybottom, $this->w, $ybottom);
        $this->Line($this->rMargin, 0, $this->rMargin, $this->h);
        $this->Line($this->w - $this->rMargin, 0, $this->w - $this->rMargin, $this->h);
    }


    /**
     * Disable the Producer and CreationDate. It breaks the functional unit-testing(date always changes)
     * phpcs:disable PSR2.Methods.MethodDeclaration.Underscore
     */
    public function _putinfo()
    {
        if (isset($_SERVER[ 'ENVIRONMENT' ]) && 'test' == $_SERVER[ 'ENVIRONMENT' ]) {
            $this->metadata[ 'Producer' ] = 'FPDF - UNIT-TEST';
            $this->metadata[ 'CreationDate' ] = 'D:' . @date('YmdHis', 1483228800);
            foreach ($this->metadata as $key => $value) {
                $this->_put('/' . $key . ' ' . $this->_textstring($value));
            }
        } else {
            parent::_putinfo();
        }
    }

    /**
     * @param string $headerSource
     * @return $this
     */
    public function setHeaderSource($headerSource)
    {
        $this->headerSource = $headerSource;
        return $this;
    }
}
