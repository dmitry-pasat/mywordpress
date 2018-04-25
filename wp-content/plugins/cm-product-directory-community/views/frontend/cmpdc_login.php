<?php if ( empty( $data[ 'form_isowner' ] ) ) : ?>
    <?php if ( !empty( $data[ 'captcha' ] ) ): ?>
        <script type="text/javascript">
            var RecaptchaOptions = {
                theme: 'clean'
            };
        </script>
    <?php endif; ?>
    <div class="clear"></div>
    <p>
        <strong><?php echo esc_html( $data[ 'form_login_label' ] ); ?></strong> <a href="javascript:void(0)" onclick="jQuery( this ).parent().next().slideToggle()"><?php echo esc_html( $data[ 'form_showhide_text' ] ); ?></a>
    </p>

    <form class="form_submit" id="cmpdc_user_form" action="<?php echo esc_url( $data[ 'form_suggest_url' ] ); ?>" method="post" style="display:none;">
        <div class="cmpdc_settings_container">
            <div class="cmpdc_single_data">
                <label class="cmpdc_label" for="form_user"><strong><?php echo esc_html( $data[ 'form_user' ] ); ?>*</strong></label>
                <input class="cmpdc_input" id="form_user" type="text" name="cmpdc_form_user" required="required">
            </div>
            <div class="clear"></div>
            <div class="cmpdc_single_data">
                <label class="cmpdc_label" for="form_password"><strong><?php echo esc_html( $data[ 'form_password' ] ); ?>*</strong></label>
                <input class="cmpdc_input" id="form_password" type="password" name="cmpdc_form_password" required="required">
            </div>
            <div class="clear"></div>

            <input type="hidden" id="form_id" name="cmpdc_post_id" value="<?php echo get_the_ID(); ?>" >
            <?php echo wp_nonce_field( 'edit_product_' . get_the_ID() ); ?>
            <input class="button button-primary" type="submit" value="<?php echo esc_html( $data[ 'form_button2_text' ] ); ?>" />
        </div>
    </form>

<?php else: ?>
    <p>
        <strong><a href="?edit=1">Edit Your Business</a></strong>
    </p>
<?php endif; ?>

<div class="clear"></div>

<?php if ( !empty( $data[ 'form_userdata' ] ) ) : ?>

    <form class="form_submit" name="cmpdc_user_authenticated_redirect" action="<?php echo $data[ 'form_suggest_url' ]; ?>" method="post" style="display:<?php echo (empty( $data[ 'form_status' ] ) ? 'none' : 'block'); ?>">
        <?php
        foreach ( $data[ 'form_userdata' ] as $key => $value ) {
            echo '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
        }
        ?>
    </form>
    <script type="text/javascript">
        document.cmpdc_user_authenticated_redirect.submit();
    </script>
<?php endif; ?>