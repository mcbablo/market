/* 
*
* Theme featured
* @since 1.1.2
*
*/

(function( $ ) {
	"use strict";

	/**
     * countdown banner
    **/
    kallesTheme.hTransparent = function () {

    	if ( $('#kalles_countdown_banner').length == 0 ) return;

        let h_banner = $('#kalles_countdown_banner'),
            h_ver    = h_banner.find( '.h__banner' ).attr( 'data-ver' ),
            txt_ver  = 'h_banner_' + h_ver;

        if ( typeof Cookies != 'undefined' ) {
                if ( Cookies.get( txt_ver ) === 'closed' ) return;
        }
        $('body').removeClass( 'h_calc_ready' );
        h_banner.css( "height", "" );

        let mt = h_banner.outerHeight();
        $('body').addClass( 'h_calc_ready' );
        h_banner.css( { height : 0 } );

        setTimeout( function () {
            h_banner.css( { height : mt } );
        }, 8 );

        setTimeout( function () {
            h_banner.css( { height : 'auto' } );
        }, 2000 );

        h_banner.on( 'click', '.h_banner_close', function ( e ) {
            e.preventDefault();

            let mt = h_banner.outerHeight();
            h_banner.css( { height : mt } );
            setTimeout( function () {
                h_banner.css( { height : 0 } );
            }, 8 );
            let date = parseInt( h_banner.find( '.h__banner' ).attr( 'data-date' ), 10 );

            if ( date ) {
                Cookies.set( txt_ver, 'closed', { expires : date, path : '/' } )
            }
        } );
    };

})( jQuery );


