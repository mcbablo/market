/*
 * Init masonry layout
 * @since 1.0.0
*/

(function( $ ) {
	"use strict";

	kallesTheme.initMasonry = function() {
		
        if ( window_w < 1024 && $('body').hasClass('tax-product_cat') ) return;

        var el = $( '.the4-masonry' );

        if ( el.length == 0 ) return;
        
        el.each( function( i, val ) {
            var _option = $.parseJSON($( this ).attr( 'data-masonryjs' ));

            if ( _option !== undefined ) {
                var _selector = _option.selector,
                    _width    = _option.columnWidth,
                    _layout   = _option.layoutMode,
                    _rtl      = _option.rtl;

                $( this ).imagesLoaded( function() {
                    $( val ).isotope( {
                        layoutMode : _layout,
                        itemSelector: _selector,
                        percentPosition: true,
                        isOriginLeft: _rtl,
                        masonry: {
                            columnWidth: _width
                        }
                    } );
                    setTimeout(function(){
                        $( val ).isotope('layout');
                    }, 200);
                });

                $( '.the4-filter a' ).click( function() {
                    var selector = $( this ).data( 'filter' ),
                        parent   = $( this ).parents( '.the4-filter' );

                    $( val ).isotope({ filter: selector });

                    // don't proceed if already selected
                    if ( $( this ).hasClass( 'selected' ) ) {
                        return false;
                    }

                    parent.find( '.selected' ).removeClass( 'selected' );
                    $( this ).addClass( 'selected' );

                    return false;
                });
            }
        });
    }

})( jQuery );
