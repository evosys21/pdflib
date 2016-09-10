<?php

//define some background colors

$aColor = array(
    array( 234, 255, 218 ),
    array( 165, 250, 220 ),
    array( 255, 252, 249 ),
    array( 86, 155, 225 ),
    array( 207, 247, 239 ),
    array( 246, 211, 207 ),
    array( 216, 243, 228 ) );


//top, right, bottom, left
$aPaddings = array(
    array( 0, 0, 0, 0 ),
    array( 1, 1, 1, 1 ),
    array( 2, 2, 2, 2 ),
    array( 3, 3, 3, 3 ),
    array( 4, 4, 4, 4 ),
    array( 5, 5, 5, 5 ),
    array( 5, 0, 0, 0 ),
    array( 0, 5, 0, 0 ),
    array( 0, 0, 5, 0 ),
    array( 0, 0, 0, 5 ),
    array( 5, 5, 0, 0 ),
    array( 0, 5, 5, 0 ),
    array( 0, 0, 5, 5 ),
    array( 5, 0, 0, 5 ),
    array( 5, 5, 5, 0 ),
    array( 0, 5, 5, 5 ),
    array( 5, 0, 5, 5 ),
    array( 5, 5, 0, 5 ),
);


$aAlignments = array( 'TL', 'TC', 'TR', 'ML', 'MC', 'MR', 'BL', 'BC', 'BR' );


$sTextShort = "Hello world!";
$sText = "Lorem ipsum dolor sit amet...";
$sText2 = "<p>Simple text\n<b>Bold text</b></p>";
$sTextLong = "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>";
$sTextExtraLong = "<p><s1><b>Lorem ipsum</b> dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</s1><s2> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</s2></p>";
$sTextSubSuperscript = "<ss ypos='-0.8'>Subscript</ss> or <ss ypos='1.1'>Superscript</ss>";


//prepare some default row settings
for ( $i = 0; $i < 5; $i++ )
{
    $aHeaderRow[ $i ][ 'TEXT' ] = "Header #$i";
    $aDataRow[ $i ][ 'TEXT' ] = "Cool <b>cell</b>";
}

$aImageCell = array(
    'TYPE' => 'IMAGE',
    'FILE' => PDF_APPLICATION_PATH . '/images/dice.jpg',
    'WIDTH' => 10
);
