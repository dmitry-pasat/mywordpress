jQuery( document ).ready( function ()
{
    jQuery( '#cmpdc_main_form' ).on( 'submit', function ( event )
    {
        event.preventDefault();
        var input_invalid = false;
        var textarea_invalid = false;
        var inputs = jQuery( '#cmpdc_main_form input' );
        var textareas = jQuery( '#cmpdc_main_form textarea' );
        var mandatoryText = 'Please fill in all mandatory fields: ';

        if ( typeof ( cmpdc_data ) !== 'undefined' )
        {
            if ( cmpdc_data.mandatory_text )
            {
                mandatoryText = cmpdc_data.mandatory_text;
            }
        }

        inputs.each( function ( entry )
        {
            var a = jQuery( this ).val();
            var attr = jQuery( this ).attr( 'required' );
            var disabled = jQuery( this ).is( ":disabled" );

            if ( typeof attr !== typeof undefined && attr !== false && jQuery( this ).val() == "" && !disabled )
            {
                input_invalid = true;
                var label = jQuery( this ).parent().find( 'label' ).html();
                label = label.replace( '*', '' );

                mandatoryText = mandatoryText + ' ' + label;
                return;
            }
        } );

        if ( cmpdc_data.textareas == false )
        {
            // as WP Editor
            tinyMCE.triggerSave();
            textareas.each( function ( entry )
            {
                var a = jQuery( this ).val();
                var attr = jQuery( this ).attr( 'required' );
                var disabled = jQuery( this ).is( ":disabled" );

                if ( typeof attr !== typeof undefined && attr !== false && jQuery( this ).val() == "" && !disabled )
                {
                    textarea_invalid = true;
                    var label = jQuery( this ).parents( '.wp-editor-wrap' ).parent().find( 'label' ).html();
                    label = label.replace( '*', '' );
                    mandatoryText = mandatoryText + ' ' + label;
                    return;
                }
            } );
        } else
        {
            // as textareas
            textareas.each( function ( entry )
            {
                var a = jQuery( this ).val();
                var attr = jQuery( this ).attr( 'required' );
                var disabled = jQuery( this ).is( ":disabled" );

                if ( typeof attr !== typeof undefined && attr !== false && jQuery( this ).val() == "" && !disabled )
                {
                    textarea_invalid = true;
                    var label = jQuery( this ).prev().html();
                    label = label.replace( '*', '' );
                    mandatoryText = mandatoryText + ' ' + label;
                    return;
                }
            } );
        }

        if ( input_invalid !== false || textarea_invalid !== false )
        {
            alert( mandatoryText );
        } else
        {
            var data = { };
            data['form_title'] = jQuery( 'input#form_title' ).val();

            if ( cmpdc_data.textareas == false )
            {
                // as WP Editor
                tinyMCE.triggerSave();
                data['form_description'] = jQuery( 'textarea#form_description' ).val();
                if ( !data['form_description'] )
                {
                    var content = tinyMCE.get( 'form_description' );
                    if ( content !== null )
                    {
                        data['form_description'] = content.getContent();
                    }
                }
                data['form_pitch'] = jQuery( 'textarea#form_pitch' ).val();
                if ( !data['form_pitch'] )
                {
                    var content = tinyMCE.get( 'form_pitch' );
                    if ( content !== null )
                    {
                        data['form_pitch'] = content.getContent();
                    }
                }
            } else
            {
                // as textarea
                data['form_description'] = jQuery( 'textarea#form_description' ).val();
                data['form_pitch'] = jQuery( 'textarea#form_pitch' ).val();
            }

            data['recaptcha_response_field'] = jQuery( '#g-recaptcha-response' ).val();

            data['form_year_founded'] = jQuery( 'select#form_year_founded' ).val();
            data['form_address'] = jQuery( 'input#form_address' ).val();
            data['form_cityTown'] = jQuery( 'input#form_cityTown' ).val();
            data['form_stateCounty'] = jQuery( 'input#form_stateCounty' ).val();
            data['form_postalcode'] = jQuery( 'input#form_postalcode' ).val();

            data['form_virtual_address'] = jQuery( 'input#form_virtual_address' ).is( ':checked' );
            data['form_add_google_map'] = jQuery( 'input#form_add_google_map' ).is( ':checked' );

            data['form_region'] = jQuery( 'input#form_region' ).val();
            data['form_country'] = jQuery( 'select#form_country' ).val();
            data['form_web_url'] = jQuery( 'input#form_web_url' ).val();
            data['form_bemail'] = jQuery( 'input#form_bemail' ).val();
            data['form_bemail_contact'] = jQuery( 'input#form_bemail_contact' ).val();
            data['form_facebook_name'] = jQuery( 'input#form_facebook_name' ).val();
            data['form_twitter_name'] = jQuery( 'input#form_twitter_name' ).val();
            data['form_google'] = jQuery( 'input#form_google' ).val();
            data['form_linkedin'] = jQuery( 'input#form_linkedin' ).val();
            data['form_rss'] = jQuery( 'input#form_rss' ).val();
            data['form_add_link1'] = jQuery( 'input#form_add_link1' ).val();
            data['form_add_link2'] = jQuery( 'input#form_add_link2' ).val();
            data['form_add_link3'] = jQuery( 'input#form_add_link3' ).val();
            data['form_add_link4'] = jQuery( 'input#form_add_link4' ).val();
            data['form_add_field1'] = jQuery( 'input#form_add_field1' ).val();
            data['form_add_field2'] = jQuery( 'input#form_add_field2' ).val();
            data['form_add_field3'] = jQuery( 'input#form_add_field3' ).val();
            data['form_add_field4'] = jQuery( 'input#form_add_field4' ).val();
            data['form_phone'] = jQuery( 'input#form_phone' ).val();

            data['form_categories'] = jQuery( 'select#form_categories' ).val();
            data['form_pricingmodel'] = jQuery( 'select#form_pricingmodel' ).val();
            data['form_languagesupport'] = jQuery( 'select#form_languagesupport' ).val();
            data['form_targetaudience'] = jQuery( 'select#form_targetaudience' ).val();

            data['form_video_url'] = jQuery( 'input#form_video_url' ).val();
            data['form_product_cost'] = jQuery( 'input#form_product_cost' ).val();
            data['form_page_link'] = jQuery( 'input#form_page_link' ).val();
            data['form_demo_link'] = jQuery( 'input#form_demo_link' ).val();
            data['form_purchase_link'] = jQuery( 'input#form_purchase_link' ).val();
            data['form_company_name'] = jQuery( 'input#form_company_name' ).val();

            data['form_gallery_image_1'] = jQuery( 'input#form_gallery_image_1' ).val();
            data['form_gallery_image_2'] = jQuery( 'input#form_gallery_image_2' ).val();
            data['form_gallery_image_3'] = jQuery( 'input#form_gallery_image_3' ).val();
            data['form_gallery_image_4'] = jQuery( 'input#form_gallery_image_4' ).val();

            data['form_user'] = jQuery( 'input#form_user' ).val();
            data['post_id'] = jQuery( 'input#post_id' ).val();

            //Assigning business
            data['form_assign_data'] = jQuery( 'input#cmpd_assign_data' ).val();
            data['form_select_busienss'] = jQuery( 'select#cmpd_select_busienss' ).val();

            var categories = [];
            jQuery('.cmpdc_checkbox.form_categories:checked').each(function() {
                categories.push(jQuery(this).val());
            });
            if ( categories.length !== 0 ) {
                data['form_categories'] = categories;
            }

            jQuery( '#communityProduct_overlay' ).show();

            var fd = new FormData();

            var file_data = jQuery( 'input[type="file"]' )[0].files;
            if ( file_data.length !== 0 )
            {
                fd.append( "form_product_image", file_data[0] );
            }
            var image_1 = jQuery( 'input[type="file"]' )[1].files;
            if ( image_1.length !== 0 ) {
                fd.append( 'form_gallery_image_1', image_1[0] );
            }
            var image_2 = jQuery( 'input[type="file"]' )[2].files;
            if ( image_2.length !== 0 ) {
                fd.append( 'form_gallery_image_2', image_2[0] );
            }
            var image_3 = jQuery( 'input[type="file"]' )[3].files;
            if ( image_3.length !== 0 ) {
                fd.append( 'form_gallery_image_3', image_3[0] );
            }
            var image_4 = jQuery( 'input[type="file"]' )[4].files;
            if ( image_4.length !== 0 ) {
                fd.append( 'form_gallery_image_4', image_4[0] );
            }
            fd.append( 'cmpdc', JSON.stringify( data ) );
            fd.append( 'action', 'save_post' );

            //var data_tmp=[];
            // data_tmp['action'] ='save_post_ajax';

            if ( typeof ( cmpdc_data ) !== 'undefined' )
            {
                jQuery.ajax(
                    {
                        url: cmpdc_data['ajaxurl'],
                        data: fd,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function ( response )
                        {
                            response = jQuery.parseJSON( response );
                            jQuery( '#communityProduct_msg' ).html( '<div class="alert alert-' + response.status + '">' + response.msg + '</div>' );
                            jQuery( '#communityProduct_msg' ).show();

                            if ( response.status === 'success' )
                            {
                                jQuery( '#communityProduct_overlay' ).hide();
                                jQuery( "input[type=text], input[type=email], textarea" ).val( "" );
                                jQuery( 'textarea#form_description' ).val( '' );
                                if ( typeof Recaptcha !== 'undefined' )
                                {
                                    Recaptcha.reload();
                                }

                                if ( response.redirect ) {
                                    setTimeout( function () {
                                        window.location.replace( response.redirect );
                                    }, 5000 );
                                }
                            }

                            if ( response.status === 'warning' )
                            {
                                jQuery( '#communityProduct_overlay' ).hide();
                                if ( typeof Recaptcha !== 'undefined' )
                                {
                                    Recaptcha.reload();
                                }
                            }

                            jQuery( 'html, body' ).animate(
                                {
                                    scrollTop: jQuery( "#communityProduct_wrapper" ).offset().top - 100
                                }, 1000 );
                            return true;
                        },
                        complete: function ()
                        {
                            jQuery( '#communityProduct_overlay' ).hide();
                        }
                    } );
            }
            return false;
        }
    } );
} );