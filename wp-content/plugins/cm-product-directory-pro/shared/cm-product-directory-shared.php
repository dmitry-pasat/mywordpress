<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class CMProductDirectoryShared {

    protected static $instance      = NULL;
    public static $calledClassName;
    public static $lastProductQuery = NULL;

    const POST_TYPE                     = 'cm-product';
    const POST_TYPE_TAXONOMY            = 'cm-product-category';
    const POST_TYPE_TAXONOMY_TAG        = 'post_tag';
    const POST_TYPE_TAX_PRICINGMODEL    = 'cmpd_pricing_model';
    const POST_TYPE_TAX_LANGUAGESUPPORT = 'cmpd_language_support';
    const POST_TYPE_TAX_TARGETAUDIENCE  = 'cmpd_target_audience';

    public static function install() {
        $args     = array(
            'post_type'  => self::POST_TYPE,
            'meta_query' => array(
                array(
                    'key'     => 'cmpd_promoted',
                    'compare' => 'NOT EXISTS',
                ),
            ),
        );
        $query    = new WP_Query( $args );
        $products = $query->get_posts();
        foreach ( $products as $product ) {
            add_post_meta( $product->ID, 'cmpd_promoted', 2 );
        }
    }

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

        self::setupConstants();
        self::setupOptions();
        self::loadClasses();
        self::registerActions();
    }

    /**
     * Register the plugin's shared actions (both backend and frontend)
     */
    private static function registerActions() {
        add_action( 'init', array( self::$calledClassName, 'registerPostTypeAndTaxonomies' ) );
        add_action( 'widgets_init', array( self::$calledClassName, 'registerWidgets' ) );

        add_filter( 'cmpd_reqister_post_type_args', array( self::$calledClassName, 'addComments' ) );
        add_filter( 'wp_insert_post_data', array( self::$calledClassName, 'defaultCommentsState' ) );
    }

    public static function addComments( $args ) {
        $comments = CMPD_Settings::getOption( CMPD_Settings::OPTION_SHOW_COMMENTS );
        if ( $comments ) {
            $args[ 'supports' ][] = 'comments';
        }
        return $args;
    }

    public static function defaultCommentsState( $data ) {
        $comments = CMPD_Settings::getOption( CMPD_Settings::OPTION_SHOW_COMMENTS );
        if ( CMProductDirectoryShared::POST_TYPE === $data[ 'post_type' ] ) {
            if ( $comments ) {
                $data[ 'comment_status' ] = 'open';
            }
        }
        return $data;
    }

    /**
     * Create custom post type
     */
    public static function registerWidgets() {
        CMPDSingleRandomProduct::init();
        register_widget( CMPDSingleRandomProduct::$calledClassName );

        CMPDWidgetCatWithNumber::init();
        register_widget( CMPDWidgetCatWithNumber::$calledClassName );

        CMPDLatestProducts::init();
        register_widget( CMPDLatestProducts::$calledClassName );
    }

    /**
     * Setup plugin constants
     *
     * @access private
     * @since 1.1
     * @return void
     */
    private static function setupConstants() {
        // code...
    }

    /**
     * Setup plugin constants
     *
     * @access private
     * @since 1.1
     * @return void
     */
    private static function setupOptions() {
        /*
         * Adding additional options
         */
        do_action( 'cmpd_setup_options' );
    }

    /**
     * Create taxonomies
     */
    public static function cmpd_create_taxonomies() {
        return;
    }

    /**
     * Load plugin's required classes
     *
     * @access private
     * @since 1.1
     * @return void
     */
    private static function loadClasses() {
        /*
         * Load the file with shared global functions
         */
        include_once CMPD_PLUGIN_DIR . "shared/functions.php";
        include_once CMPD_PLUGIN_DIR . "shared/classes/CMPDSingleRandomProduct.php";
        include_once CMPD_PLUGIN_DIR . "shared/classes/CMPDWidgetCatWithNumber.php";
        include_once CMPD_PLUGIN_DIR . 'shared/classes/CMPDLatestProducts.php';
    }

    public function registerShortcodes() {
        return;
    }

    public function registerFilters() {
        return;
    }

    public static function initSession() {
        if ( !session_id() ) {
            session_start();
        }
    }

    /**
     * Create custom post type
     */
    public static function registerPostTypeAndTaxonomies() {
        $permalink = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_PERMALINK );
        $rewrite   = false;
        if ( empty( $permalink ) ) {
            $rewrite   = true;
            $permalink = self::POST_TYPE;
        } else {
            $old_permalink = get_option( 'cmpd_permalink_old' );
            if ( $old_permalink !== $permalink || !empty( $old_permalink ) ) {
                update_option( 'cmpd_permalink_old', $permalink );
                $rewrite = true;
            }
        }
        $postType         = self::POST_TYPE;
        $postTypeTaxonomy = self::POST_TYPE_TAXONOMY;

        $args = array(
            // 'label'  => 'Product',
            'labels'              => array(
                'name'               => __( 'Product', CMPD_SLUG_NAME ),
                'singular_name'      => __( 'Product', CMPD_SLUG_NAME ),
                'menu_name'          => _x( CMPD_NAME, 'Admin menu name', CMPD_SLUG_NAME ),
                'all_items'          => __( 'Product', CMPD_SLUG_NAME ),
                'add_new'            => __( 'Add Product', CMPD_SLUG_NAME ),
                'add_new_item'       => __( 'Add New Product', CMPD_SLUG_NAME ),
                'edit'               => __( 'Edit', CMPD_SLUG_NAME ),
                'edit_item'          => __( 'Edit Product', CMPD_SLUG_NAME ),
                'new_item'           => __( 'New Product', CMPD_SLUG_NAME ),
                'all_items'          => __( 'Product', CMPD_SLUG_NAME ),
                'view'               => __( 'View Product', CMPD_SLUG_NAME ),
                'view_item'          => __( 'View Product', CMPD_SLUG_NAME ),
                'search_items'       => __( 'Search Product', CMPD_SLUG_NAME ),
                'not_found'          => __( 'No Product found', CMPD_SLUG_NAME ),
                'not_found_in_trash' => __( 'No Product found in trash', CMPD_SLUG_NAME ),
                'parent'             => __( 'Parent Product', CMPD_SLUG_NAME )
            ),
            'description'         => '',
            'map_meta_cap'        => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 500,
            '_builtin'            => false,
            'capability_type'     => 'post',
            'hierarchical'        => true,
            'has_archive'         => true,
            'rewrite'             => array( 'slug' => $permalink, 'with_front' => false ),
            'query_var'           => true,
            'supports'            => array( 'title', 'editor', 'excerpt', 'revisions', 'page-attributes', 'custom-fields' ), //'post-thumbnails', 'thumbnail',
            'taxonomies'          => array( 'post_tag', $postTypeTaxonomy )
        );

        register_post_type( $postType, apply_filters( 'cmpd_reqister_post_type_args', $args ) );

        register_taxonomy( $postTypeTaxonomy, $postType, array(
            'hierarchical'      => true,
            'label'             => __( 'Product Categories', CMPD_SLUG_NAME ),
            'labels'            => array(
                'name'              => __( 'Product Categories', CMPD_SLUG_NAME ),
                'singular_name'     => __( 'Product Category', CMPD_SLUG_NAME ),
                'menu_name'         => _x( 'Categories', 'Admin menu name', CMPD_SLUG_NAME ),
                'search_items'      => __( 'Search Product Categories', CMPD_SLUG_NAME ),
                'all_items'         => __( 'All Product Categories', CMPD_SLUG_NAME ),
                'parent_item'       => __( 'Parent Product Category', CMPD_SLUG_NAME ),
                'parent_item_colon' => __( 'Parent Product Category:', CMPD_SLUG_NAME ),
                'edit_item'         => __( 'Edit Product Category', CMPD_SLUG_NAME ),
                'update_item'       => __( 'Update Product Category', CMPD_SLUG_NAME ),
                'add_new_item'      => __( 'Add New Product Category', CMPD_SLUG_NAME ),
                'new_item_name'     => __( 'New Product Category Name', CMPD_SLUG_NAME )
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'rewrite'           => array(
                'slug'         => $postTypeTaxonomy,
                'with_front'   => false,
                'hierarchical' => true,
            )
        )
        );

        register_taxonomy( self::POST_TYPE_TAX_PRICINGMODEL, self::POST_TYPE, array(
            'hierarchical'      => true,
            'label'             => __( 'Pricing Model', CMPD_SLUG_NAME ),
            'labels'            => array(
                'name'              => __( 'Pricing Models', CMPD_SLUG_NAME ),
                'singular_name'     => __( 'Pricing Model', CMPD_SLUG_NAME ),
                'menu_name'         => _x( 'Pricing Models', 'Admin menu name', CMPD_SLUG_NAME ),
                'search_items'      => __( 'Search Pricing Model', CMPD_SLUG_NAME ),
                'all_items'         => __( 'All Pricing Models', CMPD_SLUG_NAME ),
                'parent_item'       => __( 'Parent Pricing Model', CMPD_SLUG_NAME ),
                'parent_item_colon' => __( 'Parent Pricing Model:', CMPD_SLUG_NAME ),
                'edit_item'         => __( 'Edit Pricing Model', CMPD_SLUG_NAME ),
                'update_item'       => __( 'Update Pricing Model', CMPD_SLUG_NAME ),
                'add_new_item'      => __( 'Add New Pricing Model', CMPD_SLUG_NAME ),
                'new_item_name'     => __( 'New Pricing Model Name', CMPD_SLUG_NAME ),
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'rewrite'           => array(
                'slug'         => self::POST_TYPE_TAX_PRICINGMODEL,
                'with_front'   => false,
                'hierarchical' => true,
            )
        )
        );

        register_taxonomy( self::POST_TYPE_TAX_LANGUAGESUPPORT, self::POST_TYPE, array(
            'hierarchical'      => true,
            'label'             => __( 'Language Support', CMPD_SLUG_NAME ),
            'labels'            => array(
                'name'              => __( 'Language Support', CMPD_SLUG_NAME ),
                'singular_name'     => __( 'Language Support', CMPD_SLUG_NAME ),
                'menu_name'         => _x( 'Language Support', 'Admin menu name', CMPD_SLUG_NAME ),
                'search_items'      => __( 'Search Language Support', CMPD_SLUG_NAME ),
                'all_items'         => __( 'All Language Support', CMPD_SLUG_NAME ),
                'parent_item'       => __( 'Parent Language Support', CMPD_SLUG_NAME ),
                'parent_item_colon' => __( 'Parent Language Support:', CMPD_SLUG_NAME ),
                'edit_item'         => __( 'Edit Language Support', CMPD_SLUG_NAME ),
                'update_item'       => __( 'Update Language Support', CMPD_SLUG_NAME ),
                'add_new_item'      => __( 'Add New Language Support', CMPD_SLUG_NAME ),
                'new_item_name'     => __( 'New Language Support Name', CMPD_SLUG_NAME ),
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'rewrite'           => array(
                'slug'         => self::POST_TYPE_TAX_LANGUAGESUPPORT,
                'with_front'   => false,
                'hierarchical' => true,
            )
        )
        );

        register_taxonomy( self::POST_TYPE_TAX_TARGETAUDIENCE, self::POST_TYPE, array(
            'hierarchical'      => true,
            'label'             => __( 'Target Audience', CMPD_SLUG_NAME ),
            'labels'            => array(
                'name'              => __( 'Target Audiences', CMPD_SLUG_NAME ),
                'singular_name'     => __( 'Target Audience', CMPD_SLUG_NAME ),
                'menu_name'         => _x( 'Target Audiences', 'Admin menu name', CMPD_SLUG_NAME ),
                'search_items'      => __( 'Search Target Audience', CMPD_SLUG_NAME ),
                'all_items'         => __( 'All Target Audiences', CMPD_SLUG_NAME ),
                'parent_item'       => __( 'Parent Target Audience', CMPD_SLUG_NAME ),
                'parent_item_colon' => __( 'Parent Target Audience:', CMPD_SLUG_NAME ),
                'edit_item'         => __( 'Edit Target Audience', CMPD_SLUG_NAME ),
                'update_item'       => __( 'Update Target Audience', CMPD_SLUG_NAME ),
                'add_new_item'      => __( 'Add New Target Audience', CMPD_SLUG_NAME ),
                'new_item_name'     => __( 'New Target Audience Name', CMPD_SLUG_NAME ),
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'rewrite'           => array(
                'slug'         => self::POST_TYPE_TAX_TARGETAUDIENCE,
                'with_front'   => false,
                'hierarchical' => true,
            )
        )
        );

        if ( $rewrite ) {
            global $wp_rewrite;
            // Clear the permalinks
            flush_rewrite_rules();
            //Call flush_rules() as a method of the $wp_rewrite object
            $wp_rewrite->flush_rules();
        }
    }

    /*
     * Tags Search
     */

    public static function posts_join( $join, $query ) {
        global $wpdb;
        $s = $query->query_vars[ 's' ];
        if ( is_main_query() && !empty( $s ) ) {
            $join .= "
                LEFT JOIN
                (
                    `{$wpdb->term_relationships}`
                    INNER JOIN
                        `{$wpdb->term_taxonomy}` ON `{$wpdb->term_taxonomy}`.term_taxonomy_id = `{$wpdb->term_relationships}`.term_taxonomy_id
                    INNER JOIN
                        `{$wpdb->terms}` ON `{$wpdb->terms}`.term_id = `{$wpdb->term_taxonomy}`.term_id
                )
                ON `{$wpdb->posts}`.ID = `{$wpdb->term_relationships}`.object_id ";
        }
        return $join;
    }

    /*
     * Tags Search
     */

    public static function posts_where( $where, $query ) {
        global $wpdb;
        $s = $query->query_vars[ 's' ];
        if ( is_main_query() && !empty( $s ) ) {
            $taxonomies = self::posts_where_taxonomies();
            $taxonomies = implode( ', ', $taxonomies );
            $where .= " OR (
                            `{$wpdb->term_taxonomy}`.taxonomy IN( {$taxonomies} )
                            AND
                            `{$wpdb->terms}`.name LIKE '%" . esc_sql( $s ) . "%'
                        )";
        }
        return $where;
    }

    /*
     * Tags Search
     */

    public static function posts_groupby( $groupby, $query ) {
        global $wpdb;
        $s = $query->query_vars[ 's' ];
        if ( is_main_query() && !empty( $s ) ) {
            $groupby = "`{$wpdb->posts}`.ID";
        }
        return $groupby;
    }

    /*
     * Tags Search
     */

    public static function posts_where_taxonomies() {
        $taxonomies = array(
            'post_tag',
        );
        $taxonomies = apply_filters( 'cmpd_posts_where_taxonomies', $taxonomies );
        foreach ( $taxonomies as $index => $taxonomy ) {
            $taxonomies[ $index ] = sprintf( "'%s'", esc_sql( $taxonomy ) );
        }
        return $taxonomies;
    }

    /**
     * Gets the list of the product
     * @param type $atts
     * @return type
     */
    public static function getProduct_s( $atts = array(), $get_for_filters = null ) {
        static $setLastQuery = 0;
        $postTypes           = array( CMProductDirectoryShared::POST_TYPE );
        $orderby             = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_ORDERBY );
        $order               = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_ORDER );

        if ( !empty( $atts[ 'page_product' ] ) ) {
            $args = array(
                'posts_per_page'   => $atts[ 'page_product' ],
                'paged'            => $atts[ 'pg' ],
                'post_status'      => 'publish',
                'post_type'        => CMProductDirectoryShared::POST_TYPE,
                'orderby'          => array( $orderby => $order ),
                'suppress_filters' => false,
            );
        }

        $metaQueryArgs = array( 'relation' => 'OR', );

        if ( !empty( $atts[ 'query' ] ) ) {

            $meta_keys = self::getMetaKeys();

            unset( $meta_keys[ 'cmpd_rating' ] );

            $unset_video  = CMPD_Settings::getOption( CMPD_Settings::OPTION_ACTIVATE_VIDEO_FIELD );
            $unset_fields = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_FIELDS );
            $unset_links  = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_LINKS );

            if ( $unset_video === 0 ) {
                unset( $meta_keys[ 'cmpd_product_video' ] );
            }
            if ( $unset_fields === 0 ) {
                unset( $meta_keys[ 'cmpd_add_field1' ] );
                unset( $meta_keys[ 'cmpd_add_field2' ] );
                unset( $meta_keys[ 'cmpd_add_field3' ] );
                unset( $meta_keys[ 'cmpd_add_field4' ] );
            }
            if ( $unset_links === 0 ) {
                unset( $meta_keys[ 'cmpd_add_link1' ] );
                unset( $meta_keys[ 'cmpd_add_link2' ] );
                unset( $meta_keys[ 'cmpd_add_link3' ] );
                unset( $meta_keys[ 'cmpd_add_link4' ] );
            }

            $searchableMetaFields = array();
            foreach ( $meta_keys as $item ) {
                array_push( $searchableMetaFields, $item[ 'key_name' ] );
            }

            foreach ( $searchableMetaFields as $fieldKey ) {
                $metaQueryArgs[] = array(
                    'key'     => $fieldKey,
                    'value'   => $atts[ 'query' ],
                    'compare' => 'LIKE',
                );
            }
        }

        $args[ 'meta_query' ]              = $metaQueryArgs;
        $args[ 'tax_query' ][ 'relation' ] = 'AND';

        // Categories
        if ( !empty( $atts[ 'cmcats' ] ) && !in_array( 'all', $atts[ 'cmcats' ] ) ):

            if ( !empty( $atts[ 'limited_cmcats' ] ) ) {
                foreach ( $atts[ 'limited_cmcats' ] as $limited_term ) {
                    if ( !in_array( $limited_term, $atts[ 'cmcats' ] ) && $limited_term != 'all' ) {
                        array_push( $atts[ 'cmcats' ], $limited_term );
                    }
                }
            }
            $operator = sizeof( $atts[ 'cmcats' ] ) > 1 ? 'IN' : 'AND';

            $args[ 'tax_query' ][] = array(
                'taxonomy' => CMProductDirectoryShared::POST_TYPE_TAXONOMY,
                'terms'    => $atts[ 'cmcats' ],
                'operator' => $operator,
                'field'    => 'slug',
            );
        endif;

        // Pricing Models
        if ( !empty( $atts[ 'cmpd_pricing_model' ] ) && !in_array( 'all', $atts[ 'cmpd_pricing_model' ] ) ):

            if ( !empty( $atts[ 'limited_cmpd_pricing_model' ] ) ) {
                foreach ( $atts[ 'limited_cmpd_pricing_model' ] as $limited_term ) {
                    if ( !in_array( $limited_term, $atts[ 'cmpd_pricing_model' ] ) && $limited_term != 'all' ) {
                        array_push( $atts[ 'cmpd_pricing_model' ], $limited_term );
                    }
                }
            }
            $operator = sizeof( $atts[ 'cmpd_pricing_model' ] ) > 1 ? 'IN' : 'AND';

            $args[ 'tax_query' ][] = array(
                'taxonomy' => CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL,
                'terms'    => $atts[ 'cmpd_pricing_model' ],
                'operator' => $operator,
                'field'    => 'slug',
            );
        endif;

        // Language Supports
        if ( !empty( $atts[ 'cmpd_language_support' ] ) && !in_array( 'all', $atts[ 'cmpd_language_support' ] ) ):

            if ( !empty( $atts[ 'limited_cmpd_language_support' ] ) ) {
                foreach ( $atts[ 'limited_cmpd_language_support' ] as $limited_term ) {
                    if ( !in_array( $limited_term, $atts[ 'cmpd_language_support' ] ) && $limited_term != 'all' ) {
                        array_push( $atts[ 'cmpd_language_support' ], $limited_term );
                    }
                }
            }
            $operator = sizeof( $atts[ 'cmpd_language_support' ] ) > 1 ? 'IN' : 'AND';

            $args[ 'tax_query' ][] = array(
                'taxonomy' => CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT,
                'terms'    => $atts[ 'cmpd_language_support' ],
                'operator' => $operator,
                'field'    => 'slug',
            );
        endif;
        // Target Audiences
        if ( !empty( $atts[ 'cmpd_target_audience' ] ) && !in_array( 'all', $atts[ 'cmpd_target_audience' ] ) ):

            if ( !empty( $atts[ 'limited_cmpd_target_audience' ] ) ) {
                foreach ( $atts[ 'limited_cmpd_target_audience' ] as $limited_term ) {
                    if ( !in_array( $limited_term, $atts[ 'cmpd_target_audience' ] ) && $limited_term != 'all' ) {
                        array_push( $atts[ 'cmpd_target_audience' ], $limited_term );
                    }
                }
            }
            $operator = sizeof( $atts[ 'cmpd_target_audience' ] ) > 1 ? 'IN' : 'AND';

            $args[ 'tax_query' ][] = array(
                'taxonomy' => CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE,
                'terms'    => $atts[ 'cmpd_target_audience' ],
                'operator' => $operator,
                'field'    => 'slug',
            );
        endif;

        if ( !empty( $atts[ 'cmtags' ] ) && !in_array( 'all', $atts[ 'cmtags' ] ) ) {
            $args[ 'tag_slug__in' ] = $atts[ 'cmtags' ];
        }

        if ( !empty( $atts[ 'product_ids' ] ) ) {
            $atts[ 'product_ids' ] = is_array( $atts[ 'product_ids' ] ) ? $atts[ 'product_ids' ] : array( $atts[ 'product_ids' ] );
            $args[ 'post__in' ]    = $atts[ 'product_ids' ];
        }

        /*
         * Return only product with given ids
         */
        if ( !empty( $atts[ 'exclude_ids' ] ) ) {
            $atts[ 'exclude_ids' ]  = is_array( $atts[ 'exclude_ids' ] ) ? $atts[ 'exclude_ids' ] : array( $atts[ 'exclude_ids' ] );
            $args[ 'post__not_in' ] = $atts[ 'exclude_ids' ];
        }

        if ( !empty( $atts[ 'fields' ] ) ) {
            $args[ 'fields' ] = $atts[ 'fields' ];
        }

        /*
         * Return only business which title/description includes the query
         */
        if ( !empty( $atts[ 'query' ] ) ) {
            $args[ 's' ] = $atts[ 'query' ];
            add_filter( 'get_meta_sql', array( __CLASS__, 'specialMetaFilter' ) );
        }
        add_filter( 'posts_join', array( __CLASS__, 'specialSearchFilter' ), 10, 2 );
        add_filter( 'posts_orderby', array( __CLASS__, 'specialSearchFilterOrderby' ), 10, 2 );

        /*
         * Tags Search
         */
        $searchInTags = CMPD_Settings::getOption( CMPD_Settings::OPTION_SEARCH_IN_TAGS );
        if ( $searchInTags ) {
            add_filter( 'posts_join', array( __CLASS__, 'posts_join' ), 10, 2 );
            add_filter( 'posts_where', array( __CLASS__, 'posts_where' ), 10, 2 );
            add_filter( 'posts_groupby', array( __CLASS__, 'posts_groupby' ), 10, 2 );
        }
        /*
         * Tags Search End
         */

        // Show businesses after using search only
        $show_after_search_option = CMPD_Settings::getOption( CMPD_Settings::OPTION_SHOW_WHEN_SEARCH );

        if ( $show_after_search_option && empty( $atts[ 'query' ] ) ) {
            $args[ 'p' ] = -1;
        }


        $query = new WP_Query( apply_filters( 'get_cmproduct_query_args', $args, $atts ) );

        /*
         * Store the query to save info about pagination
         */
        if ( $setLastQuery == 0 ) {
            self::$lastProductQuery = $query;
            $setLastQuery           = 1;
        }

        $product = $query->posts;

        if ( !empty( $atts[ 'query' ] ) ) {
            remove_filter( 'get_meta_sql', array( __CLASS__, 'specialMetaFilter' ) );
        }
        remove_filter( 'posts_join', array( __CLASS__, 'specialSearchFilter' ) );
        remove_filter( 'posts_orderby', array( __CLASS__, 'specialSearchFilterOrderby' ) );

        return $product;
    }

    public static function specialSearchFilter( $join, $query ) {
        global $wpdb;

        $new_join = "
        INNER JOIN {$wpdb->postmeta} AS pm1 ON 1=1
            AND pm1.post_id = {$wpdb->posts}.ID
            AND pm1.meta_key = 'cmpd_promoted'";

        return $join . ' ' . $new_join;
    }

    public static function specialSearchFilterOrderby( $orderby, $query ) {
        global $wpdb;

        $new_orderby = "pm1.meta_value ASC";
        if ( !empty( $orderby ) ) {
            $new_orderby .= ',';
        }

        return $new_orderby . ' ' . $orderby;
    }

    public static function specialMetaFilter( $sql ) {
        if ( !empty( $sql[ 'where' ] ) ) {
            $sql[ 'where' ] = preg_replace( '/' . preg_quote( 'AND', '/' ) . '/', 'OR', $sql[ 'where' ], 1 );
        }
        return $sql;
    }

    public static function getProduct( $productIdName ) {
        if ( is_numeric( $productIdName ) ) {
            $product = get_post( $productIdName );
            if ( !$product || CMProductDirectoryShared::POST_TYPE !== $product->post_type )
                return null;
            return $product;
        }

        $args = array(
            'post_type'   => CMProductDirectoryShared::POST_TYPE,
            'name'        => $product,
            'numberposts' => 1
        );

        $product = get_posts( $args );

        if ( $product ) {
            return $product[ 0 ];
        }

        return null;
    }

    public static function scanTemplateDir() {
        $template_dir = CMPD_PLUGIN_DIR . 'frontend/templates/';
        $templates    = array();

        if ( is_dir( $template_dir ) ) {
            $dir = scandir( $template_dir );
            foreach ( $dir as $template ) {
                if ( !in_array( $template, array( ".", ".." ) ) ) {
                    if ( is_dir( $template_dir . $template ) ) {
                        if ( !array_key_exists( $template, $templates ) ) {
                            $templates[ $template ] = $template;
                        }
                    }
                }
            }
        }

        $template_dir = get_stylesheet_directory() . '/CMPD/';
        if ( is_dir( $template_dir ) ) {
            $dir = scandir( $template_dir );
            foreach ( $dir as $template ) {
                if ( !in_array( $template, array( ".", ".." ) ) ) {
                    if ( is_dir( $template_dir . $template ) ) {
                        if ( !array_key_exists( $template, $templates ) ) {
                            $templates[ $template ] = $template;
                        }
                    }
                }
            }
        }

        return $templates;
    }

    public static function getMetaKeys() {
        $keys = array(
            'cmpd_product_gallery'       => array( 'key_name' => 'cmpd_product_gallery' ),
            'cmpd_product_gallery_id'    => array( 'key_name' => 'cmpd_product_gallery_id' ),
            'cmpd_product_image_gallery' => array( 'key_name' => 'cmpd_product_image_gallery' ),
            'cmpd_purchase_link'         => array( 'key_name' => 'cmpd_purchase_link' ),
            'cmpd_demo_link'             => array( 'key_name' => 'cmpd_demo_link' ),
            'cmpd_product_page'          => array( 'key_name' => 'cmpd_product_page' ),
            'cmpd_product_video'         => array( 'key_name' => 'cmpd_product_video' ),
            'cmpd_product_cost'          => array( 'key_name' => 'cmpd_product_cost' ),
            'cmpd_company_name'          => array( 'key_name' => 'cmpd_company_name' ),
            'cmpd_bemail_contact'        => array( 'key_name' => 'cmpd_bemail_contact' ),
            'cmpd_phone'                 => array( 'key_name' => 'cmpd_phone' ),
            'cmpd_bemail'                => array( 'key_name' => 'cmpd_bemail' ),
            'cmpd_web_url'               => array( 'key_name' => 'cmpd_web_url' ),
            'cmpd_product_pitch'         => array( 'key_name' => 'cmpd_product_pitch' ),
            'cmpd_rating'                => array( 'key_name' => 'cmpd_rating' ),
            'cmpd_promoted'              => array( 'key_name' => 'cmpd_promoted' ),
            'cmpd_year_founded'          => array( 'key_name' => 'cmpd_year_founded' ),
            'cmpd_virtual_address'       => array( 'key_name' => 'cmpd_virtual_address' ),
            'cmpd_address'               => array( 'key_name' => 'cmpd_address' ),
            'cmpd_cityTown'              => array( 'key_name' => 'cmpd_cityTown' ),
            'cmpd_region'                => array( 'key_name' => 'cmpd_region' ),
            'cmpd_stateCounty'           => array( 'key_name' => 'cmpd_stateCounty' ),
            'cmpd_country'               => array( 'key_name' => 'cmpd_country' ),
            'cmpd_postalcode'            => array( 'key_name' => 'cmpd_postalcode' ),
            'cmpd_add_address_field'     => array( 'key_name' => 'cmpd_add_address_field' ),
            'cmpd_add_google_map'        => array( 'key_name' => 'cmpd_add_google_map' ),
            'cmpd_facebook_name'         => array( 'key_name' => 'cmpd_facebook_name' ),
            'cmpd_twitter_name'          => array( 'key_name' => 'cmpd_twitter_name' ),
            'cmpd_google'                => array( 'key_name' => 'cmpd_google' ),
            'cmpd_linkedin'              => array( 'key_name' => 'cmpd_linkedin' ),
            'cmpd_rss_name'              => array( 'key_name' => 'cmpd_rss_name' ),
            'cmpd_add_field1'            => array( 'key_name' => 'cmpd_add_field1' ),
            'cmpd_add_field2'            => array( 'key_name' => 'cmpd_add_field2' ),
            'cmpd_add_field3'            => array( 'key_name' => 'cmpd_add_field3' ),
            'cmpd_add_field4'            => array( 'key_name' => 'cmpd_add_field4' ),
            'cmpd_add_link1'             => array( 'key_name' => 'cmpd_add_link1' ),
            'cmpd_add_link2'             => array( 'key_name' => 'cmpd_add_link2' ),
            'cmpd_add_link3'             => array( 'key_name' => 'cmpd_add_link3' ),
            'cmpd_add_link4'             => array( 'key_name' => 'cmpd_add_link4' ),
        );
        return $keys;
    }

}
