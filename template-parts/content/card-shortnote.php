<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package writemore
 */

use Writemore\Output;
use ShortNotes\PostType\Note;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if ( is_singular( 'shortnote' ) ) : ?>
	<header>
		<h1>Note</h1>
	</header>
<?php endif; ?>

<?php if ( ! is_singular( 'shortnote' ) ) : ?>
	<?php Output\published(); ?>
<?php endif; ?>

<?php if ( function_exists( 'Note\reply_to_markup' ) ) : ?>
		<?php Note\reply_to_markup(); ?>
	<?php  ?>
<?php endif; ?>

	<div class="entry-content e-content">
		<?php the_content(); ?>
	</div>

<?php if ( is_singular( 'shortnote' ) ) : ?>
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
