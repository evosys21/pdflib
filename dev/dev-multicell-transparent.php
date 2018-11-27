<?php

/**
 * Pdf Advanced Multicell - Example
 * Copyright (c), Andrei Bintintan, http://www.interpid.eu
 */

require 'dev-includes.php';

// create new PDF document
$oPdf = new myPdfMulticell();

$oPdf->SetMargins(20, 20, 20);

//set default font/colors
$oPdf->SetFont('helvetica', '', 11);
$oPdf->SetTextColor(200, 10, 10);
$oPdf->SetFillColor(254, 255, 245);

//add the page
$oPdf->AddPage();
$oPdf->AliasNbPages();


$y = $oPdf->GetY();
$oPdf->Image("flash2.jpg");

$oPdf->SetY($y);


/**
 * Create the Advanced Multicell Object and pass the PDF object as a parameter to the constructor
 */
$oMulticell = new PdfMulticell($oPdf);
$oMulticell->enableFill(true);

/**
 * Set the styles for the advanced multicell
 */
$oMulticell->setStyle("p", $oPdf->getDefaultFontName(), "", 11, "130,0,30");
$oMulticell->setStyle("b", $oPdf->getDefaultFontName(), "B", 11, "130,0,30");
$oMulticell->setStyle("i", $oPdf->getDefaultFontName(), "I", 11, "80,80,260");
$oMulticell->setStyle("u", $oPdf->getDefaultFontName(), "U", 11, "80,80,260");
$oMulticell->setStyle("h1", $oPdf->getDefaultFontName(), "", 11, "80,80,260");
$oMulticell->setStyle("h3", $oPdf->getDefaultFontName(), "B", 12, "203,0,48");
$oMulticell->setStyle("h4", $oPdf->getDefaultFontName(), "BI", 11, "0,151,200");
$oMulticell->setStyle("hh", $oPdf->getDefaultFontName(), "B", 11, "255,189,12");
$oMulticell->setStyle("ss", $oPdf->getDefaultFontName(), "", 7, "203,0,48");
$oMulticell->setStyle("font", $oPdf->getDefaultFontName(), "", 10, "0,0,255");
$oMulticell->setStyle("style", $oPdf->getDefaultFontName(), "BI", 10, "0,0,220");
$oMulticell->setStyle("size", $oPdf->getDefaultFontName(), "BI", 12, "0,0,120");
$oMulticell->setStyle("color", $oPdf->getDefaultFontName(), "BI", 12, "0,255,255");

//read TAG formatted text from files
$sTxt1 = file_get_contents('content/createdby.txt');
$sTxt2 = file_get_contents('content/multicell.txt');

//create an advanced multicell
$oMulticell->multiCell(150, 5, $sTxt1, 1, "L", 1, 5, 5, 5, 5);
$oPdf->Ln(10); //new line

//send the pdf to the browser
$oPdf->Output();
