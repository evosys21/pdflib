<?php

$columns = 3;

//Initialize the table, 3 columns
$table->initialize([40, 50, 30]);

$header = [];

//Table Header
for ($i = 0; $i < $columns; $i++) {
    $header[$i]['TEXT'] = 'Header #' . ($i + 1);
}

//add the header
$table->addHeader($header);

for ($j = 1; $j < 5; $j++) {
    $row = [];
    $row[0]['TEXT'] = "Line $j Text 1"; //text for column 0
    $row[0]['TEXT_ALIGN'] = 'L'; //text align
    //$row[0]['LINE_SIZE'] = 7; //text align
    $row[1]['TEXT'] = "Line $j Text 2"; //text for column 1
    $row[2]['TEXT'] = "Line $j Text 3"; //text for column 2
    $row[2]['TEXT_ALIGN'] = 'R'; //text align

    //add the row
    $table->addRow($row);
    //break;
}

//close the table
$table->close();
