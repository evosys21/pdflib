<?php

/** @noinspection PhpUnused */

namespace EvoSys21\PdfLib;

use EvoSys21\PdfLib\Fpdf\Pdf;
use EvoSys21\PdfLib\Fpdf\PdfInterface;

/**
 * Class MulticellOptions
 */
class MulticellOptions
{
    public $styles = [];
    public $spacers = [];

    public bool $disablePageBreak = false;
    protected $stylesBackup = null;

    /**
     * The maximum number of lines allowed
     *
     * @var int
     */
    public $maxLines = 0;

    /**
     * The maximum height allowed
     *
     * @var int
     */
    public $maxHeight = 0;

    /**
     * Shrink text to fit
     *
     * @var bool
     */
    public $shrinkToFit = false;

    /**
     * Font shrink step
     */
    public int|bool $shrinkFontStep = 1;

    /**
     * Cell Height shrink step
     */
    public bool|float $shrinkLineHeightStep = 0.5;

    /**
     * Apply options to next cell ONLY
     */
    public bool $applyAll = false;

    /**
     * Contains the line height value for a multicell
     */
    public int|float $lineHeight;

    public object $pdf;

    public object $pdfi;

    public function __construct($pdfi)
    {
        $this->pdfi = $pdfi;
        $this->pdf = $pdfi->getPdfObject();
        $this->resetCellOptions();
    }

    public function isHeightOverflow($lines, $height): bool
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
     */
    public function saveStyles(): self
    {
        $this->stylesBackup = $this->styles;

        return $this;
    }

    /**
     * Restore the used TagStyles from backup
     */
    public function restoreStyles(): self
    {
        if ($this->stylesBackup) {
            $this->styles = $this->stylesBackup;
        }

        return $this;
    }

    /**
     * Shrink all font-sizes by the specified step
     */
    public function shrinkStyleFonts(): self
    {
        foreach ($this->styles as &$style) {
            if (! isset($style['size'])) {
                continue;
            }
            $style['size'] = $this->shrinkValue($style['size'], $this->shrinkFontStep);
        }
        unset($style);

        return $this;
    }

    /**
     * Shrinks a value by the specified step, but not lower than the $minValue into account
     *
     * @return int|mixed
     */
    public function shrinkValue($value, $step, int $minValue = 1)
    {
        $value -= $step;
        if ($value < $minValue) {
            return $minValue;
        }

        return $value;
    }

    /**
     * Save the current pdf settings as "current" style
     */
    public function saveCurrentStyle(): self
    {
        // use uppercase - make styling case insensitive
        $current = strtoupper(Multicell::PDF_CURRENT);
        $this->styles[$current]['family'] = $this->pdfi->getFontFamily();
        $this->styles[$current]['style'] = $this->pdfi->getFontStyle();
        $this->styles[$current]['size'] = $this->pdfi->getFontSizePt();
        $this->styles[$current]['color'] = PdfInterface::RAW . $this->pdf->TextColor;

        return $this;
    }

    public function resetCellOptions(): self
    {
        $this->maxHeight = 0;
        $this->maxLines = 0;
        $this->shrinkFontStep = 1;
        $this->shrinkLineHeightStep = 0.5;
        $this->shrinkToFit = false;
        $this->applyAll = false;

        return $this;
    }
}
