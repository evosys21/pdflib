<?php

/**
 * Pdf Tools
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
 * @version   : 5.1.0
 * @author    : Andrei Bintintan <andy@interpid.eu>
 * @copyright : Copyright (c) 2014, Andrei Bintintan, http://www.interpid.eu
 * @license   : http://www.interpid.eu/pdf-addons/eula
 */
class Pdf_Validate
{

    /**
     * Returns a positive(>0) integer value
     *
     * @param $value
     * @return int
     */
    public static function intPositive( $value )
    {
        $value = intval( $value );
        if ( $value < 1 ) $value = 1;

        return $value;
    }


    /**
     * Returns a float value.
     * If min and max are specified, then $value will have to be between $min and $max
     *
     * @param float $value
     * @param null|float $min
     * @param null|float $max
     * @return float
     */
    public static function float( $value, $min = null, $max = null )
    {
        $value = floatval( $value );

        if ( $min !== null )
        {
            $min = floatval( $min );
            if ( $value < $min ) return $min;
        }

        if ( $max !== null )
        {
            $max = floatval( $max );
            if ( $value > $max ) return $max;
        }

        return $value;
    }


    /**
     * Validates the align Vertical value
     *
     * @param $value
     * @return string
     */
    public static function alignVertical( $value )
    {
        $value = strtoupper( $value );

        $aValid = array( 'T', 'B', 'M' );

        if ( !in_array( $value, $aValid ) )
        {
            return 'M';
        }

        return $value;
    }
}
