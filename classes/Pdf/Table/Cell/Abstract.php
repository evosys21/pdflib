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
 * @author    : Andrei Bintintan <andy@interpid.eu>
 * @copyright : Andrei Bintintan, http://www.interpid.eu
 * @license   : http://www.interpid.eu/pdf-addons/eula
 */

require_once( dirname( __FILE__ ) . '/Interface.php' );

/**
 * @property mixed|null HEIGHT_LEFT_RW
 */
abstract class Pdf_Table_Cell_Abstract implements Pdf_Table_Cell_Interface
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

    protected $backgroundColor = array( 255, 255, 255 );

    protected $borderType = '1';
    protected $borderSize = 0.1;
    protected $borderColor = array( 0, 0, 0 );

    protected $align = 'L';
    protected $alignVertical = 'M';

    protected $aProperties = array();

    protected $aInternValueSet = array();

    protected $nCellWidth = 0;

    protected $nCellHeight = 0;

    protected $nCellDrawWidth = 0;

    protected $nCellDrawHeight = 0;

    protected $nContentWidth = 0;

    protected $nContentHeight = 0;

    /**
     * Default alignment is Middle Center
     *
     * @var string
     */
    protected $sAlignment = 'MC';

    /**
     * Pdf Interface
     *
     * @var Pdf
     */
    protected $oPdf;

    /**
     * Pdf Interface
     *
     * @var Pdf_Interface
     */
    protected $oPdfi;

    /**
     * If this cell will be skipped
     *
     * @var boolean
     */
    protected $bSkip = false;


    public function __construct( $pdf )
    {
        if ( $pdf instanceof Pdf_Interface )
        {
            $this->oPdfi = $pdf;
            $this->oPdf = $pdf->getPdfObject();
        }
        else
        {
            //it must be an instance of a pdf object
            $this->oPdf = $pdf;
            $this->oPdfi = new Pdf_Interface( $pdf );
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
        foreach ( $aValues as $key => $value )
        {

            if ( $bCheckSet && $this->isInternValueSet( $key ) )
            {
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
        return array_key_exists( $key, $this->aInternValueSet );
    }

    /**
     * Marks the property as set
     *
     * @param string $key
     */
    protected function markInternValueAsSet( $key )
    {
        $this->aInternValueSet[ $key ] = true;
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

        if ( isset( $this->aPropertyMethodMap[ $key ] ) )
        {

            call_user_func_array( array(
                $this,
                $this->aPropertyMethodMap[ $key ]
            ), Pdf_Tools::makeArray( $value ) );

            return;
        }

        $method = "set" . ucfirst( $key );

        if ( method_exists( $this, $method ) )
        {
            call_user_func_array( array(
                $this,
                $method
            ), Pdf_Tools::makeArray( $value ) );

            return;
        }

        $this->aProperties[ $key ] = $value;
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
        $this->sAlignment = strtoupper( $alignment );
    }


    public function setColSpan( $value )
    {
        $this->colSpan = Pdf_Validate::intPositive( $value );
    }


    public function getColSpan()
    {
        return $this->colSpan;
    }


    public function setRowSpan( $value )
    {
        $this->rowSpan = Pdf_Validate::intPositive( $value );
    }


    public function getRowSpan()
    {
        return $this->rowSpan;
    }


    public function setCellWidth( $value )
    {
        $value = Pdf_Validate::float( $value, 0 );

        $this->nCellWidth = $value;

        if ( $value > $this->getCellDrawWidth() )
        {
            $this->setCellDrawWidth( $value );
        }
    }


    public function getCellWidth()
    {
        return $this->nCellWidth;
    }


    public function setCellHeight( $value )
    {
        $value = Pdf_Validate::float( $value, 0 );

        $this->nCellHeight = $value;

        if ( $value > $this->getCellDrawHeight() )
        {
            $this->setCellDrawHeight( $value );
        }
    }


    public function getCellHeight()
    {
        return $this->nCellHeight;
    }


    public function setCellDrawHeight( $value )
    {
        $value = Pdf_Validate::float( $value, 0 );

        if ( $this->getCellHeight() <= $value )
        {
            $this->nCellDrawHeight = $value;
        }
    }


    public function getCellDrawHeight()
    {
        return $this->nCellDrawHeight;
    }


    public function setCellDrawWidth( $value )
    {
        $value = Pdf_Validate::float( $value, 0 );

        $this->nCellDrawWidth = $value;
        $this->setCellWidth( $value );
    }


    public function getCellDrawWidth()
    {
        return $this->nCellDrawWidth;
    }


    public function setContentWidth( $value )
    {
        $this->nContentWidth = Pdf_Validate::float( $value, 0 );
    }


    public function getContentWidth()
    {
        return $this->nContentWidth;
    }


    public function setContentHeight( $value )
    {
        $this->nContentHeight = Pdf_Validate::float( $value, 0 );
    }


    public function getContentHeight()
    {
        return $this->nContentHeight;
    }


    public function setSkipped( $value )
    {
        $this->bSkip = (bool) $value;
    }


    public function getSkipped()
    {
        return $this->bSkip;
    }


    public function __get( $property )
    {
        if ( isset( $this->aProperties[ $property ] ) )
        {
            return $this->aProperties[ $property ];
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
        if ( isset( $this->aProperties[ $property ] ) )
            return true;

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
        $x = $this->oPdf->GetX();
        $y = $this->oPdf->GetY();

        //border size BORDER_SIZE
        $this->oPdf->SetLineWidth( $this->getBorderSize() );

        if ( !$this->isTransparent() )
        {
            //fill color = BACKGROUND_COLOR
            list ( $r, $g, $b ) = $this->getBackgroundColor();
            $this->oPdf->SetFillColor( $r, $g, $b );
        }

        //Draw Color = BORDER_COLOR
        list ( $r, $g, $b ) = $this->getBorderColor();
        $this->oPdf->SetDrawColor( $r, $g, $b );

        $this->oPdf->Cell( $this->getCellDrawWidth(), $this->getCellDrawHeight(), '', $this->getBorderType(), 0, '', !$this->isTransparent() );

        $this->oPdf->SetXY( $x, $y );
    }


    protected function isTransparent()
    {
        return Pdf_Tools::isFalse( $this->getBackgroundColor() );
    }


    public function copyProperties( Pdf_Table_Cell_Abstract $oSource )
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
        $this->paddingBottom = Pdf_Validate::float( $paddingBottom, 0 );
    }


    public function getPaddingBottom()
    {
        return $this->paddingBottom;
    }


    public function setPaddingLeft( $paddingLeft )
    {
        $this->paddingLeft = Pdf_Validate::float( $paddingLeft, 0 );
    }


    public function getPaddingLeft()
    {
        return $this->paddingLeft;
    }


    public function setPaddingRight( $paddingRight )
    {
        $this->paddingRight = Pdf_Validate::float( $paddingRight, 0 );
    }


    public function getPaddingRight()
    {
        return $this->paddingRight;
    }


    public function setPaddingTop( $paddingTop )
    {
        $this->paddingTop = Pdf_Validate::float( $paddingTop, 0 );
    }


    public function getPaddingTop()
    {
        return $this->paddingTop;
    }


    public function setBorderSize( $borderSize )
    {
        $this->borderSize = Pdf_Validate::float( $borderSize, 0 );
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
        $this->borderColor = Pdf_Tools::getColor( $r, $b, $g );
    }

    public function getBorderColor()
    {
        return $this->borderColor;
    }


    public function setAlignVertical( $alignVertical )
    {
        $this->alignVertical = Pdf_Validate::alignVertical( $alignVertical );
    }


    public function getAlignVertical()
    {
        return $this->alignVertical;
    }

    public function setBackgroundColor( $r, $b = null, $g = null )
    {
        $this->backgroundColor = Pdf_Tools::getColor( $r, $b, $g );
    }

    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    public function split( $nRowHeight, $nMaxHeight )
    {
        return array( $this, 0 );
    }
}


