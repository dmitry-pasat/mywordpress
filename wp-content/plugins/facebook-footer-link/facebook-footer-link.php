<?php
/**
 * Plugin name: Facebook Footer Link
 * Description: Ads a Facebook profile link to the end of posts
 * Version: 1.0
 * Author: Brad Traversy
 */

//exit if accesed directly
if(!defined('ABSPATH')){
    exit;
}

//Global Options vVariable
$ffl_options = get_option('ffl_settings');

//Load Scripts
require_once(plugin_dir_path(__FILE__).'/includes/facebook-footer-link-scripts.php');

//Load Content
require_once(plugin_dir_path(__FILE__).'/includes/facebook-footer-link-content.php');

//Load Settings
if(is_admin()){
    require_once(plugin_dir_path(__FILE__).'/includes/facebook-footer-link-settings.php');
    require_once(plugin_dir_path(__FILE__).'/includes/facebook-footer-link-training.php');
}
