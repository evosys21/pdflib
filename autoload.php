<?php

if ( !defined( 'PDF_APPLICATION_PATH' ) ) {
    define( 'PDF_APPLICATION_PATH', __DIR__ );
}

if ( !defined( 'PDF_RESOURCES_IMAGES' ) ) {
    define( 'PDF_RESOURCES_IMAGES', __DIR__ . '/images' );
}

$BASE_PATH = realpath( __DIR__ );
/**
 * @param $class
 */
function autoLoadVendor( $class )
{
    global $BASE_PATH;
    $filename = $BASE_PATH . '/vendor/' . str_replace( '\\', '/', $class ) . '.php';
    if ( !file_exists( $filename ) ) {
        echo "<pre>";
        debug_print_backtrace();
        echo "</pre>";
    }
    require( $filename );
}

spl_autoload_register( 'autoLoadVendor' );
