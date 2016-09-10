<?php
/**
 * Pdf Multicell
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
 * @version   : 2.5.0
 * @author    : Andrei Bintintan <andy@interpid.eu>
 * @copyright : Andrei Bintintan, http://www.interpid.eu
 * @license   : http://www.interpid.eu/pdf-addons/eula
 */


require_once( dirname( __FILE__ ) . '/Tools.php' );
require_once( dirname( __FILE__ ) . '/Validate.php' );
require_once( dirname( __FILE__ ) . '/String/Tags.php' );
require_once( dirname( __FILE__ ) . '/Interface.php' );

if ( !defined( 'PARAGRAPH_STRING' ) )
    define( 'PARAGRAPH_STRING', '~~~' );

class Pdf_Multicell
{
    const DEBUG_CELL_BORDERS = 0;
    const SEPARATOR = ' ,.:;';

    /**
     * The list of line breaking characters Default to self::SEPARATOR
     *
     * @var string
     */
    protected $sLineBreakingChars;

    /**
     * Valid Tag Maximum Width
     *
     * @var integer
     */
    protected $nTagWidthMax = 25;

    /**
     * The current active tag
     *
     * @var string
     */
    protected $sCurrentTag = '';

    /**
     * Tags Font Information
     *
     * @var array
     */
    protected $oFontInfo;

    /**
     * Parsed string data info
     *
     * @var array
     */
    protected $aDataInfo;

    /**
     * Data Extra Info
     *
     * @var array
     */
    protected $aDataExtraInfo;

    /**
     * Temporary Info
     *
     *
     * @var array
     */
    protected $aTempData;

    /**
     * == true if a tag was more times defined.
     *
     * @var boolean
     */
    protected $bDoubleTags = false;

    /**
     * Pointer to the pdf object
     *
     * @var Pdf
     */
    protected $oPdf = null;

    /**
     * PDF Interface Object
     *
     * @var Pdf_Interface
     *
     */
    protected $oPdfi;

    /**
     * Contains the Singleton Object
     *
     * @var object
     */
    private static $_singleton = array(); //implements the Singleton Pattern


    protected $aImage = null;

    protected $bFill = true;

    protected $TagStyle = array();

    /**
     * Class constructor.
     *
     * @param Pdf $oPdf Instance of the pdf class
     * @return Pdf_Multicell
     */
    public function __construct( $oPdf )
    {

        $this->oPdf = $oPdf;
        $this->oPdfi = new Pdf_Interface( $oPdf );
        $this->sLineBreakingChars = self::SEPARATOR;
    }


    /**
     * Returns the PDF object
     *
     * @return Pdf
     */
    public function getPdfObject()
    {
        return $this->oPdf;
    }


    /**
     * Returns the Pdf Interface Object
     *
     * @return Pdf_Interface
     */
    public function getPdfInterfaceObject()
    {
        return $this->oPdfi;
    }


    /**
     * Returnes the Singleton Instance of this class.
     *
     * @param Pdf $oPdf Instance of the pdf class
     * @return Pdf_Multicell
     */
    static function getInstance( $oPdf )
    {
        $oInstance = &self::$_singleton[ spl_object_hash( $oPdf ) ];

        if ( !isset( $oInstance ) ) {
            $oInstance = new self( $oPdf );
        }

        return $oInstance;
    }


    /**
     * Sets the list of characters that will allow a line-breaking
     *
     * @param $sChars string
     */
    public function setLineBreakingCharacters( $sChars )
    {
        $this->sLineBreakingChars = $sChars;
    }


    /**
     * Resets the list of characters that will allow a line-breaking
     */
    public function resetLineBreakingCharacters()
    {
        $this->sLineBreakingChars = self::SEPARATOR;
    }


    /**
     * Sets the Tags Maximum width
     *
     * @param int|number $iWidth the width of the tags
     */
    public function setTagWidthMax( $iWidth = 25 )
    {
        $this->nTagWidthMax = $iWidth;
    }


    /**
     * Resets the current class internal variables to default values
     */
    protected function resetData()
    {
        $this->sCurrentTag = "";

        //@formatter:off
        $this->aDataInfo = array();
        $this->aDataExtraInfo = array(
            "LAST_LINE_BR" => "", //CURRENT LINE BREAK TYPE
            "CURRENT_LINE_BR" => "", //LAST LINE BREAK TYPE
            "TAB_WIDTH" => 10 ); //The tab WIDTH IS IN mm
        //@formatter:on

        //if another measure unit is used ... calculate your OWN
        $this->aDataExtraInfo[ "TAB_WIDTH" ] *= ( 72 / 25.4 ) / $this->oPdf->k;
    }


