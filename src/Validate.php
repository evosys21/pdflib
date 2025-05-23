<?php

namespace EvoSys21\PdfLib;

/**
 * Class Validate
 */
class Validate
{
    /**
     * Returns a positive(>0) integer value
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
     */
    public static function alignVertical($value): string
    {
        $value = strtoupper($value);

        $aValid = ['T', 'B', 'M'];

        if (! in_array($value, $aValid)) {
            return 'M';
        }

        return $value;
    }
}
