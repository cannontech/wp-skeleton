<?php

/*
Plugin Name: Facebook Test
Version: 0.0.0.0.0.0.0.0.0.1
*/

define('FB_MIN_WORDPRESS_VERSION', '3.0');

define('FB_BUTTON_TEMPLATE', 
	'<div class="fb-like" data-href="%s" data-width="100" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>'
	);

//function _fb_button_get_post_description() {}
//function _fb_button_get_post_media_type() {}
//function _fb_button_get_post_title() {}
//function _fb_button_get_post_topic() {}

function _fb_button_get_post_url() {
	return get_permalink();
}

add_action('init', 'fb_check_wp_version');
add_action('init', 'fb_button_add_js_to_doc');
add_filter('the_content', 'fb_button_get_button');

function fb_button_add_js_to_doc(){

	$src = plugins_url('fb.js', __FILE__);
	wp_register_script('fb', $src);
	wp_enqueue_script('fb');
}

function fb_button_check_wordpress_version() {}

function fb_button_get_button($content) {

	//return $content . '<div class="fb-like" data-href="http://www.groceryshopping.net" data-width="100" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>';
	
	$url = urlencode(_fb_button_get_post_url());
	return $content . sprintf(FB_BUTTON_TEMPLATE, $url);
}

function fb_check_wp_version(){

	global $wp_version;

	$msg = 'Need WP version ' . FB_MIN_WORDPRESS_VERSION . ' or newer';

	if(version_compare($wp_version, FB_MIN_WORDPRESS_VERSION, '<')){
		exit($msg);
	}
}
/*eof*/