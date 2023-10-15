<?php
/**
 * Template part for displaying page content.
 *
 * @package writemore
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( ! is_front_page() && post_type_supports( get_post_type(), 'title' ) ) :
		?>
	<header>
		<?php
		if ( is_singular() ) {
			the_title( '<h1 class="p-name">', '</h1>' );
		} else {
			the_title( '<h1><a href="' . get_the_permalink() . '" class="p-name">', '</a></h1>' );
		}

		?>
		<?php the_post_thumbnail(); ?>
	</header>
		<?php
	endif;

	if ( ! is_front_page() ) {
		?>
		<div class="entry-content e-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
		<?php
	} else {
		the_content();
	}
	?>

	<footer class="entry-footer">
		<?php get_template_part( 'template-parts/post/author-bio' ); ?>
	</footer><!-- .entry-footer -->r

	<?php
	// If comments are open or there is at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template(); // Outputs its own <section>.
	}
	?>

</article><!-- #post-<?php the_ID(); ?> -->
