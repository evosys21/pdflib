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

namespace Interpid\PdfExamples;

if (!defined('PDF_APPLICATION_PATH')) {
    define('PDF_APPLICATION_PATH', __DIR__ . '/../../..');
}

class PdfSettings
{

    public static $colors = [
        [234, 255, 218],
        [165, 250, 220],
        [255, 252, 249],
        [86, 155, 225],
        [207, 247, 239],
        [246, 211, 207],
        [216, 243, 228]
    ];


    //top, right, bottom, left
    public static $paddings = [[0, 0, 0, 0],
        [1, 1, 1, 1],
        [2, 2, 2, 2],
        [3, 3, 3, 3],
        [4, 4, 4, 4],
        [5, 5, 5, 5],
        [5, 0, 0, 0],
        [0, 5, 0, 0],
        [0, 0, 5, 0],
        [0, 0, 0, 5],
        [5, 5, 0, 0],
        [0, 5, 5, 0],
        [0, 0, 5, 5],
        [5, 0, 0, 5],
        [5, 5, 5, 0],
        [0, 5, 5, 5],
        [5, 0, 5, 5],
        [5, 5, 0, 5]
    ];


    public static $alignments = ['TL', 'TC', 'TR', 'ML', 'MC', 'MR', 'BL', 'BC', 'BR'];


    public static $textShort = "Hello world!";
    public static $text = "Lorem ipsum dolor sit amet...";
    public static $text2 = "<p>Simple text\n<b>Bold text</b></p>";
    public static $textLong = "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>";
    public static $textExtraLong = "<p><s1><b>Lorem ipsum</b> dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</s1><s2> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</s2></p>";
    public static $textSubSuperscript = "<ss ypos='-0.8'>Subscript</ss> or <ss ypos='1.1'>Superscript</ss>";

    public static $columns = 5;

    //prepare some default row settings
    public static $imageCell = array(
        'TYPE' => 'IMAGE',
        'FILE' => PDF_RESOURCES_IMAGES . '/dice.jpg',
        'WIDTH' => 10
    );

    public static function headerRow()
    {
        $headerRow = [];
        for ($i = 0; $i < static::$columns; $i++) {
            $headerRow[$i]['TEXT'] = "Header #$i";
        }
        return $headerRow;
    }

    public static function dataRow()
    {
        $dataRow = [];
        for ($i = 0; $i < static::$columns; $i++) {
            $dataRow[$i]['TEXT'] = "Cool <b>cell</b>";
        }
        return $dataRow;
    }
}
