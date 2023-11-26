<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package writemore
 */

use Writemore\Output;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( is_singular() ) : ?>
		<header>
			<h1>Note</h1>
		</header>
	<?php endif; ?>
	<?php Output\published( 'full' ); ?>
	<?php
	if ( function_exists( 'ShortNotes\PostType\Note\reply_to_markup' ) ) {
		\ShortNotes\PostType\Note\reply_to_markup();
	}
	?>
	<div class="entry-content e-content">
		<?php the_content(); ?>
	</div>
	<?php if ( is_singular() ) : ?>
	<footer class="entry-footer">
		<?php
		Output\published();
		get_template_part( 'template-parts/author-bio' );
		?>
	</footer>
	<section class="more-notes">
		<?php
		Output\other_notes();
		echo '<p>Back to <a href="' . get_post_type_archive_link( 'shortnote' ) . '">all notes</a>.</p>';
		?>
	</section>
	<?php endif; ?>
	<?php
	// If comments are open or there is at least one comment, load up the comment template.
	if ( is_singular( 'shortnote' ) && comments_open() || get_comments_number() ) {
		comments_template(); // Outputs its own <section>.
	}
	?>
</article>
