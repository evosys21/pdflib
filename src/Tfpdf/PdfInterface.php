<?php

/** @noinspection PhpUnused */

/** @noinspection PhpMissingParamTypeInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpDocMissingThrowsInspection */
//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace EvoSys21\PdfLib\Tfpdf;

use EvoSys21\PdfLib\AbstractPdfUtils;
use EvoSys21\PdfLib\PdfInterfaceDef;
use EvoSys21\PdfLib\Tools;

/**
 * Pdf Class Interface
 *
 */
class PdfInterface extends AbstractPdfUtils implements PdfInterfaceDef
{
    public const RAW = '__RAW__';

    /**
     * Pointer to the pdf object
     *
     * @var Pdf
     */
    protected $pdf;

    protected $backupDrawColor;
    public $textColor;


    public function __construct($pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Returns the PDF object of the Interface
     *
     * @return Pdf
     */
    public function getPdfObject(): Pdf
    {
        return $this->pdf;
    }


    /**
     * Returns the page width
     */
    public function getPageWidth(): int
    {
        return (int)$this->pdf->w - $this->pdf->rMargin - $this->pdf->lMargin;
    }


    /**
     * Returns the current X position
     *
     * @return int|float
     */
    public function getX()
    {
        return $this->pdf->GetX();
    }


    /**
     * Returns the remaining width to the end of the current line
     *
     * @return int|float The remaining width
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
    public function stringToArray(string $str): array
    {
        return $this->pdf->UTF8StringToArray($str);
    }


    /**
     * Returns the active font family
     *
     * @return string The font family
     */
    public function getFontFamily(): string
    {
        return $this->pdf->FontFamily;
    }


    /**
     * Returns the active font style
     *
     * @return string the font style
     */
    public function getFontStyle(): string
    {
        return $this->pdf->FontStyle;
    }


    /**
     * Returns the active font size in PT
     *
     * @return int|float The font size
     */
    public function getFontSizePt()
    {
        return $this->pdf->FontSizePt;
    }


    /**
     * Adds an image to the pdf document
     *
     * @param string $file File Path
     * @param int|float $x
     * @param int|float $y
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
     * @param int $w
     * @param int $h
     * @return array(width, height)
     */
    public function getImageParams($file, $w = 0, $h = 0): array
    {
        $h = floatval($h);
        $w = floatval($w);

        // Put an image on the page
        if (!isset($this->pdf->images[$file])) {
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
            $info['i'] = count($this->pdf->images) + 1;
            $this->pdf->images[$file] = $info;
        } else {
            $info = $this->pdf->images[$file];
        }

        // Automatic width and height calculation if needed
        if ($w == 0 && $h == 0) {
            // Put image at 96 dpi
            $w = -96;
            $h = -96;
        }
        if ($w < 0) {
            $w = -$info['w'] * 72 / $w / $this->pdf->k;
        }
        if ($h < 0) {
            $h = -$info['h'] * 72 / $h / $this->pdf->k;
        }
        if ($w == 0) {
            $w = $h * $info['w'] / $info['h'];
        }
        if ($h == 0) {
            $h = $w * $info['h'] / $info['w'];
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

    /**
     * Sets the PDF TextColor
     *
     * @param $color
     * @return $this
     */
    public function setTextColor($color): self
    {
        $this->textColor = $color;

        if (is_string($color) && strpos($color, self::RAW) === 0) {
            $this->pdf->TextColor = substr($color, strlen(self::RAW));
            $this->pdf->ColorFlag = ($this->pdf->FillColor != $this->pdf->TextColor);
            return $this;
        }
        $colorData = Tools::parseColor($color);
        call_user_func_array([$this->pdf, 'SetTextColor'], $colorData);
        return $this;
    }

    /**
     * Sets the PDF DrawColor
     *
     * @param $color
     * @return $this
     */
    public function setDrawColor($color): self
    {
        $this->backupDrawColor = $this->pdf->DrawColor;
        if (is_string($color) && strpos($color, self::RAW) === 0) {
            $this->pdf->DrawColor = substr($color, strlen(self::RAW));
            return $this;
        }
        $colorData = Tools::parseColor($color);
        call_user_func_array([$this->pdf, 'SetDrawColor'], $colorData);
        return $this;
    }

    /**
     * Restores the DrawColor from the backup
     * @return $this
     */
    public function restoreDrawColor(): self
    {
        if ($this->backupDrawColor) {
            $this->pdf->DrawColor = $this->backupDrawColor;
            $this->pdf->_out($this->pdf->DrawColor);
        }
        return $this;
    }

    public function getEncoding(): string
    {
        return 'utf-8';
    }

    /**
     * Set the Internal Encoding to used in PDF Class.
     */
    public function setEncoding()
    {
        mb_internal_encoding($this->getEncoding());
    }

    /**
     * Returns the Available Width to draw the Text.
     *
     * @param string $str
     * @param int $start
     * @param int|float|null $length
     * @return string
     */
    public function substr(string $str, int $start, $length = null): string
    {
        if (null === $length) {
            return mb_substr($str, $start);
        } else {
            return mb_substr($str, $start, $length);
        }
    }


    public function strlen(string $s): int
    {
        return mb_strlen($s);
    }

    public function getCharStringWidth($tag, $char, $fontFamily, $fontStyle, $fontSize)
    {
        $fontInfo = &$this->fontInfo[$tag]; //font info array
        $cw = &$fontInfo['CurrentFont']['cw']; //character widths
        $w = 0;

        if (isset($fontInfo['unifontSubset'])) {
            if (isset($cw[$char]) && isset($cw[2 * $char]) && isset($cw[2 * $char + 1])) {
                $w += (ord($cw[2 * $char]) << 8) + ord($cw[2 * $char + 1]);
            } else {
                if ($char > 0 && $char < 128 && isset($cw[chr($char)])) {
                    $w += $cw[chr($char)];
                } else {
                    $w += $this->CurrentFont['desc']['MissingWidth'] ?? $this->CurrentFont['MissingWidth'] ?? 500;
                }
            }
        } else {
            $w += $cw[chr($char)];
        }

        return ($w * $fontInfo['FontSize']) / 1000;
    }
}
