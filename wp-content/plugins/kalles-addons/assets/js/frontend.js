(function( $ ) {
	jQuery( document ).ready( function( $ ){

        if (  typeof t4DiscountPrice === 'undefined' ) return;
        
        var t4DiscountPriceVar = new T4DiscountPriceVariation();

        t4DiscountPriceVar.init();
	});

	

    var T4DiscountPriceVariation = function() {

        

        this.productType = t4DiscountPrice.product_type;

    	this.init = function() {

            if (this.productType === 'variable') {

                $(".single_variation_wrap").on("show_variation", this.loadVariationPrice.bind( this ));

                $(document).on('reset_data', function () {
                    $('[data-variation-price-rules-table]').html('');
                });
            }
    	}

    	this.loadVariationPrice = function( event, variation ) {

    		var ajaxUrl = document.location.origin + document.location.pathname + '?wc-ajax=get_t4_discount_price_variation';
    		$.post( 
    			ajaxUrl,
    			{
    				variation_id: variation['variation_id']
    			},
    			(function ( response ) {

    				$('.price-rules-table').remove();
                    $('[data-variation-price-rules-table]').html(response);

    			}).bind( this ) );	
    	}
    }

})( jQuery )