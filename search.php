<?php
/**
 * The template for displaying search pages.
 *
 * @package writemore
 */

get_header();

$writemore_description = 'Search results for ' . esc_html( get_search_query() );
$writemore_header      = 'Search';
?>
<header>
	<h1><?php echo esc_html( $writemore_header ); ?></h1>
	<?php if ( ! empty( trim( $writemore_description ) ) ) : ?>
	<p><?php echo wp_kses_post( $writemore_description ); ?></p>
	<?php endif; ?>
</header><!-- .page-header -->
<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php get_template_part( 'template-parts/content/card', get_post_type() ); ?>
	<?php endwhile; ?>

	<?php
	the_posts_navigation(
		array(
			'prev_text' => 'View older content',
			'next_text' => 'View newer content',
		)
	);

	?>

<?php else : ?>
	<article>
		<div class="entry-content">
			<p>No search results found.</p>
		</div>
	</article>
<?php endif; ?>

<?php

get_template_part( 'template-parts/author-bio' );
get_footer(); ?>
