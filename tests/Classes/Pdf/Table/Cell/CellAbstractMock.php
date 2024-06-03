<?php
namespace evosys21\PdfLib\Tests\Classes\Pdf\Table\Cell;

use evosys21\PdfLib\Table\Cell\CellAbstract;

/**
 * Class CellAbstractMock
 * Mock class just to unit-test an abstract class
 *
 * @property mixed|null TEST2
 * @property mixed|null TEST
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
