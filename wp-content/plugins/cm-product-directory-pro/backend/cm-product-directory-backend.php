<?php
//include_once CMPD_PLUGIN_DIR . '/shared/cm-product-directory-shared.php';
include_once CMPD_PLUGIN_DIR . '/frontend/cm-product-directory-product-page.php';

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class CMProductDirectoryBackend {

    public static $calledClassName;
    protected static $instance  = NULL;
    protected static $cssPath   = NULL;
    protected static $jsPath    = NULL;
    protected static $viewsPath = NULL;

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
        self::setupConstans();

        self::$cssPath   = CMPD_PLUGIN_URL . 'backend/assets/css/';
        self::$jsPath    = CMPD_PLUGIN_URL . 'backend/assets/js/';
        self::$viewsPath = CMPD_PLUGIN_DIR . 'backend/views/';

        add_action( 'admin_enqueue_scripts', array( self::$calledClassName, 'cmpd_enqeue_scripts' ) );
        add_action( 'admin_menu', array( self::$calledClassName, 'cmpd_admin_menu' ) );

        add_filter( 'manage_edit-' . CMProductDirectoryShared::POST_TYPE . '_columns', array( self::$calledClassName, 'editScreenColumns' ) );
        add_filter( 'manage_' . CMProductDirectoryShared::POST_TYPE . '_posts_custom_column', array( self::$calledClassName, 'editScreenColumnsContent' ), 10, 2 );
        add_filter( 'manage_edit-' . CMProductDirectoryShared::POST_TYPE . '_sortable_columns', array( self::$calledClassName, 'editScreenSortableColumns' ) );

        add_action( 'restrict_manage_posts', array( self::$calledClassName, 'editScreenCustomFilters' ) );
        add_filter( 'parse_query', array( self::$calledClassName, 'editScreenCustomPostTypeRequest' ) );

        add_action( 'admin_init', array( self::$calledClassName, 'cmpd_product_handleexport' ) );

        add_action( 'wp_ajax_cmpd_get_directory_backup', array( self::$calledClassName, 'cmpd_get_ProductBackup' ) );
        add_action( 'wp_ajax_nopriv_cmpd_get_directory_backup', array( self::$calledClassName, 'cmpd_get_ProductBackup' ) );
        add_action( 'add_meta_boxes', array( self::$calledClassName, 'addMetaBox' ) );
        add_action( 'add_meta_boxes', array( __CLASS__, 'add_product_gallery_metabox' ), 10 ); // Gallery
        add_action( 'save_post', array( self::$calledClassName, 'saveMetabox' ) );
        add_filter( 'CMPD_admin_settings', array( self::$calledClassName, 'addAdminSettings' ) );

        add_filter( 'cmpd_save_options_before', array( self::$calledClassName, 'toggleCommentsStatus' ) );

        add_image_size( 'cm-admin-thumb', 100, 100 );
        $permalink_structure = get_option( 'permalink_structure' );
        if ( empty( $permalink_structure ) ) {
            echo '<div id="message" class="error"><p><strong>Permalinks are disabled, CM Product Directory can work incorrectly</strong></p></div>';
        }

        add_action( 'admin_menu', array( __CLASS__, 'remove_additional_taxonomy_field' ) );

        /*
         * Taxonomy Featured Image
         */
        $keys = array(
            CMProductDirectoryShared::POST_TYPE_TAXONOMY,
            CMProductDirectoryShared::POST_TYPE_TAXONOMY_TAG,
            CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL,
            CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT,
            CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE,
        );

        foreach ( $keys as $item ) {
            // Add
            add_action( $item . '_add_form_fields', array( __CLASS__, 'add_featured_image_field' ), 10, 2 );

            // Edit
            add_action( $item . '_edit_form_fields', array( __CLASS__, 'edit_featured_image_field' ), 10, 2 );

            // Save
            add_action( 'edited_' . $item, array( __CLASS__, 'save_featured_image_field' ), 10, 2 );
            add_action( 'created_' . $item, array( __CLASS__, 'save_featured_image_field' ), 10, 2 );
        }
    }

    /*
     * Taxonomy Featured Image
     */

    public static function add_featured_image_field() {
        ?>
        <fieldset class="form-field term-description-wrap">
            <label for="cmpd_category_featured_image"><?php _e( 'Taxonomy Featured Image', CMPD_SLUG_NAME ); ?></label>
            <input type="text" name="cmpd_category_featured_image" id="cmpd_category_featured_image" />
            <p><?php _e( 'Enter Image ID: copy ID from navigation bar after upload into Media', CMPD_SLUG_NAME ); ?></p>
        </fieldset>
        <?php
    }

    public static function edit_featured_image_field( $term ) {
        $image_id = get_term_meta( $term->term_id, 'cmpd_category_featured_image', true );
        ?>
        <tr class="form-field form-required term-name-wrap">
            <th scope="row"><label for="cmpd_category_featured_image"><?php _e( 'Taxonomy Featured Image', CMPD_SLUG_NAME ); ?></label></th>
            <td><input name="cmpd_category_featured_image" id="cmpd_category_featured_image" value="<?php echo esc_attr( $image_id ); ?>" type="text" size="40" />
                <p class="description"><?php _e( 'Enter Image ID: copy ID from navigation bar after upload into Media', CMPD_SLUG_NAME ); ?></p></td>
        </tr>
        <?php
    }

    public static function save_featured_image_field( $term_id, $tt_id ) {
        if ( isset( $_POST[ 'cmpd_category_featured_image' ] ) ) {
            $image = $_POST[ 'cmpd_category_featured_image' ];
            update_term_meta( $term_id, 'cmpd_category_featured_image', $image );
        }
    }

    /**
     * Change comments status
     * @global type $wpdb
     */
    public static function toggleCommentsStatus() {
        global $wpdb;
        $post          = filter_input_array( INPUT_POST );
        $commentsSaved = CMPD_Settings::getOption( CMPD_Settings::OPTION_SHOW_COMMENTS );
        $comments      = $post[ CMPD_Settings::OPTION_SHOW_COMMENTS ];

        /*
         * Status changes
         */
        if ( $comments != $commentsSaved ) {
            $status = $comments ? 'open' : 'closed';

            $results = $wpdb->update(
            $wpdb->posts, array(
                'comment_status' => $status,
            ), array( 'post_type' => CMProductDirectoryShared::POST_TYPE ), array(
                '%s', // value1
            ) );
        }
    }

    public static function postPublished() {
        do_action( 'save_post' );
    }

    public static function setupConstans() {
        if ( !defined( 'CMPD_BACKUP_FILENAME' ) ) {
            define( 'CMPD_BACKUP_FILENAME', 'exportData.json' );
        }
    }

    public static function cmpd_enqeue_scripts() {
        $currentScreen = get_current_screen();

        if ( $currentScreen->id == 'cm-product_page_cm-product-directory-settings' OR $currentScreen->id == 'cm-product' ) {
            $path = self::$jsPath . 'cmpd_admin_scripts.js';

            wp_enqueue_script( 'cmpd-admin-functions', $path, array( 'jquery', 'jquery-ui-tooltip', 'jquery-ui-datepicker', 'wp-color-picker', 'media-upload', 'thickbox' ) );

            wp_enqueue_script( 'media-upload' );
            wp_enqueue_script( 'thickbox' );

            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_style( 'thickbox' );
            wp_enqueue_style( 'cmpd-admin', self::$cssPath . 'cmpd_admin.css' );

            wp_enqueue_script( 'cmpd-google-map', 'https://maps.googleapis.com/maps/api/js', array( 'jquery' ) );

            wp_register_script( 'cmpd-functions', self::$jsPath . 'cmpd-functions.js', array( 'jquery' ) );
            wp_enqueue_script( 'cmpd_product_gallery_meta_boxes', self::$jsPath . 'cmpd_meta_boxes_product.js' );
        }
    }

    public static function cmpd_admin_menu() {
        add_submenu_page( 'edit.php?post_type=' . CMProductDirectoryShared::POST_TYPE, 'Settings', __( 'Settings', CMPD_SLUG_NAME ), 'manage_options', CMPD_SLUG_NAME . '-settings', array( self::$calledClassName, 'cmpd_render_page' ) );
        add_submenu_page( 'edit.php?post_type=' . CMProductDirectoryShared::POST_TYPE, 'Import/Export', __( 'Import/Export', CMPD_SLUG_NAME ), 'manage_options', CMPD_SLUG_NAME . '-importexprt', array( self::$calledClassName, 'cmpd_import_export_page' ) );
    }

    public static function cmpd_render_page() {
        global $wpdb;
        $pageId = filter_input( INPUT_GET, 'page' );

        switch ( $pageId ) {
            case CMPD_SLUG_NAME . '-settings': {
                    wp_enqueue_style( 'jquery-ui-tabs-css', self::$cssPath . 'jquery-ui-tabs.css' );
                    wp_enqueue_script( 'jquery-ui-tabs', false, array(), false, true );

                    $params = apply_filters( 'CMPD_admin_settings', array() );
                    extract( $params );

                    ob_start();
                    include_once self::$viewsPath . 'settings.phtml';
                    $content = ob_get_contents();
                    ob_end_clean();
                    break;
                }
            case CMPD_SLUG_NAME . '-about': {
                    ob_start();
                    include_once self::$viewsPath . 'about.phtml';
                    $content = ob_get_contents();
                    ob_end_clean();
                    break;
                }
        }

        self::displayAdminPage( $content );
    }

    public static function cmpd_import_export_page() {
        ob_start();
        $directoryShowCredentialsForm    = self::cmpd_directory_backup();
        $directoryShowBackupDownloadLink = self::cmpd_get_product_backup( false );
        include_once self::$viewsPath . 'import_export.phtml';
        //$content = ob_get_contents();
        ob_end_flush();
        //ob_end_clean();
    }

    public static function cmpd_directory_backup() {

        if ( empty( $_POST ) ) {
            return false;
        }

        check_admin_referer( 'cmpd_directory_do_backup' );

        if ( isset( $_POST[ 'cmpd_directory_doBackup' ] ) ) {
            $url = wp_nonce_url( 'admin.php?page=cmpd_import_export_page' );
            self::cmpd_doBackup( $url );
        }

        return false;
    }

    public static function cmpd_doBackup( $url = null ) {
        $form_fields = array( 'cmpd_directory_doBackup' ); // this is a list of the form field contents I want passed along between page views
        $method      = ''; // Normally you leave this an empty string and it figures it out by itself, but you can override the filesystem method here
        // check to see if we are trying to save a file


        if ( empty( $url ) ) {
            $url = wp_nonce_url( 'admin.php?page=cmpd_import_export_page' );
        }
        // okay, let's see about getting credentials
        if ( false === ($creds = request_filesystem_credentials( $url, $method, false, false, $form_fields ) ) ) {
            // if we get here, then we don't have credentials yet,
            // but have just produced a form for the user to fill in,
            // so stop processing for now
            return true; // stop the normal page form from displaying
        }

        // now we have some credentials, try to get the wp_filesystem running
        if ( !WP_Filesystem( $creds ) ) {
            // our credentials were no good, ask the user for them again
            request_filesystem_credentials( $url, $method, true, false, $form_fields );
            return true;
        }

        // get the upload directory
        $upload_dir = wp_upload_dir();
        $filename   = trailingslashit( $upload_dir[ 'basedir' ] ) . 'cmpd/';

        if ( !file_exists( $filename ) ) {
            if ( !wp_mkdir_p( $filename ) ) {
                echo 'wp_mkdir_p can\'t create file/folder ' . $filename;
                return;
            }
        }

        chmod( $filename, 0775 );
        $filename .= CMPD_BACKUP_FILENAME;

        $string    = '';
        $outstream = fopen( "php://temp", 'w' );

        $exportData = self::cmpd_prepare_directory_export();

        $data = json_encode( $exportData );
        fwrite( $outstream, $data );
        rewind( $outstream );
        while ( !feof( $outstream ) ) {
            $string .= fgets( $outstream );
        }
        fclose( $outstream );

        if ( !empty( $secureWrite ) ) {
            /*
             * by this point, the $wp_filesystem global should be working, so let's use it to create a file
             */
            global $wp_filesystem;
            if ( !$wp_filesystem->put_contents( $filename, $string, FS_CHMOD_FILE ) ) {
                echo 'error saving file!';
            }
        } else {
            file_put_contents( $filename, $string, LOCK_EX );
            chmod( $filename, 0775 );
        }
    }

    public static function cmpd_get_product_backup() {
        $upload_dir = wp_upload_dir();
        $filepath   = trailingslashit( $upload_dir[ 'basedir' ] ) . 'cmpd/' . CMPD_BACKUP_FILENAME;

        if ( file_exists( $filepath ) ) {
            $url = admin_url( 'admin-ajax.php?action=cmpd_get_directory_backup' );

            return $url;
        }

        return false;
    }

    /**
     * Outputs the backup file
     */
    public static function cmpd_get_ProductBackup() {
        self::cmpd_doBackup();
        $backupGlossary = self::cmpd_get_product_backup();

        if ( !empty( $backupGlossary ) ) {
            $upload_dir = wp_upload_dir();
            $filepath   = trailingslashit( $upload_dir[ 'basedir' ] ) . 'cmpd/' . CMPD_BACKUP_FILENAME;

            $outstream = fopen( $filepath, 'r' );
            rewind( $outstream );

            header( 'Content-Encoding: UTF-8' );
            header( 'Content-Type: application/json; charset=UTF-8' );
            header( 'Content-Disposition: attachment; filename=product_directory_backup_' . date( 'Ymd_His', current_time( 'timestamp' ) ) . '.json' );

            while ( !feof( $outstream ) ) {
                echo fgets( $outstream );
            }
            fclose( $outstream );
        }
        die();
    }

    public static function cmpd_prepare_directory_export() {
        $args = array(
            'post_type'   => 'cm-product',
            'post_status' => 'publish',
            'nopaging'    => true,
            'orderby'     => 'ID',
            'order'       => 'ASC'
        );

        $q          = new WP_Query( $args );
        $exportData = array();
        /*
         * Get all the Product Directory product
         */
        foreach ( $q->get_posts() as $product ) {
            /*
             * All the meta information
             */
            $meta                = get_post_meta( $product->ID, '', true );
            $get_tags            = get_the_terms( $product->ID, 'post_tag' );
            $get_cats            = get_the_terms( $product->ID, 'cm-product-category' );
            $get_pricingmodel    = get_the_terms( $product->ID, CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL );
            $get_languagesupport = get_the_terms( $product->ID, CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT );
            $get_targetaudience  = get_the_terms( $product->ID, CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE );


            $tags = array();
            if ( !empty( $get_tags ) ) {
                foreach ( $get_tags as $term ) {
                    $tags[] = $term->name;
                }
            }
            $cats = array();
            if ( !empty( $get_cats ) ) {
                foreach ( $get_cats as $term ) {
                    $cats[] = $term->name;
                }
            }
            $pricingmodel = array();
            if ( !empty( $get_pricingmodel ) ) {
                foreach ( $get_pricingmodel as $term ) {
                    $pricingmodel[] = $term->name;
                }
            }
            $languagesupport = array();
            if ( !empty( $get_languagesupport ) ) {
                foreach ( $get_languagesupport as $term ) {
                    $languagesupport[] = $term->name;
                }
            }
            $targetaudience = array();
            if ( !empty( $get_targetaudience ) ) {
                foreach ( $get_targetaudience as $term ) {
                    $targetaudience[] = $term->name;
                }
            }
            foreach ( $meta as $key => $value ) {
                $meta[ $key ] = is_array( $value ) ? $value[ 0 ] : $value;
            }
            $jsonEncodedMeta = json_encode( $meta );


            $image_id = CMProductDirectory::meta( $product->ID, 'cmpd_product_gallery_id' );
            $ids      = '';
            $gallery  = array();

            if ( !empty( $image_id ) ) {
                $ids = explode( ",", $image_id );
                foreach ( $ids as $id ) {
                    $gallery[] = array( 'url' => wp_get_attachment_image_src( $id, 'cmpd_image' ), 'ID' => $id, 'tiltle' => get_the_title( $id ), );
                }
            }

            $exportDataRow = array(
                'ID'                                                    => $product->ID,
                'post_title'                                            => $product->post_title,
                'post_name'                                             => $product->post_name,
                'post_excerpt'                                          => str_replace( array( "\r\n", "\n", "\r" ), array( "", "", "" ), nl2br( $product->post_excerpt ) ),
                'post_content'                                          => str_replace( array( "\r\n", "\n", "\r" ), array( "", "", "" ), nl2br( $product->post_content ) ),
                'post_meta'                                             => $meta,
                'post_category'                                         => $cats,
                'post_tags'                                             => $tags,
                CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL    => $pricingmodel,
                CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT => $languagesupport,
                CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE  => $targetaudience,
                // 'post_image' => $image,
                'post_gallery'                                          => $gallery
            );
            $exportData[]  = $exportDataRow;
        }

        return $exportData;
    }

    public static function cmpd_product_handleexport() {
        if ( !empty( $_POST[ 'cmpd_directory_doExport' ] ) ) {
            self::cmpd_doBackup();
            self::cmpd_get_ProductBackup();
        } else if ( !empty( $_POST[ 'cmpd_directory_doImport' ] ) && !empty( $_FILES[ 'cmpd_directory_import_file' ] ) && is_uploaded_file( $_FILES[ 'cmpd_directory_import_file' ][ 'tmp_name' ] ) ) {
            self::cmpd_import_directory( $_FILES[ 'cmpd_directory_import_file' ] );
        } else if ( !empty( $_FILES[ 'cmpd_directory_import_csv_file' ] ) ) {
            self::cmpd_import_csv( $_FILES[ 'cmpd_directory_import_csv_file' ] );
        }
    }

    public static function cmpd_import_csv( $file ) {
        $old_error_level = error_reporting( 0 );
        $get_new_items   = self::get_imported_items( $file );

        if ( !empty( $get_new_items ) ) {
            foreach ( $get_new_items as $item ) {
                if ( !empty( $item[ 'post' ][ 'post_title' ] ) ) {
                    // single post
                    $new_post_id = wp_insert_post( $item[ 'post' ] );

                    if ( $new_post_id ) {
                        foreach ( $item[ 'taxonomy' ][ 'category' ] as $category ) {
                            self::set_imported_term( $category, $new_post_id, CMProductDirectoryShared::POST_TYPE_TAXONOMY );
                        }

                        foreach ( $item[ 'taxonomy' ][ CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL ] as $tax ) {
                            self::set_imported_term( $tax, $new_post_id, CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL );
                        }

                        foreach ( $item[ 'taxonomy' ][ CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT ] as $tax ) {
                            self::set_imported_term( $tax, $new_post_id, CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT );
                        }

                        foreach ( $item[ 'taxonomy' ][ CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE ] as $tax ) {
                            self::set_imported_term( $tax, $new_post_id, CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE );
                        }

                        foreach ( $item[ 'taxonomy' ][ 'tag' ] as $tag ) {
                            self::set_imported_term( $tag, $new_post_id, CMProductDirectoryShared::POST_TYPE_TAXONOMY_TAG );
                        }

                        foreach ( $item[ 'post_meta' ] as $key => $value ) {
                            update_post_meta( $new_post_id, $key, $value );
                        }
                    }
                }
            }
        }

        $numberOfElements = sizeof( $get_new_items );

        error_reporting( $old_error_level );
        wp_redirect( esc_url_raw( add_query_arg( array( 'cmpd_msg' => 'imported', 'cmpd_productnumber' => $numberOfElements, ), $_SERVER[ 'REQUEST_URI' ] ) ), 303 );
        exit;
    }

    /*
     * Setting terms for posts imported from CSV
     */

    public static function set_imported_term( $taxonomy, $postId, $taxonomyName ) {
        $term = get_term_by( 'name', $taxonomy, $taxonomyName );
        if ( !$term ) {
            wp_insert_term( $taxonomy, $taxonomyName );
        }
        wp_set_object_terms( $postId, $taxonomy, $taxonomyName, true );
    }

    public static function get_imported_items( $file ) {
        $filesrc = $file[ 'tmp_name' ];
        $fp      = fopen( $filesrc, 'r+' );

        $tmp_items = array();
        while ( !feof( $fp ) ) {
            $tmp_items[] = fgetcsv( $fp, 0, ',', '"' );
        }

        $headings = $tmp_items[ 0 ];
        unset( $tmp_items[ 0 ] );

        $numberOfElements = 0;

        $items = array();
        foreach ( $tmp_items as $item ) {
            $items[] = array_combine( $headings, $item );
        }

        $newProducts = array();
        /*
         * Remove empty lines
         */
        $items       = array_filter( $items );

        /*
         * Check if there are fields to import
         */
        if ( !empty( $items ) ) {
            foreach ( $items as $key => $value ) {
                $newProduct = array(
                    'post'      => array(
                        'post_title'   => $value[ 'post_title' ],
                        'post_type'    => CMProductDirectoryShared::POST_TYPE,
                        'post_content' => $value[ 'post_content' ],
                        'post_status'  => 'publish',
                    ),
                    'taxonomy'  => array(
                        'category'              => array(),
                        'tag'                   => array(),
                        'cmpd_pricing_model'    => array(),
                        'cmpd_language_support' => array(),
                        'cmpd_target_audience'  => array(),
                    ),
                    'post_meta' => array(),
                );

                foreach ( $value as $key => $value ) {

                    /*
                     * Check if field contains slash and value is not empty
                     */
                    if ( strpos( $key, '/' ) !== FALSE && !empty( $value ) ) {
                        $explodedKey = explode( '/', $key );

                        if ( 'post_category' === $explodedKey[ 0 ] ) {
                            $newProduct[ 'taxonomy' ][ 'category' ][] = $value;
                        }
                        if ( 'cmpd_pricing_model' === $explodedKey[ 0 ] ) {
                            $newProduct[ 'taxonomy' ][ 'cmpd_pricing_model' ][] = $value;
                        }
                        if ( 'cmpd_language_support' === $explodedKey[ 0 ] ) {
                            $newProduct[ 'taxonomy' ][ 'cmpd_language_support' ][] = $value;
                        }
                        if ( 'cmpd_target_audience' === $explodedKey[ 0 ] ) {
                            $newProduct[ 'taxonomy' ][ 'cmpd_target_audience' ][] = $value;
                        }
                        if ( 'post_tags' === $explodedKey[ 0 ] ) {
                            $newProduct[ 'taxonomy' ][ 'tag' ][] = $value;
                        }

                        if ( 'post_meta' === $explodedKey[ 0 ] ) {
                            $meta_key                               = $explodedKey[ 1 ];
                            $newProduct[ 'post_meta' ][ $meta_key ] = $value;
                        }
                    }
                }

                if ( empty( $newProduct[ 'post_meta' ][ 'cmpd_promoted' ] ) ) {
                    $newProduct[ 'post_meta' ][ 'cmpd_promoted' ] = '2';
                }

                array_push( $newProducts, $newProduct );
            }
        }

        return $newProducts;
    }

    public static function cmpd_import_directory( $file ) {
        $old_error_level = error_reporting( 0 );

        $filesrc = $file[ 'tmp_name' ];
        $fp      = fopen( $filesrc, 'r' );

        if ( $fp !== FALSE ) {
            $jsonString                = fgets( $fp );
            fclose( $fp );
            $products                  = json_decode( $jsonString );
            array_shift( $product );
            $existing_categories       = get_terms( CMProductDirectoryShared::POST_TYPE_TAXONOMY );
            $existing_tags             = get_terms( 'post_tag' );
            $existing_pricingmodels    = get_terms( CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL );
            $existing_languagesupports = get_terms( CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT );
            $existing_targetaudiences  = get_terms( CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE );
            $numberOfElements          = 0;
            foreach ( $products as $key => $product ) {

                $newFields = new stdClass();

                foreach ( $product as $field => $value ) {
                    if ( strpos( $field, '/' ) !== FALSE ) {

                        $structure = $value;

                        $subkeysArr = explode( '/', $field );
                        if ( is_array( $subkeysArr ) ) {
                            $firstKey   = reset( $subkeysArr );
                            array_shift( $subkeysArr );
                            $subkeysArr = array_reverse( $subkeysArr );
                        }

                        foreach ( $subkeysArr as $subkey ) {
                            if ( is_numeric( $subkey ) || $firstKey == 'post_gallery' ) {
                                $tmpStructure            = array();
                                $tmpStructure[ $subkey ] = $structure;
                                $structure               = $tmpStructure;
                            } else {
                                $tmpStructure          = new stdClass();
                                $tmpStructure->$subkey = $structure;
                                $structure             = clone $tmpStructure;
                            }
                        }

                        if ( $firstKey == 'post_meta' ) {
                            $newFields->$firstKey = (object) array_merge_recursive( (array) $newFields->$firstKey, (array) $structure );
                        } else if ( $firstKey == 'post_gallery' ) {
                            if ( empty( $newFields->$firstKey ) ) {
                                $newFields->$firstKey = array();
                            }
                            $newFields->$firstKey = array_replace_recursive( $newFields->$firstKey, $structure );
                        } else {
                            $newFields->$firstKey = array_merge_recursive( (array) $newFields->$firstKey, (array) $structure );
                        }

                        unset( $product->$field );
                    }
                }

                $product = (object) array_merge_recursive( (array) $product, (array) $newFields );

                $productArr = array(
                    'post_content'   => $product->post_content, // The full text of the post.
                    'post_title'     => $product->post_title, // The title of your post.
                    'post_status'    => 'publish',
                    'post_type'      => CMProductDirectoryShared::POST_TYPE,
                    'comment_status' => 'closed',
                );

                if ( !empty( $product->post_name ) ) {
                    $productArr[ 'post_name' ] = $product->post_name; // The name (slug) for your post
                }

                if ( !empty( $product->post_excerpt ) ) {
                    $productArr[ 'post_excerpt' ] = $product->post_excerpt; // For all your post excerpt needs.
                }
                /*
                 * Insert a new Product Directory product
                 */

                $newDownloadId = wp_insert_post( $productArr );

                if ( !empty( $newDownloadId ) ) {
                    $numberOfElements++;
                }


                /*
                 * Get product logo
                 */
                if ( !empty( $product->post_gallery ) ) {
                    $gallery    = $product->post_gallery;
                    $meta_value = '';
                    foreach ( $gallery as $image ) {
                        if ( !is_object( $image ) ) {
                            $image = (object) $image;
                        }
                        $url  = $image->url[ 0 ];
                        $file = basename( $url );

                        $checker = null;
                        if ( !empty( $image->ID ) && !empty( $image->title ) ) {
                            $id      = $image->ID;
                            $title   = $image->tiltle;
                            $checker = get_post( $id );
                        }
                        if ( !empty( $checker ) && $checker->ID === $id && $title == $checker->post_title && $checker->guid === $url ) {
                            $imageArr  = array(
                                'post_title'     => $file,
                                'post_status'    => 'inherit',
                                'post_parent'    => $newDownloadId,
                                'post_type'      => 'attachment',
                                'comment_status' => 'closed',
                                'guid'           => $url,
                            );
                            $attach_id = wp_insert_post( $imageArr );
                        } else {
                            $attach_id = self::downloadImage( $url, $newDownloadId, $title );
                        }

                        $meta_value.= $attach_id . ',';
                    }
                    $meta_value = substr( $meta_value, 0, -1 );
                    if ( !empty( $meta_value ) && $meta_value !== '' ) {
                        add_post_meta( $newDownloadId, 'cmpd_product_gallery_id', $meta_value );
                    }
                }

                if ( !empty( $product->post_meta ) ) {
                    $post_metas = $product->post_meta;
                    foreach ( $post_metas as $key2 => $meta ) {
                        if ( $key2 === 'cmpd_product_gallery_id' ) {
                            continue;
                        }

                        if ( $key2 === 'cmpd_rating' ) {
                            $meta = maybe_unserialize( $meta );
                        }
                        update_post_meta( $newDownloadId, $key2, $meta );
                    }
                }
                if ( !empty( $product->post_category ) ) {
                    $downloadCategories = $product->post_category;
                    foreach ( $downloadCategories as $category ) {
                        if ( !empty( $category ) && !in_array( $category, $existing_categories ) ) {
                            wp_insert_term( $category, CMProductDirectoryShared::POST_TYPE_TAXONOMY );
                        }
                    }

                    wp_set_object_terms( $newDownloadId, $downloadCategories, CMProductDirectoryShared::POST_TYPE_TAXONOMY );
                }

                if ( !empty( $product->cmpd_pricing_model ) ) {
                    $downloadPricingmodel = $product->cmpd_pricing_model;
                    foreach ( $downloadPricingmodel as $tax ) {
                        if ( !in_array( $tax, $existing_pricingmodels ) ) {
                            wp_insert_term( $tax, CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL );
                        }
                    }
                    wp_set_object_terms( $newDownloadId, $downloadPricingmodel, CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL );
                }

                if ( !empty( $product->cmpd_language_support ) ) {
                    $downloadLanguagesupport = $product->cmpd_language_support;
                    foreach ( $downloadLanguagesupport as $tax ) {
                        if ( !in_array( $tax, $existing_languagesupports ) ) {
                            wp_insert_term( $tax, CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT );
                        }
                    }
                    wp_set_object_terms( $newDownloadId, $downloadLanguagesupport, CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT );
                }

                if ( !empty( $product->cmpd_target_audience ) ) {
                    $downloadTargetaudience = $product->cmpd_target_audience;
                    foreach ( $downloadTargetaudience as $tax ) {
                        if ( !in_array( $tax, $existing_targetaudiences ) ) {
                            wp_insert_term( $tax, CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE );
                        }
                    }
                    wp_set_object_terms( $newDownloadId, $downloadTargetaudience, CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE );
                }

                if ( !empty( $product->post_tags ) ) {
                    $downloadTags = $product->post_tags;
                    foreach ( $downloadTags as $tag ) {
                        if ( !in_array( $tag, $existing_tags ) ) {
                            wp_insert_term( $tag, 'post_tag' );
                        }
                    }
                    wp_set_object_terms( $newDownloadId, $downloadTags, 'post_tag' );
                }
            }
        }
        error_reporting( $old_error_level );
        wp_redirect( esc_url_raw( add_query_arg( array( 'cmpd_msg' => 'imported', 'cmpd_productnumber' => $numberOfElements ), $_SERVER[ 'REQUEST_URI' ] ) ), 303 );
        exit;
    }

    public static function downloadImage( $url, $parent_post, $img_title ) {
        $image_data = file_get_contents( $url );
        $upload_dir = wp_upload_dir();
        $filename   = basename( $url );
        if ( wp_mkdir_p( $upload_dir[ 'path' ] ) )
            $file       = $upload_dir[ 'path' ] . '/' . $filename;
        else
            $file       = $upload_dir[ 'basedir' ] . '/' . $filename;
        file_put_contents( $file, $image_data );
        $guid       = $upload_dir[ 'path' ] . '/' . $filename;

        // $upload_dir = wp_upload_dir();
        /* $attachment = array(
          'post_title' => $img_title,
          'post_status' => 'inherit',
          'post_parent' => $parent_post,
          'post_type' => 'attachment',
          'comment_status' => 'closed',
          'guid' => $guid,
          );  // to insert post */
        // Check image file type
        $wp_filetype = wp_check_filetype( $filename, null );
        $atache_path = $upload_dir[ 'subdir' ] . '/' . $filename;
        $attachment  = array(
            'guid'           => $upload_dir[ 'url' ] . '/' . $filename,
            'post_mime_type' => $wp_filetype[ 'type' ],
            'post_title'     => $img_title,
            'post_content'   => '',
            'post_status'    => 'inherit',
        );
        //$attach_id = wp_insert_attachment($attachment, $guid, $parent_post);
        //$attach_id = wp_insert_post($attachment);
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        // Generate the metadata for the attachment, and update the database record.
        $attach_id   = wp_insert_attachment( $attachment, $atache_path, $parent_post );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $guid );
        wp_update_attachment_metadata( $attach_id, $attach_data );
        return $attach_id;
    }

    public static function addAdminSettings( $params = array() ) {
        do_action( 'cmpd_save_settings_before' );
        if ( self::_isPost() ) {
            if ( isset( $_POST[ 'cmpd_nonce' ] ) && wp_verify_nonce( $_POST[ 'cmpd_nonce' ], 'dg@3vasdHHT4$bsdcs_SDdSS34637' ) ) {
                do_action( 'cmpd_save_options_before' );
                $params = CMPD_Settings::processPostRequest();
                do_action( 'cmpd_save_options_after' );
            }
            /*
             *  Labels
             */
            $labels = CMPD_Labels::getLabels();
            foreach ( $labels as $labelKey => $label ) {
                if ( isset( $_POST[ 'label_' . $labelKey ] ) ) {
                    CMPD_Labels::setLabel( $labelKey, stripslashes( $_POST[ 'label_' . $labelKey ] ) );
                }
            }

            if ( filter_input( INPUT_POST, 'cmpd_pluginCleanup' ) ) {
                self::_cleanup();
            }
            if ( filter_input( INPUT_POST, 'cmpd_pluginSetDefault' ) ) {
                self::_setdefault();
            }
        }

        return $params;
    }

    public static function displayAdminPage( $content ) {
        $nav = self::getAdminNav();
        include_once self::$viewsPath . 'template.phtml';
    }

    public static function getAdminNav() {
        global $self, $parent_file, $submenu_file, $plugin_page, $typenow, $submenu;
        ob_start();
        $submenus = array();

        $menuProduct = 'edit.php?post_type=' . CMProductDirectoryShared::POST_TYPE;

        if ( isset( $submenu[ $menuProduct ] ) ) {
            $thisMenu = $submenu[ $menuProduct ];

            foreach ( $thisMenu as $sub_product ) {
                $slug = $sub_product[ 2 ];

                // Handle current for post_type=post|page|foo pages, which won't match $self.
                $self_type = !empty( $typenow ) ? $self . '?post_type=' . $typenow : 'nothing';

                $isCurrent  = FALSE;
                $subpageUrl = get_admin_url( '', 'edit.php?post_type=' . CMProductDirectoryShared::POST_TYPE . '&page=' . $slug );

                if (
                (!isset( $plugin_page ) && $self == $slug ) ||
                ( isset( $plugin_page ) && $plugin_page == $slug && ( $menuProduct == $self_type || $menuProduct == $self || file_exists( $menuProduct ) === false ) )
                ) {
                    $isCurrent = TRUE;
                }

                $url        = (strpos( $slug, '.php' ) !== false || strpos( $slug, 'http://' ) !== false || strpos( $slug, 'https://' ) !== false ) ? $slug : $subpageUrl;
                $url        = ( strpos( $slug, $typenow . '_' ) === false) ? $url : $subpageUrl;
                $submenus[] = array(
                    'link'    => $url,
                    'title'   => $sub_product[ 0 ],
                    'current' => $isCurrent
                );
            }
            include self::$viewsPath . 'nav.phtml';
        }
        $nav = ob_get_contents();
        ob_end_clean();
        return $nav;
    }

    /**
     * Adds the meta box container.
     */
    public static function addMetaBox( $post_type ) {
        /*
         * Limit meta box to custom post type
         */
        $post_types = array( CMProductDirectoryShared::POST_TYPE );
        if ( in_array( $post_type, $post_types ) ) {
            add_meta_box(
            CMPD_SLUG_NAME . '-custom-fields'
            , __( 'CM Product Directory Custom Fields', CMPD_SLUG_NAME )
            , array( self::$calledClassName, 'renderMetaboxContent' )
            , $post_type
            , 'advanced'
            , 'high'
            );
        }
    }

    public static function remove_additional_taxonomy_field() {
        if ( is_admin() ) {
            $display_pricingmodel    = CMPD_Settings::getOption( CMPD_Settings::OPTION_TAXONOMY_PRICINGMODEL );
            $display_languagesupport = CMPD_Settings::getOption( CMPD_Settings::OPTION_TAXONOMY_LANUAGESUPPORT );
            $display_targetaudience  = CMPD_Settings::getOption( CMPD_Settings::OPTION_TAXONOMY_TARGETAUDIENCE );

            if ( !$display_pricingmodel ) {
                remove_meta_box( CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL . 'div', CMProductDirectoryShared::POST_TYPE, 'side' );
            }
            if ( !$display_languagesupport ) {
                remove_meta_box( CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT . 'div', CMProductDirectoryShared::POST_TYPE, 'side' );
            }
            if ( !$display_targetaudience ) {
                remove_meta_box( CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE . 'div', CMProductDirectoryShared::POST_TYPE, 'side' );
            }
        }
    }

    /* Product Gallery */

    public static function add_product_gallery_metabox() {
        add_meta_box( 'product-gallery', __( 'Product gallery', CMPD_SLUG_NAME ), 'CMProductDirectoryBackend::cmpd_output_gallery_metabox', CMProductDirectoryShared::POST_TYPE, 'side', 'low' );
    }

    public static function save_product_gallery_metabox() {
        //code...
    }

    public static function cmpd_output_gallery_metabox( $post ) {
        global $post;
        ?>
        <div class="cmpd_product_gallery_container">
            <ul class="cmpd_product_images">
        <?php
        if ( metadata_exists( 'post', $post->ID, 'cmpd_product_gallery' ) ) {
            $product_image_gallery = get_post_meta( $post->ID, 'cmpd_product_gallery', true );
        } else {
            // Backwards compat
            $attachment_ids        = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_value=0' );
            $attachment_ids        = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
            $product_image_gallery = implode( ',', $attachment_ids );
        }

        $attachments = array_filter( explode( ',', $product_image_gallery ) );

        $update_meta = false;

        if ( !empty( $attachments ) ) {
            foreach ( $attachments as $attachment_id ) {
                $attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );

                // if attachment is empty skip
                if ( empty( $attachment ) ) {
                    $update_meta = true;

                    continue;
                }

                echo '<li class="image cmpd_image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
									' . $attachment . '
									<ul class="actions">
										<li><a href="#" class="delete tips" data-tip="' . esc_attr__( 'Delete image', 'woocommerce' ) . '"></a></li>
									</ul>
								</li>';

                // rebuild ids to be saved
                $updated_gallery_ids[] = $attachment_id;
            }

            // need to update product meta to set new gallery ids
            if ( $update_meta ) {
                update_post_meta( $post->ID, 'cmpd_product_gallery', implode( ',', $updated_gallery_ids ) );
            }
        }
        ?>
            </ul>

            <input type="hidden" id="cmpd_product_image_gallery" name="cmpd_product_image_gallery" value="<?php echo esc_attr( $product_image_gallery ); ?>" />

        </div>
        <p class="cmpd_add_product_images hide-if-no-js">
            <a href="#" data-choose="<?php esc_attr_e( 'Add Images to Product Gallery', 'woocommerce' ); ?>" data-update="<?php esc_attr_e( 'Add to gallery', 'woocommerce' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'woocommerce' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'woocommerce' ); ?>"><?php _e( 'Add product gallery images', 'woocommerce' ); ?></a>
        </p>
                <?php
            }

            /**
             * Save the meta when the post is saved.
             *
             * @param int $post_id The ID of the post being saved.
             */
            public static function saveMetabox( $post_id ) {
                /*
                 * We need to verify this came from the our screen and with proper authorization,
                 * because save_post can be triggered at other times.
                 */

                // Check if our nonce is set.
                if ( !isset( $_POST[ CMPD_SLUG_NAME . '-custom-fields-nonce' ] ) ) {
                    return $post_id;
                }

                $nonce = $_POST[ CMPD_SLUG_NAME . '-custom-fields-nonce' ];

                // Verify that the nonce is valid.
                if ( !wp_verify_nonce( $nonce, CMPD_SLUG_NAME . '-custom-fields' ) ) {
                    return $post_id;
                }

                // If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
                if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                    return $post_id;
                }

                // Check the user's permissions.
                if ( !current_user_can( 'edit_post', $post_id ) ) {
                    return $post_id;
                }

                $postData      = filter_input_array( INPUT_POST );
                $options_names = array_filter( array_keys( $postData ), array( self::$calledClassName, 'getTheOptionNames' ) );


                // Meta keys to import from Business
                $business_fields = array(
                    'cmpd_company_name',
                    'cmpd_address',
                    'cmpd_cityTown',
                    'cmpd_region',
                    'cmpd_stateCounty',
                    'cmpd_country',
                    'cmpd_postalcode',
                    'cmpd_year_founded',
                    'cmpd_phone',
                    'cmpd_bemail',
                    'cmpd_web_url',
                    'cmpd_facebook_name',
                    'cmpd_twitter_name',
                    'cmpd_google',
                    'cmpd_linkedin',
                    'cmpd_rss_name',
                    'cmpd_product_gallery_id'
                );

                // @param business_selected = ID of selected business
                // @param $assign_checked = Assign business or not, bool
                $business_selected = isset( $postData[ 'cmpd_select_busienss' ] ) ? $postData[ 'cmpd_select_busienss' ] : null;
                $assign_checked    = isset( $postData[ 'cmpd_assign_data' ] ) ? $postData[ 'cmpd_assign_data' ] : null;

                /*
                 * If Business selected and assign checkbox checked
                 * save Business ID as mete field in Product
                 * clear value in cmpd_import_from meta
                 *
                 * If Business selected and not assign checkbox not checked
                 * get Business all metas, for each create meta key and save as Product meta
                 * Get Business title and save it as cmpd_company_name meta field
                 * save Business ID as cmpd_imported_from meta
                 * clear value in cmpd_assign_business meta
                 *
                 * If Business is no selected
                 * save values from inputs as meta
                 * clear values in both cmpd_imported_from adn cmpd_assign_business meta fields
                 */
                if ( $business_selected != false && $assign_checked != false ) {
                    update_post_meta( $post_id, 'cmpd_assign_business', $business_selected );
                    update_post_meta( $post_id, 'cmpd_imported_from', '' );
                } elseif ( $business_selected != false && $assign_checked == false ) {
                    $business_meta = get_post_meta( $business_selected );
                    foreach ( $business_fields as $field ) {
                        $from_business_meta = str_replace( 'cmpd', 'cmbd', $field );
                        update_post_meta( $post_id, $field, $business_meta[ $from_business_meta ][ 0 ] );
                    }

                    $business_title = get_the_title( $business_selected );
                    update_post_meta( $post_id, 'cmpd_company_name', $business_title );
                    update_post_meta( $post_id, 'cmpd_imported_from', $business_selected );
                    update_post_meta( $post_id, 'cmpd_assign_business', '' );
                } elseif ( $business_selected == false ) {
                    foreach ( $business_fields as $field ) {
                        $value = !empty( $postData[ $field ] ) ? $postData[ $field ] : '';
                        update_post_meta( $post_id, $field, $value );
                    }
                    update_post_meta( $post_id, 'cmpd_imported_from', '' );
                    update_post_meta( $post_id, 'cmpd_assign_business', '' );
                }

                /*
                 * Meta keys to save from inputs
                 */
                $product_fields = array(
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
                    'cmpd_add_field1',
                    'cmpd_add_field2',
                    'cmpd_add_field3',
                    'cmpd_add_field4',
                );

                foreach ( $product_fields as $option_name ) {
                    if ( isset( $postData[ $option_name ] ) ) {
                        update_post_meta( $post_id, $option_name, $postData[ $option_name ] );
                    }
                }

                if ( isset( $postData[ 'cmpd_product_image_gallery' ] ) ) {
                    $cmpd_attachments_ids = array_filter( explode( ',', self::cmpd_clean( $postData[ 'cmpd_product_image_gallery' ] ) ) );
                    update_post_meta( $post_id, 'cmpd_product_gallery', $postData[ 'cmpd_product_image_gallery' ] );
                }

                do_action( 'cmpd_after_save_post', $post_id );
            }

            public static function cmpd_clean( $var ) {
                return is_array( $var ) ? array_map( 'wc_clean', $var ) : sanitize_text_field( $var );
            }

            public static function getTheOptionNames( $k ) {
                return strpos( $k, 'cmpd_' ) === 0;
            }

            /**
             * Render Meta Box content.
             *
             * @param WP_Post $post The post object.
             */
            public static function renderMetaboxContent( $post ) {
                include_once self::$viewsPath . 'metabox.phtml';
            }

            public static function editScreenColumns( $columns ) {
                $baseColumns = $columns;
                $columns     = array(
                    'cb'                                                       => '<input type="checkbox" />',
                    'thumbnail'                                                => __( 'Logo' ),
                    'title'                                                    => __( 'Product name' ),
                    'status'                                                   => __( 'Status' ),
                    'taxonomy-' . CMProductDirectoryShared::POST_TYPE_TAXONOMY => $baseColumns[ 'taxonomy-' . CMProductDirectoryShared::POST_TYPE_TAXONOMY ],
                    'tags'                                                     => __( 'Tags' ),
                    'date'                                                     => __( 'Date' ),
                );

                return $columns;
            }

            public static function editScreenSortableColumns( $columns ) {
                $columns = array(
                    'title'         => 'title',
                    'status'        => 'status',
                    'categories'    => 'categories',
                    'tags'          => 'tags',
                    'purchase_link' => 'purchase_link',
                    'info_link'     => 'info_link',
                    'date'          => 'date',
                );

                return $columns;
            }

            public static function editScreenCustomFilters() {
                global $typenow;

                if ( $typenow != CMProductDirectoryShared::POST_TYPE ) {
                    return;
                }

                $filters = get_object_taxonomies( $typenow );

                foreach ( $filters as $tax_slug ) {
                    $tax_obj  = get_taxonomy( $tax_slug );
                    $selected = isset( $_GET[ $tax_slug ] ) ? $_GET[ $tax_slug ] : false;

                    wp_dropdown_categories( array(
                        'show_option_all' => __( 'Show All ' . $tax_obj->label ),
                        'taxonomy'        => $tax_slug,
                        'name'            => $tax_obj->name,
                        'orderby'         => 'name',
                        'selected'        => $selected,
                        'hierarchical'    => $tax_obj->hierarchical,
                        'show_count'      => false,
                        'hide_empty'      => true
                    ) );
                }
            }

            public static function editScreenCustomPostTypeRequest( $query ) {
                global $pagenow, $typenow;

                if ( $typenow != CMProductDirectoryShared::POST_TYPE ) {
                    return;
                }

                if ( 'edit.php' == $pagenow ) {
                    $filters = get_object_taxonomies( $typenow );
                    foreach ( $filters as $tax_slug ) {
                        $var = &$query->query_vars[ $tax_slug ];
                        if ( !empty( $var ) ) { //was isset, now !empty because $var = 0 during searching product on admin side
                            $product = get_term_by( 'id', $var, $tax_slug );
                            $var     = $product->slug;
                        }
                    }
                }
            }

            public static function editScreenColumnsContent( $column, $post_id ) {

                switch ( $column ) {
                    case 'thumbnail' :
                        $url = CMProductDirectoryProductPage::getProductGallery( $post_id );
                        if ( empty( $url ) ) {
                            return;
                        }
                        $url = $url[ 0 ][ 'thumb' ][ 0 ];

                        echo '<img width="100" height="100" src="' . esc_attr( $url ) . '">';

                        // the_post_thumbnail('cm-admin-thumb', $attr);
                        break;
                    case 'purchase_link' :
                        $link   = get_post_meta( $post_id, 'cmpd_purchase', true );
                        echo '<a href="' . esc_attr( $link ) . '" target="_blank">' . $link . '</a>';
                        break;
                    case 'info_link' :
                        $link   = get_post_meta( $post_id, 'cmpd_link', true );
                        echo '<a href="' . esc_attr( $link ) . '" target="_blank">' . $link . '</a>';
                        break;
                    case 'status' :
                        $status = get_post_status( $post_id );
                        echo $status;
                        break;
                }
            }

            protected static function _isPost() {
                return strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) == 'post';
            }

            /**
             * Function set all setings to default.
             */
            protected static function _setdefault() {
                $options = CMPD_Settings::getOptionsConfig();
                foreach ( $options as $name => $optionConfig ) {
                    update_option( $name, $optionConfig[ 'default' ] );
                }
                $options = apply_filters( 'cmpd_set_default_option', array() );
                foreach ( $options as $name => $value ) {
                    update_option( $name, $value );
                }

                $labels = CMPD_Labels::getLabels();
                foreach ( $labels as $labelKey => $optionConfig ) {
                    CMPD_Labels::setLabel( $labelKey, CMPD_Labels::getDefaultLabel( $labelKey ) );
                }
            }

            /**
             * Function cleans up the plugin, removing the product, resetting the options etc.
             *
             * @return string
             */
            protected static function _cleanup( $force = true ) {
                $directoryProduct = get_posts( array(
                    'post_type'                 => CMProductDirectoryShared::POST_TYPE,
                    'post_status'               => 'any',
                    'numberposts'               => -1,
                    'update_post_meta_cache'    => false,
                    'update_post_product_cache' => false,
                    'suppress_filters'          => false
                ) );

                /*
                 * Remove the product
                 */
                foreach ( $directoryProduct as $post ) {
                    wp_delete_post( $post->ID, $force );
                }

                // Delete all custom product for this taxonomy
                $product = get_terms( CMProductDirectoryShared::POST_TYPE_TAXONOMY );
                foreach ( $product as $product ) {
                    wp_delete_term( $product->ID, CMProductDirectoryShared::POST_TYPE_TAXONOMY );
                }

                //CMPD_Settings::deleteAllOptions();
            }

            public static function getProductGalleryImageIds( $post_id ) {
                $image_id = CMProductDirectory::meta( $post_id, 'cmpd_product_gallery_id' );
                if ( !empty( $image_id ) ) {
                    $image = wp_get_attachment_image_src( $image_id, 'cmpd_image' );
                    $image = array( 'html' => $image[ 0 ], 'id' => $image_id, 'width' => $image[ 1 ], 'height' => $image[ 2 ] );
                } else {
                    $image = null;
                }
                return $image;
            }

            public static function getBusinessesList() {
                $args = array(
                    'post_type'      => CMBusinessDirectoryShared::POST_TYPE,
                    'post_status'    => 'publish',
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                    'posts_per_page' => -1,
                );

                $list = new WP_Query( $args );
                return $list->posts;
            }

        }
