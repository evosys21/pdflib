<?php
/** @noinspection PhpUnused */
namespace EvoSys21\PdfLib;

use EvoSys21\PdfLib\Fpdf\Pdf as Fpdf;
use EvoSys21\PdfLib\Fpdf\PdfInterface as FpdfInterface;
use EvoSys21\PdfLib\Tcpdf\Pdf as Tcpdf;
use EvoSys21\PdfLib\Tcpdf\PdfInterface as TcpdfInterface;
use EvoSys21\PdfLib\Tfpdf\Pdf as Tfpdf;
use EvoSys21\PdfLib\Tfpdf\PdfInterface as TfpdfInterface;
use Exception;

class Factory
{
    /**
     * @throws Exception
     */
    public static function pdfInterface($pdf): PdfInterfaceDef
    {
        if ($pdf instanceof Fpdf) {
            return new FpdfInterface($pdf);
        } elseif ($pdf instanceof Tcpdf) {
            return new TcpdfInterface($pdf);
        } elseif ($pdf instanceof Tfpdf) {
            return new TfpdfInterface($pdf);
        } else {
            throw new Exception('Invalid PDF object');
        }
    }
}
