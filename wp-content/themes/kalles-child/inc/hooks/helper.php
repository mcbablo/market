<?php
/**
 * Helpper function
 * @since   1.0.0
 * @package Kalles
 */

/**
 * Render header layout.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_header' ) ) {
    function the4_kalles_header() {
        $layout = cs_get_option( 'header-layout' ) ? cs_get_option( 'header-layout' ) : 3;

        ob_start();
        get_template_part( 'views/header/layout', $layout );
        $output = ob_get_clean();

        echo apply_filters( 'the4_kalles_header', $output );
    }
}

/**
 * Render footer layout.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_footer' ) ) {
    function the4_kalles_footer() {
        $layout = cs_get_option( 'footer-layout' ) ? cs_get_option( 'footer-layout' ) : 1;

        ob_start();
        get_template_part( 'views/footer/layout', $layout );
        $output = ob_get_clean();

        echo apply_filters( 'the4_kalles_footer', $output );
    }
}

/**
 * Render google font link
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'kalles_google_font_url' ) ) {
    function kalles_google_font_url() {
        // Google font
        $fonts = $font_parse = array();

        // Font default
        $fonts['Poppins'] = array(
            '300',
            '400',
            '500',
            '600',
            '700',
        );
        $fonts['Libre Baskerville'] = array( '400italic' );

        // Body font
        $body_font    = cs_get_option( 'body-font' );
        $heading_font = cs_get_option( 'heading-font' );

        if ( $body_font && $body_font['type'] == 'google' ) {
            $font_family = esc_attr( $body_font['font-family'] );

            $font_weight = array( esc_attr( $body_font['font-weight'] ) );

            // Merge array and delete values duplicated
            $fonts[$font_family] = isset( $fonts[$font_family] ) ? array_unique( array_merge( $fonts[$font_family], $font_weight ) ) : $font_weight;

        }

        if ( $heading_font && $heading_font['type'] == 'google' ) {
            $font_family = esc_attr( $heading_font['font-family'] );
            $font_weight = array( esc_attr( $heading_font['font-weight'] ) );

            // Merge array and delete values duplicated
            $fonts[$font_family] = isset( $fonts[$font_family] ) ? array_unique( array_merge( $fonts[$font_family], $font_weight ) ) : $font_weight;
        }

        // Parse array to string for url Google fonts
        foreach ( $fonts as $font_name => $font_weight ) {
            $font_parse[] = $font_name . ':'. implode( ',' , $font_weight );
        }
        
        $query_args = array(
            'family' => urldecode( implode( '|', $font_parse ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
        

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

        return esc_url_raw( $fonts_url );
    }
}

/**
 * Render logo.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_logo' ) ) {
    function the4_kalles_logo() {
        $output = '';
        $output .= '<div class="branding ts__05">';
        $output .= '<a href="' . esc_url( home_url( '/' ) ) . '">';
        if ( ! cs_get_option( 'header-transparent' ) ) {
            if ( cs_get_option( 'logo' ) ) {
                $logo_id = cs_get_option( 'logo' );
                $logo = wp_get_attachment_image_src( $logo_id['id'], 'full', true );
                $output .= '<img class="regular-logo normal-logo" src="' . esc_url( $logo[0] ) . '" width="' . esc_attr( $logo[1] ? $logo[1] : '' ) . '" height="' . esc_attr( $logo[2] ? $logo[2] : '' ) . '" alt="' . get_bloginfo( 'name' ) . '" />';
                if ( cs_get_option( 'logo-sticky' ) ) {
                    $logo_id = cs_get_option( 'logo-sticky' );
                    $logo = wp_get_attachment_image_src( $logo_id['id'], 'full', true );
                    $output .= '<img class="sticky-logo" src="' . esc_url( $logo[0] ) . '" width="' . esc_attr( $logo[1] ? $logo[1] : '' ) . '" height="' . esc_attr( $logo[2] ? $logo[2] : '' ) . '" alt="' . get_bloginfo( 'name' ) . '" />';
                }
            } else {
                $output .= '<img class="regular-logo" src="' . THE4_KALLES_URL . '/assets/images/logo.png' . '" width="96" height="29" alt="' . get_bloginfo( 'name' ) . '" />';
            }

            if ( cs_get_option( 'logo-retina' ) ) {
                $logo_id = cs_get_option( 'logo-retina' );
                $logo_retina = wp_get_attachment_image_src(  $logo_id['id'], 'full', true );

                $output .= '<img class="retina-logo normal-logo" src="' . esc_url( $logo_retina[0] ) . '" width="' . esc_attr( $logo_retina[1] ? $logo_retina[1] / 2 : '' ) . '" height="' . esc_attr( $logo_retina[2] ? $logo_retina[2] / 2 : '' ) . '" alt="' . get_bloginfo( 'name' ) . '" />';
            } else {
                $output .= '<img class="retina-logo" src="' . THE4_KALLES_URL . '/assets/images/logo-2x.png' . '" width="96" height="29" alt="' . get_bloginfo( 'name' ) . '" />';
            }
        } else {
            if ( cs_get_option( 'logo-transparent' ) ) {
                $logo_id = cs_get_option( 'logo-transparent' );
                $logo = wp_get_attachment_image_src( $logo_id['id'], 'full', true );

                $output .= '<img class="regular-logo normal-logo" src="' . esc_url( $logo[0] ) . '" width="' . esc_attr( $logo[1] ? $logo[1] : '' ) . '" height="' . esc_attr( $logo[2] ? $logo[2] : '' ) . '" alt="' . get_bloginfo( 'name' ) . '" />';
                if ( cs_get_option( 'logo-sticky' ) ) {
                    $logo_id = cs_get_option( 'logo-sticky' );
                    $logo = wp_get_attachment_image_src( $logo_id['id'], 'full', true );
                    $output .= '<img class="sticky-logo" src="' . esc_url( $logo[0] ) . '" width="' . esc_attr( $logo[1] ? $logo[1] : '' ) . '" height="' . esc_attr( $logo[2] ? $logo[2] : '' ) . '" alt="' . get_bloginfo( 'name' ) . '" />';
                }
            } else {
                $output .= '<img class="regular-logo" src="' . THE4_KALLES_URL . '/assets/images/logo.png' . '" width="96" height="29" alt="' . get_bloginfo( 'name' ) . '" />';
            }

            if ( cs_get_option( 'logo-transparent-retina' ) ) {
                $logo_id = cs_get_option( 'logo-retina' );
                $logo_retina = wp_get_attachment_image_src( $logo_id['id'], 'full', true );

                $output .= '<img class="retina-logo normal-logo" src="' . esc_url( $logo_retina[0] ) . '" width="' . esc_attr( $logo_retina[1] ? $logo_retina[1] : '' ) . '/2" height="' . esc_attr( $logo_retina[2] ? $logo_retina[2] : '' ) . '/2" alt="' . get_bloginfo( 'name' ) . '" />';
            } else {
                $output .= '<img class="retina-logo" src="' . THE4_KALLES_URL . '/assets/images/logo-2x.png' . '" width="96" height="29" alt="' . get_bloginfo( 'name' ) . '" />';
            }
        }
        $output .= '</a>';
        $output .= '</div>';

        echo apply_filters( 'the4_kalles_logo', $output );
    }
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_posted_on' ) ) {
    function the4_kalles_posted_on() {
        $output = '';
        $time = '<a class="cg" href="%3$s"><time class="entry-date published updated" ' . the4_kalles_schema_metadata( array( 'context' => 'entry_time', 'echo' => false ) ) . '>%2$s</time></a>';


        $output .= sprintf( $time,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_url( get_permalink() )
        );

        echo apply_filters( 'the4_kalles_posted_on', '<span class="posted-on fs__12">' . $output . '</span>' );
    }
}

/**
 * Prints post title.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_post_title' ) ) {
    function the4_kalles_post_title( $link = true ) {
        $output = '';

        if ( $link ) {
            $output .= sprintf( '<h3 class="post-title fs__16 mb__5 mg__0" ' . the4_kalles_schema_metadata( array( 'context' => 'entry_title', 'echo' => false ) ) . '><a class="chp" href="%2$s" rel="bookmark">%1$s</a></h3>', get_the_title(), esc_url( get_permalink() ) );
        } else {
            $output .= sprintf( '<h3 class="post-title fs__14  mt__10 mg__5 tu" ' . the4_kalles_schema_metadata( array( 'context' => 'entry_title', 'echo' => false ) ) . '>%s</h3>', get_the_title() );

        }

        echo apply_filters( 'the4_kalles_post_title', $output );
    }
}

/**
 * Prints post meta with the post author, categories and post comments.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_post_meta' ) ) {
    function the4_kalles_post_meta() {
        $output = '';
        // Post author
        $output .= sprintf(
            esc_html__( '%1$s', 'kalles' ),
            '<span class="author vcard pr" ' . the4_kalles_schema_metadata( array( 'context' => 'author', 'echo' => false ) ) . '>' . esc_html__( 'By ', 'kalles' ) . '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'

        );

        // Post categories
        $categories = get_the_category_list( esc_html__( ', ', 'kalles' ) );
        if ( $categories ) {
            $output .= sprintf(
                '<span class="cat pr">' . esc_html__( 'in %1$s', 'kalles' ) . '</span>', $categories
            );
        }

        echo apply_filters( 'the4_kalles_post_meta', '<div class="post-meta fs__12">' . $output . '</div>' );
    }
}

/**
 * Prints post meta with the post author, categories and post comments.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_post_meta_layout_grid' ) ) {
    function the4_kalles_post_meta_layout_grid() {
        $output = '';
        // Post author
        $output .= sprintf(
            esc_html__( '%1$s', 'kalles' ),
            '<span class="post-author mr__5" ' . the4_kalles_schema_metadata( array( 'context' => 'author', 'echo' => false ) ) . '>' . esc_html__( 'By ', 'kalles' ) . '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'

        );
        $time = '<span class="post-time mr__5">'. esc_html__( 'on ', 'kalles' ) . '<a class="cd" href="%3$s"><time class="entry-date published updated" ' . the4_kalles_schema_metadata( array( 'context' => 'entry_time', 'echo' => false ) ) . '>%2$s</time></a></span>';


        $output .= sprintf( $time,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_url( get_permalink() )
        );
        // Post categories
        $categories = get_the_category_list( esc_html__( ', ', 'kalles' ) );
        if ( $categories ) {
            $output .= sprintf(
                '<span class="post-cat mr__5">' . esc_html__( 'in %1$s', 'kalles' ) . '</span>', $categories
            );
        }

        echo apply_filters( 'the4_kalles_post_meta_layout_grid', '<div class="post-meta fs__14">' . $output . '</div>' );
    }
}
/**
 * Render post tags.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_get_tags' ) ) :
    function the4_kalles_get_tags() {
        $output = '';

        // Get the tag list
        $tags_list = get_the_tag_list( '', esc_html__( ', ', 'kalles' ) );
        if ( $tags_list ) {
            $output .= sprintf( '<div class="post-tags"><i class="t4_icon_t4-tag"></i> ' . esc_html__( '%1$s', 'kalles' ) . '</div>', $tags_list );
        }
        return apply_filters( 'the4_kalles_get_tags', $output );
    }
endif;

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_post_thumbnail' ) ) {
    function the4_kalles_post_thumbnail() {
        ?>
        <div class="post-thumbnail pr mb__20">
            <?php
            $display_style = cs_get_option( 'blog-style' );
            if ( has_post_thumbnail() ) :
                if ( $display_style == 'grid') { ?>
                    <a href="<?php esc_url( the_permalink() ); ?>" aria-hidden="true">
                        <?php
                            $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

                            $image = the4_resizer( $img[0], 640, 475, true );
                        ?>
                        <img src="<?php echo esc_url( $image ); ?>" width="640" height="475" alt="<?php get_the_title() ?>" />
                    </a>
                <?php } else { ?>
                    <a href="<?php esc_url( the_permalink() ); ?>" aria-hidden="true">
                        <img src="<?php echo get_the_post_thumbnail_url('','full'); ?>" alt="<?php get_the_title() ?>">
                    </a>
                <?php } ?>
            <?php endif; ?>
            <?php
            if ( $display_style == 'masonry') {?>
                <div class="pa inside-thumb tc cg">
                    <?php the4_kalles_post_meta(); ?>
                    <?php the4_kalles_post_title(); ?>
                    <?php the4_kalles_posted_on(); ?>
                </div>
            <?php }  ?>

        </div>
        <?php
    }
}

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_pagination' ) ) {
    function the4_kalles_pagination( $nav_query = false ) {

        global $wp_query, $wp_rewrite;

        // Don't print empty markup if there's only one page.
        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
            return;
        }

        // Prepare variables
        $query        = $nav_query ? $nav_query : $wp_query;
        $max          = $query->max_num_pages;
        $current_page = max( 1, get_query_var( 'paged' ) );
        $big          = 999999;
        ?>
        <nav class="the4-pagination">
            <?php
            echo '' . paginate_links(
                    array(
                        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format'    => '?paged=%#%',
                        'current'   => $current_page,
                        'total'     => $max,
                        'type'      => 'list',
                        'prev_text' => esc_html__( 'Prev', 'kalles' ),
                        'next_text' => esc_html__( 'Next', 'kalles' ),
                    )
                ) . ' ';
            ?>
        </nav><!-- .page-nav -->
        <?php
    }
}

/**
 * Create a breadcrumb menu.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_breadcrumb' ) ) {
    function the4_kalles_breadcrumb() {
        // Settings
        $sep   = '<i class="t4_icon_angle-right-solid"></i>';
        $home  = esc_html__( 'Home', 'kalles' );
        $blog  = esc_html__( 'Blog', 'kalles' );
        $shop  = esc_html__( 'Shop', 'kalles' );

        // Get the query & post information
        global $post, $wp_query;

        // Get post category
        $category = get_the_category();

        // Get product category
        $product_cat = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

        if ( $product_cat ) {
            $tax_title = $product_cat->name;
        }

        $output = '';

        // Build the breadcrums
        $output .= '<div class="bgbl w__100"><ul class="the4-breadcrumb oh">';

        // Do not display on the homepage
        if ( ! is_front_page() ) {

            if ( is_home() ) {

                // Home page
                $output .= '<li class="fl home"><a href="' . esc_url( get_home_url() ) . '" title="' . esc_attr( $home ) . '">' . $home . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';
                $output .= '<li class="fl separator"> ' . $blog . ' </li>';

            } elseif ( function_exists( 'is_shop' ) && is_shop() ) {

                $output .= '<li class="fl home"><a href="' . esc_url( get_home_url() ) . '" title="' . esc_attr( $home ) . '">' . $home . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';
                $output .= '<li class="fl">' . $shop . '</li>';

            } elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {

                $output .= '<li class="fl home"><a href="' . esc_url( get_home_url() ) . '" title="' . esc_attr( $home ) . '">' . $home . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';
                $output .= '<li class="fl"><a href="' . esc_url( get_post_type_archive_link( 'product' ) ) . '" title="' . esc_attr( $home ) . '">' . $shop . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';
                $output .= '<li class="fl separator"> ' . esc_html__( 'Category', 'kalles' ) . ' </li>';

            } elseif ( function_exists( 'is_product_tag' ) && is_product_tag() ) {

                $output .= '<li class="fl home"><a href="' . esc_url( get_home_url() ) . '" title="' . esc_attr( $home ) . '">' . $home . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';
                $output .= '<li class="fl"><a href="' . esc_url( get_post_type_archive_link( 'product' ) ) . '" title="' . esc_attr( $home ) . '">' . $shop . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';
                $output .= '<li class="fl separator"> ' . esc_html__( 'Tag', 'kalles' ) . ' </li>';

            } elseif ( is_post_type_archive() ) {

                $post_type = get_post_type_object( get_post_type() );

                $output .= '<li class="fl home"><a href="' . esc_url( get_home_url() ) . '" title="' . esc_attr( $home ) . '">' . $home . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';
                $output .= '<li class="fl current">' . $post_type->labels->singular_name . '</li>';
            } elseif ( is_tax() ) {

                $term = $GLOBALS['wp_query']->get_queried_object();

                $output .= '<li class="fl home"><a href="' . esc_url( get_home_url() ) . '" title="' . esc_attr( $home ) . '">' . $home . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';
                $output .= '<li class="fl current">' . $term->name . '</li>';

            } elseif ( is_single() ) {

                // Single post (Only display the first category)
                if ( ! empty( $category ) ) {
                    $output .= '<li class="fl"><a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '" title="' . esc_attr( $category[0]->cat_name ) . '">' . $category[0]->cat_name . '</a></li>';
                }

                $output .= '<li class="fl separator"> ' . $sep . ' </li>';
                $output .= '<li class="fl current">' . get_the_title() . '</li>';

            } elseif ( is_category() ) {

                $thisCat = get_category( get_query_var( 'cat' ), false );
                if ( $thisCat->parent != 0 ) echo get_category_parents( $thisCat->parent, TRUE, ' ' );

                // Category page
                $output .= '<li class="fl current">' . single_cat_title( '', false ) . '</li>';

            } elseif ( is_page() ) {

                $output .= '<li class="fl home"><a href="' . esc_url( get_home_url() ) . '" title="' . esc_attr( $home ) . '">' . $home . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';

                // Standard page
                if ( $post->post_parent ) {

                    // If child page, get parents
                    $anc = get_post_ancestors( $post->ID );

                    // Get parents in the right order
                    $anc = array_reverse($anc);

                    // Parent page loop
                    foreach ( $anc as $ancestor ) {
                        $parents = '<li class="fl"><a href="' . esc_url( get_permalink( $ancestor ) ) . '" title="' . esc_attr( get_the_title( $ancestor ) ) . '">' . get_the_title( $ancestor ) . '</a></li>';
                        $parents .= '<li class="fl separator"> ' . $sep . ' </li>';
                    }

                    // Display parent pages
                    $output .= $parents;

                    // Current page
                    $output .= '<li class="fl current"> ' . get_the_title() . '</li>';

                } else {

                    // Just display current page if not parents
                    $output .= '<li class="fl current"> ' . get_the_title() . '</li>';

                }

            } elseif ( is_tag() ) {

                // Tag page

                // Get tag information
                $term_id  = get_query_var( 'tag_id' );
                $taxonomy = 'post_tag';
                $args     = 'include=' . $term_id;
                $terms    = get_terms( $taxonomy, $args );

                // Display the tag name
                $output .= '<li class="fl current">' . $terms[0]->name . '</li>';

            } elseif ( is_day() ) {

                // Day archive

                // Year link
                $output .= '<li class="fl"><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . esc_html__( ' Archives', 'kalles' ) . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';

                // Month link
                $output .= '<li class="fl"><a href="' . esc_url( get_month_link( get_the_time('Y'), get_the_time( 'm' ) ) ) . '" title="' . esc_attr( get_the_time( 'M' ) ) . '">' . get_the_time( 'M' ) . esc_html__( ' Archives', 'kalles' ) . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';

                // Day display
                $output .= '<li class="fl current"> ' . get_the_time('jS') . ' ' . get_the_time('M') . esc_html__( ' Archives', 'kalles' ) . '</li>';

            } elseif ( is_month() ) {

                // Month Archive

                // Year link
                $output .= '<li class="fl"><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . esc_html__( ' Archives', 'kalles' ) . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';

                // Month display
                $output .= '<li class="fl">' . get_the_time( 'M' ) . esc_html__( ' Archives', 'kalles' ) . '</li>';

            } elseif ( is_year() ) {

                // Display year archive
                $output .= '<li class="fl current">' . get_the_time('Y') . esc_html__( 'Archives', 'kalles' ) . '</li>';

            } elseif ( is_author() ) {

                // Auhor archive

                // Get the author information
                global $author;
                $userdata = get_userdata( $author );

                // Display author name
                $output .= '<li class="fl current">' . esc_html__( 'Author: ', 'kalles' ) . $userdata->display_name . '</li>';

            } elseif ( get_query_var('paged') ) {

                // Paginated archives
                $output .= '<li class="fl current">' .  esc_html__( 'Page', 'kalles' ) . ' ' . get_query_var( 'paged' ) . '</li>';

            } elseif ( is_search() ) {

                // Search results page
                $output .= '<li class="fl current">' .  esc_html__( 'Search results for: ', 'kalles' ) . get_search_query() . '</li>';

            } elseif ( is_404() ) {

                // 404 page
                $output .= '<li class="fl home"><a href="' . esc_url( get_home_url() ) . '" title="' . esc_attr( $home ) . '">' . $home . '</a></li>';
                $output .= '<li class="fl separator"> ' . $sep . ' </li>';
                $output .= '<li class="fl current">' . esc_html__( 'Error 404', 'kalles' ) . '</li>';
            }

        } else  {
            $output .= '<li class="fl current">' . esc_html__( 'Front Page', 'kalles' ) . '</li>';
        }

        $output .= '</ul></div>';

        return apply_filters( 'the4_kalles_breadcrumb', $output );
    }
}

/**
 * Print HTML for social share.
 *
 * @return  void
 */
