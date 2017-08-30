<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf1d4fefbcefdfceba1d913a3b7fdb906
{
    public static $classMap = array (
        'FPDF' => __DIR__ . '/..' . '/fpdf/fpdf.php',
        'Interpid\\PdfExamples\\myPdf' => __DIR__ . '/..' . '/interpid/PdfExamples/mypdf.php',
        'Interpid\\PdfExamples\\pdfFactory' => __DIR__ . '/..' . '/interpid/PdfExamples/pdfFactory.php',
        'Interpid\\PdfLib\\Multicell' => __DIR__ . '/..' . '/interpid/PdfLib/Multicell.php',
        'Interpid\\PdfLib\\Pdf' => __DIR__ . '/..' . '/interpid/PdfLib/Pdf.php',
        'Interpid\\PdfLib\\PdfInterface' => __DIR__ . '/..' . '/interpid/PdfLib/PdfInterface.php',
        'Interpid\\PdfLib\\String\\Tags' => __DIR__ . '/..' . '/interpid/PdfLib/String/Tags.php',
        'Interpid\\PdfLib\\Table' => __DIR__ . '/..' . '/interpid/PdfLib/Table.php',
        'Interpid\\PdfLib\\Table\\Cell\\CellAbstract' => __DIR__ . '/..' . '/interpid/PdfLib/Table/Cell/CellAbstract.php',
        'Interpid\\PdfLib\\Table\\Cell\\CellInterface' => __DIR__ . '/..' . '/interpid/PdfLib/Table/Cell/CellInterface.php',
        'Interpid\\PdfLib\\Table\\Cell\\EmptyCell' => __DIR__ . '/..' . '/interpid/PdfLib/Table/Cell/Void.php',
        'Interpid\\PdfLib\\Table\\Cell\\Image' => __DIR__ . '/..' . '/interpid/PdfLib/Table/Cell/Image.php',
        'Interpid\\PdfLib\\Table\\Cell\\Multicell' => __DIR__ . '/..' . '/interpid/PdfLib/Table/Cell/Multicell.php',
        'Interpid\\PdfLib\\Tools' => __DIR__ . '/..' . '/interpid/PdfLib/Tools.php',
        'Interpid\\PdfLib\\Validate' => __DIR__ . '/..' . '/interpid/PdfLib/Validate.php',
        'TTFParser' => __DIR__ . '/..' . '/fpdf/makefont/ttfparser.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitf1d4fefbcefdfceba1d913a3b7fdb906::$classMap;

        }, null, ClassLoader::class);
    }
}
