<?php

class MapasCulturais2Post {

	// URL base para a API
	var $api_base_url = '';
	
	static function init() {
	
		// cria metabox
		add_action('add_meta_boxes', array(__CLASS__, 'addMetaBox'));
        
		// hook para salvar infos do metabox
		add_action('save_post', array(__CLASS__, 'savePost'));
		
		// hooks ajax para pegar informações no mapas culturais
		add_action('wp_ajax_mapas_check_event_url', array(__CLASS__, 'ajax_check_event_url'));
		add_action('wp_ajax_mapas_get_event_info', array(__CLASS__, 'ajax_get_event_info'));
		add_action('wp_ajax_mapas_get_event_image', array(__CLASS__, 'ajax_get_event_image'));
		
		
		add_action('admin_enqueue_scripts', array(__CLASS__, 'add_JS'));
	}
	
	static function add_JS($hook) {
		global $post;

		if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
			if ( 'post' === $post->post_type || 'noticias' === $post->post_type ) {     
				wp_enqueue_script(  'mapasculturais2post', get_stylesheet_directory_uri().'/includes/mapasculturais2post/admin.js' );
			}
		}
	}
	
	static function ajax_get_event_image() {
	
		require_once('importimages.php');
		$post_id = $_POST['post_id'];
		$image_url = $_POST['image_url'];
		$post_title = str_replace(dirname($image_url) . '/', '', $image_url);
		global $wpdb;
		
		$checkExists = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_parent = %d AND post_type = 'attachment' AND post_title = %s", $post_id, $post_title));
		
		if (!$checkExists) {
			$newatt = array(
				'post_date_gmt' => $post->post_date_gmt, 
				'post_title' => str_replace(dirname($image_url) . '/', '', $image_url),
				'post_status' => 'publish', 
				'post_parent' => $post_id,
				'post_type' => 'attachment'
			);
			
			process_attachment( $newatt, $image_url );
		}
		
		die;
	
	}
	
	static function ajax_get_event_info() {
	
		header('Content-Type: application/json');
		$event_url = $_POST['event_url'];
		$event_info = self::api_get_event_info($event_url);
		echo json_encode($event_info);
		die;
	
	}
	
	static function ajax_check_event_url() {
		
		$event_url = $_POST['event_url'];
		$valid = self::parse_event_url($event_url);
		
		if ($valid)
			echo 'ok';
		else
			echo 'erro';
		
		die;
	}
	
	static function api_get_event_info($event_url) {
		
		if ($event_id = self::parse_event_url($event_url)) {
			
			$event_json = self::api_request_event($event_id);
			
			if ($event_json)
				return self::parse_event_json($event_json);
			
		}
		
		return false;
		
	}
	
	static function parse_event_json($event_json) {
		
		return array(
			'title' => 'Titulo de evento teste',
			'short_description' => 'Descricao curta noo nononono noonononon onononono nonoon',
			'description' => 'Descricao nononono noonnoononoo nononono noonnoononoo nononono noonnoononoo nononono noonnoononoo nononono noonnoononoo nononono noonnoononoo nononono noonnoononoo nononono noonnoononoo nononono noonnoononoo nononono noonnoononoo nononono noonnoononoo nononono noonnoononoo',
			'date' => '22/05/2014',
			'time' => '11:00',
			'place' => 'Palco Santa Ifigenia',
			'place_id' => 12,
			//'thumbnail' => 'http://mapasculturais.hacklab.com.br//files/event/8/file/3345/siba-serralheria_sp-3-5e5f9305f9bf5ef9af51b837c2b694db.jpg',
			'photos' => array(
				'http://mapasculturais.hacklab.com.br//files/event/8/siba-serralheria_sp.jpg',
				'http://mapasculturais.hacklab.com.br//files/agent/173/file/1206/a_firma-8712ab9cd68f5478f62e4c19f2489308.jpg'
			)
			
		);
		
	}
	
	static function parse_event_url($event_url) {
		if ($event_url == 'teste_erro')
			return false;
		else
			return 10;
		
	}
	
	
	static function api_request_event($event_id) {
	
		return 'json...';
	
	}
	
	static function addMetaBox() {
        
        $pts = array('post', 'noticias');        
			foreach ($pts as $pt) {
				add_meta_box(
				'mapasculturais',
				'Informações do SP Cultura',
				array(__CLASS__, 'metabox'), 
				$pt,
				'normal'
				
			);
		}
        
        
    }
    
    static function metabox(){
        global $post;
        
        wp_nonce_field( 'save_'.__CLASS__, __CLASS__.'_noncename' );
        
        $metadata = get_metadata('post', $post->ID);
        
        ?>
        
        <label>URL do evento no SP Cultura</label>
        <br />
        <input type="text" id="mapas_url_evento" name="<?php echo __CLASS__ ?>[mapas_url_evento]"  value="<?php echo $metadata['mapas_url_evento'][0]; ?>">
        <input type="button" value="Buscar informações do SP Cultura" id="mapas_button" />
        
        <hr />
		
		<div id="mapas_loading" style="display:none">Carregando...</div>
		<div id="mapas_loading_images" style="display:none">Importando imagens...</div>
		
        <div id="mapas_fields">
			
			<label> Título do evento: <input type="text" name="<?php echo __CLASS__ ?>[mapas_titutlo]" id="mapas_titutlo" value="<?php echo $metadata['mapas_titutlo'][0]; ?>" /></label>
			<br/>
			<label> Descrição curta: <input type="text" name="<?php echo __CLASS__ ?>[mapas_descri_curta]" id="mapas_descri_curta" value="<?php echo $metadata['mapas_descri_curta'][0]; ?>" /></label>
			<br/>
			<label> Descrição completa: <textarea name="<?php echo __CLASS__ ?>[mapas_descri_completa]" id="mapas_descri_completa"><?php echo $metadata['mapas_descri_completa'][0]; ?></textarea></label>
			<br/>
			<label> Data: <input type="text" name="<?php echo __CLASS__ ?>[mapas_data]" id="mapas_data" value="<?php echo $metadata['mapas_data'][0]; ?>" /></label>
			<br/>
			<label> Hora: <input type="text" name="<?php echo __CLASS__ ?>[mapas_hora]" id="mapas_hora" value="<?php echo $metadata['mapas_hora'][0]; ?>" /></label>
			<br/>
			<label> Local: <input type="text" name="<?php echo __CLASS__ ?>[mapas_local]" id="mapas_local" value="<?php echo $metadata['mapas_local'][0]; ?>" /></label>
			<br/>
			<label> ID do Local: <input type="text" name="<?php echo __CLASS__ ?>[mapas_local_id]" id="mapas_local_id" value="<?php echo $metadata['mapas_local_id'][0]; ?>" /></label>
			
        </div>
        <?php
    }
    
    static function filterValue($meta_key, $value){
        global $post;
		return $value;
		/*
        switch ($meta_key){
            case 'outro_dado':
                return strtoupper($value);
            break;
        
            default:
                return $value;
            break;
        }
        */
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

MapasCulturais2Post::init();
