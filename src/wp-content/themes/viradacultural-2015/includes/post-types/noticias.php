<?php

// Dê um Find Replace (CASE SENSITIVE!) em Noticias pelo nome do seu post type 

class Noticias {

    const NAME = 'Noticias';
    const MENU_NAME = 'Noticias';

    // configuração dos metaboxes
    protected static $meta_cfg = array(
        'post_relacionado' => array(
        ),

    );
    protected static $metaboxes_ativos = array(

    );

    /**
     * alug do post type: deve conter somente minúscula 
     * @var string
     */
    protected static $post_type;

    static function init() {
        // o slug do post type
        self::$post_type = strtolower(__CLASS__);

        add_action('init', array(self::$post_type, 'register'), 0);

        // descomente se precisar de taxonomias e configure as taxonomias na funcao register_taxonomies
        //add_action( 'init', array(__CLASS__, 'register_taxonomies') ,10);
        //add_filter('menu_order', array(self::$post_type, 'change_menu_label'));
        //add_filter('custom_menu_order', array(self::$post_type, 'custom_menu_order'));
        //add_action('save_post',array(__CLASS__, 'on_save'));
        
        add_action('pre_get_posts', array(self::$post_type, 'add_to_main_query'));
       
        
        
    }

    static function register() {
        register_post_type(self::$post_type, array(
            'labels' => array(
                'name' => _x(self::NAME, 'post type general name', 'SLUG'),
                'singular_name' => _x('Noticias', 'post type singular name', 'SLUG'),
                'add_new' => _x('Adicionar Novo', 'image', 'SLUG'),
                'add_new_item' => __('Adicionar novo Noticias', 'SLUG'),
                'edit_item' => __('Editar Noticias', 'SLUG'),
                'new_item' => __('Novo Noticias', 'SLUG'),
                'view_item' => __('Ver Noticias', 'SLUG'),
                'search_items' => __('Search Noticiass', 'SLUG'),
                'not_found' => __('Nenhum Noticias Encontrado', 'SLUG'),
                'not_found_in_trash' => __('Nenhum Noticias na Lixeira', 'SLUG'),
                'parent_item_colon' => ''
            ),
            'public' => true,
            'rewrite' => array('slug' => 'noticias'),
            'capability_type' => 'post',
            'hierarchical' => true,
            'map_meta_cap ' => true,
            'menu_position' => 6,
            'has_archive' => true, //se precisar de arquivo
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'comments',
                'revisions',
                'thumbnail'
                //'page-attributes'
            ),
                //'taxonomies' => array('taxonomia')
                )
        );
    }

    static function register_taxonomies() {
        // se for usar, descomentar //'taxonomies' => array('taxonomia') do post type (logo acima)

        $labels = array(
            'name' => _x('Taxonomias', 'taxonomy general name', 'SLUG'),
            'singular_name' => _x('Taxonomia', 'taxonomy singular name', 'SLUG'),
            'search_items' => __('Search Taxonomias', 'SLUG'),
            'all_items' => __('All Taxonomias', 'SLUG'),
            'parent_item' => __('Parent Taxonomia', 'SLUG'),
            'parent_item_colon' => __('Parent Taxonomia:', 'SLUG'),
            'edit_item' => __('Edit Taxonomia', 'SLUG'),
            'update_item' => __('Update Taxonomia', 'SLUG'),
            'add_new_item' => __('Add New Taxonomia', 'SLUG'),
            'new_item_name' => __('New Taxonomia Name', 'SLUG'),
        );

        register_taxonomy('taxonomia', self::$post_type, array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
                )
        );
    }

    static function change_menu_label($stuff) {
        global $menu, $submenu;
        foreach ($menu as $i => $mi) {
            if ($mi[0] == self::NAME) {
                $menu[$i][0] = self::MENU_NAME;
            }
        }
        return $stuff;
    }

    static function custom_menu_order() {
        return true;
    }

    /**
     * Chamado pelo hook save_post
     * @param int $post_id
     * @param object $post
     */
    static function on_save($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
        
        global $post;
        
        if ($post->post_type == self::$post_type) {
            // faça algo com o post 
        }
    }
    
    function add_to_main_query($wp_query) {

        if (!$wp_query->is_main_query())
            return $wp_query;
        
        if (is_front_page()) 
            $wp_query->query_vars['post_type'] = array('post', 'noticias', 'imprensa');
        
     
    }
    
}
Noticias::init();
