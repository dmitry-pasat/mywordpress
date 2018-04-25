<?php
/**
 * Plugin name: My Todo List
 * Description: Simple Todo list plugin
 * Version: 1.0
 * Author: Brad Traversy
 */

//exit if accesed directly
if(!defined('ABSPATH')){
    exit;
}

//Load Scripts
require_once(plugin_dir_path(__FILE__).'/includes/my-todo-list-scripts.php');

//Load Shortcodes
require_once(plugin_dir_path(__FILE__).'/includes/my-todo-list-shortcodes.php');

//Check if Admin
if(is_admin()){
    //Load custom Post types
    require_once(plugin_dir_path(__FILE__).'/includes/my-todo-list-cpt.php');

    //Load Custom Fields
    require_once(plugin_dir_path(__FILE__).'/includes/my-todo-list-fields.php');
}
