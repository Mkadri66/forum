<?php
/**
 * This file is part of the framework
 *
 * The ForumController class is used to manage conservations
 *
 * @package FORUM
 * @copyright ©2018 tous droits réservés
 * @author Mustapha Kadri
 */
class ForumController extends KernelController {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
     */
    const PAGE_ID = 'conversation';
    const PAGE_TITLE = 'Conservations';

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

        if( !empty( $this->getRequest()->session() ) ) {

            header( 'Location: ./forum/list' ); 
        }

        if( empty( $this->getRequest()->session() ) ) {
            if( isset( $this->getRequest()->post()['prenom'] ) &&  $this->getRequest()->post()['prenom'] !=="" &&  isset( $this->getRequest()->post()['mail'] ) && $this->getRequest()->post( )['mail'] !=="") {
                // affectation des posts
                $mail = $this->getRequest()->post()['mail'];
                $prenom = $this->getRequest()->post()['prenom'];

                //on verifie que l'utilisateur existe et qu'il a le bon mot de passe
                $user = $this->getModel()->verifyUser($mail, $prenom); 

                if( !empty($this->getModel()->verifyUser($mail, $prenom) ) ) {
                    // Si l'utilisateur existe on stocke les données en session 
                    $this->getRequest()->session('id',  $user['u_id']); 
                    header( 'Location: ./forum/list' ); 
                } else {
                    $message = '<br><br><p class="alert alert-danger col-lg-4 offset-lg-4 text-center" role="alert" > Cette utilisateur n existe pas </p>';
                }
            } else {
                    $message = '<br><br><p class="alert alert-danger col-lg-4 offset-lg-4 text-center" role="alert" > Veuillez remplir tous les champs </p>';
            }
        } 

