/*
 * Init sidebar
 * @since 1.0.0
*/

(function( $ ) {
	"use strict";

	kallesTheme.initSidebar = function() {
		// Open search form
        $( '.sf-open' ).on( 'click', function( e ) {
            e.preventDefault();

            var classOpen = $(this).data('open');

            if ( ! classOpen ) return;
            
            var mask = $('.mask-overlay');
            mask.addClass('mask_opened');

            $( 'body' ).toggleClass( classOpen );

            $( '.mask-overlay, .close-cart' ).on( 'click', function() {
                $( 'body' ).removeClass( classOpen );
                mask.removeClass('mask_opened');
            });

            $( 'body' ).removeClass( 'popup-opened' );
        });

        // Init push on header
        // 
        $( 'a.the4-push-menu-btn' ).on( 'click', function (e) {
            e.preventDefault();

            $( 'body' ).toggleClass( 'menu-opened' );

            var mask = $('.mask-overlay');
            mask.addClass('mask_opened');

            $( '.mask-overlay, .close-menu' ).on( 'click', function() {
                $( 'body' ).removeClass( 'menu-opened' );
                mask.removeClass('mask_opened');
            });
        });
        $('body').on( 'click', '.mb_nav_tabs>div', function () {
            if ( $( this ).hasClass( 'active' ) ) return;
            let _this = $( this ), menuID = _this.data( 'id' );

            _this.parent().find( '.active' ).removeClass( 'active' );
            _this.addClass( 'active' );
            $( '.mb_nav_tab' ).removeClass( 'active' );
            $( menuID ).addClass( 'active' );
        } );


    }

})( jQuery );
