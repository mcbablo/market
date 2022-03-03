/*
 * Init Quickview
 * @since 1.0.0
*/

(function( $ ) {
	"use strict";

    // Product quick view
    window._inQuickview = false;
    kallesTheme.initQuickView = function() {

        $( 'body' ).on( 'click', '.btn-quickview', function(e) {

            e.preventDefault();
            e.stopPropagation();

            var _this = $( this ),
                res = null,
                id    = _this.attr( 'data-prod' ),
                data  = { action: 'the4_quickview', product: id };

            if ( kallesTheme.sp_nt_storage ) { res = sessionStorage.getItem( 'qv' + id ) }

            if ( res != null ) {
                _this.addClass('the4-loading');

                if ($.magnificPopup.instance.isOpen) {
                $.magnificPopup.close();
                   setTimeout(function(){  quickview_js( res, false, id ); }, $.magnificPopup.instance.st.removalDelay+10);

                   _this.removeClass('the4-loading')
                } else {
                  quickview_js( res, false, id );
                  _this.removeClass('the4-loading')
                }

            } else {
                _this.addClass('the4-loading');
                $.post( THE4_AjaxURL, data, function( response ) {
                    quickview_js( response, true, id);

                    _this.removeClass('the4-loading')
                });
            }

            window._inQuickview = true;

            
        });

        var quickview_js = function( response, bl, id ) {

            $.magnificPopup.open({
                items: {
                    src: response,
                    type: 'inline',
                },
                mainClass: 'mfp-fade mfp-move-horizontal',
                removalDelay: 800
            });

            setTimeout(function() {
                if ( $( '.product-quickview form' ).hasClass( 'variations_form' ) ) {
                    $( '.product-quickview form.variations_form' ).wc_variation_form();
                    $( '.product-quickview select' ).trigger( 'change' );
                }
            }, 100);
            if ( $( '.wpa-wcpb-list' ).length > 0 && window._inQuickview ) {
                setTimeout(function() {
                    $.PLT.main_product_variation_select();
                    $.PLT.main_product_variation_load_default();
                    $.PLT.product_bundle_variation_select();
                    wpa_wcpb_onchange_input_check_total_discount();

                }, 1000);
            }

            
            //Init check swatch
            kallesTheme.check_swatch();
            //Init count swatch
            kallesTheme.count_swatch();
            kallesTheme.initCarousel();

            kallesTheme.productGlobal.init();

            $( '.images' ).imagesLoaded( function() {
                $('.single-product-thumbnail').find('.the4-lazyload').removeClass('the4-lazyload');
                var imgHeight = $( '.product-quickview .images' ).outerHeight();

            });

            if(kallesTheme.sp_nt_storage && bl) {
            sessionStorage.setItem('qv'+ id, response)
          }
        }
    }

})( jQuery );
