/*
 * Init Dropdown Menu
 * @since 1.0.0
*/

(function( $ ) {
	"use strict";
    
    kallesTheme.initMobieDropdownMenu = function() {

        $( '#the4-mobile-menu ul li.has-sub' ).append( '<span class="holder"></span>' );

        $( 'body' ).on('click','.holder',function() {
            var el = $( this ).closest( 'li' );
            if ( el.hasClass( 'open' ) ) {
                el.removeClass( 'open' );
                el.find( 'li' ).removeClass( 'open' );
                el.find( 'ul' ).slideUp();
            } else {
                el.addClass( 'open' );
                el.children( 'ul' ).slideDown();
                el.siblings( 'li' ).children( 'ul' ).slideUp();
                el.siblings( 'li' ).removeClass( 'open' );
                el.siblings( 'li' ).find( 'li' ).removeClass( 'open' );
                el.siblings( 'li' ).find( 'ul' ).slideUp();
            }
        });
    }

})( jQuery );
