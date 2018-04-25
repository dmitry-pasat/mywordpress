<?php

class CMProductDirectoryCommunityProductBackend {

	const meta_user					 = "cmpd_product_user";
	const meta_password				 = "cmpd_product_password";
	const COMMUNITYPRODUCT_TEXTAREAS	 = 'cmpdc_textareas';
	const COMMUNITYPRODUCT_CAPTCHA								 = 'cmpdc_captcha';
	const COMMUNITYPRODUCT_CAPTCHA_KEY							 = 'cmpdc_captcha_key';
	const COMMUNITYPRODUCT_CAPTCHA_PRIVATE_KEY					 = 'cmpdc_captcha_private_key';
	const COMMUNITYPRODUCT_MODERATION								 = 'cmpdc_moderation';
	const COMMUNITYPRODUCT_ALLOW_ROLES							 = 'cmpdc_allow_add_product_roles';
	const COMMUNITYPRODUCT_TEXT_UNAUTHORIZED					='cmpdc_text_for_unauthorized_roles';
	const COMMUNITYPRODUCT_ADMIN_NOTIFICATION						 = 'cmpdc_notification';
	const COMMUNITYPRODUCT_ADMIN_NOTIFICATION_ADMIN				 = 'cmpdc_notification_admin';
	const COMMUNITYPRODUCT_NOTIFICATION_TEXT						 = 'cmpdc_notification_text';
	const COMMUNITYPRODUCT_NOTIFICATION_SUBJECT					 = 'cmpdc_notification_subject';
	const COMMUNITYPRODUCT_CLAIM_NOTIFICATION_TEXT				 = 'cmpdc_claim_notification_text';
	const COMMUNITYPRODUCT_CLAIM_NOTIFICATION_SUBJECT				 = 'cmpdc_claim_notification_subject';
	const COMMUNITYPRODUCT_USER_NOTIFICATION						 = 'cmpdc_user_notification';
	const COMMUNITYPRODUCT_USER_NOTIFICATION_TEXT					 = 'cmpdc_user_notification_text';
	const COMMUNITYPRODUCT_USER_NOTIFICATION_SUBJECT				 = 'cmpdc_user_notification_subject';
	const COMMUNITYPRODUCT_CLAIM_REJECTED_NOTIFICATION			 = 'cmpdc_claim_rejected_notification';
	const COMMUNITYPRODUCT_CLAIM_REJECTED_NOTIFICATION_TEXT		 = 'cmpdc_claim_rejected_notification_text';
	const COMMUNITYPRODUCT_CLAIM_REJECTED_NOTIFICATION_SUBJECT	 = 'cmpdc_claim_rejected_notification_subject';
	const COMMUNITYPRODUCT_ACCESS_NOTIFICATION_TEXT				 = 'cmpdc_access_notification_text';
	const COMMUNITYPRODUCT_ACCESS_NOTIFICATION_SUBJECT			 = 'cmpdc_access_notification_title';
	const COMMUNITYPRODUCT_PANEL_NOTIFICATION						 = 'cmpdc_panel_notification';
	const CMPDC_MAIN_FORM_PAGE_ID									 = 'cmpdc_form_page_id';
	const CMPDC_MAIN_FORM_PAGE_ID_ON								 = 'cmpdc_form_page_id_on';
	const CMPDC_MAIN_FORM_CLAIM_ON								 = 'cmpdc_form_claim_on';
	const CMPDC_LOGIN_ON_PRODUCT_PAGE								 = 'cmpdc_login_on_product_page';
	const CMPDC_MAIN_FORM_CLAIM_CAPTCHA							 = 'cmpdc_form_claim_captcha';
	const CMPDC_MAIN_FORM_CLAIM_MULTI_CLAIMS						 = 'cmpdc_form_claim_multi_claims';
	const CMPDC_MAIN_FORM_RECOVER_ON								 = 'cmpdc_form_recover_on';
	const CMPDC_MAIN_FORM_CATEGORIES_LIMIT						 = 'cmpdc_form_categories_limit';
	// Form parts
	const CMPDC_MAIN_FORM_SHOW_SOCIAL_MEDIA_SECTION              = 'cmpdc_form_show_social_media_section';
	const CMPDC_MAIN_FORM_SHOW_CATEGORIES_AS_CHECKBOXES          = 'cmpdc_form_show_categories_as_checkboxes';
	const CMPDC_MAIN_FORM_SHOW_TAGS                              = 'cmpdc_form_show_tags';
	// Labels
	const CMPDC_MAIN_FORM_USER									 = 'cmpdc_form_user';
	const CMPDC_MAIN_FORM_PASSWORD								 = 'cmpdc_form_password';
	const CMPDC_MAIN_FORM_PRODUCT_PITCH							 = 'cmpdc_form_product_pitch';
	const CMPDC_MAIN_FORM_PRODUCT_GALLERY_ID				     = 'cmpdc_form_product_gallery_id';
	const CMPDC_MAIN_FORM_YEAR_FOUNDED							 = 'cmpdc_form_year_founded';
	const CMPDC_MAIN_FORM_VIRTUAL_ADDRESS						 = 'cmpdc_form_virtual_address';
	const CMPDC_MAIN_FORM_ADDRESS								 = 'cmpdc_form_address';
	const CMPDC_MAIN_FORM_CITYTOWN								 = 'cmpdc_form_cityTown';
	const CMPDC_MAIN_FORM_STATECOUNTY							 = 'cmpdc_form_stateCounty';
	const CMPDC_MAIN_FORM_POSTALCODE							 = 'cmpdc_form_postalcode';
	const CMPDC_MAIN_FORM_REGION								 = 'cmpdc_form_region';
	const CMPDC_MAIN_FORM_COUNTRY								 = 'cmpdc_form_country';
	const CMPDC_MAIN_FORM_CATEGORIES							 = 'cmpdc_form_categories';
	const CMPDC_MAIN_FORM_TAGS                                   = 'cmpdc_form_tags';
	const CMPDC_MAIN_FORM_ADD_GOOGLE_MAP						 = 'cmpdc_form_add_google_map';
	const CMPDC_MAIN_FORM_WEB_URL								 = 'cmpdc_form_web_url';
	const CMPDC_MAIN_FORM_BEMAIL								 = 'cmpdc_form_bemail';
	const CMPDC_MAIN_FORM_BEMAIL_CONTACT						 = 'cmpdc_form_bemail_contact';
	const CMPDC_MAIN_FORM_FACEBOOK_NAME							 = 'cmpdc_form_facebook_name';
	const CMPDC_MAIN_FORM_TWITTER_NAME							 = 'cmpdc_form_twitter_name';
	const CMPDC_MAIN_FORM_GOOGLE								 = 'cmpdc_form_google';
	const CMPDC_MAIN_FORM_LINKEDIN								 = 'cmpdc_form_linkedin';
	const CMPDC_MAIN_FORM_RSS									 = 'cmpdc_form_rss';
	const CMPDC_MAIN_FORM_ADD_LINK1								 = 'cmpdc_form_add_link1';
	const CMPDC_MAIN_FORM_ADD_LINK2								 = 'cmpdc_form_add_link2';
	const CMPDC_MAIN_FORM_ADD_LINK3								 = 'cmpdc_form_add_link3';
	const CMPDC_MAIN_FORM_ADD_LINK4								 = 'cmpdc_form_add_link4';
	const CMPDC_MAIN_FORM_ADD_FIELD1								 = 'cmpdc_form_add_field1';
	const CMPDC_MAIN_FORM_ADD_FIELD2								 = 'cmpdc_form_add_field2';
	const CMPDC_MAIN_FORM_ADD_FIELD3								 = 'cmpdc_form_add_field3';
	const CMPDC_MAIN_FORM_ADD_FIELD4								 = 'cmpdc_form_add_field4';
	const CMPDC_MAIN_FORM_PHONE									 = 'cmpdc_form_phone';
	const CMPDC_MAIN_FORM_TITLE									 = 'cmpdc_form_title';
	const CMPDC_MAIN_FORM_DESCRIPTION								 = 'cmpdc_form_description';
	const CMPDC_FORM_MANDATORY_TEXT								 = 'cmpdc_form_mandatory_text';
	const CMPDC_FORM_SHOWHIDE_TEXT								 = 'cmpdc_form_showhide_text';
	const CMPDC_FORM_CLAIM_TEXT									 = 'cmpdc_form_claim_text';
	const CMPDC_FORM_CLAIM_NAME									 = 'cmpdc_form_claim_name';
	const CMPDC_FORM_CLAIM_EMAIL									 = 'cmpdc_form_claim_email';
	const CMPDC_FORM_CLAIM_BUTTON									 = 'cmpdc_form_claim_button';
	const CMPDC_FORM_CLAIM_SUCCESS								 = 'cmpdc_form_claim_success';
	const CMPDC_FORM_CLAIM_FILL_ALL								 = 'cmpdc_form_claim_fill_all';
	const CMPDC_FORM_CLAIM_WARNING								 = 'cmpdc_form_claim_warning';
	const CMPDC_FORM_CLAIM_WRONG_CAPTCHA							 = 'cmpdc_form_claim_wrong_captcha';
	const CMPDC_FORM_CLAIM_PENDING								 = 'cmpdc_form_claim_pending';
	const CMPDC_FORM_RECOVER_TEXT									 = 'cmpdc_form_recover_text';
	const CMPDC_FORM_RECOVER_EMAIL								 = 'cmpdc_form_recover_email';
	const CMPDC_FORM_RECOVER_BUTTON								 = 'cmpdc_form_recover_button';
	const CMPDC_FORM_RECOVER_SUCCESS								 = 'cmpdc_form_recover_success';
	const CMPDC_FORM_RECOVER_FILL_ALL								 = 'cmpdc_form_recover_fill_all';
	const CMPDC_FORM_RECOVER_WARNING								 = 'cmpdc_form_recover_warning';
//Mandatory
	const CMPDC_MAIN_FORM_PRODUCT_PITCH_MANDATORY					 = 'cmpdc_form_product_pitch_mandatory';
	const CMPDC_MAIN_FORM_ADDRESS_MANDATORY						 = 'cmpdc_form_address_mandatory';
	const CMPDC_MAIN_FORM_CITYTOWN_MANDATORY						 = 'cmpdc_form_cityTown_mandatory';
	const CMPDC_MAIN_FORM_STATECOUNTY_MANDATORY					 = 'cmpdc_form_stateCounty_mandatory';
	const CMPDC_MAIN_FORM_POSTALCODE_MANDATORY					 = 'cmpdc_form_postalcode_mandatory';
	const CMPDC_MAIN_FORM_REGION_MANDATORY						 = 'cmpdc_form_region_mandatory';
	const CMPDC_MAIN_FORM_WEB_URL_MANDATORY						 = 'cmpdc_form_web_url_mandatory';
	const CMPDC_MAIN_FORM_BEMAIL_MANDATORY						 = 'cmpdc_form_bemail_mandatory';
	const CMPDC_MAIN_FORM_BEMAIL_CONTACT_MANDATORY				 = 'cmpdc_form_bemail_contact_mandatory';
	const CMPDC_MAIN_FORM_FACEBOOK_NAME_MANDATORY					 = 'cmpdc_form_facebook_name_mandatory';
	const CMPDC_MAIN_FORM_TWITTER_NAME_MANDATORY					 = 'cmpdc_form_twitter_name_mandatory';
	const CMPDC_MAIN_FORM_GOOGLE_MANDATORY						 = 'cmpdc_form_google_mandatory';
	const CMPDC_MAIN_FORM_LINKEDIN_MANDATORY						 = 'cmpdc_form_linkedin_mandatory';
	const CMPDC_MAIN_FORM_RSS_MANDATORY							 = 'cmpdc_form_rss_mandatory';
	const CMPDC_MAIN_FORM_ADD_LINK1_MANDATORY						 = 'cmpdc_form_add_link1_mandatory';
	const CMPDC_MAIN_FORM_ADD_LINK2_MANDATORY						 = 'cmpdc_form_add_link2_mandatory';
	const CMPDC_MAIN_FORM_ADD_LINK3_MANDATORY						 = 'cmpdc_form_add_link3_mandatory';
	const CMPDC_MAIN_FORM_ADD_LINK4_MANDATORY						 = 'cmpdc_form_add_link4_mandatory';
	const CMPDC_MAIN_FORM_ADD_FIELD1_MANDATORY					 = 'cmpdc_form_add_field1_mandatory';
	const CMPDC_MAIN_FORM_ADD_FIELD2_MANDATORY					 = 'cmpdc_form_add_field2_mandatory';
	const CMPDC_MAIN_FORM_ADD_FIELD3_MANDATORY					 = 'cmpdc_form_add_field3_mandatory';
	const CMPDC_MAIN_FORM_ADD_FIELD4_MANDATORY					 = 'cmpdc_form_add_field4_mandatory';
	const CMPDC_MAIN_FORM_PHONE_MANDATORY							 = 'cmpdc_form_phone_mandatory';
	const CMPDC_MAIN_FORM_TITLE_MANDATORY							 = 'cmpdc_form_title_mandatory';
	const CMPDC_MAIN_FORM_DESCRIPTION_MANDATORY					 = 'cmpdc_form_description_mandatory';
//Placecholders
	const CMPDC_MAIN_FORM_PRODUCT_PITCH_PLACECHOLDER				 = 'cmpdc_form_product_pitch_placeholder';
	const CMPDC_MAIN_FORM_PRODUCT_GALLERY_ID_PLACECHOLDER			 = 'cmpdc_form_product_gallery_id_placeholder';
	const CMPDC_MAIN_FORM_YEAR_FOUNDED_PLACECHOLDER				 = 'cmpdc_form_year_founded_placeholder';
	const CMPDC_MAIN_FORM_VIRTUAL_ADDRESS_PLACECHOLDER			 = 'cmpdc_form_virtual_address_placeholder';
	const CMPDC_MAIN_FORM_ADDRESS_PLACECHOLDER					 = 'cmpdc_form_address_placeholder';
	const CMPDC_MAIN_FORM_CITYTOWN_PLACECHOLDER					 = 'cmpdc_form_cityTown_placeholder';
	const CMPDC_MAIN_FORM_STATECOUNTY_PLACECHOLDER				 = 'cmpdc_form_stateCounty_placeholder';
	const CMPDC_MAIN_FORM_POSTALCODE_PLACECHOLDER					 = 'cmpdc_form_postalcode_placeholder';
	const CMPDC_MAIN_FORM_REGION_PLACECHOLDER						 = 'cmpdc_form_region_placeholder';
	const CMPDC_MAIN_FORM_COUNTRY_PLACECHOLDER					 = 'cmpdc_form_country_placeholder';
	const CMPDC_MAIN_FORM_CATEGORIES_PLACECHOLDER					 = 'cmpdc_form_categories_placeholder';
	const CMPDC_MAIN_FORM_ADD_GOOGLE_MAP_PLACECHOLDER				 = 'cmpdc_form_add_google_map_placeholder';
	const CMPDC_MAIN_FORM_WEB_URL_PLACECHOLDER					 = 'cmpdc_form_web_url_placeholder';
	const CMPDC_MAIN_FORM_BEMAIL_PLACECHOLDER						 = 'cmpdc_form_bemail_placeholder';
	const CMPDC_MAIN_FORM_BEMAIL_CONTACT_PLACECHOLDER				 = 'cmpdc_form_bemail_contact_placeholder';
	const CMPDC_MAIN_FORM_FACEBOOK_NAME_PLACECHOLDER				 = 'cmpdc_form_facebook_name_placeholder';
	const CMPDC_MAIN_FORM_TWITTER_NAME_PLACECHOLDER				 = 'cmpdc_form_twitter_name_placeholder';
	const CMPDC_MAIN_FORM_GOOGLE_PLACECHOLDER						 = 'cmpdc_form_google_placeholder';
	const CMPDC_MAIN_FORM_LINKEDIN_PLACECHOLDER					 = 'cmpdc_form_linkedin_placeholder';
	const CMPDC_MAIN_FORM_RSS_PLACECHOLDER						 = 'cmpdc_form_rss_placeholder';
	const CMPDC_MAIN_FORM_ADD_LINK1_PLACEHOLDER					 = 'cmpdc_form_add_link1_placeholder';
	const CMPDC_MAIN_FORM_ADD_LINK2_PLACEHOLDER					 = 'cmpdc_form_add_link2_placeholder';
	const CMPDC_MAIN_FORM_ADD_LINK3_PLACEHOLDER					 = 'cmpdc_form_add_link3_placeholder';
	const CMPDC_MAIN_FORM_ADD_LINK4_PLACEHOLDER					 = 'cmpdc_form_add_link4_placeholder';
	const CMPDC_MAIN_FORM_ADD_FIELD1_PLACEHOLDER					 = 'cmpdc_form_add_field1_placeholder';
	const CMPDC_MAIN_FORM_ADD_FIELD2_PLACEHOLDER					 = 'cmpdc_form_add_field2_placeholder';
	const CMPDC_MAIN_FORM_ADD_FIELD3_PLACEHOLDER					 = 'cmpdc_form_add_field3_placeholder';
	const CMPDC_MAIN_FORM_ADD_FIELD4_PLACEHOLDER					 = 'cmpdc_form_add_field4_placeholder';
	const CMPDC_MAIN_FORM_PHONE_PLACECHOLDER						 = 'cmpdc_form_phone_placeholder';
	const CMPDC_MAIN_FORM_TITLE_PLACECHOLDER						 = 'cmpdc_form_title_placeholder';
	const CMPDC_MAIN_FORM_DESCRIPTION_PLACECHOLDER				 = 'cmpdc_form_description_placeholder';
	const CMPDC_MAIN_FORM_CAPTCHA_TEXT							 = 'cmpdc_form_captcha_text';
	const CMPDC_MAIN_FORM_BUTTON_TEXT								 = 'cmpdc_form_button_text';
	const CMPDC_MAIN_FORM_BUTTON_TEXT_UPDATE						 = 'cmpdc_form_button_text_update';
	const CMPDC_MAIN_FORM_LOGIN_LABEL								 = 'cmpdc_form_login_label';
	const CMPDC_MAIN_FORM_BACK_LABEL								 = 'cmpdc_form_back_label';
	const CMPDC_MAIN_FORM_BUTTON2_TEXT							 = 'cmpdc_form_button2_text';
	const CMPDC_MYPRODUCT_USER_NOTIFICATION_DEFAULT_TEXT			 = 'Status of your product "%s" has been changed from "%s" to "%s".';
	const CMPDC_MYPRODUCT_ACCESS_NOTIFICATION_DEFAULT_TEXT		 = 'The status of the product: "%s" is "%s". Your login: "%s", password: "%s".';
	const COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_TERM			 = '[product]';
	const COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_NEW_STATUS	 = '[new_status]';
	const COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_OLD_STATUS	 = '[old_status]';
	const COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_STATUS		 = '[status]';
	const COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_LOGIN		 = '[login]';
	const COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_PASSWORD	 = '[password]';
	const COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_POST_URL		 = '[url]';
	const COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_ACCEPT_URL		 = '[accept_url]';
	const COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_NAME			 = '[name]';
	const COMMUNITYPRODUCT_EMAIL_NOTIFICATION_TAG_EMAIL			 = '[email]';
	const COMMUNITYPRODUCT_PUBLISH_ALL_MSG						 = '[<strong>CM Product Directory Community Items</strong>] All of the pending products has been published.';
	const COMMUNITYPRODUCT_PUBLISH_TERM_MSG						 = '[<strong>CM Product Directory Community Items</strong>] Selected products has been published.';
	const COMMUNITYPRODUCT_SETTINGS_SAVED							 = 'cmpdc_settings_saved';
	const COMMUNITYPRODUCT_SETTINGS_ERROR_TEXT					 = 'cmpdc_settings_error_text';
	const COMMUNITYPRODUCT_SETTINGS_ERROR_CAPTCHA					 = 'cmpdc_settings_error_captcha';
	const COMMUNITYPRODUCT_SETTINGS_MODERATION					 = 'cmpdc_settings_moderation';
	const COMMUNITYPRODUCT_SETTINGS_PUBLISHED						 = 'cmpdc_settings_published';
	// Product additional taxonomy
	// Pricing model
	const CMPDC_MAIN_FORM_PRICINGMODEL			 = 'cmpdc_form_pricingmodel';
	const CMPDC_MAIN_FORM_PRICINGMODEL_PLACEHOLDER = 'cmpdc_form_pricingmodel_placeholder';
	const CMPDC_MAIN_FORM_PRICINGMODEL_LIMIT		 = 'cmpdc_form_pricingmodel_limit';
	// Language support
	const CMPDC_MAIN_FORM_LANGUAGESUPPORT				 = 'cmpdc_form_languagesupport';
	const CMPDC_MAIN_FORM_LANGUAGESUPPORT_PLACEHOLDER	 = 'cmpdc_form_languagesupport_placeholder';
	const CMPDC_MAIN_FORM_LANGUAGESUPPORT_LIMIT		 = 'cmpdc_form_languagesupport_limit';
	// Target audience
	const CMPDC_MAIN_FORM_TARGETAUDIENCE				 = 'cmpdc_form_targetaudience';
	const CMPDC_MAIN_FORM_TARGETAUDIENCE_PLACEHOLDER	 = 'cmpdc_form_targetaudience_placeholder';
	const CMPDC_MAIN_FORM_TARGETAUDIENCE_LIMIT		 = 'cmpdc_form_targetaudience_limit';
	const CMPDC_MAIN_FORM_VIDEO_URL				 = 'cmpdc_main_form_video_url';
	const CMPDC_MAIN_FORM_VIDEO_URL_PLACEHOLDER	 = 'cmpdc_main_form_video_url_placeholder';
	const CMPDC_MAIN_FORM_VIDEO_URL_MANDATORY		 = 'cmpdc_main_form_video_url_mandatory';
	const CMPDC_MAIN_FORM_COMPANY_NAME			 = 'cmpdc_main_form_company_name';
	const CMPDC_MAIN_FORM_COMPANY_NAME_PLACEHOLDER = 'cmpdc_main_form_company_name_placeholder';
	const CMPDC_MAIN_FORM_COMPANY_NAME_MANDATORY	 = 'cmpdc_main_form_company_name_mandatory';
	const CMPDC_MAIN_FORM_PRODUCT_COST			 = 'cmpdc_main_form_product_cost';
	const CMPDC_MAIN_FORM_PRODUCT_COST_PLACEHOLDER = 'cmpdc_main_form_product_cost_placeholder';
	const CMPDC_MAIN_FORM_PRODUCT_COST_MANDATORY	 = 'cmpdc_main_form_product_cost_mandatory';
	const CMPDC_MAIN_FORM_PURCHASE_LINK				 = 'cmpdc_main_form_purchase_link';
	const CMPDC_MAIN_FORM_PURCHASE_LINK_PLACEHOLDER	 = 'cmpdc_main_form_purchase_link_placeholder';
	const CMPDC_MAIN_FORM_PURCHASE_LINK_MANDATORY		 = 'cmpdc_main_form_purchase_link_mandatory';
	const CMPDC_MAIN_FORM_DEMO_LINK				 = 'cmpdc_main_form_demo_link';
	const CMPDC_MAIN_FORM_DEMO_LINK_PLACEHOLDER	 = 'cmpdc_main_form_demo_link_placeholder';
	const CMPDC_MAIN_FORM_DEMO_LINK_MANDATORY		 = 'cmpdc_main_form_demo_link_mandatory';
	const CMPDC_MAIN_FORM_PAGE_LINK				 = 'cmpdc_main_form_page_link';
	const CMPDC_MAIN_FORM_PAGE_LINK_PLACEHOLDER	 = 'cmpdc_main_form_page_link_placeholder';
	const CMPDC_MAIN_FORM_PAGE_LINK_MANDATORY		 = 'cmpdc_main_form_page_link_mandatory';
	const CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE				 = 'cmpdc_form_add_product_image';
	const CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_TEXT			 = 'cmpdc_form_add_product_image_text';
	const CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_MANDATORY		 = 'cmpdc_form_add_product_image_mandatory';
	const CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_PLACECHOLDER	 = 'cmpdc_form_add_product_image_placeholder';
	const CMPDC_GALLERY_IMAGE_1	 = 'cmpdc_form_add_gallery_image_1';
	const CMPDC_GALLERY_IMAGE_2	 = 'cmpdc_form_add_gallery_image_2';
	const CMPDC_GALLERY_IMAGE_3	 = 'cmpdc_form_add_gallery_image_3';
	const CMPDC_GALLERY_IMAGE_4	 = 'cmpdc_form_add_gallery_image_4';
	const CMPDC_GALLERY_IMAGE_TEXT_1	 = 'cmpdc_form_add_gallery_image_text_1';
	const CMPDC_GALLERY_IMAGE_TEXT_2	 = 'cmpdc_form_add_gallery_image_text_2';
	const CMPDC_GALLERY_IMAGE_TEXT_3	 = 'cmpdc_form_add_gallery_image_text_3';
	const CMPDC_GALLERY_IMAGE_TEXT_4	 = 'cmpdc_form_add_gallery_image_text_4';
    const CMPDC_USER_DASHBOARD_EMPTY_LABEL                         = 'cmpdc_user_dashboard_empty_label';

