<?php

/*
  Plugin Name: CM Product Directory Pro
  Plugin URI: https://www.cminds.com/cm-product-directory
  Description: Build, organize and display a local directory of product.
  Version: 1.1.11
  Author: CreativeMindsSolutions
  Author URI: https://www.cminds.com/
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class file.
 * What it does:
 * - checks which part of the plugin should be affected by the query frontend or backend and passes the control to the right controller
 * - manages installation
 * - manages uninstallation
 * - defines the things that should be global in the plugin scope (settings etc.)
 * @author CreativeMindsSolutions - Marcin Dudek
 */
class CMProductDirectory {

	public static $calledClassName;
	protected static $instance	 = NULL;
	public static $isLicenseOK	 = NULL;

	const SHORTCODE_PAGE_OPTION  = 'cmpd_shortcode_page_id';
	public static $blankThumbnailId 		 = NULL;

	/**
	 * Main Instance
	 *
	 * Insures that only one instance of class exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0
	 * @static
	 * @staticvar array $instance
	 * @return The one true AKRSubscribeNotifications
	 */
	public static function instance()
	{
		$class = __CLASS__;
		if ( !isset( self::$instance ) && !( self::$instance instanceof $class ) )
		{
			self::$instance = new $class;
		}
		return self::$instance;
	}

	public function __construct()
	{

		if ( empty( self::$calledClassName ) )
		{
			self::$calledClassName = __CLASS__;
		}

		self::setupConstants();

		// Shared
		include_once CMPD_PLUGIN_DIR . '/shared/classes/Labels.php';
		include_once CMPD_PLUGIN_DIR . '/backend/classes/Settings.php';
		include_once CMPD_PLUGIN_DIR . '/shared/cm-product-directory-shared.php';
		$CMProductDirectorySharedInstance = CMProductDirectoryShared::instance();

		include_once CMPD_PLUGIN_DIR . '/package/cminds-pro.php';

		global $cmpd_isLicenseOk;
		self::$isLicenseOK = $cmpd_isLicenseOk;

		if ( is_admin() )
		{
			// Backend
			add_action( 'after_setup_theme', array( __CLASS__, 'baw_theme_setup' ) );
			include_once CMPD_PLUGIN_DIR . '/backend/cm-product-directory-backend.php';
			$CMProductDirectoryBackendInstance = CMProductDirectoryBackend::instance();
            include_once CMPD_PLUGIN_DIR . '/backend/cm-product-directory-page-count-backend.php';
            $CMProductPageCountBackend = CMProductPageCountBackend::instance();
		}
		else
		{
			if ( self::$isLicenseOK )
			{
				include_once CMPD_PLUGIN_DIR . '/frontend/cm-product-directory-product-page-sc.php';
				include_once CMPD_PLUGIN_DIR . '/frontend/cm-product-directory-product-page.php';

				add_filter( 'single_template', array( 'CMProductDirectoryProductPage', 'get_custom_post_type_template' ) );

				// Frontend
				include_once CMPD_PLUGIN_DIR . '/frontend/cm-product-directory-frontend.php';
				$CMProductDirectoryFrontendInstance = CMProductDirectoryFrontend::instance();

                /*
                 * Page visit and transition shortcodes
                 */
                include_once CMPD_PLUGIN_DIR . '/frontend/cm-product-directory-page-count-sc.php';
                $CMPDPageCountShortcodesInstance = CMPDPageCountShortcodes::instance();
			}
		}

        /*
         * Page visit and transition count
         */
        include_once CMPD_PLUGIN_DIR . '/frontend/cm-product-directory-page-count.php';
        $CMProductDirectoryPageCount = CMProductDirectoryPageCount::instance();

	}

