<?php
namespace The4;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<script type="text/template" id="tmpl-the4-elementor-pack-template">
	<div class="dialog-widget dialog-lightbox-widget dialog-type-buttons dialog-type-lightbox elementor-templates-modal" id="the4-elementor-pack-modal">
		<div class="dialog-widget-content dialog-lightbox-widget-content">
			<div class="library-header">

			</div>
			<div class="dialog-message dialog-lightbox-message">
				<div class="dialog-content dialog-lightbox-content">
					<div id="the4-template-library-templates">
						<div id="the4-template-library-toolbar">
							<div class="the4-blocks-category-fillter-wrapper">
							 <select
							  id="elementor-template-library-filter"
							  class="
							   the4-elementor-categories
							   elementor-template-library-filter-select elementor-select2
							  "
							 >
							  <option value="all-blocks"><?php esc_html_e( 'All', 'the4-elementor-pack' ); ?></option>
							  <# for ( const [ key, value ] of Object.entries( the4ElementorData.categories ) ) { #>
							  <option value="{{ key }} ">{{ value }}</option>
							  <# } #>
							 </select>
							</div>

							<div id="elementor-template-library-filter-text-wrapper">
							 <label
							  for="elementor-template-library-filter-text"
							  class="elementor-screen-only"
							  >Search Block:</label
							 >
							 <input id="the4-block-library-filter-text" placeholder="Search" />
							 <i class="eicon-search"></i>
							</div>

						</div>
						<div id="the4-template-library-templates-container">

						</div>
					</div>
					<div id="the4-template-single-templates">

					</div>
					<div id="the4-loading">
						<div class="loader">
					      <span></span>
					      <span></span>
					      <span></span>
					      <span></span>
					      <span></span>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
