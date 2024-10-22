<?php

namespace EvoSys21\PdfLib\Tests\Unit\Table;

use EvoSys21\PdfLib\Table\Cell\CellAbstract;

/**
 * Class CellAbstractMock
 * Mock class just to unit-test an abstract class
 *
 * @property string|int|null TEST2
 * @property string|int|null TEST
 */
class CellAbstractMock extends CellAbstract
{
    protected $someValue;

    public function render()
    {
    }

    public function isSplittable()
    {
        return false;
    }

    public function setSomeValue($value)
    {
        $this->someValue = $value;
    }

    public function getSomeValue()
    {
        return $this->someValue;
    }
}
