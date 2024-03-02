<?php
/**
 * Configuration for the theme.
 *
 * @package writemore
 */

namespace WriteMore\ThemeSetup;

add_action( 'after_setup_theme', __NAMESPACE__ . '\setup_theme_support' );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );
add_filter( 'nav_menu_item_id', '__return_empty_string' );
add_filter( 'nav_menu_css_class', __NAMESPACE__ . '\filter_nav_menu_item_class', 10, 2 );

/**
 * Filter the classes for a nav menu item.
 *
 * @param array    $classes   Classes attached to a menu item.
 * @param \WP_Post $menu_item The menu item.
 * @return array Modified list of classes.
 */
function filter_nav_menu_item_class( $classes, $menu_item ) {
	if ( $menu_item->current ) {
		return array( 'current' );
	}

	return array();
}

function setup_theme_support() {
	// Add default RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// WordPress provides a <title> tag.
	add_theme_support( 'title-tag' );

	add_theme_support( 'align-wide' );
	add_theme_support( 'post-thumbnails' );

	// Use HTML5 markup for common core items.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	register_nav_menus(
		array(
			'header-menu' => __( 'Header Menu' ),
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Author Bio' ),
			'id'            => 'writemore-author-bio',
			'description'   => __( 'Widgets in this area will be shown in the author bio.' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer' ),
			'id'            => 'writemore-footer',
			'description'   => __( 'Widgets in this area will be shown in the site footer.' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		)
	);

	// Clear the default editor styles, register support, and then enqueue our own.
	remove_editor_styles();
	add_theme_support( 'editor-styles' );
	add_editor_style( 'editor-style.css' );
}

/**
 * Enqueue theme assets.
 */
function enqueue_assets() {

	wp_enqueue_style(
		'writemore-style',
		get_stylesheet_uri(),
		array(),
		filemtime( get_stylesheet_directory() . '/style.css' ),
	);
}