    /**
     * Sets the font parameters for the specified tag
     *
     * @param $tag string tag name
     * @param $fontfamily string font family
     * @param $fontstyle string font style
     * @param $fontsize number font size
     * @param $color mixed font color
     */
    public function SetStyle( $tag, $fontfamily, $fontstyle, $fontsize, $color )
    {

        if ( $tag == "ttags" )
            $this->oPdf->Error( ">> ttags << is reserved TAG Name." );
        if ( $tag == "" )
            $this->oPdf->Error( "Empty TAG Name." );

        //use case insensitive tags
        $tag = trim( strtoupper( $tag ) );

        if ( isset( $this->TagStyle[ $tag ] ) )
            $this->bDoubleTags = true;

        $this->TagStyle[ $tag ][ 'family' ] = trim( $fontfamily );
        $this->TagStyle[ $tag ][ 'style' ] = trim( $fontstyle );
        $this->TagStyle[ $tag ][ 'size' ] = trim( $fontsize );
        $this->TagStyle[ $tag ][ 'color' ] = trim( $color );
    }


    /**
     * Returns the specified tag font family
     *
     * @param string $tag tag name
     * @return string The font family
     */
    public function getTagFont( $tag )
    {

        return $this->getTagAttribute( $tag, 'family' );
    }


    /**
     * Returns the specified tag font style
     *
     * @param string $tag tag name
     * @return string The font style
     */
    public function getTagFontStyle( $tag )
    {
        return $this->getTagAttribute( $tag, 'style' );
    }


    /**
     * Returns the specified tag font size
     *
     * @param string $tag tag name
     * @return string The font size
     */
    public function getTagSize( $tag )
    {
        return $this->getTagAttribute( $tag, 'size' );
    }


    /**
     * Returns the specified tag text color
     *
     * @param string $tag tag name
     * @return string The tag color
     */
    public function getTagColor( $tag )
    {
        return $this->getTagAttribute( $tag, 'color' );
    }


    /**
     * Returns the attribute the specified tag
     *
     * @param string $sTag tag name
     * @param string $sAttribute attribute name
     */
    protected function getTagAttribute( $sTag, $sAttribute )
    {
        //tags are saved uppercase!
        $sTag = strtoupper( $sTag );

        if ( 'TTAGS' === $sTag )
            $sTag = "DEFAULT";
        if ( 'PPARG' === $sTag )
            $sTag = "DEFAULT";
        if ( '' === $sTag )
            $sTag = "DEFAULT";

        if ( !isset( $this->TagStyle[ $sTag ] ) ) {
            //trigger_error("Tag $sTag not found!");
            $sTag = "DEFAULT";
        }

        if ( !isset( $this->TagStyle[ $sTag ][ $sAttribute ] ) ) {
            trigger_error( "Attribute $sAttribute for Tag $sTag not found!" );
        }

        return $this->TagStyle[ $sTag ][ $sAttribute ];
    }


    /**
     * Sets the styles from the specified tag active.
     * Font family, style, size and text color.
     *
     * If the tag is not found then the DEFAULT tag is being used
     *
     * @param string $tag tag name
     */
    protected function applyStyle( $tag )
    {
        //use case insensitive tags
        $tag = trim( strtoupper( $tag ) );

        if ( $this->sCurrentTag == $tag )
            return;

        if ( ( $tag == "" ) || ( !isset( $this->TagStyle[ $tag ] ) ) )
            $tag = "DEFAULT";

        $this->sCurrentTag = $tag;

        $style = &$this->TagStyle[ $tag ];

        if ( isset( $style ) ) {
            if ( strpos( $style[ 'size' ], '%' ) !== false ) {
                $style[ 'size' ] = $this->oPdf->FontSizePt * ( ( (float)$style[ 'size' ] ) / 100 );
            }
            $this->oPdf->SetFont( $style[ 'family' ], $style[ 'style' ], $style[ 'size' ] );
            //this is textcolor in PDF format
            if ( isset( $style[ 'textcolor_pdf' ] ) ) {
                $this->oPdf->TextColor = $style[ 'textcolor_pdf' ];
                $this->oPdf->ColorFlag = ( $this->oPdf->FillColor != $this->oPdf->TextColor );
            } else {
                if ( $style[ 'color' ] != "" ) { //if we have a specified color
                    $temp = explode( ",", $style[ 'color' ] );
                    // added to support Grayscale, RGB and CMYK
                    call_user_func_array(
                        array(
                            $this->oPdf,
                            'SetTextColor'
                        ), $temp );
                }
            }
        }
    }


    /**
     * Save the current settings as a tag default style under the DEFAUTLT tag name
     *
     * @param none
     * @return void
     */
    protected function saveCurrentStyle()
    {
        $this->TagStyle[ 'DEFAULT' ][ 'family' ] = $this->oPdfi->getFontFamily();
        $this->TagStyle[ 'DEFAULT' ][ 'style' ] = $this->oPdfi->getFontStyle();
        $this->TagStyle[ 'DEFAULT' ][ 'size' ] = $this->oPdfi->getFontSizePt();
        $this->TagStyle[ 'DEFAULT' ][ 'textcolor_pdf' ] = $this->oPdf->TextColor;
        $this->TagStyle[ 'DEFAULT' ][ 'color' ] = "";
    }


