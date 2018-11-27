<?php

/**
 * Pdf Factory
 * Contains functions that creates and initializes the PDF class
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
 * @author    : Interpid <office@interpid.eu>
 * @copyright : Interpid, http://www.interpid.eu
 * @license   : http://www.interpid.eu/pdf-addons/eula
 */

namespace Interpid\PdfExamples;

if (!defined('PDF_RESOURCES_IMAGES')) {
    define('PDF_RESOURCES_IMAGES', __DIR__ . '/images');
}

use Interpid\PdfLib\Pdf;

class PdfFactory
{
    /**
     * Creates a new Fpdf Object and Initializes it
     *
     * @param $type
     * @return MyPdf
     */
    public static function newPdf($type)
    {
        $pdf = new MyPdf();

        switch ($type) {
            case 'multicell':
                $pdf->setHeaderSource('header-multicell.txt');
                break;
            case 'table':
                $pdf->setHeaderSource('header-table.txt');
                break;
        }

        //initialize the pdf document
        self::initPdf($pdf);

        return $pdf;
    }

    /**
     * Initializes the pdf object.
     * Set the margins, adds a page, adds default fonts etc...
     *
     * @param Pdf $pdf
     * @return Pdf $pdf
     */
    public static function initPdf($pdf)
    {
        $pdf->SetMargins(20, 20, 20);

        //set default font/colors
        $pdf->SetFont('helvetica', '', 11);
        $pdf->SetTextColor(200, 10, 10);
        $pdf->SetFillColor(254, 255, 245);

        // add a page
        $pdf->AddPage();
        $pdf->AliasNbPages();

        //disable compression for unit-testing!
        if (isset($_SERVER[ 'ENVIRONMENT' ]) && 'test' == $_SERVER[ 'ENVIRONMENT' ]) {
            $pdf->SetCompression(false);
        }

        return $pdf;
    }
}
