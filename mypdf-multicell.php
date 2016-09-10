<?php


/**
 * Custom PDF class extention for Header and Footer Definitions
 *
 * @author andy@interpid.eu
 *
 */

require_once( 'mypdf.php' );

class myPdfMulticell extends myPdf
{
    protected $headerSource = 'header-multicell.txt';
}

