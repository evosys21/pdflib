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

namespace Interpid\PdfLib;

/**
 * FPDF extended class.
 *
 * In order to implement the FPDF Add-on, we need access to private/protected properties from
 * the FPDF class. As these are not provided by setters and getters the FPDF class was
 * extended and these properties made public.
 *
 * In all subclasses we refer to Pdf class and not FPDF.
 *
 * @package Interpid\PdfLib
 */
class Pdf extends \FPDF
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
    public $FillColor;
    public $ColorFlag;
    public $AutoPageBreak;
    public $CurOrientation;

    // phpcs:disable
    public function _out($s)
    {
        parent::_out($s);
    }

    public function _parsejpg($file)
    {
        return parent::_parsejpg($file);
    }

    public function _parsegif($file)
    {
        return parent::_parsegif($file);
    }

    public function _parsepng($file)
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
}
