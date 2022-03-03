<?php
/**
 * Description
 *
 * @package Kalles
 * @version 1.0.0
 * @author  The4
 */

if ( ! defined('ABSPATH' ) ) {
	exit;
}

// Enqueue Color Picker.
wp_enqueue_script( 'wp-color-picker' );
wp_enqueue_style( 'wp-color-picker' );

// Enqueue WordPress's media manager.
wp_enqueue_media();
?>
<div class="form-field t4-color-wrap">
	<label for="t4-color"><?php esc_html_e( 'Color', 'kalles' ); ?></label>
	<input name="t4_color" id="t4-color" type="text" value="">
</div>
<div class="form-field t4-image-wrap">
	<label for="t4-image"><?php _e( 'Thumbnail', 'kalles' ); ?></label>

	<img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" />

	<a href="javascript:void(0)" class="button t4-image-upload">
		<?php esc_html_e( 'Upload/Add image', 'kalles' ); ?>
	</a>

	<a href="javascript:void(0)" class="button t4-image-remove">
		<?php esc_html_e( 'Remove', 'kalles' ); ?>
	</a>

	<input type="hidden" name="t4_image" id="t4-image" type="text" value="">
	<p><?php esc_html_e( 'This option will be overridden color.', 'kalles' ); ?></p>
</div>
<div class="form-field t4-tooltip-wrap">
	<label for="t4-tooltip"><?php esc_html_e( 'Tooltip', 'kalles' ); ?></label>
	<input name="t4_tooltip" id="t4-tooltip" type="text" value="">
</div>
<script type="text/javascript">
	( function( $ ) {
		$( document ).ready( function() {
			$( '#t4-color' ).wpColorPicker();

			$( '.t4-image-upload' ).click( function( e ) {
				e.preventDefault();

				// Store clicked element for later reference
				var btn = $( this ), img = btn.prev(), input = btn.next(), manager = btn.data( 't4_image_select' );

				if ( ! manager) {
					// Create new media manager.
					manager = wp.media({
						button: {
							text: '<?php esc_html_e( 'Select',  'kalles' ); ?>',
						},
						states: [
							new wp.media.controller.Library({
								title: '<?php esc_html_e( 'Select an image',  'kalles' ); ?>',
								library: wp.media.query({type: 'image'}),
								multiple: false,
								date: false,
							})
						]
					});

					// When an image is selected, run a callback
					manager.on( 'select', function() {
						// Grab the selected attachment
						var attachment = manager.state().get( 'selection' ).first();

						// Update the field value
						input.val( attachment.attributes.url ).trigger( 'change' );
						img.attr( 'src', attachment.attributes.url );
					});

					// Store media manager object for later reference
					btn.data( 't4_image_select', manager );
				}

				manager.open();
			});
			$( '.t4-image-remove' ).click( function( e ) {
				e.preventDefault();

				var btn = $( this ), img = btn.prev().prev(), input = btn.next();

				img.attr( 'src', '<?php echo esc_url( wc_placeholder_img_src() ); ?>' );
				input.val( '' );
			});
		});
	})(jQuery);
</script>
