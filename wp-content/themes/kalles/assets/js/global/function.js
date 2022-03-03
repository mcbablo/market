/* 
*
* Global function
* @since 1.1.2
*
*/

(function( $ ) {
	"use strict";


	// Check is mobile
    kallesTheme.isMobile = function() {
        return (/Android|iPhone|iPad|iPod|BlackBerry/i).test(navigator.userAgent || navigator.vendor || window.opera);
    }

    //Make radom image
    kallesTheme.GetRandomInt = function (min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    };

    kallesTheme.check_swatch = function() {
        $('.product form.cart .is-label.rounded').addClass('true-rounded');
        $('.product form.cart .is-label.rounded .swatch__list--item').each(function () {
            var w_label = $(this).find('.swatch__value').outerWidth();
            var h_label = $(this).find('.swatch__value').outerHeight();
            if( w_label !== h_label ){
            $(this).closest('.is-label.rounded').addClass('off-rounded');
            }

        });

    }
    kallesTheme.count_swatch = function() {
        $('.product-info .swatch__list:not(.count-over)').each(function () {
            var count = $(this).children('.swatch__list--item').length;
            if( count > 5 ){
                $(this).addClass('count-over');
                $(this).append('<span class="count-over-text">(+)</span>');
            }

        });
    }
})( jQuery );



