<?php

class MinhaVirada {

    static $folder;
    
    static function init() {
		self::$folder = WP_CONTENT_DIR . '/uploads/minha-virada/';
        add_action('wp_ajax_minhavirada_get_user_events', array(__CLASS__, 'ajax_get_user_events'));
        add_action('wp_ajax_nopriv_minhavirada_get_user_events', array(__CLASS__, 'ajax_get_user_events'));
        
        add_action('wp_ajax_minhavirada_updateJSON', array(__CLASS__, 'ajax_update_JSON'));
        add_action('wp_ajax_nopriv_minhavirada_updateJSON', array(__CLASS__, 'ajax_update_JSON'));
        
    }

	// Essa função tem que ser chamada logo depois da abertura da tag body das páginas que vão usar a conexão com o facebook
    static function add_JS() {
        ?>
		<div id="fb-root"></div>
		<script>
			window.fbAsyncInit = function() {
				FB.init({
				appId      : '1460336737533597',
				status     : false,
				xfbml      : true
				});
			};

			(function(d, s, id){
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/pt_BR/all.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
        <?php
        
    }
    
    static function get_user_events($user_fb_id = null) {
		
		if (is_null($user_fb_id))
			return false;
		
		$data = self::loadJSON($user_fb_id);
		
		if ($data && isset($data->events) && is_array($data->events)) {
			foreach ($data->events as $k => $v)
				$data->events[$k] = intval($v);
			return $data->events;
		} else
			return false;
		
	}
	
	static function loadJSON($user_fb_id) {
		$file = self::$folder . $user_fb_id;
		if (file_exists($file)) {
			
			$handle = fopen($file, 'r');
			$data = fread($handle,filesize($file));
			fclose($handle);
			return json_decode($data);
			
		} else 
			return false;
	
	}
	
	static function ajax_get_user_events() {
		$user_events = self::get_user_events($_POST['userid']);
		
		if (!$user_events)
			$user_events = array();
		
		header('Content-Type: application/json');
		
		echo json_encode($user_events);
		
		die;
		
	}
	
	static function ajax_update_JSON() {
		if( is_array($_POST['dados'])) {
			$file = self::$folder . $_POST['dados']['uid'];
			$handle = fopen($file, 'w');
			fwrite($handle, json_encode($_POST['dados']));
			fclose($handle);
		}
		die;
	}

}

MinhaVirada::init();
#echo json_encode(array(123, '123'));
#var_dump(MinhaVirada::get_user_events(1158373728)); die;
