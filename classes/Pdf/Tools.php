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
class Pdf_Tools
{

    public static function getValue( array $var, $index = '', $default = '' )
    {
        if ( isset( $var[ $index ] ) )
        {
            return $var[ $index ];
        }

        return $default;
    }


    /**
     * Get the next value from the array
     *
     * @param array $data
     * @param number $index
     * @return mixed
     */
    public static function getNextValue( array $data, &$index )
    {
        if ( isset( $index ) )
        {
            $index++;
        }

        if ( !isset( $index ) || ( $index >= count( $data ) ) )
        {
            $index = 0;
        }

        return $data[ $index ];
    }

    /**
     * Returns the color array of the 3 parameters or the 1st param if the others are not specified
     *
     * @param int|false $r
     * @param int|null $b
     * @param int|null $g
     * @return array|false
     */
    public static function getColor( $r, $b = null, $g = null )
    {
        if ( $g !== null && $b !== null )
        {
            return array( $r, $b, $g );
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
    public static function makeArray( $value )
    {
        if ( is_array( $value ) )
        {
            return $value;
        }

        return array( $value );
    }


    /**
     * Returns TRUE if value is FALSE(0, '0', FALSE)
     *
     * @param mixed $value
     * @return bool
     */
    public static function isFalse( $value )
    {
        if ( false === $value )
            return true;

        if ( 0 === $value )
            return true;

        if ( '0' === $value )
            return true;

        return false;
    }
}
