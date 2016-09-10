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
        $oPdf = new testPdf( 'P', 'mm', array(
            130,
            180
        ) );

        $factory = new pdfFactory();
        $factory->initPdfObject( $oPdf );

        //disable compression for testing
        $oPdf->SetCompression( false );

        return $oPdf;
    }

    /**
     * @param $pdf
     */
    public static function setFontStyle1( $pdf )
    {
        $pdf->SetFont( $pdf->getDefaultFontName(), 'I', 7 );
        $pdf->SetTextColor( 170, 170, 170 );
    }

} 