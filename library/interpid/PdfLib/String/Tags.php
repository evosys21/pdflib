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

namespace Interpid\PdfLib\String;

/**
 * String Tag extraction class
 *
 * @package Interpid\PdfLib\String
 */
class Tags
{

    /**
     * Contains the Tag/String Correspondence
     *
     * @var array
     */
    protected $tags = [];

    /**
     * Contains the links for the tags that have specified this parameter
     *
     * @var array
     */
    protected $hRef;

    /**
     * The maximum number of chars for a tag
     *
     * @var integer
     */
    protected $tagMaxElem;


    /**
     * Constructor
     *
     * @param int|number $p_tagmax number - the number of characters allowed in a tag
     */
    public function __construct($p_tagmax = 10)
    {
        $this->tags = [];
        $this->hRef = [];
        $this->tagMaxElem = $p_tagmax;
    }


    /**
     * Returns TRUE if the specified tag name is an "<open tag>", (it is not already opened)
     *
     * @param $p_tag string - tag name
     * @param $p_array array - tag arrays
     * @return boolean
     */
    protected function OpenTag($p_tag, $p_array)
    {
        $tags = &$this->tags;
        $hRef = &$this->hRef;
        $maxElem = &$this->tagMaxElem;

        if (!preg_match("/^<([a-zA-Z0-9]{1,$maxElem}) *(.*)>$/i", $p_tag, $reg)) {
            return false;
        }

        $p_tag = $reg[1];

        $sHREF = [];
        if (isset($reg[2])) {
            preg_match_all("|([^ ]*)=[\"'](.*)[\"']|U", $reg[2], $out, PREG_PATTERN_ORDER);
            for ($i = 0; $i < count($out[0]); $i++) {
                $out[2][$i] = preg_replace("/(\"|')/i", '', $out[2][$i]);
                $sHREF[] = [$out[1][$i], $out[2][$i]];
            }
        }

        if (in_array("</$p_tag>", $p_array)) {
            $tags[] = $p_tag;
            $hRef[] = $sHREF;

            return true;
        }

        return false;
    }


    /**
     * returnes true if $p_tag is a "<close tag>"
     *
     * @param $p_tag - tag string $p_array - tag array;
     * @return true/false
     */
    /**
     * Returns true if $p_tag is a "<close tag>"
     *
     * @param $p_tag string - tag name
     * @return boolean
     */
    protected function CloseTag($p_tag)
    {
        $tags = &$this->tags;
        $hRef = &$this->hRef;
        $maxElem = &$this->tagMaxElem;

        if (!preg_match("/^<\/([a-zA-Z0-9]{1,$maxElem})>$/i", $p_tag, $reg)) {
            return false;
        }

        $p_tag = $reg[1];

        if (in_array("$p_tag", $tags)) {
            array_pop($tags);
            array_pop($hRef);

            return true;
        }

        return false;
    }


    /**
     * Expands the paramteres that are kept in Href field
     *
     * @param $pResult
     * @return string
     */
    protected function expand_parameters($pResult)
    {
        $aTmp = $pResult['params'];
        if ($aTmp != '') {
            for ($i = 0; $i < count($aTmp); $i++) {
                $pResult[$aTmp[$i][0]] = $aTmp[$i][1];
            }
        }

        unset($pResult['params']);

        return $pResult;
    }


    /**
     * Optimizes the result of the tag result array In the result array there can be strings that are consecutive and have the same tag, they are concatenated.
     *
     * @param $result array - the array that has to be optimized
     * @return array - optimized result
     */
    protected function optimizeTags($result)
    {
        if (count($result) == 0) {
            return $result;
        }

        $res_result = [];
        $current = $result[0];
        $i = 1;

        while ($i < count($result)) {
            //if they have the same tag then we concatenate them
            if (($current['tag'] == $result[$i]['tag']) && ($current['params'] == $result[$i]['params'])) {
                $current['text'] .= $result[$i]['text'];
            } else {
                $current = $this->expand_parameters($current);
                $res_result[] = $current;
                $current = $result[$i];
            }

            $i++;
        }

        $current = $this->expand_parameters($current);
        $res_result[] = $current;

        return $res_result;
    }


    /**
     * Parses a string and returnes an array of TAG - SRTING correspondent array The result has the following structure: [ array (string1, tag1), array (string2, tag2), ... etc ]
     *
     * @param $string string - the Input String
     * @return array - the result array
     */
    public function getTags($string)
    {
        $tags = &$this->tags;
        $hRef = &$this->hRef;
        $tags = [];
        $result = [];

        $reg = preg_split('/(<.*>)/U', $string, -1, PREG_SPLIT_DELIM_CAPTURE);

        $tag = '';
        $href = '';

        foreach ($reg as $key => $val) {

            if ($val == '') {
                continue;
            }

            if ($this->OpenTag($val, $reg)) {
                $tag = (($temp = end($tags)) != null) ? $temp : '';
                $href = (($temp = end($hRef)) != null) ? $temp : '';
            } elseif ($this->CloseTag($val)) {
                $tag = (($temp = end($tags)) != null) ? $temp : '';
                $href = (($temp = end($hRef)) != null) ? $temp : '';
            } else {
                if ($val != '') {
                    $result[] = ['text' => $val, 'tag' => implode('/', $tags), 'params' => $href];
                }
            }
        }

        return $this->optimizeTags($result);
    }
}
