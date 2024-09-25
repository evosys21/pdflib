<?php
/** @noinspection PhpUnused */

namespace evosys21\PdfLib\Examples\Tcpdf;

use evosys21\PdfLib\Tcpdf\Pdf;
use evosys21\PdfLib\Multicell;

/**
 * Custom PDF class extension for Header and Footer Definitions
 *
 * @package Interpid\PdfExamples
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.Superglobals)
 * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class MyPdf extends Pdf
{
    protected $headerSource = 'header.txt';
    public $defaultFont = 'helvetica';

    /**
     * Custom Header
     *
     * @see Pdf::Header()
     * @noinspection HttpUrlsUsage
     */
    public function Header()
    {
        if (!$this->showHeader) return;

        $this->SetY(10);

        /**
         * yes, even here we can use the multicell tag! this will be a local object
         */
        $multicell = Multicell::getInstance($this);

        $multicell->setStyle('p', 6, '', '160,160,160', 'helvetica');
        $multicell->setStyle('h1', 6, '', '160,160,160', 'helvetica');
        $multicell->setStyle('h2', 6, '', '0,119,220', 'helvetica');
        $multicell->setStyle('h4', 6, '', '0,151,200', 'helvetica');

        $multicell->multiCell(100, 3, file_get_contents(CONTENT_PATH . '/' . $this->headerSource));

        $width = 25;

        $this->Image(
            CONTENT_PATH . '/images/logo.jpg',
            $this->w - $this->rMargin - $width,
            5,
            $width,
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
        $this->drawMargins && $this->drawMarginLines();

        if (!$this->showFooter) return;

        $this->SetY(-10);
        $this->SetFont('helvetica', 'I', 7);
        $this->SetTextColor(170, 170, 170);
        $this->MultiCell(0, 4, "Page {$this->PageNo()} / {$this->getNumPages()}", 0, 'C');
    }

    /**
     * Returns the default Font to be used
     *
     * @return string
     */
    public function getDefaultFont(): string
    {
        return $this->defaultFont;
    }

    /**
     * Draws the margin lines.
     * It's helpful during development
     */
    public function drawMarginLines(): void
    {
        //draw the top and bottom margins
        $top = $this->tMargin;
        $bottom = $this->h - 20;

        $this->SetLineWidth(0.1);
        $this->SetDrawColor(150, 150, 150);
        $this->Line(0, $top, $this->w, $top);
        $this->Line(0, $bottom, $this->w, $bottom);
        $this->Line($this->rMargin, 0, $this->rMargin, $this->h);
        $this->Line($this->w - $this->rMargin, 0, $this->w - $this->rMargin, $this->h);
    }


    /**
     * Disable the Producer and CreationDate. It breaks the functional unit-testing(date always changes)
     * phpcs:disable PSR2.Methods.MethodDeclaration.Underscore
     */
    public function _putinfo()
    {
        if (static::isTesting()) {
            $this->file_id = '1234567890';
            $this->tcpdf_version = 'x.x.x';

            if (!empty($this->title)) {
                $this->_out('/Title ' . $this->_textstring($this->title));
            }
            if (!empty($this->subject)) {
                $this->_out('/Subject ' . $this->_textstring($this->subject));
            }
            if (!empty($this->author)) {
                $this->_out('/Author ' . $this->_textstring($this->author));
            }
            if (!empty($this->keywords)) {
                $this->_out('/Keywords ' . $this->_textstring($this->keywords));
            }
            if (!empty($this->creator)) {
                $this->_out('/Creator ' . $this->_textstring($this->creator));
            }
            return parent::_putinfo();
        } else {
            return parent::_putinfo();
        }
    }

    protected function _textstring($s, $n = 0)
    {
        $s = static::_testReplace($s);
        return parent::_textstring($s, $n);
    }

    /**
     * Static function to replace the TCPDF version in the unit-testing.
     *
     * @param $s
     * @return string|string[]|null
     */
    protected static function _testReplace($s)
    {
        if (static::isTesting()) {
            $s = preg_replace("/TCPDF \d+\.\d+\.\d+ /", 'TCPDF x.x.x ', $s);
        }
        return $s;
    }

    /**
     * @param $s
     * @return int|void
     */
    public function _out($s)
    {
        if (static::isTesting()) {
            $s = static::_testReplace($s);
            parent::_out($s);
        } else {
            parent::_out($s);
        }
    }

    protected static function isTesting(): bool
    {
        return (getenv('APP_ENV') === 'testing');
    }

    /**
     * @param string $headerSource
     * @return $this
     */
    public function setHeaderSource(string $headerSource): self
    {
        $this->headerSource = $headerSource;
        return $this;
    }
}
