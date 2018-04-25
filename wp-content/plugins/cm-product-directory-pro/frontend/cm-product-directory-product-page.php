<?php

class CMProductDirectoryProductPage {

	public static $calledClassName;
	protected static $instance		 = NULL;
	protected static $cssPath		 = NULL;
	protected static $jsPath		 = NULL;
	protected static $viewsPath		 = NULL;
	private static $template_name	 = 'cm_ecommerce';
	private static $path;

	public static function instance() {
		$class = __CLASS__;
		if ( !isset( self::$instance ) && !( self::$instance instanceof $class ) ) {
			self::$instance = new $class;
		}
		return self::$instance;
	}

	public static function cmpd_add_meta() {
		if ( get_post() != null ) {
			echo '<link rel="canonical" href="' . esc_attr( get_permalink( get_post()->ID ) ) . '">';
		}
	}

	public static function cmpd_get_template_name() {
		$post	 = get_post();
		$name	 = CMProductDirectory::meta( $post->ID, 'cmpd_product_page_template' );
		if ( empty( $name ) OR $name == 0 ) {
			$name = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_PAGE_TEMPLATE );
		}
		return $name;
	}

	public static function cmpd_register_actions() {
		// Remove rel-canonical by deefault
		remove_action( 'wp_head', 'rel_canonical' );

		// Add own rel-canonical
		add_action( 'wp_head', array( __CLASS__, 'cmpd_add_meta' ) );
	}

	public static function cmpd_enqueue_templates_scripts() {
		//Registering Scripts & Styles for the FrontEnd tempalte
		wp_enqueue_style( 'cmpd-template-style', self::$cssPath . 'assets/css/style.css' );

		// include the javascript
		wp_enqueue_script( 'thickbox', null, array( 'jquery' ) );

		// include the thickbox styles
		wp_enqueue_style( 'thickbox.css', '/' . WPINC . '/js/thickbox/thickbox.css', null, '1.0' );

		// include template specified filters
		if ( method_exists( 'CMProductDirectoryProductPageView', 'cmpd_enqueue_template_scripts' ) ) {
			$template_name = self::cmpd_get_template_name();
			self::loadTemplateClass( $template_name );
			CMProductDirectoryProductPageView::cmpd_enqueue_template_scripts( self::$cssPath );
		}
	}

	public static function cmpd_register_template_filters() {
		add_filter( 'wp_enqueue_scripts', array( __CLASS__, 'cmpd_enqueue_templates_scripts' ) );
	}

	public static function cmpd_get_page_shortcodes() {
		$shortcodes = array(
			'cmpd_tags'						 => array( 'name' => 'Tags', 'callback' => array( 'CMPDProductPageShortcodes', 'outputTags' ) ),
			'cmpd_categories'				 => array( 'name' => 'Categories', 'callback' => array( 'CMPDProductPageShortcodes', 'outputCategories' ) ),
			'cmpd_post_title'				 => array( 'name' => 'Title', 'callback' => array( 'CMPDProductPageShortcodes', 'outputPostTitle' ) ),
			'cmpd_post_content'				 => array( 'name' => 'Content', 'callback' => array( 'CMPDProductPageShortcodes', 'outputPostContent' ) ),
			'cmpd_featured_image'			 => array( 'name' => 'Image', 'callback' => array( 'CMPDProductPageShortcodes', 'outputFeaturedImage' ) ),
			'cmpd_back_to_index_link'		 => array( 'name' => 'Backlink', 'callback' => array( 'CMPDProductPageShortcodes', 'outputBackLink' ) ),
			'cmpd_gallery'					 => array( 'name' => 'Gallery', 'callback' => array( 'CMPDProductPageShortcodes', 'outputGallery' ) ),
			'cmpd_image'					 => array( 'name' => 'Image', 'callback' => array( 'CMPDProductPageShortcodes', 'outputLogo' ) ),
			'cmpd_location'					 => array( 'name' => 'Location', 'callback' => array( 'CMPDProductPageShortcodes', 'outputLocation' ) ),
			'cmpd_location_shortcode'		 => array( 'name' => 'Location details', 'callback' => array( 'CMPDProductPageShortcodes', 'outputLocationShortcode' ) ),
			'cmpd_web_url'					 => array( 'name' => 'Web Url', 'callback' => array( 'CMPDProductPageShortcodes', 'outputWebUrl' ) ),
			'cmpd_email'					 => array( 'name' => 'E-mail', 'callback' => array( 'CMPDProductPageShortcodes', 'outputEmail' ) ),
			'cmpd_product_pitch'			 => array( 'name' => 'Pitch', 'callback' => array( 'CMPDProductPageShortcodes', 'outputProductPitch' ) ),
			'cmpd_company_name'				 => array( 'name' => 'Company Name', 'callback' => array( 'CMPDProductPageShortcodes', 'outputCompanyName' ) ),
			'cmpd_year_founded'				 => array( 'name' => 'Year Founded', 'callback' => array( 'CMPDProductPageShortcodes', 'outputYearFounded' ) ),
			'cmpd_facebook'					 => array( 'name' => 'Facebook', 'callback' => array( 'CMPDProductPageShortcodes', 'outputFacebook' ) ),
			'cmpd_twitter'					 => array( 'name' => 'Twitter', 'callback' => array( 'CMPDProductPageShortcodes', 'outputTwitter' ) ),
			'cmpd_alexa'					 => array( 'name' => 'Alexa', 'callback' => array( 'CMPDProductPageShortcodes', 'outputAlexa' ) ),
			'cmpd_google_plus'				 => array( 'name' => 'Google Plus', 'callback' => array( 'CMPDProductPageShortcodes', 'outputGooglePlus' ) ),
			'cmpd_linkedin'					 => array( 'name' => 'LinedIn', 'callback' => array( 'CMPDProductPageShortcodes', 'outputLinkedIn' ) ),
			'cmpd_phone'					 => array( 'name' => 'Phone', 'callback' => array( 'CMPDProductPageShortcodes', 'outputPhone' ) ),
			'cmpd_rss'						 => array( 'name' => 'RSS', 'callback' => array( 'CMPDProductPageShortcodes', 'outputRSS' ) ),
			'cmpd_add_links'				 => array( 'name' => 'Additional Links', 'callback' => array( 'CMPDProductPageShortcodes', 'outputAddLinks' ) ),
			'cmpd_add_fields'				 => array( 'name' => 'Additional Fields', 'callback' => array( 'CMPDProductPageShortcodes', 'outputAddFields' ) ),
			'cmpd_googla_map'				 => array( 'name' => 'Google Map', 'callback' => array( 'CMPDProductPageShortcodes', 'outputGoogleMap' ) ),
			'cmpd_related_product'			 => array( 'name' => 'Related Products', 'callback' => array( 'CMPDProductPageShortcodes', 'outputRelatedProduct' ) ),
			'cmpd_additions'				 => array( 'name' => 'Additons', 'callback' => array( 'CMPDProductPageShortcodes', 'outputAdditions' ) ),
			'cmpd_product_cost'				 => array( 'name' => 'Product Cost', 'callback' => array( 'CMPDProductPageShortcodes', 'output_product_cost' ) ),
			'cmpd_purchase_link'			 => array( 'name' => 'Purchase Link', 'callback' => array( 'CMPDProductPageShortcodes', 'output_purchase_link' ) ),
			'cmpd_demo_link'				 => array( 'name' => 'Demo Link', 'callback' => array( 'CMPDProductPageShortcodes', 'output_demo_link' ) ),
			'cmpd_product_page'				 => array( 'name' => 'Product Page', 'callback' => array( 'CMPDProductPageShortcodes', 'output_product_page' ) ),
			'cmpd_product_video'			 => array( 'name' => 'Product Video', 'callback' => array( 'CMPDProductPageShortcodes', 'output_product_video' ) ),
			'cmpd_product_gallery'			 => array( 'name' => 'Product Gallery', 'callback' => array( 'CMPDProductPageShortcodes', 'output_product_gallery' ) ),
			'cmpd_display_dates'			 => array( 'name' => 'Dates', 'callback' => array( 'CMPDProductPageShortcodes', 'output_dates' ) ),
			'cmpd_display_categories'		 => array( 'name' => 'Categories', 'callback' => array( 'CMPDProductPageShortcodes', 'output_categories' ) ),
			'cmpd_display_pricing_models'	 => array( 'name' => 'Pricing Models', 'callback' => array( 'CMPDProductPageShortcodes', 'output_pricing_models' ) ),
			'cmpd_display_language_supports' => array( 'name' => 'Lanugage Supports', 'callback' => array( 'CMPDProductPageShortcodes', 'output_language_supports' ) ),
			'cmpd_display_target_audiences'	 => array( 'name' => 'Target Audiences', 'callback' => array( 'CMPDProductPageShortcodes', 'output_target_audiences' ) ),
			'cmpd_display_tags'				 => array( 'name' => 'Tags', 'callback' => array( 'CMPDProductPageShortcodes', 'output_tags' ) ),
			'cmpd_star_rating_top'			 => array( 'name' => 'Star Rating(top)', 'callback' => array( 'CMPDProductPageShortcodes', 'output_star_rating_top' ) ),
			'cmpd_star_rating_bottom'		 => array( 'name' => 'Star Rating(bottom)', 'callback' => array( 'CMPDProductPageShortcodes', 'output_star_rating_bottom' ) ),
		);

		return $shortcodes;
	}

	public static function cmpd_register_page_shortcodes() {

		$shortcodes = self::cmpd_get_page_shortcodes();

		foreach ( $shortcodes as $k => $v ) {
			add_shortcode( $k, $v[ 'callback' ] );
		}
	}

	public static function get_custom_post_type_template( $single_template ) {
		global $post;

		if ( $post->post_type == 'cm-product' ) {

			do_action( 'cmpd_before_custom_template' );

			self::cmpd_register_template_filters();
			self::$template_name = self::cmpd_get_template_name();
			$found				 = self::locateTemplate( array( self::$template_name . '/product-page-view' ) );
			$wp_template_dir	 = get_stylesheet_directory();
			if ( empty( $found ) ) { // Load default template
				self::$path		 = CMPD_PLUGIN_DIR . 'frontend/templates/' . self::$template_name . '/';
				self::$cssPath	 = CMPD_PLUGIN_URL . 'frontend/templates/' . self::$template_name . '/';
			} else {
				self::$path		 = $wp_template_dir . '/CMPD/' . self::$template_name . '/';
				self::$cssPath	 = get_stylesheet_directory_uri() . '/CMPD/' . self::$template_name . '/';
			}

			self::loadTemplateClass( self::$template_name );

			// Load template
			$single_template = self::$path . 'views/product-page.phtml';
		}
		return $single_template;
	}

	/**
	 * Load html for given view
	 *
	 * @param unknown $view
	 * @param string $html
	 * @return string
	 */
	public static function loadTemplateView( $file, $data = null, $html = false ) {
		$file = 'product-page-' . $file;

		ob_start();
		if ( !empty( $data ) )
			extract( $data );
		include_once self::$path . 'views/' . $file . '.phtml';
		$content = ob_get_clean();

		if ( $html ) {
			return $content;
		} else {
			echo $content;
		}
	}

	public static function loadTemplateClass( $template_name ) {
		include_once self::$path . '/product-page-view.php';
	}

	/**
	 * Locate the template file, either in the current theme or the public views directory
	 *
	 * @static
	 * @param array $possibilities
	 * @param string $default
	 * @return string
	 */
	protected static function locateTemplate( $possibilities, $default = '' ) {
		/*
		 *  check if the theme has an override for the template
		 */
		$theme_overrides = array();
		foreach ( $possibilities as $p ) {
			$theme_overrides[] = 'CMPD/' . $p . '.php';
		}
		if ( $found = locate_template( $theme_overrides, FALSE ) ) {
			return $found;
		}

		/*
		 *  check for it in the public directory
		 */
		foreach ( $possibilities as $p ) {
			if ( file_exists( CMPD_PLUGIN_DIR . 'frontend/templates/' . $p . '/product-page-view.php' ) ) {
				// echo " file exists ";
				return CMPD_PLUGIN_DIR . 'frontend/templates/' . $p . '/product-page-view.php';
			}
		}

		/*
		 *  we don't have it
		 */
		return $default;
	}

	public static function getProductGallery( $post_id, $size = null ) {
		$image_id	 = CMProductDirectory::meta( $post_id, 'cmpd_product_gallery_id' );
		$images		 = array();

		if ( !empty( $image_id ) ) {

			$imageArray = array(
				'thumb'				 => wp_get_attachment_image_src( $image_id ),
				'large'				 => wp_get_attachment_image_src( $image_id, 'large' ),
				'cmpd_image'		 => wp_get_attachment_image_src( $image_id, 'cmpd_image' ),
				'cmpd_image_big'	 => wp_get_attachment_image_src( $image_id, 'cmpd_image_big' ),
				'cmpd_image_medium'	 => wp_get_attachment_image_src( $image_id, 'cmpd_image_medium' ),
				'cmpd_image_small'	 => wp_get_attachment_image_src( $image_id, 'cmpd_image_small' ),
			);

			if ( !empty( $size ) && is_array( $size ) ) {
				$imageArray[ 'cmpd_image_custom' ] = wp_get_attachment_image_src( $image_id, $size );
			}

			$images[] = $imageArray;
		}

		return $images;
	}

	public static function getRelatedProduct() {
		$post		 = get_post();
		$categories	 = (array) wp_get_post_terms( $post->ID, CMProductDirectoryShared::POST_TYPE_TAXONOMY );
		$tmp_cat	 = array();
		foreach ( $categories as $cat ) {
			$tmp_cat[] = $cat->term_id;
		}
		$categories	 = $tmp_cat;
		$number		 = CMPD_Settings::getOption( CMPD_Settings::OPTION_RELATEDPRODUCT_NUMBER );
		$showCat	 = CMPD_Settings::getOption( CMPD_Settings::OPTION_RELATEDPRODUCT_CAT );
		if ( !is_int( $number ) ) {
			$number = 5;
		}
		$args	 = array();
		$post_id = get_post()->ID;
		if ( !empty( $showCat ) ) {
			$args = array( 'posts_per_page' => $number,
				'post_type'		 => CMProductDirectoryShared::POST_TYPE,
				'post__not_in'	 => array( $post_id ),
				'meta_key'		 => 'cmpd_promoted', //promoted
				'orderby'		 => array( 'meta_value' => 'ASC', 'rand' => 'post_title' ), //promoted
			);
			if ( !empty( $categories ) ) { //because notice on product page
				$args[ 'tax_query' ] = array(
					'relation' => 'AND',
					array(
						'taxonomy'	 => CMProductDirectoryShared::POST_TYPE_TAXONOMY,
						'field'		 => 'term_id',
						'terms'		 => $categories,
					),
				);
			}
		} else {
			$args = array( 'posts_per_page' => $number,
				'post_type'		 => CMProductDirectoryShared::POST_TYPE,
				'post__not_in'	 => array( $post_id ),
				'meta_key'		 => 'cmpd_promoted', //promoted
				'orderby'		 => array( 'meta_value' => 'ASC', 'rand' => 'post_title' ), //promoted
			);
		}
		$product = get_posts( $args );

		$return	 = array();
		$count	 = 0;
		foreach ( $product as $product ) {
			$meta = CMProductDirectory::meta( $product->ID, 'cmpd_product_pitch' );
			if ( !empty( $meta ) ) {
				$meta	 = strip_tags( $meta );
				$meta	 = substr( $meta, 0, 300 );
			} else {
				$meta = ' ';
			}

			if ( $product->ID != $post_id ) {
				$return[ $count ][ 'images' ]	 = CMProductDirectoryProductPage::getProductGallery( $product->ID );
				$return[ $count ][ 'name' ]		 = $product->post_title;
				$return[ $count ][ 'id' ]		 = $product->ID;
				$return[ $count ][ 'pitch' ]	 = $meta;
				$count++;
			}
		}

		return $return;
	}

}
