<?php

/**
 * Pdf_Table_Cell_AbstractMock
 *
 * Mock class just to unit-test an abstract class
 *
 * @property mixed TEST
 * @property mixed TEST2
 */
class Pdf_Table_Cell_AbstractMock extends Pdf_Table_Cell_Abstract
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

