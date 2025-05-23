<?php

/** @noinspection PhpUnused */

namespace EvoSys21\PdfLib\Examples\Tfpdf;

use EvoSys21\PdfLib\Tfpdf\Pdf;

/**
 * Pdf Factory
 * Contains functions that creates and initializes the PDF class
 */
class PdfFactory
{
    /**
     * Creates a new PDF Object and Initializes it
     *
     * @param bool $header Show the header
     * @param bool $footer Show the footer
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
     * @return Pdf $pdf
     */
    public static function initPdf(Pdf $pdf, bool $header = true, bool $footer = true): Pdf
    {
        $pdf->showHeader = $header;
        $pdf->showFooter = $footer;

        //add the required fonts(required for UTF8 fonts)
        $pdf->AddFont('dejavusans', '', 'DejaVuSans.ttf', true);
        $pdf->AddFont('dejavusans', 'B', 'DejaVuSans-Bold.ttf', true);

        $pdf->SetMargins(20, 20, 20);

        //set default font/colors
        $pdf->SetFont('dejavusans', '', 11);
        $pdf->SetTextColor(200, 10, 10);
        $pdf->SetFillColor(254, 255, 245);

        // add a page
        $pdf->AddPage();
        $pdf->AliasNbPages();

        //disable compression for unit-testing!
        if (getenv('APP_ENV') === 'testing') {
            $pdf->SetCompression(false);
        }

        return $pdf;
    }
}
