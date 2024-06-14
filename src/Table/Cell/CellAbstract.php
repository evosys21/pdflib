<?php
/** @noinspection PhpUnused */
namespace evosys21\PdfLib\Table\Cell;

use evosys21\PdfLib\Factory;
use evosys21\PdfLib\Fpdf\Pdf;
use evosys21\PdfLib\Fpdf\PdfInterface;
use evosys21\PdfLib\Tools;
use evosys21\PdfLib\Validate;

/**
 * Pdf Table Cell Abstract Class
 *\Table\Cell
 * @property mixed|null HEIGHT_LEFT_RW
 */
abstract class CellAbstract implements CellInterface
{
    protected $aPropertyMethodMap = array(
        'ALIGN' => 'setAlign',
        'VERTICAL_ALIGN' => 'setAlignVertical',
        'COLSPAN' => 'setColSpan',
        'ROWSPAN' => 'setRowSpan',
        'HEIGHT' => 'setHeight',
        'PADDING' => 'setPadding',
        'PADDING_TOP' => 'setPaddingTop',
        'PADDING_RIGHT' => 'setPaddingRight',
        'PADDING_BOTTOM' => 'setPaddingBottom',
        'PADDING_LEFT' => 'setPaddingLeft',
        'BORDER_TYPE' => 'setBorderType',
        'BORDER_SIZE' => 'setBorderSize',
        'BORDER_COLOR' => 'setBorderColor',
        'BACKGROUND_COLOR' => 'setBackgroundColor',
    );

    /**
     * Colspan
     *
     * @var int
     */
    protected $colSpan = 1;

    /**
     * Rowspan
     *
     * @var int
     */
    protected $rowSpan = 1;

    /**
     * @var float
     */
    protected $paddingTop = 0;

    /**
     * @var float
     */
    protected $paddingRight = 0;

    /**
     * @var float
     */
    protected $paddingBottom = 0;

    /**
     * @var float
     */
    protected $paddingLeft = 0;

    protected $backgroundColor = [255, 255, 255];

    /**
     * @var string|int
     */
    protected $borderType = '1';

    /**
     * @var float
     */
    protected $borderSize = 0.1;

    /**
     * @var string|array
     */
    protected $borderColor = [0, 0, 0];

    /**
     * @var string
     */
    protected $align = 'L';

    /**
     * @var string
     */
    protected $alignVertical = 'M';

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @var array
     */
    protected $internValueSet = [];

    /**
     * @var float|int
     */
    protected $height = 0;

    /**
     * @var float|int
     */
    protected $cellWidth = 0;

    /**
     * @var float|int
     */
    protected $cellHeight = 0;

    /**
     * @var float|int
     */
    protected $cellDrawWidth = 0;

    /**
     * @var float|int
     */
    protected $cellDrawHeight = 0;

    /**
     * @var float|int
     */
    protected $contentWidth = 0;

    /**
     * @var float|int
     */
    protected $contentHeight = 0;

    /**
     * Default alignment is Middle Center
     *
     * @var string
     */
    protected $alignment = 'MC';

    /**
     * Pdf Interface
     *
     * @var Pdf
     */
    protected $pdf;

    /**
     * Pdf Interface
     *
     * @var PdfInterface
     */
    protected $pdfi;

    /**
     * If this cell will be skipped
     *
     * @var boolean
     */
    protected $bSkip = false;


    public function __construct($pdf)
    {
        if ($pdf instanceof PdfInterface) {
            $this->pdfi = $pdf;
            $this->pdf = $pdf->getPdfObject();
        } else {
            //it must be an instance of a pdf object
            $this->pdf = $pdf;
            $this->pdfi = Factory::pdfInterface($pdf);
        }
    }

    public function setProperties(array $values = []): CellInterface
    {
        $this->setInternValues($values, false);
        return $this;
    }

    /**
     * Sets the intern variable values
     *
     * @param array $values The values to be set
     * @param bool $checkSet If the values are already set, the values will NOT be set
     */
    protected function setInternValues(array $values = [], bool $checkSet = true)
    {
        foreach ($values as $key => $value) {
            if ($checkSet && $this->isInternValueSet($key)) {
                //property is already set, ignore the value
                continue;
            }

            $this->setInternValue($key, $value);
        }
    }