	public static function init() {
		if ( defined( 'DOING_AJAX' ) ) {
			CMProductDirectoryCommunityProductFrontend::registerAjax();
		}

		// register scripts
		self::registerAdminScripts();
		self::registerAjax();

		add_action( 'add_meta_boxes', array( __CLASS__, 'addMetaBox' ) );
		add_action( 'cmpd_after_save_post', array( __CLASS__, 'saveMetabox' ) );

		//  add_action('cmpd_before_product_page_content',array('CMProductDirectoryCommunityProductFrontend', 'processPostClaim'),10,0);
		add_filter( 'cmpd_thirdparty_option_names', array( __CLASS__, 'addOptionNames' ) );
		//Send current placecholders
		add_filter( 'cmpd_placecholders', array( __CLASS__, 'addPlacecholders' ) );
		//Send default settings
		add_filter( 'cmpd_set_default_option', array( __CLASS__, 'setDefaultSettings' ) );
		// New Tab for myProduct option
		add_filter( 'cmpd-settings-tabs-array', array( __CLASS__, 'addSettingsTab' ) );

		add_filter( 'cmpd_shortcodes_available_html', array( __CLASS__, 'addAvailableShortcodes' ) );
		add_filter( 'cmpd_settings_top_html', array( __CLASS__, 'addAddingPageLink' ) );
	}

