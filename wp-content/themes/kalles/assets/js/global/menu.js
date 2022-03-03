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

     kallesTheme.initPushMenuSidebarBuger = function() {
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

    // Init right to left menu
    kallesTheme.initRTLMenu = function() {
        var menu = $( '.sub-menu li' ), subMenu = menu.find( ' > .sub-menu');
        menu.on( 'mouseenter', function () {
            if ( subMenu.length ) {
                if ( subMenu.outerWidth() > ( $( window ).outerWidth() - subMenu.offset().left ) ) {
                    subMenu.addClass( 'rtl-menu' );
                }
            }
        });
    }

})( jQuery );
