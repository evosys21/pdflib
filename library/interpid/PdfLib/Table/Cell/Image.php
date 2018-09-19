<?php

/**
 * Pdf Table Cell Image
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
 * @version   : 5.4.0
 * @author    : Interpid <office@interpid.eu>
 * @copyright : Interpid, http://www.interpid.eu
 * @license   : http://www.interpid.eu/pdf-addons/eula
 */

namespace Interpid\PdfLib\Table\Cell;
use Interpid\PdfLib\Tools;

class Image extends CellAbstract implements CellInterface
{

    protected $sFile;

    protected $sType = '';

    protected $sLink = '';

    /**
     * Default alignment is Middle Center
     *
     * @var string
     */
    protected $alignment = 'MC';


    /**
     * Image cell constructor
     *
     * @param $pdf
     * @param string $file
     * @param int $width
     * @param int $height
     * @param string $type
     * @param string $link
     */
    public function __construct( $pdf, $file = '', $width = 0, $height = 0, $type = '', $link = '' )
    {
        parent::__construct( $pdf );

        if ( strlen( $file ) > 0 )
        {
            $this->setImage( $file, $width, $height, $type, $link );
        }
    }


    public function setProperties( array $aValues = array() )
    {
        //call the parent function
        parent::setProperties( $aValues );


        $this->setImage(
            Tools::getValue( $aValues, 'FILE' ),
            Tools::getValue( $aValues, 'WIDTH' ),
            Tools::getValue( $aValues, 'HEIGHT' ),
            Tools::getValue( $aValues, 'IMAGE_TYPE' ),
            Tools::getValue( $aValues, 'LINK' ) );
    }


    public function setImage( $file = '', $width = 0, $height = 0, $type = '', $link = '' )
    {
        $this->sFile = $file;
        $this->sType = $type;
        $this->sLink = $link;

        //check if file exists etc...
        $this->doChecks();

        list ( $width, $height ) = $this->pdfi->getImageParams( $file, $width, $height );

        $this->setContentWidth( $width );
        $this->setContentHeight( $height );
    }


    /**
     * Set image alignment.
     * It can be any combination of the 2 Vertical and Horizontal values:
     * Vertical values: TBM
     * Horizontal values: LRC
     *
     * @todo: check if this function is REALLY used
     * @param string $alignment
     */
    public function setAlign( $alignment )
    {
        $this->alignment = strtoupper( $alignment );
    }


    public function isSplittable()
    {
        return false;
    }


    public function getType()
    {
        return $this->sType;
    }


    public function getLink()
    {
        return $this->sLink;
    }


    /**
     * Renders the image in the pdf Object
     */
    public function render()
    {
        $this->renderCellLayout();

        $x = $this->pdf->GetX() + $this->getBorderSize();
        $y = $this->pdf->GetY() + $this->getBorderSize();

        //Horizontal Alignment
        if ( strpos( $this->alignment, 'J' ) !== false )
        {
            //justified - image is fully streched

            $x += $this->getPaddingLeft();
            $this->setContentWidth( $this->getCellDrawWidth() - 2 * $this->getBorderSize() - $this->getPaddingLeft() - $this->getPaddingRight() );
        }
        elseif ( strpos( $this->alignment, 'C' ) !== false )
        {
            //center
            $x += ( $this->getCellDrawWidth() - $this->getContentWidth() ) / 2;
        }
        elseif ( strpos( $this->alignment, 'R' ) !== false )
        {
            //right
            $x += $this->getCellDrawWidth() - $this->getContentWidth() - $this->getPaddingRight();
        }
        else
        {
            //left, this is default
            $x += $this->getPaddingLeft();
        }

        //Vertical Alignment
        if ( strpos( $this->alignment, 'T' ) !== false )
        {
            //top
            $y += $this->getPaddingTop();
        }
        elseif ( strpos( $this->alignment, 'B' ) !== false )
        {
            //bottom
            $y += $this->getCellDrawHeight() - $this->getContentHeight() - $this->getPaddingBottom();
        }
        else
        {
            //middle, this is default
            $y += ( $this->getCellDrawHeight() - $this->getContentHeight() ) / 2;
        }

        $this->pdf->Image( $this->sFile, $x, $y, $this->getContentWidth(), $this->getContentHeight(), $this->sType, $this->sLink );
    }


    /**
     * Checks if the image file is set and it is accessible
     */
    protected function doChecks()
    {
        //check if the image is set
        if ( 0 == strlen( $this->sFile ) )
        {
            trigger_error( "Image File not set!", E_USER_ERROR );
        }

        if ( !file_exists( $this->sFile ) )
        {
            trigger_error( "Image File Not found: {$this->sFile}!", E_USER_ERROR );
        }
    }


    public function processContent()
    {
        $this->doChecks();

        $this->setCellHeight( $this->getContentHeight() + $this->getPaddingTop() + $this->getPaddingBottom() + 2 * $this->getBorderSize() );
    }
}