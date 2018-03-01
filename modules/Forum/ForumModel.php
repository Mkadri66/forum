<?php
/**
 * This file is part of the framework
 *
 * The PostModel class
 *
 * @package POST
 * @copyright ©2018 tous droits réservés
 * @author Mustapha Kadri
 */
class ForumModel extends KernelModel {
    
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
     * list Performs a database query to list all conversations
     * @param  integer|null     $id     The id of a post
     * @return array                    The result of the query
     */
    public function list() {

            $query = 'SELECT `c_id` AS `ID de la conversation`, DATE_FORMAT( `c_date`, "%d/%m/%Y" ) AS `Date de la conversation`, DATE_FORMAT( `c_date`, "%T" ) AS `Heure de la conversation`, COUNT( DISTINCT `m_id` ) AS `Nombre de messages`, `c_termine` FROM `conversation` LEFT JOIN `message` ON `conversation`.`c_id`=`message`.`m_conversation_fk` GROUP BY `c_id` ORDER BY `c_id` ASC';

            return $this->query(
                $query
        
            );

    }
    /**
     * showconversation Performs a database query to show conversation by id
     * @param  integer|null     $id     The id of a post
     * @param  integer|null     $index  The index of the query
     * @param  string|null     $tri    The sort for the query
     * @return array                    The result of the query
     */
    public function showconversation( $id , $index = 0, $tri = 'date'  ) {

            switch( $tri ) {
                case 'id':
                    $field = '`m_id` ASC';
                    break;
                case 'auteur':
                    $field = '`u_nom` ASC, `u_prenom` ASC';
                    break;
                case 'date':
                default :
                    $field = '`m_date` DESC , "Heure du message" DESC';
                    break;
            }    
            $query = 'SELECT `m_id` AS `id`,DATE_FORMAT( `m_date`, "%d/%m/%Y" ) AS `Date du message`, DATE_FORMAT( `m_date`, "%T" ) AS `Heure du message`, CONCAT( `user`.`u_nom`, " ", `user`.`u_prenom` ) AS `Nom Prénom`, `m_contenu` AS `Message` FROM `message` LEFT JOIN `user` ON `message`.`m_auteur_fk`=`user`.`u_id` WHERE `m_conversation_fk`=:id  ORDER BY ' . $field .' LIMIT ' . $index . ', ' . PAGINATE ;

            return $this->query(
                $query, 
                array(
                    'id'    => array(
                        'VAL'   => $id,
                        'TYPE'  => PDO::PARAM_INT
                        )
                    )

            );

    }



     /**
     * verifyUser Performs a database query to find a user if exists in the database
     * @param  integer|null     $id     The id of the user
     * @param  integer|null     $prenom The firstname of the user
     * @return array                    The result of the query
     */
    public function verifyUser($mail, $prenom) {

            $query = 'SELECT * FROM `user` WHERE `u_login`=:mail AND `u_prenom`=:prenom';

            return $this->query(
                $query, 
                array(
                    'mail'    => array(
                        'VAL'   => $mail,
                        'TYPE'  => PDO::PARAM_STR
                    ),
                    
                    'prenom'    => array(
                        'VAL'   => $prenom,
                        'TYPE'  => PDO::PARAM_STR
                        )
                    )

            );
            
    }

    /**
     * getUser Performs a database query to get user by id
     * @param  integer|null     $id     The id of a post
     * @return array                    The result of the query
     */
    public function getUser($id) {

            $query = 'SELECT * FROM `user` WHERE `u_id`=:id';

            return $this->query(
                $query, 
                array(
                    'id'    => array(
                        'VAL'   => $id,
                        'TYPE'  => PDO::PARAM_STR
                    )
                )
            );
            
    }

    
     /**
     * insertUser Performs a database to insert an user to the database
     * @param  integer|null     $mail               The mail of the user
     * @param  string|null      $prenom             The firstname of the user
     * @param  string|null      $nom                The name of the user
     * @param  string|null      $date_naissance     The birth date of the user
     * @return void                               
     */
    public function insertUser($mail, $prenom, $nom, $date_naissance) {

            $query = 'INSERT INTO `user`(`u_login`,`u_prenom`,`u_nom`,`u_date_naissance`,`u_date_inscription`,`u_rang_fk`) VALUES (:mail, :prenom , :nom , :date_naissance, NOW() , 3);';
            // gerer en fonction du niveau du rang de l'utilisateur 
            return $this->query(
                $query, 
                array(
                    'mail'    => array(
                        'VAL'   => $mail,
                        'TYPE'  => PDO::PARAM_STR
                    ),
                    
                    'prenom'    => array(
                        'VAL'   => $prenom,
                        'TYPE'  => PDO::PARAM_STR
                    ),
                     

                    'nom'        => array(
                        'VAL'   => $nom,
                        'TYPE'  => PDO::PARAM_STR
                    ),
                    'date_naissance'    => array(
                        'VAL'   => $date_naissance,
                        'TYPE'  => PDO::PARAM_STR
                    )
                    
                )
                    


            );

    }


     /**
     * insertMessage Performs a database to insert a message to the database
     * @param  string|null      $contenu            The content of the message
     * @param  string|null      $auteur             The writter of the message
     * @param  integer|null      $conversation       The id of the conversationS
     * @return void
     */

    public function insertMessage($contenu, $auteur , $conversation) {

            $query = 'INSERT INTO `message`(`m_contenu`,`m_date`,`m_auteur_fk`,`m_conversation_fk`) VALUES (:contenu, NOW(), :auteur, :id_conversation);';
            // gerer en fonction du niveau du rang de l'utilisateur 
            return $this->query(
                $query, 
                array(
                    'contenu'    => array(
                        'VAL'   => $contenu,
                        'TYPE'  => PDO::PARAM_STR
                    ),
                    
                    'auteur'    => array(
                        'VAL'   => $auteur,
                        'TYPE'  => PDO::PARAM_STR
                    ),
                     

                    'id_conversation'        => array(
                        'VAL'   => $conversation,
                        'TYPE'  => PDO::PARAM_STR
                    )
                    
                )
 
            );

    }
 }