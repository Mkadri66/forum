        </main>

        <footer class="container-fluid" role="contentinfo">
            <p><small>&copy;<?php echo date( 'Y' ) . ' ' . get_app_info( 'author' ) . ' - tous droits réservés'; ?></small></p>
            <nav id="secondary-nav">
                <ul class="menus" id="secondary-menu">
                    <li class="menu-item"><a href="<?php app_info( 'url' ); ?>credits/" title="Mentions légales">Mentions légales</a></li>
                </ul>
            </nav>
        </footer>

        <script type="text/javascript">
            /*<![CDATA[*/
            window.addEventListener( 'load', function ( e ) {
                for( var svg of document.querySelectorAll( 'img.svg' ) ) {
                    if( svg.getAttribute( 'data-svg' )!='' && svg.getAttribute( 'data-svg' )!==null )
                        svg.src = svg.getAttribute( 'data-svg' );
                }
            } );
            /*]]>*/
        </script>
    </body>
</html>