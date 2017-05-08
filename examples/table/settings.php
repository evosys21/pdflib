<?php

//define some background colors

if ( !defined( 'PDF_APPLICATION_PATH' ) ) {
    define( 'PDF_APPLICATION_PATH', __DIR__ . '/../..' );
}

$aColor = [
    [ 234, 255, 218 ],
    [ 165, 250, 220 ],
    [ 255, 252, 249 ],
    [ 86, 155, 225 ],
    [ 207, 247, 239 ],
    [ 246, 211, 207 ],
    [ 216, 243, 228 ]
];


//top, right, bottom, left
$aPaddings = [
    [ 0, 0, 0, 0 ],
    [ 1, 1, 1, 1 ],
    [ 2, 2, 2, 2 ],
    [ 3, 3, 3, 3 ],
    [ 4, 4, 4, 4 ],
    [ 5, 5, 5, 5 ],
    [ 5, 0, 0, 0 ],
    [ 0, 5, 0, 0 ],
    [ 0, 0, 5, 0 ],
    [ 0, 0, 0, 5 ],
    [ 5, 5, 0, 0 ],
    [ 0, 5, 5, 0 ],
    [ 0, 0, 5, 5 ],
    [ 5, 0, 0, 5 ],
    [ 5, 5, 5, 0 ],
    [ 0, 5, 5, 5 ],
    [ 5, 0, 5, 5 ],
    [ 5, 5, 0, 5 ]
];


$alignments = [ 'TL', 'TC', 'TR', 'ML', 'MC', 'MR', 'BL', 'BC', 'BR' ];


$sTextShort = "Hello world!";
$sText = "Lorem ipsum dolor sit amet...";
$sText2 = "<p>Simple text\n<b>Bold text</b></p>";
$sTextLong = "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>";
$sTextExtraLong = "<p><s1><b>Lorem ipsum</b> dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</s1><s2> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</s2></p>";
$sTextSubSuperscript = "<ss ypos='-0.8'>Subscript</ss> or <ss ypos='1.1'>Superscript</ss>";

$dataRow = [];
$headerRow = [];

//prepare some default row settings
for ( $i = 0; $i < 5; $i++ ) {
    $headerRow[ $i ][ 'TEXT' ] = "Header #$i";
    $dataRow[ $i ][ 'TEXT' ] = "Cool <b>cell</b>";
}

$imageCell = array(
    'TYPE' => 'IMAGE',
    'FILE' => PDF_RESOURCES_IMAGES . '/dice.jpg',
    'WIDTH' => 10
);
