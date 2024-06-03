<?php 
/** @noinspection PhpUnused */

/**
 * This file is part of the Interpid PDF Addon package.
 *
 * @author Interpid <office@interpid.eu>
 * @copyright (c) Interpid, http://www.interpid.eu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Interpid\PdfExamples;

use Interpid\PdfLib\Pdf;

if (!defined('PDF_RESOURCES_IMAGES')) {
    define('PDF_RESOURCES_IMAGES', __DIR__ . '/images');
}

/**
 * Pdf Factory
 * Contains functions that creates and initializes the PDF class
 *
 * @package Interpid\PdfExamples
 */
class PdfFactory
{
    /**
     * Creates a new PDF Object and Initializes it
     *
     * @param string $type
     * @param bool $header Show the header
     * @param bool $footer Show the footer
     * @return MyPdf
     */
    public static function newPdf(string $type, bool $header = true, bool $footer = true): MyPdf
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
        self::initPdf($pdf, $header, $footer);

        return $pdf;
    }

    /**
     * Initializes the pdf object.
     * Set the margins, adds a page, adds default fonts etc...
     *
     * @param Pdf $pdf
     * @param bool $header
     * @param bool $footer
     * @return Pdf $pdf
     */
    public static function initPdf(Pdf $pdf, bool $header = true, bool $footer = true): Pdf
    {
        $pdf->showHeader = $header;
        $pdf->showFooter = $footer;
        // use the default TCPDF configuration
        $pdf->SetCreator('TCPDF');
        $pdf->SetAuthor('Interpid');
        $pdf->SetMargins(20, 20, 20);
        $pdf->SetAutoPageBreak(true, 20);

        //set default font/colors
        $pdf->SetFont('helvetica', '', 11);
        $pdf->SetTextColor(200, 10, 10);
        $pdf->SetFillColor(254, 255, 245);

        // add a page
        $pdf->AddPage();

        //disable compression for unit-testing!
        if (isset($_SERVER['ENVIRONMENT']) && 'test' == $_SERVER['ENVIRONMENT']) {
            $pdf->SetCompression(false);
            $pdf->setDocCreationTimestamp(1420070400);
            $pdf->setDocModificationTimestamp(1420070400);
        }

        return $pdf;
    }
}
