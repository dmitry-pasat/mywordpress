<?php
	$placeholder 			= get_option(CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BEMAIL_CONTACT_PLACECHOLDER);
	$allowMultipleClaims 	= (bool) get_option(CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CLAIM_MULTI_CLAIMS);

	$post 				= get_post();
	$contact_email_tmp 	= CMProductDirectory::meta($post->ID, 'cmpd_bemail_contact_tmp');

	if( empty($contact_email_tmp) )
	{	
		update_post_meta($post->ID, 'cmpd_product_user', md5(rand()));
		update_post_meta($post->ID, 'cmpd_product_password', md5(rand()));
	}

	$message 	= '';
	$accept 	= empty($_GET['accept']) ? '' : $_GET['accept'];
	if( !empty($accept) && !empty($contact_email_tmp[$accept]) )
	{
		update_post_meta($post->ID, 'cmpd_bemail_contact', $contact_email_tmp[$accept]['email']);
		$args = array();
		if( CMProductDirectoryCommunityProductBackend::notification($post, $args) )
		{
			$message = 'Login and Password sent corectly';
		}
		else
		{
			$message = 'Can\'t send Login and Password';
		}
	}
	$contact_email = CMProductDirectory::meta($post->ID, 'cmpd_bemail_contact');
?>
<div class="cmpd_metabox_settings_container">
	<div id="communityProduct_msg"><?php echo esc_html($message); ?></div>
	<?php if( !empty($contact_email_tmp) ) : ?>
		<p>
			<label for="bemail_contact_tmp" class="cmpd_metabox_label"><span><strong>
				<?php _e('Pending product claims:', CMPD_SLUG_NAME); ?>
			</strong></span></label>
			<?php if( $allowMultipleClaims ) : ?>
				<select class="large-text ui-autocomplete-input cm_input_contact_email" type="text" id="cmpd_bemail_contact_claims" >
					<?php foreach($contact_email_tmp as $key => $value)
					{
						if( is_array($value) )
						{
							echo '<option value="' . esc_attr($value['email']) . '">' . $value['name'] . ':' . $value['email'] . '</option>';
						}
					} ?>
				</select>
			<div class="button button-secondary" id="cmpdc_bemail_contact_claim_erase">
				Clean claimer list
			</div>
		<?php else:
			$claim = end($contact_email_tmp);
			if( !empty($claim['email']) && !empty($claim['name']) ) : ?>
				<p>
					<?php echo sprintf(__('Product claim posted by: %s (e-mail: %s)'), $claim['name'], $claim['email']); ?>
					<input type="submit" value="Accept" name="cmpdc_claim_accept" class="button button-primary">
					<input type="submit" value="Reject" name="cmpdc_claim_reject" class="button button-secondary">
				</p>
			<?php endif;
		endif; ?>
	</p>
	<div class="clear"></div>
<?php endif; ?>

<p>
	<label for="bemail_contact" class="cmpd_metabox_label">
		<span><strong>
			<?php _e('Owner Email', CMPD_SLUG_NAME); ?>
		</strong></span>
	</label>

	<?php if( empty($placeholder) )
	{ ?>
		<input class="large-text ui-autocomplete-input cm_input_contact_email " type="text" placeholder="email@company-domain.com" name="cmpd_bemail_contact" id="bemail_contact" value="<?php echo esc_attr($contact_email); ?>">
	<?php } else { ?>
		<input class="large-text ui-autocomplete-input cm_input_contact_email " type="text"   placeholder="<?php echo esc_attr($placeholder); ?>" name="cmpd_bemail_contact" id="bemail_contact" value="<?php echo esc_attr($contact_email); ?>">
	<?php } ?>
</p>
<?php if( !empty($contact_email) && !empty($post) )
{ ?>
	<div class="button button-secondary" id="cmpdc_bemail_contact_submit">
		Send login and password
	</div>
<?php }
echo '<input type="hidden" id="bemail_contact_post_id" value="' . esc_attr($post->ID) . '">';
?>

<div class="clear"></div>
</div>