if ( ! function_exists( 'the4_kalles_social_share' ) ) {
    function the4_kalles_social_share() {
        global $post;
        $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), false, '' );
        if (! isset($src[ 0 ])) {
            $src[ 0 ] = '';
        }
        $social_option = cs_get_option( 'wc-social-share-option' );

        ?>
        <div class="social-share">
            <div class="the4-social <?php echo esc_attr( cs_get_option( 'wc-social-share-align' ) ); ?>">
                <?php if (cs_get_option( 'wc-social-share-type' ) == 'default') : ?>
                <?php if ( in_array('facebook', $social_option) ) { ?>
                    <a data-no-instant rel="noopener noreferrer nofollow"
                        class="cb facebook ttip_nt tooltip_top"
                        href="http://www.facebook.com/sharer.php?u=<?php esc_url( the_permalink() ); ?>"
                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=380,width=660');return false;">
                        <span class="tt_txt"><?php esc_html_e( 'Share on Facebook', 'kalles' ) ?></span>
                        <i class="t4_icon_facebook-f"></i>
                    </a>
                <?php } ?>
                <?php if (in_array('tweet', $social_option) ) { ?>
                    <a class="cb twitter ttip_nt tooltip_top"
                        data-no-instant rel="noopener noreferrer nofollow"
                        href="https://twitter.com/share?url=<?php esc_url( the_permalink() ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=380,width=660');return false;">
                        <span class="tt_txt"><?php esc_html_e( 'Tweet on Twitter', 'kalles' ) ?></span>
                        <i class="t4_icon_twitter"></i>
                    </a>
                <?php } ?>
                <?php if ( in_array('pinterest', $social_option) ) { ?>
                    <a  data-no-instant rel="noopener noreferrer nofollow"
                        class="cb pinterest ttip_nt tooltip_top"
                        href="//pinterest.com/pin/create/button/?url=<?php esc_url( the_permalink() ); ?>&media=<?php echo esc_url( $src[0] ); ?>&description=<?php the_title(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                       <span class="tt_txt"><?php esc_html_e( 'Pin on Pinterest', 'kalles' ) ?></span>
                       <i class="t4_icon_pinterest-p"></i>
                    </a>
                <?php } ?>
                <?php if ( in_array('tumblr', $social_option) ) { ?>
                    <a data-no-instant rel="noopener noreferrer nofollow"
                        class="cb tumblr ttip_nt tooltip_top"
                        data-content="<?php echo esc_url( $src[0] ); ?>"
                        href="//tumblr.com/widgets/share/tool?canonicalUrl=<?php esc_url( the_permalink() ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=540');return false;">
                          <span class="tt_txt"><?php esc_html_e( 'Pin on Tumblr', 'kalles' ) ?></span>
                       <i class="t4_icon_tumblr"></i>
                    </a>
                <?php } ?>
                <?php if ( in_array('email', $social_option) ) { ?>
                    <a data-no-instant rel="noopener noreferrer nofollow"
                        class="cb email ttip_nt tooltip_top"
                        data-content="<?php echo esc_url( $src[0] ); ?>"
                        href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php esc_url( the_permalink() ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=540');return false;">
                        <span class="tt_txt"><?php esc_html_e( 'Share on Email', 'kalles' ) ?></span>
                        <i class="t4_icon_mail-fill"></i>
                    </a>
                <?php } ?>
                <?php if ( in_array('telegram', $social_option) ) { ?>
                    <a data-no-instant rel="noopener noreferrer nofollow"
                        class="cb telegram ttip_nt tooltip_top"
                        data-content="<?php echo esc_url( $src[0] ); ?>"
                        href="https://telegram.me/share/url?url=<?php esc_url( the_permalink() ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=540');return false;">
                        <span class="tt_txt"><?php esc_html_e( 'Share on Telegram', 'kalles' ) ?></span>
                        <i class="t4_icon_telegram1"></i>
                    </a>
                <?php } ?>
                <?php if ( in_array('whatsapp', $social_option) ) { ?>
                    <a data-no-instant rel="noopener noreferrer nofollow"
                        class="cb whatsapp ttip_nt tooltip_top"
                        data-content="<?php echo esc_url( $src[0] ); ?>"
                        href="https://wa.me/?text=<?php the_title(); ?>&#x20;<?php esc_url( the_permalink() ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=540');return false;">
                        <span class="tt_txt"><?php esc_html_e( 'Share on Whatsapp', 'kalles' ) ?></span>
                        <i class="t4_icon_whatsapp"></i>
                    </a>
                <?php } ?>

                <?php else : ?>
                    <div class="nt__addthis addthis_inline_share_toolbox_icxz"></div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}

