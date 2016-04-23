<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Radical
 */

/**
 * Theme Mod Defaults
 *
 * @param string $theme_mod - Theme modification name.
 * @return mixed
 */
function radical_default( $theme_mod = 'radical_sidebar_position' ) {

	$radical_default = array(
		'radical_sidebar_position' => 'right',
	);

	if ( isset( $radical_default[$theme_mod] ) ) {
		return $radical_default[$theme_mod];
	}

	return '';

}

/**
 * Register Google fonts for Radical.
 *
 * @return string Google fonts URL for the theme.
 */
function radical_fonts_url() {

    // Fonts and Other Variables
    $fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

    /* Translators: If there are characters in your language that are not
    * supported by Source Sans Pro, translate this to 'off'. Do not translate
    * into your own language.
    */
    if ( 'off' !== esc_html_x( 'on', 'Source Sans Pro font: on or off', 'radical' ) ) {
		$fonts[] = 'Source Sans Pro:400,700,400italic,700italic';
	}

	/* Translators: If there are characters in your language that are not
    * supported by Open Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    if ( 'off' !== esc_html_x( 'on', 'Open Sans font: on or off', 'radical' ) ) {
		$fonts[] = 'Open Sans:400,400italic,700,700italic,600,600italic';
	}

	/* Translators: To add an additional character subset specific to your language,
	* translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'.
	* Do not translate into your own language.
	*/
	$subset = esc_html_x( 'no-subset', 'Add new subset (cyrillic, greek, devanagari, vietnamese)', 'radical' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;

}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function radical_page_menu_args( $args ) {
	$args['show_home'] = true;
	$args['menu_class'] = 'site-primary-menu';
	return $args;
}
add_filter( 'wp_page_menu_args', 'radical_page_menu_args' );

/**
 * Add ID and CLASS attributes to the first <ul> occurence in wp_page_menu
 */
function radical_page_menu_class( $class ) {
  return preg_replace( '/<ul>/', '<ul class="primary-menu sf-menu">', $class, 1 );
}
add_filter( 'wp_page_menu', 'radical_page_menu_class' );

/**
 * Filter 'excerpt_length'
 *
 * @param int $length
 * @return int
 */
function radical_excerpt_length( $length ) {
	return apply_filters( 'radical_excerpt_length', 20 );
}
add_filter( 'excerpt_length', 'radical_excerpt_length' );

/**
 * Filter 'excerpt_more'
 *
 * Remove [...] string
 * @param str $more
 * @return str
 */
function radical_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'radical_excerpt_more' );

/**
 * Filter 'the_content_more_link'
 * Prevent Page Scroll When Clicking the More Link.
 *
 * @param string $link
 * @return filtered link
 */
function radical_the_content_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'radical_the_content_more_link_scroll' );

/**
 * Filter 'the_site_logo'
 *
 * @return string
 */
function radical_get_custom_logo( $html ) {
	return '<div class="site-logo-wrapper">' . $html . '</div>';
}
add_filter( 'get_custom_logo', 'radical_get_custom_logo' );

/**
 * Filter `body_class`
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function radical_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Site Title & Tagline Class
	if ( 'blank' !== get_header_textcolor() ) {
		$classes[] = 'has-site-branding';
	}

	// Custom Header
	if ( get_header_image() ) {
		$classes[] = 'has-custom-header';
	}

	// Custom Background Image
	if ( get_background_image() ) {
		$classes[] = 'has-custom-background-image';
	}

	// Sidebar Position Class
	if ( radical_has_sidebar() ) {
		$classes[] = 'has-' . esc_attr( get_theme_mod( 'radical_sidebar_position', radical_default( 'radical_sidebar_position' ) ) ) . '-sidebar';
	} else {
		$classes[] = 'has-no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'radical_body_classes' );

/**
 * Filter `post_class`
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function radical_post_classes( $classes ) {

	// Excerpt Class
	if ( radical_has_excerpt() ) {
		$classes[] = 'has-excerpt';
	}

	return $classes;

}
add_filter( 'post_class', 'radical_post_classes' );

/**
 * Display Blog Credits.
 *
 * @return void
 */
function radical_credit_blog() {
	$credit_blog_string = '<div class="credit-blog">&copy; %1$s %2$s <span>&sdot;</span> <a href="%3$s">%4$s</a></div>';
	printf( $credit_blog_string,
		esc_html__( 'Copyright', 'radical' ),
		esc_html( date( 'Y' ) ),
		esc_url( home_url() ),
		esc_html( get_bloginfo( 'name' ) )
	);
}
add_action( 'radical_credits', 'radical_credit_blog' );

/**
 * Display Designer Credits.
 *
 * @return void
 */
function radical_credit_designer() {
	$credit_designer_string = '<a href="%1$s" title="%2$s">%3$s</a> <span>&sdot;</span> %4$s <a href="%5$s" title="%6$s">%7$s</a>';
	printf( $credit_designer_string,
		esc_url( 'https://wpflask.com/radical/' ),
		esc_attr( 'Radical Theme' ),
		esc_html( 'Radical Theme' ),
		esc_html__( 'Powered by', 'radical' ),
		esc_url( 'https://wordpress.org/' ),
		esc_attr( 'WordPress', 'radical' ),
		esc_html( 'WordPress' )
	);
}
add_action( 'radical_credits', 'radical_credit_designer' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function radical_attachment_link( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) ) {
		return $url;
	}

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id ) {
		$url .= '#main';
	}

	return $url;
}
add_filter( 'attachment_link', 'radical_attachment_link', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function radical_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'radical_setup_author' );

if ( ! function_exists( 'radical_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @return void
 */
function radical_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Radical attachment size.
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 1140.
	 *     @type int $width  Width of the image in pixels. Default 1140.
	 * }
	 */
	$attachment_size     = apply_filters( 'radical_attachment_size', 'full' );
	$next_attachment_url = wp_get_attachment_url();

	if ( $post->post_parent ) { // Only look for attachments if this attachment has a parent object.

		/*
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => 100,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID',
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {

			foreach ( $attachment_ids as $key => $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					break;
				}
			}

			// For next attachment
			$key++;

			if ( isset( $attachment_ids[ $key ] ) ) {
				// get the URL of the next image attachment
				$next_attachment_url = get_attachment_link( $attachment_ids[$key] );
			} else {
				// or get the URL of the first image attachment
				$next_attachment_url = get_attachment_link( $attachment_ids[0] );
			}

		}

	} // end post->post_parent check

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		esc_attr( get_the_title() ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);

}
endif;
