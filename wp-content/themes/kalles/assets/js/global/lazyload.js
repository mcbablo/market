/*
 * Lazyload
 * Using Lazysite library. https://github.com/aFarkas/lazysizes
 * @since 1.0.0
*/

(function( $ ) {
	"use strict";

	kallesTheme.lazyload = function() {

		if ( ! kallesTheme.is_lazyload ) return;

        $('.lazyloaded').closest('.the4-lazyload').removeClass('the4-lazyload');

        $(document).on('lazyloaded', function(e){
            var $image_parent = $(e.target).closest('.the4-lazyload');
            if ($image_parent.hasClass('the4-lazyload'))
                $image_parent.removeClass('the4-lazyload');

            //Product Zoom
            
            if ( kallesTheme.is_zoom ) {

            	var p_item = $(e.target).closest('.p-item');

	            if ( p_item.hasClass('the4-image-zoom')  && !window._inQuickview && ! kallesTheme.isMobile() )
	            {
	                if ( $('.the4-wc-single.wc-single-1').length == 0 && body.hasClass('single-product') ) {
	                    $(e.target).ezPlus( kallesTheme.t4_zoom_option );
	                }

	            }
            }
            
        });
    }

})( jQuery );

