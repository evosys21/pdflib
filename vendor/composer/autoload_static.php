<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf1d4fefbcefdfceba1d913a3b7fdb906
{
    public static $classMap = array (
        'FPDF' => __DIR__ . '/..' . '/fpdf/fpdf.php',
        'Interpid\\PdfExamples\\myPdf' => __DIR__ . '/..' . '/interpid/PdfExamples/mypdf.php',
        'Interpid\\PdfExamples\\pdfFactory' => __DIR__ . '/..' . '/interpid/PdfExamples/pdfFactory.php',
        'Interpid\\Pdf\\Multicell' => __DIR__ . '/..' . '/interpid/Pdf/Multicell.php',
        'Interpid\\Pdf\\Pdf' => __DIR__ . '/..' . '/interpid/Pdf/Pdf.php',
        'Interpid\\Pdf\\PdfInterface' => __DIR__ . '/..' . '/interpid/Pdf/PdfInterface.php',
        'Interpid\\Pdf\\String\\Tags' => __DIR__ . '/..' . '/interpid/Pdf/String/Tags.php',
        'Interpid\\Pdf\\Table' => __DIR__ . '/..' . '/interpid/Pdf/Table.php',
        'Interpid\\Pdf\\Table\\Cell\\CellAbstract' => __DIR__ . '/..' . '/interpid/Pdf/Table/Cell/CellAbstract.php',
        'Interpid\\Pdf\\Table\\Cell\\CellInterface' => __DIR__ . '/..' . '/interpid/Pdf/Table/Cell/CellInterface.php',
        'Interpid\\Pdf\\Table\\Cell\\Image' => __DIR__ . '/..' . '/interpid/Pdf/Table/Cell/Image.php',
        'Interpid\\Pdf\\Table\\Cell\\Multicell' => __DIR__ . '/..' . '/interpid/Pdf/Table/Cell/Multicell.php',
        'Interpid\\Pdf\\Table\\Cell\\Void' => __DIR__ . '/..' . '/interpid/Pdf/Table/Cell/Void.php',
        'Interpid\\Pdf\\Tools' => __DIR__ . '/..' . '/interpid/Pdf/Tools.php',
        'Interpid\\Pdf\\Validate' => __DIR__ . '/..' . '/interpid/Pdf/Validate.php',
        'TTFParser' => __DIR__ . '/..' . '/fpdf/makefont/ttfparser.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitf1d4fefbcefdfceba1d913a3b7fdb906::$classMap;

        }, null, ClassLoader::class);
    }
}
