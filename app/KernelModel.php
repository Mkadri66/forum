<?php
/**
 * This file is part of the framework
 *
 * The KernelModel class
 *
 * @package {__PACKAGE_NAME__}
 * @copyright {__PACKAGE_LICENSE__}
 * @author {__PACKAGE_AUTHOR__}
 */
abstract class KernelModel {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
     */
    const ATTR_RETURNMODE = 'returningOption';
    const RETURNMODE_LASTINSERTID = 'lastInstertId';
    const RETURNMODE_ROWCOUNT = 'rowCount';
    const RETURNMODE_FETCHALL = 'fetchAll';

    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
     */
    /**
     * $_model The name of the called model
     * @var string
     */
    private $_model;
    /**
     * $_db The connexion to the database
     * @var PDO
     */
    private $_db;



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
     */
    /**
     * getModel The getter of the "_model" property
     * @return string   The name of the called model
     */
    protected function getModel() {
        return $this->_model;
    }

    /**
     * getDB The getter of the "_db" property
     * @return PDO  The connexion to the database
     */
    protected function getDB() {
        return $this->_db;
    }



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
     */
    /**
     * __construct Class constructor
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function __construct( PDO $db = null ) {
        $this->_model = substr( get_class( $this ), 0, strlen( 'Model' )*(-1) );

        if( !is_null( $db ) )
            $this->_db = $db;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
     */
    /**
     * increaseGroupConcatMaxLen Performs a query on database for the session
     * @param  integer  $number     The group concat max length
     * @return boolean              The result of the query
     */
    protected function increaseGroupConcatMaxLen( int $number = 1024 ) {
        return $this->query( 'SET SESSION group_concat_max_len = :increase', array( 'increase' => array( 'VAL' => $number, 'TYPE' => PDO::PARAM_INT ) ) ); // CAUTION: GROUP_CONCAT() truncates the number of results based on the value of a MySQL constant (group_concat_max_len, which is set to 1024 bits by default). This value should be increased (globally with GLOBAL or only for the session with SESSION) thanks to this query
    }

    /**
     * query Performs a database query
     * @param  string   $str        The query string with optional markers
     * @param  array    $values     The values to bind in the query
     * @param  array    $options    The options for the query
     * @return mixed                The result of the query
     */
    protected function query( $str, array $values = array(), array $options = array() ) {
        try {
            if( count( $values )>0 )
                if( ( $stmt = $this->_db->prepare( $str ) )!==false ) :
                    $ctrl = true;
                    foreach( $values as $key => $value ) :
                        if( ( $ctrl = $stmt->bindValue( $key, $value['VAL'], ( isset( $value['TYPE'] ) ? $value['TYPE'] : PDO::PARAM_STR ) ) )===false )
                            break;

                    endforeach;

                    if( $ctrl && ( $out = $stmt->execute() ) ) :
                        switch( strtoupper( substr( $str, 0, 6 ) ) ) :
                            case 'SELECT':
                                $result_set = $stmt->fetchAll( PDO::FETCH_ASSOC );
                                $stmt->closeCursor();

                                return ( count( $result_set )>1 || ( isset( $options[self::ATTR_RETURNMODE] ) && $options[self::ATTR_RETURNMODE]==self::RETURNMODE_FETCHALL ) ? $result_set : ( count( $result_set )>0 ? $result_set[0] : array() ) );
                                break;
                            case 'INSERT':
                                $stmt->closeCursor();
                                return ( isset( $options[self::ATTR_RETURNMODE] ) && $options[self::ATTR_RETURNMODE]==self::RETURNMODE_LASTINSERTID ? $this->_db->lastInsertId() : $out );
                                break;
                            default:
                                $result_set = $stmt->rowCount();
                                $stmt->closeCursor();
                                return ( isset( $options[self::ATTR_RETURNMODE] ) && $options[self::ATTR_RETURNMODE]==self::RETURNMODE_ROWCOUNT ? $result_set : $out );
                        endswitch;
                    endif;
                endif;
            else
                switch( strtoupper( substr( $str, 0, 6 ) ) ) :
                    case 'SELECT':
                        if( ( $stmt = $this->_db->query( $str ) )!==false ) :
                            $result_set = $stmt->fetchAll( PDO::FETCH_ASSOC );
                            $stmt->closeCursor();

                            return ( count( $result_set )>1 || ( isset( $options[self::ATTR_RETURNMODE] ) && $options[self::ATTR_RETURNMODE]==self::RETURNMODE_FETCHALL ) ? $result_set : ( count( $result_set )>0 ? $result_set[0] : array() ) );
                        endif;
                        break;
                    case 'INSERT':
                        if( ( $stmt = $this->_db->query( $str ) )!==false ) :
                            $stmt->closeCursor();
                            return ( isset( $options[self::ATTR_RETURNMODE] ) && $options[self::ATTR_RETURNMODE]==self::RETURNMODE_LASTINSERTID ? $this->_db->lastInsertId() : true );
                        endif;
                        break;
                    default:
                        if( ( $stmt = $this->_db->exec( $str ) )!==false )
                            return ( isset( $options[self::ATTR_RETURNMODE] ) && $options[self::ATTR_RETURNMODE]==self::RETURNMODE_ROWCOUNT ? $stmt : true );
                endswitch;

            return false;
        } catch( PDOException $e ) {
            throw new KernelException( 'An error occurred in the ' . get_class( $this ) . ' model during the request "' . $str . '" with values ' . implode( $values ), 100, $e );
        }
    }
}