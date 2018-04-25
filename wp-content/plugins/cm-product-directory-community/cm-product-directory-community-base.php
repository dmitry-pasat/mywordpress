<?php
if ( !class_exists( 'CMProductDirectoryCommunityProduct' ) ) {

    class CMProductDirectoryCommunityProduct {

        const CMEB_MENU                            = 'edit.php?post_type=cm-product';
        const COMMUNITYPRODUCT_SHORTTAG_PAGE_TITLE = 'Suggest a product';
        const COMMUNITYPRODUCT_ACTION_PUBLISH_ALL  = 'cmpdc_publish_all';
        const COMMUNITYPRODUCT_ACTION_PUBLISH      = 'cmpdc_publish_product';

        /**
         * instance
         * @var CMProductDirectoryCommunityProduct
         */
        protected static $instance = NULL;

        /**
         * Called class name.
         * @var string
         */
        private static $calledClassName;

        /**
         * Singleton
         * @return CMProductDirectoryCommunityProduct
         */
        static public function getInstance() {
            if ( empty( self::$instance ) ) {
                self::$instance = new CMProductDirectoryCommunityProduct();
            } else {
                return self::$instance;
            }
        }

        /**
         * Actions executing on plugin activation.
         */
        static public function activate() {
            self::install();
        }

        /**
         * Construct the plugin object
         */
        public function __construct() {
            if ( empty( self::$calledClassName ) ) {
                self::$calledClassName = __CLASS__;
            }

            // register init action
            add_action( 'admin_init', array( self::$calledClassName, 'checkForBase' ) );
            // register init hook
            add_action( 'init', array( self::$calledClassName, 'init' ) );

            global $cmpdc_isLicenseOk;

            if ( is_admin() ) {
                CMProductDirectoryCommunityProductBackend::init();
            } else {
                if ( $cmpdc_isLicenseOk ) {
                    // register scripts
                    CMProductDirectoryCommunityProductFrontend::registerScripts();
                    // register add form shortcode
                    CMProductDirectoryCommunityProductFrontend::registerShortCode();
                    // register ajax
                    CMProductDirectoryCommunityProductFrontend::registerAjax();
                    //register filter actions
                    CMProductDirectoryCommunityProductFrontend::registerFilterActions();
                    //Send Claim button
                    add_filter( 'cmpd_additions', array( 'CMProductDirectoryCommunityProductFrontend', 'addClaimButton' ), 10, 2 );
                }
            }

            // Move plugin to be executed in the end
            if ( !empty( $_GET[ 'page' ] ) && strstr( $_GET[ 'page' ], "cmpd_settings" ) ) {
                CMProductDirectoryCommunityProduct::putMeOnEnd();
            }

            add_filter( 'cmpd_avaliable_shortcodes', array( __CLASS__, 'cmpd_avaliable_shortcodes' ) );

            if ( class_exists( 'CMProductDirectory' ) ) {
                add_action( 'init', array( 'CMProductDirectory', 'baw_theme_setup' ) );
            }

            add_filter( 'the_editor', array( __CLASS__, 'change_editor_colsnum' ) );
        }

        public static function change_editor_colsnum( $html ) {
            return str_replace(
            array( 'cols="40"', ' style="height: 360;' ), array( 'cols="100"', ' style="height: 100%;' ), $html
            );
        }

        /**
         * Initialize some actions.
         */
        public static function init() {
            // Saving form when POST vars exists
            //      CMProductDirectoryCommunityProductBackend::cmdbc_ajax();
            //      CMProductDirectoryCommunityProductFrontend::handlePost();

            if ( is_admin() ) {
                if ( is_user_logged_in() ) {
                    if ( !empty( $_GET[ 'cmpdc_action' ] ) ) {
                        self::doAction( $_GET[ 'cmpdc_action' ] );
                    }
                }

                $anonymous          = username_exists( 'ProductDirectoryAnonymousUser' );
                $isAnonymousSecured = get_option( 'cmpd_anonymous_user_secured', FALSE );
                if ( !empty( $anonymous ) && $isAnonymousSecured < 2 ) {
                    wp_update_user( array(
                        'ID'         => $anonymous,
                        'user_login' => 'ProductDirectoryAnonymousUser',
                        'user_pass'  => md5( mt_rand() ),
                    ) );
                    update_option( 'cmpd_anonymous_user_secured', 2 );
                }

                $settings = CMProductDirectoryCommunityProduct::getMyProductSettings();
                if ( !empty( $settings[ 'panel_notification' ] ) ) {
                    CMProductDirectoryCommunityProductBackend::showPanelNotification();
                }

                // Register backend actions
                CMProductDirectoryCommunityProductBackend::registerActions();

                // Register action for new filter
                CMProductDirectoryCommunityProductBackend::registerFilterAction();

                // Check if the cookie needs to be cleared
                CMProductDirectoryCommunityProductBackend::maybeClearCookie();
            }
        }

        public static function cmpd_avaliable_shortcodes() {
            $output = '<br /><li><b>CM Product Community</b>:
            <ul>
                <li>* <em>cmpdc_dashboard</em> - display user dashboard</li>
                <li>* <em>community_product_form</em> - shortcode allowing to add the items</li>
            </ul></li>';

            return $output;
        }

        /**
         * Check if base plugin is instaled.
         */
        public static function checkForBase() {
            if ( !defined( 'CMPD_NAME' ) ) {
                add_action( 'admin_notices

			', array( self::$calledClassName, ' __showProMessage' ) );
            }
        }

        /**
         * Shows the message about Pro versions on activate
         */
        public static function __showProMessage() {
            /*
             * Only show to admins
             */
            if ( current_user_can( 'manage_options' ) ) {
                ?>
                <div id="message" class="updated fade">
                    <p>
                        <strong>&quot;<?php echo CMPDC_NAME ?>&quot;</strong> plugin requires <strong>&quot; CM Product Directory &quot;</strong> plugin to be activated! <br/>
                        <i>For more information about extending &quot; CM Product Directory &quot; please visit <a href="http://product-directory.cminds.com/" target="_blank"> this page.</a></i>
                    </p>
                </div>
                <?php
                delete_option( 'cmpd_afterActivation' );
            }
        }

        /**
         * Move plugin to the end of plugins execution list.
         */
        public static function putMeOnEnd() {

            $plugin_list        = get_option( 'active_plugins' );
            $me                 = plugin_basename( constant( 'CMPDC_PLUGIN_FILE' ) );
            $my_plugin_position = array_search( $me, $plugin_list );

            if ( $my_plugin_position ) {
                array_splice( $plugin_list, $my_plugin_position, 1 );
                array_push( $plugin_list, $me );
                update_option( 'active_plugins', $plugin_list );
            }
        }

        /**
         * Load html for given view
         *
         * @param unknown $view
         * @param string $html
         * @return string
         */
        public static function loadView( $view, $data = null, $html = false ) {
            $content = '';
            ob_start();
            if ( !empty( $data ) )
                extract( $data );
            include_once CMPDC_PLUGIN_DIR_VIEWS_PATH . $view;
            $content .= ob_get_contents();
            ob_end_clean();

            if ( $html ) {
                return $content;
            } else {
                echo $content;
            }
        }

        /**
         * Install needed elments of the plugin.
         */
        private static function install() {
            // Add anonymous user to bind not logged users product
            $anonymous = username_exists( 'ProductDirectoryAnonymousUser' );
            if ( empty( $anonymous ) ) {
                $id = wp_insert_user( array(
                    'user_login'    => 'ProductDirectoryAnonymousUser',
                    'user_pass'     => md5( mt_rand() ),
                    'user_nickname' => 'Product Directory Anonymous Users',
                    'role'          => 'editor'
                ) );

                if ( is_int( $id ) ) {
                    add_option( 'cmpdc_ProductDirectoryAnonymousUserId', $id );
                }
            }

            $page = get_page_by_title( self::COMMUNITYPRODUCT_SHORTTAG_PAGE_TITLE );

            if ( empty( $page ) ) {
                // Add page with short tag
                $post    = array(
                    'post_type'    => 'page',
                    'post_content' => '[' . CMProductDirectoryCommunityProductFrontend::COMMUNITYPRODUCT_SHORT_CODE . ']', // The full text of the post.
                    'post_name'    => self::COMMUNITYPRODUCT_SHORTTAG_PAGE_TITLE, // The name (slug) for your post
                    'post_title'   => self::COMMUNITYPRODUCT_SHORTTAG_PAGE_TITLE, // The title of your post.
                    'post_status'  => '  publish',
                    'post_author'  => get_current_user_id()
                );
                $post_id = wp_insert_post( $post );

                // Update form page_id
                update_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_ID, $post_id );
            }

            // Forms labels
            CMProductDirectoryCommunityProductBackend::setDefaultLabelsValues();
        }

        public static function getDefaultValue( $option ) {
            $value = false;

            switch ( $option ) {
                case CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_NOTIFICATION_TEXT:
                    $value = 'New product: [product] has been added to the product.';
                    break;
                case CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CLAIM_NOTIFICATION_TEXT:
                    $value = 'Product: [product] is claimed by [name] : [email]. To accept click the link [accept_url].';
                    break;
                case CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_USER_NOTIFICATION_TEXT:
                    $value = 'The status of the product: [product]  has been changed from [old_status] to [new_status].';
                    break;
                case CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_ACCESS_NOTIFICATION_TEXT:
                    $value = 'The status of the product: [product] is[status].If you want you can update your product on site: [url]. Your login: [login], password: [password]';
                    break;
                case CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_ACCESS_NOTIFICATION_SUBJECT:
                    $value = 'Your [product] is updated.';
                    break;
                default:
                    $value = false;
                    break;
            }

            return $value;
        }

        public static function getMyProductSettings( $data = array() ) {
            if ( !class_exists( 'CMPD_Settings' ) ) {
                return;
            }
            $notification_text = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_NOTIFICATION_TEXT, self::getDefaultValue( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_NOTIFICATION_TEXT ) );

            $user_notification_text    = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_USER_NOTIFICATION_TEXT, self::getDefaultValue( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_USER_NOTIFICATION_TEXT ) );
            $user_notification_subject = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_USER_NOTIFICATION_SUBJECT );

            $claim_rejected_notification_text    = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CLAIM_REJECTED_NOTIFICATION_TEXT, self::getDefaultValue( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CLAIM_REJECTED_NOTIFICATION_TEXT ) );
            $claim_rejected_notification_subject = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CLAIM_REJECTED_NOTIFICATION_SUBJECT );

            $access_notification_text  = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_ACCESS_NOTIFICATION_TEXT, self::getDefaultValue( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_ACCESS_NOTIFICATION_TEXT ) );
            $access_notification_title = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_ACCESS_NOTIFICATION_SUBJECT );

            /* ML */
            $text_for_unauthorized_roles = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_TEXT_UNAUTHORIZED );

            return array(
                'form_user'                           => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_USER ),
                'form_password'                       => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PASSWORD ),
                'form_mandatory_text'                 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_MANDATORY_TEXT ),
                'form_showhide_text'                  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_SHOWHIDE_TEXT ),
                'form_claim_text'                     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_TEXT ),
                'form_claim_name'                     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_NAME ),
                'form_claim_email'                    => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_EMAIL ),
                'form_claim_button'                   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_BUTTON ),
                'form_claim_success'                  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_SUCCESS ),
                'form_claim_fill_all'                 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_FILL_ALL ),
                'form_claim_warning'                  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_WARNING ),
                'form_claim_wrong_captcha'            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_WRONG_CAPTCHA ),
                'form_claim_pending'                  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_CLAIM_PENDING ),
                'form_recover_text'                   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_TEXT ),
                'form_recover_email'                  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_EMAIL ),
                'form_recover_button'                 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_BUTTON ),
                'form_recover_success'                => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_SUCCESS ),
                'form_recover_fill_all'               => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_FILL_ALL ),
                'form_recover_warning'                => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_RECOVER_WARNING ),
                'captcha'                             => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CAPTCHA ),
                'captcha_key'                         => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CAPTCHA_KEY ),
                'captcha_private_key'                 => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CAPTCHA_PRIVATE_KEY ),
                'moderation'                          => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_MODERATION ),
                'allow_roles'                         => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_ALLOW_ROLES ),
                'text_for_unauthorized'               => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_TEXT_UNAUTHORIZED ),
                'notification'                        => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_ADMIN_NOTIFICATION ),
                'notification_admin'                  => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_ADMIN_NOTIFICATION_ADMIN ),
                /* ML */
                'text_for_unauthorized_roles'         => self::_prepareNotification( $data, $text_for_unauthorized_roles ),
                'notification_text'                   => self::_prepareNotification( $data, $notification_text ),
                'notification_subject'                => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_NOTIFICATION_SUBJECT ),
                'claim_notification_text'             => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CLAIM_NOTIFICATION_TEXT, self::getDefaultValue( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CLAIM_NOTIFICATION_TEXT ) ),
                'claim_notification_subject'          => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CLAIM_NOTIFICATION_SUBJECT ),
                'user_notification'                   => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_USER_NOTIFICATION ),
                'user_notification_text'              => self::_prepareNotification( $data, $user_notification_text ),
                'user_notification_subject'           => self::_prepareNotification( $data, $user_notification_subject ),
                'claim_rejected_notification'         => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CLAIM_REJECTED_NOTIFICATION ),
                'claim_rejected_notification_text'    => self::_prepareNotification( $data, $claim_rejected_notification_text ),
                'claim_rejected_notification_subject' => self::_prepareNotification( $data, $claim_rejected_notification_subject ),
                'access_notification_text'            => self::_prepareNotification( $data, $access_notification_text ),
                'access_notification_title'           => self::_prepareNotification( $data, $access_notification_title ),
                'panel_notification'                  => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_PANEL_NOTIFICATION ),
                'form_product_pitch'                  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRODUCT_PITCH ),
                'form_product_gallery_id'             => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRODUCT_GALLERY_ID ),
                'form_year_founded'                   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_YEAR_FOUNDED ),
                'form_virtual_address'                => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_VIRTUAL_ADDRESS ),
                'form_address'                        => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADDRESS ),
                'form_cityTown'                       => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CITYTOWN ),
                'form_stateCounty'                    => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_STATECOUNTY ),
                'form_postalcode'                     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_POSTALCODE ),
                'form_region'                         => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_REGION ),
                'form_country'                        => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_COUNTRY ),
                'form_categories'                     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CATEGORIES ),
                'form_tags'                           => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_TAGS ),
                'form_add_google_map'                 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_GOOGLE_MAP ),
                'form_web_url'                        => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_WEB_URL ),
                'form_bemail'                         => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BEMAIL ),
                'form_bemail_contact'                 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BEMAIL_CONTACT ),
                'form_facebook_name'                  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_FACEBOOK_NAME ),
                'form_twitter_name'                   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_TWITTER_NAME ),
                'form_google'                         => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_GOOGLE ),
                'form_linkedin'                       => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_LINKEDIN ),
                'form_rss'                            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_RSS ),
                'form_phone'                          => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PHONE ),
                'form_title'                          => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_TITLE ),
                'form_description'                    => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_DESCRIPTION ),
                'form_product_pitch_mandatory'        => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRODUCT_PITCH_MANDATORY ),
                'form_address_mandatory'              => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADDRESS_MANDATORY ),
                'form_cityTown_mandatory'             => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CITYTOWN_MANDATORY ),
                'form_stateCounty_mandatory'          => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_STATECOUNTY_MANDATORY ),
                'form_postalcode_mandatory'           => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_POSTALCODE_MANDATORY ),
                'form_region_mandatory'               => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_REGION_MANDATORY ),
                'form_web_url_mandatory'              => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_WEB_URL_MANDATORY ),
                'form_bemail_mandatory'               => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BEMAIL_MANDATORY ),
                'form_bemail_contact_mandatory'       => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BEMAIL_CONTACT_MANDATORY ),
                'form_facebook_name_mandatory'        => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_FACEBOOK_NAME_MANDATORY ),
                'form_twitter_name_mandatory'         => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_TWITTER_NAME_MANDATORY ),
                'form_google_mandatory'               => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_GOOGLE_MANDATORY ),
                'form_linkedin_mandatory'             => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_LINKEDIN_MANDATORY ),
                'form_rss_mandatory'                  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_RSS_MANDATORY ),
                'form_phone_mandatory'                => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PHONE_MANDATORY ),
                'form_title_mandatory'                => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_TITLE_MANDATORY ),
                'form_description_mandatory'          => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_DESCRIPTION_MANDATORY ),
                'form_product_pitch_placeholder'      => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRODUCT_PITCH_PLACECHOLDER ),
                'form_product_gallery_id_placeholder' => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRODUCT_GALLERY_ID_PLACECHOLDER ),
                'form_year_founded_placeholder'       => CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_DEFAULT_YEAR ),
                'form_virtual_address_placeholder'    => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_VIRTUAL_ADDRESS_PLACECHOLDER ),
                'form_address_placeholder'            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADDRESS_PLACECHOLDER ),
                'form_cityTown_placeholder'           => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CITYTOWN_PLACECHOLDER ),
                'form_stateCounty_placeholder'        => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_STATECOUNTY_PLACECHOLDER ),
                'form_postalcode_placeholder'         => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_POSTALCODE_PLACECHOLDER ),
                'form_region_placeholder'             => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_REGION_PLACECHOLDER ),
                'form_country_placeholder'            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_COUNTRY_PLACECHOLDER ),
                'form_add_google_map_placeholder'     => (defined( 'CMPD_Settings::OPTION_PRODUCT_DEFAULT_MAP' )) ? CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_DEFAULT_MAP ) : FALSE,
                'form_web_url_placeholder'            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_WEB_URL_PLACECHOLDER ),
                'form_bemail_placeholder'             => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BEMAIL_PLACECHOLDER ),
                'form_bemail_contact_placeholder'     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BEMAIL_CONTACT_PLACECHOLDER ),
                'form_facebook_name_placeholder'      => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_FACEBOOK_NAME_PLACECHOLDER ),
                'form_twitter_name_placeholder'       => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_TWITTER_NAME_PLACECHOLDER ),
                'form_google_placeholder'             => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_GOOGLE_PLACECHOLDER ),
                'form_linkedin_placeholder'           => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_LINKEDIN_PLACECHOLDER ),
                'form_rss_placeholder'                => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_RSS_PLACECHOLDER ),
                'form_phone_placeholder'              => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PHONE_PLACECHOLDER ),
                'form_title_placeholder'              => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_TITLE_PLACECHOLDER ),
                'form_description_placeholder'        => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_DESCRIPTION_PLACECHOLDER ),
                'form_captcha_text'                   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CAPTCHA_TEXT ),
                'form_button_text'                    => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BUTTON_TEXT ),
                'form_button_text_update'             => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BUTTON_TEXT_UPDATE ),
                'form_login_label'                    => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_LOGIN_LABEL ),
                'form_back_label'                     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BACK_LABEL ),
                'form_page_id'                        => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_ID ),
                'form_page_id_on'                     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_ID_ON ),
                'form_claim_on'                       => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CLAIM_ON ),
                'login_on_product_page'               => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_LOGIN_ON_PRODUCT_PAGE ),
                'form_claim_captcha'                  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CLAIM_CAPTCHA ),
                'form_claim_multi_claims'             => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CLAIM_MULTI_CLAIMS ),
                'form_recover_on'                     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_RECOVER_ON ),
                'form_categories_limit'               => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CATEGORIES_LIMIT ),
                'form_button2_text'                   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BUTTON2_TEXT ),
                'cmpdc_settings_saved'                => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_SETTINGS_SAVED ),
                'cmpdc_settings_moderation'           => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_SETTINGS_MODERATION ),
                'cmpdc_settings_published'            => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_SETTINGS_PUBLISHED ),
                'form_pricingmodel'                   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRICINGMODEL ),
                'form_pricingmodel_placeholder'       => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRICINGMODEL_PLACEHOLDER ),
                'form_languagesupport'                => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_LANGUAGESUPPORT ),
                'form_languagesupport_placeholder'    => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_LANGUAGESUPPORT_PLACEHOLDER ),
                'form_targetaudience'                 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_TARGETAUDIENCE ),
                'form_targetaudience_placeholder'     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_TARGETAUDIENCE_PLACEHOLDER ),
                'main_form_video_url'                 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_VIDEO_URL ),
                'main_form_video_url_mandatory'       => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_VIDEO_URL_MANDATORY ),
                'main_form_video_url_placeholder'     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_VIDEO_URL_PLACEHOLDER ),
                'main_form_product_cost'              => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRODUCT_COST ),
                'main_form_product_cost_mandatory'    => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRODUCT_COST_MANDATORY ),
                'main_form_product_cost_placeholder'  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRODUCT_COST_PLACEHOLDER ),
                'main_form_purchase_link'             => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PURCHASE_LINK ),
                'main_form_purchase_link_mandatory'   => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PURCHASE_LINK_MANDATORY ),
                'main_form_purchase_link_placeholder' => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PURCHASE_LINK_PLACEHOLDER ),
                'main_form_page_link'                 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_LINK ),
                'main_form_page_link_mandatory'       => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_LINK_MANDATORY ),
                'main_form_page_link_placeholder'     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_LINK_PLACEHOLDER ),
                'main_form_demo_link'                 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_DEMO_LINK ),
                'main_form_demo_link_mandatory'       => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_DEMO_LINK_MANDATORY ),
                'main_form_demo_link_placeholder'     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_DEMO_LINK_PLACEHOLDER ),
                'main_form_company_name'              => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_COMPANY_NAME ),
                'main_form_company_name_mandatory'    => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_COMPANY_NAME_MANDATORY ),
                'main_form_company_name_placeholder'  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_COMPANY_NAME_PLACEHOLDER ),
                'form_add_product_image'              => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE ),
                'form_add_product_image_text'         => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_TEXT ),
                'form_add_product_image_mandatory'    => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_MANDATORY ),
                'form_add_product_image_placeholder'  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_PLACECHOLDER ),
                'textareas'                           => get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_TEXTAREAS ),
                // Gallery Images
                'form_add_gallery_image_1'            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_GALLERY_IMAGE_1 ),
                'form_add_gallery_image_2'            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_GALLERY_IMAGE_2 ),
                'form_add_gallery_image_3'            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_GALLERY_IMAGE_3 ),
                'form_add_gallery_image_4'            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_GALLERY_IMAGE_4 ),
                // Additional Links
                'form_add_link1_placeholder'          => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK1_PLACEHOLDER ),
                'form_add_link2_placeholder'          => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK2_PLACEHOLDER ),
                'form_add_link3_placeholder'          => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK3_PLACEHOLDER ),
                'form_add_link4_placeholder'          => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK4_PLACEHOLDER ),
                'form_add_link1'                      => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK1 ),
                'form_add_link2'                      => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK2 ),
                'form_add_link3'                      => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK3 ),
                'form_add_link4'                      => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK4 ),
                'form_add_link1_mandatory'            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK1_MANDATORY ),
                'form_add_link2_mandatory'            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK2_MANDATORY ),
                'form_add_link3_mandatory'            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK3_MANDATORY ),
                'form_add_link4_mandatory'            => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK4_MANDATORY ),
                // Additional Fields
                'form_add_field1'                     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD1 ),
                'form_add_field2'                     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD2 ),
                'form_add_field3'                     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD3 ),
                'form_add_field4'                     => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD4 ),
                'form_add_field1_mandatory'           => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD1_MANDATORY ),
                'form_add_field2_mandatory'           => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD2_MANDATORY ),
                'form_add_field3_mandatory'           => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD3_MANDATORY ),
                'form_add_field4_mandatory'           => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD4_MANDATORY ),
                'form_add_field1_placeholder'         => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD1_PLACEHOLDER ),
                'form_add_field2_placeholder'         => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD2_PLACEHOLDER ),
                'form_add_field3_placeholder'         => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD3_PLACEHOLDER ),
                'form_add_field4_placeholder'         => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD4_PLACEHOLDER ),
	            // Form parts settings
                'form_show_social_media_section'      => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_SHOW_SOCIAL_MEDIA_SECTION ),
                'form_show_categories_as_checkboxes'  => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_SHOW_CATEGORIES_AS_CHECKBOXES ),
                'form_show_tags'                      => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_SHOW_TAGS ),
            );
        }

        public static function checkOwner( $product ) {
            $current_user = wp_get_current_user();
            if ( $current_user->ID > 0 ) {
                $is_owner1          = $product->post_author == $current_user->ID;
                $productOwnerEmail = get_post_meta( $product->ID, 'cmpd_bemail_contact', true );
                $is_owner2          = $productOwnerEmail == $current_user->user_email;
                $productOwnerId    = get_post_meta( $product->ID, 'cmpd_product_owner_id', true );
                $is_owner3          = $productOwnerId == $current_user->ID;

                $is_owner = $is_owner1 || $is_owner2 || $is_owner3;
            } else {
                $is_owner = false;
            }
            return $is_owner;
        }

        /**
         * Prepare user notification text send by email.
         *
         * @param array $data
         * @param string $user_notification_text
         * @return mixed
         */
        public static function _prepareNotification( $data, $user_notification_text ) {

            if ( !empty( $data[ 'title' ] ) && strstr( $user_notification_text, CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_TERM ) ) {
                $user_notification_text = str_replace( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_TERM, $data[ 'title' ], $user_notification_text );
            }

            if ( !empty( $data[ 'old_status' ] ) && strstr( $user_notification_text, CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_OLD_STATUS ) ) {
                $user_notification_text = str_replace( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_OLD_STATUS, $data[ 'old_status' ], $user_notification_text );
            }
            if ( !empty( $data[ 'new_status' ] ) && strstr( $user_notification_text, CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_NEW_STATUS ) ) {
                $user_notification_text = str_replace( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_NEW_STATUS, $data[ 'new_status' ], $user_notification_text );
            }
            if ( !empty( $data[ 'status' ] ) && strstr( $user_notification_text, CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_STATUS ) ) {
                $user_notification_text = str_replace( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_STATUS, $data[ 'status' ], $user_notification_text );
            }
            if ( !empty( $data[ 'login' ] ) && strstr( $user_notification_text, CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_LOGIN ) ) {
                $user_notification_text = str_replace( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_LOGIN, $data[ 'login' ], $user_notification_text );
            }
            if ( !empty( $data[ 'password' ] ) && strstr( $user_notification_text, CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_PASSWORD ) ) {
                $user_notification_text = str_replace( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_PASSWORD, $data[ 'password' ], $user_notification_text );
            }
            if ( !empty( $data[ 'url' ] ) && strstr( $user_notification_text, CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_URL ) ) {
                $user_notification_text = str_replace( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_URL, $data[ 'url' ], $user_notification_text );
            }
            if ( !empty( $data[ 'accept_url' ] ) && strstr( $user_notification_text, CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_ACCEPT_URL ) ) {
                $user_notification_text = str_replace( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_ACCEPT_URL, $data[ 'accept_url' ], $user_notification_text );
            }
            if ( !empty( $data[ 'email' ] ) && strstr( $user_notification_text, CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_EMAIL ) ) {
                $user_notification_text = str_replace( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_EMAIL, $data[ 'email' ], $user_notification_text );
            }
            if ( !empty( $data[ 'name' ] ) && strstr( $user_notification_text, CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_NAME ) ) {
                $user_notification_text = str_replace( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_NAME, $data[ 'name' ], $user_notification_text );
            }
            if ( !empty( $data[ 'allow_roles' ] ) && strstr( $user_notification_text, '[list of roles]' ) ) {
                $roles            = CMProductDirectoryCommunityProductBackend::getRoles();
                $rolesReplacement = '';
                foreach ( $data[ 'allow_roles' ] as $key => $val ) {
                    if ( $key !== 0 ) {
                        $rolesReplacement.= ',';
                    }
                    $rolesReplacement.= ' ' . $roles[ $val ];
                }
                $user_notification_text = str_replace( '[list of roles]', $rolesReplacement, $user_notification_text );
            }
            return $user_notification_text;
        }

        public static function doAction( $action ) {
            if ( !empty( $action ) ) {
                switch ( $action ) {
                    case self::COMMUNITYPRODUCT_ACTION_PUBLISH_ALL: CMProductDirectoryCommunityProductBackend::publishAll();
                        break;
                    case self::COMMUNITYPRODUCT_ACTION_PUBLISH : CMProductDirectoryCommunityProductBackend::publishTerm( $_GET[ 'post_id' ] );
                        break;
                }

                wp_redirect( 'edit.php?post_type = product' );
                exit;
            }
        }

    }

}