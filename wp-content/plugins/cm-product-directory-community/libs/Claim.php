<?php

class CMProductDirectoryCommunityClaim {

    const meta_user     = "cmpd_product_user";
    const meta_password = "cmpd_product_password";

    public static function getPostByUser($user) {
        global $wpdb;
        $sql     = $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %s", self::meta_user, $user );
        $post_id = $wpdb->get_var( $sql );
        return $post_id;
    }

    public static function getPostByPassword($password) {
        global $wpdb;
        $sql       = $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %s", self::meta_password, $password );
        $post_id = $wpdb->get_var( $sql );
        return $post_id;
    }

    public static function acceptClaim( $post_id, $claimKeyToAccept = null ) {
        $message = '';
        if ( empty( $post_id ) ) {
            return $message;
        }
        $post = get_post( $post_id );
        if ( empty( $post ) ) {
            return $message;
        }

        $claimsList       = CMProductDirectory::meta( $post->ID, 'cmpd_bemail_contact_tmp' );
        $claimKeyToAccept = empty( $claimKeyToAccept ) ? (empty( $_GET[ 'accept' ] ) ? '' : $_GET[ 'accept' ]) : $claimKeyToAccept;
        if ( !empty( $claimKeyToAccept ) && !empty( $claimsList[ $claimKeyToAccept ] ) ) {

            update_post_meta( $post_id, 'cmpd_bemail_contact', $claimsList[ $claimKeyToAccept ][ 'email' ] );
            CMProductDirectoryCommunityBusinessClaim::set_login_password( $post_id );

            $notificationResult = CMProductDirectoryCommunityBusinessBackend::notification( $post, array() );

            if ( $notificationResult ) {
                $message = __( 'Login and Password sent correctly', 'cmt_community_product' );
                /*
                 * Clean claimer list
                 */
                update_post_meta( $post_id, 'cmpd_bemail_contact_tmp', array() );
            } else {
                $message = __( 'Can\'t send the data', 'cmt_community_product' );
            }
        }
        return $message;
    }

    public static function rejectClaim( $post_id ) {

    }

    public static function eraseClaims( $post_id ) {
        $post = get_post( $post_id );
        if ( !empty( $post ) ) {
            update_post_meta( $post->ID, 'cmpd_bemail_contact_tmp', array() );
            return json_encode( array( 'status' => 'success', 'code'   => 0,
                'msg'    => __( 'Claimer data was erased', 'cmt_community_product' ) ) );
        } else {
            return json_encode( array( 'status' => 'warning', 'code'   => 0,
                'msg'    => __( 'Can\'t erase claimer data', 'cmt_community_product' ) ) );
        }
    }

    public static function resetPassword( $post_id ) {
        $args = array();
        $post = get_post( $post_id );
        if ( !empty( $post ) ) {

            CMProductDirectoryCommunityBusinessClaim::set_login_password( $post_id );
            $notificationResult = CMProductDirectoryCommunityBusinessBackend::notification( $post, $args );

            if ( $notificationResult ) {
                return json_encode( array( 'status' => 'success', 'code'   => 0,
                    'msg'    => __( 'Login and Password sent correctly', 'cmt_community_product' ) ) );
            } else {
                return json_encode( array( 'status' => 'warning', 'code'   => 0,
                    'msg'    => __( 'Can\'t send the data', 'cmt_community_product' ) ) );
            }
        }
        return '';
    }

    public static function set_login_password( $post_id ) {
        $password = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand( 0, 50 ), 1 ) . substr( md5( time() ), 1 );
        $user     = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand( 0, 50 ), 1 ) . substr( md5( time() ), 1 );
        update_post_meta( $post_id, self::meta_password, $password );
        update_post_meta( $post_id, self::meta_user, $user );
    }

}
