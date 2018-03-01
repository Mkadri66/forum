<?php
class ClassConversation {

    private $id;
    private $date;
    private $heure;
    private $termine;
    private $messages;
    private $keys;

    private static $conversations = array();


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
        if( ctype_digit( $id ) ) {
            $this->id = $id;
        }

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
    public function getTermine()
    {
        return $this->termine;
    }

    /**
     * @param mixed $termine
     *
     * @return self
     */
    public function setTermine($termine)
    {
        if( ctype_digit( $termine ) ) {
            $this->termine = $termine;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param mixed $messages
     *
     * @return self
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    public function __construct( $datas ) {
        $this->hydrate( $datas );
        self::$conversations[] = $this;
    }

    private function hydrate( $datas ) {
        foreach( $datas as $key => $value ) {
            $this->keys[] = $key;
            $method = str_replace( ' de la conversation', '', $key );
            $method = str_replace( 'Nombre de ', '', $method );
            $method = str_replace( 'c_', '', $method );
            $method = strtolower( $method );
            $method = ucfirst( $method );
            $method = 'set' . $method;

            if( method_exists( $this, $method ) ) {
                $this->$method( $value );
            }
        }
    }

    private function getCss() {
        if( $this->getTermine()==1 ) {
            return 'opened';
        } else {
            return 'closed';
        }
    }

    public function showThead() {
        echo '
        <thead>
            <tr>';
        foreach( $this->keys as $key ) {
            if( $key!=='c_termine' ) {
                echo '
                <th>' . $key . '</th>';
            }
        }
        echo '
                <th></th>
            </tr>
        </thead>';
    }

    public function showTd() {
        echo '
        <tr class="' . $this->getCss() . '">
            <td>' . $this->getId() . '</td>
            <td>' . $this->getDate() . '</td>
            <td>' . $this->getHeure() . '</td>
            <td>' . $this->getMessages() . '</td>
            <td><a class="link" href="conversation.php?conv=' . $this->getId() . '" title="Conversation n° ' . $this->getId() . '">Voir plus</a></td>
        </tr>';
    }


    public static function showTable() {
        if( isset( self::$conversations) && is_array( self::$conversations ) && count( self::$conversations )>0 ) {
            echo '
            <table border="1">';
            self::$conversations[0]->showThead();
            echo '
                <tbody>';
            foreach( self::$conversations as $conversation ) {
                $conversation->showTd();
            }
            echo '
                </tbody>
            </table>';
        }
    }
}