<?php

// Dê um Find Replace (CASE SENSITIVE!) em imprensa pelo nome do seu post type

class imprensa {

    const NAME = 'Imprensa';
    const MENU_NAME = 'Release';

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
                'name' => _x(self::NAME, 'post type general name', 'viradacultural'),
                'singular_name' => _x('Release', 'post type singular name', 'viradacultural'),
                'add_new' => _x('Adicionar Release', 'image', 'viradacultural'),
                'add_new_item' => __('Adicionar novo Release', 'viradacultural'),
                'edit_item' => __('Editar Release', 'viradacultural'),
                'new_item' => __('Novo Release', 'viradacultural'),
                'view_item' => __('Ver Release', 'viradacultural'),
                'search_items' => __('Search Releases', 'viradacultural'),
                'not_found' => __('Nenhum Release Encontrado', 'viradacultural'),
                'not_found_in_trash' => __('Nenhum Release na Lixeira', 'viradacultural'),
                'parent_item_colon' => ''
            ),
            'public' => true,
            'rewrite' => array('slug' => 'imprensa'),
            'capability_type' => 'post',
            'hierarchical' => false,
            'map_meta_cap ' => true,
            'menu_position' => 6,
            'has_archive' => true, //se precisar de arquivo
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail',
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
}

imprensa::init();
