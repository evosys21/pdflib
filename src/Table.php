<?php

/** @noinspection PhpUnused */

namespace EvoSys21\PdfLib;

use EvoSys21\PdfLib\Fpdf\Pdf as Fpdf;
use EvoSys21\PdfLib\Fpdf\PdfInterface as FpdfInterface;
use EvoSys21\PdfLib\Table\Cell\Image;
use EvoSys21\PdfLib\Table\Cell\ImageSVG;
use EvoSys21\PdfLib\Tcpdf\Pdf as Tcpdf;
use EvoSys21\PdfLib\Tcpdf\PdfInterface as TcpdfInterface;
use EvoSys21\PdfLib\Tfpdf\Pdf as Tfpdf;
use EvoSys21\PdfLib\Tfpdf\PdfInterface as TfpdfInterface;
use EvoSys21\PdfLib\Table\Cell\CellAbstract;
use EvoSys21\PdfLib\Table\Cell\CellInterface;
use EvoSys21\PdfLib\Table\Cell\EmptyCell;

/**
 * Pdf Table Class
 */
class Table
{
    const TB_DATA_TYPE_INSERT_NEW_PAGE = 'insert_new_page';

    /**
     * Text Color.
     * Array. @example: array(220,230,240)
     */
    const TEXT_COLOR = 'TEXT_COLOR';

    /**
     * Text Font Size.
     * number. @example: 8
     */
    const TEXT_SIZE = 'TEXT_SIZE';

    /**
     * Text Fond Family.
     * String. @example: 'Arial'
     */
    const TEXT_FONT = 'TEXT_FONT';

    /**
     * Text Align.
     * String. Possible values: LRC (left, right, center). @example 'C'
     */
    const TEXT_ALIGN = 'TEXT_ALIGN';

    /**
     * Text Font Type(Bold/Italic).
     * String. Possible values: BI. @example: 'B'
     */
    const TEXT_TYPE = 'TEXT_TYPE';

    /**
     * Vertical alignment of the text.
     * String. Possible values: TMB(top, middle, bottom). @example: 'M'
     */
    const VERTICAL_ALIGN = 'VERTICAL_ALIGN';

    /**
     * Line size for one row.
     * number. @example: 5
     */
    const LINE_SIZE = 'LINE_SIZE';

    /**
     * Cell background color.
     * Array. @example: array(41, 80, 132)
     */
    const BACKGROUND_COLOR = 'BACKGROUND_COLOR';

    /**
     * Cell border color.
     * Array. @example: array(0,92,177)
     */
    const BORDER_COLOR = 'BORDER_COLOR';

    /**
     * Cell border size.
     * number. @example: 0.2
     */
    const BORDER_SIZE = 'BORDER_SIZE';

    /**
     * Cell border type.
     * Mixed. Possible values: 0, 1 or a combination of: 'LRTB'. @example 'LRT'
     */
    const BORDER_TYPE = 'BORDER_TYPE';

    /**
     * Cell text.
     * The text that will be displayed in the cell. String. @example: 'This is a cell'
     */
    const TEXT = 'TEXT';

    /**
     * Padding Top.
     * number. Expressed in units. @example: 5
     */
    const PADDING_TOP = 'PADDING_TOP';

    /**
     * Padding Right.
     * number. Expressed in units. @example: 5
     */
    const PADDING_RIGHT = 'PADDING_RIGHT';

    /**
     * Padding Left.
     * number. Expressed in units. @example: 5
     */
    const PADDING_LEFT = 'PADDING_LEFT';

    /**
     * Padding Bottom.
     * number. Expressed in units. @example: 5
     */
    const PADDING_BOTTOM = 'PADDING_BOTTOM';

    /**
     * Table aling on page.
     * String. @example: 'C'
     */
    const TABLE_ALIGN = 'TABLE_ALIGN';

    /**
     * Table left margin.
     * number. @example: 20
     */
    const TABLE_LEFT_MARGIN = 'TABLE_LEFT_MARGIN';

    /**
     * Number of Columns of the Table
     *
     * @var int
     */
    protected $columns = 0;

    /**
     * Table configuration array
     * @var array
     */
    protected $configuration = [];

    /**
     * @var array
     */
    protected $tableHeaderType = [];

    /**
     * Header is drawed or not
     *
     * @var boolean
     */
    protected $drawHeader = true;

    /**
     * True if the header will be added on a new page.
     *
     * @var boolean
     *
     */
    protected $headerOnNewPage = true;

    /**
     * Header is parsed or not
     *
     * @var boolean
     *
     */
    protected $headerParsed = false;

    /**
     * Page Split Variable - if the table does not have enough space on the current page
     * then the cells will be splitted if $tableSplit== TRUE
     * If $tableSplit == FALSE then the current cell will be drawed on the next page
     *
     * @var boolean
     */
    protected $tableSplit = false;

    /**
     * TRUE - if on current page was some data written
     *
     * @var boolean
     */
    protected $dataOnCurrentPage = false;

    /**
     * TRUE - if on current page the header was written
     *
     * @var boolean
     */
    protected $headerOnCurrentPage = false;

    /**
     * Table Data Cache.
     * Will contain the information about the rows of the table
     *
     * @var array
     */
    protected $dataCache = [];

    /**
     * TRUE - if there is a Rowspan in the Data Cache
     *
     * @var boolean
     */
    protected $rowSpanInCache = false;

    /**
     * Sequence for Rowspan ID's.
     * Every Rowspan gets a unique ID
     *
     * @var int
     */
    protected $rowSpanID = 0;

    /**
     * Table Header Cache.
     * Will contain the information about the header of the table
     *
     * @var array
     */
    protected $headerCache = [];

    /**
     * Header Height.
     * In user units!
     *
     * @var int
     */
    protected $headerHeight = 0;

    /**
     * Table Start X Position
     *
     * @var int
     */
    protected $tableStartX = 0;

    /**
     * Table Start Y Position
     *
     * @var int
     */
    protected $tableStartY = 0;

    /**
     * Multicell Object
     *
     * @var object
     *
     */
    protected $multicell = null;