    /**
     * Returns true if the property is already set
     *
     * @param string $key
     * @return bool
     */
    protected function isInternValueSet(string $key): bool
    {
        return array_key_exists($key, $this->internValueSet);
    }

    /**
     * Marks the property as set
     *
     * @param string $key
     */
    protected function markInternValueAsSet(string $key)
    {
        $this->internValueSet[$key] = true;
    }

    /**
     * Sets an intern value
     *
     * @param $key
     * @param $value
     */
    protected function setInternValue($key, $value)
    {
        $this->markInternValueAsSet($key);

        if (isset($this->aPropertyMethodMap[$key])) {
            call_user_func_array(array(
                $this,
                $this->aPropertyMethodMap[$key]
            ), Tools::makeArray($value));

            return;
        }

        $method = 'set' . ucfirst($key);

        if (method_exists($this, $method)) {
            call_user_func_array(array(
                $this,
                $method
            ), Tools::makeArray($value));

            return;
        }

        $this->properties[$key] = $value;
    }


    /**
     * Set image alignment.
     * It can be any combination of the 2 Vertical and Horizontal values:
     * Vertical values: TBM
     * Horizontal values: LRC
     *
     * @param string $alignment
     */
    public function setAlign(string $alignment)
    {
        $this->alignment = strtoupper($alignment);
    }


    public function setColSpan(int $value): CellInterface
    {
        $this->colSpan = Validate::intPositive($value);
        return $this;
    }


    public function getColSpan(): int
    {
        return $this->colSpan;
    }


    public function setRowSpan(int $value): CellInterface
    {
        $this->rowSpan = Validate::intPositive($value);
        return $this;
    }


    public function getRowSpan(): int
    {
        return $this->rowSpan;
    }


    public function setCellWidth($value): CellInterface
    {
        $value = Validate::float($value, 0);

        $this->cellWidth = $value;

        if ($value > $this->getCellDrawWidth()) {
            $this->setCellDrawWidth($value);
        }
        return $this;
    }


    public function getCellWidth(): float
    {
        return $this->cellWidth;
    }


    public function setCellHeight($value): CellInterface
    {
        $value = Validate::float($value, 0);

        $this->cellHeight = $value;

        if ($value > $this->getCellDrawHeight()) {
            $this->setCellDrawHeight($value);
        }
        return $this;
    }


    public function getCellHeight(): float
    {
        return $this->cellHeight;
    }


    public function setCellDrawHeight($value): CellInterface
    {
        $value = Validate::float($value, 0);

        if ($this->getCellHeight() <= $value) {
            $this->cellDrawHeight = $value;
        }
        return $this;
    }


    public function getCellDrawHeight()
    {
        if ($this->height > 0) {
            return Validate::float($this->height, 0);
        }
        return $this->cellDrawHeight;
    }


    public function setCellDrawWidth($value): CellInterface
    {
        $value = Validate::float($value, 0);

        $this->cellDrawWidth = $value;
        $this->setCellWidth($value);
        return $this;
    }


    public function getCellDrawWidth()
    {
        return $this->cellDrawWidth;
    }


    public function setContentWidth($value): CellInterface
    {
        $this->contentWidth = Validate::float($value, 0);
        return $this;
    }


    public function getContentWidth()
    {
        return $this->contentWidth;
    }


    public function setContentHeight($value): CellInterface
    {
        $this->contentHeight = Validate::float($value, 0);
        return $this;
    }


    public function getContentHeight()
    {
        return $this->contentHeight;
    }


    public function setSkipped(bool $value): CellInterface
    {
        $this->bSkip = $value;
        return $this;
    }


    public function getSkipped(): bool
    {
        return $this->bSkip;
    }


    public function __get($property)
    {
        if (isset($this->properties[$property])) {
            return $this->properties[$property];
        }

         return null;
    }


    public function __set($property, $value)
    {
        $this->setInternValue($property, $value);

        return $this;
    }


    public function isPropertySet($property): bool
    {
        if (isset($this->properties[$property])) {
            return true;
        }

        return false;
    }


    public function setDefaultValues(array $values = []): CellInterface
    {
        $this->setInternValues($values);
        return $this;
    }