    /**
     * Divides $this->aDataInfo and returnes a line from this variable
     *
     * @param $nWidth
     * @internal param number $width the width of the cell
     * @return array $aLine - array() -> contains informations to draw a line
     */
    protected function makeLine( $nWidth )
    {
        //last line break >> current line break
        $this->aDataExtraInfo[ 'LAST_LINE_BR' ] = $this->aDataExtraInfo[ 'CURRENT_LINE_BR' ];
        $this->aDataExtraInfo[ 'CURRENT_LINE_BR' ] = "";

        if ( 0 == $nWidth ) {
            $nWidth = $this->oPdfi->getRemainingWidth();
        }

        $nMaximumWidth = $nWidth;

        $aLine = array(); //this will contain the result
        $bReturnResult = false; //if break and return result
        $bResetSpaces = false;

        $nLineWith = 0; //line string width
        $nTotalChars = 0; //total characters included in the result string
        $fw = &$this->oFontInfo; //font info array


        $last_sepch = ""; //last separator character


        foreach ( $this->aDataInfo as $key => $val ) {

            $s = $val[ 'text' ];

            $tag = $val[ 'tag' ];

            $bParagraph = false;
            if ( ( $s == "\t" ) && ( $tag == 'pparg' ) ) {
                $bParagraph = true;
                $s = "\t"; //place instead a TAB
            }

            $i = 0; //from where is the string remain
            $j = 0; //untill where is the string good to copy -- leave this == 1->> copy at least one character!!!
            $nCurrentWidth = 0; //string width
            $last_sep = -1; //last separator position
            $last_sepwidth = 0;
            $last_sepch_width = 0;
            $ante_last_sep = -1; //ante last separator position
            $nSpaces = 0;

            $aString = $this->oPdfi->stringToArray( $s );
            $nStringLength = count( $aString );

            //parse the whole string
            while ( $i < $nStringLength ) {

                $c = $aString[ $i ];

                if ( $c == ord( "\n" ) ) { //Explicit line break
                    $i++; //ignore/skip this caracter
                    $this->aDataExtraInfo[ 'CURRENT_LINE_BR' ] = "BREAK";
                    $bReturnResult = true;
                    $bResetSpaces = true;
                    break;
                }

                //space
                if ( $c == ord( " " ) ) {
                    $nSpaces++;
                }

                //    Font Width / Size Array
                if ( !isset( $fw[ $tag ] ) || ( $tag == "" ) || ( $this->bDoubleTags ) ) {
                    //if this font was not used untill now,
                    $this->applyStyle( $tag );
                    $fw[ $tag ][ 'CurrentFont' ] = &$this->oPdf->CurrentFont; //this can be copied by reference!
                    $fw[ $tag ][ 'FontSize' ] = $this->oPdf->FontSize;
                }

                $char_width = $this->mt_getCharWidth( $tag, $c );

                //separators
                if ( in_array( $c, array_map( 'ord', str_split( $this->sLineBreakingChars ) ) ) ) {

                    $ante_last_sep = $last_sep;
                    $ante_last_sepch = $last_sepch;
                    $ante_last_sepwidth = $last_sepwidth;

                    $last_sep = $i; //last separator position
                    $last_sepch = $c; //last separator char
                    $last_sepch_width = $char_width; //last separator char
                    $last_sepwidth = $nCurrentWidth;
                }

                if ( $c == ord( "\t" ) ) { //TAB
                    //$c = $s[$i] = "";
                    $c = ord( "" );
                    $s = substr_replace( $s, '', $i, 1 );
                    $char_width = $this->aDataExtraInfo[ 'TAB_WIDTH' ];
                }

                if ( $bParagraph == true ) {
                    $c = ord( "" );
                    $s = substr_replace( $s, ' ', $i, 1 );
                    $char_width = $this->aTempData[ 'LAST_TAB_REQSIZE' ] - $this->aTempData[ 'LAST_TAB_SIZE' ];
                    if ( $char_width < 0 )
                        $char_width = 0;
                }

                $nLineWith += $char_width;

                //round these values to a precision of 5! should be enough
                if ( round( $nLineWith, 5 ) > round( $nMaximumWidth, 5 ) ) { //Automatic line break


                    $this->aDataExtraInfo[ 'CURRENT_LINE_BR' ] = "AUTO";

                    if ( $nTotalChars == 0 ) {
                        /*
                         * This MEANS that the width is lower than a char width... Put $i and $j to 1 ... otherwise infinite while
                         */
                        $i = 1;
                        $j = 1;
                        $bReturnResult = true; //YES RETURN THE RESULT!!!
                        break;
                    }


                    if ( $last_sep != -1 ) {
                        //we have a separator in this tag!!!
                        //untill now there one separator
                        if ( ( $last_sepch == $c ) && ( $last_sepch != ord( " " ) ) && ( $ante_last_sep != -1 ) ) {
                            /*
                             * this is the last character and it is a separator, if it is a space the leave it... Have to jump back to the last separator... even a space
                             */
                            $last_sep = $ante_last_sep;
                            $last_sepch = $ante_last_sepch;
                            $last_sepwidth = $ante_last_sepwidth;
                        }

                        if ( $last_sepch == ord( " " ) ) {
                            $j = $last_sep; //just ignore the last space (it is at end of line)
                            $i = $last_sep + 1;
                            if ( $nSpaces > 0 )
                                $nSpaces--;
                            $nCurrentWidth = $last_sepwidth;
                        } else {
                            $j = $last_sep + 1;
                            $i = $last_sep + 1;
                            $nCurrentWidth = $last_sepwidth + $last_sepch_width;
                        }
                    } elseif ( count( $aLine ) > 0 ) {
                        //we have elements in the last tag!!!!
                        if ( $last_sepch == ord( " " ) ) { //the last tag ends with a space, have to remove it


                            $temp = &$aLine[ count( $aLine ) - 1 ];

                            if ( ' ' == self::strchar( $temp[ 'text' ], -1 ) ) {

                                $temp[ 'text' ] = self::substr( $temp[ 'text' ], 0, self::strlen( $temp[ 'text' ] ) - 1 );
                                $temp[ 'width' ] -= $this->mt_getCharWidth( $temp[ 'tag' ], ord( ' ' ) );
                                $temp[ 'spaces' ]--;

                                //imediat return from this function
                                break 2;
                            } else {
                                #die("should not be!!!");
                            }
                        }
                    }


                    $bReturnResult = true;
                    break;
                }


                //increase the string width ONLY when it is added!!!!
                $nCurrentWidth += $char_width;

                $i++;
                $j = $i;
                $nTotalChars++;
            }


            $str = self::substr( $s, 0, $j );

            $sTmpStr = $this->aDataInfo[ 0 ][ 'text' ];
            $sTmpStr = self::substr( $sTmpStr, $i, self::strlen( $sTmpStr ) );

            if ( ( $sTmpStr == "" ) || ( $sTmpStr === false ) ) {
                array_shift( $this->aDataInfo );
            } else {
                $this->aDataInfo[ 0 ][ 'text' ] = $sTmpStr;
            }

            if ( !isset( $val[ 'href' ] ) )
                $val[ 'href' ] = '';
            if ( !isset( $val[ 'ypos' ] ) )
                $val[ 'ypos' ] = 0;

            //we have a partial result
            array_push( $aLine, array(
                'text' => $str,
                'char' => $nTotalChars,
                'tag' => $val[ 'tag' ],
                'href' => $val[ 'href' ],
                'width' => $nCurrentWidth,
                'spaces' => $nSpaces,
                'ypos' => $val[ 'ypos' ]
            ) );


            $this->aTempData[ 'LAST_TAB_SIZE' ] = $nCurrentWidth;
            $this->aTempData[ 'LAST_TAB_REQSIZE' ] = ( isset( $val[ 'size' ] ) ) ? $val[ 'size' ] : 0;

            if ( $bReturnResult )
                break; //break this for
        }


        // Check the first and last tag -> if first and last caracters are " " space remove them!!!"
        if ( ( count( $aLine ) > 0 ) && ( $this->aDataExtraInfo[ 'LAST_LINE_BR' ] == "AUTO" ) ) {

            // first tag
            // If the first character is a space, then cut it off
            $temp = &$aLine[ 0 ];
            if ( ( self::strlen( $temp[ 'text' ] ) > 0 ) && ( " " == self::strchar( $temp[ 'text' ], 0 ) ) ) {
                $temp[ 'text' ] = self::substr( $temp[ 'text' ], 1, self::strlen( $temp[ 'text' ] ) );
                $temp[ 'width' ] -= $this->mt_getCharWidth( $temp[ 'tag' ], ord( " " ) );
                $temp[ 'spaces' ]--;
            }

            // If the last character is a space, then cut it off
            $temp = &$aLine[ count( $aLine ) - 1 ];
            if ( ( self::strlen( $temp[ 'text' ] ) > 0 ) && ( " " == self::strchar( $temp[ 'text' ], -1 ) ) ) {
                $temp[ 'text' ] = self::substr( $temp[ 'text' ], 0, self::strlen( $temp[ 'text' ] ) - 1 );
                $temp[ 'width' ] -= $this->mt_getCharWidth( $temp[ 'tag' ], ord( " " ) );
                $temp[ 'spaces' ]--;
            }
        }

        if ( $bResetSpaces ) { //this is used in case of a "Explicit Line Break"
            //put all spaces to 0 so in case of "J" align there is no space extension
            for ( $k = 0; $k < count( $aLine ); $k++ ) {
                $aLine[ $k ][ 'spaces' ] = 0;
            }
        }

        return $aLine;
    }


