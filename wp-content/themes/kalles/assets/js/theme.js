let The4Kalles = {};
if ( ! THE4_Data_Js ) var THE4_Data_Js = [];

(function( $ ) {
    "use strict";
        const body  = $( 'body' ),
        _rtl        = THE4_Data_Js['is_rtl'],
        is_rtl      = ( THE4_Data_Js['is_rtl'] === 'true' ),
        is_zoom     = ( THE4_Data_Js['is-zoom'] === '1' ),
        is_lazyload = ( THE4_Data_Js['is_lazy_kalles'] === 'true' );

        var  $ld = $('#ld_cl_bar'),
        $window  = $(window),
        window_w = $window.width();

    var yesHover = Modernizr.hovermq,
        touchevents = Modernizr.touchevents;


    var timezone = THE4_Data_Js['timezone'],
        bltimezone = (timezone != 'not4'),
        day_t4_js = moment();

    if (bltimezone) {
        try {
            var timezoneDay = moment().tz(timezone);
        } catch(err) {
            console.log('Timezone error 2: '+timezone);
            bltimezone = false;
        }
    }

    var sp_nt_storage = false,
        Enablestorage = true,
        tuttimer = [];
    try {
        sp_nt_storage = (typeof(Storage) !== "undefined" && Enablestorage);
    } catch (err) {
        sp_nt_storage = false;
    }
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

    //Global function

    //https://github.com/benevolenttech/jquery.confetti.js
    //
    The4Kalles.Confetti = new function() {
    // globals
    var canvas;
    var ctx;
    var W;
    var H;
    var mp = 150; //max particles
    var particles = [];
    var angle = 0;
    var tiltAngle = 0;
    var confettiActive = true;
    var animationComplete = true;
    var deactivationTimerHandler;
    var reactivationTimerHandler;
    var animationHandler;

    // objects

    var particleColors = {
        colorOptions: ["DodgerBlue", "OliveDrab", "Gold", "pink", "SlateBlue", "lightblue", "Violet", "PaleGreen", "SteelBlue", "SandyBrown", "Chocolate", "Crimson"],
        colorIndex: 0,
        colorIncrementer: 0,
        colorThreshold: 10,
        getColor: function () {
            if (this.colorIncrementer >= 10) {
                this.colorIncrementer = 0;
                this.colorIndex++;
                if (this.colorIndex >= this.colorOptions.length) {
                    this.colorIndex = 0;
                }
            }
            this.colorIncrementer++;
            return this.colorOptions[this.colorIndex];
        }
    }

    function confettiParticle(color) {
        this.x = Math.random() * W; // x-coordinate
        this.y = (Math.random() * H) - H; //y-coordinate
        this.r = RandomFromTo(10, 30); //radius;
        this.d = (Math.random() * mp) + 10; //density;
        this.color = color;
        this.tilt = Math.floor(Math.random() * 10) - 10;
        this.tiltAngleIncremental = (Math.random() * 0.07) + .05;
        this.tiltAngle = 0;

        this.draw = function () {
            ctx.beginPath();
            ctx.lineWidth = this.r / 2;
            ctx.strokeStyle = this.color;
            ctx.moveTo(this.x + this.tilt + (this.r / 4), this.y);
            ctx.lineTo(this.x + this.tilt, this.y + this.tilt + (this.r / 4));
            return ctx.stroke();
        }
    }

    function init() {
        SetGlobals();
        InitializeButton();
        // InitializeConfetti();

        $(window).resize(function () {
            W = window.innerWidth;
            H = window.innerHeight;
            canvas.width = W;
            canvas.height = H;
        });

    }

    function InitializeButton() {
        $('#startConfetti').click(InitializeConfetti);
        $('#stopConfetti').click(DeactivateConfetti);
        $('#restartConfetti').click(RestartConfetti);
    }

    function SetGlobals() {
        $(body).append('<canvas id="confettiCanvas" style="position:fixed;top:0;left:0;display:none;z-index:9999;pointer-events: none;"></canvas>');
        canvas = document.getElementById("confettiCanvas");
        ctx = canvas.getContext("2d");
        W = window.innerWidth;
        H = window.innerHeight;
        canvas.width = W;
        canvas.height = H;
    }

    function InitializeConfetti() {
        canvas.style.display = 'block';
        particles = [];
        animationComplete = false;
        for (var i = 0; i < mp; i++) {
            var particleColor = particleColors.getColor();
            particles.push(new confettiParticle(particleColor));
        }
        StartConfetti();
    }

    function Draw() {
        ctx.clearRect(0, 0, W, H);
        var results = [];
        for (var i = 0; i < mp; i++) {
            (function (j) {
                results.push(particles[j].draw());
            })(i);
        }
        Update();

        return results;
    }

    function RandomFromTo(from, to) {
        return Math.floor(Math.random() * (to - from + 1) + from);
    }


    function Update() {
        var remainingFlakes = 0;
        var particle;
        angle += 0.01;
        tiltAngle += 0.1;

        for (var i = 0; i < mp; i++) {
            particle = particles[i];
            if (animationComplete) return;

            if (!confettiActive && particle.y < -15) {
                particle.y = H + 100;
                continue;
            }

            stepParticle(particle, i);

            if (particle.y <= H) {
                remainingFlakes++;
            }
            CheckForReposition(particle, i);
        }

        if (remainingFlakes === 0) {
            StopConfetti();
        }
    }

    function CheckForReposition(particle, index) {
        if ((particle.x > W + 20 || particle.x < -20 || particle.y > H) && confettiActive) {
            if (index % 5 > 0 || index % 2 == 0) //66.67% of the flakes
            {
                repositionParticle(particle, Math.random() * W, -10, Math.floor(Math.random() * 10) - 10);
            } else {
                if (Math.sin(angle) > 0) {
                    //Enter from the left
                    repositionParticle(particle, -5, Math.random() * H, Math.floor(Math.random() * 10) - 10);
                } else {
                    //Enter from the right
                    repositionParticle(particle, W + 5, Math.random() * H, Math.floor(Math.random() * 10) - 10);
                }
            }
        }
    }
    function stepParticle(particle, particleIndex) {
        particle.tiltAngle += particle.tiltAngleIncremental;
        particle.y += (Math.cos(angle + particle.d) + 3 + particle.r / 2) / 2;
        particle.x += Math.sin(angle);
        particle.tilt = (Math.sin(particle.tiltAngle - (particleIndex / 3))) * 15;
    }

    function repositionParticle(particle, xCoordinate, yCoordinate, tilt) {
        particle.x = xCoordinate;
        particle.y = yCoordinate;
        particle.tilt = tilt;
    }

    function StartConfetti() {
        W = window.innerWidth;
        H = window.innerHeight;
        canvas.width = W;
        canvas.height = H;
        (function animloop() {
            if (animationComplete) return null;
            animationHandler = requestAnimFrame(animloop);
            return Draw();
        })();
    }

    function ClearTimers() {
        clearTimeout(reactivationTimerHandler);
        clearTimeout(animationHandler);
    }

    function DeactivateConfetti() {
        confettiActive = false;
        ClearTimers();
    }

    function StopConfetti() {
        animationComplete = true;
        if (ctx == undefined) return;
        ctx.clearRect(0, 0, W, H);
        canvas.style.display = 'none';
    }

    function RestartConfetti() {
        ClearTimers();
        StopConfetti();
        reactivationTimerHandler = setTimeout(function () {
            confettiActive = true;
            animationComplete = false;
            InitializeConfetti();
        }, 100);

    }

    window.requestAnimFrame = (function () {
        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (callback) {
            return window.setTimeout(callback, 1000 / 60);
        };
    })();

    this.init = init;
    this.start = InitializeConfetti;
    this.stop = DeactivateConfetti;
    this.restart = RestartConfetti;
  }

    // Check is mobile

    The4Kalles.isMobile = function() {
        return (/Android|iPhone|iPad|iPod|BlackBerry/i).test(navigator.userAgent || navigator.vendor || window.opera);
    }

    //Top header loading bar

    var The4KallesloadingBar =  function (_this) {
        if ($ld.length == 0) return;


        $ld.on("ld_bar_star", function() { $ld.addClass('on_star') });
        $ld.on("ld_bar_60", function() { $ld.addClass('on_60') });
        $ld.on("ld_bar_80", function() { $ld.addClass('on_80') });
        $ld.on("ld_bar_90", function() { $ld.addClass('on_90') });
        $ld.on("ld_bar_94", function() { $ld.addClass('on_94') });
        $ld.on("ld_bar_end", function() {
            $ld.addClass('on_end');
            setTimeout(function(){ $ld.attr('class', '').addClass('op__0 pe_none'); }, 300);
        });
    }

    // Init slick carousel
    var initCarousel = function() {

        $( '.the4-carousel-ins' ).not( '.slick-initialized' ).slick();
        setTimeout(function(){
            $( '.the4-carousel-ins.slick-initialized' ).slick('refresh');
        }, 200);

        $( '.the4-carousel' ).not( '.slick-initialized' ).slick();

        // Reset the index of image on product variation
        $( 'body' ).on( 'found_variation', '.variations_form', function( ev, variation ) {

            if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
                var exist = $('.p-thumb .p-item img[data-large_image="'+variation.image.full_src+'"]');
                if (exist.length > 0) {
                    var index = exist.parents('.p-item').attr('data-slick-index');
                    $( '.product .the4-carousel' ).slick( 'slickGoTo', index);
                }
            }
        });
    }

    //Init Popup
    The4Kalles.initPopup = function() {
        body.on('click', '[data-opennt]', function (e) {
            //$("[data-opennt]").on("click", function(e) {
            var $this = $(e.currentTarget),
                html      = $("html"),
                datas     = $this.data(),
                id        = datas.opennt,
                color     = datas.color,
                bg        = datas.bg,
                position  = datas.pos,
                ani       = datas.ani || 'has_ntcanvas',
                remove    = datas.remove,
                cl        = datas.class,
                close     = datas.close || false,
                focuslast = datas.focuslast || false,
                focus     = $this.attr("data-focus"),
                YOffset   = window.pageYOffset,
                height    = window.height - $('#the4-header').outerHeight();

            var nt_scroll = function () {
                if( !YOffset) return;
                $('html, body').scrollTop(YOffset);
            }
            $this.addClass("current_clicked");
            $.magnificPopup.open({
                items: {
                    src: id,
                    type: "inline",
                    tLoading: '<div class="loading-spin dark"></div>'
                },
                tClose: 'Close',
                removalDelay: 300,
                closeBtnInside: close,
                focus: focus,
                autoFocusLast: focuslast,
                callbacks: {
                    beforeOpen: function() {
                        this.st.mainClass = ani + " " + color + " " + ani+"_" + position;
                    },
                    open: function() {

                        html.addClass(ani);
                        html.addClass(ani+"_" + position);
                        cl && $(".mfp-content").addClass(cl);
                        bg && $(".mfp-bg").addClass(bg);
                        body.on('click', '.close_pp', function(e) {
                            e.preventDefault();
                            $.magnificPopup.close();
                        });
                        nt_scroll();



                    },
                    beforeClose: function() {
                        html.removeClass(ani);

                    },
                    afterClose: function() {
                        html.removeClass(ani+"_" + position);

                        $(".current_clicked").removeClass("current_clicked");
                        remove && $(id).removeClass("mfp-hide");
                    }
                }
            });
            e.preventDefault()
        })
    }


    // Init masonry layout
    The4Kalles.initMasonry = function() {
        if ( window_w < 1024 && body.hasClass('tax-product_cat') ) return;
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
    };

    // Init push on header Menusidebar
    var initPushMenuSidebar = function() {
        $( 'a.the4-push-menu-sibebar-btn' ).on( 'click', function (e) {
            e.preventDefault();

            $( 'body' ).toggleClass( 'menu-sidebar-opened' );

            var mask = $('.mask-overlay');
            mask.addClass('mask_opened');

            $( '.mask-overlay, .close-menu' ).on( 'click', function() {
                $( 'body' ).removeClass( 'menu-sidebar-opened' );
                mask.removeClass('mask_opened');
            });
        });
    };
    var initPushMenuSidebarBuger = function() {
        $( '.primary-menu-sidebar li.has-sub').append( "<span class='the4-has-children'><i class='t4_icon_angle-right-solid'></i> </span>" );
        $( '.primary-menu-sidebar li.has-sub > .kalles-nav-link').after( "<span class='back-to-menu'></span>" );
        var $main_menu = $('.primary-menu-sidebar');
        var $width_menu = $main_menu.outerWidth();
        $('.the4-has-children').on( "click", function(e) {
            var $li = $(this).parent().closest('li');
            var $parent_text = $li.find('> .kalles-nav-link').text();
            $('.back-to-menu').addClass('show-back-menu');
            $main_menu.animate({'left': '-=' + $width_menu + 'px'});
            $li.addClass('has-active');
            $li.find('.back-to-menu').html($parent_text);
            $('.the4-canvas-menu-sidebar').addClass('menu-rolled');
            return false;
        });
        $('.back-to-menu').on( "click", function(e) {
            if ($main_menu.css('left') !== '0px') {
                setTimeout(function () {
                    $('.primary-menu-sidebar li.has-active').last().removeClass('has-active');
                }, 100)
                $main_menu.animate({'left': '+=' + $width_menu + 'px'}, 100);
            };
            return false;

        });
        $('.primary-menu-sidebar > li.has-sub > .back-to-menu').on( "click", function(e) {
            $('.the4-canvas-menu-sidebar').removeClass('menu-rolled');
            return false;
        });

    };
    // Accordion mobile menu
    var initDropdownMenu = function() {
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
    // Sticky menu
    var initStickyMenu = function() {
        if ( THE4_Data_Js != undefined && THE4_Data_Js[ 'header_sticky' ] == 1) {
            var header          = document.getElementById( 'the4-header' ),
                headerMid       = document.getElementsByClassName( 'header__mid' )[0],
                headerMidHeight = $( '.header__mid' ).outerHeight(),
                headerTopHeight = 0,
                adminBar        = $( '.admin-bar' ).length ? $( '#wpadminbar' ).height() : 0;

            if ( headerMid == undefined ) return;
            if( $('.header__top').length ){
                headerTopHeight = $( '.header__top' ).height();
            }
            var headerHeight    = headerMidHeight + headerTopHeight;
            headerMid.setAttribute( 'style', 'height:' + headerMidHeight + 'px' );

            $( window ).scroll( function() {
                if ( $( this ).scrollTop() > headerTopHeight ) {
                    header.classList.add( 'header-sticky' );
                    headerMid.setAttribute( 'style', 'position: fixed;top:' + adminBar + 'px' );
                } else {
                    header.classList.remove( 'header-sticky' );
                    headerMid.removeAttribute( 'style' );
                }
            });
        }
    }

    // Init right to left menu
    var initRTLMenu = function() {
        var menu = $( '.sub-menu li' ), subMenu = menu.find( ' > .sub-menu');
        menu.on( 'mouseenter', function () {
            if ( subMenu.length ) {
                if ( subMenu.outerWidth() > ( $( window ).outerWidth() - subMenu.offset().left ) ) {
                    subMenu.addClass( 'rtl-menu' );
                }
            }
        });
    }

    // Initialize WC quantity adjust.
    var wcQuantityAdjust = function() {

        $( '.quantity .input-text' ).keyup(function() {
            var $button = $( this ).parent().next().next(),
                $max = parseInt($(this).attr( 'max' )),
                $val = parseInt($( this ).val());
            if ($val <= $max) {
                $button.attr( 'data-quantity', $val );
            }
        });
        $( 'body' ).on( 'click', '.quantity .plus', function( e ) {
            e.preventDefault();
            var $input     = $( this ).parent().parent().find( 'input.input-text' ),
                $quantity  = parseInt( $input.attr( 'max' ) ),
                $step      = parseInt( $input.attr( 'step' ) ),
                $val       = parseInt( $input.val() ),
                $button    = $( this ).parent().parent().next().next();

            if ( ( $quantity !== '' ) && ( $quantity <= $val + $step ) ) {
                $( '.quantity .plus' ).css( 'pointer-events', 'none' );
            }

            if ($val + $step > $quantity) return;

            $input.val( $val + $step );

            $input.trigger( 'change' );

            if ( $( '.btn-atc' ).hasClass( 'atc-popup' ) ) {
                $button.attr( 'data-quantity', $val + $step );
            }
        });
        $( 'body' ).on( 'click', '.quantity .minus', function( e ) {

            e.preventDefault();

            var $input  = $( this ).parent().parent().find( 'input.input-text' ),
                $step   = parseInt( $input.attr( 'step' ) ),
                $val    = parseInt( $input.val() ) - $step,
                $group  = $(this).parents('form'),
                $button = $( this ).parent().parent().next().next();

            if ($group.hasClass('grouped_form') || $(this).hasClass('allown-input-remove')) {
                if ( $val <= 0 ) $val = 0;
            } else {
                if ( $val < $step ) $val = $step;
            }


            $input.val( $val );

            $( '.quantity .plus' ).removeAttr( 'style' );

            $input.trigger( 'change' );
            if ( $( '.btn-atc' ).hasClass( 'atc-popup' ) ) {
                $button.attr( 'data-quantity', $val );
            }
        });
    }

    // Back to top button
    var backToTop = function() {
        var el = $( '#the4-backtop' );
        $( window ).scroll(function() {
            if( $( this ).scrollTop() > $( window ).height() ) {
                el.show();
            } else {
                el.hide();
            }
        });
        el.click( function() {
            $( 'body,html' ).animate({
                scrollTop: 0
            }, 500);
            return false;
        });
    }

    // Init Magnific Popup
    var initMagnificPopup = function() {
        if ( $( '.the4-magnific-image' ).length > 0 ) {
            $( '.the4-magnific-image' ).magnificPopup({
                type: 'image',
                image: {
                    verticalFit: true
                },
                mainClass: 'mfp-fade',
                removalDelay: 500,
                callbacks: {
                    beforeOpen: function() {

                    },
                    open: function() {

                    },
                }
            });
        }
    }

    // Product quick view
    window._inQuickview = false;
    var initQuickView = function() {

        $( 'body' ).on( 'click', '.btn-quickview', function(e) {

            e.preventDefault();
            e.stopPropagation();

            var _this = $( this ),
                res = null,
                id    = _this.attr( 'data-prod' ),
                data  = { action: 'the4_quickview', product: id };

            if ( sp_nt_storage ) { res = sessionStorage.getItem( 'qv' + id ) }

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

                var ajax_url = THE4_Data_Js.ajax_url.toString().replace('%%endpoint%%', 'product_quick_view');

                $.post( ajax_url, data, function( response ) {
                    quickview_js( response.data , true, id);

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
            kalles_check_swatch();
            //Init count swatch
            kalles_count_swatch();
            initCarousel();

            //Btn animation
            The4Kalles.The4KallesProductSection();

            $( '.images' ).imagesLoaded( function() {
                $('.single-product-thumbnail').find('.the4-lazyload').removeClass('the4-lazyload');
                var imgHeight = $( '.product-quickview .images' ).outerHeight();

            });

            if(sp_nt_storage && bl) {
            sessionStorage.setItem('qv'+ id, response)
          }
        }
    }

    // Product quick Shop
    window._inQuickShop = false;
    var initQuickShop = function() {

        $(body).on( 'click', '.js__qs, .product_type_variable.quick_shop_js', function(e) {
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
                kalles_check_swatch();
                //Init count swatch
                kalles_count_swatch();
                initCarousel();


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

                    refresIconCart();

                    cart_threshold.html(response.free_shipping);

                    $('.woocommerce-mini-cart__total > .amount').html(response.cart_total);

                    $('.mfp-close').trigger('click');
                }
            });

            return false;
        });
    }

    // Extra content on single product ( Help & Shipping - Return )
    var wcExtraContent = function() {
        $( 'body' ).on( 'click', '.js_get_html_content', function(e) {
            $ld.trigger( "ld_bar_star" );

            var _this = $( this ),
                content = _this.data( 'content' ),
                data = { action: content }

            $.post( THE4_AjaxURL, data, function( response ) {
                $.magnificPopup.open({
                    items: {
                        src: '<div class="mfp-with-anim white-popup ajax_pp_popup">' + response + '</div>',
                        type: 'inline'
                    },
                    removalDelay: 500,
                    callbacks: {
                        beforeOpen: function() {
                            this.st.mainClass = 'mfp-move-horizontal';
                         },
                        open: function() {

                        },
                        close: function() {}
                     },
                });

                $ld.trigger( "ld_bar_end" );
            });
            e.preventDefault();
            e.stopPropagation();
        });
    }

    // Init mini cart on header
    var initMiniCart = function() {
        $( 'body' ).on( 'click', '.the4-icon-cart.sidebar > a', function (e) {
            if (body.is('.woocommerce-checkout, .woocommerce-cart'))
                return;
            e.preventDefault();

            $( 'body' ).toggleClass( 'cart-opened' );

            var mask = $('.mask-overlay');
            mask.addClass('mask_opened');

            $( '.mask-overlay, .close-cart' ).on( 'click', function() {
                $( 'body' ).removeClass( 'cart-opened' );
                mask.removeClass('mask_opened');
            });

            $( 'body' ).removeClass( 'popup-opened' );
        });

        var Timeout;
        $(body).on('click', '.js_cart_tls', function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            $('.widget_shopping_cart_content').addClass('ld_nt_cl ld_cart_tls');
            $('.mini_cart_'+id).addClass('is_nt_op');
            if (id == 'note') {
                Timeout = setTimeout(function(){ $('#CartSpecialInstructions').focus(); }, 500);
            } else if (id == 'dis') {
                Timeout = setTimeout(function(){ $('#the4_coupon_code').focus(); }, 500);
            }
        });

        $(".js_cart_tls_back").click(function(e) {
            e.preventDefault();
            clearTimeout(Timeout);
            $('.widget_shopping_cart_content').removeClass('ld_nt_cl ld_cart_tls');
            $('.is_nt_op').removeClass('is_nt_op');
        });
    }

    // Dropdown cart header
    var cartPosDropdown = function() {
        var $cart = $('.the4-mini-cart');

        if (!$cart.hasClass('cart_pos_dropdown') || body.hasClass('woocommerce-cart')) return;

        var $icon_cart = $('.the4-icon-cart'),
            $window        = $(window),
            fullHeight     = 60,
            windowHeight   = $window.height(),
            windowWidth    = $window.width(),
            offsetTop      = $icon_cart.offset().top,
            right          = (windowWidth - ($icon_cart.offset().left + $icon_cart.outerWidth())),
            outerH         = $icon_cart.outerHeight(),
            top            = offsetTop + 40;

        $cart.css({
            'position' : 'absolute',
            'top' : top,
            'right' : right
        });

        if ( offsetTop < windowHeight ) {
            var fullHeight = 100 - (offsetTop+40) / (windowHeight / 100);
        }

        $icon_cart.hoverIntent({
            sensitivity: 6,
            interval: 100,
            timeout: 100,
            over:function(t){

                top = $icon_cart.offset().top + 40;
                body.addClass('oped_dropdown_cart');
                $cart.css("top", top).addClass("current_hover");

            },
            out: function(){

                if ($cart.is(":hover")) return;
                body.removeClass('oped_dropdown_cart');
                $cart.removeClass("current_hover");
            }
        });

        $cart.on("mouseleave", function () {

            body.removeClass('oped_dropdown_cart');
            $cart.removeClass("current_hover");
        });
    };
    // Refesh mini cart on ajax event
    var refreshMiniCart = function( openCart ) {

        openCart = openCart ? true : false;

        var is_free_shipping = $('.cart_threshold').find('.cart_thres_3');

        $.ajax({
            type: 'POST',
            url: THE4_AjaxURL,
            dataType: 'json',
            data: { action: 'load_mini_cart' },
            success: function( data ) {

                //Threeshot
                if ( data.free_shipping ) {
                    if ( data.free_shipping.indexOf( 'cart_thres_3' ) != -1
                        && THE4_Data_Js[ 'is_shipping_bar' ] == '1'
                        && is_free_shipping.length == 0 ) {
                        The4Kalles.Confetti.restart();
                        setTimeout(function(){ The4Kalles.Confetti.stop() }, 3500);
                    }
                }

                if ( data.message != null && $( data.message.error ).length > 0 ) {
                    $( 'body' ).append( '<div class="woocommerce-error">' + data.message.error + '</div>' );
                    $( '.woocommerce-message' ).remove();
                } else {
                    var cartContent = $( '.the4-mini-cart .widget_shopping_cart_content' );
                    if ( data.cart_html.length > 0 ) {
                        cartContent.html( data.cart_html );
                    }

                    $( '.the4-icon-cart .count' ).text( data.cart_total );
                    if (body.hasClass('kalles-cart-cart_pos_dropdown') && !openCart) {
                        $('.the4-mini-cart').addClass('current_hover');
                    }
                    if (openCart) {

                        var mask = $('.mask-overlay');
                        mask.addClass('mask_opened');

                        $( 'body' ).addClass( 'cart-opened' );

                        $( '.mask-overlay, .close-cart' ).on( 'click', function() {
                            $( 'body' ).removeClass( 'cart-opened' );
                            mask.removeClass('mask_opened');
                        });
                    }
                }
            }
        });
    }

    var OpenMiniCart  = function( fragments = true ) {

        if ( $( 'body').hasClass( 'kalles-atc-behavior-popup' ) ) { // popup
                    // Need call an ajax request to get custom cart content in popup.
        $.ajax({
            url: THE4_AjaxURL,
            type: 'POST',
            data: {
                action: 'the4_kalles_popup_content_ajax',
            },
            success: function(response) {

                $.magnificPopup.open({
                    items: {
                        src: '<div class="product-quickview cart__popup pr">' + response + '</div>',
                        type: 'inline'
                    },
                    mainClass: 'mfp-fade',
                    removalDelay: 800,
                    showCloseBtn: true
                });

                initCarousel();
            }
        });

        refreshMiniCart(false);

        } else if ($('body').hasClass('kalles-atc-behavior-slide')) {
            if ( $( 'body').hasClass( 'kalles-cart-sidebar' )) {

                if ( fragments ) {

                    var mask = $('.mask-overlay');

                    mask.addClass('mask_opened');

                    $( 'body' ).addClass( 'cart-opened' );

                    $( '.mask-overlay, .close-cart' ).on( 'click', function() {
                        $( 'body' ).removeClass( 'cart-opened' );
                        mask.removeClass('mask_opened');
                    });
                } else {
                    refreshMiniCart(true);
                }

            } else {
                refreshMiniCart(false);

            }
        } else if ( $('body').hasClass('kalles-atc-behavior-do_nothing') ) {
            refreshMiniCart(false);
        }
    }

    var OpenMiniCartFragments = function() {

        $( document.body ).on( 'added_to_cart', function( fragments, cart_hash, button ) {
            OpenMiniCart();

            //Icon cart toolbar count
            $('.type_toolbar_cart.the4-icon-cart .count').text( cart_hash.cart_count );
        });
    }

    var cartThreSholdFreeShipping = function( free_shipping ) {

        var is_free_shipping = $('.cart_threshold').find('.cart_thres_3');

        if ( free_shipping ) {
            if ( free_shipping.indexOf( 'cart_thres_3' ) != -1
                && THE4_Data_Js[ 'is_shipping_bar' ] == '1' ) {
                The4Kalles.Confetti.restart();
                setTimeout(function(){ The4Kalles.Confetti.stop() }, 3500);
            }
        }
    }
    // Refesh mini icon Cart on ajax event
    var refresIconCart = function( ) {
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


    // Trigger add to cart button
    var initAddToCart = function() {
        var _input = $( '.quantity input' ), _quantity = _input.attr( 'max' );


        // Single add to cart button
        $( 'body' ).on( 'click', '.atc-slide .single_add_to_cart_button, .atc-do_nothing .single_add_to_cart_button', function(e) {
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


    }

    // T4 Discount Price
    var t4DiscountPrice = function() {

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


    }

    // Switch wc currency
    var initSwitchCurrency = function() {
        $( 'body' ).on( 'click', '.currency-item', function() {
            var currency = $( this ).data( 'currency' );
            Cookies.set( 'the4_currency', currency, { path: '/' });
            location.reload();
            $( document.body ).trigger( 'wc_fragment_refresh' );
        });
    }

    // Init ajax search
    var wcLiveSearch = function() {
        if ( ! $.fn.autocomplete || ( $( '.the4-ajax-search' ).length === 0 ) ) return;

        $( '.the4-ajax-search' ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: THE4_AjaxURL ,
                    dataType: 'json',
                    data: {
                        key: request.term,
                        action: 'the4_kalles_live_search'
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            minLength: 2,
            select: function( event, ui ) {
                window.location = ui.item.url;
            },
            open: function() {
                $( this ).removeClass( 'ui-corner-all' ).addClass( 'ui-corner-top' );
            },
            close: function() {
                $( this ).removeClass( 'ui-corner-top' ).addClass( 'ui-corner-all' );
            }
        }).data( 'ui-autocomplete' )._renderItem = function( ul, item ) {
            return $( '<li class="oh mt__10 pt__10">' )
                .data( 'ui-autocomplete-item', item )
                .attr( 'data-url', item.url )
                .append( "<img class='ajax-result-item fl' src='" + item.thumb + "'><div class='oh pl__15'><a class='ajax-result-item-name' href='" + item.url + "'>" + item.label + "</a><p>" + item.except + "</p></div>" )
                .appendTo( ul );
        };
    }

    // init ajax load
    The4Kalles.initAjaxLoad = function() {

        var button = $( '.the4-ajax-load' );

        if ( button.length == 0 ) return;

        button.each( function( i, val ) {
            var _option = $( this ).data( 'load-more' );

            if ( _option !== undefined ) {
                var page      = _option.page,
                    container = _option.container,
                    layout    = _option.layout,
                    isLoading = false,
                    anchor    = $( val ).find( 'a' ),
                    next      = $( anchor ).attr( 'href' ),
                    i         = 2;

                if ( layout == 'loadmore' ) {
                    $( val ).on( 'click', 'a', function( e ) {
                        e.preventDefault();
                        anchor = $( val ).find( 'a' );
                        next   = $( anchor ).attr( 'href' );
                        isLoading = true;
                        $( anchor ).addClass('jscl_ld');
                        if (isLoading) {
                            getData();
                        }
                    });
                } else {
                    var animationFrame = function() {
                        anchor = $( val ).find( 'a' );
                        next   = $( anchor ).attr( 'href' );

                        var bottomOffset = $( '.' + container ).offset().top + $( '.' + container ).height() - $( window ).scrollTop();

                        if ( bottomOffset < window.innerHeight && bottomOffset > 0 && ! isLoading ) {
                            if ( ! next )
                                return;
                            isLoading = true;
                            $( anchor ).addClass('jscl_ld');

                            getData();
                        }
                    }

                    var scrollHandler = function() {
                        requestAnimationFrame( animationFrame );
                    };

                    $( window ).scroll( scrollHandler );
                }

                var getData = function() {
                    $.get( next + '', function( data ) {
                        var content    = $( '.' + container, data ).wrapInner( '' ).html(),
                            newElement = $( '.' + container, data ).find( '.portfolio-item, .product' ),
                            typeColumn = container == 'portfolios' ? 'portfolio-column' : 'wc-column',
                            col        = $('.wc-col-switch a.active').length ? $('.wc-col-switch a.active').data('col') : THE4_Data_Js[typeColumn];
                        newElement = newElement.removeClass( 'col-md-2 col-md-3 col-md-4 col-md-6' ).addClass( 'col-md-' + col );
                        $( content ).imagesLoaded( function() {
                            next = $( anchor, data ).attr( 'href' );
                            // isotope has been initalized, okay to call methods
                            $( '.' + container ).append( newElement ).isotope( 'appended', newElement ).isotope('layout');
                        });
                        $( anchor ).text( THE4_Data_Js['load_more'] );
                        $( anchor ).removeClass('jscl_ld');

                        if ( page > i ) {
                            if ( THE4_Data_Js != undefined && THE4_Data_Js[ 'permalink' ] == 'plain' ) {
                                var link = next.replace( /paged=+[0-9]+/gi, 'paged=' + ( i + 1 ) );
                            } else {
                                var link = next.replace( 'page/' + i, 'page/' + ( i + 1 ) );
                            }

                            $( anchor ).attr( 'href', link );
                        } else {
                            $( anchor ).remove();
                        }
                        isLoading = false;
                        i++;
                    });
                }
            }
        });

        if ( $( '.yith-wcan' ).length > 0 && button.length > 0 ) {
            $( 'body' ).on( 'click', '.yith-wcan a', function() {
                $( document ).ajaxComplete(function() {
                    window.location.reload();
                });
            });
        }
    }

    // Init Scroll Reveal
    var initScrollReveal = function() {
        window.sr = ScrollReveal().reveal( '.the4-animated', {
            duration: 700
        });
    }

    // Init Countdown
    The4Kalles.initCountdown =  function () {

        //Home page Elementor
        var $el = $( '.the4-countdown' );

        $el.each( function( i, val ) {
            var _end = $( this ).data( 'time' );
            if (_end) {
                $( val ).countdown(
                    _end,
                    function(event) {
                        $( this ).html(event.strftime(' '
                            + '<div class="pr"><span class="db cw fs__16 mt__10">%d</span>'
                            + '<span class="db">' + THE4_Data_Js['days'] + '</span></div>'
                            + '<div class="pr"><span class="db cw fs__16 mt__10">%H</span>'
                            + '<span class="db">' + THE4_Data_Js['hrs'] + '</span></div>'
                            + '<div class="pr"><span class="db cw fs__16 mt__10">%M</span>'
                            + '<span class="db">' + THE4_Data_Js['mins'] + '</span></div>'
                            + '<div class="pr"><span class="db cw fs__16 mt__10">%S</span>'
                            + '<span class="db">' + THE4_Data_Js['secs'] + '</span></div>'
                        ));
                    }
                );
            }
        });

        //Product Page
        var $el_page = $( '.the4-countdown-page' );
        if( $el_page.length > 0) {
            $('#the4-kalles-product-coundow-page').find('.mess_cd').show();
            var _end = $el_page.data( 'time' );
            if (_end) {
                $el_page.countdown(
                    _end,
                    function(event) {
                        $( this ).html(event.strftime(' '
                            + '<div class="block tc"><span class="flip-top">%-D</span><br><span class="label tu">' + THE4_Data_Js['days'] + '</span></div>'
                            + '<div class="block tc"><span class="flip-top">%H</span><br><span class="label tu">' + THE4_Data_Js['hrs'] + '</span></div>'
                            + '<div class="block tc"><span class="flip-top">%M</span><br><span class="label tu">' + THE4_Data_Js['mins'] + '</span></div>'
                            + '<div class="block tc"><span class="flip-top">%S</span><br><span class="label tu">' + THE4_Data_Js['secs'] + '</span></div>'
                        ));
                    }
                );
            }
        }
    }

    // Init sidebar filter
    var wcTopSidebarMenu = function() {
        $( 'body' ).on( 'click', '.the4-mobile .shop-top-sidebar .cat-parent > a', function(e) {
            $( this ).parent().toggleClass( 'opened' );
            e.preventDefault();
        });
    }

    // Init product accordion
    function wcAccordion() {
        $( '.wc-accordions .tab-heading' ).click( function( e ) {
            e.preventDefault();

            var _this = $( this );
            var parent = _this.closest( '.wc-accordion' );
            var parent_top = _this.closest( '.wc-accordions' );

            if ( parent.hasClass( 'active' ) ) {
                parent.removeClass( 'active' );
                parent.find( '.entry-content' ).stop( true, true ).slideUp();
            } else {
                parent_top.find( '.wc-accordion' ).removeClass( 'active' );
                parent.addClass( 'active' );
                parent_top.find( '.entry-content' ).stop( true, true ).slideUp();
                parent.find( '.entry-content' ).stop( true, true ).slideDown();
            }
        });
    }

    // Sticky sidebar for single product layout 3, 4
    function wcStickySidebar() {
        if ( $( '.the4-sidebar-sticky' ).length > 0 && ! The4Kalles.isMobile() ) {
            $( '.the4-sidebar-sticky' ).stick_in_parent();
        }
    }

    // Init openswatch update images
    function initOpenswatch() {
        $( document.body ).off( 'openswatch_update_images' ).bind( 'openswatch_update_images',function( event, data ) {
            var data_html = data.html;
            var productId = data.productId;

            $( '#product-' + productId + ' .single-product-thumbnail' ).html( data_html );

            setTimeout(function() {
                initCarousel();
                initPrettyPhoto();
            }, 10 );
        });
        $( 'body' ).on( 'click', '.product-list-color-swatch a', function() {
            var src = $( this ).data( 'thumb' );
            if ( src != '' ) {
                $( this ).closest( '.product' ).find( 'img.wp-post-image' ).first().attr( 'src', src );
                $( this ).closest( '.product' ).find( 'img.wp-post-image' ).first().attr( 'srcset', src );
            }
        });
    }



    // Preloader
    function initPreLoader() {
        var loader = $( '.preloader' );

        if ( loader.length ) {
            $( window ).on( 'pageshow', function( event ) {
                if ( event.originalEvent != undefined && event.originalEvent.persisted ) {
                    loader.fadeIn( 500, function() {
                        loader.hide();
                        loader.children().hide();
                    });
                }
            });

            $( window ).on( 'beforeunload', function() {
                loader.fadeIn( 500, function() {
                    loader.children().fadeIn( 100 )
                });
            });

            loader.fadeOut( 800 );
            loader.children().fadeOut();
        }
    }

    // Custom 3rd-party plugin
    function customThirdParties() {
        // Reinit carousel on VC tabs
        $( 'body' ).on( 'click', '.vc_tta-panel-title a', function( e ) {
            if ( $( '.the4-carousel' ).length > 0 ) {
                $( '.the4-carousel' ).slick( 'unslick' );

                setTimeout( function() {
                    $( '.the4-carousel' ).not( '.slick-initialized' ).slick();
                }, 50);
            }
        });

        /**
         * Sets product images for the chosen variation
         */
        $.fn.wc_variations_image_update = function( variation ) {
            var $form             = this,
                $product          = $form.closest( '.product' ),
                $product_gallery  = $product.find( '.images' ),
                $gallery_nav      = $product.find( '.flex-control-nav' ),
                $gallery_img      = $gallery_nav.find( 'li:eq(0) img' ),
                $product_img_wrap = $product_gallery
                    .find( '.woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder' )
                    .eq( 0 ),
                $product_img      = $product_img_wrap.find( '.wp-post-image' ),
                $product_link     = $product_img_wrap.find( 'a' ).eq( 0 );


            if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
                // See if the gallery has an image with the same original src as the image we want to switch to.
                var galleryHasImage = $gallery_nav.find( 'li img[data-o_src="' + variation.image.gallery_thumbnail_src + '"]' ).length > 0;

                // If the gallery has the image, reset the images. We'll scroll to the correct one.
                if ( galleryHasImage ) {
                    $form.wc_variations_image_reset();
                }

                // See if gallery has a matching image we can slide to.
                var slideToImage = $gallery_nav.find( 'li img[src="' + variation.image.gallery_thumbnail_src + '"]' );

                if ( slideToImage.length > 0 ) {
                    slideToImage.trigger( 'click' );
                    $form.attr( 'current-image', variation.image_id );
                    window.setTimeout( function() {
                        if ( ! window._inQuickShop || ! window._inQuickview ) {
                            $( window ).trigger( 'resize' );
                        }
                        $product_gallery.trigger( 'woocommerce_gallery_init_zoom' );
                    }, 20 );
                    return;
                }

                $product_img.wc_set_variation_attr( 'src', variation.image.src );
                $product_img.wc_set_variation_attr( 'height', variation.image.src_h );
                $product_img.wc_set_variation_attr( 'width', variation.image.src_w );
                $product_img.wc_set_variation_attr( 'srcset', variation.image.srcset );
                $product_img.wc_set_variation_attr( 'sizes', variation.image.sizes );
                $product_img.wc_set_variation_attr( 'title', variation.image.title );
                $product_img.wc_set_variation_attr( 'data-caption', variation.image.caption );
                $product_img.wc_set_variation_attr( 'alt', variation.image.alt );
                $product_img.wc_set_variation_attr( 'data-src', variation.image.full_src );
                $product_img.wc_set_variation_attr( 'data-large_image', variation.image.full_src );
                $product_img.wc_set_variation_attr( 'data-large_image_width', variation.image.full_src_w );
                $product_img.wc_set_variation_attr( 'data-large_image_height', variation.image.full_src_h );
                $product_img_wrap.wc_set_variation_attr( 'data-thumb', variation.image.src );
                $gallery_img.wc_set_variation_attr( 'src', variation.image.gallery_thumbnail_src );
                $product_link.wc_set_variation_attr( 'href', variation.image.full_src );
            } else {
                $form.wc_variations_image_reset();
            }

            window.setTimeout( function() {
                if ( ! window._inQuickShop || ! window._inQuickview ) {
                    $( window ).trigger( 'resize' );
                }

                $form.wc_maybe_trigger_slide_position_reset( variation );
                $product_gallery.trigger( 'woocommerce_gallery_init_zoom' );
            }, 20 );
        };


        jQuery('.adsw-attribute-option .meta-item-img').on('click', function(){
            setTimeout(function(){
                jQuery('.the4-image-zoom .imgZoom').remove();
                jQuery('.the4-image-zoom').zoom();
            }, 100);
        });
    }

    // Add to cart popup
    function wcPopupAddtocart() {
        $( 'body' ).on( 'click', '.atc-popup .single_add_to_cart_button', function( e ) {
            var _btn  = $( this ),
                _form = $( 'form.cart' ),
                product_data = {},
                ajaxs = [],
                ajaxCall = function(data, step) { // step: next call ajax
                    if (typeof step != 'undefined' ) {
                        var url = THE4_AjaxURL;
                    } else {
                        var url = THE4_AjaxURL+'?claucartf5=1';
                    }

                    $ld.trigger( "ld_bar_star" );

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            action: 'the4_kalles_popup_update_cart',
                            product_data: data
                        },
                        beforeSend: function() {
                            _btn.addClass('the4-loading');
                        },
                        success: function( response, status, jqXHR ) {
                            _btn.removeClass('the4-loading');
                            $ld.trigger( "ld_bar_end" );

                            var sticky_addtocart_btn = $('.sticky_add_to_cart_btn');
                            if (sticky_addtocart_btn.length > 0 && sticky_addtocart_btn.hasClass('the4-loading'))
                                sticky_addtocart_btn.removeClass('the4-loading');

                            if (typeof step != 'undefined' ) {
                                var next = step + 1;
                                if (typeof ajaxs[next] != 'undefined') {
                                    if (next == ajaxs.length - 1) {
                                        ajaxCall(ajaxs[next]);
                                    } else {
                                        ajaxCall(ajaxs[next], next);
                                    }
                                }
                            } else {
                                if ( typeof response == 'object' ) {
                                    $.magnificPopup.open({
                                        items: {
                                            src: '<div class="mfp-with-anim product-quickview cart__popup pr">' + response.output + '</div>',
                                            type: 'inline'
                                        },
                                        mainClass: 'mfp-fade',
                                        removalDelay: 500,
                                        callbacks: {
                                             beforeOpen: function() {
                                                 this.st.mainClass = 'mfp-move-horizontal';
                                             },
                                            open: function() {
                                                initCarousel();
                                            },
                                            close: function() {
                                            }
                                         },
                                    });
                                } else { // error label
                                    $('body').append( response );
                                }

                                $( 'body' ).addClass( 'popup-opened' );
                                setTimeout( function() {
                                    $( '.mask-overlay' ).remove();
                                    $( 'body' ).removeClass( 'cart-opened' );
                                }, 1000)
                            }
                        }
                    });
                };

            if ( _btn.hasClass( 'disabled' ) || $( '.btn-atc' ).hasClass( 'no-ajax' ) ) return;

                var quantity = _btn.parents( 'form' ).find('input[name=quantity]').val();

            if (  _btn.parents( 'form' ).hasClass( 'variations_form' ) ) {
                var variation_id = parseInt( _form.find( '[name=variation_id]' ).val() ),
                    product_id   = parseInt( _form.find('[name=add-to-cart]' ).val() );


                if ( variation_id ) {
                    var attributes_select = _form.find( '.variations select' ),
                        attributes = {};

                    attributes_select.each( function() {
                        attributes[ $( this ).data( 'attribute_name' ) ] = $( this ).val();
                    });

                    attributes = JSON.stringify( attributes );
                    product_data['attributes']   = attributes;
                    product_data['variation_id'] = variation_id;
                }

                product_data['product_id'] = product_id;

            } else if (_btn.parents( 'form' ).hasClass( 'grouped_form' )) {
                var formGroupData = jQuery('.grouped_form').serializeArray();
                jQuery.each(formGroupData, function(index, el){
                    if (el.name.indexOf('quantity[') == 0 && el.value > 0) {
                        var pid = el.name.replace('quantity[', '').replace(']', ''),
                            product_data = {};
                        product_data['product_id']   = pid;
                        product_data['variation_id'] = 0;
                        product_data['quantity']     = el.value || 1;
                        product_data = JSON.stringify( product_data );
                        ajaxs.push(product_data);
                    }
                });
                if (ajaxs.length > 0) {
                    if (ajaxs.length > 1) {
                        ajaxCall(ajaxs[0], 0);
                    } else {
                        ajaxCall(ajaxs[0]);
                    }
                }
                e.preventDefault();
                return;
            } else {
                var product_id   = _btn.data( 'product_id' ),
                    product_data = {};

                product_data['product_id']   = product_id;
                product_data['variation_id'] = 0;

            }

            product_data['quantity']     = quantity || 1;
            product_data['type'] = 'popup';
            product_data = JSON.stringify( product_data );

            ajaxCall(product_data);

            e.preventDefault();
        });

        $( 'body' ).on( 'click', '.modal_btn_add_to_cart', function( e ) {
            e.preventDefault();

            var _btn = $( this );
            if ( _btn.hasClass( 'product_type_variable' ) ) { return; }

            var product_id = _btn.data( 'product_id' ), quantity = 1, product_data = {};

            product_data['product_id']   = product_id;
            product_data['variation_id'] = 0;
            product_data['quantity']     = quantity;

            product_data = JSON.stringify( product_data );

            $.ajax({
                url: THE4_AjaxURL,
                type: 'POST',
                data: {
                    action: 'the4_kalles_popup_update_cart',
                    product_data: product_data
                },
                beforeSend: function() {
                    $( '.cart__popup' ).addClass( 'loading' );
                },
                success: function( response, status, jqXHR ) {
                    $( '.cart__popup' ).html( response.output );
                    $( '.cart__popup' ).removeClass( 'loading' );

                }
            });
        })

        function wcUpdateCartAjax( cart_key, new_qty, undo_item ) {
            return $.ajax({
                url: THE4_AjaxURL,
                type: 'POST',
                data: {
                    action: 'the4_kalles_popup_update_ajax',
                    cart_key: cart_key,
                    new_qty: new_qty,
                    undo_item: undo_item || false
                }
            });
        }

        //Ajax mini cart update
        function wcMiniUpdateCart( _this, new_qty) {
            var _pwrap     = _this.parents( '.cart__mini-item' ),
                _pdata         = _pwrap.data( 'cart-item' ),
                _cartkey       = _pdata.key,
                _pname         = _pdata.pname,
                _qtyinput      = _pwrap.find( '.cart__mini-qty--input' ),
                ld_bar         = _pwrap.find('.ld_cart_bar'),
                btn_minus      = _pwrap.find('.mini_cart_actions_btn.minus');

            //Begin send data
            ld_bar.addClass('on_star');
            wcUpdateCartAjax( _cartkey, new_qty ).done( function( response, status, jqXHR ) {
                if ( jqXHR.getResponseHeader( 'content-type' ).indexOf( 'text/html' ) >= 0 ) {
                    _qtyinput.val( focus_qty );
                } else {
                    $( '.woocommerce-mini-cart__total.total > .amount' ).html( response.cart_total );
                    $( '.cart_tot_price > .money' ).html( response.cart_total );

                    //Update cart item price
                    if ( response.cart_item_price ) {
                        _pwrap.find('.cart_meta_price').html( response.cart_item_price );
                    }

                    $( document ).trigger('kallesAfterAtcEvent', [response] );

                    _qtyinput.val( new_qty );
                    refresIconCart();
                    if (new_qty != 1 && btn_minus.hasClass('qty_1')) {
                        btn_minus.removeClass('qty_1');
                    }
                    if (new_qty == 1) {
                        btn_minus.addClass('qty_1');
                    }
                }
                ld_bar.addClass('on_end');
                setTimeout(() => ld_bar.attr('class', 'ld_cart_bar'), 200);
            });
        }
        body.on( 'change','.cart__mini-qty--input', function( e ) {
            var _this   = $( this ),
                new_qty = parseInt( _this.val( ) ),
                _step   = parseInt( _this.attr( 'step' ) ),
                _min    = parseInt( _this.attr( 'min' ) ),
                _max    = parseInt( _this.attr( 'max' ) ),
                invalid = false;

            if ( new_qty === 0 ) {
                _this.parents( '.cart__mini-item' ).find( '.cart_ac_remove' ).trigger( 'click' );
                return;

            } else if ( isNaN( new_qty ) || new_qty < 0 ) {
                invalid = true;

            } else if ( new_qty > _max && _max > 0 ) {
                alert( 'Maximum product is: ' + _max );
                invalid = true;

            } else if ( new_qty < _min ) {
                invalid = true;

            } else if ( ( new_qty % _step ) !== 0 ) {
                alert( 'Quantity can only be purchased in multiple of ' + _step );
                invalid = true;

            } else {
                wcMiniUpdateCart( _this, new_qty );
            }

            if ( invalid === true ) {
                _this.val( focus_qty );
            }
        });

        //Delete Mini cart
        // Remove item from the cart
        $(body).on( 'click', '.js_cart_rem',function() {
            var _this          = $( this ),
                _pwrap         = _this.parents( '.cart__mini-item' ),
                _pdata         = _pwrap.data( 'cart-item' ),
                _ckey          = _pdata.key,
                new_qty        = 0,
                _pname         = _pdata.pname,
                ld_bar         = _pwrap.find('.ld_cart_bar'),
                cart_threshold = $('.widget_shopping_cart_content .cart_threshold');;
            ld_bar.addClass('on_star');
            wcUpdateCartAjax( _ckey, 0 ).done( function( response ) {
                _pwrap.slideUp('fast', () => _pwrap.remove());
                cart_threshold.html(response.free_shipping);

                $( '.woocommerce-mini-cart__total > .amount' ).html( response.cart_total );

                ld_bar.addClass('on_end');
                $('.the4-icon-cart .count').text(response.cart_total_item);
                //Display Tool add Gift wrap
                if (_this.hasClass('is_product_gift_wrap')) {
                    $('.mini_cart_tool_gift').css('display', 'inline-block');
                }
                //Check cart item quantity
                if (response.items_count == 0) {
                    $('.mini_cart_tool').css('display', 'none');
                    // Show empty cart
                    $('.mini-cart-empty').show('fast');
                    //Hide footer cart
                    $('.mini_cart_footer').hide('fast');
                }
                setTimeout(() => ld_bar.attr('class', 'ld_cart_bar'), 200);
            });
        });

        function wcPopupUpdateCart( _this, new_qty ) {
            var _pwrap    = _this.parents( '.cart__popup-item' ),
                _pdata    = _pwrap.data( 'cart-item' ),
                _cartkey  = _pdata.key,
                _pname    = _pdata.pname,
                _qtyinput = _pwrap.find( '.cart__popup-qty--input' ),
                cart_threshold = $('.cart__popup .cart_threshold');

            $( '.cart__popup' ).addClass( 'loading' );

            var is_free_shipping = $('.cart__popup').find('.cart_thres_3');

            wcUpdateCartAjax( _cartkey, new_qty ).done( function( response, status, jqXHR ) {
                if ( jqXHR.getResponseHeader( 'content-type' ).indexOf( 'text/html' ) >= 0 ) {
                    _qtyinput.val( focus_qty );
                } else {
                    _pwrap.find( '.cart__popup-total' ).html( response.ptotal );
                    $( '.cart__popup-stotal' ).html( response.cart_total );

                    //Free shipping bar
                    cart_threshold.html(response.free_shipping);

                    //check if free shiping
                    if ( response.free_shipping ) {
                      if ( response.free_shipping.indexOf( 'cart_thres_3' ) != -1
                              && THE4_Data_Js[ 'is_shipping_bar' ] == '1'
                              && is_free_shipping.length == 0 ) {
                          The4Kalles.Confetti.restart();
                          setTimeout(function(){ The4Kalles.Confetti.stop() }, 3500);
                      }
                    }
                    _qtyinput.val( new_qty );
                }
                $( '.cart__popup' ).removeClass( 'loading' );
            });
        }

        $( 'body' ).on( 'change','.cart__popup-qty--input', function( e ) {
            var _this   = $( this ),
                new_qty = parseInt( _this.val( ) ),
                _step   = parseInt( _this.attr( 'step' ) ),
                _min    = parseInt( _this.attr( 'min' ) ),
                _max    = parseInt( _this.attr( 'max' ) ),
                invalid = false;

            if ( new_qty === 0 ) {
                _this.parents( '.cart__popup-item' ).find( '.cart__popup-remove' ).trigger( 'click' );
                return;

            } else if ( isNaN( new_qty ) || new_qty < 0 ) {
                invalid = true;

            } else if ( new_qty > _max && _max > 0 ) {
                alert( 'Maximum product is: ' + _max );
                invalid = true;

            } else if ( new_qty < _min ) {
                invalid = true;

            } else if ( ( new_qty % _step ) !== 0 ) {
                alert( 'Quantity can only be purchased in multiple of ' + _step );
                invalid = true;

            } else {
                wcPopupUpdateCart( _this, new_qty );
            }

            if ( invalid === true ) {
                _this.val( focus_qty );
            }
        });

        $( 'body' ).on( 'click', '.cart__popup-qty' ,function() {
            var _this     = $(this),
                _qty      = _this.siblings( '.cart__popup-qty--input' ),
                _qtyinput = parseInt( _qty.val() ),
                _step     = parseInt( _qty.attr( 'step' ) ),
                _min      = parseInt( _qty.attr( 'min' ) ),
                _max      = parseInt( _qty.attr( 'max' ) );

            _qty.trigger( 'focusin' );

            if ( _this.hasClass( 'cart__popup-qty--plus' ) ) {
                var _newqty = _qtyinput + _step;

                if ( _newqty > _max && _max > 0 ) {
                    alert( 'Maximum Quantity: ' + _max );
                    return;
                }
            } else if ( _this.hasClass( 'cart__popup-qty--minus' ) ) {
                var _newqty = _qtyinput - _step;
                if ( _newqty === 0 ) {
                    _this.parents( '.cart__popup-item' ).find( '.cart__popup-remove' ).trigger( 'click' );
                    return;
                } else if ( _newqty < _min ) {
                    return;
                } else if ( _qtyinput < 0 ) {
                    alert( 'Invalid' );
                    return;
                }
            }
            wcPopupUpdateCart( _this, _newqty );
        })

        // Remove item from the cart
        $( 'body' ).on( 'click', '.cart__popup-remove',function() {
            $( '.cart__popup' ).addClass( 'loading' );

            var _this    = $( this ),
                _pwrap   = _this.parents( '.cart__popup-item' ),
                _pdata   = _pwrap.data( 'cart-item' ),
                _ckey    = _pdata.key,
                new_qty  = 0,
                _pname   = _pdata.pname,
                cart_threshold = $('.cart__popup .cart_threshold');

            wcUpdateCartAjax( _ckey, 0 ).done( function( response ) {
                _pwrap.after( '<div class="cart__popup-empty center-xs mt__15 mb__15">' + _pname + ' ' + THE4_Data_Js['popup_remove'] + ' <span class="cart__popup-undo fwb cb">' + THE4_Data_Js['popup_undo'] + '</span></div>' )
                    .hide()
                    .attr( 'class', 'cart__popup-undo--active' );
                //Free shipping bar
                cart_threshold.html(response.free_shipping);

                $( '.cart__popup-stotal' ).html( response.cart_total );
                $( '.cart__popup' ).removeClass( 'loading' );
            });
        });

        // Undo the product removed
        $( 'body' ).on( 'click', '.cart__popup-undo', function() {
            var _this          = $( this ),
                _pwrap         = _this.parents( '.cart__popup-empty' ),
                _pwraps        = _pwrap.prev( '.cart__popup-undo--active' ),
                cart_threshold = $('.cart__popup .cart_threshold');

            if ( _pwraps.length === 0 ) {
                return;
            }
            $( '.cart__popup' ).addClass( 'loading' );

            var _data = _pwraps.data( 'cart-item' ), _cartkey = _data.key, _pid = _data._pid, qty = 10;

            wcUpdateCartAjax( _cartkey, qty, true ).done( function( response ) {
                _pwraps.attr( 'class','cart__popup-item flex middle-xs' )
                    .show()
                    .find( '.cart__popup-quantity input' ).val( response.quantity );

                _pwrap.remove();

                //Free shipping bar
                cart_threshold.html(response.free_shipping);

                $( '.cart__popup' ).removeClass( 'loading' );
                $( '.cart__popup-stotal' ).html( response.cart_total );
            });
        });

        // Update cart number with custom add to cart and show mini cart with default add to cart
        $( document ).ajaxComplete( function( event, xhr, settings ) {

            if ( settings.url.indexOf( 'claucartf5' ) > 0 ) {
                refreshMiniCart( false );
            }
            if ( settings.url.indexOf( 'wcpb-add-to-cart' ) > 0 ) {
                refreshMiniCart( true );
            }
        });
    }

    var afterAddToCartEvent = function() {
        $( document ).on('kallesAfterAtcEvent', function( e, response ) {
             var cart_threshold = $('.widget_shopping_cart_content .cart_threshold'),
                 is_free_shipping = $('.cart_threshold').find('.cart_thres_3');

            cart_threshold.html(response.free_shipping);

            //check if free shiping
            if ( response.free_shipping ) {

                if ( response.free_shipping.indexOf( 'cart_thres_3' ) != -1
                    && THE4_Data_Js[ 'is_shipping_bar' ] == '1'
                    && is_free_shipping.length == 0 ) {
                    The4Kalles.Confetti.restart();
                    setTimeout(function(){ The4Kalles.Confetti.stop() }, 3500);
                }
            }
        });
    }
    /**
     * countdown banner
     */
    var hTransparent = function () {
        let h_banner = $('#kalles_countdown_banner'),
            h_ver    = h_banner.find( '.h__banner' ).attr( 'data-ver' ),
            txt_ver  = 'h_banner_' + h_ver;

        if ( typeof Cookies != 'undefined' ) {
                if ( Cookies.get( txt_ver ) === 'closed' ) return;
        }
        body.removeClass( 'h_calc_ready' );
        h_banner.css( "height", "" );

        let mt = h_banner.outerHeight();
        body.addClass( 'h_calc_ready' );
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

    The4Kalles.KallesCountdown = function () {

        t4_countdown('#hbanner_cd');
        t4_countdown('.pr_coun_dt');

        function t4_countdown ( selector ) {
            if ( $( selector ).length == 0 ) return;

            var date = $( selector ).data( 'date' );
            $( selector ).countdown( date, function ( event ) {
                $( this ).html( event.strftime( '%D days %H:%M:%S' ) );
            } );
        }
    };

    // Init Account Login / Register  cart on header
    var initAccount = function() {
        //Display account slide
        $( 'body:not(.woocommerce-account)' ).on( 'click', '.the4-login-register.sidebar > a', function (e) {
            e.preventDefault();
            var mask = $('.mask-overlay');
            mask.addClass('mask_opened');

            $( 'body' ).toggleClass( 'account-opened' );

            $( '.mask-overlay, .close-cart' ).on( 'click', function() {
                $( 'body' ).removeClass( 'account-opened' );
                mask.removeClass('mask_opened');
            });

            $( 'body' ).removeClass( 'popup-opened' );
        });

        // Switch form
        $('body').on( "click", ".the4_link_acc:not(.dokan_installed)", function ( e ) {
            e.preventDefault();
            $( '.the4-account-ajax .is_selected' ).removeClass( 'is_selected' );
            $($(this).data( 'id' )).addClass( 'is_selected' );
        } );
        // Switch form
        $('body').on( 'click', '.the4_link_acc_custom', function ( e ) {
            $(this).closest('.form-login').find('.the4-woocommerce-acction').toggleClass('link_acc_active');
            $(this).closest('.form-login').find('.form-acc-wrap,.login-s-head').toggleClass('the4-acc-show');
            e.preventDefault();
            return false;
        } );
        $('body').on( 'click', '.link-reset-pw', function ( e ) {
            $(this).closest('.form-login-reset-wrap').find('.woocommerce-form').toggleClass('the4-form-show');
            e.preventDefault();
            return false;
        } );
        //Display account Popup
        $( 'body:not(.woocommerce-account)' ).on( 'click', '.the4-login-register.popup > a', function (e) {
            e.preventDefault();
            var mask = $('.mask-overlay'),
                popup_wrapper = $('.the4-account-popup');

            mask.addClass('mask_opened');

            $( 'body' ).toggleClass( 'the4-account-popup-opened' );

            $( '.mask-overlay, .close-cart' ).on( 'click', function() {
                $( 'body' ).removeClass( 'the4-account-popup-opened' );
                mask.removeClass('mask_opened');
            });

            $( 'body' ).removeClass( 'popup-opened' );
        });


        //Trigger link lost password error
        $('body').on('click', '.form-row.error a', function(event) {
            event.preventDefault();

            $('.the4_link_acc[data-id=#the4-customer-repass]').trigger('click');

        });

        if ( $('body').hasClass('account_ajax') ) {
            //Login
            $('.the4-account-form form.woocommerce-form-login').on('submit', function( e ) {
                e.preventDefault();

                var _btn = $(this).find('button[type=submit]'), _form = $( this ), _err = _form.find(' .error');

                _btn.addClass('loading');
                _err.html('');

                $.ajax({
                    url:THE4_AjaxURL,
                    type: 'post',
                    data: {
                        action: 'the4_ajax_login',
                        data: _form.serialize(),
                        security_code: _btn.data('skey') },
                    success: function( data ) {

                         _btn.removeClass('loading');

                        var obj = JSON.parse( data );

                        _err.html(obj.message);

                        if( obj.error == false ){
                            window.location.reload(true);
                        }
                    }
                });
            });

        //Register
            $('form.woocommerce-form-register').on('submit', function( e ) {
                e.preventDefault();

                var _btn = $(this).find('button[type=submit]'), _form = $( this ), _err = _form.find(' .error');

                _btn.addClass('loading');
                _err.html('');

                $.ajax({
                    url:THE4_AjaxURL,
                    type: 'post',
                    data: {
                        action: 'the4_ajax_register',
                        data: _form.serialize(),
                        security_code: _btn.data('skey') },
                    success: function( data ) {

                         _btn.removeClass('loading');

                        var obj = JSON.parse( data );

                        _err.html(obj.message);

                        if( obj.error == false ){
                            window.location.reload(true);
                        }
                    }
                });
            });
        }
    }

    // Initialize search form in header.
    var initSidebar = function() {

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

        $('.search_on_top .the4-icon-cart').on('click', function () {
            window.location = $(this).find('a').attr("href");
            return false;
        });

    }

    //The4 Woocommere search ajax
    function initThe4WoocommereSearch() {

        //add Search full Width
        var search_wrapper = $('.the4-woocommere-search');
        if (window_w < 1025) {
            search_wrapper.addClass('nt_fk_full');
            setTimeout(function() {
                search_wrapper.css('opacity', '1');
            }, 500);
        }

        var the4WoocommereSearch = function(form,query,currentQuery,timeout){

                var search     = form.find('.the4-search'),
                _frmParent     = form.closest('.cl_h_search'),
                category       = form.find('.the4-search-category'),
                result_content = $('.the4-search-results'),
                ld_bar         = $('.ld_bar_search'),
                skeleton       = $('.skeleton_js'),
                search_header  = $('.search_header__prs');

            if ( !search.hasClass('search_ajax_enable')) return;



            query = query.trim();

            if (query.length >= 3) {

                if (timeout) {
                    clearTimeout(timeout);
                }
                search_header.find('.h_suggest').addClass('dn');
                search_header.find('.h_results').removeClass('dn');
                search_header.removeClass('dn');

                result_content.html('');
                result_content.removeClass('the4-empty');
                _frmParent.addClass('atc_show_rs');
                ld_bar.addClass('on_star');
                skeleton.removeClass('dn');
                if (query != currentQuery) {
                    timeout = setTimeout(function() {

                        $.ajax({
                            url:THE4_AjaxURL,
                            type: 'post',
                            data: {
                                action: 'the4_search_product',
                                keyword: query, category: category.val(),
                                security_code: THE4_NONCE },
                            success: function(data) {
                                currentQuery = query;
                                ld_bar.addClass('on_end');
                                skeleton.addClass('dn');
                                setTimeout(function() {
                                    ld_bar.attr('class', '').addClass('ld_bar_search');
                                    if (!(result_content.hasClass('the4-empty'))) {

                                        if (data.length) {
                                            result_content.html(data).addClass('the4-active');
                                        } else {
                                            result_content.html('No product').addClass('the4-active');
                                        }

                                    }
                                }, 280);
                                clearTimeout(timeout);
                                timeout = false;
                            }
                        });

                    }, 500);
                }
                $('.search_on_top').addClass('the4-resuilt-active');
                $('.search_on_top .the4-woocommere-search__content').removeClass('dn');
            } else {
                skeleton.addClass('dn');
                clearTimeout(timeout);
                timeout = false;
                $('.search_on_top').removeClass('the4-resuilt-active');
                $('.search_on_top .the4-woocommere-search__content').addClass('dn');
                $('.search_on_top .h_suggest').removeClass('dn');
                $('.search_on_top .h_results').addClass('dn');
            }
        }
        body.on('click', function (e) {
            var target = e.target,
                _target = $(target),
                _targetParents = _target.parents();
            if (!_target.is('.cl_h_search') && !_targetParents.is('.cl_h_search') && !_targetParents.is('.js_h_search')) {
                //$('.atc_show_rs,.atc_opended_rs').removeClass('atc_show_rs atc_opended_rs');
                $('.atc_show_rs').removeClass('atc_show_rs');
                var val_old = '';
            }
            if (!_targetParents.is('.search-overlap')) {
                $('body').removeClass('hsearch-dropdown-opened');
            }
        });
        //End the4WoocommereSearch;
        $('form[name="the4-product-search"]').each(function(){

            var form          = $(this),
                search        = form.find('.the4-search'),
                category      = form.find('.the4-search-category'),
                currentQuery  = '',
                timeout       = false;

            category.on('change',function(){
                currentQuery  = '';
                var query = search.val();
                the4WoocommereSearch(form,query,currentQuery,timeout);
            });

            search.keyup(function(){
                var query = $(this).val();
                the4WoocommereSearch(form,query,currentQuery,timeout);
            });

        });
    }

    //Init megamenu
    function initMegamenu() {
        if ($('.the4-navigation.main-menu-left li.menu-width-full-width:not(.pos-center)').length > 0) {
            $('.the4-navigation.main-menu-left li.menu-width-full-width:not(.pos-center)').each(function () {
                $(this).addClass('pos-center');
            });
        }
        if ($('.the4-navigation.main-menu-left li.pos-center').length > 0) {

            var container = $('#the4-header .main-menu-wrapper'),
                $window = $(window),
                window_size = $window.width();


            if (container != 'undefined') {
                var container_width = 0;
                container_width = container.innerWidth();
                var width_mega  = $('.sub-menu:not(.megamenu-dropdown)').width();
                var container_offset = container.offset();
                setTimeout(function () {
                    $('.the4-menu > li.pos-center').each(function (index, element) {
                        $(element).children('.sub-menu:not(.megamenu-dropdown)').css({'max-width': container_width + 'px'});
                        var sub_menu_width = $(element).children('.sub-menu:not(.megamenu-dropdown)').outerWidth();
                        var item_width = $(element).outerWidth();
                        $(element).children('.sub-menu:not(.megamenu-dropdown)').css({'left': '-' + (sub_menu_width / 2 - item_width / 2) + 'px'});
                        var container_left = container_offset.left;
                        var container_right = (container_left + container_width);
                        var item_left = $(element).offset().left;
                        var overflow_left = (sub_menu_width / 2 > (item_left - container_left));
                        var overflow_right = ((sub_menu_width / 2 + item_left) > container_right);
                        if (overflow_left) {
                            var left = (item_left - container_left);
                            $(element).children('.sub-menu:not(.megamenu-dropdown)').css({'left': -left + 'px'});
                        }
                        if (overflow_right && !overflow_left) {
                            var left = (item_left - container_left);
                            left = left - ( container_width - sub_menu_width );
                            $(element).children('.sub-menu:not(.megamenu-dropdown)').css({'left': -left + 'px'});
                        }
                    })
                    $('.the4-menu > li.pos-center').each(function (index, element) {
                        if (window_size < width_mega) {
                            $(element).children('.sub-menu:not(.megamenu-dropdown) .container').css({'max-width': container_width + 'px'});
                        }else{
                            $(element).children('.sub-menu:not(.megamenu-dropdown) .container').css({'max-width':'inherit'});
                        }
                    });

                }, 100);


            }
        }else{
            var megamenu = $('.the4-menu > li.menu-mega-dropdown');
            megamenu.each(function() {
                    let li         = $(this),
                    $window        = $(window),
                    screenWidth    = $window.width(),
                    global_wrapper = $( '#the4-wrapper' ),
                    bodyRight      = global_wrapper.outerWidth() + global_wrapper.offset().left,
                    viewportWidth  = ( body.hasClass('wrapper-boxed') || body.hasClass('wrapper-boxed-small') ) ? bodyRight : screenWidth;

                let nav_dropdown = li.find( ' > .sub-menu' );

                nav_dropdown.addClass( 'calc_pos' ).attr( 'style', '' );
                let nav_dropdownWidth  = nav_dropdown.outerWidth(),
                    nav_dropdownOffset = nav_dropdown.offset(),
                    extraSpace = ( li.is( '.menu-width-full-width, .menu-width-custom_size' ) ) ? 18 : 0;

                if ( !nav_dropdownWidth || !nav_dropdownOffset ) return;

                let dropdownOffsetRight = screenWidth - nav_dropdownOffset.left - nav_dropdownWidth;

                if ( nav_dropdownWidth >= 0 && li.hasClass('pos-center')  /*li.is( '.menu-width-full-width, .menu-width-custom_size' )*/ ) {

                    let toLeft = ( nav_dropdownOffset.left + ( nav_dropdownWidth / 2 ) ) - screenWidth / 2;

                    if ( is_rtl ) {
                        nav_dropdown.css( { right : toLeft - extraSpace } );
                    } else {
                        nav_dropdown.css( { left : -toLeft - extraSpace } );
                    }
                } else if ( is_rtl
                            && ( dropdownOffsetRight + nav_dropdownWidth >= viewportWidth )
                                && ( li.hasClass( 'menu-width-full-width' ) || li.hasClass( 'menu-width-custom_size' )  )
                        ) {
                    // If right point is not in the viewport
                    var toLeft = dropdownOffsetRight + nav_dropdownWidth - viewportWidth;

                    nav_dropdown.css({
                      right: - toLeft - extraSpace
                    });
                } else if ( ( nav_dropdownOffset.left + nav_dropdownWidth >= viewportWidth )
                            && ( li.hasClass( 'menu-width-full-width' ) || li.hasClass( 'menu-width-custom_size' )  ) ) {
                    var toRight = nav_dropdownOffset.left + nav_dropdownWidth - viewportWidth;

                        nav_dropdown.css({
                          left: - toRight - extraSpace
                        });
                }
            });
        }
    }

    var KallesMenuhoverIntent = function () {
        if( ! yesHover ) return;

        $("#the4-menu li.menu-mega-dropdown").each(function (e, i) {
          var _this = $(this);

          _this.hoverIntent({
              sensitivity: 3,
              interval: 35,
              timeout: 150,
              over: function (t) {
                 _this.addClass("menu_item_hover");
              },
              out: function () {
                 _this.removeClass("menu_item_hover");
              },
          });
        });

    };

    // Add coupon code on Mini cart

    function miniCartTools() {
        $(body).on('click', '.js_cart_save_dis', function(e) {
            e.preventDefault();
            var coupon_code = $('#the4_coupon_code').val(),
                _this = $(this);
            if ( coupon_code ) {
                var data = {
                    coupon_code: coupon_code,
                    action: 'the4_kalles_add_coupon',
                    security_code: THE4_NONCE
                };

                _this.addClass('the4-loading');

                $.ajax({
                    url     : THE4_AjaxURL,
                    type    : 'POST',
                    dataType: 'json',
                    data    : data,
                    success : function(response) {
                        _this.removeClass('the4-loading');
                        if ( response.add_coupon ) {
                            $('.js_cat_dics').removeClass( 'dn' )
                                .html( response.discount_total );

                            $('.js_cat_ttprice').html( response.sub_total);

                            $('.js_cart_tls_back').trigger('click');
                        } else {
                            $('.the4_coupon_result').text( response.text );
                        }

                    }
                });
            }

        });
        // Add order note
        if (sessionStorage.the4_order_note) {
            $('#CartSpecialInstructions').val(sessionStorage.the4_order_note);
            $('#order_comments').val(sessionStorage.the4_order_note);
        }
        $(body).on('click', '.js_cart_save_note', function(e) {
            e.preventDefault();
            var note = $('#CartSpecialInstructions').val(),
                _this = $(this);
            if ( note ) {
                sessionStorage.setItem('the4_order_note', note);
            }
            _this.removeClass('the4-loading');
            $('.js_cart_tls_back').trigger('click');
        });



        // Minicart shipping Calculate

        $( body ).on('click', '.js_cart_caculate_shiping', function(e) {
            e.preventDefault();
            var _this = $(this),
                form = _this.closest('.kalles-woocommerce-shipping-calculator'),
                data = {
                    calc_shipping_country : $('#calc_shipping_country').val(),
                    calc_shipping_state   : $('#calc_shipping_state').val(),
                    calc_shipping_postcode: $('#calc_shipping_postcode').val(),
                    calc_shipping_city    : $('#calc_shipping_city').val(),
                    action                : 'the4_kalles_caculate_shiping',
                    security_code         : _this.data('skey')
                };
            _this.addClass('the4-loading');

            $.ajax({
                url    : THE4_AjaxURL,
                type   : 'POST',
                data   : data,
                success: function(response) {
                    $('#response_calcship').hide();
                    $('#response_calcship').html(response).fadeIn();
                    _this.removeClass('the4-loading');
                }
            });

        });

        // Minicart add Gift

        $( body ).on('click', '.js_cart_add_gift', function(e) {
            e.preventDefault();
            var _this = $(this),
                product_id = _this.data('id'),
                data = {
                    product_id: product_id,
                    action: 'the4_kalles_add_gift_cart',
                    security_code: _this.data('skey')
                };
            _this.addClass('the4-loading');

            $.ajax({
                url: THE4_AjaxURL,
                type: 'POST',
                data: data,
                success: function(response) {
                    var html = `<li class="woocommerce-mini-cart-item flex cart__mini-item cart-item-${response.pid} mini_cart_item" data-cart-item='${response.cart_key}'>`;
                    html += '<div class="ld_cart_bar"></div>';
                    html += `<a class="mini-cart-pimg">${response.pimg}</a>`;
                    html += '<div class="mini_cart_info">';
                    html += '<a href="#" class="mini_cart_title truncate">' + response.pname + '</a>';
                    html += '<div class="mini_cart_meta">';
                    html += '<div class="cart_meta_price">'+ response.pprice +'</div>'; //.cart_meta_price
                    html += '<div class="add_to_cart_button mini_cart_actions mt__20">';
                    html += `<a href="javascript:void(0);" rel="nofollow"
                                    data-prod="${response.pid}"
                                    class="cart_ac_remove js_cart_rem ttip_nt tooltip_top_right is_product_gift_wrap">
                                                    <span class="tt_txt">Remove this item</span>
                                                    <svg viewBox="0 0 24 24"><use xlink:href="#scl_remove"></use></svg>
                                                </a>`;
                    html += '</div>'; //.mini_cart_actions
                    html += '</div>'; //.mini_cart_meta
                    html += '</div>'; //.mini_cart_info
                    html += '</li>';
                    $('ul.woocommerce-mini-cart').append(html);
                    $( '.the4-icon-cart .count' ).text( response.items_count );
                    $('.mini_cart_tool_gift').css('display', 'none');
                    _this.closest('.mini_cart_gift').find('.js_cart_tls_back').trigger('click');
                    _this.removeClass('the4-loading');
                }
            });

        });
    }

    // Age verify.
    var The4KallesAgeVerify = function () {
      if ( typeof Cookies == 'undefined' ) return;
        if ( $('.popup_age_wrap').length == 0 || Cookies.get('kalles_age_verify') == 'confirmed')  return;

            var popup     = $('.popup_age_wrap'),
            stt           = popup.data('stt'),
            age_limit     = stt.age_limit,
            date_of_birth = stt.date_of_birth,
            day_next      = stt.day_next;


        var showPopup = function () {
            $.magnificPopup.open({
                items: {
                    src: '.popup_age_wrap'
                },
                type           : 'inline',
                closeOnBgClick : false,
                closeBtnInside : false,
                showCloseBtn   : false,
                enableEscapeKey: false,
                removalDelay   : 500,
                //tClose: nt_settings.close,
                callbacks: {
                    beforeOpen: function () {
                        this.st.mainClass ='mfp-move-horizontal age_pp_wrapper';
                    },
                }
            });
        };

        showPopup();

        $('.age_verify_allowed').on('click', function(){

            if ( date_of_birth ) {
                    var year  =  parseInt($('#ageyear').val()),
                    month     = parseInt($('#agemonth').val()),
                    day       =   parseInt($('#ageday').val()),
                    theirDate = new Date((year + age_limit), month, day),
                    today     = new Date;

                if ((today.getTime() - theirDate.getTime()) < 0) {
                    popup.addClass('animated shake');
                    window.setTimeout(function(){
                        popup.removeClass('animated shake');
                    }, 1000);
                } else {
                    Cookies.set('kalles_age_verify', 'confirmed', { expires: parseInt( day_next ), path: '/' });
                    $.magnificPopup.close();
                }
            } else {
                Cookies.set('kalles_age_verify', 'confirmed', { expires: parseInt( day_next ), path: '/' });
                $.magnificPopup.close();
            }

        });

        $('.age_verify_forbidden').on('click', function(){
            popup.addClass('active_forbidden');
        });
    };

    // Cookies law.
    var The4KallesCookiesLawPP = function () {
      if ( typeof Cookies == 'undefined' ) return;

        var popup = $('.popup_cookies_wrap'),
            popup_parent = popup.parent(),
            stt = popup.data('stt');
        try {
            var pp_version = stt.pp_version;
        }
        catch(err) {
            var pp_version = 1994;
        }
        if ( (Cookies.get('kalles_cookies_' + pp_version) == 'accepted') || popup.length == 0 ) return;

        var cookie_wraper = $('#kalles-section-cookies_law');
        if (cookie_wraper.hasClass('popup')) {
            if ( window.location.href == cookie_wraper.data('url')) return;
            $.magnificPopup.open({
                items: {
                    src: cookie_wraper
                },
                type           : 'inline',
                closeOnBgClick : false,
                closeBtnInside : false,
                showCloseBtn   : false,
                enableEscapeKey: false,
                removalDelay   : 500,
                callbacks: {
                    beforeOpen: function () {
                        this.st.mainClass ='mfp-move-horizontal cookie_pp_wrapper';
                    },
                }
            });
            popup.on('click', '.pp_cookies_accept_btn', function (e) {
                e.preventDefault();
                $.magnificPopup.close();
                acceptCookies();
            });
        } else {
            var showPopup = function () {
                popup_parent.removeClass('pp_onhide').addClass('pp_onshow');
                popup.on('click', '.pp_cookies_accept_btn', function (e) {
                    e.preventDefault();
                    popup_parent.removeClass('pp_onshow').addClass('pp_onhide');
                    acceptCookies();
                });
            };
            setTimeout(function () {
                showPopup();
            }, 2500);
            if (cookie_wraper.data('scrollhide') == '1') {
                $(window).scroll(function(event) {
                    if(window.pageYOffset > 100) {
                        popup_parent.removeClass('pp_onshow').addClass('pp_onhide');
                        acceptCookies();
                    }
                });
            }
        }

        var acceptCookies = function () {
            Cookies.set('kalles_cookies_' + pp_version, 'accepted', { expires: stt.day_next, path: '/' });
        };

    };
    //Make radom image
    var The4KallesGetRandomInt = function (min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    };
    //Sale Popup
    var The4KallesSalesPopup = function () {

        if ($('.popup_slpr_wrap').length == 0
            || ($('.salse_pp_mb_false').length > 0 && $(window).width() < 768)) return;

        var popup         = $('.popup_slpr_wrap'),
            stt           = popup.data('stt'),
            show          = stt.show,
            limit         = stt.limit - 1,
            pp_type       = stt.pp_type,
            arrTitle      = kalles_sale_popup.sale_title,
            arrUrl        = stt.url,
            arrImage      = stt.image,
            arrID         = stt.id,
            arrLocation   = kalles_sale_popup.sale_location,
            arrTime       = kalles_sale_popup.sale_time,
            ClassUp       = stt.ClassUp,
            ClassDown     = stt.classDown[ClassUp],
            StarTimeout   ,StayTimeout,

            slpr_img      = $('.js_slpr_img'),
            slpr_a        = $('.js_slpr_a'),
            slpr_tt       = $('.js_slpr_tt'),
            slpr_location = $('.js_slpr_location'),
            slpr_ago      = $('.js_slpr_ago'),
            slpr_qv       = $('.pp_slpr_qv'),

            index         = 0,
            min           = 0,
            max           = arrUrl.length - 1,
            max2          = arrLocation.length - 1,
            max3          = arrTime.length - 1,
            StarTime      = stt.StarTime * stt.StarTime_unit,
            StayTime      = stt.StayTime * stt.StayTime_unit;

        //Check page display:
        if (popup.data('display') == 0) return;


        var Updatedata = function (index) {

            // update img
            var img = arrImage[index];

            slpr_img.attr('src',img);

            slpr_img.attr('srcset',img);

            // update title
            slpr_tt.text(arrTitle[index]);

            // update link
            slpr_a.attr('href',arrUrl[index]);

            // update id quick view
            slpr_qv.attr('data-prod',arrID[index]);

            // update location
            slpr_location.text(arrLocation[The4KallesGetRandomInt(min, max2)]);

            // update time
            slpr_ago.text(arrTime[The4KallesGetRandomInt(min, max3)]);

            showSlaesPopUp();
        };

        // Load sales popup
        var loadSalesPopup = function () {
            //if (nt_check) return;
            if (pp_type == '1') {
                Updatedata(index);
                ++index;
                if (index > limit || index > max) {index = 0}

            } else {
                Updatedata(The4KallesGetRandomInt(min, max));
            }

            StayTimeout = setTimeout(function() {
                unloadSalesPopup();
            }, StayTime);
        };

        // unLoad sales popup
        var unloadSalesPopup = function () {
            hideSlaesPopUp();
            StarTimeout = setTimeout(function(){

                //console.log('Timeout loadSalesPopup');
                loadSalesPopup();

            }, StarTime);
        };
        //slideOutDown, fadeOut

        var showSlaesPopUp = function () {
            popup.removeClass('dn').addClass(ClassUp).removeClass(ClassDown);
        };

        var hideSlaesPopUp = function () {
            popup.removeClass(ClassUp).addClass(ClassDown);
        };

        $(".pp_slpr_close").on("click", function(e){
            e.preventDefault();
            hideSlaesPopUp();
            clearTimeout(StayTimeout);
            clearTimeout(StarTimeout);
        });

        popup.on('open_slpr_pp', function () {
            unloadSalesPopup();
        });

        // Run unloadSalesPopup
        unloadSalesPopup();

    };
    //btn Animation
    var The4KallesATC_animation = function (id) {
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
    };


    //Exist product Popup
    var The4KallesPromoPrPopup = function () {
        if ( typeof Cookies == 'undefined' ) return;
        var pp_version = 1;
        if ( window_w < 1025
            || !yesHover
            || (Cookies.get('kalles_age_verify') != 'confirmed' && $('.popup_age_wrap').length > 0)
            || (Cookies.get('kalles_prpr_pp_' + pp_version) == 'shown')
            || THE4_Data_Js['exist_product_cat'] == '0') return;

        var showPopup = function () {

            $.ajax({
                url: THE4_AjaxURL,
                type: 'POST',
                data: {
                    action: 'the4_kalles_exist_product_popup'
                },
                success: function(response) {
                    var check_display = false;
                    response.page_display.forEach( function(item, index) {
                        if (body.hasClass(item) || item == 'all') check_display = true;
                    });
                    if (check_display == false) return;

                    $.magnificPopup.open({
                        items: {
                            src: response.output,
                            type: 'inline',
                        },
                        tClose: 'Close',
                        removalDelay: 500, //delay removal by X to allow out-animation
                        callbacks: {
                            beforeOpen: function () {
                                this.st.mainClass ='mfp-move-horizontal prpr_pp_wrapper mfp-fade';
                            },
                            open:function () {

                                $('.popup_prpr_wrap .the4-carousel:not(.slick-initialized)').slick();
                                $(document).off('mouseleave.registerexit');
                            },
                            close:function () {
                                Cookies.set('kalles_prpr_pp_' + pp_version, 'shown', { expires: parseInt(response.day_next), path: '/' });
                            }
                            // e.t.c.
                        }
                    });
                }
            })
        };

        // Detect exit
        $(document).on('mouseleave.registerexit', function(e){
            if ( e.clientY < 60 && $('.mfp-content').length == 0 && $('.popup_prpr_wrap').length == 0){
                showPopup();
            }
        });
    };

    //Product live view
    var The4KallesReal_time = function () {

        var $el = $('#the4-kalles-product-liveview');
        //console.log($el);
        if ($el.length == 0) return;

        var min      = $el.data('min'),
            max      = $el.data('max'),
            interval = $el.data('interval'),
            o        = The4KallesGetRandomInt(min,max),
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
                o = The4KallesGetRandomInt(min,max);
            }
            $el.find(".count").html((parseInt(o)));
            $el.show();

        }
        ShowView();
        setInterval(ShowView, interval);
    };
    //Product live view
    var The4KallesFlashSold = function () {
        var $el = $('#the4-kalles-product-flash-sale');
        if ($el.length == 0) return;

        var mins = $el.data('mins'),
            maxs = $el.data('maxs'),
            mint = $el.data('mint'),
            maxt = $el.data('maxt');

        $el.find(".nt_pr_sold").html(The4KallesGetRandomInt(mins,maxs));
        $el.find(".nt_pr_hrs").html(The4KallesGetRandomInt(mint,maxt));
        $el.show();
    };

    var The4KallesGetDateCountdown = function(date) {

            if (typeof date == 'undefined') return;

            var rt_date = date.replace("24:00:00", "23:59:59");

            if (timezone != 'not4' ) {
                try {

                    rt_date = moment.tz(date.replace(/\//g,"-"), timezone).toDate();
                }
                catch(err) {
                    console.log('Timezone error: '+timezone);
                }
            } else {
                rt_date = new Date(rt_date);
            }
            return rt_date
        },

        //Product delivery order
        The4KallesDeliveryOrder = function () {

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
                local_time       = (bltimezone && order_bltimezone) ? timezoneDay.format('HHmmss') : day_t4_js.format('HHmmss'),
                timeint          = time.replace(/ /g,'').replace(/:/g,''),
                arr_d            = time.replace(/ /g,'').split(':'),
                local_date       = day_t4_js.format('YYYY/MM/DD'),
                shopt            = (bltimezone && order_bltimezone) ? timezoneDay.format('YYYY/MM/DD') : local_date;
            local_date       = shopt + ' ' + time;

            if (bltimezone && order_bltimezone) {
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
        };

    //Product page stock left progressbar
    var The4KallesProgressbar = function () {

        var $id = $('#the4-kalles-product-left-stock');
        var qty = $id.data('cur');
        if ($id.length == 0) return;

        $id.removeAttr('data-ttcalc');
        var pr_id = $id.data('prid');
        var updateMeter = function (a, remaining_items,bgprocess,bgten) {

            remaining_items =  parseInt(remaining_items);
            if(sp_nt_storage) {sessionStorage.setItem('probar'+pr_id, remaining_items)}
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
            var remaining_items =  The4KallesGetRandomInt(min_items_left, max_items_left);
        } else {
            var remaining_items = qty || The4KallesGetRandomInt(min_items_left, max_items_left);
        }
        if(sp_nt_storage && dt_type == 'ATC_NONE') {
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
                remaining_items = qty || The4KallesGetRandomInt(min_items_left, max_items_left)
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
                remaining_items = qty || The4KallesGetRandomInt(min_items_left, max_items_left)
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

    };

    //Display variant selected
    var StickyLabelVariant = function() {

        var swatch_label = '',
            swatch_list = $('li.swatch__list--item').toArray();

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        if (swatch_list) {
            swatch_list.forEach( function(item, index) {
                if ($(item).hasClass('is-selected')) {

                    var label = $(item).find('.swatch__tooltip').text();

                    if ( !label ) {
                        label = capitalizeFirstLetter( $(item).data('variation') );
                    }
                    if (swatch_label == '') {
                        swatch_label += label;
                    } else {
                        swatch_label += ' / ' + label;
                    }
                }

            });
        }

        $('.sticky_atc_a').text(swatch_label);

        //Product price
        $.fn.wc_variations_image_update = function( variation ) {

            if (variation.price_html) {
                $('.sticky_atc_price').html(variation.price_html);
            }
        }

    }

    //Kalles product Swatches
    var The4KallesProductSwatches = function() {
        var _galleries = $( '.variations_form' ).data( 'galleries' );
        var _form_data = $( '.variations_form' ).data( 'product_variations' );

        // ======================================================
        // Update HTML
        // ------------------------------------------------------
        function kalles_swatches_update_images() {
            setTimeout( function() {
                $( '.variations_form select[data-attribute_name]' ).trigger( 'change' );
            });

            var selected = [];
            $( 'body' )
                .on( 'click touchstart', '.variations_form .swatch__list--item:not(.is-selected)', function ( e ) {

                    e.preventDefault();
                    e.stopPropagation();

                    _form      = $( this ).parents( 'form' );
                    _galleries = _form.data( 'galleries' );
                    _form_data = _form.data( 'product_variations' );
                    _pid       = _form.data( 'product_id' );

                    var _this       = $( this ),
                        _select         = _this.parent().next( '.value' ).find( 'select' ),
                        _attr           = _this.parent().data( 'attribute' ),
                        _variation      = _this.data( 'variation' ),
                        _is_color_label = $( this ).parents('.is-color').length;

                    // Check if this combination is available
                    if ( ! _select.find( 'option[value="' + _variation + '"]' ).length ) {
                        _this.addClass( 'is-selected' );
                        _this.siblings( '.swatch__list--item' ).removeClass( 'is-selected' );
                        _select.val( '' ).change();
                        _form.trigger( 'kalles_swatches_no_matching_variations', [_this] );
                        return;
                    }

                    if ( selected.indexOf( _attr ) === -1) {
                        selected.push( _attr );
                    }

                    if ( _this.hasClass( 'is-selected' ) ) {
                        _select.val( '' );
                        _this.removeClass( 'is-selected' );
                        delete selected[selected.indexOf( _attr )];
                        _select.change();
                    } else {
                        _this.addClass( 'is-selected' ).siblings( '.is-selected' ).removeClass( 'is-selected' );
                        _select.val( _variation );
                        _select.change();
                    }
                    if (_is_color_label > 0) {
                        $( document.body ).trigger( 'kalles_swatches_update_html', {
                            'pid': _pid,
                            '_this': _this
                        });

                    }


                })
                .on( 'click', '.reset_variations', function() {
                    $( this ).closest( '.variations_form' ).find( '.swatch__list--item.is-selected' ).removeClass( 'is-selected' );

                    selected = [];
                })
                .on( 'kalles_swatches_no_matching_variations', function() {
                    window.alert( wc_add_to_cart_variation_params.i18n_no_matching_variations_text );
                });

            // Update image gallery for default value
            if ( $( '.swatch__list--item' ).hasClass( 'is-selected' ) ) {
                var _this = $( '.swatch__list--item.is-selected' ),
                    _form = $( '.variations_form' ),
                    _pid = _form.data( 'product_id' ),
                    _is_color_label = $( this ).parents('.is-color').length;
                if (_is_color_label > 0) {
                    $( document.body ).trigger( 'kalles_swatches_update_html', {
                            'pid': _pid,
                            '_this': _this
                        });
                }
            }

            function isMatch ( variation_attributes, attributes ) {
                var match = true;

                // loop all attributes to see this variation is valid or not
                for ( var attr_name in variation_attributes ) {
                    if ( variation_attributes.hasOwnProperty( attr_name ) ) {
                        var val1 = variation_attributes[ attr_name ];
                        var val2 = attributes[ attr_name.replace('attribute_', '') ];
                        // if attribute value of variation is not equal value is selected => not matched
                        if (
                            val1 !== undefined && val2 !== undefined && val1 && val2
                            && val1.length !== 0 && val2.length !== 0 && val1 !== val2 ) {
                            match = false;
                        }
                    }
                }
                return match;
            };

            function findMatchingVariations ( variations, attributes ) {
                var matching = [];
                for ( var i = 0; i < variations.length; i++ ) {
                    var variation = variations[i];
                    // if this variation is in stock and matched => this variation is valid
                    if ( variation.is_in_stock && isMatch( variation.attributes, attributes ) ) {
                        matching.push( variation );
                    }
                }
                return matching;
            };

            // Refresh options of available variations.
            $( '.variations_form' ).on( 'change', 'select[data-attribute_name]', function() {
                setTimeout( function() {
                    // get info of variations from server
                    var attributes      = $( '.variations_form' ).data( 'attributes' );
                    var variations      = $( '.variations_form' ).data( 'product_variations' );
                    var selected        = {};
                    var attributes_info = {};

                    $.each( attributes, function( key, attrs_array ) {
                        // get selected value from select
                        selected[key] = $(`.variations_form #${key}`).val();
                        // set all values of attribute are disable, false is disable
                        $.each( attrs_array, function( k2, attr_val ) {
                            attributes_info[attr_val] = false;
                        });
                    });

                    // check each attribute is enable (true) or disable (false)
                    $.each( attributes, function( handling_attr, handling_val ) {
                        var compared_attr = 'attribute_' + handling_attr;
                        var checkedAttrs = {...selected};
                        // only check rest attributes to find matched variations, no check handling_attr
                        checkedAttrs[handling_attr] = '';
                        var matchedVariations = findMatchingVariations(variations, checkedAttrs);
                        // check variations are valid or not
                        $.each( matchedVariations, function( k1, variation ) {
                            var variationAttributes = variation.attributes;
                            $.each( variationAttributes, function( attr_name, attr_val ) {
                                if(attr_name == compared_attr) {
                                    // enable only this value of attribute
                                    if(attr_val) {
                                        attributes_info = {...attributes_info, [attr_val]: true};
                                        // enable all values of this attribute
                                    } else {
                                        $.each( attributes, function( attribute_name, attribute_values ) {
                                            if('attribute_' + attribute_name == attr_name) {
                                                $.each( attribute_values, function( key, value ) {
                                                    attributes_info = {...attributes_info, [value]: true};
                                                });
                                            }
                                        });
                                    }

                                }
                            });
                        });
                    });

                    $.each( attributes_info, function( attr_name, attr_val ) {
                        // disable if that attr is not active
                        if( !attr_val ) {

                            $('.variations_form li[data-variation="' + attr_name + '"]').addClass( 'disabled' );

                        } else {

                            $('.variations_form li[data-variation="' + attr_name + '"]').removeClass( 'disabled' );
                        }

                    });
                }, 50 );
            });

        }

        // ======================================================
        // Update images on product list
        // ------------------------------------------------------
        function kalles_swatches_change_images() {
            $( 'body' ).on( 'click touchstart', 'div.swatch__list span.swatch__value', function() {

                var parent = $(this).parent();
                var _src           = $( parent ).data( 'thumb' ),
                    _src_flip      = $( parent ).data( 'thumb-flip' ),
                    _title         = $( parent ).data( 'title' ),
                    _product_title = $( parent ).data( 'product-title' );

                // Add class is-selected
                $('.swatch__list > span.is-selected').removeClass('is-selected');
                parent.addClass('is-selected');

                if ( typeof _src !== typeof undefined && _src !== false ){
                    if ( body.hasClass( 'home' ) ) {
                        $( parent ).closest( '.product' ).find( '.product-image-loop img' ).attr( 'src', _src ).attr( 'srcset', _src );
                    } else {
                        $( parent ).closest( '.product' ).find( 'img.attachment-shop_catalog, img.attachment-woocommerce_thumbnail' ).attr( 'src', _src ).attr( 'srcset', _src );
                    }
                }

                if ( typeof _title !== typeof undefined && _title !== false && typeof _product_title !== typeof undefined && _product_title !== false ){
                    $( this ).parents().eq(2).find( '.product-title a' ).text( _product_title + ' ' + _title );
                }

                if ( typeof _src_flip !== typeof undefined && _src_flip !== false ){
                    $( parent ).closest( '.product' ).find( '.wp-image-flip' ).attr( 'src', _src_flip ).attr( 'srcset', _src_flip );
                }
            });
        }

        kalles_swatches_update_images();
        kalles_swatches_change_images();


    }

    // Change Main image and gallery when click change variant.
    var The4KallesClickVariant = function () {

        body.on('afterChange','.single-product-thumbnail .p-thumb', function(event, slick, currentSlide) {
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
            The4KallesChangeImage(productId, galleries, galleryKey, false, selected_variant_id);
        });
    }

    // Change Main image and gallery for Default variant.
    var The4KallesSelectedVariantion = function () {
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
        if ( key_variant )
            The4KallesChangeImage(product_id, data_gallery, key_variant, true);

    }

    //Change variations image
    var The4KallesChangeImage = function(productId, galleries, galleryKey, first, selected_variant_id = '') {
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
                                $(".the4-carousel .slick-current.p-item img").ezPlus(The4Kalles.t4_zoom_option);
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
                    The4Kalles.initMasonry();
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
                && ! The4Kalles.isMobile() ) {

                selector.ezPlus(The4Kalles.t4_zoom_option);

            }
        }
    }


    // Display warning messager when Customer not select variant
    var The4DisplaySelectedVariant = function() {

        var check_timeout = null;

        var form_add_to_cart = $('form.variations_form'),
            btn_add_to_cart = form_add_to_cart.find( '[type="submit"]' );

        if ( form_add_to_cart.lenght == 0 ) return;

        //Destroy Woocommerce default event
        $( document ).on( 'check_variations', function( e ) {

            clearTimeout( check_timeout );

            check_timeout = setTimeout(function(){
                if ( btn_add_to_cart.hasClass( 'wc-variation-selection-needed' )) {
                    form_add_to_cart.unbind('click');
                }
            },500);
        } );

        body.on( 'click', '.single_add_to_cart_button.wc-variation-selection-needed', function( e ) {
            e.preventDefault();
            $('.t4-variant-warning').slideDown('fast');
        })


        $( document ).on( "found_variation.first", function ( e, v ) {
            if ( $('.t4-variant-warning').length > 0 ) {
                $('.t4-variant-warning').slideUp();
            }
        } );
    }

    // Show More Less
    var The4KallesCatHeader6 = function (el) {

        var $element = $(el);
        if ($element.length == 0) return;
        var $window = $(window),
            windowHeight = $window.height(),
            offsetTop = $element.offset().top;
       if (offsetTop < windowHeight) {
            var fullHeight = 100 - (offsetTop + 40) / (windowHeight / 100);
            $element.addClass('mh_js_cat').css("max-height", fullHeight + "vh");
        }
    };

    /*******************************************
     *
     * WISHLIST LOCAL
     *
     * ****************************************/

    var The4KallesWishlistLocal = function () {
        if (THE4_Data_Js['wishlist-local'] != '1') return;

        var limit = 80;

        var wishlistUpdate = function(product_id, skey, remove = false, action) {
            var data = {
                product_id: product_id,
                action: action,
                security_code: skey
            };
            if (action == 'addWishlist') {
                var _this = $('.wishlistadd[data-id="'+product_id+'"]');
            } else {
                var _this = $('.wis_added[data-id="'+product_id+'"]');
            }

            _this.addClass('the4-loading');

            _this.find('i').css('opacity', '0');

            $.ajax({
                url: THE4_AjaxURL,
                type: 'POST',
                data: data,
                success: function(response) {
                    _this.removeClass('the4-loading');
                    _this.find('i').css('opacity', '1');
                    $('.jswcount').text(response.w_count);
                    if (remove) {
                        if (response.w_count == 0) location.reload();
                        _this.closest('.post-' + product_id).remove();
                    } else {
                        if (action == 'addWishlist') {
                            _this.removeClass('pe_none wishlistadd').addClass('wis_added wis_remove').find('.tt_txt').text(response.txt_added);
                            _this.parent('.nt_add_w').addClass('nt_added_w');
                        } else {
                            _this.removeClass('pe_none wis_added wis_remove').addClass('wishlistadd').find('.tt_txt').text(response.txt_added);
                            _this.parent('.nt_add_w').removeClass('nt_added_w');

                        }
                    }
                }
            });

        }
        // Add wishlist
        body.on('click', '.wishlistadd', function (e) {
            e.preventDefault();
            var _this = $(this),
                dt_id = _this.data('id') || '',
                skey = _this.data('skey');

            _this.addClass('pe_none');
            wishlistUpdate(dt_id, skey, false, 'addWishlist');

        });

        // Remove wishlist
        body.on('click', '.wis_remove.enable_remove', function (e) {
            e.preventDefault();
            var _this = $(this),
                dt_id = _this.data('id') || '',
                skey = _this.data('skey');

            _this.addClass('pe_none');
            wishlistUpdate(dt_id, skey, false, 'removeWishlist');

        });

        // Remove wishlist Page
        body.on('click', '.wis_remove.wishlist-page', function (e) {
            e.preventDefault();
            var _this = $(this),
                dt_id = _this.data('id') || '',
                skey = _this.data('skey');

            _this.addClass('pe_none');
            _this.css({
                'background-color': 'transparent',
                'box-shadow': 'none'
            });
            wishlistUpdate(dt_id, skey, true, 'removeWishlist');

        });

    };

    /*******************************************
     *
     * COMPARE LOCAL
     *
     * ****************************************/
    var The4KallesCompareLocal = function () {
        if (THE4_Data_Js['compare-local'] != '1') return;

        var compareUpdate = function(product_id, skey, remove = false, action, _this) {
            var data = {
                product_id: product_id,
                action: action,
                security_code: skey
            };

            _this.addClass('the4-loading');

            if ( remove ) {
                _this.find('span').addClass('t4-remove-loader');
            }

            _this.find('i').css('opacity', '0');
            $.ajax({
                url: THE4_AjaxURL,
                type: 'POST',
                data: data,
                success: function(response) {
                    _this.removeClass('the4-loading');
                    _this.find('i').css('opacity', '1');

                    if (remove) {
                        _this.find('span').addClass('t4-remove-loader');

                        $('.compare_id_' + product_id).remove();

                        if (response.cp_count == 0) location.reload();

                    } else {
                        _this.removeClass('compare_add pe_none').addClass('cpt4_added');
                        _this.find('.tt_txt').text( response.txt_added );
                    }
                }
            });

        }
        // Add Compare
        body.on('click', '.compare_add', function (e) {
            e.preventDefault();
            var _this = $(this),
                dt_id = _this.data('id') || '',
                skey = _this.data('skey');

            _this.addClass('pe_none');
            compareUpdate(dt_id, skey, false, 'addCompare', _this);

        });

        // Remove compare
        body.on('click', '.cpt4_remve.compare_remove', function (e) {
            e.preventDefault();
            var _this = $(this),
                dt_id = _this.data('id') || '',
                skey = _this.data('skey');

            _this.addClass('pe_none');
            _this.css({
                'background-color': 'transparent',
                'box-shadow': 'none'
            });
            compareUpdate(dt_id, skey, true, 'removeCompare', _this);

        });

    };

    /*
     * Lazyload
     * Using Lazysite library. https://github.com/aFarkas/lazysizes
     * @since 1.0.0
     */

    var The4KallesLazyload = function() {

        if ( ! is_lazyload ) return;

        $('.lazyloaded').closest('.the4-lazyload').removeClass('the4-lazyload');

        $(document).on('lazyloaded', function(e){
            var $image_parent = $(e.target).closest('.the4-lazyload');
            if ($image_parent.hasClass('the4-lazyload'))
                $image_parent.removeClass('the4-lazyload');

            //Product Zoom
            var p_item = $(e.target).closest('.p-item');

            if ( is_zoom && p_item.hasClass('the4-image-zoom')  && !window._inQuickview && !The4Kalles.isMobile() )
            {
                if ( $('.the4-wc-single.wc-single-1').length == 0 && body.hasClass('single-product') ) {
                    $(e.target).ezPlus(The4Kalles.t4_zoom_option);
                }

            }
        });
    }


    /**
     * Elementor products loadmore product
     */
    var The4KallesElementorLoadmore = function() {
        if ( $('.nt_home_lm').length = 0 ) return;

        body.on('click', '.nt_home_lm', function(e) {
            e.preventDefault();

            var _this = $(this),
                products_wrapper = _this.closest('.the4-sc-products'),
                products = products_wrapper.find('.products.row'),
                attrs = products_wrapper.data('attrs'),
                pages = products_wrapper.data('pages'),
                paged = parseInt( products_wrapper.attr('data-paged') );

            _this.addClass('the4-loading');

            paged += 1;

            $.ajax({
                type: 'POST',
                url: THE4_AjaxURL,
                dataType: 'html',
                data: {
                    action: 'kalles_addons_shortcode_products_ajax',
                    attrs : attrs,
                    paged : paged
                },
                success: function( response ) {
                    if ( products.hasClass('the4-masonry') ) {
                        var elem = $( response );

                        products.append( elem ).isotope( 'appended', elem );
                        products.imagesLoaded().progress( function() {
                            products.isotope('layout');
                        });
                    } else {
                        products.append( response );
                    }


                },
                error: function( xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                },
                complete: function() {
                    _this.removeClass('the4-loading');
                    products_wrapper.attr('data-paged', paged );

                    //Hide loadmore button if total page <= current page
                    if ( pages <= paged ) {
                        $('.nt_home_lm').hide();
                    }

                }
            });


        });
    }

    /**
     * CART COUNTDOWN
     **/

      var The4KallesCartCountdown = function (){
            var cart_cd = $('[data-cart-countdown]');

            if (cart_cd.length == 0) return;

            //format = '%H:%M:%S',
            var mn = parseInt(cart_cd.attr('data-mn')),
                unit = cart_cd.data('unit'),
                nt_cartcd_mn = 'nt_cartcd'+unit+mn,
                val = (unit == 'min') ? mn * 60 * 1000 : mn * 60 * 60 * 1000,
                format = '%M min %S sec',
                selectedDate,
                totalHours = 0,
                after_atc_1 = ($('[data-after-cartcd-1]').length>0);


            if (sp_nt_storage) {
               if (localStorage.getItem(nt_cartcd_mn) !== null) {
                  selectedDate = parseInt(localStorage.getItem(nt_cartcd_mn));
               } else {
                  selectedDate = new Date().valueOf() + val;
                  localStorage.setItem(nt_cartcd_mn, selectedDate);
               }
            }
            $('.js_cart_cd').show();
            cart_cd.countdown(selectedDate.toString()).on('update.countdown', function(event) {
                totalHours = event.offset.totalDays * 24 + event.offset.hours;
                if (totalHours > 24){
                  format = totalHours+' hr %M min %S sec';
                } else if (totalHours >= 1){
                  format ='%H hr %M min %S sec';
                }

               $(this).html(event.strftime(format));

            }).on('finish.countdown', function(event) {

               if (after_atc_1){

                  selectedDate = new Date().valueOf() + val;
                  localStorage.setItem(nt_cartcd_mn, selectedDate);
                  cart_cd.countdown(selectedDate.toString());

               }
            });

         }

    //Add params to all Link on demo site

    var addQueryParameterToDomain = function(key, value, conditionDomain) {
        var links = document.querySelectorAll('a[href]'),
            linksLength = links.length,
            index,
            queryIndex,
            queryString,
            query,
            url,
            domain,
            colonSlashSlash;

        // Iterate through and add query paramter
        for(index = 0; index < linksLength; ++index) {
            url = links[index].href,
                queryIndex = url.indexOf('?'),
                colonSlashSlash = url.indexOf('://');

            domain = url.substring(colonSlashSlash + 3);
            domain = domain.substring(0, domain.indexOf('/'));

            if(domain !== conditionDomain) {
                continue;
            }

            if(queryIndex === -1) {
                url += '?' + key + '=' + value;
            } else {
                queryString = url.substring(queryIndex);
                url = url.substring(0, queryIndex);
                query = parseQuery(queryString);

                query[key] = value;

                url += '?' + encodeQuery(query);
            }

            links[index].href = url;
        }

        function parseQuery(qstr) {
            var query = {};
            var a = (qstr[0] === '?' ? qstr.substr(1) : qstr).split('&');
            for (var i = 0; i < a.length; i++) {
                var b = a[i].split('=');
                query[decodeURIComponent(b[0])] = decodeURIComponent(b[1] || '');
            }
            return query;
        }

        // encodeQuery originally from StackOverflow: https://stackoverflow.com/a/1714899/2529423
        function encodeQuery(obj) {
            var str = [];
            for(var p in obj)
                if (obj.hasOwnProperty(p)) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
            return str.join("&");
        }
    }

    /**
     * NEWSLETTER POPUP
     **/

    var KallesNewsletterPopup = function () {

        if ($('.popup_new_wrap').length == 0 || ($('.mobile_new_false').length > 0 && $(window).width() < 768) || (Cookies.get('kalles_age_verify') != 'confirmed' && $('.popup_age_wrap').length > 0) ) return;

        var popup = $('.popup_new_wrap'),
          stt = popup.data('stt'),
          pp_version = stt.pp_version,
          shown = false,
          pages = Cookies.get('kalles_shown_pages');

          var showPopup = function () {
            $.magnificPopup.open({
              items: {
                src: '.popup_new_wrap'
              },
              type: 'inline',
              removalDelay: 500, //delay removal by X to allow out-animation
              tClose: 'Close',
              callbacks: {
                beforeOpen: function () {
                  this.st.mainClass ='mfp-move-horizontal new_pp_wrapper';
                },
                open: function () {
                  // Will fire when this exact popup is opened
                  // this - is Magnific Popup object
                },
                close: function () {
                  Cookies.set('kalles_popup_' + pp_version, 'shown', { expires: stt.day_next, path: '/' });
                }
                // e.t.c.
              }
            });
          };

          var showPopup2 = function () {
              if ($.magnificPopup.instance.isOpen) {
                 $.magnificPopup.close();
                 setTimeout(function(){ showPopup(); }, $.magnificPopup.instance.st.removalDelay+10);
              } else {
                showPopup();
              }
          };

          $('.kalles_open_newsletter').on('click', function (e) {
            e.preventDefault();
            showPopup2();
          });

          popup.on('open_newsletter', function () {
            showPopup2();
          });

          if (Cookies.get('kalles_popup_' + pp_version) != 'shown') {
            if (stt.after == 'scroll') {
              $(window).scroll(function () {
                if (shown) return false;
                if ($(document).scrollTop() >= stt.scroll_delay) {
                  showPopup2();
                  shown = true;
                }
              });
            } else {
              setTimeout(function () {
                showPopup2();
              }, stt.time_delay);
            }
          }
      };

    /**
     * El Product Tabs Widget
     **/

    The4Kalles.KallesElProductTabs = function () {
        $('.the4-el-product-tabs').each( function() {
            var _this = $( this ),
                res = null,
                wrapper = _this.find('.the4-tab-content');

            _this.find(' div.the4-tab-header__item').on( 'click', function( e ) {
                e.preventDefault();

                var $this     = $( this ),
                    options   = $this.data( 'shortcode' ),
                    cat_id    = options.cat_id,
                    skey      = $this.data( 'skey' ),
                    index     = $this.index();
                if( sp_nt_storage ) {res = sessionStorage.getItem('cat_tab'+ cat_id)}

                if ( $this.hasClass( 'elementor-active' ) ) return;

                    load_tab_data( $this, options, skey, wrapper, index, res, cat_id );
            });

            function load_tab_data( $this, options, skey, wrapper, index, res, cat_id) {

                _this.find( 'div.the4-tab-header__item.elementor-active' ).removeClass( 'elementor-active' );
                _this.closest('.the4-el-product-tabs').addClass('element-loading');

                $this.addClass( 'elementor-active' );
                wrapper.addClass( 'loading' );

                //Check if have temp data

                if ( res ) {
                    setTimeout( function() {
                        display_tab( cat_id, res, false );
                    }, 200);

                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: THE4_AjaxURL,
                    dataType: 'json',
                    data: {
                        action: 'kalles_load_tab_data',
                        options: options,
                        security_code: skey
                    },
                    success: function( response ) {

                        if ( response ) {

                            display_tab( cat_id, response, true );

                        }

                    },
                    error: function( xhr, status, error) {

                    },
                    complete: function() {

                    }
                });
            }

            var display_tab = function( id, response, bl) {

                wrapper.removeClass( 'loading' );
                _this.closest('.the4-el-product-tabs').removeClass('element-loading');
                wrapper.html( response );

                var products = wrapper.find('.the4-sc-products '),
                    atts = products.data('attrs');

                if ( atts.style == 'carousel' ) {
                    initCarousel();
                } else if ( atts.style == 'masonry' ){
                    The4Kalles.initMasonry();
                }

                if( sp_nt_storage && bl ) {
                    sessionStorage.setItem('cat_tab' + id, response)
                  }
            }
        });
    }

    //Swatch limit on Categories list

    var KallesRecalculateSwatches = function (bl) {

        var sw_limit_true = body.hasClass('prs_sw_limit_true');

        if (! sw_limit_true) return;


          if (bl) {
            var string_sl = '.post-22224 .swatch__list_js';
          } else {
            var string_sl = '.post-22224 .swatch__list_js:not(.swatch__list--calced)';
          }

          fastdom.measure(function () {
            $(string_sl).each(function( index ) {
              var swatchList = $(this),
                  ck_w = parseInt( swatchList.data('size') ) + 12,
                  colorSwatchesLength = parseInt(swatchList.attr('data-colorcount')),
                  maxFit = Math.floor(swatchList.outerWidth() / ck_w),
                  Numsapce = colorSwatchesLength - maxFit;

                  fastdom.mutate(function () {

                    swatchList.addClass('swatch__list--calced');
                    swatchList.removeClass('swatch__list--limit');

                    if ( Numsapce > 0 && Numsapce != colorSwatchesLength) {
                      Numsapce = Numsapce + 1;
                      swatchList.addClass('swatch__list--limit');

                      swatchList.attr('data-limit',maxFit).attr('style', '--text : "+'+Numsapce+'";--text2 : "-'+Numsapce+'"');

                     }

                  });

            });
          });
     };

     //Buy now button check variant

     var KallesBuynowBtnCheckVariant = function() {
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
     }

   var kalles_check_swatch = function() {
        $('.product form.cart .is-label.rounded').addClass('true-rounded');
        $('.product form.cart .is-label.rounded .swatch__list--item').each(function () {
            var w_label = $(this).find('.swatch__value').outerWidth();
            var h_label = $(this).find('.swatch__value').outerHeight();
            if( w_label !== h_label ){
            $(this).closest('.is-label.rounded').addClass('off-rounded');
            }

        });

    }
    var kalles_count_swatch = function() {
        $('.product-info .swatch__list:not(.count-over)').each(function () {
            var count = $(this).children('.swatch__list--item').length;
            if( count > 5 ){
                $(this).addClass('count-over');
                $(this).append('<span class="count-over-text">(+)</span>');
            }

        });
    }

     //Panda JS function
    var pandaFunction = function () {

        function time_count_down() {
            if ($('#countdown').length) {
                var countDownData = $('#countdown').attr('data-time'), countDownDate = new Date(countDownData).getTime();
                var x = setInterval(function () {
                    var now                      = new Date().getTime();
                    var distance                 = countDownDate - now;

                    // Time calculations for days, hours, minutes and seconds
                    var days                     = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours                    = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes                  = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds                  = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("countdown").innerHTML = days + "d : " + hours + "h : " + minutes + "m : " + seconds + "s";

                    // If the count down is finished, write some text
                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById("countdown").innerHTML = "0d:0h:0m:0s";
                    }
                }, 1000);
            }
        }

        time_count_down();


        $(document).on('click', '.the4-tab-head .tab-title-li', function (e) {
            var $this = $(this);
            var tab_id = $this.data('tab-id');
            var $thisTabs = $this.closest('.the4-tabs-element');

            if (!$this.is('.active')) {
                $thisTabs.find('.tab-title-li').removeClass('active');
                $thisTabs.find('.the4-banner-wrap').removeClass('active');
                $thisTabs.find('.tab-title-li[data-tab-id="' + tab_id + '"]').addClass('active');
                $thisTabs.find('.the4-banner-wrap[data-tab-id="' + tab_id + '"]').addClass('active');
            }

            e.preventDefault();
            return false;
        });
        function kalles_clone_append_category() {
            if ($('.product-category').length > 0) {
                $('.container_cat:not(.cat-ready)').each(function () {
                    var $this = $(this).find('.products');
                    $('<div class="list-cate row"></div>').insertBefore($this);
                    $(this).find('.product-category').detach().prependTo('.list-cate');
                    $(this).addClass('cat-ready');
                })
            }

        }
        kalles_clone_append_category();

        function kalles_el_tabs_element() {
            $(document).on('click', '.the4-tab-head .tab-title-li', function (e) {
                var $this = $(this);
                var tab_id = $this.data('tab-id');
                var $thisTabs = $this.closest('.the4-tabs-element');

                if (!$this.is('.active')) {
                    $thisTabs.find('.tab-title-li').removeClass('active');
                    $thisTabs.find('.the4-banner-wrap').removeClass('active');
                    $thisTabs.find('.tab-title-li[data-tab-id="' + tab_id + '"]').addClass('active');
                    $thisTabs.find('.the4-banner-wrap[data-tab-id="' + tab_id + '"]').addClass('active');
                }

                e.preventDefault();
                return false;
            });
        }
        kalles_el_tabs_element();

        //Footer mobile
        if($('.footer-mobile .widget-title').length){
            $(document).on('click', '.footer-mobile .widget-title', function (e) {
                $(this).closest('.widget ').find('.widget-title + div,.widget-title ~ form').toggle('300');
                $(this).toggleClass('widget-show');
                e.preventDefault();
                return false;
            });

        }
        if($('#show-demo').length) {
            $('#show-demo').magnificPopup({
                type           : 'inline',
                mainClass      : 'mfp-fade',
                removalDelay   : 500,
                disableOn      : true,
                preloader      : true,
                fixedContentPos: true,
                callbacks: {
                    open: function () {
                        $(window).resize()
                    },
                },
            });
        }
    }


    //init Swiper Carousel
    var initSwiperCarousel = function () {

        if ( $('.the4-swiper-container').lenght == 0 ) return;

        $('.the4-swiper-container:not(.slider-ready)').each(function () {
            var $this = $(this),
                pagination = $this.find('.swiper-pagination'),
                navNext = $this.find('.the4-swiper-button-next'),
                navPrev = $this.find('.the4-swiper-button-prev');

            var swiperOptions = {
                slidesPerView: 1, spaceBetween: 30, pagination: {
                    el: pagination, clickable: true,
                }, effect: 'slide'
            };

            var this_slide_settings = $this.data('carousel_options');

            var effect = this_slide_settings.hasOwnProperty('effect') ? this_slide_settings.effect : 'slide';
            swiperOptions.effect = effect;

            var slides_to_show          = this_slide_settings.hasOwnProperty('slides_to_show') ? parseInt(this_slide_settings.slides_to_show) : 1;
            var slides_to_show_tablet   = this_slide_settings.hasOwnProperty('slides_to_show_tablet') ? parseInt(this_slide_settings.slides_to_show_tablet) : 2;
            var slides_to_show_mobile   = this_slide_settings.hasOwnProperty('slides_to_show_mobile') ? parseInt(this_slide_settings.slides_to_show_mobile) : 1;
            var slides_to_scroll        = this_slide_settings.hasOwnProperty('slides_to_scroll') ? parseInt(this_slide_settings.slides_to_scroll) : 1;
            var slides_to_scroll_tablet = this_slide_settings.hasOwnProperty('slides_to_scroll_tablet') ? parseInt(this_slide_settings.slides_to_scroll_tablet) : 1;
            var slides_to_scroll_mobile = this_slide_settings.hasOwnProperty('slides_to_scroll_mobile') ? parseInt(this_slide_settings.slides_to_scroll_mobile) : 1;
            var space_between           = this_slide_settings.hasOwnProperty('space_between') ? parseInt(this_slide_settings.space_between) : 30;
            var space_between_tablet    = this_slide_settings.hasOwnProperty('space_between_tablet') ? parseInt(this_slide_settings.space_between_tablet) : 20;
            var space_between_mobile    = this_slide_settings.hasOwnProperty('space_between_mobile') ? parseInt(this_slide_settings.space_between_mobile) : 15;

            if (isNaN(slides_to_show)) {
                slides_to_show = 3;
            }

            if (isNaN(slides_to_show_tablet)) {
                slides_to_show_tablet = 2;
            }

            if (isNaN(slides_to_show_mobile)) {
                slides_to_show_mobile = 1;
            }

            if (isNaN(slides_to_scroll)) {
                slides_to_scroll = 1;
            }

            if (isNaN(slides_to_scroll_tablet)) {
                slides_to_scroll_tablet = 1;
            }

            if (isNaN(slides_to_scroll_mobile)) {
                slides_to_scroll_mobile = 1;
            }
            if (isNaN(space_between)) {
                space_between = 30;
            }

            if (isNaN(space_between_tablet)) {
                space_between_tablet = 20;
            }

            if (isNaN(space_between_mobile)) {
                space_between_mobile = 15;
            }
            if (slides_to_show_tablet > slides_to_show) {
                slides_to_show_tablet = slides_to_show;
            }
            var elementorBreakpoints = elementorFrontend.config.breakpoints;
            swiperOptions.spaceBetween = parseInt(this_slide_settings.space_between_mobile);

            swiperOptions.slidesPerView = slides_to_show;
            swiperOptions.breakpoints = {};
            swiperOptions.breakpoints[elementorBreakpoints.xs] = {
                slidesPerView: slides_to_show_mobile,
                slidesPerGroup: slides_to_scroll_mobile,
                spaceBetween: space_between_mobile
            };
            swiperOptions.breakpoints[elementorBreakpoints.md] = {
                slidesPerView: slides_to_show_tablet,
                slidesPerGroup: slides_to_scroll_tablet,
                spaceBetween: space_between_tablet
            };
            swiperOptions.breakpoints[elementorBreakpoints.lg] = {
                slidesPerView: slides_to_show, slidesPerGroup: slides_to_scroll, spaceBetween: space_between
            };
            swiperOptions.speed = parseInt(this_slide_settings.speed) || 300;

            // swiperOptions.direction = this_slide_settings.hasOwnProperty('direction') ? this_slide_settings.direction : 'ltr';
            if (this_slide_settings.autoplay == 'yes') {
                swiperOptions.autoplay = {
                    delay: parseInt(this_slide_settings.autoplay_speed),
                    disableOnInteraction: !!this_slide_settings.pause_on_hover
                };
            }

            var showArrows = 'arrows' === this_slide_settings.navigation || 'both' === this_slide_settings.navigation,
                showDots = 'dots' === this_slide_settings.navigation || 'both' === this_slide_settings.navigation;

            if (showArrows) {
                swiperOptions.navigation = {
                    prevEl: navPrev , nextEl: navNext
                };
            }

            if (showDots) {
                swiperOptions.pagination = {
                    el:  pagination , clickable: true, type: "bullets"
                };
            }

            if ( 'undefined' === typeof Swiper ) {

              setTimeout( function(){
                  const asyncSwiper = elementorFrontend.utils.swiper;
                  new asyncSwiper( $this, swiperOptions ).then( ( newSwiperInstance ) => {

                    var thisSwiper = newSwiperInstance;
                  } );
              }, 500 );


            } else {

              var thisSwiper = new Swiper($this, swiperOptions);
            }

            $this.addClass('slider-ready');

        });
    }

    //Footer sticky
    var kalles_footer_sticky = function() {
        if (!$('.footer-sticky').length) {
            return;
        }
        var dType = 'desktop';
        $(window).on('load resize', function () {
            var curDType = 'desktop';

            if (matchMedia('only screen and (max-width: 1024px)').matches) {
                curDType = 'mobile';
            }
            var height_footer = $('.footer-sticky').outerHeight();
            if (curDType !== dType) {
                dType = curDType;

                if (curDType === 'mobile') {
                    $('#the4-footer').removeClass('footer-fixed');
                    $('#the4-wrapper').css({'margin-bottom': '0'});
                }
            } else {
                $('#the4-wrapper').css({'margin-bottom': height_footer});
                $('#the4-footer').addClass('footer-fixed');
            }
        });

    };

    //Brand page fillter

    var The4KallesBrandsFilter = function() {
        if ($('.brands_page_holder').length == 0 ) return;

        var $grid = $('.brands_page_holder'),
            $buttonGroup = $('.nt_filteriso_js');
        $buttonGroup.on( 'click', '.brands_filter_control>button', function() {
         $buttonGroup.find('.filter-t4s-active').removeClass('filter-t4s-active');
          $( this ).addClass('filter-t4s-active');
          $grid.isotope({ filter: $( this ).attr('data-filter') });
        });
     }

    //Product section

    The4Kalles.The4KallesProductSection = function() {

        //btn Animation
        The4KallesATC_animation('.type-product .single_add_to_cart_button');
        //Live view
        The4KallesReal_time();
        //Flash sale
        The4KallesFlashSold();
        //Product delivery order
        The4KallesDeliveryOrder();
        //Product page stock left progressbar
        The4KallesProgressbar();

        //Set selected Main image + Gallery
        The4KallesSelectedVariantion();
        //Set Main image + Gallery when click variant
        The4KallesClickVariant();

        //Quick buy click check variant
        KallesBuynowBtnCheckVariant();

        //T4 Discount Qty
        t4DiscountPrice();
    }

    /**
     * DOMready event.
     */
    $( document ).ready( function() {
        The4KallesLazyload();
        hTransparent();
        initCarousel();
        The4Kalles.initMasonry();
        initSidebar();
        initMagnificPopup();
        initSwitchCurrency();
        initPushMenuSidebar();
        initPushMenuSidebarBuger();
        initQuickView();
        initQuickShop();
        initAddToCart();
        initMiniCart();
        The4Kalles.initAjaxLoad();
        initScrollReveal();
        The4Kalles.initCountdown();
        initOpenswatch();
        backToTop();
        initPreLoader();
        wcLiveSearch();
        wcQuantityAdjust();
        wcExtraContent();
        wcTopSidebarMenu();
        wcAccordion();
        wcPopupAddtocart();
        The4KallesBrandsFilter();
        customThirdParties();
        initAccount();
        initThe4WoocommereSearch();
        The4KallesCompareLocal();
        The4KallesloadingBar($('body'));
        The4KallesElementorLoadmore();
        initSwiperCarousel();
        kalles_footer_sticky();
        //Newsletter popup
        KallesNewsletterPopup();

        //Popup exist Product
        The4KallesPromoPrPopup();
        //Tools: Add note, coupon, Gift Wrap, Estimate shipping
        miniCartTools();
        //Dropdown Minicart when hover
        cartPosDropdown();
        //Age verify
        The4KallesAgeVerify();
        //Cookie Law
        The4KallesCookiesLawPP();

        //Sale Popup
        The4KallesSalesPopup();

        //Wishlist local
        The4KallesWishlistLocal();
        //Header 6
        The4KallesCatHeader6('.cl_h_search .product_list_widget');

        //Product swatches
        The4KallesProductSwatches();

        //Init Popup
        The4Kalles.initPopup();

        //Product function
        The4Kalles.The4KallesProductSection();

        The4Kalles.KallesCountdown();

        The4KallesCartCountdown();
        //Product tabs Elementor Widget
        The4Kalles.KallesElProductTabs();

        //Init MegaMenu
        initMegamenu();

        //Menu hover Intent
        KallesMenuhoverIntent();

        //Panda JS Function
        pandaFunction();
        //Init check swatch
        kalles_check_swatch();
        //Init count swatch
        kalles_count_swatch();

        //Init shipping bar animation
        if ( THE4_Data_Js[ 'is_shipping_bar' ] == '1' ) {
            The4Kalles.Confetti.init();
        }
        //Trigger event after add to cart
        afterAddToCartEvent();

        OpenMiniCartFragments();

        //Mobile function
        if ( window_w < 768 ) {
            initDropdownMenu();
        }


        //RTL
        if ( is_rtl ) {
            initRTLMenu();
        }
    });


    $(window).on('load', function () {
        initStickyMenu();
        wcStickySidebar();
    });

})( jQuery );