    /**
     * Pdf Object
     * @var object
     */
    protected object $pdf;

    /**
     * PDF Interface Object
     * @var object
     */
    protected object $pdfi;

    /**
     * Contains the Singleton Object
     */
    private static array $singleton = []; //implements the Singleton Pattern


    /**
     * Column Widths
     *
     * @var array
     *
     */
    protected $columnWidths = [];

    protected $typeMap = array(
        'EMPTY' => EmptyCell::class,
        'MULTICELL' => \EvoSys21\PdfLib\Table\Cell\Multicell::class,
        'IMAGE' => Image::class,
        'IMAGESVG' => ImageSVG::class,
    );

    /**
     * If set to true then page-breaks will be disabled
     *
     * @var bool
     */
    protected $disablePageBreak = false;

    /**
     * Configuration file path
     * @var string|null
     */
    protected $configFile = null;


    /**
     * Class constructor.
     *
     * @param $pdf object Instance of the PDF class
     * @param string|null $configFile
     */
    public function __construct(object $pdf, ?string $configFile = 'table.config.php')
    {
        //pdf object
        $this->pdf = $pdf;
        $this->pdfi = Factory::pdfInterface($pdf);

        $this->configFile = $configFile;

        //call the multicell instance
        $this->multicell = new Multicell($pdf);

        //get the default configuration
        $this->configuration = $this->getDefaultConfiguration();

        $this->pdfi->setEncoding();
    }


    /**
     * Returnes the Singleton Instance of this class.
     *
     * @param $pdf object the pdf Object
     * @return self
     */
    public static function getInstance($pdf): Table
    {
        $oInstance = &self::$singleton[spl_object_hash($pdf)];

        if (!isset($oInstance)) {
            $oInstance = new self($pdf);
        }

        return $oInstance;
    }


    /**
     * Returns the Multicell instance
     *
     * @return Multicell
     */
    public function getMulticellInstance()
    {
        return $this->multicell;
    }


    /**
     * Table Initialization Function
     *
     * @param array $columnWidths
     * @param array $configuration
     */
    public function initialize(array $columnWidths, array $configuration = [])
    {
        //set the no of columns
        $this->columns = count($columnWidths);
        $this->setColumnsWidths($columnWidths);

        //header is not parsed
        $this->headerParsed = false;

        $this->tableHeaderType = [];

        $this->dataCache = [];
        $this->headerCache = [];

        $this->tableStartX = $this->pdf->GetX();
        $this->tableStartY = $this->pdf->GetY();

        $this->dataOnCurrentPage = false;
        $this->headerOnCurrentPage = false;

        foreach ($configuration as $key => $value) {
            if (!in_array($key, ['TABLE', 'HEADER', 'ROW'])) {
                continue;
            }
            $this->configuration[$key] = array_merge($this->configuration[$key], $value);
        }

        $this->markMarginX();
    }


    /**
     * Closes the table.
     * This function writes the table content to the PDF Object.
     */
    public function close()
    {
        //output the table data to the pdf
        $this->ouputData();

        //draw the Table Border
        $this->drawBorder();
    }


    /**
     * Set the width of all columns with one function call
     *
     * @param $columnWidths array|null the width of columns, example: 50, 40, 40, 20
     */
    public function setColumnsWidths(array $columnWidths = null)
    {
        if (is_array($columnWidths)) {
            $this->columnWidths = $columnWidths;
        } else {
            $this->columnWidths = func_get_args();
        }
    }


    /**
     * Set the Width for the specified Column
     *
     * @param int $columnIndex the column index, 0 based ( first column starts with 0)
     * @param int|float $width number
     *
     */
    public function setColumnWidth(int $columnIndex, $width)
    {
        $this->columnWidths[$columnIndex] = $width;
    }


    /**
     * Get the Width for the specified Column
     *
     * @param int $columnIndex the column index, 0 based ( first column starts with 0)
     * @return int|float $width The column Width
     */
    public function getColumnWidth(int $columnIndex)
    {
        if (!isset($this->columnWidths[$columnIndex])) {
            trigger_error("Undefined width for column $columnIndex");

            return 0;
        }

        return $this->columnWidths[$columnIndex];
    }


    /**
     * Returns the current page Width
     *
     * @return integer - the Page Width
     */
    protected function pageWidth(): int
    {
        return (int)$this->pdf->w - $this->pdf->rMargin - $this->pdf->lMargin;
    }


    /**
     * Returns the current page Height
     *
     * @return int|float - the Page Height
     */
    protected function pageHeight()
    {
        return (int)$this->pdf->h - $this->pdf->tMargin - $this->pdf->bMargin;
    }


    /**
     * Sets the Split Mode of the Table.
     * Default is ON(true)
     *
     * @param $bSplit boolean - if TRUE then Split is Active
     */
    public function setSplitMode(bool $bSplit = true)
    {
        $this->tableSplit = $bSplit;
    }


    /**
     * Enable or disables the header on a new page
     *
     * @param $bValue boolean
     *
     */
    public function setHeaderNewPage(bool $bValue)
    {
        $this->headerOnNewPage = $bValue;
    }


    /**
     * Adds a Header Row to the table
     *
     * Example of a header row input array:
     * array(
     * 0 => array(
     * 'TEXT' => "Header Text 1"
     * "TEXT_COLOR" => array(120,120,120),
     * "TEXT_SIZE" => 5,
     * ...
     * ),
     * 1 => array(
     * ...
     * ),
     * );
     *
     * @param $headerRow array
     */
    public function addHeader(array $headerRow = [])
    {
        $this->tableHeaderType[] = $headerRow;
    }


