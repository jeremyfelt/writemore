<?php
/**
 * Write More Things functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Write_More_Things
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function writemore_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Write More Things, use a find and replace
	 * to change 'writemore' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'writemore', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'writemore' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'writemore_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	/**
	 * Add theme support for specific Gutenberg options.
	 */
	add_theme_support( 'gutenberg', array(
		'wide-images' => true,
	) );
}
add_action( 'after_setup_theme', 'writemore_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function writemore_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'writemore_content_width', 640 );
}
add_action( 'after_setup_theme', 'writemore_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function writemore_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'writemore' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'writemore' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'writemore_widgets_init' );
/**
 * Enqueue scripts and styles.
 */
function writemore_scripts() {
	wp_enqueue_style( 'writemore-fonts', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600' );
	wp_enqueue_style( 'writemore-style', get_stylesheet_uri(), array(), '1.0.5' );

	wp_enqueue_script( 'writemore-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'writemore-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'writemore_scripts' );

add_filter( 'previous_post_link', 'writemore_post_nav_link_text', 10, 5 );
add_filter( 'next_post_link', 'writemore_post_nav_link_text', 10, 5 );
function writemore_post_nav_link_text( $output, $format, $link, $post, $adjacent ) {
	if ( 'next' === $adjacent ) {
		$output = str_replace( '<div class="nav-next">', '<div class="nav-next">Next: ', $output );
	} else if ( 'previous' === $adjacent ) {
		$output = str_replace( '<div class="nav-previous">', '<div class="nav-previous">Previously: ', $output );
	}

	return $output;
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

require get_template_directory() . '/inc/class-writemore-comment-walker.php';
