<?php
/** @noinspection PhpUndefinedMethodInspection */
/** @noinspection PhpUndefinedFieldInspection */

namespace EvoSys21\PdfLib\Table\Cell;

use TCPDF_IMAGES;
use TCPDF_STATIC;

/**
 * Pdf Table Cell SVG Image
 */
class ImageSVG extends Image
{
    public function isImageSVG($file): bool
    {
        return TCPDF_IMAGES::getImageFileType($file) == 'svg';
    }

    public function setImage($file = '', $width = 0, $height = 0, $type = '', $link = '')
    {
        if ($this->isImageSVG($file)) {
            $this->file = $file;
            $this->type = $type;
            $this->link = $link;

            //check if file exists etc...
            $this->doChecks();

            list($width, $height) = $this->getImageParamsSVG($file, $width, $height);

            $this->setContentWidth($width);
            $this->setContentHeight($height);
        } else {
            parent::setImage($file, $width, $height, $type, $link);
        }
    }

    private function getImageParamsSVG($file, $w = 0, $h = 0)
    {
        $svgData = TCPDF_STATIC::fileGetContents($file);

        if ($svgData === false) {
            $this->pdf->Error('SVG file not found: ' . $file);
        }
        $k = $this->pdf->k;
        $ow = $w;
        $oh = $h;
        $regs = [];
        // get original image width and height
        preg_match('/<svg([^\>]*)>/si', $svgData, $regs);
        if (isset($regs[1]) and !empty($regs[1])) {
            $tmp = [];
            if (preg_match('/[\s]+width[\s]*=[\s]*"([^"]*)"/si', $regs[1], $tmp)) {
                $ow = $this->pdf->getHTMLUnitToUnits($tmp[1], 1, $this->pdf->svgunit, false);
            }
            $tmp = [];
            if (preg_match('/[\s]+height[\s]*=[\s]*"([^"]*)"/si', $regs[1], $tmp)) {
                $oh = $this->pdf->getHTMLUnitToUnits($tmp[1], 1, $this->pdf->svgunit, false);
            }
        }
        if ($ow <= 0) {
            $ow = 1;
        }
        if ($oh <= 0) {
            $oh = 1;
        }
        // calculate image width and height on document
        if (($w <= 0) and ($h <= 0)) {
            // convert image size to document unit
            $w = $ow;
            $h = $oh;
        } elseif ($w <= 0) {
            $w = $h * $ow / $oh;
        } elseif ($h <= 0) {
            $h = $w * $oh / $ow;
        }

        return array(
            $w,
            $h
        );
    }


    /**
     * Renders the image in the pdf Object at the specified position
     *
     */
    public function render()
    {
        $this->renderCellLayout();

        $x = $this->pdf->GetX() + $this->getBorderSize();
        $y = $this->pdf->GetY() + $this->getBorderSize();

        //Horizontal Alignment
        if (str_contains($this->alignment, 'J')) {
            //justified - image is fully stretched

            //var_dump($this->getCellDrawWidth());

            $x += $this->PADDING_LEFT;
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

        if ($this->isImageSVG($this->file)) {
            $this->pdf->ImageSVG(
                $this->file,
                $x,
                $y,
                $this->getContentWidth(),
                $this->getContentHeight(),
                $this->type,
                $this->link
            );
        } else {
            $this->pdf->Image(
                $this->file,
                $x,
                $y,
                $this->getContentWidth(),
                $this->getContentHeight(),
                $this->sType,
                $this->sLink
            );
        }
    }
}
