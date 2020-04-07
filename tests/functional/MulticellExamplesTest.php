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
 * Class MulticellExamplesTest
 * @group functional
 */
class MulticellExamplesTest extends BaseExamplesTestCase
{

    /**
     * Tests testExample1
     */
    public function testExamples()
    {
        $aSources = array(
            'example-multicell-1-overview.php',
            'example-multicell-2-overview-page-break.php',
            'example-multicell-3-line-breaking.php',
            'example-multicell-4-page-break.php',
            'example-multicell-5-max-lines.php',
        );

        foreach ($aSources as $source) {
            $require = APPLICATION_PATH . '/examples/' . $source;
            $this->runTestWithExample($require, basename($require));
        }
    }
}
