/*
 * Sticky add to cart 
 * @since 1.0.0
*/

(function( $ ) {
	"use strict";
    
    // Sticky add to cart
    kallesTheme.StickyAddToCart = function() {
        var $trigger = $('.entry-summary form.cart');
        var $stickyBtn = $('.sticky_atc_wrap');

        if ($stickyBtn.length <= 0 || $trigger.length <= 0 || (window_w < 768 && $stickyBtn.hasClass('mobile_false'))) return;

        var summaryOffset     = $trigger.offset().top + $trigger.outerHeight(),
            back_to_top       = $('#the4-backtop'),
            $selector         = $('.sticky_atc_wrap'),
            _footer           = $( '#the4-footer' ),
            off_footer        = 0,
            ck_footer         = _footer.length > 0;

        var stickyAddToCartToggle = function () {
            var windowScroll = $(window).scrollTop(),
                windowHeight = $(window).height(),
                documentHeight = $(document).height();
            if (ck_footer) {
                off_footer = _footer.offset().top - _footer.height();
            } else {
                off_footer = windowScroll;
            }

            if (windowScroll + windowHeight == documentHeight || summaryOffset > windowScroll || windowScroll > off_footer ) {
                $selector.removeClass('sticky_atc_shown');
                back_to_top.removeClass('sticky_atc_shown');
            } else if (summaryOffset < windowScroll && windowScroll + windowHeight != documentHeight) {

                $selector.addClass('sticky_atc_shown');
                back_to_top.addClass('sticky_atc_shown');
            }
        };
        stickyAddToCartToggle();

        $(window).scroll(stickyAddToCartToggle);

        $('.sticky_atc_a').on('click', function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('.entry-summary').offset().top
            }, 800);
        });



        //StickyLabelVariant();
        $(body).on('click', '.swatch__list--item', function( e ) {
            StickyLabelVariant();

            //Display selected variant on product page
            var _this        = $(this),
                variant_name = _this.data( 'variation' ),
                swatch_title = _this.parent().prev();

            if ( variant_name  && swatch_title) {
                var name = swatch_title.data('name');

                swatch_title.html( name.toUpperCase() + ': ' + variant_name.toUpperCase() );
            }
        });
        //Price
        var product_price = $('.summary .price').html();
        if ( product_price ) {
            $('.sticky_atc_price .price').html(product_price);
        }
        // Quantity.
        var _qtyProduct = $('.entry-summary .quantity input').val();
        if (_qtyProduct) {
            $('.sticky_atc_wrap .sticky_input').val(_qtyProduct);
        }

        $('.sticky_atc_wrap .sticky_input').on('change', function(){
            $('.entry-summary .quantity input').val($(this).val())

        });

        $('.entry-summary .quantity input').on('change', function(){
            $('.sticky_atc_wrap .sticky_input').val($(this).val());
        });

        var sticky_addtocart_btn = $('.sticky_add_to_cart_btn');
        //Triggle when found variant
        $(document).on( 'found_variation', 'form.cart', function( event, variation ) {
            if ( sticky_addtocart_btn.hasClass('disabled'))
                sticky_addtocart_btn.removeClass('disabled');
        });

        //Add to cart btn
        sticky_addtocart_btn.click(function(e) {
            e.preventDefault();
            $('.single_add_to_cart_button').trigger('click');
            if ( $(this).hasClass('disabled') ) {
                $('html, body').animate({
                    scrollTop: $('.entry-summary').offset().top
                }, 800);
            } else {
                $(this).addClass('the4-loading');
            }
        });
    }


})( jQuery );
