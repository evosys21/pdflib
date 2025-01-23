<?php

namespace EvoSys21\PdfLib;

/**
 * Class MulticellOptions
 */
class MulticellData
{
    /**
     * Contains the line height value for a multicell
     *
     * @var int|float
     */
    public $lineHeight;

    /**
     * Contains the width of the multicell
     *
     * @var int|float
     */
    public $width;

    /**
     * Contains the width of the text (without the paddings)
     *
     * @var int|float
     */
    public $textWidth;

    /**
     * @var string
     */
    public $string = '';

    /**
     * @var string|int
     */
    public $border = 0;

    /**
     * @var string
     */
    public $align = 'J';

    /**
     * @var string|int
     */
    public $fill = 0;

    /**
     * @var int
     */
    public $paddingLeft = 0;

    /**
     * @var int
     */
    public $paddingTop = 0;

    /**
     * @var int
     */
    public $paddingRight = 0;

    /**
     * @var int
     */
    public $paddingBottom = 0;

    public $pdf;

    public function __construct($pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Calculates the text width
     */
    public function initialize(): self
    {
        //if with is == 0
        if (0 == $this->width) {
            $this->width = $this->pdf->w - $this->pdf->rMargin - $this->pdf->x;
        }

        /**
         * If the vertical padding is bigger than the width then we ignore it In this case we put them to 0.
         */
        if (($this->paddingLeft + $this->paddingRight) > $this->width) {
            $this->paddingLeft = 0;
            $this->paddingRight = 0;
        }

        //read width of the text
        $this->textWidth = $this->width - $this->paddingLeft - $this->paddingRight;

        return $this;
    }
}
