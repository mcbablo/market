<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//Check enable
$is_swatches = cs_get_option( 'wc_product_swatches-enable' );
$swatches_size = cs_get_option( 'wc_product_single_swatches-width' );
$swatches_style = cs_get_option( 'wc_product_swatches-style' );

global $product, $wpdb;

$attribute_keys = array_keys( $attributes );
// Get gallery data
if ($is_swatches) {
	$galleries = The4_Woocommerce_Swatches::image_galleries( $product->get_id(), $available_variations, $attributes );
} else {
	$variations_json = wp_json_encode( $available_variations );
	$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
}
// transform attributes data for client
$data_attributes = [];
foreach ($attributes as $key => $value) {
	$data_attributes[$key] = array_values($value);
}
do_action( 'woocommerce_before_add_to_cart_form' );
?>
	<?php if ( $is_swatches ) : ?>
	<form class="variations_form cart" method="post" enctype='multipart/form-data'
		data-attributes="<?php echo htmlspecialchars( wp_json_encode( $data_attributes ) ) ?>"
		  data-product_id="<?php echo absint( $product->get_id() ); ?>"
		  data-galleries="<?php echo htmlspecialchars( wp_json_encode( $galleries ) ); ?>"
		  data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>"
		  <?php echo apply_filters('kalles-add-to-cart-attr', ''); ?>
		  >
	<?php else : ?>
		<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo esc_attr( absint( $product->get_id() ) ); ?>" data-product_variations="<?php echo esc_attr( $variations_attr ); // WPCS: XSS ok. ?>">
	<?php endif; ?>
		<?php do_action( 'woocommerce_before_variations_form' ); ?>

		<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
			<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'kalles' ); ?></p>
		<?php else : ?>
			<?php if ( $is_swatches ) : ?>

			<div class="variations is-swatches">
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<?php
					$attr = current(
						$wpdb->get_results(
							"SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
							"WHERE attribute_name = '" . substr( $attribute_name, 3 ) . "' LIMIT 0, 1;"
						)
					);
					$custom_attr_type = get_post_meta( $product->get_id(), '_display_type_' . sanitize_title($attribute_name), true );

					// Generate request variable name.
					$key = 'attribute_' . sanitize_title( $attribute_name );

					// Get selected attribute value.
					$selected = isset( $_REQUEST[ $key ] )
						? wc_clean( $_REQUEST[ $key ] )
						: $product->get_variation_default_attribute( $attribute_name );
					?>

				   <div class="swatch is-<?php echo esc_attr( isset( $attr->attribute_type ) ? $attr->attribute_type : $custom_attr_type ); ?> <?php echo esc_attr( $swatches_style ); ?>">
						<h4 class="swatch__title"
							data-name="<?php echo wc_attribute_label( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></h4>
						<?php if ( isset( $attr->attribute_type )
									&& ( $attr->attribute_type == 'color'
									|| $attr->attribute_type == 'label'
									|| $attr->attribute_type == 'radio' ) ) : ?>
							<ul class="swatch__list is-flex"
								data-attribute="<?php echo esc_attr( $attribute_name ); ?>">
								<?php
								// Get terms if this is a taxonomy - ordered. We need the names too.
								$terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );


								foreach ( $terms as $term ) {
									$meta_swatches = get_term_meta( $term->term_id, '_custom_product_attr_options', true );

									if ( $attr->attribute_type == 'radio' ) {
                                        $label   = isset( $meta_swatches['radio-label'] ) ? $meta_swatches['radio-label'] : '' ;
										$tooltip = '' ;

										//Get variantion ID
										$variantion_id = the4_woo_get_default_variant_id( $term, $available_variations );

										$data_variantion_id = $variantion_id ? 'data-variation_id="' . esc_attr ( $variantion_id ) . '"' : '';
										//Check Enable variant image


										if ( in_array( $term->slug, $options ) ) {

											echo '<li '. $data_variantion_id .' data-variation="' . esc_attr( $term->slug ) . '" data-image-id="" class="swatch__list--item is-relative' . ( $term->slug == $selected ? ' is-selected' : '' ) . '">';

											    echo '<span class="mr__5 pr dib radio_styled"></span>';
												echo '<span class="swatch__value">';
													if ( $label ) {
														echo esc_html( $label );
													} else {
														echo esc_html( $term->name );
													}
												echo '</span>';
											echo '</li>';
										}

									} else {

										if (  $attr->attribute_type == 'color' ) {
											$color   = isset( $meta_swatches['color-color'] ) ? $meta_swatches['color-color'] : '' ;
											$image   = isset( $meta_swatches['color-image']['thumbnail'] ) ? $meta_swatches['color-image']['thumbnail'] : '' ;
											$tooltip = isset( $meta_swatches['color-tooltip'] ) ? $meta_swatches['color-tooltip'] : '' ;

										} else if ( $attr->attribute_type == 'label' ) {
											$label   = isset( $meta_swatches['label-label'] ) ? $meta_swatches['label-label'] : '' ;
											$tooltip = isset( $meta_swatches['label-tooltip'] ) ? $meta_swatches['label-tooltip'] : '' ;
										}

										//Check Enable tooltip
										$enable_tooltip = cs_get_option( 'wc_product_swatches-tooltip' );

										//Get variantion ID
										$variantion_id = the4_woo_get_default_variant_id( $term, $available_variations );

										$data_variantion_id = $variantion_id ? 'data-variation_id="' . esc_attr( $variantion_id ) . '"' : '';
										//Check Enable variant image

										if ( cs_get_option( 'wc_product_swatches-att_img' ) ) {
											//Get Variant img
											$variant_img = The4_Woocommerce_Swatches::get_img_variant( $term, $available_variations );
											$image = $variant_img[0];
										}


										//Swaches image
										if ( $image ) {
												$style = 'style="background-image: url( ' . esc_url( $image ) . ' ); width: '. esc_attr( $swatches_size ). 'px; height: ' . esc_attr( $swatches_size ) . 'px;"';

										} else {
											$style = 'style="background: ' . esc_attr( $color ) . '; width: '. esc_attr( $swatches_size ). 'px; height: ' . esc_attr( $swatches_size ) . 'px;"';
										}


										if ( in_array( $term->slug, $options ) ) {

											echo '<li '. $data_variantion_id .' data-variation="' . esc_attr( $term->slug ) . '" data-image-id="" class="swatch__list--item is-relative' . ( $term->slug == $selected ? ' is-selected' : '' ) . '">';
											if ( $attr->attribute_type == 'color' ) {
												echo '<span class="swatch__value" ' . $style .'></span>';
											} elseif ( $attr->attribute_type == 'label' ) {
												echo '<span class="swatch__value">';
													if ( $label ) {
														echo esc_attr( $label );
													} else {
														echo esc_attr( $term->name );
													}
												echo '</span>';
											}
											if ( $enable_tooltip ) {
												if ( $tooltip ) {
													echo '<span class="swatch__tooltip is-absolute is-block">' . esc_attr( $tooltip ) . '</span>';
												} else {
													echo '<span class="swatch__tooltip is-absolute is-block">' . esc_attr( $term->name ) . '</span>';
												}
											}
											echo '</li>';
										}
									} // End if
								} // End foreach
								?>
							</ul>
						<?php elseif ( $custom_attr_type == 'color' || $custom_attr_type == 'label' ) : ?>
							<ul class="swatch__list is-flex" data-attribute="<?php echo esc_attr( strtolower( sanitize_title($attribute_name) ) ); ?>">
								<?php
									foreach ( $options as $attr_value ) {
										$attr_color = get_post_meta( $product->get_id(), 'custom_attr_color_' . sanitize_title( $attr_value ), true );
										$attr_img   = get_post_meta( $product->get_id(), 'custom_attr_img_' . sanitize_title( $attr_value ), true );
										$attr_label = get_post_meta( $product->get_id(), 'custom_attr_label_' . sanitize_title( $attr_value ), true );

										if ( $attr_img ) {
											$style = 'background-image: url( ' . esc_url( wp_get_attachment_url( $attr_img ) ) . ' );';
										} else {
											$style = 'background: ' . esc_attr( $attr_color ) . ';';
										}

										echo '<li data-variation="' . esc_attr( $attr_value ) . '" class="swatch__list--item is-relative' . ( $attr_value == $selected ? ' is-selected' : '' ) . '">';

											if ( $custom_attr_type == 'color' ) {
												echo '<span class="swatch__value" style="' . $style . '"></span>';
											} elseif ( $custom_attr_type == 'label' ) {
												echo '<span class="swatch__value">';
													if ( $attr_label ) {
														echo esc_attr( $attr_label );
													} else {
														echo sanitize_title( $attr_value );
													}
												echo '</span>';
											}
										echo '</li>';
									}
								?>
							</ul>
						<?php endif; ?>

						<div class="value">
							<?php
							$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );


							wc_dropdown_variation_attribute_options( array(
								'options'   => $options,
								'attribute' => sanitize_title($attribute_name),
								'product'   => $product,
								'selected'  => $selected
							) );
							echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'kalles' ) . '</a>' ) : '';
							?>
						</div>
					</div>
				<?php endforeach; ?>
			</div> <!-- .variations -->
			<?php else : ?> <!-- swatch disable -->
			<table class="variations" cellspacing="0">
				<tbody>
					<?php foreach ( $attributes as $attribute_name => $options ) : ?>
						<tr>
							<td class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></td>
							<td class="value">
								<?php
									wc_dropdown_variation_attribute_options(
										array(
											'options'   => $options,
											'attribute' => $attribute_name,
											'product'   => $product,
										)
									);
									echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'kalles' ) . '</a>' ) ) : '';
								?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		 <?php endif; ?> <!-- swatch check -->
			<div class="single_variation_wrap">
				<?php
				/**
				 * woocommerce_before_single_variation Hook.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook.
				 */
				do_action( 'woocommerce_after_single_variation' );
				?>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_variations_form' ); ?>
		<?php do_action( 't4_woocommerce_after_add_to_cart_button' ); ?>
	</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );