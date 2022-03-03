<?php
/**
 * Product swatches for woocommerce.
 *
 * @since   1.0.0
 * @package Kalles
 */


defined( 'ABSPATH' ) || exit('No direct script access allowed');

class The4_Woocommerce_Swatches {

    /**
     * The single instance of the class.
     *
     * @since 1.0.0
     */
    protected static $_instance = null;

    /**
     * Variable to hold supported custom attribute types.
     *
     * @var  array
     */
    protected static $types;

    protected $_prefix = '_custom_product_attr_options';
    /**
     * The4_Woocommerce_Swatches instance.
     *
     * @since 1.0.0
     */
    public static function instance()
    {
        self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * The4_Woocommerce_Swatches construct.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        self::$types = array(
                'color' => esc_html__( 'Color', 'kalles' ),
                'label' => esc_html__( 'Label'  , 'kalles' ),
                'radio' => esc_html__( 'Radio'  , 'kalles' ),
            );

        //Admin
        if ( is_admin() ) {
            // Register filter to add custom types for WooCommerce product attributes.
            add_filter( 'product_attributes_type_selector', array( __CLASS__, 'add_custom_type' ) );

            // Register action to print values for custom attribute types in add/edit product screen.
            add_action( 'woocommerce_product_option_terms', array( __CLASS__, 'print_values' ), 10, 2 );


            // Add custom Term on taxonomy setting
            $this->add_custom_attributes_value();
            
            add_action( 'add_meta_boxes', array( __CLASS__, 'add_gallery_product_metabox'  ) );
            add_action( 'save_post'     , array( __CLASS__, 'save_gallery_product_metabox' ) );

            //Show swatch on Product list
            $show       = cs_get_option( 'wc_product_swatches-list' );
            $position   = cs_get_option( 'wc_product_swatches-list_position' );

            if ( $show  ) {
                if ( $position == 'before' ) {
                    add_action( 'woocommerce_shop_loop_item_title', array( __CLASS__, 'add_swatch_on_product_list' ) );
                } else {
                    add_action( 'woocommerce_after_shop_loop_item_title', array( __CLASS__, 'add_swatch_on_product_list' ) );
                }
            }

        } else {
            //FrontEnd

            //Show swatch on Product list
            $show       = cs_get_option( 'wc_product_swatches-list' );
            $position   = cs_get_option( 'wc_product_swatches-list_position' );

            if ( $show  ) {
                if ( $position == 'before' ) {
                    add_action( 'woocommerce_shop_loop_item_title', array( __CLASS__, 'add_swatch_on_product_list' ) );
                } else {
                    add_action( 'woocommerce_after_shop_loop_item_title', array( __CLASS__, 'add_swatch_on_product_list' ) );
                }
            }
        }

    }



    /********************************
     *
     * FrontEnd function
     *
     * ******************************/


    /**
     * Get variant default Image
     *
     * @return  array
     */
    public static function get_img_variant( $term, $available_variations )
    {
        $img = '';
        foreach ($available_variations as $variation) {
           foreach ($variation['attributes'] as $key => $value) {
           // echo   . '<br>';
               if ( strpos($key, $term->taxonomy) && strtolower($term->name) == $value ) {
                $img = $variation['image_id'];
               }
           }
        }

        return wp_get_attachment_image_src( $img, 'shop_thumbnail' );
    }

