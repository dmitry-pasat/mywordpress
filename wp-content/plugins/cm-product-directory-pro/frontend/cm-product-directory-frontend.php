<?php

class CMProductDirectoryFrontend {

    public static $calledClassName;
    protected static $instance  = NULL;
    protected static $cssPath   = NULL;
    protected static $jsPath    = NULL;
    protected static $viewsPath = NULL;
    protected static $viewsUrl  = NULL;

    public static function instance() {
        $class = __CLASS__;
        if ( !isset( self::$instance ) && !( self::$instance instanceof $class ) ) {
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function __construct() {
        if ( empty( self::$calledClassName ) ) {
            self::$calledClassName = __CLASS__;
        }

        self::$cssPath   = CMPD_PLUGIN_URL . 'frontend/assets/css/';
        self::$jsPath    = CMPD_PLUGIN_URL . 'frontend/assets/js/';
        self::$viewsPath = CMPD_PLUGIN_DIR . 'frontend/views/';
        self::$viewsUrl  = CMPD_PLUGIN_URL . 'frontend/views/';

        if ( CMProductDirectory::$isLicenseOK ) {
            add_filter( 'wp_head', array( self::$calledClassName, 'metadescription' ) );
            add_filter( 'wp_enqueue_scripts', array( self::$calledClassName, 'cmpd_enqueue_styles' ) );
            add_action( 'wp_enqueue_scripts', array( self::$calledClassName, 'cmpd_enqueue_styles' ) );
            add_shortcode( 'cmpd_product', array( self::$calledClassName, 'cmpd_product_shortcode' ) );
            add_shortcode( 'cmpd_single_product', array( self::$calledClassName, 'cmpd_single_product_shortcode' ) );
            add_shortcode( 'cmpd_category_list', array( self::$calledClassName, 'cmpd_category_list' ) );
            CMProductDirectoryProductPage::cmpd_register_page_shortcodes();
            CMProductDirectoryProductPage::cmpd_register_actions();
        }

        if ( !is_admin() ) {
            add_action( 'wp_enqueue_scripts', array( __CLASS__, 'cmpd_enqueue_scripts' ) );
            add_action( 'wp_footer', array( __CLASS__, 'initFeatherlight' ) );
        }
    }

    public static function initFeatherlight() {
        ?>
        <script>jQuery( document ).ready( function () {
                jQuery( '.cmpd_lightbox_gallery' ).featherlightGallery( {
                    gallery: {
                        fadeIn: 300,
                        fadeOut: 300
                    },
                    openSpeed: 300,
                    closeSpeed: 300
                } );
            } );</script>
        <?php

    }

    public static function cmpd_enqueue_scripts() {
        wp_enqueue_style( 'featherlight-css', CMPD_PLUGIN_URL . 'frontend/assets/css/featherlight.min.css' );
        wp_enqueue_style( 'featherlight-gallery-css', CMPD_PLUGIN_URL . 'frontend/assets/css/featherlight.gallery.min.css' );

        wp_enqueue_script( 'featherlight-js', CMPD_PLUGIN_URL . 'frontend/assets/js/featherlight.min.js' );
        wp_enqueue_script( 'featherlight-gallery-js', CMPD_PLUGIN_URL . 'frontend/assets/js/featherlight.gallery.min.js' );

        // ListNav
        wp_enqueue_script( 'cmpd-listnav', self::$jsPath . 'jquery-listnav.min.js', array( 'jquery' ) );
        wp_enqueue_style( 'cmpd-listnav', self::$cssPath . 'cmpd-listnav.css' );

        // Google Map Authentication
        $googleAuthKey = CMPD_Settings::getOption( CMPD_Settings::GOOGLE_MAP_AUTH_KEY );
        if ( $googleAuthKey ):
            wp_enqueue_script( 'cmpd-google-map-auth', 'https://maps.googleapis.com/maps/api/js?key=' . esc_attr( $googleAuthKey ) . '&callback=initMap', array( 'jquery' ) );
        endif;
    }

    /**
     * Adds the meta description based on the product pitch if the WordpressSEO is disabled
     * @global type $post
     * @return type
     */
    public static function metadescription() {
        $enabled = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_METADESCRIPTION );
        if ( !$enabled ) {
            return;
        }

        if ( has_action( 'wpseo_head' ) ) {
            return;
        }

        global $post;

        $metadesc  = '';
        $post_type = '';

        if ( is_object( $post ) && ( isset( $post->post_type ) && $post->post_type !== '' ) ) {
            $post_type = $post->post_type;
        } else {
            return;
        }

        if ( is_singular() && $post_type === CMProductDirectoryShared::POST_TYPE ) {
            $metaOriginal = CMProductDirectory::meta( $post->ID, 'cmpd_product_pitch' );
            $metadesc     = cmpd_truncate( $metaOriginal, 160, '', true );
        }

        if ( is_string( $metadesc ) && $metadesc !== '' ) {
            echo '<meta name="description" content="', esc_attr( strip_tags( stripslashes( $metadesc ) ) ), '"/>', "\n";
        } elseif ( current_user_can( 'manage_options' ) && is_singular() ) {
            echo '<!-- ', CMProductDirectory::__( 'Admin only notice: this page doesn\'t show a meta description because it doesn\'t have one.' ), ' -->', "\n";
        }
    }

    public static function cmpd_enqueue_styles() {
        //Registering Scripts & Styles for the FrontEnd
        $post = get_post();
        wp_enqueue_style( 'dashicons' );

        if ( $post != null && $post->post_type == 'cm-product' ) {
            wp_enqueue_script( 'cmpd-google-map', 'https://maps.googleapis.com/maps/api/js', array( 'jquery' ) );
        }

        if ( $post != null && ($post->post_type == 'cm-product' || $post->post_type == 'page' ) ) {

            $default_view        = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_VIEW );

            if( $default_view == 'new-view' && file_exists( CMPD_PLUGIN_DIR . 'frontend/assets/css/cmpd-new-style.css' ) ) {
                wp_enqueue_style( 'cmpd-style', self::$cssPath . 'cmpd-new-style.css' );
            } else {
                wp_enqueue_style( 'cmpd-style', self::$cssPath . 'cmpd-style.css' );
            }

            wp_register_script( 'cmpd-functions', self::$jsPath . 'cmpd-functions.js', array( 'jquery' ) );
            //wp_enqueue_script('cmpd-functions');
        }
    }

