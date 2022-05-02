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

use Interpid\PdfLib\Tools;

/**
 * Pdf Table Cell Image
 *
 * @package Interpid\PdfLib\Table\Cell
 */
class Image extends CellAbstract implements CellInterface
{
    protected $sFile;

    protected $sType = '';

    protected $sLink = '';

    /**
     * Default alignment is Middle Center
     *
     * @var string
     */
    protected $alignment = 'MC';


    /**
     * Image cell constructor
     *
     * @param $pdf
     * @param string $file
     * @param int $width
     * @param int $height
     * @param string $type
     * @param string $link
     */
    public function __construct($pdf, $file = '', $width = 0, $height = 0, $type = '', $link = '')
    {
        parent::__construct($pdf);

        if (strlen($file) > 0) {
            $this->setImage($file, $width, $height, $type, $link);
        }
    }


    public function setProperties(array $values = [])
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
    }


    public function setImage($file = '', $width = 0, $height = 0, $type = '', $link = '')
    {
        $this->sFile = $file;
        $this->sType = $type;
        $this->sLink = $link;

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
    public function setAlign($alignment)
    {
        $this->alignment = strtoupper($alignment);
    }


    public function isSplittable()
    {
        return false;
    }


    public function getType()
    {
        return $this->sType;
    }


    public function getLink()
    {
        return $this->sLink;
    }


    /**
     * Renders the image in the pdf Object
     */
    public function render()
    {
        $this->renderCellLayout();

        $x = $this->pdf->GetX() + $this->getBorderSize();
        $y = $this->pdf->GetY() + $this->getBorderSize();

        $width = $this->getContentWidth();
        $height = $this->getContentHeight();

        //Horizontal Alignment
        if (strpos($this->alignment, 'J') !== false) {
            //justified - image is fully streched
            $x += $this->getPaddingLeft();
            $this->setContentWidth($this->getCellDrawWidth() - 2 * $this->getBorderSize() - $this->getPaddingLeft() - $this->getPaddingRight());
        } elseif (strpos($this->alignment, 'C') !== false) {
            //center
            $x += ($this->getCellDrawWidth() - $this->getContentWidth()) / 2;
        } elseif (strpos($this->alignment, 'R') !== false) {
            //right
            $x += $this->getCellDrawWidth() - $this->getContentWidth() - $this->getPaddingRight();
        } else {
            //left, this is default
            $x += $this->getPaddingLeft();
        }

        //Vertical Alignment
        if (strpos($this->alignment, 'T') !== false) {
            //top
            $y += $this->getPaddingTop();
        } elseif (strpos($this->alignment, 'B') !== false) {
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
            $this->sFile,
            $x,
            $y,
            $this->getContentWidth(),
            $this->getContentHeight(),
            $this->sType,
            $this->sLink
        );
    }


    /**
     * Checks if the image file is set and it is accessible
     */
    protected function doChecks()
    {
        //check if the image is set
        if (0 == strlen($this->sFile)) {
            trigger_error("Image File not set!", E_USER_ERROR);
        }

        if (!file_exists($this->sFile)) {
            trigger_error("Image File Not found: {$this->sFile}!", E_USER_ERROR);
        }
    }


    public function processContent()
    {
        $this->doChecks();

        $this->setCellHeight($this->getContentHeight() + $this->getPaddingTop() + $this->getPaddingBottom() + 2 * $this->getBorderSize());
    }
}
