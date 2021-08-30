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
 * Class MulticellOptions
 * @package Interpid\PdfLib
 */
class MulticellOptions
{
    public $styles = [];
    protected $stylesBackup = null;

    /**
     * The maximum number of lines allowed
     * @var int
     */
    public $maxLines = 0;

    /**
     * The maximum height allowed
     * @var int
     */
    public $maxHeight = 0;

    /**
     * Shrink text to fit
     * @var boolean
     */
    public $shrinkToFit = false;

    /**
     * Font shrink step
     * @var boolean
     */
    public $shrinkFontStep = 1;

    /**
     * Cell Height shrink step
     * @var boolean
     */
    public $shrinkLineHeightStep = 0.5;

    /**
     * Apply options to next cell ONLY
     * @var boolean
     */
    public $applyAll = false;

    /**
     * Contains the line height value for a multicell
     * @var int|float
     */
    public $lineHeight;

    /**
     * @var Pdf
     */
    public $pdf;

    /**
     * @var PdfInterface
     */
    public $pdfi;

    public function __construct($pdfi)
    {
        $this->pdfi = $pdfi;
        $this->pdf = $pdfi->getPdfObject();
        $this->resetCellOptions();
    }

    public function isHeightOverflow($lines, $height)
    {
        $maxLines = $this->maxLines;
        if ($maxLines > 0 && $lines > $maxLines) {
            return true;
        }

        $maxHeight = $this->maxHeight;
        if ($maxHeight > 0 && $height > $maxHeight) {
            return true;
        }
        return false;
    }


    /**
     * Save the TagStyles to a backup variable
     * @return $this
     */
    public function saveStyles()
    {
        $this->stylesBackup = $this->styles;
        return $this;
    }

    /**
     * Restore the used TagStyles from backup
     * @return $this
     */
    public function restoreStyles()
    {
        if ($this->stylesBackup) {
            $this->styles = $this->stylesBackup;
        }
        return $this;
    }

    /**
     * Shrink all font-sizes by the specified step
     *
     * @return $this
     */
    public function shrinkStyleFonts()
    {
        foreach ($this->styles as &$style) {
            if (!isset($style['size'])) {
                continue;
            }
            $style['size'] = $this->shrinkValue($style['size'], $this->shrinkFontStep, 1);
        }
        unset($style);
        return $this;
    }

    /**
     * Shrinks a value by the specified step, but not lower than the $minValue into account
     *
     * @param $value
     * @param $step
     * @param int $minValue
     * @return int|mixed
     */
    public function shrinkValue($value, $step, $minValue = 1)
    {
        $value -= $step;
        if ($value < $minValue) {
            return $minValue;
        }
        return $value;
    }

    /**
     * Save the current settings as a tag default style under the DEFAULT tag name
     *
     * @return void
     */
    public function saveCurrentStyle()
    {
        $this->styles['DEFAULT']['family'] = $this->pdfi->getFontFamily();
        $this->styles['DEFAULT']['style'] = $this->pdfi->getFontStyle();
        $this->styles['DEFAULT']['size'] = $this->pdfi->getFontSizePt();
        $this->styles['DEFAULT']['color'] = PdfInterface::RAW . $this->pdf->TextColor;
    }


    public function resetCellOptions()
    {
        $this->maxHeight = 0;
        $this->maxLines = 0;
        $this->shrinkFontStep = 1;
        $this->shrinkLineHeightStep = 0.5;
        $this->shrinkToFit = false;
        $this->applyAll = false;
    }
}