    /**
     * Function displaying the [cmpd_product] shortcode
     *
     * @param type $atts
     * @param type $content
     * @return string
     */
    public static function cmpd_product_shortcode( $atts, $content = null ) {
        $defaultView        = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_VIEW );
        $defaultPageProduct = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_PRODUCT_ON_PAGE );

        $showEditlink = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_SHOWEDITLINK );
        $customCSS    = CMPD_Settings::getOption( CMPD_Settings::OPTION_CUSTOM_CSS );

        $passedProductIds = array();
        if ( !empty( $atts[ 'product_ids' ] ) ) {
            $passedProductIds = explode( ',', $atts[ 'product_ids' ] );
        }

        $passedExcludeIds = array();
        if ( !empty( $atts[ 'exclude_ids' ] ) ) {
            $passedExcludeIds = explode( ',', $atts[ 'exclude_ids' ] );
        }

        $passedCats            = !empty( $atts[ 'cats' ] ) ? explode( ',', $atts[ 'cats' ] ) : array( 'all' );
        $passedTags            = !empty( $atts[ 'tags' ] ) ? explode( ',', $atts[ 'tags' ] ) : array( 'all' );
        $passedPricingmodels   = !empty( $atts[ 'pricingmodels' ] ) ? explode( ',', $atts[ 'pricingmodels' ] ) : array( 'all' );
        $passedLangsupports    = !empty( $atts[ 'langsupports' ] ) ? explode( ',', $atts[ 'langsupports' ] ) : array( 'all' );
        $passedTargetaudiences = !empty( $atts[ 'targetaudiences' ] ) ? explode( ',', $atts[ 'targetaudiences' ] ) : array( 'all' );

        $row_product = !empty( $atts[ 'row_product' ] );

        $atts = array(
            'view'                          => $defaultView,
            'single'                        => null,
            /*
             * @since 12.04
             * Get settings for additional taxonomy
             * These settings determine if taxonomy is active or not
             */
            'active_pricingmodel'           => CMPD_Settings::getOption( CMPD_Settings::OPTION_TAXONOMY_PRICINGMODEL ),
            'active_languagetaxonomy'       => CMPD_Settings::getOption( CMPD_Settings::OPTION_TAXONOMY_LANUAGESUPPORT ),
            'active_targetaudience'         => CMPD_Settings::getOption( CMPD_Settings::OPTION_TAXONOMY_TARGETAUDIENCE ),
            /*
             * @since 12.04
             * Get settings from shortcode attributes
             * each value is provided by settings
             * if no attribute, get value from settings
             */
            'filter_search'                 => isset( $atts[ 'filter_search' ] ) ? $atts[ 'filter_search' ] : CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_SHOWSEARCH ),
            'filter_category'               => isset( $atts[ 'filter_category' ] ) ? $atts[ 'filter_category' ] : CMPD_Settings::getOption( CMPD_Settings::SHORTCODE_ATTR_TAXONOMY_CATEGORY ),
            'filter_pricingmodel'           => isset( $atts[ 'filter_pricingmodel' ] ) ? $atts[ 'filter_pricingmodel' ] : CMPD_Settings::getOption( CMPD_Settings::SHORTCODE_ATTR_TAXONOMY_PRICINGMODEL ),
            'filter_languagesupport'        => isset( $atts[ 'filter_languagesupport' ] ) ? $atts[ 'filter_languagesupport' ] : CMPD_Settings::getOption( CMPD_Settings::SHORTCODE_ATTR_TAXONOMY_LANGUAGESUPPORT ),
            'filter_targetaudience'         => isset( $atts[ 'filter_targetaudience' ] ) ? $atts[ 'filter_targetaudience' ] : CMPD_Settings::getOption( CMPD_Settings::SHORTCODE_ATTR_TAXONOMY_TARGETAUDIENCE ),
            'filter_tag'                    => isset( $atts[ 'filter_tag' ] ) ? $atts[ 'filter_tag' ] : CMPD_Settings::getOption( CMPD_Settings::SHORTCODE_ATTR_TAXONOMY_TAG ),
            'page_product'                  => $defaultPageProduct,
            // if to display product of taxonomy (by shortcode)
            'cmcats'                        => $passedCats,
            'cmtags'                        => $passedTags,
            'cmpd_pricing_model'            => $passedPricingmodels,
            'cmpd_language_support'         => $passedLangsupports,
            'cmpd_target_audience'          => $passedTargetaudiences,
            'limited_cmcats'                => $passedCats,
            'limited_cmtags'                => $passedTags,
            'limited_cmpd_pricing_model'    => $passedPricingmodels,
            'limited_cmpd_language_support' => $passedLangsupports,
            'limited_cmpd_target_audience'  => $passedTargetaudiences,
            'product_ids'                   => $passedProductIds,
            'exclude_ids'                   => $passedExcludeIds,
            'only_relevant'                 => isset( $atts[ 'only_relevant' ] ) ? $atts[ 'only_relevant' ] : false,
            'row_product'                   => !empty( $atts[ 'row_product' ] ) ? $atts[ 'row_product' ] : '',
        );

        $view = in_array( $atts[ 'view' ], array( 'tiles', 'image-tiles', 'cube-view' ) ) ? $atts[ 'view' ] : 'tiles';

        /* Pricing Model slugs, exploded by coma */
        $getTax                       = filter_input( INPUT_GET, 'cmpd_pricing_model' );
        $atts[ 'cmpd_pricing_model' ] = !empty( $getTax ) ? explode( ',', $getTax ) : $atts[ 'cmpd_pricing_model' ];

        /* Language Support slugs, exploded by coma */
        $getTax                          = filter_input( INPUT_GET, 'cmpd_language_support' );
        $atts[ 'cmpd_language_support' ] = !empty( $getTax ) ? explode( ',', $getTax ) : $atts[ 'cmpd_language_support' ];

        /* Target Audience slugs, exploded by coma */
        $getTax                         = filter_input( INPUT_GET, 'cmpd_target_audience' );
        $atts[ 'cmpd_target_audience' ] = !empty( $getTax ) ? explode( ',', $getTax ) : $atts[ 'cmpd_target_audience' ];

        /* Category slugs, exploded by coma */
        $getCats          = filter_input( INPUT_GET, 'cmcats' );
        $atts[ 'cmcats' ] = !empty( $getCats ) ? explode( ',', $getCats ) : $atts[ 'cmcats' ];

        /* Tags exploded by comma */
        $getTags          = filter_input( INPUT_GET, 'cmtags' );
        $atts[ 'cmtags' ] = !empty( $getTags ) ? explode( ',', $getTags ) : $atts[ 'cmtags' ];

        /* Whether or not show the filter */
        if ( isset( $_GET[ "showfilter" ] ) ) {
            $atts[ 'showfilter' ] = in_array( $_GET[ "showfilter" ], array( 'yes', 'no', true, 1, 0 ) ) ? $_GET[ "showfilter" ] : ($_GET[ "showfilter" ] ? 1 : 0);
        }
        if ( isset( $_GET[ "showfilter_tags" ] ) ) {
            $atts[ 'showfilter_tags' ] = in_array( $_GET[ "showfilter_tags" ], array( 'yes', 'no', true, 1, 0 ) ) ? $_GET[ "showfilter_tags" ] : ($_GET[ "showfilter_tags" ] ? 1 : 0);
        }

        /* Number of product on page */
        if ( isset( $_GET[ "page_product" ] ) ) {
            $atts[ 'page_product' ] = $_GET[ "page_product" ];
        }

        if ( isset( $_GET[ "pg" ] ) ) {
            $atts[ 'pg' ] = $_GET[ "pg" ];
        } else {
            $atts[ 'pg' ] = 1;
        }

        /* Show single product only */
        if ( $atts[ 'single' ] ) {
            $atts[ 'showfilter' ] = 'no';
            $atts[ 'cmtags' ]     = array( 'all' );
            $atts[ 'cmcats' ]     = array( 'all' );
        }

        /* Don't show paused */
        $atts[ 'paused' ] = true;

        /* Explode product_ids by "," */
        if ( !empty( $atts[ 'product_ids' ] ) && is_string( $atts[ 'product_ids' ] ) ) {
            $atts[ 'product_ids' ] = explode( ',', $atts[ 'product_ids' ] );
        }

        /* Explode exclude_ids by "," */
        if ( !empty( $atts[ 'exclude_ids' ] ) && is_string( $atts[ 'exclude_ids' ] ) ) {
            $atts[ 'exclude_ids' ] = explode( ',', $atts[ 'exclude_ids' ] );
        }

        /* Search */
        if ( isset( $_GET[ "query" ] ) ) {
            $atts[ 'query' ] = $_GET[ "query" ];
        }

        if ( $showEditlink ) {
            $atts[ 'showeditlink' ] = true;
        }

        /* Get the list of product */
        $product = CMProductDirectoryShared::getProduct_s( $atts );

        //cmpd Main Container
        $output = '<div class="clear"></div><div id="cmpd-container" class="cmpd-container ' . $view . '">';

        /* Output custom CSS */
        if ( !empty( $customCSS ) ) {
            $output .= '<style type="text/css">' . $customCSS . '</style>';
        }

        /* Output filters and search */
        $filters = '';
        // output search
        if ( $atts[ 'filter_search' ] ) {
            if ( $atts[ 'view' ] != 'new-view' ) {
                $filters .= '<label class="cmpd-filter-label">' . CMPD_Labels::getLocalized('search_label') . '</label>';
            }
            $filters .= self::outputSearch( $atts );
        }

        $filters .= self::outputCategories( $atts );

        $filters .= self::outputPricingModels( $atts );

        $filters .= self::outputLanguageSupports( $atts );

        $filters .= self::outputTargetAudiences( $atts );

        $filters .= self::outputTags( $atts );

        /* Output product/product/product per page */
        if ( CMPD_Settings::getOption( CMPD_Settings::OPTION_POST_PER_PAGE_SHOW ) == true ) {
            $filters .= self::outputProductPerPage( $atts );
        }

        $output .=!empty( $filters ) ? '
			<div class="cmpd-filters-panel'. ( CMPD_Settings::getOption( CMPD_Settings::OPTION_CATEGORY_SHOW_AS ) == 'tags' ? ' cmpd-filters-panel-tags' : '' )  .'">
				<form method="get">' .
        $filters . '
					<div class="cmpd-single-filter filter-submitt-container">
						<input class="cmpd-filter-submit" type="submit" value="' . esc_attr( CMPD_Labels::getLocalized( 'search_submit' ) ) . '"/>
					</div>
				</form>
			</div>' : '';


        if ( $atts[ 'view' ] == 'new-view' ) {
            /* Output pagination */
            if ( $atts[ 'page_product' ] > 0 && CMPD_Settings::getOption( CMPD_Settings::OPTION_PAGINATION_TOP ) ) {
                $atts[ 'pagination' ] = 'top';
                $output.= self::outputPagination( $atts );
            }

            /* Output found posts */
            if ( !empty( $product ) && CMPD_Settings::getOption( CMPD_Settings::OPTION_FOUND_PRODUCT ) ) {

                $output.= self::outputFoundPosts( $atts );
            }
            $output.='</div>';
            $output.='<div class="clear"></div>';
        } else {
            /* Output found posts */
            if ( !empty( $product ) && CMPD_Settings::getOption( CMPD_Settings::OPTION_FOUND_PRODUCT ) ) {

                $output.= self::outputFoundPosts( $atts );
            }
            $output.='</div>';
            $output.='<div class="clear"></div>';

            /* Output pagination */
            if ( $atts[ 'page_product' ] > 0 && CMPD_Settings::getOption( CMPD_Settings::OPTION_PAGINATION_TOP ) ) {
                $atts[ 'pagination' ] = 'top';
                $output.= self::outputPagination( $atts );
            }
            $output.='<div class="clear" style="height:10px;"></div>';
        }

        $output .= self::getViewStyles( $atts[ 'view' ], $atts[ 'row_product' ] );

        /* Output Product */
        if ( !empty( $product ) ) {
            $output.='<div class="cmpd-product">';
            $k = 1;

            $viewClass = self::getViewClass( $atts[ 'view' ] );
            if ( $atts[ 'view' ] == 'list-view' ) {
                $output .= '<script>jQuery(document).ready(function($) { jQuery("#cmpdListview").listnav(); });</script>';
                $output .= '<div id="cmpdListview-nav"></div><ul class="' . $viewClass . '" id="cmpdListview">';
            } else {
                $output .= '<div class="' . $viewClass . '">';
            }
            foreach ( $product as $key => $product ) {
                $atts[ 'css_id' ] = 'cmpd_product_' . $key;
                $output .= self::cmpd_display_single_product( $product, $atts );
                $k++;
            }
            $output .= $atts[ 'view' ] == 'list-view' ? '</ul>' : '</div>';

            if ( !empty( $atts[ 'row_product' ] ) && $atts[ 'row_product' ] == $k ) {
                $k = 0;
                $output.='<div style="clear:both;height:0px;"></div>';
            }
            $k++;

            $output .= '</div>';
        } else {
            $output.='<div class="cmpd-no-results">';
            $output.= CMPD_Labels::getLocalized( 'nothing_found' );
            $output.='</div>';
        }

        if ( $atts[ 'view' ] === 'list-view' ) {
            $output = '<div class="cmpd_list_view"><ul class="cmpd_list_view_list">' . $output . '</ul></div>';
        }

        $output.='<div class="clear"></div>';

        /* Output pagination */
        if ( $atts[ 'page_product' ] > 0 && CMPD_Settings::getOption( CMPD_Settings::OPTION_PAGINATION_BOTTOM ) ) {
            $atts[ 'pagination' ] = 'bottom';
            $output.= self::outputPagination( $atts );
        }

        // $output.='</div>';
        //cmpd Main Container - End
        // $output.='<div class="clear"></div>';

        $output = apply_filters( 'cmpd_after_content', $output ); //filter to get content from comunity product

        return $output;
    }

    /*
     * Get class for product container
     */

    public static function getViewClass( $view ) {
        // temp
        $view = $view == 'cube-view' ? 'image-tiles' : $view;

        switch ( $view ) {
            case 'directory-view':
                return 'cmpd_directory_view_container';
                break;

            case 'image-tiles':
                return 'cmpd_tiles_view_container';
                break;

            case 'cube-view':
                return 'cmpd_cube_view_container';
                break;

            case 'new-view':
                return 'cmpd_modern_view_container';
                break;

            case 'list-view':
                return 'cmpd_list_view_container';
                break;

            default:
                return 'cmpd_' . $view . '_container';
        }
    }

    public static function getViewStyles( $view, $arg_columns ) {
        $styles = '';

        // temp
        $view = $view == 'cube-view' ? 'image-tiles' : $view;

        switch ( $view ) {
            case 'directory-view':
                return;
                break;

            case 'image-tiles':
                $displayBorder = CMPD_Settings::getOption( CMPD_Settings::CMPD_OPTION_APPEARANCE_TILES_BORDER );
				$border			 = $displayBorder ? '.cmpd_tiles_view_inner_container{border: 1px solid #cecece; border-radius: 0.25em;}' : '.cmpd_tiles_view_inner_container{border: none;}';

                $img_container_height = CMPD_Settings::getOption( CMPD_Settings::CMPD_OPTION_APPEARANCE_TILES_IMG_HEIGHT );
                $height               = '.cmpd_tiles_view_item_image_container { min-height: ' . $img_container_height . '; }';

                $columns = empty( $arg_columns ) ? CMPD_Settings::getOption( CMPD_Settings::CMPD_OPTION_APPEARANCE_TILES_COLUMNS ) : $arg_columns;
                $padding = CMPD_Settings::getOption( CMPD_Settings::CMPD_OPTION_APPEARANCE_TILES_MARGINS );

                $styles .= '@media all and (max-width:480px) { .cmpd_tiles_view_item{width: 100%; order:1; padding:0;margin-bottom:0.5em;} .cmpd_tiles_view_item_image_container{min-height:auto;} ' . $border . ' }';
				$styles .= '@media all and (min-width:481px){.cmpd_tiles_view_item{width: calc(100%/3); order:3;padding:' . $padding . ';}' . $border . $height . '}';
				$styles .= '@media all and (min-width:768px){.cmpd_tiles_view_item{width: calc(100%/' . $columns . '); order:' . $columns . ';padding:' . $padding . ';}' . $border . $height . '}';
                break;

            case 'list-view':
                $displayBottomborder = CMPD_Settings::getOption( CMPD_Settings::CMPD_OPTION_APPEARANCE_LIST_BOTTOMBORDER );
				$styles .= $displayBottomborder ? '.cmpd_list_view_item{ border-bottom: 1px solid #cecece; }' : '.cmpd_list_view_item{ border: none; }';

                $displayRating = CMPD_Settings::getOption( CMPD_Settings::CMPD_OPTION_APPEARANCE_LIST_RATING );
                $styles .= $displayRating ? '.cmpd_list_view_content { width: calc((100%/5)*4); }.cmpd_list_view_rating { width: calc(100%/5); }' : '.cmpd_list_view_content { width: 100%; }';
                break;

            case 'cube-view':
                return;
                break;
        }
        return '<style>' . $styles . '</style>';
    }

    public static function cmpd_single_product_shortcode( $atts = array(), $content = null ) {
        static $stylesheetEnqueued = FALSE;
        global $post;

        /*
         * store the global post object
         */
        $currentPost   = $post;
        $shortcodeAtts = shortcode_atts( array( 'slug' => null ), $atts );

        if ( empty( $shortcodeAtts[ 'slug' ] ) ) {
            return;
        }

        $the_slug = esc_attr( $shortcodeAtts[ 'slug' ] );
        $args     = array(
            'name'        => $the_slug,
            'post_type'   => CMProductDirectoryShared::POST_TYPE,
            'post_status' => 'publish',
            'numberposts' => 1
        );
        $products = get_posts( $args );
        if ( empty( $products ) ) {
            return;
        }

        $post = reset( $products );

        if ( !$stylesheetEnqueued ) {
            $stylesheetEnqueued = TRUE;
            wp_enqueue_style( 'single-product-directory-view-shortcode', CMPD_PLUGIN_URL . 'views/assets/css/single-product-directory-view.css' );
        }

        ob_start();
        include CMPD_PLUGIN_DIR . 'views/single-product-directory-view.phtml';
        $internalContent = ob_get_clean();
        $internalContent = do_shortcode( $internalContent );

        /*
         * reset the global post object
         */
        $post = $currentPost;
        return $internalContent;
    }

    /*
     * Taxonomy Featured Image
     * List all category terms with number of assigned posts
     */

    public static function cmpd_category_list( $atts ) {
        $output = '';

        wp_enqueue_style( 'cmpd_category_list_styles', self::$cssPath . 'cmpd_category_list.css' );

        $atts = shortcode_atts(
        array(
            'count'           => 0,
            'columns'         => 3,
            'hide_empty'      => 0,
            'category'        => CMPD_Settings::getOption( CMPD_Settings::SHORTCODE_LIST_CATEGORY_TERMS_CATEGORY ),
            'pricingmodel'    => CMPD_Settings::getOption( CMPD_Settings::SHORTCODE_LIST_CATEGORY_TERMS_PRICINGMODEL ),
            'languagesupport' => CMPD_Settings::getOption( CMPD_Settings::SHORTCODE_LIST_CATEGORY_TERMS_LANGUAGESUPPORT ),
            'targetaudience'  => CMPD_Settings::getOption( CMPD_Settings::SHORTCODE_LIST_CATEGORY_TERMS_TARGETAUDIENCE ),
            'tag'             => CMPD_Settings::getOption( CMPD_Settings::SHORTCODE_LIST_CATEGORY_TERMS_TAG ),
        ), $atts );

        $taxonomy_args = array(
            array(
                'name'    => CMProductDirectoryShared::POST_TYPE_TAXONOMY,
                'label'   => CMPD_Labels::getLocalized( 'cat_filter_label' ),
                'slug'    => 'cmcats',
                'display' => $atts[ 'category' ],
            ),
            array(
                'name'    => CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL,
                'label'   => CMPD_Labels::getLocalized( 'pricingmodel_filter_label' ),
                'slug'    => 'cmpd_pricing_model',
                'display' => $atts[ 'pricingmodel' ],
            ),
            array(
                'name'    => CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT,
                'label'   => CMPD_Labels::getLocalized( 'langsupport_filter_label' ),
                'slug'    => 'cmpd_language_support',
                'display' => $atts[ 'languagesupport' ],
            ),
            array(
                'name'    => CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE,
                'label'   => CMPD_Labels::getLocalized( 'targetaudience_filter_label' ),
                'slug'    => 'cmpd_target_audience',
                'display' => $atts[ 'targetaudience' ],
            ),
            array(
                'name'    => CMProductDirectoryShared::POST_TYPE_TAXONOMY_TAG,
                'label'   => CMPD_Labels::getLocalized( 'tag_filter_label' ),
                'slug'    => 'cmtags',
                'display' => $atts[ 'tag' ],
            ),
        );

        $taxonomy = self::get_terms_for_taxonomy( $taxonomy_args, $atts[ 'hide_empty' ] );

        $output = self::outputCategoryList( $taxonomy, $atts );
        return $output;
    }

    /*
     * Taxonomy Featured Image
     * Get Image URL from Term Meta
     * @param int $id Taxonomy term ID
     */

    public static function get_category_image( $term_id ) {
        // Get image by its ID
        $image_id  = get_term_meta( $term_id, 'cmpd_category_featured_image', true );
        $image_URL = wp_get_attachment_image_src( $image_id, 'cmpd_image_icon' );

        // If false, check if user set Custom Icon
        if ( empty( $image_URL[ 0 ] ) ) {
            $default_image_URL = CMPD_PLUGIN_URL . 'frontend/assets/img/default-category-32-32.png';
            $custom_image_URL  = CMPD_Settings::getOption( CMPD_Settings::SHORTCODE_LIST_CATEGORY_TERMS_DEFAULT_ICON );

            $image_URL = !empty( $custom_image_URL ) ? $custom_image_URL : $default_image_URL;
        } else {
            $image_URL = $image_URL[ 0 ];
        }

        return '<img src="' . $image_URL . '" />';
    }

    /*
     * Taxonomy Featured Image
     * Get terms for taxonomy if display = true
     * @param array $taxonomy Table of taxonomy data
     */

    public static function get_terms_for_taxonomy( $taxonomy, $hide_empty ) {
        $output = array();
        foreach ( $taxonomy as $item ) {
            if ( true == $item[ 'display' ] ) {
                $terms                                = get_terms( $item[ 'name' ], array( 'hide_empty' => $hide_empty ) );
                $output[ $item[ 'slug' ] ]            = $item;
                $output[ $item[ 'slug' ] ][ 'terms' ] = $terms;
            }
        }
        return $output;
    }

    /*
     * Taxonomy Featured Image
     * Output category list
     * @param array $taxonomy Table of taxonomy data (with terms)
     */

    public static function outputCategoryList( $taxonomy, $atts ) {
        $output          = '';
        $directoryPageID = CMPD_Settings::getOption( CMProductDirectory::SHORTCODE_PAGE_OPTION );
        if ( !empty( $taxonomy ) ) {
            foreach ( $taxonomy as $taxonomy ) {
                if ( !empty( $taxonomy[ 'terms' ] ) ) {
                    $output .= '<div class="cmpd_content_box">';
                    $link = get_page_link( $directoryPageID ) . '?query=&' . esc_attr( $taxonomy[ 'slug' ] ) . '=';
                    $output .= '<h3>' . esc_html( $taxonomy[ 'label' ] ) . '</h3><ul class="cmpd_category_list cmpd_category_list_col_' . esc_attr( $atts[ 'columns' ] ) . '">';
                    foreach ( $taxonomy[ 'terms' ] as $term ) {
                        $image = self::get_category_image( $term->term_id );
                        $count = $atts[ 'count' ] ? '<span>' . $term->count . '</span>' : '';
                        $output .= '<li><a href="' . esc_attr( $link . $term->slug ) . '">' . $image . esc_html( $term->name ) . '</a>' . $count . '</li>';
                    }
                    $output .= '</ul></div>';
                }
            }
        }
        return $output;
    }

    public static function cmpd_display_single_product( $product, $atts ) {
        extract( $atts );

        ob_start();
        include self::$viewsPath . 'single-product-' . $atts[ 'view' ] . '.phtml';
        $output = ob_get_clean();

        return $output;
    }

    public static function outputFoundPosts( $atts ) {

        $output = '<div class="cmpd-module-found-posts">' . CMPD_Labels::getLocalized( 'product_found:' ) . ' <span>' . CMProductDirectoryShared::$lastProductQuery->found_posts . '</span></div>';

        return $output;
    }

    public static function outputPagination( $atts ) {
        $output = '';


        $pagination_args = array(
            'base'       => esc_url( add_query_arg( 'pg', '%#%' ) ),
            'format'     => '',
            'total'      => CMProductDirectoryShared::$lastProductQuery->max_num_pages,
            'current'    => max( 1, $atts[ 'pg' ] ),
            'link_class' => 'cmpd-button',
        );

        $pagination       = cmpd_paginate_links( $pagination_args );
        $class_pagination = empty( $atts[ 'pagination' ] ) ? '' : '-' . $atts[ 'pagination' ];
        if ( $pagination ) {
            if ( $atts[ 'view' ] == 'new-view' ) {
                $output .= '<div class="cmpd-module-pagination cmpd-module-pagination' . esc_attr($class_pagination) . '">' . $pagination . '</div>';
            } else {
                $output .= '<div class="cmpd-module-pagination' . esc_attr($class_pagination) . '">' . CMProductDirectory::__('Page: ') . $pagination . '</div>';
            }
        }

        return $output;
    }

    public static function outputEditlink( $post, $atts ) {
        $output = '';
		if ( !empty( $atts[ 'showeditlink' ] ) && is_user_logged_in() && current_user_can('edit_posts') ) {
            $output .= '<a href="' . esc_attr( get_edit_post_link( $post->ID ) ) . '" class="cmpd_editlink" target="_blank">(' . CMProductDirectory::__( 'edit' ) . ')</a>';
        }
        return $output;
    }

    public static function get_posts_ids( $taxonmyname, $terms, $ids = null ) {
        if ( $ids == null ) {
            $operator = sizeof( $terms ) > 1 ? 'IN' : 'AND';
            if ( $terms[ 0 ] != 'all' ) {
                $byTerms = array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => $taxonmyname,
                        'terms'    => $terms,
                        'operator' => $operator,
                        'field'    => 'slug',
                    ),
                );
            } else {
                $byTerms = array();
            }

            $args  = array(
                'post_type'   => CMProductDirectoryShared::POST_TYPE,
                'post_status' => 'publish',
                'fields'      => 'ids',
                'tax_query'   => $byTerms,
                'nopaging'    => true,
                'numberposts' => -1,
            );
            $query = new WP_Query( $args );
            $query = $query->posts;
        } else {
            $query = $ids;
        }

        return $query;
    }

    public static function outputCategories( $atts ) {
        $output = '';
        if ( $atts[ 'filter_category' ] ) {
            $data = array(
                'name'          => CMProductDirectoryShared::POST_TYPE_TAXONOMY,
                'slug'          => 'cmcats',
                'label'         => CMPD_Labels::getLocalized( 'cat_filter_label' ),
                'limited'       => $atts[ 'limited_cmcats' ],
                'only_relevant' => isset( $atts[ 'only_relevant' ] ) ? $atts[ 'only_relevant' ] : 0,
                'products_ids'  => isset( $atts[ 'products_ids' ] ) ? $atts[ 'products_ids' ] : '',
            );

            $output = self::get_tax_terms( $data );
        }
        return $output;
    }

    public static function outputPricingModels( $atts ) {
        $output = '';
        if ( $atts[ 'filter_pricingmodel' ] && $atts[ 'active_pricingmodel' ] ) {
            $data = array(
                'name'          => CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL,
                'slug'          => 'cmpd_pricing_model',
                'label'         => CMPD_Labels::getLocalized( 'pricingmodel_filter_label' ),
                'limited'       => $atts[ 'limited_cmpd_pricing_model' ],
                'only_relevant' => isset( $atts[ 'only_relevant' ] ) ? $atts[ 'only_relevant' ] : 0,
                'products_ids'  => isset( $atts[ 'products_ids' ] ) ? $atts[ 'products_ids' ] : '',
            );

            $output = self::get_tax_terms( $data );
        }
        return $output;
    }

    public static function outputLanguageSupports( $atts ) {
        $output = '';
        if ( $atts[ 'filter_languagesupport' ] && $atts[ 'active_languagetaxonomy' ] ) {
            $data = array(
                'name'          => CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT,
                'slug'          => 'cmpd_language_support',
                'label'         => CMPD_Labels::getLocalized( 'langsupport_filter_label' ),
                'limited'       => $atts[ 'limited_cmpd_language_support' ],
                'only_relevant' => isset( $atts[ 'only_relevant' ] ) ? $atts[ 'only_relevant' ] : 0,
                'products_ids'  => isset( $atts[ 'products_ids' ] ) ? $atts[ 'products_ids' ] : '',
            );

            $output = self::get_tax_terms( $data );
        }
        return $output;
    }

    public static function outputTargetAudiences( $atts ) {
        $output = '';
        if ( $atts[ 'filter_targetaudience' ] && $atts[ 'active_targetaudience' ] ) {
            $data = array(
                'name'          => CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE,
                'slug'          => 'cmpd_target_audience',
                'label'         => CMPD_Labels::getLocalized( 'targetaudience_filter_label' ),
                'limited'       => $atts[ 'limited_cmpd_target_audience' ],
                'only_relevant' => isset( $atts[ 'only_relevant' ] ) ? $atts[ 'only_relevant' ] : 0,
                'products_ids'  => isset( $atts[ 'products_ids' ] ) ? $atts[ 'products_ids' ] : '',
            );

            $output = self::get_tax_terms( $data );
        }
        return $output;
    }

    public static function outputTags( $atts ) {
        $output = '';
        if ( $atts[ 'filter_tag' ] ) {
            $data = array(
                'name'          => CMProductDirectoryShared::POST_TYPE_TAXONOMY_TAG,
                'slug'          => 'cmtags',
                'label'         => CMPD_Labels::getLocalized( 'tag_filter_label' ),
                'limited'       => $atts[ 'limited_cmtags' ],
                'only_relevant' => isset( $atts[ 'only_relevant' ] ) ? $atts[ 'only_relevant' ] : 0,
                'products_ids'  => isset( $atts[ 'products_ids' ] ) ? $atts[ 'products_ids' ] : '',
            );

            $output = self::get_tax_terms( $data );
        }
        return $output;
    }

    public static function get_tax_terms( $data ) {
        $output = '';

        $current = isset( $_GET[ $data[ 'slug' ] ] ) ? $_GET[ $data[ 'slug' ] ] : '';

        $posts_ids = self::get_posts_ids( $data[ 'name' ], $data[ 'limited' ], $data[ 'products_ids' ] );
        $terms     = wp_get_object_terms( $posts_ids, $data[ 'name' ], array( 'hide_empty' => $data[ 'only_relevant' ], 'orderby' => 'name', 'order' => 'ASC' ) );

        if ( CMPD_Settings::getOption( CMPD_Settings::OPTION_CATEGORY_SHOW_AS ) == 'tags' ) {
            $output .= self::outputAsTags( $data, $terms );
        } else {
            $output .= self::outputAsDropdown( $data, $terms );
        }

        return $output;
    }

    public static function outputAsTags( $data, $terms ) {
        $output = '';
        if ( !empty( $terms ) ) {

            $current = isset( $_GET[ $data[ 'slug' ] ] ) ? $_GET[ $data[ 'slug' ] ] : '';
            $all_value = $data[ 'limited' ][ 0 ] == 'all' ? 'all' : $data[ 'limited' ][ 0 ];

            $default_view        = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_VIEW );

            if( $default_view == 'new-view' ) {
                $output .= '<div class="cmpd-single-filter '.esc_attr( $data[ 'slug' ] ).'">';
                $output .= '<label class="cmpd-filter-label">' . esc_html( $data[ 'label' ] ) . '</label>';
            } else {
                $output .= '<label class="cmpd-filter-label">' . esc_html( $data[ 'label' ] ) . '</label>';
                $output .= '<div class="cmpd-single-filter">';
            }

            $output .= '<input class="display_none" type="radio" id="' . esc_attr( $data[ 'slug' ] ) . '-all" ' . checked( $current, 'all', 0 ) . ' name="' . esc_attr( $data[ 'slug' ] ) . '" value="' . esc_attr( $all_value ) . '" />';
            $output .= '<label class="cmpd-filter-tag" for="' . esc_attr( $data[ 'slug' ] ) . '-all">' . esc_html( CMPD_Labels::getLocalized( 'filter_all' ) ) . '</label>';
            foreach ( $terms as $term ) {
                $output.= ' <input ' . checked( $current, $term->slug, 0 ) . ' class="display_none" type="radio" id="' . esc_attr( $term->slug ) . '" name="' . esc_attr( $data[ 'slug' ] ) . '" value="' . esc_attr( $term->slug ) . '" /><label class="cmpd-filter-tag" for="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</label>';
            }
            $output.='</div>';
        }
        return $output;
    }

    public static function outputAsDropdown( $data, $terms ) {
        $output = '';

        $current   = isset( $_GET[ $data[ 'slug' ] ] ) ? $_GET[ $data[ 'slug' ] ] : '';
        $all_value = $data[ 'limited' ][ 0 ] == 'all' ? 'all' : $data[ 'limited' ][ 0 ];

        if ( !empty( $terms ) ) {

            $default_view        = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_VIEW );

            if( $default_view == 'new-view' ) {
                $output .= '<div class="cmpd-single-filter">';
                $output .= '<label class="cmpd-filter-label">' . esc_html( $data[ 'label' ] ) . '</label>';
            } else {
                $output .= '<label class="cmpd-filter-label">' . esc_html( $data[ 'label' ] ) . '</label>';
                $output .= '<div class="cmpd-single-filter">';
            }

            $output .= '<select name="' . esc_attr( $data[ 'slug' ] ) . '" id="' . esc_attr( $data[ 'slug' ] ) . '" class="cmpd-filter-input-select">';
            $output .= '<option value="' . esc_attr( $all_value ) . '" ' . selected( $current, $all_value, false ) . '>' . esc_html( CMPD_Labels::getLocalized( 'filter_all' ) ) . '</option>';
            foreach ( $terms as $term ) {
                $output .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( $current, $term->slug, false ) . '>' . esc_html( $term->name ) . '</option>';
            }
            $output .= '</select>';
            $output .= '</div>';
        }

        return $output;
    }

    public static function outputProductPerPage( $atts ) {
        global $post;
        if ( empty( $post ) ) {
            return;
        }

        $output  = '';
        $i       = 10;
        $selected = 1;
        $current = (int) (empty( $atts[ 'page_product' ] )) ? 10 : $atts[ 'page_product' ];

        if( $atts[ 'view' ] == 'new-view' ) {
            $output.='<div class="cmpd-single-filter filter-per_page-container">';
            $output.='<label class="cmpd-filter-label" id="cmpd-module-actions-top-title">' . CMPD_Labels::getLocalized( 'post_per_page_lebel' ) . ' </label>';
            $output .='<select class="cmpd-filter-input-select" name="page_product">';
        } else {
            $output .= '<div class="cmpd_filters"><span class="cmpd_label" id="cmpd-module-actions-top-title">' . CMPD_Labels::getLocalized('post_per_page_lebel') . ' </span>';
            $output .= '<select class="cmpd_input_xmini" name="page_product">';
        }

        $output.= '<option ' . selected( $current, 1, 0 ) . 'value="1">1</option>';

        if ( $current == 2 ) {
            $selected = 0;
            $output.= '<option ' . selected( $current, 2, 0 ) . 'value="2">2</option>';
        }
        $output.= '<option ' . selected( $current, 3, 0 ) . 'value="3">3</option>';

        if ( $current == 4 && $selected ) {
            $selected = 0;
            $output.= '<option ' . selected( $current, 4, 0 ) . 'value="' . esc_attr( $current ) . '">' . $current . '</option>';
        }
        $output.= '<option ' . selected( $current, 5, 0 ) . 'value="5">5</option>';

        if ( $current < 10 && $current % 10 && $selected ) {
            $selected = 0;
            $output.= '<option ' . selected( 1, 1, 0 ) . ' value="' . esc_attr( $current ) . '">' . $current . '</option>';
        }
        for ( $i; $i < 101; $i+=10 ) {
            if ( $current < $i && $current % 10 && $selected ) {
                $selected = 0;
                $output.= '<option ' . selected( 1, 1, 0 ) . ' value="' . esc_attr( $current ) . '">' . $current . '</option>';
            }
            $output.= '<option ' . selected( $current, $i, 0 ) . 'value="' . esc_attr( $i ) . '">' . $i . '</option>';
        }
        $output .='</select><div class="clear clearfix"></div></div>';


        return $output;
    }

    public static function outputSearch( $atts ) {
        $output = '';
        if ( $atts[ 'view' ] == 'new-view' ) {
            $output .= '<div class="cmpd-single-filter">';
            $output .= '<label class="cmpd-filter-label">' . CMPD_Labels::getLocalized('search_label') . '</label>';
            $output .= '<input class="cmpd-filter-input" type="search" name="query" placeholder="' . esc_attr( CMPD_Labels::getLocalized( 'search_placeholder' ) ) . '" value="' . esc_attr( !empty( $atts[ 'query' ] ) ? $atts[ 'query' ] : ''  ) . '" />';
            $output .= '</div>';
        } else {
            $output .= '<div class="cmpd-single-filter"><input class="cmpd-filter-input" type="search" name="query" placeholder="' . esc_attr( CMPD_Labels::getLocalized( 'search_placeholder' ) ) . '" value="' . esc_attr( !empty( $atts[ 'query' ] ) ? $atts[ 'query' ] : ''  ) . '" /></div>';
        }
        return $output;
    }

    public static function outputImage( $product, $atts ) {
        $output = '';
        $postId = $product->ID;
        $image  = CMProductDirectoryProductPage::getProductGallery( $postId );

        if ( !empty( $image ) ) {
            $imageUrl = $image[ 0 ][ 'cmpd_image' ][ 0 ];
            $output .= '<img class="default-image" src="' . esc_attr( $imageUrl ) . '">';
        } else {
            $view          = (!empty( $atts[ 'view' ] ) && in_array( $atts[ 'view' ], array( 'tiles', 'list', 'image-tiles' ) )) ? $atts[ 'view' ] : 'tiles';
            $default_image = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_DEFAULT_IMAGE );
            $default_image = empty( $default_image ) ? CMPD_PLUGIN_URL . 'frontend/assets/img/default-product-300-300.png' : $default_image;
            $output .= '<img class="default-image" src="' . esc_attr( $default_image ) . '">';
        }
        return $output;
    }

    public static function getDefaultThumbnail( $size, $alt ) {
        $thumbnail = '<img src="' . CMPD_PLUGIN_URL . 'frontend/assets/img/default-product-300-300.png" class="attachment-' . esc_attr( $size ) . ' size-' . esc_attr( $size ) . '" alt="' . esc_attr( $alt ) . '" />';
        return $thumbnail;
    }

}
