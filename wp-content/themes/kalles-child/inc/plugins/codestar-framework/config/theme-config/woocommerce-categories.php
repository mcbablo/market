<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//Woocommerce Categories config

CSF::createSection( $prefix, array(
  'id'    => 'woocommerce-categories',
  'title' => esc_html__( 'Categories Page', 'kalles' ),
  'icon'  => 'fas fa-shopping-basket',
  ) );

CSF::createSection( $prefix, array(
  'parent'      => 'woocommerce-categories',
  'id'          => 'wc_categories-general',
  'title'       => esc_html__( 'General Settings', 'kalles' ),
  'icon'        => 'fa fa-minus',
  'fields'      => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'General Settings', 'kalles' ),
    ),

    array(
      'id'         => 'wc-pagination',
      'type'       => 'select',
      'title'      => esc_html__( 'Pagination Style', 'kalles' ),
      'options' => array(
        'number'   => esc_html__( 'Number', 'kalles' ),
        'loadmore' => esc_html__( 'Load More', 'kalles' ),
        'scroll' => esc_html__( 'Infinite Scroll', 'kalles' ),
      ),
      'default' => 'number'
    ),
    array(
      'id'      => 'wc-flip-thumb',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Flip Product Thumbnail', 'kalles' ),
      'default' => false,
    ),
    array(
      'id'      => 'wc-atc-on-product-list',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable add to cart button', 'kalles' ),
      'default' => false,
    ),
    array(
      'id'      => 'wc-product-list_price',
      'type'    => 'button_set',
      'title'   => esc_html__( 'Display price', 'kalles' ),
      'default' => 'display',
      'options'     => array(
        'display'  => 'display',
        'hide'  => 'Hide',
      ),
    ),
    array(
      'id'      => 'wc-quick-view-btn',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable quick view button', 'kalles' ),
      'default' => true,
    ),
    array(
      'id'      => 'wc-quick-shop-enable',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable quick shop', 'kalles' ),
      'default' => true,
    ),
    array(
      'id'      => 'wc-col-switch',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable Column Switcher', 'kalles' ),
      'default' => true
    ),
    array(
      'id'      => 'wc_cateogries_filter_on',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Filter Top default open', 'kalles' ),
      'default' => false
    ),
    array(
      'id'      => 'wc-atc-on-product-short_description',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Display short description', 'kalles' ),
      'default' => false,
    ),
    array(
      'id'      => 'wc_categories-general_move_out_stock',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Move out stock product to the last of categories page', 'kalles' ),
      'default' => false,
    ),
    array(
      'id'      => 'wc-attr',
      'type'    => 'checkbox',
      'title'   => esc_html__( 'Enable Products Attribute On Product List', 'kalles' ),
      'options' => kalles_csf_get_attr(),
    ),
    array(
      'id'      => 'wc-attr-background',
      'type'    => 'color',
      'title'   => esc_html__( 'Products Attribute Background Color when hover', 'kalles' ),
      'default' => 'transparent',
    ),
  )
) );

CSF::createSection( $prefix, array(
  'parent'      => 'woocommerce-categories',
  'id'          => 'wc_categories-layout',
  'title'       => esc_html__( 'Layout & Style', 'kalles' ),
  'icon'        => 'fa fa-minus',
  'fields'      => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Layout & Style Settings', 'kalles' ),
    ),
    array(
      'id'      => 'wc-layout-full',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable Full-Width', 'kalles' ),
      'default' => false,
    ),
    array(
      'id'    => 'wc-style',
      'type'  => 'image_select',
      'title' => esc_html__( 'Style', 'kalles' ),
      'desc'  => esc_html__( 'Display product listing as grid or masonry or metro', 'kalles' ),
      'radio' => true,
      'label' => true,
      'options' => array(
        'grid'    => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/grid.png',
        'masonry' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/masonry.png',
        'metro'   => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/metro.png'
      ),
      'default' => 'grid',
    ),
    array(
      'id'    => 'wc_categories_product-style',
      'type'  => 'image_select',
      'title' => esc_html__( 'Hover style', 'kalles' ),
      'radio' => true,
      'options' => array(
        'default'       => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/hover-1.png',
        'full_info'     => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/hover-2.png',
        'icon_on_hover' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/hover-3.png',
        'layout-4'      => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/hover-4.png',
        'layout-5'      => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/hover-5.png',
        'layout-6'      => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/hover-6.png',
      ),
      'default' => 'default',
    ),
    array(
      'id'    => 'wc-column',
      'type'  =>'image_select',
      'title' => esc_html__( 'Number Of Column', 'kalles' ),
      'desc'  => esc_html__( 'Display number of product per row', 'kalles' ),
      'radio' => true,
      'options' => array(
        '6' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/2cols.png',
        '4' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/3cols.png',
        '3' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/4cols.png',
        '2' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/6cols.png',
        'listt4' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/list-view.png',
      ),
      'default' => '4'
    ),
    array(
      'id'      => 'wc-number-per-page',
      'type'    => 'number',
      'title'   => esc_html__( 'Per Page', 'kalles' ),
      'desc'    => esc_html__( 'How much items per page to show (-1 to show all products)', 'kalles' ),
      'default' => '12',
    ),
  )
) );

