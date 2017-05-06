<?php

$BASE_PATH = realpath( __DIR__ );
/**
 * @param $class
 */
function autoLoadVendor( $class )
{
    global $BASE_PATH;
    $filename = $BASE_PATH . '/vendor/' . str_replace( '\\', '/', $class ) . '.php';
    require( $filename );
}

spl_autoload_register( 'autoLoadVendor' );