        $this->setProperty( 'message', ( isset( $message) ? $message : '' )  );
        $this->setProperty( 'ariane', $this->ariane( _( self::PAGE_TITLE ) ) );
        $this->render( true );   
    }

    

    /**
     * listAction Displays the conservation list view
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function listAction( PDO $db = null ) {
        $this->init(  __FILE__, __FUNCTION__, $db ); // Adds third paramater for database usage

        if( empty( $this->getRequest()->session() ) ) {

            header( 'Location: '. DOMAIN . '' ); 
        }

       foreach( $this->getModel()->list() as $conversation ) {
            $conversation = new ClassConversation( $conversation );  
            if( $conversation->getTermine() ) {
                $conversations =  ( isset( $conversations ) ? $conversations : '' ) . 
                '<tr style=" background-color: #FFDDDD; " >
                    <td> ' . $conversation->getId() . '</td> 
                    <td> ' . $conversation->getDate() . '</td>
                    <td> ' . $conversation->getHeure()  . '</td>
                    <td> ' . $conversation->getMessages() . '</td>
                    <td><a href= "'. DOMAIN .'forum/conversation/' . $conversation->getId(). '/"> Voir la fiche </a> </td>
                </tr>
                ' ;          
            } else {

                $conversations =  ( isset( $conversations ) ? $conversations : '' ) . 
                '<tr style=" background-color: #DDFFDD; " >
                    <td> ' . $conversation->getId() . '</td> 
                    <td> ' . $conversation->getDate() . '</td>
                    <td> ' . $conversation->getHeure()  . ' </td>
                    <td> ' . $conversation->getMessages() . '</td>
                    <td><a href= "'. DOMAIN .'forum/conversation/' . $conversation->getId(). '/"> Voir la fiche </a> </td>
                </tr>
                ' ;
            }   

        };
        $this->setProperty( 'conversations', '<tbody>' . ( isset( $conversations ) ? $conversations : '' ) . '</tbody>' );   
        $this->render( true );

    }

    /**
     * conversationAction Show by conservation
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function conversationAction( PDO $db = null ) {
        $this->init(  __FILE__, __FUNCTION__, $db ); // Adds third paramater for database usage

        if( empty( $this->getRequest()->session() ) ) {

            header( 'Location: '. DOMAIN . '' ); 
        }

        $pas = NavigationManagement::walks(DOMAIN);
        switch( count($pas) ) {
            case 3: 
            $id = $pas[ count($pas)-1 ];
            $maPageActuelle = 1; // recupere le dernier pas ici 4 - 1 on peut recuperer l'id
            break;
            case 4: // dans le cas ou on à la pagination
            $id = $pas[ count($pas) -2 ];
            $maPageActuelle =  $pas[ count($pas)-1 ] ;
            break;
        }
        // Gestion de l'ajout de message 


         $utilisateur = $this->getModel()->getUser( $this->getRequest()->session()['id'] );
        // var_dump( $id );

        if( isset( $this->getRequest()->post()['message'] ) && $this->getRequest()->post()['message']!=='' ) {
            $this->getModel()->insertMessage($this->getRequest()->post()['message'] ,$utilisateur['u_id'], $id);
        }

        // Garder le tri durant le changement de page 

        if( isset( $this->getRequest()->post( )['tri'] ) ) {

            $tri = $this->getRequest()->post( )['tri'];
        }
            elseif( isset( $this->getRequest()->get( )['tri'] ) )  {
                  $tri = $this->getRequest()->get( )['tri'];
            }
        
        else {
            $tri = 'date';
        }

        $offset = ( $maPageActuelle * PAGINATE ) - PAGINATE;  

       foreach( $this->getModel()->showConversation( $id, $offset , $tri ) as $conversation ) {
            $conversation = new ClassMessage( $conversation );
    
            $messages = ( isset( $messages) ? $messages : '' ) . 
            '<tr>
            <td> ' . $conversation->getId()  .'</td>
            <td> ' . $conversation->getDate()  . ' </td>
            <td> ' . $conversation->getHeure() .  ' </td>
            <td> ' . $conversation->getAuteur() . '</td>
            <td> ' . $conversation->getContenu() . ' </td>      
            </tr>';
        }     

        $this->setProperty( 'messages', '<tbody>' . ( isset( $messages ) ? $messages : '' ) . '</tobdy>' );
        
        $this->setProperty( 'id',  ( isset( $id) ? $id : '' ) );

        $this->setProperty( 'maPageActuelle',  ( isset( $maPageActuelle) ? $maPageActuelle : '' ) );

        $this->setProperty( 'PageSuivante',  ( isset( $pageSuivante ) ? $pageSuivante : '' ) );

        $this->setProperty( 'tri',  ( isset( $tri ) ? $tri: '' ) );

        $this->render( true );

    }
    /**
     * createUserAction Show by conservation
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function createUserAction( PDO $db = null ) {
        $this->init(  __FILE__, __FUNCTION__, $db ); // Adds third paramater for database usage
       
    
         if(isset($this->getRequest()->post()['mail']) && $this->getRequest()->post()['mail']!=="" && isset($this->getRequest()->post()['prenom']) &&  $this->getRequest()->post()['prenom']!=="" && isset($this->getRequest()->post()['nom']) && $this->getRequest()->post()['nom']!=="" && isset($this->getRequest()->post()['date_naissance']) && $this->getRequest()->post()['date_naissance']!=='' ) {
            $this->getModel()->insertUser( $this->getRequest()->post()['mail'], $this->getRequest()->post( )['prenom'], $this->getRequest()->post( )['nom'], $this->getRequest()->post( )['date_naissance'] );
            $message = '<br><br><p class="alert alert-success col-lg-4 text-center" role="alert" >Votre inscription a bien été prise en compte.</p>';
           
        }  else {
            $message = '<br><br><p class="alert alert-danger col-lg-4 text-center" role="alert" > Veuillez remplir tous les champs </p>';
        }
           

        

        $this->setProperty( 'message', ( isset( $message) ? $message : '' )  );
        $this->setProperty( 'ariane', $this->ariane( _( self::PAGE_TITLE ) ) );
        $this->render( true );

        
     
    }
    /**
     * addConversationAction
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function addConversationAction( PDO $db = null ) {
        $this->init(  __FILE__, __FUNCTION__, $db ); // Adds third paramater for database usage
        $this->setProperty( 'message', ( isset( $message) ? $message : '' )  );
        $this->setProperty( 'ariane', $this->ariane( _( self::PAGE_TITLE ) ) );
        $this->render( true );

        
     
    }

     /**
     * deconnectAction Show by conservation
     * @param  PDO|null     $db     The database object
     * @return void
     */
    public function deconnectAction( PDO $db = null ) {
        $this->init(  __FILE__, __FUNCTION__, $db ); // Adds third paramater for database usage
        $this->getRequest()->unset(session, 'id');
        if( empty( $this->getRequest()->session() ) ) {

            header( 'Location: '. DOMAIN . '' ); 
        }


        $this->setProperty( 'tri',  ( isset( $tri ) ? $tri: '' ) );

        $this->render( true );

    }



    
}