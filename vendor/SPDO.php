<?php
/**
 * This file is a third-party dependency
 *
 * The SPDO class is used to restricts the instantiation of a PDO class to one object
 *
 * @package {__PACKAGE_NAME__}
 * @copyright {__PACKAGE_LICENSE__}
 * @author {__PACKAGE_AUTHOR__}
 */
class SPDO {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
     */
    /**
     * $_db The connexion to the database
     * @var PDO
     */
    private $_db;
    /**
     * $_engine The engine of the database
     * @var string
     */
    private $_engine;
    /**
     * $_host The host of the database
     * @var string
     */
    private $_host;
    /**
     * $_dbname The name of the database
     * @var string
     */
    private $_dbname;
    /**
     * $_login The username authorized to access the database
     * @var string
     */
    private $_login;
    /**
     * $_pwd The password associated to the username authorized to access the database
     * @var string
     */
    private $_pwd;
    /**
     * $_charset The charset
     * @var string
     */
    private $_charset;
    /**
     * $_collate The collate
     * @var string
     */
    private $_collate;
    /**
     * --------------------------------------------------
     * STATICS
     * --------------------------------------------------
     */
    /**
     * $_instance The unique instance
     * @var SPDO
     */
    static private $_instance;



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
     */
    /**
     * getPDO The getter of the "_db" property
     * @return PDO  The connexion to the database
     */
    public function getPDO() {
        return $this->_db;
    }



    /**
     * --------------------------------------------------
     * STATIC METHODS
     * --------------------------------------------------
     */
    /**
     * getInstance The getter of the "_instance" static property
     * @return SPDO     The instance of SPDO
     */
    static public function getInstance() {
        if( !isset( self::$_instance ) )
            self::$_instance = new self;

        return self::$_instance;
    }



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
     */
    /**
     * __construct Class constructor
     * @return void
     */
    private function __construct() {}



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
     */
    /**
     * init Initializes the instance
     * @param  string   $host       The host of the database
     * @param  string   $dbname     The name of the database
     * @param  string   $login      The username authorized to access the database
     * @param  string   $pwd        The password associated to the username authorized to access the database
     * @param  string   $charset    The charset
     * @param  string   $collate    The collate
     * @param  string   $engine     The engine of the database
     * @return void
     */
    public function init( $host, $dbname, $login, $pwd, $charset = 'utf8mb4', $collate = 'utf8mb4_general_ci', $engine = 'mysql' ) {
        try {
            $this->_engine = $engine;
            $this->_host = $host;
            $this->_dbname = $dbname;
            $this->_login = $login;
            $this->_pwd = $pwd;
            $this->_charset = $charset;
            $this->_collate = $collate;

            $this->_db = new PDO( $this->_engine . ':host=' . $this->_host . ';dbname=' . $this->_dbname . ';charset=' . $this->_charset, $this->_login, $this->_pass, array( PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES ' . $this->_charset . ' COLLATE ' . $this->_collate, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION ) );
        } catch( PDOException $e ) {
            throw $e;
        }
    }
}