<?php
/**
 * app_info Displays information about the current app
 * @param  string   $show   The code of the information to show
 * @return void
 */
function app_info( $show = '' ) {
    echo get_app_info( $show );
}

/**
 * get_app_info Retrieves information about the current app
 * @param  string   $show   The code of the information
 * @return mixed            The information
 */
function get_app_info( $show = '' ) {
    switch( $show ) :
        case 'url':
        case 'home':
            return get_home_url();
            break;
        case 'charset':
            return get_option( 'charset', 'UTF-8' );
            break;
        case 'language':
            return get_option( 'language', 'en' );
            break;
        case 'text_direction':
            if( function_exists( 'is_rtl' ) )
                return ( is_rtl() ? 'rtl' : 'ltr' );
            else
                return 'ltr';
            break;
        case 'app_name':
            return get_option( 'app_name' );
            break;
        case 'app_description':
            return get_option( 'app_description' );
            break;
        case 'stylesheet_url':
            return get_stylesheet_uri( false );
            break;
        case 'admin_stylesheet_url':
            return get_stylesheet_uri( true );
            break;
        case 'assets_directory':
            return get_assets_directory_uri();
            break;
        case 'author':
            return get_option( 'author' );
            break;
        case 'support_email':
            return get_option( 'support_email' );
            break;
        case 'pagination':
            return get_option( 'pagination', 12 );
            break;
        case 'default_theme':
            return get_option( 'default_theme', DEFAULT_THEME );
            break;
        case 'active_theme':
            return get_option( 'active_theme', DEFAULT_THEME );
            break;
    endswitch;
}

/**
 * get_home_url Retrieves the URL for the current app where the front end is accessible
 * @return string   The URL for the current app where the front end is accessible
 */
function get_home_url() {
    return DOMAIN;
}

/**
 * get_uploads_url Retrieves the URL for the uploads dir
 * @return string   The URL for the uploads dir
 */
function get_uploads_url() {
    return UPLOADS_URL;
}

/**
 * get_option Retrieves an option value based on an option name
 * @param  string   $option     The option name
 * @param  boolean  $default    The default value
 * @return mixed                The option value
 */
function get_option( $option, $default = false ) {
    if( empty( $option ) )
        return false;

    switch( $option ) :
        case 'charset':
            return defined( 'CHARSET' ) ? CHARSET : $default;
            break;
        case 'language':
            $output = defined( 'ISO_LANGUAGE_CODE' ) ? ISO_LANGUAGE_CODE : $default;
            return str_replace( '_', '-', $output );
            break;
        case 'app_name':
            return defined( 'SITE_TITLE' ) ? SITE_TITLE : '';
            break;
        case 'app_description':
            return defined( 'DESCRIPTION' ) ? DESCRIPTION : '';
            break;
        case 'author':
            return defined( 'AUTHOR_NAME' ) ? AUTHOR_NAME : $default;
            break;
        case 'support_email':
            return defined( 'SUPPORT_EMAIL' ) ? SUPPORT_EMAIL : $default;
            break;
        case 'pagination':
            return defined( 'RESULTS_PER_PAGE' ) ? RESULTS_PER_PAGE : $default;
            break;
        case 'default_theme':
            return defined( 'DEFAULT_THEME' ) ? DEFAULT_THEME : $default;
            break;
        case 'active_theme':
            return defined( 'ACTIVE_THEME' ) ? ACTIVE_THEME : $default;
            break;
    endswitch;
}

/**
 * get_stylesheet_uri Retrieves the URI of current theme stylesheet
 * @param  boolean  $backend    Indicates whether the backend stylesheet is requested
 * @param  string  $theme       Active or default theme
 * @return string               The URI of theme stylesheet
 */
function get_stylesheet_uri( $backend = false, $theme = 'active' ) {
    return ( $backend && file_exists( THEMEPATH . get_app_info( $theme . '_theme' ) . DS . 'admin.css' ) ? THEMES_URL . get_app_info( $theme . '_theme' ) . '/admin.css' : THEMES_URL . get_app_info( $theme . '_theme' ) . '/style.css' );
}

/**
 * get_assets_directory_uri - Retrieves the URI of current theme stylesheet
 * @param  string   $theme  Active or default theme
 * @return string           The assets directory URI for the selected theme
**/
function get_assets_directory_uri( $theme = 'active' ) {
    return ( file_exists( THEMEPATH . get_app_info( $theme . '_theme' ) . DS ) ? THEMES_URL . get_app_info( $theme . '_theme' ) . '/' : THEMES_URL . get_app_info( 'default_theme' ) . '/' );
}

/**
 * language_attributes Displays the language attributes for the html tag
 * @param  string   $doctype    The language which is used
 * @return void
 */
function language_attributes( $doctype = 'html' ) {
    echo get_language_attributes( $doctype );
}

/**
 * get_language_attributes Gets the language attributes for the html tag
 * @param  string   $doctype    The language which is used
 * @return string               The attribute's formatted string
 */
function get_language_attributes( $doctype = 'html' ) {
    $attributes = array();

    if( function_exists( 'is_rtl' ) && is_rtl() )
        $attributes[] = 'dir="rtl"';

    if( ( $lang = get_app_info( 'language' ) )!==false ) :
        if( $doctype == 'html' )
            $attributes[] = 'lang="' . $lang . '"';

        if( $doctype == 'xhtml' )
            $attributes[] = 'xmlns="http://www.w3.org/1999/xhtml" lang="' . $lang . '" xml:lang="' . $lang / '"';
    endif;

    return ' ' . implode( ' ', $attributes );
}

/**
 * is_current_menu_item Defines if the current menu item is the current page
 * @param  string   $uri    The URI to test
 * @return boolean
 */
function is_current_menu_item( $uri ) {
    if( NavigationManagement::requestUri()==$_SERVER['REQUEST_URI'] )
        $walks = array_diff( explode( '/', NavigationManagement::requestUri( $uri ) ), explode( '/', $_SERVER['REQUEST_URI'] ) );
    else
        $walks = array_diff( explode( '/', $_SERVER['REQUEST_URI'] ), explode( '/', NavigationManagement::requestUri( $uri ) ) );

    return empty( $walks );
}

/**
 * display_error Displays error message
 * @return void
 */
function display_error() {
    echo NavigationManagement::error( SRequest::getInstance()->get( '_err' ) );
}