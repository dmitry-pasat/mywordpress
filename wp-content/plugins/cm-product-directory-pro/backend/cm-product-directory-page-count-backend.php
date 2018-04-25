<?php

class CMProductPageCountBackend
{

    public static $calledClassName;
    protected static $instance  = NULL;

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

        add_filter( 'manage_edit-' . CMProductDirectoryShared::POST_TYPE . '_columns', array( self::$calledClassName, 'editProductCountColumns' ) );
        add_filter( 'manage_edit-' . CMProductDirectoryShared::POST_TYPE . '_sortable_columns', array( self::$calledClassName, 'editProductCountSortableColumns' ) );
        add_action( 'manage_' . CMProductDirectoryShared::POST_TYPE . '_posts_custom_column', array( self::$calledClassName, 'editProductCountColumnsContent' ), 10, 2 );
        add_action( 'plugins_loaded' , array( self::$calledClassName, 'getProductsCsv' ));

    }


    public static function editProductCountColumns( $columns ) {
        return array_merge($columns, array(
                'visit'         => __( 'Visit' ),
                'transition'    => __( 'Click' ),
            )
        );
    }

    public static function editProductCountSortableColumns( $columns ) {
        return array_merge($columns, array(
                'visit'         => 'visit',
                'transition'    => 'transition',
            )
        );

    }


    public static function editProductCountColumnsContent( $column, $post_id ) {
        switch ( $column ) {
            case 'visit':
                echo get_post_meta( $post_id , self::CMPD_META_VISIT_PAGE_COUNT , true );
                break;
            case 'transition':
                echo get_post_meta( $post_id , self::CMPD_META_TRANSITION_COUNT , true );
                break;
        }
    }

    public static function getProductsCsv() {
        if ( isset( $_GET['page'] ) &&
            $_GET['page'] == 'cm-product-directory-settings' &&
            isset( $_GET['cmpd_statistic_csv'] ) &&
            $_GET['cmpd_statistic_csv'] == 'get') {

            $args = array(
                'post_type' => CMProductDirectoryShared::POST_TYPE,
                'fields'    => 'ids'
            );
            $query = new WP_Query( $args );
            $productsIds = $query->get_posts();
            $products = array();
            foreach ($productsIds as $id) {
                $products[$id]['title'] = esc_html( get_the_title( $id ) );
                $products[$id]['visit'] = get_post_meta( $id, self::CMPD_META_VISIT_PAGE_COUNT , true);
                $products[$id]['clicks'] = get_post_meta( $id , self::CMPD_META_TRANSITION_COUNT , true );
            }

            $f = fopen('php://memory', 'w');
            $delimiter = ",";
            foreach ($products as $line) {
                fputcsv($f, $line, $delimiter);
            }
            fseek($f, 0);
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="products-statistic.csv";');
            fpassthru($f);
            exit;
        }
    }


}