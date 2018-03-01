<?php
require_once( 'ini.php' );

try {
    SPDO::getInstance()->init( DB_HOST, DB_NAME, DB_LOGIN, DB_PWD );

    /**
     * --------------------------------------------------
     * AUTOROUTING
     * --------------------------------------------------
     */
    NavigationManagement::route( get_app_info('url'), SPDO::getInstance()->getPDO(), SRequest::getInstance(), get_app_info( 'active_theme' ), 'Forum' );

} catch( Exception $e ) {
    if( defined( 'DEBUG' ) && DEBUG )
        if( get_class( $e )=='KernelException' )
            die( $e );
        else
            die( $e->getMessage() );
    else
        NavigationManagement::redirect( DOMAIN . 'error/500/');
}