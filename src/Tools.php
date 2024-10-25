<?php

/** @noinspection PhpUnused */

namespace EvoSys21\PdfLib;

/**
 * Class Tools
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
     * @return string|null
     */
    public static function string($value, bool $trim = true): ?string
    {
        if (is_null($value)) {
            return null;
        }
        $value = strval($value);
        if ($trim) {
            $value = trim($value);
        }
        return $value;
    }

    /**
     * String|Array with NULL Allowed
     *
     * @param array|string $value
     * @return array|string
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
     * @param null|number $index
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
     * @param string|int $r
     * @param int|null $g
     * @param int|null $b
     * @return array|string
     */
    public static function getColor($r, ?int $g = null, ?int $b = null)
    {
        if ($g !== null && $b !== null) {
            return [$r, $g, $b];
        }

        return $r;
    }

    /**
     * Returns an array. If the input parameter is array then this array will be returned.
     * Otherwise a array($value) will be returned;
     *
     * @param mixed $value
     * @return array
     */
    public static function makeArray($value): array
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
    public static function isFalse($value): bool
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

    public static function getCellAlign($align): string
    {
        $align = strtoupper($align);
        return match ($align) {
            'L', 'LEFT' => 'L',
            'R', 'RIGHT' => 'R',
            'C', 'CENTER' => 'C',
            default => $align,
        };
    }

    /**
     * Compares 2 float values by the specified precision
     *
     * @param float $value1
     * @param float $value2
     * @param int $precision
     * @return bool
     */
    public static function compareFloats(float $value1, float $value2, int $precision = 5): bool
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
    public static function mergeNonNull(array $array1, array $array2): array
    {
        foreach ($array1 as $key => $value) {
            if (is_null($value) && isset($array2[$key])) {
                $array1[$key] = $array2[$key];
            }
        }
        return $array1;
    }

    /**
     * Parses html attributes and returns an associative array
     * color: #0000BB; font-size: 20px
     *
     * @param $value
     * @return array
     */
    public static function parseHtmlAttribute($value): array
    {
        $values = array_map('trim', explode(";", $value));
        $result = [];
        foreach ($values as $entry) {
            $entries = array_map('trim', explode(":", $entry));
            if (isset($entries[0]) && isset($entries[1])) {
                $result[$entries[0]] = $entries[1];
            }
        }
        return $result;
    }

    public static function parseColor($color): array
    {
        if (is_array($color)) {
            return $color;
        }

        if (preg_match("#\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*#", $color, $matches)) {
            array_shift($matches); //remove first element
            return array_map("intval", $matches);
        }

        $result = self::hex2rgb($color);
        if ($result) {
            return $result;
        }

        return array_map('trim', explode(",", $color));
    }

    /**
     * Convert a hexa decimal color code to its RGB equivalent
     *
     * @param $hex_color
     * @return array|null
     */
    public static function hex2rgb($hex_color): ?array
    {
        $values = str_replace('#', '', $hex_color);
        switch (strlen($values)) {
            case 3:
                list($r, $g, $b) = sscanf($values, "%1s%1s%1s");
                if (ctype_xdigit($r) && ctype_xdigit($g) && ctype_xdigit($b)) {
                    return [hexdec("$r$r"), hexdec("$g$g"), hexdec("$b$b")];
                }
                break;
            case 6:
                return array_map('hexdec', sscanf($values, "%2s%2s%2s"));
        }

        return null;
    }

    /**
     * Converts code highlight for the Multicell Output
     *
     * @param $content
     * @return string|string[]
     */
    public static function convertHighlight($content)
    {
        $content = preg_replace("#<br\s?/>#", "\n", $content);
        $content = preg_replace("#</?pre>#", "", $content);
        $replacements = [
            "&nbsp;" => " ",
            '<code style="color: #000000">' => '<code><span style="color: #000000">' . "\n",
            '</span></code>' => "</span>\n</span>\n</code>",
        ];
        return str_replace(array_keys($replacements), array_values($replacements), $content);
    }
}