CSF::createSection( $prefix, array(
  'parent'      => 'woocommerce-categories',
  'id'          => 'wc_categories-sidebar',
  'title'       => esc_html__( 'Sidebar Settings', 'kalles' ),
  'icon'        => 'fa fa-minus',
  'fields' => array(
        array(
          'type'    => 'heading',
          'content' => esc_html__( 'Categories Sidebar Settings', 'kalles' ),
        ),
        array(
          'id'    => 'wc-layout',
          'type'  => 'image_select',
          'title' => esc_html__( 'Layout', 'kalles' ),
          'radio' => true,
          'label' => true,
          'options' => array(
            'left-sidebar'  => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/left-sidebar.png',
            'no-sidebar'    => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/no-sidebar.png',
            'right-sidebar' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/right-sidebar.png',
            'hidden-sidebar' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/no-sidebar.png',
          ),
          'default' => 'no-sidebar'
        ),
        array(
          'id'         => 'wc-sidebar',
          'type'       => 'select',
          'title'      => esc_html__( 'Select Sidebar', 'kalles' ),
          'options'    => 'sidebars',
          'dependency' => array( 'wc-layout', '!=', 'false' ),
        ),
        array(
          'id'      => 'wc-sidebar-filter',
          'type'    => 'switcher',
          'title'   => esc_html__( 'Enable Sidebar Filter', 'kalles' ),
          'default' => false,
          'desc'    => sprintf( wp_kses_post( 'Edit content in sidebar <a target="_blank" href="%s">WooCommerce Filter Sidebar</a>', 'kalles' ), esc_url( admin_url( 'widgets.php' ) ) )
        ),
        array(
          'id'         => 'wc-sidebar-filter-position',
          'type'       => 'button_set',
          'title'      => esc_html__( 'Sidebar Filter Position', 'kalles' ),
          'options' => array(
            'left'  => esc_html__( 'Left Slidebar', 'kalles' ),
            'top'  => esc_html__( 'Center Inner', 'kalles' ),
            'top_show'  => esc_html__( 'Top Inner Show ', 'kalles' ),
            'right' => esc_html__( 'Right Slidebar', 'kalles' ),
          ),
          'default'    => 'left',
          'dependency' => array( 'wc-sidebar-filter', '==', true ),
        ),

      )
) );

 CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-categories',
    'id'          => 'wc_sub_cat_setting',
    'title'       => esc_html__( 'Sub Category Settings', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Sub Category', 'kalles' ),
          ),
          array(
            'id'    => 'wc-sub-cat-layout',
            'type'  =>'image_select',
            'title' => esc_html__( 'Sub-Categories Layout', 'kalles' ),
            'desc'  => esc_html__( 'Display sub-categories as grid or masonry', 'kalles' ),
            'radio' => true,
            'label' => true,
            'options' => array(
              'grid'    => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/grid.png',
              'masonry' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/masonry.png'
            ),
            'default' => 'masonry'
          ),
          array(
            'id'    => 'wc-sub-cat-column',
            'type'  =>'image_select',
            'title' => esc_html__( 'Columns', 'kalles' ),
            'desc'  => esc_html__( 'Display number of sub-category per row', 'kalles' ),
            'radio' => true,
            'options' => array(
              '6' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/2cols.png',
              '4' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/3cols.png',
              '3' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/4cols.png',
              '2' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/6cols.png',
            ),
            'default' => '3'
          ),
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Sub Category after title', 'kalles' ),
          ),
          array(
            'id'      => 'wc-subcustom-enable',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable', 'kalles' ),
            'default' => false,
          ),
          array(
            'id'      => 'wc-subcustom-product_count',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Show product count', 'kalles' ),
            'default' => false,
          ),
          array(
            'id'      => 'wc-subcustom-only_sub',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Only show subcategories', 'kalles' ),
            'default' => false,
          ),
          array(
            'id'    => 'wc-subcustom_layout',
            'type'  =>'select',
            'title' => esc_html__( 'Layout', 'kalles' ),

            'options' => array(
              'default'      => 'Default',
              'title_center' => 'Category name on hover',
              'title_button' => 'Category button center',
            ),
            'default' => 'default'
          ),
          array(
            'id'      => 'wc-subcustom_image_size',
            'type'    => 'slider',
            'title'   => 'Thumbnail max width',
            'min'     => 50,
            'max'     => 500,
            'step'    => 10,
            'default' => 180,
          ),
        )
  ) );
