<?php


class CMProductDirectoryPageCount
{

    public static $calledClassName;

    protected static $instance  = NULL;
    protected static $jsPath    = NULL;

    const CMPD_META_VISIT_PAGE_COUNT = 'cmpd_visit_count';
    const CMPD_META_TRANSITION_COUNT = 'cmpd_transition_count';


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

        self::$jsPath    = CMPD_PLUGIN_URL . 'frontend/assets/js/';

        if ( CMProductDirectory::$isLicenseOK ) {
            add_action( 'plugins_loaded', array( self::$calledClassName, 'cmpd_redirect' ) );
            add_action( 'template_redirect', array( self::$calledClassName, 'cmpd_count_page_visit' ) );
            CMProductDirectoryProductPage::cmpd_register_actions();
        }
    }


    public static function cmpd_count_page_visit() {
        global $post;
        $is_single = is_single() && get_post_type() == 'cm-product';
        wp_enqueue_script( 'cmpd-visit', self::$jsPath . 'cmpd-visit.js', array( 'jquery') );
        if ( $is_single ) {
            $visitCount = get_post_meta( $post->ID, self::CMPD_META_VISIT_PAGE_COUNT, true );
            $value = empty( $visitCount ) ? 1 : (int)$visitCount +  1;
            update_post_meta($post->ID, self::CMPD_META_VISIT_PAGE_COUNT, $value);
        }
    }


    public static function cmpd_redirect() {
        if ( isset( $_GET['cmpdkey'] ) &&
            isset( $_GET['cmpdid'] ) &&
            wp_verify_nonce( $_GET['cmpdkey'], 'key' . $_GET['cmpdid'] ) ) {

            $transitionCount = get_post_meta( $_GET['cmpdid'], self::CMPD_META_TRANSITION_COUNT, true );
            $value = empty( $transitionCount ) ? 1 : (int)$transitionCount + 1;
            update_post_meta( $_GET['cmpdid'], self::CMPD_META_TRANSITION_COUNT, $value );
            $url = CMProductDirectory::meta( $_GET['cmpdid'], 'cmpd_purchase_link' );
            wp_redirect( $url, 301 );
            exit;

        }

    }

    public static function get_statistics( $option, $id = null ) {
        $is_single = is_single() && get_post_type() == 'cm-product';
        $statistics = array();
        if( $option != 1 ) {
            return '';
        }
        if ( $is_single ) {
            return do_shortcode('[cmpd_page_visit_transition]');
        } else {
            $post = get_post();

            if ( empty( $post ) ) {
                return;
            }

            $visit = get_post_meta( $id, self::CMPD_META_VISIT_PAGE_COUNT, true );
            $transition = get_post_meta( $id, self::CMPD_META_VISIT_PAGE_COUNT, true );
            $statistics['visit'] = empty( $visit ) ? 0 : $visit;
            $statistics['transition'] = empty( $transition ) ? 0 : $transition;
            return $statistics;
        }
        return false;
    }

}