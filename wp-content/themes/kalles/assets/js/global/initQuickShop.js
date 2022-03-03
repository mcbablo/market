/*
 * Init Quickshop
 * @since 1.0.0
*/

(function( $ ) {
	"use strict";
    
    // Product quick Shop
    window._inQuickShop = false;
    kallesTheme.initQuickShop = function() {

        $('body').on( 'click', '.js__qs, .product_type_variable.quick_shop_js', function(e) {
            var _this = $( this ),
                id    = _this.attr( 'data-product_id' ),
                cart_key = _this.attr('data-cart-item'),
                data  = {
                    action: 'the4_quickshop',
                    product: id,
                    cart_key: cart_key };

            if ( _this.hasClass('js__qs') ) {
                _this.addClass('loading');
                _this.find('svg').css('opacity', '0');
                var main_action_class = 'editcart-action';
            } else {
                _this.addClass('the4-loading');

                var main_action_class = 'quickshop-action';
            }



            $.post( THE4_AjaxURL, data, function( response ) {
                $.magnificPopup.open({
                    items: {
                        src: response,
                        type: 'inline',
                    },
                    mainClass: 'mfp-fade ' + main_action_class,
                    removalDelay: 800
                });

                setTimeout(function() {
                    if ( $( '.product-quickshop form' ).hasClass( 'variations_form' ) ) {
                        $( '.product-quickshop form.variations_form' ).wc_variation_form();
                        $( '.product-quickshop select' ).trigger( 'change' );
                    }
                }, 100);
                if ( $( '.wpa-wcpb-list' ).length > 0 && window._inQuickShop ) {
                    setTimeout(function() {
                        $.PLT.main_product_variation_select();
                        $.PLT.main_product_variation_load_default();
                        $.PLT.product_bundle_variation_select();
                        wpa_wcpb_onchange_input_check_total_discount();

                    }, 1000);
                }

                if ( _this.hasClass('js__qs') ) {
                    _this.removeClass('loading');
                    _this.find('svg').css('opacity', '1');
                } else {
                    _this.removeClass('the4-loading');
                }
                
                //Init check swatch
                kallesTheme.check_swatch();
                //Init count swatch
                kallesTheme.count_swatch();
                kallesTheme.initCarousel();

            });
            e.preventDefault();
            e.stopPropagation();
            window._inQuickShop = true;
        });

        $( 'body' ).on( 'click', '.single-product-img-link', function( e ) {
            e.preventDefault();

        })

        $( 'body' ).on( 'click', '.quickshop-action .single_add_to_cart_button', function(e) {
            e.preventDefault();

            var _this = $( this ), _form = _this.parents( 'form' );

            if ( _this.hasClass( 'disabled' ) || $( '.btn-atc' ).hasClass( 'no-ajax' ) ) return;
            $ld.trigger( "ld_bar_star" );
            $.ajax({
                type: 'POST',
                url: THE4_SiteURL + "?wc-ajax=the4-ajax",
                dataType: 'html',
                data: _form.serialize(),
                cache: false,
                headers: { 'cache-control': 'no-cache' },
                beforeSend: function() {
                    _this.addClass('the4-loading');
                },
                success:function() {

                    OpenMiniCart( false );
                    _this.removeClass('the4-loading');
                    $.magnificPopup.close();
                    $ld.trigger( "ld_bar_end" );

                }
            });

            return false;
        });

        $( 'body' ).on( 'click', '.editcart-action .single_add_to_cart_button:not(.disabled)', function(e) {
            e.preventDefault();
            var _this = $( this ),
                _form = _this.parents( 'form' ),
                cart_key = _this.parents('.product-quickshop').data('cart'),
                cart_threshold = $('.widget_shopping_cart_content .cart_threshold'),
                clicked_ed_js = 'clicked_ed_js',
                security_code = _this.data('skey');


            $.ajax({
                type: 'POST',
                url: THE4_AjaxURL,
                //dataType: 'html',
                data: {
                    action: 'the4_kalles_edit_mini_cart',
                    product_data: _form.serialize(),
                    cart_key: cart_key,
                    security_code: security_code
                },
                beforeSend: function() {
                    _this.addClass('the4-loading ' + clicked_ed_js);
                },
                success:function(response) {
                    setTimeout( function() {
                        $( '.fa-spinner' ).remove();
                    }, 480);
                    var cart_item = $('.cart-item-' + response.pid);
                    cart_item.attr('data-cart-item', response.pdata_key);
                    cart_item.find('.mini_cart_title').text(response.pname);
                    cart_item.find('.cart_meta_variant').text(response.item_variants);
                    cart_item.find('.mini-cart-pimg').html(response.pimg);
                    cart_item.find('.cart__mini-qty--input').val(response.pqty);
                    cart_item.find('.cart_ac_edit').attr('data-cart-item', response.cart_key);

                    kallesTheme.Cart.refresIconCart();

                    cart_threshold.html(response.free_shipping);

                    $('.woocommerce-mini-cart__total > .amount').html(response.cart_total);

                    $('.mfp-close').trigger('click');
                }
            });

            return false;
        });
    }

})( jQuery );
