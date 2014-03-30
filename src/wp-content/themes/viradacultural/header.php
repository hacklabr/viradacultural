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
<html <?php language_attributes(); ?>>
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
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
        <!-- Bootstrap -->
        <link rel="stylesheet/less" type="text/css" href="<?php bloginfo( 'stylesheet_directory' ) ?>/less/main.less" />        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->        
        
        <?php wp_head(); ?>        
    </head>

    <body <?php body_class(); ?>>
        <header id="main-header" <?php if (is_page_template('programacao')): ?>class="col-md-1"<?php else: ?>class="col-md-2"<?php endif; ?>>
            <h1 id="logo-virada" class="logo"><a href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
            <time>17-18 de maio de 2014</time>
            <nav id="main-nav">
                <?php wp_nav_menu( array( 'theme_location' => 'main', 'container' => 'nav', 'container_id' => 'main-nav', 'menu_id' => 'main-menu', 'menu_class' => 'nav', 'fallback_cb' =>'', 'depth' => '1',) ); ?>
            </nav>
            <!-- #main-nav -->
            <h2 id="logo-smc" class="logo"><a href="http://www.prefeitura.sp.gov.br/">Secretaria Municipal de Cultural de São Paulo</a></h2>
        </header>
        <!-- #main-header -->
