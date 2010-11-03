<?php
/*
Plugin Name: Simple Login Redirect
Plugin URI: http://www.wpinsideout.com/plugins/a-simple-redirect
Author: Kyle G.
Author URI: http://www.wpinsideout.com
Description: It adds a new field to the user profile that can contain a URL which will be used to redirect the user to a specific page upon a successful login.
Version:1.0
*/

class Simple_redirect {

	var $allowed_hosts = array();
	
	function add_allowed_host($hosts)
	{
		return array_merge($hosts, $this->allowed_hosts);
	}
	
	function add_host($host)
	{
		$this->allowed_hosts[] = $host;
	}
	function do_simple_redirect($redirect_to,  $requested_redirect_to)
	{
		global $user;
   		global $wpdb;
		
		$row = $wpdb->get_row("SELECT meta_value AS redirect FROM {$wpdb->prefix}usermeta WHERE meta_key = 'redirect_url' AND user_id = {$user->ID}");
   	
   		$redirect = $row->redirect;
		
		//THIS FUNCTION IS NOT IN VERSIONS OF WORDPRESS BEFORE 3.0
		//$redirect = get_user_meta($user->ID, 'redirect_url', TRUE);
   
		if(!empty($redirect)){
   
			$redirect_data 	= parse_url($redirect);
			$site_data 		= parse_url(get_option('home'));
   
			if($redirect_data['host'] == $site_data['host'])
			{
				return $redirect;
			}
			else
			{
				$this->add_host($redirect_data['host']);
   
				add_filter( 'allowed_redirect_hosts', array($this, 'add_allowed_host'));
   
				return $redirect;
			}
		}
		return $redirect_to;
	}
}

function login_redirect_field($user){
	$content = "<h3>Login Redirect</h3>\n";
	$content .= "<p>Please specific a URL to redirect this use.  If blank WordPress will just use the default action.</p>\n";
	$content .= "<table class='form-table'>\n";
	$content .= "<tr><th><label for='redirect_url'>" . __('Login Redirect URL') . "</th><td><input class='regular-text' type='text' name='redirect_url' id='redirect_url' value='" . esc_attr(get_user_meta($user->ID, 'redirect_url', TRUE)) . "' /></td></tr>\n";  
	$content .= "</table>\n";

	echo $content;	
}

function save_login_redirect($user_id){
	update_user_meta($user_id, 'redirect_url', $_POST['redirect_url'], get_user_meta($user->ID, 'redirect_url', TRUE));
}


add_action('edit_user_profile', 'login_redirect_field');
add_action('show_user_profile', 'login_redirect_field');

add_action('edit_user_profile_update', 'save_login_redirect');
add_action('personal_options_update', 'save_login_redirect');

$simple_redirect = new Simple_redirect;
add_filter('login_redirect', array($simple_redirect, 'do_simple_redirect'), 10, 2);