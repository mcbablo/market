/*
* Backend function
* @since 1.0.0
* @package Kalles
*/

;(function ( $, window, document, undefined ) {
	"use strict";

	$.THE4 = $.THE4 || {};

	// ======================================================
	// Upload gallery
	// ------------------------------------------------------
	$.THE4.variable_gallery_upload = function() {
		$( '[id^="product-gallery-color-"], [id^="product-gallery-images-"], [id^="the4_product_360"]' ).each( function() {

			var image_gallery_ids = $( this ).find( 'input.product_variation_image_gallery' ),
				product_images = $( this ).find( '.product_variation_images_container ul.product_images' );

			$( this ).on( 'click', '.add_product_variation_images a', function( event ) {
				event.preventDefault();

				// Get media frame.
				var $el = $( this ),
					media_frame = $el.data( 'product_variation_gallery_frame' );

				if ( ! media_frame ) {
					// Create the media frame.
					media_frame = wp.media({
						// Set the title of the modal.
						title: $el.data( 'choose' ),
						button: {
							text: $el.data( 'update' )
						},
						states: [
							new wp.media.controller.Library({
								title: $el.data( 'choose' ),
								filterable: 'all',
								multiple: true
							})
						]
					});

					// When an image is selected, run a callback.
					media_frame.on( 'select', function() {
						var selection = media_frame.state().get( 'selection' ),
							attachment_ids = image_gallery_ids.val();

						selection.map( function( attachment ) {
							attachment = attachment.toJSON();

							if ( attachment.id ) {
								attachment_ids = attachment_ids != '' ? attachment_ids + ',' + attachment.id : attachment.id;

								var attachment_image = ( attachment.sizes && attachment.sizes.thumbnail )
									? attachment.sizes.thumbnail.url
									: attachment.url;

								product_images.append(
									'<li class="image" data-attachment_id="' + attachment.id + '">'
									+ '<img src="' + attachment_image + '" />'
									+ '<ul class="actions"><li>'
									+ '<a href="#" class="delete" title="' + $el.data( 'delete' ) + '">' + $el.data( 'text' ) + '</a>'
									+ '</li></ul>'
									+ '</li>'
								);
							}
						});

						image_gallery_ids.val( attachment_ids );
					});

					$el.data( 'product_variation_gallery_frame', media_frame );
				}

				// Finally, open the modal.
				media_frame.open();
			});

			// Image ordering.
			product_images.sortable({
				items: 'li.image',
				cursor: 'move',
				scrollSensitivity: 40,
				forcePlaceholderSize: true,
				forceHelperSize: false,
				helper: 'clone',
				opacity: 0.65,
				placeholder: 'wc-metabox-sortable-placeholder',
				start: function( event, ui ) {
					ui.item.css( 'background-color', '#f6f6f6' );
				},
				stop: function(event, ui) {
					ui.item.removeAttr( 'style' );
				},
				update: function() {
					var attachment_ids = [];

					product_images.find( 'li.image' ).css( 'cursor', 'default' ).each(function() {
						var attachment_id = $( this ).attr( 'data-attachment_id' );
						//attachment_ids = attachment_ids + attachment_id + ',';
						attachment_ids.push(attachment_id);
					});

					image_gallery_ids.val( attachment_ids.join(',') );
				}
			});

			// Remove images.
			$( this ).on( 'click', 'li.image a.delete', function() {
				$( this ).closest( 'li.image' ).remove();

				var attachment_ids = [];

				product_images.find( 'li.image' ).css( 'cursor', 'default' ).each(function() {
					var attachment_id = $( this ).attr( 'data-attachment_id' );
					attachment_ids.push(attachment_id);
				});

				image_gallery_ids.val( attachment_ids.join(',') );

				// Remove any lingering tooltips.
				$( '#tiptip_holder' ).removeAttr( 'style' );
				$( '#tiptip_arrow' ).removeAttr( 'style' );

				return false;
			});
		});
	};

	// ======================================================
	// Custom ajax load when upload image gallery
	// ------------------------------------------------------
	$( document ).ajaxSuccess( function( event, jqXHR, ajaxOptions, data ) {
		// Check if this is an Ajax request to load product variations?
		if ( ajaxOptions.data && ajaxOptions.data.indexOf( '&action=woocommerce_load_variations&' ) > 0 ) {
			// Send an Ajax request to check if product variations has Color Picker attribute?
			$.ajax({
				url: ajaxOptions.url,
				type: 'POST',
				data: ajaxOptions.data.replace( '&action=woocommerce_load_variations&', '&action=wr-detect-color-picker-attribute&' ),
				complete: function(response) {
					if ( response.responseJSON && response.responseJSON.success ) {
						// Detected Color Picker attribute used for product variations, create button to reload page.
						if ( ! $( '.wpa-reload-page' ).length ) {
							$( '.variations-pagenav' ).before( '<button type="button" class="button wpa-reload-page">Refresh</button>' );

							// Create a tool-tip to describe the button.
							$( '.wpa-reload-page' ).tipTip({
								content: wpa_THE4.refresh_tip
							});

							$( '.wpa-reload-page' ).click(function() {
								window.location.reload();
							});
						}
					}
				}
			});
		}
	});

	// ======================================================
	// Add variable attribute image
	// ------------------------------------------------------
	$.THE4.variable_attribute_image_upload = function() {
		$( 'body' ).on( 'click', '.kalles-swatches-btn-upload', function( e ) {
			e.preventDefault();

			var _this   = $( this ), _input  = _this.siblings( '.wpa_THE4_thumb_id' ), _image  = _this.children( 'img' ), _remove = _this.children( 'span' ), media_frame;

			// If the media frame already exists, reopen it.
			if ( media_frame ) {
				media_frame.open();
				return;
			}

			// Create the media frame.
			media_frame = wp.media.frames.downloadable_file = wp.media({
				title: _this.data( 'choose' ),
				button: {
					text: _this.data( 'update' )
				},
				states: [
					new wp.media.controller.Library({
						title: _this.data( 'choose' ),
						filterable: 'all',
						multiple: false
					})
				]
			});

			// When an image is selected, run a callback.
			media_frame.on( 'select', function() {
				var attachment = media_frame.state().get( 'selection' ).first().toJSON();
				_input.val( attachment.id );
				_image.attr( 'src', attachment.url );
				_remove.removeClass( 'hidden' );
			});

			// Finally, open the modal.
			media_frame.open();
			return false;
		});

		$( 'body' ).on( 'click', '.kalles-swatches-btn-remove', function( e ) {
			e.preventDefault();

			var _this  = $( this ),
				_input = _this.closest( '.wpa-swatch' ).find( '.kalles-swatches_thumb_id' ),
				_image = _this.closest( '.wpa-swatch' ).find( 'img' ),
				_noimg = _this.data( 'thumb' );

			_image.attr( 'src', _noimg );
			_input.val( '' );
			_this.addClass( 'hidden' );
			return false;
		});
	}

	// ======================================================
	// Active theme
	// ------------------------------------------------------
	$.THE4.active_theme = function() {

		var top_lever_menu = $('#toplevel_page_the4-dashboard > ul > li'), link_option;

		var ipt_codet4 = $("#ipt_codet4"),
           	res_codet4 = $('#res_codet4'),
           	purchase_codet4 = $('#purchase_codet4'),
           	shop_email = purchase_codet4.attr('data-email'),
           	val_codet4 = ipt_codet4.val();

       $("#btn_codet4").on('click', function (e) {
       	 	e.preventDefault();
        	e.stopPropagation();
            var _this = $(this),
                curent_vlCodet4 = ipt_codet4.val();

            if ( curent_vlCodet4 == val_codet4 ) {
              if (ipt_codet4.hasClass('t4Warning')) {
                ipt_codet4.removeClass('shaket4code').addClass('t4Warning2');
                setTimeout(function(){ ipt_codet4.addClass('shaket4code'); }, 100);
              } else {
                ipt_codet4.addClass('t4Warning shaket4code');
              }
            } else {
            	val_codet4 = curent_vlCodet4;
	            ipt_codet4.attr('class','');
	            _this.addClass('loading');
	            var domain = T4_ADMIN_JS.T4_ShopURL;
	            var mix = ['4','t','h','e','p','l','i','c','o','/','.',':','n','s'];
	            var mix_domain = mix[2]+mix[1]+mix[1]+mix[4]+mix[13]+mix[11]+mix[9]+mix[9]+mix[5]+mix[6]+mix[7]+mix[10]+mix[1]+mix[2]+mix[3]+mix[0]+mix[10]+mix[7]+mix[8]+mix[9]+mix[5]+mix[6]+mix[7]+mix[3]+mix[12]+mix[13]+mix[3]+mix[9]+mix[7]+mix[2]+mix[3]+mix[7]+'k';
	            var data = {
	                 "shopify_domain":domain,
	                 "email":shop_email,
	                 "theme":T4_ADMIN_JS.T4_ThemeItem,
	                 "purchase_code": curent_vlCodet4
	            };
	              
	              fetch(mix_domain, {
	                  "headers": {
	                    "accept": "*/*",
	                    "cache-control": "no-cache",
	                    "x-requested-with": "XMLHttpRequest"
	                  },
	                  "body": btoa (encodeURIComponent(JSON.stringify(data))) ,
	                  "method": "POST",
	                  "mode": "cors"
	              }).then((response)=>{ 
	                if(response.ok){ 
	                return response.json()
	                } throw ""
	              }).then((response)=>{ 
	                //console.log(response);
	                if ( response.status == 1) {
	                  res_codet4.html("ACTIVATION SUCCESSFULLY. Thanks for buying my theme!");

	                  active_theme( val_codet4 );

	                  _this.removeClass('loading');

	                } else {
	                   _this.removeClass('loading');
	                  if (response.message.length == 58) {
	                   res_codet4.html("That license key doesn't appear to be valid. Please check your purchase code again!<br> Please email <a class='cg' href='mailto:the4studio.net@gmail.com' target='_blank'><span>the4studio.net@gmail.com</span></a> if you have any question.").slideDown(250);
	                  } else {
	                   try {
	                      var mess = response.message.split('active domain `')[1].split('`. ')[0];
	                    }
	                    catch(err) {
	                      var mess = response.message;
	                    }
	                   //var mess = response.message.split('active domain `')[1].split('`. ')[0];
	                   res_codet4.html("That license key has been invalidated, due to being active domain "+mess+".<br> Please email <a class='cg' href='mailto:the4studio.net@gmail.com' target='_blank'><span>the4studio.net@gmail.com</span></a> if you have any question.").slideDown(250);
	                  }
	                }

	              }).catch((e)=>{ 
	                 _this.removeClass('loading');
	                console.error(e)
	              });
            }
       	});

		function active_theme( evanto_key ) {
			$.ajax({
                type : "post", 
                dataType : "json", 
                url : T4_ADMIN_JS.T4_AjaxURL,
                data : {
                    action: "the4_admin_register_key",
                    security_code: T4_ADMIN_JS.T4_ActiveNonce,
                    evanto_key : evanto_key
                },
                context: this,
                beforeSend: function(){
                    
                },
                success: function(response) {
                	location.reload();
                },
                error: function(error){

                    console.log( error );
                }
            });
		}
	}

	// ======================================================
	// Deactive theme
	// ------------------------------------------------------
	$.THE4.deactive_theme = function() {

		$(".t4-deactive").on('click', function (e) {
       	 	e.preventDefault();
        	e.stopPropagation();

        	if ( window.confirm('Are you want to deactive the theme? ') ) {
        		var _this = $(this),
                skey = _this.data( 'skey' ),
                evanto_key = _this.data( 'evanto_key' ),
                shop_email = _this.data( 'email' ),
                domain = T4_ADMIN_JS.T4_ShopURL
                ;

	            var mix = ['4','t','h','e','p','l','i','c','o','/','.',':','n','s'];
	            var mix_domain = mix[2]+mix[1]+mix[1]+mix[4]+mix[13]+mix[11]+mix[9]+mix[9]+mix[5]+mix[6]+mix[7]+mix[10]+mix[1]+mix[2]+mix[3]+mix[0]+mix[10]+mix[7]+mix[8]+mix[9]+mix[5]+mix[6]+mix[7]+mix[3]+mix[12]+mix[13]+mix[3]+mix[9]+mix[7]+mix[2]+mix[3]+mix[7]+'k';
	            var data = {
	                 "shopify_domain":domain,
	                 "email":shop_email,
	                 "theme": 'kalleswp',
	                 "purchase_code": evanto_key
	            };
	              
	              fetch(mix_domain, {
	                  "headers": {
	                    "accept": "*/*",
	                    "cache-control": "no-cache",
	                    "x-requested-with": "XMLHttpRequest"
	                  },
	                  "body": btoa (encodeURIComponent(JSON.stringify(data))) ,
	                  "method": "DELETE",
	                  "mode": "cors"
	              }).then((response)=>{ 
	                if(response.ok){ 
	                return response.json()
	                } throw ""
	              }).then((response)=>{ 

	                if ( response.status == 0 || response.status == 3 ) {
	                  $('.text-active-info').html( response.message );

	                  deactive_theme( skey );

	                  _this.removeClass('loading');
	             
	                } else {
	                   _this.removeClass('loading');
	                  
	                  $('.text-active-info').html( response.message );

	                }

	              }).catch((e)=>{ 
	                 _this.removeClass('loading');
	                console.error(e)
	              });
        	}
            
       	});

		function deactive_theme( skey ) {
			$.ajax({
                type : "post", 
                dataType : "json", 
                url : T4_ADMIN_JS.T4_AjaxURL,
                data : {
                    action: "the4_admin_deactive_theme",
                    security_code: skey
                },
                context: this,

                beforeSend: function(){
                    
                },
                success: function(response) {
                	location.reload();
                },
                error: function(error){

                    console.log( error );
                }
            });
		}
	}

	// ======================================================
	// Accodion Option
	// ------------------------------------------------------
	$.THE4.accodion_option = function() {
		var list = $('.csf-tab-item');

		$('body').on('click', '.csf-tab-item > a', function(event) {
			//event.preventDefault();
			var _this = $(this),
				_next = _this.next('ul'),
				_parent = _this.closest('.csf-tab-item');

			if ( ! _parent.hasClass('csf-tab-expanded') ) {
				_next.slideDown();
				var _li = $('.csf-nav-options').find('.csf-tab-expanded');
				_li.removeClass('csf-tab-expanded');
				_li.find('ul').slideUp();
				_parent.addClass('csf-tab-expanded');
			} else {
				_next.slideUp();
				_parent.removeClass('csf-tab-expanded');
			}
			
		});
	}

	// ======================================================
	// Init Slick slider
	// ------------------------------------------------------
	$.THE4.init_slick_slider = function() {
		var el = $( ".js_packery" );

		el.each( function( i, val ) {
			var option = $( this ).attr("data-packery") || '{}';
            $( this ).packery(JSON.parse(option));
		});

	}

	// ======================================================
	// White label
	// ------------------------------------------------------
	$.THE4.white_label = function() {

		setTimeout(function() {
			$('.theme').on('click', function() {
				theme_overlay_class();
			});
			theme_overlay_class();

			function theme_overlay_class() {
				var theme_name = $('.theme-overlay');
				console.log( theme_name.text() );

				if ( theme_name.text().includes('Kalles')  || theme_name.text().includes('kalles')) {
					$('.theme-overlay').addClass('kalles');
				} else {
					$('.theme-overlay').removeClass('kalles');
				}
			}
		}, 300);

	}

	$( document ).ready( function() {
		$.THE4.variable_gallery_upload();
		$.THE4.variable_attribute_image_upload();
		$.THE4.active_theme();
		$.THE4.deactive_theme();
		$.THE4.accodion_option();
		$.THE4.white_label();

	} );
	
})( jQuery, window, document );