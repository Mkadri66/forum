<?php
/**
 * This file is part of the framework
 *
 * The ClassPost class
 *
 * @package POST
 * @copyright ©2018 tous droits réservés
 * @author Damien TIVELET
 */
class ClassPost {
    use TypeTest;

    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
     */
    // const PREFIX = 'user';
    const DATE_FORMAT = 'Y-m-d';
    const TIME_FORMAT = 'H:i:s';
    const DATETIME_FORMAT = 'Y-m-d H:i:s';
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    */
    /**
     * $_id The id of the post
     * @var integer
     */
    private $_id;
    /**
     * $_title The title of the post
     * @var string
     */
    private $_title;
    /**
     * $_content The content of the post
     * @var string
     */
    private $_content;
    /**
     * $_excerpt The excerpt of the post
     * @var string
     */
    private $_excerpt;
    /**
     * $_release_date The release date of the post
     * @var datetime
     */
    private $_release_date;
    /**
     * $_tab The order of the post in the list
     * @var integer
     */
    private $_tab;
    /**
     * $_type The type of the post
     * @var string
     */
    private $_type;
    /**
     * $_status The status of the post
     * @var string
     */
    private $_status;
    /**
     * $_access The access level of the post
     * @var string
     */
    private $_access;
    /**
     * $_format The format of the post
     * @var string
     */
    private $_format;
    /**
     * $_parent The parent of the post
     * @var integer
     */
    private $_parent;
    /**
     * $_author The author of the post
     * @var string
     */
    private $_author;



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
     */
    /**
     * setId The setter of the "_id" property
     * @param  integer  $value  The id of the post
     * @return void
     */
    public function setId( $value ) {
        if( TypeTest::is_valid_int( $value ) )
            $this->_id = (int)$value;
    }

    /**
     * setTitle The setter of the "_title" property
     * @param  string   $value  The title of the post
     * @return void
     */
    public function setTitle( $value ) {
        $this->_title = $value;
    }

    /**
     * setContent The setter of the "_content" property
     * @param  string   $value  The content of the post
     * @return void
     */
    public function setContent( $value ) {
        $this->_content = $value;
    }

    /**
     * setExcerpt The setter of the "_excerpt" property
     * @param  string   $value  The excerpt of the post
     * @return void
     */
    public function setExcerpt( $value ) {
        $this->_excerpt = $value;
    }

    /**
     * setReleaseDate The setter of the "_release_date" property
     * @param  datetime     $value  The release date of the post
     * @return void
     */
    public function setReleaseDate( $value ) {
        if( TypeTest::is_valid_date( $value ) )
            $this->_release_date = $value;
    }

    /**
     * setTab The setter of the "_tab" property
     * @param  integer  $value  The order of the post in the list
     * @return void
     */
    public function setTab( $value ) {
        if( TypeTest::is_valid_int( $value ) )
            $this->_tab = (int)$value;
    }

    /**
     * setType The setter of the "_type" property
     * @param  string   $value  The type of the post
     * @return void
     */
    public function setType( $value ) {
        $this->_type = $value;
    }

    /**
     * setStatus The setter of the "_status" property
     * @param  string   $value  The status of the post
     * @return void
     */
    public function setStatus( $value ) {
        $this->_status = $value;
    }

    /**
     * setAccess The setter of the "_access" property
     * @param  string   $value  The access level of the post
     * @return void
     */
    public function setAccess( $value ) {
        $this->_access = $value;
    }

    /**
     * setFormat The setter of the "_format" property
     * @param  string   $value  The format of the post
     * @return void
     */
    public function setFormat( $value ) {
        $this->_format = $value;
    }

    /**
     * setParent The setter of the "_parent" property
     * @param  integer  $value  The parent of the post
     * @return void
     */
    public function setParent( $value ) {
        if( TypeTest::is_valid_int( $value ) )
            $this->_parent = (int)$value;
    }

    /**
     * setAuthor The setter of the "_author" property
     * @param  string   $value  The author of the post
     * @return void
     */
    public function setAuthor( $value ) {
        if( filter_var( $value, FILTER_VALIDATE_EMAIL ) )
            $this->_author = strtolower( $value );
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
     */
    /**
     * getId The getter of the "_path" property
     * @return integer The id of the post
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * getTitle The getter of the "_title" property
     * @return string The title of the post
     */
    public function getTitle() {
        return $this->_title;
    }

    /**
     * getContent The getter of the "_content" property
     * @return string The content of the post
     */
    protected function getContent() {
        return $this->_content;
    }

    /**
     * getExcerpt The getter of the "_excerpt" property
     * @return string The excerpt of the post
     */
    public function getExcerpt() {
        return $this->_excerpt;
    }

    /**
     * getReleaseDate The getter of the "_release_date" property
     * @return datetime The release date of the post
     */
    public function getReleaseDate() {
        return $this->_release_date;
    }

    /**
     * getTab The getter of the "_tab" property
     * @return integer The order of the post in the list
     */
    public function getTab() {
        return $this->_tab;
    }

    /**
     * getType The getter of the "_type" property
     * @return string The type of the post
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * getStatus The getter of the "_status" property
     * @return string The status of the post
     */
    public function getStatus() {
        return $this->_status;
    }

    /**
     * getAccess The getter of the "_access" property
     * @return string The access level of the post
     */
    public function getAccess() {
        return $this->_access;
    }

    /**
     * getFormat The getter of the "_format" property
     * @return string The format of the post
     */
    public function getFormat() {
        return $this->_format;
    }

    /**
     * getParent The getter of the "_parent" property
     * @return integer The parent of the post
     */
    public function getParent() {
        return $this->_parent;
    }

    /**
     * getAuthor The getter of the "_author" property
     * @return string The author of the post
     */
    public function getAuthor() {
        return $this->_author;
    }



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
     */
    /**
     * __construct - Class constructor
     * @param  array    $datas  The datas for the object to hydrate
     * @return void
     */
    public function __construct( $datas = array() ) {
        $this->hydrate( $datas );
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
     */
    /**
     * [upload description]
     * @param  array            $file   The informations of the file to upload
     * @param  string           $path   The path to which to upload the file
     * @return array|boolean            The informations about the uploaded file, or false if file can't be uploaded
     */
    static public function upload( $file, $path ) {
        if( !file_exists( $path ) || !is_dir( $path ) )
            mkdir( $path, 0777, true );

        $spl = new SplFileInfo( $file['name'] );
        $extension = $spl->getExtension();
        $currenttimestamp = date( 'Y-m-d H:i:s' );
        $filename = $spl->getBasename( '.' . $extension ) . '_' . preg_replace( '/((?!\d).)*/', '', $currenttimestamp ) . '.' . $extension;

        if( move_uploaded_file( $file['tmp_name'], $path . $filename ) )
            return array(
                'filename'          => $filename,
                'currenttimestamp'  => $currenttimestamp
            );

        return false;
    }

    /**
     * hydrate Sets automatically each properties depending on datas
     * @param  array    $datas  The datas for the object to hydrate
     * @return void
     */
    private function hydrate( $datas ) {
        foreach( $datas as $key=>$value ) :
            // $key = preg_replace( '/^' . self::PREFIX . '_(.+)$/', '$1', $key );
            $key = str_replace( '_', ' ', $key );
            $key = ucwords( $key );
            $key = str_replace( ' ', '', $key );
            $method = 'set' . $key;

            if( method_exists( $this, $method) )
                $this->$method( $value );
        endforeach;
    }
}