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
	<?php
	if ( function_exists( 'ShortNotes\PostType\Note\reply_to_markup' ) ) {
		\ShortNotes\PostType\Note\reply_to_markup();
	}
	?>
	<div class="entry-content e-content">
		<?php the_content(); ?>
	</div>
	<footer class="entry-footer">
		<?php
		\Writemore\Output\published();
		if ( is_singular() ) {
			echo '<p>Back to <a href="' . get_post_type_archive_link( 'shortnote' ) . '">all notes</a>.</p>';
			get_template_part( 'template-parts/post/author-bio' );
		}
		?>
	</footer>
	<?php
	// If comments are open or there is at least one comment, load up the comment template.
	if ( is_singular( 'shortnote' ) && comments_open() || get_comments_number() ) {
		comments_template(); // Outputs its own <section>.
	}
	?>
</article>
