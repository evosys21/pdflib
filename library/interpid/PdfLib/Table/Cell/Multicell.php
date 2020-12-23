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

use Interpid\PdfLib\Pdf;

/**
 * Pdf Table Cell Multicell
 * @package Interpid\PdfLib\Table\Cell
 * @property mixed|array TEXT_STRLINES
 * @property mixed|null TEXT_ALIGN
 * @property mixed|null LINE_SIZE
 * @property mixed|null TEXT_SIZE
 * @property mixed|null TEXT_TYPE
 * @property mixed|null TEXT_FONT
 * @property mixed|null TEXT_COLOR
 * @property int|null nLines
 * @property string TEXT
 * @property float|int V_OFFSET
 */
class Multicell extends CellAbstract implements CellInterface
{

    /**
     *
     * @var \Interpid\PdfLib\Multicell
     */
    protected $multicell;

    /**
     * Class Constructor
     *
     * @param Pdf $pdf
     * @param string|array $data
     */
    public function __construct($pdf, $data = ' ')
    {
        parent::__construct($pdf);

        if (is_string($data)) {
            $this->TEXT = $data;
        } elseif (is_array($data)) {
            $this->setProperties($data);
        }
    }


    public function getDefaultValues()
    {
        $values = array(
            'TEXT' => '',
            'TEXT_COLOR' => [0, 0, 0], //text color
            'TEXT_SIZE' => 6, //font size
            'TEXT_FONT' => 'Arial', //font family
            'TEXT_ALIGN' => 'C', //horizontal alignment, possible values: LRC (left, right, center)
            'TEXT_TYPE' => '', //font type
            'LINE_SIZE' => 4
        ); //line size for one row

        return array_merge(parent::getDefaultValues(), $values);
    }


    /**
     * Alignment - can be any combination of the following values:
     * Vertical values: TBMJ
     * Horizontal values: LRC
     *
     * @param string $alignment
     * @see CellAbstract::setAlign()
     */
    public function setAlign($alignment)
    {
        parent::setAlign($alignment);

        $vertical = 'TBM';
        $horizontal = 'LRCJ';

        foreach (str_split($horizontal) as $val) {
            if (false !== stripos($alignment, $val)) {
                $this->TEXT_ALIGN = $val;
                break;
            }
        }

        foreach (str_split($vertical) as $val) {
            if (false !== stripos($alignment, $val)) {
                $this->setAlignVertical($val);
                break;
            }
        }
    }


    public function attachMulticell($multicell)
    {
        $this->multicell = $multicell;
        $this->multicell->enableFill(false);
    }


    /**
     * (non-PHPdoc)
     *
     * @param $value
     * @see CellAbstract::setCellDrawWidth()
     */
    public function setCellDrawWidth($value)
    {
        parent::setCellDrawWidth($value);
        $this->calculateContentWidth();
    }


    /**
     * (non-PHPdoc)
     *
     * @see CellInterface::isSplittable()
     */
    public function isSplittable()
    {
        if ($this->isPropertySet('SPLITTABLE')) {
            return true && $this->isPropertySet('SPLITTABLE');
        }

        return true;
    }


    /**
     * Splits the current cell
     *
     * @param number $nRowHeight - the Height of the row that contains this cell
     * @param number $nMaxHeight - the Max height available
     * @return array(oNewCell, iSplitHeight)
     */
    public function split($nRowHeight, $nMaxHeight)
    {
        $oCell2 = clone $this;

        /**
         * Have to look at the VERTICAL_ALIGN of the cells and calculate exaclty for each cell how much space is left
         */
        switch ($this->getAlignVertical()) {
            case 'M':
                //Middle align
                $x = ($nRowHeight - $this->getCellHeight()) / 2;

                if ($nMaxHeight <= $x) {
                    //CASE 1
                    $fHeightSplit = 0;
                    $this->V_OFFSET = $x - $nMaxHeight;
                    $this->setAlignVertical('T'); //top align
                } elseif (($x + $this->getCellHeight()) >= $nMaxHeight) {
                    //CASE 2
                    $fHeightSplit = $nMaxHeight - $x;

                    $this->setAlignVertical('B'); //top align
                    $oCell2->setAlignVertical('T'); //top align
                } else { //{
                    //CASE 3
                    $fHeightSplit = $nMaxHeight;
                    $this->V_OFFSET = $x;
                    $this->setAlignVertical('B'); //bottom align
                }
                break;

            case 'B':
                //Bottom Align
                if (($nRowHeight - $this->getCellHeight()) > $nMaxHeight) {
                    //if the text has enough place on the other page then we show nothing on this page
                    $fHeightSplit = 0;
                } else {
                    //calculate the space that the text needs on this page
                    $fHeightSplit = $nMaxHeight - ($nRowHeight - $this->getCellHeight());
                }

                break;

            case 'T':
            default:
                //Top Align and default align
                $fHeightSplit = $nMaxHeight;
                break;
        }

        $fHeightSplit = $fHeightSplit - $this->getPaddingTop();
        if ($fHeightSplit < 0) {
            $fHeightSplit = 0;
        }

        //calculate the number of the lines that have space on the $fHeightSplit
        $iNoLinesCPage = floor($fHeightSplit / $this->LINE_SIZE);

        //check which paddings we need to set
        if ($iNoLinesCPage == 0) {
            //there are no lines on the current cell - all paddings are 0
            $this->setPaddingTop(0);
            $this->setPaddingBottom(0);
        } else {
            //the bottom padding of the first cell gets eliminated
            //as well as the top padding from the following cell(resulted from the split)
            $this->setPaddingBottom(0);
            $oCell2->setPaddingTop(0);
        }

        $iCurrentLines = count($this->TEXT_STRLINES);

        //if the number of the lines is bigger than the number of the lines in the cell decrease the number of the lines
        if ($iNoLinesCPage > $iCurrentLines) {
            $iNoLinesCPage = $iCurrentLines;
        }

        $aLines = $this->TEXT_STRLINES;
        $aLines2 = array_splice($aLines, $iNoLinesCPage);
        $this->TEXT_STRLINES = $aLines;
        $this->calculateCellHeight();

        //this is the second cell from the splitted one
        $oCell2->TEXT_STRLINES = $aLines2;
        $oCell2->calculateCellHeight();
        //$oCell2->setCellDrawHeight($nRowHeight);


        $this->setCellDrawHeight($nMaxHeight);

        return array(
            $oCell2,
            $fHeightSplit
        );
    }


