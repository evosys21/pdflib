<?php
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpDocMissingThrowsInspection */

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

use Exception;
use Interpid\PdfLib\String\Tags;
use Interpid\PdfLib\Utils\Arr;

/**
 * Pdf Multicell
 * @package Interpid\PdfLib
 */
class Multicell
{
    const SEPARATOR = ' ,.:;';
    const DEFAULT_TAG = 'default';
    const PDF_CURRENT = '__current__';

    /**
     * Set to 1 to debug cell borders
     * @var int
     */
    public $cellBorders = 0;

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
    protected $currentTag = '__UNDEFINED__';

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

    /**
     * @var MulticellOptions
     */
    protected $options;

    /**
     * @var MulticellData
     */
    protected $multicellData;

    /**
     * Class constructor.
     *
     * @param Pdf $pdf Instance of the pdf class
     */
    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
        $this->pdfi = new PdfInterface($pdf);
        $this->lineBreakingChars = self::SEPARATOR;
        $this->options = new MulticellOptions($this->pdfi);
    }

    /**
     * Reset the multicell options
     * @return self
     */
    public function reset(): self
    {
        $this->options->resetCellOptions();
        return $this;
    }


    /**
     * Returns the PDF object
     *
     * @return Pdf
     */
    public function getPdfObject(): ?Pdf
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
     * Returns the Singleton Instance of this class.
     *
     * @param Pdf $pdf Instance of the pdf class
     * @return self
     */
    public static function getInstance(Pdf $pdf): self
    {
        $instance = &self::$_singleton[spl_object_hash($pdf)];

        if (!isset($instance)) {
            $instance = new self($pdf);
        }

        return $instance;
    }


    /**
     * Sets the list of characters that will allow a line-breaking
     *
     * @param $string string
     */
    public function setLineBreakingCharacters(string $string)
    {
        $this->lineBreakingChars = $string;
    }


    /**
     * Resets the list of characters that will allow a line-breaking
     */
    public function resetLineBreakingCharacters()
    {
        $this->lineBreakingChars = self::SEPARATOR;
    }


    /**
     * Sets the attributes for the specified tag
     *
     * @param string $tag tag name/key
     * @param int|float|null $fontSize font size
     * @param string|null $fontStyle font style
     * @param string|array|null $color
     * @param string|null $fontFamily font family
     * @param string|null $inherit Tag to be inherited
     * @return self
     */
    public function setStyle(string $tag, $fontSize = null, ?string $fontStyle = null, $color = null, ?string $fontFamily = null, ?string $inherit = null):self
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

        if (isset($this->options->styles[$tag])) {
            $this->doubleTags = true;
        }

        $tagData = [
            'family' => Tools::string($fontFamily),
            'style' => Tools::string($fontStyle),
            'size' => Tools::string($fontSize),
            'color' => Tools::color($color),
        ];

        if ($inherit && $inherit !== $tag) {
            if (isset($this->options->styles[$inherit])) {
                $tagData = Tools::mergeNonNull($tagData, $this->options->styles[$inherit]);
            }
        }

        $this->options->styles[$tag] = $tagData;
        return $this;
    }

    /**
     * Define a tag style with a configuration array
     *
     * @param string $tag Tag name
     * @param array $properties Tag properties
     * @param null $inherit Tag to inherit
     */
    public function setStyleAssoc(string $tag, array $properties = [], $inherit = null)
    {
        $this->setStyle(
            $tag,
            Arr::firstKey($properties, ['size', 'font_size']),
            Arr::firstKey($properties, ['style', 'font_style']),
            Arr::firstKey($properties, ['color', 'text_color']),
            Arr::firstKey($properties, ['family', 'font_family']),
            $inherit
        );
    }

    /**
     * Sets the Tags Maximum width
     *
     * @param int $width the width of the tags
     */
    public function setTagWidthMax(int $width = 25)
    {
        $this->tagWidthMax = $width;
    }


    /**
     * Resets the current class internal variables to default values
     */
    protected function resetData()
    {
        $this->currentTag = '__UNDEFINED__';

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
    public function getTagFont(string $tag): string
    {
        return $this->getTagAttribute($tag, 'family');
    }


    /**
     * Returns the specified tag font style
     *
     * @param string $tag tag name
     * @return string The font style
     */
    public function getTagFontStyle(string $tag): string
    {
        return $this->getTagAttribute($tag, 'style');
    }


    /**
     * Returns the specified tag font size
     *
     * @param string $tag tag name
     * @return string The font size
     */
    public function getTagSize(string $tag): string
    {
        return $this->getTagAttribute($tag, 'size');
    }


    /**
     * Returns the specified tag text color
     *
     * @param string $tag tag name
     * @return string|array The tag color
     */
    public function getTagColor(string $tag)
    {
        return $this->getTagAttribute($tag, 'color');
    }


    /**
     * Returns the attribute the specified tag
     *
     * @param string $tag tag name
     * @param string $attribute attribute name
     * @return mixed
     * @throws Exception
     */
    protected function getTagAttribute(string $tag, string $attribute)
    {
        // explode and remove empty values
        $tags = array_filter(explode('/', $tag));
        //reverse the array - the latter is going to be first
        $tags = array_reverse($tags);
        $tags[] = static::DEFAULT_TAG;
        $tags[] = static::PDF_CURRENT;
        foreach ($tags as $oneTag) {
            $val = $this->getOneTagAttribute($oneTag, $attribute);
            if (!is_null($val)) {
                return $val;
            }
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
    protected function getOneTagAttribute(string $tag, string $attribute)
    {
        //tags are saved uppercase!
        $tag = strtoupper($tag);

        if ('TTAGS' === $tag) {
            $tag = static::DEFAULT_TAG;
        }
        if ('PPARG' === $tag) {
            $tag = static::DEFAULT_TAG;
        }
        if ('' === $tag) {
            $tag = static::DEFAULT_TAG;
        }

        if (isset($this->options->styles[$tag][$attribute])) {
            return $this->options->styles[$tag][$attribute];
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
     * @param array $style
     */
    protected function applyStyle(string $tag, array $style = [])
    {
        $tagKey = $tag . md5(serialize($style));

        if ($this->currentTag == $tagKey) {
            return;
        }

        $this->currentTag = $tagKey;

        $fontFamily = $this->getTagFont($tag);
        $fontStyle = $this->getTagFontStyle($tag);
        $color = Tools::getValue($style, 'color');
        if (!$color) {
            $color = $this->getTagColor($tag);
        }
        $fontSize = intval(Tools::getValue($style, 'font-size'));
        if (!$fontSize) {
            $fontSize = $this->getTagSize($tag);
        }

        if (strpos($fontSize, '%') !== false) {
            $fontSize = $this->pdf->FontSizePt * (((float)$fontSize) / 100);
        }

        $this->pdf->SetFont($fontFamily, $fontStyle, $fontSize);

        if ($color) {
            $this->pdfi->setTextColor($color);
        }
    }


    /**
     * Divides $this->dataInfo and returns a line from this variable
     *
     * @param $width
     * @return array $aLine - array() -> contains information to draw a line
     * @internal param number $width the width of the cell
     */
    protected function makeLine($width): array
    {
        //last line break >> current line break
        $this->dataExtraInfo['LAST_LINE_BR'] = $this->dataExtraInfo['CURRENT_LINE_BR'];
        $this->dataExtraInfo['CURRENT_LINE_BR'] = '';

        if (0 == $width) {
            $width = $this->pdfi->getRemainingWidth();
        }

        $maximumWidth = $width;

        $lineData = []; //this will contain the result
        $returnResult = false; //if break and return result
        $resetSpaces = false;

        $lineWith = 0; //line string width
        $totalChars = 0; //total characters included in the result string
        $fw = &$this->fontInfo; //font info array


        $lastSeparator = ''; //last separator character

        foreach ($this->dataInfo as $val) {
            $s = $val['text'];

            $tag = $val['tag'];

            $cellData = [
                'align' => Tools::getValue($val, 'align'),
                'href' => Tools::getValue($val, 'href'),
                'nowrap' => Tools::getValue($val, 'nowrap'),
                'style' => Tools::parseHtmlAttribute(Tools::getValue($val, 'style')),
                'strike' => $this->getStrikeValue($val),
            ];

            $this->applyStyle($tag, $cellData['style']);

            $fw[$tag]['CurrentFont'] = &$this->pdf->CurrentFont; //this can be copied by reference!
            $fw[$tag]['FontSize'] = $this->pdf->FontSize;

            $isParagraph = false;
            if (($s == "\t") && (strpos($tag, 'pparg') !== false)) {
                $isParagraph = true;
                $s = "\t"; //place instead a TAB
            }

            $nowrap = isset($val['nowrap']) && $val['nowrap'];

            $i = 0; //from where is the string remain
            $j = 0; //until where is the string good to copy
            $currentWidth = 0; //string width
            $lastSeparatorPosition = -1; //last separator position
            $lastSeparatorWidth = 0;
            $lastSeparatorCharWidth = 0;
            $anteSeparatorPosition = -1; //ante last separator position
            $anteSeparatorWitdh = '';
            $anteSeparatorCharWidth = 0;
            $spaces = 0;

            $string = $this->pdfi->stringToArray($s);
            $stringLength = count($string);

            //parse the whole string
            while ($i < $stringLength) {
                $c = $string[$i];

                if ($c == ord("\n")) { //Explicit line break
                    $i++; //ignore/skip this character
                    $this->dataExtraInfo['CURRENT_LINE_BR'] = 'BREAK';
                    $returnResult = true;
                    $resetSpaces = true;
                    break;
                }

                //space
                if ($c == ord(" ")) {
                    $spaces++;
                }

                $char_width = $this->mt_getCharWidth($tag, $c);

                //separators
                if (!$nowrap && in_array($c, array_map('ord', str_split($this->lineBreakingChars)))) {
                    $anteSeparatorPosition = $lastSeparatorPosition;
                    $anteSeparatorWitdh = $lastSeparator;
                    $anteSeparatorCharWidth = $lastSeparatorWidth;

                    $lastSeparatorPosition = $i; //last separator position
                    $lastSeparator = $c; //last separator char
                    $lastSeparatorCharWidth = $char_width; //last separator char
                    $lastSeparatorWidth = $currentWidth;
                }

                if ($c == ord("\t")) { //TAB
                    //$c = $s[$i] = '';
                    $c = ord('');
                    $s = substr_replace($s, '', $i, 1);
                    $char_width = $this->dataExtraInfo['TAB_WIDTH'];
                }

                if ($isParagraph) {
                    $c = ord('');
                    $s = substr_replace($s, ' ', $i, 1);
                    $char_width = $this->tempData['LAST_TAB_REQSIZE'] - $this->tempData['LAST_TAB_SIZE'];
                    if ($char_width < 0) {
                        $char_width = 0;
                    }
                }

                $lineWith += $char_width;

                //round these values to a precision of 5! should be enough
                if (round($lineWith, 5) > round($maximumWidth, 5)) { //Automatic line break


                    $this->dataExtraInfo['CURRENT_LINE_BR'] = 'AUTO';

                    if ($totalChars == 0) {
                        /*
                         * This MEANS that the width is lower than a char width... Put $i and $j to 1 ... otherwise infinite while
                         */
                        $i = 1;
                        $j = 1;
                        $returnResult = true; //YES RETURN THE RESULT!!!
                        break;
                    }


                    if ($lastSeparatorPosition != -1) {
                        //we have a separator in this tag!!!
                        //untill now there one separator
                        if (($lastSeparator == $c) && ($lastSeparator != ord(" ")) && ($anteSeparatorPosition != -1)) {
                            /*
                             * this is the last character and it is a separator, if it is a space the leave it... Have to jump back to the last separator... even a space
                             */
                            $lastSeparatorPosition = $anteSeparatorPosition;
                            $lastSeparator = $anteSeparatorWitdh;
                            $lastSeparatorWidth = $anteSeparatorCharWidth;
                        }

                        if ($lastSeparator == ord(" ")) {
                            $j = $lastSeparatorPosition; //just ignore the last space (it is at end of line)
                            $i = $lastSeparatorPosition + 1;
                            if ($spaces > 0) {
                                $spaces--;
                            }
                            $currentWidth = $lastSeparatorWidth;
                        } else {
                            $j = $lastSeparatorPosition + 1;
                            $i = $lastSeparatorPosition + 1;
                            $currentWidth = $lastSeparatorWidth + $lastSeparatorCharWidth;
                        }
                    } elseif (count($lineData) > 0) {
                        //we have elements in the last tag!!!!
                        if ($lastSeparator == ord(" ")) { //the last tag ends with a space, have to remove it


                            $temp = &$lineData[count($lineData) - 1];

                            if (' ' == self::strChar($temp['text'], -1)) {
                                $temp['text'] = self::substr(
                                    $temp['text'],
                                    0,
                                    self::strlen($temp['text']) - 1
                                );
                                $temp['width'] -= $this->mt_getCharWidth($temp['tag'], ord(' '));
                                $temp['spaces']--;

                                break 2;
                            }
                        }
                    }


                    $returnResult = true;
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

            if ($sTmpStr == '') {
                array_shift($this->dataInfo);
            } else {
                $this->dataInfo[0]['text'] = $sTmpStr;
            }

            $y = $val['y'] ?? ($val['ypos'] ?? 0);

            $cellData = array_merge([
                'text' => $str,
                'char' => $totalChars,
                'tag' => $val['tag'],
                'custom_width' => 0,
                'width_real' => $currentWidth,
                'width' => $currentWidth,
                'spaces' => $spaces,
                'y' => $y
            ], $cellData);

            if (isset($val['width'])) {
                $cellData['custom_width'] = $val['width'];
                $cellData['width'] = $val['width'];
            }

            //we have a partial result
            $lineData[] = $cellData;


            $this->tempData['LAST_TAB_SIZE'] = $currentWidth;
            $this->tempData['LAST_TAB_REQSIZE'] = (isset($val['size'])) ? $val['size'] : 0;

            if ($returnResult) {
                break;
            } //break this for
        }


        // Check the first and last tag -> if first and last caracters are " " space remove them!!!"
        if ((count($lineData) > 0) && ($this->dataExtraInfo['LAST_LINE_BR'] == 'AUTO')) {

            // first tag
            // If the first character is a space, then cut it off
            $temp = &$lineData[0];
            if ((self::strlen($temp['text']) > 0) && (" " == self::strChar($temp['text'], 0))) {
                $temp['text'] = self::substr($temp['text'], 1, self::strlen($temp['text']));
                $temp['width'] -= $this->mt_getCharWidth($temp['tag'], ord(" "));
                $temp['width_real'] -= $this->mt_getCharWidth($temp['tag'], ord(" "));
                $temp['spaces']--;
            }

            // If the last character is a space, then cut it off
            $temp = &$lineData[count($lineData) - 1];
            if ((self::strlen($temp['text']) > 0) && (" " == self::strChar($temp['text'], -1))) {
                $temp['text'] = self::substr($temp['text'], 0, self::strlen($temp['text']) - 1);
                $temp['width'] -= $this->mt_getCharWidth($temp['tag'], ord(" "));
                $temp['width_real'] -= $this->mt_getCharWidth($temp['tag'], ord(" "));
                $temp['spaces']--;
            }
        }

        if ($resetSpaces) { //this is used in case of a "Explicit Line Break"
            //put all spaces to 0 so in case of 'J' align there is no space extension
            for ($k = 0; $k < count($lineData); $k++) {
                $lineData[$k]['spaces'] = 0;
            }
        }

        return $lineData;
    }


    /**
     * Draws a MultiCell with a TAG Based Formatted String as an Input
     *
     *
     * @param float $width width of the cell
     * @param float $height height of the lines in the cell
     * @param $data
     * @param string|int $border
     * @param string $align Sets the text alignment Possible values: L: left R: right C: center J: justified
     * @param int $fill Indicates if the cell background must be painted (1) or transparent (0). Default value: 0.
     * @param float $paddingLeft Left padding
     * @param float $paddingTop Top padding
     * @param float $paddingRight Right padding
     * @param float $paddingBottom Bottom padding
     */
    public function multiCell(
        float  $width,
        float  $height,
               $data,
               $border = 0,
        string $align = 'J',
        int    $fill = 0,
        float  $paddingLeft = 0,
        float  $paddingTop = 0,
        float  $paddingRight = 0,
        float  $paddingBottom = 0
    )
    {
        $this->multicellData = new MulticellData($this->pdf);
        $this->multicellData->width = $width;
        $this->multicellData->lineHeight = $height;
        $this->multicellData->string = $data;
        $this->multicellData->border = $border;
        $this->multicellData->align = $align;
        $this->multicellData->fill = $fill;
        $this->multicellData->paddingLeft = $paddingLeft;
        $this->multicellData->paddingTop = $paddingTop;
        $this->multicellData->paddingRight = $paddingRight;
        $this->multicellData->paddingBottom = $paddingBottom;

        $this->multicellData->initialize();

        // set the proper encoding
        $this->pdfi->setEncoding();

        $this->saveStyles();

        $nStartX = $this->pdf->GetX();
        $aRecData = $this->stringToLines($this->multicellData);
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

            $this->multiCellSec($this->multicellData, $aSendData);

            if ($bAddNewPage) {
                $this->beforeAddPage();
                $this->pdf->AddPage();
                $this->afterAddPage();
                $this->pdf->SetX($nStartX);
            }
        } while ((($iCounter--) > 0) && (false == $doBreak));

        $this->restoreStyles();
        $this->multicellData = null;
    }


    /**
     * Draws a MultiCell with TAG recognition parameters
     *
     *
     * @param $multicellData MulticellData
     * @param $data string|array
     * @internal param \or $string number $border Indicates if borders must be drawn around the cell block.
     * The value can be either a number: 0 = no border 1 = frame border or a string containing some or all of
     * the following characters (in any order): L: left T: top R: right B: bottom
     */
    public function multiCellSec(MulticellData $multicellData, $data)
    {
        $this->resetData();

        $b = $b1 = $b2 = $b3 = ''; //borders

        $multicellData->initialize();
        $align = $multicellData->align;

        //save the current X position, we will have to jump back!!!!
        $startX = $this->pdf->GetX();

        $border = $multicellData->border;
        if ($border) {
            if ($border == 1) {
                $border = 'LTRB';
                $b1 = 'LRT'; //without the bottom
                $b2 = 'LR'; //without the top and bottom
                $b3 = 'LRB'; //without the top
            } else {
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
            $b .= is_int(strpos($border, 'L')) ? 'L' : '';
            $b .= is_int(strpos($border, 'R')) ? 'R' : '';
            $b .= is_int(strpos($border, 'T')) ? 'T' : '';
            $b .= is_int(strpos($border, 'B')) ? 'B' : '';
        }

        $bFirstLine = true;

        $bLastLine = !(count($data) > 0);

        while (!$bLastLine) {
            if ($bFirstLine && ($multicellData->paddingTop > 0)) {
                /**
                 * If this is the first line and there is top_padding
                 */
                $x = $this->pdf->GetX();
                $y = $this->pdf->GetY();
                $this->pdfi->Cell($multicellData->width, $multicellData->paddingTop, '', $b1, 0, $align, $this->fill);
                $b1 = str_replace('T', '', $b1);
                $b = str_replace('T', '', $b);
                $this->pdf->SetXY($x, $y + $multicellData->paddingTop);
            }

            if ($multicellData->fill == 1) {
                //fill in the cell at this point and write after the text without filling
                $this->pdf->SetX($startX); //restore the X position
                $this->pdfi->Cell($multicellData->width, $multicellData->lineHeight, '', 0, 0, '', $this->fill);
                $this->pdf->SetX($startX); //restore the X position
            }
            //make a line
            $str_data = array_shift($data);
            //check for last line
            $bLastLine = !(count($data) > 0);

            if ($bLastLine && ($align == 'J')) { //do not Justify the Last Line
                $align = 'L';
            }

            /**
             * Restore the X position with the corresponding padding if it exist The Right padding is done automatically by calculating the width of the text
             */
            $this->pdf->SetX($startX + $multicellData->paddingLeft);
            $this->printLine($multicellData->textWidth, $multicellData->lineHeight, $str_data, $align);

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

            if ($bLastLine && ($multicellData->paddingBottom > 0)) {
                /**
                 * If we have bottom padding then the border and the padding is outputted
                 */
                $this->pdf->SetX($startX); //restore the X
                $this->pdfi->Cell($multicellData->width, $multicellData->lineHeight, '', $b2, 2);
                $this->pdf->SetX($startX); //restore the X
                $this->pdfi->Cell($multicellData->width, $multicellData->paddingBottom, '', $real_brd, 0, $align, $this->fill);
                $this->pdf->y += $multicellData->paddingBottom;
            } else {
                //draw the border and jump to the next line
                $this->pdf->SetX($startX); //restore the X
                $this->pdfi->Cell($multicellData->width, $multicellData->lineHeight, '', $real_brd, 2);
            }

            if ($bFirstLine) {
                $bFirstLine = false;
            }
        }

        $this->pdf->x = $this->pdf->lMargin;
    }


    /**
     * This method divides the string into the tags and puts the result into dataInfo variable.
     *
     * @param string $string string to be parsed
     */
    protected function divideByTags(string $string)
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
     * This method parses the current text and return an array that contains the text information for each line that will be drawn.
     *
     * @param MulticellData $multicellData
     * @return array $aStrLines - contains parsed text information.
     */
    public function stringToLines(MulticellData $multicellData): array
    {
        //save the current style settings, this will be the default in case of no style is specified
        $options = $this->options;
        $this->resetData();

        if ($options->shrinkToFit) {
            $eols = substr_count($multicellData->string, "\n") + 1;
            if ($options->maxLines && $eols > $options->maxLines) {
                $options->maxLines = $eols;
            }
        }

        $this->divideByTags($multicellData->string);

        $dataInfo = $this->dataInfo;

        $lastLine = !(count($this->dataInfo) > 0);

        $parsedLines = [];
        $lines = 0;
        $shrinkRun = 0;

        while (!$lastLine) {
            $lines++;
            $height = $lines * $multicellData->lineHeight;

            //make a line
            $str_data = $this->makeLine($multicellData->textWidth);
            $parsedLines[] = $str_data;

            #1247 - limit the maximum number of lines
            if ($options->isHeightOverflow($lines, $height)) {
                if ($shrinkRun++ > 20) break;   //avoid infinite loop
                if ($options->shrinkToFit) {
                    $parsedLines = [];
                    $lines = 0;
                    $options->shrinkStyleFonts();
                    $multicellData->lineHeight = $options->shrinkValue($multicellData->lineHeight, $options->shrinkLineHeightStep);
                    $this->dataInfo = $dataInfo;
                    $this->currentTag = '__UNDEFINED__';
                    continue;
                } else {
                    break;
                }
            }

            //check for last line
            $lastLine = !(count($this->dataInfo) > 0);
        }

//        //APPLY THE DEFAULT STYLE
//        $this->applyStyle(static::DEFAULT_TAG);

        if (!$options->applyAll) {
            $this->reset();
        }

        return $parsedLines;
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
    protected function printLine($width, $height, array $data, string $align = 'J')
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
            $this->pdf->Cell($w_first, $height, '', $this->cellBorders, 0, 'L', 0);
        }

        $last_width = $nMaximumWidth - $w_first;

        foreach ($data as $val) {
            $bYPosUsed = false;

            //apply current tag style
            $this->applyStyle($val['tag'], $val['style']);

            //If > 0 then we will move the current X Position
            $extra_X = 0;
            $x = $this->pdf->x;

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
                $cellAlign = Tools::getCellAlign(Tools::getValue($val, 'align'));

                switch ($cellAlign) {
                    case 'C':
                        $this->pdf->Cell($val['width'], $height, $val['text'], $this->cellBorders, 0, 'C', 0, $val['href']);
                        break;
                    case 'R':
                        //Output the Text/Links
                        $this->pdf->Cell($val['width'] - $val['width_real'], $height, '', $this->cellBorders);
                        $this->pdf->Cell($val['width_real'], $height, $val['text'], $this->cellBorders, 0, 'C', 0, $val['href']);
                        break;
                    default:
                        //Output the Text/Links
                        $this->pdf->Cell($val['width_real'], $height, $val['text'], $this->cellBorders, 0, 'C', 0, $val['href']);
                        $this->pdf->Cell($val['width'] - $val['width_real'], $height, '', $this->cellBorders);
                        break;
                }
            } else {
                //Output the Text/Links
                $this->pdf->Cell($width, $height, $val['text'], $this->cellBorders, 0, 'C', 0, $val['href']);
            }

            // Strikethrough text #1950
            if ($val['strike']) {
                $this->pdfi->setDrawColor($this->pdfi->textColor);
                $lineWidth = $this->pdf->LineWidth;
                $strikeY = $this->pdf->y + ($height / 2);
                if (is_numeric($val['strike'])) {
                    $this->pdf->SetLineWidth($val['strike']);
                }
                $this->pdf->line($x, $strikeY, $x + $width, $strikeY);
                $this->pdf->SetLineWidth($lineWidth); //restore the line width
                $this->pdfi->restoreDrawColor();
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
            $this->pdfi->Cell($last_width, $height, '', $this->cellBorders, 0, '', 0);
        }
    }


    /**
     * Function executed BEFORE a new page is added for further actions on the current page.
     * Usually overwritten.
     */
    public function beforeAddPage()
    {
        /*
         * TODO: place your code here
         */
    }


    /**
     * Function executed AFTER a new page is added for pre - actions on the current page.
     * Usually overwritten.
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
     * @return float|int the char width
     */
    protected function mt_getCharWidth(string $tag, string $char)
    {
        //if this font was not used until now,
        $this->applyStyle($tag);
        $fw[$tag]['w'] = $this->pdf->CurrentFont['cw']; //width
        $fw[$tag]['s'] = $this->pdf->FontSize; //size


        return $fw[$tag]['w'][chr($char)] * $fw[$tag]['s'] / 1000;
    }


    /**
     * Returns the Available Width to draw the Text.
     *
     * @param float $width
     * @param float $paddingLeft
     * @param float $paddingRight
     * @return float the width
     * @noinspection PhpUnused
     */
    protected function mt_getAvailableTextWidth(float $width, float $paddingLeft = 0, float $paddingRight = 0): float
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
        return $width - $paddingLeft - $paddingRight;
    }

    /**
     * Returns the character found in the string at the specified position
     *
     * @param string $string
     * @param int $position
     * @return string
     */
    protected static function strChar(string $string, int $position): string
    {
        return self::substr($string, $position, 1);
    }


    /**
     * Get string length
     *
     * @param string $sStr
     * @return int
     */
    public static function strlen(string $sStr): int
    {
        return strlen($sStr);
    }


    /**
     * Return part of a string
     *
     * @param string $str
     * @param number $start
     * @param number $length
     * @return string
     */
    public static function substr(string $str, $start, $length = null): string
    {
        return PdfInterface::substr($str, $start, $length);
    }


    /**
     * Enable or disable background fill.
     *
     * @param boolean $value
     * @return $this
     */
    public function enableFill(bool $value): self
    {
        $this->fill = $value;
        return $this;
    }

    /**
     * @param int $maxLines
     * @return $this
     * @noinspection PhpUnused
     */
    public function setMaxLines(int $maxLines): self
    {
        $this->maxLines($maxLines - 1);
        return $this;
    }

    /**
     * @param int $maxLines
     * @return $this
     */
    public function maxLines(int $maxLines): self
    {
        $this->options->maxLines = $maxLines;
        return $this;
    }

    /**
     * @param int $maxHeight
     * @return self
     */
    public function maxHeight(int $maxHeight): self
    {
        $this->options->maxHeight = $maxHeight;
        return $this;
    }

    /**
     * @param bool $shrinkToFit
     * @return self
     */
    public function shrinkToFit(bool $shrinkToFit = true): self
    {
        $this->options->shrinkToFit = $shrinkToFit;
        return $this;
    }

    /**
     * @param int|float $step
     * @return self
     * @noinspection PhpUnused
     */
    public function shrinkFontStep($step = 1): self
    {
        $this->options->shrinkFontStep = $step;
        return $this;
    }

    /**
     * @param int|float $step
     * @return self
     * @noinspection PhpUnused
     */
    public function shrinkLineHeightStep($step): self
    {
        $this->options->shrinkLineHeightStep = $step;
        return $this;
    }

    /**
     * @return self
     */
    public function applyAll(): self
    {
        $this->options->applyAll = true;
        return $this;
    }


    /**
     * Returns the strike tag value.
     * If "strike" is specified in the tag and it has a value the value specifies the line width
     *
     * @param $val
     * @return bool|mixed
     */
    protected function getStrikeValue($val)
    {
        if (isset($val['strike'])) {
            if (empty($val['strike'])) {
                return true;
            }
            return $val['strike'];
        }

        return false;
    }

    public function saveStyles()
    {
        $this->options->saveCurrentStyle();
        $this->options->saveStyles();
    }

    public function restoreStyles()
    {
        $this->options->restoreStyles();
        $this->applyStyle(static::PDF_CURRENT);
    }

}