    /**
     * Sets a specific value for a header row
     *
     * @param $nColumn integer the Cell Column. Starts with 0.
     * @param $sPropertyKey string the Property Identifierthat should be set
     * @param $sPropertyValue mixed the Property Value value for the Key Index
     * @param $nRow integer The header Row. If the header row does not exists, then they will be created with default values.
     */
    public function setHeaderProperty(int $nColumn, string $sPropertyKey, $sPropertyValue, int $nRow = 0)
    {
        for ($i = 0; $i <= $nRow; $i++) {
            if (!isset($this->tableHeaderType[$i])) {
                $this->tableHeaderType[$i] = [];
            }
        }

        if (!isset($this->tableHeaderType[$nRow][$nColumn])) {
            $this->tableHeaderType[$nRow][$nColumn] = [];
        }

        $this->tableHeaderType[$nRow][$nColumn][$sPropertyKey] = $sPropertyValue;
    }


    /**
     * Parses the header data and adds the data to the cache
     *
     * @param $bForce boolean
     */
    protected function parseHeader(bool $bForce = false)
    {
        //if the header was parsed don't parse it again!
        if ($this->headerParsed && !$bForce) {
            return;
        }

        //empty the header cache
        $this->headerCache = [];

        //create the header cache data
        foreach ($this->tableHeaderType as $val) {
            $this->addDataToCache($val, 'header');
        }

        $this->cacheParseRowspan(0, 'header');
        $this->headerHeight();
    }


    /**
     * Calculates the Header Height.
     * If the Header height is bigger than the page height then the script dies.
     */
    protected function headerHeight()
    {
        $this->headerHeight = 0;

        $count = count($this->headerCache);
        for ($i = 0; $i < $count; $i++) {
            $this->headerHeight += $this->headerCache[$i]['HEIGHT'];
        }

        if ($this->headerHeight > $this->pageHeight()) {
            die("Header Height($this->headerHeight) bigger than Page Height({$this->pageHeight()})");
        }
    }


    /**
     * Calculates the X margin of the table depending on the ALIGN
     */
    protected function markMarginX()
    {
        $tb_align = $this->getTableConfig('TABLE_ALIGN');

        //set the table align
        switch ($tb_align) {
            case 'C':
                $this->tableStartX = $this->pdf->lMargin +
                    $this->getTableConfig('TABLE_LEFT_MARGIN') +
                    ($this->pageWidth() - $this->getWidth()) / 2;
                break;
            case 'R':
                $this->tableStartX = $this->pdf->lMargin +
                    $this->getTableConfig('TABLE_LEFT_MARGIN') +
                    ($this->pageWidth() - $this->getWidth());
                break;
            case 'L':
                $this->tableStartX = $this->pdf->lMargin + $this->getTableConfig('TABLE_LEFT_MARGIN');
                break;
            default:
                $this->tableStartX = $this->pdf->getX();
                break;
        }
    }


    /**
     * Draws the Table Border
     */
    public function drawBorder()
    {
        if (0 == $this->getTableConfig('BORDER_TYPE')) {
            return;
        }

        if (!$this->dataOnCurrentPage) {
            return;
        } //there was no data on the current page


        //set the colors
        list($r, $g, $b) = $this->getTableConfig('BORDER_COLOR');
        $this->pdf->SetDrawColor($r, $g, $b);

        if (0 == $this->getTableConfig('BORDER_SIZE')) {
            return;
        }

        //set the line width
        $this->pdf->SetLineWidth($this->getTableConfig('BORDER_SIZE'));

        $x = $this->tableStartX;
        if ($this->pdf->getRTL()) {
            $x = $this->pdf->getPageWidth() - $x - $this->getWidth();
        }

        //draw the border
        $this->pdf->Rect(
            $x,
            $this->tableStartY,
            $this->getWidth(),
            $this->pdf->GetY() - $this->tableStartY
        );
    }


    /**
     * End Page Special Border Draw.
     * This is called in the case of a Page Split
     */
    protected function tbEndPageBorder()
    {
        if ('' != $this->getTableConfig('BRD_TYPE_END_PAGE')) {
            if (strpos($this->getTableConfig('BRD_TYPE_END_PAGE'), 'B') >= 0) {
                //set the colors
                list($r, $g, $b) = $this->getTableConfig('BORDER_COLOR');
                $this->pdf->SetDrawColor($r, $g, $b);

                //set the line width
                $this->pdf->SetLineWidth($this->getTableConfig('BORDER_SIZE'));

                //draw the line
                $this->pdf->Line(
                    $this->tableStartX,
                    $this->pdf->GetY(),
                    $this->tableStartX + $this->getWidth(),
                    $this->pdf->GetY()
                );
            }
        }
    }


    /**
     * Returns the table width in user units
     *
     * @return integer - table width
     */
    public function getWidth()
    {
        //calculate the table width
        $tb_width = 0;

        for ($i = 0; $i < $this->columns; $i++) {
            $tb_width += $this->getColumnWidth($i);
        }

        return $tb_width;
    }


    /**
     * Aligns the table to the Start X point
     */
    protected function tbAlign()
    {
        $this->pdf->SetX($this->tableStartX);
    }


    /**
     * "Draws the Header".
     * More specific puts the data from the Header Cache into the Data Cache
     *
     */
    public function drawHeader()
    {
        $this->parseHeader();

        foreach ($this->headerCache as $val) {
            $this->dataCache[] = $val;
        }

        $this->headerOnCurrentPage = true;
    }


    /**
     * Adds a line to the Table Data or Header Cache.
     * Call this function after the table initialization, table, header and data types are set
     *
     * @param array $rowData Data to be Drawed
     */
    public function addRow(array $rowData = [])
    {
        if (!$this->headerOnCurrentPage) {
            $this->drawHeader();
        }

        $this->addDataToCache($rowData);
    }


    /**
     * Adds a Page Break in the table.
     */
    public function addPageBreak()
    {
        $this->dataCache[] = array(
            'HEIGHT' => 0,
            'DATATYPE' => self::TB_DATA_TYPE_INSERT_NEW_PAGE
        );
    }


    /**
     * Applies the default values for a header or data row
     *
     * @param $aData array Data Row
     * @param $sDataType string
     * @return array The Data with default values
     */
    protected function applyDefaultValues(array $aData, string $sDataType): array
    {
        switch ($sDataType) {
            case 'header':
                $aReference = $this->configuration['HEADER'];
                break;

            default:
                $aReference = $this->configuration['ROW'];
                break;
        }

        return array_merge($aReference, $aData);
    }


