
(function ($, Elementor) {

	"use strict";

	const _body = $( 'body' ),
		  _document = $( document );

	var $app = {},
		helper = {
			hideBtn : ($app, $selector) => {
				$app.find($selector).css({
					'visibility': 'hidden',
					'opacty': '0'
				});
			},

			showBtn : ($app, $selector) => {
				$app.find($selector).css({
					'visibility': 'visible',
					'opacty': '1'
				});
			},

			hide: ($app, $selector) => {
				$app.find($selector).hide();
			},

			show: ($app, $selector) => {
				$app.find($selector).show();
			},

			setHtml: ( $app, $selector, $html) => {
				$app.find($selector).html($html);
			},

			inArrayString: (needle, haystack) => {
			    var length = haystack.length;
			    for(var i = 0; i < length; i++) {
			        if(haystack[i].toLowerCase().includes( needle.toLowerCase() ) ) return true;
			    }
			    return false;
			},

			inArray: (needle, haystack) => {
			    var length = haystack.length;

			    for(var i = 0; i < length; i++) {
			        if(haystack[i].toLowerCase().trim() == needle.toLowerCase().trim()  ) return true;
			    }
			    return false;
			}
		},
		the4Libary =  {

		 _createLibraryBtn : () => {

			if ( Elementor ) {
				var section_wrapper = $( '#tmpl-elementor-add-section' ),
					library_btn = '<div class="elementor-add-section-area-button the4-elementor-add-library-section"><i class="eicon-folder"></i></div>';

				if ( section_wrapper.length > 0 ) {
					var html = section_wrapper.text();

					html = html.replace( '<div class="elementor-add-section-drag-title', library_btn +  '<div class="elementor-add-section-drag-title' );

					section_wrapper.text(html);
				}
			}
		},

		_btnAction : () => {
			Elementor.on( 'preview:loaded', () => {
					var template = wp.template( 'the4-elementor-pack-template' ),
						header_template = $('#tmpl-the4-template-modal__header').html();

					if ( $( '#the4-elementor-pack-modal' ).length == 0 ) {

						_body.append( template() );

						$app = $( '#the4-elementor-pack-modal' );

						$app.find('.library-header').html( header_template );


						
					}

					
					$app.find('.the4-elementor-categories').on( 'select2:select', the4Libary._changeCatagory);
					//Open library
					$( Elementor.$previewContents ).on( 'click.onAddTemplateButton', '.the4-elementor-add-library-section', (e) => {
						the4Libary._openLibrary(e);
					});
					// Close library
					_body.on( 'click', '.the4-templates-modal__header__close', the4Libary._closeLibrary );
					//Back to library
					_body.on( 'click', '.the4-template-library-header-preview-back', the4Libary._backLibrary );
					//Single item view
					_body.on( 'click', '#the4-elementor-pack-modal .elementor-template-library-template-preview', (e) => {
						the4Libary._singleItemView(e.target);
					} );
					//Sync data
					_body.on( 'click', '#the4-template-library-header-sync', the4Libary._syncLibrary);
					//Insert blog
					_body.on( 'click', '#the4-elementor-pack-modal .the4-template-library-template-insert', (e) => {
						the4Libary._insertBlock(e.target);
					} );

					//Search 
					_document.on('keyup', '#the4-elementor-pack-modal #the4-block-library-filter-text', (e) => {
						the4Libary._searchBlock(e.target);
					} );

					//Triggle event
					_document.on( 'the4_library_open_before', the4Libary._beforeOpenLibrary );
				})
		},

		_openLibrary : (e) => {

			_document.trigger('the4_library_open_before');

			the4Libary._loadLayout();

			$app.fadeIn();

			helper.hideBtn($app, '.the4-template-library-header-preview-back');
			helper.hideBtn($app, '.the4-template-library-template-insert');

			_document.trigger('the4_library_open_after');
		},

		_syncLibrary : () => {
			helper.hide($app, '#the4-template-library-templates');
			helper.show($app, '#the4-loading');
			var icon = $('#the4-template-library-header-sync > i');
				icon.addClass('eicon-animation-spin');
			elementorCommon.ajax.addRequest('the4_elementor_sync_library', {
				success: ( data ) => {
					the4Libary._loadLayout( data['layouts']);
				},

				error: ( data ) => {
					console.log('Error');
				},

				complete: ( data ) => {
					helper.show($app, '#the4-template-library-templates');
					helper.hide($app, '#the4-loading');
					icon.removeClass('eicon-animation-spin');
				}
			});
		},

		_backLibrary : () => {

			helper.hideBtn($app, '.the4-template-library-header-preview-back');
			helper.hideBtn($app, '.the4-template-library-template-insert');
			helper.show($app, '#the4-template-library-templates');
			helper.hide($app, '#the4-template-single-templates');
			helper.show($app, '#elementor-template-library-header-tools');
		},

		_beforeOpenLibrary : () => {

			helper.hide( $app, '#the4-template-single-templates');
			helper.setHtml( $app, '#the4-template-single-templates', '');
			helper.show($app, '#the4-template-library-templates');
			helper.show($app, '#elementor-template-library-header-tools');
			helper.hideBtn($app, '.the4-template-library-header-preview-back');
			$app.find('.the4-elementor-categories').select2();
		},

		_loadLayout : (data = the4ElementorData['layouts']) => {
			var template_items = wp.template('the4-items-list'),
			 	items_list = template_items(data);


			helper.setHtml( $app, '#the4-template-library-templates-container', items_list);
			the4Libary._initMasonry();
		},

		_emptyLayout : () => {
			var page_empty_template = wp.template( 'the4-elementor-empty ');
				helper.setHtml( $app, '#the4-template-library-templates-container', page_empty_template);
		},

		_singleItemView : (e) => {
			
			the4Libary.block_id = $( e ).closest('.the4-template-library-template').data('block-id');
			helper.showBtn($app, '.the4-template-library-header-preview-back');
			helper.showBtn($app, '.the4-template-library-template-insert');
			helper.hide($app, '#the4-template-library-templates');
			helper.hide($app, '#elementor-template-library-header-tools');
			helper.show($app, '#the4-template-single-templates');

			var single_view_template = wp.template('the4-elementor-single-view'),
				btn_insert = wp.template('the4-elementor-insert-button'),
				single_view_template_obj = the4ElementorData['layouts'].filter( block => block.block_id == the4Libary.block_id ),
				btn_insert_obj = the4Libary.block_id;
				

			var single_view_html = single_view_template( single_view_template_obj ),
				btn_insert_html = btn_insert( btn_insert_obj );

			helper.setHtml( $app, '#the4-template-single-templates', single_view_html);
			helper.setHtml( $app, '#elementor-template-library-header-preview-insert-wrapper', btn_insert_html);

		},

		_changeCatagory : (e) => {
			var category = e.params.data.id, items = []; 

			if ( category ) {
				if ( category == 'all-blocks') {
					the4Libary._loadLayout();
				} else {
					items = the4ElementorData['layouts'].filter( blocks => helper.inArray( category, blocks.tags) );

					if ( items.length > 0) {
						the4Libary._loadLayout( items );
					} else {
						the4Libary._emptyLayout();
					}
				}
			}
		},

		_searchBlock : (e) => {
			var key = $( e ).val() || '',
				search_results = [];

			if ( key.length > 0 ) {
				search_results = the4Libary._getSearchBlocks(key);
				if ( search_results.length > 0 ) {
					the4Libary._loadLayout( search_results );
				} else {
					the4Libary._emptyLayout();
				}
			}
		},

		_getSearchBlocks : (key) => {
			var blocks_title = [],
				blocks_tag = [],
				blockLibrary = the4ElementorData['layouts'];
			if ( key.length ) {
				blocks_tag = blockLibrary.filter( blocks => helper.inArrayString( key, blocks.tags ) );
				blocks_title = blockLibrary.filter( blocks => helper.inArrayString( key, blocks.title ) );

				return blocks_tag.concat( blocks_title );
			}
			return false;
		},

		_insertBlock : (e) => {
			var data = {
					data: {
						block_id : the4Libary.block_id
					}
				};
			$('.the4-template-library-template-insert').addClass('loading');

			elementorCommon.ajax.addRequest('the4_elementor_import_template', {
				data: data,
				success: ( data ) => {
					$e.run("document/elements/import", {
						data: data,
						model: Elementor.elementsModel,
						option: {}
					});
				},

				error: ( data ) => {
					console.log('Error');
				},

				complete: ( data ) => {
					$('.the4-template-library-template-insert').removeClass('loading');
					the4Libary._closeLibrary();
				}
			});
		},

		_closeLibrary : (e) => {
			setTimeout( () => {
				$app.fadeOut();

			}, 100);

		},
		
		_initMasonry: () => {

			var _masonry = {},
				wrapper = document.querySelector('#the4-template-library-templates-container');

			imagesLoaded( wrapper, () => {

				_masonry = new Masonry( wrapper, {
					itemSelector: '.elementor-template-library-template-block'
				});
			});
		}


		,
		_init : () => {
			the4Libary._createLibraryBtn();
			the4Libary._btnAction();

		}
	};
	the4Libary._init();


})(jQuery , window.elementor )