<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
$product_meta = cs_get_option('wc_product_meta-check');
?>
<div class="product_meta">
	<?php do_action( 'woocommerce_product_meta_start' ); ?>
	<?php if ( is_array( $product_meta ) ) : ?>
	<?php foreach($product_meta as $meta) : ?>
		<?php if($meta == 'sku') : ?>
			<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

				<span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'kalles' ); ?> <span class="sku"><?php echo esc_html( ( $sku = $product->get_sku() ) ? $sku :  'N/A' ); ?></span></span>

			<?php endif; ?>
		<?php endif; ?>
		<?php if($meta == 'category') : ?>
			<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in the4-posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'kalles' ) . ' ', '</span>' ); ?>
		<?php endif; ?>
		<?php if($meta == 'tags') : ?>
			<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'kalles' ) . ' ', '</span>' ); ?>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php endif; ?>
	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>

