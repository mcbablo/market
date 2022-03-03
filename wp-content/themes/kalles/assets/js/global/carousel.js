/*
 * Init slick carousel
 * @since 1.0.0
*/

(function( $ ) {
	"use strict";

	kallesTheme.initCarousel = function() {
		
        $( '.the4-carousel-ins' ).not( '.slick-initialized' ).slick();

        $( '.the4-carousel' ).not( '.slick-initialized' ).slick();

        // Reset the index of image on product variation
        $( 'body' ).on( 'found_variation', '.variations_form', function( ev, variation ) {

            if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
                var exist = $('.p-thumb .p-item img[data-large_image="'+variation.image.full_src+'"]');
                if (exist.length > 0) {
                    var index = exist.parents('.p-item').attr('data-slick-index');
                    $( '.product .the4-carousel' ).slick( 'slickGoTo', index);
                }
            }
        });
    }

    // Init slick carousel custom control
    kallesTheme.initCarouselCustom = function() {
        $( '.the4-carousel-custom-control' ).not( '.slick-initialized' ).slick(
            {
                infinite: false,
                verticalSwiping: true,
                prevArrow: $('.btn_pnav_prev'),
                nextArrow: $('.btn_pnav_next')
            }
        );
    }

})( jQuery );
