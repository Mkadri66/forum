<?php
/**
 * This file is part of the framework
 *
 * The KernelException class
 *
 * @package {__PACKAGE_NAME__}
 * @copyright {__PACKAGE_LICENSE__}
 * @author {__PACKAGE_AUTHOR__}
 */
class KernelException extends Exception {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
     */
    const DEBUG_MODE = FALSE;
    const STYLE = '
<style>
    <!--
    .alert {
        background-color:orange;
        color:white;
        display:inline-block;
        padding:10px;padding:1rem;
        position:relative;
        vertical-align:top;
    }
    .alert::before {content:"/!\\ ";}
        .alert a { color:white; }
        .alert hr {
            border:none;
            border-bottom:#ffffff thin solid;
        }

    .debug {
        display:block;
        margin-top:25px;margin-top:2.5rem;
    }
    -->
</style>';
    /**
     * --------------------------------------------------
     * STATICS
     * --------------------------------------------------
     */
    /**
     * $_exceptions The tracking of exceptions
     * @var array
     */
    static private $_exceptions = [];
    static public $_debug_mode = self::DEBUG_MODE;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
     */
    /**
     * [__construct description]
     * @param string         $message  The explanation message of the exception
     * @param integer        $code     The short code of the exception
     * @param Exception|null $previous The previous exception
     */
    public function __construct( $message = '', $code = 0, Exception $previous = null ) {
        parent::__construct( $message, $code, $previous );
        self::$_exceptions[] = $this;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
     */
    public function __toString() {
        $trace = '';
        if( self::$_debug_mode && count( self::$_exceptions )>0 && self::$_exceptions[0]->getPrevious()!==null )
            $trace .= '<hr><p> - An error occured with code <strong>' . self::$_exceptions[0]->getPrevious()->getCode() . '</strong> in <strong>' . basename( self::$_exceptions[0]->getPrevious()->getFile() ) . '</strong> at line <strong>' . self::$_exceptions[0]->getPrevious()->getLine() . '</strong></p><blockquote><p><span style="white-space:nowrap;">The following information has been provided :</span><br><i><small>' . self::$_exceptions[0]->getPrevious()->getMessage() . '</small></i></p></blockquote>';

        foreach( self::$_exceptions as $value )
            $trace .= '<hr><p> - An error occured with code <strong>' . $value->getCode() . '</strong> in <strong>' . basename( $value->getFile() ) . '</strong> at line <strong>' . $value->getLine() . '</strong></p><blockquote><p><span style="white-space:nowrap;">The following information has been provided :</span><br><i><small>' . $value->getMessage() . '</small></i></p></blockquote>';

        return ( $trace!='' ? self::STYLE . '<div class="alert debug"><strong style="text-transform:uppercase;">Trace</strong>' . $trace . '</div>' : '' );
    }
}