    /**
     * Returns the default values
     *
     * @param $sDataType string
     * @return array The Data with default values
     */
    protected function getDefaultValues(string $sDataType): array
    {
        switch ($sDataType) {
            case 'header':
                return $this->configuration['HEADER'];

            default:
                return $this->configuration['ROW'];
        }
    }


    protected function getCellObject($data = null)
    {
        if (null === $data) {
            $cell = new \EvoSys21\PdfLib\Table\Cell\Multicell($this->pdf);
        } elseif (is_object($data)) {
            $cell = $data;
        } else {
            $type = $data['TYPE'] ?? 'MULTICELL';
            $type = strtoupper($type);

            if (!isset($this->typeMap[$type])) {
                trigger_error("Invalid cell type: $type", E_USER_ERROR);
            }

            $class = $this->typeMap[$type];

            $cell = new $class($this->pdf);
            /** @var $cell CellInterface */
            if (!is_array($data)) {
                $data = [
                    'TEXT' => $data
                ];
            }
            $cell->setProperties($data);
        }

        if ($cell instanceof \EvoSys21\PdfLib\Table\Cell\Multicell) {
            $cell->attachMulticell($this->multicell);
        }

        return $cell;
    }


    /**
     * Adds the data to the cache
     *
     * @param $data array - array containing the data to be added
     * @param $dataType string - data type. Can be 'data' or 'header'. Depending on this data the $data is put in the selected cache
     */
    protected function addDataToCache(array $data, string $dataType = 'data')
    {
        if ($dataType == 'header') {
            $cache = &$this->headerCache;
        } else { //data
            $cache = &$this->dataCache;
        }

        $rowSpan = [];

        $hm = 0;

        /**
         * If dataCache is empty initialize it
         */
        if (count($cache) > 0) {
            $dataCache = end($cache);
        } else {
            $dataCache = [];
        }

        //this variable will contain the active colspans
        $activeColspan = 0;

        $row = [];

        //calculate the maximum height of the cells
        for ($i = 0; $i < $this->columns; $i++) {
            if (isset($data[$i])) {
                $cellObject = $this->getCellObject($data[$i]);
            } else {
                $cellObject = $this->getCellObject();
            }

            $row[$i] = $cellObject;

            $cellObject->setDefaultValues($this->getDefaultValues($dataType));
            $cellObject->setCellDrawWidth($this->getColumnWidth($i)); //copy this from the header settings

            //if there is an active colspan on this line we just skip this cell
            if ($activeColspan > 1) {
                $cellObject->setSkipped(true);
                $activeColspan--;
                continue;
            }

            if (!empty($dataCache)) {
                //there was at least one row before and was data or header
                $cell = &$dataCache['DATA'][$i];
                /** @var $cell CellInterface */


                if (isset($cell) && ($cell->getRowSpan() > 1)) {
                    /**
                     * This is rowspan over this cell.
                     * The cell will be ignored but some characteristics are kept
                     */

                    //this cell will be skipped
                    $cellObject->setSkipped(true);
                    //decrease the rowspan value... one line less to be spanned
                    $cellObject->setRowSpan($cell->getRowSpan() - 1);

                    //copy the colspan from the last value
                    $cellObject->setColSpan($cell->getColSpan());

                    //cell width is the same as the one from the line before it
                    $cellObject->setCellDrawWidth($cell->getCellDrawWidth());

                    if ($cellObject->getColSpan() > 1) {
                        $activeColspan = $cellObject->getColSpan();
                    }

                    continue; //jump to the next column
                }
            }

            /**
             * If we have colspan then we ignore the 'colspanned' cells
             */
            if ($cellObject->getColSpan() > 1) {
                for ($j = 1; $j < $cellObject->getColSpan(); $j++) {
                    //if there is a colspan, then calculate the number of lines also with the with of the next cell
                    if (($i + $j) < $this->columns) {
                        $cellObject->setCellDrawWidth($cellObject->getCellDrawWidth() + $this->getColumnWidth($i + $j));
                    }
                }
            }

            //add the cells that are with rowspan to the rowspan array - this is used later
            if ($cellObject->getRowSpan() > 1) {
                $rowSpan[] = $i;
            }

            $cellObject->processContent();

            //@todo: check this condition
            /**
             * IF THERE IS ROWSPAN ACTIVE Don't include this cell Height in the calculation.
             * This will be calculated later with the sum of all heights
             */
            if (1 == $cellObject->getRowSpan()) {
                $hm = max($hm, $cellObject->getCellDrawHeight()); //this would be the normal height
            }

            if ($cellObject->getColSpan() > 1) {
                //just skip the other cells
                $activeColspan = $cellObject->getColSpan();
            }
        }

        //for every cell, set the Draw Height to the maximum height of the row
        foreach ($row as $aCell) {
            /** @var $aCell CellInterface */
            $aCell->setCellDrawHeight($hm);
        }

        //@formatter:off
        $cache[] = array(
            'HEIGHT' => $hm, //the line maximum height
            'DATATYPE' => $dataType, //The data Type - Data/Header
            'DATA' => $row, //this line's data
            'ROWSPAN' => $rowSpan //rowspan ID array
        );
        //@formatter:on

        //we set the rowspan in cache variable to true if we have a rowspan
        if (!empty($rowSpan) && (!$this->rowSpanInCache)) {
            $this->rowSpanInCache = true;
        }
    }