/**
 * Render author information.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_author_info' ) ) {
    function the4_kalles_author_info() {
        $author = sprintf(
            wp_kses_post( '<div class="post-author">%1$s<div class="clearfix">%2$s%3$s</div></div>', 'kalles' ),
            '<h4 class="mg__0 mb__35 pr dib tu cp head__1">' . esc_html__( 'About Author', 'kalles' ) . '</h4>',
            '<div class="fl">' . get_avatar( get_the_author_meta( 'user_email' ), '100', '' ) . '</div>',
            '<div class="oh pl__70"><a class="f__mont cb chp fwb db mb__10 mt__5" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a><p>' . get_the_author_meta( 'description' ) . '</p></div>'

        );
        echo apply_filters( 'the4_kalles_author_info', $author );
    }
}

/**
 * Render related post based on post tags.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_related_post' ) ) {
    function the4_kalles_related_post() {
        global $post;
		if( ! cs_get_option('blog-detail-related') ){
            return;
        }
        // Get post's tags
        $tags = wp_get_post_tags( $post->ID );

        if ( $tags ) {
            // Get id for all tags
            $tag_ids = array();

            foreach ( $tags as $tag ) {
                $tag_ids[] = $tag->term_id;
            }

            // Build arguments to query for related posts
            $args = array(
                'tag__in'             => $tag_ids,
                'post__not_in'        => array( $post->ID ),
                'posts_per_page'      => apply_filters( 'the4_kalles_related_post_per_page', '5' ),
                'ignore_sticky_posts' => 1,
                'orderby'             => 'rand',
            );

            // Get related post
            $related = new wp_query( $args );

            $output = '';
            $output .= '<div class="post-related mt__50">';
            $output .= '<h4 class="mg__0 mb__30 tu">' . esc_html__( 'Related Articles', 'kalles' ) . '</h4>';
            $output .= '<div class="the4-carousel" data-slick=\'{"slidesToShow": 3,"slidesToScroll": 1, "responsive":[{"breakpoint": 960,"settings":{"slidesToShow": 2}},{"breakpoint": 480,"settings":{"slidesToShow": 1}}]'. ( is_rtl() ? ',"rtl":true' : '' ) .'}\'>';
            while ( $related->have_posts() ) :
                // Update global post data
                $related->the_post();

                $output .= '<div class="item">';
                if ( has_post_thumbnail() ) {
                    $output .= '<a class="db mb__20" href="' . esc_url( get_permalink() ) . '">';
                    $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

                    if ( $img[1] >= 370 && $img[2] >= 210 ) {
                        $image = the4_resizer( $img[0], 370, 210, true );
                        $output .= '<img src="' . esc_url( $image ) . '" width="370" height="210" alt="' . get_the_title() . '" />';
                    } else {
                        $output .= '<div class="pr placeholder mb__15">';
                        $output .= '<img src="' . THE4_KALLES_URL . '/assets/images/placeholder.png" width="370" height="210" alt="' . get_the_title() . '" />';
                        $output .= '<div class="pa tc fs__10">' . esc_html__( 'The photos should be at least 370px x 210px', 'kalles' ) . '</div>';
                        $output .= '</div>';
                    }
                    $output .= '</a>';
                }

                $output .= '<h5 class="mg__0 fs__14"><a class="cd chp" href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h5>';
                $output .= '<span class="f__libre">' . get_the_date( 'j F Y' ) . '</span>';
                $output .= '</div>';
            endwhile;
            $output .= '</div>';
            $output .= '</div>';

            // Reset global query object
            wp_reset_postdata();

            echo apply_filters( 'the4_kalles_related_post', $output );
        }
    }
}

/**
 * custom function to use to open and display each comment
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_comments_list' ) ) {
    function the4_kalles_comments_list( $comment, $args, $depth ) {
        // Globalize comment object
        $GLOBALS['comment'] = $comment;

        switch ( $comment->comment_type ) :

            case 'pingback'  :
            case 'trackback' :
                ?>
                <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <p>
                    <?php
                    echo esc_html__( 'Pingback:', 'kalles' );
                    comment_author_link();
                    edit_comment_link( esc_html__( 'Edit', 'kalles' ), '<span class="edit-link">', '</span>' );
                    ?>
                </p>
                <?php
                break;

            default :
                global $post;
                ?>
            <li <?php comment_class( 'mt__30' ); ?> id="li-comment-<?php comment_ID(); ?>">
                <article id="comment-<?php comment_ID(); ?>" class="comment_container" <?php the4_kalles_schema_metadata( array( 'context' => 'comment' ) ); ?>>
                    <?php echo get_avatar( $comment, 80 ); ?>

                    <div class="comment-text">
                        <?php if ( '0' == $comment->comment_approved ) : ?>
                            <p class="comment-awaiting-moderation"><?php echo esc_html__( 'Your comment is awaiting moderation.', 'kalles' ); ?></p>
                        <?php endif; ?>

                        <?php
                        printf(
                            '<h5 class="comment-author mg__0 mb__5 tu cb" ' . the4_kalles_schema_metadata( array( 'context' => 'comment_author', 'echo' => false ) ) . '><span ' . the4_kalles_schema_metadata( array( 'context' => 'author_name', 'echo' => false ) ) . '>%1$s</span></h5>',
                            get_comment_author_link(),
                            ( $comment->user_id == $post->post_author ) ? '<span class="author-post">' . esc_html__( 'Post author', 'kalles' ) . '</span>' : ''
                        );
                        ?>
                        <div <?php the4_kalles_schema_metadata( array( 'context' => 'entry_content' ) ); ?>>
                            <?php comment_text(); ?>
                        </div>


                        <div class="flex">
                            <?php
                            printf(
                                '<time class="grow f__libre" ' . the4_kalles_schema_metadata( array( 'context' => 'entry_time', 'echo' => false ) ) . '>%3$s</time>',
                                esc_url( get_comment_link( $comment->comment_ID ) ),
                                get_comment_time( 'c' ),
                                sprintf( wp_kses_post( '%1$s '. esc_html__( 'at', 'kalles') .' %2$s', 'kalles' ), get_comment_date(), get_comment_time() )
                            );
                            ?>
                            <?php
                            edit_comment_link( wp_kses_post( '<span>' . esc_html__( 'Edit', 'kalles' ) . '</span>', 'kalles' ) );
                            comment_reply_link(
                                array_merge(
                                    $args,
                                    array(
                                        'reply_text' => wp_kses_post( '<span class="ml__10">' . esc_html__( 'Reply', 'kalles' ) . '</span>', 'kalles' ),
                                        'depth'      => $depth,
                                        'max_depth'  => $args['max_depth'],
                                    )
                                )
                            );
                            ?>
                        </div><!-- .action-link -->
                    </div><!-- .comment-content -->
                </article><!-- #comment- -->
                <?php
                break;

        endswitch;
    }
}

/**
 * Render custom styles.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_custom_css' ) ) {
    function the4_kalles_custom_css( $css = array() )
    {
        $primary_color = cs_get_option('primary-color') ? cs_get_option('primary-color') : '#4cbccd';
        //Root
        $css[] = '
                :root {
                    --primary-color: ' . $primary_color . ';
                    --secondary-color: ' . cs_get_option('secondary-color') . ';
                }

                ';
        // Content width boxed
        $layout_page_type = cs_get_option('layout_type');

        if (isset($_REQUEST['layout_type'])) {
            $layout_page_type = sanitize_text_field($_REQUEST['layout_type']);
        }
        if ($layout_page_type == 'boxed') {
            $content_width = cs_get_option('content-width');
            $css[] = '
                    @media only screen and (min-width: 1025px) {
                        .wrapper_boxed #the4-wrapper .container, .wrapper_boxed .container {
                            max-width: ' . $content_width . 'px;
                        }
                    }
                ';
        }

        // Logo width
        $logo_width = cs_get_option('logo-max-width');
        if (! empty( $logo_width ) ) {
            $css[] = '
                header .branding,
                .top-menu .branding,
				div .search-on-top .branding{
                    max-width: ' . esc_attr($logo_width) . 'px;
                }
            ';
        }

        //Custom Lazyload icon
        $lazyload_icon = cs_get_option('general_lazyload-icon');

        if (!empty($lazyload_icon['url'])) {
            $css[] = '.the4-lazyload::before, .pr_lazy_img_bg.lazyloading::before {
                    background-size: ' . cs_get_option('general_lazyload-icon_size') . 'px;
                    -webkit-animation: .35s linear infinite alternate skeletonAnimation;
                    animation: .35s linear infinite alternate skeletonAnimation;
                    background-image: url(' . $lazyload_icon['url'] . ') !important;

                }';
        } else {
            $lazyload_icon_size = cs_get_option('general_lazyload-icon_size') ? cs_get_option('general_lazyload-icon_size') : 30;
            $css[] = '.the4-lazyload::before, .pr_lazy_img_bg.lazyloading::before {
                    background-size: ' . $lazyload_icon_size . 'px;
                    background-image: url(data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22100px%22%20height%3D%22100px%22%20viewBox%3D%220%200%20100%20100%22%20preserveAspectRatio%3D%22xMidYMid%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M24.3%2C30C11.4%2C30%2C5%2C43.3%2C5%2C50s6.4%2C20%2C19.3%2C20c19.3%2C0%2C32.1-40%2C51.4-40%20C88.6%2C30%2C95%2C43.3%2C95%2C50s-6.4%2C20-19.3%2C20C56.4%2C70%2C43.6%2C30%2C24.3%2C30z%22%20stroke%3D%22%2356cfe1%22%20stroke-width%3D%222%22%20stroke-dasharray%3D%22205.271142578125%2051.317785644531256%22%3E%3Canimate%20attributeName%3D%22stroke-dashoffset%22%20calcMode%3D%22linear%22%20values%3D%220%3B256.58892822265625%22%20keyTimes%3D%220%3B1%22%20dur%3D%221%22%20begin%3D%220s%22%20repeatCount%3D%22indefinite%22%2F%3E%3C%2Fpath%3E%3C%2Fsvg%3E);

                }';
        }

        // Boxed layout
        $boxed_bg = cs_get_option('boxed-bg');
        if ( ! empty( $boxed_bg['background-image'] ) ) {
            $css[] = 'htnl .boxed {';
            $css[] = 'background-image:  url(' . esc_url($boxed_bg['background-image']['url']) . ');';

            if ( ! empty( $boxed_bg['background-size'] ) ) {
                $css[] = 'background-size:' . $boxed_bg['background-size'] . ';';
            }
            if ( ! empty( $boxed_bg['background-repeat'] ) ) {
                $css[] = 'background-repeat:' . $boxed_bg['background-repeat'] . ';';
            }
            if ( ! empty( $boxed_bg['background-position'] ) ) {
                $css[] = 'background-position:' . $boxed_bg['background-position'] . ';';
            }
            if ( ! empty( $boxed_bg['background-attachment'] ) ) {
                $css[] = 'background-attachment:' . $boxed_bg['background-attachment'] . ';';
            }
                    
            $css[] = '}';
        }
        if ( ! empty( $boxed_bg['background-color'] ) ) {
            $css[] = '.boxed #the4-wrapper {';
            $css[] = 'background-color: ' . $boxed_bg['background-color'] . ';';
            $css[] = '}';
        }

        // WC page title
        $wc_head_bg = cs_get_option('wc-pagehead-bg');
        if ( (function_exists('is_shop') && is_shop() || function_exists('is_product') && is_product() )
             && ( !empty( $wc_head_bg['background-color'] ) || !empty( $wc_head_bg['background-image']['url'] ) )
            ) {
            $css[] = '.the4-wc .page-head, .the4-wc-single .page-head {';
            $css[] = '
                    background-image:  url(' . esc_url($wc_head_bg['background-image']['url']) . ');';
            if ( ! empty( $wc_head_bg['background-size'] ) ) {
                $css[] = 'background-size:' . $wc_head_bg['background-size'] . ';';
            }
            if ( ! empty( $wc_head_bg['background-repeat'] ) ) {
                $css[] = 'background-repeat:' . $wc_head_bg['background-repeat'] . ';';
            }
            if ( ! empty( $wc_head_bg['background-position'] ) ) {
                $css[] = 'background-position:' . $wc_head_bg['background-position'] . ';';
            }
            if ( ! empty( $wc_head_bg['background-attachment'] ) ) {
                $css[] = 'background-attachment:' . $wc_head_bg['background-attachment'] . ';';
            }
            if ( ! empty( $wc_head_bg['background-color'] ) ) {
                $css[] = 'background-color:' . $wc_head_bg['background-color'] . ';';
            }
            $css[] = '}';
        } elseif (function_exists('is_product_category') && is_product_category()) {
            global $wp_query;
            $cat = $wp_query->get_queried_object();
            $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
            $tmp = wp_get_attachment_image_src($thumbnail_id, 'full');
            if (!empty($tmp)) {
                $css[] = '.the4-wc div.page-head {';
                $css[] = '
                        background-image:  url(' . esc_url($tmp[0]) . ');
                        background-position: center center;
                        background-size: cover;
                    ';
                $css[] = '}';
            }
        }

        // Portfolio page title
        $portfolio_head_bg = cs_get_option('portfolio-pagehead-bg');
        if (!empty($portfolio_head_bg['background-image']['url'])) {
            $css[] = 'div.the4-portfolio .page-head {';
            $css[] = '
                    background-image:  url(' . esc_url($portfolio_head_bg['background-image']['url']) . ');';
            if ( ! empty( $portfolio_head_bg['background-size'] ) ) {
                $css[] = 'background-size:' . $portfolio_head_bg['background-size'] . ';';
            }
            if ( ! empty( $portfolio_head_bg['background-repeat'] ) ) {
                $css[] = 'background-repeat:' . $portfolio_head_bg['background-repeat'] . ';';
            }
            if ( ! empty( $portfolio_head_bg['background-position'] ) ) {
                $css[] = 'background-position:' . $portfolio_head_bg['background-position'] . ';';
            }
            if ( ! empty( $portfolio_head_bg['background-attachment'] ) ) {
                $css[] = 'background-attachment:' . $portfolio_head_bg['background-attachment'] . ';';
            }
            if ( ! empty( $portfolio_head_bg['background-color'] ) ) {
                $css[] = 'background-color:' . $portfolio_head_bg['background-color'] . ';';
            }
            $css[] = '}';
        }


        // Footer background
        $footer_bg = cs_get_option('footer-bg');

        if (!empty($footer_bg['background-image']['url'])) {
            $css[] = 'div.footer__top {';
            $css[] = '
                    background-image:  url(' . esc_url($footer_bg['background-image']['url']) . ');';
            if ( ! empty( $footer_bg['background-size'] ) ) {
                $css[] = 'background-size:' . $footer_bg['background-size'] . ';';
            }
            if ( ! empty( $footer_bg['background-repeat'] ) ) {
                $css[] = 'background-repeat:' . $footer_bg['background-repeat'] . ';';
            }
            if ( ! empty( $footer_bg['background-position'] ) ) {
                $css[] = 'background-position:' . $footer_bg['background-position'] . ';';
            }
            if ( ! empty( $footer_bg['background-attachment'] ) ) {
                $css[] = 'background-attachment:' . $footer_bg['background-attachment'] . ';';
            }
            if ( ! empty( $footer_bg['background-color'] ) ) {
                $css[] = 'background-color:' . $footer_bg['background-color'] . ';';
            }
            $css[] = '}';
        }

        // Maintenance background
        $offline = cs_get_option('maintenance-bg');

        if (!empty($offline['background-image'])) {
            $css[] = 'div.the4-offline-content {';
            $css[] = '
                    background-image:  url(' . esc_url($offline['background-image']['url']) . ') !important;';
            
            if ( ! empty( $offline['background-size'] ) ) {
                $css[] = 'background-size:' . $offline['background-size'] . ' !important;';
            }
            if ( ! empty( $offline['background-repeat'] ) ) {
                $css[] = 'background-repeat:' . $offline['background-repeat'] . '  !important;';
            }
            if ( ! empty( $offline['background-position'] ) ) {
                $css[] = 'background-position:' . $offline['background-position'] . '  !important;';
            }
            if ( ! empty( $offline['background-attachment'] ) ) {
                $css[] = 'background-attachment:' . $offline['background-attachment'] . '  !important;';
            }
            if ( ! empty( $offline['background-color'] ) ) {
                $css[] = 'background-color:' . $offline['background-color'] . '  !important;';
            }

            $css[] = '}';
        }

        // Typography
        $body_font = cs_get_option('body-font');

        $heading_font = cs_get_option('heading-font');

        if ( $body_font ) {
        // Body font family

            $css[] = 'html body, .the4-menu > li > a, .f__pop, .the4-menu ul li a, .prod-content div {';
            // Body font family
            $css[] = 'font-family: "' . $body_font['font-family'] . '";';
            if (!empty($body_font['font-weight'])) {
                $css[] = 'font-weight: ' . $body_font['font-weight'] . ';';
            }
            if (!empty($body_font['font-style'])) {
                $css[] = 'font-style: ' . $body_font['font-style'] . ';';
            }
            if (!empty($body_font['font-size'])) {
                $css[] = 'font-size: ' . $body_font['font-size'] . $body_font['unit'] . ';';
            }
            if (!empty($body_font['color'])) {
                $css[] = 'color: ' . $body_font['color'] . ';';
            }
            if (!empty($body_font['text-align'])) {
                $css[] = 'text-align: ' . $body_font['text-align'] . ';';
            }
            if (!empty($body_font['text-transform'])) {
                $css[] = 'text-transform: ' . $body_font['text-transform'] . ';';
            }
            if (!empty($body_font['text-align'])) {
                $css[] = 'text-align: ' . $body_font['text-align'] . ';';
            }
            if (!empty($body_font['line-height'])) {
                $css[] = 'line-height: ' . $body_font['line-height'] . ';';
            }
            if (!empty($body_font['letter-spacing'])) {
                $css[] = 'letter-spacing: ' . $body_font['letter-spacing'] . ';';
            }

            $css[] = '}';
        }

        if ( $heading_font ) {
            $css[] = 'h1, h2, h3, h4, h5, h6, .f__pop {';
            $css[] = 'font-family: "' . $heading_font['font-family'] . '";';
            if (!empty($heading_font['font-weight'])) {
                $css[] = 'font-weight: ' . $heading_font['font-weight'] . ';';
            }
            if (!empty($heading_font['font-style'])) {
                $css[] = 'font-style: ' . $heading_font['font-style'] . ';';
            }
            if (!empty($heading_font['font-size'])) {
                $css[] = 'font-size: ' . $heading_font['font-size'] . $heading_font['unit'] . ';';
            }
            if (!empty($heading_font['color'])) {
                $css[] = 'color: ' . $heading_font['color'] . ';';
            }
            if (!empty($heading_font['text-align'])) {
                $css[] = 'text-align: ' . $heading_font['text-align'] . ';';
            }
            if (!empty($heading_font['text-transform'])) {
                $css[] = 'text-transform: ' . $heading_font['text-transform'] . ';';
            }
            if (!empty($heading_font['text-align'])) {
                $css[] = 'text-align: ' . $heading_font['text-align'] . ';';
            }
            if (!empty($heading_font['line-height'])) {
                $css[] = 'line-height: ' . $heading_font['line-height'] . ';';
            }
            if (!empty($heading_font['letter-spacing'])) {
                $css[] = 'letter-spacing: ' . $heading_font['letter-spacing'] . ';';
            }
            $css[] = '}';
        }



        if (cs_get_option('menu-font-size')) {
            $css[] = '.the4-menu > li > a { font-size:' . cs_get_option('menu-font-size') . 'px; }';
        }
        if (cs_get_option('head-top-font-size')) {
            $css[] = '.header__top { font-size:' . cs_get_option('head-top-font-size') . 'px; }';
        }
        if (cs_get_option('h1-font-size')) {
            $css[] = 'h1 { font-size:' . cs_get_option('h1-font-size') . 'px; }';
        }
        if (cs_get_option('h2-font-size')) {
            $css[] = 'h2 { font-size:' . cs_get_option('h2-font-size') . 'px; }';
        }
        if (cs_get_option('h3-font-size')) {
            $css[] = 'h3 { font-size:' . cs_get_option('h3-font-size') . 'px; }';
        }
        if (cs_get_option('h4-font-size')) {
            $css[] = 'h4 { font-size:' . cs_get_option('h4-font-size') . 'px; }';
        }
        if (cs_get_option('h5-font-size')) {
            $css[] = 'h5 { font-size:' . cs_get_option('h5-font-size') . 'px; }';
        }
        if (cs_get_option('h6-font-size')) {
            $css[] = 'h6 { font-size:' . cs_get_option('h6-font-size') . 'px; }';
        }

        $enable_font_face = cs_get_option('enable_font_face');
        if (isset($_REQUEST['enable_font_face'])) {
            $enable_font_face = sanitize_text_field($_REQUEST['enable_font_face']);
        }
        $font_face_option = cs_get_option('font_face_option');
        if (isset($_REQUEST['font_face_option'])) {
            $font_face_option = sanitize_text_field($_REQUEST['font_face_option']);
        }
        if ($enable_font_face && $font_face_option == 'futura') {
            $css[] = 'body, .the4-menu > li > a, .f__pop, .the4-menu ul li a, h1,h2, h3, h4, h5, h6 {';
            // Body font family
            $css[] = 'font-family: "Futura"';
            $css[] = '}';
        } elseif ($enable_font_face && $font_face_option == 'jost') {
            $css[] = 'body, .the4-menu > li > a, .f__pop, .the4-menu ul li a, h1,h2, h3, h4, h5, h6 {';
            // Body font family
            $css[] = 'font-family: "Jost"';
            $css[] = '}';
        }
        // Body color
        if (cs_get_option('body-background-color')) {
            $css[] = 'body { background-color: ' . esc_attr(cs_get_option('body-background-color')) . '}';
        }
        if (cs_get_option('body-color')) {
            $css[] = 'body { color: ' . esc_attr(cs_get_option('body-color')) . '}';
        }
        if (cs_get_option('heading-color')) {
            $css[] = 'h1, h2, h3, h4, h5, h6 { color: ' . esc_attr(cs_get_option('heading-color')) . '}';
        }
        // Header Top color
        $header_top_color = cs_get_option('header-top-color');
        if ($header_top_color) {
            $css[] = '
                #the4-header .header__top .the4-social a,
                .the4-socials a,
                .header-text,
                .header-text a,
                .header-text .cr,
                div .the4-currency,
                .header__top .the4-action a {
                    color: ' . esc_attr($header_top_color) . ';
                }
            ';
        }
        // Header color
        if (cs_get_option('header-background')) {
            $css[] = '#the4-header, .the4-my-account ul { background-color: ' . esc_attr(cs_get_option('header-background')) . '}';
        }

        // Header top
        if (cs_get_option('header-top-background')) {
            $css[] = 'div.header__top { background-color: ' . esc_attr(cs_get_option('header-top-background')) . '}';
        }
        if (cs_get_option('header-mid-background')) {
            $css[] = '.header__mid,.home header.header-13 .header__mid > .container { background-color: ' . esc_attr(cs_get_option('header-mid-background')) . '}';
        }
        // Menu color
        if (cs_get_option('main-menu-color')) {
            $css[] = '
                .home[data-elementor-device-mode="desktop"] a.the4-push-menu-btn,
                .home[data-elementor-device-mode="desktop"] .header__mid .header-text,
                .home[data-elementor-device-mode="desktop"] .the4-menu > li > a,
                .home[data-elementor-device-mode="desktop"] #the4-mobile-menu ul > li:hover > a,
                .home[data-elementor-device-mode="desktop"] #the4-mobile-menu ul > li.current-menu-item > a,
                .home[data-elementor-device-mode="desktop"] #the4-mobile-menu ul > li.current-menu-parent > a,
                .home[data-elementor-device-mode="desktop"] #the4-mobile-menu ul > li.current-menu-ancestor > a,
                .home[data-elementor-device-mode="desktop"] #the4-mobile-menu ul > li:hover > .holder,
                .home[data-elementor-device-mode="desktop"] #the4-mobile-menu ul > li.current-menu-item > .holder,
                .home[data-elementor-device-mode="desktop"] #the4-mobile-menu ul > li.current-menu-parent  > .holder,
                .home[data-elementor-device-mode="desktop"] #the4-mobile-menu ul > li.current-menu-ancestor > .holder,
                .home[data-elementor-device-mode="desktop"] the4-menu li.current-product_cat-ancestor > a,
                .home[data-elementor-device-mode="desktop"] .the4-action a,
                 a.the4-push-menu-sibebar-btn,
                .header__mid:not(.header__transparent) a.the4-push-menu-btn,
                .header__mid:not(.header__transparent) .header__mid .header-text,
                .header__mid:not(.header__transparent) .the4-menu > li > a,
                .header__mid:not(.header__transparent) #the4-mobile-menu ul > li:hover > a,
                .header__mid:not(.header__transparent) #the4-mobile-menu ul > li.current-menu-item > a,
                .header__mid:not(.header__transparent) #the4-mobile-menu ul > li.current-menu-parent > a,
                .header__mid:not(.header__transparent) #the4-mobile-menu ul > li.current-menu-ancestor > a,
                .header__mid:not(.header__transparent) #the4-mobile-menu ul > li:hover > .holder,
                .header__mid:not(.header__transparent) #the4-mobile-menu ul > li.current-menu-item > .holder,
                .header__mid:not(.header__transparent) #the4-mobile-menu ul > li.current-menu-parent  > .holder,
                .header__mid:not(.header__transparent) #the4-mobile-menu ul > li.current-menu-ancestor > .holder,
                .header__mid:not(.header__transparent) the4-menu li.current-product_cat-ancestor > a,
                .header__mid:not(.header__transparent) .the4-action a:not(:hover),
                .header-layout-1 .cl_h_search .h_search_btn,
                .header-layout-1 .cl_h_search .mini_search_frm input.search_header__input::-webkit-input-placeholder,
                .header-layout-1 .cl_h_search .mini_search_frm input.search_header__input,
                .header-layout-1 .cl_h_search button.h_search_btn,
                .primary-menu-sidebar li a:not(:hover),
                .header-layout-1 ul.the4-mobilenav-bottom .menu-item-btns a,
                li span.the4-has-children,
                li span.back-to-menu,
                .shop-top-sidebar .widget ul li a:not(:hover){
                     color: ' . esc_attr(cs_get_option('main-menu-color')) . ';
                }
                div .the4-action .bgb{
                    background-color: ' . esc_attr(cs_get_option('main-menu-color')) . ';
                }
            ';
        }
        if (cs_get_option('main-menu-action-count-color')) {
            $css[] = '
                div .the4-action .bgb {
                    color: ' . esc_attr(cs_get_option('main-menu-action-count-color')) . ';
                }
            ';
        }
        if (cs_get_option('main-menu-hover-color')) {
            $css[] = '
                .home[data-elementor-device-mode="desktop"] .the4-menu li.current-menu-ancestor > a:hover,
                .home[data-elementor-device-mode="desktop"] .the4-menu li.current-menu-item > a:hover,
                .home[data-elementor-device-mode="desktop"] .the4-menu li > a:hover,
                .home[data-elementor-device-mode="desktop"] .the4-account-menu a:hover,
                .home[data-elementor-device-mode="desktop"] .the4-action a:hover,
                .header__mid:not(.header__transparent) .the4-menu li.current-menu-ancestor > a:hover,
                .header__mid:not(.header__transparent) .the4-menu li.current-menu-item > a:hover,
                .header__mid:not(.header__transparent) .the4-menu li > a:hover,
                .header__mid:not(.header__transparent) .the4-account-menu a:hover,
                .header__mid:not(.header__transparent) .the4-action a:hover{
                    color: ' . esc_attr(cs_get_option('main-menu-hover-color')) . ';
                }
            ';
        }
        if (cs_get_option('main-menu-active-color')) {
            $css[] = '
                div .the4-menu li.current-menu-ancestor > a,
                div .the4-menu li.current-menu-item > a{
                    color: ' . esc_attr(cs_get_option('main-menu-active-color')) . ';
                }
            ';
        }
        if (cs_get_option('sub-menu-color')) {
            $css[] = '
                div .the4-menu ul a, .the4-account-menu ul a, .the4-menu ul li a {
                    color: ' . esc_attr(cs_get_option('sub-menu-color')) . ';
                }
            ';
        }
        if (cs_get_option('sub-menu-hover-color')) {
            $css[] = '
                div .the4-menu ul li a:hover {
                    color: ' . esc_attr(cs_get_option('sub-menu-hover-color')) . ';
                }
            ';
        }
        if (cs_get_option('sub-menu-background-color')) {
            $css[] = '
                .the4-account-menu ul, .the4-menu > li > ul {
                    background: ' . esc_attr(cs_get_option('sub-menu-background-color')) . ';
                }
            ';
        }
        if (cs_get_option('button-search-background-color')) {
            $css[] = '
                .cl_h_search .h_search_btn {
                    background: ' . esc_attr(cs_get_option('button-search-background-color')) . ';
                }
            ';
        }
        if (cs_get_option('header-cat-background-color')) {
            $css[] = '
                div.header__bot .ha8_cat h5 {
                    background: ' . esc_attr(cs_get_option('header-cat-background-color')) . ';
                }
            ';
        }
        if (cs_get_option('header-bottom-background-color')) {
            $css[] = '
                .header-layout-6 div.header__bot,
                .header-layout-20 div.header__bot {
                    background: ' . esc_attr(cs_get_option('header-bottom-background-color')) . ';
                }
            ';
        }

        //Header Transparent Menu color
        if (cs_get_option('transparent-main-menu-color')) {
            $css[] = '
                .home .header__transparent .the4-menu > li > a {
                    color: ' . esc_attr(cs_get_option('transparent-main-menu-color')) . ';
                }
            ';
        }
        if (cs_get_option('transparent-main-menu-hover-color')) {
            $css[] = '
                .home .header__transparent .the4-menu li > a:hover {
                    color: ' . esc_attr(cs_get_option('transparent-main-menu-hover-color')) . ';
                }
                .home .header-sticky .the4-menu > li > a,
                .header-sticky a.the4-push-menu-btn,
                .home .header-sticky .the4-action a  {
                    color: ' . esc_attr(cs_get_option('sticky-main-menu-color')) . ' !important;
                }
            ';
        }

        //Header Sticky Color
        if (cs_get_option('header-sticky-background')) {
            $css[] = '
                .header-sticky .header__mid {
                    background: ' . esc_attr(cs_get_option('header-sticky-background')) . ';
                }
            ';
        }
        if (cs_get_option('sticky-main-menu-color')) {
            $css[] = '
                .header-sticky .the4-menu > li > a,
                .header-sticky .the4-action a  {
                    color: ' . esc_attr(cs_get_option('sticky-main-menu-color')) . ' !important;
                }
               #the4-header.header-sticky .the4-action .bgb{
                    background-color: ' . esc_attr(cs_get_option('sticky-main-menu-color')) . ' !important;
                }
            ';
        }
        if (cs_get_option('sticky-main-menu-action-count-color')) {
            $css[] = '
                #the4-header.header-sticky .the4-action .bgb {
                    color: ' . esc_attr(cs_get_option('sticky-main-menu-action-count-color')) . ';
                }
            ';
        }
        if (cs_get_option('sticky-main-menu-hover-color')) {
            $css[] = '
                .header-sticky .the4-menu li a:hover,
                .header-sticky .the4-menu li.current-menu-ancestor > a,
                .header-sticky .the4-menu li.current-menu-item > a,
                .header-sticky .the4-action a:hover {
                    color: ' . esc_attr(cs_get_option('sticky-main-menu-hover-color')) . ';
                }
            ';
        }
        if (cs_get_option('sticky-sub-menu-background-color')) {
            $css[] = '
                .header-sticky .the4-account-menu ul,
                .header-sticky .the4-menu > li > ul {
                    background: ' . esc_attr(cs_get_option('sticky-sub-menu-background-color')) . ';
                }
            ';
        }
        if (cs_get_option('sticky-sub-menu-color')) {
            $css[] = '
                .header-sticky .the4-menu ul li a {
                    color: ' . esc_attr(cs_get_option('sticky-sub-menu-color')) . ';
                }
            ';
        }
        if (cs_get_option('sticky-sub-menu-color-hover')) {
            $css[] = '
                .header-sticky .the4-menu ul li a:hover,
                .header-sticky .the4-menu ul li.current-menu-item a,
                .header-sticky .the4-menu ul li.current-menu-ancestor > a {
                    color: ' . esc_attr(cs_get_option('sticky-sub-menu-color-hover')) . ';
                }
            ';
        }

        // Footer color
        if (cs_get_option('footer-background')) {
            $css[] = '
                #the4-footer {
                    background: ' . esc_attr(cs_get_option('footer-background')) . ';
                }
            ';
        }
        if (cs_get_option('footer-bottom-background')) {
            $css[] = '
                footer#the4-footer div.footer__bot {
                    background: ' . esc_attr(cs_get_option('footer-bottom-background')) . ';
                }
            ';
        }
        if (cs_get_option('footer-color')) {
            $css[] = '
                #the4-footer {
                    color: ' . esc_attr(cs_get_option('footer-color')) . ';
                }
            ';
        }

        if (cs_get_option('footer-link-color')) {
            $css[] = '
                footer .footer__top a, .signup-newsletter-form, div.footer__top .signup-newsletter-form .input-text::-webkit-input-placeholder  {
                    color: ' . esc_attr(cs_get_option('footer-link-color')) . ';
                }
            ';
        }
        if (cs_get_option('footer-bottom-link-hover-color')) {
            $css[] = '
                footer .footer__bot a:hover  {
                    color: ' . esc_attr(cs_get_option('footer-bottom-link-hover-color')) . ';
                }
            ';
        }
        if (cs_get_option('footer-bottom-cp-color')) {
            $css[] = '
                footer#the4-footer .footer__bot span.cp {
                    color: ' . esc_attr(cs_get_option('footer-bottom-cp-color')) . ';
                }
            ';
        }
        if (cs_get_option('footer-widget-title-transform')) {
            $css[] = '
                #the4-footer footer__top .widget-title {
                     text-transform: uppercase;
                }
            ';
        }
        if (cs_get_option('footer-newsletter-radius') == false) {
            $css[] = '
                #the4-footer .signup-newsletter-form input.input-text,
                #the4-footer .signup-newsletter-form,
                #the4-footer .signup-newsletter-form .submit-btn {
                     border-radius: 0;
                }
            ';
        }
        if (cs_get_option('footer-bottom-color')) {
            $css[] = '
                        footer .footer__bot{
                            color: ' . esc_attr(cs_get_option('footer-bottom-color')) . ';
                        }
                    ';
        }
        if (cs_get_option('footer-bottom-link-color')) {
            $css[] = '
                        footer .footer__bot a{
                            color: ' . esc_attr(cs_get_option('footer-bottom-link-color')) . ';
                        }
                    ';
        }
        if ( cs_get_option( 'footer-widget-color' ) ) {
            $css[] = '
                footer div.footer__top .widget-title {
                    color: ' . esc_attr( cs_get_option( 'footer-widget-color' ) ) . ';
                }
            ';
        }

        if ( cs_get_option( 'footer-link-hover-color' ) ) {
            $css[] = '
                footer .footer__top a:hover{
                    color: ' . esc_attr( cs_get_option( 'footer-link-hover-color' ) ) . ';
                }
            ';
        }
        if ( cs_get_option( 'footer-bottom-newsletter-color' ) ) {
            $css[] = '
                footer div.footer__top .signup-newsletter-form .submit-btn {
                    background: ' . esc_attr( cs_get_option( 'footer-bottom-newsletter-color' ) ) . ';
                }
            ';
        }

        if( cs_get_option('product-sale-color') ) {
            $css[] = '
                div .badge span {
                    background:'. esc_attr( cs_get_option( 'product-sale-color' ) ) .';
                }
            ';
        }

        if( cs_get_option('product-text-color') ) {
            $css[] = '
                div .badge span {
                    color:'. esc_attr( cs_get_option( 'product-text-color' ) ) .';
                }
            ';
        }

        if( cs_get_option('product-new-color') ) {
            $css[] = '
                div .badge .new {
                    background:'. esc_attr( cs_get_option( 'product-new-color' ) ) .';
                }
            ';
        }

        if( cs_get_option('wc-attr-background') ) {
            $css[] = '
                .product-image .product-attr {
                    background:'. esc_attr( cs_get_option( 'wc-attr-background' ) ) .';
                }
            ';
        }

        //Popup cookie law

        if( cs_get_option('popup-cookie_verify_btn_hover_bg') ) {
            $css[] = '
                a.pp_cookies_accept_btn:focus, a.pp_cookies_accept_btn:hover {
                    background-color:'. esc_attr( cs_get_option( 'popup-cookie_verify_btn_hover_bg' ) ) .';
                }
            ';
        }
        if( cs_get_option('popup-cookie_verify_btn_bg') ) {
            $css[] = '
                .pp_cookies_accept_btn {
                    background-color:'. esc_attr( cs_get_option( 'popup-cookie_verify_btn_bg' ) ) .';
                }
            ';
        }

        //Popup Age verify

        if( cs_get_option('popup-age_verify_bg_color') ) {
            $css[] = '
                .popup_age_wrap {
                    background-color:'. esc_attr( cs_get_option( 'popup-age_verify_bg_color' ) ) .';
                }
            ';
        }
        if( cs_get_option('popup-age_bg_opacity') ) {
            $css[] = '
                .popup_age_wrap::before {
                    opacity:'. esc_attr( cs_get_option( 'popup-age_bg_opacity' ) ) .';
                }
            ';
        }
        if( cs_get_option('popup-age_verify_btn_color') ) {
            $css[] = '
                .age_verify_buttons>a.age_verify_allowed {
                    background-color:'. esc_attr( cs_get_option( 'popup-age_verify_btn_color' ) ) .';
                }
            ';
        }
        if( cs_get_option('popup-age_verify_btn_hover_color') ) {
            $css[] = '
                .age_verify_buttons>a.age_verify_allowed:hover {
                    background-color:'. esc_attr( cs_get_option( 'popup-age_verify_btn_hover_color' ) ) .';
                }
            ';
        }

        //Button config

        //Add to cart btn        
        if ( cs_get_option('wc-summary_btn_color') ) {
             $css[] = the4_kalles_set_btn_color('wc-summary_btn_color', 'wc-summary_btn_opacity', '.product .single_add_to_cart_button');
        }
        //Buy now btn        
        if ( cs_get_option('wc-summary_btn_buynow_color') ) {
             $css[] = the4_kalles_set_btn_color('wc-summary_btn_buynow_color', 'wc-summary_btn_buynow_opacity', '.product .btn-buy-now');
        }
        //Sticky ATC
        if ( cs_get_option('wc-summary_btn_sticky_atc_color') ) {
             $css[] = the4_kalles_set_btn_color('wc-summary_btn_sticky_atc_color', 'wc-summary_btn_sticky_atc_opacity', '.sticky_add_to_cart_btn');
        }
        //Minicart viewcart btn
        if ( cs_get_option('wc-checkout_btn_viewcart_color') ) {
             $css[] = the4_kalles_set_btn_color('wc-checkout_btn_viewcart_color', 'wc-summary_btn_viewcart_opacity', '.woocommerce-mini-cart__buttons .btn.viewcart');
        }
         //Minicart checkout btn
        if ( cs_get_option('wc-checkout_btn_checkout_color') ) {
             $css[] = the4_kalles_set_btn_color('wc-checkout_btn_checkout_color', 'wc-summary_btn_checkout_opacity', '.the4-mini-cart .btn.checkout');
        }
        // Custom css
        if ( cs_get_option( 'custom-css' ) ) {
            $css[] = cs_get_option( 'custom-css' );
        }

        return preg_replace( '/\n|\t/i', '', implode( '', $css ) );
    }
}

/**
 * Set btn color
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'the4_kalles_set_btn_color' ) ) {
    function the4_kalles_set_btn_color( $btn, $btn_opacity, $selector ) {
        $css = '';
        $btn_atc_color = cs_get_option( $btn );
        $opacity = cs_get_option( $btn_opacity ) ? cs_get_option( $btn_opacity ) : 1;

        if ( ! empty( $btn_atc_color ) ) {
            $css = $selector . ' {
                background-color:' . $btn_atc_color['bg'] . ' !important;
                color:' . $btn_atc_color['color'] . ' !important;
                border-color:' . $btn_atc_color['border'] . ' !important;
                border-width: 1px !important;
                border-style: solid !important;
            }';

            $css .= $selector . ':hover {
                background-color:' . $btn_atc_color['bg_hover'] . ' !important;
                color:' . $btn_atc_color['color_hover'] . ' !important;
                opacity:' . $opacity . ' !important;
                border-color:' . $btn_atc_color['border_hover'] . ' !important;
                border-width: 1px !important;
                border-style: solid !important;
            }';
        }

        return $css;
        
    }
}
/**
 * Add custom javascript code
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_custom_js' ) ) {
    function the4_kalles_custom_js( $data = array() ) {
        $data[] = '
            var THE4_AjaxURL = "' . esc_js( admin_url( 'admin-ajax.php' ) ) . '";
            var THE4_SiteURL = "' . get_home_url() . '/index.php' . '";
            var THE4_NONCE = "' . wp_create_nonce('the4-kalles-ajax-sec') . '";
        ';
        $data[] = cs_get_option( 'custom-js' );

        return preg_replace( '/\n|\t/i', '', implode( '', $data ) );
    }
}

/**
 * Get custom data to js.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_custom_data_js' ) ) {
    function the4_kalles_custom_data_js() {
        $data = array(
            'load_more'    => esc_html__( 'Load More', 'kalles' ),
            'no_more_item' => esc_html__( 'No More Items To Show', 'kalles' ),
            'days'         => esc_html__( 'days', 'kalles' ),
            'hrs'          => esc_html__( 'hrs', 'kalles' ),
            'mins'         => esc_html__( 'mins', 'kalles' ),
            'secs'         => esc_html__( 'secs', 'kalles' ),
            'popup_remove' => esc_html__( 'Removed from the cart', 'kalles' ),
            'popup_undo'   => esc_html__( 'Undo?', 'kalles' ),
            'timezone'     => 'not4',
            'order_day'    => 'Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'order_mth'    => 'January,February,March,April,May,June,July,August,September,October,November,December'
        );

        // Header Sticky
        $data['header_sticky'] = cs_get_option( 'header-sticky' );
        // Get option for permalink
        $data['permalink'] = ( get_option( 'permalink_structure' ) == '' ) ? 'plain' : '';

        $data['wc-column'] = ( cs_get_option( 'wc-column' ) !== '' ) ? cs_get_option( 'wc-column' ) : 3;

        $data['portfolio-column'] = ( cs_get_option( 'portfolio-column' ) !== '' ) ? cs_get_option( 'portfolio-column' ) : 3;

        $data['is-zoom'] = cs_get_option( 'wc-single-zoom' );

        $data['wc-sticky-atc'] = ( cs_get_option( 'wc-sticky-atc' ) !== '' ) ? cs_get_option( 'wc-sticky-atc' ) : 0;

        //Wishlist local
        $data['wishlist-local'] = (cs_get_option('wc_general_wishlist-type'));

        //Compare
        $data['compare-local'] = (cs_get_option('wc_general_compare'));

        //Ajax Shop
        $data['ajax_shop'] = (cs_get_option('wc-filter_ajax')) ? cs_get_option('wc-filter_ajax') : 0;
        $data['ajax_url'] =  class_exists( 'WC_AJAX' ) ? \WC_AJAX::get_endpoint( '%%endpoint%%' ) : '';

        //RTL
        $data['is_rtl'] = is_rtl() ? 'true' : 'false';

        //RTL
        $data['header_type'] = cs_get_option( 'header-layout' ) ? cs_get_option( 'header-layout' ) : '3';
        //Free shipping bar
        $data['is_shipping_bar'] = cs_get_option( 'wc_mini_cart_setting-shipping_bar' ) ? 1 : 0;

        //Exist product popup
        $data['exist_product_cat'] = cs_get_option('popup-exist_product_cat') ? 1 : 0;
        
        //LazyLoad
        $data['is_lazy_kalles'] = kalles_image_lazyload_class() ? 'true' : 'false';

        //Config product Zoom
        if ( cs_get_option( 'wc-single-zoom' ) ) {
            $zoom_option = array();
            $zoom_option['zoomType'] = ( cs_get_option( 'wc_cart_zoom-type' ) !== '' ) ? cs_get_option( 'wc_cart_zoom-type' ) : 'inner';
            $zoom_option['cursor'] = ( cs_get_option( 'wc_cart_zoom-cursor_type' ) !== '' ) ? cs_get_option( 'wc_cart_zoom-cursor_type' ) : 'crosshair';

            if ($zoom_option['zoomType'] != 'inner') {
                if (cs_get_option( 'wc_cart_zoom-fade_time' ) != '') {
                    $zoom_option['lensFadeIn'] = (int)cs_get_option( 'wc_cart_zoom-fade_time' );
                    $zoom_option['zoomWindowFadeIn'] = (int)(cs_get_option( 'wc_cart_zoom-fade_time' ) * 1000);
                }
                if (cs_get_option( 'wc_cart_zoom-border_width' ) != 0) {
                    $zoom_option['borderSize'] = (int)cs_get_option( 'wc_cart_zoom-border_width' );
                    $zoom_option['lensBorder'] = (int)cs_get_option( 'wc_cart_zoom-border_width' );
                    $zoom_option['borderColour'] = cs_get_option( 'wc_cart_zoom-border_color' );
                } else {
                     $zoom_option['borderSize'] = $zoom_option['lensBorder'] = 0;
                }


            }
            if ($zoom_option['zoomType'] == 'lens') {

                $zoom_option['containLensZoom'] = true;
                $zoom_option['lensSize'] = ( cs_get_option( 'wc_cart_zoom-lens_size' ) !== '' ) ? (int)cs_get_option( 'wc_cart_zoom-lens_size' ) : 200;
                $zoom_option['lensShape'] = ( cs_get_option( 'wc_cart_zoom-lens_shape' ) !== '' ) ? cs_get_option( 'wc_cart_zoom-lens_shape' ) : 'round';

            }
            if ($zoom_option['zoomType'] == 'window') {
                if (cs_get_option( 'wc_cart_zoom-tint' ) == 1) {
                    $zoom_option['tint'] = true;
                    $data['zoom_tint'] = true;
                    $zoom_option['tintColour'] = ( cs_get_option( 'wc_cart_zoom-tint_color' ) !== '' ) ? cs_get_option( 'wc_cart_zoom-tint_color' ) : '#FFF';
                    $zoom_option['tintOpacity'] = ( cs_get_option( 'wc_cart_zoom-tint_opacity' ) !== '' ) ? (float)cs_get_option( 'wc_cart_zoom-tint_opacity' ) : 0.4;
                }
                $zoom_option['scrollZoom'] = ( cs_get_option( 'wc_cart_zoom-scroll_zoom' ) == 1 ) ? true : false;
                $zoom_option['easing'] = ( cs_get_option( 'wc_cart_zoom-easing' ) == 1 ) ? true : false;
                $zoom_option['zoomWindowWidth'] = ( cs_get_option( 'wc_cart_zoom-window_width' ) !== '' ) ? (int)cs_get_option( 'wc_cart_zoom-window_width' ) : 500;
                $zoom_option['zoomWindowHeight'] = ( cs_get_option( 'wc_cart_zoom-window_height' ) !== '' ) ? (int)cs_get_option( 'wc_cart_zoom-window_height' ) : 500;
            }
            $data['zoom_type'] = $zoom_option['zoomType'];

            //RTL Zoom
            if ( is_rtl() ) {
                $zoom_option['zoomWindowPosition'] = 11;
            }

            $data['zoom_option'] = json_encode($zoom_option);
        }


        return $data;
    }
}

/**
 * Render title of page.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_page_title' ) ) {
    function the4_kalles_page_title() {
        $output = '';

        // Get title of blog list
        $blog_title      = cs_get_option( 'blog-page-title' );
        $portfolio_title = cs_get_option( 'portfolio-page-title' );

        $output .= '<h1 class="tu mb__5 cw" ' . the4_kalles_schema_metadata( array( 'context' => 'entry_title', 'echo' => false ) ) . '>';
        if ( is_page() ) {

            $output .= get_the_title();

        } elseif ( is_home() ) {

            if ( ! empty( $blog_title ) ) {
                $output .= $blog_title;
            } else {
                $output .= esc_html__( 'Article', 'kalles' );
            }

        } elseif ( is_post_type_archive( 'portfolio' ) ) {

            if ( ! empty( $portfolio_title ) ) {
                $output .= $portfolio_title;
            } else {
                $output .= esc_html__( 'Portfolio', 'kalles' );
            }

        } elseif ( is_search() ) {

            $output .= esc_html__( 'Search', 'kalles' );

        } elseif ( is_tax() ) {
            $term = $GLOBALS['wp_query']->get_queried_object();
            $output .= $term->name;
        }
        $output .= '</h1>';

        return apply_filters( 'the4_kalles_page_title', $output );
    }
}

/**
 * Render sub title of page.
 *
 * @return string
 */
