<?php
/**
 * The header template.
 *
 * @package writemore
 */

$writemore_tagline = get_bloginfo( 'description', 'display' );
if ( ! $writemore_tagline ) {
	$writemore_tagline = get_bloginfo( 'name' );
}
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
			<h1><?php echo esc_html( $writemore_tagline ); ?></h1>
		<?php else : ?>
			<p><?php echo esc_html( $writemore_tagline ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( has_nav_menu( 'header-menu' ) ) : ?>
	<nav aria-label="<?php esc_attr_e( 'Site navigation', 'writemore' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'header-menu',
				'container'      => '',
				'items_wrap'     => '<ul>%3$s</ul>',
				'fallback_cb'    => false,
			)
		);
		?>
	</nav>
	<?php endif; ?>

</header>

<main id="main">
