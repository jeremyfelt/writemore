<?php
/**
 * Write More Things functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Write_More_Things
 */

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once __DIR__ . '/inc/template-functions.php';

require_once __DIR__ . '/inc/content-aggregator-block.php';
require_once __DIR__ . '/inc/class-writemore-comment-walker.php';
require_once __DIR__ . '/inc/comments.php';
require_once get_template_directory() . '/inc/navigation.php';
require_once __DIR__ . '/inc/og.php';
require_once get_template_directory() . '/inc/output.php';
require_once __DIR__ . '/inc/theme-setup.php';