if ( ! function_exists( 'the4_kalles_page_sub_title' ) ) {
    function the4_kalles_page_sub_title() {
        $output = '';

        // Get sub title
        if ( is_page() ) {
            $subtitle = get_post_meta( get_the_ID(), '_custom_page_options', true );
            if ( isset( $subtitle['subtitle'] ) && ! $subtitle['subtitle'] ) return;

            $output .= '<p>';
            if ( isset( $subtitle['subtitle'] ) && $subtitle['subtitle'] && ! empty( $subtitle['title'] ) ) {
                $output .= $subtitle['title'];
            }
            $output .= '</p>';
        } elseif ( is_post_type_archive( 'portfolio' ) ) {
            $portfolio_subtitle = cs_get_option( 'portfolio-sub-title' );
            if ( ! empty( $portfolio_subtitle ) ) {
                $output .= '<p>' . esc_html( $portfolio_subtitle ) . '</p>';
            }
        } elseif ( is_tax() ) {
            $output .= category_description();
        }

        return apply_filters( 'the4_kalles_page_sub_title', $output );
    }
}

/**
 * Render page heading for page.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_head_page' ) ) {
    function the4_kalles_head_page() {
        $output = $atts = '';
        $options = get_post_meta( get_the_ID(), '_custom_page_options', true );

        if ( ! is_post_type_archive( 'portfolio' ) && ! is_tax( 'portfolio_cat' ) ) {
            // Get post or page thumbnail
            $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false );

            if ( $image ) {
                $atts = 'style="background: url(' . esc_url( $image[0] ) . ') no-repeat center center / cover;"';
            }
        }

        $output .= '<div class="page-head pr tc" ' . $atts . '>';
        $output .= '<div class="container pr">';
        $output .= the4_kalles_page_title();
        $output .= the4_kalles_page_sub_title();
        if ( isset( $options['breadcrumb'] ) && $options['breadcrumb'] ) {
            $output .= the4_kalles_breadcrumb();
        }

        $output .= '</div>';
        $output .= '</div>';

        return apply_filters( 'the4_kalles_head_page', $output );
    }
}

/**
 * Render page heading for single post.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_head_single' ) ) {
    function the4_kalles_head_single() {
        $output = $atts = '';

        // Get post or page thumbnail
        $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false );

        if ( $image ) {
            $atts = 'style="background: url(' . esc_url( $image[0] ) . ') no-repeat center center / cover;"';
        }

        // Get posted on
        $time = '<time class="entry-date published updated f__libre"' . the4_kalles_schema_metadata( array( 'context' => 'entry_time', 'echo' => false ) ) . '>%2$s</time>';

        // Post categories
        $categories = get_the_category_list( esc_html__( ', ', 'kalles' ) );

        $output .= '<div class="page-head pr tc" ' . $atts . '>';
        $output .= '<div class="container pr">';
        $output .= sprintf( '<h1 class="tu cw" ' . the4_kalles_schema_metadata( array( 'context' => 'entry_title', 'echo' => false ) ) . '>%s</h1>', get_the_title() );
        $output .= '<div class="head-meta pr mt__5">';
        $output .= '<span>' . esc_html__( 'On','kalles' ) . ' ';
        $output .= sprintf( $time,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() )
        );
        $output .= '</span>';
        if ( $categories ) {
            $output .= sprintf( '<span>' . esc_html__( 'In %1$s ', 'kalles' ) . '</span>', $categories );
        }
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

        return apply_filters( 'the4_kalles_head_single', $output );
    }
}

/**
 * Get all registered sidebars.
 *
 * @return  array
 */
