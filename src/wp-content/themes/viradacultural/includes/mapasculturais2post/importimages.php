<?php


/**** Configurar aqui ******/

$id_do_blog = 6; // Coloque aqui o ID do blog de esportes
$slug_do_blog = 'esporte';

/**************************/
#include('wp-load.php');

#require_once ABSPATH . 'wp-admin/includes/import.php';
#require_once ABSPATH . 'wp-admin/includes/image.php';  


#global $url_remap;
#$url_remap = array();



//backfill_attachment_urls();


function fetch_remote_file( $url, $post ) {
    
    global $url_remap;
    
    // extract the file name and extension from the url
    $file_name = basename( $url );

    // get placeholder file in the upload dir with a unique, sanitized filename
    $upload = wp_upload_bits( $file_name, 0, '', $post['upload_date'] );
    if ( $upload['error'] )
        return new WP_Error( 'upload_dir_error', $upload['error'] );

    // fetch the remote url and write it to the placeholder file
    $headers = wp_get_http( $url, $upload['file'] );

    // request failed
    if ( ! $headers ) {
        @unlink( $upload['file'] );
        return new WP_Error( 'import_file_error', __('Remote server did not respond', 'wordpress-importer') );
    }

    // make sure the fetch was successful
    if ( $headers['response'] != '200' ) {
        @unlink( $upload['file'] );
        return new WP_Error( 'import_file_error', sprintf( __('Remote server returned error response %1$d %2$s', 'wordpress-importer'), esc_html($headers['response']), get_status_header_desc($headers['response']) ) );
    }

    $filesize = filesize( $upload['file'] );

    if ( isset( $headers['content-length'] ) && $filesize != $headers['content-length'] ) {
        @unlink( $upload['file'] );
        return new WP_Error( 'import_file_error', __('Remote file is incorrect size', 'wordpress-importer') );
    }

    if ( 0 == $filesize ) {
        @unlink( $upload['file'] );
        return new WP_Error( 'import_file_error', __('Zero size file downloaded', 'wordpress-importer') );
    }

    
    // keep track of the old and new urls so we can substitute them later
    $url_remap[$url] = $upload['url'];


    return $upload;
}


function process_attachment( $post, $url ) {
    
    // if the URL is absolute, but does not contain address, then upload it assuming base_site_url
    //if ( preg_match( '|^/[\w\W]+$|', $url ) )
    //	$url = rtrim( $this->base_url, '/' ) . $url;
    
    global $url_remap;
    
    $upload = fetch_remote_file( $url, $post );
    if ( is_wp_error( $upload ) )
        return $upload;

    if ( $info = wp_check_filetype( $upload['file'] ) )
        $post['post_mime_type'] = $info['type'];
    else
        return new WP_Error( 'attachment_processing_error', __('Invalid file type', 'wordpress-importer') );

    $post['guid'] = $upload['url'];

    // as per wp-admin/includes/upload.php
    $post_id = wp_insert_attachment( $post, $upload['file'] );
    wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );

    // remap resized image URLs, works by stripping the extension and remapping the URL stub.
    if ( preg_match( '!^image/!', $info['type'] ) ) {
        $parts = pathinfo( $url );
        $name = basename( $parts['basename'], ".{$parts['extension']}" ); // PATHINFO_FILENAME in PHP 5.2

        $parts_new = pathinfo( $upload['url'] );
        $name_new = basename( $parts_new['basename'], ".{$parts_new['extension']}" );

        $url_remap[$parts['dirname'] . '/' . $name] = $parts_new['dirname'] . '/' . $name_new;
    }

    return $post_id;
}


/*
function backfill_attachment_urls() {
    global $wpdb, $url_remap;
    // make sure we do the longest urls first, in case one is a substring of another
    uksort( $url_remap, array(&$this, 'cmpr_strlen') );

    print_r($url_remap);

    $blogs = get_blog_list(0, 'all');

    foreach ($blogs as $blog) {

        switch_to_blog($blog['blog_id']);


        foreach ( $url_remap as $from_url => $to_url ) {
        // remap urls in post_content
        $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_url) );
        // remap enclosure urls
        $result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='enclosure'", $from_url, $to_url) );
        }
    }
}
* */
?>

