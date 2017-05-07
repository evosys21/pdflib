<?php

// Define path to application directory
defined( 'APPLICATION_PATH' ) || define( 'APPLICATION_PATH', realpath( __DIR__ . '/../' ) );

defined( 'TEST_PATH' ) || define( 'TEST_PATH', realpath( __DIR__ ) );

$_SERVER[ 'ENVIRONMENT' ] = 'test';

define( 'PDF_RESOURCES_IMAGES', APPLICATION_PATH . '/images' );

// Ensure library/ is on include_path
set_include_path( implode( PATH_SEPARATOR, array(
    realpath( APPLICATION_PATH . '/classes' ),
    get_include_path()
) ) );

require '../autoload.php';

require 'BaseTestCase.php';
require 'BaseExamplesTestCase.php';
