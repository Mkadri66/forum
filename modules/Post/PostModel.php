<?php
/**
 * This file is part of the framework
 *
 * The PostModel class
 *
 * @package POST
 * @copyright ©2018 tous droits réservés
 * @author Damien TIVELET
 */
class PostModel extends KernelModel {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
     */
    const ALL = '-1';
    const TYPE = 'post';

    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
     */
    /**
     * get Performs a database query to select all or a specific post
     * @param  integer|null     $id     The id of a post
     * @return array                    The result of the query
     */
    public function get( $id = null ) {
        if( !empty( $id ) ) :
            $query = '';

            return $this->query(
                $query,
                array(
                    'id'    => array(
                        'VAL'   => $id,
                        'TYPE'  => PDO::PARAM_INT
                    )
                )
            );

        else:
            $query = '';

            return $this->query(
                $query,
                array(),
                array(
                    self::ATTR_RETURNMODE   => self::RETURNMODE_FETCHALL
                )
            );
        endif;
    }

    /**
     * add Performs a database query to insert a post
     * @param  array            $post   The datas to insert
     * @param  string           $author The author of the post
     * @return integer|boolean          The last insert id if is numeric and with auto increment, boolean if not
     */
    public function add( $post, $author ) {}

    /**
     * update Performs a database query to update a post
     * @param  array            $post   The datas to insert
     * @param  string           $author The author of the update
     * @return integer|boolean          The last insert id if is numeric and with auto increment, boolean if not
     */
    public function update( $post, $author ) {}

    /**
     * delete Performs a database query to delete a post
     * @param  integer          $post   The datas to insert
     * @param  string           $author The author of the removal
     * @return integer|boolean          The last insert id if is numeric and with auto increment, boolean if not
     */
    public function delete( $post, $author ) {}
}