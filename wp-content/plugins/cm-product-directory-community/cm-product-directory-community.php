<?php

/*
  Plugin Name: CM Product Directory Community
  Plugin URI: https://www.cminds.com/store/cm-product-directory-community-addon-for-wordpress/
  Description: An extension to the CM Product Directory Plugin which allows users to add own product from the public site
  Version: 1.2.8
  Author: CreativeMindsSolutions
  Author URI: https://www.cminds.com/
 */

/**
 * Define Plugin Version
 *
 * @since 1.0
 */
if ( !defined( 'CMPDC_VERSION' ) ) {
	define( 'CMPDC_VERSION', '1.2.8' );
}

/**
 * Define Plugin Directory
 *
 * @since 1.0
 */
if ( !defined( 'CMPDC_PLUGIN_DIR' ) ) {
	define( 'CMPDC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Define Plugin URL
 *
 * @since 1.0
 */
if ( !defined( 'CMPDC_PLUGIN_URL' ) ) {
	define( 'CMPDC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Define Plugin File Name
 *
 * @since 1.0
 */
if ( !defined( 'CMPDC_PLUGIN_FILE' ) ) {
	define( 'CMPDC_PLUGIN_FILE', __FILE__ );
}

/**
 * Define Plugin Slug name
 *
 * @since 1.0
 */
if ( !defined( 'CMPDC_SLUG_NAME' ) ) {
	define( 'CMPDC_SLUG_NAME', 'cm-product-directory-community-product' );
}

/**
 * Define Plugin name
 *
 * @since 1.0
 */
if ( !defined( 'CMPDC_NAME' ) ) {
	define( 'CMPDC_NAME', 'CM Product Directory Community Items' );
}

/**
 * Define Plugin basename
 *
 * @since 1.0
 */
if ( !defined( 'CMPDC_PLUGIN' ) ) {
	define( 'CMPDC_PLUGIN', plugin_basename( __FILE__ ) );
}

/**
 * Define Plugin Views path
 */
if ( !defined( 'CMPDC_PLUGIN_DIR_VIEWS_PATH' ) ) {
	define( 'CMPDC_PLUGIN_DIR_VIEWS_PATH', plugin_dir_path( __FILE__ ) . 'views/' );
}

/**
 * Define Plugin Views path
 */
if ( !defined( 'CMPDC_PLUGIN_DIR_FRONTEND_SCRIPT_PATH' ) ) {
	define( 'CMPDC_PLUGIN_DIR_FRONTEND_SCRIPT_PATH', plugin_dir_url( __FILE__ ) . 'views/frontend/assets/' );
}
if ( !defined( 'CMPDC_PLUGIN_DIR_BACKEND_SCRIPT_PATH' ) ) {
	define( 'CMPDC_PLUGIN_DIR_BACKEND_SCRIPT_PATH', plugin_dir_url( __FILE__ ) . 'views/backend/assets/' );
}

/**
 * Define Plugin release notes url
 *
 * @since 1.0
 */
if ( !defined( 'CMPDC_RELEASE_NOTES' ) ) {
	define( 'CMPDC_RELEASE_NOTES', 'https://www.cminds.com/store/cm-product-directory-community-addon-for-wordpress/#changelog' );
}


// includes
include_once CMPDC_PLUGIN_DIR . 'cm-product-directory-community-base.php';
include_once CMPDC_PLUGIN_DIR . 'cm-product-directory-community-frontend.php';
include_once CMPDC_PLUGIN_DIR . 'cm-product-directory-community-backend.php';

// vendors
include_once CMPDC_PLUGIN_DIR . 'vendor/recaptcha.php';

// libs
include_once CMPDC_PLUGIN_DIR . 'libs/Notification.php';
include_once CMPDC_PLUGIN_DIR . 'libs/CMPDC_Cookie.php';
include_once CMPDC_PLUGIN_DIR . '/package/cminds-pro.php';

if ( class_exists( 'CMProductDirectoryCommunityProduct' ) ) {
	// Installation and uninstallation hooks
	register_activation_hook( __FILE__, array( 'CMProductDirectoryCommunityProduct', 'activate' ) );

	// instantiate the plugin class
	$CMProductDirectoryCommunityProduct = CMProductDirectoryCommunityProduct::getInstance();

	// User Dashboard
	include_once plugin_dir_path( __FILE__ ).'classes/cmpdc_user_dashboard.php';
	if ( class_exists( 'CMProductDirectoryCommunityUserDashboard' ) ) {
		$CMProductDirectoryCommunityUserDashboard = CMProductDirectoryCommunityUserDashboard::getInstance();
	}
}
