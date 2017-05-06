<?php

/**
 * Custom PDF class extention for Header and Footer Definitions
 *
 * @author office@interpid.eu
 *
 */

require_once( APPLICATION_PATH . "/mypdf.php" );
require_once( APPLICATION_PATH . "/classes/pdf.php" );
require_once( APPLICATION_PATH . "/classes/pdftable.php" );

require_once( __DIR__ . "/Helper.php" );

class testPdf extends myPdf
{


    /**
     * Custom Header
     *
     * @see Pdf::Header()
     */
    public function Header()
    {
    }


    /**
     * Custom Footer
     *
     * @see Pdf::Footer()
     */
    public function Footer()
    {
        $this->SetY( -10 );
        Helper::setFontStyle1( $this );
        $this->SetTextColor( 170, 170, 170 );
        $this->MultiCell( 0, 4, "Page {$this->PageNo()} / {nb}", 0, 'C' );

        $this->drawMarginLines();
    }
}

