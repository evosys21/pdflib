<?php

namespace evosys21\PdfLib\Table\Cell;

use evosys21\PdfLib\Fpdf\Pdf;
use evosys21\PdfLib\MulticellData;

/**
 * Pdf Table Cell Multicell\Table\Cell
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
     * @var \evosys21\PdfLib\Multicell
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


    public function getDefaultValues(): array
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
    public function setAlign(string $alignment)
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


    public function setCellDrawWidth($value): CellInterface
    {
        parent::setCellDrawWidth($value);
        $this->calculateContentWidth();
        return $this;
    }


    public function isSplittable(): bool
    {
        if ($this->isPropertySet('SPLITTABLE')) {
            return $this->isPropertySet('SPLITTABLE');
        }

        return true;
    }


    /**
     * Splits the current cell
     *
     * @param int|float $rowHeight - the Height of the row that contains this cell
     * @param int|float $maxHeight - the Max height available
     * @return array
     */
    public function split($rowHeight, $maxHeight): array
    {
        $oCell2 = clone $this;

        /**
         * Have to look at the VERTICAL_ALIGN of the cells and calculate exaclty for each cell how much space is left
         */
        switch ($this->getAlignVertical()) {
            case 'M':
                //Middle align
                $x = ($rowHeight - $this->getCellHeight()) / 2;

                if ($maxHeight <= $x) {
                    //CASE 1
                    $splitHeight = 0;
                    $this->V_OFFSET = $x - $maxHeight;
                    $this->setAlignVertical('T'); //top align
                } elseif (($x + $this->getCellHeight()) >= $maxHeight) {
                    //CASE 2
                    $splitHeight = $maxHeight - $x;

                    $this->setAlignVertical('B'); //top align
                    $oCell2->setAlignVertical('T'); //top align
                } else { //{
                    //CASE 3
                    $splitHeight = $maxHeight;
                    $this->V_OFFSET = $x;
                    $this->setAlignVertical('B'); //bottom align
                }
                break;

            case 'B':
                //Bottom Align
                if (($rowHeight - $this->getCellHeight()) > $maxHeight) {
                    //if the text has enough place on the other page then we show nothing on this page
                    $splitHeight = 0;
                } else {
                    //calculate the space that the text needs on this page
                    $splitHeight = $maxHeight - ($rowHeight - $this->getCellHeight());
                }

                break;

            case 'T':
            default:
                //Top Align and default align
                $splitHeight = $maxHeight;
                break;
        }

        $splitHeight = $splitHeight - $this->getPaddingTop();
        if ($splitHeight < 0) {
            $splitHeight = 0;
        }

        //calculate the number of the lines that have space on the $splitHeight
        $splitLines = floor($splitHeight / $this->LINE_SIZE);

        //check which paddings we need to set
        if ($splitLines == 0) {
            //there are no lines on the current cell - all paddings are 0
            $this->setPaddingTop(0);
            $this->setPaddingBottom(0);
        } else {
            //the bottom padding of the first cell gets eliminated
            //as well as the top padding from the following cell(resulted from the split)
            $this->setPaddingBottom(0);
            $oCell2->setPaddingTop(0);
        }

        $currentLines = count($this->TEXT_STRLINES);

        //if the number of the lines is bigger than the number of the lines in the cell decrease the number of the lines
        if ($splitLines > $currentLines) {
            $splitLines = $currentLines;
        }

        $lines = $this->TEXT_STRLINES;
        $lines2 = array_splice($lines, $splitLines);
        $this->TEXT_STRLINES = $lines;
        $this->calculateCellHeight();

        //this is the second cell from the splitted one
        $oCell2->TEXT_STRLINES = $lines2;
        $oCell2->calculateCellHeight();
        //$oCell2->setCellDrawHeight($rowHeight);


        $this->setCellDrawHeight($maxHeight);

        return array(
            $oCell2,
            $splitHeight
        );
    }


    public function getText(): string
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

        $multicellData = new MulticellData($this->pdf);
        $multicellData->string = $this->getText();
        $multicellData->width = $this->getContentWidth();
        $multicellData->initialize();

        $this->multicell->saveStyles();
        $this->TEXT_STRLINES = $this->multicell->stringToLines($multicellData);
        $this->multicell->restoreStyles();

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
    )
    {
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

        $multicellData = new MulticellData($this->pdf);
        $multicellData->width = $w;
        $multicellData->lineHeight = $h;
        $multicellData->border = 0;
        $multicellData->align = $hAlign;
        $multicellData->fill = 1;
        $multicellData->paddingLeft = $pad_left;
        $multicellData->paddingTop = $pad_top + $wh_T;
        $multicellData->paddingRight = $pad_right;
        $multicellData->paddingBottom = $pad_bottom;

        $this->multicell->saveStyles();
        $this->multicell->multiCellSec($multicellData, $txtData);
        $this->multicell->restoreStyles();
    }
}