    /**
     * Get image gallery
     *
     * @return array
     */
    public static function image_galleries( $product_id, $available_variations, $attributes = array()) {
        // List of meta key which we want to search
        $search_meta_keys = array();
        $variation_img = array();

        if( is_array( $available_variations ) ) {
            foreach ( $available_variations as $variation ) {
                foreach ( $variation['attributes'] as $attribute_name => $attribute_value ) {
                    $attribute_name     = str_replace( 'attribute_pa_', '', $attribute_name );
                    $search_meta_keys[] = '_product_image_gallery_pa_' . $attribute_name . '-' . $attribute_value;
                    $variation_img['_product_image_gallery_pa_' . $attribute_name . '-' . $attribute_value] = $variation['image_id'];
                }
            }
        }

        // check for custom attribute when use custom attribute
        foreach ( $attributes as $key => $attribute ) {
            foreach ($attribute as $value) {
                $search_meta_keys[] = '_product_image_gallery_' . strtolower(sanitize_title($key)) . '-' . strtolower(sanitize_title($value));
            }
        }

        // Get all post meta then search galleries
        $post_metas = get_post_meta( $product_id );
        $galleries  = array();

        foreach ( $post_metas as $meta_key => $meta_value ) {
            if ( in_array( $meta_key, $search_meta_keys ) ) {
                if ( ! empty( $variation_img[$meta_key] ) ) {
                     $galleries[ $meta_key ] = $variation_img[$meta_key] . ',';
                     $galleries[ $meta_key ] .= $meta_value[0];
                } else {
                    $galleries[ $meta_key ] = $meta_value[0];
                }


            }
        }

        // Get images attributes
        $images = array();
        foreach ( $galleries as $meta_key => $gallery ) {
            $attachment_ids = array_filter( explode( ',', $gallery ) );
            if($images){
				foreach ( $attachment_ids as $key => $attachment_id ) {
					$full_size_image             = wp_get_attachment_image_src( $attachment_id, 'full' );
					$single                      = wp_get_attachment_image_src( $attachment_id, 'shop_single' );
					$thumbnail                   = wp_get_attachment_image_src( $attachment_id, 'woocommerce_thumbnail' );
					$catalog                     = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' );
					$images[ $meta_key ][ $key ] = array(
						'single'                  => $single[0],
						'single_w'                => $single[1],
						'single_h'                => $single[2],
						'thumbnail'               => $thumbnail[0],
						'catalog'                 => $catalog[0],
						'data-src'                => $full_size_image[0],
						'data-large_image'        => $full_size_image[0],
						'data-large_image_width'  => $full_size_image[1],
						'data-large_image_height' => $full_size_image[2],
					);
				}
			}
        }

        // Get default gallery
        $product        = new WC_product( $product_id );
        $attachment_ids = $product->get_gallery_image_ids();
        if ( has_post_thumbnail( $product_id ) ) {
            $attachment_ids = $result = array_merge( array( get_post_thumbnail_id( $product_id ) ), $attachment_ids );
        }


        $usedImages = array();

        foreach ( $attachment_ids as $key => $attachment_id ) {
            $full_size_image             = wp_get_attachment_image_src( $attachment_id, 'full' );
            $single                      = wp_get_attachment_image_src( $attachment_id, 'shop_single' );
            $thumbnail                   = wp_get_attachment_image_src( $attachment_id, 'woocommerce_thumbnail' );
            $catalog                     = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' );

            if (!in_array($single[0], $usedImages)) {
                $usedImages[] = $single[0];
                $images['default_gallery'][ $key ] = array(
                    'single'                  => $single[0],
                    'single_w'                => $single[1],
                    'single_h'                => $single[2],
                    'thumbnail'               => $thumbnail[0],
                    'catalog'                 => $catalog[0],
                    'data-src'                => $full_size_image[0],
                    'data-large_image'        => $full_size_image[0],
                    'data-large_image_width'  => $full_size_image[1],
                    'data-large_image_height' => $full_size_image[2],
                );
            }
        }

        return $images;
    }

