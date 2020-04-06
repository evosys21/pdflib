<?php

/**
 * This file is part of the Interpid PDF Addon package.
 *
 * @author Interpid <office@interpid.eu>
 * @copyright (c) Interpid, http://www.interpid.eu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Interpid\PdfLib;

if (!defined('PARAGRAPH_STRING')) {
    define('PARAGRAPH_STRING', '~~~');
}

use Interpid\PdfLib\String\Tags;

/**
 * Pdf Multicell
 * @package Interpid\PdfLib
 */
class Multicell
{
    const DEBUG_CELL_BORDERS = 0;
    const SEPARATOR = ' ,.:;';

    /**
     * The list of line breaking characters Default to self::SEPARATOR
     *
     * @var string
     */
    protected $lineBreakingChars;

    /**
     * Valid Tag Maximum Width
     *
     * @var integer
     */
    protected $tagWidthMax = 25;

    /**
     * The current active tag
     *
     * @var string
     */
    protected $currentTag = '';

    /**
     * Tags Font Information
     *
     * @var array
     */
    protected $fontInfo;

    /**
     * Parsed string data info
     *
     * @var array
     */
    protected $dataInfo;

    /**
     * Data Extra Info
     *
     * @var array
     */
    protected $dataExtraInfo;

    /**
     * Temporary Info
     *
     *
     * @var array
     */
    protected $tempData;

    /**
     * == true if a tag was more times defined.
     *
     * @var boolean
     */
    protected $doubleTags = false;

    /**
     * Pointer to the pdf object
     *
     * @var Pdf
     */
    protected $pdf = null;

    /**
     * PDF Interface Object
     *
     * @var PdfInterface
     *
     */
    protected $pdfi;

    /**
     * Contains the Singleton Object
     *
     * @var object
     */
    private static $_singleton = []; //implements the Singleton Pattern


    protected $fill = true;

    protected $tagStyle = [];

    /**
     * Class constructor.
     *
     * @param Pdf $pdf Instance of the pdf class
     */
    public function __construct($pdf)
    {
        $this->pdf = $pdf;
        $this->pdfi = new PdfInterface($pdf);
        $this->lineBreakingChars = self::SEPARATOR;
    }


    /**
     * Returns the PDF object
     *
     * @return Pdf
     */
    public function getPdfObject()
    {
        return $this->pdf;
    }


    /**
     * Returns the Pdf Interface Object
     *
     * @return PdfInterface
     */
    public function getPdfInterfaceObject()
    {
        return $this->pdfi;
    }


    /**
     * Returnes the Singleton Instance of this class.
     *
     * @param Pdf $pdf Instance of the pdf class
     * @return self
     */
    public static function getInstance($pdf)
    {
        $oInstance = &self::$_singleton[spl_object_hash($pdf)];

        if (!isset($oInstance)) {
            $oInstance = new self($pdf);
        }

        return $oInstance;
    }


    /**
     * Sets the list of characters that will allow a line-breaking
     *
     * @param $sChars string
     */
    public function setLineBreakingCharacters($sChars)
    {
        $this->lineBreakingChars = $sChars;
    }


    /**
     * Resets the list of characters that will allow a line-breaking
     */
    public function resetLineBreakingCharacters()
    {
        $this->lineBreakingChars = self::SEPARATOR;
    }


    /**
     * Sets the attrbitues for the specified tag
     *
     * @param string $tag tag name/key
     * @param float|null $fontSize font size
     * @param string|null $fontStyle font style
     * @param string|array|null $color
     * @param string|null $fontFamily font family
     * @param string $inherit
     */
    public function setStyle($tag, $fontSize = null, $fontStyle = null, $color = null, $fontFamily = null, $inherit = 'base')
    {
        if ($tag == 'ttags') {
            $this->pdf->Error(">> ttags << is reserved TAG Name.");
        }
        if ($tag == '') {
            $this->pdf->Error("Empty TAG Name.");
        }

        //use case insensitive tags
        $tag = trim(strtoupper($tag));
        $inherit = trim(strtoupper($inherit));

        if (isset($this->tagStyle[$tag])) {
            $this->doubleTags = true;
        }

        $tagData = [
            'family' => Tools::string($fontFamily),
            'style' => Tools::string($fontStyle),
            'size' => Tools::string($fontSize),
            'color' => Tools::color($color),
            'textcolor_pdf' => '',
        ];

        if ($inherit && $inherit !== $tag) {
            if (isset($this->tagStyle[$inherit])) {
                $tagData = Tools::mergeNonNull($tagData, $this->tagStyle[$inherit]);
            }
        }

        $this->tagStyle[$tag] = $tagData;
    }


