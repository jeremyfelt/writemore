<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Write_More_Things
 */

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
add_filter( 'body_class', 'writemore_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function writemore_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'writemore_pingback_header' );

add_filter( 'post_class', 'writemore_post_class', 10 );
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

/**
 * Hack together a way to output the right posted on information
 * for an archive of shortnotes.
 */
function writemore_posted_on() {
	$time_string = '<time class="entry-date dt-published published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);

	if ( is_post_type_archive( 'shortnote' ) ) {
		echo '<a href="' . esc_url( get_the_permalink() ) . '" class="posted-on u-url">';
	} else {
		echo '<span class="posted-on">';
	}

	printf(
		/* translators: %s: publish date. */
		esc_html__( 'Published %s', 'writemore' ),
		$time_string // phpcs:ignore WordPress.Security.EscapeOutput
	);

	if ( is_post_type_archive( 'shortnote' ) ) {
		echo '</a>';
	} else {
		echo ' under a <a rel="license" href="https://creativecommons.org/licenses/by-sa/4.0/">CC BY-SA 4.0 International License</a>.</span>';
	}
}
