<?php

/** @noinspection SpellCheckingInspection */

namespace EvoSys21\PdfLib\Tfpdf;

use tFPDF;

/**
 * tFPDF extended class.
 *
 * In order to implement the tFPDF Add-on, we need access to private/protected properties from
 * the tFPDF class. As these are not provided by setters and getters the tFPDF class was
 * extended and these properties made public.
 *
 * In all subclasses we refer to Pdf class and not tFPDF.
 *
 */
class Pdf extends tFPDF
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

    public $showHeader = true;
    public $showFooter = true;
    public bool $drawMargins = false;

    public $unifontSubset;

    // phpcs:disable
    public function _out($s)
    {
        parent::_out($s);
    }

    public function _parsejpg($file): array
    {
        return parent::_parsejpg($file);
    }

    public function _parsegif($file): array
    {
        return parent::_parsegif($file);
    }

    public function _parsepng($file): array
    {
        return parent::_parsepng($file);
    }
    // phpcs:enable

    //phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        /**
         * AB 10.09.2016 - for "some" reason(haven't investigated) the TXT breaks the cell
         */
        $txt = strval($txt);
        parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
    }

    // phpcs:enable

    public function saveToFile($fileName)
    {
        $this->Output("F", $fileName);
    }

    public function UTF8StringToArray($str)
    {
        return parent::UTF8StringToArray($str);
    }

    public function getRTL(): bool
    {
        return false;
    }
}