    /**
     * Sets the Tags Maximum width
     *
     * @param int|number $iWidth the width of the tags
     */
    public function setTagWidthMax($iWidth = 25)
    {
        $this->tagWidthMax = $iWidth;
    }


    /**
     * Resets the current class internal variables to default values
     */
    protected function resetData()
    {
        $this->currentTag = '';

        //@formatter:off
        $this->dataInfo = [];
        $this->dataExtraInfo = array(
            "LAST_LINE_BR" => '', //CURRENT LINE BREAK TYPE
            "CURRENT_LINE_BR" => '', //LAST LINE BREAK TYPE
            "TAB_WIDTH" => 10
        ); //The tab WIDTH IS IN mm
        //@formatter:on

        //if another measure unit is used ... calculate your OWN
        $this->dataExtraInfo["TAB_WIDTH"] *= (72 / 25.4) / $this->pdf->k;
    }


    /**
     * Returns the specified tag font family
     *
     * @param string $tag tag name
     * @return string The font family
     */
    public function getTagFont($tag)
    {
        return $this->getTagAttribute($tag, 'family');
    }


    /**
     * Returns the specified tag font style
     *
     * @param string $tag tag name
     * @return string The font style
     */
    public function getTagFontStyle($tag)
    {
        return $this->getTagAttribute($tag, 'style');
    }


    /**
     * Returns the specified tag font size
     *
     * @param string $tag tag name
     * @return string The font size
     */
    public function getTagSize($tag)
    {
        return $this->getTagAttribute($tag, 'size');
    }


    /**
     * Returns the specified tag text color
     *
     * @param string $tag tag name
     * @return string The tag color
     */
    public function getTagColor($tag)
    {
        return $this->getTagAttribute($tag, 'color');
    }


    /**
     * Returns the attribute the specified tag
     *
     * @param string $tag tag name
     * @param string $attribute attribute name
     * @return mixed
     * @throws \Exception
     */
    protected function getTagAttribute($tag, $attribute)
    {

        $tags = explode('/', $tag);
        //reverse the array - the latter is going to be first
        $tags = array_reverse($tags);
        foreach ($tags as $oneTag) {
            $val = $this->getOneTagAttribute($oneTag, $attribute);
            if (!is_null($val)) {
                return $val;
            }
        }

        if ($tag !== 'DEFAULT') {
            //avoid recursivity
            return $this->getOneTagAttribute('DEFAULT', $attribute);
        }

        return '';
    }

    /**
     * Returns the attribute the specified tag
     *
     * @param string $tag tag name
     * @param string $attribute attribute name
     * @return mixed
     */
    protected function getOneTagAttribute($tag, $attribute)
    {
        //tags are saved uppercase!
        $tag = strtoupper($tag);

        if ('TTAGS' === $tag) {
            $tag = 'DEFAULT';
        }
        if ('PPARG' === $tag) {
            $tag = 'DEFAULT';
        }
        if ('' === $tag) {
            $tag = 'DEFAULT';
        }

        if (!isset($this->tagStyle[$tag])) {
            $tag = 'DEFAULT';
        }

        if (isset($this->tagStyle[$tag][$attribute])) {
            return $this->tagStyle[$tag][$attribute];
        }

        return null;
    }


    /**
     * Sets the styles from the specified tag active.
     * Font family, style, size and text color.
     *
     * If the tag is not found then the DEFAULT tag is being used
     *
     * @param string $tag tag name
     */
    protected function applyStyle($tag)
    {
        if ($this->currentTag == $tag) {
            return;
        }

        $this->currentTag = $tag;

        $fontFamily = $this->getTagFont($tag);
        $fontStyle = $this->getTagFontStyle($tag);
        $fontSize = $this->getTagSize($tag);
        $color = $this->getTagColor($tag);

        if (strpos($fontSize, '%') !== false) {
            $fontSize = $this->pdf->FontSizePt * (((float)$fontSize) / 100);
        }

        $this->pdf->SetFont($fontFamily, $fontStyle, $fontSize);

        $textColorPdf = $this->getTagAttribute($tag, 'textcolor_pdf');

        if ($textColorPdf) {
            $this->pdf->TextColor = $textColorPdf;
            $this->pdf->ColorFlag = ($this->pdf->FillColor != $this->pdf->TextColor);
        } else {
            if ($color) {
                $colorData = is_array($color) ? $color : explode(',', $color);
                // added to support Grayscale, RGB and CMYK
                call_user_func_array([$this->pdf, 'SetTextColor'], $colorData);
            }
        }
    }


