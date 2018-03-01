<?php
/**
 * generateDS
 * @param  string   $path   URI
 * @return string
 */
function generateDS( $path ) {
    return ( substr( $path, -1 )!=( defined( 'DS' ) ? DS : DIRECTORY_SEPARATOR ) ? ( defined( 'DS' ) ? DS : DIRECTORY_SEPARATOR ) : '' );
}

/**
 * exploreToInclude Explore directories to include file if exists
 * @param  string   $path   URI to explore
 * @param  string   $file   File to include
 * @return boolean
 */
function exploreToInclude( $path, $file ) {
    $out = false;
    if( file_exists( $path ) && is_dir( $path . generateDS( $path ) ) )
        if( ( $resource = opendir( $path ) )!==false ) :
            while( ( $entry = readdir( $resource ) )!==false )
                if( $entry!='.' && $entry!='..' )
                    if( is_file( $path . generateDS( $path ) . $entry ) )
                        if( $entry==$file ) :
                            require_once( $path . generateDS( $path ) . $file );
                            return true;
                        endif;
                    elseif( is_dir( $path . generateDS( $path ) . $entry . generateDS( $entry ) ) )
                        if( ( $out = exploreToInclude( $path . generateDS( $path ) . $entry . generateDS( $entry ), $file ) )===true )
                            return true;

            closedir( $resource );
        endif;

    if( !isset( $out ) || !$out )
        return false;
}

/**
 * loadKernel Checks whether a file exists and includes it
 * @param  string   $className  Name of instantiated class
 * @return
 */
function loadKernel( $className ) {
    $file = ( defined( 'APPPATH' ) ? APPPATH : '' ) . $className . '.php';

    if( file_exists( $file ) )
        require_once( $file );
}

/**
 * loadVendor Checks whether a file exists and includes it
 * @param  string   $className  Name of instantiated class
 * @return
 */
function loadVendor( $className ) {
    $file = ( defined( 'VENDORPATH' ) ? VENDORPATH : '' ) . $className . '.php';

    if( file_exists( $file ) )
        require_once( $file );
}

/**
 * loadModules Checks whether a file exists and includes it
 * @param  string   $className  Name of instantiated class
 * @return
 */
function loadModules( $className ) {
    $path = ( defined( 'MODULESPATH' ) ? MODULESPATH : '' );
    $file = $className . '.php';

    if( file_exists( $path . $file ) )
        require_once( $path . $file );
    else
        exploreToInclude( $path, $file );
}

spl_autoload_register( 'loadVendor' ); // Registers "loadVendor" function as __autoload() implementation
spl_autoload_register( 'loadKernel' ); // Registers "loadVendor" function as __autoload() implementation
spl_autoload_register( 'loadModules' ); // Registers "loadModules" function as __autoload() implementation