    /**
     * Draws a MultiCell with a TAG Based Formatted String as an Input
     *
     *
     * @param number $nWidth width of the cell
     * @param number $nHeight height of the lines in the cell
     * @param mixed(string|array) $pData string or formatted data to be putted in the multicell
     * @param mixed(string|number) $border Indicates if borders must be drawn around the cell block. The value can be either a number: 0 = no border 1 = frame border or a string containing some or
     * all of the following characters (in any order): L: left T: top R: right B: bottom
     * @param string $align Sets the text alignment Possible values: L: left R: right C: center J: justified
     * @param int|number $fill Indicates if the cell background must be painted (1) or transparent (0). Default value: 0.
     * @param int|number $nPaddingLeft Left padding
     * @param int|number $nPaddingTop Top padding
     * @param int|number $nPaddingRight Right padding
     * @param int|number $nPaddingBottom Bottom padding
     * @param boolean $bDataIsString true if $pData is a string - false if $pData is an array containing lines formatted with $this->makeLine($nWidth) function (the false option is used in relation
     * with stringToLines, to avoid double formatting of a string
     */
    public function multiCell( $nWidth, $nHeight, $pData, $border = 0, $align = 'J', $fill = 0, $nPaddingLeft = 0, $nPaddingTop = 0, $nPaddingRight = 0,
                               $nPaddingBottom = 0, $bDataIsString = true )
    {
        //get the available width for the text
        $w_text = $this->mt_getAvailableTextWidth( $nWidth, $nPaddingLeft, $nPaddingRight );

        $nStartX = $this->oPdf->GetX();
        $aRecData = $this->stringToLines( $w_text, $pData );
        $iCounter = 9999; //avoid infinite loop for any reasons

        $doBreak = false;

        do {
            $iLeftHeight = $this->oPdf->h - $this->oPdf->bMargin - $this->oPdf->GetY() - $nPaddingTop - $nPaddingBottom;
            $bAddNewPage = false;

            //Number of rows that have space on this page:
            $iRows = floor( $iLeftHeight / $nHeight );
            // Added check for "AcceptPageBreak"
            if ( count( $aRecData ) > $iRows && $this->oPdf->AcceptPageBreak() ) {
                $aSendData = array_slice( $aRecData, 0, $iRows );
                $aRecData = array_slice( $aRecData, $iRows );
                $bAddNewPage = true;
            } else {
                $aSendData = &$aRecData;
                $doBreak = true;
            }

            $this->multiCellSec( $nWidth, $nHeight, $aSendData, $border, $align, $fill, $nPaddingLeft, $nPaddingTop, $nPaddingRight, $nPaddingBottom, false );

            if ( true == $bAddNewPage ) {
                $this->beforeAddPage();
                $this->oPdf->AddPage();
                $this->afterAddPage();
                $this->oPdf->SetX( $nStartX );
            }
        } while ( ( ( $iCounter-- ) > 0 ) && ( false == $doBreak ) );
    }


