<?php
/**
 * This file is part of the framework
 *
 * The PostController class is used to manage posts actions
 *
 * @package POST
 * @copyright ©2018 tous droits réservés
 * @author Damien TIVELET
 */
class PostController extends KernelController {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
     */
    const PAGE_ID = 'post';
    const PAGE_TITLE = 'Articles';

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
        $this->init(  __FILE__, __FUNCTION__, $db ); // Adds third paramater for database usage

        $this->setProperty( 'ariane', $this->ariane( _( self::PAGE_TITLE ) ) );
        $this->render( true );
    }

    /**
     * listAction Displays the posts list view
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function listAction( PDO $db = null ) {
        $this->init(  __FILE__, __FUNCTION__, $db ); // Adds third paramater for database usage

        foreach( $this->getModel()->get() as $post ) :
            $post = new ClassPost( $post );
            $out = ( isset( $out ) ? $out : '' ) . '<li class="' . self::PAGE_ID . '" data-author="' . $post->getAuthor() . '" data-releasedate="' . $post->getReleaseDate() . '"><a href="' . DOMAIN . $this->getBundle() . '/edit/' . $post->getId() . '" title="' . $post->getTitle() . '"><h2>' . $post->getTitle() . '</h2></a></li>';
        endforeach;

        $this->setProperty( 'title', _( 'Posts list' ) );
        $this->setProperty( 'ariane', $this->ariane( array( '<a href="' . ( defined( 'DOMAIN' ) ? DOMAIN : '' ) . '?c=' . strtolower( $this->getBundle() ) . '" title="' . _( self::PAGE_TITLE ) . '">' . _( self::PAGE_TITLE ) . '</a>', ( $this->getProperties( 'title' )!==null ? $this->getProperties( 'title' ) : 'Inconnu' ) ) ) );
        $this->setProperty( 'list', '<ul id="list">' . ( isset( $out ) ? $out : '' ) . '</ul>' );
        $this->render( true );
    }

    /**
     * addAction Displays the post add view
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function addAction( PDO $db = null ) {
        $this->init(  __FILE__, __FUNCTION__, $db ); // Adds third paramater for database usage

        $this->setProperty( 'title', _( 'Add new post' ) );
        $this->setProperty( 'ariane', $this->ariane( array( '<a href="' . ( defined( 'DOMAIN' ) ? DOMAIN : '' ) . '?c=' . strtolower( $this->getBundle() ) . '" title="' . _( self::PAGE_TITLE ) . '">' . _( self::PAGE_TITLE ) . '</a>', ( $this->getProperties( 'title' )!==null ? $this->getProperties( 'title' ) : 'Inconnu' ) ) ) );
        $this->render( true );
    }

    /**
     * addingAction Adds a post
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function addingAction( PDO $db = null ) {
        $this->init(  __FILE__, __FUNCTION__, $db ); // Adds third paramater for database usage
    }

    /**
     * editAction Displays the post edit view
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function editAction( PDO $db = null ) {
        $this->init(  __FILE__, __FUNCTION__, $db ); // Adds third paramater for database usage

        $this->setProperty( 'title', _( 'Edit post' ) );
        $this->setProperty( 'ariane', $this->ariane( array( '<a href="' . ( defined( 'DOMAIN' ) ? DOMAIN : '' ) . '?c=' . strtolower( $this->getBundle() ) . '" title="' . _( self::PAGE_TITLE ) . '">' . _( self::PAGE_TITLE ) . '</a>', ( $this->getProperties( 'title' )!==null ? $this->getProperties( 'title' ) : 'Inconnu' ) ) ) );
        $this->render( true );
    }

    /**
     * updatingAction Updates a post
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function updatingAction( PDO $db = null ) {
        $this->init(  __FILE__, __FUNCTION__, $db ); // Adds third paramater for database usage
    }

    /**
     * deletingAction Deletes a post
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function deletingAction( PDO $db = null ) {
        $this->init(  __FILE__, __FUNCTION__, $db ); // Adds third paramater for database usage
    }
}