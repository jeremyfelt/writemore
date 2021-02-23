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

	<header class="entry-header alignwide">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php twenty_twenty_one_post_thumbnail(); ?>
	</header>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'twentytwentyone' ) . '">',
				'after'    => '</nav>',
				/* translators: %: page number. */
				'pagelink' => esc_html__( 'Page %', 'twentytwentyone' ),
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer default-max-width">
		<?php twenty_twenty_one_entry_meta_footer(); ?>
	</footer><!-- .entry-footer -->
	<?php
	if ( is_singular( 'post' ) ) {
		?>
		<div class="cc-copyright default-max-width">
			<p>"<span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="dct:title" rel="dct:type"><a xmlns:dct="http://purl.org/dc/terms/" href="<?php the_permalink(); ?>" rel="dct:source"><?php the_title(); ?></a></span>"
			by <a xmlns:cc="http://creativecommons.org/ns#" href="https://jeremyfelt.com" property="cc:attributionName" rel="cc:attributionURL">Jeremy Felt</a>, unless otherwise expressly stated,
			is licensed under a <a rel="license" href="https://creativecommons.org/licenses/by-sa/4.0/">CC BY-SA 4.0 International License</a>.</p>
		</div>
		<?php
	}
	?>
	<?php if ( ! is_singular( 'attachment' ) ) : ?>
		<?php get_template_part( 'template-parts/post/author-bio' ); ?>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
