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


/**
 * Default configuration values for the PDF Advanced table
 */
return [

    'TABLE' => [
        'TABLE_ALIGN' => 'L', //table align on page
        'TABLE_LEFT_MARGIN' => 10, //space to the left margin
        'BORDER_COLOR' => [0, 92, 177], //border color
        'BORDER_SIZE' => '0.3', //border size
        'BORDER_TYPE' => '1', //border type, can be: 0, 1
    ],

    'HEADER' => [
        'TEXT_COLOR' => [220, 230, 240], //text color
        'TEXT_SIZE' => 8, //font size
        'TEXT_FONT' => 'helvetica', //font family
        'TEXT_ALIGN' => 'C', //horizontal alignment, possible values: LRCJ (left, right, center, justified)
        'VERTICAL_ALIGN' => 'M', //vertical alignment, possible values: TMB(top, middle, bottom)
        'TEXT_TYPE' => 'B', //font type
        'LINE_SIZE' => 4, //line size for one row
        'BACKGROUND_COLOR' => [41, 80, 132], //background color
        'BORDER_COLOR' => [0, 92, 177], //border color
        'BORDER_SIZE' => 0.2, //border size
        'BORDER_TYPE' => '1', //border type, can be: 0, 1 or a combination of: 'LRTB'
        'TEXT' => ' ', //default text
        //padding
        'PADDING_TOP' => 0, //padding top
        'PADDING_RIGHT' => 1, //padding right
        'PADDING_LEFT' => 1, //padding left
        'PADDING_BOTTOM' => 0, //padding bottom
    ],

    'ROW' => [
        'TEXT_COLOR' => [0, 0, 0], //text color
        'TEXT_SIZE' => 6, //font size
        'TEXT_FONT' => 'helvetica', //font family
        'TEXT_ALIGN' => 'C', //horizontal alignment, possible values: LRCJ (left, right, center, justified)
        'VERTICAL_ALIGN' => 'M', //vertical alignment, possible values: TMB(top, middle, bottom)
        'TEXT_TYPE' => '', //font type
        'LINE_SIZE' => 4, //line size for one row
        'BACKGROUND_COLOR' => [255, 255, 255], //background color
        'BORDER_COLOR' => [0, 92, 177], //border color
        'BORDER_SIZE' => 0.1, //border size
        'BORDER_TYPE' => '1', //border type, can be: 0, 1 or a combination of: 'LRTB'
        'TEXT' => ' ', //default text
        //padding
        'PADDING_TOP' => 1,
        'PADDING_RIGHT' => 1,
        'PADDING_LEFT' => 1,
        'PADDING_BOTTOM' => 1,
    ],
];

