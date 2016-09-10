<?php

/**
 * Pdf Factory
 * Contains functions that creates and initializes the PDF class
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.
 *
 * IN NO EVENT SHALL WE OR OUR SUPPLIERS BE LIABLE FOR ANY SPECIAL, INCIDENTAL, INDIRECT
 * OR CONSEQUENTIAL DAMAGES WHATSOEVER (INCLUDING, WITHOUT LIMITATION, DAMAGES FOR LOSS
 * OF BUSINESS PROFITS, BUSINESS INTERRUPTION, LOSS OF BUSINESS INFORMATION OR ANY OTHER
 * PECUNIARY LAW) ARISING OUT OF THE USE OF OR INABILITY TO USE THE SOFTWARE, EVEN IF WE
 * HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.
 *
 * @version   : 5.1.0
 * @author    : Andrei Bintintan <andy@interpid.eu>
 * @copyright : Copyright (c) 2014, Andrei Bintintan, http://www.interpid.eu
 * @license   : http://www.interpid.eu/pdf-addons/eula
 */

if ( !defined( 'PDF_RESOURCES_IMAGES' ) )
{
    define( 'PDF_RESOURCES_IMAGES', dirname( __FILE__ ) . '/images' );
}

//include pdf class
require_once( "classes/pdf.php" );


class pdfFactory
{

    /**
     * Initializes the pdf object.
     * Opens the object, sets the margins, adds default fonts etc...
     *
     * @param Pdf $pdf
     * @return Pdf $pdf
     */
    public function initPdfObject( $pdf )
    {
        $pdf->Open();
        $pdf->SetMargins( 20, 20, 20 );

        //set default font/colors
        $pdf->SetFont( 'helvetica', '', 11 );
        $pdf->SetTextColor( 200, 10, 10 );
        $pdf->SetFillColor( 254, 255, 245 );

        // add a page
        $pdf->AddPage();
        $pdf->AliasNbPages();

        //disable compression for unit-testing!
        if ( isset( $_SERVER[ 'ENVIRONMENT' ] ) && 'test' == $_SERVER[ 'ENVIRONMENT' ] )
        {
            $pdf->SetCompression( false );
        }

        return $pdf;
    }
}

