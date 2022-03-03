<?php
/**
 * Custom menu
 *
 * @since   1.0.0
 * @package Kalles
 */
class THE4_Kalles_Menu_Walker extends Walker {
	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$depth_plus = ( $depth + 1 );

		if ( $depth_plus == '1' ) {
			$class_names[] = 'sub-menu';
		} else {
			$class_names[] = 'sub-column';
		}

		$classes = implode(' ', $class_names );

		$indent = str_repeat( "\t", $depth );


		if ($depth == 0) {
			$output .= "\n$indent<div class='megamenu-dropdown sub-menu'>\n";
		}
		$output .= "\n$indent<ul class='" . $classes . "'>\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
		if ($depth == 0) {
			$output .= "\n$indent</div>\n";
		}
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$classes[] = 'item-level-' . $depth;

		$menu_type = '';
		$mega_menu = $menu_pos = $menu_width = $menu_height = $menu_icon = $menu_block = $menu_label = $menu_label_color = '';
		$kalles_megamenu_options = get_post_meta( $item->ID, '_kalles_megamenu_options', true );

		$mega_menu = isset ( $kalles_megamenu_options['megamenu'] ) ? $kalles_megamenu_options['megamenu'] : '';
		$menu_type = isset ( $kalles_megamenu_options['megamenu-type'] ) ? $kalles_megamenu_options['megamenu-type'] : '';
		$menu_width = isset ( $kalles_megamenu_options['megamenu-width'] ) ? $kalles_megamenu_options['megamenu-width'] : '';
		$menu_height = isset ( $kalles_megamenu_options['megamenu-height'] ) ? $kalles_megamenu_options['megamenu-height'] : '';
		$menu_icon = isset ( $kalles_megamenu_options['menu-icon'] ) ? $kalles_megamenu_options['menu-icon'] : '';
		$menu_label = isset( $kalles_megamenu_options['label-title'] ) ? $kalles_megamenu_options['label-title'] : '';
		$menu_label_color = isset( $kalles_megamenu_options['label-color'] ) ? $kalles_megamenu_options['label-color'] : '';
		$menu_block = isset ( $kalles_megamenu_options['block-megamenu'] ) ? $kalles_megamenu_options['block-megamenu'] : '';
		$menu_pos = isset ( $kalles_megamenu_options['megamenu-pos'] ) ? $kalles_megamenu_options['megamenu-pos'] : 'default';

		if (empty($menu_label_color)) $menu_label_color = 'blue';
		if (empty($menu_type)) {
			$menu_type = 'default';
		}
		if ($depth == 0) {
			$classes[] = 'menu-width-' . $menu_type;

		}
		$menu_drop_type = ($mega_menu) ? 'mega-dropdown' : 'default-dropdown';
		$classes[] = 'menu-' . $menu_drop_type;
		$classes[] = 'pos-' . $menu_pos;

		if (isset($block)) {
			$classes[] = 'menu-item-block';
		}