    /**
     * Parses the Data Cache and calculates the maximum Height of each row.
     * Normally the cell Height of a row is calculated when the data's are added,
     * but when that row is involved in a Rowspan then it's Height can change!
     *
     * @param $iStartIndex integer - the index from which to parse
     * @param $sCacheType string - what type has the cache - possible values: 'header' && 'data'
     */
    protected function cacheParseRowspan(int $iStartIndex = 0, string $sCacheType = 'data')
    {
        if ($sCacheType == 'data') {
            $aRefCache = &$this->dataCache;
        } else {
            $aRefCache = &$this->headerCache;
        }

        $rowSpans = [];

        $count = count($aRefCache);

        for ($ix = $iStartIndex; $ix < $count; $ix++) {
            $val = &$aRefCache[$ix];

            if (
                !in_array($val['DATATYPE'], array(
                'data',
                'header'
                ))
            ) {
                continue;
            }

            //if there is no rowspan jump over
            if (empty($val['ROWSPAN'])) {
                continue;
            }

            foreach ($val['ROWSPAN'] as $k) {
                /** @var $cell CellInterface */
                $cell = &$val['DATA'][$k];

                if ($cell->getRowSpan() < 1) {
                    continue;
                } //skip the rows without rowspan


                //@formatter:off
                $rowSpans[] = array(
                    'row_id' => $ix,
                    'reference_cell' => $cell
                );
                //@formatter:on

                $h_rows = 0;

                //calculate the sum of the Heights for the lines that are included in the rowspan
                for ($i = 0; $i < $cell->getRowSpan(); $i++) {
                    if (isset($aRefCache[$ix + $i])) {
                        $h_rows += $aRefCache[$ix + $i]['HEIGHT'];
                    }
                }

                //this is the cell height that makes the rowspan
                //$h_cell = $val['DATA'][$k]['HEIGHT'];
                //$h_cell = $val['DATA'][$k]->getCellDrawHeight();
                $h_cell = $cell->getCellDrawHeight();

                /**
                 * The Rowspan Cell's Height is bigger than the sum of the Rows Heights that he
                 * is spanning In this case we have to increase the height of each row
                 */
                if ($h_cell > $h_rows) {
                    //calculate the value of the HEIGHT to be added to each row
                    $add_on = ($h_cell - $h_rows) / $cell->getRowSpan();
                    for ($i = 0; $i < $cell->getRowSpan(); $i++) {
                        if (isset($aRefCache[$ix + $i])) {
                            $aRefCache[$ix + $i]['HEIGHT'] += $add_on;
                        }
                    }
                }
            }
        }

        /**
         * Calculate the height of each cell that makes the rowspan.
         * The height of this cell is the sum of the heights of the rows where the rowspan occurs
         */

        foreach ($rowSpans as $val1) {
            /** @var CellAbstract $cell */
            $cell = $val1['reference_cell'];

            $h_rows = 0;
            //calculate the sum of the Heights for the lines that are included in the rowspan
            for ($i = 0; $i < $cell->getRowSpan(); $i++) {
                if (isset($aRefCache[$val1['row_id'] + $i])) {
                    $h_rows += $aRefCache[$val1['row_id'] + $i]['HEIGHT'];
                }
            }

            $cell->setCellDrawHeight($h_rows);

            if (!$this->tableSplit) {
                $aRefCache[$val1['row_id']]['HEIGHT_ROWSPAN'] = $h_rows;
            }
        }
    }