	public static function addAddingPageLink( $content ) {
		$shortcodePageId		 = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_ID );
		$shortcodePageLink		 = get_page_link( $shortcodePageId );
		$shortcodePageEditLink	 = admin_url( 'post.php?post=' . $shortcodePageId . '&action=edit' );
		ob_start();
		?>
		<p>
			<strong>Link to the CM Product Directory Community page:</strong>
			<a href="<?php echo esc_attr( $shortcodePageLink ); ?>" target="_blank"><?php echo esc_html( $shortcodePageLink ); ?></a> (<a title="Edit the CM Product Directory Community Page" href="<?php echo esc_attr( $shortcodePageEditLink ); ?>">edit</a>)
		</p>
		<?php
		$additionalContent		 = ob_get_clean();
		$content .= $additionalContent;
		return $content;
	}

	public static function addAvailableShortcodes( $content ) {
		ob_start();
		?>
		<li>Shortcode allowing to add the items - [community_product_form]</li>
		<?php
		$additionalContent = ob_get_clean();
		$content .= $additionalContent;
		return $content;
	}

	/**
	 * Add new Product Directory configuration tab
	 *
	 * @return type
	 */
	public static function addSettingsTab( $tabs ) {
		$tabs[ 'comunity' ]			 = 'Community Product';
		$tabs[ 'comunity-labels' ]	 = 'Community Product Labels';

		add_filter( 'cmpd-custom-settings-tab-content-comunity', array( __CLASS__, 'addSettingsTabContent' ) );
		add_filter( 'cmpd-custom-settings-tab-content-comunity-labels', array( __CLASS__, 'addSettingsTabComunityLabels' ) );
		return $tabs;
	}

	/**
	 * Adds the content to the appropriate settings tab
	 * @return type
	 */
	public static function addSettingsTabContent( $content ) {
		ob_start();

		$data = CMProductDirectoryCommunityProductBackend::getSettings();
		extract( $data );

		require_once CMPDC_PLUGIN_DIR_VIEWS_PATH . 'backend/myProduct_settings.php';
		$content .= ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public static function addSettingsTabComunityLabels( $content ) {
		ob_start();

		$data = CMProductDirectoryCommunityProductBackend::getSettings();
		extract( $data );

		require_once CMPDC_PLUGIN_DIR_VIEWS_PATH . 'backend/myProduct_labels.php';
		$content .= ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public static function getSettings() {
		$settings			 = CMProductDirectoryCommunityProduct::getMyProductSettings();
		$settings[ 'roles' ] = self::getRoles();

		return $settings;
	}

	public static function getRoles() {
		$roles	 = new WP_Roles();
		// Add Anonymous user to the roles array
		$_tmp	 = array_merge( $roles->get_names(), array( 'anonymous' => 'Anonymous' ) );
		asort( $_tmp );

		return $_tmp;
	}

	/**
	 * Register ajax method
	 *
	 */
	public static function registerAjax() {
		add_action( 'wp_ajax_cmpdc_ajax', array( __CLASS__, 'cmpdc_ajax' ) );
	}

	public static function set_login_password( $post_id ) {
		$password	 = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand( 0, 50 ), 1 ) . substr( md5( time() ), 1 );
		$user		 = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand( 0, 50 ), 1 ) . substr( md5( time() ), 1 );
		update_post_meta( $post_id, self::meta_password, $password );
		update_post_meta( $post_id, self::meta_user, $user );
	}

	public static function cmpdc_ajax() {
		if ( !empty( $_POST[ 'form_send_email_login' ] ) ) {
			$post_id = $_POST[ 'form_send_post_id' ];

			self::set_login_password( $post_id );

			$post	 = get_post( $post_id );
			$args	 = array();
			if ( !empty( $post ) && self::notification( $post, $args ) ) {
				echo json_encode( array( 'status' => 'success', 'code'	 => 0,
					'msg'	 => __( 'Login and Password sent correctly', 'cmt_community_product' ) ) );
				exit;
			} else {
				echo json_encode( array( 'status' => 'warning', 'code'	 => 0,
					'msg'	 => __( 'Can\'t send the data', 'cmt_community_product' ) ) );
				exit;
			}
		} else if ( !empty( $_POST[ 'form_erase_claimers' ] ) ) {
			$post_id = $_POST[ 'form_send_post_id' ];
			$post	 = get_post( $post_id );
			if ( !empty( $post ) ) {
				update_post_meta( $post->ID, 'cmpd_bemail_contact_tmp', array() );
				echo json_encode( array( 'status' => 'success', 'code'	 => 0,
					'msg'	 => __( 'Claimer data was erased', 'cmt_community_product' ) ) );
				exit;
			} else {
				echo json_encode( array( 'status' => 'warning', 'code'	 => 0,
					'msg'	 => __( 'Can\'t erase claimer data', 'cmt_community_product' ) ) );
				exit;
			}
		}
	}

	/**
	 * Register enqueue script action.
	 */
	public static function registerAdminScripts() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueueAdminScripts' ) );
	}

	/**
	 * Register JS & CSS scripts.
	 */
	public static function enqueueAdminScripts() {
		wp_enqueue_style( 'product_settings', CMPDC_PLUGIN_DIR_BACKEND_SCRIPT_PATH . 'css/settings.css' );
		wp_enqueue_script( 'cmpdc_ajax_js', CMPDC_PLUGIN_DIR_BACKEND_SCRIPT_PATH . 'js/cmpdc-ajax.js', array( 'jquery' ) );
		self::insert_admin_php_js();
	}

	public static function insert_admin_php_js() {
		$data						 = array();
		$data[ 'ajaxurl' ]			 = admin_url( 'admin-ajax.php' );
		$data[ 'mandatory_text' ]	 = get_option( CMProductDirectoryCommunityProductBackend::CMPDC_FORM_MANDATORY_TEXT );
		wp_localize_script( 'cmpdc_ajax_js', 'cmpdc_data', $data );
	}

	/**
	 * Adds the community product options to the saved options
	 * @return string
	 */
	public static function addOptionNames( $option_names ) {
		$option_names = array_merge( $option_names, array(
			self::COMMUNITYPRODUCT_CAPTCHA,
			self::COMMUNITYPRODUCT_CAPTCHA_KEY,
			self::COMMUNITYPRODUCT_CAPTCHA_PRIVATE_KEY,
			self::COMMUNITYPRODUCT_MODERATION,
			self::COMMUNITYPRODUCT_ALLOW_ROLES,
			self::COMMUNITYPRODUCT_TEXT_UNAUTHORIZED,
			self::COMMUNITYPRODUCT_ADMIN_NOTIFICATION,
			self::COMMUNITYPRODUCT_ADMIN_NOTIFICATION_ADMIN,
			self::COMMUNITYPRODUCT_NOTIFICATION_TEXT,
			self::COMMUNITYPRODUCT_NOTIFICATION_SUBJECT,
			self::COMMUNITYPRODUCT_CLAIM_NOTIFICATION_TEXT,
			self::COMMUNITYPRODUCT_CLAIM_NOTIFICATION_SUBJECT,
			self::COMMUNITYPRODUCT_USER_NOTIFICATION,
			self::COMMUNITYPRODUCT_USER_NOTIFICATION_TEXT,
			self::COMMUNITYPRODUCT_USER_NOTIFICATION_SUBJECT,
			self::COMMUNITYPRODUCT_CLAIM_REJECTED_NOTIFICATION,
			self::COMMUNITYPRODUCT_CLAIM_REJECTED_NOTIFICATION_TEXT,
			self::COMMUNITYPRODUCT_CLAIM_REJECTED_NOTIFICATION_SUBJECT,
			self::COMMUNITYPRODUCT_ACCESS_NOTIFICATION_TEXT,
			self::COMMUNITYPRODUCT_ACCESS_NOTIFICATION_SUBJECT,
			self::COMMUNITYPRODUCT_PANEL_NOTIFICATION,
            self::CMPDC_MAIN_FORM_SHOW_SOCIAL_MEDIA_SECTION,
            self::CMPDC_MAIN_FORM_SHOW_CATEGORIES_AS_CHECKBOXES,
            self::CMPDC_MAIN_FORM_SHOW_TAGS,
			self::CMPDC_MAIN_FORM_USER,
			self::CMPDC_FORM_MANDATORY_TEXT,
			self::CMPDC_FORM_SHOWHIDE_TEXT,
			self::CMPDC_FORM_CLAIM_TEXT,
			self::CMPDC_FORM_CLAIM_NAME,
			self::CMPDC_FORM_CLAIM_EMAIL,
			self::CMPDC_FORM_CLAIM_BUTTON,
			self::CMPDC_FORM_CLAIM_SUCCESS,
			self::CMPDC_FORM_CLAIM_FILL_ALL,
			self::CMPDC_FORM_CLAIM_WARNING,
			self::CMPDC_FORM_CLAIM_WRONG_CAPTCHA,
			self::CMPDC_FORM_CLAIM_PENDING,
			self::CMPDC_FORM_RECOVER_TEXT,
			self::CMPDC_FORM_RECOVER_EMAIL,
			self::CMPDC_FORM_RECOVER_BUTTON,
			self::CMPDC_FORM_RECOVER_SUCCESS,
			self::CMPDC_FORM_RECOVER_FILL_ALL,
			self::CMPDC_FORM_RECOVER_WARNING,
			self::CMPDC_MAIN_FORM_PASSWORD,
			self::CMPDC_MAIN_FORM_PRODUCT_PITCH,
			self::CMPDC_MAIN_FORM_PRODUCT_GALLERY_ID,
			self::CMPDC_MAIN_FORM_YEAR_FOUNDED,
			self::CMPDC_MAIN_FORM_VIRTUAL_ADDRESS,
			self::CMPDC_MAIN_FORM_ADDRESS,
			self::CMPDC_MAIN_FORM_CITYTOWN,
			self::CMPDC_MAIN_FORM_STATECOUNTY,
			self::CMPDC_MAIN_FORM_POSTALCODE,
			self::CMPDC_MAIN_FORM_REGION,
			self::CMPDC_MAIN_FORM_COUNTRY,
			self::CMPDC_MAIN_FORM_CATEGORIES,
            self::CMPDC_MAIN_FORM_TAGS,
			self::CMPDC_MAIN_FORM_ADD_GOOGLE_MAP,
			self::CMPDC_MAIN_FORM_WEB_URL,
			self::CMPDC_MAIN_FORM_BEMAIL,
			self::CMPDC_MAIN_FORM_BEMAIL_CONTACT,
			self::CMPDC_MAIN_FORM_FACEBOOK_NAME,
			self::CMPDC_MAIN_FORM_TWITTER_NAME,
			self::CMPDC_MAIN_FORM_GOOGLE,
			self::CMPDC_MAIN_FORM_LINKEDIN,
			self::CMPDC_MAIN_FORM_RSS,
			self::CMPDC_MAIN_FORM_ADD_LINK1,
			self::CMPDC_MAIN_FORM_ADD_LINK2,
			self::CMPDC_MAIN_FORM_ADD_LINK3,
			self::CMPDC_MAIN_FORM_ADD_LINK4,
			self::CMPDC_MAIN_FORM_ADD_FIELD1,
			self::CMPDC_MAIN_FORM_ADD_FIELD2,
			self::CMPDC_MAIN_FORM_ADD_FIELD3,
			self::CMPDC_MAIN_FORM_ADD_FIELD4,
			self::CMPDC_MAIN_FORM_PHONE,
			self::CMPDC_MAIN_FORM_TITLE,
			self::CMPDC_MAIN_FORM_DESCRIPTION,
			//Mandatory
			self::CMPDC_MAIN_FORM_PRODUCT_PITCH_MANDATORY,
			self::CMPDC_MAIN_FORM_ADDRESS_MANDATORY,
			self::CMPDC_MAIN_FORM_CITYTOWN_MANDATORY,
			self::CMPDC_MAIN_FORM_STATECOUNTY_MANDATORY,
			self::CMPDC_MAIN_FORM_POSTALCODE_MANDATORY,
			self::CMPDC_MAIN_FORM_REGION_MANDATORY,
			self::CMPDC_MAIN_FORM_WEB_URL_MANDATORY,
			self::CMPDC_MAIN_FORM_BEMAIL_MANDATORY,
			self::CMPDC_MAIN_FORM_BEMAIL_CONTACT_MANDATORY,
			self::CMPDC_MAIN_FORM_FACEBOOK_NAME_MANDATORY,
			self::CMPDC_MAIN_FORM_TWITTER_NAME_MANDATORY,
			self::CMPDC_MAIN_FORM_GOOGLE_MANDATORY,
			self::CMPDC_MAIN_FORM_LINKEDIN_MANDATORY,
			self::CMPDC_MAIN_FORM_RSS_MANDATORY,
			self::CMPDC_MAIN_FORM_ADD_LINK1_MANDATORY,
			self::CMPDC_MAIN_FORM_ADD_LINK2_MANDATORY,
			self::CMPDC_MAIN_FORM_ADD_LINK3_MANDATORY,
			self::CMPDC_MAIN_FORM_ADD_LINK4_MANDATORY,
			self::CMPDC_MAIN_FORM_ADD_FIELD1_MANDATORY,
			self::CMPDC_MAIN_FORM_ADD_FIELD2_MANDATORY,
			self::CMPDC_MAIN_FORM_ADD_FIELD3_MANDATORY,
			self::CMPDC_MAIN_FORM_ADD_FIELD4_MANDATORY,
			self::CMPDC_MAIN_FORM_PHONE_MANDATORY,
			self::CMPDC_MAIN_FORM_TITLE_MANDATORY,
			self::CMPDC_MAIN_FORM_DESCRIPTION_MANDATORY,
			//Placecholders
			self::CMPDC_MAIN_FORM_PRODUCT_PITCH_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_PRODUCT_GALLERY_ID_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_YEAR_FOUNDED_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_VIRTUAL_ADDRESS_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_ADDRESS_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_CITYTOWN_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_STATECOUNTY_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_POSTALCODE_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_REGION_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_COUNTRY_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_CATEGORIES_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_ADD_GOOGLE_MAP_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_WEB_URL_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_BEMAIL_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_BEMAIL_CONTACT_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_FACEBOOK_NAME_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_TWITTER_NAME_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_GOOGLE_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_LINKEDIN_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_RSS_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_ADD_LINK1_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_ADD_LINK2_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_ADD_LINK3_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_ADD_LINK4_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_ADD_FIELD1_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_ADD_FIELD2_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_ADD_FIELD3_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_ADD_FIELD4_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_PHONE_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_TITLE_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_DESCRIPTION_PLACECHOLDER,
			self::CMPDC_MAIN_FORM_CAPTCHA_TEXT,
			self::CMPDC_MAIN_FORM_BUTTON_TEXT,
			self::CMPDC_MAIN_FORM_BUTTON_TEXT_UPDATE,
			self::CMPDC_MAIN_FORM_LOGIN_LABEL,
			self::CMPDC_MAIN_FORM_BACK_LABEL,
			self::CMPDC_MAIN_FORM_BUTTON2_TEXT,
			self::CMPDC_MAIN_FORM_PAGE_ID,
			self::CMPDC_MAIN_FORM_PAGE_ID_ON,
			self::CMPDC_MAIN_FORM_CLAIM_ON,
			self::CMPDC_LOGIN_ON_PRODUCT_PAGE,
			self::CMPDC_MAIN_FORM_CLAIM_CAPTCHA,
			self::CMPDC_MAIN_FORM_CLAIM_MULTI_CLAIMS,
			self::CMPDC_MAIN_FORM_RECOVER_ON,
			self::CMPDC_MAIN_FORM_CATEGORIES_LIMIT,
			self::COMMUNITYPRODUCT_SETTINGS_SAVED,
			self::COMMUNITYPRODUCT_SETTINGS_ERROR_TEXT,
			self::COMMUNITYPRODUCT_SETTINGS_ERROR_CAPTCHA,
			self::COMMUNITYPRODUCT_SETTINGS_MODERATION,
			self::COMMUNITYPRODUCT_SETTINGS_PUBLISHED,
			self::CMPDC_MAIN_FORM_PRICINGMODEL,
			self::CMPDC_MAIN_FORM_PRICINGMODEL_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_LANGUAGESUPPORT,
			self::CMPDC_MAIN_FORM_LANGUAGESUPPORT_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_TARGETAUDIENCE,
			self::CMPDC_MAIN_FORM_TARGETAUDIENCE_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_VIDEO_URL,
			self::CMPDC_MAIN_FORM_VIDEO_URL_MANDATORY,
			self::CMPDC_MAIN_FORM_VIDEO_URL_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_PRODUCT_COST,
			self::CMPDC_MAIN_FORM_PRODUCT_COST_MANDATORY,
			self::CMPDC_MAIN_FORM_PRODUCT_COST_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_PURCHASE_LINK,
			self::CMPDC_MAIN_FORM_PURCHASE_LINK_MANDATORY,
			self::CMPDC_MAIN_FORM_PURCHASE_LINK_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_PAGE_LINK,
			self::CMPDC_MAIN_FORM_PAGE_LINK_MANDATORY,
			self::CMPDC_MAIN_FORM_PAGE_LINK_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_DEMO_LINK,
			self::CMPDC_MAIN_FORM_DEMO_LINK_MANDATORY,
			self::CMPDC_MAIN_FORM_DEMO_LINK_PLACEHOLDER,
			self::CMPDC_MAIN_FORM_COMPANY_NAME,
			self::CMPDC_MAIN_FORM_COMPANY_NAME_MANDATORY,
			self::CMPDC_MAIN_FORM_COMPANY_NAME_PLACEHOLDER,
			self::CMPDC_OPTION_GALLERY_IMAGE_1,
			self::CMPDC_OPTION_GALLERY_IMAGE_TEXT_1,
			self::CMPDC_OPTION_GALLERY_IMAGE_2,
			self::CMPDC_OPTION_GALLERY_IMAGE_TEXT_2,
			self::CMPDC_OPTION_GALLERY_IMAGE_3,
			self::CMPDC_OPTION_GALLERY_IMAGE_TEXT_3,
			self::CMPDC_OPTION_GALLERY_IMAGE_4,
			self::CMPDC_OPTION_GALLERY_IMAGE_TEXT_4,
			self::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE,
			self::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_MANDATORY,
			self::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_PLACECHOLDER,
			self::CMPDC_GALLERY_IMAGE_1,
			self::CMPDC_GALLERY_IMAGE_2,
			self::CMPDC_GALLERY_IMAGE_3,
			self::CMPDC_GALLERY_IMAGE_4,
			self::CMPDC_GALLERY_IMAGE_TEXT_1,
			self::CMPDC_GALLERY_IMAGE_TEXT_2,
			self::CMPDC_GALLERY_IMAGE_TEXT_3,
			self::CMPDC_GALLERY_IMAGE_TEXT_4,
            self::CMPDC_USER_DASHBOARD_EMPTY_LABEL,
		)
		);
		return $option_names;
	}

	/*
	 * Send current placecholders settings to e.g product directory prometabox
	 */

	public static function addPlacecholders( $placecholders ) {
		$placecholders2 = array(
			'form_product_pitch_placeholder'		 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRODUCT_PITCH_PLACECHOLDER ),
			'form_add_product_image_placeholder'	 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_PLACECHOLDER ),
			'form_product_gallery_id_placeholder'	 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRODUCT_GALLERY_ID_PLACECHOLDER ),
			'form_year_founded_placeholder'			 => CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_DEFAULT_YEAR ),
			'form_address_placeholder'				 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADDRESS_PLACECHOLDER ),
			'form_cityTown_placeholder'				 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_CITYTOWN_PLACECHOLDER ),
			'form_stateCounty_placeholder'			 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_STATECOUNTY_PLACECHOLDER ),
			'form_postalcode_placeholder'			 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_POSTALCODE_PLACECHOLDER ),
			'form_region_placeholder'				 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_REGION_PLACECHOLDER ),
			'form_country_placeholder'				 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_COUNTRY_PLACECHOLDER ),
			'form_add_google_map_placeholder'		 => (defined( 'CMPD_Settings::OPTION_PRODUCT_DEFAULT_MAP' )) ? CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_DEFAULT_MAP ) : FALSE,
			'form_web_url_placeholder'				 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_WEB_URL_PLACECHOLDER ),
			'form_bemail_placeholder'				 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BEMAIL_PLACECHOLDER ),
			'form_bemail_contact_placeholder'		 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_BEMAIL_CONTACT_PLACECHOLDER ),
			'form_facebook_name_placeholder'		 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_FACEBOOK_NAME_PLACECHOLDER ),
			'form_twitter_name_placeholder'			 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_TWITTER_NAME_PLACECHOLDER ),
			'form_google_placeholder'				 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_GOOGLE_PLACECHOLDER ),
			'form_linkedin_placeholder'				 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_LINKEDIN_PLACECHOLDER ),
			'form_rss_placeholder'					 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_RSS_PLACECHOLDER ),
			'form_add_link1_placeholder'			 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK1_PLACEHOLDER ),
			'form_add_link2_placeholder'			 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK2_PLACEHOLDER ),
			'form_add_link3_placeholder'			 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK3_PLACEHOLDER ),
			'form_add_link4_placeholder'			 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_LINK4_PLACEHOLDER ),
			'form_add_field1_placeholder'			 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD1_PLACEHOLDER ),
			'form_add_field2_placeholder'			 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD2_PLACEHOLDER ),
			'form_add_field3_placeholder'			 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD3_PLACEHOLDER ),
			'form_add_field4_placeholder'			 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_ADD_FIELD4_PLACEHOLDER ),
			'form_phone_placeholder'				 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PHONE_PLACECHOLDER ),
			'form_title_placeholder'				 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_TITLE_PLACECHOLDER ),
			'form_description_placeholder'			 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_DESCRIPTION_PLACECHOLDER ),
			'form_video_url_placeholder'	 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_VIDEO_URL_PLACEHOLDER ),
			'form_product_cost_placeholder'	 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PRODUCT_COST_PLACEHOLDER ),
			'form_purchase_link_placeholder' => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PURCHASE_LINK_PLACEHOLDER ),
			'form_demo_link_placeholder'	 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_LINK_PLACEHOLDER ),
			'form_page_link_placeholder'	 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_DEMO_LINK_PLACEHOLDER ),
			'form_company_name_placeholder'	 => get_option( CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_COMPANY_NAME_PLACEHOLDER ),
		);
		return array_merge( $placecholders, $placecholders2 );
		;
	}

	/**
	 * Set default values for the form labels
	 */
	public static function setDefaultLabelsValues() {
		add_option( self::CMPDC_MAIN_FORM_USER, __( 'Login', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_PASSWORD, __( 'Password', 'cmt_community_product' ) );

		add_option( self::CMPDC_FORM_MANDATORY_TEXT, __( 'Please fill in all mandatory fields.', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_SHOWHIDE_TEXT, __( 'Show/hide', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_CLAIM_TEXT, __( 'Claim this product', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_CLAIM_NAME, __( 'Name', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_CLAIM_EMAIL, __( 'Email', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_CLAIM_BUTTON, __( 'Claim', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_CLAIM_SUCCESS, __( 'Your claim is in process', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_CLAIM_FILL_ALL, __( 'You need to fill in all the mandatory fields', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_CLAIM_WARNING, __( 'Something went wrong, please try again', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_CLAIM_WRONG_CAPTCHA, __( 'The Captcha was invalid, please try again', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_CLAIM_PENDING, __( 'The Product claim has been filled. Awaiting moderation.', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_RECOVER_TEXT, __( 'Recover login and password', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_RECOVER_EMAIL, __( 'Email', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_RECOVER_BUTTON, __( 'Recover', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_RECOVER_SUCCESS, __( 'Your request is in process', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_RECOVER_FILL_ALL, __( 'You need to fill in all the mandatory fields', 'cmt_community_product' ) );
		add_option( self::CMPDC_FORM_RECOVER_WARNING, __( 'Wrong email', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_PRODUCT_PITCH, __( 'Product Pitch', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_PRODUCT_GALLERY_ID, 'id' );
		add_option( self::CMPDC_MAIN_FORM_YEAR_FOUNDED, __( 'Year founded', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_VIRTUAL_ADDRESS, __( 'Virtual address', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_ADDRESS, __( 'Address', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_CITYTOWN, __( 'City/Town', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_STATECOUNTY, __( 'State/County', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_POSTALCODE, __( 'Zip code', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_REGION, __( 'Region', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_COUNTRY, __( 'Country', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_CATEGORIES, __( 'Category', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_TAGS, __( 'Tags', 'cmt_community_business' ) );
		add_option( self::CMPDC_MAIN_FORM_ADD_GOOGLE_MAP, __( 'Google Map', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_WEB_URL, __( 'URL', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_BEMAIL, __( 'Product e-mail', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_BEMAIL_CONTACT, __( 'Contact e-mail', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_FACEBOOK_NAME, __( 'Facebook', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_TWITTER_NAME, __( 'Twitter', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_GOOGLE, __( 'Product Pitch', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_LINKEDIN, __( 'LinkedIn', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_RSS, __( 'RSS', 'cmt_community_product' ) );

		add_option( self::CMPDC_MAIN_FORM_ADD_LINK1, 'Additional Link 1' );
		add_option( self::CMPDC_MAIN_FORM_ADD_LINK2, 'Additional Link 2' );
		add_option( self::CMPDC_MAIN_FORM_ADD_LINK3, 'Additional Link 3' );
		add_option( self::CMPDC_MAIN_FORM_ADD_LINK4, 'Additional Link 4' );

		add_option( self::CMPDC_MAIN_FORM_ADD_FIELD1, 'Additional text field 1' );
		add_option( self::CMPDC_MAIN_FORM_ADD_FIELD2, 'Additional text field 2' );
		add_option( self::CMPDC_MAIN_FORM_ADD_FIELD3, 'Additional text field 3' );
		add_option( self::CMPDC_MAIN_FORM_ADD_FIELD4, 'Additional text field 4' );

		add_option( self::CMPDC_MAIN_FORM_PHONE, __( 'Phone', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_TITLE, __( 'Title', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_DESCRIPTION, __( 'Description', 'cmt_community_product' ) );
		//Mandatory
		add_option( self::CMPDC_MAIN_FORM_PRODUCT_PITCH_MANDATORY, 1 );
		add_option( self::CMPDC_MAIN_FORM_ADDRESS_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_CITYTOWN_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_STATECOUNTY_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_POSTALCODE_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_REGION_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_WEB_URL_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_BEMAIL_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_BEMAIL_CONTACT_MANDATORY, 1 );
		add_option( self::CMPDC_MAIN_FORM_FACEBOOK_NAME_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_TWITTER_NAME_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_GOOGLE_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_LINKEDIN_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_RSS_MANDATORY, 0 );

		add_option( self::CMPDC_MAIN_FORM_ADD_LINK1_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_ADD_LINK2_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_ADD_LINK3_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_ADD_LINK4_MANDATORY, 0 );

		add_option( self::CMPDC_MAIN_FORM_ADD_FIELD1_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_ADD_FIELD2_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_ADD_FIELD3_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_ADD_FIELD4_MANDATORY, 0 );

		add_option( self::CMPDC_MAIN_FORM_PHONE_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_TITLE_MANDATORY, 1 );
		add_option( self::CMPDC_MAIN_FORM_DESCRIPTION_MANDATORY, 1 );

		//Placecholders
		add_option( self::CMPDC_MAIN_FORM_PRODUCT_PITCH_PLACECHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_PRODUCT_GALLERY_ID_PLACECHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_YEAR_FOUNDED_PLACECHOLDER, __( '2015', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_VIRTUAL_ADDRESS_PLACECHOLDER, 0 );
		add_option( self::CMPDC_MAIN_FORM_ADDRESS_PLACECHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_CITYTOWN_PLACECHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_STATECOUNTY_PLACECHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_POSTALCODE_PLACECHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_REGION_PLACECHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_COUNTRY_PLACECHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_CATEGORIES_PLACECHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_ADD_GOOGLE_MAP_PLACECHOLDER, 1 );
		add_option( self::CMPDC_MAIN_FORM_WEB_URL_PLACECHOLDER, 'https://www.your_company_site.com' );
		add_option( self::CMPDC_MAIN_FORM_BEMAIL_PLACECHOLDER, 'email@company-domain.com' );
		add_option( self::CMPDC_MAIN_FORM_BEMAIL_CONTACT_PLACECHOLDER, 'email@company-domain.com' );
		add_option( self::CMPDC_MAIN_FORM_FACEBOOK_NAME_PLACECHOLDER, 'https://www.facebook.com/your_company_name' );
		add_option( self::CMPDC_MAIN_FORM_TWITTER_NAME_PLACECHOLDER, 'https://www.twitter.com/your_company_name/' );
		add_option( self::CMPDC_MAIN_FORM_GOOGLE_PLACECHOLDER, 'https://www.plus.google.com/your_company_name/' );
		add_option( self::CMPDC_MAIN_FORM_LINKEDIN_PLACECHOLDER, 'https://www.linkedin.com/company/your_company_name/' );
		add_option( self::CMPDC_MAIN_FORM_RSS_PLACECHOLDER, 'https://www.your_company_site.com/your_company_rss.xml' );

		add_option( self::CMPDC_MAIN_FORM_ADD_LINK1_PLACEHOLDER, 'https://www.your_link.com/' );
		add_option( self::CMPDC_MAIN_FORM_ADD_LINK2_PLACEHOLDER, 'https://www.your_link.com/' );
		add_option( self::CMPDC_MAIN_FORM_ADD_LINK3_PLACEHOLDER, 'https://www.your_link.com/' );
		add_option( self::CMPDC_MAIN_FORM_ADD_LINK4_PLACEHOLDER, 'https://www.your_link.com/' );

		add_option( self::CMPDC_MAIN_FORM_ADD_FIELD1_PLACEHOLDER, 'Additional text' );
		add_option( self::CMPDC_MAIN_FORM_ADD_FIELD2_PLACEHOLDER, 'Additional text' );
		add_option( self::CMPDC_MAIN_FORM_ADD_FIELD3_PLACEHOLDER, 'Additional text' );
		add_option( self::CMPDC_MAIN_FORM_ADD_FIELD4_PLACEHOLDER, 'Additional text' );

		add_option( self::CMPDC_MAIN_FORM_PHONE_PLACECHOLDER, '(XXX)-XXX-XXXX' );
		add_option( self::CMPDC_MAIN_FORM_TITLE_PLACECHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_DESCRIPTION_PLACECHOLDER, '' );

		add_option( self::CMPDC_MAIN_FORM_CAPTCHA_TEXT, __( 'Captcha', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_BUTTON_TEXT, __( 'Suggest a product', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_BUTTON_TEXT_UPDATE, __( 'Update', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_LOGIN_LABEL, __( 'Login and Edit', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_BACK_LABEL, __( 'Return', 'cmt_community_product' ) );

		add_option( self::CMPDC_MAIN_FORM_BUTTON2_TEXT, __( 'Login', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_PAGE_ID_ON, 1 );
		add_option( self::CMPDC_MAIN_FORM_CLAIM_ON, 1 );
		add_option( self::CMPDC_LOGIN_ON_PRODUCT_PAGE, 1 );
		add_option( self::CMPDC_MAIN_FORM_CLAIM_CAPTCHA, 1 );
		add_option( self::CMPDC_MAIN_FORM_CLAIM_MULTI_CLAIMS, 1 );
		add_option( self::CMPDC_MAIN_FORM_RECOVER_ON, 1 );

		add_option( self::CMPDC_MAIN_FORM_CATEGORIES_LIMIT, 10 );

		add_option( self::COMMUNITYPRODUCT_NOTIFICATION_TEXT, __( 'New product: [product] has been added to the products.', 'cmt_community_product' ) );
		add_option( self::COMMUNITYPRODUCT_CLAIM_NOTIFICATION_TEXT, __( 'Product: [product] (url: [url]) is claimed by [name] : [email]. To accept click the link [accept_url].', 'cmt_community_product' ) );

		add_option( self::COMMUNITYPRODUCT_USER_NOTIFICATION_TEXT, __( 'The status of the product: [product] has been changed from [old_status] to [new_status].', 'cmt_community_product' ) );
		add_option( self::COMMUNITYPRODUCT_CLAIM_REJECTED_NOTIFICATION_TEXT, __( 'Your claim of the [product] (url: [url]) has been rejected.', 'cmt_community_product' ) );
		add_option( self::COMMUNITYPRODUCT_ACCESS_NOTIFICATION_TEXT, __( 'The status of the product: [product] is [status].If you want you can update your product on the site please check this URL: [url]. Your login: [login], password: [password]', 'cmt_community_product' ) );
		add_option( self::COMMUNITYPRODUCT_ACCESS_NOTIFICATION_SUBJECT, __( 'Your product [product] is updated', 'cmt_community_product' ) );

		add_option( self::COMMUNITYPRODUCT_SETTINGS_SAVED, __( 'Product has been saved.', 'cmt_community_product' ) );
		add_option( self::COMMUNITYPRODUCT_SETTINGS_ERROR_TEXT, __( 'Wrong title or description.', 'cmt_community_product' ) );
		add_option( self::COMMUNITYPRODUCT_SETTINGS_ERROR_CAPTCHA, __( 'Wrong Captcha.', 'cmt_community_product' ) );
		add_option( self::COMMUNITYPRODUCT_SETTINGS_MODERATION, __( 'Waiting for moderation.', 'cmt_community_product' ) );
		add_option( self::COMMUNITYPRODUCT_SETTINGS_PUBLISHED, __( 'Product is published.', 'cmt_community_product' ) );

		add_option( self::CMPDC_MAIN_FORM_PRICINGMODEL, __( 'Pricing Model', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_PRICINGMODEL_PLACEHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_PRICINGMODEL_LIMIT, 10 );

		add_option( self::CMPDC_MAIN_FORM_LANGUAGESUPPORT, __( 'Language Support', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_LANGUAGESUPPORT_PLACEHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_LANGUAGESUPPORT_LIMIT, 10 );

		add_option( self::CMPDC_MAIN_FORM_TARGETAUDIENCE, __( 'Target Audience', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_TARGETAUDIENCE_PLACEHOLDER, '' );
		add_option( self::CMPDC_MAIN_FORM_TARGETAUDIENCE_LIMIT, 10 );

		add_option( self::CMPDC_MAIN_FORM_VIDEO_URL, __( 'Video URL', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_PRODUCT_COST, __( 'Product cost', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_PURCHASE_LINK, __( 'Product page link', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_PAGE_LINK, __( 'Product demo link', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_DEMO_LINK, __( 'Product purchase link', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_COMPANY_NAME, __( 'Company name', 'cmt_community_product' ) );

		add_option( self::CMPDC_MAIN_FORM_VIDEO_URL_PLACEHOLDER, 'http://www.youtube.com/embed/12345' );
		add_option( self::CMPDC_MAIN_FORM_PRODUCT_COST_PLACEHOLDER, __( '$20 - $100', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_PURCHASE_LINK_PLACEHOLDER, 'http://www.product-page.com/' );
		add_option( self::CMPDC_MAIN_FORM_PAGE_LINK_PLACEHOLDER, 'http://www.product-demo.com/' );
		add_option( self::CMPDC_MAIN_FORM_DEMO_LINK_PLACEHOLDER, 'http://www.purchase-product.com/' );
		add_option( self::CMPDC_MAIN_FORM_COMPANY_NAME_PLACEHOLDER, __( 'Company name', 'cmt_community_product' ) );

		add_option( self::CMPDC_MAIN_FORM_VIDEO_URL_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_PRODUCT_COST_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_PURCHASE_LINK_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_PAGE_LINK_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_DEMO_LINK_MANDATORY, 0 );
		add_option( self::CMPDC_MAIN_FORM_COMPANY_NAME_MANDATORY, 0 );

		add_option( self::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE, __( 'Add Image', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_TEXT, __( 'Please choose your product logo', 'cmt_community_product' ) );
		add_option( self::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_MANDATORY, 1 );
		add_option( self::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_PLACECHOLDER, '' );

		add_option( self::CMPDC_GALLERY_IMAGE_1, __( 'Add an image', 'cmt_community_product' ) );
		add_option( self::CMPDC_GALLERY_IMAGE_2, __( 'Add an image', 'cmt_community_product' ) );
		add_option( self::CMPDC_GALLERY_IMAGE_3, __( 'Add an image', 'cmt_community_product' ) );
		add_option( self::CMPDC_GALLERY_IMAGE_4, __( 'Add an image', 'cmt_community_product' ) );
		add_option( self::CMPDC_USER_DASHBOARD_EMPTY_LABEL, __( 'You have no submited products yet. Please suggest %s.', 'cmt_community_product' ) );
	}

	public static function setDefaultSettings( $options ) {
		$options2 = array(
			self::CMPDC_MAIN_FORM_USER				 => __( 'Login', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PASSWORD			 => __( 'Password', 'cmt_community_product' ),
			self::CMPDC_FORM_MANDATORY_TEXT			 => __( 'Please fill in all mandatory fields.', 'cmt_community_product' ),
			self::CMPDC_FORM_SHOWHIDE_TEXT			 => __( 'Show/hide', 'cmt_community_product' ),
			self::CMPDC_FORM_CLAIM_TEXT				 => __( 'Claim this product', 'cmt_community_product' ),
			self::CMPDC_FORM_CLAIM_NAME				 => __( 'Name', 'cmt_community_product' ),
			self::CMPDC_FORM_CLAIM_EMAIL			 => __( 'Email', 'cmt_community_product' ),
			self::CMPDC_FORM_CLAIM_BUTTON			 => __( 'Claim', 'cmt_community_product' ),
			self::CMPDC_FORM_CLAIM_SUCCESS			 => __( 'Your claim is in process', 'cmt_community_product' ),
			self::CMPDC_FORM_CLAIM_FILL_ALL			 => __( 'You need to fill in all the mandatory fields', 'cmt_community_product' ),
			self::CMPDC_FORM_CLAIM_WARNING			 => __( 'Something went wrong, please try again', 'cmt_community_product' ),
			self::CMPDC_FORM_CLAIM_WRONG_CAPTCHA	 => __( 'The Captcha was invalid, please try again', 'cmt_community_product' ),
			self::CMPDC_FORM_CLAIM_PENDING			 => __( 'The Product claim has been filled. Awaiting moderation.', 'cmt_community_product' ),
			self::CMPDC_FORM_RECOVER_TEXT			 => __( 'Recover login and password', 'cmt_community_product' ),
			self::CMPDC_FORM_RECOVER_EMAIL			 => __( 'Email', 'cmt_community_product' ),
			self::CMPDC_FORM_RECOVER_BUTTON			 => __( 'Recover', 'cmt_community_product' ),
			self::CMPDC_FORM_RECOVER_SUCCESS		 => __( 'Your request is in process', 'cmt_community_product' ),
			self::CMPDC_FORM_RECOVER_FILL_ALL		 => __( 'You need to fill in all the mandatory fields', 'cmt_community_product' ),
			self::CMPDC_FORM_RECOVER_WARNING		 => __( 'Wrong email', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PRODUCT_PITCH		 => __( 'Product Pitch', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PRODUCT_GALLERY_ID => __( 'id', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_YEAR_FOUNDED		 => __( 'Year founded', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_VIRTUAL_ADDRESS	 => __( 'Virtual address', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADDRESS			 => __( 'Address', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_CITYTOWN			 => __( 'City/Town', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_STATECOUNTY		 => __( 'State/County', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_POSTALCODE		 => __( 'Postalcode', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_REGION			 => __( 'Region', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_COUNTRY			 => __( 'Country', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_CATEGORIES		 => __( 'Categories', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_TAGS               => __( 'Tags', 'cmt_community_business' ),
            self::CMPDC_MAIN_FORM_ADD_GOOGLE_MAP	 => __( 'Google Map', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_WEB_URL			 => __( 'Web/URL', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_BEMAIL			 => __( 'Product e-mail', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_BEMAIL_CONTACT	 => __( 'Contact e-mail', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_FACEBOOK_NAME		 => __( 'Facebook', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_TWITTER_NAME		 => __( 'Twitter', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_GOOGLE			 => __( 'Google+', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_LINKEDIN			 => __( 'LinkedIn', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_RSS				 => __( 'RSS', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_LINK1	 => __( 'Additional Link 1', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_LINK2	 => __( 'Additional Link 2', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_LINK3	 => __( 'Additional Link 3', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_LINK4	 => __( 'Additional Link 4', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_FIELD1 => __( 'Additional text Field 1', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_FIELD2 => __( 'Additional text Field 2', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_FIELD3 => __( 'Additional text Field 3', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_FIELD4 => __( 'Additional text Field 4', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PHONE								 => __( 'Phone', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_TITLE								 => __( 'Title', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_DESCRIPTION						 => __( 'Description', 'cmt_community_product' ),
			//Placecholders
			self::CMPDC_MAIN_FORM_PRODUCT_PITCH_PLACECHOLDER		 => __( '', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PRODUCT_GALLERY_ID_PLACECHOLDER	 => __( '', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_YEAR_FOUNDED_PLACECHOLDER			 => __( '2015', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_VIRTUAL_ADDRESS_PLACECHOLDER		 => __( '0', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADDRESS_PLACECHOLDER				 => __( '', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_CITYTOWN_PLACECHOLDER				 => __( '', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_STATECOUNTY_PLACECHOLDER			 => __( '', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_POSTALCODE_PLACECHOLDER			 => __( '', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_REGION_PLACECHOLDER				 => __( '', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_COUNTRY_PLACECHOLDER				 => __( '', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_GOOGLE_MAP_PLACECHOLDER		 => __( '1', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_WEB_URL_PLACECHOLDER				 => __( 'https://www.your_company_site.com', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_BEMAIL_PLACECHOLDER				 => __( 'email@company-domain.com', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_BEMAIL_CONTACT_PLACECHOLDER		 => __( 'email@company-domain.com', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_FACEBOOK_NAME_PLACECHOLDER		 => __( 'https://www.facebook.com/your_company_name/', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_TWITTER_NAME_PLACECHOLDER			 => __( 'https://www.twitter.com/your_company_name/', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_GOOGLE_PLACECHOLDER				 => __( 'https://www.plus.google.com/your_company_name/', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_LINKEDIN_PLACECHOLDER				 => __( 'https://www.linkedin.com/company/your_company_name/', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_RSS_PLACECHOLDER					 => __( 'https://www.your_company_site.com/your_company_rss.xml', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_LINK1_PLACEHOLDER	 => __( 'https://www.your_link.com/', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_LINK2_PLACEHOLDER	 => __( 'https://www.your_link.com/', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_LINK3_PLACEHOLDER	 => __( 'https://www.your_link.com/', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_LINK4_PLACEHOLDER	 => __( 'https://www.your_link.com/', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_FIELD1_PLACEHOLDER => __( 'Additional text 1', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_FIELD2_PLACEHOLDER => __( 'Additional text 2', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_FIELD3_PLACEHOLDER => __( 'Additional text 3', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_FIELD4_PLACEHOLDER => __( 'Additional text 4', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PHONE_PLACECHOLDER				 => __( '(XXX)-XXX-XXXX', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_TITLE_PLACECHOLDER				 => __( '', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_DESCRIPTION_PLACECHOLDER			 => __( '', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_CAPTCHA_TEXT						 => __( 'Captcha', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_BUTTON_TEXT						 => __( 'Suggest a product', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_BUTTON_TEXT_UPDATE				 => __( 'Update', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_LOGIN_LABEL						 => __( 'Login and Edit', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_BACK_LABEL						 => __( 'Return', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_BUTTON2_TEXT						 => __( 'Login', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PAGE_ID_ON						 => __( 1, 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_CLAIM_ON							 => __( 1, 'cmt_community_product' ),
			self::CMPDC_LOGIN_ON_PRODUCT_PAGE						 => 1,
			self::CMPDC_MAIN_FORM_CLAIM_CAPTCHA						 => 1,
			self::CMPDC_MAIN_FORM_CLAIM_MULTI_CLAIMS				 => 1,
			self::CMPDC_MAIN_FORM_RECOVER_ON						 => __( 1, 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_CATEGORIES_LIMIT					 => __( 10, 'cmt_community_product' ),
			self::COMMUNITYPRODUCT_NOTIFICATION_TEXT				 => __( 'New product: [product] has been added to the products.', 'cmt_community_product' ),
			self:: COMMUNITYPRODUCT_CLAIM_NOTIFICATION_TEXT			 => __( 'Product: [product] is claimed by [name] : [email]. To accept click the link [accept_url].', 'cmt_community_product' ),
			self:: COMMUNITYPRODUCT_USER_NOTIFICATION_TEXT			 => __( 'The status of the product: [product] has been changed from [old_status] to [new_status].', 'cmt_community_product' ),
			self:: COMMUNITYPRODUCT_CLAIM_REJECTED_NOTIFICATION_TEXT => __( 'Your claim of the [product] (url: [url]) has been rejected.', 'cmt_community_product' ),
			self:: COMMUNITYPRODUCT_ACCESS_NOTIFICATION_TEXT		 => __( 'The status of the product: [product] is [status]. If you want you can update your product on site please check this URL: [url]. Your login: [login], password: [password]', 'cmt_community_product' ),
			self:: COMMUNITYPRODUCT_ACCESS_NOTIFICATION_SUBJECT		 => __( 'Your product [product] is updated', 'cmt_community_product' ),
			self:: COMMUNITYPRODUCT_SETTINGS_SAVED					 => __( 'Product has been saved.', 'cmt_community_product' ),
			self:: COMMUNITYPRODUCT_SETTINGS_ERROR_TEXT				 => __( 'Wrong title or description.', 'cmt_community_product' ),
			self:: COMMUNITYPRODUCT_SETTINGS_ERROR_CAPTCHA			 => __( 'Wrong Captcha.', 'cmt_community_product' ),
			self:: COMMUNITYPRODUCT_SETTINGS_MODERATION				 => __( 'Waiting for moderation.', 'cmt_community_product' ),
			self:: COMMUNITYPRODUCT_SETTINGS_PUBLISHED				 => __( 'Product is published.', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PRICINGMODEL				 => __( 'Pricing Model', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PRICINGMODEL_PLACEHOLDER	 => '$20 - $100',
			self::CMPDC_MAIN_FORM_LANGUAGESUPPORT				 => __( 'Language Support', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_LANGUAGESUPPORT_PLACEHOLDER	 => __( 'E.g. English', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_TARGETAUDIENCE			 => __( 'Target Audience', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_TARGETAUDIENCE_PLACEHOLDER => __( 'E.g. Developers', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_VIDEO_URL		 => __( 'Video URL', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PRODUCT_COST	 => __( 'Product cost', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PURCHASE_LINK	 => __( 'Product page link', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PAGE_LINK		 => __( 'Product demo link', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_DEMO_LINK		 => __( 'Product purchase link', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_COMPANY_NAME	 => __( 'Company name', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_VIDEO_URL_PLACEHOLDER		 => 'http://www.youtube.com/embed/12345',
			self::CMPDC_MAIN_FORM_PRODUCT_COST_PLACEHOLDER	 => __( '$20 - $100', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_PURCHASE_LINK_PLACEHOLDER	 => 'http://www.product-page.com/',
			self::CMPDC_MAIN_FORM_PAGE_LINK_PLACEHOLDER		 => 'http://www.product-demo.com/',
			self::CMPDC_MAIN_FORM_DEMO_LINK_PLACEHOLDER		 => 'http://www.purchase-product.com/',
			self::CMPDC_MAIN_FORM_COMPANY_NAME_PLACEHOLDER	 => __( 'Company name', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE				 => __( 'Add Image', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_TEXT		 => __( '', 'cmt_community_product' ),
			self::CMPDC_MAIN_FORM_ADD_PRODUCT_IMAGE_PLACECHOLDER => __( '', 'cmt_community_product' ),
			self::CMPDC_GALLERY_IMAGE_1	 => __( 'Add an image', 'cmt_community_product' ),
			self::CMPDC_GALLERY_IMAGE_2	 => __( 'Add an image', 'cmt_community_product' ),
			self::CMPDC_GALLERY_IMAGE_3	 => __( 'Add an image', 'cmt_community_product' ),
			self::CMPDC_GALLERY_IMAGE_4	 => __( 'Add an image', 'cmt_community_product' ),
			self::CMPDC_USER_DASHBOARD_EMPTY_LABEL	 => __( 'You have no submited products yet. Please suggest %s.', 'cmt_community_product' ),
			// form parts
			self::CMPDC_MAIN_FORM_SHOW_SOCIAL_MEDIA_SECTION           => '1',
			self::CMPDC_MAIN_FORM_SHOW_CATEGORIES_AS_CHECKBOXES       => '0',
			self::CMPDC_MAIN_FORM_SHOW_TAGS                           => '0',
        );
		return array_merge( $options, $options2 );
	}

	private static function getPostCount() {
		$result	 = wp_count_posts( 'cm-product' );
		$result	 = (!empty( $result->pending )) ? $result->pending : false;
		return $result;
	}

	public static function getPanelNotification() {
		$count	 = self::getPostCount();
		$text	 = '';

		if ( $count ) {
			$text = sprintf( '
		    <div class="updated">
		        <p>[<strong>CM Product Directory Community Items</strong>] <strong>%s</strong> pending %s waiting for the approval. Go to the <a href="' . esc_attr( admin_url() ) . 'edit.php?post_status=pending&post_type=cm-product">product list</a> or <a href="' . esc_attr( admin_url() ) . 'edit.php?post_status=pending&post_type=cm-product&cmpdc_action=' . CMProductDirectoryCommunityProduct::COMMUNITYPRODUCT_ACTION_PUBLISH_ALL . '">publish all</a>.</p>
		    </div>', $count, ($count > 1 ? 'product are' :
			'product is' ) );
		}

		$cookie		 = new CMPD_Cookie();
		$cookie_data = $cookie->getData();

		if ( !empty( $cookie_data[ 'msg' ] ) ) {
			$text .= '<div class="updated">' . $cookie_data[ 'msg' ] . '</div>';
			/*
			 * Clearing a cookie here would cause a notice
			 */
			set_transient( 'cmpdc_panel_notification_clear_cookie', 1, 60 );
		}
		echo $text;
	}

	public static function showPanelNotification() {
		add_action( 'admin_notices', array( __CLASS__, 'getPanelNotification' ) );
	}

	public static function registerFilterAction() {
		add_filter( 'cmpd_restrict_manage_posts_filter', array( __CLASS__, 'cmpdc_restrict_manage_posts' ) );
		add_filter( 'cmpd_product_restrict_manage_posts', array( __CLASS__, 'cmpdc_restrict_manage_posts' ) );

		if ( !empty( $_GET[ 'post_type' ] ) && $_GET[ 'post_type' ] == 'cm-product' ) {
			add_filter( 'page_row_actions', array( __CLASS__, 'addPostRowAction' ), 10, 2 );
			add_filter( 'manage_posts_columns', array( __CLASS__, 'addEmailColumn' ), 10, 2 );
		}
	}

	public static function registerActions() {
		add_action( 'manage_pages_custom_column', array( __CLASS__, 'displayEmail' ), 10, 2 );
		add_action( 'transition_post_status', array( __CLASS__, 'statusObserver' ), 10, 3 );
	}

	public static function addPostRowAction( $actions, $post ) {
		if ( $post->post_type == 'cm-product' && $post->post_status != 'publish' ) {
			// Adding a custom row action used to publish a product
			$actions[ 'publish' ] = '<a href=\'' . admin_url( 'edit.php?cmpdc_action=' . CMProductDirectoryCommunityProduct::COMMUNITYPRODUCT_ACTION_PUBLISH . '&post_id=' . $post->ID ) . '\'>Publish</a>';
		}
		return $actions;
	}

	public static function cmpdc_restrict_manage_posts( $options ) {
		$status = '';
		if ( !empty( $options ) ) {
			return array_merge( $options, array( 'pending' => 'Pending' ) );
		} else {
			return '<option value="pending" ' . (( $status == 'pending' ) ? ' selected="selected"' : '') . ' >' . 'Pending' . '</option>';
		}
	}

	public static function maybeClearCookie() {
		if ( get_transient('cmpdc_panel_notification_clear_cookie') ) {
			$cookie = new CMPD_Cookie();
			$cookie->clear();
			delete_transient('cmpdc_panel_notification_clear_cookie');
		}
	}

	public static function publishAll() {
		$pending_posts = get_posts( array( 'numberposts' => 10000, 'post_status' => 'pending', 'post_type' => 'cm-product' ) );
		if ( !empty( $pending_posts ) ) {
			foreach ( $pending_posts as $post ) {
				self:: statusObserver( 'publish', 'pending', $post );
				wp_update_post( array( 'ID' => $post->ID, 'post_status' => 'publish' ) );
			}

			$cookie		 = new CMPD_Cookie();
			$cookie->msg = self::COMMUNITYPRODUCT_PUBLISH_ALL_MSG;
			$cookie->ref = wp_get_referer();
			$cookie->save();

			wp_redirect( wp_get_referer() );
			exit;
		}
	}

	public static function publishTerm( $post_id ) {
		$post = get_post( $post_id );
		self::statusObserver( 'publish', 'pending', $post );
		wp_update_post( array( 'ID' => $post_id, 'post_status' => 'publish' ) );

		$cookie		 = new CMPD_Cookie();
		$cookie->msg = self::COMMUNITYPRODUCT_PUBLISH_TERM_MSG;
		$cookie->save();

		wp_redirect( wp_get_referer() );
		exit;
	}

	/**
	 * Add email column to post list.
	 */
	public static function addEmailColumn( $columns ) {
		return array_merge( $columns, array( 'email' => 'Email' ) );
	}

	/**
	 *  Display email column
	 */
	public static function displayEmail( $column, $post_id ) {
		if ( $column == 'email' ) {
			$post = get_post_custom( $post_id );
			if ( !empty( $post[ 'cmpdc_anonymous_email' ] ) ) {
				echo $post[ 'cmpdc_anonymous_email' ][ 0 ];
			} else {
				$post	 = get_post( $post_id );
				$user	 = get_userdata( $post->post_author );
				echo $user->user_email;
			}
		}
	}

	public static function statusObserver( $new_status, $old_status, $post ) {
		if ( $old_status == 'pending' && $new_status == 'publish' ) {
			$settings = CMProductDirectoryCommunityProduct::getMyProductSettings( array( 'old_status' => $old_status,
				'new_status' => $new_status
			) );

			$args = array(
				'old_status'
				=> $old_status,
				'new_status' => $new_status
			);

			if ( !empty( $settings[ 'user_notification' ] ) ) {
				self::notification( $post, $args );
			}
		}
	}

	public static function notification( $post, $args ) {
		$post_id	 = $post->ID;
		$user		 = get_user_by( 'id', $post->post_author );
		$post_meta	 = get_post_meta( $post_id );

		if ( !empty( $post_meta[ "cmpd_bemail_contact" ] ) ) {
			$email = $post_meta[ "cmpd_bemail_contact" ][ 0 ];
		} else {
			$email = $user->user_email;
		}
		if ( isset( $post_meta[ "cmpd_product_user" ] ) && isset( $post_meta[ "cmpd_product_password" ] ) ) {
			$login		 = $post_meta[ "cmpd_product_user" ][ 0 ];
			$password	 = $post_meta[ "cmpd_product_password" ][ 0 ];
		} else {
			CMProductDirectoryCommunityProductBackend::set_login_password(
			$post->ID );
			$post_meta = get_post_meta( $post_id );
			if ( isset( $post_meta[ "cmpd_product_user" ] ) && isset( $post_meta[ "cmpd_product_password" ] ) ) {
				$login		 = $post_meta[ "cmpd_product_user" ][ 0 ];
				$password	 = $post_meta[ "cmpd_product_password" ][ 0 ];
			} else {
				return false;
			}
		}

		$form_page_id = get_option( CMProductDirectoryCommunityProductBackend ::CMPDC_MAIN_FORM_PAGE_ID );
		if ( !empty( $form_page_id ) ) {
			$url = get_page_link( $form_page_id );
			$url = empty( $url ) ? '' : $url;
		} else {
			$url = '';
		}
		$old		 = empty( $args[ 'old_status' ] ) ? '' : $args[ 'old_status' ];
		$new		 = empty( $args[ 'new_status' ] ) ? '' : $args[ 'new_status' ];
		$settings	 = CMProductDirectoryCommunityProduct::getMyProductSettings( array(
			'title'		 => $post->post_title,
			'status'	 => $post->post_status,
			'login'		 => $login,
			'password'	 => $password,
			'url'		 => $url,
			'old_status' => $old,
			'new_status' => $new
		) );
		// Notification
		if ( !empty( $args[ 'old_status' ] ) ) {
			$subject = $settings[ 'user_notification_subject' ];
			$content = !empty( $settings[ 'user_notification_text' ] ) ? $settings[ 'user_notification_text' ] : self::CMPDC_MYPRODUCT_USER_NOTIFICATION_DEFAULT_TEXT;
		} else {
			$subject = $settings[ 'access_notification_title' ];
			$content = !empty( $settings[ 'access_notification_text' ] ) ? $settings[ 'access_notification_text' ] : self::CMPDC_MYPRODUCT_ACCESS_NOTIFICATION_DEFAULT_TEXT;
		}
		$notify = new CMProductDirectoryCommunityProductNotification();
		$notify->setEmail( $email );
		$notify->setNotificationSubject( $subject );

		$notify->setContent( $content );

		if ( !empty( $args[ 'old_status' ] ) && empty( $settings[ 'notification_text' ] ) ) {
			$notify->setContentData( array( $post->title, $args[ 'old_status' ], $args[ 'new_status' ] ) );
		}
		$notify->send();
		return true;
	}

	/**
	 * Adds the meta box container.
	 */
	public static function addMetaBox( $post_type ) {
		if ( !class_exists( 'CMProductDirectoryShared' ) ) {
			return;
		}

		/*
		 * Limit meta box to custom post type
		 */
		$post_types = array( CMProductDirectoryShared::POST_TYPE );
		if ( in_array( $post_type, $post_types ) ) {
			add_meta_box(
			CMPD_SLUG_NAME . '-community-custom-fields'
			, __( 'CM Product Directory Community Custom Fields', CMPD_SLUG_NAME )
			, array( __CLASS__, 'renderMetaboxContent' )
			, $post_type
			, 'advanced'
			, 'high'
			);
		}
	}

	public static function renderMetaboxContent( $post ) {
		include_once CMPDC_PLUGIN_DIR_VIEWS_PATH . 'backend/metabox.php';
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public static function saveMetabox( $post_id ) {
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( !isset( $_POST[ CMPD_SLUG_NAME . '-custom-fields-nonce' ] ) ) {
			return $post_id;
		}

		$nonce = $_POST[ CMPD_SLUG_NAME . '-custom-fields-nonce' ];

		// Verify that the nonce is valid.
		if ( !wp_verify_nonce( $nonce, CMPD_SLUG_NAME . '-custom-fields' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$postData = filter_input_array( INPUT_POST );

		if ( !empty( $postData ) ) {
			$claimsList = CMProductDirectory::meta( $post_id, 'cmpd_bemail_contact_tmp' );
			if ( empty( $claimsList ) || !is_array( $claimsList ) ) {
				$claimsList = array();
			}
			$claim = end( $claimsList );

			if ( !empty( $claim ) && !empty( $postData[ 'cmpdc_claim_accept' ] ) ) {
				/*
				 * Update owner e-mail
				 */
				update_post_meta( $post_id, 'cmpd_bemail_contact', $claim[ 'email' ] );

				/*
				 * Send the accept e-mail
				 */
				if ( $settings[ 'claim_rejected_notification' ] ) {
					$notify = new CMProductDirectoryCommunityProductNotification();
					$notify->setEmail( $claim[ 'email' ] );
					$notify->setNotificationSubject( $settings[ 'claim_rejected_notification_subject' ] );

					$notify->setContent( $settings[ 'claim_rejected_notification_text' ] );
					$notify->setContentData( $data );

					$notify->send();
				}

				/*
				 * Clear the claims list
				 */
				update_post_meta( $post_id, 'cmpd_bemail_contact_tmp', array() );
			}

			if ( !empty( $claim ) && !empty( $postData[ 'cmpdc_claim_reject' ] )  ) {
				$data		 = array(
					'title'	     => $postData[ 'post_title' ],
					'product'	 => $postData[ 'post_title' ],
					'url'		 => get_permalink( $post_id ),
				);
				$settings	 = CMProductDirectoryCommunityProduct::getMyProductSettings( $data );

				/*
				 * Send the reject e-mail
				 */
				if ( $settings[ 'claim_rejected_notification' ] ) {
					$notify = new CMProductDirectoryCommunityProductNotification();
					$notify->setEmail( $claim[ 'email' ] );
					$notify->setNotificationSubject( $settings[ 'claim_rejected_notification_subject' ] );

					$notify->setContent( $settings[ 'claim_rejected_notification_text' ] );
					$notify->setContentData( $data );

					$notify->send();
				}

				/*
				 * Clear the claims list
				 */
				update_post_meta( $post_id, 'cmpd_bemail_contact_tmp', array() );
			}
		}
		update_post_meta( $post_id, '', '' );
	}

}
