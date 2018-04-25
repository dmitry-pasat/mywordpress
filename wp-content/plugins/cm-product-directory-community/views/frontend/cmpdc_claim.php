<div class="clear"></div>
<style>
    .cmpdc_claim_button{
        margin-top:10px ;
        margin-bottom: 10px;
    }
</style>

<p>
    <strong><?php echo esc_html( $data[ 'form_claim_text' ] ); ?></strong> <a href="javascript:void(0)" onclick="jQuery( this ).parent().next().slideToggle()"><?php echo esc_html( $data[ 'form_showhide_text' ] ); ?></a>
</p>

<form class="form_submit" class="cmpdc_claim_container" id="cmpdc_claim_form" method="post" style="display:<?php echo (empty( $data[ 'form_status' ] ) ? 'none' : 'block'); ?>">
    <div class="cmpdc_settings_container">
		<?php
		if ( !empty( $data[ 'form_status' ] ) ) {
			echo $data[ 'form_status' ];
			?>
			<div class="clear"></div><?php
		}
		?>
        <div class="cmpdc_single_data">
            <label class="cmpdc_label" for="form_claim_name"><strong><?php echo esc_html( $data[ 'form_claim_name' ] ); ?>*</strong></label>
            <div class="clear"></div>
            <input class="cmpdc_input" id="form_claim_name" type="text" name="cmpdc_form_claim_name" required="required">
        </div>
        <div class="clear"></div>
        <div class="cmpdc_single_data">
            <label class="cmpdc_label" for="form_claim_email"><strong><?php echo esc_html( $data[ 'form_claim_email' ] ); ?>*</strong></label>
            <div class="clear"></div>
            <input class="cmpdc_input" id="form_claim_email" type="text" name="cmpdc_form_claim_email" required="required">
        </div>
        <div class="clear"></div>

		<?php if ( !empty( $data[ 'form_captcha' ] ) ) : ?>

			<?php
			$captchaKey = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_CAPTCHA_KEY, '' );
			?>
			<script type="text/javascript">
	            var RecaptchaOptions = {
	                theme: 'custom',
	                custom_theme_widget: 'recaptcha_widget'
	            };
			</script>
			<style>
				#recaptcha_widget div#recaptcha_image {
					max-width: 95% !important;
				}
				#recaptcha_widget img#recaptcha_challenge_image {
					max-width: 95%;
				}
			</style>
			<label for="communityProduct_captcha"><?php echo esc_html( $data[ 'form_captcha_text' ] ); ?></label>
			<div class="cmpdc_captcha" id="communityProduct_captcha">
				<strong>
					<div id="recaptcha_widget" style="display:none">

						<div id="recaptcha_image"></div>
						<div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>

						<span class="recaptcha_only_if_image">Enter the words above:*</span>
						<span class="recaptcha_only_if_audio">Enter the numbers you hear:*</span>

						<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />

						<div><a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a></div>
						<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
						<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>

						<div><a href="javascript:Recaptcha.showhelp()">Help</a></div>

					</div>

					<script type="text/javascript"
							src="http://www.google.com/recaptcha/api/challenge?k=<?php echo $captchaKey; ?>">
					</script>
					<noscript>
					<iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php echo $captchaKey; ?>"
							height="300" width="500" frameborder="0"></iframe><br>
					<textarea name="recaptcha_challenge_field" rows="3" cols="40">
					</textarea>
					<input type="hidden" name="recaptcha_response_field"
						   value="manual_challenge">
					</noscript>
				</strong>
			</div>
		<?php endif; ?>

        <input type="hidden" name="cmpdc_form_claim_post_id" value="<?php echo esc_attr( $data[ 'form_product_id' ] ); ?> ">

        <input class="button button-primary cmpdc_claim_button" name="cmpdc_claim" type="submit" value="<?php echo esc_html( $data[ 'form_claim_button' ] ); ?>"/>
    </div>
</form>
<div class="clear"></div>