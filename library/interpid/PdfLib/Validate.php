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
 * Class Validate
 * @package Interpid\PdfLib
 */
class Validate
{

    /**
     * Returns a positive(>0) integer value
     *
     * @param $value
     * @return int
     */
    public static function intPositive($value): int
    {
        $value = intval($value);
        if ($value < 1) {
            $value = 1;
        }

        return $value;
    }


    /**
     * Returns a float value.
     * If min and max are specified, then $value will have to be between $min and $max
     *
     * @param mixed $value
     * @param int|float|null $min
     * @param int|float|null $max
     * @return float
     */
    public static function float($value, $min = null, $max = null): float
    {
        $value = floatval($value);

        if ($min !== null) {
            $min = floatval($min);
            if ($value < $min) {
                return $min;
            }
        }

        if ($max !== null) {
            $max = floatval($max);
            if ($value > $max) {
                return $max;
            }
        }

        return $value;
    }


    /**
     * Validates the align Vertical value
     *
     * @param $value
     * @return string
     */
    public static function alignVertical($value): string
    {
        $value = strtoupper($value);

        $aValid = ['T', 'B', 'M'];

        if (!in_array($value, $aValid)) {
            return 'M';
        }

        return $value;
    }
}
