<?php

defined( 'APPLICATION_PATH' ) || define( 'APPLICATION_PATH', realpath( dirname( __FILE__ ) . '/../' ) );
define( 'PDF_RESOURCES_IMAGES', APPLICATION_PATH . '/images' );

require_once( APPLICATION_PATH . "/classes/pdf.php" );
require_once( APPLICATION_PATH . "/classes/pdftable.php" );
require_once( APPLICATION_PATH . "/mypdf-table.php" );
