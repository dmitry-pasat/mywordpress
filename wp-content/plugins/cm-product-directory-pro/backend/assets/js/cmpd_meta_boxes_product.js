// jQuery( function( $ ) {
jQuery(document).ready(function($){

	// Product gallery file uploads
	var product_gallery_frame;
	var $image_gallery_ids = $( '#cmpd_product_image_gallery' );
	var $product_images    = $( '.cmpd_product_gallery_container' ).find( 'ul.cmpd_product_images' );

	jQuery( '.cmpd_add_product_images' ).on( 'click', 'a', function( event ) {
		var $el = $( this );

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( product_gallery_frame ) {
			product_gallery_frame.open();
			return;
		}

		// Create the media frame.
		product_gallery_frame = wp.media.frames.product_gallery = wp.media({
			// Set the title of the modal.
			title: $el.data( 'choose' ),
			button: {
				text: $el.data( 'update' )
			},
			states: [
				new wp.media.controller.Library({
					title: $el.data( 'choose' ),
					filterable: 'all',
					multiple: true
				})
			]
		});

		// When an image is selected, run a callback.
		product_gallery_frame.on( 'select', function() {
			var selection = product_gallery_frame.state().get( 'selection' );
			var attachment_ids = $image_gallery_ids.val();

			selection.map( function( attachment ) {
				attachment = attachment.toJSON();

				if ( attachment.id ) {
					attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
					var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

					$product_images.append( '<li class="cmpd_image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '"></a></li></ul></li>' );
				}
			});

			$image_gallery_ids.val( attachment_ids );
		});

		// Finally, open the modal.
		product_gallery_frame.open();
	});

	// Remove images
	$( '.cmpd_product_gallery_container' ).on( 'click', 'a.delete', function() {
		$( this ).closest( 'li.image' ).remove();

		var attachment_ids = '';

		$( '.cmpd_product_gallery_container' ).find( 'ul li.cmpd_image' ).css( 'cursor', 'default' ).each( function() {
			var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
			attachment_ids = attachment_ids + attachment_id + ',';
		});

		$image_gallery_ids.val( attachment_ids );

		// remove any lingering tooltips
		$( '#tiptip_holder' ).removeAttr( 'style' );
		$( '#tiptip_arrow' ).removeAttr( 'style' );

		return false;
	});
});