    /**
     * Renders the base cell layout - Borders and Background Color
     */
    public function renderCellLayout()
    {
        $x = $this->pdf->GetX();
        $y = $this->pdf->GetY();

        //border size BORDER_SIZE
        $this->pdf->SetLineWidth($this->getBorderSize());

        if (!$this->isTransparent()) {
            //fill color = BACKGROUND_COLOR
            list($r, $g, $b) = $this->getBackgroundColor();
            $this->pdf->SetFillColor($r, $g, $b);
        }

        //Draw Color = BORDER_COLOR
        list($r, $g, $b) = $this->getBorderColor();
        $this->pdf->SetDrawColor($r, $g, $b);

        $this->pdf->Cell(
            $this->getCellDrawWidth(),
            $this->getCellDrawHeight(),
            '',
            $this->getBorderType(),
            0,
            '',
            !$this->isTransparent()
        );

        $this->pdf->SetXY($x, $y);
    }


    protected function isTransparent(): bool
    {
        return Tools::isFalse($this->getBackgroundColor());
    }


    public function copyProperties(CellAbstract $oSource)
    {
        $this->rowSpan = $oSource->getRowSpan();
        $this->colSpan = $oSource->getColSpan();

        $this->paddingTop = $oSource->getPaddingTop();
        $this->paddingRight = $oSource->getPaddingRight();
        $this->paddingBottom = $oSource->getPaddingBottom();
        $this->paddingLeft = $oSource->getPaddingLeft();

        $this->borderColor = $oSource->getBorderColor();
        $this->borderSize = $oSource->getBorderSize();
        $this->borderType = $oSource->getBorderType();

        $this->backgroundColor = $oSource->getBackgroundColor();

        $this->alignVertical = $oSource->getAlignVertical();
    }


    public function processContent()
    {
    }


    public function setPadding($top = 0, $right = 0, $bottom = 0, $left = 0): CellInterface
    {
        $this->setPaddingTop($top);
        $this->setPaddingRight($right);
        $this->setPaddingBottom($bottom);
        $this->setPaddingLeft($left);
        return $this;
    }


    public function setPaddingBottom($paddingBottom): CellInterface
    {
        $this->paddingBottom = Validate::float($paddingBottom, 0);
        return $this;
    }


    public function getPaddingBottom()
    {
        return $this->paddingBottom;
    }


    public function setPaddingLeft($paddingLeft): CellInterface
    {
        $this->paddingLeft = Validate::float($paddingLeft, 0);
        return $this;
    }


    public function getPaddingLeft()
    {
        return $this->paddingLeft;
    }


    public function setPaddingRight($paddingRight): CellInterface
    {
        $this->paddingRight = Validate::float($paddingRight, 0);
        return $this;
    }


    public function getPaddingRight()
    {
        return $this->paddingRight;
    }


    public function setPaddingTop($paddingTop): CellInterface
    {
        $this->paddingTop = Validate::float($paddingTop, 0);
        return $this;
    }


    public function getPaddingTop()
    {
        return $this->paddingTop;
    }


    public function setBorderSize($borderSize): CellInterface
    {
        $this->borderSize = Validate::float($borderSize, 0);
        return $this;
    }


    public function getBorderSize(): float
    {
        return $this->borderSize;
    }


    public function setBorderType($borderType): CellInterface
    {
        $this->borderType = $borderType;
        return $this;
    }


    public function getBorderType(): string
    {
        return $this->borderType;
    }

    public function setBorderColor($r, ?int $g = null, ?int $b = null): CellInterface
    {
        $this->borderColor = Tools::getColor($r, $g, $b);
        return $this;
    }

    public function getBorderColor()
    {
        return $this->borderColor;
    }


    public function setAlignVertical(string $alignVertical): CellInterface
    {
        $this->markInternValueAsSet('VERTICAL_ALIGN');
        $this->alignVertical = Validate::alignVertical($alignVertical);
        return $this;
    }


    public function getAlignVertical(): string
    {
        return $this->alignVertical;
    }

    public function setBackgroundColor($r, ?int $g = null, ?int $b = null): CellInterface
    {
        $this->backgroundColor = Tools::getColor($r, $g, $b);
        return $this;
    }

    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    public function split($rowHeight, $maxHeight): array
    {
        return [$this, 0];
    }

    public function getDefaultValues(): array
    {
        return [];
    }

    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }
}
