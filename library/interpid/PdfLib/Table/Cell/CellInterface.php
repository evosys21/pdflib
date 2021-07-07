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

namespace Interpid\PdfLib\Table\Cell;

use Interpid\PdfLib\PdfInterface;

/**
 * Pdf Table Cell Interface
 * @package Interpid\PdfLib\Table\Cell
 */
interface CellInterface
{


    /**
     * Class constructor
     *
     * @param PdfInterface $pdf
     */
    public function __construct($pdf);


    /**
     * Returns true of the cell is splittable
     */
    public function isSplittable();

    /**
     * Splits the current cell
     *
     * @param number $nRowHeight - the Height of the row that contains this cell
     * @param number $nMaxHeight - the Max height available
     * @return array(oNewCell, iSplitHeight)
     */
    public function split($nRowHeight, $nMaxHeight);


    /**
     * Set the default values
     *
     * @param array $aValues
     */
    public function setDefaultValues(array $aValues = []);


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
    public function setProperties(array $values = []);

    public function render();

    /**
     * Returns the colspan value
     *
     * @return integer
     */
    public function getColSpan();

    /**
     * Sets the colspan value
     *
     * @param integer $value
     */
    public function setColSpan($value);

    /**
     * Returns the rowspan value
     *
     * @return integer
     */
    public function getRowSpan();

    /**
     * Sets the rowspan value
     *
     * @param integer $value
     */
    public function setRowSpan($value);


    /**
     * Sets the paddings
     *
     * @param int $top Top padding
     * @param int $right Right padding
     * @param int $bottom Bottom padding
     * @param int $left Left padding
     */
    public function setPadding($top = 0, $right = 0, $bottom = 0, $left = 0);

    /**
     * Sets the padding bottom
     *
     * @param int $paddingBottom
     */
    public function setPaddingBottom($paddingBottom);

    /**
     * Returns the padding bottom
     *
     * @return int
     */
    public function getPaddingBottom();

    /**
     * Sets the padding left
     *
     * @param int $paddingLeft
     */
    public function setPaddingLeft($paddingLeft);

    /**
     * Returns the padding left
     *
     * @return int
     */
    public function getPaddingLeft();

    /**
     * Sets the padding right
     *
     * @param int $paddingRight
     */
    public function setPaddingRight($paddingRight);

    /**
     * Returns the padding right
     *
     * @return int
     */
    public function getPaddingRight();

    /**
     * Sets the padding top
     *
     * @param int $paddingTop
     */
    public function setPaddingTop($paddingTop);

    /**
     * Returns the padding top
     *
     * @return int
     */
    public function getPaddingTop();

    /**
     * Sets the border Size
     *
     * @param float $borderSize
     */
    public function setBorderSize($borderSize);

    /**
     * Returns the border Size
     *
     * @return float
     */
    public function getBorderSize();

    /**
     * Sets the border Type
     * Can be: 0, 1 or a combination of: 'LRTB'
     *
     * @param string $borderType
     */
    public function setBorderType($borderType);

    /**
     * Returns the border Type
     *
     * @return string
     */
    public function getBorderType();

    /**
     * Sets the Border Color.
     * If the value is set to FALSE, 0 or '0' then we assume transparency
     *
     * @param int | bool | array $r
     * @param int | null $g
     * @param int | null $b
     */
    public function setBorderColor($r, $g = null, $b = null);

    /**
     * Returns the Border Color
     *
     * @return array
     */
    public function getBorderColor();

    /**
     * Sets the Align Vertical
     *
     * @param string $alignVertical
     */
    public function setAlignVertical($alignVertical);

    /**
     * Returns the Align Vertical
     *
     * @return string
     */
    public function getAlignVertical();

    /**
     * Sets the Background Color.
     * If the value is set to FALSE, 0 or '0' then we assume transparency
     *
     * @param int | bool | array $r
     * @param int | null $g
     * @param int | null $b
     */
    public function setBackgroundColor($r, $g = null, $b = null);

    /**
     * Returns the Background Color
     *
     * @return array
     */
    public function getBackgroundColor();


    public function setCellWidth($value);


    public function getCellWidth();


    public function setCellHeight($value);


    public function getCellHeight();


    public function setCellDrawHeight($value);

    public function getCellDrawHeight();


    public function setCellDrawWidth($value);


    public function getCellDrawWidth();


    public function setContentWidth($value);


    public function getContentWidth();


    public function setContentHeight($value);


    public function getContentHeight();


    public function setSkipped($value);


    public function getSkipped();
}
