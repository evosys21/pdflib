<?php
/** @noinspection SpellCheckingInspection */

namespace evosys21\PdfLib\Tcpdf;

use TCPDF;

/**
 * TCPDF extended class.
 *
 * In order to implement the TCPDF Add-on, we need access to private/protected properties from
 * the TCPDF class. As these are not provided by setters and getters the TCPDF class was
 * extended and these properties made public.
 *
 * In all subclasses we refer to Pdf class and not TCPDF.
 *
 * @package Interpid\PdfLib
 */
class Pdf extends TCPDF
{
    public $images;
    public $w;
    public $tMargin;
    public $bMargin;
    public $lMargin;
    public $rMargin;
    public $k;
    public $h;
    public $x;
    public $y;
    public $ws;
    public $FontFamily;
    public $FontStyle;
    public $FontSize;
    public $FontSizePt;
    public $CurrentFont;
    public $TextColor;
    public $DrawColor;
    public $LineWidth;
    public $FillColor;
    public $ColorFlag;
    public $AutoPageBreak;
    public $CurOrientation;
    public $encoding;
    public $isunicode;
    public $doc_creation_timestamp;
    public $doc_modification_timestamp;
    public $file_id;
    public $tcpdf_version;
    public $svgunit;



    public bool $showHeader = true;
    public bool $showFooter = true;
    
    // phpcs:disable
    public function _out($s)
    {
        return parent::_out($s);
    }

    // phpcs:enable

    public function getCellCode(
        $w,
        $h = 0,
        $txt = '',
        $border = 0,
        $ln = 0,
        $align = '',
        $fill = false,
        $link = '',
        $stretch = 0,
        $ignore_min_height = false,
        $hAlign = 'T',
        $vAlign = 'M'
    ) {
        return parent::getCellCode(
            $w,
            $h,
            $txt,
            $border,
            $ln,
            $align,
            $fill,
            $link,
            $stretch,
            $ignore_min_height,
            $hAlign,
            $vAlign
        );
    }

    public function saveToFile($fileName)
    {
        $this->Output($fileName, 'F');
    }
}
