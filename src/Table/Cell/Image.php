<?php

/** @noinspection PhpUnused */

namespace EvoSys21\PdfLib\Table\Cell;

use EvoSys21\PdfLib\Fpdf\Pdf;
use EvoSys21\PdfLib\Fpdf\PdfInterface;
use EvoSys21\PdfLib\Tools;

/**
 * Pdf Table Cell Image
 *\Table\Cell
 */
class Image extends CellAbstract implements CellInterface
{
    protected $file;

    protected $type = '';

    protected $link = '';

    /**
     * Default alignment is Middle Center
     *
     * @var string
     */
    protected $alignment = 'MC';


    /**
     * Image cell constructor
     *
     * @param Pdf|PdfInterface $pdf
     * @param string $file
     * @param int $width
     * @param int $height
     * @param string $type
     * @param string $link
     */
    public function __construct($pdf, string $file = '', int $width = 0, int $height = 0, string $type = '', string $link = '')
    {
        parent::__construct($pdf);

        if (strlen($file) > 0) {
            $this->setImage($file, $width, $height, $type, $link);
        }
    }


    public function setProperties(array $values = []): CellInterface
    {
        //call the parent function
        parent::setProperties($values);


        $this->setImage(
            Tools::getValue($values, 'FILE'),
            Tools::getValue($values, 'WIDTH'),
            Tools::getValue($values, 'HEIGHT'),
            Tools::getValue($values, 'IMAGE_TYPE'),
            Tools::getValue($values, 'LINK')
        );

        return $this;
    }


    public function setImage($file = '', $width = 0, $height = 0, $type = '', $link = '')
    {
        $this->file = $file;
        $this->type = $type;
        $this->link = $link;

        //check if file exists etc...
        $this->doChecks();

        list($width, $height) = $this->pdfi->getImageParams($file, $width, $height);

        $this->setContentWidth($width);
        $this->setContentHeight($height);
    }


    /**
     * Set image alignment.
     * It can be any combination of the 2 Vertical and Horizontal values:
     * Vertical values: TBM
     * Horizontal values: LRC
     *
     * @param string $alignment
     * @todo: check if this function is REALLY used
     */
    public function setAlign(string $alignment)
    {
        $this->alignment = strtoupper($alignment);
    }


    public function isSplittable(): bool
    {
        return false;
    }


    public function getType(): string
    {
        return $this->type;
    }


    public function getLink(): string
    {
        return $this->link;
    }


    /**
     * Renders the image in the pdf Object
     */
    public function render()
    {
        $this->renderCellLayout();

        $x = $this->pdf->GetX() + $this->getBorderSize();
        $y = $this->pdf->GetY() + $this->getBorderSize();

        //Horizontal Alignment
        if (str_contains($this->alignment, 'J')) {
            //justified - image is fully stretched
            $x += $this->getPaddingLeft();
            $this->setContentWidth($this->getCellDrawWidth() - 2 * $this->getBorderSize() - $this->getPaddingLeft() - $this->getPaddingRight());
        } elseif (str_contains($this->alignment, 'C')) {
            //center
            $x += ($this->getCellDrawWidth() - $this->getContentWidth()) / 2;
        } elseif (str_contains($this->alignment, 'R')) {
            //right
            $x += $this->getCellDrawWidth() - $this->getContentWidth() - $this->getPaddingRight();
        } else {
            //left, this is default
            $x += $this->getPaddingLeft();
        }

        //Vertical Alignment
        if (str_contains($this->alignment, 'T')) {
            //top
            $y += $this->getPaddingTop();
        } elseif (str_contains($this->alignment, 'B')) {
            //bottom
            $y += $this->getCellDrawHeight() - $this->getContentHeight() - $this->getPaddingBottom();
        } else {
            //middle, this is default
            $y += ($this->getCellDrawHeight() - $this->getContentHeight()) / 2;
        }

        if ($this->pdf->getRTL()) {
            $x = $this->pdf->getPageWidth() - $x;
        }

        $this->pdf->Image(
            $this->file,
            $x,
            $y,
            $this->getContentWidth(),
            $this->getContentHeight(),
            $this->type,
            $this->link
        );
    }


    /**
     * Checks if the image file is set and it is accessible
     */
    protected function doChecks()
    {
        //check if the image is set
        if (0 == strlen($this->file)) {
            trigger_error("Image File not set!", E_USER_ERROR);
        }

        if (!file_exists($this->file)) {
            trigger_error("Image File Not found: $this->file!", E_USER_ERROR);
        }
    }


    public function processContent()
    {
        $this->doChecks();

        $this->setCellHeight($this->getContentHeight() + $this->getPaddingTop() + $this->getPaddingBottom() + 2 * $this->getBorderSize());
    }
}
