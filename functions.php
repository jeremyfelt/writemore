<?php
/**
 * The Write More theme.
 *
 * @package writemore
 */

// Load Composer autoloader for league/commonmark and other dependencies.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

require_once __DIR__ . '/inc/markdown.php';
require_once __DIR__ . '/inc/template-functions.php';
require_once __DIR__ . '/inc/content-aggregator-block.php';
require_once __DIR__ . '/inc/class-writemore-comment-walker.php';
require_once __DIR__ . '/inc/comments.php';
require_once __DIR__ . '/inc/navigation.php';
require_once __DIR__ . '/inc/og.php';
require_once __DIR__ . '/inc/output.php';
require_once __DIR__ . '/inc/queries.php';
require_once __DIR__ . '/inc/theme-setup.php';
