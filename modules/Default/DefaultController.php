<?php
/**
 * This file is part of the framework
 *
 * The DefaultController class is used to prevent default actions
 *
 * @package {__PACKAGE_NAME__}
 * @copyright {__PACKAGE_LICENSE__}
 * @author {__PACKAGE_AUTHOR__}
 */
class DefaultController extends KernelController {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
     */
    const PAGE_ID = 'default';
    const PAGE_TITLE = 'Default';

    /**
     * --------------------------------------------------
     * ACTIONS
     * --------------------------------------------------
     */
    /**
     * defaultAction
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function defaultAction( PDO $db = null ) {
        $this->init( __FILE__, __FUNCTION__ ); // Adds third paramater for database usage

        $this->setProperty( 'title', self::PAGE_TITLE );
        $this->setProperty( 'ariane', $this->ariane( _( self::PAGE_TITLE ) ) );
        $this->render( true );
    }
}