function the4_kalles_get_sidebars() {
    global $wp_registered_sidebars;

    // Get custom sidebars.
    $custom_sidebars = get_option( 'kalles_custom_sidebars' );

    // Prepare output.
    $output = array();

    $output[] = esc_html__( 'Select a sidebar', 'kalles' );

    if ( ! empty( $wp_registered_sidebars ) ) {
        foreach ( $wp_registered_sidebars as $sidebar ) {
            $output[ $sidebar['id'] ] = $sidebar['name'];
        }
    }

    if ( ! empty( $custom_sidebars ) ) {
        foreach ( $custom_sidebars as $sidebar ) {
            $output[ $sidebar['id'] ] = $sidebar['name'];
        }
    }


    return $output;
}


/**
 * Setup schema metadata.
 *
 * @param   array  $args  Arguments.
 *
 * @return  void
 */
if ( ! function_exists( 'the4_kalles_schema_metadata' ) ) {
    function the4_kalles_schema_metadata( $args ) {
        // Set default arguments
        $default_args = array(
            'post_type' => '',
            'context'   => '',
            'echo'      => true,
        );

        $args = apply_filters( 'the4_kalles_schema_metadata_args', wp_parse_args( $args, $default_args ) );

        if ( empty( $args['context'] ) ) {
            return;
        }

        // Markup string - stores markup output
        $markup     = ' ';
        $attributes = array();

        // Try to fetch the right markup
        switch ( $args['context'] ) {
            case 'body':
                $attributes['itemscope'] = 'itemscope';
                $attributes['itemtype']  = 'http://schema.org/WebPage';
                break;

            case 'header':
                $attributes['itemscope'] = 'itemscope';
                $attributes['itemtype']  = 'http://schema.org/WPHeader';
                break;

            case 'nav':
                $attributes['role']      = 'navigation';
                $attributes['itemscope'] = 'itemscope';
                $attributes['itemtype']  = 'http://schema.org/SiteNavigationElement';
                break;

            case 'content':
                $attributes['role']     = 'main';
                $attributes['itemprop'] = 'mainContentOfPage';

                // Frontpage, Blog, Archive & Single Post
                if ( is_singular( 'post' ) || is_archive() || is_home() ) {
                    $attributes['itemscope'] = 'itemscope';
                    $attributes['itemtype']  = 'http://schema.org/Blog';
                }

                // Search Results Pages
                if ( is_search() ) {
                    $attributes['itemscope'] = 'itemscope';
                    $attributes['itemtype']  = 'http://schema.org/SearchResultsPage';
                }
                break;

            case 'entry':
                $attributes['itemscope'] = 'itemscope';
                $attributes['itemtype']  = 'http://schema.org/CreativeWork';
                break;

            case 'image':
                $attributes['itemscope'] = 'itemscope';
                $attributes['itemtype']  = 'http://schema.org/ImageObject';
                break;

            case 'image_url':
                $attributes['itemprop'] = 'contentURL';
                break;

            case 'name':
                $attributes['itemprop'] = 'name';
                break;

            case 'email':
                $attributes['itemprop'] = 'email';
                break;

            case 'url':
                $attributes['itemprop'] = 'url';
                break;

            case 'author':
                $attributes['itemprop']  = 'author';
                $attributes['itemscope'] = 'itemscope';
                $attributes['itemtype']  = 'http://schema.org/Person';
                break;

            case 'author_link':
                $attributes['itemprop'] = 'url';
                break;

            case 'author_name':
                $attributes['itemprop'] = 'name';
                break;

            case 'author_description':
                $attributes['itemprop'] = 'description';
                break;

            case 'entry_time':
                $attributes['itemprop'] = 'datePublished';
                $attributes['datetime'] = get_the_time( 'c' );
                break;

            case 'entry_title':
                $attributes['itemprop'] = 'headline';
                break;

            case 'entry_content':
                $attributes['itemprop'] = 'text';
                break;

            case 'comment':
                $attributes['itemprop']  = 'comment';
                $attributes['itemscope'] = 'itemscope';
                $attributes['itemtype']  = 'http://schema.org/Comment';
                break;

            case 'comment_author':
                $attributes['itemprop']  = 'creator';
                $attributes['itemscope'] = 'itemscope';
                $attributes['itemtype']  = 'http://schema.org/Person';
                break;

            case 'comment_author_link':
                $attributes['itemprop']  = 'creator';
                $attributes['itemscope'] = 'itemscope';
                $attributes['itemtype']  = 'http://schema.org/Person';
                $attributes['rel']       = 'external nofollow';
                break;

            case 'comment_time':
                $attributes['itemprop']  = 'commentTime';
                $attributes['itemscope'] = 'itemscope';
                $attributes['datetime']  = get_the_time( 'c' );
                break;

            case 'comment_text':
                $attributes['itemprop'] = 'commentText';
                break;

            case 'sidebar':
                $attributes['role']      = 'complementary';
                $attributes['itemscope'] = 'itemscope';
                $attributes['itemtype']  = 'http://schema.org/WPSideBar';
                break;

            case 'search_form':
                $attributes['itemprop']  = 'potentialAction';
                $attributes['itemscope'] = 'itemscope';
                $attributes['itemtype']  = 'http://schema.org/SearchAction';
                break;

            case 'footer':
                $attributes['itemscope'] = 'itemscope';
                $attributes['itemtype']  = 'http://schema.org/WPFooter';
                break;
        }

        $attributes = apply_filters( 'the4_kalles_schema_metadata_attributes', $attributes, $args );

        // If failed to fetch the attributes - let's stop
        if ( empty( $attributes ) ) {
            return;
        }

        // Cycle through attributes, build tag attribute string
        foreach ( $attributes as $key => $value ) {
            $markup .= $key . '="' . $value . '" ';
        }

        $markup = apply_filters( 'the4_kalles_schema_metadata_output', $markup, $args );

        if ( $args['echo'] ) {
            echo '' . $markup ;
        } else {
            return $markup;
        }
    }
}

/**
 * Setup Header countdown banner
 *
 * @param
 *
 * @return  void
 */
if ( ! function_exists( 'the4_kalles_countdown_banner' ) ) {
    function the4_kalles_countdown_banner() {
        if ( ! cs_get_option( 'header-countdown' ) || ! cs_get_option( 'header-promobar-text' ) ) return;
        $data_text       = cs_get_option( 'header-promobar-text' );
        $date_date       = '<span id="hbanner_cd" data-date="' . cs_get_option( 'header-countdown-date' ) . '"></span>';
        $data_text       = str_replace('[countdown]', $date_date, $data_text);
        $data_ver        = cs_get_option('header-countdown-ver') ? cs_get_option('header-countdown-ver') : 1;
        $data_expires    = cs_get_option('header-countdown-expires') ? cs_get_option('header-countdown-expires') : 30;
        $min_height      = cs_get_option('header-countdown-minheight') ? cs_get_option('header-countdown-minheight') : 44;
        $font_size       = cs_get_option('header-countdown-fontsize') ? cs_get_option('header-countdown-fontsize') : 14;
        $text_color      = cs_get_option('header-promobar-textcolor') ? cs_get_option('header-promobar-textcolor') : '#FFF';
        $background      = cs_get_option('header-promobar-background') ? cs_get_option('header-promobar-background') : '#e91e63';
        $opacity         = cs_get_option('header-promobar-bg_opacity') ? cs_get_option('header-promobar-bg_opacity') : 100;
        $show_close      = cs_get_option('header-promobar-show_close');
        $show_close_icon = cs_get_option('header-promobar-show_close_icon');
        $btn_close_text  = cs_get_option('header-promobar-btn_close_text') ? cs_get_option('header-promobar-btn_close_text') : 'close';
        $btn_close_color = cs_get_option('header-promobar-btn_close_color') ? cs_get_option('header-promobar-btn_close_color') : '#FFF';
        $shop_link       = cs_get_option( 'header-countdown-link' );
        $shop_link_url   = isset( $shop_link['url'] ) ? $shop_link['url'] : '#';
        $shop_link_target   = isset( $shop_link['target'] ) ? $shop_link['target'] : '_blank';

        $output = '';
        $output .= '<section id="kalles_countdown_banner" style="background-color: ' . esc_attr( $background ) .'">
                        <div class="container">
                             <div class="h__banner row middle-xs pt__10 pb__10"
                                  data-ver="' . esc_attr( $data_ver ) . '"
                                  data-date="' . esc_attr( $data_expires ) . '"
                                  style="min-height: ' . esc_attr( $min_height ) .'px; font-size: ' . esc_attr( $font_size ) .'px;  opacity: ' . esc_attr( $opacity ) .'%;"
                                  >
                                <div class="col-auto op__0">
                                    <a href="#" class="h_banner_close pr pl__10 cw z_100">close</a>
                                </div>
                                <a href="' . $shop_link_url . '" class="pa t__0 l__0 r__0 b__0 z_100" target="' . $shop_link_target . '"></a>
                                <div class="col h_banner_wrap tc cw" style="color: ' . esc_attr( $text_color ) .';">
                                    <div class="col h_banner_wrap tc cw" style="color: ' . esc_attr( $text_color ) .';">' .  wp_kses_post( $data_text ) . '</div>
                                </div>';
        if ($show_close) {
            if ($show_close_icon) {
                $output .= '<div class="col-auto">
                             <a href="" class="h_banner_close pr pl__10 cw z_100" style="color: ' . esc_attr( $btn_close_color ) .';"></a>
                        </div>';
            } else {
                $output .= '<div class="col-auto mr__10">
                             <a href="" class="h_banner_close pr pl__10 cw z_100" style="color: ' . esc_attr( $btn_close_color ) .';">' . esc_html( $btn_close_text ) . '</a>
                        </div>';
            }

        }
        $output .=          '</div>
                        </div>
                    </section>';
        return $output;
    }
}

/**
 * Get megamenu post type block.
 *
 * @param   array  $args  Arguments.
 *
 * @return  void
 */
if (! function_exists('kalles_get_megamenu_block')) {
    function kalles_get_megamenu_block() {
        $args = array(
            'posts_per_page' => 100,
            'post_type' => 'megamenu'
        );
        $megamenu_blocks = get_posts($args);
        $results = array();
        if ($megamenu_blocks) {
            foreach ($megamenu_blocks as $block) {
                $results[$block->ID] = $block->post_title;
            }
        }
        return $results;
    }
}


/**
 * Load common template
 *
 *
 * @return  void
 */
if(!function_exists( 'kalles_load_common_template' ))
{
    function kalles_load_common_template()
    {
        if ( ! kalles_is_maintance() ) {
            get_template_part('views/common/mobile-menu');

            get_template_part('views/common/sidebar-hide-menu');

            if ( class_exists( 'WooCommerce' ) ) {
                // Account Login / Register
                $account_type = cs_get_option( 'woocommerce_account-type' ) ? cs_get_option( 'woocommerce_account-type' ) : 'sidebar';

                if ( $account_type == 'sidebar' ) {
                    get_template_part('views/common/account-sidebar');
                } elseif ( $account_type == 'popup' ) {
                    get_template_part('views/common/account-popup');
                }
                
                //Load mini cart
                 if ( ! is_cart() && ! is_checkout() ) {
                    kalles_load_common_mini_cart();
                 }
                 // Woocommere Search
                get_template_part('views/common/woocommere-search');
                // Sale Popup
                if (cs_get_option('popup-sale_enable')){
                    get_template_part('views/common/popup-sale');
                }
            }

            // Age verify Popup
             if (cs_get_option('popup-age_verify_enable')){
                get_template_part('views/common/popup-verify');
             }

            // Cookie Law Popup
             if (cs_get_option('popup-cookie-law_enable')) {
                get_template_part('views/common/popup-cookie-law');
            } 

            // Toolbar Mobile
             if ( cs_get_option('general_mobile_toolbar-enable') ) {
                 get_template_part('views/common/toolbar-mobile');
             }
        }

    }
}
add_action( 'wp_footer', 'kalles_load_common_template' );

/**
 * Load common Mini Cart
 *
 *
 * @return  void
 */
if(!function_exists( 'kalles_load_common_mini_cart' ))
{
    function kalles_load_common_mini_cart()
    {
        $the4_kalles_cart_mode = cs_get_option('wc-cart-cart_type');
        if ( class_exists( 'WooCommerce' ) && cs_get_option('wc-cart-cart_mode') != 'disable') :
            ?>
                <div class="the4-mini-cart the4-push-menu <?php echo esc_attr( $the4_kalles_cart_mode ); ?>">
                    <div class="the4-mini-cart-content flex column h__100">
                        <div class="mini_cart_header flex fl_between al_center">
                            <h3 class="mg__0 tc cb tu ls__2"><?php esc_html_e( 'Shoping Cart', 'kalles' );?> <i class="close-cart pe-7s-close pa cb ts__03"></i></h3>
                        </div>
                        <div class="mini_cart_wrap">
                            <div class="widget_shopping_cart_content"></div>
                        </div>

                        <?php if ( cs_get_option( 'wc-order_note' ) ) : ?>
                        <div class="mini_cart_note pe_none">
                            <label for="CartSpecialInstructions" class="mb__5 dib">
                            <span class="txt_add_note "><?php esc_html_e('Add Order Note', 'kalles'); ?></span>
                            <span class="txt_edit_note dn"><?php esc_html_e('Edit Order Note', 'kalles'); ?></span></label>
                            <textarea name="note" id="CartSpecialInstructions" placeholder="<?php esc_attr_e('How can i help you?', 'kalles'); ?>"></textarea>
                            <a href="#" class="pr button btn_back js_cart_save_note mt__15 mb__10">
                                <?php esc_html_e('Save', 'kalles'); ?>
                            </a>
                            <a href="#" class="button btn_back btn_back2 js_cart_tls_back"> <?php esc_html_e('Cancel', 'kalles'); ?></a>
                        </div> <!-- .mini_cart_note -->
                        <?php endif; ?>
                        <?php if ( cs_get_option( 'wc-coupon' ) ) : ?>

                        <div class="mini_cart_dis pe_none">
                            <div class="the4_coupon_content">
                                <h3><?php esc_html_e('Add A Coupon', 'kalles'); ?></h3>
                                <p class="the4_coupon_result"><?php esc_html_e('Enter coupon code here', 'kalles'); ?></p>
                                <p class="field">
                                    <input type="text" name="discount" id="the4_coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'kalles'); ?>">
                                </p>
                                <p class="field">
                                    <a href="#" class="button btn_back js_cart_save_dis pr"><span><?php esc_html_e('Save', 'kalles'); ?></span></a>
                                </p>
                                <a href="#" class="button btn_back btn_back2 js_cart_tls_back"><?php esc_html_e('Cancel', 'kalles'); ?></a>
                            </div>
                        </div> <!-- .mini_cart_dis -->
                        <?php endif; ?>
                        <?php if ( cs_get_option( 'wc-estimate-shipping' ) ) : ?>

                        <div class="mini_cart_ship pe_none">
                            <?php wp_enqueue_script( 'wc-country-select' ) ?>
                            <?php get_template_part('views/common/minicart-shiping'); ?>
                        </div> <!-- .mini_cart_ship -->
                        <?php endif; ?>
                        <?php if ( cs_get_option( 'wc-giftwrap' ) ) : ?>
                        <div class="mini_cart_gift pe_none">
                            <?php get_template_part('views/common/minicart-gift'); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div><!-- .the4-mini-cart -->
            <?php endif;
    }
}
/**
 * Check is Pjax request
 *
 *
 * @return  void
 */

if ( ! function_exists( 'kalles_is_pjax_request' ) )
{
    function kalles_is_pjax_request()
    {
        return wp_doing_ajax();
    }
}

/**
 * Add class to loadmore button
 *
 *
 * @return  void
 */
if ( ! function_exists( 'kalles_posts_link_attributes' ) )
{
    function kalles_posts_link_attributes() {
      return 'class="pr nt_cat_lm button"';
    }
    add_filter('next_posts_link_attributes', 'kalles_posts_link_attributes');
    add_filter('previous_posts_link_attributes', 'kalles_posts_link_attributes');
}


/**
 * Add the4-lazyload class for Kalles Lazy load
 *
 *
 * @return  void
 */
if(!function_exists( 'kalles_image_lazyload_class' ))
{
    function kalles_image_lazyload_class($class = true) {
        if ( $class == true ) {
            return ( cs_get_option('general_lazyload-enable') && cs_get_option('general_lazyload-type') == 'kalles'  && ! is_admin() ) ? esc_attr( 'the4-lazyload' ) : '';
        } else {
            return ( cs_get_option('general_lazyload-enable') && cs_get_option('general_lazyload-type') == 'kalles' ) && ! is_admin() ? true : false;
        }

    }
}

/**
 * Check if Elementor is running
 *
 *
 * @return  bool
 */

