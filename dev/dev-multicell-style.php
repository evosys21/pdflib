<?php

/**
 * Pdf Advanced Multicell - Example
 */

use EvoSys21\PdfLib\Tools;

$factory = new DevFactory();

// Create the Advanced Multicell Object and inject the PDF object
$multicell = $factory->multicell();
$pdf = $multicell->getPdfObject();

$txt = <<<EOL
<code>
<span style="color: #0000BB; font-size: 12px">&lt;?php<br /></span>
<span style="color: #FF8000">/**<br />&nbsp;*&nbsp;Pdf&nbsp;Advanced&nbsp;Multicell&nbsp;-&nbsp;Example<br /></span>
</code>
EOL;

$txt = Tools::convertHighlight($txt);

$multicell->multiCell(0, 5, $txt, 1, 'J', 1, 3, 3, 3, 3);

// output the pdf
$pdf->Output();
