<?php

$columns = 3;

//Initialize the table, 3 columns
$table->initialize([40, 50, 30]);

$header = [];

//Table Header
for ($i = 0; $i < $columns; $i++) {
    $header[$i]['TEXT'] = "Header #" . ($i + 1);
}

$table->addHeader($header);
$table->addHeader($header);
$table->addHeader($header);

$table->setHeaderProperty(1, 'TEXT', 'Rowspan/Colspan can be made also in the header.');
$table->setHeaderProperty(1, 'ROWSPAN', 2);
$table->setHeaderProperty(1, 'COLSPAN', 2);
$table->setHeaderProperty(1, 'BACKGROUND_COLOR', $bgColor4);
$table->setHeaderProperty(1, 'TEXT_COLOR', [0, 0, 0]);

if (isset($tableSplitMode)) {
    $table->setSplitMode($tableSplitMode);
}

for ($j = 1; $j <= 15; $j++) {
    $row = [];
    $row[0]['TEXT'] = "Line $j Text 1";
    $row[1]['TEXT'] = "Line $j Text 2";
    $row[2]['TEXT'] = "Line $j Text 3";

    if ($j == 1) {
        $row[0]['BACKGROUND_COLOR'] = $bgColor5;
        $row[0]['TEXT'] = 'Colspan Example';
        $row[0]['COLSPAN'] = 2;
    }

    if ($j == 2) {
        $row[1]['BACKGROUND_COLOR'] = $bgColor6;
        $row[1]['TEXT'] = 'Rowspan Example';
        $row[1]['ROWSPAN'] = 2;
    }

    if ($j == 4) {
        $row[1]['BACKGROUND_COLOR'] = $bgColor7;
        $row[1]['TEXT'] = 'Rowspan and Colspan Example';
        $row[1]['ROWSPAN'] = 2;
        $row[1]['COLSPAN'] = 2;
    }

    if (($j >= 7) and ($j <= 9)) {
        $row[0]['TEXT'] = "More lines...\nLine2\nLine3";
    }

    if ($j == 7) {
        $row[1]['TEXT'] = "Top Left Align";
        $row[1]['VERTICAL_ALIGN'] = 'T';
        $row[1]['TEXT_ALIGN'] = 'L';

        $row[2]['TEXT'] = "Bottom Right Align";
        $row[2]['VERTICAL_ALIGN'] = 'B';
        $row[2]['TEXT_ALIGN'] = 'R';
    }

    if ($j == 8) {
        $row[1]['TEXT'] = "Top Center Align";
        $row[1]['VERTICAL_ALIGN'] = 'T';
        $row[1]['TEXT_ALIGN'] = 'C';

        $row[2]['TEXT'] = "Bottom Center Align";
        $row[2]['VERTICAL_ALIGN'] = 'B';
        $row[2]['TEXT_ALIGN'] = 'C';
    }

    if ($j == 9) {
        $table->setStyle('sd1', 6, '', '0,49,159', 'helvetica');
        $table->setStyle('sd2', 5, '', '140,12,12', 'helvetica');
        $table->setStyle('sd3', 6, '', '0,5,90', 'helvetica');

        $row[1]['TEXT'] = "<sd1>This is just a longer text, justified align, middle vertical align to demonstrate some other capabilities. Test text. Test text.</sd1>
<sd3>\tSettings:</sd3>
<p size='15' > ~~~</p><sd2>- Rowspan=4</sd2>
<p size='15' > ~~~</p><sd2>- Colspan=2</sd2>
";

        $row[1]['VERTICAL_ALIGN'] = 'M';
        $row[1]['TEXT_ALIGN'] = 'J';
        $row[1]['COLSPAN'] = 2;
        $row[1]['ROWSPAN'] = 4;
        $row[1]['LINE_SIZE'] = 2.3;
    }

    if ($j == 14) {
        $row[1]['TEXT'] = "Cell Properties Overwriting Example";
        $row[1]['TEXT_FONT'] = 'Times';
        $row[1]['TEXT_SIZE'] = 7;
        $row[1]['TEXT_TYPE'] = 'B';
        $row[1]['BACKGROUND_COLOR'] = [240, 240, 209];
        $row[1]['BORDER_COLOR'] = [100, 100, 200];

        $row[1]['VERTICAL_ALIGN'] = 'T';
        $row[1]['TEXT_ALIGN'] = 'C';
    }

    $table->addRow($row);
}

//close the table
$table->close();
