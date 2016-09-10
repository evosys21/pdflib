<?php

// Define path to application directory
defined( 'APPLICATION_PATH' ) || define( 'APPLICATION_PATH', realpath( dirname( __FILE__ ) . '/../' ) );

defined( 'TEST_PATH' ) || define( 'TEST_PATH', realpath( dirname( __FILE__ ) ) );

$_SERVER[ 'ENVIRONMENT' ] = 'test';

define( 'PDF_RESOURCES_IMAGES', APPLICATION_PATH . '/images' );

// Ensure library/ is on include_path
set_include_path( implode( PATH_SEPARATOR, array(
    realpath( APPLICATION_PATH . '/classes' ),
    get_include_path()
) ) );


require 'BaseTestCase.php';
require 'BaseExamplesTestCase.php';
require_once( APPLICATION_PATH . "/classes/pdf.php" );
require_once( APPLICATION_PATH . "/classes/pdftable.php" );
require_once( APPLICATION_PATH . "/pdfFactory.php" );