    public function getText()
    {
        return $this->TEXT;
    }


    public function getLineSize()
    {
        return $this->LINE_SIZE;
    }


    public function processContent()
    {
        //Text Color = TEXT_COLOR
        list($r, $g, $b) = $this->TEXT_COLOR;
        $this->pdf->SetTextColor($r, $g, $b);

        //Set the font, font type and size
        $this->pdf->SetFont($this->TEXT_FONT, $this->TEXT_TYPE, $this->TEXT_SIZE);

        $this->TEXT_STRLINES = $this->multicell->stringToLines($this->getContentWidth(), $this->getText());

        $this->calculateCellHeight();
    }


    public function calculateCellHeight()
    {
        $this->nLines = count($this->TEXT_STRLINES);
        $this->cellHeight = $this->getLineSize() * $this->nLines + $this->getPaddingTop() + $this->getPaddingBottom();

        $this->setCellDrawHeight($this->cellHeight);
    }


    /**
     */
    public function calculateContentWidth()
    {
        $this->contentWidth = $this->getCellWidth() - $this->getPaddingLeft() - $this->getPaddingRight();

        if ($this->contentWidth < 0) {
            trigger_error("Cell with negative value. Please check width, padding left and right");
        }
    }


    /**
     * Renders the image in the pdf Object at the specified position
     */
    public function render()
    {
        $this->renderCellLayout();

        //Text Color = TEXT_COLOR
        list($r, $g, $b) = $this->TEXT_COLOR;
        $this->pdf->SetTextColor($r, $g, $b);

        //Set the font, font type and size
        $this->pdf->SetFont($this->TEXT_FONT, $this->TEXT_TYPE, $this->TEXT_SIZE);

        //print the text
        $this->multiCellTbl(
            $this->getCellWidth(),
            $this->LINE_SIZE,
            $this->TEXT_STRLINES,
            $this->TEXT_ALIGN,
            $this->getAlignVertical(),
            //@todo: check this one
            $this->getCellDrawHeight() - $this->getCellHeight(),
            0,
            $this->getPaddingLeft(),
            $this->getPaddingTop(),
            $this->getPaddingRight(),
            $this->getPaddingBottom()
        );
    }


    public function multiCellTbl(
        $w,
        $h,
        $txtData,
        $hAlign = 'J',
        $vAlign = 'T',
        $vh = 0,
        $vtop = 0,
        $pad_left = 0,
        $pad_top = 0,
        $pad_right = 0,
        $pad_bottom = 0
    ) {
        $wh_Top = 0;

        if ($vtop > 0) { //if this parameter is set
            if ($vtop < $vh) { //only if the top add-on is bigger than the add-width
                $wh_Top = $vtop;
                $vh = $vh - $vtop;
            }
        }

        if (empty($txtData)) {
            return;
        }

        switch ($vAlign) {
            case 'T':
                $wh_T = $wh_Top; //Top width
                break;
            case 'M':
                $wh_T = $wh_Top + $vh / 2;
                break;
            case 'B':
                $wh_T = $wh_Top + $vh;
                break;
            default: //default is TOP ALIGN
                $wh_T = $wh_Top; //Top width
        }

        $this->multicell->multiCellSec(
            $w,
            $h,
            $txtData,
            0,
            $hAlign,
            1,
            $pad_left,
            $pad_top + $wh_T,
            $pad_right,
            $pad_bottom,
            false
        );
    }
}