    /**
     * Draws a MultiCell with TAG recognition parameters
     *
     *
     * @param $nWidth number - with of the cell
     * @param $nHeight number - height of the lines in the cell
     * @param $pData string - string or formatted data to be putted in the multicell
     * @param int $border
     * @param $align string - Sets the text alignment Possible values: L: left R: right C: center J: justified
     * @param int|number $fill number - Indicates if the cell background must be painted (1) or transparent (0). Default value: 0.
     * @param int|number $nPaddingLeft number - Left pad
     * @param int|number $nPaddingTop number - Top pad
     * @param int|number $nPaddingRight number - Right pad
     * @param int|number $nPaddingBottom number - Bottom pad
     * @param $bDataIsString boolean - true if $pData is a string - false if $pData is an array containing lines formatted with $this->makeLine($nWidth) function (the false option is used in relation
     * with stringToLines, to avoid double formatting of a string
     * @internal param \or $string number $border Indicates if borders must be drawn around the cell block. The value can be either a number: 0 = no border 1 = frame border or a string containing some or all of
     * the following characters (in any order): L: left T: top R: right B: bottom
     * @return void
     */
    public function multiCellSec( $nWidth, $nHeight, $pData, $border = 0, $align = 'J', $fill = 0, $nPaddingLeft = 0, $nPaddingTop = 0, $nPaddingRight = 0,
                                  $nPaddingBottom = 0, $bDataIsString = true )
    {
        //save the current style settings, this will be the default in case of no style is specified
        $this->saveCurrentStyle();
        $this->resetData();

        //if data is string
        if ( $bDataIsString === true )
            $this->divideByTags( $pData );

        $b = $b1 = $b2 = $b3 = ''; //borders


        if ( $nWidth == 0 )
            $nWidth = $this->oPdf->w - $this->oPdf->rMargin - $this->oPdf->x;

        /**
         * If the vertical padding is bigger than the width then we ignore it In this case we put them to 0.
         */
        if ( ( $nPaddingLeft + $nPaddingRight ) > $nWidth ) {
            $nPaddingLeft = 0;
            $nPaddingRight = 0;
        }

        $w_text = $nWidth - $nPaddingLeft - $nPaddingRight;

        //save the current X position, we will have to jump back!!!!
        $startX = $this->oPdf->GetX();

        if ( $border ) {
            if ( $border == 1 ) {
                $border = 'LTRB';
                $b1 = 'LRT'; //without the bottom
                $b2 = 'LR'; //without the top and bottom
                $b3 = 'LRB'; //without the top
            } else {
                $b2 = '';
                if ( is_int( strpos( $border, 'L' ) ) )
                    $b2 .= 'L';
                if ( is_int( strpos( $border, 'R' ) ) )
                    $b2 .= 'R';
                $b1 = is_int( strpos( $border, 'T' ) ) ? $b2 . 'T' : $b2;
                $b3 = is_int( strpos( $border, 'B' ) ) ? $b2 . 'B' : $b2;
            }

            //used if there is only one line
            $b = '';
            $b .= is_int( strpos( $border, 'L' ) ) ? 'L' : "";
            $b .= is_int( strpos( $border, 'R' ) ) ? 'R' : "";
            $b .= is_int( strpos( $border, 'T' ) ) ? 'T' : "";
            $b .= is_int( strpos( $border, 'B' ) ) ? 'B' : "";
        }

        $bFirstLine = true;

        if ( $bDataIsString === true ) {
            $bLastLine = !( count( $this->aDataInfo ) > 0 );
        } else {
            $bLastLine = !( count( $pData ) > 0 );
        }

        while ( !$bLastLine ) {

            if ( $bFirstLine && ( $nPaddingTop > 0 ) ) {
                /**
                 * If this is the first line and there is top_padding
                 */
                $x = $this->oPdf->GetX();
                $y = $this->oPdf->GetY();
                $this->oPdfi->Cell( $nWidth, $nPaddingTop, '', $b1, 0, $align, $this->bFill, '', 0, true );
                $b1 = str_replace( 'T', '', $b1 );
                $b = str_replace( 'T', '', $b );
                $this->oPdf->SetXY( $x, $y + $nPaddingTop );
            }

            if ( $fill == 1 ) {
                //fill in the cell at this point and write after the text without filling
                $this->oPdf->SetX( $startX ); //restore the X position
                $this->oPdfi->Cell( $nWidth, $nHeight, "", 0, 0, "", $this->bFill );
                $this->oPdf->SetX( $startX ); //restore the X position
            }

            if ( $bDataIsString === true ) {
                //make a line
                $str_data = $this->makeLine( $w_text );
                //check for last line
                $bLastLine = !( count( $this->aDataInfo ) > 0 );
            } else {
                //make a line
                $str_data = array_shift( $pData );
                //check for last line
                $bLastLine = !( count( $pData ) > 0 );
            }

            if ( $bLastLine && ( $align == "J" ) ) { //do not Justify the Last Line
                $align = "L";
            }

            /**
             * Restore the X position with the corresponding padding if it exist The Right padding is done automatically by calculating the width of the text
             */
            $this->oPdf->SetX( $startX + $nPaddingLeft );
            $this->printLine( $w_text, $nHeight, $str_data, $align );

            //see what border we draw:
            if ( $bFirstLine && $bLastLine ) {
                //we have only 1 line
                $real_brd = $b;
            } elseif ( $bFirstLine ) {
                $real_brd = $b1;
            } elseif ( $bLastLine ) {
                $real_brd = $b3;
            } else {
                $real_brd = $b2;
            }

            if ( $bLastLine && ( $nPaddingBottom > 0 ) ) {
                /**
                 * If we have bottom padding then the border and the padding is outputted
                 */
                $this->oPdf->SetX( $startX ); //restore the X
                $this->oPdf->Cell( $nWidth, $nHeight, "", $b2, 2 );
                $this->oPdf->SetX( $startX ); //restore the X
                $this->oPdf->MultiCell( $nWidth, $nPaddingBottom, '', $real_brd, $align, $this->bFill );
            } else {
                //draw the border and jump to the next line
                $this->oPdf->SetX( $startX ); //restore the X
                $this->oPdf->Cell( $nWidth, $nHeight, "", $real_brd, 2 );
            }

            if ( $bFirstLine )
                $bFirstLine = false;
        }


        //APPLY THE DEFAULT STYLE
        $this->applyStyle( "DEFAULT" );

        $this->oPdf->x = $this->oPdf->lMargin;
    }


