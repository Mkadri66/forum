<?php
header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found' );
require_once( 'ini.php' );

$title = 'Erreur 404';
?>
<!DOCTYPE html>
<html<?php language_attributes(); ?>>
    <head>
        <meta charset="<?php app_info( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <title><?php echo ( isset( $title ) ? $title . ( defined( 'TITLE_SEPARATOR' ) ? TITLE_SEPARATOR : '' ) : '' ) . get_app_info( 'app_name' ); ?></title>

        <style type="text/css">
            <!--
            @import url('<?php echo get_stylesheet_uri( false, 'default' ); ?>');
            -->
        </style>
    </head>
    <body>
        <header role="banner">
            <hgroup>
                <h1><?php echo _( 'Error' ); ?> 404</h1>
                <hr>
                <h2><?php echo _( 'Page not found' ); ?></h2>
            </hgroup>
        </header>

        <main role="main">
            <article role="article">
                <header>
                    <img alt="" src="<?php echo get_assets_directory_uri( 'default' ); ?>images/errors/404.png" style="float:left;margin:0 25px 25px 0;margin:0 2.5rem 2.5rem 0;max-width:150px;max-width:15rem;">
                    <h3><?php echo _( 'You are lost !' ); ?></h3>
                </header>

                <div class="content">
                    <p><?php echo _( 'They can\'t all be winners ... try again.' ); ?></p>
                    <p><small><?php printf( _( 'The requested URL could not be found on this server.<br>If you entered the URL manually, please check it and try again.<br>If you think this is a server error, please <a href="mailto:%s">contact technical support</a>.' ), SUPPORT_EMAIL ); ?></small></p>
                </div>

                <footer>
                    <a class="back" href="<?php app_info( 'home' ); ?>" title=""><?php echo _( 'Back to homepage' ); ?></a></li>
                </footer>
            </article>
        </main>

        <footer role="contentinfo">
            <p><small>&copy;<?php echo date( 'Y' ) . ' ' . get_app_info( 'author' ) . ' - ' . mb_strtolower( _( 'All rights reserved' ) ); ?></small></p>
        </footer>
    </body>
</html>