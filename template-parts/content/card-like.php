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
	<div class="entry-content e-content">
		<?php the_content(); ?>
	</div>
	<footer class="entry-footer">
		<?php
		\Writemore\Output\published();
		if ( is_singular() ) {
			echo '<p>Back to <a href="' . get_post_type_archive_link( 'like' ) . '">all likes</a>.</p>';
			get_template_part( 'template-parts/post/author-bio' );
		}
		?>
	</footer>
	<?php
	// If comments are open or there is at least one comment, load up the comment template.
	if ( is_singular( 'like' ) && comments_open() || get_comments_number() ) {
		comments_template(); // Outputs its own <section>.
	}
	?>
</article>
