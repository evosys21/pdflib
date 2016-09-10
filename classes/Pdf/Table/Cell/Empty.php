<?php
/**
 * Pdf Table Cell Empty
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
 * @version   : 5.3.0
 * @author    : Andrei Bintintan <andy@interpid.eu>
 * @copyright : Andrei Bintintan, http://www.interpid.eu
 * @license   : http://www.interpid.eu/pdf-addons/eula
 */


require_once( dirname( __FILE__ ) . '/Abstract.php' );

/**
 * @property array aDefaultValues
 */
class Pdf_Table_Cell_Empty extends Pdf_Table_Cell_Abstract implements Pdf_Table_Cell_Interface
{


    public function isSplittable()
    {
        return false;
    }


    public function render()
    {
        $this->renderCellLayout();
    }

    public function copyProperties( Pdf_Table_Cell_Abstract $oSource )
    {

        $aProps = array_keys( $this->aDefaultValues );

        foreach ( $aProps as $sProperty )
        {
            if ( $oSource->isPropertySet( $sProperty ) )
            {
                $this->$sProperty = $oSource->$sProperty;
            }
        }

        //set 0 padding
        $this->setPadding();
    }
}

