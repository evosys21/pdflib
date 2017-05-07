<?php
/**
 * Pdf Table Cell Abstract
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
 * @version   : 5.3.0
 * @author    : Interpid <office@interpid.eu>
 * @copyright : Interpid, http://www.interpid.eu
 * @license   : http://www.interpid.eu/pdf-addons/eula
 */

namespace Interpid\Pdf\Table\Cell;

use Interpid\Pdf\PdfInterface;
use Interpid\Pdf\Tools;
use Interpid\Pdf\Pdf;
use Interpid\Pdf\Validate;

/**
 * @property mixed|null HEIGHT_LEFT_RW
 */
abstract class CellAbstract implements CellInterface
{

    protected $aPropertyMethodMap = array(
        'ALIGN' => 'setAlign',
        'VERTICAL_ALIGN' => 'setAlignVertical',
        'COLSPAN' => 'setColSpan',
        'ROWSPAN' => 'setRowSpan',
        'PADDING' => 'setPadding',
        'PADDING_TOP' => 'setPaddingTop',
        'PADDING_RIGHT' => 'setPaddingRight',
        'PADDING_BOTTOM' => 'setPaddingBottom',
        'PADDING_LEFT' => 'setPaddingLeft',
        'BORDER_TYPE' => 'setBorderType',
        'BORDER_SIZE' => 'setBorderSize',
        'BORDER_COLOR' => 'setBorderColor',
        'BACKGROUND_COLOR' => 'setBackgroundColor',
    );

    /**
     * Colspan
     *
     * @var int
     */
    protected $colSpan = 1;

    /**
     * Rowspan
     *
     * @var int
     */
    protected $rowSpan = 1;

    protected $paddingTop = 0;
    protected $paddingRight = 0;
    protected $paddingBottom = 0;
    protected $paddingLeft = 0;

    protected $backgroundColor = [ 255, 255, 255 ];

    protected $borderType = '1';
    protected $borderSize = 0.1;
    protected $borderColor = [ 0, 0, 0 ];

    protected $align = 'L';
    protected $alignVertical = 'M';

    protected $properties = [];

    protected $internValueSet = [];

    protected $cellWidth = 0;

    protected $cellHeight = 0;

    protected $cellDrawWidth = 0;

    protected $cellDrawHeight = 0;

    protected $contentWidth = 0;

    protected $contentHeight = 0;

    /**
     * Default alignment is Middle Center
     *
     * @var string
     */
    protected $alignment = 'MC';

    /**
     * Pdf Interface
     *
     * @var Pdf
     */
    protected $pdf;

    /**
     * Pdf Interface
     *
     * @var PdfInterface
     */
    protected $pdfi;

    /**
     * If this cell will be skipped
     *
     * @var boolean
     */
    protected $bSkip = false;


    public function __construct( $pdf )
    {
        if ( $pdf instanceof PdfInterface ) {
            $this->pdfi = $pdf;
            $this->pdf = $pdf->getPdfObject();
        } else {
            //it must be an instance of a pdf object
            $this->pdf = $pdf;
            $this->pdfi = new PdfInterface( $pdf );
        }
    }

    public function setProperties( array $aValues = array() )
    {
        $this->setInternValues( $aValues, false );
    }

    /**
     * Sets the intern variable values
     *
     * @param array $aValues The values to be set
     * @param bool $bCheckSet If the values are already set, the values will NOT be set
     */
    protected function setInternValues( array $aValues = array(), $bCheckSet = true )
    {
        foreach ( $aValues as $key => $value ) {
            if ( $bCheckSet && $this->isInternValueSet( $key ) ) {
                //property is already set, ignore the value
                continue;
            }

            $this->setInternValue( $key, $value );
        }
    }


    /**
     * Returns true if the property is already set
     *
     * @param string $key
     * @return bool
     */
    protected function isInternValueSet( $key )
    {
        return array_key_exists( $key, $this->internValueSet );
    }