    /**
     * Save the current settings as a tag default style under the DEFAUTLT tag name
     *
     * @return void
     */
    protected function saveCurrentStyle()
    {
        $this->tagStyle['DEFAULT']['family'] = $this->pdfi->getFontFamily();
        $this->tagStyle['DEFAULT']['style'] = $this->pdfi->getFontStyle();
        $this->tagStyle['DEFAULT']['size'] = $this->pdfi->getFontSizePt();
        $this->tagStyle['DEFAULT']['textcolor_pdf'] = $this->pdf->TextColor;
        $this->tagStyle['DEFAULT']['color'] = '';
    }


    /**
     * Divides $this->dataInfo and returnes a line from this variable
     *
     * @param $width
     * @return array $aLine - array() -> contains informations to draw a line
     * @internal param number $width the width of the cell
     */
    protected function makeLine($width)
    {
        //last line break >> current line break
        $this->dataExtraInfo['LAST_LINE_BR'] = $this->dataExtraInfo['CURRENT_LINE_BR'];
        $this->dataExtraInfo['CURRENT_LINE_BR'] = '';

        if (0 == $width) {
            $width = $this->pdfi->getRemainingWidth();
        }

        $nMaximumWidth = $width;

        $aLine = []; //this will contain the result
        $bReturnResult = false; //if break and return result
        $bResetSpaces = false;

        $nLineWith = 0; //line string width
        $totalChars = 0; //total characters included in the result string
        $fw = &$this->fontInfo; //font info array


        $last_sepch = ''; //last separator character


        foreach ($this->dataInfo as $key => $val) {
            $s = $val['text'];

            $tag = $val['tag'];

            $bParagraph = false;
            if (($s == "\t") && (strpos($tag, 'pparg') !== false)) {
                $bParagraph = true;
                $s = "\t"; //place instead a TAB
            }

            $i = 0; //from where is the string remain
            $j = 0; //untill where is the string good to copy -- leave this == 1->> copy at least one character!!!
            $currentWidth = 0; //string width
            $last_sep = -1; //last separator position
            $last_sepwidth = 0;
            $last_sepch_width = 0;
            $ante_last_sep = -1; //ante last separator position
            $ante_last_sepch = '';
            $ante_last_sepwidth = 0;
            $nSpaces = 0;

            $aString = $this->pdfi->stringToArray($s);
            $nStringLength = count($aString);

            //parse the whole string
            while ($i < $nStringLength) {
                $c = $aString[$i];

                if ($c == ord("\n")) { //Explicit line break
                    $i++; //ignore/skip this caracter
                    $this->dataExtraInfo['CURRENT_LINE_BR'] = 'BREAK';
                    $bReturnResult = true;
                    $bResetSpaces = true;
                    break;
                }

                //space
                if ($c == ord(" ")) {
                    $nSpaces++;
                }

                //    Font Width / Size Array
                if (!isset($fw[$tag]) || ($tag == '') || ($this->doubleTags)) {
                    //if this font was not used untill now,
                    $this->applyStyle($tag);
                    $fw[$tag]['CurrentFont'] = &$this->pdf->CurrentFont; //this can be copied by reference!
                    $fw[$tag]['FontSize'] = $this->pdf->FontSize;
                }

                $char_width = $this->mt_getCharWidth($tag, $c);

                //separators
                if (in_array($c, array_map('ord', str_split($this->lineBreakingChars)))) {
                    $ante_last_sep = $last_sep;
                    $ante_last_sepch = $last_sepch;
                    $ante_last_sepwidth = $last_sepwidth;

                    $last_sep = $i; //last separator position
                    $last_sepch = $c; //last separator char
                    $last_sepch_width = $char_width; //last separator char
                    $last_sepwidth = $currentWidth;
                }

                if ($c == ord("\t")) { //TAB
                    //$c = $s[$i] = '';
                    $c = ord('');
                    $s = substr_replace($s, '', $i, 1);
                    $char_width = $this->dataExtraInfo['TAB_WIDTH'];
                }

                if ($bParagraph == true) {
                    $c = ord('');
                    $s = substr_replace($s, ' ', $i, 1);
                    $char_width = $this->tempData['LAST_TAB_REQSIZE'] - $this->tempData['LAST_TAB_SIZE'];
                    if ($char_width < 0) {
                        $char_width = 0;
                    }
                }

                $nLineWith += $char_width;

                //round these values to a precision of 5! should be enough
                if (round($nLineWith, 5) > round($nMaximumWidth, 5)) { //Automatic line break


                    $this->dataExtraInfo['CURRENT_LINE_BR'] = 'AUTO';

                    if ($totalChars == 0) {
                        /*
                         * This MEANS that the width is lower than a char width... Put $i and $j to 1 ... otherwise infinite while
                         */
                        $i = 1;
                        $j = 1;
                        $bReturnResult = true; //YES RETURN THE RESULT!!!
                        break;
                    }


                    if ($last_sep != -1) {
                        //we have a separator in this tag!!!
                        //untill now there one separator
                        if (($last_sepch == $c) && ($last_sepch != ord(" ")) && ($ante_last_sep != -1)) {
                            /*
                             * this is the last character and it is a separator, if it is a space the leave it... Have to jump back to the last separator... even a space
                             */
                            $last_sep = $ante_last_sep;
                            $last_sepch = $ante_last_sepch;
                            $last_sepwidth = $ante_last_sepwidth;
                        }

                        if ($last_sepch == ord(" ")) {
                            $j = $last_sep; //just ignore the last space (it is at end of line)
                            $i = $last_sep + 1;
                            if ($nSpaces > 0) {
                                $nSpaces--;
                            }
                            $currentWidth = $last_sepwidth;
                        } else {
                            $j = $last_sep + 1;
                            $i = $last_sep + 1;
                            $currentWidth = $last_sepwidth + $last_sepch_width;
                        }
                    } elseif (count($aLine) > 0) {
                        //we have elements in the last tag!!!!
                        if ($last_sepch == ord(" ")) { //the last tag ends with a space, have to remove it


                            $temp = &$aLine[count($aLine) - 1];

                            if (' ' == self::strchar($temp['text'], -1)) {
                                $temp['text'] = self::substr(
                                    $temp['text'],
                                    0,
                                    self::strlen($temp['text']) - 1
                                );
                                $temp['width'] -= $this->mt_getCharWidth($temp['tag'], ord(' '));
                                $temp['spaces']--;

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
                $currentWidth += $char_width;

                $i++;
                $j = $i;
                $totalChars++;
            }


            $str = self::substr($s, 0, $j);

            $sTmpStr = $this->dataInfo[0]['text'];
            $sTmpStr = self::substr($sTmpStr, $i, self::strlen($sTmpStr));

            if (($sTmpStr == '') || ($sTmpStr === false)) {
                array_shift($this->dataInfo);
            } else {
                $this->dataInfo[0]['text'] = $sTmpStr;
            }

            $y = isset($val['y']) ? $val['y'] : (isset($val['ypos']) ? $val['ypos'] : 0);

            $cellData = [
                'text' => $str,
                'char' => $totalChars,
                'tag' => $val['tag'],
                'custom_width' => 0,
                'width_real' => $currentWidth,
                'width' => $currentWidth,
                'spaces' => $nSpaces,
                'align' => Tools::getValue($val, 'align'),
                'href' => Tools::getValue($val, 'href', ''),
                'y' => $y
            ];


            if (isset($val['width'])) {
                $cellData['custom_width'] = $val['width'];
                $cellData['width'] = $val['width'];
            }

            //we have a partial result
            array_push($aLine, $cellData);


            $this->tempData['LAST_TAB_SIZE'] = $currentWidth;
            $this->tempData['LAST_TAB_REQSIZE'] = (isset($val['size'])) ? $val['size'] : 0;

            if ($bReturnResult) {
                break;
            } //break this for
        }


        // Check the first and last tag -> if first and last caracters are " " space remove them!!!"
        if ((count($aLine) > 0) && ($this->dataExtraInfo['LAST_LINE_BR'] == 'AUTO')) {

            // first tag
            // If the first character is a space, then cut it off
            $temp = &$aLine[0];
            if ((self::strlen($temp['text']) > 0) && (" " == self::strchar($temp['text'], 0))) {
                $temp['text'] = self::substr($temp['text'], 1, self::strlen($temp['text']));
                $temp['width'] -= $this->mt_getCharWidth($temp['tag'], ord(" "));
                $temp['width_real'] -= $this->mt_getCharWidth($temp['tag'], ord(" "));
                $temp['spaces']--;
            }

            // If the last character is a space, then cut it off
            $temp = &$aLine[count($aLine) - 1];
            if ((self::strlen($temp['text']) > 0) && (" " == self::strchar($temp['text'], -1))) {
                $temp['text'] = self::substr($temp['text'], 0, self::strlen($temp['text']) - 1);
                $temp['width'] -= $this->mt_getCharWidth($temp['tag'], ord(" "));
                $temp['width_real'] -= $this->mt_getCharWidth($temp['tag'], ord(" "));
                $temp['spaces']--;
            }
        }

        if ($bResetSpaces) { //this is used in case of a "Explicit Line Break"
            //put all spaces to 0 so in case of 'J' align there is no space extension
            for ($k = 0; $k < count($aLine); $k++) {
                $aLine[$k]['spaces'] = 0;
            }
        }

        return $aLine;
    }


    /**
     * Draws a MultiCell with a TAG Based Formatted String as an Input
     *
     *
     * @param number $width width of the cell
     * @param number $height height of the lines in the cell
     * @param mixed(string|array) $data string or formatted data to be putted in the multicell
     * @param mixed(string|number) $border Indicates if borders must be drawn around the cell block. The value can be either a number: 0 = no border 1 = frame border or a string containing some or
     * all of the following characters (in any order): L: left T: top R: right B: bottom
     * @param string $align Sets the text alignment Possible values: L: left R: right C: center J: justified
     * @param int|number $fill Indicates if the cell background must be painted (1) or transparent (0). Default value: 0.
     * @param int|number $paddingLeft Left padding
     * @param int|number $paddingTop Top padding
     * @param int|number $paddingRight Right padding
     * @param int|number $paddingBottom Bottom padding
     */
    public function multiCell(
        $width,
        $height,
        $data,
        $border = 0,
        $align = 'J',
        $fill = 0,
        $paddingLeft = 0,
        $paddingTop = 0,
        $paddingRight = 0,
        $paddingBottom = 0
    ) {
        //get the available width for the text
        $w_text = $this->mt_getAvailableTextWidth($width, $paddingLeft, $paddingRight);

        $nStartX = $this->pdf->GetX();
        $aRecData = $this->stringToLines($w_text, $data);
        $iCounter = 9999; //avoid infinite loop for any reasons

        $doBreak = false;

        do {
            $iLeftHeight = $this->pdf->h - $this->pdf->bMargin - $this->pdf->GetY() - $paddingTop - $paddingBottom;
            $bAddNewPage = false;

            //Number of rows that have space on this page:
            $iRows = floor($iLeftHeight / $height);
            // Added check for 'AcceptPageBreak'
            if (count($aRecData) > $iRows && $this->pdf->AcceptPageBreak()) {
                $aSendData = array_slice($aRecData, 0, $iRows);
                $aRecData = array_slice($aRecData, $iRows);
                $bAddNewPage = true;
            } else {
                $aSendData = &$aRecData;
                $doBreak = true;
            }

            $this->multiCellSec(
                $width,
                $height,
                $aSendData,
                $border,
                $align,
                $fill,
                $paddingLeft,
                $paddingTop,
                $paddingRight,
                $paddingBottom,
                false
            );

            if (true == $bAddNewPage) {
                $this->beforeAddPage();
                $this->pdf->AddPage();
                $this->afterAddPage();
                $this->pdf->SetX($nStartX);
            }
        } while ((($iCounter--) > 0) && (false == $doBreak));
    }


    /**
     * Draws a MultiCell with TAG recognition parameters
     *
     *
     * @param number $width width of the cell
     * @param number $height height of the lines in the cell
     * @param mixed(string|array) $data - string or formatted data to be putted in the multicell
     * @param int $border
     * @param $align string - Sets the text alignment Possible values: L: left R: right C: center J: justified
     * @param int|number $fill Indicates if the cell background must be painted (1) or transparent (0). Default value: 0.
     * @param int|number $paddingLeft Left pad
     * @param int|number $paddingTop Top pad
     * @param int|number $paddingRight Right pad
     * @param int|number $paddingBottom Bottom pad
     * @param $bDataIsString boolean - true if $data is a string - false if $data is an array containing lines formatted with $this->makeLine($width) function (the false option is used in relation
     * with stringToLines, to avoid double formatting of a string
     * @return void
     * @internal param \or $string number $border Indicates if borders must be drawn around the cell block. The value can be either a number: 0 = no border 1 = frame border or a string containing some or all of
     * the following characters (in any order): L: left T: top R: right B: bottom
     */
    public function multiCellSec(
        $width,
        $height,
        $data,
        $border = 0,
        $align = 'J',
        $fill = 0,
        $paddingLeft = 0,
        $paddingTop = 0,
        $paddingRight = 0,
        $paddingBottom = 0,
        $bDataIsString = true
    ) {
        //save the current style settings, this will be the default in case of no style is specified
        $this->saveCurrentStyle();
        $this->resetData();

        //if data is string
        if ($bDataIsString === true) {
            $this->divideByTags($data);
        }

        $b = $b1 = $b2 = $b3 = ''; //borders


        if ($width == 0) {
            $width = $this->pdf->w - $this->pdf->rMargin - $this->pdf->x;
        }

        /**
         * If the vertical padding is bigger than the width then we ignore it In this case we put them to 0.
         */
        if (($paddingLeft + $paddingRight) > $width) {
            $paddingLeft = 0;
            $paddingRight = 0;
        }

        $w_text = $width - $paddingLeft - $paddingRight;

        //save the current X position, we will have to jump back!!!!
        $startX = $this->pdf->GetX();

        if ($border) {
            if ($border == 1) {
                $border = 'LTRB';
                $b1 = 'LRT'; //without the bottom
                $b2 = 'LR'; //without the top and bottom
                $b3 = 'LRB'; //without the top
            } else {
                $b2 = '';
                if (is_int(strpos($border, 'L'))) {
                    $b2 .= 'L';
                }
                if (is_int(strpos($border, 'R'))) {
                    $b2 .= 'R';
                }
                $b1 = is_int(strpos($border, 'T')) ? $b2 . 'T' : $b2;
                $b3 = is_int(strpos($border, 'B')) ? $b2 . 'B' : $b2;
            }

            //used if there is only one line
            $b = '';
            $b .= is_int(strpos($border, 'L')) ? 'L' : '';
            $b .= is_int(strpos($border, 'R')) ? 'R' : '';
            $b .= is_int(strpos($border, 'T')) ? 'T' : '';
            $b .= is_int(strpos($border, 'B')) ? 'B' : '';
        }

        $bFirstLine = true;

        if ($bDataIsString === true) {
            $bLastLine = !(count($this->dataInfo) > 0);
        } else {
            $bLastLine = !(count($data) > 0);
        }

        while (!$bLastLine) {
            if ($bFirstLine && ($paddingTop > 0)) {
                /**
                 * If this is the first line and there is top_padding
                 */
                $x = $this->pdf->GetX();
                $y = $this->pdf->GetY();
                $this->pdfi->Cell($width, $paddingTop, '', $b1, 0, $align, $this->fill, '');
                $b1 = str_replace('T', '', $b1);
                $b = str_replace('T', '', $b);
                $this->pdf->SetXY($x, $y + $paddingTop);
            }

            if ($fill == 1) {
                //fill in the cell at this point and write after the text without filling
                $this->pdf->SetX($startX); //restore the X position
                $this->pdfi->Cell($width, $height, '', 0, 0, '', $this->fill);
                $this->pdf->SetX($startX); //restore the X position
            }

            if ($bDataIsString === true) {
                //make a line
                $str_data = $this->makeLine($w_text);
                //check for last line
                $bLastLine = !(count($this->dataInfo) > 0);
            } else {
                //make a line
                $str_data = array_shift($data);
                //check for last line
                $bLastLine = !(count($data) > 0);
            }

            if ($bLastLine && ($align == 'J')) { //do not Justify the Last Line
                $align = 'L';
            }

            /**
             * Restore the X position with the corresponding padding if it exist The Right padding is done automatically by calculating the width of the text
             */
            $this->pdf->SetX($startX + $paddingLeft);
            $this->printLine($w_text, $height, $str_data, $align);

            //see what border we draw:
            if ($bFirstLine && $bLastLine) {
                //we have only 1 line
                $real_brd = $b;
            } elseif ($bFirstLine) {
                $real_brd = $b1;
            } elseif ($bLastLine) {
                $real_brd = $b3;
            } else {
                $real_brd = $b2;
            }

            if ($bLastLine && ($paddingBottom > 0)) {
                /**
                 * If we have bottom padding then the border and the padding is outputted
                 */
                $this->pdf->SetX($startX); //restore the X
                $this->pdfi->Cell($width, $height, '', $b2, 2);
                $this->pdf->SetX($startX); //restore the X
                $this->pdf->MultiCell($width, $paddingBottom, '', $real_brd, $align, $this->fill);
            } else {
                //draw the border and jump to the next line
                $this->pdf->SetX($startX); //restore the X
                $this->pdfi->Cell($width, $height, '', $real_brd, 2);
            }

            if ($bFirstLine) {
                $bFirstLine = false;
            }
        }

        //APPLY THE DEFAULT STYLE
        $this->applyStyle('DEFAULT');

        $this->pdf->x = $this->pdf->lMargin;
    }


    /**
     * This method divides the string into the tags and puts the result into dataInfo variable.
     *
     * @param string $string string to be parsed
     */
    protected function divideByTags($string)
    {
        $string = str_replace("\t", "<ttags>\t</ttags>", $string);
        $string = str_replace(PARAGRAPH_STRING, "<pparg>\t</pparg>", $string);
        $string = str_replace("\r", '', $string);

        //initialize the StringTags class
        $sWork = new Tags($this->tagWidthMax);

        //get the string divisions by tags
        $this->dataInfo = $sWork->getTags($string);

        foreach ($this->dataInfo as &$val) {
            $val['text'] = html_entity_decode($val['text']);
        }

        unset($val);
    }


    /**
     * This method parses the current text and return an array that contains the text information for each line that will be drawed.
     *
     *
     * @param int|number $width width of the line
     * @param string $string - String to be parsed
     * @return array $aStrLines - contains parsed text information.
     */
    public function stringToLines($width, $string)
    {
        //save the current style settings, this will be the default in case of no style is specified
        $this->saveCurrentStyle();
        $this->resetData();

        $this->divideByTags($string);

        $bLastLine = !(count($this->dataInfo) > 0);

        $aStrLines = [];

        $lines = 0;

        while (!$bLastLine) {
            $lines++;

            //make a line
            $str_data = $this->makeLine($width);
            array_push($aStrLines, $str_data);

            #1247 - limit the maximum number of lines
            $maxLines = $this->getMaxLines();
            if ($maxLines > 0 && $lines >= $maxLines) {
                break;
            }

            //check for last line
            $bLastLine = !(count($this->dataInfo) > 0);
        }

        //APPLY THE DEFAULT STYLE
        $this->applyStyle('DEFAULT');

        return $aStrLines;
    }


    /**
     * Draws a Tag Based formatted line returned from makeLine function into the pdf document
     *
     *
     * @param number $width width of the text
     * @param number $height height of a line
     * @param array $data data with text to be draw
     * @param string $align align of the text
     */
    protected function printLine($width, $height, $data, $align = 'J')
    {
        if (0 == $width) {
            $width = $this->pdfi->getRemainingWidth();
        }

        $nMaximumWidth = $width; //Maximum width

        $totalWidth = 0; //the total width of all strings
        $totalSpaces = 0; //the total number of spaces

        $nr = count($data); //number of elements

        for ($i = 0; $i < $nr; $i++) {
            $totalWidth += $data[$i]['width'];
            $totalSpaces += $data[$i]['spaces'];
        }

        //default
        $w_first = 0;
        $extra_space = 0;
        $lastY = 0;

        switch ($align) {
            case 'J':
                if ($totalSpaces > 0) {
                    $extra_space = ($nMaximumWidth - $totalWidth) / $totalSpaces;
                } else {
                    $extra_space = 0;
                }
                break;
            case 'L':
                break;
            case 'C':
                $w_first = ($nMaximumWidth - $totalWidth) / 2;
                break;
            case 'R':
                $w_first = $nMaximumWidth - $totalWidth;
                break;
        }

        // Output the first Cell
        if ($w_first != 0) {
            $this->pdf->Cell($w_first, $height, '', self::DEBUG_CELL_BORDERS, 0, 'L', 0);
        }

        $last_width = $nMaximumWidth - $w_first;

        foreach ($data as $val) {
            $bYPosUsed = false;

            //apply current tag style
            $this->applyStyle($val['tag']);

            //If > 0 then we will move the current X Position
            $extra_X = 0;

            if ($val['y'] != 0) {
                $lastY = $this->pdf->y;
                $this->pdf->y = $lastY - $val['y'];
                $bYPosUsed = true;
            }

            //string width
            $width = $val['width'];

            if ($width == 0) {
                continue;
            } // No width jump over!!!


            if ($align == 'J') {
                if ($val['spaces'] < 1) {
                    $temp_X = 0;
                } else {
                    $temp_X = $extra_space;
                }

                $this->pdf->ws = $temp_X;

                $this->pdf->_out(sprintf('%.3f Tw', $temp_X * $this->pdf->k));

                $extra_X = $extra_space * $val['spaces']; //increase the extra_X Space
            } else {
                $this->pdf->ws = 0;
                $this->pdf->_out('0 Tw');
            }

            if ($val['custom_width']) {
                $cellAlign = Tools::getCellAlign(Tools::getValue($val, 'align', ''));

                switch ($cellAlign) {
                    case 'C':
                        $this->pdf->Cell($val['width'], $height, $val['text'], self::DEBUG_CELL_BORDERS, 0, 'C', 0, $val['href']);
                        break;
                    case 'R':
                        //Output the Text/Links
                        $this->pdf->Cell($val['width'] - $val['width_real'], $height, '', self::DEBUG_CELL_BORDERS);
                        $this->pdf->Cell($val['width_real'], $height, $val['text'], self::DEBUG_CELL_BORDERS, 0, 'C', 0, $val['href']);
                        break;
                    default:
                        //Output the Text/Links
                        $this->pdf->Cell($val['width_real'], $height, $val['text'], self::DEBUG_CELL_BORDERS, 0, 'C', 0, $val['href']);
                        $this->pdf->Cell($val['width'] - $val['width_real'], $height, '', self::DEBUG_CELL_BORDERS);
                        break;
                }
            } else {
                //Output the Text/Links
                $this->pdf->Cell($width, $height, $val['text'], self::DEBUG_CELL_BORDERS, 0, 'C', 0, $val['href']);
            }

            $last_width -= $width; //last column width


            if ($extra_X != 0) {
                $this->pdf->SetX($this->pdf->GetX() + $extra_X);
                $last_width -= $extra_X;
            }


            if ($bYPosUsed) {
                $this->pdf->y = $lastY;
            }
        }

        // Output the Last Cell
        if ($last_width != 0) {
            $this->pdfi->Cell($last_width, $height, '', self::DEBUG_CELL_BORDERS, 0, '', 0);
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
     * @param string $tag inner tag
     * @param string $char character specified by ascii/unicode code
     * @return number the char width
     */
    protected function mt_getCharWidth($tag, $char)
    {
        //if this font was not used untill now,
        $this->applyStyle($tag);
        $fw[ $tag ][ 'w' ] = $this->pdf->CurrentFont[ 'cw' ]; //width
        $fw[ $tag ][ 's' ] = $this->pdf->FontSize; //size


        return $fw[ $tag ][ 'w' ][ chr($char) ] * $fw[ $tag ][ 's' ] / 1000;
    }


    /**
     * Returns the Available Width to draw the Text.
     *
     * @param number $width
     * @param int|number $paddingLeft
     * @param int|number $paddingRight
     * @return number the width
     */
    protected function mt_getAvailableTextWidth($width, $paddingLeft = 0, $paddingRight = 0)
    {
        //if with is == 0
        if (0 == $width) {
            $width = $this->pdf->w - $this->pdf->rMargin - $this->pdf->x;
        }

        /**
         * If the vertical padding is bigger than the width then we ignore it In this case we put them to 0.
         */
        if (($paddingLeft + $paddingRight) > $width) {
            $paddingLeft = 0;
            $paddingRight = 0;
        }

        //read width of the text
        $nTextWidth = $width - $paddingLeft - $paddingRight;

        return $nTextWidth;
    }


    /**
     * Returns the Maximum width of the lines of a Tag based formatted Text(String).
     * If the optional width parameter is not specified if functions the same as if 'autobreak' would be disabled.
     *
     * @param string $sText Tag based formatted Text
     * @param int|number $width The specified Width. Optional.
     * @return number The maximum line Width
     */
    public function getMultiCellTagWidth($sText, $width = 999999)
    {
        $aRecData = $this->stringToLines($width, $sText);

        $nMaxWidth = 0;

        foreach ($aRecData as $aLine) {
            $nLineWidth = 0;
            foreach ($aLine as $aLineComponent) {
                $nLineWidth += $aLineComponent['width'];
            }

            $nMaxWidth = max($nMaxWidth, $nLineWidth);
        }

        return $nMaxWidth;
    }


    /**
     * Returns the calculated Height of the Tag based formated Text(String) within the specified Width
     *
     * @param number $width
     * @param number $height
     * @param string $sText
     * @return number The calculated height
     */
    public function getMultiCellTagHeight($width, $height, $sText)
    {
        $aRecData = $this->stringToLines($width, $sText);

        $height *= count($aRecData);

        return $height;
    }


    /**
     * Returns the character found in the string at the specified position
     *
     * @param string $sString
     * @param int $nPosition
     * @return string
     */
    protected static function strchar($sString, $nPosition)
    {
        return self::substr($sString, $nPosition, 1);
    }


    /**
     * Get string length
     *
     * @param string $sStr
     * @return int
     */
    public static function strlen($sStr)
    {
        return strlen($sStr);
    }


    /**
     * Return part of a string
     *
     * @param string $sStr
     * @param number $nStart
     * @param number $nLenght
     * @return string
     */
    public static function substr($sStr, $nStart, $nLenght = null)
    {
        if (null === $nLenght) {
            return substr($sStr, $nStart);
        } else {
            return substr($sStr, $nStart, $nLenght);
        }
    }


    /**
     * Enable or disable background fill.
     *
     * @param boolean $value
     */
    public function enableFill($value)
    {
        $this->fill = $value;
    }


    protected $maxLines = 0;

    /**
     * @return int
     */
    public function getMaxLines()
    {
        return $this->maxLines;
    }

    /**
     * @param int $maxLines
     * @return $this
     */
    public function setMaxLines($maxLines)
    {
        $this->maxLines = $maxLines;
        return $this;
    }
}
