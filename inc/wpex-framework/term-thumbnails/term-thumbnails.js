( function( $ ) {

	'use strict';

	$( document ).on( 'ready', function() {

		var $thumbnailField = $( '#wpex_term_thumbnail' );

		// Make sure field exists
		if ( ! $thumbnailField.length ) return;

		// Only show the "remove image" button when needed
		if ( ! $thumbnailField.val() ) {
			$( '.wpex-remove-term-thumbnail' ).hide();
		}

		// Uploading files
		var file_frame;
		var $thumbImg    = $( '.wpex-term-thumbnail-img' );
		var $removeField = $( '.wpex-remove-term-thumbnail' );

		// Run on click
		$( document ).on( 'click', '.wpex-add-term-thumbnail', function( event ) {

			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( file_frame ) {
				file_frame.open();
				return;
			}

			// Create the media frame.
			file_frame = wp.media.frames.downloadable_file = wp.media({
				title    : wpexTermThumbnails.title,
				button   : {
					text : wpexTermThumbnails.button,
				},
				multiple : false
			} );

			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				var attachment = file_frame.state().get( 'selection' ).first().toJSON();
				$thumbnailField.val( attachment.id );
				$thumbImg.attr( 'src', attachment.url );
				$removeField.show();
			} );

			// Finally, open the modal.
			file_frame.open();

		} );

		$removeField.click( function() {
			$thumbImg.attr( 'src', wpexTermThumbnails.placeholder );
			$thumbnailField.val( '' );
			$removeField.hide();
			return false;
		} );

	} );

} ) ( jQuery );