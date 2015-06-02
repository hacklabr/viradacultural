<?php
/*
Plugin Name: Styles and Scripts MD5
Plugin URI:
Description:
Author: Rafael Chaves Freitas
Version: 1.0
Author URI:
*/


add_action('wp_print_scripts', function(){
    global $wp_scripts;
    foreach($wp_scripts->registered as $script){
        $src = str_replace(get_bloginfo('url'),'',$script->src);

        if(preg_match('#^/?wp-content#',$src)){
            $fname = ABSPATH."/$src";
            $script->ver = $script->ver ? $script->ver . '.' . md5_file($fname) : md5_file($fname);
        }
    }
},100);


add_filter('bloginfo_url', function($output, $show){
    if($show !== 'stylesheet_url')
        return $output;

    $src = str_replace(get_bloginfo('url'),'',$output);
     if(preg_match('#^/?wp-content#',$src)){
        $fname = ABSPATH."/$src";
        $md5 = md5_file($fname);
    }

    return "$output?ver=$md5";
},100,2);