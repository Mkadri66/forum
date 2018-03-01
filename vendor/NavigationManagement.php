<?php
/**
 * This file is a third-party dependency
 *
 * The NavigationManagement class is a trait used to manage navigation
 *
 * @package {__PACKAGE_NAME__}
 * @copyright {__PACKAGE_LICENSE__}
 * @author {__PACKAGE_AUTHOR__}
 */
trait NavigationManagement {
    /**
     * requestUri
     * @param  string|null  $uri    The URI
     * @return string               The requested URI
     */
    static public function requestUri( $uri = null ) {
        return substr( ( !is_null( $uri ) ? $uri : get_app_info( 'url' ) ), strlen( ( isset( $_SERVER['REQUEST_SCHEME'] ) ? $_SERVER['REQUEST_SCHEME'] : 'http' ) . '://' . $_SERVER['SERVER_NAME'] . ( !empty( $_SERVER['SERVER_PORT'] ) ? ':' . $_SERVER['SERVER_PORT'] : '' ) ) );
    }

    /**
     * redirect Manages redirection
     * @param  string   $uri    The URI where redirect to
     * @return void
     */
    static public function redirect( $uri = 'error/404/' ) {
        header( 'Location:' . $uri );
        exit;
    }

    /**
     * walks Defines the walks
     * @param  string|null  $base_uri   The base URI
     * @return array                    The walks from base URI to current script
     */
    static public function walks( $base_uri = null ) {
        $request_uri = ( strlen( $_SERVER['QUERY_STRING'] )>0 ? substr( $_SERVER['REQUEST_URI'], 0, ( ( strlen( $_SERVER['QUERY_STRING'] ) * (-1) ) - 1 ) ) : $_SERVER['REQUEST_URI'] );
        return array_values( array_diff( explode( '/', $request_uri ), explode( '/', $base_uri ) ) );
    }

    /**
     * clean Cleans the walks
     * @param  string   $walk   The walk to clean
     * @return string           The cleaned walk
     */
    static public function clean( $walk ) {
        return str_replace( ' ', '', ucwords( mb_strtolower( preg_replace( '/(_|-)/', ' ', $walk ) ) ) );
    }

    /**
     * route Defines the route
     * @param  string       $base_uri           The base URI
     * @param  PDO|null     $db                 The database object
     * @param  array|null   $request            The database object
     * @param  string       $theme              The active theme
     * @param  string       $default_controller The default controller name
     * @param  string       $default_action     The default action name
     * @return void
     */
    static public function route( $base_uri, PDO $db = null, $request = null, $theme = 'parent', $default_controller = 'Default', $default_action = 'default' ) {
        try {
            $walks = self::walks( $base_uri );

            if( count( $walks )>0 )
                $class = self::clean( $walks[0] ) . 'Controller'; // Defines the controller's name depending on passed value

            if( !isset( $class ) || !class_exists( $class ) )
                $class = $default_controller . 'Controller'; // Defines the default controller's name

            if( class_exists( $class ) ) :
                $ctrl = new $class( $request ); // Instantiates the controller
                $ctrl->setLayout( $theme );

                if( count( $walks )>1 )
                    $method = self::clean( $walks[1] ) . 'Action'; // Defines the method's name depending on passed value
                elseif( count( $walks )==1 && $class==$default_controller . 'Controller' )
                    $method = self::clean( $walks[0] ) . 'Action'; // Defines the method's name depending on passed value
                else
                    $method = $default_action . 'Action'; // Defines the default method's name

                if( method_exists( $ctrl, 'launcher' ) ) :
                    $ctrl->launcher( $method, $db ); // Calls the launcher
                    exit;
                endif;
            endif;

            throw new KernelException( 'Can not find the route', 1 );
        } catch( Exception $e ) {
            if( defined( 'DEBUG' ) && DEBUG )
                if( get_class( $e )=='KernelException' )
                    die( $e );
                else
                    die( $e->getMessage() );
            else
                if( ( $class==$default_controller . 'Controller' && $method==$default_action . 'Action' ) || $e->getCode()==20 || $e->getPrevious()->getCode()==20 )
                    self::redirect( DOMAIN . 'error/500/');
                else
                    self::redirect( DOMAIN . 'error/404/');
        }
    }

    /**
     * error Manages error messages
     * @param  array|null   $code   The database object
     * @return string               The message of the error
     */
    static public function error( $code ) {
        if( !is_null( $error ) )
            switch( $error ) :
                case 'ok':
                    return _( '<span class="ok">Updating successfully</span>' );
                    break;
                case 'required':
                    return _( '<span class="warning">Please fill all required fields</span>' );
                    break;
                case 'password':
                    return _( '<span class="warning">Password mismatch</span>' );
                    break;
                case 'avatar':
                    return _( '<span class="warning">Avatar can\'t be changed</span>' );
                    break;
                case 'login':
                    return _( '<span class="error">Wrong login or password. Try again</span>' );
                    break;
                default:
                    return _( '<span class="error">An error occured</span>' );
            endswitch;
    }
}