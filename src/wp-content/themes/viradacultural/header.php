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
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <?php wp_head(); ?>

        <script src='//maps.googleapis.com/maps/api/js?sensor=false'></script>

        <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/lunr.js" ></script>
        <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/angular.js" ></script>
        <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/underscore-min.js" ></script>
        <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/angular-google-maps.js" ></script>
        <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/virada.js" ></script>
        <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/directives.js" ></script>
        <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/controllers.js" ></script>
        <script type="text/javascript" src="<?php bloginfo( 'template_url' ) ?>/app/services.js" ></script>

        <script src="<?php bloginfo( 'template_url' ) ?>/js/moment.min.js"></script>
        <script src="<?php bloginfo( 'template_url' ) ?>/js/countdown.min.js"></script>
        <script src="<?php bloginfo( 'template_url' ) ?>/js/moment-countdown.min.js"></script>

        <script src="<?php bloginfo( 'template_url' ) ?>/js/jquery.knob.js"></script>

        <script src="<?php bloginfo( 'template_url' ) ?>/js/rrssb.js"></script>

        <script src="<?php bloginfo( 'stylesheet_directory' ) ?>/js/scrollmagic/_dependent/greensock/TweenMax.min.js" type="text/javascript"></script>
        <script src="<?php bloginfo( 'stylesheet_directory' ) ?>/js/scrollmagic/jquery.scrollmagic.js" type="text/javascript"></script>
        <script src="<?php bloginfo( 'stylesheet_directory' ) ?>/js/scrollmagic/jquery.scrollmagic.debug.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php bloginfo( 'stylesheet_directory' ) ?>/js/scrollmagic/_mobile/iscroll.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body <?php body_class(); ?> ng-controller="main">

        <header id="main-header" <?php if (get_query_var('virada_tpl')): ?>class="minified"<?php endif; ?>>
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
                    <li class="has-children">
                        <a class="a-virada" href="<?php bloginfo( 'url' ); ?>/a-virada" title="A Virada"><span>A Virada</span></a>
                        <ul class="children">
                            <li><a>Teste 1</a></li>
                            <li><a>Teste 2</a></li>
                            <li><a>Teste 3</a></li>
                        </ul>
                    </li>
                    <li><a class="anos-10" href="<?php bloginfo( 'url' ); ?>/10-anos" title="10 anos"><span>10 anos</span></a></li>
                    <li class="has-children">
                        <a class="programacao" href="<?php bloginfo( 'url' ); ?>/programacao" title="Programação"><span>Programação</span></a>
                        <ul class="children">
                            <li><a>Teste 1</a></li>
                            <li><a>Teste 2</a></li>
                            <li><a>Teste 3</a></li>
                            <li><a>Teste 1</a></li>
                            <li><a>Teste 2</a></li>
                            <li><a>Teste 3</a></li>
                        </ul>
                    </li>
                    <li><a class="noticias" href="<?php echo get_post_type_archive_link( 'noticias' ); ?>" title="Notícias"><span>Notícias</span></a></li>
                    <li><a class="blog" href="<?php echo esc_url( $blog_link ); ?>" title="Blog"><span>Blog</span></a></li>
                    <li><a class="imprensa" href="<?php echo get_post_type_archive_link( 'imprensa' ); ?>" title="Imprensa"><span>Imprensa</span></a></li>
                    <li><a class="nas-redes" href="<?php bloginfo( 'url' ); ?>/nas-redes" title="Nas redes"><span>Nas redes</span></a></li>
                    <li><a class="minha-virada" href="<?php bloginfo( 'url' ); ?>/minha-virada" title="Minha Virada"><span>Minha Virada</span></a></li>
                    <li class="whitespace"><span></span></li>
                </ul>
            </nav>
            <!-- #main-nav -->

            <h2 id="logo-smc" class="logo"><a href="http://www.prefeitura.sp.gov.br/"><span class="sr-only">Secretaria Municipal de Cultural de São Paulo</span></a></h2>
        </header>
        <!-- #main-header -->

        <?php html::part('top-navbar'); ?>
