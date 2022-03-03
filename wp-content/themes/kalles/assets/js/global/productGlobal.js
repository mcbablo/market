/*
 * Init Product global function
 * @since 1.0.0
*/

(function( $ ) {
	"use strict";
    
    kallesTheme.productGlobal = {

        init: function() {
            this.ATC_animation('.type-product .single_add_to_cart_button');
            this.Real_time();
            this.FlashSold();
            this.Progressbar();
            this.DeliveryOrder();
            this.SelectedVariantion();
            this.ClickVariant();
            this.BuynowBtnCheckVariant();
            this.t4DiscountPrice();
        },

        // T4 Discount Price
        t4DiscountPrice : function() {

            // Single add to cart button
            $( 'body' ).on( 'click', '.t4_discount_qty_btn_add', function(e) {

                var _this = $( this ), _form = _this.parents( 'form' );

                $ld.trigger( "ld_bar_star" );

                var data_form = _form.serialize(),
                    form_qty      = _form.find('.qty').val(),
                    product_id    = _this.data( 'product_id' ),
                    qty           = _this.data( 'quantity' ),
                    data          = data_form.replace( 'quantity=' + form_qty, 'quantity=' + qty);

                $.ajax({
                    type: 'POST',
                    url: THE4_SiteURL + "?wc-ajax=the4-ajax",
                    dataType: 'html',
                    data: data,
                    cache: false,
                    headers: { 'cache-control': 'no-cache' },
                    beforeSend: function() {
                        _this.addClass('the4-loading');
                    },
                    success:function() {

                        _this.removeClass('the4-loading');
                        OpenMiniCart( false );
                        if ( $.magnificPopup.instance.isOpen ) $.magnificPopup.close();

                        var sticky_addtocart_btn = $('.sticky_add_to_cart_btn');
                        if (sticky_addtocart_btn.length > 0 && sticky_addtocart_btn.hasClass('the4-loading'))
                            sticky_addtocart_btn.removeClass('the4-loading');
                        $ld.trigger( "ld_bar_end" );
                    }
                });

                return false;
            });

            if ( $( '.cart-moved' ).length > 0 ) {
                $( '.btn-atc' ).appendTo( '.cart-moved' );
            }


        },

        ATC_animation : function (id) {
            var $id = $(id);
            if ($id.length == 0 || $id.data('ani') == 'none') return;

            var animation = "animated "+$id.data('ani'),
                intervalTime = parseInt($id.data('time')) * 1000,
                animTime = 1000;

            function ATC_animation() {
                setInterval(function() {
                    $id.addClass(animation);
                    setTimeout(function(){
                        $id.removeClass(animation);
                    }, animTime);
                }, intervalTime);
            };
            ATC_animation();
        },

        //Product live view
        Real_time : function () {

            var $el = $('#the4-kalles-product-liveview');

            if ($el.length == 0) return;

            var min      = $el.data('min'),
                max      = $el.data('max'),
                interval = $el.data('interval'),
                o        = kallesTheme.GetRandomInt(min,max),
                n        = ["1", "2", "4", "3", "6", "10", "-1", "-3", "-2", "-4", "-6"],
                l        = ["10", "20", "15"],
                h        = "",
                e        = "",
                M        = "";

            var ShowView = function () {

                if (h = Math.floor(Math.random() * n.length), e = n[h], o = parseInt(o) + parseInt(e), min >= o) {
                    M = Math.floor(Math.random() * l.length);
                    var a = l[M];
                    o += a
                }
                if (o < min || o > max) {
                    o = kallesTheme.GetRandomInt(min,max);
                }
                $el.find(".count").html((parseInt(o)));
                $el.show();

            }
            ShowView();
            setInterval(ShowView, interval);
        },

        //Product live view
        FlashSold : function () {
            var $el = $('#the4-kalles-product-flash-sale');
            if ($el.length == 0) return;

            var mins = $el.data('mins'),
                maxs = $el.data('maxs'),
                mint = $el.data('mint'),
                maxt = $el.data('maxt');

            $el.find(".nt_pr_sold").html(kallesTheme.GetRandomInt(mins,maxs));
            $el.find(".nt_pr_hrs").html(kallesTheme.GetRandomInt(mint,maxt));
            $el.show();
        },

        //Product delivery order
        DeliveryOrder : function () {

            var selectorCurent = $('#the4-kalles-product-delivery_time');

            if (selectorCurent.length == 0) return;

            var today            = new Date(),
                today2           = new Date(),i = 0,
                today3           = new Date(),j = 0,
                getDate          = today.getDate(),
                dateStart        = selectorCurent.data("ds") || 0,
                dateEnd          = selectorCurent.data("de") || 0,
                mode             = selectorCurent.data("mode"),
                frm              = selectorCurent.data("frm"),
                time             = selectorCurent.data("time").replace("24:00:00", "23:59:59") || '19041994',
                arr              = ["SUN","MON","TUE","WED","THU","FRI","SAT"],
                excludeDays      = selectorCurent.data("cut").replace(/ /g,'').split(","),
                order_bltimezone = selectorCurent.data("timezone"),
                local_time       = (kallesTheme.bltimezone && order_bltimezone) ? kallesTheme.timezoneDay.format('HHmmss') : kallesTheme.day_t4_js.format('HHmmss'),
                timeint          = time.replace(/ /g,'').replace(/:/g,''),
                arr_d            = time.replace(/ /g,'').split(':'),
                local_date       = kallesTheme.day_t4_js.format('YYYY/MM/DD'),
                shopt            = (kallesTheme.bltimezone && order_bltimezone) ? kallesTheme.timezoneDay.format('YYYY/MM/DD') : local_date;
            local_date       = shopt + ' ' + time;

            //Get Today
            var getToday = function(setday, format, day, dayfulljs) {
                var arrd       = THE4_Data_Js['order_day'].replace(/ /g,'').split(","),
                    arrm       = THE4_Data_Js['order_mth'].replace(/ /g,'').split(","),
                    days       = ArrUnique(arrd),
                    months     = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
                    monthNames = ArrUnique(arrm),
                    d = (day !== '') ? new Date(day) : new Date();
                d.setDate(d.getDate()+setday);

                var getDate = d.getDate(),
                    ww          = days[d.getDay()],
                    dd          = ("0" + getDate).slice(-2),
                    dst         = day_suffix(getDate),
                    mm          = months[d.getMonth()], //January is 0! today.getMonth()+1
                    mmn         = monthNames[d.getMonth()],
                    yyyy        = d.getFullYear();

                switch(format) {
                    case 0:
                        // 19940419
                        return yyyy+''+mm+''+dd;
                        break;
                    case 1:
                        // Wednesday, 19th April
                        return ww+', '+dst+' '+mmn;
                        break;
                    case 2:
                        // Wednesday, 19th April 2019
                        return ww+', '+dst+' '+mmn+' '+yyyy;
                        break;
                    case 3:
                        // Wednesday, 19th April, 2019
                        return ww+', '+dst+' '+mmn+', '+yyyy;
                        break;
                    case 4:
                        // Wednesday, April 19th, 2019
                        return ww+', '+mmn+' '+dst+', '+yyyy;
                        break;
                    case 5:
                        // Wednesday, April 19th
                        return ww+', '+mmn+' '+dst;
                        break;
                    case 6:
                        // Wednesday, April 19th 2019
                        return ww+', '+mmn+' '+dst+' '+yyyy;
                        break;
                    case 7:
                        // Wednesday, April 19
                        return ww+', '+mmn+' '+dd;
                        break;
                    case 8:
                        // Wednesday, April 19 2019
                        return ww+', '+mmn+' '+dd+' '+yyyy;
                        break;
                    case 9:
                        // Wednesday, 04/19/2019
                        return ww+', '+mm+'/'+dd+'/'+yyyy;
                        break;
                    case 10:
                        // Wednesday, 19/04/2019
                        return ww+', '+dd+'/'+mm+'/'+yyyy;
                        break;
                    case 11:
                        // 2019/04/19 use countdown
                        return yyyy+'/'+mm+'/'+dd;
                        break;
                    default:
                        // Wednesday, 2019/04/19, case:20
                        return ww+', '+yyyy+'/'+mm+'/'+dd;
                }
            };
            var ArrUnique = function(arr) {
                var onlyUnique = function (value, index, self) {
                    return self.indexOf(value) === index;
                };
                return arr.filter( onlyUnique );
            };

            var day_suffix = function(n) {
                if (n >= 11 && n <= 13) {return n+"th";}
                switch (n % 10) {
                    case 1:  return n+"st";
                    case 2:  return n+"nd";
                    case 3:  return n+"rd";
                    default: return n+"th";
                }
            };

            if (kallesTheme.bltimezone && order_bltimezone) {
                var lastDay = The4KallesGetDateCountdown(local_date);
            } else {
                var lastDay = new Date(local_date);
            }

            if (parseInt(local_time) >= parseInt(timeint)) lastDay.setDate(lastDay.getDate()+1);

            if (mode == '2') {
                // Shipping + delivery

                // START DATE
                today2.setDate( getDate );
                while (i < dateStart) {
                    i++;
                    today2.setDate( today2.getDate() + 1 );
                    if (excludeDays.indexOf(arr[today2.getDay()]) > -1) {
                        i--;
                    }
                }

                selectorCurent.find(".start_delivery").html(getToday(0,frm,today2));

                // END DATE
                today3.setDate( getDate );
                while (j < dateEnd) {
                    j++;
                    today3.setDate( today3.getDate() + 1 );
                    if (excludeDays.indexOf(arr[today3.getDay()]) > -1) {
                        j--;
                    }
                }
                selectorCurent.find(".end_delivery").html(getToday(0,frm,today3));

            } else {
                // only delivery

                today2.setDate( getDate + dateStart - 1 );

                do {

                    today2.setDate( today2.getDate() + 1 );

                } while (excludeDays.indexOf(arr[today2.getDay()]) > -1);

                selectorCurent.find(".start_delivery").html(getToday(0,frm,today2));

                today3.setDate( getDate + dateEnd - 1 );
                do {

                    today3.setDate( today3.getDate() + 1 );

                } while (excludeDays.indexOf(arr[today3.getDay()]) > -1);

                selectorCurent.find(".end_delivery").html(getToday(0,frm,today3));

            }

            if (time != '19041994') {
                var $id = selectorCurent.find('.h_delivery');
                $id.countdown(lastDay, {elapse: true})
                    .on('update.countdown', function (event) {
                        if (event.elapsed) {

                        } else {
                            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                            $id.html( event.strftime(totalHours+' '+THE4_Data_Js['hrs']+' %M '+ THE4_Data_Js['mins'] ) );
                        }
                    });
            }

            selectorCurent.show();


        },

        //Product page stock left progressbar
        Progressbar: function () {

            var $id = $('#the4-kalles-product-left-stock');
            var qty = $id.data('cur');
            if ($id.length == 0) return;

            $id.removeAttr('data-ttcalc');
            var pr_id = $id.data('prid');
            var updateMeter = function (a, remaining_items,bgprocess,bgten) {

                remaining_items =  parseInt(remaining_items);
                if(kallesTheme.sp_nt_storage) {sessionStorage.setItem('probar'+pr_id, remaining_items)}
                total_items = $id.attr('data-ttcalc') || (total_items > remaining_items) ? total_items : remaining_items + total_items;
                $id.attr('data-ttcalc',total_items);

                var b = 100 * remaining_items / total_items,
                    color = (remaining_items < 10) ? bgten : bgprocess;
                a.find('.progressbar>div').css("background-color", color);

                setTimeout(function () {
                    a.find('.progressbar>div').css('width', b + '%');

                }, 300);
            };

            var total_items               = parseInt($id.data('total')),
                min_items_left            = parseInt($id.data('min')),
                max_items_left            = parseInt($id.data('max')),
                dt_type                   = $id.data('type'),
                mode                      = $id.data('st'),
                limit                     = $id.data('qty'),
                bgprocess                 = $id.data('bgprocess'),
                bgten                     = $id.data('bgten'),
                timer                     = null,
                timerinterval             = null,
                min_of_remaining_items    = 1,
                decrease_after            = 1.7,
                decrease_after_first_item = 0.17;

            if ((mode == 3 && qty >= limit) || mode == 2) {
                var remaining_items =  kallesTheme.GetRandomInt(min_items_left, max_items_left);
            } else {
                var remaining_items = qty || kallesTheme.GetRandomInt(min_items_left, max_items_left);
            }
            if(kallesTheme.sp_nt_storage && dt_type == 'ATC_NONE') {
                var getse_re = sessionStorage.getItem('probar'+pr_id);
                if (getse_re > 0) {
                    remaining_items = getse_re;
                }
            }

            $id.find(".count").text(remaining_items).css({'background-color': '#fff','color': bgprocess});
            $id.find('.mess_cd').show();
            $id.find('.message').show();
            $id.find('.progressbar').show();
            updateMeter($id, remaining_items,bgprocess,bgten);

            if (dt_type == 'ATC') return;

            timer = setTimeout(function () {

                remaining_items--;
                if (remaining_items < min_of_remaining_items) {
                    remaining_items = qty || kallesTheme.GetRandomInt(min_items_left, max_items_left)
                }
                $id.find('.count').css({'background-color': bgprocess,'color': '#fff'});
                setTimeout(function () {
                    $id.find('.count').css({'background-color': '#fff','color': bgprocess});
                }, 1000 * 60 * 0.03);
                $id.find('.count').text(remaining_items);
                updateMeter($id, remaining_items,bgprocess,bgten)
            }, 1000 * 60 * decrease_after_first_item);


            timerinterval = setInterval(function () {
                remaining_items--;

                if (remaining_items < min_of_remaining_items) {
                    remaining_items = qty || kallesTheme.GetRandomInt(min_items_left, max_items_left)
                }
                $id.find('.count').css({'background-color': bgprocess,'color': '#fff'});
                setTimeout(function () {
                    $id.find('.count').css({'background-color': '#fff','color': bgprocess});
                }, 1000 * 60 * 0.03);
                $id.find(".count").text(remaining_items);
                updateMeter($id, remaining_items,bgprocess,bgten)
            }, 1000 * 60 * decrease_after);

            $id.bind("cleart", function(){
                clearTimeout(timer);
                clearInterval(timerinterval);
            });

        },

        //Buy now button check variant

        BuynowBtnCheckVariant : function() {
            var buynow_btn = $( '.btn-buy-now.type_variable' ),
                add_to_cart_button = $( '.single_add_to_cart_button' );

            if ( buynow_btn.length == 0 ) return;

            buynow_btn.click( function( e ) {
                if ( add_to_cart_button.is('.wc-variation-is-unavailable') ) {
                    window.alert( wc_add_to_cart_variation_params.i18n_unavailable_text );
                    e.preventDefault();
                } else if ( add_to_cart_button.is('.wc-variation-selection-needed') ) {
                    window.alert( wc_add_to_cart_variation_params.i18n_make_a_selection_text );
                    e.preventDefault();
                } else {
                    var variant_id = $( 'input[name=variation_id]').val();
                    if ( variant_id ) {
                        var url = buynow_btn.attr( 'href' );

                        buynow_btn.attr( 'href', url + '=' + variant_id);

                    } else {
                        e.preventDefault();
                        window.alert( wc_add_to_cart_variation_params.i18n_make_a_selection_text );
                    }
                }
            });
         },

         //Change variations image
        ChangeImage : function(productId, galleries, galleryKey, first, selected_variant_id = '') {
            var images,
                formData        = $( '.variations_form' ).data( 'product_variations' ),
                thumb_stype     = $( '.variations_form' ).data( 'thumb_style' ),
                thumb_position  = $( '.variations_form' ).data( 'thumb_position' ),
                usedImages      = [],
                output_gal      = [],
                selectedAttr    = {},
                output_thumb    = [],
                changeVariation = false,
                zoom_class      = '',
                kalles_lazy = ( THE4_Data_Js['is_lazy_kalles'] == 'true' ) ? 'the4-lazyload' : '';

            //Check zoom is enable
            if ( THE4_Data_Js['is-zoom'] != '0' )
                zoom_class = 'the4-image-zoom';


            //If gallery have 1 picture, go to Picture
            if ( typeof( galleries[galleryKey] ) !== 'undefined'
                    && galleries[galleryKey] !== null
                    && galleries[galleryKey].length == 1 ) {

                if (thumb_stype == '1') {
                    if ( ! window._inQuickview ) {
                        var thum_slide = $('.p-nav').find('.slick-slide[data-variation="' + selected_variant_id +'"]'),
                        slideIndex = $( thum_slide ).data('slick-index');
                    } else {
                        var thum_slide = $('.p-thumb').find('.slick-slide[data-variation="' + selected_variant_id +'"]'),
                        slideIndex = $( thum_slide ).data('slick-index');
                    }

                    if ( slideIndex != 'undefined' ) {
                        $( '.product .the4-carousel' ).slick( 'slickGoTo', slideIndex );
                    }
                    return;
                } else {
                    return;
                }

            }
            //Delete window Zoom
                var zoom_dom = $('.zoomContainer');
                if (zoom_dom) {
                    zoom_dom.each(function(index, el) {
                        $(el).remove();
                    });
                }

            if ( typeof( galleries[galleryKey] ) !== 'undefined'
                    && galleries[galleryKey] !== null ) {
                images = galleries[galleryKey];

            } else {

                images = galleries['default_gallery'];

                $.each( formData, function ( index, variation ) {
                    $.each( selectedAttr, function ( attrName, attrValue ) {
                        if ( variation['attributes']['attribute_' + attrName + ''] !== '' && variation['attributes']['attribute_' + attrName + ''] == attrValue && $.inArray( variation['image']['full_src'], usedImages ) === -1) {
                            changeVariation = variation['image'];
                            // image of variation
                            output_gal += '<div class="' + kalles_lazy + ' p-item woocommerce-product-gallery__image">';
                            output_gal += '<a href="' + changeVariation['full_src'] + '" >';
                            output_gal += '<img width="' + changeVariation['src_w'] + '" height="' + changeVariation['src_h'] + '" src="' + changeVariation['src'] + '" class="lazyload attachment-shop_single size-shop_single" data-src="' + changeVariation['src'] + '" data-large_image="' + changeVariation['full_src'] + '" data-large_image_width="' + changeVariation['full_src_w'] + '" data-large_image_height="' + changeVariation['full_src_h'] + '"/>';
                            output_gal += '</a></div>';

                            output_thumb += '<div>';
                            output_thumb += '</div>';

                            usedImages.push( changeVariation['full_src'] );
                        }
                    });
                });
            }

            //Product Image sticky add to cart
            if ( $('.sticky_atc_wrap').length > 0 ) {
                if ( typeof galleries[galleryKey] != 'undefined' )
                {
                    var sticky_img = $('.sticky_atc_thumb img');
                    sticky_img.removeClass('lazyloaded');
                    sticky_img.attr('src', galleries[galleryKey][0].thumbnail);
                    sticky_img.attr('data-srcset', galleries[galleryKey][0].thumbnail);
                    sticky_img.addClass('lazyloaded');
                } else {
                    var sticky_img = $('.sticky_atc_thumb img');
                    sticky_img.removeClass('lazyloaded');
                    sticky_img.attr('src', galleries['default_gallery'][0].thumbnail);
                    sticky_img.attr('data-srcset', galleries['default_gallery'][0].thumbnail);
                    sticky_img.addClass('lazyloaded');
                }
            }

            // Get image gallery
            if (usedImages.length != 1 ) {
                $.each( images, function ( index, image ) {
                    if ( image['single'] == undefined ) {
                        var img_single = image['thumbnail'];
                    } else {
                        var img_single = image['single'];
                    }
                    if ( $.inArray( img_single, usedImages ) === -1) {

                        output_gal += '<div class="' + kalles_lazy + ' p-item woocommerce-product-gallery__image ' + zoom_class + '">';
                        output_gal += '<a class="single-product-img-link" href="' + image['data-large_image'] + '">';
                        output_gal += '<img width="' + image['single_w'] + '" height="' + image['single_h'] + '" src="' + img_single + '" class="lazyload attachment-shop_single size-shop_single" data-src="' + image['data-src'] + '" data-large_image="' + image['data-large_image'] + '" data-large_image_width="' + image['data-large_image_width'] + '" data-large_image_height="' + image['data-large_image_height'] + '"/>';
                        output_gal += '</a></div>';
                        if ( images.length > 1 ) {
                            output_thumb += '<div>';
                            output_thumb += '<img src="' + image['thumbnail'] + '" />';
                            output_thumb += '</div>';
                        }


                        usedImages.push( img_single );

                        if (changeVariation && changeVariation['gallery_thumbnail_src'] == image['thumbnail']) {
                            changeVariation = index;
                        }
                    }
                });
            }
            //PhotoSwipe btn
            //Gallery image btn
            var gallery_photoswipe_btn = '<div class="kalles_product_image_action pa"><div class="kalles-product-gallery-btn p_group_btns flex"><button class="br__40 tc flex al_center fl_center bghp_ show_btn_pr_gallery ttip_nt tooltip_top_left"><i class="t4_icon_expand-arrows-alt-solid"></i><span class="tt_txt">Click to enlarge</span></button></div></div>';
            //Main Image
            if ( window._inQuickview || window._inQuickShop)   {
                var output = '<div class="main-img-wrapper pr"><div class="p-thumb images the4-carousel woocommerce-product-gallery" data-slick=\'{"focusOnSelect": true, "slidesToShow": 1, "slidesToScroll": 1, "fade":true, "dots":true, "rtl":' + _rtl + '}\'>' + output_gal + '</div>';
            } else {
                if ( thumb_stype == '1') {
                    var output = '<div class="main-img-wrapper pr"><div class="p-thumb images the4-carousel woocommerce-product-gallery" data-slick=\'{"focusOnSelect": true, "slidesToShow": 1, "slidesToScroll": 1, "fade":true, "dots":false,  "rtl":' + _rtl + '}\'>' + output_gal + '</div>';
                } else if (thumb_stype == '2') {
                    var output = '<div class="main-img-wrapper pr"><div class="p-thumb images woocommerce-product-gallery the4-masonry" data-masonryjs=\'{"selector":".p-item", "layoutMode":"masonry", "rtl":' + _rtl + '}\'>' + output_gal + '</div>';
                } else {
                    if ( window_w < 736 ) {
                        var output = '<div class="main-img-wrapper pr"><div class="p-thumb images the4-carousel woocommerce-product-gallery" data-slick=\'{"responsive":[{"breakpoint": 736,"settings":{"slidesToShow": 1, "vertical": false, "arrows": true, "rtl":' + _rtl + '}}]}\'>' + output_gal + '</div>';
                    } else {
                        var output = '<div class="main-img-wrapper pr"><div class="p-thumb images woocommerce-product-gallery">' + output_gal + '</div>';
                    }
                }
                //PhotoSwipe btn
                output += gallery_photoswipe_btn;

                //Video btn
                var product_video_btn = document.querySelectorAll('.p-video');
                if ( product_video_btn.length > 0 ) {
                    output += product_video_btn[0].outerHTML;
                }

                output += '</div>' //End .main-img-wrapper
                //Thumb slider
                if ( thumb_stype == '1' && thumb_position != 'outside') {
                    output += '<div class="kales-thumb-outsite">';

                    if ( thumb_position == 'left' || thumb_position == 'right') {
                        output += '<div class="p-nav oh the4-carousel" data-slick=\'{"slidesToShow": 4,"slidesToScroll": 1,"asNavFor": ".p-thumb","arrows": false, "focusOnSelect": true, "vertical": true, "responsive":[{"breakpoint": 736,"settings":{"slidesToShow": 4, "vertical":false, "rtl":' + _rtl + '}}]}\'>' + output_thumb + '</div>';

                    } else {
                        output += '<div class="p-nav oh the4-carousel" data-slick=\'{"slidesToShow": 4,"slidesToScroll": 1,"asNavFor": ".p-thumb","arrows": false, "focusOnSelect": true, "rtl":' + _rtl + ', "responsive":[{"breakpoint": 736,"settings":{"slidesToShow": 4, "vertical":false, "rtl":' + _rtl + '}}]}\'>' + output_thumb + '</div>';

                    }

                    output += '</div>' //End .kales-thumb-outsite

                } else {
                    // Gallery Outside
                    var outside_gal = '<div class="p-nav oh the4-carousel p-nav-outside" data-slick=\'{"slidesToShow": 4,"slidesToScroll": 1,"asNavFor": ".p-thumb","arrows": false, "focusOnSelect": true, "rtl":' + _rtl + ', "responsive":[{"breakpoint": 736,"settings":{"slidesToShow": 4, "vertical":false, "rtl":' + _rtl + '}}]}\'>' + output_thumb + '</div>';

                }

            }


            var product_img_wrap = $( '#product-' + productId + ' .single-product-thumbnail' );

            setTimeout( function() {
                if (usedImages.length != 1) {
                    $('.single-product-thumbnail').removeClass('no-nav');
                } else {
                    $('.single-product-thumbnail').addClass('no-nav');
                }
                if ( first ) { // Check if default vartions
                    product_img_wrap.html( output );
                    // Gallery Outside
                    if ( thumb_position == 'outside' ) {
                        $('.kales-thumb-outsite').html(outside_gal);
                    }
                } else {
                    product_img_wrap.hide().html( output ).fadeIn(400);
                    // Gallery Outside
                    if ( thumb_position == 'outside' ) {
                        $('.kales-thumb-outsite').hide().html( outside_gal ).fadeIn(400);
                    }
                }

            }, 100);

            setTimeout(function() {

                if ( window._inQuickview ) {
                    //Remove fix height after init
                    $( '.the4-carousel' ).on('init', function ( event, slick ) {
                        $('#content_quickview').css('height', 'auto');
                    })
                    //init Slick slider
                    $( '.the4-carousel' ).not( '.slick-initialized' ).slick({focusOnSelect: true, adaptiveHeight: true});

                } else if ( window._inQuickShop ) {

                    //Remove fix height after init
                    $( '.the4-carousel' ).on('init', function ( event, slick ) {
                        $('.single-product-thumbnail').css('height', 'auto');
                    })
                    $( '.the4-carousel' ).not( '.slick-initialized' ).slick({focusOnSelect: true, adaptiveHeight: true, dots: false});
                } else {

                    if (thumb_stype == '1') {
                        $( '.the4-carousel' ).not( '.slick-initialized' ).slick({focusOnSelect: true, adaptiveHeight: true});
                        if ($.isNumeric(changeVariation)) {
                            $( '.product .the4-carousel' ).slick( 'slickGoTo', changeVariation );
                        }
                        var zoom_selector =  $(".slick-active.p-item img");
                        //Init Zoom
                        initZoomVariantion(zoom_selector);

                        $(".the4-carousel").on("beforeChange", function(event,slick,currentSlide,nextSlide) {

                            $(".zoomContainer").remove();
                            setTimeout(function(){
                                if ( body.hasClass('single-product') ) {
                                    $(".the4-carousel .slick-current.p-item img").ezPlus(kallesTheme.t4_zoom_option);
                                }
                            }, 10);
                        });
                        // Reset the index of image on product variation
                        $( 'body' ).on( 'found_variation', '.variations_form', function( ev, variation ) {
                            if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
                                var exist = $('.the4-carousel.p-thumb .p-item img[data-large_image="'+variation.image.full_src+'"]');
                                if (exist.length > 0) {
                                    var index = exist.parents('.p-item').attr('data-slick-index');
                                    $( '.product .the4-carousel' ).slick( 'slickGoTo', index);
                                }
                            }
                        });
                    } else if ( thumb_stype == '2' ) {
                        kallesTheme.initMasonry();
                        var zoom_selector = $('.single-product-thumbnail .p-item  img');
                        initZoomVariantion(zoom_selector);
                    } else {
                        var zoom_selector = $('.single-product-thumbnail .p-item  img');
                        initZoomVariantion(zoom_selector);
                    }
                }
            }, 200);


            var initZoomVariantion = function( selector ) {
                if ( $( '.the4-image-zoom' ).length > 0
                    && ! window._inQuickview
                    && body.hasClass('single-product')
                    && ! kallesTheme.isMobile() ) {

                    selector.ezPlus(kallesTheme.t4_zoom_option);

                }
            }
        },

        // Change Main image and gallery for Default variant.
        SelectedVariantion : function () {

            var swatches_list = $('.swatch__list > li'),
                is_default_vanriant = false;

            if ( swatches_list.length  == 0 )
                return;
            var data_variant = {};
            $.each(swatches_list , function (index, item){
                if ( $(item).hasClass( 'is-selected' ) ) {

                    var data_var = $(item).data('variation'),
                        data_attr = $(item).parent().data('attribute');

                    data_variant[data_attr] = data_var;

                    is_default_vanriant = true;

                }
            });
            var data_gallery = $('.variations_form').data('galleries'),
                product_id = $('.variations_form').data('product_id'),
                key_variant = '';

            $.each(data_variant, function(key, value) {

                var check = '_product_image_gallery_' + key + '-' + value;
                if ( typeof( data_gallery[check] ) !== 'undefined' && data_gallery[check] !== null ) {
                    key_variant = check;
                    return false;
                }
            });
            if ( key_variant ) {
                kallesTheme.productGlobal.ChangeImage(product_id, data_gallery, key_variant, true);
            }
        },

        // Change Main image and gallery when click change variant.
        ClickVariant : function () {

            $('body').on('afterChange','.single-product-thumbnail .p-thumb', function(event, slick, currentSlide) {
                var current = $('.single-product-thumbnail .p-nav [data-slick-index="'+currentSlide+'"]');
                current.addClass('slick-current');
                current.siblings().removeClass('slick-current');
            });

            $( document.body ).off( 'kalles_swatches_update_html' ).bind( 'kalles_swatches_update_html', function( event, data ) {
                    var productId           = data.pid,
                        _this               = data._this,
                        selected_variant_id = _this.data('variation_id'),
                        galleries           = $( '.variations_form' ).data( 'galleries' ),
                        formData            = $( '.variations_form' ).data( 'product_variations' ),
                        galleryKey          = '',
                        selectedAttr        = {},
                        usedImages          = [];

                //Fix height Quick view & Quick shop
                if ( window._inQuickview ) {
                    if ( window_w > 767 ) {
                        var img_height = $('.p-item.slick-current').height();
                        if ( img_height ) {
                            $('#content_quickview').height(img_height);
                        }
                    } else {
                        var img_height = $('.product-quickview').height();
                        if ( img_height ) {
                            $('#content_quickview').height(img_height);
                        }
                    }

                }

                // Get selected size and color
                if ( ! $('#product-' + productId).hasClass('product-quickshop') ) {
                    $( '#product-' + productId + ' .swatch select' ).each(function () {
                        if ( $( this ).parent().parent().hasClass( 'is-color' ) ) {
                            galleryKey = '_product_image_gallery_' + $( this ).data( 'attribute_name' ).replace( 'attribute_', '' ) + '-' + $( this ).val().toLowerCase();
                            selectedAttr[$( this ).data( 'attribute_name' ).replace( 'attribute_', '' )] = $( this ).val();
                        }
                    });
                } else {
                    $( '.mfp-content #product-' + productId + ' .swatch select' ).each(function () {
                        if ( $( this ).parent().parent().hasClass( 'is-color' ) ) {
                            galleryKey = '_product_image_gallery_' + $( this ).data( 'attribute_name' ).replace( 'attribute_', '' ) + '-' + $( this ).val().toLowerCase();
                            selectedAttr[$( this ).data( 'attribute_name' ).replace( 'attribute_', '' )] = $( this ).val();
                        }
                    });
                }
                kallesTheme.productGlobal.ChangeImage(productId, galleries, galleryKey, false, selected_variant_id);
            });
        }
    }

})( jQuery );
