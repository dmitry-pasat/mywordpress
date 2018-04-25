<?php

class CMProductDirectoryCommunityProductFrontend {

    // const RECAPTCHA_KEY = '6LekvvMSAAAAAF4PAjJiLRqlJ7LP20aCsyymxJTQ';
    // const RECAPTCHA_PRIV_KEY = '6LekvvMSAAAAADvxYqXBHNRIDFNym67VfvKDyqkW';
    const CMPDC_MYPRODUCT_META_KEY                             = 'cmpdc_anonymous_email';
    const CMPDC_MYPRODUCT_NOTIFICATION_DEFAULT_TEXT            = 'A user %s have added a new product "%s" to the Product Directory.';
    const CMPDC_MYPRODUCT_NOTIFICATION_DEFAULT_CLAIM_TEXT      = 'Product: "%s" is claimed by "%s" : "%s". To accept click the link "%s".';
    const CMPDC_MYPRODUCT_NOTIFICATION_DEFAULT_CLAIM_SUBJECT   = ' ';
    const CMPDC_MYPRODUCT_NOTIFICATION_DEFAULT_RECOVER_SUBJECT = ' ';
    const CMPDC_MYPRODUCT_NOTIFICATION_DEFAULT_RECOVER_TEXT    = 'Owner %s asked to resend login and password for product %s. Confirm:%s';
    const COMMUNITYPRODUCT_SHORT_CODE                          = 'community_product_form';
    const meta_user                                            = "cmpd_product_user";
    const meta_password                                        = "cmpd_product_password";

    protected static $authenticatedUserData = null;

    public static function init() {
        // register scripts
        self::registerScripts();
        // register add form shortcode
        self::registerShortCode();
        // register ajax
        self::registerAjax();
        //register filter actions
        self::registerFilterActions();
        //Send Claim button
    }

    /**
     * Register enqueue script action.
     */
    public static function registerScripts() {
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueueScripts' ) );
    }

    /**
     * Register shortcode.
     */
    public static function registerShortCode() {
        add_shortcode( self::COMMUNITYPRODUCT_SHORT_CODE, array( __CLASS__, 'loadMyProductForm' ) );
    }

    public static function registerAjax() {
        add_action( 'wp_ajax_nopriv_save_post', array( __CLASS__, 'save_post' ) );
        add_action( 'wp_ajax_save_post', array( __CLASS__, 'save_post' ) );
    }

    /**
     * Register filter actions
     *
     */
    public static function registerFilterActions() {
        add_filter( 'cmpd_after_content', array( __CLASS__, 'addLinkToForm' ), 5, 2 );
        add_filter( 'cmpdc_functions_localize', array( __CLASS__, 'passJsSettings' ), 5, 2 );
    }

