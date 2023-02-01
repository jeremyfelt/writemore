<?php
/**
 * Displays the site header.
 *
 * @package WriteMore
 */

$blog_info = get_bloginfo( 'name' );
?>

<header>

	<div class="site-branding">
		<?php if ( is_front_page() && ! is_paged() ) : ?>
			<h1><?php echo esc_html( $blog_info ); ?></h1>
		<?php elseif ( is_front_page() && ! is_home() ) : ?>
			<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $blog_info ); ?></a></h1>
		<?php else : ?>
			<p><?php echo esc_html( $blog_info ); ?></p>
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
