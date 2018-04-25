<?php
/**
 * Plugin name: Social Links
 * Description: Ads Social Icons with links to profiles
 * Version: 1.0
 * Author: Brad Traversy
 */

//exit if accesed directly
if(!defined('ABSPATH')){
    exit;
}

//Load scripts
require_once(plugin_dir_path(__FILE__) ."/includes/social-links-scripts.php");

//Load Class
require_once(plugin_dir_path(__FILE__) ."/includes/social-links-class.php");

//Register Widget
function register_social_links(){
    register_widget('Social_Links_Widget');
}
add_action('widgets_init', 'register_social_links');