<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	if ( post_type_supports( get_post_type(), 'title' ) ) :
	?>
	<header class="entry-header alignwide">
		<?php the_title( '<h1 class="entry-title p-name">', '</h1>' ); ?>
		<?php twenty_twenty_one_post_thumbnail(); ?>
	</header>
	<?php
	endif;
	?>

	<?php
	if ( function_exists( 'ShortNotes\PostType\Note\reply_to_markup' ) ) {
		\ShortNotes\PostType\Note\reply_to_markup();
	}
	?>
	<div class="entry-content e-content">
		<?php
		the_content();
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer default-max-width">
		<?php
		if ( is_singular( 'shortnote' ) || is_archive( 'shortnote' ) ) {
			echo '<div class="posted-by">';
			// Posted on.
			writemore_posted_on();
			// Posted by.
			twenty_twenty_one_posted_by();

			if ( is_singular( 'shortnote' ) ) {
				echo '<p>Back to <a href="' . get_post_type_archive_link( 'shortnote' ) . '">all notes</a>.</p>';
			}
			echo '</div>';
		}

		if ( ! is_archive( 'shortnote' ) ) {
			twenty_twenty_one_entry_meta_footer();
		}
		?>
	</footer><!-- .entry-footer -->
	<?php
	if ( is_singular( 'post' ) || is_singular( 'shortnote' ) ) {
		?>
		<div class="cc-copyright default-max-width">
			<p>"<span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="dct:title" rel="dct:type"><a xmlns:dct="http://purl.org/dc/terms/" href="<?php the_permalink(); ?>" rel="dct:source"><?php the_title(); ?></a></span>"
			by <a xmlns:cc="http://creativecommons.org/ns#" href="https://jeremyfelt.com" property="cc:attributionName" rel="cc:attributionURL">Jeremy Felt</a>, unless otherwise expressly stated,
			is licensed under a <a rel="license" href="https://creativecommons.org/licenses/by-sa/4.0/">CC BY-SA 4.0 International License</a>.</p>
		</div>
		<?php
	}
	?>
	<?php if ( ! is_singular( 'attachment' ) && ! is_archive( 'shortnote' ) ) : ?>
		<?php get_template_part( 'template-parts/post/author-bio' ); ?>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
