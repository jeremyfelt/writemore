<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Write_More_Things
 */

?>

<div id="post-<?php the_ID(); ?>" class="entries-content-wrapper">

	<?php writemore_post_thumbnail(); ?>

	<?php the_content(); ?>

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

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
	comments_template();
	endif;
	?>
</div><!-- #post-<?php the_ID(); ?> -->
