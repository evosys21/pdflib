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

/**
 * Class Tools
 * @package Interpid\PdfLib
 */
class Tools
{
    public static function getValue(array $data, $path, $default = '', $delimiter = '')
    {
        if (empty($delimiter)) {
            $delimiter = '/';
        }

        $paths = explode($delimiter, $path);

        foreach ($paths as $val) {
            if (isset($data[$val])) {
                $data = $data[$val];
            } else {
                return $default;
            }
        }

        return $data;
    }

    /**
     * String with NULL Allowed
     *
     * @param mixed $value
     * @param bool $trim
     * @return string
     */
    public static function string($value, $trim = true)
    {
        if (is_null($value)) {
            return $value;
        }
        $value = strval($value);
        if ($trim) {
            $value = trim($value);
        }
        return $value;
    }

    /**
     * String with NULL Allowed
     *
     * @param mixed $value
     * @return string
     */
    public static function color($value)
    {
        if (is_array($value)) {
            return $value;
        }
        return static::string($value);
    }


    /**
     * Get the next value from the array
     *
     * @param array $data
     * @param number $index
     * @return mixed
     */
    public static function getNextValue(array $data, &$index)
    {
        if (isset($index)) {
            $index++;
        }

        if (!isset($index) || ($index >= count($data))) {
            $index = 0;
        }

        return $data[$index];
    }

    /**
     * Returns the color array of the 3 parameters or the 1st param if the others are not specified
     *
     * @param int|false $r
     * @param int|null $b
     * @param int|null $g
     * @return array|false
     */
    public static function getColor($r, $b = null, $g = null)
    {
        if ($g !== null && $b !== null) {
            return [$r, $b, $g];
        }

        return $r;
    }

    /**
     * Returns an array. If the input paramter is array then this array will be returned.
     * Otherwise a array($value) will be returned;
     *
     * @param mixed $value
     * @return array
     */
    public static function makeArray($value)
    {
        if (is_array($value)) {
            return $value;
        }

        return [$value];
    }


    /**
     * Returns TRUE if value is FALSE(0, '0', FALSE)
     *
     * @param mixed $value
     * @return bool
     */
    public static function isFalse($value)
    {
        if (false === $value) {
            return true;
        }

        if (0 === $value) {
            return true;
        }

        if ('0' === $value) {
            return true;
        }

        return false;
    }

    public static function getCellAlign($align)
    {
        $align = strtoupper($align);
        switch ($align) {
            case 'L':
            case 'LEFT':
                return 'L';
            case 'R':
            case 'RIGHT':
                return 'R';
            case 'C':
            case 'CENTER':
                return 'C';
        }
        return $align;
    }

    /**
     * Compares 2 float values by the specified precision
     *
     * @param float $value1
     * @param float $value2
     * @param int $precision
     * @return bool
     */
    public static function compareFloats($value1, $value2, $precision = 5)
    {
        return round($value1, $precision) === round($value2, $precision);
    }

    /**
     * Parses array1 and sets all the null values from array2 if they exist
     *
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public static function mergeNonNull($array1, $array2)
    {
        foreach ($array1 as $key => $value) {
            if (is_null($value) && isset($array2[$key])) {
                $array1[$key] = $array2[$key];
            }
        }
        return $array1;
    }
}