    /**
     * Show color swatch on product list.
     *
     * @return  string
     */
    public static function add_swatch_on_product_list() {
        global $wpdb, $product, $jassc;

        $attributes = $product->get_attributes();

        $output = $tmp_arr = $style = $flip_thumb_attr = '';

        $swatches_size = cs_get_option( 'wc_product_swatches-width' );
        $swatches_style = cs_get_option( 'wc_product_swatches-style' );

        if ( $product->is_type( 'variable' ) ) {
            $variation_attributes = $product->get_variation_attributes();
            $variations = $product->get_available_variations();
            $used_colors = array();

            foreach ( $attributes as $attribute_name => $options ) {
                $attribute_name = sanitize_title($attribute_name);
                $attr = current(
                    $wpdb->get_results(
                        "SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
                        "WHERE attribute_name = '" . substr( $attribute_name, 3 ) . "' LIMIT 0, 1;"
                    )
                );

                // Get selected attribute value.
                $default_attribute_value = $product->get_variation_default_attribute( $attribute_name );

                $custom_attr_type = get_post_meta( $product->get_id(), '_display_type_' . $attribute_name, true );

                if ( ! empty( $attr ) && $attr->attribute_type == 'color' && $options['options'] ) {

                    $terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );

                    $output .= '<div class="swatch__list swatch__list_js swatch '. $swatches_style .'" data-attribute="' . esc_attr( $attribute_name) . '" data-colorCount="8" data-size="' . $swatches_size . '">';
                    // Get terms if this is a taxonomy - ordered. We need the names too.
                    //
                    foreach ( $terms as $term ) {

                        $meta_swatches = get_term_meta( $term->term_id, '_custom_product_attr_options', true );

                        if (  $attr->attribute_type == 'color' ) {

                            $color   = isset( $meta_swatches['color-color'] ) ? $meta_swatches['color-color'] : '';
                            $image   = isset( $meta_swatches['color-image']['thumbnail'] ) ? $meta_swatches['color-image']['thumbnail'] : '' ;
                            $tooltip = isset( $meta_swatches['color-tooltip'] ) ?  $meta_swatches['color-tooltip'] : '' ;

                        }

                        if ( cs_get_option( 'wc_product_swatches-att_img' ) ) {
                            //Get Variant img
                            $variant_img = self::get_img_variant( $term, $variations );
                            if($variant_img){
								$image = $variant_img[0];
							}
                        }
                        //Swaches image
                        if ( $image ) {
                            
                            $style = 'style="background-image: url( ' . esc_url( $image ) . ' ); width: '. $swatches_size. 'px; height: ' .$swatches_size . 'px;"';
    
                        } else {
                            if ( ! empty( $color ) ) {
                                $style = 'style="background: ' . esc_attr( $color ) . '; width: '. $swatches_size. 'px; height: ' .$swatches_size . 'px"';
                            } else {
                                $style = 'style="width: '. $swatches_size. 'px; height: ' .$swatches_size . 'px"';
                            }
                            
                        }

                        foreach ( $variations as $key => $variation ) {
                            if ( isset( $variation['attributes']['attribute_' . $attribute_name] ) ) {
                                if ( $term->slug == $variation['attributes']['attribute_' . $attribute_name] ) {
                                    $variation_color = $variation['attributes']['attribute_' . $attribute_name];

                                    if ( ! in_array( $variation_color, $used_colors ) ) {
                                        $used_colors[]  = $variation_color;
                                        $meta_key       = "_product_image_gallery_{$term->taxonomy}-{$variation_color}";
                                        $image_gallery  = get_post_meta( $product->get_id(), $meta_key, true );
                                        $attachment_ids = array_filter( explode( ',', $image_gallery ) );

                                        $galleries = self::image_galleries( $product->get_id(), $variations, $attributes );

                                        if ( ! empty( $variation['image_id'] ) ) {
                                            $thumbnail_id = $variation['image_id'];
                                        }
                                        elseif ( ! empty($attachment_ids ) ) {
                                            $thumbnail_id = ( int ) $attachment_ids[0];
                                        }  else {
                                            $thumbnail_id = false;
                                        }

                                        if ( $thumbnail_id ) {
                                            $tmp_arr = wp_get_attachment_image_src( $thumbnail_id, 'woocommerce_thumbnail' );
                                        }

                                        $flip_thumb = ( $jassc && isset( $jassc['flip'] ) ) ? $jassc['flip'] : ( function_exists( 'cs_get_option' ) && cs_get_option( 'wc-flip-thumb' ) );

                                        
                                        if ( $flip_thumb && $galleries ) {
                                            if ( isset( $galleries[$meta_key][1]['catalog'] ) ) {
                                                $flip_thumb_attr = 'data-thumb-flip="' . esc_url( $galleries[$meta_key][1]['catalog'] ) . '"';
                                            } else {
                                                $flip_thumb_attr = '';
                                            }
                                        }

                                        if (is_array($tmp_arr)) {

                                            $selected_span = $term->slug == $default_attribute_value ? ' selected-span' : '';

                                            $output .= '<span data-thumb="' . esc_url( $tmp_arr[0] ) . '"
                                                        data-variation="' . esc_attr( $term->slug ) . '" ' . $flip_thumb_attr . ' class="swatch__list--item is-relative '.$selected_span.'">';
                                            $output .= '<span class="swatch__value" ' . $style .'></span>';
                                            $output .= '</span>';
                                        }
                                    }
                                }
                            }
                        }

                    }
                    $output .= '</div>';
                }

                if (  $custom_attr_type == 'color' || $custom_attr_type == 'label' )
                {
                    $output .= '<div class="swatch__list is-flex '. $swatches_style .'" data-attribute="' . esc_attr( $attribute_name) . '">';
                    $options = $options->get_options();

                    foreach ( $options as $key => $option ) {

                        $attr_color = get_post_meta( $product->get_id(), 'custom_attr_color_' . sanitize_title( $option ), true );
                        $attr_img   = get_post_meta( $product->get_id(), 'custom_attr_img_' . sanitize_title( $option ), true );

                        $attr_label = get_post_meta( $product->get_id(), 'custom_attr_label_' . sanitize_title( $option ), true );

                        $meta_key       = "_product_image_gallery_{$attribute_name}-".sanitize_title($option);
                        $image_gallery  = get_post_meta( $product->get_id(), $meta_key, true );
                        $attachment_ids = array_filter( explode( ',', $image_gallery ) );
                        $image_varition = false;
                        $galleries = The4_Woocommerce_Swatches::image_galleries( $product->get_id(), $variations, $variation_attributes );

                        foreach ($variations as $variation) {
                            if (isset($variation['attributes']['attribute_' . $attribute_name]) &&$variation['attributes']['attribute_' . $attribute_name] == $option) {
                                $image_varition = $variation['image_id'] ? $variation['image_id'] : false;
                            }
                        }

                        if ( $attr_img ) {
                            $thumbnail_id = $attr_img;
                        } elseif ( ! empty($attachment_ids ) ) {
                            $thumbnail_id = ( int ) $attachment_ids[0];
                        } elseif ($image_varition) {
                            $thumbnail_id = ( int ) $image_varition;
                        } else {
                            $thumbnail_id = false;
                        }

                        if ( $thumbnail_id ) {
                            $tmp_arr = wp_get_attachment_image_src( $thumbnail_id, 'shop_catalog' );
                        }

                        if ($attr_img) {
                            $style = 'background-image: url( ' . esc_url( wp_get_attachment_image_src( $attr_img, 'thumbnail' )[0] ) . ' );';
                        } else {
                            $style = 'background: ' . $attr_color . ';';
                        }


                        $flip_thumb = ( $jassc && isset( $jassc['flip'] ) ) ? $jassc['flip'] : ( function_exists( 'cs_get_option' ) && cs_get_option( 'wc-flip-thumb' ) );

                        if ( $flip_thumb ) {
                            if ( isset( $galleries[$meta_key][0]['catalog'] ) ) {
                                $flip_thumb_attr = 'data-thumb-flip="' . esc_url( $galleries[$meta_key][0]['catalog'] ) . '"';
                            } else {
                                $flip_thumb_attr = '';
                            }
                        }

                        if (is_array($tmp_arr)) {
                            $output .= '<span data-thumb="' . esc_url( $tmp_arr[0] ) . '" data-variation="' . esc_attr( $option ) . '" ' . $flip_thumb_attr . '
                                        class="swatch__list--item is-relative">';
                            $output .= '<span class="swatch__value" style="' . $style . '"></span>';
                            $output .= '</span>';
                        }
                    }

                    $output .= '</div>';
                }
            }
        }

