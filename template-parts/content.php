<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Write_More_Things
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php writemore_post_thumbnail(); ?>

	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php writemore_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'writemore' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'writemore' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php writemore_entry_footer(); ?>

		<?php
		if ( is_singular( 'post' ) ) {
			?>
			<div class="cc-copyright">
				<p>"<span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="dct:title" rel="dct:type"><a xmlns:dct="http://purl.org/dc/terms/" href="<?php the_permalink(); ?>" rel="dct:source"><?php the_title(); ?></a></span>"
				by <a xmlns:cc="http://creativecommons.org/ns#" href="https://jeremyfelt.com" property="cc:attributionName" rel="cc:attributionURL">Jeremy Felt</a>, unless otherwise expressly stated,
				is licensed under a <a rel="license" href="https://creativecommons.org/licenses/by-sa/4.0/">CC BY-SA 4.0 International License</a>.</p>
			</div>
			<?php
		}
		?>
	</footer><!-- .entry-footer -->

	<?php
	if ( is_singular( 'post' ) ) {
		the_post_navigation();
	}

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
	comments_template();
	endif;
	?>
</article><!-- #post-<?php the_ID(); ?> -->