if ( ! function_exists( 'kalles_is_elementor' ))
{
    function kalles_is_elementor() {
        return did_action( 'elementor/loaded' );
    }
}

/**
 * Check if Elementor is running
 *
 *
 * @return  bool
 */

if ( ! function_exists( 'kalles_is_woocommerce' ) )
{
    function kalles_is_woocommerce() {
        return class_exists( 'WooCommerce' );
    }
}

/**
 * Check if Dokan is running
 *
 *
 * @return  bool
 */

if ( ! function_exists( 'kalles_is_dokan' ) )
{
    function kalles_is_dokan() {
        return class_exists( 'WeDevs_Dokan' );
    }
}

/**
 * Get mailchimp form list
 *
 *
 * @return  bool
 */

if ( ! function_exists( 'kalles_get_mailchimp_form_list' ) )
{
    function kalles_get_mailchimp_form_list() {
        $list_forms = get_posts(
            array(
                'post_type'   => 'mc4wp-form',
                'numberposts' => -1
            )
        );

        $lists = array();

        if ( !empty( $list_forms ) ) {
            foreach( $list_forms as $form ) {
                $lists[ $form->ID ] = $form->post_title;
            }
        }

        return $lists;
    }
}


/**
 * Get Payment icon SVG list
 *
 *
 * @return  Array
 */

