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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php
            /* Print the <title> tag based on what is being viewed. */
            global $page, $paged;

            wp_title( '|', true, 'right' );

            // Add the blog name.
            bloginfo( 'name' );

            // Add the blog description for the home/front page.
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) )
                echo " | $site_description";

            // Add a page number if necessary:
            if ( $paged >= 2 || $page >= 2 )
                echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );
        ?></title>

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' ); ?>/elegant-font.css" />
        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' ) ?>/main.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' ) ?>/js/angular-rangeslider-master/angular.rangeSlider.css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.png" type="image/x-icon" />
        <?php wp_head(); ?>

        <script src='//maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry'></script>

        <?php if(defined('VIRADA_TEMPLATE') && VIRADA_TEMPLATE): ?>
            <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/angular.js" ></script>
            <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/underscore-min.js" ></script>
            <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/angular-google-maps.js" ></script>
            <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/virada.js" ></script>
            <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/directives.js" ></script>
            <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/controllers.js" ></script>
            <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/services.js" ></script>

            <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/js/angular-rangeslider-master/angular.rangeSlider.js" ></script>
            <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/js/resig.js" ></script>
        <?php endif; ?>

        <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/js/jquery.lazyload.min.js" ></script>
        <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/js/jquery.animascroll.js" ></script>

        <script src="<?php bloginfo( 'template_url' ) ?>/js/moment.min.js"></script>
        <script src="<?php bloginfo( 'template_url' ) ?>/js/moment.lang.pt-br.js"></script>
        <script src="<?php bloginfo( 'template_url' ) ?>/js/countdown.min.js"></script>
        <script src="<?php bloginfo( 'template_url' ) ?>/js/moment-countdown.min.js"></script>

        <script src="<?php bloginfo( 'template_url' ) ?>/js/jquery.knob.js"></script>

        <script src="<?php bloginfo( 'template_url' ) ?>/js/rrssb.js"></script>

        <script src="<?php bloginfo( 'stylesheet_directory' ) ?>/js/scrollmagic/_mobile/iscroll.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php bloginfo( 'template_url' ) ?>/js/fastclick.js"></script>

        <script src="<?php bloginfo( 'template_url' ) ?>/js/viradacultural.js"></script>
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

        <!-- MEDIUM AND LARGE DEVICES -->
        <header id="main-header" <?php if (get_query_var('virada_tpl') == 'programacao' || is_page_template('page-dez-anos.php')): ?>class="minified hidden-sm hidden-xs"<?php endif; ?> class="hidden-sm hidden-xs">
            <div id="brand">
                <h1 id="logo-virada" class="logo"><a href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?>"><span class="sr-only"><?php bloginfo( 'name' ); ?></span></a></h1>
                <p class="assinatura sr-only"><span>A</span> <span>cidade</span> <span>em</span> <span>festa!</span></p>
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
                        <li><a class="programacao" href="<?php bloginfo( 'url' ); ?>/programacao" title="Programação"><span>Programação</span></a></li>
                    <?php endif; ?>
                    <li><a class="noticias" href="<?php echo get_post_type_archive_link( 'noticias' ); ?>" title="Notícias"><span>Notícias</span></a></li>
                    <li><a class="blog" href="<?php echo esc_url( $blog_link ); ?>" title="Blog"><span>Blog</span></a></li>
                    <li><a class="imprensa" href="<?php echo get_post_type_archive_link( 'imprensa' ); ?>" title="Imprensa"><span>Imprensa</span></a></li>
                    <?php if (mostrar_programacao()): ?>
                        <li><a class="nas-redes" href="<?php bloginfo( 'url' ); ?>/nas-redes" title="Nas redes"><span>Nas redes</span></a></li>
                        <li><a class="anos-10" href="<?php bloginfo( 'url' ); ?>/10-anos" title="10 anos"><span>10 anos</span></a></li>
                        <li><a class="minha-virada" href="<?php bloginfo( 'url' ); ?>/minha-virada" title="Minha Virada"><span>Minha Virada</span></a></li>
                    <?php endif; ?>
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
                            <span class="verde">Virada</span> <span class="rosa">Cultural</span>
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
                            <li class="col-sm-6 col-xs-6"><a class="programacao" href="<?php bloginfo( 'url' ); ?>/programacao" title="Programação"><span>Programação</span></a></li>
                        <?php endif; ?>
                        <li class="col-sm-6 col-xs-6"><a class="noticias" href="<?php echo get_post_type_archive_link( 'noticias' ); ?>" title="Notícias"><span>Notícias</span></a></li>
                        <li class="col-sm-6 col-xs-6"><a class="blog" href="<?php echo esc_url( $blog_link ); ?>" title="Blog"><span>Blog</span></a></li>
                        <li class="col-sm-6 col-xs-6"><a class="imprensa" href="<?php echo get_post_type_archive_link( 'imprensa' ); ?>" title="Imprensa"><span>Imprensa</span></a></li>
                        <?php if (mostrar_programacao()): ?>
                            <li class="col-sm-6 col-xs-6"><a class="nas-redes" href="<?php bloginfo( 'url' ); ?>/nas-redes" title="Nas redes"><span>Nas redes</span></a></li>
                            <li class="col-sm-6 col-xs-6"><a class="anos-10" href="<?php bloginfo( 'url' ); ?>/10-anos" title="10 anos"><span>10 anos</span></a></li>
                            <li class="col-sm-6 col-xs-6"><a class="minha-virada" href="<?php bloginfo( 'url' ); ?>/minha-virada" title="Minha Virada"><span>Minha Virada</span></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </header>

        <?php
            if ($paginaprogramacao !== 'programacao') {
                html::part('top-navbar');
            }
        ?>
