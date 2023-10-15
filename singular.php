<?php
/**
 * The template for displaying all singular views.
 *
 * @package WriteMore
 */

get_header(); ?>

<?php if ( is_home() && ! is_front_page() && ! empty( single_post_title( '', false ) ) ) : ?>
	<header class="page-header alignwide">
		<h1 class="page-title"><?php single_post_title(); ?></h1>
	</header><!-- .page-header -->
<?php endif; ?>

<?php
// Load posts loop.
while ( have_posts() ) {
	the_post();

	get_template_part( 'template-parts/content/card', get_post_type() );
}

get_footer();