	public static function get_meta_from_assigned( $result, $key, $id )
	{
		// List of meta values to ignore when importing from Business
		$product_fields = array(
			'cmpd_product_image_gallery',
			'cmpd_product_cost',
			'cmpd_purchase_link',
			'cmpd_demo_link',
			'cmpd_product_page',
			'cmpd_product_video',
			'cmpd_product_gallery_id',
			'cmpd_product_pitch',
			'cmpd_promoted',
			'cmpd_add_link1',
			'cmpd_add_link2',
			'cmpd_add_link3',
			'cmpd_add_link4',
			'cmpd_add_address_field',
			'cmpd_add_google_map',
			'cmpd_product_gallery',
			'cmpd_add_field1',
			'cmpd_add_field2',
			'cmpd_add_field3',
			'cmpd_add_field4',
		);

		/* @param $id = Product ID */
		/* @param $assigned = Business ID */
		$assigned = get_post_meta( $id, 'cmpd_assign_business', true );
		if ( $assigned )
		{
			$business_key	= str_replace( 'cmpd', 'cmbd', $key );
			if ( !in_array( $key, $product_fields ) )
			{
				// Save Business Title as meta for Product
				if ( 'cmpd_company_name' == $key )
				{
					$result = get_the_title( $assigned );
				}
				else
				{
					// Get rest of values from meta
					$result = get_post_meta( $assigned, $business_key, true );
				}
			}
		}
		return $result;
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.1
	 * @return void
	 */
	private static function setupConstants() {
		/**
		 * Define Plugin Version
		 *
		 * @since 1.0
		 */
		if ( !defined( 'CMPD_VERSION' ) ) {
			define( 'CMPD_VERSION', '1.1.11' );
		}

		/**
		 * Define Plugin Directory
		 *
		 * @since 1.0
		 */
		if ( !defined( 'CMPD_PLUGIN_DIR' ) ) {
			define( 'CMPD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Define Plugin URL
		 *
		 * @since 1.0
		 */
		if ( !defined( 'CMPD_PLUGIN_URL' ) ) {
			define( 'CMPD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		/**
		 * Define Plugin File Name
		 *
		 * @since 1.0
		 */
		if ( !defined( 'CMPD_PLUGIN_FILE' ) ) {
			define( 'CMPD_PLUGIN_FILE', __FILE__ );
		}

		/**
		 * Define Plugin Slug name
		 *
		 * @since 1.0
		 */
		if ( !defined( 'CMPD_SLUG_NAME' ) ) {
			define( 'CMPD_SLUG_NAME', 'cm-product-directory' );
		}


		/**
		 * Define Plugin name
		 *
		 * @since 1.0
		 */
		if ( !defined( 'CMPD_NAME' ) ) {
			define( 'CMPD_NAME', 'CM Product Directory Pro' );
		}

		/**
		 * Define Plugin basename
		 *
		 * @since 1.0
		 */
		if ( !defined( 'CMPD_PLUGIN' ) ) {
			define( 'CMPD_PLUGIN', plugin_basename( __FILE__ ) );
		}

		/**
		 * Define Plugin code
		 *
		 * @since 1.0
		 */
		if ( !defined( 'CMPD_CODE' ) ) {
			define( 'CMPD_CODE', 'cmpd' );
		}

		/**
		 * Define Plugin code
		 *
		 * @since 1.0
		 */
		if ( !defined( 'CMPD_URL' ) ) {
			define( 'CMPD_URL', 'https://www.cminds.com/store/purchase-cm-product-directory-plugin-for-wordpress/' );
		}

		/**
		 * Define Plugin release notes url
		 *
		 * @since 1.0
		 */
		if ( !defined( 'CMPD_RELEASE_NOTES' ) ) {
			define( 'CMPD_RELEASE_NOTES', 'https://www.cminds.com/store/purchase-cm-product-directory-plugin-for-wordpress/' );
		}
	}

	public static function baw_theme_setup() {
		add_image_size( 'cmpd_image', 255, 255, true );

		add_image_size( 'cmpd_image_big', 300, 300, array( 'center', 'center' ) );
		add_image_size( 'cmpd_image_medium', 200, 200, array( 'center', 'center' ) );
		add_image_size( 'cmpd_image_small', 100, 100, array( 'center', 'center' ) );
	}

	public static function _install() {
		global $user_ID;

		if ( !get_option( self::SHORTCODE_PAGE_OPTION ) ) {
			$page[ 'post_type' ]		= 'page';
			$page[ 'post_content' ]	 	= '[cmpd_product]';
			$page[ 'post_parent' ]	 	= 0;
			$page[ 'post_author' ]	 	= $user_ID;
			$page[ 'comment_status' ]	= 'closed';
			$page[ 'post_status' ]	 	= 'publish';
			$page[ 'post_title' ]		= CMPD_NAME;

			$pageid = wp_insert_post( $page );
			add_option( self::SHORTCODE_PAGE_OPTION, $pageid );
		}
		CMProductDirectoryShared::install();
		return;
	}

	public static function _uninstall() {
		return;
	}

	public function registerAjaxFunctions() {
		return;
	}

	/**
	 * Get localized string.
	 *
	 * @param string $msg
	 * @return string
	 */
	public static function __( $msg ) {
		return __( $msg, CMPD_SLUG_NAME );
	}

	/**
	 * Get product meta
	 *
	 * @param string $msg
	 * @return string
	 */
	public static function meta( $id, $key, $default = null )
	{
		$result = get_post_meta( $id, $key, true );
		if ( $default !== null )
		{
			$result = !empty( $result ) ? $result : $default;
		}
		// Get values from Business if assigned
		$result = apply_filters( 'assigned_business', $result, $key, $id );

		return $result;
	}

}

/**
 * The main function responsible for returning the one true plugin class
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $marcinPluginPrototype = MarcinPluginPrototypePlugin(); ?>
 *
 * @since 1.0
 * @return object The one true CM_Micropayment_Platform Instance
 */
function CMProductDirectoryInit() {
	return CMProductDirectory::instance();
}

$CMProductDirectory = CMProductDirectoryInit();

register_activation_hook( __FILE__, array( 'CMProductDirectory', '_install' ) );
register_deactivation_hook( __FILE__, array( 'CMProductDirectory', '_uninstall' ) );


/* Star Rating */
include_once plugin_dir_path(__FILE__).'classes/cm-star-rating.php';
include_once plugin_dir_path(__FILE__).'classes/cm-star-rating-config.php';

$CMPD_StarRating = new CMStarRating($cmpd_config);