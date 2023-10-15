<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package writemore
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<?php
		if ( is_singular() ) {
			the_title( '<h1 class="p-name">', '</h1>' );
		} else {
			the_title( '<h1><a href="' . get_the_permalink() . '" class="p-name">', '</a></h1>' );
		}

		the_post_thumbnail();
		?>
	</header>
	<?php \Writemore\Output\published( false ); ?>
	<div class="entry-content e-content">
		<?php
		if ( is_home() || is_archive() ) {
			\Writemore\Output\excerpt();
		} else {
			the_content();
		}
		?>
	</div>
	<footer class="entry-footer">
		<?php
		\Writemore\Output\published();
		get_template_part( 'template-parts/post/author-bio' );
		?>
	</footer>
	<?php
	// If comments are open or there is at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template(); // Outputs its own <section>.
	}
	?>
</article><!-- #post-<?php the_ID(); ?> -->