		/* Check for children */
		$children = get_posts(
			array(
				'post_type'              => 'nav_menu_item',
				'nopaging'               => true,
				'numberposts'            => 1,
				'meta_key'               => '_menu_item_menu_item_parent',
				'meta_value'             => $item->ID,
				'update_post_meta_cache' => false
			)
		);
		if ( ! empty( $children ) && $depth != 0 ) {
			$classes[] = 'sub-column-item';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes = array();
		$attributes['title'] = ! empty($item->attr_title) ? $item->attr_title : '';
		$attributes['target'] = ! empty($item->target) ? $item->target : '';
		$attributes['rel'] = ! empty($item->xfn) ? $item->xfn : '';
		$attributes['href'] = ! empty($item->url) ? $item->url : '';

		$attributes = apply_filters('nav_menu_link_attributes', $attributes, $item, $args, $depth);
		$attributes['class'] = 'kalles-nav-link';

		$item_output_value = '';
		foreach ($attributes as $attr => $value) {
			if (!empty($value)) {
				$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
				$item_output_value .= ' ' . $attr . '="' . $value .'"';
			}
		}
		if ( is_object( $args ) ) {
			$item_output = $args->before;
			$item_output .= '<a'. $item_output_value .'>';
			if (!empty($menu_icon)) {
				$item_output .= '<i class="mr__10 fs__20 ' . $menu_icon . '"></i>';
			}
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			if (!empty($menu_label)) {
				$item_output .= '<span class="menu-item-label hi"
										style="background-color: '. $menu_label_color .'">'. $menu_label .'</span>';
			}
			$item_output .= '</a>';
			$item_output .= $args->after;
		} else {
			$item_output = '<a'. $item_output_value .'>';
			if (!empty($menu_icon)) {
				$item_output .= '<i class="mr__10 fs__20 ' . $menu_icon . '"></i>';
			}
			$item_output .= apply_filters( 'the_title', $item->title, $item->ID );
			$item_output .= '</a>';
		}
		if ($menu_type == 'custom_size') {
			$style = 'style="width: '. $menu_width .'px !important; height: '. $menu_height .'px !important;"';
		} else {
			$style = '';
		}
		if ($depth == 0 && !empty($menu_block) && $mega_menu) {
			$item_output .= "\n$indent<div class='megamenu-dropdown-block sub-menu'>\n";

			$item_output .= "\n$indent<div class='container' ". $style .">\n";

			$item_output .= kalles_get_megamenu_html($menu_block);

			$item_output .= "\n$indent</div>\n";
			$item_output .= "\n$indent</div>\n";
		}


		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}

/**
 * Custom mobile menu
 *
 * @since   1.0.0
 * @package Kalles
 */
class THE4_Kalles_Mobile_Menu_Walker extends Walker {

	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul>\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'item-level-' . $depth;

		$kalles_megamenu_options = get_post_meta( $item->ID, '_kalles_megamenu_options', true );
		$menu_icon = isset ( $kalles_megamenu_options['menu-icon'] ) ? $kalles_megamenu_options['menu-icon'] : '';
		$menu_label = isset ( $kalles_megamenu_options['label-title'] ) ? $kalles_megamenu_options['label-title'] : '';
		$menu_label_color = isset ( $kalles_megamenu_options['label-color'] ) ? $kalles_megamenu_options['label-color'] : '';
		/* Add active class */
		if ( in_array( 'current-menu-item', $classes ) ) {
			$classes[] = 'active';
			unset( $classes['current-menu-item'] );
		}

		/* Check for children */
		$children = get_posts(
			array(
				'post_type'   => 'nav_menu_item',
				'nopaging'    => true,
				'numberposts' => 1,
				'meta_key'    => '_menu_item_menu_item_parent',
				'meta_value'  => $item->ID,
				'update_post_meta_cache' => false
			)
		);
		if ( ! empty( $children ) ) {
			$classes[] = 'has-sub';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class="kalles-nav-link" ';
		if ( is_object( $args ) ) {
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			if (!empty($menu_icon)) {
				$item_output .= '<i class="mr__10 fs__20 ' . $menu_icon . '"></i>';
			}
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			if (!empty($menu_label)) {
				$item_output .= '<span class="menu-item-label d"
										style="background-color: '. $menu_label_color .'">'. $menu_label .'</span>';
			}
			$item_output .= '</a>';
			$item_output .= $args->after;
		} else {
			$item_output = '<a'. $attributes .'>';
			if (!empty($menu_icon)) {
				$item_output .= '<i class="mr__10 fs__20 ' . $menu_icon . '"></i>';
			}
			$item_output .= apply_filters( 'the_title', $item->title, $item->ID );
			if (!empty($menu_label)) {
				$item_output .= '<span class="menu-item-label d"
										style="background-color: '. $menu_label_color .'">'. $menu_label .'</span>';
			}
			$item_output .= '</a>';
		}
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}