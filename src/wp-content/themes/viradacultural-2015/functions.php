<?php

include dirname(__FILE__).'/includes/congelado-functions.php';
include dirname(__FILE__).'/includes/html.class.php';
include dirname(__FILE__).'/includes/utils.class.php';
include dirname(__FILE__).'/includes/form.class.php';
include dirname(__FILE__).'/includes/hacklab_post2home/hacklab_post2home.php';
//include dirname(__FILE__).'/includes/mapasculturais2post/mapasculturais2post.php';
include dirname(__FILE__).'/includes/nas-redes-wp-cron.php';
include dirname(__FILE__).'/includes/minha-virada.php';


add_action( 'after_setup_theme', 'viradacultural_setup' );
function viradacultural_setup() {

    load_theme_textdomain('viradacultural', TEMPLATEPATH . '/languages' );

    // POST THUMBNAILS
    add_theme_support('post-thumbnails');
    //set_post_thumbnail_size( 200, 150, true );

    //REGISTRAR AQUI TODOS OS TAMANHOS UTILIZADOS NO LAYOUT
    add_image_size('i1080',1920,1080, true);
    add_image_size('i900', 1600, 900, true);
    add_image_size('i800', 1422, 800, true);
    add_image_size('i768', 1366, 768, true);
    add_image_size('i480',  853, 480, true);
    add_image_size('i320',  568, 320, true);

    // AUTOMATIC FEED LINKS
    add_theme_support('automatic-feed-links');
}


// admin_bar removal
//wp_deregister_script('admin-bar');
//wp_deregister_style('admin-bar');
remove_action('wp_footer','wp_admin_bar_render',1000);
function remove_admin_bar(){
   return false;
}
add_filter( 'show_admin_bar' , 'remove_admin_bar');

function virada_get_facebook_app_id() {
    if(defined('FACEBOOK_APP_ID')){
        return FACEBOOK_APP_ID;
    }else{
        return '364818143726863';
    }
}

// JS
add_action('wp_print_scripts', 'viradacultural_addJS');
function viradacultural_addJS() {
    if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
    global $wp_query;

    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.js', 'jquery');

    $facebookAppId = virada_get_facebook_app_id();

    wp_localize_script('jquery', 'GlobalConfiguration', array(
        'baseURL' =>        get_bloginfo("url"),
        'templateURL' =>    get_bloginfo("template_url"),
        'pdfURL' =>         get_theme_option('pdf-programacao'),
        'ajaxurl' =>        admin_url('admin-ajax.php'),
        'facebookAppId' =>  $facebookAppId,
        'md5' => array(
            'events' => md5_file(realpath(__DIR__.'/app/events.json')),
            'spaces' => md5_file(realpath(__DIR__.'/app/spaces.json')),
            'spaces-order' => md5_file(realpath(__DIR__.'/app/spaces-order.json')),
        )
    ));


    wp_enqueue_script('viradacultural', get_stylesheet_directory_uri().'/js/viradacultural.js', array('jquery'));

    if(is_page() && get_post_meta(get_the_ID(), '_wp_page_template', true) === 'page-dez-anos.php'){
        wp_enqueue_script('jquery.animascroll', get_stylesheet_directory_uri().'/js/jquery.animascroll.js', array('jquery'));

    }else if($tpl = get_query_var('virada_tpl')) {

        wp_enqueue_script('google-maps', '//maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry');
        wp_enqueue_script('angular', get_stylesheet_directory_uri().'/js/angular.min.js');

        wp_enqueue_script('angulartics', get_stylesheet_directory_uri().'/js/angulartics.min.js', array('angular'));
        wp_enqueue_script('angulartics-ga', get_stylesheet_directory_uri().'/js/angulartics-ga.min.js', array('angulartics'));

        wp_enqueue_script('underscore', get_stylesheet_directory_uri().'/js/underscore-min.js');
        wp_enqueue_script('angular-google-maps', get_stylesheet_directory_uri().'/js/angular-google-maps.js', array('google-maps', 'underscore', 'angular'));

        wp_enqueue_script('minha-virada', get_stylesheet_directory_uri().'/js/minha-virada.js', array('jquery', 'angulartics'));

        wp_enqueue_script('app-virada', get_stylesheet_directory_uri().'/app/virada.js', array('moment', 'angular', 'angular-rangeslider', 'minha-virada'));

        wp_enqueue_script('app-services', get_stylesheet_directory_uri().'/app/services.js', array('angular', 'app-virada'));

        wp_enqueue_script('angular-rangeslider', get_stylesheet_directory_uri().'/js/angular-rangeslider-master/angular.rangeSlider.js', array('angular'));

        wp_enqueue_script('app-directives', get_stylesheet_directory_uri().'/app/directives.js', array('angular', 'app-virada'));
        wp_enqueue_script('app-controllers', get_stylesheet_directory_uri().'/app/controllers.js', array('angular', 'app-services', 'app-virada'));

    }

    wp_enqueue_script('resig', get_stylesheet_directory_uri().'/js/resig.js');


    wp_enqueue_script('moment', get_stylesheet_directory_uri().'/js/moment.min.js');
    wp_enqueue_script('moment-lang-pt-br', get_stylesheet_directory_uri().'/js/moment.lang.pt-br.js', array('moment'));
    wp_enqueue_script('countdown', get_stylesheet_directory_uri().'/js/countdown.min.js');
    wp_enqueue_script('moment-countdown', get_stylesheet_directory_uri().'/js/moment-countdown.min.js', array('moment', 'countdown'));
    wp_enqueue_script('jquery-knob', get_stylesheet_directory_uri().'/js/jquery.knob.js', array('jquery'));

    wp_enqueue_script('fastclick', get_stylesheet_directory_uri().'/js/fastclick.js');

    wp_enqueue_script('rrssb', get_stylesheet_directory_uri().'/js/rrssb.js');


    // wp_enqueue_script('iscroll', get_stylesheet_directory_uri().'/js/scrollmagic/_mobile/iscroll.js');

    wp_enqueue_script('smartbanner', get_stylesheet_directory_uri().'/js/jquery.smartbanner.js', array('jquery'));
}

