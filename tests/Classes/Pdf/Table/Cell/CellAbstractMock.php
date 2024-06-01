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

namespace Interpid\PdfLib\Tests\Classes\Pdf\Table\Cell;

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
