class KallesMapWidgetHandle extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.kalles-map'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );
		return {
			$container: this.$element.find( selectors.container )
		};
	}

	kallesMapBox() {
			var _this        = this,
				map_data     = [],
				el           = _this.elements.$container,
				dataMap      = el.data('locations'),
				localtions   = dataMap.localtions,
				mapToken     = dataMap.token,
				mapboxInit   = mapboxSdk( {accessToken: mapToken} ),
				map_wrarpper = el.find('.kalles-map__content').attr( 'id' );
			console.log( dataMap );

			mapboxgl.accessToken = mapToken;

			jQuery.each( localtions, function(index, val) {
				console.log( val );
				mapboxInit.geocoding.forwardGeocode( {
					query       : val,
					autocomplete: false,
					limit       : 1
				} )
				.send()
				.then( function( response){
					if ( response && response.body && response.body.features && response.body.features.length ) {
						var feature = response.body.features[0],
							map_item = el.find('.kalles-map__list .kalles-map__list--item');
						
						map_item.eq( index ).attr( 'data-latitude', feature.center[0] );
						map_item.eq( index ).attr( 'data-longitude', feature.center[1] );

						var item = {
							"type"    : "Feature",
							'properties': {
								'description': map_item.eq(index).html(),
								'icon': 'theatre'
							},
							"geometry": {
								"type"       : "Point",
								"coordinates": [feature.center[0],feature.center[1]]
							}
						};

						if( index == 0 ) {
							var map_default = [feature.center[0],feature.center[1]],
								name_default = val;
							_this.load_map(map_wrarpper,dataMap,map_item, mapToken, map_data, map_default, name_default);
						}

						map_data.push(item);

						index++;

					}
				});
			});

		return map_data;
	}

	load_map(map_wrarpper,dataMap, map_item, accessToken, map_data, map_default, name_default){
		
			var map = new mapboxgl.Map( {
				container: map_wrarpper,
				style    : 'mapbox://styles/mapbox/'+ dataMap.style ,
				center   : map_default,
				zoom     : dataMap.zom
			} );

			var geocoder = new MapboxGeocoder( {
				accessToken: mapboxgl.accessToken
			} );

			map.addControl( geocoder );

			map.on( 'load', function () {

				createPopUp( map_default, name_default );
				
			} );

			map_item.on('click', function () {
				var  latitude = jQuery(this).data('latitude'),
					 longitude = jQuery(this).data('longitude');

				map.flyTo({
					center: [latitude,longitude ],
					zoom: dataMap.zom,
					essential: true,
					speed: 3,
					curve: 1,
				});

			});

			function createPopUp(currentFeature, name) {
		        const popUps = document.getElementsByClassName('mapboxgl-popup');
		        if (popUps[0]) popUps[0].remove();
		        const popup = new mapboxgl.Popup({ closeOnClick: false })
		          .setLngLat(currentFeature)
		          .setHTML(
		            `<h3>${name}</h3>`
		          )
		          .addTo(map);
		     }
	}

	onInit() {

		super.onInit();
		this.kallesMapBox();
	}
}

jQuery( window ).on( 'elementor/frontend/init', () => {
	elementorFrontend.hooks.addAction( 'frontend/element_ready/kalles-map.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( KallesMapWidgetHandle, { $element } );
	} );
});