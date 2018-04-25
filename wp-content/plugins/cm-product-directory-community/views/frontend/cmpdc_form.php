<?php
if ( $data[ 'allowAddProduct' ] ):

    $category = array(
        'slug'  => 'category',
        'terms' => get_terms( CMProductDirectoryShared::POST_TYPE_TAXONOMY, array( 'hide_empty' => 0 ) ),
        'label' => esc_attr( $data[ 'form_categories' ] )
    );

    $tags = array(
        'slug'  => 'tags',
        'terms' => get_terms( CMProductDirectoryShared::POST_TYPE_TAXONOMY_TAG, array( 'hide_empty' => 0 ) ),
        'label' => esc_attr( $data[ 'form_tags' ] )
    );

    print_r($tags);

    $category[ 'attached_terms' ] = isset( $data[ 'post_id' ] ) ? wp_get_post_terms( $data[ 'post_id' ], CMProductDirectoryShared::POST_TYPE_TAXONOMY, array( "fields" => "ids" ) ) : '';

    $tags[ 'attached_terms' ] = isset( $data[ 'post_id' ] ) ? wp_get_post_terms( $data[ 'post_id' ], CMProductDirectoryShared::POST_TYPE_TAXONOMY_TAG, array( "fields" => "ids" ) ) : '';

    $pricingmodelEnabled = CMPD_Settings::getOption( CMPD_Settings::OPTION_TAXONOMY_PRICINGMODEL );
    if ( $pricingmodelEnabled ) {
        $pricingmodel                     = array(
            'slug'  => 'pricingmodel',
            'terms' => get_terms( CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL, array( 'hide_empty' => 0 ) ),
            'label' => esc_html( $data[ 'form_pricingmodel' ] ),
        );
        $pricingmodel[ 'attached_terms' ] = isset( $data[ 'post_id' ] ) ? wp_get_post_terms( $data[ 'post_id' ], CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL, array( 'fields' => 'ids' ) ) : '';
    }

    $languagesupportEnabled = CMPD_Settings::getOption( CMPD_Settings::OPTION_TAXONOMY_LANUAGESUPPORT );
    if ( $languagesupportEnabled ) {
        $languagesupport                     = array(
            'slug'  => 'languagesupport',
            'terms' => get_terms( CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT, array( 'hide_empty' => 0 ) ),
            'label' => esc_html( $data[ 'form_languagesupport' ] ),
        );
        $languagesupport[ 'attached_terms' ] = isset( $data[ 'post_id' ] ) ? wp_get_post_terms( $data[ 'post_id' ], CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT, array( 'fields' => 'ids' ) ) : '';
    }

    $targetaudienceEnabled = CMPD_Settings::getOption( CMPD_Settings::OPTION_TAXONOMY_TARGETAUDIENCE );
    if ( $targetaudienceEnabled ) {
        $targetaudience                     = array(
            'slug'  => 'targetaudience',
            'terms' => get_terms( CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE, array( 'hide_empty' => 0 ) ),
            'label' => esc_html( $data[ 'form_targetaudience' ] ),
        );
        $targetaudience[ 'attached_terms' ] = isset( $data[ 'post_id' ] ) ? wp_get_post_terms( $data[ 'post_id' ], CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE, array( 'fields' => 'ids' ) ) : '';
    }

    $asTextarea = get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_TEXTAREAS );
    if ( !$asTextarea ):
        $wpEditorSettings_description = array(
            'media_buttons' => false,
            'textarea_name' => 'form_description',
            'teeny'         => true,
            'textarea_rows' => 5
        );
        $wpEditorSettings_pitch       = array(
            'media_buttons' => false,
            'textarea_name' => 'form_pitch',
            'teeny'         => true,
            'textarea_rows' => 5
        );
    endif;

    // Default Google Map value
    $form_add_google_map = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_DEFAULT_MAP );
    $form_add_google_map = '0' == $form_add_google_map ? '' : $form_add_google_map;

    $displayVideo            = CMPD_Settings::getOption( CMPD_Settings::OPTION_ACTIVATE_VIDEO_FIELD );
    $displayAdditionalLinks  = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_LINKS );
    $displayAdditionalFields = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_FIELDS );

    $user = isset( $data[ 'user' ] ) ? $data[ 'user' ] : '';

    $post_id = isset( $data[ 'post_id' ] ) ? $data[ 'post_id' ] : '';

    // Values if ID exist
    if ( $post_id ) {
        // Basic Section
        $form_title       = get_post_field( 'post_title', $post_id );
        $form_description = get_post_field( 'post_content', $post_id );
        $form_pitch       = CMProductDirectory::meta( $post_id, 'cmpd_product_pitch' );

        // Product Section
        $form_video_url     = CMProductDirectory::meta( $post_id, 'cmpd_product_video' );
        $form_product_cost  = CMProductDirectory::meta( $post_id, 'cmpd_product_cost' );
        $form_page_link     = CMProductDirectory::meta( $post_id, 'cmpd_product_page' );
        $form_demo_link     = CMProductDirectory::meta( $post_id, 'cmpd_demo_link' );
        $form_purchase_link = CMProductDirectory::meta( $post_id, 'cmpd_purchase_link' );

        // Address Section
        $form_company_name    = CMProductDirectory::meta( $post_id, 'cmpd_company_name' );
        $form_virtual_address = CMProductDirectory::meta( $post_id, 'cmpd_virtual_address' );
        $form_address         = CMProductDirectory::meta( $post_id, 'cmpd_address' );
        $form_cityTown        = CMProductDirectory::meta( $post_id, 'cmpd_cityTown' );
        $form_stateCounty     = CMProductDirectory::meta( $post_id, 'cmpd_stateCounty' );
        $form_postalcode      = CMProductDirectory::meta( $post_id, 'cmpd_postalcode' );
        $form_region          = CMProductDirectory::meta( $post_id, 'cmpd_region' );
        $form_country         = CMProductDirectory::meta( $post_id, 'cmpd_country' );
        $form_add_google_map  = CMProductDirectory::meta( $post_id, 'cmpd_add_google_map' );

        // Social Media Section
        $form_year_founded  = CMProductDirectory::meta( $post_id, 'cmpd_year_founded' );
        $form_phone         = CMProductDirectory::meta( $post_id, 'cmpd_phone' );
        $form_bemail        = CMProductDirectory::meta( $post_id, 'cmpd_bemail' );
        $form_web_url       = CMProductDirectory::meta( $post_id, 'cmpd_web_url' );
        $form_facebook_name = CMProductDirectory::meta( $post_id, 'cmpd_facebook_name' );
        $form_twitter_name  = CMProductDirectory::meta( $post_id, 'cmpd_twitter_name' );
        $form_google        = CMProductDirectory::meta( $post_id, 'cmpd_google' );
        $form_linkedin      = CMProductDirectory::meta( $post_id, 'cmpd_linkedin' );
        $form_rss           = CMProductDirectory::meta( $post_id, 'cmpd_rss_name' );

        if ( $displayAdditionalLinks ) {
            $form_add_link1 = CMProductDirectory::meta( $post_id, 'cmpd_add_link1' );
            $form_add_link2 = CMProductDirectory::meta( $post_id, 'cmpd_add_link2' );
            $form_add_link3 = CMProductDirectory::meta( $post_id, 'cmpd_add_link3' );
            $form_add_link4 = CMProductDirectory::meta( $post_id, 'cmpd_add_link4' );
        }//$displayAdditionalLinks

        if ( $displayAdditionalFields ) {
            $form_add_field1 = CMProductDirectory::meta( $post_id, 'cmpd_add_field1' );
            $form_add_field2 = CMProductDirectory::meta( $post_id, 'cmpd_add_field2' );
            $form_add_field3 = CMProductDirectory::meta( $post_id, 'cmpd_add_field3' );
            $form_add_field4 = CMProductDirectory::meta( $post_id, 'cmpd_add_field4' );
        }//$displayAdditionalFields

        $product_gallery = CMProductDirectory::meta( $post_id, 'cmpd_product_gallery' );
        if ( !empty( $product_gallery ) ) {
            $product_gallery = explode( ',', $product_gallery );

            foreach ( $product_gallery as $key => $value ) {
                $image_id = wp_get_attachment_image_src( $value, 'cmpd_image' );

                $image_key = $key + 1;

                ${'form_gallery_image_' . $image_key . '_id'} = $value;
                ${'form_gallery_image_' . $image_key}         = $image_id[ 0 ];
            }
        }

        // Product Image
        $product_image_id = CMProductDirectory::meta( $post_id, 'cmpd_product_gallery_id' );
        if ( is_wp_error( $product_image_id ) ) {
            $form_product_image = '';
            $error_string       = $product_image_id->get_error_message();
            if ( $error_string === 'No file was uploaded.' ) {
                echo json_encode( array( 'status' => 'warning', 'code' => 1, 'msg' => __( $error_string, 'cmt_community_product' ) ) );
            } else {
                error_log( $error_string, 0 );
            }
        } else {
            $thumb      = wp_get_attachment_image_src( $product_image_id );
            $large      = wp_get_attachment_image_src( $product_image_id, 'large' );
            $cmpd_image = wp_get_attachment_image_src( $product_image_id, 'cmpd_image' );

            $form_product_image = empty( $cmpd_image[ 0 ] ) ? empty( $large[ 0 ] ) ? empty( $thumb[ 0 ] ) ? '' : $thumb[ 0 ] : $large[ 0 ] : $cmpd_image[ 0 ];
        }
    }
    $google_map_checked = !empty( $form_add_google_map ) ? ' checked="checked"' : '';
    ?>

    <div id="communityProduct_wrapper">
        <a name="mtmsg"></a>
        <div id="communityProduct_msg"></div>

        <?php if ( !empty( $data[ 'captcha' ] ) ): ?>
            <script type="text/javascript">
                var RecaptchaOptions = { theme: 'clean' };
            </script>
        <?php endif; ?>
        <div class="clear"></div>

        <?php if ( !is_user_logged_in() ) : ?>
            <p>
                <strong><?php echo esc_html( $data[ 'form_login_label' ] ); ?></strong> <a href="javascript:void(0)" onclick="jQuery( this ).parent().next().slideToggle()"><?php echo esc_html( $data[ 'form_showhide_text' ] ); ?></a>
            </p>

            <form class="form_submit" id="cmpdc_user_form" method="post" style="display:none">
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
                    <input class="button button-primary" type="submit" value="<?php echo esc_html( $data[ 'form_button2_text' ] ); ?>" />
                </div>
            </form>
            <div class="clear"></div>
        <?php endif; ?>

        <form id="cmpdc_main_form" method="post" enctype="multipart/form-data" novalidate>
            <?php if ( $post_id ) : ?>
                <input type="hidden" name="form_user" id="form_user" value="<?php echo esc_attr( $user ); ?>"/>
                <input type="hidden" name="post_id" id="post_id" value="<?php echo esc_attr( $post_id ); ?>"/>
                <?php echo wp_nonce_field( 'edit_product_' . $post_id ); ?>
            <?php else : ?>
                <input type="hidden" name="form_user" id="form_user" value="" />
                <input type="hidden" name="post_id" id="post_id" value="" />
            <?php endif; ?>

            <?php
            $fieldMap            = isset( $data[ 'fieldMap' ] ) ? $data[ 'fieldMap' ] : false;
            $displayFieldsNewWay = !empty( $fieldMap );

            if ( $displayFieldsNewWay ) {
                if ( !empty( $fieldMap ) && is_array($fieldMap) ) {
                    foreach ( $fieldMap as $sectionName => $sectionArr ) {
                        $sectionId = !empty( $sectionArr[ 'id' ] ) ? $sectionArr[ 'id' ] : sanitize_title( $sectionName );
                        $copyable  = false;
                        if ( !empty( $sectionArr[ 'copyable' ] ) ) {
                            $copyable = true;
                        }
                        ?>
                        <div class="cmbd_frontend_form_settings_container" id="cmbdl-form-section-<?php echo esc_attr( $sectionId ); ?>">
                            <div class="row-header">
                                <div class="col_1">
                                    <h3><?php echo esc_html( $sectionName ); ?></h3>

                                </div>
                            </div>
                            <div class="clear"></div>

                            <?php if ( !empty( $sectionArr ) && is_array( $sectionArr ) && !empty( $sectionArr[ 'fields' ] ) && is_array( $sectionArr[ 'fields' ] ) ) : ?>
                                <div class="row" style="display: none">
                                    <?php if ( !empty( $sectionArr[ 'description' ] ) ) : ?>
                                        <div class="row-description">
                                            <?php echo wpautop( $sectionArr[ 'description' ] ); ?>
                                        </div>
                                    <?php endif; ?>
                                    <input type="hidden" name="section_id" value="<?php echo esc_attr( $sectionId ); ?>" class="form-part-collectible">
                                    <div class="row-inner">
                                        <div class="cmbd_frontend_form_settings_container_message_box"></div>
                                        <?php
                                        foreach ( $sectionArr[ 'fields' ] as $oneField ) {
                                            $oneField = apply_filters( 'cmpdc_one_field', $oneField, $data );
                                            if ( is_array( $oneField ) ) {
                                                echo CMProductDirectoryCommunityProductFrontend::generateBusinessFormField( $oneField, $copyable );
                                            }
                                        }
                                        $confirmField = array(
                                            'id'          => sanitize_title( 'Confirm Correct' ),
                                            'name'        => 'Confirm Correct',
                                            'placeholder' => 'Confirm Correct',
                                            'type'        => 'confirm',
                                        );
                                        if ( $copyable ) {
                                            echo '<div class="clear"></div><a href="javascript:void(0)" class="row-remove copyable-action-element">-</a>';
                                        }
                                        ?>
                                        <?php
                                        if ( $copyable ) :
                                            ?>
                                            <a href="javascript:void(0)" class="row-copy copyable-action-element" />+</a>
                                        <?php endif; ?>
                                    </div>
                                    <?php
                                    echo CMProductDirectoryCommunityProductFrontend::generateBusinessFormField( $confirmField, $copyable );
                                    ?>
                                    <div class="clear"></div>
                                </div>
                            <?php endif; ?>

                            <a href="javascript:void(0)" class="row-toggle collapsed" /></a>
                        </div>
                        <?php
                    }
                }
            } else {
                ?>

                <!-- Basic Info Section -->
                <div class="cmpdc_settings_container">

                    <!-- Title -->
                    <div class="cmpdc_single_data">
                        <label for="form_title" class="cmpdc_desc">
                            <?php echo esc_html( $data[ 'form_title' ] ); ?>
                            <?php echo!empty( $data[ 'form_title_mandatory' ] ) ? ' *' : ''; ?>
                        </label>
                        <input type="text" class="cmpdc_input" id="form_title" name="form_title" value="<?php echo esc_attr( !empty( $form_title ) ? $form_title : ''  ); ?>" placeholder="<?php echo esc_attr( stripslashes( $data[ 'form_title_placeholder' ] ) ); ?>" <?php echo esc_attr( !empty( $data[ 'form_title_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                    </div>
                    <div class="clear"></div>

                    <!-- Description -->
                    <div class="cmpdc_single_data">
                        <label for="form_description" class="cmpdc_desc">
                            <?php echo esc_html( $data[ 'form_description' ] ); ?>
                            <?php echo!empty( $data[ 'form_description_mandatory' ] ) ? ' *' : ''; ?>
                        </label>
                        <?php
                        $form_description = isset( $form_description ) ? $form_description : '';
                        ?>
                        <?php if ( $asTextarea ) { ?>
                            <textarea class="wp-editor-area cmpdc_textarea" rows="5" autocomplete="off" name="form_description" id="form_description" placeholder="<?php echo esc_attr( $data[ 'form_education_placeholder' ] ); ?>" <?php echo esc_html( !empty( $data[ 'form_description_mandatory' ] ) ? ' required="required"' : ''  ); ?> ><?php echo!empty( $form_description ) ? $form_description : ''; ?></textarea>
                            <?php
                        } else {
                            ob_start();
                            wp_editor( esc_html( $form_description ), 'form_description', $wpEditorSettings_description );
                            $editor = ob_get_clean();
                            if ( !empty( $data[ 'form_description_mandatory' ] ) ) {
                                $editor = str_replace( '<textarea', '<textarea required="required" ', $editor );
                            }
                            echo $editor;
                        }
                        ?>
                    </div>
                    <div class="clear"></div>

                    <!-- Pitch -->
                    <div class="cmpdc_single_data">
                        <label for="form_pitch" class="cmpdc_desc">
                            <?php echo esc_html( $data[ 'form_product_pitch' ] ); ?>
                            <?php echo!empty( $data[ 'form_product_pitch_mandatory' ] ) ? ' *' : ''; ?>
                        </label>
                        <?php
                        $form_pitch = isset( $form_pitch ) ? $form_pitch : '';
                        ?>
                        <?php if ( $asTextarea ) { ?>
                            <textarea class="wp-editor-area cmpdc_textarea" rows="5" autocomplete="off" name="form_pitch" id="form_pitch" placeholder="<?php echo esc_attr( $data[ 'form_education_placeholder' ] ); ?>" <?php echo esc_html( !empty( $data[ 'form_product_pitch_mandatory' ] ) ? ' required="required"' : ''  ); ?> ><?php echo!empty( $form_pitch ) ? $form_pitch : ''; ?></textarea>
                            <?php
                        } else {
                            ob_start();
                            wp_editor( esc_html( $form_pitch ), 'form_pitch', $wpEditorSettings_pitch );
                            $editor = ob_get_clean();
                            if ( !empty( $data[ 'form_product_pitch_mandatory' ] ) ) {
                                $editor = str_replace( '<textarea', '<textarea required="required" ', $editor );
                            }
                            echo $editor;
                        }
                        ?>
                    </div>
                    <div class="clear"></div>

                    <!-- Taxonomy::Category -->
                    <?php if ( !empty( $category[ 'terms' ] ) ): ?>
                        <div class="cmpdc_single_data">
	                        <?php if ( isset($data['form_show_categories_as_checkboxes']) && $data['form_show_categories_as_checkboxes'] == 1) : ?>
                                <label class="cmpdc_desc col_4">
			                        <?php echo esc_html( $data[ 'form_categories' ] ); ?>
                                </label>
		                        <?php foreach ( $category[ 'terms' ] as $term ) {
			                        $attached_term = is_array($category[ 'attached_terms' ]) && in_array( $term->term_id, $category[ 'attached_terms' ] ) ? ' checked' : ''; ?>
                                    <label>
                                        <input class="cmpdc_checkbox form_categories"
                                               type="checkbox"
                                               name="form_categories[]"
                                               value="<?php echo esc_attr($term->term_id); ?>"
					                        <?php echo $attached_term; ?> />
                                        <span><?php echo esc_html($term->name); ?> </span>
                                    </label>
		                        <?php } ?>
	                        <?php else: ?>
                                <label class="cmpdc_desc col_4" for="form_categories">
			                        <?php echo esc_html( $data[ 'form_categories' ] ); ?>
                                </label>
                                <select name="form_categories[]" id="form_categories" class="cmpdc_select col_4c" multiple type="text" size="6">
			                        <?php
			                        foreach ( $category[ 'terms' ] as $term ) {
				                        $attached_term = in_array( $term->term_id, $category[ 'attached_terms' ] ) ? 'selected' : '';
				                        echo '<option  value="' . esc_attr( $term->term_id ) . '" ' . $attached_term . ' >' . esc_html( $term->name ) . '</option>';
			                        }
			                        ?>
                                </select>
	                        <?php endif;?>
                        </div>
                        <div class="clear"></div>
                    <?php endif; ?>

                    <!-- Tags -->
	                <?php if ( isset($data['form_show_tags']) && $data['form_show_tags'] == 1) : ?>
                        <div class="cmpdc_single_data row">

                            <!--<div class="cmpdc_single_data">
                                <label class="cmpdc_desc col_4">
                                    <?php /*echo esc_html( $data[ 'form_tags' ] ); */?>
                                </label>
                                <?php /*foreach ( $tags[ 'terms' ] as $term ) {
                                    $attached_term = is_array($tags[ 'attached_terms' ]) && in_array( $term->term_id, $tags[ 'attached_terms' ] ) ? ' checked' : ''; */?>
                                    <label>
                                        <input class="cmpdc_checkbox form_categories"
                                               type="checkbox"
                                               name="form_categories[]"
                                               value="<?php /*echo esc_attr($term->term_id); */?>"
                                            <?php /*echo $attached_term; */?> />
                                        <span><?php /*echo esc_html($term->name); */?> </span>
                                    </label>
                                <?php /*} */?>
                            </div>-->

                            <label class="cmpdc_desc col_4" for="form_tags">
				                <?php echo esc_html( $data[ 'form_tags' ] ); ?>
                            </label>
                            <input type="text" id="form_tags" name="form_tags[]" value="" />
                            <span class="description">Separate tags with commas</span>
                        </div>
                        <div class="clear"></div>
	                <?php endif; ?>

                    <!-- Taxonomy::Pricingmodel -->
                    <?php if ( !empty( $pricingmodel[ 'terms' ] ) ): ?>
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_pricingmodel">
                                <?php echo esc_html( $data[ 'form_pricingmodel' ] ); ?>
                            </label>
                            <select name="form_pricingmodel[]" id="form_pricingmodel" class="cmpdc_select" multiple type="text" size="6">
                                <?php
                                foreach ( $pricingmodel[ 'terms' ] as $term ) {
                                    $attached_term = in_array( $term->term_id, $pricingmodel[ 'attached_terms' ] ) ? 'selected' : '';
                                    echo '<option  value="' . esc_attr( $term->term_id ) . '" ' . $attached_term . ' >' . esc_html( $term->name ) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="clear"></div>
                    <?php endif; ?>

                    <!-- Taxonomy::Languagesupport -->
                    <?php if ( !empty( $languagesupport[ 'terms' ] ) ): ?>
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_languagesupport">
                                <?php echo esc_html( $data[ 'form_languagesupport' ] ); ?>
                            </label>
                            <select name="form_languagesupport[]" id="form_languagesupport" class="cmpdc_select" multiple type="text" size="6">
                                <?php
                                foreach ( $languagesupport[ 'terms' ] as $term ) {
                                    $attached_term = in_array( $term->term_id, $languagesupport[ 'attached_terms' ] ) ? 'selected' : '';
                                    echo '<option  value="' . esc_attr( $term->term_id ) . '" ' . $attached_term . ' >' . esc_html( $term->name ) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="clear"></div>
                    <?php endif; ?>

                    <!-- Taxonomy::Targetaudience -->
                    <?php if ( !empty( $targetaudience[ 'terms' ] ) ): ?>
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_targetaudience">
                                <?php echo esc_html( $data[ 'form_targetaudience' ] ); ?>
                            </label>
                            <select name="form_targetaudience[]" id="form_targetaudience" class="cmpdc_select" multiple type="text" size="6">
                                <?php
                                foreach ( $targetaudience[ 'terms' ] as $term ) {
                                    $attached_term = in_array( $term->term_id, $targetaudience[ 'attached_terms' ] ) ? 'selected' : '';
                                    echo '<option  value="' . esc_attr( $term->term_id ) . '" ' . $attached_term . ' >' . esc_html( $term->name ) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="clear"></div>
                    <?php endif; ?>
                </div>
                <div class="clear"></div>

                <!-- Contact E-Mail -->
                <?php if ( !$data[ 'loggedIn' ] ): ?>
                    <div class="cmpdc_settings_container">
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_bemail_contact">
                                <?php echo esc_html( $data[ 'form_bemail_contact' ] ); ?>
                                <?php echo esc_html( !empty( $data[ 'form_bemail_contact_mandatory' ] ) ? ' *' : ''  ); ?>
                            </label>
                            <input type="text" class="cmpdc_input" id="form_bemail_contact" name="form_bemail_contact"
                                   value="<?php echo esc_attr( !empty( $form_bemail_contact ) ? $form_bemail_contact : ''  ); ?>"
                                   placeholder="<?php echo esc_attr( $data[ 'form_bemail_contact_placeholder' ] ); ?>"
                                <?php echo esc_attr( !empty( $data[ 'form_bemail_contact_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                <?php endif; ?>

                <!-- Product Info Section -->
                <div class="cmpdc_settings_container">

                    <!-- Product Image -->
                    <div class="cmpdc_single_data">
                        <label for="form_product_image" class="cmpdc_desc">
                            <?php echo esc_html( $data[ 'form_add_product_image' ] ); ?>
                            <?php echo esc_html( !empty( $data[ 'form_add_product_image_mandatory' ] ) ? ' *' : ''  ); ?>
                        </label>
                        <input type="file" class="cmpdc_input" id="form_product_image" name="form_product_image"
                        <?php echo ((empty( $data[ 'form_add_product_image_mandatory' ] ) && empty( $url )) ? '' : 'required="required"'); ?>
                               />
                               <?php if ( !empty( $form_product_image ) ): ?>
                            <img class="cmpdc_preview" src="<?php echo esc_attr( $form_product_image ); ?>" alt="Can't load the image" />
                        <?php endif; ?>
                    </div>
                    <div class="clear"></div>

                    <!-- Video URL -->
                    <?php if ( $displayVideo ): ?>
                        <div class="cmpdc_single_data">
                            <label for="form_video_url" class="cmpdc_desc">
                                <?php echo esc_html( $data[ 'main_form_video_url' ] ); ?>
                                <?php echo!empty( $data[ 'main_form_video_url_mandatory' ] ) ? ' *' : ''; ?>
                            </label>
                            <input type="text" class="cmpdc_input" id="form_video_url" name="form_video_url" placeholder="<?php echo esc_attr( $data[ 'main_form_video_url_placeholder' ] ); ?>" value="<?php echo esc_attr( !empty( $form_video_url ) ? $form_video_url : ''  ); ?>" <?php echo esc_attr( !empty( $data[ 'main_form_video_url_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                        </div>
                        <div class="clear"></div>
                    <?php endif; ?>

                    <!-- Product Cost -->
                    <div class="cmpdc_single_data">
                        <label for="form_product_cost" class="cmpdc_desc">
                            <?php echo esc_html( $data[ 'main_form_product_cost' ] ); ?>
                            <?php echo!empty( $data[ 'main_form_product_cost_mandatory' ] ) ? ' *' : ''; ?>
                        </label>
                        <input type="text" class="cmpdc_input" id="form_product_cost" name="form_product_cost" placeholder="<?php echo esc_attr( $data[ 'main_form_product_cost_placeholder' ] ); ?>" value="<?php echo esc_attr( !empty( $form_product_cost ) ? $form_product_cost : ''  ); ?>" <?php echo esc_attr( !empty( $data[ 'main_form_product_cost_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                    </div>
                    <div class="clear"></div>

                    <!-- Page Link -->
                    <div class="cmpdc_single_data">
                        <label for="form_page_link" class="cmpdc_desc">
                            <?php echo esc_html( $data[ 'main_form_page_link' ] ); ?>
                            <?php echo!empty( $data[ 'main_form_page_link_mandatory' ] ) ? ' *' : ''; ?>
                        </label>
                        <input type="text" class="cmpdc_input" id="form_page_link" name="form_page_link" placeholder="<?php echo esc_attr( $data[ 'main_form_page_link_placeholder' ] ); ?>" value="<?php echo esc_attr( !empty( $form_page_link ) ? $form_page_link : ''  ); ?>" <?php echo esc_attr( !empty( $data[ 'main_form_page_link_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                    </div>
                    <div class="clear"></div>

                    <!-- Demo Link -->
                    <div class="cmpdc_single_data">
                        <label for="form_demo_link" class="cmpdc_desc">
                            <?php echo esc_html( $data[ 'main_form_demo_link' ] ); ?>
                            <?php echo!empty( $data[ 'main_form_demo_link_mandatory' ] ) ? ' *' : ''; ?>
                        </label>
                        <input type="text" class="cmpdc_input" id="form_demo_link" name="form_demo_link" placeholder="<?php echo esc_attr( $data[ 'main_form_demo_link_placeholder' ] ); ?>" value="<?php echo esc_attr( !empty( $form_demo_link ) ? $form_demo_link : ''  ); ?>" <?php echo esc_attr( !empty( $data[ 'main_form_demo_link_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                    </div>
                    <div class="clear"></div>

                    <!-- Purchase Link -->
                    <div class="cmpdc_single_data">
                        <label for="form_purchase_link" class="cmpdc_desc">
                            <?php echo esc_html( $data[ 'main_form_purchase_link' ] ); ?>
                            <?php echo!empty( $data[ 'main_form_purchase_link_mandatory' ] ) ? ' *' : ''; ?>
                        </label>
                        <input type="text" class="cmpdc_input" id="form_purchase_link" name="form_purchase_link" placeholder="<?php echo esc_attr( $data[ 'main_form_purchase_link_placeholder' ] ); ?>" value="<?php echo esc_attr( !empty( $form_purchase_link ) ? $form_purchase_link : ''  ); ?>" <?php echo esc_attr( !empty( $data[ 'main_form_purchase_link_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                    </div>
                    <div class="clear"></div>

                </div>
                <div class="clear"></div>

                <?php
                // get logged in user id
                if ( is_user_logged_in() ) :
                    $user = wp_get_current_user();

                    $args = array(
                        'author'      => $user->ID,
                        'post_type'   => 'cm-business',
                        'post_status' => array( 'pending', 'publish' ),
                    );

                    $assigned               = (!empty( $data[ 'post_id' ] )) ? get_post_meta( $data[ 'post_id' ], 'cmpd_assign_business', true ) : false;
                    $assigned_business_post = !empty( $assigned ) ? get_post( $assigned ) : '';
                    $assigned_business      = (!empty( $assigned_business_post ) && $assigned_business_post->post_status == 'publish' ) ? $assigned_business_post : '';
                    $input_disabled         = $assigned != false && !empty( $assigned_business ) ? 'disabled' : '';
                    $businesses             = new WP_Query( $args );

                    if ( !empty( $businesses->posts ) ) {
                        $get_businesses = $businesses->posts;
                        if ( $assigned != false && !empty( $assigned_business ) ) {
                            $assign_checked = !empty( $assigned ) ? 1 : 0;
                            ?>
                            <p>
                                <label for="cmpd_assign_data" class="cmpd_metabox_label">Business assigned:</label>
                                <input type="hidden" name="cmpd_assign_data" id="cmpd_assign_data" value="0" />
                                <input type="hidden" name="cmpd_select_busienss" id="cmpd_select_busienss" value="<?php echo $assigned; ?>" />
                                <input type="checkbox" name="cmpd_assign_data" id="cmpd_assign_data" <?php checked( $assign_checked, '1', 1 ); ?> />

                                <b><a href="<?php echo get_permalink( $assigned_business->ID ); ?>" title="<?php echo esc_attr( $assigned_business->post_title ); ?>"><?php echo esc_attr( $assigned_business->post_title ); ?></a></b> <a href="<?php echo admin_url(); ?>post.php?post=<?php echo $assigned_business->ID; ?>&amp;action=edit" title="Edit <?php echo esc_attr( $assigned_business->post_title ); ?>">(Edit)</a>.
                            </p>
                            <div class="clear"></div>
                            <?php
                        } elseif ( ( $assigned != false && empty( $assigned_business ) ) || $assigned == false ) {
                            ?>
                            <p>
                                <label for="cmpd_select_busienss" class="cmpd_metabox_label"><?php _e( 'Get product company info from an existing business:', CMPD_SLUG_NAME ); ?></label>
                                <select name="cmpd_select_busienss" id="cmpd_select_busienss">
                                    <option value="0"><?php _e( '-None-', CMPD_SLUG_NAME ); ?></option>
                                    <?php
                                    foreach ( $get_businesses as $business ):
                                        echo '<option value="' . $business->ID . '">' . esc_html( $business->post_title ) . '</option>';
                                    endforeach;
                                    ?>
                                </select>
                            </p>
                            <div class="clear"></div>
                            <p>
                                <label for="cmpd_assign_data" class="cmpd_metabox_label"><?php _e( 'Assign the product to business?', CMPD_SLUG_NAME ); ?></label>
                                <input type="checkbox" name="cmpd_assign_data" id="cmpd_assign_data" />
                                <span style="font-style: italic"><?php _e( 'If you check this the company info fields will be taken from the assigned business and will not be editable for this product.', CMPD_SLUG_NAME ); ?></span>
                            </p>
                            <div class="clear"></div>
                            <?php
                        }
                    }
                    else {
                        echo '<p>' . __( 'No Businesses found', CMPD_SLUG_NAME ) . '</p>';
                    }
                    ?>
                    <script>
                        jQuery( document ).ready( function () {

                            function cmpd_check_business_fields() {

                                var select = jQuery( '#cmpd_select_busienss' );
                                var container = jQuery( '#cmpdc_business_shared_container' );
                                if ( select.val() !== '0' ) {
                                    container.hide();
                                } else {
                                    container.show();
                                }
                            }
                            jQuery( '#cmpd_select_busienss' ).on( 'change', cmpd_check_business_fields ).trigger( 'change' );
                        } );
                    </script>
                    <?php
                endif;
                ?>

                <div id="cmpdc_business_shared_container">
                    <!-- Address Section -->
                    <div class="cmpdc_settings_container" id="with_map">
                        <div class="cmpdc_settings_container_inner">

                            <!-- Company Name -->
                            <div class="cmpdc_single_data">
                                <label for="form_company_name" class="cmpdc_desc">
                                    <?php echo esc_html( $data[ 'main_form_company_name' ] ); ?>
                                    <?php echo!empty( $data[ 'main_form_company_name_mandatory' ] ) ? ' *' : ''; ?>
                                </label>
                                <input type="text" class="cmpdc_input" id="form_company_name" name="form_company_name" placeholder="<?php echo esc_attr( $data[ 'main_form_company_name_placeholder' ] ); ?>" value="<?php echo esc_attr( !empty( $form_company_name ) ? $form_company_name : ''  ); ?>" <?php echo esc_attr( !empty( $data[ 'main_form_company_name_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                            </div>
                            <div class="clear"></div>


                            <!-- Virtual Address -->
                            <div class="cmpdc_single_data">
                                <label class="cmpdc_desc" for="form_virtual_address">
                                    <?php echo esc_html( $data[ 'form_virtual_address' ] ); ?>
                                </label>
                                <input class="cmpdc_checkbox" id="form_virtual_address" type="checkbox" name="form_virtual_address" value="1"
                                <?php
                                if ( !empty( $data[ 'form_virtual_address_placeholder' ] ) ) {
                                    echo 'checked="checked"';
                                }
                                ?> />
                            </div>
                            <div class="clear"></div>

                            <!-- Address -->
                            <div class="cmpdc_single_data">
                                <label class="cmpdc_desc" for="form_address">
                                    <?php echo esc_html( $data[ 'form_address' ] ); ?>
                                    <?php echo!empty( $data[ 'form_address_mandatory' ] ) ? ' *' : ''; ?>
                                </label>
                                <input type="text" class="cmpdc_input" name="form_address" id="form_address" value="<?php echo esc_attr( !empty( $form_address ) ? $form_address : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_address_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_address_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                            </div>
                            <div class="clear"></div>

                            <!-- City/Town -->
                            <div class="cmpdc_single_data">
                                <label class="cmpdc_desc" for="form_cityTown">
                                    <?php echo esc_html( $data[ 'form_cityTown' ] ); ?>
                                    <?php echo!empty( $data[ 'form_cityTown_mandatory' ] ) ? ' *' : ''; ?>
                                </label>
                                <input type="text" class="cmpdc_input" name="form_cityTown" id="form_cityTown" value="<?php echo esc_attr( !empty( $form_cityTown ) ? $form_cityTown : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_cityTown_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_cityTown_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                            </div>
                            <div class="clear"></div>

                            <!-- State/County -->
                            <div class="cmpdc_single_data">
                                <label class="cmpdc_desc" for="form_stateCounty">
                                    <?php echo esc_html( $data[ 'form_stateCounty' ] ); ?>
                                    <?php echo!empty( $data[ 'form_stateCounty_mandatory' ] ) ? ' *' : ''; ?>
                                </label>
                                <input type="text" class="cmpdc_input" name="form_stateCounty" id="form_stateCounty" value="<?php echo esc_attr( !empty( $form_stateCounty ) ? $form_stateCounty : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_stateCounty_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_stateCounty_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                            </div>
                            <div class="clear"></div>

                            <!-- Postalcode -->
                            <div class="cmpdc_single_data">
                                <label class="cmpdc_desc" for="form_postalcode">
                                    <?php echo esc_html( $data[ 'form_postalcode' ] ); ?>
                                    <?php echo!empty( $data[ 'form_postalcode_mandatory' ] ) ? ' *' : ''; ?>
                                </label>
                                <input type="text" class="cmpdc_input" name="form_postalcode" id="form_postalcode" value="<?php echo esc_attr( !empty( $form_postalcode ) ? $form_postalcode : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_postalcode_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_postalcode_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                            </div>
                            <div class="clear"></div>

                            <!-- Region -->
                            <div class="cmpdc_single_data">
                                <label class="cmpdc_desc" for="form_region">
                                    <?php echo esc_html( $data[ 'form_region' ] ); ?>
                                    <?php echo!empty( $data[ 'form_region_mandatory' ] ) ? ' *' : ''; ?>
                                </label>
                                <input type="text" class="cmpdc_input" name="form_region" id="form_region" value="<?php echo esc_attr( !empty( $form_region ) ? $form_region : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_region_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_region_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                            </div>
                            <div class="clear"></div>

                            <!-- Country -->
                            <div class="cmpdc_single_data">
                                <label class="cmpdc_desc" for="form_country">
                                    <?php echo esc_html( $data[ 'form_country' ] ); ?>
                                    <?php echo!empty( $data[ 'form_country_mandatory' ] ) ? ' *' : ''; ?>
                                </label>
                                <?php
                                $form_country = isset( $form_country ) ? $form_country : '';
                                $countries    = array( "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe" );
                                $current      = $form_country;
                                if ( empty( $current ) ) {
                                    $current = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_DEFAULT_COUNTRY );
                                    $current = empty( $current ) ? '' : $countries[ $current ];
                                }
                                ?>
                                <select class="cmpdc_select" type="text" name="form_country" id="form_country">
                                    <?php
                                    foreach ( $countries as $country ) {
                                        $checked = ($current == $country) ? 'selected' : '';
                                        echo '<option value="' . esc_attr( $country ) . '" ' . $checked . '>' . esc_html( $country ) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="clear"></div>

                            <!-- Googl Map -->
                            <div class="cmpdc_single_data">
                                <label class="cmpdc_desc" for="form_add_google_map">
                                    <?php echo esc_html( $data[ 'form_add_google_map' ] ); ?>
                                </label>
                                <input class="cmpdc_checkbox" id="form_add_google_map" type="checkbox" name="form_add_google_map" value="1"
                                       <?php echo $google_map_checked; ?> />

                                <?php if ( !empty( $google_map_checked ) ) { ?>
                                    <div class="cmpdc-map" id="cmpdc-map-canvas"></div>
                                <?php } else { ?>
                                    <div class="cmpdc-map" id="cmpdc-map-canvas" style="display: none"></div>
                                <?php } ?>
                            </div>
                            <div class="clear"></div>

                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>

                <?php if ( $data['form_show_social_media_section'] == 1 ) : ?>
                    <!-- Social Media Section -->
                    <div class="cmpdc_settings_container">
                        <div class="row">
                            <div class="col_1">
                                <h3>Social Media Section</h3>
                            </div>
                        </div>

                        <!-- Year Founded -->
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_year_founded">
                                <?php echo esc_html( $data[ 'form_year_founded' ] ); ?>
                            </label>
                            <select class="cmpdc_select cm_imput_short" name="form_year_founded" id="form_year_founded">
                                <?php
                                $current_date = date( 'Y' );
                                $current_date = (int)$current_date;

                                $i        = 1950;
                                $max      = date( 'Y' ) + 1;
                                $selected = empty( $form_year_founded ) ? $current_date : $form_year_founded;

                                echo '<option value="Not indicated"' . selected( $selected, 'Not indicated', 0 ) . '>Not indicated</option>';
                                for ( $i; $i <= $max; $i++ ) {
                                    echo '<option value="' . esc_attr( $i ) . '" ' . selected( $selected, $i, 0 ) . '>' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="clear"></div>

                        <!-- Phone -->
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_phone">
                                <?php echo esc_html( $data[ 'form_phone' ] ); ?>
                                <?php echo esc_html( !empty( $data[ 'form_phone_mandatory' ] ) ? ' *' : ''  ); ?>
                            </label>
                            <input type="text" class="cmpdc_input" name="form_phone" id="form_phone" value="<?php echo esc_attr( !empty( $form_phone ) ? $form_phone : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_phone_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_phone_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                        </div>
                        <div class="clear"></div>

                        <!-- E-Mail -->
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_bemail">
                                <?php echo esc_html( $data[ 'form_bemail' ] ); ?>
                                <?php echo esc_html( !empty( $data[ 'form_bemail_mandatory' ] ) ? ' *' : ''  ); ?>
                            </label>
                            <input type="text" class="cmpdc_input" name="form_bemail" id="form_bemail" value="<?php echo esc_attr( !empty( $form_bemail ) ? $form_bemail : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_bemail_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_bemail_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                        </div>
                        <div class="clear"></div>

                        <!-- Web URL -->
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_web_url">
                                <?php echo esc_html( $data[ 'form_web_url' ] ); ?>
                                <?php echo esc_html( !empty( $data[ 'form_web_url_mandatory' ] ) ? ' *' : ''  ); ?>
                            </label>
                            <input type="text" class="cmpdc_input" name="form_web_url" id="form_web_url" value="<?php echo esc_attr( !empty( $form_web_url ) ? $form_web_url : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_web_url_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_web_url_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                        </div>
                        <div class="clear"></div>

                        <!-- Facebook -->
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_facebook_name">
                                <?php echo esc_html( $data[ 'form_facebook_name' ] ); ?>
                                <?php echo esc_html( !empty( $data[ 'form_facebook_name_mandatory' ] ) ? ' *' : ''  ); ?>
                            </label>
                            <input type="text" class="cmpdc_input" name="form_facebook_name" id="form_facebook_name" value="<?php echo esc_attr( !empty( $form_facebook_name ) ? $form_facebook_name : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_facebook_name_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_facebook_name_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                        </div>
                        <div class="clear"></div>

                        <!-- Twitter -->
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_twitter_name">
                                <?php echo esc_html( $data[ 'form_twitter_name' ] ); ?>
                                <?php echo esc_html( !empty( $data[ 'form_twitter_name_mandatory' ] ) ? ' *' : ''  ); ?>
                            </label>
                            <input type="text" class="cmpdc_input" name="form_twitter_name" id="form_twitter_name" value="<?php echo esc_attr( !empty( $form_twitter_name ) ? $form_twitter_name : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_twitter_name_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_twitter_name_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                        </div>
                        <div class="clear"></div>

                        <!-- Google Plus -->
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_google">
                                <?php echo esc_html( $data[ 'form_google' ] ); ?>
                                <?php echo esc_html( !empty( $data[ 'form_google_mandatory' ] ) ? ' *' : ''  ); ?>
                            </label>
                            <input type="text" class="cmpdc_input" name="form_google" id="form_google" value="<?php echo esc_attr( !empty( $form_google ) ? $form_google : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_google_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_google_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                        </div>
                        <div class="clear"></div>

                        <!-- LinkedIn -->
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_linkedin">
                                <?php echo esc_html( $data[ 'form_linkedin' ] ); ?>
                                <?php echo esc_html( !empty( $data[ 'form_linkedin_mandatory' ] ) ? ' *' : ''  ); ?>
                            </label>
                            <input type="text" class="cmpdc_input" name="form_linkedin" id="form_linkedin" value="<?php echo esc_attr( !empty( $form_linkedin ) ? $form_linkedin : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_linkedin_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_linkedin_mandatory' ] ) ? ' required="required"' : ''  ); ?> />
                        </div>
                        <div class="clear"></div>

                        <!-- RSS -->
                        <div class="cmpdc_single_data">
                            <label class="cmpdc_desc" for="form_rss">
                                <?php echo esc_html( $data[ 'form_rss' ] ); ?>
                                <?php echo esc_html( !empty( $data[ 'form_rss_mandatory' ] ) ? ' *' : ''  ); ?>
                            </label>
                            <input type="text" class="cmpdc_input" name="form_rss" id="form_rss" placeholder="<?php echo esc_attr( $data[ 'form_rss_placeholder' ] ); ?>" <?php echo esc_attr( !empty( $data[ 'form_rss_mandatory' ] ) ? ' required="required"' : ''  ); ?> value="<?php echo esc_attr( !empty( $form_rss ) ? $form_rss : ''  ); ?>" />
                        </div>
                        <div class="clear"></div>

                        <!-- Additional Links Section -->
                        <?php
                        if ( defined( 'CMPD_Settings::OPTION_ADD_LINKS' ) ):
                            if ( $displayAdditionalLinks ): ?>

                                <!-- Additional Link 1 -->
                                <?php
                                $add_link1 = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_LINKS_LABEL1 );
                                if ( !empty( $add_link1 ) ):
                                    ?>
                                    <div class="cmpdc_single_data">
                                        <label class="cmpdc_desc" for="form_add_link1">
                                            <?php echo esc_html( $data[ 'form_add_link1' ] ); ?>
                                        </label>
                                        <input type="text" class="cmpdc_input" name="form_add_link1" id="form_add_link1" value="<?php echo esc_attr( !empty( $form_add_link1 ) ? $form_add_link1 : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_add_link1_placeholder' ] ); ?>" />
                                    </div>
                                    <div class="clear"></div>
                                <?php endif; ?>

                                <!-- Additional Link 2 -->
                                <?php
                                $add_link2 = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_LINKS_LABEL2 );
                                if ( !empty( $add_link2 ) ):
                                    ?>
                                    <div class="cmpdc_single_data">
                                        <label class="cmpdc_desc" for="form_add_link2">
                                            <?php echo esc_html( $data[ 'form_add_link2' ] ); ?>
                                        </label>
                                        <input type="text" class="cmpdc_input" name="form_add_link2" id="form_add_link2" value="<?php echo esc_attr( !empty( $form_add_link2 ) ? $form_add_link2 : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_add_link2_placeholder' ] ); ?>" />
                                    </div>
                                    <div class="clear"></div>
                                <?php endif; ?>

                                <!-- Additional Link 3 -->
                                <?php
                                $add_link3 = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_LINKS_LABEL3 );
                                if ( !empty( $add_link3 ) ):
                                    ?>
                                    <div class="cmpdc_single_data">
                                        <label class="cmpdc_desc" for="form_add_link3">
                                            <?php echo esc_html( $data[ 'form_add_link3' ] ); ?>
                                        </label>
                                        <input type="text" class="cmpdc_input" name="form_add_link3" id="form_add_link3" value="<?php echo esc_attr( !empty( $form_add_link3 ) ? $form_add_link3 : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_add_link3_placeholder' ] ); ?>" />
                                    </div>
                                    <div class="clear"></div>
                                <?php endif; ?>

                                <!-- Additional Link 4 -->
                                <?php
                                $add_link4 = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_LINKS_LABEL4 );
                                if ( !empty( $add_link4 ) ):
                                    ?>
                                    <div class="cmpdc_single_data">
                                        <label class="cmpdc_desc" for="form_add_link4">
                                            <?php echo esc_html( $data[ 'form_add_link4' ] ); ?>
                                        </label>
                                        <input type="text" class="cmpdc_input" name="form_add_link4" id="form_add_link4" value="<?php echo esc_attr( !empty( $form_add_link4 ) ? $form_add_link4 : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_add_link4_placeholder' ] ); ?>" />
                                    </div>
                                    <div class="clear"></div>
                                <?php endif; ?>
                                <?php
                            endif;
                        endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Additional Fields -->
                <?php
                if ( defined( 'CMPD_Settings::OPTION_ADD_FIELDS' ) ):
                    if ( $displayAdditionalFields ): ?>
                        <div class="cmpdc_settings_container">
                            <div class="row">
                                <div class="col_1">
                                    <h3>Custom Section</h3>
                                </div>
                            </div>
                            <!-- Additional Field 1 -->
                            <?php
                            $add_field1 = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_FIELDS_LABEL1 );
                            if ( !empty( $add_field1 ) ):
                                ?>
                                <div class="cmpdc_single_data">
                                    <label class="cmpdc_desc" for="form_add_field1">
                                        <?php echo esc_html( $data[ 'form_add_field1' ] ); ?>
                                    </label>
                                    <input type="text" class="cmpdc_input" name="form_add_field1" id="form_add_field1" value="<?php echo esc_attr( !empty( $form_add_field1 ) ? $form_add_field1 : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_add_field1_placeholder' ] ); ?>" />
                                </div>
                                <div class="clear"></div>
                            <?php endif; ?>

                            <!-- Additional Field 2 -->
                            <?php
                            $add_field2 = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_FIELDS_LABEL2 );
                            if ( !empty( $add_field2 ) ):
                                ?>
                                <div class="cmpdc_single_data">
                                    <label class="cmpdc_desc" for="form_add_field2">
                                        <?php echo esc_html( $data[ 'form_add_field2' ] ); ?>
                                    </label>
                                    <input type="text" class="cmpdc_input" name="form_add_field2" id="form_add_field2" value="<?php echo esc_attr( !empty( $form_add_field2 ) ? $form_add_field2 : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_add_field2_placeholder' ] ); ?>" />
                                </div>
                                <div class="clear"></div>
                            <?php endif; ?>

                            <!-- Additional Field 3 -->
                            <?php
                            $add_field3 = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_FIELDS_LABEL3 );
                            if ( !empty( $add_field3 ) ):
                                ?>
                                <div class="cmpdc_single_data">
                                    <label class="cmpdc_desc" for="form_add_field3">
                                        <?php echo esc_html( $data[ 'form_add_field3' ] ); ?>
                                    </label>
                                    <input type="text" class="cmpdc_input" name="form_add_field3" id="form_add_field3" value="<?php echo esc_attr( !empty( $form_add_field3 ) ? $form_add_field3 : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_add_field3_placeholder' ] ); ?>" />
                                </div>
                                <div class="clear"></div>
                            <?php endif; ?>

                            <!-- Additional Field 4 -->
                            <?php
                            $add_field4 = CMPD_Settings::getOption( CMPD_Settings::OPTION_ADD_FIELDS_LABEL4 );
                            if ( !empty( $add_field4 ) ):
                                ?>
                                <div class="cmpdc_single_data">
                                    <label class="cmpdc_desc" for="form_add_field4">
                                        <?php echo esc_html( $data[ 'form_add_field4' ] ); ?>
                                    </label>
                                    <input type="text" class="cmpdc_input" name="form_add_field4" id="form_add_field4" value="<?php echo esc_attr( !empty( $form_add_field4 ) ? $form_add_field4 : ''  ); ?>" placeholder="<?php echo esc_attr( $data[ 'form_add_field4_placeholder' ] ); ?>" />
                                </div>
                                <div class="clear"></div>
                            <?php endif; ?>

                        </div>
                        <div class="clear"></div>
                    <?php
                endif;
            endif;
            ?>

            <?php } ?>

            <!-- Product Gallery -->
            <div class="cmpdc_settings_container">

                <!-- Product Image #1 -->
                <div class="cmpdc_single_data">
                    <label for="form_gallery_image_1" class="cmpdc_desc">
                        <?php echo esc_html( $data[ 'form_add_gallery_image_1' ] ); ?>
                    </label>
                    <input type="hidden" id="form_gallery_image_1" name="form_gallery_image_1" value="<?php echo esc_attr( !empty( $form_gallery_image_1_id ) ? $form_gallery_image_1_id : ''  ); ?>" />
                    <input type="file" class="cmpdc_input" id="form_gallery_image_1" name="form_gallery_image_1"
                           <?php echo empty( $data[ 'form_add_gallery_image_1_mandatory' ] ) ? '' : 'required="required"'; ?> />
                           <?php if ( !empty( $form_gallery_image_1 ) ): ?>
                        <img class="cmpdc_preview" src="<?php echo esc_attr( $form_gallery_image_1 ); ?>" alt="Can't load the image" />
                    <?php endif; ?>
                </div>
                <div class="clear"></div>

                <!-- Product Image #2 -->
                <div class="cmpdc_single_data">
                    <label for="form_gallery_image_2" class="cmpdc_desc">
                        <?php echo esc_html( $data[ 'form_add_gallery_image_2' ] ); ?>
                    </label>
                    <input type="hidden" id="form_gallery_image_2" name="form_gallery_image_2" value="<?php echo esc_attr( !empty( $form_gallery_image_2_id ) ? $form_gallery_image_2_id : ''  ); ?>" />
                    <input type="file" class="cmpdc_input" id="form_gallery_image_2" name="form_gallery_image_2"
                    <?php echo empty( $data[ 'form_add_gallery_image_2_mandatory' ] ) ? '' : 'required="required"'; ?>
                           />
                           <?php if ( !empty( $form_gallery_image_2 ) ): ?>
                        <img class="cmpdc_preview" src="<?php echo esc_attr( $form_gallery_image_2 ); ?>" alt="Can't load the image" />
                    <?php endif; ?>
                </div>
                <div class="clear"></div>

                <!-- Product Image #3 -->
                <div class="cmpdc_single_data">
                    <label for="form_gallery_image_3" class="cmpdc_desc">
                        <?php echo esc_html( $data[ 'form_add_gallery_image_3' ] ); ?>
                    </label>
                    <input type="hidden" id="form_gallery_image_3" name="form_gallery_image_3" value="<?php echo esc_attr( !empty( $form_gallery_image_3_id ) ? $form_gallery_image_3_id : ''  ); ?>" />
                    <input type="file" class="cmpdc_input" id="form_gallery_image_3" name="form_gallery_image_3"
                    <?php echo empty( $data[ 'form_add_gallery_image_3_mandatory' ] ) ? '' : 'required="required"'; ?>
                           />
                           <?php if ( !empty( $form_gallery_image_3 ) ): ?>
                        <img class="cmpdc_preview" src="<?php echo esc_attr( $form_gallery_image_3 ); ?>" alt="Can't load the image" />
                    <?php endif; ?>
                </div>
                <div class="clear"></div>

                <!-- Product Image #4 -->
                <div class="cmpdc_single_data">
                    <label for="form_gallery_image_4" class="cmpdc_desc">
                        <?php echo esc_html( $data[ 'form_add_gallery_image_4' ] ); ?>
                    </label>
                    <input type="hidden" id="form_gallery_image_4" name="form_gallery_image_4" value="<?php echo esc_attr( !empty( $form_gallery_image_4_id ) ? $form_gallery_image_4_id : ''  ); ?>" />
                    <input type="file" class="cmpdc_input" id="form_gallery_image_4" name="form_gallery_image_4"
                    <?php echo empty( $data[ 'form_add_gallery_image_4_mandatory' ] ) ? '' : 'required="required"'; ?>
                           />
                           <?php if ( !empty( $form_gallery_image_4 ) ): ?>
                        <img class="cmpdc_preview" src="<?php echo esc_attr( $form_gallery_image_4 ); ?>" alt="Can't load the image" />
                    <?php endif; ?>
                </div>
                <div class="clear"></div>

            </div>
            <div class="clear"></div>

            <!-- Captcha -->
            <?php
            if ( !empty( $data[ 'captcha' ] ) ) {
                echo CMPDC_Recaptcha::getScript();
            }
            ?>

            <?php do_action( 'cmpdc_form_after', $data ); ?>

            <div class="communityProduct_button">
                <input <?php echo!empty( $data[ 'captcha' ] ) ? CMPDC_Recaptcha::getAtts() : ''; ?> class="button button-primary cmpdc_claim_button" name="cmpdc_form_submit" type="submit" value="<?php echo esc_html( $data[ 'form_button_text' ] ); ?>"/>
            </div>

            <div id="communityProduct_overlay" class="alert alert-info"><?php echo __( 'Please wait', 'cmt_community_product' ) . '...' ?></div>

        </form>

    </div> <!-- #communityProduct_wrapper -->
    <?php
endif;

if ( !$data[ 'allowAddProduct' ] ) {
    $first = 1;
    $roles = CMProductDirectoryCommunityProductBackend::getRoles();

    ob_start();
    echo '<div class="">';
    if ( isset( $data[ 'allow_roles' ] ) && is_array( $data[ 'allow_roles' ] ) ) {
        /* ML
         * Add the option to change the text displayed to unauthorized users according to settings
         */
        $text_to_display = CMProductDirectoryCommunityProduct::_prepareNotification( $data, get_option( CMProductDirectoryCommunityProductBackend::COMMUNITYPRODUCT_TEXT_UNAUTHORIZED ) );
        if ( !empty( $text_to_display ) ) {
            echo $text_to_display;
        } else {
            echo 'The suggest product form is displayed only for: <br/><div><b>';
            foreach ( $data[ 'allow_roles' ] as $key => $val ) {
                if ( $first === 0 ) {
                    echo ',';
                } else {
                    $first = 0;
                }
                echo ' ' . $roles[ $val ];
            }
            echo '</b></div>';
        }
    } else {
        echo 'Suggest product form is disabled.';

        $current_user = wp_get_current_user();
        if ( user_can( $current_user, 'administrator' ) ) {
            echo ' Go to <a href="' . get_admin_url() . 'edit.php?post_type=cm-product&page=cm-product-directory-settings#tab-comunity">Settings</a> to grant access.';
        }
    }
    echo '</div>';
    $output = apply_filters( 'cmpdc_form_not_allowed', ob_get_clean(), $data );
    echo $output;
}