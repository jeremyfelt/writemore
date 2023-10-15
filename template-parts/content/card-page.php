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

	if ( function_exists( 'ShortNotes\PostType\Note\reply_to_markup' ) ) {
		\ShortNotes\PostType\Note\reply_to_markup();
	}

	if ( ! is_front_page() ) {
		if ( is_singular( 'post' ) ) {
			\Writemore\Output\published( false );
		}
		?>
		<div class="entry-content e-content">
			<?php the_content(); ?>
			<?php
			if ( is_singular( 'shortnote' ) ) {
				\Writemore\Output\published();
			}
			?>
		</div><!-- .entry-content -->
		<?php
	} else {
		the_content();
	}
	?>
	<?php if ( ! is_front_page() ) : ?>
	<footer class="entry-footer">
		<?php
		if ( is_singular( 'shortnote' ) || is_post_type_archive( 'shortnote' ) ) {
			if ( is_singular( 'shortnote' ) ) {
				echo '<p>Back to <a href="' . get_post_type_archive_link( 'shortnote' ) . '">all notes</a>.</p>';
			}
		}

		if ( ! is_singular( 'shortnote' ) && ! is_post_type_archive( 'shortnote' ) ) {
			\Writemore\Output\published();
		}

		get_template_part( 'template-parts/post/author-bio' );
		?>
	</footer><!-- .entry-footer -->

		<?php
		// If comments are open or there is at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template(); // Outputs its own <section>.
		}
		?>

	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
