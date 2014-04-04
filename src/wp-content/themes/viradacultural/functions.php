<?php 
/*
 * IMPORTANTE
 * substituir todos os viradacultural pelo slug do projeto
 */

include dirname(__FILE__).'/includes/congelado-functions.php';
include dirname(__FILE__).'/includes/html.class.php';
include dirname(__FILE__).'/includes/utils.class.php';
include dirname(__FILE__).'/includes/form.class.php';
include dirname(__FILE__).'/includes/hacklab_post2home/hacklab_post2home.php';


add_action( 'after_setup_theme', 'viradacultural_setup' );
function viradacultural_setup() {

    load_theme_textdomain('viradacultural', TEMPLATEPATH . '/languages' );

    // POST THUMBNAILS
    add_theme_support('post-thumbnails');
    //set_post_thumbnail_size( 200, 150, true );

    //REGISTRAR AQUI TODOS OS TAMANHOS UTILIZADOS NO LAYOUT
    //add_image_size('nome',X,Y);
    //add_image_size('nome2',X,Y);

    // AUTOMATIC FEED LINKS
    add_theme_support('automatic-feed-links');

    // CUSTOM IMAGE HEADER
    define('HEADER_TEXTCOLOR', '000000');
    define('HEADER_IMAGE_WIDTH', 980); 
    define('HEADER_IMAGE_HEIGHT', 176);

    add_theme_support(
        'custom-header', 
        array('wp-head-callback' => 'viradacultural_custom_header', 'admin-head-callback' => 'viradacultural_admin_custom_header')
    );

    register_default_headers( array(
        'Mundo' => array(
            'url' => '%s/img/headers/image001.jpg',
            'thumbnail_url' => '%s/img/headers/image001-thumbnail.jpg',
        ),
        'Árvores' => array(
            'url' => '%s/img/headers/image002.jpg',
            'thumbnail_url' => '%s/img/headers/image002-thumbnail.jpg',
            'description' => 'barco'
        ),
        'Caminho' => array(
            'url' => '%s/img/headers/image003.jpg',
            'thumbnail_url' => '%s/img/headers/image003-thumbnail.jpg',
        ),
    ) );

    // CUSTOM BACKGROUND
    add_theme_support('custom-background');
}


// admin_bar removal
//wp_deregister_script('admin-bar');
//wp_deregister_style('admin-bar');
remove_action('wp_footer','wp_admin_bar_render',1000);
function remove_admin_bar(){
   return false;
}
add_filter( 'show_admin_bar' , 'remove_admin_bar');

// JS
add_action('wp_print_scripts', 'viradacultural_addJS');
function viradacultural_addJS() {
    if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); 
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', 'jquery');
    wp_enqueue_script('less', get_stylesheet_directory_uri().'/js/less-1.7.0.min.js');
    wp_enqueue_script('viradacultural', get_stylesheet_directory_uri().'/js/viradacultural.js','jquery');
    wp_localize_script('congelado', 'vars', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
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

// SETUP
if (!function_exists('viradacultural_custom_header')) :

    function viradacultural_custom_header() {
        ?><style type="text/css">
            #branding {
                background: url(<?php header_image(); ?>);
            }
                
            #branding, #branding a, #branding a:hover {
                color: #<?php header_textcolor(); ?> !important;
            }
            #branding a:hover {
                text-decoration: none; 
            }
            #description { 
                filter: alpha(opacity=60);
                opacity: 0.6;
            }
        
        </style><?php

    }

endif;

if (!function_exists('viradacultural_admin_custom_header')) :

    function viradacultural_admin_custom_header() {
        ?><style type="text/css">
        
           #headimg {
                padding:55px 10px;
                width: 960px !important;
                height: 66px !important;
                min-height: 66px !important;
            }
        
            #headimg h1 {
                font-size:36px;
                line-height:44px;
                font-weight:normal !important;
                margin: 0px;
                margin: 0 10px;            
            }
        
            #headimg h1 a {
                text-decoration: none !important;
            }
        
            #headimg #desc { 
                font-style: italic; 
                font-size: 16px; 
                margin: 0 10px;
                filter: alpha(opacity=60);
                opacity: 0.6;
            }

        </style><?php
    }

endif;

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
	        .login h1 a { background-image: url('. html::getImageUrl('logo.png') .'); background-size: auto; }
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
    
    if ($post_type != 'post' && $post_type != 'noticias')
        return;
        
    $icon_name = $post_type == 'post' ? 'blog-icon-2x.png' : 'noticias-icon-2x.png';
    
    echo '<div class="category-icon">';
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
    $public_query_vars[] = "minhavirada";

    return $public_query_vars;
}

// REDIRECIONAMENTOS
function virada_custom_url_rewrites($rules) {
    
    //var_dump($rules); die;
    $new_rules = array( 
        "programacao/?$" => "index.php?virada_tpl=programacao",
        "programacao/atracoes/?$" => "index.php?virada_tpl=programacao-atracoes",
        "programacao/atracoes/([^/]+)/?$" => 'index.php?virada_tpl=programacao-atracoes-single&virada_object=$matches[1]',
        //"programacao/locais/?$" => "index.php?virada_tpl=programacao",
        "programacao/locais/([^/]+)/?$" => 'index.php?virada_tpl=programacao-locais-single&virada_object=$matches[1]',
        "minha-virada/([^/]+)/?$" => 'index.php?minhavirada=1&virada_tpl=programacao-locais-single&virada_object=$matches[1]',
    );

    return $new_rules + $rules;
}

function virada_template_redirect_intercept() {
    global $wp_query;

    if ( $wp_query->get('virada_tpl') ) {

        if (file_exists( TEMPLATEPATH . '/' . $wp_query->get('virada_tpl') . '.php' )) {
            include( TEMPLATEPATH . '/' . $wp_query->get('virada_tpl') . '.php' );
            exit;
        }

    }
}