if ( ! function_exists( 'kalles_get_payment_icon_svg' ) )
{
    function kalles_get_payment_icon_svg( $svg_width = 68, $svg_height = 50 ) {
        return array(
            'american_express' => '<svg xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 38 24" width="'. $svg_width .'" height="'. $svg_height .'" aria-labelledby="pi-american_express"><title id="pi-american_express">American Express</title><g fill="none"><path fill="#000" d="M35,0 L3,0 C1.3,0 0,1.3 0,3 L0,21 C0,22.7 1.4,24 3,24 L35,24 C36.7,24 38,22.7 38,21 L38,3 C38,1.3 36.6,0 35,0 Z" opacity=".07"/><path fill="#006FCF" d="M35,1 C36.1,1 37,1.9 37,3 L37,21 C37,22.1 36.1,23 35,23 L3,23 C1.9,23 1,22.1 1,21 L1,3 C1,1.9 1.9,1 3,1 L35,1"/><path fill="#FFF" d="M8.971,10.268 L9.745,12.144 L8.203,12.144 L8.971,10.268 Z M25.046,10.346 L22.069,10.346 L22.069,11.173 L24.998,11.173 L24.998,12.412 L22.075,12.412 L22.075,13.334 L25.052,13.334 L25.052,14.073 L27.129,11.828 L25.052,9.488 L25.046,10.346 L25.046,10.346 Z M10.983,8.006 L14.978,8.006 L15.865,9.941 L16.687,8 L27.057,8 L28.135,9.19 L29.25,8 L34.013,8 L30.494,11.852 L33.977,15.68 L29.143,15.68 L28.065,14.49 L26.94,15.68 L10.03,15.68 L9.536,14.49 L8.406,14.49 L7.911,15.68 L4,15.68 L7.286,8 L10.716,8 L10.983,8.006 Z M19.646,9.084 L17.407,9.084 L15.907,12.62 L14.282,9.084 L12.06,9.084 L12.06,13.894 L10,9.084 L8.007,9.084 L5.625,14.596 L7.18,14.596 L7.674,13.406 L10.27,13.406 L10.764,14.596 L13.484,14.596 L13.484,10.661 L15.235,14.602 L16.425,14.602 L18.165,10.673 L18.165,14.603 L19.623,14.603 L19.647,9.083 L19.646,9.084 Z M28.986,11.852 L31.517,9.084 L29.695,9.084 L28.094,10.81 L26.546,9.084 L20.652,9.084 L20.652,14.602 L26.462,14.602 L28.076,12.864 L29.624,14.602 L31.499,14.602 L28.987,11.852 L28.986,11.852 Z"/></g></svg>',
            'amazon_payments' => '<svg xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 38 24" width="'. $svg_width .'" height="'. $svg_height .'" aria-labelledby="pi-amazon"><title id="pi-amazon">Amazon</title><path d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z" fill="#000" fill-rule="nonzero" opacity=".07"/><path d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32" fill="#FFF" fill-rule="nonzero"/><path d="M25.26 16.23c-1.697 1.48-4.157 2.27-6.275 2.27-2.97 0-5.644-1.3-7.666-3.463-.16-.17-.018-.402.173-.27 2.183 1.504 4.882 2.408 7.67 2.408 1.88 0 3.95-.46 5.85-1.416.288-.145.53.222.248.47v.001zm.706-.957c-.216-.328-1.434-.155-1.98-.078-.167.024-.193-.148-.043-.27.97-.81 2.562-.576 2.748-.305.187.272-.047 2.16-.96 3.063-.14.138-.272.064-.21-.12.205-.604.664-1.96.446-2.29h-.001z" fill="#F90" fill-rule="nonzero"/><path d="M21.814 15.291c-.574-.498-.676-.73-.993-1.205-.947 1.012-1.618 1.315-2.85 1.315-1.453 0-2.587-.938-2.587-2.818 0-1.467.762-2.467 1.844-2.955.94-.433 2.25-.51 3.25-.628v-.235c0-.43.033-.94-.208-1.31-.212-.333-.616-.47-.97-.47-.66 0-1.25.353-1.392 1.085-.03.163-.144.323-.3.33l-1.677-.187c-.14-.033-.296-.153-.257-.38.386-2.125 2.223-2.766 3.867-2.766.84 0 1.94.234 2.604.9.842.82.762 1.918.762 3.11v2.818c0 .847.335 1.22.65 1.676.113.164.138.36-.003.482-.353.308-.98.88-1.326 1.2a.367.367 0 0 1-.414.038zm-1.659-2.533c.34-.626.323-1.214.323-1.918v-.392c-1.25 0-2.57.28-2.57 1.82 0 .782.386 1.31 1.05 1.31.487 0 .922-.312 1.197-.82z" fill="#221F1F"/></svg>',
            'apple_pay' => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" role="img" x="0" y="0" width="'. $svg_width .'" height="'. $svg_height .'" viewBox="0 0 165.521 105.965" xml:space="preserve" aria-labelledby="pi-apple_pay"><title id="pi-apple_pay">Apple Pay</title><path fill="#000" d="M150.698 0H14.823c-.566 0-1.133 0-1.698.003-.477.004-.953.009-1.43.022-1.039.028-2.087.09-3.113.274a10.51 10.51 0 0 0-2.958.975 9.932 9.932 0 0 0-4.35 4.35 10.463 10.463 0 0 0-.975 2.96C.113 9.611.052 10.658.024 11.696a70.22 70.22 0 0 0-.022 1.43C0 13.69 0 14.256 0 14.823v76.318c0 .567 0 1.132.002 1.699.003.476.009.953.022 1.43.028 1.036.09 2.084.275 3.11a10.46 10.46 0 0 0 .974 2.96 9.897 9.897 0 0 0 1.83 2.52 9.874 9.874 0 0 0 2.52 1.83c.947.483 1.917.79 2.96.977 1.025.183 2.073.245 3.112.273.477.011.953.017 1.43.02.565.004 1.132.004 1.698.004h135.875c.565 0 1.132 0 1.697-.004.476-.002.952-.009 1.431-.02 1.037-.028 2.085-.09 3.113-.273a10.478 10.478 0 0 0 2.958-.977 9.955 9.955 0 0 0 4.35-4.35c.483-.947.789-1.917.974-2.96.186-1.026.246-2.074.274-3.11.013-.477.02-.954.022-1.43.004-.567.004-1.132.004-1.699V14.824c0-.567 0-1.133-.004-1.699a63.067 63.067 0 0 0-.022-1.429c-.028-1.038-.088-2.085-.274-3.112a10.4 10.4 0 0 0-.974-2.96 9.94 9.94 0 0 0-4.35-4.35A10.52 10.52 0 0 0 156.939.3c-1.028-.185-2.076-.246-3.113-.274a71.417 71.417 0 0 0-1.431-.022C151.83 0 151.263 0 150.698 0z"/><path fill="#FFF" d="M150.698 3.532l1.672.003c.452.003.905.008 1.36.02.793.022 1.719.065 2.583.22.75.135 1.38.34 1.984.648a6.392 6.392 0 0 1 2.804 2.807c.306.6.51 1.226.645 1.983.154.854.197 1.783.218 2.58.013.45.019.9.02 1.36.005.557.005 1.113.005 1.671v76.318c0 .558 0 1.114-.004 1.682-.002.45-.008.9-.02 1.35-.022.796-.065 1.725-.221 2.589a6.855 6.855 0 0 1-.645 1.975 6.397 6.397 0 0 1-2.808 2.807c-.6.306-1.228.511-1.971.645-.881.157-1.847.2-2.574.22-.457.01-.912.017-1.379.019-.555.004-1.113.004-1.669.004H14.801c-.55 0-1.1 0-1.66-.004a74.993 74.993 0 0 1-1.35-.018c-.744-.02-1.71-.064-2.584-.22a6.938 6.938 0 0 1-1.986-.65 6.337 6.337 0 0 1-1.622-1.18 6.355 6.355 0 0 1-1.178-1.623 6.935 6.935 0 0 1-.646-1.985c-.156-.863-.2-1.788-.22-2.578a66.088 66.088 0 0 1-.02-1.355l-.003-1.327V14.474l.002-1.325a66.7 66.7 0 0 1 .02-1.357c.022-.792.065-1.717.222-2.587a6.924 6.924 0 0 1 .646-1.981c.304-.598.7-1.144 1.18-1.623a6.386 6.386 0 0 1 1.624-1.18 6.96 6.96 0 0 1 1.98-.646c.865-.155 1.792-.198 2.586-.22.452-.012.905-.017 1.354-.02l1.677-.003h135.875"/><g><g><path fill="#000" d="M43.508 35.77c1.404-1.755 2.356-4.112 2.105-6.52-2.054.102-4.56 1.355-6.012 3.112-1.303 1.504-2.456 3.959-2.156 6.266 2.306.2 4.61-1.152 6.063-2.858"/><path fill="#000" d="M45.587 39.079c-3.35-.2-6.196 1.9-7.795 1.9-1.6 0-4.049-1.8-6.698-1.751-3.447.05-6.645 2-8.395 5.1-3.598 6.2-.95 15.4 2.55 20.45 1.699 2.5 3.747 5.25 6.445 5.151 2.55-.1 3.549-1.65 6.647-1.65 3.097 0 3.997 1.65 6.696 1.6 2.798-.05 4.548-2.5 6.247-5 1.95-2.85 2.747-5.6 2.797-5.75-.05-.05-5.396-2.101-5.446-8.251-.05-5.15 4.198-7.6 4.398-7.751-2.399-3.548-6.147-3.948-7.447-4.048"/></g><g><path fill="#000" d="M78.973 32.11c7.278 0 12.347 5.017 12.347 12.321 0 7.33-5.173 12.373-12.529 12.373h-8.058V69.62h-5.822V32.11h14.062zm-8.24 19.807h6.68c5.07 0 7.954-2.729 7.954-7.46 0-4.73-2.885-7.434-7.928-7.434h-6.706v14.894z"/><path fill="#000" d="M92.764 61.847c0-4.809 3.665-7.564 10.423-7.98l7.252-.442v-2.08c0-3.04-2.001-4.704-5.562-4.704-2.938 0-5.07 1.507-5.51 3.82h-5.252c.157-4.86 4.731-8.395 10.918-8.395 6.654 0 10.995 3.483 10.995 8.89v18.663h-5.38v-4.497h-.13c-1.534 2.937-4.914 4.782-8.579 4.782-5.406 0-9.175-3.222-9.175-8.057zm17.675-2.417v-2.106l-6.472.416c-3.64.234-5.536 1.585-5.536 3.95 0 2.288 1.975 3.77 5.068 3.77 3.95 0 6.94-2.522 6.94-6.03z"/><path fill="#000" d="M120.975 79.652v-4.496c.364.051 1.247.103 1.715.103 2.573 0 4.029-1.09 4.913-3.899l.52-1.663-9.852-27.293h6.082l6.863 22.146h.13l6.862-22.146h5.927l-10.216 28.67c-2.34 6.577-5.017 8.735-10.683 8.735-.442 0-1.872-.052-2.261-.157z"/></g></g></svg>',
            'bitcoin' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38 24" width="'. $svg_width .'" height="'. $svg_height .'" role="img" aria-labelledby="pi-bitcoin"><title id="pi-bitcoin">Bitcoin</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"/><path fill="#EDA024" d="M21.6 4.4c-4.2-1.4-8.7.8-10.2 5s.8 8.7 5 10.2 8.7-.8 10.2-5c1.4-4.2-.8-8.7-5-10.2z"/><path fill="#fff" d="M16.1 8.3l.3-1c.6.2 1.3.4 1.9.7.2-.5.4-1 .5-1.6l.9.3-.5 1.5.8.3.5-1.5.9.3c-.2.5-.4 1-.5 1.6l.4.2c.3.2.6.4.9.7.3.3.4.6.5 1 0 .3 0 .6-.2.9-.2.5-.5.8-1.1.9h-.2c.2.1.3.2.4.4.4.4.5.8.4 1.4 0 .1 0 .2-.1.3 0 .1 0 .1-.1.2-.1.2-.2.3-.2.5-.3.5-.8.9-1.5.9-.5 0-1 0-1.4-.1l-.4-.1c-.2.5-.4 1-.5 1.6l-.9-.3c.2-.5.4-1 .5-1.5l-.8-.3c-.2.5-.4 1-.5 1.5l-.9-.3c.2-.5.4-1 .5-1.6l-1.9-.6.6-1.1c.2.1.5.2.7.2.2.1.4 0 .5-.2L17 9.3v-.1c0-.3-.1-.5-.4-.5 0-.2-.2-.3-.5-.4zm1.2 6c.5.2.9.3 1.3.4.3.1.5.1.8.1.2 0 .3 0 .5-.1.5-.3.6-1 .2-1.4l-.6-.5c-.3-.2-.7-.3-1.1-.4-.1 0-.3-.1-.4-.2l-.7 2.1zm1-3.1c.3.1.5.2.7.2.3.1.6.2.9.1.4 0 .7-.1.8-.5.1-.3.1-.6 0-.8-.1-.2-.3-.3-.5-.4-.3-.2-.6-.3-1-.4l-.3-.1c-.1.7-.4 1.3-.6 1.9z"/></svg>',
            'dankort' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38 24" width="'. $svg_width .'" height="'. $svg_height .'" role="img" aria-labelledby="pi-dankort"><title id="pi-dankort">Dankort</title><path d="M3 0C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3H3z" fill="#D8232A"/><path d="M27.144 6c-.15.062-3.395 5.163-3.395 5.163L24 6h-7s-.357 3.054-.445 4.482C16.22 8.85 13.635 6 10.04 6H0v12h10.527c1.953 0 3.778-1.236 4.892-3.028.4-.657.71-1.338.98-2.04-.135 1.632-.202 3.413-.38 5.068 2.383-.023 7.373 0 7.373 0 .044-2.04.29-6.293.29-6.293L27.86 18H37c-1.746-2.037-3.537-4.44-5.076-6.627l.023-.095C33.56 9.494 35.214 7.6 37 6h-9.856zM5.128 14v-3.99c1.33.1 4.803-.066 4.803 1.995 0 2.06-3.477 1.933-4.802 1.995z" fill="#fff"/><path d="M.5 6.5v11" stroke="#e5e5e5"/></svg>',
            'diners_club' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38 24" role="img" width="'. $svg_width .'" height="'. $svg_height .'" aria-labelledby="pi-diners_club"><title id="pi-diners_club">Diners Club</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"/><path d="M12 12v3.7c0 .3-.2.3-.5.2-1.9-.8-3-3.3-2.3-5.4.4-1.1 1.2-2 2.3-2.4.4-.2.5-.1.5.2V12zm2 0V8.3c0-.3 0-.3.3-.2 2.1.8 3.2 3.3 2.4 5.4-.4 1.1-1.2 2-2.3 2.4-.4.2-.4.1-.4-.2V12zm7.2-7H13c3.8 0 6.8 3.1 6.8 7s-3 7-6.8 7h8.2c3.8 0 6.8-3.1 6.8-7s-3-7-6.8-7z" fill="#3086C8"/></svg>',
            'discover' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38 24" width="'. $svg_width .'" height="'. $svg_height .'" role="img" aria-labelledby="pi-discover" fill="none"><title id="pi-discover">Discover</title><path fill="#000" opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32z" fill="#fff"/><path d="M3.57 7.16H2v5.5h1.57c.83 0 1.43-.2 1.96-.63.63-.52 1-1.3 1-2.11-.01-1.63-1.22-2.76-2.96-2.76zm1.26 4.14c-.34.3-.77.44-1.47.44h-.29V8.1h.29c.69 0 1.11.12 1.47.44.37.33.59.84.59 1.37 0 .53-.22 1.06-.59 1.39zm2.19-4.14h1.07v5.5H7.02v-5.5zm3.69 2.11c-.64-.24-.83-.4-.83-.69 0-.35.34-.61.8-.61.32 0 .59.13.86.45l.56-.73c-.46-.4-1.01-.61-1.62-.61-.97 0-1.72.68-1.72 1.58 0 .76.35 1.15 1.35 1.51.42.15.63.25.74.31.21.14.32.34.32.57 0 .45-.35.78-.83.78-.51 0-.92-.26-1.17-.73l-.69.67c.49.73 1.09 1.05 1.9 1.05 1.11 0 1.9-.74 1.9-1.81.02-.89-.35-1.29-1.57-1.74zm1.92.65c0 1.62 1.27 2.87 2.9 2.87.46 0 .86-.09 1.34-.32v-1.26c-.43.43-.81.6-1.29.6-1.08 0-1.85-.78-1.85-1.9 0-1.06.79-1.89 1.8-1.89.51 0 .9.18 1.34.62V7.38c-.47-.24-.86-.34-1.32-.34-1.61 0-2.92 1.28-2.92 2.88zm12.76.94l-1.47-3.7h-1.17l2.33 5.64h.58l2.37-5.64h-1.16l-1.48 3.7zm3.13 1.8h3.04v-.93h-1.97v-1.48h1.9v-.93h-1.9V8.1h1.97v-.94h-3.04v5.5zm7.29-3.87c0-1.03-.71-1.62-1.95-1.62h-1.59v5.5h1.07v-2.21h.14l1.48 2.21h1.32l-1.73-2.32c.81-.17 1.26-.72 1.26-1.56zm-2.16.91h-.31V8.03h.33c.67 0 1.03.28 1.03.82 0 .55-.36.85-1.05.85z" fill="#231F20"/><path d="M20.16 12.86a2.931 2.931 0 100-5.862 2.931 2.931 0 000 5.862z" fill="url(#pi-paint0_linear)"/><path opacity=".65" d="M20.16 12.86a2.931 2.931 0 100-5.862 2.931 2.931 0 000 5.862z" fill="url(#pi-paint1_linear)"/><path d="M36.57 7.506c0-.1-.07-.15-.18-.15h-.16v.48h.12v-.19l.14.19h.14l-.16-.2c.06-.01.1-.06.1-.13zm-.2.07h-.02v-.13h.02c.06 0 .09.02.09.06 0 .05-.03.07-.09.07z" fill="#231F20"/><path d="M36.41 7.176c-.23 0-.42.19-.42.42 0 .23.19.42.42.42.23 0 .42-.19.42-.42 0-.23-.19-.42-.42-.42zm0 .77c-.18 0-.34-.15-.34-.35 0-.19.15-.35.34-.35.18 0 .33.16.33.35 0 .19-.15.35-.33.35z" fill="#231F20"/><path d="M37 12.984S27.09 19.873 8.976 23h26.023a2 2 0 002-1.984l.024-3.02L37 12.985z" fill="#F48120"/><defs><linearGradient id="pi-paint0_linear" x1="21.657" y1="12.275" x2="19.632" y2="9.104" gradientUnits="userSpaceOnUse"><stop stop-color="#F89F20"/><stop offset=".25" stop-color="#F79A20"/><stop offset=".533" stop-color="#F68D20"/><stop offset=".62" stop-color="#F58720"/><stop offset=".723" stop-color="#F48120"/><stop offset="1" stop-color="#F37521"/></linearGradient><linearGradient id="pi-paint1_linear" x1="21.338" y1="12.232" x2="18.378" y2="6.446" gradientUnits="userSpaceOnUse"><stop stop-color="#F58720"/><stop offset=".359" stop-color="#E16F27"/><stop offset=".703" stop-color="#D4602C"/><stop offset=".982" stop-color="#D05B2E"/></linearGradient></defs></svg>',
            'dogecoin' => '<svg xmlns="http://www.w3.org/2000/svg" width="'. $svg_width .'" height="'. $svg_height .'" viewBox="-36 25 38 24" role="img" aria-labelledby="pi-dogecoin"><title id="pi-dogecoin">Dogecoin</title><path fill="#fff" d="M-.283 48.947H-33.44a1.94 1.94 0 0 1-1.934-1.934V27.842a1.94 1.94 0 0 1 1.934-1.934H-.283a1.94 1.94 0 0 1 1.934 1.934v19.171a1.94 1.94 0 0 1-1.934 1.934z"/><path fill="#A7A8AB" d="M-.298 49.427h-33.128c-1.344 0-2.436-1.077-2.436-2.4v-19.2c0-1.323 1.092-2.4 2.436-2.4H-.298c1.344 0 2.436 1.077 2.436 2.4v19.2c0 1.323-1.092 2.4-2.436 2.4zm-33.128-23.04c-.806 0-1.462.646-1.462 1.44v19.2c0 .794.656 1.44 1.462 1.44H-.298c.806 0 1.462-.646 1.462-1.44v-19.2c0-.794-.656-1.44-1.462-1.44h-33.128z" opacity=".25"/><circle fill="#CBA747" cx="-17" cy="37" r="7.669"/><path fill="#fff" d="M-12.586 36.004c-.295-1.753-1.7-2.648-2.411-2.878-.711-.227-5.413-.133-5.413-.133-.106.13-.041 1.898-.041 1.898l1.071-.006.021 1.358h-.924a.105.105 0 0 0-.106.106v1.34c0 .059.047.106.106.106h.939c.003.723-.006 1.302-.035 1.313-.08.032-.95-.044-1.036.015-.083.056-.038 1.104-.038 1.505-.003.401.106.384.106.384 4.985-.127 4.864.331 6.269-.511 1.405-.841 1.792-2.742 1.493-4.498zm-5.308 3.099v-1.325l1.601.017a.108.108 0 0 0 .109-.106v-1.34a.108.108 0 0 0-.109-.106l-1.601.003v-1.479s3.666-.406 3.666 2.343c0 2.642-3.666 1.993-3.666 1.993z"/></svg>',
            'dwolla' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38 24" width="'. $svg_width .'" height="'. $svg_height .'" role="img" aria-labelledby="pi-dwolla"><title id="pi-dwolla">Dwolla</title><path fill="#F37421" d="M38 22.5a1.5 1.5 0 0 1-1.5 1.5h-35A1.5 1.5 0 0 1 0 22.5v-21A1.5 1.5 0 0 1 1.5 0h35A1.5 1.5 0 0 1 38 1.5v21z"/><path d="M13.06 10.72c-.34-.37-.85-.56-1.53-.57H9.98v4.47h1.55c.68-.02 1.19-.21 1.53-.58.35-.36.52-.92.52-1.66s-.17-1.29-.52-1.66zm-.14 2.47c-.06.22-.16.39-.29.53s-.3.23-.51.3c-.2.06-.44.09-.73.09h-.8v-3.39h.8c.29 0 .53.03.73.09.21.07.38.16.51.3s.23.31.29.53c.06.21.1.47.1.78 0 .3-.03.56-.1.77zm-4.79-.92c-.26-.38-.58-.72-.87-1.09-.29-.38-.6-.75-.81-1.18-.3-.61-.36-1.46.44-2.03L4.51 9.05c-.54.25-.8.69-.79 1.29.01.57.25 1.06.6 1.49.33.41.67.8 1.02 1.2l.07.09.01.01-.57.26-.4.18c-.72.32-.97.94-.67 1.71.18.46.59.75 1.07.75l.31-.04.01-.01c.12-.04.21-.09.3-.15.79-.35 1.57-.71 2.34-1.08.51-.25.71-.71.72-1.26.01-.46-.14-.84-.4-1.22zm-3.04 3.46l-.24.03c-.37 0-.68-.22-.82-.58-.25-.63-.06-1.1.53-1.37l.4-.18c.2-.09.4-.19.61-.27l.04-.02.21.33c.11.21.19.46.17.74-.03.48-.29 1.07-.9 1.32zm18.45-4.23c-.09-.28-.22-.53-.39-.74-.18-.22-.4-.39-.66-.52-.26-.12-.57-.19-.92-.19-.35 0-.66.07-.93.19-.26.13-.48.3-.66.52-.17.21-.3.46-.39.74-.09.28-.13.57-.13.88s.04.61.13.88c.09.28.22.53.39.74.18.22.4.39.66.51.27.13.58.19.93.19.35 0 .66-.06.92-.19.26-.12.48-.29.66-.51.17-.21.3-.45.39-.74.09-.27.13-.57.13-.88s-.04-.6-.13-.88zm-.71 1.44c-.06.19-.14.36-.25.52-.11.15-.25.28-.42.37-.17.09-.38.14-.62.14s-.45-.05-.62-.14c-.17-.09-.32-.22-.43-.37-.11-.16-.19-.33-.24-.52-.05-.2-.08-.4-.08-.6 0-.2.03-.4.08-.59s.14-.37.24-.52c.11-.15.26-.28.43-.37.17-.09.38-.14.62-.14s.45.05.62.14c.17.09.31.22.42.37.11.15.19.33.25.52.05.19.08.39.08.59 0 .2-.03.4-.08.6zm9.76-2.79h-.76l-1.64 3.93h-2.03v-3.93h-.59v4.47h3.2l.54-1.39h1.81l.46 1.39h.77l-1.76-4.47zm-1.15 2.71l.83-2.12.65 2.12h-1.48zm-11.92-2.7l-1.23 4.47h-.46v-.01h-.16l-1.06-3.71-1.05 3.72h-.46v-.01h-.17l-1.24-4.47h.46v.01h.17l.94 3.63 1.01-3.64h.53v.01h.16l1.02 3.63.95-3.64h.42v.01zm7.62 3.92v.54h-2.93v-4.47h.66v3.93z" fill="#fff"/></svg>',
            'forbrugsforeningen' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38 24" width="'. $svg_width .'" height="'. $svg_height .'" role="img" aria-labelledby="pi-forbrugsforeningen"><title id="pi-forbrugsforeningen">Forbrugsforeningen</title><path d="M3 0C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3H3z" fill="#0076BC"/><path d="M17 1S7.427-1.002 7.078 6.99v9.514c0 1.417-3.078 1.38-3.078 1.38V23s7.03 2.267 8.127-5.104c.177-1.268 0-8.06 0-8.678 0-.62-.783-5.48 4.873-4.103V1z" fill="#fff"/><path fill="#fff" d="M0 9h17v4H0z"/><path d="M.5 9.5v3" stroke="#E5E5E5"/></svg>',
            'terac' => '<svg xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="pi-interac" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414" version="1.1" width="'. $svg_width .'" height="'. $svg_height .'" viewBox="0 0 38 24" xml:space="preserve"><title id="pi-interac">Interac</title><path d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z" fill-opacity=".07"/><path d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32" fill="#fff"/><path d="M11.453 3.104h15.095c.828 0 1.51.681 1.51 1.51v15.095c0 .828-.682 1.51-1.51 1.51H11.453c-.828 0-1.51-.682-1.51-1.51V4.614c0-.828.682-1.51 1.51-1.51z" fill="#fdb913"/><path d="M20.057 12.357l-.001-3.243.846-.201v.425s.22-.56.729-.69a.493.493 0 0 1 .235-.015v.828a1.187 1.187 0 0 0-.444.092c-.312.123-.47.393-.47.805v1.79l-.895.209zm-4.462 1.055s-.138-.207-.138-.937v-1.614l-.436.103V10.3l.437-.103V9.47l.9-.213v.725l.636-.15v.664l-.636.15v1.645c0 .748.198.891.198.891l-.961.229v.001zm1.493-1.93c0-.576.082-.997.259-1.32.21-.383.553-.633 1.054-.747.988-.224 1.344.36 1.33 1.144-.005.28-.004.417-.004.417l-1.74.409v.028c0 .548.115.807.463.734.3-.063.383-.251.406-.483.004-.038.006-.133.006-.133l.815-.195s.002.066 0 .141c-.006.311-.097 1.083-1.23 1.351-1.073.255-1.359-.4-1.359-1.346m1.35-1.463c-.289.066-.44.349-.447.817l.876-.208.001-.141c-.001-.354-.11-.54-.43-.468m6.475-.434c-.034-.987.222-1.771 1.324-2.02.703-.16.97.022 1.105.199.13.168.18.396.18.714v.058l-.862.205v-.12c0-.377-.105-.52-.379-.452-.326.082-.458.391-.458 1.007l.001.287c0 .625.086.911.461.833.326-.068.371-.354.376-.605l.003-.165.86-.204.001.134c-.002.82-.434 1.337-1.244 1.526-1.115.261-1.334-.384-1.368-1.397m-2.981 1.383c0-.751.44-.989 1.103-1.263.595-.246.608-.368.61-.583.004-.18-.08-.334-.376-.258a.45.45 0 0 0-.36.424 1.83 1.83 0 0 0-.005.166l-.835.198a1.647 1.647 0 0 1 .058-.494c.133-.45.53-.751 1.213-.91.889-.204 1.185.185 1.186.792v1.437c0 .694.13.796.13.796l-.82.194c-.046-.095-.083-.193-.11-.294s-.18.452-.8.597c-.65.154-.994-.25-.994-.802m1.708-1.026a3.072 3.072 0 0 1-.436.256c-.274.133-.397.298-.397.552 0 .22.136.364.383.303.266-.067.45-.315.45-.659v-.452zm-12.752 5.743a.526.526 0 0 1-.436-.804l.006-.007.01-.003 1.224-.289v.93l-.02.004c-.277.067-.61.143-.677.158a.546.546 0 0 1-.107.01m0 1.191a.523.523 0 0 1-.436-.802l.006-.009.01-.002 1.224-.29v.93l-.02.006c-.277.066-.61.143-.677.157a.546.546 0 0 1-.107.01m0 1.191a.525.525 0 0 1-.436-.802l.006-.01 1.234-.29v.93l-.02.004a45.52 45.52 0 0 1-.677.158.546.546 0 0 1-.107.01m-.145-3.521V9.342l.949-.224v5.203l-.949.224zm2.363-.442c0-.321-.264-.585-.585-.585s-.585.264-.585.585v4.863a1.6 1.6 0 0 0 1.584 1.584l1.657-.002v-4.291a.766.766 0 0 0-.34-.638l-1.476-1.002v2.277a.127.127 0 0 1-.126.126.128.128 0 0 1-.126-.126l-.003-2.791m.791-3.628a1.281 1.281 0 0 0-.845.653v-.366l-.854.202.001 2.335a.875.875 0 0 1 .9.157V11.95c0-.361.18-.65.436-.707.193-.042.354.027.354.371v2.2l.9-.211v-2.327c0-.564-.217-.959-.893-.8m13.071-3.331a.563.563 0 0 1-.556-.556c0-.305.25-.556.556-.556s.556.25.556.556a.559.559 0 0 1-.556.556m0-1.042c-.267 0-.486.22-.486.486s.22.486.486.486.486-.22.486-.486a.492.492 0 0 0-.486-.486" fill="#231f20"/><path d="M26.765 6.258h.24l.016-.001c.086 0 .157.071.157.157l-.001.018c0 .088-.04.156-.113.167v.002c.067.007.102.044.106.14l.004.137a.07.07 0 0 0 .032.059h-.123a.108.108 0 0 1-.018-.06c-.004-.041-.003-.08-.004-.129-.002-.074-.025-.106-.1-.106h-.088v.295h-.108v-.68.001zm.195.302h.01a.1.1 0 0 0 .1-.1l-.001-.01c0-.072-.032-.11-.104-.11h-.092v.22h.087z" fill="#231f20"/></svg>',
            'google_pay' => '<svg xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 38 24" width="'. $svg_width .'" height="'. $svg_height .'" aria-labelledby="pi-google_pay"><title id="pi-google_pay">Google Pay</title><path d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z" fill="#000" opacity=".07"/><path d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32" fill="#FFF"/><path d="M18.093 11.976v3.2h-1.018v-7.9h2.691a2.447 2.447 0 0 1 1.747.692 2.28 2.28 0 0 1 .11 3.224l-.11.116c-.47.447-1.098.69-1.747.674l-1.673-.006zm0-3.732v2.788h1.698c.377.012.741-.135 1.005-.404a1.391 1.391 0 0 0-1.005-2.354l-1.698-.03zm6.484 1.348c.65-.03 1.286.188 1.778.613.445.43.682 1.03.65 1.649v3.334h-.969v-.766h-.049a1.93 1.93 0 0 1-1.673.931 2.17 2.17 0 0 1-1.496-.533 1.667 1.667 0 0 1-.613-1.324 1.606 1.606 0 0 1 .613-1.336 2.746 2.746 0 0 1 1.698-.515c.517-.02 1.03.093 1.49.331v-.208a1.134 1.134 0 0 0-.417-.901 1.416 1.416 0 0 0-.98-.368 1.545 1.545 0 0 0-1.319.717l-.895-.564a2.488 2.488 0 0 1 2.182-1.06zM23.29 13.52a.79.79 0 0 0 .337.662c.223.176.5.269.785.263.429-.001.84-.17 1.146-.472.305-.286.478-.685.478-1.103a2.047 2.047 0 0 0-1.324-.374 1.716 1.716 0 0 0-1.03.294.883.883 0 0 0-.392.73zm9.286-3.75l-3.39 7.79h-1.048l1.281-2.728-2.224-5.062h1.103l1.612 3.885 1.569-3.885h1.097z" fill="#5F6368"/><path d="M13.986 11.284c0-.308-.024-.616-.073-.92h-4.29v1.747h2.451a2.096 2.096 0 0 1-.9 1.373v1.134h1.464a4.433 4.433 0 0 0 1.348-3.334z" fill="#4285F4"/><path d="M9.629 15.721a4.352 4.352 0 0 0 3.01-1.097l-1.466-1.14a2.752 2.752 0 0 1-4.094-1.44H5.577v1.17a4.53 4.53 0 0 0 4.052 2.507z" fill="#34A853"/><path d="M7.079 12.05a2.709 2.709 0 0 1 0-1.735v-1.17H5.577a4.505 4.505 0 0 0 0 4.075l1.502-1.17z" fill="#FBBC04"/><path d="M9.629 8.44a2.452 2.452 0 0 1 1.74.68l1.3-1.293a4.37 4.37 0 0 0-3.065-1.183 4.53 4.53 0 0 0-4.027 2.5l1.502 1.171a2.715 2.715 0 0 1 2.55-1.875z" fill="#EA4335"/></svg>',
            'jcb' => '<svg xmlns="http://www.w3.org/2000/svg" width="'. $svg_width .'" height="'. $svg_height .'" role="img" aria-labelledby="pi-jcb" viewBox="0 0 38 24"><title id="pi-jcb">JCB</title><g fill="none" fill-rule="evenodd"><g fill-rule="nonzero"><path d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z" fill="#000" opacity=".07"/><path d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32" fill="#FFF"/></g><path d="M11.5 5H15v11.5a2.5 2.5 0 0 1-2.5 2.5H9V7.5A2.5 2.5 0 0 1 11.5 5z" fill="#006EBC"/><path d="M18.5 5H22v11.5a2.5 2.5 0 0 1-2.5 2.5H16V7.5A2.5 2.5 0 0 1 18.5 5z" fill="#F00036"/><path d="M25.5 5H29v11.5a2.5 2.5 0 0 1-2.5 2.5H23V7.5A2.5 2.5 0 0 1 25.5 5z" fill="#2AB419"/><path d="M10.755 14.5c-1.06 0-2.122-.304-2.656-.987l.78-.676c.068 1.133 3.545 1.24 3.545-.19V9.5h1.802v3.147c0 .728-.574 1.322-1.573 1.632-.466.144-1.365.221-1.898.221zm8.116 0c-.674 0-1.388-.107-1.965-.366-.948-.425-1.312-1.206-1.3-2.199.012-1.014.436-1.782 1.468-2.165 1.319-.49 3.343-.261 3.926.27v.972c-.572-.521-1.958-.898-2.919-.46-.494.226-.737.917-.744 1.448-.006.56.245 1.252.744 1.497.953.467 2.39.04 2.919-.441v1.01c-.358.255-1.253.434-2.129.434zm8.679-2.587c.37-.235.582-.567.582-1.005 0-.438-.116-.687-.348-.939-.206-.207-.58-.469-1.238-.469H23v5h3.546c.696 0 1.097-.23 1.315-.415.283-.25.426-.53.426-.96 0-.431-.155-.908-.737-1.212zm-1.906-.281h-1.428v-1.444h1.495c.956 0 .944 1.444-.067 1.444zm.288 2.157h-1.716v-1.513h1.716c.986 0 1.083 1.513 0 1.513z" fill="#FFF" fill-rule="nonzero"/></g></svg>',
            'klarna' => '<svg xmlns="http://www.w3.org/2000/svg" role="img" width="'. $svg_width .'" height="'. $svg_height .'" viewBox="0 0 38 24" aria-labelledby="pi-klarna"><title id="pi-klarna">Klarna</title><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><path d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z" fill="#FFB3C7"/><path d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32" fill="#FFB3C7"/><path d="M34.117 13.184c-.487 0-.882.4-.882.892 0 .493.395.893.882.893.488 0 .883-.4.883-.893a.888.888 0 00-.883-.892zm-2.903-.69c0-.676-.57-1.223-1.274-1.223-.704 0-1.274.547-1.274 1.222 0 .675.57 1.223 1.274 1.223.704 0 1.274-.548 1.274-1.223zm.005-2.376h1.406v4.75h-1.406v-.303a2.446 2.446 0 01-1.394.435c-1.369 0-2.478-1.122-2.478-2.507 0-1.384 1.11-2.506 2.478-2.506.517 0 .996.16 1.394.435v-.304zm-11.253.619v-.619h-1.44v4.75h1.443v-2.217c0-.749.802-1.15 1.359-1.15h.016v-1.382c-.57 0-1.096.247-1.378.618zm-3.586 1.756c0-.675-.57-1.222-1.274-1.222-.703 0-1.274.547-1.274 1.222 0 .675.57 1.223 1.274 1.223.704 0 1.274-.548 1.274-1.223zm.005-2.375h1.406v4.75h-1.406v-.303A2.446 2.446 0 0114.99 15c-1.368 0-2.478-1.122-2.478-2.507 0-1.384 1.11-2.506 2.478-2.506.517 0 .997.16 1.394.435v-.304zm8.463-.128c-.561 0-1.093.177-1.448.663v-.535H22v4.75h1.417v-2.496c0-.722.479-1.076 1.055-1.076.618 0 .973.374.973 1.066v2.507h1.405v-3.021c0-1.106-.87-1.858-2.002-1.858zM10.465 14.87h1.472V8h-1.472v6.868zM4 14.87h1.558V8H4v6.87zM9.45 8a5.497 5.497 0 01-1.593 3.9l2.154 2.97H8.086l-2.341-3.228.604-.458A3.96 3.96 0 007.926 8H9.45z" fill="#0A0B09" fill-rule="nonzero"/></g></svg>',
            'litecoin' => '<svg xmlns="http://www.w3.org/2000/svg" width="'. $svg_width .'" height="'. $svg_height .'" viewBox="-36 25 38 24" role="img" aria-labelledby="pi-litecoin"><title id="pi-litecoin">Litecoin</title><path fill="#fff" d="M-.4 49h-33.2c-1.3 0-2.4-1.1-2.4-2.4V27.4c0-1.3 1.1-2.4 2.4-2.4H-.4C.9 25 2 26.1 2 27.4v19.2C2 47.9.9 49-.4 49z"/><path opacity=".25" fill="#A8AAAD" d="M-.4 49h-33.2c-1.3 0-2.4-1.1-2.4-2.4V27.4c0-1.3 1.1-2.4 2.4-2.4H-.5C.9 25 2 26.1 2 27.4v19.2C2 47.9.9 49-.4 49zm-33.2-23c-.8 0-1.4.6-1.4 1.4v19.2c0 .8.6 1.4 1.4 1.4H-.5c.8 0 1.5-.6 1.5-1.4V27.4C1 26.6.4 26-.4 26h-33.2z"/><circle fill="#58595B" cx="-17" cy="37" r="8.2"/><path fill="#fff" d="M-17.8 32.5L-19 37l-1 .4-.3 1.1 1-.4-.7 2.7h6.9l.4-1.6H-17l.6-2.2 1.2-.4.3-1.1-1.2.5.9-3.5h-2.6z"/></svg>',
            'maestro' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38 24" width="'. $svg_width .'" height="'. $svg_height .'" role="img" aria-labelledby="pi-maestro"><title id="pi-maestro">Maestro</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"/><circle fill="#EB001B" cx="15" cy="12" r="7"/><circle fill="#00A2E5" cx="23" cy="12" r="7"/><path fill="#7375CF" d="M22 12c0-2.4-1.2-4.5-3-5.7-1.8 1.3-3 3.4-3 5.7s1.2 4.5 3 5.7c1.8-1.2 3-3.3 3-5.7z"/></svg>',
            'master' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38 24" role="img" width="'. $svg_width .'" height="'. $svg_height .'" aria-labelledby="pi-master"><title id="pi-master">Mastercard</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"/><circle fill="#EB001B" cx="15" cy="12" r="7"/><circle fill="#F79E1B" cx="23" cy="12" r="7"/><path fill="#FF5F00" d="M22 12c0-2.4-1.2-4.5-3-5.7-1.8 1.3-3 3.4-3 5.7s1.2 4.5 3 5.7c1.8-1.2 3-3.3 3-5.7z"/></svg>',
            'paypal' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38 24" width="'. $svg_width .'" height="'. $svg_height .'" role="img" aria-labelledby="pi-paypal"><title id="pi-paypal">PayPal</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"/><path fill="#003087" d="M23.9 8.3c.2-1 0-1.7-.6-2.3-.6-.7-1.7-1-3.1-1h-4.1c-.3 0-.5.2-.6.5L14 15.6c0 .2.1.4.3.4H17l.4-3.4 1.8-2.2 4.7-2.1z"/><path fill="#3086C8" d="M23.9 8.3l-.2.2c-.5 2.8-2.2 3.8-4.6 3.8H18c-.3 0-.5.2-.6.5l-.6 3.9-.2 1c0 .2.1.4.3.4H19c.3 0 .5-.2.5-.4v-.1l.4-2.4v-.1c0-.2.3-.4.5-.4h.3c2.1 0 3.7-.8 4.1-3.2.2-1 .1-1.8-.4-2.4-.1-.5-.3-.7-.5-.8z"/><path fill="#012169" d="M23.3 8.1c-.1-.1-.2-.1-.3-.1-.1 0-.2 0-.3-.1-.3-.1-.7-.1-1.1-.1h-3c-.1 0-.2 0-.2.1-.2.1-.3.2-.3.4l-.7 4.4v.1c0-.3.3-.5.6-.5h1.3c2.5 0 4.1-1 4.6-3.8v-.2c-.1-.1-.3-.2-.5-.2h-.1z"/></svg>',
            'sofort' => '<svg xmlns="http://www.w3.org/2000/svg" role="img" width="'. $svg_width .'" height="'. $svg_height .'" viewBox="0 0 38 24" aria-labelledby="pi-sofort"><title id="pi-sofort">SOFORT</title><g fill="none" fill-rule="evenodd"><rect width="38" height="24" fill="#EB6F93" fill-rule="nonzero" rx="3"/><path fill="#FFF" d="M11.804 21.453c-.57 0-1.062-.264-1.362-.672l.564-.57c.168.216.444.45.81.45.342 0 .576-.204.576-.528 0-.348-.276-.432-.714-.558-.804-.234-1.128-.654-1.128-1.194 0-.678.516-1.266 1.332-1.266.516 0 .99.24 1.2.708l-.678.426c-.126-.21-.306-.348-.546-.348-.282 0-.462.192-.462.438 0 .294.258.384.672.504.648.192 1.176.516 1.176 1.26 0 .804-.624 1.35-1.44 1.35zm3.298 0c-.864 0-1.566-.69-1.566-1.53 0-.84.702-1.53 1.566-1.53.864 0 1.566.69 1.566 1.53 0 .84-.702 1.53-1.566 1.53zm0-.768c.42 0 .75-.33.75-.762a.745.745 0 0 0-.75-.762c-.42 0-.75.33-.75.762s.33.762.75.762zm3.586-2.742c-.456-.018-.786.21-.786.714v.312c.18-.192.438-.288.762-.288v.78c-.45.012-.762.3-.762.702v1.212h-.816v-2.76c0-.78.486-1.44 1.482-1.44h.12v.768zm1.78 3.51c-.864 0-1.566-.69-1.566-1.53 0-.84.702-1.53 1.566-1.53.864 0 1.566.69 1.566 1.53 0 .84-.702 1.53-1.566 1.53zm0-.768c.42 0 .75-.33.75-.762a.745.745 0 0 0-.75-.762c-.42 0-.75.33-.75.762s.33.762.75.762zm2.8-1.884c.162-.264.426-.39.798-.378v.876c-.492 0-.774.27-.774.75v1.326h-.816v-2.904h.792v.33zm2.08 1.092c0 .504.33.732.786.714v.768h-.12c-.996 0-1.482-.66-1.482-1.44v-2.4h.816v.456c0 .396.318.69.762.702v.78c-.324 0-.582-.096-.762-.288v.708zm1.762 1.53a.548.548 0 0 1-.546-.546c0-.3.246-.546.546-.546.3 0 .546.246.546.546 0 .3-.246.546-.546.546zm-7.772-6.71c2.55-.004 3.628-1.459 3.824-3.789.056-.67-.056-1.079-.258-1.295a.486.486 0 0 0-.153-.114.23.23 0 0 0-.06-.018l-3.023-.706a1.276 1.276 0 0 0-.581-.02.57.57 0 0 0-.46.431c-.101.34-.094.6.121.807.056.02.101.057.132.104.15.1.362.186.648.264l1.993.445c.33.074.23.57-.104.507a1.76 1.76 0 0 0-.86.083c-.487.183-.789.601-.826 1.377a.259.259 0 0 1-.518-.026c.042-.855.376-1.421.915-1.722l-.724-.161a3.181 3.181 0 0 1-.635-.24c-.083.128-.192.24-.321.33l-.057.037c-.035.024-.071.045-.107.065.23.434.167.983-.191 1.355l-.05.054a1.17 1.17 0 0 1-1.65.022l-.388-.384c.318 1.553 1.702 2.593 3.32 2.593h.013zm-.09.516c-2.05-.037-3.773-1.547-3.828-3.69l-.471-.466c-.582-.584-.676-1.393-.208-1.873l.05-.053c.2-.207.464-.32.733-.334-.325-.641-.224-1.343.282-1.69l.072-.047c.55-.319 1.028-.196 1.437.21l-.47-3.865c-.158-.672.254-1.408.882-1.542a1.233 1.233 0 0 1 1.464.958l.801 3.42 1.015-3.476a1.285 1.285 0 0 1 1.565-.911c.617.183.989.811.854 1.436l-1.118 5.57.48.112c.14.02.322.103.494.287.313.334.464.886.396 1.692-.217 2.59-1.493 4.288-4.413 4.263l-.017-.001zm2.556-6.47L22.918 3.2a.711.711 0 0 0-.484-.832.767.767 0 0 0-.928.55l-1.292 4.427a.26.26 0 0 1-.433.108.258.258 0 0 1-.07-.124l-1.026-4.384a.713.713 0 0 0-.85-.56c-.334.07-.584.523-.483.926l.005.031.583 4.79.37.552c.16-.22.39-.358.664-.419a1.773 1.773 0 0 1 .824.024l2.006.468zm-3.726.51l-.572-.852a.258.258 0 0 1-.053-.079l-.262-.39c-.334-.486-.658-.654-1.04-.433l-.055.037c-.297.204-.338.698-.028 1.167l1.132 1.685a.651.651 0 0 0 .902.173l.056-.037a.64.64 0 0 0 .19-.205c-.282-.293-.35-.655-.27-1.067zm-.324 1.937a1.17 1.17 0 0 1-.983-.512l-.842-1.253a.587.587 0 0 0-.765.065l-.05.053c-.252.259-.196.75.2 1.147l1.44 1.427a.65.65 0 0 0 .915-.012l.05-.052a.65.65 0 0 0 .035-.863z"/></g></svg>',
            'visa' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38 24" role="img" width="'. $svg_width .'" height="'. $svg_height .'" aria-labelledby="pi-visa"><title id="pi-visa">Visa</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"/><path d="M28.3 10.1H28c-.4 1-.7 1.5-1 3h1.9c-.3-1.5-.3-2.2-.6-3zm2.9 5.9h-1.7c-.1 0-.1 0-.2-.1l-.2-.9-.1-.2h-2.4c-.1 0-.2 0-.2.2l-.3.9c0 .1-.1.1-.1.1h-2.1l.2-.5L27 8.7c0-.5.3-.7.8-.7h1.5c.1 0 .2 0 .2.2l1.4 6.5c.1.4.2.7.2 1.1.1.1.1.1.1.2zm-13.4-.3l.4-1.8c.1 0 .2.1.2.1.7.3 1.4.5 2.1.4.2 0 .5-.1.7-.2.5-.2.5-.7.1-1.1-.2-.2-.5-.3-.8-.5-.4-.2-.8-.4-1.1-.7-1.2-1-.8-2.4-.1-3.1.6-.4.9-.8 1.7-.8 1.2 0 2.5 0 3.1.2h.1c-.1.6-.2 1.1-.4 1.7-.5-.2-1-.4-1.5-.4-.3 0-.6 0-.9.1-.2 0-.3.1-.4.2-.2.2-.2.5 0 .7l.5.4c.4.2.8.4 1.1.6.5.3 1 .8 1.1 1.4.2.9-.1 1.7-.9 2.3-.5.4-.7.6-1.4.6-1.4 0-2.5.1-3.4-.2-.1.2-.1.2-.2.1zm-3.5.3c.1-.7.1-.7.2-1 .5-2.2 1-4.5 1.4-6.7.1-.2.1-.3.3-.3H18c-.2 1.2-.4 2.1-.7 3.2-.3 1.5-.6 3-1 4.5 0 .2-.1.2-.3.2M5 8.2c0-.1.2-.2.3-.2h3.4c.5 0 .9.3 1 .8l.9 4.4c0 .1 0 .1.1.2 0-.1.1-.1.1-.1l2.1-5.1c-.1-.1 0-.2.1-.2h2.1c0 .1 0 .1-.1.2l-3.1 7.3c-.1.2-.1.3-.2.4-.1.1-.3 0-.5 0H9.7c-.1 0-.2 0-.2-.2L7.9 9.5c-.2-.2-.5-.5-.9-.6-.6-.3-1.7-.5-1.9-.5L5 8.2z" fill="#142688"/></svg>',
        );
    }
}


