<?php

require( 'settings.php' );

if ( !isset( $pdf ) ) {
    $pdf = new \Interpid\PdfExamples\myPdf();
}

use \Interpid\Pdf\Table;

$table = new Table( $pdf );

$table->setStyle( "p", 'Helvetica', "", 6, "130,0,30" );
$table->setStyle( "b", 'Helvetica', "B", 6, "130,0,30" );
$table->setStyle( "bi", 'Helvetica', "BI", 6, "0,0,120" );
$table->setStyle( "s1", 'Helvetica', "I", 6, "0,0,120" );
$table->setStyle( "s2", 'Helvetica', "", 7, "110,50,120" );
$table->setStyle( "h1", 'Helvetica', "", 10, "255,0,0" );

$columns = 3;

$resultSet = array(
    array( 'one', 'two', 'three' ),
    array( 'four', 'five', 'six' ),
    array( 'seven', 'eight', 'nine' ),
    array( 'one1', 'two', 'three' ),
    array( 'four2', 'five', 'six' ),
    array( 'seven3', 'eight', 'nine' ),
    array( 'one4', 'two', 'three' ),
    array( 'four5', 'five', 'six' ),
    array( 'seven6', 'eight', 'nine' )
);

/**
 * Set the tag styles
 */

$table->initialize( array( 20, 30, 40 ) );

foreach ( $resultSet as $resultRow ) {
    $aRow = [];
    $aRow[ 0 ][ 'TEXT' ] = $resultRow[ 0 ];
    $aRow[ 1 ][ 'TEXT' ] = $resultRow[ 1 ];
    $aRow[ 2 ][ 'TEXT' ] = $resultRow[ 2 ];
    $table->addRow( $aRow );
}

$table->close();

/**
 * Set the tag styles
 */
$table->initialize( array( 20, 80, 30 ) );


$header = [
    [ 'TEXT' => 'Id' ],
    [ 'TEXT' => 'Details' ],
    [ 'TEXT' => 'Date' ]
];

//add the header row
$table->addHeader( $header );

$resultSet2 = [
    [ 1, 1, 'MARY', 'SMITH', 'MARY.SMITH@sakilacustomer.org', 5, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 2, 1, 'PATRICIA', 'JOHNSON', 'PATRICIA.JOHNSON@sakilacustomer.org', 6, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 3, 1, 'LINDA', 'WILLIAMS', 'LINDA.WILLIAMS@sakilacustomer.org', 7, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 4, 2, 'BARBARA', 'JONES', 'BARBARA.JONES@sakilacustomer.org', 8, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 5, 1, 'ELIZABETH', 'BROWN', 'ELIZABETH.BROWN@sakilacustomer.org', 9, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 6, 2, 'JENNIFER', 'DAVIS', 'JENNIFER.DAVIS@sakilacustomer.org', 10, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 7, 1, 'MARIA', 'MILLER', 'MARIA.MILLER@sakilacustomer.org', 11, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 8, 2, 'SUSAN', 'WILSON', 'SUSAN.WILSON@sakilacustomer.org', 12, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 9, 2, 'MARGARET', 'MOORE', 'MARGARET.MOORE@sakilacustomer.org', 13, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 10, 1, 'DOROTHY', 'TAYLOR', 'DOROTHY.TAYLOR@sakilacustomer.org', 14, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 11, 2, 'LISA', 'ANDERSON', 'LISA.ANDERSON@sakilacustomer.org', 15, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 12, 1, 'NANCY', 'THOMAS', 'NANCY.THOMAS@sakilacustomer.org', 16, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 13, 2, 'KAREN', 'JACKSON', 'KAREN.JACKSON@sakilacustomer.org', 17, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 14, 2, 'BETTY', 'WHITE', 'BETTY.WHITE@sakilacustomer.org', 18, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 15, 1, 'HELEN', 'HARRIS', 'HELEN.HARRIS@sakilacustomer.org', 19, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 16, 2, 'SANDRA', 'MARTIN', 'SANDRA.MARTIN@sakilacustomer.org', 20, 0, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
    [ 17, 1, 'DONNA', 'THOMPSON', 'DONNA.THOMPSON@sakilacustomer.org', 21, 1, '2006-02-14 22:04:36', '2006-02-15 04:57:20' ],
];

foreach ( $resultSet2 as $key => $resultRow ) {
    $aRow = [];
    $aRow[ 0 ][ 'TEXT' ] = $resultRow[ 0 ];
    $aRow[ 1 ][ 'TEXT' ] = sprintf( "<b>%s - %s</b>\n <s1>%s</s1>", $resultRow[ 2 ], $resultRow[ 3 ], $resultRow[ 4 ] );
    if ( $key % 2 ) {
        $aRow[ 1 ][ 'ALIGN' ] = "L";
    }
    $aRow[ 2 ][ 'TEXT' ] = $resultRow[ 7 ];
    $table->addRow( $aRow );
}


//close the table
$table->close();
