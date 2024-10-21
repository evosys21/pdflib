<?php
namespace EvoSys21\PdfLib\String;

/**
 * String Tag extraction class
 *\String
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
    protected $maxLength;


    /**
     * Constructor
     *
     * @param int $maxLength number - the number of characters allowed in a tag
     */
    public function __construct(int $maxLength = 10)
    {
        $this->tags = [];
        $this->hRef = [];
        $this->maxLength = $maxLength;
    }


    /**
     * Returns TRUE if the specified tag name is an "<open tag>", (it is not already opened)
     *
     * @param string $tag - tag name
     * @param array $data - tag arrays
     * @return boolean
     */
    protected function isOpenTag(string $tag, array $data): bool
    {
        $tags = &$this->tags;
        $hRef = &$this->hRef;
        $maxElem = &$this->maxLength;

        if (!preg_match("/^<([a-zA-Z\d]{1,$maxElem}) *(.*)>$/i", $tag, $reg)) {
            return false;
        }

        $match = $reg[1];

        $hrefs = [];
        if (isset($reg[2])) {
            preg_match_all("|([^ ]*)=[\"'](.*)[\"']|U", $reg[2], $out, PREG_PATTERN_ORDER);
            for ($i = 0; $i < count($out[0]); $i++) {
                $out[2][$i] = preg_replace("/([\"'])/i", '', $out[2][$i]);
                $hrefs[] = [$out[1][$i], $out[2][$i]];
            }
        }

        if (in_array("</$match>", $data)) {
            $tags[] = $match;
            $hRef[] = $hrefs;

            return true;
        }

        return false;
    }


    /**
     * Returns true if $tag is a "<close tag>"
     *
     * @param string $tag tag name
     * @return boolean
     */
    protected function isCloseTag(string $tag): bool
    {
        $tags = &$this->tags;
        $hRef = &$this->hRef;
        $maxElem = $this->maxLength;

        if (!preg_match("/^<\/([a-zA-Z\d]{1,$maxElem})>$/i", $tag, $reg)) {
            return false;
        }

        $tag = $reg[1];

        if (in_array("$tag", $tags)) {
            array_pop($tags);
            array_pop($hRef);

            return true;
        }

        return false;
    }


    /**
     * Expands the parameters that are kept in Href field
     *
     * @param array $data
     * @return array
     */
    protected function expandParams(array $data): array
    {
        $tmp = $data['params'];
        if ($tmp != '') {
            for ($i = 0; $i < count($tmp); $i++) {
                $data[$tmp[$i][0]] = $tmp[$i][1];
            }
        }

        unset($data['params']);

        return $data;
    }


    /**
     * Optimizes the result of the tag result array In the result array there can be strings that are consecutive and have the same tag, they are concatenated.
     *
     * @param $result array - the array that has to be optimized
     * @return array - optimized result
     */
    protected function optimizeTags(array $result): array
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
                $current = $this->expandParams($current);
                $res_result[] = $current;
                $current = $result[$i];
            }

            $i++;
        }

        $current = $this->expandParams($current);
        $res_result[] = $current;

        return $res_result;
    }


    /**
     * Parses a string and returns an array of TAG - STRING correspondent array
     * The result has the following structure: [ array (string1, tag1), array (string2, tag2), ... etc ]
     *
     * @param $string string - the Input String
     * @return array - the result array
     */
    public function getTags(string $string): array
    {
        $tags = &$this->tags;
        $hRef = &$this->hRef;
        $tags = [];
        $result = [];

        $reg = preg_split('/(<.*>)/U', $string, -1, PREG_SPLIT_DELIM_CAPTURE);

        $params = '';

        foreach ($reg as $val) {

            if ($val == '') {
                continue;
            }

            if ($this->isOpenTag($val, $reg)) {
                $params = (($temp = end($hRef)) != null) ? $temp : '';
            } elseif ($this->isCloseTag($val)) {
                $params = (($temp = end($hRef)) != null) ? $temp : '';
            } else {
                $result[] = ['text' => $val, 'tag' => implode('/', $tags), 'params' => $params];
            }
        }

        return $this->optimizeTags($result);
    }
}
