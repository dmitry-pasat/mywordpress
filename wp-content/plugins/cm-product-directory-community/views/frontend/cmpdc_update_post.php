<?php
if ( !empty( $data[ 'allowUpdatePost' ] ) ):
	if ( empty( $data[ 'post_id' ] ) || empty( $data[ 'user' ] ) ) {
		return;
	}
	$message = !isset( $data[ 'sukces' ] ) ? 'Something goes wrong' : $data[ 'sukces' ];

	$post_id	 = $data[ 'post_id' ];
	$post_url	 = get_permalink( $post_id );
	$post		 = get_post( $post_id );
	$user		 = $data[ 'user' ];
	$image_id	 = CMProductDirectory::meta( $post_id, 'cmpd_product_gallery_id' );
	if ( is_wp_error( $image_id ) ) {
		$url			 = '';
		$error_string	 = $image_id->get_error_message();
		if ( $error_string === 'No file was uploaded.' ) {
			echo json_encode( array( 'status' => 'warning', 'code' => 1, 'msg' => __( $error_string, 'cmt_community_product' ) ) );
		} else {
			error_log( $error_string, 0 );
		}
	} else {
		$thumb		 = wp_get_attachment_image_src( $image_id );
		$large		 = wp_get_attachment_image_src( $image_id, 'large' );
		$cmpd_image	 = wp_get_attachment_image_src( $image_id, 'cmpd_image' );

		$url = empty( $cmpd_image[ 0 ] ) ?
		empty( $large[ 0 ] ) ?
		empty( $thumb[ 0 ] ) ?
		'' : $thumb[ 0 ] : $large[ 0 ] : $cmpd_image[ 0 ];
	}

	$cmpdc_product_pitch	 = CMProductDirectory::meta( $post->ID, 'cmpd_product_pitch' );
	$cmpdc_year_founded		 = CMProductDirectory::meta( $post->ID, 'cmpd_year_founded' );
	$cmpdc_address			 = CMProductDirectory::meta( $post->ID, 'cmpd_address' );
	$cmpdc_cityTown			 = CMProductDirectory::meta( $post->ID, 'cmpd_cityTown' );
	$cmpdc_stateCounty		 = CMProductDirectory::meta( $post->ID, 'cmpd_stateCounty' );
	$cmpdc_postalcode		 = CMProductDirectory::meta( $post->ID, 'cmpd_postalcode' );
	$cmpdc_region			 = CMProductDirectory::meta( $post->ID, 'cmpd_region' );
	$cmpdc_country			 = CMProductDirectory::meta( $post->ID, 'cmpd_country' );
	$cmpdc_virtual_address	 = CMProductDirectory::meta( $post->ID, 'cmpd_virtual_address' );

	$cmpdc_web_url			 = CMProductDirectory::meta( $post->ID, 'cmpd_web_url' );
	$cmpdc_bemail			 = CMProductDirectory::meta( $post->ID, 'cmpd_bemail' );
	$cmpdc_bemail_contact	 = CMProductDirectory::meta( $post->ID, 'cmpd_bemail_contact' );
	$cmpdc_facebook_name	 = CMProductDirectory::meta( $post->ID, 'cmpd_facebook_name' );
	$cmpdc_twitter_name		 = CMProductDirectory::meta( $post->ID, 'cmpd_twitter_name' );
	$cmpdc_google			 = CMProductDirectory::meta( $post->ID, 'cmpd_google' );
	$cmpdc_linkedin			 = CMProductDirectory::meta( $post->ID, 'cmpd_linkedin' );
	$cmpdc_rss				 = CMProductDirectory::meta( $post->ID, 'cmpd_rss_name' );
	$cmpdc_add_link1		 = CMProductDirectory::meta( $post->ID, 'cmpd_add_link1' );
	$cmpdc_add_link2		 = CMProductDirectory::meta( $post->ID, 'cmpd_add_link2' );
	$cmpdc_add_link3		 = CMProductDirectory::meta( $post->ID, 'cmpd_add_link3' );
	$cmpdc_add_link4		 = CMProductDirectory::meta( $post->ID, 'cmpd_add_link4' );
	$cmpdc_phone			 = CMProductDirectory::meta( $post->ID, 'cmpd_phone' );
	$cmpdc_add_google_map	 = CMProductDirectory::meta( $post->ID, 'cmpd_add_google_map' );
	$cmpdc_title			 = $post->post_title;
	$cmpdc_description		 = $post->post_content;

	$field_url_video		= CMProductDirectory::meta( $post->ID, 'cmpd_product_video' );
	$field_cost				= CMProductDirectory::meta( $post->ID, 'cmpd_product_cost' );
	$field_link_page		= CMProductDirectory::meta( $post->ID, 'cmpd_product_page' );
	$field_link_demo		= CMProductDirectory::meta( $post->ID, 'cmpd_demo_link' );
	$field_link_purchase	= CMProductDirectory::meta( $post->ID, 'cmpd_purchase_link' );
	$field_companyname		= CMProductDirectory::meta( $post->ID, 'cmpd_company_name' );



	$post_cats	 = wp_get_post_terms( $post_id, CMProductDirectoryShared::POST_TYPE_TAXONOMY );
	$tmp_cats	 = array();
	foreach ( $post_cats as $past_cat ) {
		$tmp_cats[] = $past_cat->term_id;
	}
	$post_cats							 = $tmp_cats;	
	$desc_settings						 = array();
	$desc_settings[ 'media_buttons' ]	 = 0;
	$desc_settings[ 'textarea_name' ]	 = 'cmpdc_description';
	$desc_settings[ 'tenny' ]			 = 1;
	$desc_settings[ 'textarea_rows' ]	 = 5;
	$desc_settings2						 = array();
	$desc_settings2[ 'media_buttons' ]	 = 0;
	$desc_settings2[ 'textarea_name' ]	 = 'cmpdc_form_product_pitch';
	$desc_settings2[ 'tenny' ]			 = 1;
	$desc_settings2[ 'textarea_rows' ]	 = 5;

	$taxonomy = array(
		'category' => array(
			'slug'	=> 'category',
			'terms' => get_terms( CMProductDirectoryShared::POST_TYPE_TAXONOMY , array( 'hide_empty' => 0 ) ),
			'label' => CMPD_Labels::getLocalized( 'category' ),
		),
		'pricingmodel' => array(
			'slug'	=> 'pricingmodel',
			'terms' => get_terms( CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL , array( 'hide_empty' => 0 ) ),
			'label' => CMPD_Labels::getLocalized( 'pricingmodel_filter_label' ),
		),
		'languagesupport' => array(
			'slug'	=> 'languagesupport',
			'terms' => get_terms( CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT , array( 'hide_empty' => 0 ) ),
			'label' => CMPD_Labels::getLocalized( 'langsupport_filter_label' ),
		),
		'targetaudience' => array(
			'slug'	=> 'targetaudience',
			'terms' => get_terms( CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE , array( 'hide_empty' => 0 ) ),
			'label' => CMPD_Labels::getLocalized( 'targetaudience_filter_label' ),
		),
	);

	$display_video = CMPD_Settings::getOption( CMPD_Settings::OPTION_ACTIVATE_VIDEO_FIELD );
	?>
	<div id="communityProduct_wrapper">
		<?php /* <p>
		  <a href=''> <strong> </?php echo $data['form_back_label']; ?/> </strong> </a>
		  </p> */ ?>
		<p> <?php echo esc_html( $message ); ?></p>
		<form id="cmpdc_update_form" method="post" enctype="multipart/form-data" novalidate>
			<input type="hidden" name="cmpdc_form_user" value="<?php echo esc_attr( $user ); ?>"/>
			<input type="hidden" name="cmpdc_post_id" value="<?php echo esc_attr( $post_id ); ?>"/>

			<?php echo wp_nonce_field( 'edit_product_'.$data['post_id'] ); ?>

			<div id="communityProduct_msg"></div>
			<div class="cmpdc_settings_container">
				<a class="cmpdc_preview_link" href="<?php echo esc_attr( $post_url ); ?>"> Product preview </a>
				<div class="clear"></div>

				<div class="cmpdc_single_data">
					<label class="cmpdc_desc" for="communityProduct_title">
						<strong><?php
							echo $data[ 'form_title' ];
							echo empty( $data[ 'form_title_mandatory' ] ) ? '' : '*';
							?></strong>
					</label>
					<input class="cmpdc_input" id="communityProduct_title" type="text" name="cmpdc_title" value="<?php echo esc_attr( $cmpdc_title ); ?>" <?php echo empty( $data[ 'form_title_mandatory' ] ) ? '' : 'required="required"'; ?> />
					<div class="clear"></div>
				</div>
				<div class="clear"></div>

				<div class="cmpdc_single_data_editor">
					<label class="cmpdc_desc_label" for="communityProduct_description"><strong><?php
							echo $data[ 'form_description' ];
							echo empty( $data[ 'form_description_mandatory' ] ) ? '' : '*';
							?></strong></label>
					<?php
					ob_start();
					wp_editor( $cmpdc_description, 'communityProduct_description_area', $desc_settings );
					$editor								 = ob_get_clean();
					if ( !empty( $data[ 'form_description_mandatory' ] ) ) {
						$editor = str_replace( '<textarea', '<textarea required="required"="required="required"" ', $editor );
					}
					echo $editor;
					?>
				</div>
				<div class="clear"></div>

				<div class="cmpdc_single_data_editor">
					<label class="cmpdc_desc_label" for="form_product_pitch"><strong><?php
							echo $data[ 'form_product_pitch' ];
							echo empty( $data[ 'form_product_pitch_mandatory' ] ) ? '' : '*';
							?></strong></label>
					<?php
					ob_start();
					wp_editor( $cmpdc_product_pitch, 'form_product_pitch', $desc_settings2 );
					$editor = ob_get_clean();
					if ( !empty( $data[ 'form_product_pitch_mandatory' ] ) ) {
						$editor = str_replace( '<textarea', '<textarea required="required" ', $editor );
					}
					echo $editor;
					?>
				</div>

				<!-- Taxonomy -->
				<?php if ( !empty( $taxonomy ) ) {
					foreach( $taxonomy as $tax ) { ?>

						<div class="cmpdc_single_data">
							<label class="cmpdc_desc" for="form_<?php echo $tax['slug']; ?>"><strong>
								<?php echo $tax['label']; ?>
							</strong></label>

							<select multiple class="cmpdc_select" type="text" name="cmpdc[form_<?php echo $tax['slug']; ?>][]" id="form_<?php echo $tax['slug']; ?>" size="5">
							<?php if ( !empty( $tax['terms'] ) ) {
								foreach ( $tax['terms'] as $term ) { ?>
									<option value="<?php echo esc_attr( $term->term_id ); ?>"><?php echo $term->name; ?></option>

								<?php }
							} ?>
							</select>
						</div>
						<div class="clear"></div>

					<?php } ?>
					<div class="clear"></div>
				<?php } ?>
			</div>

			<?php if ( !$data[ 'loggedIn' ] ): ?>
				<div class="cmpdc_settings_container" <?php echo!empty( $url ) ? 'style =\'\'' : ''; ?> >
					<div class="cmpdc_single_data">
						<label class="cmpdc_desc" for="form_bemail_contact"><strong><?php
								echo $data[ 'form_bemail_contact' ];
								echo empty( $data[ 'form_bemail_contact_mandatory' ] ) ? '' : '*';
								?></strong></label>
						<input class="cmpdc_input" id="form_bemail_contact" type="email" name="cmpdc_form_bemail_contact" value="<?php echo esc_attr( $cmpdc_bemail_contact ); ?>" <?php echo empty( $data[ 'form_bemail_contact_mandatory' ] ) ? '' : 'required="required"'; ?> />
					</div>
					<div class="clear"></div>
				</div>
			<?php endif; ?>

			<div class="cmpdc_settings_container">
				<div class="cmpdc_single_data">
					<label class="cmpdc_desc_width" for="form_add_product_image">
						<strong>
							<?php
							echo $data[ 'form_add_product_image_text' ];
							?>
						</strong>
					</label>
				</div>

				<div class="cmpdc_single_data" style="width: 99%;width: calc(100% - 10px);width: -moz-calc(100% - 10px);width: -webkit-calc(100% - 10px);">
					<label class="cmpdc_desc" for="form_add_product_image"><strong><?php
							echo $data[ 'form_add_product_image' ];
							echo empty( $data[ 'form_add_product_image_mandatory' ] ) ? '' : '*';
							?></strong></label>
					<div class="cmpdc_input_img">
						<input class="cmpdc_input" id="form_add_product_image" type="file" name="form_add_product_image" <?php echo ((empty( $data[ 'form_add_product_image_mandatory' ] ) && empty( $url )) ? '' : 'required="required"'); ?> />
						<?php if ( !empty( $url ) ): ?>
							<img class="cmpdc_preview" src="<?php echo esc_attr( $url ); ?>" alt="Can't load the image" />
						<?php endif; ?>
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>


