<?php

namespace WriteMore\ThemeSetup;

add_action( 'after_setup_theme', __NAMESPACE__ . '\setup_theme_support' );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );

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

	// Clear the default editor styles, register support, and then enqueue our own.
	remove_editor_styles();
	add_theme_support( 'editor-styles' );
	add_editor_style( 'editor-style.css' );
}

function enqueue_assets() {

	wp_enqueue_style(
		'montserrat-font',
		'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,400;1,600&display=swap'
	);

	// Theme Stylesheet.
	$asset_data = require dirname( __DIR__ ) . '/style.css.php';
	wp_enqueue_style(
		'writemore-style',
		get_stylesheet_uri(),
		array(),
		'3.0.0',
	);
}
