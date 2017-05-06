<?php

/**
 * CellAbstractMock
 *
 * Mock class just to unit-test an abstract class
 *
 * @property mixed TEST
 * @property mixed TEST2
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

    public function setSomeValue( $value )
    {
        $this->someValue = $value;
    }

    public function getSomeValue()
    {
        return $this->someValue;
    }
}

