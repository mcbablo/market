<?php
namespace The4;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<script type="text/template" id="tmpl-the4-items-list">
	<#
		for ( key in data ) {
	#>
		<div
		 class="elementor-template-library-template the4-template-library-template elementor-template-library-template-block elementor-template-library-template-remote"
		 data-block-id="{{ data[key]['block_id'] }}"
		>
		 <div class="elementor-template-library-template-body">
		  <div
		   class="elementor-template-library-template-screenshot">
		   <img src="{{ data[key]['thumbnail'] }}" srcset="{{ data[key]['thumbnail'] }}" alt="{{ data[key]['title'] }}" />
			</div>

		  <div class="elementor-template-library-template-preview">
		   <i class="eicon-zoom-in-bold" aria-hidden="true"></i>
		  </div>
		 </div>
		 <div class="elementor-template-library-template-footer">
		  <div class="elementor-template-library-template-name">
		   {{ data[key]['title'] }}
		  </div>
		 </div>
		</div>
	<#
		}
	#>

</script>

<script type="text/template" id="tmpl-the4-elementor-empty">
	<div class="the4-elementor-empty">
		<div class="inner">
			<div class="content">
				<i class="eicon-search"></i>
				<h3><?php esc_html_e( 'Sorry No Blocks Found.', 'the4-elementor-pack' ); ?></h3>
			</div>
		</div>
	</div>

</script>