    /**
     * Splits the Data Cache into Pages.
     * Parses the Data Cache and when it is needed then a "new page" command is inserted into the Data Cache.
     */
    protected function cachePaginate()
    {
        $pageHeight = $this->PageHeight();

        /**
         * This Variable will contain the remained page Height
         */
        $leftHeight = $pageHeight - $this->pdf->GetY() + $this->pdf->tMargin;
        $iLastOkKey = 0;

        $this->dataOnCurrentPage = false;
        $headerOnPage = false;
        $iLastDataKey = 0;

        //will contain the rowspans on the current page, EMPTY THIS VARIABLE AT EVERY NEW PAGE!!!
        $rowSpans = [];

        $aDC = &$this->dataCache;

        $count = count($aDC);

        for ($i = 0; $i < $count; $i++) {
            $val = &$aDC[$i];

            if ($val['DATATYPE'] == self::TB_DATA_TYPE_INSERT_NEW_PAGE) {
                /** @noinspection PhpUnusedLocalVariableInspection */
                $rowSpans = [];
                /** @noinspection PhpUnusedLocalVariableInspection */
                $leftHeight = $pageHeight;
                $this->dataOnCurrentPage = false; //new page
                $this->insertNewPage($i, null, true, true);
                break;
            }

            $isHeader = $val['DATATYPE'] == 'header';

            if ($isHeader) {
                $iLastDataKey = $iLastOkKey;
            }

            if (isset($val['ROWSPAN'])) {
                foreach ($val['ROWSPAN'] as $v) {
                    $rowSpans[] = array(
                        $i,
                        $v
                    );
                    $aDC[$i]['DATA'][$v]->HEIGHT_LEFT_RW = $leftHeight;
                }
            }

            $iLeftHeightLast = $leftHeight;

            $iRowHeight = $val['HEIGHT'];
            $iRowHeightRowspan = 0;
            if (!$this->tableSplit && (isset($val['HEIGHT_ROWSPAN']))) {
                $iRowHeightRowspan = $val['HEIGHT_ROWSPAN'];
            }

            $iLeftHeightRowspan = $leftHeight - $iRowHeightRowspan;
            $leftHeight -= $iRowHeight;

            if (isset($val['DATA'][0]->IGNORE_PAGE_BREAK) && ($leftHeight < 0)) {
                $leftHeight = 0;
            }

            if (($leftHeight >= 0) && ($iLeftHeightRowspan >= 0)) {
                //this row has enough space on the page
                if ($isHeader) {
                    $headerOnPage = true;
                } else {
                    $iLastDataKey = $i;
                    $this->dataOnCurrentPage = true;
                }
                $iLastOkKey = $i;
            } else {
                //@formatter:off

                /**
                 * THERE IS NOT ENOUGH SPACE ON THIS PAGE - HAVE TO SPLIT
                 * Decide the split type
                 *
                 * SITUATION 1:
                 * IF
                 *         - the current data type is header OR
                 *         - on this page we had no data(that means untill this point was nothing or just header) AND tableSplit is off AND $iLastDataKey is NOT the first row(>0)
                 * THEN we just add new page on the positions of LAST DATA KEY ($iLastDataKey)
                 *
                 * SITUATION 2:
                 * IF
                 *         - TableSplit is OFF and the height of the current data is bigger than the Page Height minus (-) Header Height
                 * THEN we split the current cell
                 *
                 * SITUATION 3:
                 *         - normal split flow
                 *
                 */
                //@formatter:on


                //use this switch for flow control
                switch (1) {
                    case 1:
                        //SITUATION 1:
                        if (
                            $isHeader or
                            (!$headerOnPage and !$this->dataOnCurrentPage and !$this->tableSplit and ($iLastDataKey > 0))
                        ) {
                            $count = $this->insertNewPage(
                                $iLastDataKey,
                                null,
                                (!$isHeader) && (!$headerOnPage)
                            );
                            break; //exit from switch(1);
                        }

                        $doSplit = $this->tableSplit;

                        //SITUATION 2:
                        if ($val['HEIGHT'] > ($pageHeight - $this->headerHeight)) {
                            //even if the tableSplit is OFF - split the data!!!
                            $doSplit = true;
                        }

                        if ($this->disablePageBreak) {
                            $doSplit = false;
                        }

                        if ($doSplit) {
                            /**
                             * *************************************************
                             * * * * * * * * * * * * * * * * * * * * * * * * * *
                             * SPLIT IS ACTIVE
                             * * * * * * * * * * * * * * * * * * * * * * * * * *
                             * *************************************************
                             */

                            //if we can draw on this page at least one line from the cells

                            $data = $val['DATA'];

                            $rowHeight = $iLeftHeightLast;
                            #$rowHeight = 0;
                            $rowHeightData = 0;

                            $aTData = [];

                            //parse the data's on this line
                            for ($j = 0; $j < $this->columns; $j++) {
                                /** @var $cell CellAbstract */
                                /** @var $cellSplit CellAbstract */

                                $aTData[$j] = $data[$j];
                                $cellSplit = &$aTData[$j];
                                $cell = &$data[$j];

                                /**
                                 * The cell is Skipped or is a Rowspan.
                                 * For active split we handle rowspanned cells later
                                 */
                                if (($cell->getSkipped() === true) || ($cell->getRowSpan() > 1)) {
                                    continue;
                                }

                                if ($cell->isSplittable()) {
                                    list($cellSplit) = $cell->split($val['HEIGHT'], $iLeftHeightLast);
                                    $cell->setCellDrawHeight($iLeftHeightLast);
                                } else {
                                    $cellSplit = clone $cell;

                                    $o = new EmptyCell($this->pdf);
                                    $o->copyProperties($cell);
                                    $o->setCellDrawWidth($cell->getCellDrawWidth());
                                    $o->setCellHeight($iLeftHeightLast);
                                    $cell = $o;
                                }

                                $rowHeight = max($rowHeight, $cell->getCellDrawHeight());
                                $rowHeightData = max($rowHeightData, $cellSplit->getCellDrawHeight());
                            }

                            $val['HEIGHT'] = $rowHeight;
                            $val['DATA'] = $data;

                            $v_new = $val;
                            $v_new['HEIGHT'] = $rowHeightData;
                            $v_new['ROWSPAN'] = [];
                            /**
                             * Parse separately the rows with the ROWSPAN
                             */

                            $bNeedParseCache = false;

                            foreach ($rowSpans as $rws) {
                                $rData = &$aDC[$rws[0]]['DATA'][$rws[1]];
                                /** @var $rData CellAbstract */

                                if ($rData->isPropertySet('HEIGHT_LEFT_RW') && $rData->getCellDrawHeight() > $rData->HEIGHT_LEFT_RW) {
                                    /**
                                     * This cell has a rowspan in IT
                                     * We have to split this cell only if its height is bigger than the space to the end of page
                                     * that was set when the cell was parsed.
                                     * HEIGHT_LEFT_RW
                                     */

                                    if ($rData->isSplittable()) {
                                        list($aTData[$rws[1]]) = $rData->split(
                                            $rData->getCellDrawHeight(),
                                            $rData->HEIGHT_LEFT_RW
                                        );
                                        $rData->setCellDrawHeight($rData->HEIGHT_LEFT_RW);
                                    } else {
                                        $aTData[$rws[1]] = clone $rData;

                                        $o = new EmptyCell($this->pdf);
                                        $o->copyProperties($rData);
                                        $o->setCellDrawWidth($rData->getCellDrawWidth());
                                        $o->setCellDrawHeight($rData->HEIGHT_LEFT_RW);
                                        $rData = $o;
                                        //$rData->setSkipped(true);
                                    }

                                    $aTData[$rws[1]]->setRowSpan($aTData[$rws[1]]->getRowSpan() - ($i - $rws[0]));

                                    $v_new['ROWSPAN'][] = $rws[1];

                                    $bNeedParseCache = true;
                                }
                            }

                            $v_new['DATA'] = $aTData;
                            $this->dataOnCurrentPage = true;

                            //Insert the new page, and get the new number of the lines
                            $count = $this->insertNewPage($i, $v_new);

                            if ($bNeedParseCache) {
                                $this->cacheParseRowspan($i + 1);
                            }
                        } else {
                            /**
                             * *************************************************
                             * * * * * * * * * * * * * * * * * * * * * * * * * *
                             * SPLIT IS INACTIVE
                             * * * * * * * * * * * * * * * * * * * * * * * * * *
                             * *************************************************
                             */

                            /**
                             * Check if we have a rowspan that needs to be splitted
                             */

                            $bNeedParseCache = false;

                            $rowSpan = $aDC[$i]['ROWSPAN'];

                            foreach ($rowSpans as $rws) {
                                $rData = &$aDC[$rws[0]]['DATA'][$rws[1]];
                                /** @var $rData CellAbstract */

                                if ($rws[0] == $i) {
                                    continue;
                                } //means that this was added at the last line, that will not appear on this page


                                if ($rData->getCellDrawHeight() > $rData->HEIGHT_LEFT_RW) {
                                    /**
                                     * This cell has a rowspan in IT
                                     * We have to split this cell only if its height is bigger than the space to the end of page
                                     * that was set when the cell was parsed.
                                     * HEIGHT_LEFT_RW
                                     */

                                    list($aTData) = $rData->split(
                                        $rData->getCellDrawHeight(),
                                        $rData->HEIGHT_LEFT_RW - $iLeftHeightLast
                                    );

                                    /** @var $aTData CellInterface */

                                    $rData->setCellDrawHeight($rData->HEIGHT_LEFT_RW - $iLeftHeightLast);

                                    $aTData->setRowSpan($aTData->getRowSpan() - ($i - $rws[0]));

                                    $aDC[$i]['DATA'][$rws[1]] = $aTData;

                                    $rowSpan[] = $rws[1];
                                    $aDC[$i]['ROWSPAN'] = $rowSpan;

                                    $bNeedParseCache = true;
                                }
                            }

                            if ($bNeedParseCache) {
                                $this->cacheParseRowspan($i);
                            }

                            //Insert the new page, and get the new number of the lines
                            $count = $this->insertNewPage($i);
                        }
                }

                $leftHeight = $pageHeight;
                $rowSpans = [];
                $this->dataOnCurrentPage = false; //new page
            }
        }
    }


