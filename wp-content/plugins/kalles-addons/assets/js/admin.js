(function( $ ) {
	jQuery( document ).ready( function( $ ){
		$( 'body' ).on('click', '.add_price_rule', function( e ) {
			event.preventDefault();
			
			var newRuleInputs = $( e.target ).parent().find('[data-price-rules-input-wrapper]').first().clone();

			$('<span data-price-rules-container></span>').insertBefore($(e.target))
                .append(newRuleInputs)
                .append('<span class="notice-dismiss remove-price-rule" data-remove-price-rule style="vertical-align: middle"></span>')
                .append('<br><br>');

            newRuleInputs.children('input').val('');
            recalculateIndexes($(e.target).closest('[data-price-rules-wrapper]'));``
		});
	});

	$('body').on('click', '.remove-price-rule', function (e) {
        e.preventDefault();

        var element = $(e.target.parentElement);
        var wrapper = element.parent('[data-price-rules-wrapper]');
        var containers = wrapper.find('[data-price-rules-container]');

        if ((containers.length) < 2) {
            containers.find('input').val('');
            return;
        }

        $('[data-price-rules-wrapper] .wc_input_price').trigger('change');

        element.remove();

        recalculateIndexes(wrapper);

    });

	function recalculateIndexes(container) {

        var fieldsName = [
            't4_price_percent_quantity',
            't4_price_percent_discount',
            't4_price_fixed_quantity',
            't4_price_fixed_price'
        ];

        for (var key in fieldsName) {
            if (fieldsName.hasOwnProperty(key)) {
                var name = fieldsName[key];

                $.each($(container.find('input[name^="' + name + '"]')), function (index, el) {
                    var currentName = $(el).attr('name');

                    var newName = currentName.replace(/\[\d*\]$/, '[' + index + ']');

                    $(el).attr('name', newName);
                });
            }
        }

    }

})( jQuery )