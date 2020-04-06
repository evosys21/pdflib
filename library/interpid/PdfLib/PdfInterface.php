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
 * Pdf Class Interface
 *
 * @package Interpid\PdfLib
 */
class PdfInterface
{

    /**
     * Pointer to the pdf object
     *
     * @var Pdf
     */
    protected $pdf;


    public function __construct($pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Returns the PDF object of the Interface
     *
     * @return Pdf
     */
    public function getPdfObject()
    {
        return $this->pdf;
    }


    /**
     * Returns the page width
     */
    public function getPageWidth()
    {
        return (int)$this->pdf->w - $this->pdf->rMargin - $this->pdf->lMargin;
    }


    /**
     * Returns the current X position
     *
     * @return number
     */
    public function getX()
    {
        return $this->pdf->GetX();
    }


    /**
     * Returns the remaining width to the end of the current line
     *
     * @return number The remaining width
     */
    public function getRemainingWidth()
    {
        $n = $this->getPageWidth() - $this->getX();

        if ($n < 0) {
            $n = 0;
        }

        return $n;
    }


    /**
     * Split string into array of equivalent codes and return the result array
     *
     * @param string $str The input string
     * @return array List of codes
     */
    public function stringToArray($str)
    {
        // split string into array of equivalent codes
        $aResult = [];
        $strlen = strlen($str);
        for ($i = 0; $i < $strlen; $i++) {
            $aResult[] = ord($str[ $i ]);
        }

        return $aResult;
    }


    /**
     * Returns the active font family
     *
     * @return string The font family
     */
    public function getFontFamily()
    {
        return $this->pdf->FontFamily;
    }


    /**
     * Returns the active font style
     *
     * @return string the font style
     */
    public function getFontStyle()
    {
        return $this->pdf->FontStyle;
    }


    /**
     * Returns the active font size in PT
     *
     * @return number The font size
     */
    public function getFontSizePt()
    {
        return $this->pdf->FontSizePt;
    }


    /**
     * Adds an image to the pdf document
     *
     * @param string $file File Path
     * @param number $x
     * @param number $y
     * @param int $w Width
     * @param int $h Height
     * @param string $type Type
     * @param string $link Link
     */
    public function Image($file, $x = null, $y = null, $w = 0, $h = 0, $type = '', $link = '')
    {
        $this->pdf->Image($file, $x, $y, $w, $h, $type, $link);
    }


    /**
     * Returns the image width and height in PDF values!
     *
     * @param string $file Image file
     * @param int|number $w
     * @param int|number $h
     * @return array(width, height)
     */
    public function getImageParams($file, $w = 0, $h = 0)
    {
        // Put an image on the page
        if (!isset($this->pdf->images[ $file ])) {
            $pos = strrpos($file, '.');
            $type = substr($file, $pos + 1);
            $type = strtolower($type);
            if ($type == 'jpeg') {
                $type = 'jpg';
            }
            $mtd = '_parse' . $type;
            if (!method_exists($this->pdf, $mtd)) {
                $this->pdf->Error('Unsupported image type: ' . $type);
            }
            $info = $this->pdf->$mtd($file);
            $info[ 'i' ] = count($this->pdf->images) + 1;
            $this->pdf->images[ $file ] = $info;
        } else {
            $info = $this->pdf->images[ $file ];
        }

        // Automatic width and height calculation if needed
        if ($w == 0 && $h == 0) {
            // Put image at 96 dpi
            $w = -96;
            $h = -96;
        }
        if ($w < 0) {
            $w = -$info[ 'w' ] * 72 / $w / $this->pdf->k;
        }
        if ($h < 0) {
            $h = -$info[ 'h' ] * 72 / $h / $this->pdf->k;
        }
        if ($w == 0) {
            $w = $h * $info[ 'w' ] / $info[ 'h' ];
        }
        if ($h == 0) {
            $h = $w * $info[ 'h' ] / $info[ 'w' ];
        }

        return array(
            $w,
            $h
        );
    }

    /**
     * Wrapper for the cell function
     * @param $w
     * @param int $h
     * @param string $txt
     * @param int $border
     * @param int $ln
     * @param string $align
     * @param bool $fill
     * @param string $link
     */
    public function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->pdf->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
    }
}
