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

namespace Interpid\PdfLib\Tests\Functional;

use Interpid\PdfLib\Tests\BaseExamplesTestCase;


/**
 * Class TableExamplesTest
 * @package Interpid\PdfLib\Tests\Functional
 * @group functional
 */
class TableExamplesTest extends BaseExamplesTestCase
{

    /**
     * Tests testExample1
     */
    public function testExamples()
    {
        $aSources = array(
            'example-table-1-overview.php',
            'example-table-2-overview.php',
            'example-table-3-detailed.php',
            'example-table-4-override.php',
        );

        foreach ($aSources as $source) {
            $require = APPLICATION_PATH . '/examples/' . $source;
            $this->runTestWithExample($require, basename($require));
        }
    }
}
