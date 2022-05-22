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

/**
 * Pdf Table Cell EmptyCell
 *
 * @package Interpid\PdfLib\Table\Cell
 * @property array aDefaultValues
 */
class EmptyCell extends CellAbstract implements CellInterface
{
    public function isSplittable(): bool
    {
        return false;
    }


    public function render()
    {
        $this->renderCellLayout();
    }

    public function copyProperties(CellAbstract $oSource)
    {
        $aProps = array_keys($this->aDefaultValues);

        foreach ($aProps as $sProperty) {
            if ($oSource->isPropertySet($sProperty)) {
                $this->$sProperty = $oSource->$sProperty;
            }
        }

        //set 0 padding
        $this->setPadding();
    }
}