<?php  if ( $display_video ) { ?>
<?php if ( !$data['field_url_video'] ) { ?>
<div class="cmpdc_single_data">
	<label for="field_url_video" class="cmpdc_desc"><strong>
		<?php echo $data[ 'field_url_video' ]; ?>
		<?php echo empty( $data[ 'mandatory_url_video' ] ) ? '' : '*'; ?>
	</strong></label>
	<input type="text" class="cmpdc_input" id="field_url_video" name="field_url_video" <?php echo empty( $data[ 'field_url_video' ] ) ? '' : 'required="required"'; ?> placeholder="<?php echo $data['placeholder_url_video']; ?>" value="<?php echo esc_attr( $field_url_video); ?>" >
</div>
<div class="clear"></div>
<?php } ?>
<?php } ?>

<?php if ( !$data['field_cost'] ) { ?>
<div class="cmpdc_single_data">
	<label for="field_cost" class="cmpdc_desc"><strong>
		<?php echo $data[ 'field_cost' ]; ?>
		<?php echo empty( $data[ 'mandatory_cost' ] ) ? '' : '*'; ?>
	</strong></label>
	<input type="text" class="cmpdc_input" id="field_cost" name="field_cost" <?php echo empty( $data[ 'field_cost' ] ) ? '' : 'required="required"'; ?> placeholder="<?php echo $data['placeholder_cost']; ?>" value="<?php echo esc_attr( $field_cost); ?>" >
</div>
<div class="clear"></div>
<?php } ?>

