<?php

/**
 * Created by PhpStorm.
 * User: andy
 * Date: 10/20/2014
 * Time: 10:21 PM
 */
class Helper
{

    /**
     * Returns the pdf object
     *
     * @return testPdf
     */
    public static function pdfObject1()
    {
        require_once( __DIR__ . '/testPdf.php' );

        //create the pdf object and do some initialization
        $pdf = new testPdf( 'P', 'mm', array(
            130,
            180
        ) );

        $factory = new pdfFactory();
        $factory->initPdfObject( $pdf );

        //disable compression for testing
        $pdf->SetCompression( false );

        return $pdf;
    }

    /**
     * @param $pdf
     */
    public static function setFontStyle1( $pdf )
    {
        $pdf->SetFont( 'Helvetica', 'I', 7 );
        $pdf->SetTextColor( 170, 170, 170 );
    }

} 