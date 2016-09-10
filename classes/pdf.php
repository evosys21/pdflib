<?php
/**
 * Pdf main class.
 * This class just extends FPDF class and it is used for "IDE/Editor reference simplicity".
 * In all subclasses we refer to Pdf class and not FPDF.
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

require_once( dirname( __FILE__ ) . '/../fpdf.php' );

class Pdf extends FPDF
{
    public $images;
    public $w;
    public $tMargin;
    public $bMargin;
    public $lMargin;
    public $rMargin;
    public $k;
    public $h;
    public $x;
    public $y;
    public $ws;
    public $FontFamily;
    public $FontStyle;
    public $FontSize;
    public $FontSizePt;
    public $CurrentFont;
    public $TextColor;
    public $FillColor;
    public $ColorFlag;
    public $AutoPageBreak;
    public $CurOrientation;

    public function _out( $s )
    {
        return parent::_out( $s );
    }

    public function _parsejpg( $file )
    {
        return parent::_parsejpg( $file );
    }

    public function _parsegif( $file )
    {
        return parent::_parsegif( $file );
    }

    public function _parsepng( $file )
    {
        return parent::_parsepng( $file );
    }

}

