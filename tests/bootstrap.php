<?php

// Define path to application directory
defined( 'APPLICATION_PATH' ) || define( 'APPLICATION_PATH', realpath( __DIR__ . '/../' ) );

defined( 'TEST_PATH' ) || define( 'TEST_PATH', realpath( __DIR__ ) );
$_SERVER[ 'ENVIRONMENT' ] = 'test';

define( 'PDF_RESOURCES_IMAGES', APPLICATION_PATH . '/content/images' );

date_default_timezone_set( "Europe/Zurich" );


require_once __DIR__ . '/../vendor/autoload.php';

require 'BaseTestCase.php';
require 'BaseExamplesTestCase.php';
