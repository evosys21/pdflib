<?php

/** @noinspection PhpUnused */

namespace EvoSys21\PdfLib\Table\Cell;

use EvoSys21\PdfLib\Fpdf\Pdf;
use EvoSys21\PdfLib\Fpdf\PdfInterface;

/**
 * Pdf Table Cell Interface\Table\Cell
 */
interface CellInterface
{
    /**
     * Class constructor
     *
     * @param PdfInterface|Pdf $pdf
     */
    public function __construct($pdf);

    /**
     * Returns true of the cell is splittable
     */
    public function isSplittable();

    /**
     * Splits the current cell
     *
     * @param number $rowHeight - the Height of the row that contains this cell
     * @param number $maxHeight - the Max height available
     * @return array(oNewCell, iSplitHeight)
     */
    public function split($rowHeight, $maxHeight): array;

    /**
     * Set the default values
     */
    public function setDefaultValues(array $values = []): self;

    /**
     * Process the cell content
     * This method is called when all the properties/values are set and the cell content can be processed.
     *
     * After the execution of this method it is expected that the cell height/width are all calculated
     */
    public function processContent();

    /**
     * Set the properties of the cell
     *
     * @param array $values key=>value pair
     */
    public function setProperties(array $values = []): self;

    public function render();

    /**
     * Returns the colspan value
     */
    public function getColSpan(): int;

    /**
     * Sets the colspan value
     */
    public function setColSpan(int $value): self;

    /**
     * Returns the rowspan value
     */
    public function getRowSpan(): int;

    /**
     * Sets the rowspan value
     */
    public function setRowSpan(int $value): self;

    /**
     * Sets the paddings
     *
     * @param int|float $top Top padding
     * @param int|float $right Right padding
     * @param int|float $bottom Bottom padding
     * @param int|float $left Left padding
     */
    public function setPadding($top = 0, $right = 0, $bottom = 0, $left = 0): self;

    /**
     * Sets the padding bottom
     *
     * @param int|float $paddingBottom
     */
    public function setPaddingBottom($paddingBottom): self;

    /**
     * Returns the padding bottom
     *
     * @return int|float
     */
    public function getPaddingBottom();

    /**
     * Sets the padding left
     *
     * @param int|float $paddingLeft
     */
    public function setPaddingLeft($paddingLeft): self;

    /**
     * Returns the padding left
     *
     * @return int|float
     */
    public function getPaddingLeft();

    /**
     * Sets the padding right
     *
     * @param int|float $paddingRight
     */
    public function setPaddingRight($paddingRight): self;

    /**
     * Returns the padding right
     *
     * @return int|float
     */
    public function getPaddingRight();

    /**
     * Sets the padding top
     *
     * @param int|float $paddingTop
     */
    public function setPaddingTop($paddingTop): self;

    /**
     * Returns the padding top
     *
     * @return int|float
     */
    public function getPaddingTop();

    /**
     * Sets the border Size
     *
     * @param int|float $borderSize
     */
    public function setBorderSize($borderSize): self;

    /**
     * Returns the border Size
     *
     * @return int|float
     */
    public function getBorderSize();

    /**
     * Sets the border Type
     * Can be: 0, 1 or a combination of: 'LRTB'
     *
     * @param int|string $borderType
     */
    public function setBorderType($borderType): self;

    /**
     * Returns the border Type
     *
     * @return int|string
     */
    public function getBorderType();

    /**
     * Sets the Border Color.
     * If the value is set to FALSE, 0 or '0' then we assume transparency
     *
     * @param int|bool|array $r
     */
    public function setBorderColor($r, ?int $g = null, ?int $b = null): self;

    /**
     * Returns the Border Color
     *
     * @return string|array
     */
    public function getBorderColor();

    /**
     * Sets the Align Vertical
     */
    public function setAlignVertical(string $alignVertical): self;

    /**
     * Returns the Align Vertical
     */
    public function getAlignVertical(): string;

    /**
     * Sets the Background Color.
     * If the value is set to FALSE, 0 or '0' then we assume transparency
     *
     * @param int|bool|array $r
     */
    public function setBackgroundColor($r, ?int $g = null, ?int $b = null): self;

    /**
     * Returns the Background Color
     *
     * @return string|array
     */
    public function getBackgroundColor();

    public function setCellWidth($value): self;

    public function getCellWidth();

    public function setCellHeight($value): self;

    public function getCellHeight();

    public function setCellDrawHeight($value): self;

    public function getCellDrawHeight();

    public function setCellDrawWidth($value): self;

    public function getCellDrawWidth();

    public function setContentWidth($value): self;

    public function getContentWidth();

    public function setContentHeight($value): self;

    public function getContentHeight();

    public function setSkipped(bool $value): self;

    public function getSkipped(): bool;
}