    /**
     * Marks the property as set
     *
     * @param string $key
     */
    protected function markInternValueAsSet( $key )
    {
        $this->internValueSet[ $key ] = true;
    }

    /**
     * Sets an intern value
     *
     * @param $key
     * @param $value
     */
    protected function setInternValue( $key, $value )
    {
        $this->markInternValueAsSet( $key );

        if ( isset( $this->aPropertyMethodMap[ $key ] ) ) {
            call_user_func_array( array(
                $this,
                $this->aPropertyMethodMap[ $key ]
            ), Tools::makeArray( $value ) );

            return;
        }

        $method = "set" . ucfirst( $key );

        if ( method_exists( $this, $method ) ) {
            call_user_func_array( array(
                $this,
                $method
            ), Tools::makeArray( $value ) );

            return;
        }

        $this->properties[ $key ] = $value;
    }


    /**
     * Set image alignment.
     * It can be any combination of the 2 Vertical and Horizontal values:
     * Vertical values: TBM
     * Horizontal values: LRC
     *
     * @param string $alignment
     */
    public function setAlign( $alignment )
    {
        $this->alignment = strtoupper( $alignment );
    }


    public function setColSpan( $value )
    {
        $this->colSpan = Validate::intPositive( $value );
    }


    public function getColSpan()
    {
        return $this->colSpan;
    }


    public function setRowSpan( $value )
    {
        $this->rowSpan = Validate::intPositive( $value );
    }


    public function getRowSpan()
    {
        return $this->rowSpan;
    }


    public function setCellWidth( $value )
    {
        $value = Validate::float( $value, 0 );

        $this->cellWidth = $value;

        if ( $value > $this->getCellDrawWidth() ) {
            $this->setCellDrawWidth( $value );
        }
    }


    public function getCellWidth()
    {
        return $this->cellWidth;
    }


    public function setCellHeight( $value )
    {
        $value = Validate::float( $value, 0 );

        $this->cellHeight = $value;

        if ( $value > $this->getCellDrawHeight() ) {
            $this->setCellDrawHeight( $value );
        }
    }


    public function getCellHeight()
    {
        return $this->cellHeight;
    }


    public function setCellDrawHeight( $value )
    {
        $value = Validate::float( $value, 0 );

        if ( $this->getCellHeight() <= $value ) {
            $this->cellDrawHeight = $value;
        }
    }


    public function getCellDrawHeight()
    {
        return $this->cellDrawHeight;
    }


    public function setCellDrawWidth( $value )
    {
        $value = Validate::float( $value, 0 );

        $this->cellDrawWidth = $value;
        $this->setCellWidth( $value );
    }


    public function getCellDrawWidth()
    {
        return $this->cellDrawWidth;
    }


    public function setContentWidth( $value )
    {
        $this->contentWidth = Validate::float( $value, 0 );
    }


    public function getContentWidth()
    {
        return $this->contentWidth;
    }


    public function setContentHeight( $value )
    {
        $this->contentHeight = Validate::float( $value, 0 );
    }


    public function getContentHeight()
    {
        return $this->contentHeight;
    }


    public function setSkipped( $value )
    {
        $this->bSkip = (bool)$value;
    }


    public function getSkipped()
    {
        return $this->bSkip;
    }


    public function __get( $property )
    {
        if ( isset( $this->properties[ $property ] ) ) {
            return $this->properties[ $property ];
        }

        trigger_error( "Undefined property $property" );

        return null;
    }


    public function __set( $property, $value )
    {
        $this->setInternValue( $property, $value );

        return $this;
    }


    public function isPropertySet( $property )
    {
        if ( isset( $this->properties[ $property ] ) ) {
            return true;
        }

        return false;
    }


    public function setDefaultValues( array $aValues = array() )
    {
        $this->setInternValues( $aValues, true );
    }


