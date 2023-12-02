<?php
/**
 * The header template.
 *
 * @package writemore
 */

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
		<?php if ( is_front_page() ) : ?>
			<h1>Jeremy Felt's web</h1>
		<?php else : ?>
			<p>Jeremy Felt's web</p>
		<?php endif; ?>
	</div>

	<?php if ( has_nav_menu( 'header-menu' ) ) : ?>
	<nav id="site-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'writemore' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'header-menu',
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
