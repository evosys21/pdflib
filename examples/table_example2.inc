<?php

$columns = 3;

//Initialize the table class, 3 columns
$table->initialize( [ 40, 50, 30 ] );

$header = [];

//Table Header
for ( $i = 0; $i < $columns; $i++ ) {
    $header[ $i ][ 'TEXT' ] = "Header #" . ( $i + 1 );
}

$table->addHeader( $header );
$table->addHeader( $header );
$table->addHeader( $header );

$table->setHeaderProperty( 1, 'TEXT', 'Rowspan/Colspan can be made also in the header.' );
$table->setHeaderProperty( 1, 'ROWSPAN', 2 );
$table->setHeaderProperty( 1, 'COLSPAN', 2 );
$table->setHeaderProperty( 1, 'BACKGROUND_COLOR', $aBgColor4 );
$table->setHeaderProperty( 1, 'TEXT_COLOR', [ 0, 0, 0 ] );

if ( isset( $tableSplitMode ) ) {
    $table->setSplitMode( $tableSplitMode );
}

for ( $j = 1; $j <= 15; $j++ ) {
    $aRow = [];
    $aRow[ 0 ][ 'TEXT' ] = "Line $j Text 1";
    $aRow[ 1 ][ 'TEXT' ] = "Line $j Text 2";
    $aRow[ 2 ][ 'TEXT' ] = "Line $j Text 3";

    if ( $j == 1 ) {
        $aRow[ 0 ][ 'BACKGROUND_COLOR' ] = $aBgColor5;
        $aRow[ 0 ][ 'TEXT' ] = 'Colspan Example';
        $aRow[ 0 ][ 'COLSPAN' ] = 2;
    }

    if ( $j == 2 ) {
        $aRow[ 1 ][ 'BACKGROUND_COLOR' ] = $aBgColor6;
        $aRow[ 1 ][ 'TEXT' ] = 'Rowspan Example';
        $aRow[ 1 ][ 'ROWSPAN' ] = 2;
    }

    if ( $j == 4 ) {
        $aRow[ 1 ][ 'BACKGROUND_COLOR' ] = $bg_color7;
        $aRow[ 1 ][ 'TEXT' ] = 'Rowspan && Colspan Example';
        $aRow[ 1 ][ 'ROWSPAN' ] = 2;
        $aRow[ 1 ][ 'COLSPAN' ] = 2;
    }

    if ( ( $j >= 7 ) && ( $j <= 9 ) ) {
        $aRow[ 0 ][ 'TEXT' ] = "More lines...\nLine2\nLine3";
    }

    if ( $j == 7 ) {
        $aRow[ 1 ][ 'TEXT' ] = "Top Left Align";
        $aRow[ 1 ][ 'VERTICAL_ALIGN' ] = "T";
        $aRow[ 1 ][ 'TEXT_ALIGN' ] = "L";

        $aRow[ 2 ][ 'TEXT' ] = "Bottom Right Align";
        $aRow[ 2 ][ 'VERTICAL_ALIGN' ] = "B";
        $aRow[ 2 ][ 'TEXT_ALIGN' ] = "R";
    }

    if ( $j == 8 ) {
        $aRow[ 1 ][ 'TEXT' ] = "Top Center Align";
        $aRow[ 1 ][ 'VERTICAL_ALIGN' ] = "T";
        $aRow[ 1 ][ 'TEXT_ALIGN' ] = "C";

        $aRow[ 2 ][ 'TEXT' ] = "Bottom Center Align";
        $aRow[ 2 ][ 'VERTICAL_ALIGN' ] = "B";
        $aRow[ 2 ][ 'TEXT_ALIGN' ] = "C";
    }

    if ( $j == 9 ) {
        $table->setStyle( "sd1", $pdf->getDefaultFontName(), "", 6, "0,49,159" );
        $table->setStyle( "sd2", $pdf->getDefaultFontName(), "", 5, "140,12,12" );
        $table->setStyle( "sd3", $pdf->getDefaultFontName(), "", 6, "0,5,90" );

        $aRow[ 1 ][ 'TEXT' ] = "<sd1>This is just a longer text, justified align, middle vertical align to demonstrate some other capabilities. Test text. Test text.</sd1>
<sd3>\tSettings:</sd3>
<p size='15' > ~~~</p><sd2>- Rowspan=4</sd2>
<p size='15' > ~~~</p><sd2>- Colspan=2</sd2>
";

        $aRow[ 1 ][ 'VERTICAL_ALIGN' ] = "M";
        $aRow[ 1 ][ 'TEXT_ALIGN' ] = "J";
        $aRow[ 1 ][ 'COLSPAN' ] = 2;
        $aRow[ 1 ][ 'ROWSPAN' ] = 4;
        $aRow[ 1 ][ 'LINE_SIZE' ] = 2.3;
    }

    if ( $j == 14 ) {
        $aRow[ 1 ][ 'TEXT' ] = "Cell Properties Overwriting Example";
        $aRow[ 1 ][ 'TEXT_FONT' ] = "Times";
        $aRow[ 1 ][ 'TEXT_SIZE' ] = 7;
        $aRow[ 1 ][ 'TEXT_TYPE' ] = "B";
        $aRow[ 1 ][ 'BACKGROUND_COLOR' ] = [ 240, 240, 209 ];
        $aRow[ 1 ][ 'BORDER_COLOR' ] = [ 100, 100, 200 ];

        $aRow[ 1 ][ 'VERTICAL_ALIGN' ] = "T";
        $aRow[ 1 ][ 'TEXT_ALIGN' ] = "C";
    }

    $table->addRow( $aRow );
}

//close the table
$table->close();
