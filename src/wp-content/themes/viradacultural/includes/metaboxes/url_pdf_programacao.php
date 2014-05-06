<?php

// SUBSTITUA  url_pdf_ pelo slug do metabox

class url_pdf_Metabox {

    protected static $metabox_config = array(
        'url_pdf_', // slug do metabox
        'Programação', // título do metabox
        'page', // array('post','page','etc'), // post types
        'normal' // onde colocar o metabox
    );

    static function init() {
        add_action('add_meta_boxes', array(__CLASS__, 'addMetaBox'));
        add_action('save_post', array(__CLASS__, 'savePost'));
    }

    static function addMetaBox() {
        add_meta_box(
            self::$metabox_config[0],
            self::$metabox_config[1],
            array(__CLASS__, 'metabox'), 
            self::$metabox_config[2],
            self::$metabox_config[3]
            
        );
    }
    
    
    static function filterValue($meta_key, $value){
        global $post;
    
        switch ($meta_key){
            case 'outro_dado':
                return strtoupper($value);
            break;
        
            default:
                return $value;
            break;
        }
        
    }
    
    static function metabox(){
        global $post;
        
        wp_nonce_field( 'save_'.__CLASS__, __CLASS__.'_noncename' );
        
        $metadata = get_metadata('post', $post->ID);
        
        ?>
        <label> URL do PDF: <input type="text" name="<?php echo __CLASS__ ?>[url_do_pdf]" value="<?php echo $metadata['url_do_pdf'][0]; ?>" /></label>
        <?php
    }

    static function savePost($post_id) {
        // verify if this is an auto save routine. 
        // If it is our form has not been submitted, so we dont want to do anything
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times

        if (!wp_verify_nonce($_POST[__CLASS__.'_noncename'], 'save_'.__CLASS__))
            return;


        // Check permissions
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return;
        }
        else {
            if (!current_user_can('edit_post', $post_id))
                return;
        }

        // OK, we're authenticated: we need to find and save the data
        if(isset($_POST[__CLASS__])){
            foreach($_POST[__CLASS__] as $meta_key => $value)
                update_post_meta($post_id, $meta_key, self::filterValue($meta_key, $value));
        }
    }

    
}


url_pdf_Metabox::init();
