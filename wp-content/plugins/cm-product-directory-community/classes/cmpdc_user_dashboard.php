<?php

class CMProductDirectoryCommunityUserDashboard {

    protected static $instance = NULL;

    static public function getInstance() {
        if ( empty( self::$instance ) ) {
            self::$instance = new CMProductDirectoryCommunityUserDashboard();
        } else {
            return self::$instance;
        }
    }

    public function __construct() {
        self::registerShortCode();
        add_action( 'template_redirect', array( __CLASS__, 'cmpdc_delete_product' ) );
    }

    public static function registerShortCode() {
        add_shortcode( 'cmpdc_dashboard', array( __CLASS__, 'outputUserDasboard' ) );
    }

    public static function outputUserDasboard() {
        if ( !class_exists( 'CMProductDirectory' ) ) {
            return;
        }
        global $post;
        $suggest_page_id = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_ID );


        ob_start();
        // get logged in user id
        if ( is_user_logged_in() ) :
            $user = wp_get_current_user();

            $args = array(
                'author'      => $user->ID,
                'post_type'   => CMProductDirectoryShared::POST_TYPE,
                'post_status' => array( 'pending', 'publish' ),
            );

            $isEditor = user_can( $user, 'editor' );

            $products = new WP_Query( $args );
            if ( !empty( $products->posts ) ) :
                echo self::get_styles();
                ?>
                <style>.cmpdc_pending_post { color: #cecece; }</style>
                <table>
                    <tbody>
                        <tr>
                            <th><?php _e( 'Product name', CMPD_SLUG_NAME ); ?></th>
                            <?php if ( $isEditor ) : ?>
                                <th><?php _e( 'Edit on backend', CMPD_SLUG_NAME ); ?></th>
                            <?php endif; ?>
                            <th><?php _e( 'Edit', CMPD_SLUG_NAME ); ?></th>
                            <th><?php _e( 'Delete', CMPD_SLUG_NAME ); ?></th>
                        </tr>

                        <?php
                        $products = $products->posts;

                        foreach ( $products as $product ) :
                            ?>
                            <tr>
                                <td style="width:75%;">
                                    <a target="_blank" href="<?php echo get_permalink( $product->ID ); ?>"><?php echo $product->post_title; ?></a>
                                    <!-- if moderate -->
                                    <?php $isModerate = $product->post_status == 'pending' ? '<span class="cmpdc_pending_post">' . __( 'Pending', CMPD_SLUG_NAME ) . '</span>' : ''; ?>
                                    <?php echo $isModerate; ?>
                                </td>
                                <?php if ( $isEditor ) : ?>
                                    <td>
                                        <?php
                                        $editUrl = get_admin_url() . 'post.php?post=' . $product->ID . ' &amp;action=edit';
                                        ?>
                                        <a target="_blank" href="<?php echo esc_attr( $editUrl ); ?>"><?php _e( 'Edit', CMPD_SLUG_NAME ); ?>
                                        </a>
                                    </td>
                                <?php endif; ?>
                                <td>
                                    <?php
                                    $editUrl = add_query_arg( array( 'edit' => '1' ), get_permalink( $product->ID ) );
                                    ?>
                                    <a target="_blank" href="<?php echo $editUrl; ?>"><?php _e( 'Edit', CMPD_SLUG_NAME ); ?>
                                    </a>
                                </td>
                                <td><a target="_blank" href="<?php echo $_SERVER[ 'REQUEST_URI' ]; ?>?delete_product=<?php echo $product->ID; ?>" onclick="return confirm( 'Are you sure you want to delete this product?' )" ><?php _e( 'Delete', CMPD_SLUG_NAME ); ?></a></td>
                            </tr>

                        <?php endforeach; ?>

                        <tr>
                            <td><?php _e( 'Product found', CMPD_SLUG_NAME ); ?>: <?php echo sizeof( $products ); ?></td>
                            <td colspan="2"><p style="text-align:right;">
                                    <a href="<?php echo get_permalink( $suggest_page_id ); ?>"><?php _e( 'Suggest Product', CMPD_SLUG_NAME ); ?></a>
                                </p></td>
                        </tr>
                    </tbody>
                </table>
                <?php
            else:
                $suggest_product_link = '<a href="' . get_permalink( $suggest_page_id ) . '">' . __( 'here', CMPD_SLUG_NAME ) . '</a>';
                $no_submitted_label   = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_USER_DASHBOARD_EMPTY_LABEL, 'You have no submited products yet. Please suggest %s.' );
                echo '<p>' . sprintf( __( $no_submitted_label, CMPD_SLUG_NAME ), $suggest_product_link ) . '</p>';
            endif;
        else :
            echo '<p>' . __( 'You are not logged in', CMPD_SLUG_NAME ) . '.</p>';
        endif;
        $content = ob_get_clean();
        return $content;
    }

    public static function get_styles() {
        return '<style>
			.cmpdc_pending_post { color: #cececece; }
			.cmpdc_pending_post:after { content: ")"; }
			.cmpdc_pending_post:before { content: "("; }
			</style>';
    }

    public static function cmpdc_delete_product() {
        if ( isset( $_GET[ 'delete_product' ] ) ) :
            wp_delete_post( $_GET[ 'delete_product' ], false );
            wp_redirect( get_permalink( $post->ID ), 302 );
            exit;
        endif;
    }

}