    /**
     * Inserts a new page in the Data Cache, after the specified Index.
     * If sent then also a new data is inserted after the new page
     *
     * @param $index integer - after this index the new page inserted
     * @param $newData resource - default null. If specified this data is inserted after the new page
     * @param $insertHeader boolean - true then the header is inserted, false - no header is inserted
     * @param bool $removeCurrentRow
     * @return integer the new number of lines that the Data Cache Contains.
     */
    protected function insertNewPage(int $index = 0, $newData = null, bool $insertHeader = true, bool $removeCurrentRow = false): int
    {
        if ($this->disablePageBreak) {
            return 0;
        }

        $this->headerOnCurrentPage = false;

        //parse the header if for some reason it was not parsed!?
        $this->parseHeader();

        //the number of lines that the header contains
        if ($this->drawHeader && $insertHeader && ($this->headerOnNewPage)) {
            $headerLines = count($this->headerCache);
        } else {
            $headerLines = 0;
        }

        $aDC = &$this->dataCache;
        $items = count($aDC); //the number of elements in the cache

        //if we have a NewData to be inserted after the new page then we have to shift the data with 1
        if (null != $newData) {
            $shift = 1;
        } else {
            $shift = 0;
        }

        //if we have a header and no data on the current page, remove the header from the current page!
        if ($headerLines > 0 && !$this->dataOnCurrentPage) {
            $shift -= $headerLines;
        }

        $nIdx = 0;
        if ($removeCurrentRow) {
            $nIdx = 1;
        }

        //shift the array with the number of lines that the header contains + one line for the new page
        for ($j = $items; $j > $index; $j--) {
            $aDC[$j + $headerLines + $shift - $nIdx] = $aDC[$j - 1];
        }

        $aDC[$index + $shift] = array(
            'HEIGHT' => 0,
            'DATATYPE' => 'new_page'
        );

        $j = $shift;

        if ($headerLines > 0) {
            //only if we have a header
            //insert the header into the corresponding positions
            foreach ($this->headerCache as $rHeaderVal) {
                $j++;
                $aDC[$index + $j] = $rHeaderVal;
            }

            $this->headerOnCurrentPage = true;
        }

        if (1 == $shift) {
            $j++;
            $aDC[$index + $j] = $newData;
        }

        $this->dataOnCurrentPage = false;

        return count($aDC);
    }


    /**
     * Sends all the Data Cache to the PDF Document.
     * This is the Function that Outputs the table data to the pdf document
     */
    protected function cachePrepOutputData()
    {
        $this->dataOnCurrentPage = false;

        //save the old auto page break value
        $oldAutoPageBreak = $this->pdf->AutoPageBreak;
        $oldbMargin = $this->pdf->bMargin;

        //disable the auto page break
        $this->pdf->SetAutoPageBreak(false, $oldbMargin);

        $dataCache = &$this->dataCache;

        $count = count($dataCache);

        for ($k = 0; $k < $count; $k++) {
            $val = &$dataCache[$k];

            //each array contains one line
            $this->tbAlign();

            if ($val['DATATYPE'] == 'new_page') {
                //add a new page
                $this->addPage();
                continue;
            }

            $data = &$val['DATA'];

            //Draw the cells of the row
            for ($i = 0; $i < $this->columns; $i++) {
                /** @var $cell CellInterface */
                $cell = &$data[$i];

                //Save the current position
                $x = $this->pdf->GetX();
                $y = $this->pdf->GetY();

                if ($cell->getSkipped() === false) {
                    //render the cell to the pdf
                    //$data[$i]->render($rowHeight = $val['HEIGHT']);


                    if ($val['HEIGHT'] > $cell->getCellDrawHeight()) {
                        $cell->setCellDrawHeight($val['HEIGHT']);
                    }

                    $cell->render();
                }

                $this->pdf->SetXY($x + $this->getColumnWidth($i), $y);

                //if we have colspan, just ignore the next cells
            }

            $this->dataOnCurrentPage = true;

            //Go to the next line
            $this->pdf->Ln($val['HEIGHT']);
        }

        $this->pdf->SetAutoPageBreak($oldAutoPageBreak, $oldbMargin);
    }


    /**
     * Prepares the cache for Output.
     * Parses the cache for Rowspans, Paginates the cache and then send the data to the pdf document
     */
    protected function cachePrepOutput()
    {
        if ($this->rowSpanInCache) {
            $this->cacheParseRowspan();
        }

        $this->cachePaginate();

        $this->cachePrepOutputData();
    }


    /**
     * Adds a new page in the pdf document and initializes the table and the header if necessary.
     */
    protected function addPage()
    {
        $this->drawBorder(); //draw the table border
        $this->tbEndPageBorder(); //if there is a special handling for end page??? this is specific for me

        $this->pdf->AddPage($this->pdf->CurOrientation); //add a new page

        $this->dataOnCurrentPage = false;

        $this->tableStartX = $this->pdf->GetX();
        $this->tableStartY = $this->pdf->GetY();
        $this->markMarginX();
    }