/**
 * Set Cookie function
 *
 */
if ( ! function_exists( 'the4_set_cookie' ) ) {
    function the4_set_cookie( $name, $value ) {
        $expire = time() + 30 * 84600;
        setcookie( $name, $value, $expire, COOKIEPATH, COOKIE_DOMAIN, false, false );
        $_COOKIE[ $name ] = $value;
    }
}

/**
 * Get Header action icon
 *
 */
if ( ! function_exists( 'the4_get_header_action_icon' ) ) {
    function the4_get_header_action_icon() {
        $icon_search_class = $icon_heart_class = $icon_cart_class = $icon_acc_class = '';
        $style = cs_get_option( 'header-icon_type' );

        if ( $style == 'la' ) {
            $icon_search_class .= 't4_icon_search-solid pr';
            $icon_heart_class .= 't4_icon_heart pr';
            $icon_acc_class .= 't4_icon_user';
            $icon_cart_class .= 't4_icon_shopping-cart-solid pr';
        } elseif ( $style == 'pe' ) {
            $icon_search_class .= 'pegk pe-7s-search';
            $icon_heart_class .= 'pegk pe-7s-like pr';
            $icon_acc_class .= 'pegk pe-7s-user';
            $icon_cart_class .= 'pegk pe-7s-shopbag';
        } else {
            $icon_search_class .= 't4_icon_t4-search';
            $icon_heart_class .= 't4_icon_t4-heart pr';
            $icon_acc_class .= 't4_icon_t4-user';
            $icon_cart_class .= 't4_icon_t4-shopping-cart';
        }

        $icons = array(
            'search' => $icon_search_class,
            'heart' => $icon_heart_class,
            'user' => $icon_acc_class,
            'cart' => $icon_cart_class
        );

        return $icons;
    }
}

/**
 * Get time ago
 *
 * @since  1.0
 */
function the4_kalles_get_time_ago($timestamp)
{
    $time_ago        = strtotime($timestamp);
    $current_time    = time();
    $time_difference = $current_time - $time_ago;
    $seconds         = $time_difference;
    $minutes         = round($seconds / 60 );           // value 60 is seconds
    $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
    $days            = round($seconds / 86400);          //86400 = 24 * 60 * 60;
    $weeks           = round($seconds / 604800);          // 7*24*60*60;
    $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
    $years           = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60
    if($seconds <= 60)
    {
        return translate('Just now', 'kalles');
    }
    else if($minutes <=60)
    {
        if($minutes==1)
        {
            return translate('one minute ago', 'kalles');
        }
        else
        {
            return $minutes . translate(' minutes ago', 'kalles');
        }
    }
    else if($hours <=24)
    {
        if($hours==1)
        {
            return translate('an hour ago', 'kalles');
        }
        else
        {
            return $hours . translate(' hrs ago', 'kalles');
        }
    }
    else if($days <= 7)
    {
        if($days==1)
        {
            return translate('yesterday', 'kalles');
        }
        else
        {
            return $days . translate(' days ago', 'kalles');
        }
    }
    else if($weeks <= 4.3) //4.3 == 52/12
    {
        if($weeks==1)
        {
            return translate('a week ago', 'kalles');
        }
        else
        {
            return $weeks . translate(' weeks ago', 'kalles');
        }
    }
    else if($months <=12)
    {
        if($months==1)
        {
            return translate('a month ago', 'kalles');
        }
        else
        {
            return $months . translate(' months ago', 'kalles');
        }
    }
    else
    {
        if($years==1)
        {
            return translate('one year ago', 'kalles');
        }
        else
        {
            return $years . translate(' years ago', 'kalles');
        }
    }
}

/**
 * Count swatch color
 *
 * @since  1.0
 */

if ( ! function_exists( 't4_woo_count_swatch_color' ) ) {
    function t4_woo_count_swatch_color( $attr, $terms ){
        $count = 0;
        foreach ( $terms as $term ) {
            if (  $attr->attribute_type == 'color' ) {
                $count++;
            }
        }
        return $count;
    }
}


/**
 * Get Theme Version
 *
 * @since  1.1.1
 */
if ( ! function_exists( 'kalles_get_theme_version') ) {
    function kalles_get_theme_version() {
        $theme_info = wp_get_theme();

        if ( is_object( $theme_info->parent() ) && is_child_theme() ) {
            $theme_info = wp_get_theme( $theme_info->parent()->template );
        }

        return $theme_info->get( 'Version' );
    }
}

/**
 * Get maintance mode
 *
 * @since  1.1.1
 * 
 */
if ( ! function_exists( 'kalles_is_maintance') ) {
    function kalles_is_maintance() {
        $isMaintance = false;

        if ( cs_get_option( 'maintenance' ) && ! is_user_logged_in() ) {
            $isMaintance = true;
        }

        return $isMaintance;
    }
}

/**
 * Get class Toolbar mobile icon
 *
 * @since  1.1.1
 * 
 */
if ( ! function_exists( 'kalles_get_toolbar_mobile_icon_class') ) {
    function kalles_get_toolbar_mobile_icon_class( $event ) {
        switch ( $event) {
            case 'the4-icon-cart':

                $event .= ' sidebar';
                break;
            case 'the4-my-account':

                $the4_check_login = (is_user_logged_in()) ? '' : 'the4-login-register';
                $account_type = cs_get_option( 'woocommerce_account-type' ) ? cs_get_option( 'woocommerce_account-type' )  : 'sidebar';
                $event = $the4_check_login . ' ' . $account_type;
                break;
        }

        return $event;
    }
}