    /**
     * Renders the base cell layout - Borders and Background Color
     */
    public function renderCellLayout()
    {
        $x = $this->pdf->GetX();
        $y = $this->pdf->GetY();

        //border size BORDER_SIZE
        $this->pdf->SetLineWidth( $this->getBorderSize() );

        if ( !$this->isTransparent() ) {
            //fill color = BACKGROUND_COLOR
            list ( $r, $g, $b ) = $this->getBackgroundColor();
            $this->pdf->SetFillColor( $r, $g, $b );
        }

        //Draw Color = BORDER_COLOR
        list ( $r, $g, $b ) = $this->getBorderColor();
        $this->pdf->SetDrawColor( $r, $g, $b );

        $this->pdf->Cell( $this->getCellDrawWidth(), $this->getCellDrawHeight(), '', $this->getBorderType(), 0, '',
            !$this->isTransparent() );

        $this->pdf->SetXY( $x, $y );
    }


    protected function isTransparent()
    {
        return Tools::isFalse( $this->getBackgroundColor() );
    }


    public function copyProperties( CellAbstract $oSource )
    {
        $this->rowSpan = $oSource->getRowSpan();
        $this->colSpan = $oSource->getColSpan();

        $this->paddingTop = $oSource->getPaddingTop();
        $this->paddingRight = $oSource->getPaddingRight();
        $this->paddingBottom = $oSource->getPaddingBottom();
        $this->paddingLeft = $oSource->getPaddingLeft();

        $this->borderColor = $oSource->getBorderColor();
        $this->borderSize = $oSource->getBorderSize();
        $this->borderType = $oSource->getBorderType();

        $this->backgroundColor = $oSource->getBackgroundColor();

        $this->alignVertical = $oSource->getAlignVertical();
    }


    public function processContent()
    {
    }


    public function setPadding( $top = 0, $right = 0, $bottom = 0, $left = 0 )
    {
        $this->setPaddingTop( $top );
        $this->setPaddingRight( $right );
        $this->setPaddingBottom( $bottom );
        $this->setPaddingLeft( $left );
    }


    public function setPaddingBottom( $paddingBottom )
    {
        $this->paddingBottom = Validate::float( $paddingBottom, 0 );
    }


    public function getPaddingBottom()
    {
        return $this->paddingBottom;
    }


    public function setPaddingLeft( $paddingLeft )
    {
        $this->paddingLeft = Validate::float( $paddingLeft, 0 );
    }


    public function getPaddingLeft()
    {
        return $this->paddingLeft;
    }


    public function setPaddingRight( $paddingRight )
    {
        $this->paddingRight = Validate::float( $paddingRight, 0 );
    }


    public function getPaddingRight()
    {
        return $this->paddingRight;
    }


    public function setPaddingTop( $paddingTop )
    {
        $this->paddingTop = Validate::float( $paddingTop, 0 );
    }


    public function getPaddingTop()
    {
        return $this->paddingTop;
    }


    public function setBorderSize( $borderSize )
    {
        $this->borderSize = Validate::float( $borderSize, 0 );
    }


    public function getBorderSize()
    {
        return $this->borderSize;
    }


    public function setBorderType( $borderType )
    {
        $this->borderType = $borderType;
    }


    public function getBorderType()
    {
        return $this->borderType;
    }

    public function setBorderColor( $r, $b = null, $g = null )
    {
        $this->borderColor = Tools::getColor( $r, $b, $g );
    }

    public function getBorderColor()
    {
        return $this->borderColor;
    }


    public function setAlignVertical( $alignVertical )
    {
        $this->markInternValueAsSet('VERTICAL_ALIGN');
        $this->alignVertical = Validate::alignVertical( $alignVertical );
    }


    public function getAlignVertical()
    {
        return $this->alignVertical;
    }

    public function setBackgroundColor( $r, $b = null, $g = null )
    {
        $this->backgroundColor = Tools::getColor( $r, $b, $g );
    }

    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    public function split( $nRowHeight, $nMaxHeight )
    {
        return [ $this, 0 ];
    }

    public function getDefaultValues()
    {
        return [];
    }
}


