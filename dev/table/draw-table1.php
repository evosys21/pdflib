<?php
/**
 * Create the pdf Table object
 * Alternative you can use the Singleton Instance
 *
 * @example : $oTable = PdfTable::getInstance($oPdf);
 */
require_once("../settings.php");
require_once("../table.config.php");

$oTable = new PdfTable($oPdf);

/**
 * Set the tag styles
 */
$oTable->setStyle("p", $oPdf->getDefaultFontName(), "", 10, "130,0,30");
$oTable->setStyle("b", $oPdf->getDefaultFontName(), "B", 8, "80,80,260");
$oTable->setStyle("h1", $oPdf->getDefaultFontName(), "", 10, "0,151,200");
$oTable->setStyle("bi", $oPdf->getDefaultFontName(), "BI", 12, "0,0,120");

$nColumns = 4;


$oTable->initialize(array(20, 30, 50, 30), $aDefaultConfiguration);


$aHeader = array();

//Table Header
for ($i = 0; $i < $nColumns; $i++) {
    $aHeader[ $i ][ 'TEXT' ] = "Header #" . ($i + 1);
    //$aHeader[ $i ][ '' ]
}

//add the header
#$oTable->addHeader( $aHeader );
#$oTable->addHeader( $aHeader );
#$oTable->addHeader();

for ($j = 1; $j < 10; $j++) {
    $row = Array();
    $row[ 0 ][ 'TEXT' ] = "This is\nLine $j";
    $row[ 1 ][ 'TEXT' ] = $sText;
    $align = Pdf_Tools::getNextValue($aAlignments, $nAlign);
    $row[ 2 ][ 'TEXT' ] = "ALIGN = <b>$align</b>";
    $row[ 2 ][ 'ALIGN' ] = $align;
    $row[ 3 ][ 'TEXT' ] = $sText;

    //add the row
    $oTable->addRow($row);

    break;
}

//close the table
$oTable->close();