<?php if ( !$data['field_link_purchase'] ) { ?>
<div class="cmpdc_single_data">
	<label for="field_link_purchase" class="cmpdc_desc"><strong>
		<?php echo $data[ 'field_link_purchase' ]; ?>
		<?php echo empty( $data[ 'mandatory_link_purchase' ] ) ? '' : '*'; ?>
	</strong></label>
	<input type="text" class="cmpdc_input" id="field_link_purchase" name="field_link_purchase" <?php echo empty( $data[ 'field_link_purchase' ] ) ? '' : 'required="required"'; ?> placeholder="<?php echo $data['placeholder_link_purchase']; ?>" value="<?php echo esc_attr( $field_link_purchase); ?>" >
</div>
<div class="clear"></div>
<?php } ?>

<?php if ( !$data['field_link_demo'] ) { ?>
<div class="cmpdc_single_data">
	<label for="field_link_demo" class="cmpdc_desc"><strong>
		<?php echo $data[ 'field_link_demo' ]; ?>
		<?php echo empty( $data[ 'mandatory_link_demo' ] ) ? '' : '*'; ?>
	</strong></label>
	<input type="text" class="cmpdc_input" id="field_link_demo" name="field_link_demo" <?php echo empty( $data[ 'field_link_demo' ] ) ? '' : 'required="required"'; ?> placeholder="<?php echo $data['placeholder_link_demo']; ?>" value="<?php echo esc_attr( $field_link_demo); ?>" >
</div>
<div class="clear"></div>
<?php } ?>

