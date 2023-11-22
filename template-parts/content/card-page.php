<?php
/**
 * Template part for displaying page content.
 *
 * @package writemore
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( ! is_front_page() ) {
		?>
		<header>
			<?php the_title( '<h1 class="p-name">', '</h1>' ); ?>
			<?php the_post_thumbnail(); ?>
		</header>
		<div class="entry-content e-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
		<?php
	} else {
		the_content();
	}
	?>

	<footer class="entry-footer">
		<?php get_template_part( 'template-parts/author-bio' ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
