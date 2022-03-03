<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

// Layout
$layout = cs_get_option( 'wc-extra-layout' ) ? cs_get_option( 'wc-extra-layout' ) : 'tab';

if ( ! empty( $tabs ) ) : ?>
	<?php if ( $layout == 'tab' && ! wp_is_mobile() && cs_get_option('wc-single-style') != '3') : ?>

		<div class="woocommerce-tabs wc-tabs-wrapper pt__50">
			<ul class="tabs wc-tabs flex center-xs fs__16" role="tablist">
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
						<a class="db br__40 cg" href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>"  role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
					<?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>
				</div>
			<?php endforeach; ?>
		</div>

	<?php else : ?>

		<div class="woocommerce-tabs wc-accordions">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<div class="<?php echo esc_attr( $key ); ?>_tab wc-accordion">
					<div class="heading bgbl">
						<a class="tab-heading db pr cd chp fwm" href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
					</div>
					<div class="panel entry-content wc-accordion-content" id="tab-<?php echo esc_attr( $key ); ?>">
						<?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>
<?php endif; ?>
