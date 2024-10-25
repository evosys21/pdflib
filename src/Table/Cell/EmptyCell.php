<?php

namespace EvoSys21\PdfLib\Table\Cell;

/**
 * Pdf Table Cell EmptyCell
 */
class EmptyCell extends CellAbstract implements CellInterface
{
    public function isSplittable(): bool
    {
        return false;
    }


    public function render(): void
    {
        $this->renderCellLayout();
    }

    public function copyProperties(CellAbstract $source): void
    {
        $props = array_keys($this->propMap);

        foreach ($props as $prop) {
            if ($source->isPropertySet($prop)) {
                $this->$prop = $source->$prop;
            }
        }

        //set 0 padding
        $this->setPadding();
    }
}