    /**
     * This method divides the string into the tags and puts the result into aDataInfo variable.
     *
     * @param string $pStr string to be parsed
     */
    protected function divideByTags( $pStr )
    {
        $pStr = str_replace( "\t", "<ttags>\t</ttags>", $pStr );
        $pStr = str_replace( PARAGRAPH_STRING, "<pparg>\t</pparg>", $pStr );
        $pStr = str_replace( "\r", "", $pStr );

        //initialize the StringTags class
        $sWork = new Pdf_String_Tags( $this->nTagWidthMax );

        //get the string divisions by tags
        $this->aDataInfo = $sWork->get_tags( $pStr );

        foreach ( $this->aDataInfo as &$val ) {
            $val[ 'text' ] = html_entity_decode( $val[ 'text' ] );
        }

        unset( $val );
    }


    /**
     * This method parses the current text and return an array that contains the text information for each line that will be drawed.
     *
     *
     * @param int|number $nWidth number - width of the line
     * @param $pStr string - String to be parsed
     * @return array $aStrLines - contains parsed text information.
     */
    public function stringToLines( $nWidth = 0, $pStr )
    {
        //save the current style settings, this will be the default in case of no style is specified
        $this->saveCurrentStyle();
        $this->resetData();

        $this->divideByTags( $pStr );

        $bLastLine = !( count( $this->aDataInfo ) > 0 );

        $aStrLines = array();

        while ( !$bLastLine ) {

            //make a line
            $str_data = $this->makeLine( $nWidth );
            array_push( $aStrLines, $str_data );

            //check for last line
            $bLastLine = !( count( $this->aDataInfo ) > 0 );
        }

        //APPLY THE DEFAULT STYLE
        $this->applyStyle( "DEFAULT" );

        return $aStrLines;
    }