    /**
     * Sends to the pdf document the cache data
     */
    public function ouputData()
    {
        $this->cachePrepOutput();
    }


    /**
     * Sets the attributes for the specified tag
     *
     * @param string $tag tag name/key
     * @param float|null $fontSize font size
     * @param string|null $fontStyle font style
     * @param string|array|null $color
     * @param string|null $fontFamily font family
     * @param string $inherit Tag to be inherited
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setStyle($tag, $fontSize = null, $fontStyle = null, $color = null, $fontFamily = null, $inherit = 'base')
    {
        $this->multicell->setStyle($tag, $fontSize, $fontStyle, $color, $fontFamily, $inherit);
    }

    /**
     * Define a style with a configuration array
     *
     * @param string $tag Tag name
     * @param array $config Tag configuration
     * @param null $inherit Tag to inherit
     */
    public function setStyleAssoc(string $tag, array $config = [], $inherit = null)
    {
        $this->multicell->setStyleAssoc($tag, $config, $inherit);
    }

    /**
     * Returns the array value if set otherwise the default
     *
     * @param $var mixed
     * @param $index mixed
     * @param $default mixed
     * @return mixed value or default
     */
    public static function getValue($var, $index = '', $default = '')
    {
        if (is_array($var)) {
            if (isset($var[$index])) {
                return $var[$index];
            }
        }

        return $default;
    }

    /**
     * Returns the table configuration value specified by the input key
     *
     * @param string $key
     * @return mixed
     *
     */
    protected function getTableConfig(string $key)
    {
        return self::getValue($this->configuration['TABLE'], $key);
    }


    /**
     * Sets the Table Config
     * @param $aConfig array - array containing the Table Configuration
     */
    public function setTableConfig(array $aConfig)
    {
        $this->configuration['TABLE'] = array_merge($this->configuration['TABLE'], $aConfig);
        $this->markMarginX();
    }

    /**
     * Sets Header configuration values
     *
     * @param array $aConfig
     */
    public function setHeaderConfig(array $aConfig)
    {
        $this->configuration['HEADER'] = array_merge($this->configuration['HEADER'], $aConfig);
    }

    /**
     * Sets Row configuration values
     *
     * @param array $aConfig
     */
    public function setRowConfig(array $aConfig)
    {
        $this->configuration['ROW'] = array_merge($this->configuration['ROW'], $aConfig);
    }


    /**
     * Returns the header configuration value specified by the input key
     *
     * @param string $key
     * @return mixed
     *
     */
    protected function getHeaderConfig(string $key)
    {
        return self::getValue($this->configuration['HEADER'], $key);
    }


    /**
     * Returns the row configuration value specified by the input key
     *
     * @param string $key
     * @return mixed
     *
     */
    protected function getRowConfig(string $key)
    {
        return self::getValue($this->configuration['ROW'], $key);
    }


    /**
     * Returns the default configuration array of the table.
     * The array contains values for the Table style, Header Style and Data Style.
     * All these values can be overwritten when creating the table or in the case of CELLS for every individual cell
     *
     * @return array The Default Configuration
     */
    protected function getDefaultConfiguration(): array
    {
        $files = [
            $this->configFile,
            __DIR__ . '/' . $this->configFile,
        ];

        if (defined('PDF_TABLE_CONFIG_PATH')) {
            array_unshift($files, PDF_TABLE_CONFIG_PATH . $this->configFile);
        }

        foreach ($files as $file) {
            if (is_readable($file)) {
                return require($file);
            }
        }

        trigger_error("Table Configuration file not found. Please check your settings");
        return [];
    }

    /**
     * Returns the compatibility map between STRINGS and Constants
     *
     * @return array
     */
    protected function compatibilityMap(): array
    {
        //@formatter:off
        return array(
            'TEXT_COLOR' => self::TEXT_COLOR,
            'TEXT_SIZE' => self::TEXT_SIZE,
            'TEXT_FONT' => self::TEXT_FONT,
            'TEXT_ALIGN' => self::TEXT_ALIGN,
            'VERTICAL_ALIGN' => self::VERTICAL_ALIGN,
            'TEXT_TYPE' => self::TEXT_TYPE,
            'LINE_SIZE' => self::LINE_SIZE,
            'BACKGROUND_COLOR' => self::BACKGROUND_COLOR,
            'BORDER_COLOR' => self::BORDER_COLOR,
            'BORDER_SIZE' => self::BORDER_SIZE,
            'BORDER_TYPE' => self::BORDER_TYPE,
            'TEXT' => self::TEXT,
            'PADDING_TOP' => self::PADDING_TOP,
            'PADDING_RIGHT' => self::PADDING_RIGHT,
            'PADDING_LEFT' => self::PADDING_LEFT,
            'PADDING_BOTTOM' => self::PADDING_BOTTOM,
            'TABLE_ALIGN' => self::TABLE_ALIGN,
            'TABLE_LEFT_MARGIN' => self::TABLE_LEFT_MARGIN,
        );
        //@formatter:on
    }


    /**
     * Returns the current type map
     *
     * @return array
     */
    protected function getTypeMap(): array
    {
        return $this->typeMap;
    }


    /**
     * Adds a type/class relationship
     *
     * @param string $name
     * @param string $class
     */
    public function addTypeMap(string $name, string $class)
    {
        if (!class_exists($class)) {
            //fatal error
            trigger_error("Invalid class specified: $class", E_USER_ERROR);
        }

        $this->typeMap[strtoupper($name)] = $class;
    }


    /**
     * Sets the disable page break value. If TRUE then page-breaks are disabled
     *
     * @param boolean $value
     * @return $this
     */
    public function setDisablePageBreak(bool $value): Table
    {
        $this->disablePageBreak = $value;

        return $this;
    }

    /**
     * Returns the PDF object
     *
     * @return Object|null
     */
    public function getPdfObject(): ?object
    {
        return $this->pdf;
    }
}
