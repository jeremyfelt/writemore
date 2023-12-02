<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package writemore
 */

add_filter( 'post_class', 'writemore_post_class', 10 );
add_action( 'wp_head', 'writemore_pingback_header' );
add_filter( 'body_class', 'writemore_body_classes' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function writemore_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes = array( 'multiple hfeed' );
	} elseif ( is_front_page() ) {
		$classes = array( 'multiple' );
	} else {
		$classes = array( 'single' );
	}

	return $classes;
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function writemore_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}

/**
 * Mark articles up with the microformat class `h-entry` for an entry.
 */
function writemore_post_class() {
	$classes = array();

	$classes[] = 'type-' . get_post_type();
	$classes[] = 'h-entry';

	if ( has_block( 'core/image' ) && 'shortnote' === get_post_type() ) {
		$classes[] = 'has-image';
	}

	return $classes;
}
