<?php
/*
 * Plugin Name: Better Front Page UI
 * Plugin URI: http://github.com/vmassuchetto/wordpress-better-front-page-ui
 * Description: Use the front page to the <code>front-page.php</code> template file without any user interference or dummy pages.
 * Version: 0.03
 * Author: Leo Germani, Vinicius Massuchetto
 * Author URI: http://github.com/vmassuchetto/wordpress-better-front-page-ui
 */

class Better_Front_Page_UI {

    public static $option_name = 'blog_base';
    public static $default_value = 'blog';

    function Better_Front_Page_UI() {
        /*
        self::$option_name = 'blog_base';
        self::$default_value = 'blog';
        */

        if ( is_admin() ) {
            add_action( 'admin_init', array( $this, 'admin_init' ) );
        }

        add_action( 'rewrite_rules_array', array( $this, 'rewrite_rules_array' ), 9999 );
        add_filter( 'option_show_on_front', array( $this, 'filter_show_on_front' ) );
        add_filter( 'query_vars', array( $this, 'query_vars' ) );
        add_action( 'admin_print_footer_scripts', array( $this, 'remove_reading_option' ) );
    }

    function activate() {
        flush_rewrite_rules();
    }

    function deactivate() {
        flush_rewrite_rules();
    }

    function uninstall() {
        delete_option( self::$option_name );
        flush_rewrite_rules();
    }

    function get_option() {
        $option = get_option( self::$option_name );
        return ! $option || empty( $option ) ? self::$default_value : $option;
    }

    function rewrite_rules_array( $rules ) {
        $option = $this->get_option();
        $new_rules = array(
            $option . '/?$' => 'index.php?force_home=1',
            $option . '/page/?([0-9]{1,})/?$' => 'index.php?force_home=1&paged=$matches[1]',
        );
        return array_merge( $new_rules, $rules );
    }

    function query_vars( $vars ) {
        array_push( $vars, 'force_home' );
        return $vars;
    }

    /*
     * If it existed, we could filter is_front_page, but since it relies on
     * this option, we filter it here
     */
    function filter_show_on_front($value) {

        /*
         * @TODO: Do we really need to bother with this? Is this a good thingo
         * to do? The point here is to filter only when is_front_page() calls it
         *
         */
        /*
        $callStack = debug_backtrace();
        if (!is_array($callStack) ||
            !isset($callStack[4]) ||
            !is_array($callStack[4]) ||
            !isset($callStack[4]['function']) ||
            $callStack[4]['function'] != 'is_front_page')
            return $value;
        */
        $value = 'posts';
        if ( is_home() && get_query_var( 'force_home' ) == 1 )
            $value = 'force';
        return $value;
    }

    function admin_init() {

        add_settings_field( self::$option_name, __( 'Post Home Page', 'better_front_page_ui' ),
            array( $this, 'output_setting_form' ), 'permalink', 'optional' );

        /*
         * sadly register_setting is useless in the permalink page, so we will
         * have to save it on our own
         */

        /* register_setting( 'permalink', self::$option_name, array($this, 'sanitize_option') ); */

        global $pagenow;
        if ( $pagenow == 'options-permalink.php' ) {
            if ( isset( $_POST[self::$option_name] ) ) {
                $value = $this->sanitize_option( $_POST[self::$option_name] );
                update_option( self::$option_name, $value );
            } else {
                delete_option( self::$option_name );
            }
        }
    }

    function sanitize_option( $value ) {
        return sanitize_title( $value );
    }

    function output_setting_form() {
        $option = $this->get_option();
        ?>
        <p class="better-front-page-ui-posts-page"><label>
            <?php echo home_url(); ?>/<input name="<?php echo self::$option_name; ?>" type="text" value="<?php echo $option; ?>" class="tog" />
        </label></p>
        <p class="description"><?php _e( 'This will be the home for your posts', 'better_front_page_ui' ); ?></p>
        <style type="text/css">
            .better-front-page-ui-posts-page input { float:none !important; }
        </style>
        <?php
    }

    /* ok, This is ugly */
    function remove_reading_option() {
        ?>
        <script>
        jQuery(document).ready(function() { jQuery('#front-static-pages').parent('tr').remove() });
        </script>
        <?php
    }

}

function better_front_page_ui_init() {
    /* This plugin only makes sense if you have a front_page.php in your theme */
    if ( file_exists( get_stylesheet_directory() . '/front-page.php' ) )
        new Better_Front_Page_UI();
}
add_action( 'plugins_loaded', 'better_front_page_ui_init' );

register_activation_hook( __FILE__, array( 'Better_Front_Page_UI', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Better_Front_Page_UI', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'Better_Front_Page_UI', 'uninstall' ) );

function the_posts_home_url() {
    $output = get_the_posts_home_url();
    if ($output)
        echo $output;
}

function get_the_posts_home_url() {
    if (class_exists('Better_Front_Page_UI'))
        return home_url( get_option( Better_Front_Page_UI::$option_name ) );
    else
        return false;
}
