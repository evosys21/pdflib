<?php
/**
 * Fpdf main class.
 * This class just FPDF class and it is used for "IDE/Editor reference simplicity".
 * In all subclasses we refer to Pdf class and not FPDF.
 * Also some methods and variables are set to Public in order to access them in the addons.
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
 * @author    : Interpid <office@interpid.eu>
 * @copyright : Interpid, http://www.interpid.eu
 * @license   : http://www.interpid.eu/pdf-addons/eula
 */

namespace Interpid\Pdf;

class Pdf extends \FPDF
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
        parent::_out( $s );
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

    public function Cell( $w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '' )
    {
        /**
         * AB 10.09.2016 - for "some" reason(haven't investigated the TXT
         */
        $txt = strval( $txt );
        parent::Cell( $w, $h, $txt, $border, $ln, $align, $fill, $link );
    }

}

