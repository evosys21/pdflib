<?php
/**
 * Pdf Advanced Multicell - Example
 * Copyright (c), Interpid, http://www.interpid.eu
 */

use evosys21\PdfLib\Tools;

require_once 'Factory.php';

$factory = new DevFactory();

// Create the Advanced Multicell Object and inject the PDF object
$multicell = DevFactory::multicell();
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
