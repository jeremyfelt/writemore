<?php
/**
 * The header template.
 *
 * @package writemore
 */

$writemore_blog_info = get_bloginfo( 'name' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'writemore' ); ?></a>

<header>

	<div class="site-branding">
		<?php if ( is_front_page() && ! is_paged() ) : ?>
			<h1><?php echo esc_html( $writemore_blog_info ); ?></h1>
		<?php elseif ( is_front_page() && ! is_home() ) : ?>
			<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $writemore_blog_info ); ?></a></h1>
		<?php else : ?>
			<p><?php echo esc_html( $writemore_blog_info ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( has_nav_menu( 'header-menu' ) ) : ?>
	<nav id="site-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'writemore' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'menu_class'      => 'menu-wrapper',
				'container'       => false,
				'container_class' => 'primary-menu-container',
				'items_wrap'      => '<ul id="primary-menu-list">%3$s</ul>',
				'fallback_cb'     => false,
			)
		);
		?>
	</nav>
	<?php endif; ?>

</header>

<main id="main">
