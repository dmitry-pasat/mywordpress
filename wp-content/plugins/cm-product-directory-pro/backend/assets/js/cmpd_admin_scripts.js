
( function ( $ ) {
    $.fn.extend( {
        limiter: function ( limit, elem ) {
            $( this ).on( "keyup focus", function () {
                setCount( this, elem );
            } );
            function setCount( src, elem ) {
                var chars = src.value.length;
                if ( chars > limit ) {
                    src.value = src.value.substr( 0, limit );
                    chars = limit;
                }
                elem.html( limit - chars );
            }
            setCount( $( this )[0], elem );
        }
    } );

    $( document ).ready( function ( $ ) {

        $( '.cmpd_field_help' ).tooltip( {
            show: {
                effect: "slideDown",
                delay: 100
            },
            position: {
                my: "left top",
                at: "right top"
            },
            content: function () {
                var element = $( this );
                return element.attr( 'title' );
            },
            close: function ( event, ui ) {
                ui.tooltip.hover(
                    function () {
                        $( this ).stop( true ).fadeTo( 400, 1 );
                    },
                    function () {
                        $( this ).fadeOut( "400", function () {
                            $( this ).remove();
                        } );
                    } );
            }
        } );

        var which_one = 0;
        var conntainer = document.getElementsByClassName( 'cmpd_metabox_settings_container' )[0];
        if ( conntainer !== undefined && conntainer !== null ) {
            var mapCanvas = document.getElementById( 'cmpd-map-canvas' );
            var cmpd_image = document.getElementById( 'cmpd_image' );
            var width = document.getElementsByClassName( 'cmpd_metabox_settings_container' )[0].offsetWidth - ( 120 + 300 + 40 ); //120 label, 300 input 20 margin and padding
            if ( width > 320 ) {
                width = 320;
            }
            // var width = mapCanvas.offsetWidth - 50 + "px";
            if ( mapCanvas !== undefined && mapCanvas !== null ) {
                mapCanvas.style.width = width + "px";
                mapCanvas.style.height = width + "px";
            }

            if ( cmpd_image !== undefined && cmpd_image !== null ) {
                cmpd_image.style.width = width + "px";
                cmpd_image.style.height = width + "px";
            }
        }

        var orig_send_to_editor = window.send_to_editor;

        $( '#image' ).click( function () {
            which_one = 2;
            tb_show( 'Upload an image', 'media-upload.php?referer=cmpd_add_new_product&amp;type=image&amp;TB_iframe=true&amp;post_id=0', false );

            //restore send_to_editor() when tb closed
            jQuery( "#TB_window" ).bind( 'tb_unload', function () {
                window.send_to_editor = orig_send_to_editor;
            } );

            window.send_to_editor = function ( selectedImg ) {
                var startIndex = selectedImg.indexOf( '"' ) + 1;
                var endIndex = selectedImg.indexOf( '"', startIndex );
                var image_url = selectedImg.substring( startIndex, endIndex );
                if ( which_one == 1 ) {
                    $( '#thumbnail_adr' ).val( image_url );
                } else {
                    $( '#image_adr' ).val( image_url );
                }
                tb_remove();
            };

            return false;
        } );

        $( '#date' ).datepicker( { showAnim: 'fadeIn' } );
        $( 'input[type="color"]' ).wpColorPicker();

//        $('input[type="text"]').each(function (i, obj) {
//            var displayLimit = $(obj).after('<span class="cmpd-display-limit"></span>').next('.cmpd-display-limit');
//            $(obj).limiter(100, displayLimit);
//        });

        // Product gallery file uploads
        var product_gallery_frame;
        var $cmpd_image_gallery_ids = $( '#cmpd_product_gallery_id' );
        var $product_images = $( 'div#cmpd_product_images_container ul' );
        var cmpd_image = document.getElementById( 'cmpd_add_product_image' );
        if ( cmpd_image !== undefined && cmpd_image !== null ) { //check if it's edit post page
            $( '#cmpd_add_product_image' ).on( 'click', function ( event ) {

                var $el = $( this );
                var attachment_ids = $cmpd_image_gallery_ids.val();

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( product_gallery_frame ) {
                    product_gallery_frame.open();
                    return;
                }

                // Create the media frame.
                product_gallery_frame = wp.media.frames.product_gallery = wp.media( {
                    // Set the title of the modal.
                    title: $el.data( 'choose' ),
                    button: {
                        text: $el.data( 'update' ),
                    },
                    states: [
                        new wp.media.controller.Library( {
                            title: $el.data( 'choose' ),
                            filterable: 'all',
                        } )
                    ]
                } );

                // When an image is selected, run a callback.
                product_gallery_frame.on( 'select', function () {

                    var selection = product_gallery_frame.state().get( 'selection' );

                    selection.map( function ( attachment ) {

                        attachment = attachment.toJSON();

                        if ( typeof attachment.id != "undefined" ) {
                            attachment_ids = attachment.id;
                            $product_images.find( 'li' ).remove();
                            var width = document.getElementsByClassName( 'cmpd_metabox_settings_container' )[0].offsetWidth - ( 120 + 300 + 40 ); //120 label, 300 input 20 margin and padding
                            if ( width > 320 ) {
                                width = 320;
                            }
                            $product_images.append( '\
                    <li class="image" data-attachment_id="' + attachment.id + '">\
                <img width="' + width + '" height="' + width + '" src="' + attachment.url + '" />\
            <ul class="cmpd_actions">\
        <li><a href="#" class="delete" title="Delete"><strong>[x]</strong></a></li>\
        </ul>\
        </li>' );
                        }

                    } );

                    $cmpd_image_gallery_ids.val( attachment_ids );
                } );

                // Finally, open the modal.
                product_gallery_frame.open();
            } );

            // Remove images
            $( '#cmpd_product_images_container' ).on( 'click', 'a.delete', function () {
                $( this ).closest( 'li.image' ).remove();

                var attachment_ids = '';

                $( '#cmpd_product_images_container ul li.image' ).css( 'cursor', 'default' ).each( function () {
                    var attachment_id = $( this ).attr( 'data-attachment_id' );
                    attachment_ids = attachment_ids + attachment_id + ',';
                } );

                $cmpd_image_gallery_ids.val( attachment_ids );

                return false;
            } );

            $( ".cmpd_product_images" ).sortable( {
                start: function ( e, o ) {
                },
                drag: function ( e ) {
                },
                stop: function ( e, o ) {
                    reorder();
                }
            } );

            $( ".cmpd_product_images" ).disableSelection();
        }
    } );

    $( window ).resize( function () {

        var conntainer = document.getElementsByClassName( 'cmpd_metabox_settings_container' )[0];
        if ( conntainer !== undefined && conntainer !== null ) {
            var mapCanvas = document.getElementById( 'cmpd-map-canvas' );
            var cmpd_image = document.getElementById( 'cmpd_image' );
            var width = conntainer.offsetWidth - ( 120 + 300 + 40 ); //120 label, 300 input 20 margin and padding
            if ( width > 320 ) {
                width = 320;
            }
            // var width = mapCanvas.offsetWidth - 50 + "px";
            if ( mapCanvas !== undefined && mapCanvas !== null ) {
                mapCanvas.style.width = width + "px";
                mapCanvas.style.height = width + "px";
            }
            if ( cmpd_image !== undefined && cmpd_image !== null ) {
                cmpd_image.style.width = width + "px";
                cmpd_image.style.height = width + "px";
            }
        }
    } );

    var reorder = function () {
        var attachment_ids = "";
        $( ".cmpd_product_images li" ).each( function () {
            if ( typeof $( this ).attr( 'data-attachment_id' ) != 'undefined' ) {
                attachment_ids += ( ( attachment_ids.length > 0 ) ? ',' : '' ) + $( this ).attr( 'data-attachment_id' );
            }
        } );

        $( '#cmpd_product_gallery_id' ).val( attachment_ids );
    };

} )( jQuery );