<?php if ( !$data['field_link_page'] ) { ?>
<div class="cmpdc_single_data">
	<label for="field_link_page" class="cmpdc_desc"><strong>
		<?php echo $data[ 'field_link_page' ]; ?>
		<?php echo empty( $data[ 'mandatory_link_page' ] ) ? '' : '*'; ?>
	</strong></label>
	<input type="text" class="cmpdc_input" id="field_link_page" name="field_link_page" <?php echo empty( $data[ 'field_link_page' ] ) ? '' : 'required="required"'; ?> placeholder="<?php echo $data['placeholder_link_page']; ?>" value="<?php echo esc_attr( $field_link_page); ?>" >
</div>
<div class="clear"></div>
<?php } ?>




			</div>
			<!-- <div>
				 <label class="cmpdc_desc" for="form_product_gallery_id"><strong><?php echo esc_html( $data[ 'form_product_gallery_id' ] ); ?></strong></label>
				 <div class="cmpdc_input"><input id="form_product_gallery_id" type="text" name="cmpdc[form_product_gallery_id]" placeholder="<?php echo esc_attr( $data[ 'form_product_gallery_id_placeholder' ] ); ?>" required="required"></div>
			 </div>-->
			<div class="clear"></div>
			<div class="cmpdc_settings_container" id="with_map">
				<div class="cmpdc_settings_container_inner">
					<div class="cmpdc_single_data">
						<label class="cmpdc_desc" for="form_year_founded"><strong><?php
								echo $data[ 'form_year_founded' ];
								?></strong></label>
						<select class="cmpdc_select" name="cmpdc_form_year_founded" id="form_year_founded" class="cm_imput_short">
							<?php
							$current_date	 = date( 'Y' );
							$current_date	 = intval( $current_date );

							$i			 = 1950;
							$max		 = 2017;
							///$selected = get_option(CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_YEAR_FOUNDED_PLACECHOLDER);
							$selected	 = empty( $cmpdc_year_founded ) ? $current_date : $cmpdc_year_founded;

							echo '<option value="Not indicated"' . selected( $selected, 'Not indicated', 0 ) . '>Not indicated</option>';

							for ( $i; $i <= $max; $i++ ) {
								echo '<option value="' . esc_attr( $i ) . '" ' . selected( $selected, $i, 0 ) . '>' . $i . '</option>';
							}
							?>
						</select>

					</div>
					<div class="clear"></div>
					<div class="cmpdc_single_data">
						<label class="cmpdc_desc" for="form_phone">
							<strong><?php
								echo $data[ 'form_phone' ];
								echo empty( $data[ 'form_phone_mandatory' ] ) ? '' : '*';
								?></strong>
						</label>
						<input class="cmpdc_input" id="form_phone" type="text" value="<?php echo esc_attr( $cmpdc_phone ); ?>" name="cmpdc_form_phone" <?php echo empty( $data[ 'form_phone_mandatory' ] ) ? '' : 'required="required"'; ?> />
					</div>

					<div class="clear"></div>

	<?php if ( !$data['field_companyname'] ) { ?>
<div class="cmpdc_single_data">
	<label for="field_companyname" class="cmpdc_desc"><strong>
		<?php echo $data[ 'field_companyname' ]; ?>
		<?php echo empty( $data[ 'mandatory_companyname' ] ) ? '' : '*'; ?>
	</strong></label>
	<input type="text" class="cmpdc_input" id="field_companyname" name="field_companyname" <?php echo empty( $data[ 'field_companyname' ] ) ? '' : 'required="required"'; ?> placeholder="<?php echo $data['placeholder_companyname']; ?>" value="<?php echo esc_attr( $field_companyname); ?>" >
</div>
<div class="clear"></div>
<?php } ?>

					<div class="cmpdc_single_data">
						<label class="cmpdc_desc" for="form_virtual_address">
							<strong><?php
								echo $data[ 'form_virtual_address' ];
								?></strong>
						</label>
						<input class="cmpdc_checkbox" id="form_virtual_address" type="checkbox" value="1" name="cmpdc_form_virtual_address" value="1" <?php checked( true, !empty( $cmpdc_virtual_address ) ); ?> />
					</div>
					<div class="clear"></div>

					<div class="cmpdc_single_data">
						<label class="cmpdc_desc" for="form_address">
							<strong><?php
								echo $data[ 'form_address' ];
								echo empty( $data[ 'form_address_mandatory' ] ) ? '' : '*';
								?>
							</strong>
						</label>
						<input class="cmpdc_input" id="form_address" type="text" value="<?php echo esc_attr( $cmpdc_address ); ?>" name="cmpdc_form_address" <?php echo empty( $data[ 'form_address_mandatory' ] ) ? '' : 'required="required"'; ?> />
					</div>
					<div class="clear"></div>

					<div class="cmpdc_single_data">
						<label class="cmpdc_desc" for="form_cityTown">
							<strong><?php
								echo $data[ 'form_cityTown' ];
								echo empty( $data[ 'form_cityTown_mandatory' ] ) ? '' : '*';
								?>
							</strong>
						</label>
						<input class="cmpdc_input" id="form_cityTown" type="text" value="<?php echo esc_attr( $cmpdc_cityTown ); ?>" name="cmpdc_form_cityTown" <?php echo empty( $data[ 'form_cityTown_mandatory' ] ) ? '' : 'required="required"'; ?> />
					</div>
					<div class="clear"></div>

					<div class="cmpdc_single_data">
						<label class="cmpdc_desc" for="form_stateCounty">
							<strong><?php
								echo $data[ 'form_stateCounty' ];
								echo empty( $data[ 'form_stateCounty_mandatory' ] ) ? '' : '*';
								?>
							</strong>
						</label>
						<input class="cmpdc_input"s id="form_stateCounty" type="text" value="<?php echo esc_attr( $cmpdc_address ); ?>" name="cmpdc_form_stateCounty" <?php echo empty( $data[ 'form_stateCounty_mandatory' ] ) ? '' : 'required="required"'; ?> />
					</div>
					<div class="clear"></div>

					<div class="cmpdc_single_data">
						<label class="cmpdc_desc" for="form_postalcode">
							<strong><?php
								echo $data[ 'form_postalcode' ];
								echo empty( $data[ 'form_postalcode_mandatory' ] ) ? '' : '*';
								?>
							</strong>
						</label>
						<input class="cmpdc_input" id="form_postalcode" type="text" value="<?php echo esc_attr( $cmpdc_postalcode ); ?>" name="cmpdc_form_postalcode" <?php echo empty( $data[ 'form_postalcode_mandatory' ] ) ? '' : 'required="required"'; ?> />
					</div>
					<div class="clear"></div>

					<div class="cmpdc_single_data">
						<label class="cmpdc_desc" for="form_region">
							<strong><?php
								echo $data[ 'form_region' ];
								echo empty( $data[ 'form_region_mandatory' ] ) ? '' : '*';
								?>
							</strong>
						</label>
						<input class="cmpdc_input" id="form_region" type="text" value="<?php echo esc_attr( $cmpdc_region ); ?>" name="cmpdc_form_region" <?php echo empty( $data[ 'form_region_mandatory' ] ) ? '' : 'required="required"'; ?> />
					</div>
					<div class="clear"></div>

					<div class="cmpdc_single_data">
						<label class="cmpdc_desc" for="form_country">
							<strong>
								<?php
								_e( $data[ 'form_country' ], CMPD_SLUG_NAME );
								$countries	 = array( "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe" );
								$current	 = $cmpdc_country;
								if ( empty( $current ) ) {
									$current = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_DEFAULT_COUNTRY );
									if ( empty( $current ) ) {
										$current = '';
									} else {
										$current = $countries[ $current ];
									}
								}
								?>
							</strong>
						</label>

						<select class="cmpdc_select" type="text" name="cmpdc_form_country" id="form_country">
							<?php
							foreach ( $countries as $country ) {
								$checked = ($current == $country) ? 'selected' : '';
								echo '<option value="' . esc_attr( $country ) . '" ' . $checked . '>' . $country . '</option>';
							}
							?>
						</select>
					</div>
					<div class="clear"></div>

					<div class="cmpdc_single_data">
						<label class="cmpdc_desc" for="form_add_google_map"><strong><?php
								echo $data[ 'form_add_google_map' ]
								?></strong></label>
						<input class="cmpdc_checkbox"id="form_add_google_map" type="checkbox" name="cmpdc_form_add_google_map" value="1" <?php
						if ( !empty( $cmpdc_add_google_map ) ) {
							echo 'checked="checked"';
						}
						?>  />
					</div>
					<div class="clear"></div>
				</div>
				<div class="cmpdc-map" id="cmpdc-map-canvas"></div>
				<div class="clear"></div>
			</div>

			<div class="cmpdc_settings_container">

				<?php if ( !empty( $data[ 'form_bemail' ] ) ) : ?>
				<div class="cmpdc_single_data">
					<label class="cmpdc_desc" for="form_bemail">
						<strong><?php
							echo $data[ 'form_bemail' ];
							echo empty( $data[ 'form_bemail_mandatory' ] ) ? '' : '*';
							?>
						</strong>
					</label>
					<input class="cmpdc_input" id="form_bemail" type="email" name="cmpdc_form_bemail" value="<?php echo esc_attr( $cmpdc_bemail ); ?>" <?php echo empty( $data[ 'form_bemail_mandatory' ] ) ? '' : 'required="required"'; ?> />
				</div>
				<div class="clear"></div>
				<?php endif; ?>

				<?php if ( !empty( $data[ 'form_web_url' ] ) ) : ?>
				<div class="cmpdc_single_data">
					<label class="cmpdc_desc" for="form_web_url">
						<strong><?php
							echo $data[ 'form_web_url' ];
							echo empty( $data[ 'form_web_url_mandatory' ] ) ? '' : '*';
							?>
						</strong>
					</label>
					<input class="cmpdc_input" id="form_web_url" type="text" value="<?php echo esc_attr( $cmpdc_web_url ); ?>" name="cmpdc_form_web_url" <?php echo empty( $data[ 'form_web_url_mandatory' ] ) ? '' : 'required="required"'; ?> />
				</div>
				<div class="clear"></div>
				<?php endif; ?>

				<?php if ( !empty( $data[ 'form_facebook_name' ] ) ) : ?>
				<div class="cmpdc_single_data">
					<label class="cmpdc_desc" for="form_facebook_name"><strong><?php
							echo $data[ 'form_facebook_name' ];
							echo empty( $data[ 'form_facebook_name_mandatory' ] ) ? '' : '*';
							?></strong></label>
					<input class="cmpdc_input" id="form_facebook_name" type="text" value="<?php echo esc_attr( $cmpdc_facebook_name ); ?>" name="cmpdc_form_facebook_name" <?php echo empty( $data[ 'form_facebook_name_mandatory' ] ) ? '' : 'required="required"'; ?> />
				</div>
				<div class="clear"></div>
				<?php endif; ?>

				<?php if ( !empty( $data[ 'form_twitter_name' ] ) ) : ?>
				<div class="cmpdc_single_data">
					<label class="cmpdc_desc" for="form_twitter_name"><strong><?php
							echo $data[ 'form_twitter_name' ];
							echo empty( $data[ 'form_twitter_name_mandatory' ] ) ? '' : '*';
							?></strong></label>
					<input class="cmpdc_input" id="form_twitter_name" type="text" value="<?php echo esc_attr( $cmpdc_twitter_name ); ?>" name="cmpdc_form_twitter_name" <?php echo empty( $data[ 'form_twitter_name_mandatory' ] ) ? '' : 'required="required"'; ?> />
				</div>
				<div class="clear"></div>
				<?php endif; ?>

				<?php if ( !empty( $data[ 'form_google' ] ) ) : ?>
				<div class="cmpdc_single_data">
					<label class="cmpdc_desc" for="form_google"><strong><?php
							echo $data[ 'form_google' ];
							echo empty( $data[ 'form_google_mandatory' ] ) ? '' : '*';
							?></strong></label>
					<input class="cmpdc_input" id="form_google" type="text" value="<?php echo esc_attr( $cmpdc_google ); ?>" name="cmpdc_form_google" <?php echo empty( $data[ 'form_google_mandatory' ] ) ? '' : 'required="required"'; ?> />
				</div>
				<div class="clear"></div>
				<?php endif; ?>

				<?php if ( !empty( $data[ 'form_linkedin' ] ) ) : ?>
				<div class="cmpdc_single_data">
					<label class="cmpdc_desc" for="form_linkedin"><strong><?php
							echo $data[ 'form_linkedin' ];
							echo empty( $data[ 'form_linkedin_mandatory' ] ) ? '' : '*';
							?></strong></label>
					<input class="cmpdc_input" id="form_linkedin" type="text" value="<?php echo esc_attr( $cmpdc_linkedin ); ?>" name="cmpdc_form_linkedin" <?php echo empty( $data[ 'form_linkedin_mandatory' ] ) ? '' : 'required="required"'; ?> />
				</div>
				<?php endif; ?>

				<?php if ( !empty( $data[ 'form_rss' ] ) ) : ?>
					<div class="clear"></div>
					<div class="cmpdc_single_data">
						<label class="cmpdc_desc" for="form_rss"><strong><?php
								echo $data[ 'form_rss' ];
								echo empty( $data[ 'form_rss_mandatory' ] ) ? '' : '*';
								?></strong></label>
						<input class="cmpdc_input" id="form_rss" type="text" value="<?php echo esc_attr( $cmpdc_rss ); ?>" name="cmpdc_form_rss" <?php echo empty( $data[ 'form_rss_mandatory' ] ) ? '' : 'required="required"'; ?> />
					</div>
				<?php endif; ?>

				<div class="clear"></div>
				<?php
				if ( defined( 'CMPD_Settings::OPTION_ADD_LINKS' ) ) :
					$add_links = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_LINKS );
					if ( !empty( $add_links ) ):
						if ( !empty( $data[ 'form_add_link1' ] ) ):
							?>
							<div class="cmpdc_single_data">
								<label class="cmpdc_desc" for="form_add_link1"><strong><?php
										echo $data[ 'form_add_link1' ];
										echo empty( $data[ 'form_add_link1_mandatory' ] ) ? '' : '*';
										?></strong></label>
								<input class="cmpdc_input" id="form_add_link1" type="text"   value="<?php echo esc_attr( $cmpdc_add_link1 ); ?>" name="cmpdc_form_add_link1" <?php echo empty( $data[ 'form_add_link1_mandatory' ] ) ? '' : 'required="required"'; ?> />
							</div>
							<div class="clear"></div>
							<?php
						endif;
						if ( !empty( $data[ 'form_add_link2' ] ) ):
							?>
							<div class="cmpdc_single_data">
								<label class="cmpdc_desc" for="form_add_link2"><strong><?php
										echo $data[ 'form_add_link2' ];
										echo empty( $data[ 'form_add_link2_mandatory' ] ) ? '' : '*';
										?></strong></label>
								<input class="cmpdc_input" id="form_add_link2" type="text"   value="<?php echo esc_attr( $cmpdc_add_link2 ); ?>" name="cmpdc_form_add_link2" <?php echo empty( $data[ 'form_add_link2_mandatory' ] ) ? '' : 'required="required"'; ?>>
							</div>
							<div class="clear"></div>
							<?php
						endif;
						if ( !empty( $data[ 'form_add_link3' ] ) ):
							?>
							<div class="cmpdc_single_data">
								<label class="cmpdc_desc" for="form_add_link3"><strong><?php
										echo $data[ 'form_add_link3' ];
										echo empty( $data[ 'form_add_link3_mandatory' ] ) ? '' : '*';
										?></strong></label>
								<input class="cmpdc_input" id="form_add_link3" type="text"   value="<?php echo esc_attr( $cmpdc_add_link2 ); ?>" name="cmpdc_form_add_link3" <?php echo empty( $data[ 'form_add_link3_mandatory' ] ) ? '' : 'required="required"'; ?>>
							</div>
							<div class="clear"></div>
							<?php
						endif;
						if ( !empty( $data[ 'form_add_link4' ] ) ):
							?>
							<div class="cmpdc_single_data">
								<label class="cmpdc_desc" for="form_add_link4"><strong><?php
										echo $data[ 'form_add_link4' ];
										echo empty( $data[ 'form_add_link4_mandatory' ] ) ? '' : '*';
										?></strong></label>
								<input class="cmpdc_input" id="form_add_link4" type="text"   value="<?php echo esc_attr( $cmpdc_add_link4 ); ?>" name="cmpdc_form_add_link4" <?php echo empty( $data[ 'form_add_link4_mandatory' ] ) ? '' : 'required="required"'; ?>>
							</div>
							<div class="clear"></div>

							<?php
						endif;
					endif;
				endif;
				?>

			</div>
			<?php if ( !empty( $data[ 'captcha' ] ) && !empty( $data[ 'recaptcha' ] ) ): ?>
				<label for="communityProduct_captcha"><?php echo esc_html( $data[ 'form_captcha_text' ] ); ?></label>
				<div id="communityProduct_captcha"><?php echo $data[ 'recaptcha' ]; ?></div>
			<?php endif; //cmpdc_submit_edit     ?>

			<input class="button button-primary cmpdc_recover_button" name="cmpdc_update_post" type="submit" value="<?php echo esc_html( $data[ 'form_button_text_update' ] ); ?>"/>

		</form>
	</div>
	<?php
 endif;