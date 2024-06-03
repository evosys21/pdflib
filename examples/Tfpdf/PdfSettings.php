<?php
/** @noinspection PhpUnused */

namespace evosys21\PdfLib\Examples\Tfpdf;

use evosys21\PdfLib\Multicell;
use evosys21\PdfLib\Table;

if (!defined('__DIR__')) {
    define('__DIR__', __DIR__ . '/../../..');
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
    public static $paddings = [
        [0, 0, 0, 0],
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
        'FILE' => __DIR__ . '/content/images/dice.jpg',
        'WIDTH' => 10
    );

    public static function headerRow(): array
    {
        $headerRow = [];
        for ($i = 0; $i < static::$columns; $i++) {
            $headerRow[$i]['TEXT'] = "Header #$i";
        }
        return $headerRow;
    }

    public static function dataRow(): array
    {
        $dataRow = [];
        for ($i = 0; $i < static::$columns; $i++) {
            $dataRow[$i]['TEXT'] = "Cool <b>cell</b>";
        }
        return $dataRow;
    }


    /**
     * Set the styles for the advanced multicell
     *
     * @param $multicell Multicell
     */
    public static function setMulticellStyles(Multicell $multicell)
    {
        // 'default' style will be applied to all tags
        $multicell->setStyle('default', 11, '', '130,0,30', 'helvetica');
        $multicell->setStyle('b', null, 'B');
        $multicell->setStyle('i', null, 'I', '80,80,260');
        $multicell->setStyle('u', null, 'U', '80,80,260');
        $multicell->setStyle('h1', 14, 'B', '203,0,48');
        $multicell->setStyle('h3', 12, 'B', '203,0,48');
        $multicell->setStyle('h4', 11, 'BI', '0,151,200');
        $multicell->setStyle('hh', 11, 'B', '255,189,12');
        $multicell->setStyle('ss', 7, '', '203,0,48');
        $multicell->setStyle('font', 10, '', '0,0,255');
        $multicell->setStyle('style', 10, 'BI', '0,0,220');
        $multicell->setStyle('size', 12, 'BI', '0,0,120');
        $multicell->setStyle('color', 12, 'BI', '0,255,255');
        $multicell->setStyle('s1', 8, null, '118,0,3');
        $multicell->setStyle('s2', 6, null, '0,49,159');
        $multicell->setStyle('code', 9, '', null, 'courier');

        //set the style for utf8 texts, use 'dejavusans' fonts
        $multicell->setStyle('u8', null, '', [0, 45, 179], 'dejavusans');
        $multicell->setStyle('u8b', null, 'B', null, null, 'u8');
    }
    
    
    /**
     * Set the styles for the advanced table
     * 
     * @param Table $table
     */
    public static function setTableStyles(Table $table)
    {
        // Set the styles for the advanced table
        $table->setStyle('p', 10, '', '130,0,30', 'helvetica');
        $table->setStyle('b', 9, 'B', '80,80,260', 'helvetica');
        $table->setStyle('h1', 10, '', '0,151,200', 'helvetica');
        $table->setStyle('bi', 12, 'BI', '0,0,120', 'helvetica');

        //set the style for utf8 texts, use 'dejavusans' fonts
        $table->setStyle('u8', null, '', [0, 45, 179], 'dejavusans');
        $table->setStyle('u8b', null, 'B', null, null, 'u8');
    }
}