    /**
     * Draws a Tag Based formatted line returned from makeLine function into the pdf document
     *
     *
     * @param $nWidth number - width of the text
     * @param $nHeight number - height of a line
     * @param $aTxt array - data with text to be draw
     * @param $align string - align of the text
     */
    protected function printLine( $nWidth, $nHeight, $aTxt, $align = 'J' )
    {
        if ( 0 == $nWidth ) {
            $nWidth = $this->oPdfi->getRemainingWidth();
        }

        $nMaximumWidth = $nWidth; //Maximum width

        $nTotalWidth = 0; //the total width of all strings
        $nTotalSpaces = 0; //the total number of spaces

        $nr = count( $aTxt ); //number of elements

        for ( $i = 0; $i < $nr; $i++ ) {
            $nTotalWidth += $aTxt[ $i ][ 'width' ];
            $nTotalSpaces += $aTxt[ $i ][ 'spaces' ];
        }

        //default
        $w_first = 0;
        $extra_space = 0;

        switch ( $align ) {
            case 'J':
                if ( $nTotalSpaces > 0 )
                    $extra_space = ( $nMaximumWidth - $nTotalWidth ) / $nTotalSpaces;
                else
                    $extra_space = 0;
                break;
            case 'L':
                break;
            case 'C':
                $w_first = ( $nMaximumWidth - $nTotalWidth ) / 2;
                break;
            case 'R':
                $w_first = $nMaximumWidth - $nTotalWidth;
                break;
        }

        // Output the first Cell
        if ( $w_first != 0 ) {
            $this->oPdf->Cell( $w_first, $nHeight, "", self::DEBUG_CELL_BORDERS, 0, "L", 0 );
        }

        $last_width = $nMaximumWidth - $w_first;

        while ( false != ( list ( , $val ) = each( $aTxt ) ) ) {

            $bYPosUsed = false;

            //apply current tag style
            $this->applyStyle( $val[ 'tag' ] );

            //If > 0 then we will move the current X Position
            $extra_X = 0;

            if ( $val[ 'ypos' ] != 0 ) {
                $lastY = $this->oPdf->y;
                $this->oPdf->y = $lastY - $val[ 'ypos' ];
                $bYPosUsed = true;
            }

            //string width
            $width = $val[ 'width' ];

            if ( $width == 0 )
                continue; // No width jump over!!!


            if ( $align == 'J' ) {
                if ( $val[ 'spaces' ] < 1 )
                    $temp_X = 0;
                else
                    $temp_X = $extra_space;

                $this->oPdf->ws = $temp_X;

                $this->oPdf->_out( sprintf( '%.3f Tw', $temp_X * $this->oPdf->k ) );

                $extra_X = $extra_space * $val[ 'spaces' ]; //increase the extra_X Space
            } else {
                $this->oPdf->ws = 0;
                $this->oPdf->_out( '0 Tw' );
            }


            //Output the Text/Links
            $this->oPdf->Cell( $width, $nHeight, $val[ 'text' ], self::DEBUG_CELL_BORDERS, 0, "C", 0, $val[ 'href' ] );

            $last_width -= $width; //last column width


            if ( $extra_X != 0 ) {
                $this->oPdf->SetX( $this->oPdf->GetX() + $extra_X );
                $last_width -= $extra_X;
            }


            if ( $bYPosUsed )
                $this->oPdf->y = $lastY;
        }

        // Output the Last Cell
        if ( $last_width != 0 ) {
            $this->oPdfi->Cell( $last_width, $nHeight, "", self::DEBUG_CELL_BORDERS, 0, "", 0 );
        }
    }


