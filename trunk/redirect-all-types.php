<?php
/* 
Plugin Name: Redirect All Types
Plugin Author: Kyle G.
Plugin URI: http://www.wpinsideout.com/plugins/redirect-all-types
Author URI: http://www.wpinsideout.com
Version: 1.0
Description: This plugin will give you the ability to redirect not only posts and pages, but all custom post types.  It adds a meta box to all post, page, and all custom post types with a field to input a redirect.  
*/


//add the meta box
add_action("admin_init", "redirect_all_types_field");

function redirect_all_types_field(){

    global $wpdb;

    $dont_include = array('revision', 'attachment');

    $post_types = $wpdb->get_results("SELECT DISTINCT post_type FROM {$wpdb->prefix}posts", ARRAY_A);

    foreach($post_types as $type){
        if(!in_array($type['post_type'], $dont_include)){
            add_meta_box('redirection_meta', 'Redirect', "redirect_all_types_meta_options", $type['post_type'], "normal");
        }
    }
}

function redirect_all_types_meta_options(){
    global $post;

    $redirect = get_post_meta($post->ID, '_redirect_url', true);

    echo "<p><label for='redirect'>Redirect URL</label><input style='width:99%;' type='text' name='_redirect_url' value='{$redirect}' /></p>";
    
}


add_action('save_post', 'save_redirect_all_types_redirection');

function save_redirect_all_types_redirection(){
    global $post;

    update_post_meta($post->ID, '_redirect_url', $_POST['_redirect_url'], get_post_meta($post->ID, '_redirect_url', true));
}


//do the redirection
add_action('get_header', 'redirect_all_types_redirect');

function redirect_all_types_redirect () {
    
    global $post;

    $redirect = get_post_meta($post->ID, '_redirect_url', true);

    if (!empty($redirect) && ( is_single() || is_page() ) ) {
        header('Location: ' . $redirect);
    }
}
