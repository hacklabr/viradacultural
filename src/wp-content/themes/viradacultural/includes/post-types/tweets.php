<?php

// Dê um Find Replace (CASE SENSITIVE!) em Twitter_CPT pelo nome do seu post type 

class Twitter_CPT {

    const NAME = 'Tweets';
    const MENU_NAME = 'Tweets';

    // configuração dos metaboxes
    protected static $meta_cfg = array(
       
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

    }

    static function register() {
        register_post_type(self::$post_type, array(
            'labels' => array(
                'name' => _x(self::NAME, 'post type general name', 'SLUG'),
                'singular_name' => _x('Twitter_CPT', 'post type singular name', 'SLUG'),
                'add_new' => _x('Adicionar Novo', 'image', 'SLUG'),
                'add_new_item' => __('Adicionar novo Twitter_CPT', 'SLUG'),
                'edit_item' => __('Editar Twitter_CPT', 'SLUG'),
                'new_item' => __('Novo Twitter_CPT', 'SLUG'),
                'view_item' => __('Ver Twitter_CPT', 'SLUG'),
                'search_items' => __('Search Twitter_CPTs', 'SLUG'),
                'not_found' => __('Nenhum Twitter_CPT Encontrado', 'SLUG'),
                'not_found_in_trash' => __('Nenhum Twitter_CPT na Lixeira', 'SLUG'),
                'parent_item_colon' => ''
            ),
            'public' => true,
            'rewrite' => array('slug' => 'instagram'),
            'capability_type' => 'post',
            'hierarchical' => true,
            'map_meta_cap ' => true,
            'menu_position' => 6,
            'has_archive' => true, //se precisar de arquivo
            'supports' => array(
                'title',
                'editor',
                'page-attributes'
            ),
                //'taxonomies' => array('taxonomia')
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
}
  
Twitter_CPT::init();
