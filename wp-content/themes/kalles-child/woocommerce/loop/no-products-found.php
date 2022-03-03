<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="result_clear mt__30 mb__20 flex al_center">
	<?php the_widget('WC_Widget_Layered_Nav_Filters', array( 'title' => ''), array()); ?>
	<div class="kalles-filter-btn">
		<?php do_action('kalles_filter_btn'); ?>
	</div>
</div>
<div class="nt_svg_loader dn"></div>
<p class="woocommerce-info"><?php esc_html_e( 'No products were found matching your selection.', 'kalles' ); ?></p>

