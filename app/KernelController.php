<?php
/**
 * This file is part of the framework
 *
 * The KernelController class
 *
 * @package {__PACKAGE_NAME__}
 * @copyright {__PACKAGE_LICENSE__}
 * @author {__PACKAGE_AUTHOR__}
 */
abstract class KernelController {
    use TypeTest;

    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
     */
    /**
     * $_path The path of the called controller
     * @var string
     */
    private $_path;
    /**
     * $_bundle The bundle's name of the called controller
     * @var string
     */
    private $_bundle;
    /**
     * $_controller The name of the called controller
     * @var string
     */
    private $_controller;
    /**
     * $_action The name of the called action
     * @var string
     */
    private $_action;
    /**
     * $_model The name of the model to instanciate
     * @var object
     */
    private $_model;
    /**
     * $_view The name of the view to print
     * @var string
     */
    private $_view;
    /**
     * $_properties The properties to use in the printed view
     * @var string
     */
    private $_properties = [];
    /**
     * $_request The request
     * @var SRequest
     */
    private $_request;



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
     */
    /**
     * setPath The setter of the "_path" property
     * @param  string   $file   The name of the called file
     * @return void
     */
    protected function setPath( $file ) {
        $this->_path = dirname( $file );
    }

    /**
     * setAction The setter of the "_action" property
     * @param  string   $action     The name of the called action
     * @return void
     */
    protected function setAction( $action ) {
        $this->_action = substr( $action, 0, strlen( 'Action' )*(-1) );
    }

    /**
     * setModel The setter of the "_model" property
     * @param  PDO|null     $db     The database object
     * @return void
     */
    protected function setModel( PDO $db = null ) {
        $modelName = $this->_bundle . 'Model';

        if( class_exists( $modelName ) )
            $this->_model = new $modelName( $db );
    }

    /**
     * setLayout The setter of the "_layout" property
     * @param  string   $layout   The URI of the layout
     * @return void
     */
    public function setLayout( $layout = null ) {
        if( !is_null( $layout ) )
            $this->_layout = $layout;
        else
            $this->_layout = $this->getBundle();
    }

    /**
     * setView The setter of the "_view" property
     * @param  string   $view   The URI of the view
     * @return void
     */
    protected function setView( $view = null ) {
        if( !is_null( $view ) )
            $this->_view = $view;
        else
            $this->_view = $this->getAction();
    }

    /**
     * setProperty The setter of the "_properties" property
     * @param  string   $property   The name of the property
     * @param  mixed    $value      The value for the property
     * @return void
     */
    public function setProperty( $property, $value ) {
        $this->_properties[$property] = $value;
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
     */
    /**
     * getPath The getter of the "_path" property
     * @return string   The path of the bundle
     */
    protected function getPath() {
        return $this->_path;
    }

    /**
     * getBundle The getter of the "_bundle" property
     * @return string   The name of the bundle
     */
    protected function getBundle() {
        return $this->_bundle;
    }

    /**
     * getController The getter of the "_controller" property
     * @return string   The name of the controller
     */
    protected function getController() {
        return $this->_controller;
    }

    /**
     * getAction The getter of the "_action" property
     * @return string   The name of the called action
     */
    protected function getAction() {
        return $this->_action;
    }

    /**
     * getModel The getter of the "_model" property
     * @return object   The name of the instantiated model
     */
    protected function getModel() {
        return $this->_model;
    }

    /**
     * getLayout The getter of the "_layout" property
     * @return string   The name of the used layout
     */
    protected function getLayout() {
        return $this->_layout;
    }

    /**
     * getView The getter of the "_view" property
     * @return string   The name of the printed view
     */
    protected function getView() {
        return $this->_view;
    }

    /**
     * getProperties The getter of the "_properties" property
     * @param  string|null  $key    The name of the property
     * @return string               The value contained in the requested key of the properties array, or the properties array if the key is not set, or an empty array if the requested key doesn't exist in the properties array
     */
    protected function getProperties( $key = null ) {
        return ( isset( $key ) ? ( isset( $this->_properties[$key] ) ? $this->_properties[$key] : array() ) : $this->_properties );
    }

    /**
     * getRequest The getter of the "_request" property
     * @return SRequest     The request
     */
    protected function getRequest() {
        return $this->_request;
    }



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
     */
    /**
     * __construct Class constructor
     * @param  SRequest     $request    Request object
     * @return void
     */
    public function __construct( SRequest $request ) {
        $this->_request = $request;
        $this->_controller = get_class( $this );
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
     */
    /**
     * launcher Launches the action
     * @param  string   $action     The name of the called action
     * @param  PDO|null $db         The database object
     * @return void
     */
    public function launcher( $action, PDO $db = null ) {
        if( method_exists( $this, $action ) )
            $this->$action( $db );
        else
            throw new KernelException( 'Can not find the <strong>' . $this->_action . '</strong> specified controller\'s method', 11 );
    }

    /**
     * init Initiates the controller
     * @param  string   $file       The name of the called file
     * @param  string   $action     The name of the called action
     * @param  PDO|null $db         The database object
     * @return void
     */
    protected function init( $file, $action, PDO $db = null ) {
        $this->setPath( $file );
        $this->_bundle = basename( $this->getPath() );
        $this->setAction( $action );

        if( !is_null( $db ) )
            $this->setModel( $db );

        // $this->setLayout();
        $this->setView();
    }

    /**
     * ariane Returns the formatted breadcrumb
     * @param  string|array     $breadcrumb     Elements to integrate into the breadcrumb
     * @return string                           The formatted breadcrumb
     */
    protected function ariane( $breadcrumb ) {
        if( !is_null( $breadcrumb ) )
            $str = '
<nav role="navigation">
    <ul class="menu-ariane">
        <li><a href="' . ( defined( 'DOMAIN' ) ? DOMAIN : '' ) . '" title="Accueil">Accueil</a></li>'
        . ( isset( $breadcrumb ) ? ( is_array( $breadcrumb ) ? '<li>' . implode( '</li><li>', $breadcrumb ) . '</li>' : '<li>' . $breadcrumb . '</li>' ) : '' ) . '
    </ul>
</nav>';

        return ( isset( $str ) ? $str : '' );
    }

    /**
     * render Renders the view
     * @return void
     */
    protected function render( $layout = false ) {
        if( !file_exists( $this->getPath() . DS . 'views' . DS . $this->getView() . '.php' ) )
            throw new KernelException( 'Error in the ' . get_class( $this ) . ' controller during the rendering of the view ' . $this->getView(), 20 );

        if( defined( 'static::PAGE_ID' ) )
            $page_id = static::PAGE_ID;

        extract( $this->getProperties() );

        if( $layout )
            include( ( file_exists( THEMEPATH . $this->getLayout() . DS . 'header.php' ) ? THEMEPATH . $this->getLayout() . DS : DEFAULTTHEMEPATH ) . 'header.php' );

        if( file_exists( $this->getPath() . DS . 'views' . DS . $this->getView() . '.php' ) )
            include( $this->getPath() . DS . 'views' . DS . $this->getView() . '.php' );

        if( $layout )
            include( ( file_exists( THEMEPATH . $this->getLayout() . DS . 'footer.php' ) ? THEMEPATH . $this->getLayout() . DS : DEFAULTTHEMEPATH ) . 'footer.php' );
    }



    /**
     * --------------------------------------------------
     * ACTIONS
     * --------------------------------------------------
     */
    /**
     * defaultAction
     * @return void
     */
    abstract public function defaultAction();
}