    public static function addLinkToForm( $content ) {
        $link   = '';
        $enable = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_ID_ON );
        if ( empty( $enable ) ) {
            return $content;
        }
        $page_id                   = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_ID );
        $data                      = CMProductDirectoryCommunityProduct::getMyProductSettings();
        $data[ 'loggedIn' ]        = false;
        $data[ 'allowAddProduct' ] = false;
        $data                      = self::checkAllowAddProduct( $data );

        global $post;

        $current_page_id   = $post->ID;
        $directory_page_id = get_option( CMProductDirectory::SHORTCODE_PAGE_OPTION );
        $displayLink       = $current_page_id == $directory_page_id ? true : false;

        if ( !empty( $page_id ) && !empty( $data[ 'allowAddProduct' ] ) && $displayLink ) {
            $link = '<div id="cmpd_suggest_button_wrapper" style="margin-top: 5px; margin-bottom: 10px;"><a href="' . esc_attr( get_permalink( $page_id ) ) . '">' . esc_html( get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BUTTON_TEXT ) ) . '</a></div>';
        }

        return $link . $content;
    }

    public static function passJsSettings( $content ) {
        $content[ 'cat_limit' ] = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CATEGORIES_LIMIT );
        return $content;
    }

    /**
     * Show myProduct form.
     *
     * @return string
     */
    public static function loadMyProductForm() {
        $data                      = CMProductDirectoryCommunityProduct::getMyProductSettings();
        $data[ 'loggedIn' ]        = false;
        $data[ 'allowAddProduct' ] = false;

        $data    = self::checkAllowAddProduct( $data );
        $content = '';

        $settings = self::processPost();
        $data     = array_merge( $data, $settings );
        $view     = $settings[ 'view' ];

        if ( $data[ 'captcha' ] ) {
            CMPDC_Recaptcha::init();
        }

        $content = CMProductDirectoryCommunityProduct::loadView( 'frontend/cmpdc_form.php', array( 'data' => $data ), true );
        return $content;
    }

    public static function processPostLogin() {
        if ( !class_exists( 'CMProductDirectoryShared' ) ) {
            return;
        }

        $post = filter_input_array( INPUT_POST );
        if ( empty( $post ) || empty( $post[ 'cmpdc_post_id' ] ) ) {
            return;
        }

        if ( empty( $post[ 'cmpdc_form_user' ] ) ) {
            return;
        }

        if ( !check_admin_referer( 'edit_product_' . $post[ 'cmpdc_post_id' ] ) ) {
            return '<div class="alert-warning">' . __( 'Cheatin huh?' ) . '</div>';
        }

        $post_id = CMProductDirectoryCommunityBusinessClaim::getPostByUser( $post[ 'cmpdc_form_user' ] );
        if ( empty( $post_id ) ) {
            return '<div class="alert-warning">' . __( 'Wrong login or password!' ) . '</div>';
        }

        if ( empty( $post[ 'cmpdc_form_password' ] ) ) {
            return '<div class="alert-warning">' . __( 'Password cannot be empty' ) . '</div>';
        }

        $sql       = $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %s", self::meta_password, $post[ 'cmpdc_form_password' ] );
        $post_id_2 = $wpdb->get_var( $sql );
        if ( $post_id_2 === $post_id ) {

            $settings                         = array();
            $settings[ 'view' ]               = 'update_post';
            $settings[ 'user' ]               = $post[ 'cmpdc_form_user' ];
            $settings[ 'cmpdc_form_user' ]    = $post[ 'cmpdc_form_user' ];
            $settings[ 'authenticated_user' ] = $post[ 'cmpdc_form_user' ];
            $settings[ 'allowUpdatePost' ]    = true;
            $settings[ 'post_id' ]            = $post_id;

            self::$authenticatedUserData = $settings; //save the data so we can redirect in form

            return '<div class="alert-success">' . __( 'Login successful! Redirecting...' ) . '</div>';
        } else {
            return '<div class="alert-warning">' . __( 'Wrong login or password!' ) . '</div>';
        }
    }

    public static function getCaptcha( $data = array() ) {
        $result = '';
        $key    = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CAPTCHA_KEY );
        $key    = empty( $key ) ? '' : $key;

        if ( empty( $data[ 'captcha' ] ) ) {
            $data[ 'captcha' ] = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CAPTCHA );
        }
        if ( empty( $data[ 'captcha_key' ] ) ) {
            $data[ 'captcha_key' ] = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CAPTCHA_KEY );
        }
        if ( empty( $data[ 'captcha_private_key' ] ) ) {
            $data[ 'captcha_private_key' ] = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CAPTCHA_PRIVATE_KEY );
        }

        // reCaptcha
        if ( isset( $data[ 'captcha' ] ) && $data[ 'captcha' ] && !empty( $key ) ) {
            $result = recaptcha_get_html( $key );
        }
        return $result;
    }

    public static function processPost() {
        if ( !class_exists( 'CMProductDirectoryShared' ) ) {
            return;
        }
        
        $post = filter_input_array( INPUT_POST );

        if ( !empty( $post ) && !empty( $post[ 'authenticated_user' ] ) ) {
            $settings = $post;
            return $settings;
        }

        $settings[ 'view' ]   = 'form';
	    //todo: what's wrong with 'success' ? :)
        $settings[ 'sukces' ] = '';
        if ( empty( $_POST[ 'cmpdc_form_user' ] ) ) {
            return $settings;
        }

        if ( !empty( $_POST[ 'cmpdc_post_id' ] ) ) {
            if ( check_admin_referer( 'edit_product_' . $_POST[ 'cmpdc_post_id' ] ) ) {
                $settings[ 'view' ]            = 'update_post';
                $settings[ 'user' ]            = $_POST[ 'cmpdc_form_user' ];
                $settings[ 'allowUpdatePost' ] = true;
                $settings[ 'post_id' ]         = $_POST[ 'cmpdc_post_id' ];
                return $settings;
            }
        }

        global $wpdb;
        $sql     = $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %s", self::meta_user, $_POST[ 'cmpdc_form_user' ] );
        $post_id = $wpdb->get_var( $sql );

        if ( empty( $post_id ) ) {
            return $settings;
        }

        if ( empty( $_POST[ 'cmpdc_form_password' ] ) ) {
            return $settings;
        }

        $sql       = $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %s", self::meta_password, $_POST[ 'cmpdc_form_password' ] );
        $post_id_2 = $wpdb->get_var( $sql );
        if ( $post_id_2 === $post_id ) {
            $settings[ 'view' ]            = 'update_post';
            $settings[ 'user' ]            = $_POST[ 'cmpdc_form_user' ];
            $settings[ 'allowUpdatePost' ] = true;
            $settings[ 'post_id' ]         = $post_id;
        }
        return $settings;
    }

    public static function checkAllowAddProduct( &$data ) {
        // Is logged in user
        if ( is_user_logged_in() ) {
            $user               = get_userdata( get_current_user_id() );
            $data[ 'loggedIn' ] = true;

            // Check who can add product when users is logged in
            $data[ 'allowAddProduct' ] = self::checkRoles( $user->roles, $data[ 'allow_roles' ] );
        } else {
            // Check if anonymous user can add product
            $data[ 'allowAddProduct' ] = self::checkRoles( array( 'anonymous', 'Anonymous' ), $data[ 'allow_roles' ] );
        }
        return $data;
    }

    public static function enqueueScripts() {
        // Register and enqueue validation script
        // wp_register_script('jquery-validation-plugin', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js', array('jquery'));
        // wp_enqueue_script('jquery-validation-plugin');
        global $post;
        if ( !empty( $post ) && !has_shortcode( $post->post_content, 'community_product_form' ) ) {
            return;
        }
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_style( 'jquery-ui', '//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );

        wp_enqueue_script( 'myproduct_js', CMPDC_PLUGIN_DIR_FRONTEND_SCRIPT_PATH . 'js/myProduct.js', array( 'jquery' ) );
        $scriptData                     = array();
        $scriptData[ 'ajaxurl' ]        = admin_url( 'admin-ajax.php' );
        $scriptData[ 'mandatory_text' ] = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_MANDATORY_TEXT );
        $scriptData[ 'textareas' ]      = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_TEXTAREAS );

        wp_localize_script( 'myproduct_js', 'cmpdc_data', $scriptData );
        wp_enqueue_script( 'cmpd-google-map', 'https://maps.googleapis.com/maps/api/js', array( 'jquery' ) );
        wp_enqueue_script( 'cmpdc-functions', CMPDC_PLUGIN_DIR_FRONTEND_SCRIPT_PATH . 'js/cmpdc-functions.js', array( 'jquery', 'cmpd-google-map' ) );

        $contact = array();
        $contact = apply_filters( 'cmpdc_functions_localize', $contact );
        wp_localize_script( 'cmpdc-functions', 'cmpdc', $contact );

        // Style for form
        wp_enqueue_style( 'myProduct-css', CMPDC_PLUGIN_DIR_FRONTEND_SCRIPT_PATH . 'css/myProduct.css' );
        // wp_enqueue_style('bootstrap-css', CMPDC_PLUGIN_DIR_FRONTEND_SCRIPT_PATH . 'css/bootstrap.min.css');
    }

    /**
     * Create or update existing post if post ID sent
     * @since 1.1.4
     * @param array post data
     */
    public static function createOrUpdatePost( $data ) {
        $post_id = '';
        if ( !empty( $data[ 'post_id' ] ) ) {
            $post_id = $data[ 'post_id' ];
            // update
            $post    = array(
                'ID'           => $post_id,
                'post_title'   => $data[ 'post_title' ],
                'post_content' => $data[ 'post_content' ],
                'post_status'  => $data[ 'post_status' ],
            );
            wp_update_post( $post );
        } else {
            // create
            $post    = array(
                'post_type'    => 'cm-product',
                'post_content' => $data[ 'post_content' ],
                'post_name'    => $data[ 'post_title' ],
                'post_title'   => $data[ 'post_title' ],
                'post_status'  => $data[ 'post_status' ],
                'post_author'  => $data[ 'post_author' ],
            );
            $post_id = wp_insert_post( $post, true );
        }
        return $post_id;
    }

    /**
     * check if mandatory fields are filled
     * @param array Form $_POST
     * @since 1.1.4
     */
    public static function checkMandatoryFields( $data, $settings ) {
        $mandatoryFields = array();
        foreach ( $settings as $key => $value ) {
            $isMandatory = preg_match( '/_mandatory/', $key );
            if ( $isMandatory && $value != 0 ) {
                $single_data_key   = str_replace( '_mandatory', '', $key );
                $mandatoryFields[] = $key;
            }
        }

        foreach ( $mandatoryFields as $field ) {
            if ( empty( $data[ $field ] ) ) {
                $settings[ 'sukces' ] = __( 'Wrong ', 'cmt_community_product' ) . __( $settings[ $key ], 'cmt_community_product' );
                return $settings;
            }
        }
    }

    /**
     * Save post meta
     * @param array Form $_POST
     * @since 1.1.4
     */
    public static function save_post_meta( $data, $post_id, $settings ) {
        if ( is_wp_error( $post_id ) ) {
            echo json_encode( array( 'status' => 'warning', 'code' => 1, 'msg' => __( 'Can\'t save product, Try again', 'cmt_community_product' ) ) );
            exit;
        }

        // User E-Mail
        if ( is_user_logged_in() ) {
            $user  = wp_get_current_user();
            $email = $user->user_email;
        } else {
            $email = $data[ 'form_bemail_contact' ];
        }

        $postStatus = apply_filters( 'cmpdc_post_added_status', (!empty( $settings[ 'moderation' ] ) ? 'pending' : 'publish' ) );

        // Taxonomy
        $post_category        = empty( $data[ 'form_categories' ] ) ? array() : $data[ 'form_categories' ];
	    $post_tags            = empty( $data[ 'form_tags' ] ) ? array() : explode(',', $data[ 'form_tags' ]);
        $post_pricingmodel    = empty( $data[ 'form_pricingmodel' ] ) ? array() : $data[ 'form_pricingmodel' ];
        $post_languagesupport = empty( $data[ 'form_languagesupport' ] ) ? array() : $data[ 'form_languagesupport' ];
        $post_targetaudience  = empty( $data[ 'form_targetaudience' ] ) ? array() : $data[ 'form_targetaudience' ];

        $tax_data = array( 'limit' => $settings[ 'form_categories_limit' ], 'post_id' => $post_id );

        if ( !empty($post_tags) ) {
            wp_set_post_tags( $post_id, $post_tags,true );
        }

        self::saveTaxonomyTerms( $post_category, $tax_data, CMProductDirectoryShared::POST_TYPE_TAXONOMY );
        self::saveTaxonomyTerms( $post_pricingmodel, $tax_data, CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL );
        self::saveTaxonomyTerms( $post_languagesupport, $tax_data, CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT );
        self::saveTaxonomyTerms( $post_targetaudience, $tax_data, CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE );

        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        /* -------------------------------------------------- */

        if ( !empty( $post_id ) ) {
            // GALLERY
            self::saveGalleryImages( $post_id, $data );

            // IMAGE
            $attachment_id = null;
            if ( !empty( $_FILES[ 'form_product_image' ][ 'name' ] ) ) {
                $attachment_id = media_handle_upload( 'form_product_image', $post_id );
                if ( is_wp_error( $attachment_id ) ) {
                    $attachment_id = CMProductDirectory::meta( $post_id, 'cmpd_product_gallery_id' );
                    if ( is_wp_error( $attachment_id ) || empty( $attachment_id ) ) {
                        echo json_encode( array( 'status' => 'warning', 'code' => 1, 'msg' => __( 'Error during upload file, Try again', 'cmt_community_product' ) ) );
                        exit;
                    }
                }
            }
            if ( $attachment_id !== null ) {
                update_post_meta( $post_id, 'cmpd_product_gallery_id', $attachment_id );
            }

            // BASIC DATA SECTION
            update_post_meta( $post_id, 'cmpd_product_pitch', $data[ 'form_pitch' ] );
            update_post_meta( $post_id, 'cmpd_promoted', 2 );

            // PRODUCT DATA SECTION
            $displayVideo = CMPD_Settings::getOption( CMPD_Settings::OPTION_ACTIVATE_VIDEO_FIELD );
            if ( $displayVideo ) {
                if ( !(filter_var( $data[ 'form_video_url' ], FILTER_VALIDATE_URL ) AND preg_match( '/^https?:/', $data[ 'form_video_url' ] )) ) {
                    $data[ 'form_video_url' ] = '';
                }
                update_post_meta( $post_id, 'cmpd_product_video', $data[ 'form_video_url' ] );
            }
            update_post_meta( $post_id, 'cmpd_product_cost', $data[ 'form_product_cost' ] );
            update_post_meta( $post_id, 'cmpd_product_page', $data[ 'form_page_link' ] );
            update_post_meta( $post_id, 'cmpd_demo_link', $data[ 'form_demo_link' ] );
            update_post_meta( $post_id, 'cmpd_purchase_link', $data[ 'form_purchase_link' ] );

            // ADDRESS SECTION
            update_post_meta( $post_id, 'cmpd_company_name', $data[ 'form_company_name' ] );
            update_post_meta( $post_id, 'cmpd_virtual_address', $data[ 'form_virtual_address' ] );
            if ( empty( $data[ 'form_virtual_address' ] ) ) {
                update_post_meta( $post_id, 'cmpd_address', $data[ 'form_address' ] );
                update_post_meta( $post_id, 'cmpd_cityTown', $data[ 'form_cityTown' ] );
                update_post_meta( $post_id, 'cmpd_stateCounty', $data[ 'form_stateCounty' ] );
                update_post_meta( $post_id, 'cmpd_postalcode', $data[ 'form_postalcode' ] );
                update_post_meta( $post_id, 'cmpd_region', $data[ 'form_region' ] );
                update_post_meta( $post_id, 'cmpd_country', $data[ 'form_country' ] );

                // Add Google Map
                $add_google_map = $data[ 'form_add_google_map' ] ? '1' : '0';
                update_post_meta( $post_id, 'cmpd_add_google_map', $add_google_map );
            }

            // SOCIAL MEDIA SECTION
	        $form_year_founded = isset($data[ 'form_year_founded' ]) ? $data[ 'form_year_founded' ] : '';
	        $form_phone = isset($data[ 'form_phone' ]) ? $data[ 'form_phone' ] : '';
	        $form_bemail = isset($data[ 'form_bemail' ]) ? $data[ 'form_bemail' ] : '';
	        $form_bemail_contact = isset($data[ 'form_bemail_contact' ]) ? $data[ 'form_bemail_contact' ] : '';

	        update_post_meta( $post_id, 'cmpd_year_founded', $form_year_founded );
	        update_post_meta( $post_id, 'cmpd_phone', $form_phone );
	        update_post_meta( $post_id, 'cmpd_bemail', $form_bemail );
	        update_post_meta( $post_id, 'cmpd_bemail_contact', $form_bemail_contact );

            $form_web_url       = self::addhttp( $data[ 'form_web_url' ] );
            $form_facebook_link = self::addhttp( $data[ 'form_facebook_name' ] );
            $form_twitter_link  = self::addhttp( $data[ 'form_twitter_name' ] );
            $form_google_link   = self::addhttp( $data[ 'form_google' ] );
            $form_linkedin_link = self::addhttp( $data[ 'form_linkedin' ] );
            $form_rss_link      = self::addhttp( $data[ 'form_rss' ] );

            update_post_meta( $post_id, 'cmpd_web_url', $form_web_url );
            update_post_meta( $post_id, 'cmpd_facebook_name', $form_facebook_link );
            update_post_meta( $post_id, 'cmpd_twitter_name', $form_twitter_link );
            update_post_meta( $post_id, 'cmpd_google', $form_google_link );
            update_post_meta( $post_id, 'cmpd_linkedin', $form_linkedin_link );
            update_post_meta( $post_id, 'cmpd_rss_name', $form_rss_link );

            // Addtional Links
            $displayAdditionalLinks = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_LINKS );
            if ( $displayAdditionalLinks ) {
                $form_add_link1 = self::addhttp( $data[ 'form_add_link1' ] );
                $form_add_link2 = self::addhttp( $data[ 'form_add_link2' ] );
                $form_add_link3 = self::addhttp( $data[ 'form_add_link3' ] );
                $form_add_link4 = self::addhttp( $data[ 'form_add_link4' ] );
                update_post_meta( $post_id, 'cmpd_add_link1', $form_add_link1 );
                update_post_meta( $post_id, 'cmpd_add_link2', $form_add_link2 );
                update_post_meta( $post_id, 'cmpd_add_link3', $form_add_link3 );
                update_post_meta( $post_id, 'cmpd_add_link4', $form_add_link4 );
            }

            // Additional Fields
            $displayAdditionalFields = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_FIELDS );
            if ( $displayAdditionalFields ) {
                update_post_meta( $post_id, 'cmpd_add_field1', $data[ 'form_add_field1' ] );
                update_post_meta( $post_id, 'cmpd_add_field2', $data[ 'form_add_field2' ] );
                update_post_meta( $post_id, 'cmpd_add_field3', $data[ 'form_add_field3' ] );
                update_post_meta( $post_id, 'cmpd_add_field4', $data[ 'form_add_field4' ] );
            }

            $business_selected = !empty( $data[ 'form_select_busienss' ] ) ? $data[ 'form_select_busienss' ] : false;
            $assign_checked    = (!empty( $data[ 'form_assign_data' ] ) && 'on' == $data[ 'form_assign_data' ]) ? $data[ 'form_assign_data' ] : false;
            self::saveDataFromBusiness( $post_id, $business_selected, $assign_checked );
        }

        // Notification notification_admiin
        $email = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_ADMIN_NOTIFICATION_ADMIN, get_option( 'admin_email' ) );
        $url   = get_page_link( $post_id );

        $settings[ 'title' ]             = empty( $data[ 'title' ] ) ? '' : $data[ 'title' ];
	    if ( empty($settings[ 'title' ]) && !empty($data[ 'form_title' ]) ) {
		    $settings[ 'title' ] = $data[ 'form_title' ];
	    }
        $settings[ 'url' ]               = empty( $url ) ? '' : $url;
        $settings[ 'notification_text' ] = CMProductDirectoryCommunityProduct::_prepareNotification( $settings, $settings[ 'notification_text' ] );

        if ( !empty( $settings[ 'notification' ] ) ) {
            $notify = new CMProductDirectoryCommunityProductNotification();
            $notify->setNotificationSubject( $settings[ 'notification_subject' ] );
            $notify->setEmail( $email );
            $notify->setContent( !empty( $settings[ 'notification_text' ] ) ? $settings[ 'notification_text' ] : self::CMPDC_MYPRODUCT_NOTIFICATION_DEFAULT_TEXT  );

            // Used by default notification text
            if ( empty( $settings[ 'notification_text' ] ) ) {
                $notify->setContentData( array( $user->user_login, $data[ 'title' ] ) );
            }
            $notify->send();
        }

        /*
         * Added to send the e-mail immidiately, when the item is added
         */
        $post = get_post( $post_id );
        CMProductDirectoryCommunityProductBackend::notification( $post, array() );

        $message = __( $settings[ 'cmpdc_settings_saved' ], 'cmt_community_product' ) . ' ';

        $statusBasedMessageArr = apply_filters( 'cmpdc_post_added_status_message_arr', array(
            'pending'   => __( $settings[ 'cmpdc_settings_moderation' ], 'cmt_community_product' ),
            'publish' => __( $settings[ 'cmpdc_settings_published' ], 'cmt_community_product' ),
        ) );

        $message .= $statusBasedMessageArr[ $postStatus ];

        $message = apply_filters( 'cmpdc_form_message', $message, $post_id, $statusBasedMessageArr, $data );

        /*
         * Do something after the product was added
         */
        do_action( 'cmpdc_post_added_success', $post_id, $postStatus, $data );

        $result = array( 'status' => 'success', 'code' => 2, 'msg' => $message );

        if ( !empty( $data[ 'post_id' ] ) ) {
            $result[ 'editing' ] = 1;
        }

        echo json_encode( $result );
        exit;
    }

    public static function addhttp( $url ) {
        if ( !empty( $url ) && (!preg_match( "~^(?:f|ht)tps?://~i", $url ) && !preg_match( "~^(?:f|ht)tp?://~i", $url ) ) ) {
            $url = "http://" . $url;
        }
        return $url;
    }

    /**
     * @since 1.1.7
     */
    public static function saveTaxonomyTerms( $taxonomy, $data, $taxonomy_name ) {
        if ( !empty( $taxonomy ) ) {
            if ( !empty( $data[ 'limit' ] ) && is_numeric( $data[ 'limit' ] ) ) {
                $post_taxonomy = array_slice( $taxonomy, 0, $data[ 'limit' ] );
            }
            if ( !empty( $post_taxonomy ) ) {
                wp_set_post_terms( $data[ 'post_id' ], $post_taxonomy, $taxonomy_name );
            }
        }
    }

    /**
     * @since 1.1.7
     */
    public static function checkCaptcha( $settings, $data ) {
        $validate_captcha = false;
        $valid_captcha    = false;

        if ( !empty( $settings[ 'captcha' ] ) ) {
            $validate_captcha = true;
            $checker          = 1;
            if ( empty( $data[ "recaptcha_response_field" ] ) ) {
                $checker = 0;
            }

            if ( $checker ) {
                $private_key = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CAPTCHA_PRIVATE_KEY );
                if ( empty( $private_key ) ) {
                    echo json_encode( array( 'status' => 'warning', 'code'   => 1,
                        'msg'    => __( 'Please contact the administrator of page.', 'cmt_community_product' ) ) );
                    exit;
                }
                $captcha = CMPDC_Recaptcha::verify( $data[ "recaptcha_response_field" ] );
            }
            if ( $checker && $captcha ) {
                $valid_captcha = true;
            }
        }

        $bool = (($validate_captcha && $valid_captcha) || !$validate_captcha) ? true : false;

        return $bool;
    }

    /**
     * Handle form data.
     *
     * Save post with postmeta to DB.
     * Send notification if notification opotion is enabled.
     *
     * @param array $data
     */
    public static function save_post() {
        if ( !empty( $_POST[ 'cmpdc' ] ) ) {
            if ( !class_exists( 'CMProductDirectoryShared' ) ) {
                return;
            }

            $data = $_POST[ 'cmpdc' ];
            $data = stripslashes( $data );
            $data = (array) json_decode( $data );

            $settings = CMProductDirectoryCommunityProduct::getMyProductSettings( $data );

            // Moderation Settings
            if ( !empty( $data[ 'post_id' ] ) ) {
                // if post ID exist, business is edited
                $postStatus = apply_filters( 'cmpdc_post_added_status', (!empty( $settings[ 'moderation' ] ) ? 'pending' : 'publish' ) );
            } else {
                // if not, post is new
                $postStatus = apply_filters( 'cmpdc_post_added_status', (!empty( $settings[ 'moderation' ] ) ? 'pending' : 'publish' ) );
            }

            $captcha = self::checkCaptcha( $settings, $data );

            $settings = self::checkMandatoryFields( $data, $settings );

            if ( $captcha ) {
                $current_user_id = get_current_user_id();
                if ( $current_user_id ) {
                    $user                            = wp_get_current_user();
                    $data[ 'form_bemail_contact' ]   = $user->user_email;
                    $data[ 'form_product_owner_id' ] = $current_user_id;
                }

                $post_data = array(
                    'post_title'   => $data[ 'form_title' ],
                    'post_content' => $data[ 'form_description' ],
                    'post_status'  => $postStatus,
                    'post_id'      => isset( $data[ 'post_id' ] ) ? $data[ 'post_id' ] : '',
                    'post_author'  => (get_current_user_id() ? get_current_user_id() : get_option( 'cmpdc_ProductDirectoryAnonymousUserId' ))
                );

                $post_data = apply_filters( 'cmpdc_post_form_post_data', $post_data, $data );
                $post_id   = self::createOrUpdatePost( $post_data );

                if ( $post_id ) {
                    do_action( 'cmpdc_after_post_create_update', $data, $post_id );
                    // save post meta
                    self::save_post_meta( $data, $post_id, $settings );
                }
            } else {
                echo json_encode( array( 'status' => 'warning', 'code' => 1, 'msg' => __( 'Wrong Captcha.', 'cmt_community_product' ) ) );
                exit;
            }
        }
    }

    public static function cmbpc_validate_section_data() {
        echo json_encode( array( 'status' => 'succcess', 'msg' => __( 'Valid', 'cmt_community_product' ) ) );
        exit;
    }

    /**
     * Check if given roles can add product.
     *
     * @param array $usersRoles
     * @param array $allowRoles
     * @return boolean
     */
    private static function checkRoles( $usersRoles, $allowRoles ) {
        $allow = false;
        if ( $usersRoles && $allowRoles ) {
            foreach ( $usersRoles as $role ) {
                if ( in_array( $role, $allowRoles ) ) {
                    $allow = true;
                }
            }
        }
        return $allow;
    }

    public static function addClaimButton( $content, $product_id = NULL ) {
        $content       = '';
        $statusClaim   = '';
        $statusLogin   = '';
        $statusRecover = '';

        $post = filter_input_array( INPUT_POST );
        if ( !empty( $post ) ) {
            $statusClaim   = self::processPostClaim( $product_id );
            $statusLogin   = self::processPostLogin( $product_id );
            $statusRecover = self::processPostRecover( $product_id );
        }

        if ( empty( $product_id ) ) {
            $post = get_post();
        } else {
            $post = get_post( $product_id );
            if ( empty( $post ) ) {
                $post = get_post();
            }
        }
        if ( !empty( $post ) ) {
            $product_id = $post->ID;
        } else {
            return $content;
        }

        $post_meta = get_post_meta( $product_id );

        $claimsEnabled       = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CLAIM_ON );
        $allowMultipleClaims = (bool) get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CLAIM_MULTI_CLAIMS );

        if ( !$allowMultipleClaims ) {
            $noPendingClaims = TRUE;
            $currentClaims   = (array) CMProductDirectory::meta( $product_id, 'cmpd_bemail_contact_tmp' );
            if ( is_array( $currentClaims ) ) {
                foreach ( $currentClaims as $key => $claim ) {
                    if ( empty( $key ) ) {
                        continue;
                    }

                    if ( !isset( $claim[ 'status' ] ) || $claim[ 'status' ] == 'pending' ) {
                        $noPendingClaims = FALSE;
                        break;
                    }
                }
            }
        }
        $showClaimForm = $allowMultipleClaims || $noPendingClaims;
        $ownersEmail   = isset( $post_meta[ "cmpd_bemail_contact" ][ 0 ] ) ? $post_meta[ "cmpd_bemail_contact" ][ 0 ] : FALSE;

        /*
         * Only if DONT allow for multiple claims and have pending claims
         */
        if ( !$allowMultipleClaims && !$noPendingClaims ) {
            $pendingClaimsMessage = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_PENDING );
            $content .= '<div class="alert-success">' . $pendingClaimsMessage . '</div>';
        }

        $content .= '<style>
                .alert-success, .alert-warning{
                    border-radius: 5px;
                    padding: 10px;
                    margin-bottom: 5px;
                }
                .alert-success{
                    border: 2px solid #00cc00;
                }
                .alert-warning{
                    border: 2px solid red;
                }
            </style>';

        if ( !empty( $claimsEnabled ) && empty( $ownersEmail ) && $showClaimForm ) {
            $data = array(
                'form_showhide_text'  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_SHOWHIDE_TEXT ),
                'form_captcha_text'   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CAPTCHA_TEXT ),
                'form_claim_text'     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_TEXT ),
                'form_claim_name'     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_NAME ),
                'form_claim_email'    => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_EMAIL ),
                'form_claim_button'   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_BUTTON ),
                'form_claim_success'  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_SUCCESS ),
                'form_claim_fill_all' => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_FILL_ALL ),
                'form_claim_warning'  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_WARNING ),
                'form_product_id'     => $product_id,
                'form_status'         => $statusClaim,
            );

            /*
             * Show captcha only if the whole mechanism is enabled and it's enabled for claims
             */
            $data[ 'form_captcha' ] = !empty( $data[ 'recaptha' ] ) && get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CLAIM_CAPTCHA );

            if ( $data[ 'form_captcha' ] ) {
                CMPDC_Recaptcha::init();
            }
            $content .= CMProductDirectoryCommunityProduct::loadView( 'frontend/cmpdc_claim.php', $data, true );
        }

        $loginEnabled = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_LOGIN_ON_PRODUCT_PAGE );

        if ( !empty( $loginEnabled ) && !empty( $ownersEmail ) ) {
            $shortcodePageId   = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_ID );
            $shortcodePageLink = get_page_link( $shortcodePageId );

            $wantsToEdit = filter_input( INPUT_GET, 'edit' );
            $isOwner     = CMProductDirectoryCommunityProduct::checkOwner( $post );
            if ( $isOwner && $wantsToEdit ) {
                $currentUser                      = wp_get_current_user();
                $settings                         = array();
                $settings[ 'view' ]               = 'update_post';
                $settings[ 'user' ]               = $currentUser->user_email;
                $settings[ 'cmpdc_form_user' ]    = $currentUser->user_email;
                $settings[ 'authenticated_user' ] = $currentUser->user_email;
                $settings[ 'allowUpdatePost' ]    = true;
                $settings[ 'post_id' ]            = $product_id;
                self::$authenticatedUserData      = $settings; //save the data so we can redirect in form
            }

            $data = array(
                'form_showhide_text' => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_SHOWHIDE_TEXT ),
                'form_login_label'   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_LOGIN_LABEL ),
                'form_user'          => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_USER ),
                'form_password'      => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PASSWORD ),
                'form_button2_text'  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BUTTON2_TEXT ),
                'form_suggest_url'   => $shortcodePageLink,
                'form_product_id'    => $product_id,
                'form_status'        => $statusLogin,
                'form_userdata'      => self::$authenticatedUserData,
                'form_isowner'       => $isOwner,
            );
            $content .= CMProductDirectoryCommunityProduct::loadView( 'frontend/cmpdc_login.php', $data, true );
        }

        $recover = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_RECOVER_ON );
        if ( !empty( $recover ) && !empty( $ownersEmail ) ) {
            $data = array(
                'form_showhide_text'   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_SHOWHIDE_TEXT ),
                'form_recover_text'    => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_TEXT ),
                'form_recover_email'   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_EMAIL ),
                'form_recover_button'  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_BUTTON ),
                'form_recover_success' => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_SUCCESS ),
                'form_product_id'      => $product_id,
                'form_status'          => $statusRecover,
            );
            $content .= CMProductDirectoryCommunityProduct::loadView( 'frontend/cmpdc_recover.php', $data, true );
        }
        return $content;
    }

    public static function processPostClaim( $post_id ) {

        $data = filter_input_array( INPUT_POST );
        if ( empty( $data[ 'cmpdc_claim' ] ) ) {
            return;
        }
        if ( !empty( $data[ 'cmpdc_form_recover_post_id' ] ) ) {
            return;
        }

        $claim = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CLAIM_ON );
        /*
         * Check captcha only if the whole mechanism is enabled and it's enabled for claims
         */
        if ( empty( $claim ) ) {
            return;
        }

        $post_id = empty( $data[ 'cmpdc_form_claim_post_id' ] ) ? '' : $data[ 'cmpdc_form_claim_post_id' ];
        $email   = empty( $data[ 'cmpdc_form_claim_email' ] ) ? '' : $data[ 'cmpdc_form_claim_email' ];
        $name    = empty( $data[ 'cmpdc_form_claim_name' ] ) ? '' : $data[ 'cmpdc_form_claim_name' ];
        $post_id = intval( $post_id );

        $checkCaptcha = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CLAIM_CAPTCHA );
        if ( $checkCaptcha ) {
            $valid_captcha = true;
            if ( empty( $data[ "recaptcha_response_field" ] ) || empty( $data[ "recaptcha_challenge_field" ] ) ) {
                $valid_captcha = false;
            }

            if ( $valid_captcha ) {
                $private_key = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CAPTCHA_PRIVATE_KEY );
                if ( empty( $private_key ) ) {
                    $settings[ 'sukces' ] = __( 'Please contact the administrator of page.', 'cmt_community_product' ) . __( $settings2[ $single_setting ], 'cmt_community_product' );
                    return $settings;
                }
                $captcha = CMBPDC_Recaptcha::verify( $data[ "recaptcha_response_field" ] );
            }
            $valid_captcha = !$captcha;
        }

        if ( !empty( $data ) && $checkCaptcha && !$valid_captcha ) {
            $form_claim_wrong_captcha = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_WRONG_CAPTCHA );
            return '<div class="alert-warning">' . __( $form_claim_wrong_captcha ) . '</div>';
        }

        if ( !empty( $data[ 'cmpdc_form_claim_name' ] ) && !empty( $email ) && !empty( $post_id ) ) {

            $post       = get_post( $post_id );
            $postStatus = $post->post_status;

            $admin_email  = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_ADMIN_NOTIFICATION_ADMIN, get_option( 'admin_email' ) );
            $notification = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_ADMIN_NOTIFICATION );

            $contact_email_tmp         = (array) CMProductDirectory::meta( $post_id, 'cmpd_bemail_contact_tmp' );
            $str                       = $email . $name . time();
            $key                       = md5( $str );
            $contact_email_tmp[ $key ] = array( 'name' => $name, 'email' => $email, 'status' => 'pending' );
            update_post_meta( $post_id, 'cmpd_bemail_contact_tmp', $contact_email_tmp );

            /*
             * Send admin notification
             */
            if ( !empty( $notification ) ) {
                /*
                 * Build AcceptURl
                 */
                $acceptUrlBase = admin_url( 'post.php' );
                $accept_url    = add_query_arg( array( 'post' => $post->ID, 'action' => 'edit', 'accept' => $key ), $acceptUrlBase );

                $subject = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CLAIM_NOTIFICATION_SUBJECT );
                $content = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CLAIM_NOTIFICATION_TEXT );
                $data    = array(
                    'email'      => $email,
                    'accept_url' => $accept_url,
                    'name'       => $name,
                    'title'      => $post->post_title,
                    'product'    => $post->post_title,
                    'url'        => get_permalink( $post->ID ),
                );

                $content = CMProductDirectoryCommunityProduct::_prepareNotification( $data, $content );
                $subject = CMProductDirectoryCommunityProduct::_prepareNotification( $data, $subject );
                $subject = empty( $subject ) ? self::CMPDC_MYPRODUCT_NOTIFICATION_DEFAULT_CLAIM_SUBJECT : $subject;

                $notify = new CMProductDirectoryCommunityProductNotification();
                $notify->setNotificationSubject( $subject );
                $notify->setEmail( $admin_email );
                $notify->setContent( !empty( $content ) ? $content : self::CMPDC_MYPRODUCT_NOTIFICATION_DEFAULT_CLAIM_TEXT  );

                // Used by default notification text
                if ( empty( $content ) ) {
                    $notify->setContentData( array( $post->title, $name, $email, $accept_url ) );
                }
                $notify->send();
            }

            /*
             * Do something after the product was claimed
             */
            do_action( 'cmpdc_post_claimed_success', $post_id, $postStatus, $data );

            $form_claim_success = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_SUCCESS );
            return '<div class="alert-success">' . __( $form_claim_success ) . '</div>';

            // if ( !empty( $notification ) ) {
            // $form_claim_warning = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_WARNING );
            // return '<div class="alert-warning">' . __( $form_claim_warning ) . '</div>';
            // }
        } else {
            $form_claim_fill_all = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_FILL_ALL );
            return '<div class="alert-warning">' . __( $form_claim_fill_all ) . '</div>';
        }
    }

    public static function processPostRecover( $product_id ) {
        $recover = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_RECOVER_ON );
        if ( empty( $recover ) ) {
            return;
        }

        $data = filter_input_array( INPUT_POST );
        if ( empty( $data[ 'cmpdc_recover' ] ) ) {
            return;
        }

        $post_id = empty( $_POST[ 'cmpdc_form_recover_post_id' ] ) ? '' : $_POST[ 'cmpdc_form_recover_post_id' ];
        $email   = empty( $_POST[ 'cmpdc_form_recover_email' ] ) ? '' : $_POST[ 'cmpdc_form_recover_email' ];
        $post_id = intval( $post_id );
        if ( !empty( $email ) && !empty( $post_id ) ) {
            $contact_email = CMProductDirectory::meta( $post_id, 'cmpd_bemail_contact' );
            $args          = array();

            $post         = get_post( $post_id );
            $notification = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_ADMIN_NOTIFICATION );

            if ( !empty( $notification ) && ($contact_email === $email) && CMProductDirectoryCommunityProductBackend::notification( $post, $args ) ) {
                $form_recover_success = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_SUCCESS );
                return '<div class="alert-success">' . __( $form_recover_success ) . '</div>';
            }
            if ( !empty( $notification ) ) {
                $form_recover_warning = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_WARNING );
                return '<div class="alert-warning">' . __( $form_recover_warning ) . '</div>';
            }
        }
        if ( !empty( $post_id ) ) {
            $form_recover_fill_all = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_FILL_ALL );
            return '<div class="alert-warning">' . __( $form_recover_fill_all ) . '</div>';
        }
    }

    public static function setDefaultTextEditor() {
        return "html";
    }

    public static function generateBusinessFormField( array $meta, $copyable ) {
        if ( !empty( $meta ) ) {
            $meta[ 'placeholder' ] = isset( $meta[ 'placeholder' ] ) ? stripslashes( $meta[ 'placeholder' ] ) : '';
            $out                   = '';
            switch ( $meta[ 'type' ] ) {
                case 'clear' :
                    $out = '<div class="clear"></div>';
                    break;
                case 'text' :
                    $out = '<div class="cmpdc_column50  type-text" id="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) . '-container' : '') . '">'
                    . '<label for="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '">'
                    . (!empty( $meta[ 'placeholder' ] ) ? esc_html( $meta[ 'placeholder' ] ) : '') . (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? esc_html( ' *' ) : '') . '</label><br />'
                    . '<input type="text" id="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '" class="cmpdc_medium-input form-part-collectible"' . (!empty( $meta[ 'placeholder' ] ) ? ' placeholder="' . esc_html( $meta[ 'placeholder' ] ) . '"' : '') . ' name="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . (($copyable == true) ? '[]' : '') . '"' . (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? esc_html( ' required="required"' ) : '') . (!empty( $meta[ 'value' ] ) ? ' value="' . esc_attr( $meta[ 'value' ] ) . '"' : '') . '/>'
                    . '</div>';
                    break;
                case 'date' :
                    if ( empty( $meta[ 'value' ] ) ) {
                        $meta[ 'value' ] = date( 'd-m-Y', time() );
                    }
                    $out              = '<div class="cmpdc_column50 type-date" id="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) . '-container' : '') . '">'
                    . '<label for="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '">'
                    . (!empty( $meta[ 'placeholder' ] ) ? esc_html( $meta[ 'placeholder' ] ) : '') . (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? esc_html( ' *' ) : '') . '</label><br />'
                    . '<input type="text" id="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . md5( mt_rand() . time() ) . '" class="cmpdc_medium-input form-part-collectible"' . (!empty( $meta[ 'placeholder' ] ) ? ' placeholder="' . esc_html( $meta[ 'placeholder' ] ) . '"' : '') . ' name="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . (($copyable == true) ? '[]' : '') . '"' . (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? esc_html( ' required="required"' ) : '') . (!empty( $meta[ 'value' ] ) ? ' value="' . esc_attr( $meta[ 'value' ] ) . '"' : '') . '/>'
                    . '</div>';
                    break;
                case 'textarea' :
                    $out              = '<div class="clear"></div>';
                    $out .= '<div class="cmpdc_column100  type-textarea" id="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) . '-container' : '') . '">';
                    $out .= '<label for="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '">'
                    . (!empty( $meta[ 'placeholder' ] ) ? esc_html( $meta[ 'placeholder' ] ) : '') . (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? esc_html( ' *' ) : '') . '</label><br />';
                    $wpEditorSettings = array(
                        'media_buttons' => false,
                        'textarea_name' => (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . (($copyable == true) ? '[]' : ''),
                        'teeny'         => true,
                        'textarea_rows' => 5,
                        'editor_class'  => 'form-part-collectible'
                    );
                    add_filter( 'wp_default_editor', array( __CLASS__, 'setDefaultTextEditor' ) );
                    ob_start();
                    wp_editor( (!empty( $meta[ 'value' ] ) ? $meta[ 'value' ] : '' ), (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '' ), $wpEditorSettings );
                    $editor           = ob_get_clean();
                    if ( !empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ) {
                        $editor = str_replace( '<textarea', '<textarea required="required" ', $editor );
                    }
                    if ( !empty( $meta[ 'placeholder' ] ) ) {
                        $editor = str_replace( '<textarea', '<textarea placeholder="' . $meta[ 'placeholder' ] . '" ', $editor );
                    }
                    $out .= $editor;
                    remove_filter( 'wp_default_editor', array( __CLASS__, 'setDefaultTextEditor' ) );
                    $out .= '</div>';
                    break;
                case 'select' :
                    $out = '<div class="cmpdc_column50  type-select" id="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) . '-container' : '') . '">'
                    . '<label for="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '">'
                    . (!empty( $meta[ 'placeholder' ] ) ? esc_html( $meta[ 'placeholder' ] ) : '') . (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? esc_html( ' *' ) : '') . '</label><br />'
                    . '<select ' . (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? ' required="required"' : '') . ' name="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . (($copyable == true) ? '[]' : '') . '" id="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '" class="cmpdc_medium-input form-part-collectible">';
                    $out .= '<option value="-1"> - Please Select - </option>';
                    foreach ( $meta[ 'options' ] as $key => $option ) {
                        $out .= '<option  value="' . esc_attr( $key ) . '"' . ($key == $meta[ 'value' ] ? 'selected="selected"' : '') . '>' . esc_html( $option ) . '</option>';
                    }
                    $out .= '</select>'
                    . '</div>';
                    break;
                case 'confirm' :
                    $out       = '<div class="confirm_container">'
                    . '<input class="button button-primary confirm-section-correct-button" type="button" value="' . (!empty( $meta[ 'placeholder' ] ) ? esc_html( $meta[ 'placeholder' ] ) : '') . '" />'
                    . '</div>';
                    break;
                case 'checkbox' :
                    $out       = '<div class="cmpdc_column50 type-checkbox" id="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) . '-container' : '') . '">';
                    $out .= '<label for="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '" class="cmpdc_checkbox_label">';
                    $out .= '<input class="form-part-collectible" type="checkbox" ' . (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? ' required="required"' : '') . ' id="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '" name="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . (($copyable == true) ? '[]' : '') . '" value="1"' . (!empty( $meta[ 'value' ] ) ? 'checked="checked"' : '') . ' />';
                    $out .= '<div class="cmpdc_fake_checkbox"><div class="cmpdc_fake_checkbox_checked">V</div></div>';
                    $mandatory = (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? esc_html( '* ' ) : '');
                    $out .= (!empty( $meta[ 'placeholder' ] ) ? '<div class="cmpdc_checkbox_description">' . $mandatory . $meta[ 'placeholder' ] . '</div>' : '');
                    $out .= '</label>';
                    $out .= '</div>';
                    break;
                case 'file' :
                    $out       = '<div class="cmpdc_column50 type-file" id="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) . '-container' : '') . '">' .
                    '<label for="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '">' .
                    (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? esc_html( '* ' ) : '') . (!empty( $meta[ 'placeholder' ] ) ? $meta[ 'placeholder' ] : '') . '</label>';
                    if ( !empty( $meta[ 'value' ] ) ) {
                        $out .= apply_filters( 'cmpdc_input_file_value', '<br />', $meta );
                        $out .= '<input disabled="disabled" ' . (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? ' required="required"' : '') . ' class="cmpdc_medium-input form-part-collectible Cmbdc_file_input ' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '"  type="file" name="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . (($copyable == true) ? '[]' : '') . '" />';
                    } else {
                        $out .= '<input ' . (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? ' required="required"' : '') . ' class="cmpdc_medium-input form-part-collectible Cmbdc_file_input ' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '"  type="file" name="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . (($copyable == true) ? '[]' : '') . '" />';
                    }
                    $out .= '</div>';
                    break;
                case 'taxonomy' :
                    $multiple = !empty( $meta[ 'multiple' ] ) ? $meta[ 'multiple' ] : 0;
                    $out      = '<div class="cmpdc_column50 type-taxonomy ' . ($multiple ? 'multiple-select' : '') . '" id="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) . '-container' : '') . '">' .
                    '<label for="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '">' .
                    (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? esc_html( '* ' ) : '') . (!empty( $meta[ 'placeholder' ] ) ? $meta[ 'placeholder' ] : '');
                    if ( $multiple ) {
                        $out .= ' - CTRL+click to select multiple';
                    }
                    $out .= '</label><br />';
//                    '<input class="Cmbdc_file_input ' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '"  type="file" name="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . (($copyable == true) ? '[]' : '') . '" />'
                    $taxonomy_slug   = $meta[ 'taxonomy' ];
                    $meta[ 'value' ] = (!empty( $meta[ 'value' ] ) ? $meta[ 'value' ] : array());
                    if ( !is_array( $meta[ 'value' ] ) ) {
                        $meta[ 'value' ] = array( $meta[ 'value' ] );
                    }
                    $taxonomy = get_taxonomy( $taxonomy_slug );
                    $terms    = get_terms( [
                        'taxonomy'   => $taxonomy_slug,
                        'hide_empty' => false,
                    ] );
                    $out .= '<select id="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '" ' . ($multiple ? 'multiple="multiple"' : '') . ' ' . (!empty( $meta[ 'mandatory' ] ) && $meta[ 'mandatory' ] == 'Y' ? ' required="required"' : '') . ' class="cmpdc_medium-input tax-select form-part-collectible ' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . '" name="' . (!empty( $meta[ 'name' ] ) ? esc_html( $meta[ 'name' ] ) : '') . (($multiple || $copyable) ? '[]' : '') . '">';
                    if ( !$multiple ) {
//                        $out .= '<option value="0">' . $taxonomy->labels->singular_name . '</option>';
                        $out .= '<option value="0"> - Please Select -</option>';
                    }
                    if ( !empty( $terms ) ) {
                        foreach ( $terms as $term ) {
                            if ( is_object( $term ) ) {
                                $out .= '<option value="' . $term->term_id . '" ' . (in_array( $term->term_id, $meta[ 'value' ] ) ? 'selected="selected"' : '') . '>' . $term->name . '</option>';
                            }
                        }
                    }
                    $out .= '</select>';
                    $out .= '</div>';
                    break;
            }
            return $out;
        } else {
            return '';
        }
    }

    /**
     * Register ajax method
     *
     */

    /**
     * Save data from business to product
     * @param business_selected = ID of selected business
     * @param $assign_checked = Assign business or not, bool
     */
    public static function saveDataFromBusiness( $post_id, $business_selected, $assign_checked ) {
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
        }
    }

    /**
     * Create/Update Post by Form
     * Check if Captcha is enabled and if valid
     * @since 1.1.4
     */
    public static function saveGalleryImages( $post_id, $data ) {
        for ( $i = 1; $i <= 4; $i++ ) {
            if ( !empty( $_FILES[ 'form_gallery_image_' . $i ][ 'name' ] ) ) {
                $image_id = media_handle_upload( 'form_gallery_image_' . $i, $post_id );
                if ( is_wp_error( $image_id ) ) {
                    $image_id = CMProductDirectory( $post_id, 'form_gallery_image_' . $i );
                    if ( is_wp_error( $image_id ) ) {
                        echo json_encode( array( 'status' => 'warning', 'code' => 1, 'msg' => __( 'Error during upload file, Try again', 'cmt_community_product' ) ) );
                        exit;
                    }
                }
                $gallery[ $i ] = $image_id;
            } else {
                if ( !empty( $data[ 'form_gallery_image_' . $i ] ) ) {
                    $gallery[ $i ] = $data[ 'form_gallery_image_' . $i ];
                }
            }
        }

        if ( !empty( $gallery ) ) {
            update_post_meta( $post_id, 'cmpd_product_gallery', implode( ',', $gallery ) );
        }
    }

}
