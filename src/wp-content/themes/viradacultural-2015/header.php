<?php $paginaprogramacao = get_query_var('virada_tpl'); ?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?> ng-app="virada">
<!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="apple-itunes-app" content="app-id=999520281">
        <meta name="google-play-app" content="app-id=br.com.lfdb.viradapp">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php
            /* Print the <title> tag based on what is being viewed. */
            global $page, $paged;

            wp_title( '|', true, 'right' );

        ?></title>

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.png" type="image/x-icon" />
        <?php wp_head(); ?>

        <?php
        if ( function_exists( 'yoast_analytics' ) && !get_query_var('virada_tpl') ) {
          yoast_analytics();
        }else{
            $youstOptions = get_option('Yoast_Google_Analytics');
            $uastring = "'".$youstOptions['uastring']."'"; //for local tests, use "'UA-50858535-1'"
            ?>
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
                ga('create', <?php echo $uastring; ?>, { 'cookieDomain': 'none' });
            </script>
            <?php
        }
        ?>
<script>(function() {
var _fbq = window._fbq || (window._fbq = []);
if (!_fbq.loaded) {
var fbds = document.createElement('script');
fbds.async = true;
fbds.src = '//connect.facebook.net/en_US/fbds.js';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(fbds, s);
_fbq.loaded = true;
}
_fbq.push(['addPixelId', '1382093348746310']);
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', 'PixelInitialized', {}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=1382093348746310&amp;ev=PixelInitialized" /></noscript>

    </head>
    <body <?php body_class(); ?> ng-controller="main">
        <?php if(get_query_var('virada_tpl')) MinhaVirada::add_JS(); ?>
        <?php if (is_single()) { ?>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=1379698002311750";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <?php } ?>

        <!-- Modal evento salvo na Minha Virada -->
        <div id="modal-favorita-evento" class="modal fade favorita-evento">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <span class="icon icon_close"></span>
                        </button>
                        <h4>Minha Virada</h4>
                    </div>
                    <div class="modal-body">
                        <p>Sua programação foi atualizada! Para acessá-la, visite a página <a href="<?php echo site_url('minha-virada'); ?>">Minha Virada</a>.</p>
                        <button id="modal-favorita-dismiss" type="button" class="btn btn-primary alignright">Ok, já entendi</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="modal-facebook-disclaimer" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Minha Virada</h4>
                    </div>
                    <div class="modal-body">
                        <p>Você acaba de associar sua conta do Facebook à plataforma da Virada Cultural, tornando pública algumas informações sobre seu acesso, como <strong>em quais eventos pretende comparecer</strong>.<br><br>
                            Para mais informações consulte nossos <a href="http://viradacultural.prefeitura.sp.gov.br/2015/termos-de-uso/"><strong>termos de uso</strong></a> e nossa <a href="http://viradacultural.prefeitura.sp.gov.br/2015/politica-de-privacidade/"><strong>política de privacidade</strong></a>.<br><br>
                            Deseja continuar?</p><br>
                        <p class="alignright clearfix" style="white-space: nowrap">
                            <a class="btn btn-primary js-accept" style="display:inline-block !important;">Sim, continuar</a>
                            <a class="btn btn-default js-cancel" style="display:inline-block !important;">Não, cancelar</a>
                        </p>
                        <div class="clearfix"></div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <!-- MEDIUM AND LARGE DEVICES -->
        <header id="main-header" <?php if (get_query_var('virada_tpl') == 'programacao' || is_page_template('page-dez-anos.php')): ?>class="minified hidden-sm hidden-xs"<?php endif; ?> class="hidden-sm hidden-xs">
            <div id="brand">
                <h1 id="logo-virada" class="logo"><a href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?>"><span class="sr-only"><?php bloginfo( 'name' ); ?></span></a></h1>
            </div>
            <nav id="main-nav">
                <?php
                    $noticias_id = get_cat_ID( 'Notícias' );
                    $noticias_link = get_category_link( $noticias_id );
                    $blog_id = get_cat_ID( 'Blog' );
                    $blog_link = function_exists('get_the_posts_home_url') ? get_the_posts_home_url() : get_category_link( $blog_id );
                ?>
                <ul id="main-menu" class="nav">
                    <li><a class="a-virada" href="<?php bloginfo( 'url' ); ?>/a-virada" title="A Virada"><span>A Virada</span></a></li>
                    <?php if (mostrar_programacao()): ?>
                        <li><a class="programacao" href="<?php bloginfo( 'url' ); ?>/programacao/" title="Programação"><span>Programação</span></a></li>
                    <?php endif; ?>
                    <li><a class="noticias" href="<?php echo get_post_type_archive_link( 'noticias' ); ?>" title="Notícias"><span>Notícias</span></a></li>
                    <?php /*
                    <li><a class="blog" href="<?php echo esc_url( $blog_link ); ?>" title="Blog"><span>Blog</span></a></li>
                    */?>
                    <li><a class="imprensa" href="<?php bloginfo( 'url' ); ?>/Imprensa" title="Imprensa"><span>Imprensa</span></a></li>
                    <li><a class="anos-10" href="<?php bloginfo( 'url' ); ?>/historico/" title="Histórico"><span>Histórico</span></a></li>
                    <?php if (mostrar_programacao()): ?>
                        <li><a class="nas-redes" href="<?php bloginfo( 'url' ); ?>/nas-redes/" title="Nas redes"><span>Nas redes</span></a></li>

                        <li><a class="minha-virada" href="<?php bloginfo( 'url' ); ?>/minha-virada/" title="Minha Virada"><span>Minha Virada</span></a></li>

                    <?php endif; ?>
                    <li><a class="mapa" href="<?php bloginfo( 'url' ); ?>/mapa/" title="Mapa de Serviços"><i class="icon icon_map"></i><span>Mapa de Serviços</span></a></li>
                    <li class="whitespace"><span></span></li>
                </ul>
            </nav>
            <!-- #main-nav -->

            <h2 id="logo-smc" class="logo">
                <a href="http://www.prefeitura.sp.gov.br/">
                    <span class="sr-only">Secretaria Municipal de Cultural de São Paulo</span>
                    <?php html::image("brasao.png", "Secretaria Municipal de Cultural de São Paulo", array("class" => "img-responsive")); ?>
                </a>
            </h2>
        </header>
        <!-- #main-header -->

        <!-- SMALL DEVICES -->
        <header id="main-header-minified" class="hidden-md hidden-lg">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target="#collapsed-navigation">
                            <span class="sr-only">Menu</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?>">
                            <span class="sr-only"><?php bloginfo( 'name' ); ?></span>
                            <span class="v">V</span>irada Cultur<span class="v">a</span>l
                        </a>
                        <?php if($paginaprogramacao == 'programacao'): ?>
                            <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target="#programacao-navbar">
                                <span class="sr-only">Filtro</span>
                                <span class="glyphicon glyphicon-filter"></span>
                            </button>
                        <?php endif;?>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="collapsed-navigation">
                    <ul class="nav navbar-nav">
                        <li class="col-sm-6 col-xs-6"><a class="a-virada" href="<?php bloginfo( 'url' ); ?>/a-virada" title="A Virada"><span>A Virada</span></a></li>
                        <?php if (mostrar_programacao()): ?>
                            <li class="col-sm-6 col-xs-6"><a class="programacao" href="<?php bloginfo( 'url' ); ?>/programacao/" title="Programação"><span>Programação</span></a></li>
                        <?php endif; ?>
                        <li class="col-sm-6 col-xs-6"><a class="noticias" href="<?php echo get_post_type_archive_link( 'noticias' ); ?>" title="Notícias"><span>Notícias</span></a></li>
                        <!-- <li class="col-sm-6 col-xs-6"><a class="blog" href="<?php echo esc_url( $blog_link ); ?>" title="Blog"><span>Blog</span></a></li> -->
                        <li class="col-sm-6 col-xs-6"><a class="imprensa" href="<?php bloginfo( 'url' ); ?>/Imprensa" title="Imprensa"><span>Imprensa</span></a></li>
                        <li class="col-sm-6 col-xs-6"><a class="anos-10" href="<?php bloginfo( 'url' ); ?>/historico/" title="Histórico"><span>Histórico</span></a></li>
                        <?php if (mostrar_programacao()): ?>
                            <li class="col-sm-6 col-xs-6"><a class="nas-redes" href="<?php bloginfo( 'url' ); ?>/nas-redes/" title="Nas redes"><span>Nas redes</span></a></li>

                            <li class="col-sm-6 col-xs-6"><a class="minha-virada" href="<?php bloginfo( 'url' ); ?>/minha-virada/" title="Minha Virada"><span>Minha Virada</span></a></li>

                        <?php endif; ?>
                        <li class="col-sm-6 col-xs-6"><a class="mapa" href="<?php bloginfo( 'url' ); ?>/mapa/" title="Mapa de Serviços"><i class="icon icon_map" style="font-size:15px; margin-left: -28px; margin-right: 13px;"></i><span>Mapa de Serviços</span></a></li>

                    </ul>
                </div>
            </nav>
        </header>

        <?php
            if ($paginaprogramacao !== 'programacao') {
                html::part('top-navbar');
            }
        ?>
