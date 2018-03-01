<?php
class ClassMessage {
    private $id;
    private $contenu;
    private $date;
    private $heure;
    private $auteur;
    private $conversation;
    private $keys;

    private static $messages = array();

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param mixed $contenu
     *
     * @return self
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * @param mixed $heure
     *
     * @return self
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * @param mixed $auteur
     *
     * @return self
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * @param mixed $conversation
     *
     * @return self
     */
    public function setConversation($conversation)
    {
        $this->conversation = $conversation;

        return $this;
    }

    public function __construct( $datas ) {
        $this->hydrate( $datas );
        self::$messages[] = $this;
    }

    private function hydrate( $datas ) {
        foreach( $datas as $key => $value ) {
            $this->keys[] = $key;
            switch( $key ) {
                case 'Nom Prénom' :
                    $method = 'setAuteur';
                    break;
                case 'Message' :
                    $method = 'setContenu';
                    break;
                default :
                    $method = str_replace( ' du message', '', $key );
                    $method = strtolower( $method );
                    $method = ucfirst( $method );
                    $method = 'set' . $method;
            }

            if( method_exists( $this, $method ) ) {
                $this->$method( $value );
            }
        }
    }

    public function showThead() {
        echo '
        <thead>
            <tr>';
        foreach( $this->keys as $key ) {
            echo '
                <th>' . $key . '</th>';
        }
        echo '
            </tr>
        </thead>';
    }

    public function showTd() {
        echo '
        <tr>
            <td>' . $this->getDate() . '</td>
            <td>' . $this->getHeure() . '</td>
            <td>' . $this->getAuteur() . '</td>
            <td>' . $this->getContenu() . '</td>
        </tr>';
    }


    public static function showTable() {
        if( isset( self::$messages) && is_array( self::$messages ) && count( self::$messages )>0 ) {
            echo '
            <table border="1">';
            self::$messages[0]->showThead();
            echo '
                <tbody>';
            foreach( self::$messages as $message ) {
                $message->showTd();
            }
            echo '
                </tbody>
            </table>';
        } else {
            echo 'Cette conversation est vide pour le moment !';
        }
    }
}