add_action('wp_print_styles', 'viradacultural_addCSS');
function viradacultural_addCSS() {
    wp_enqueue_style('smartbanner', get_stylesheet_directory_uri().'/-css/jquery.smartbanner.css');

    wp_enqueue_style('elegant-font', get_stylesheet_directory_uri().'/elegant-font.css');
    wp_enqueue_style('virada-main', get_stylesheet_directory_uri().'/main.css', array('elegant-font', 'smartbanner'));
    wp_enqueue_style('range-slider', get_stylesheet_directory_uri().'/js/angular-rangeslider-master/angular.rangeSlider.css', array('virada-main'));

}

// CUSTOM MENU
add_action( 'init', 'viradacultural_custom_menus' );
function viradacultural_custom_menus() {
    register_nav_menus( array(
        'main' => 'Principal',
    ) );
}

// SIDEBARS
if(function_exists('register_sidebar')) {
    // sidebar
    register_sidebar( array(
        'name' =>  'Sidebar',
        'description' => __('Sidebar', 'viradacultural'),
        'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content clearfix">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ) );
}

// EXCERPT MORE

add_filter('utils_excerpt_more_link', 'viradacultural_utils_excerpt_more',10,2);
function viradacultural_utils_excerpt_more($more_link, $post){
    return '...<br /><a class="more-link" href="'. get_permalink($post->ID) . '">' . __('Continue reading &raquo;', 'viradacultural') . '</a>';
}


add_filter( 'excerpt_more', 'viradacultural_auto_excerpt_more' );
function viradacultural_auto_excerpt_more( $more ) {
    global $post;
    return '...<br /><a class="more-link" href="'. get_permalink($post->ID) . '">' . __('Continue reading &raquo;', 'viradacultural') . '</a>';
}

// COMMENTS
if (!function_exists('viradacultural_comment')):

    function viradacultural_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        ?>
        <li <?php comment_class("clearfix"); ?> id="comment-<?php comment_ID(); ?>">
            <p class="comment-meta alignright bottom">
                <?php comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'])) ?> <?php edit_comment_link( __('Edit', 'viradacultural'), '| ', ''); ?>
            </p>
            <p class="comment-meta bottom">
                <?php printf( __('By %s on %s at %s.', 'viradacultural'), get_comment_author_link(), get_comment_date(), get_comment_time()); ?>
                <?php if($comment->comment_approved == '0') : ?><br/><em><?php _e('Your comment is awaiting moderation.', 'viradacultural'); ?></em><?php endif; ?>
            </p>
            <?php echo get_avatar($comment, 66); ?>
            <div class="content">
                <?php comment_text(); ?>
            </div>
        </li>
        <?php
    }

endif;




// custom admin login logo
function custom_login_logo() {
	echo '
        <style type="text/css">
	        .login h1 a { background-image: url('. html::getImageUrl('logo.png') .'); background-size: contain; }
        </style>';
}
add_action('login_head', 'custom_login_logo');

function new_headertitle($url){
    return get_bloginfo('sitetitle');
}
add_filter('login_headertitle','new_headertitle');

function custom_login_headerurl($url) {
    return get_bloginfo('url');

}
add_filter ('login_headerurl', 'custom_login_headerurl');



function virada_the_post_type_icon($post_type = null) {

    if (is_null($post_type)) {
        $post_type = get_post_type();
    }

    if ($post_type != 'post' && $post_type != 'noticias'  && $post_type != 'imprensa')
        return;


    if ($post_type == 'post')
		$icon_name = 'blog-icon-1x.png';
	elseif ($post_type == 'noticias')
		$icon_name = 'noticias-icon-1x.png';
	elseif ($post_type == 'imprensa')
		$icon_name = 'imprensa-icon-1x.png';

    echo '<div class="post-type-icon">';
    html::image($icon_name, $post_type);
    echo '</div>';


}

// REWRITE RULES //
add_filter('query_vars', 'virada_custom_query_vars');
add_filter('rewrite_rules_array', 'virada_custom_url_rewrites', 10, 1);
add_action('template_redirect', 'virada_template_redirect_intercept');

function virada_custom_query_vars($public_query_vars) {
    $public_query_vars[] = "virada_tpl";
    $public_query_vars[] = "virada_object";

    return $public_query_vars;
}

// REDIRECIONAMENTOS
function virada_custom_url_rewrites($rules) {

    //var_dump($rules); die;
    $new_rules = array(
        "programacao/?$" => "index.php?virada_tpl=programacao",
        "programacao/atracoes/?$" => "index.php?virada_tpl=programacao-atracoes",
        "programacao/atracao/?$" => 'index.php?virada_tpl=programacao-atracoes-single',
        "programacao/local/?$" => 'index.php?virada_tpl=programacao-locais-single',
        "minha-virada/?$" => 'index.php?virada_tpl=minha-virada'
    );

    return $new_rules + $rules;
}

function virada_template_redirect_intercept() {
    global $wp_query;

    if ( $wp_query->get('virada_tpl') ) {

        if (!mostrar_programacao())
            die('Página não encontrada');

        if (file_exists( TEMPLATEPATH . '/' . $wp_query->get('virada_tpl') . '.php' )) {
            define('VIRADA_TEMPLATE', true);
            include( TEMPLATEPATH . '/' . $wp_query->get('virada_tpl') . '.php' );
            exit;
        }

    }
}

add_filter('body_class', function($classes) {

    $tpl = get_query_var('virada_tpl');

    if ($tpl) {
        $classes[] = 'programacao';
        if ($tpl == 'programacao-locais-single' || $tpl == 'programacao-atracoes-single')
            $classes[] = 'programacao-single';
        if ($tpl == 'minha-virada')
            $classes[] = 'page';
        if ($tpl == 'programacao')
            $classes[] = 'programacao-home';
    }

    return $classes;

});

function mostrar_programacao() {

    if (is_user_logged_in())
        return true;

    return get_theme_option('programacao_published');

}

function the_share_url() {

    if (get_query_var('virada_tpl')) {
        echo '{{current_share_url}}';
    } elseif (is_singular()) {
        the_permalink();
    } else {
        echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

}




add_action('wp_head', 'virada_meta_tags');
function virada_meta_tags() {

    global $post, $wp;

    $obj = get_queried_object();

    $name = array();

    $property = array();

    // Não executa htmlentities nestes campos
    $no_entities = array( 'og:image', 'og:url' );

    // keywords news_keywords
    /*
    $name['keywords'] = get_option( 'seo_keywords' );
    if ( is_single() ) {
        if ( $ts = get_the_tags() ) {
            foreach( $ts as $t ) $tags[] = $t->name;
            $name['keywords'] = implode( $tags );
        }
        if ( $t = get_post_meta( $post->ID, 'gnews_tags', true ) )
            $name['news_keywords'] = $t;
    } elseif ( is_category() || is_tax( 'agenda' ) ) {
        if ( $t = get_option( 'cl_seo_keywords_' . $obj->term_id . '_' . $site_code ) )
            $name['keywords'] = $t;
    }
    */

    // description og:description

    $name['description'] =get_bloginfo('description');


    // comentários do Facebook


    $property = $property + array(
        'fb:app_id' => virada_get_facebook_app_id(),
        'fb:admins' => 'leogermani'
    );

    foreach( $name as $n => $c ) {
        if ( !in_array( $n, $no_entities ) )
            $c = utils::htmlentities( $c );
        echo sprintf( "<meta name=\"{$n}\" content=\"%s\" />\n", $c );
    }

    foreach( $property as $p => $c ) {
        if ( !in_array( $p, $no_entities ) )
            $c = utils::htmlentities( $c );
        echo sprintf( "<meta property=\"{$p}\" content=\"%s\" />\n", $c );
    }

}



