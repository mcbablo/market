(function($) {

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	/*** Open popup ***/
	$('.md-size-chart-btn').click(function(e) {
		e.preventDefault();
		var chart_btn_ID = $(this).attr('chart-data-id');
		$('.scfw-size-chart-modal[chart-data-id="'+ chart_btn_ID +'"]').show();
	});

	$('div#md-size-chart-modal .remodal-close').click(function(e) {
		e.preventDefault();
		$(this).parents('.scfw-size-chart-modal').hide();
	});

	$('div.md-size-chart-overlay').click(function(e) {
		e.preventDefault();
		$(this).parents('.scfw-size-chart-modal').hide();
	});

	$('.md-size-chart-modal').each(function (i) {
		var chart_btn_ID = $(this).attr('chart-data-id');
		$('.md-size-chart-modal[chart-data-id="' + chart_btn_ID + '"]').slice(1).remove();
	});

})(jQuery);