        echo apply_filters( 'add_swatch_on_product_list', $output );
    }
    /********************************
     *
     * BackEnd function
     *
     * ******************************/



    /**
     * // Register filter to add custom types for WooCommerce product attributes.
     *
     * @since 1.0.0
     */
    public static function add_custom_type( $types )
    {
        return array_merge( $types, self::$types );
    }

    /**
     *  Add/edit attributes values
     *
     * @since 1.0.0
     */
    public function add_custom_attributes_value( )
    {
        global $pagenow;

        if (
            in_array( $pagenow, array( 'edit-tags.php', 'term.php' ) )
            ||
            ( 'admin-ajax.php' == $pagenow && 'add-tag' == $_REQUEST['action'] )
        ) {

            $taxonomy = isset( $_REQUEST['taxonomy' ] ) ? sanitize_text_field( $_REQUEST['taxonomy' ] ) : null;

            if ( $taxonomy && 'pa_' == substr( $taxonomy, 0, 3 ) ) {
                // Get custom attribute type.
                global $wpdb;

                $attribute = current(
                    $wpdb->get_results(
                        "SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
                        "WHERE attribute_name = '" . esc_sql( substr( $taxonomy, 3 ) ) . "' LIMIT 0, 1;"
                    )
                );
                if ( array_key_exists( $attribute->attribute_type, self::$types ) ) {
                    $this->create_taxonomy_option( $taxonomy );
                }
            }
        }
    }

    /**
     *  Add/edit attribute values
     *
     * @since 1.0.0
     */
    public function create_taxonomy_option( $taxonomy )
    {

        if ( class_exists('CSF') ) {
            CSF::createTaxonomyOptions( $this->_prefix, array(
              'taxonomy' => $taxonomy,
            ) );

            // Get custom attribute type.
            global $wpdb;

            $attribute = current(
                $wpdb->get_results(
                    "SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
                    "WHERE attribute_name = '" . substr( $taxonomy, 3 ) . "' LIMIT 0, 1;"
                )
            );

            if ( $attribute ) {
                if ( $attribute->attribute_type == 'color' ) {
                    CSF::createSection( $this->_prefix, array(
                      'fields' => array(
                        array(
                          'id'    => 'color-color',
                          'type'  => 'color',
                          'title'   => esc_html__( 'Color', 'kalles' ),
                        ),
                        array(
                          'id'    => 'color-image',
                          'type'    => 'media',
                          'title'   => esc_html__( 'Image thumbnail', 'kalles' ),
                          'desc'   => esc_html__( 'This option will be overridden color.', 'kalles' ),
                          'library' => 'image',
                          'url' => false,
                        ),
                        array(
                          'id'    => 'color-tooltip',
                          'type'  => 'text',
                          'title'   => esc_html__( 'Tooltip', 'kalles' ),
                        ),
                      )
                    ) );
                }

                if ( $attribute->attribute_type == 'label' ) {
                    CSF::createSection( $this->_prefix, array(
                      'fields' => array(
                        array(
                          'id'    => 'label-label',
                          'type'  => 'text',
                          'title'   => esc_html__( 'Label', 'kalles' ),
                        ),
                        array(
                          'id'    => 'label-tooltip',
                          'type'  => 'text',
                          'title'   => esc_html__( 'Tooltip', 'kalles' ),
                        ),
                      )
                    ) );
                }

                if ( $attribute->attribute_type == 'radio' ) {
                    CSF::createSection( $this->_prefix, array(
                      'fields' => array(
                        array(
                          'id'    => 'radio-label',
                          'type'  => 'text',
                          'title'   => esc_html__( 'Label', 'kalles' ),
                        )                      )
                    ) );
                }
            }
        }
    }

    /**
     * Method to print values for custom attribute types in add/edit product screen.
     *
     * @param   object  $attribute  Attribute data.
     * @param   int     $i          Current attribute index.
     *
     * @return  void
     */
    public static function print_values( $attribute, $i ) {
        // Verify attribute type.
        if ( array_key_exists( $attribute->attribute_type, self::$types ) ) {
            if ( isset( $_POST['taxonomy'] ) ) {
                $taxonomy = sanitize_text_field( $_POST['taxonomy'] );
            } else {
                $taxonomy = wc_attribute_taxonomy_name( $attribute->attribute_name );
            }
            ?>
            <select name="attribute_values[<?php echo esc_attr( $i ); ?>][]" multiple="multiple" data-placeholder="<?php
                esc_attr_e( 'Select terms', 'kalles' );
            ?>" class="multiselect attribute_values wc-enhanced-select">
                <?php
                $all_terms = get_terms( $taxonomy, 'orderby=name&hide_empty=0' );

                if ( $all_terms ) :

                foreach ( $all_terms as $term ) :
                ?>
                <option value="<?php
                    echo esc_attr( version_compare(WC_VERSION, '3.0.0', 'lt') ? $term->slug : $term->term_id );
                ?>" <?php
                    selected( has_term( absint( $term->term_id ), $taxonomy, isset($_POST['post_id']) ? $_POST['post_id'] : 0 ), true );
                ?>>
                    <?php echo esc_html( $term->name ); ?>
                </option>
                <?php
                endforeach;

                endif;
                ?>
            </select>
            <button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'kalles' ); ?></button>
            <button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'kalles' ); ?></button>
            <button class="button fr plus add_new_attribute"><?php esc_html_e( 'Add new', 'kalles' ); ?></button>
            <?php
        }
    }

    /**
     * Register meta boxes for adding product variation gallery images.
     *
     * @return  void
     */
    public static function add_gallery_product_metabox()
    {
        global $post;
        if ( ! is_object( $post ) ) return;
        
        if ( $post->post_type == 'product' ) {
            // Get product details.
            $product = function_exists( 'wc_get_product' ) ? wc_get_product( $post ) : get_product( $post );

            // If product is variable, check if it has any variation using Color Picker attribute.
            if ( $product->is_type( 'variable' ) ) {
                // Get all product variation attributes.
                $attributes = $product->get_variation_attributes();
                $attribute  = maybe_unserialize( get_post_meta( $post->ID, '_product_attributes', true ) );

                // Loop thru attributes to check if Color Picker is used.
                foreach ($attribute as $key => $single_attribute) {
                    $color = false;
                    if (!$single_attribute['is_taxonomy']) {
                        $display_type_name = '_display_type_' . sanitize_title($key);
                        $color = get_post_meta($post->ID, $display_type_name, true) == 'color' ? true : false;
                    } else {
                        global $wpdb;

                        $attr = current(
                            $wpdb->get_results(
                                "SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
                                "WHERE attribute_name = '" . substr( $single_attribute['name'], 3 ) . "' LIMIT 0, 1;"
                            )
                        );

                        $color = $attr && ( 'color' == $attr->attribute_type ) ? true : false;
                    }

                    if ( $color ) {
                        // Color Picker attribute is used in product variation, add meta boxes for selecting variation images.
                        if (isset($attributes[$single_attribute['name']])) {
                            if (is_array($attributes[$single_attribute['name']])) {
                                foreach ( $attributes[$single_attribute['name']] as $option ) {
                                    add_meta_box(
                                        sprintf( "product-gallery-color-%s", $option ),
                                        ucwords( sprintf( esc_html__( 'Product Gallery %s Color', 'kalles' ), urldecode( $option ) ) ),
                                        array( __CLASS__, 'display_metabox_form' ),
                                        'product',
                                        'side',
                                        'low',
                                        array( 'name' => sanitize_title($single_attribute['name']), 'value' => sanitize_title($option) )
                                    );
                                }
                            }
                        }
                    }
                }

                //add_filter( 'woocommerce_product_data_tabs', array( __CLASS__, 'tabs' ) );
                //add_action( 'woocommerce_product_data_panels', array( __CLASS__, 'panels' ) );
            }
        }
    }

    /**
     * Display meta box to select gallery images for product variation.
     *
     * @param   WP_Post  $post    WordPress's post object.
     * @param   object   $params  Meta box parameters.
     *
     * @return  void
     */
    public static function display_metabox_form( $post, $params ) {
        // Generate meta key to get product variation gallery.
        $meta_key = strtolower("_product_image_gallery_{$params['args']['name']}-{$params['args']['value']}");
        // Print nonce field once.
        static $nonce_field_printed;

        if ( ! isset( $nonce_field_printed ) ) {
            wp_nonce_field( 'kalles_swatches_save_product_variation_gallery_images', 'kalles_swatches_save_product_variation_gallery_images' );

            $nonce_field_printed = true;
        }
        ?>
        <div class="product_variation_images_container">
            <ul class="product_images">
                <?php
                // Get product variation gallery.
                $product_image_gallery = get_post_meta( $post->ID, $meta_key, true );
                $attachments           = array_filter( explode( ',', $product_image_gallery ) );
                $update_meta           = false;
                $updated_gallery_ids   = array();

                if ( ! empty( $attachments ) ) {
                    foreach ( $attachments as $attachment_id ) {
                        $attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );

                        if ( empty( $attachment ) ) {
                            $update_meta = true;
                            continue;
                        }
                ?>
                <li class="image" data-attachment_id="<?php echo esc_attr( $attachment_id ); ?>">
                    <?php echo '' . $attachment; ?>
                    <ul class="actions">
                        <li>
                            <a href="#" class="delete tips" data-tip="<?php
                                esc_attr_e( 'Delete image', 'kalles' );
                            ?>">
                                <?php esc_html_e( 'Delete', 'kalles' ); ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php
                        // Rebuild ids to be saved.
                        $updated_gallery_ids[] = $attachment_id;
                    }

                    // Need to update product meta to set new gallery ids.
                    if ( $update_meta ) {
                        update_post_meta( $post->ID, $meta_key, implode( ',', $updated_gallery_ids ) );
                    }
                }
                ?>
            </ul>

            <input type="hidden" class="product_variation_image_gallery" name="<?php echo esc_attr( $meta_key ); ?>" value="<?php
                echo esc_attr( $product_image_gallery );
            ?>" />
        </div>
        <p class="add_product_variation_images hide-if-no-js">
            <a href="#" data-choose="<?php
                echo esc_attr( sprintf(
                    esc_html__( 'Add Images to Product Gallery %s', 'kalles' ),
                    urldecode( ucfirst( $params['args']['value'] ) )
                ) );
            ?>" data-update="<?php
                esc_attr_e( 'Add to gallery', 'kalles' );
            ?>" data-delete="<?php
                esc_attr_e( 'Delete image', 'kalles' );
            ?>" data-text="<?php
                esc_attr_e( 'Delete', 'kalles' );
            ?>">
                <?php esc_html_e( 'Add product gallery images', 'kalles' ); ?>
            </a>
        </p>
        <?php
    }

    /**
     * Save meta boxes.
     *
     * @param   int  $post_id  The ID of the post being saved.
     *
     * @return  void
     */
    public static function save_gallery_product_metabox( $post_id ) {
        $attribute  = maybe_unserialize( get_post_meta( $post_id, '_product_attributes', true ) );

        if ( ! empty( $attribute ) ) {

            foreach ( $attribute as $key => $single_attribute ) {
                if ( isset( $single_attribute ) && ! $single_attribute['is_taxonomy'] ) {
                    $custom_attrs = explode( ' | ', $single_attribute['value'] );
                    $display_type_name = '_display_type_' . sanitize_title($single_attribute['name']);
                    $display_type = $_POST[$display_type_name];

                    if ( ! empty( $display_type ) ) {
                        update_post_meta( $post_id, $display_type_name, esc_attr( $display_type ) );
                    }

                    foreach ( $custom_attrs as $custom_attr ) {
                        $custom_attr = strtolower(sanitize_title($custom_attr));
                        $custom_attr_color = $_POST['custom_attr_color_' . $custom_attr];

                        if (isset($_POST['custom_attr_color_' . $custom_attr]) && ! empty( $_POST['custom_attr_color_' . $custom_attr] ) ) {
                            $custom_attr_color = $_POST['custom_attr_color_' . $custom_attr];
                            update_post_meta( $post_id, 'custom_attr_color_' . $custom_attr, esc_attr( $custom_attr_color ) );
                        }

                        if (isset($_POST['custom_attr_img_' . $custom_attr]) && ! empty( $_POST['custom_attr_img_' . $custom_attr] ) ) {
                            $custom_attr_img = $_POST['custom_attr_img_' . $custom_attr];
                            update_post_meta( $post_id, 'custom_attr_img_' . $custom_attr, esc_attr( $custom_attr_img ) );
                        }

                        if (isset($_POST['custom_attr_label_' . $custom_attr]) && ! empty( $_POST['custom_attr_label_' . $custom_attr] ) ) {
                            $custom_attr_label = $_POST['custom_attr_label_' . $custom_attr];
                            update_post_meta( $post_id, 'custom_attr_label_' . $custom_attr, esc_attr( $custom_attr_label ) );
                        }
                    }
                }
            }
        }

        // Check if our nonce is set.
        if ( ! isset( $_POST['kalles_swatches_save_product_variation_gallery_images'] ) ) {
            return;
        }

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $_POST['kalles_swatches_save_product_variation_gallery_images'], 'kalles_swatches_save_product_variation_gallery_images' ) ) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // Check the user's permissions.
        if ( ! ( current_user_can( 'edit_post', $post_id ) || current_user_can( 'edit_posts' ) || current_user_can( 'manage_woocommerce' ) ) ) {
            return;
        }

        // Sanitize and save meta boxes.
        foreach ( $_POST as $k => $v ) {
            if ( 0 === strpos( $k, '_product_image_gallery_' ) ) {
                // Sanitize user input.
                $v = implode( ',', array_map( 'trim', explode( ',', $v ) ) );

                // Update the meta field in the database.
                update_post_meta( $post_id, $k, $v );
            }
        }

        if ( ! empty( $_POST['kalles_swatches_attrs'] ) ) {
            update_post_meta( $post_id, 'kalles_swatches_attrs', $_POST['kalles_swatches_attrs'] );
        } else {
            update_post_meta( $post_id, 'kalles_swatches_attrs', '' );
        }
    }

    /**
     * Add product data tab.
     *
     * @param $tabs
     *
     * @return  array
     */
    public static function tabs( $tabs ) {
        $tabs['kalles_swatches'] = array(
            'label'    => esc_html__( 'Variation Swatch', 'kalles' ),
            'target'   => 'kalles_swatches_product_data',
            'class'    => 'show_if_variable',
            'priority' => 70
        );

        return $tabs;
    }

    /**
     * Add product data panel.
     *
     * @param $tabs
     *
     * @return  string
     */
    public static function panels() {
        global $post, $thepostid;

        $product    = function_exists( 'wc_get_product' ) ? wc_get_product( $post ) : get_product( $post );
        $attributes = $product->get_variation_attributes();
        $attribute  = maybe_unserialize( get_post_meta( $thepostid, '_product_attributes', true ) );

        if ( ! empty( $attributes ) ) {
            echo '<div id="kalles_swatches_product_data" class="panel woocommerce_options_panel hidden">';
            if ( ! empty( $attribute ) ) {

                $empty_taxonomy = array_column( $attribute, 'is_taxonomy' );

                if ( in_array( 0, $empty_taxonomy, true )  ) {
                    echo '<h3>' . esc_html__( 'Setting for attribute of this product', 'kalles' ) . '</h3>';
                    echo sprintf( '<span class="description">This setting affect for the attribute of this product only. By default it\'s select</span>', 'kalles' );
                }

                foreach ( $attribute as $key => $single_attribute ) {
                    if ( isset( $single_attribute ) && ! $single_attribute['is_taxonomy'] ) {
                        $custom_attrs = explode( ' | ', $single_attribute['value'] );

                            woocommerce_wp_select(
                                array(
                                    'id'          => '_display_type_' . sanitize_title($single_attribute['name']),
                                    'label'       => esc_html__( 'Attribute type for ' , 'kalles' ) . $single_attribute['name'],
                                    'desc_tip'    => true,
                                    'description' => esc_html__( 'Click Update button to see the attributes.', 'kalles' ),
                                    'options'     => array(
                                        'default' => esc_html__( 'Select', 'kalles' ),
                                        'color'   => esc_html__( 'Color', 'kalles' ),
                                        'label'   => esc_html__( 'Label', 'kalles' )
                                    )
                                )
                            );

                            $display_type = get_post_meta( $post->ID, '_display_type_' . sanitize_title($single_attribute['name']), true );

                            if ( $display_type !== 'default' ) {
                                foreach ( $custom_attrs as $custom_attr ) {
                                $custom_attr_color  = get_post_meta( $post->ID, 'custom_attr_color_' . sanitize_title( $custom_attr ), true );
                                $custom_attr_img_id = get_post_meta( $post->ID, 'custom_attr_img_' . sanitize_title( $custom_attr ), true );
                                $custom_attr_label  = get_post_meta( $post->ID, 'custom_attr_label_' . sanitize_title( $custom_attr ), true );

                                echo '<p class="form-field kalles-default-field">';
                                    echo '<label for="custom_attr_color"><strong>' . $custom_attr . '</strong></label>';
                                    if ( $display_type !== 'label' ) {
                                        echo '<span class="kalles-color-field">';
                                            echo '<input type="text" class="kalles-color-picker" name="custom_attr_color_' . sanitize_title( $custom_attr ) . '" id="custom_attr_color_' . sanitize_title( $custom_attr ) . '" value="' . $custom_attr_color . '" />';

                                            if ( isset( $custom_attr_img_id ) && $custom_attr_img_id ) {
                                                $image = wp_get_attachment_thumb_url( $custom_attr_img_id );
                                                $hidden = '';
                                            } else {
                                                $image = wc_placeholder_img_src();
                                                $hidden = ' hidden';
                                            }

                                            echo '
                                                <span class="wpa-swatch">
                                                    <a href="#" class="wpa-kalles-btn-upload" data-choose="' . esc_html__( 'Add image', 'kalles' ) . '" data-update="' . esc_html__( 'Update image', 'kalles' ) . '" data-delete="' . esc_html__( 'Delete image', 'kalles' ) . '" data-text="' . esc_html__( 'Delete', 'kalles' ) . '">
                                                        <img src="' . esc_url( $image ) . '" />
                                                        <span data-thumb="' . esc_url( wc_placeholder_img_src() ) . '" class="wpa-kalles-btn-remove dashicons dashicons-no-alt' . esc_attr( $hidden ) . '"></span>
                                                    </a>
                                                    <input type="hidden" class="kalles_swatches_thumb_id" value="" name="custom_attr_img_' . sanitize_title( $custom_attr ) . '" />
                                                </span>
                                            ';
                                        echo '</span>';
                                    } else {
                                        echo '
                                            <span class="kalles-label-field">
                                                <input type="text" class="short" name="custom_attr_label_' . sanitize_title( $custom_attr ) . '" id="custom_attr_label_' . sanitize_title( $custom_attr ) . '" value="' . $custom_attr_label . '" placeholder="Label" />
                                            </span>
                                        ';
                                    }

                                echo '</p>';
                            }
                            ?>
                            <script type="text/javascript">
                                (function($) {
                                    $(document).ready(function() {
                                        $( '.kalles-color-picker' ).wpColorPicker();
                                    });
                                })(jQuery);
                            </script>

                            <?php
                        }
                    }
                }
            }
            foreach ( $attributes as $attribute_name => $options ) {
                // Get custom attribute type.
                global $wpdb;

                $attr = current(
                    $wpdb->get_results(
                        "SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
                        "WHERE attribute_name = '" . substr( $attribute_name, 3 ) . "' LIMIT 0, 1;"
                    )
                );

                if ( $attr && ( 'color' == $attr->attribute_type ) && isset( $attribute[$attribute_name] ) ) {
                    $terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );

                    $attr_swatch = get_post_meta( $post->ID, 'kalles_swatches_attrs', true );

                    echo '<h3>' . esc_html__( 'Custom image for variation of global attribute', 'kalles' ) . '</h3>';
                    echo sprintf( '<span class="description">This setting will be overridden in global settings. <a target="_blank" href="%s">Click here</a> if you want to change global settings</span>', admin_url( 'edit-tags.php?taxonomy=' . $attribute_name . '&post_type=product' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            if ( $attr_swatch ) {
                                $thumb_id = $attr_swatch[esc_attr( $term->taxonomy )][$term->term_id];
                            }

                            if ( isset( $thumb_id ) && $thumb_id ) {
                                $image = wp_get_attachment_thumb_url( $thumb_id );
                                $hidden = '';
                            } else {
                                $image = wc_placeholder_img_src();
                                $hidden = ' hidden';
                            }
                        ?>
                            <p class="form-field">
                                <label><strong><?php echo sanitize_text_field( $term->name ) ; ?></strong></label>
                                <span class="wpa-swatch">
                                    <a href="#" class="wpa-kalles-btn-upload" data-choose="<?php esc_attr_e( 'Add image', 'kalles' ); ?>" data-update="<?php esc_attr_e( 'Update image', 'kalles' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'kalles' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'kalles' ); ?>">
                                        <img src="<?php echo esc_url( $image ); ?>">
                                        <span data-thumb="<?php echo esc_url( wc_placeholder_img_src() ); ?>" class="wpa-kalles-btn-remove dashicons dashicons-no-alt<?php echo esc_attr( $hidden ); ?>"></span>
                                    </a>
                                    <input type="hidden" name="is_attribute" value="1">
                                    <input type="hidden" class="kalles_swatches_thumb_id" value="<?php echo isset( $thumb_id ) ? $thumb_id : ''; ?>" name="kalles_swatches_attrs[<?php echo esc_attr( $term->taxonomy );?>][<?php echo absint( $term->term_id ); ?>]" />
                                </span>
                            </p>
                            <?php
                        }
                    }
                }
            }
            echo '</div>';
        } else {
            echo '<div id="kalles_swatches_product_data" class="panel woocommerce_options_panel hidden">';
                echo '<div class="inline notice woocommerce-message">';
                    echo '<p>' . esc_html__( 'Before you can add a variation you need to add some variation attributes on the Attributes tab.', 'kalles' ) . '</p>';
                echo '</div>';
            echo '</div>';
        }
    }
    /**
     * Method to get product image gallery for the selected color.
     *
     * @param   array       $attachment_ids  Current product gallery attachment IDs.
     * @param   WC_Product  $product         Current product object.
     *
     * @return  array
     */
    public static function get_product_image_gallery( $attachment_ids, $product ) {
        if ( $product->is_type( 'variable' ) ) {
            global $wpdb;

            // Prepare variation attributes.
            $attributes = $product->get_variation_attributes();

            // Alter variations form to support custom attribute types.
            foreach ( $attributes as $attribute_name => $options ) {
                // Get custom attribute type.
                $attr = current(
                    $wpdb->get_results(
                        "SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
                        "WHERE attribute_name = '" . substr( $attribute_name, 3 ) . "' LIMIT 0, 1;"
                    )
                );

                if ( $attr && ( $attr->attribute_type == 'color' ) ) {
                    // Check if certain attribute value is requested.
                    $key = 'attribute_' . sanitize_title( $attribute_name );

                    if ( isset( $_REQUEST[ $key ] ) && in_array( $_REQUEST[ $key ], $options ) ) {
                        // Get term data.
                        $term = get_term_by( 'slug', wc_clean( $_REQUEST[ $key ] ), $attribute_name );

                        if ( $term ) {
                            // Get image gallery for the selected color.
                            $meta_key      = "_product_image_gallery_{$term->taxonomy}-{$term->slug}";
                            $image_gallery = get_post_meta( $product->get_id(), $meta_key, true );

                            if ( $image_gallery ) {
                                $attachment_ids = array_filter(
                                    array_filter( ( array ) explode( ',', $image_gallery ) ),
                                    'wp_attachment_is_image'
                                );
                            }
                        }
                    }
                }
            }
        }

        return $attachment_ids;
    }

    /**
     * Print product image gallery for the selected color.
     *
     * @return  void
     */
    public static function print_product_image_gallery() {
        // Initialize necessary global variables..
        $GLOBALS['post']    = get_post( $_REQUEST['product'] );
        $GLOBALS['product'] = function_exists( 'wc_get_product' ) ? wc_get_product( $_REQUEST['product'] ) : get_product( $_REQUEST['product'] );

        // Print HTML for product image gallery.
        woocommerce_show_product_images();

        exit;
    }

}
The4_Woocommerce_Swatches::instance();
