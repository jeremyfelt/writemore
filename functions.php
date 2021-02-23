<?php
/**
 * Write More Things functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Write_More_Things
 */

/**
 * Enqueue scripts and styles.
 */
function writemore_scripts() {
	wp_enqueue_style( 'writemore-style', get_stylesheet_uri(), array( 'twenty-twenty-one-style' ), wp_get_theme()->get('Version') );
}
add_action( 'wp_enqueue_scripts', 'writemore_scripts' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once __DIR__ . '/inc/template-functions.php';

require_once __DIR__ . '/inc/class-writemore-comment-walker.php';
require_once __DIR__ . '/inc/comments.php';
require_once __DIR__ . '/inc/og.php';
