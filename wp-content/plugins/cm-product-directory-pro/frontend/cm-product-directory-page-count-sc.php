<?php

class CMPDPageCountShortcodes
{

    public static $calledClassName;
    protected static $instance = NULL;

    const CMPD_META_VISIT_PAGE_COUNT = 'cmpd_visit_count';
    const CMPD_META_TRANSITION_COUNT = 'cmpd_transition_count';

    public static function instance() {
        $class = __CLASS__;
        if (!isset(self::$instance) && !(self::$instance instanceof $class)) {
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function __construct() {
        if (empty(self::$calledClassName)) {
            self::$calledClassName = __CLASS__;

            if (CMProductDirectory::$isLicenseOK) {
                self::cmpd_register_business_page_count_shortcodes();
            }
        }

    }

    public static function cmpd_register_business_page_count_shortcodes() {
        $shortcodes = array(
            'cmpd_page_visit'		        => array( 'name' => 'Visit', 'callback' => array( self::$calledClassName, 'outputVisit' ) ),
            'cmpd_page_transition'	        => array( 'name' => 'Transition', 'callback' => array( self::$calledClassName, 'outputTransition' ) ),
            'cmpd_page_visit_transition'    => array( 'name' => 'Visit and Transition', 'callback' => array( self::$calledClassName, 'outputVisitTransition' ) ),
        );

        foreach ( $shortcodes as $k => $v ) {
            add_shortcode( $k, $v[ 'callback' ] );
        }
    }

    public static function outputVisit() {
        $output = '';
        $post   = get_post();

        if ( empty( $post ) ) {
            return;
        }
        $visitCount = get_post_meta( $post->ID, self::CMPD_META_VISIT_PAGE_COUNT, true );
        $visitCount = empty( $visitCount ) ? 0 : $visitCount;
        $output .= '<li>
                        <span class="dashicons dashicons-chart-area cmbd_dashicons"></span>
                        <span>Visits: ' . $visitCount . '</span>
                   </li>';

        return apply_filters( 'cmpd_output_visit', $output );
    }

    public static function outputTransition() {
        $output = '';
        $post   = get_post();

        if ( empty( $post ) ) {
            return;
        }
        $transitionCount = get_post_meta( $post->ID, self::CMPD_META_TRANSITION_COUNT, true );
        $transitionCount = empty( $transitionCount ) ? 0 : $transitionCount;
        $output .= '<li>
                        <span class="dashicons dashicons-chart-area cmbd_dashicons"></span>
                        <span>Transitions: ' . $transitionCount . '</span>
                   </li>';

        return apply_filters( 'cmpd_output_transition', $output );
    }

    public static function outputVisitTransition() {
        $output = '';
        $post   = get_post();

        if ( empty( $post ) ) {
            return;
        }
        $visitCount      = get_post_meta( $post->ID, self::CMPD_META_VISIT_PAGE_COUNT, true );
        $transitionCount = get_post_meta( $post->ID, self::CMPD_META_TRANSITION_COUNT, true);
        $visitCount      = empty( $visitCount ) ? 0 : $visitCount;
        $transitionCount = empty( $transitionCount ) ? 0 : $transitionCount;
        $output .= '<li>
                        <span class="dashicons dashicons-chart-area cmbd_dashicons"></span>
                        <span>Visits: ' . $visitCount . '</span>
                   </li>
                   <li>
                        <span class="dashicons dashicons-chart-area cmbd_dashicons"></span>
                        <span>Transitions: ' . $transitionCount . '</span>
                   </li>';

        return apply_filters( 'cmpd_output_visit_transition', $output );
    }

}