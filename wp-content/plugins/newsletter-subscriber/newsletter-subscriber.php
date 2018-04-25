<?php
/**
 * Plugin name: Newsletter Subscribber
 * Description: A form to subscribe to a newsletter
 * Version: 1.0
 * Author: Brad Traversy
 */

//exit if accesed directly
if(!defined('ABSPATH')){
    exit;
}

//Load scripts
require_once(plugin_dir_path(__FILE__) ."/includes/newsletter-subscriber-scripts.php");

//Load Class
require_once(plugin_dir_path(__FILE__) ."/includes/newsletter-subscriber-class.php");

//Register Widget
function register_newsletter_subscriber(){
    register_widget('Newsletter_Subscriber_Widget');
}
add_action('widgets_init', 'register_newsletter_subscriber');