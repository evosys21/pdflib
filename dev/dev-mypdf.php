<?php

/**
 * Custom PDF class extention for Header and Footer Definitions
 *
 * @author andy@interpid.eu
 *
 */

require_once 'dev-includes.php';
require_once 'settings.php';


if ( !defined( 'PDF_APPLICATION_PATH' ) )
{
    define( 'PDF_APPLICATION_PATH', dirname( __FILE__ ) . '/..' );
}

class devPdf extends Pdf
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
        //draw the top and bottom margins
        $ytop = $this->tMargin;
        $ybottom = $this->h - $this->bMargin;

        $this->SetLineWidth( 0.1 );
        $this->SetDrawColor( 150, 150, 150 );
        //$this->Rect($this->lMargin, $this->rMargin, $this->w - $this->lMargin - $this->rMargin, $this->h - $this->tMargin - $this->bMargin);
        $this->Line( 0, $ytop, $this->w, $ytop );
        $this->Line( 0, $ybottom, $this->w, $ybottom );
        $this->Line( $this->rMargin, 0, $this->rMargin, $this->h );
        $this->Line( $this->w - $this->rMargin, 0, $this->w - $this->rMargin, $this->h );

        $this->SetY( -10 );
        $this->SetFont( $this->getDefaultFontName(), 'I', 7 );
        $this->SetTextColor( 170, 170, 170 );
        $this->MultiCell( 0, 4, "Page {$this->PageNo()} / {nb}", 0, 'C' );
    }

    /**
     * Returns the default Font to be used
     *
     * @return string
     */
    public function getDefaultFontName()
    {
        return 'helvetica';
    }
}

