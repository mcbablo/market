/*
 * Init 
 * @since 1.0.0
*/

(function( $ ) {
	"use strict";

    kallesTheme.Cart = {
        // Refesh mini icon Cart on ajax event
        refresIconCart : function( ) {
            $.ajax({
                type: 'POST',
                url: THE4_AjaxURL,
                dataType: 'json',
                data: { action: 'count_mini_cart' },
                success: function( data ) {
                    $( '.the4-icon-cart .count' ).text( data.cart_total );
                }
            });
        }
    }

})( jQuery );
