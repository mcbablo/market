/*
 * Sticky add to cart 
 * @since 1.0.0
*/

(function( $ ) {
	"use strict";
    
    var body = $('body'),
        $window  = $(window),
        window_w = $window.width(),
        is_rtl      = ( THE4_Data_Js['is_rtl'] === 'true' ),
        small767 = (window_w < 768 && $(window).height() < 768);

    //Zoom option. If product layout != #1. Set to inner zoom.
    if ( THE4_Data_Js['zoom_option'] ) {
        The4Kalles.t4_zoom_option = JSON.parse(THE4_Data_Js['zoom_option']);
        if ( $('.the4-wc-single').length > 0 ) {
            if ( $('.the4-wc-single.wc-single-2').length > 0 || $('.the4-wc-single.wc-single-3').length > 0 || $('.the4-wc-single.wc-single-4').length > 0 ) {
                The4Kalles.t4_zoom_option.zoomType = 'inner';
            }
        }
    }
    // Sticky add to cart
    The4Kalles.StickyAddToCart = function() {
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
        $('body').on('click', '.swatch__list--item', function( e ) {
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

    // 360 Image

    The4Kalles.Init360Image = function() {

         if ( $('.nt_mfp_360').length == 0 ) return;

         var threesixty,pr_id,
             pr_360_mfp = $('#pr_360_mfp'),
             args = pr_360_mfp.data('args');

         $('.nt_mfp_360').magnificPopup({
              items: {
                src: '#pr_360_mfp'
              },
             type           : 'inline',
             tClose         : 'Close',
             mainClass      : 'mfp-fade',
             removalDelay   : 160,
             disableOn      : false,
             preloader      : false,
             fixedContentPos: false,
             callbacks: {
               beforeOpen: function() {},
               open: function () {

                if ($('.threesixty.doned').length > 0) return;

                     threesixty = $('.threesixty').ThreeSixty({
                        totalFrames: args.total_frame, // Total no. of image you have for 360 slider
                        endFrame: args.total_frame, // end frame for the auto spin animation
                        currentFrame: 1, // This the start frame for auto spin
                        //framerate: 60,
                        imgList: '.threesixty_imgs', // selector for image list
                        progress: '.spinner', // selector to show the loading progress
                        imgArray: args.images,
                        autoplayDirection: 1,
                        height: args.height,
                        width: args.width,
                        drag: true,
                        navigation: true,
                        responsive: true
                    });

                    $('.threesixty').addClass('doned');

                },
                beforeClose: function () {
                  threesixty.stop();
                  $('.nav_bar_stop').removeClass("nav_bar_stop").addClass("nav_bar_play");
                },
                close: function () {}
             },

          });
    }

    //Read more product short description

    The4Kalles.shortDescriptionReadMore = function() {

        $('#short_description-readmore').click(function (e) {
            e.preventDefault();

            var id = '#tab-title-description';

            $(id+":not(.active) > a").trigger("click");

            $('html, body').stop().animate({
              scrollTop: $( id ).offset().top - 100
           }, 400);
        })
    }

    // Init prettyPhoto for WC 3.0
    The4Kalles.initPrettyPhoto = function () {

        if ( typeof $.fn.prettyPhoto == "function" ) {
            $( 'a.zoom' ).prettyPhoto({
                hook: 'data-rel',
                social_tools: false,
                theme: 'pp_woocommerce',
                horizontal_padding: 20,
                opacity: 0.8,
                deeplinking: false
            });
            $( 'a[data-rel^="prettyPhoto"]' ).prettyPhoto({
                hook: 'data-rel',
                social_tools: false,
                theme: 'pp_woocommerce',
                horizontal_padding: 20,
                opacity: 0.8,
                deeplinking: false
            });
        }
    }

    // Init image zoom
    The4Kalles.wcInitImageZoom = function() {
        if ( ! $('body').hasClass('single-product') ) return;
        if ( $( '.the4-image-zoom' ).length > 0 && ! window._inQuickview && ! The4Kalles.isMobile() ) {

            var product_images_wrap = $('.single-product-thumbnail .the4-carousel'),
                product_imgs = $(".the4-carousel .slick-current.p-item img");

            if (product_images_wrap.length > 0 ) {

                $(".the4-carousel .slick-current.p-item img").ezPlus(The4Kalles.t4_zoom_option);

                $(".the4-carousel").on("beforeChange", function(event,slick,currentSlide,nextSlide) {

                    $(".zoomContainer").remove();
                    setTimeout(function(){
                        $(".the4-carousel .slick-current.p-item img").ezPlus(The4Kalles.t4_zoom_option);
                    }, 10);
                });

            } else {

                $('.main-img-wrapper img').ezPlus(The4Kalles.t4_zoom_option);
                if ( ! is_lazyload )
                    $('.single-product-thumbnail .images:not(.the4-carousel) .p-item  img').ezPlus(The4Kalles.t4_zoom_option);
            }

            var lightbox_btn_close = $('.pswp__button--close');

            if (lightbox_btn_close.length > 0) {
                lightbox_btn_close.click(function(event) {

                    $(this).closest('.pswp').removeClass('pswp--supports-fs pswp--open pswp--notouch pswp--css_animation pswp--svg pswp--animated-in pswp--zoom-allowed pswp--visible');
                });
            }

        }
    }

    // Init slick carousel custom control
    The4Kalles.initCarouselCustom = function() {
        $( '.the4-carousel-custom-control' ).not( '.slick-initialized' ).slick(
            {
                infinite: false,
                verticalSwiping: true,
                prevArrow: $('.btn_pnav_prev'),
                nextArrow: $('.btn_pnav_next')
            }
        );
    }

    // Open video in popup
    The4Kalles.wcInitPopupVideo = function() {
        $(document).on('click', '.p-video .the4-popup-url', function(event){
            event.preventDefault();
            $.magnificPopup.open({
                disableOn: 0,
                items: {
                    src: $(this).attr('href')
                },
                type: 'iframe'
            });
        });
        $(document).on('click', '.p-video .the4-popup-mp4', function(event){
            event.preventDefault();
            $.magnificPopup.open({
                disableOn: 0,
                items: {
                    src: $(this).attr('href')
                },
                delegate: 'a',
                type: 'inline',
                callbacks: {
                    open: function() {
                        // Play video on open:
                        $(this.content).find('video')[0].play();

                    },
                    close: function() {
                        // Reset video on close:
                        $(this.content).find('video')[0].load();

                    }
                }
            });
        });
    }

    /*
     * Product images
     * Using Photoswipe library. https://photoswipe.com/
     * @since 1.0.0
     */
    The4Kalles.ProductImages = function() {
        if ( ! body.hasClass('single-product') ) return;

        var  $mainImages = $('.product .p-thumb'),
            PhotoSwipeTrigger = '.show_btn_pr_gallery';

        $('.the4-wc-single').on('click', '.single-product-img-link, .attachment-product-img-link', function (e) {
            e.preventDefault();
        });

        $('.the4-wc-single').on('click', PhotoSwipeTrigger, function (e) {
            e.preventDefault();

            // build items array
            var items = getProductImages(),
                thumb_item = getProductImages('thumb'),
                p_thumb = $('.pswp__thumbnails');


            var index = getCurrentGalleryIndex(e);
            if (index == -1) {
                index = 0;
            }

            callPhotoSwipe(index, items);

            if (p_thumb.length > 0 ) {
                p_thumb.html(thumb_item);
                $('.pswp_thumb_item:eq('+index+')').addClass('pswp_tb_active');
                adjustMobileThumbPosition();

            }

        });

        function getCurrentGalleryIndex (e) {

            if ($('.p-thumb.the4-carousel').hasClass('slick-initialized'))
                return $('.p-thumb.the4-carousel').find('.slick-slide.slick-active').index();
            else if ($(e.currentTarget).hasClass('show_btn_pr_gallery'))
                return 0
            else return $(e.currentTarget).index();
        };

        function getProductImages(getvl) {
            var images = [],
                _html = '',
                img_url = '{width}x';

            $('.p-thumb').find('.p-item img').each(function(index, el) {
                var src = $(this).attr( 'data-large_image' ),
                    width = $(this).attr( 'data-large_image_width' ),
                    height = $(this).attr( 'data-large_image_height' ),
                    caption = $(this).data( 'caption' );

                images.push({
                    src: src,
                    w: width,
                    h: height,
                    title: caption
                });

                _html += '<div class="pswp_thumb_item"><img class="lazyload lz_op_ef" src="data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20'+width+'%20'+height+'%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E" data-src="' + src + '" data-widths="[50, 100]" data-sizes="auto"></div>';

            });

            if ( getvl == 'thumb') {
                return _html;
            } else {
                return images;
            }
        }

        function callPhotoSwipe (index, items) {
            var pswpElement = document.querySelectorAll('.pswp_t4_js')[0],
                items_length = 0;
            $('.pswp_size_guide').removeClass('pswp_size_guide');
            $('.pswp_t4_js').addClass('pswp_pp_prs');

            var options = {
                history: false,
                maxSpreadZoom: 1, //nt_settings.maxSpreadZoom,
                bgOpacity: 1, //nt_settings.bgOpacity,
                showHideOpacity:($('.p-thumb').hasClass('nt_contain') || $('.p-thumb').hasClass('nt_cover')),
                index: index, // start at first slide
                shareButtons: [{
                    id: 'facebook',
                    label: 'Share on Facebook',
                    url: 'https://www.facebook.com/sharer/sharer.php?u={{url}}'
                },
                    {
                        id: 'twitter',
                        label: 'Twitt on Twitter',
                        url: 'https://twitter.com/intent/tweet?text={{text}}&url={{url}}'
                    },
                    {
                        id: 'pinterest',
                        label: 'Pin on Pinterest',
                        url: 'http://www.pinterest.com/pin/create/button/?url={{url}}&media={{image_url}}&description={{text}}'
                    }
                ],
                getThumbBoundsFn: function(index) {

                    var thumbnail = $(".p-item img")[0];
                    if ($mainImages.hasClass('the4-masonry')) {thumbnail = $(".p-thumb img").eq(index)[0];}

                    var pageYScroll = window.pageYOffset || document.documentElement.scrollTop, rect = thumbnail.getBoundingClientRect();
                    return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                }
            };

            // Initializes and opens PhotoSwipe
            var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);

            gallery.init();

            gallery.listen('afterChange', function() {

                if (is_rtl) {
                    var i = items_length - gallery.getCurrentIndex();
                } else {
                    var i = gallery.getCurrentIndex();
                }

                $('.pswp_tb_active').removeClass('pswp_tb_active');
                $('.pswp_thumb_item:eq('+i+')').addClass('pswp_tb_active');
                adjustMobileThumbPosition();
            });

            $('.pswp_t4_js').off('click').on('click', '.pswp_thumb_item', function() {
                if (is_rtl) {
                    var i = items_length - $(this).index();
                } else {
                    var i = $(this).index();
                }
                gallery.goTo(i)

            });

            gallery.listen('close', function() {

                setTimeout(function(){
  
                    $('.pswp_pp_prs').attr('class', 'pswp pswp_t4_js pswp_tp_light');
                }, 500);

                if (is_rtl) {
                    var i = items_length - gallery.getCurrentIndex();
                } else {
                    var i = gallery.getCurrentIndex();
                }
                $( '.the4-carousel' ).slick( 'slickGoTo', i );

            });

        };

        function adjustMobileThumbPosition (){
            if (! small767 ) return;
            var selectedThumb = $('.pswp_tb_active')[0],
                $pswp__thumb = $('.pswp__thumbnails'),
                thumbContainer = $pswp__thumb[0],
                thumbBounds = selectedThumb.getBoundingClientRect(),
                thumbWrapperBounds = thumbContainer.getBoundingClientRect();

            if (thumbBounds.left + thumbBounds.width > thumbWrapperBounds.width) {

                $pswp__thumb.animate({scrollLeft: selectedThumb.offsetLeft + thumbBounds.width - thumbWrapperBounds.width + 10}, 200);
            } else if (selectedThumb.offsetLeft < thumbContainer.scrollLeft) {
                $pswp__thumb.animate({scrollLeft: selectedThumb.offsetLeft - 10}, 200);
            }
        };

    }

    $( document ).ready( function() {
        The4Kalles.initPrettyPhoto();
        The4Kalles.Init360Image();
        The4Kalles.StickyAddToCart();
        The4Kalles.shortDescriptionReadMore();
        The4Kalles.wcInitImageZoom();
        The4Kalles.initCarouselCustom();
        The4Kalles.wcInitPopupVideo();
        The4Kalles.ProductImages();
    })

})( jQuery );
