<?php

class MinhaVirada {

    static $folder;
    
    static function init() {
		#self::$folder = WP_CONTENT_DIR . '/uploads/minha-virada/';
        
        #add_action('wp_ajax_minhavirada_updateJSON', array(__CLASS__, 'ajax_update_JSON'));
        #add_action('wp_ajax_nopriv_minhavirada_updateJSON', array(__CLASS__, 'ajax_update_JSON'));
        
    }

	// Essa função tem que ser chamada logo depois da abertura da tag body das páginas que vão usar a conexão com o facebook
    static function add_JS() {
        ?>
		<div id="fb-root"></div>
        <?php
        
    }
    /*
	static function ajax_update_JSON() {
		if( is_array($_POST['dados'])) {
			if (isset($_POST['dados']['events']) && is_array($_POST['dados']['events'])) {
				foreach ($_POST['dados']['events'] as $k => $v)
					$_POST['dados']['events'][$k] = intval($v);
			}
			
			
			$_POST['dados']['modalDismissed'] = isset($_POST['dados']['modalDismissed']) && $_POST['dados']['modalDismissed'] == 'true' ? true : false;
			
			$file = self::$folder . $_POST['dados']['uid'];
			$handle = fopen($file, 'w');
			fwrite($handle, json_encode($_POST['dados']));
			fclose($handle);
		}
		die;
	}
    */
}

MinhaVirada::init();
