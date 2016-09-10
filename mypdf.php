<?php

/**
 * Custom PDF class extention for Header and Footer Definitions
 *
 * @author andy@interpid.eu
 *
 */
class myPdf extends Pdf
{

    protected $headerSource = "header.txt";

    /**
     * Custom Header
     *
     * @see Pdf::Header()
     */
    public function Header()
    {
        $this->SetY( 10 );

        /**
         * yes, even here we can use the multicell tag! this will be a local object
         */
        $oMulticell = PdfMulticell::getInstance( $this );

        $oMulticell->SetStyle( "h1", $this->getDefaultFontName(), "", 6, "160,160,160" );
        $oMulticell->SetStyle( "h2", $this->getDefaultFontName(), "", 6, "0,119,220" );

        $oMulticell->multiCell( 100, 3, file_get_contents( __DIR__ . '/content/' . $this->headerSource ) );

        $this->Image( __DIR__ . '/images/interpid_logo.png', 160, 10, 40, 0, '', 'http://www.interpid.eu' );
        $this->SetY( $this->tMargin );
    }


    /**
     * Custom Footer
     *
     * @see Pdf::Footer()
     */
    public function Footer()
    {
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

    /**
     * Draws the margin lines.
     * It's helpful during development
     */
    public function drawMarginLines()
    {
        //draw the top and bottom margins
        $ytop = $this->tMargin;
        $ybottom = $this->h - 20;

        $this->SetLineWidth( 0.1 );
        $this->SetDrawColor( 150, 150, 150 );
        $this->Line( 0, $ytop, $this->w, $ytop );
        $this->Line( 0, $ybottom, $this->w, $ybottom );
        $this->Line( $this->rMargin, 0, $this->rMargin, $this->h );
        $this->Line( $this->w - $this->rMargin, 0, $this->w - $this->rMargin, $this->h );
    }


    /**
     * Disable the Producer and CreationDate. It breaks the functional unit-testing(date always changes)
     */
    function _putinfo()
    {
        if ( isset( $_SERVER[ 'ENVIRONMENT' ] ) && 'test' == $_SERVER[ 'ENVIRONMENT' ] )
        {
            if ( !empty( $this->title ) )
                $this->_out( '/Title ' . $this->_textstring( $this->title ) );
            if ( !empty( $this->subject ) )
                $this->_out( '/Subject ' . $this->_textstring( $this->subject ) );
            if ( !empty( $this->author ) )
                $this->_out( '/Author ' . $this->_textstring( $this->author ) );
            if ( !empty( $this->keywords ) )
                $this->_out( '/Keywords ' . $this->_textstring( $this->keywords ) );
            if ( !empty( $this->creator ) )
                $this->_out( '/Creator ' . $this->_textstring( $this->creator ) );
        } else
        {
            parent::_putinfo();
        }
    }
}