    /**
     * Function executed BEFORE a new page is added for further actions on the current page.
     * Usually overwritted.
     */
    public function beforeAddPage()
    {
        /*
         * TODO: place your code here
         */
    }


    /**
     * Function executed AFTER a new page is added for pre - actions on the current page.
     * Usually overwritted.
     */
    public function afterAddPage()
    {
        /*
         * TODO: place your code here
         */
    }


    /**
     * Returns the Width of the Specified Char.
     * The Font Style / Size are taken from the tag specifications!
     *
     * @param $tag string - inner tag
     * @param $char number - character specified by ascii/unicode code
     * @return number - the char width
     */
    protected function mt_getCharWidth( $tag, $char )
    {
        //if this font was not used untill now,
        $this->applyStyle( $tag );
        $fw[ $tag ][ 'w' ] = $this->oPdf->CurrentFont[ 'cw' ]; //width
        $fw[ $tag ][ 's' ] = $this->oPdf->FontSize; //size


        return $fw[ $tag ][ 'w' ][ chr( $char ) ] * $fw[ $tag ][ 's' ] / 1000;
    }


    /**
     * Returns the Available Width to draw the Text.
     *
     * @param number $nWidth
     * @param int|number $nPaddingLeft
     * @param int|number $nPaddingRight
     * @return number the width
     */
    protected function mt_getAvailableTextWidth( $nWidth, $nPaddingLeft = 0, $nPaddingRight = 0 )
    {
        //if with is == 0
        if ( 0 == $nWidth ) {
            $nWidth = $this->oPdf->w - $this->oPdf->rMargin - $this->oPdf->x;
        }

        /**
         * If the vertical padding is bigger than the width then we ignore it In this case we put them to 0.
         */
        if ( ( $nPaddingLeft + $nPaddingRight ) > $nWidth ) {
            $nPaddingLeft = 0;
            $nPaddingRight = 0;
        }

        //read width of the text
        $nTextWidth = $nWidth - $nPaddingLeft - $nPaddingRight;

        return $nTextWidth;
    }


    /**
     * Returns the Maximum width of the lines of a Tag based formatted Text(String).
     * If the optional width parameter is not specified if functions the same as if "autobreak" would be disabled.
     *
     * @param string $sText Tag based formatted Text
     * @param int|number $nWidth The specified Width. Optional.
     * @return number The maximum line Width
     */
    public function getMultiCellTagWidth( $sText, $nWidth = 999999 )
    {
        $aRecData = $this->stringToLines( $nWidth, $sText );

        $nMaxWidth = 0;

        foreach ( $aRecData as $aLine ) {

            $nLineWidth = 0;
            foreach ( $aLine as $aLineComponent ) {
                $nLineWidth += $aLineComponent[ 'width' ];
            }

            $nMaxWidth = max( $nMaxWidth, $nLineWidth );
        }

        return $nMaxWidth;
    }


    /**
     * Returns the calculated Height of the Tag based formated Text(String) within the specified Width
     *
     * @param number $nWidth
     * @param number $nHeight
     * @param string $sText
     * @return number The calculated height
     */
    public function getMultiCellTagHeight( $nWidth, $nHeight, $sText )
    {
        $aRecData = $this->stringToLines( $nWidth, $sText );

        $nHeight *= count( $aRecData );

        return $nHeight;
    }


    /**
     * Returns the character found in the string at the specified position
     *
     * @param string $sString
     * @param int $nPosition
     * @return string
     */
    protected static function strchar( $sString, $nPosition )
    {
        return self::substr( $sString, $nPosition, 1 );
    }


    /**
     * Get string length
     *
     * @param string $sStr
     * @return int
     */
    public static function strlen( $sStr )
    {
        return strlen( $sStr );
    }


    /**
     * Return part of a string
     *
     * @param string $sStr
     * @param number $nStart
     * @param number $nLenght
     * @return string
     */
    public static function substr( $sStr, $nStart, $nLenght = null )
    {
        if ( null === $nLenght ) {
            return substr( $sStr, $nStart );
        } else {
            return substr( $sStr, $nStart, $nLenght );
        }
    }


    /**
     * Enable or disable background fill.
     *
     * @param boolean $value
     */
    public function enableFill( $value )
    {
        $this->bFill = $value;
    }
}