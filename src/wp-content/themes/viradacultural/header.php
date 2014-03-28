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
        <!-- Bootstrap -->
        <link href="<?php bloginfo( 'stylesheet_directory' ) ?>/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
        <link rel="stylesheet/less" type="text/css" href="<?php bloginfo( 'stylesheet_directory' ) ?>/main.less" />        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->        
        <script src="<?php bloginfo( 'stylesheet_directory' ) ?>/js/less-1.7.1.min.js" type="text/javascript"></script>
        <?php wp_head(); ?>        
    </head>

    <body <?php body_class(); ?>>

        <header id="main-header">
            <div id="branding" class="wrap clearfix">
                <h1 class="col-12"><span><a href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a></span></h1>
                <p id="description" class="col-12"><?php bloginfo( 'description' ); ?></p>			
            </div>
            <!-- .wrap -->
            <nav id="main-nav">
                <div class="wrap clearfix">
                    <?php wp_nav_menu( array( 'theme_location' => 'main', 'container' => '', 'menu_id' => 'main-menu', 'menu_class' => 'clearfix', 'fallback_cb' =>'') ); ?>
                    <div><a href="<?php bloginfo('rss_url'); ?>" title="RSS Feed">rss</a></div>
                </div>
            <!-- .wrap -->
            </nav>
            <!-- #main-nav -->
        </header>
        <!-- #main-header -->
