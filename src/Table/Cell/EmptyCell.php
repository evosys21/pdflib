<?php
namespace evosys21\PdfLib\Table\Cell;

/**
 * Pdf Table Cell EmptyCell
 *\Table\Cell
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
